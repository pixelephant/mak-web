<?php

/**
* A WebShop PHP kliens �ltal haszn�lt utility oszt�ly
* a kliens oldali SOAP kommunk�ci�hoz, PHP5 k�rnyezetben.
* 
* @version 3.3.1
* @author Bodn�r Imre / IQSYS
*/
class SoapUtils {

    /**
    * @desc A banki fel�lethez illeszked� SOAP kliens l�trehoz�sa.
    * A kliensen be�ll�tott socket_timeout 660 m�sodperc az�rt,
    * hogy a h�romszerepl�s fizet�sekhez kapcsol�d� kommunik�ci�s sz�lak
    * se szakadjanak meg.
    * 
    * @param array $properties kapcsol�d�si param�terek (javasolt
    * a otp_webshop_client.conf f�jl teljes tartalma)
    * 
    * @return SoapClient A banki fel�lethez illeszked� SOAP kliens.
    */
    function createSoapClient($properties) {
        $soapClientProps = array (   
            'location' => ConfigUtils::safeConfigParam($properties, PROPERTY_OTPMWSERVERURL),
            'uri' => ConfigUtils::safeConfigParam($properties, PROPERTY_OTPMWSERVERURL),
            'trace' => true,
            'exceptions' => 1,
            'connection_timeout' => 10,
            'default_socket_timeout' => 660);
            
        if (ConfigUtils::safeConfigParam($properties, PROPERTY_HTTPSPROXYHOST)) {
            $soapClientProps['proxy_host'] = ConfigUtils::safeConfigParam($properties, PROPERTY_HTTPSPROXYHOST);
        }
        if (ConfigUtils::safeConfigParam($properties, PROPERTY_HTTPSPROXYPORT)) {
            $soapClientProps['proxy_port'] = ConfigUtils::safeConfigParam($properties, PROPERTY_HTTPSPROXYPORT);
        }
        if (ConfigUtils::safeConfigParam($properties, PROPERTY_HTTPSPROXYUSER)) {
            $soapClientProps['proxy_login'] = ConfigUtils::safeConfigParam($properties, PROPERTY_HTTPSPROXYUSER);
        }
        if (ConfigUtils::safeConfigParam($properties, PROPERTY_HTTPSPROXYPASSWORD)) {
            $soapClientProps['proxy_password'] = ConfigUtils::safeConfigParam($properties, PROPERTY_HTTPSPROXYPASSWORD);
        }

        return new SoapClient(NULL, $soapClientProps);      
    }

    /**
     * @desc A banki fel�let Ping szolg�ltat�s�nak megh�v�sa. 
     * 
     * @param SoapClient $soapClient SOAP kliens
     * @param LoggerManager $logger log4php napl�z�
     * @return boolean true sikeres ping-et�s eset�n, egy�bk�nt false.
     */
    function ping($soapClient, $logger) {

        $result = false;
        try {
            $soapClient->__soapCall(
                "ping", array(), array('soapaction' => "urn:ping"));
            $result = true;
        }
        catch (Exception $e) {
            $logger->fatal("Hiba a banki felulet elereseben [ping]: " 
            . $e->getMessage()
            . "\n" . $e->getTraceAsString()
            . "\nSOAP valasz:\n" . $soapClient->__getLastResponse());
        }
                               
        return $result;
    }

    /**
     * Tranzakci� ind�t�sa. 
     * Ha a Bank t�lterhel�s miatt elutas�tja a k�r�st, automatikus
     * �jrak�ld�s t�rt�nik maximum RESENDCOUNT darabsz�mban, 
     * RESENDDELAY ezredm�sodperces k�sleltet�ssel.
     *
     * @param SoapClient $soapClient SOAP kliens
     * @param LoggerManager $logger log4php napl�z�
     *
     * @return boolean true sikeres ping-et�s eset�n, egy�bk�nt false.
     */
    function startWorkflowSynch($workflowName, $inputXml, $soapClient, $logger) {
        
        $workflowState = NULL;
        $retryCount = 0;
        $resendAllowed = true;

        /* A h�romszerepl�s fizet�si tranzakci� eset�n
           a process fut�si ideje a 10 percet is meghaladhatja
           (10 perc a fizet�si timeout, tov�bbi p�r m�sodperc
           a kommunik�ci�s overhead)   */
        if ($workflowName == WF_HAROMSZEREPLOSFIZETES) {
            ini_set('max_execution_time','660');
        }
        
        do {
            try {
                $workflowState = $soapClient->__soapCall(
                    "startWorkflowSynch", 
                    array( 
                        new SoapParam(new SoapVar($workflowName, XSD_STRING), "arg0"), 
                        new SoapParam(new SoapVar($inputXml, XSD_STRING), "arg1")),
                    array('soapaction' => "urn:startWorkflowSynch"));
                
                $resendAllowed = false;
            }
            catch (SoapFault $sf) {
	            $logger->fatal("Hiba a banki fel�let el�r�s�ben [" . $workflowName . "]: " 
                    . $sf->getMessage()
                    . "\n" . $sf->getTraceAsString()
                    . "\nSOAP valasz:\n" . $soapClient->__getLastResponse());
                $resendAllowed = false;
                if ($retryCount < RESENDCOUNT) {
                    if (stristr($sf->getMessage(), RESEND_ERRORPATTERN) !== false) {
                        // Pillanatnyi t�lterhel�s miatti visszautas�t�s a banki oldalon
                        $resendAllowed = true;
                        sleep(RESENDDELAY);
                    } 
                }
            }
            catch (Exception $e) {

	            $logger->fatal("Hiba a banki fel�let el�r�s�ben [" . $workflowName . "]: " 
                    . $e->getMessage()
                    . "\n" . $e->getTraceAsString()
                    . "\nSOAP valasz:\n" . $soapClient->__getLastResponse());

                    $resendAllowed = false;
            }
            
        } while ($resendAllowed && $retryCount++ < RESENDCOUNT);
        
        return $workflowState;
    }

}

?>