<?php

/**
* A WebShop PHP kliens által használt utility osztály
* a kliens oldali SOAP kommunkációhoz, PHP5 környezetben.
* 
* @version 3.3.1
* @author Bodnár Imre / IQSYS
*/
class SoapUtils {

    /**
    * @desc A banki felülethez illeszkedõ SOAP kliens létrehozása.
    * A kliensen beállított socket_timeout 660 másodperc azért,
    * hogy a háromszereplõs fizetésekhez kapcsolódó kommunikációs szálak
    * se szakadjanak meg.
    * 
    * @param array $properties kapcsolódási paraméterek (javasolt
    * a otp_webshop_client.conf fájl teljes tartalma)
    * 
    * @return SoapClient A banki felülethez illeszkedõ SOAP kliens.
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
     * @desc A banki felület Ping szolgáltatásának meghívása. 
     * 
     * @param SoapClient $soapClient SOAP kliens
     * @param LoggerManager $logger log4php naplózó
     * @return boolean true sikeres ping-etés esetén, egyébként false.
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
     * Tranzakció indítása. 
     * Ha a Bank túlterhelés miatt elutasítja a kérést, automatikus
     * újraküldés történik maximum RESENDCOUNT darabszámban, 
     * RESENDDELAY ezredmásodperces késleltetéssel.
     *
     * @param SoapClient $soapClient SOAP kliens
     * @param LoggerManager $logger log4php naplózó
     *
     * @return boolean true sikeres ping-etés esetén, egyébként false.
     */
    function startWorkflowSynch($workflowName, $inputXml, $soapClient, $logger) {
        
        $workflowState = NULL;
        $retryCount = 0;
        $resendAllowed = true;

        /* A háromszereplõs fizetési tranzakció esetén
           a process futási ideje a 10 percet is meghaladhatja
           (10 perc a fizetési timeout, további pár másodperc
           a kommunikációs overhead)   */
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
	            $logger->fatal("Hiba a banki felület elérésében [" . $workflowName . "]: " 
                    . $sf->getMessage()
                    . "\n" . $sf->getTraceAsString()
                    . "\nSOAP valasz:\n" . $soapClient->__getLastResponse());
                $resendAllowed = false;
                if ($retryCount < RESENDCOUNT) {
                    if (stristr($sf->getMessage(), RESEND_ERRORPATTERN) !== false) {
                        // Pillanatnyi túlterhelés miatti visszautasítás a banki oldalon
                        $resendAllowed = true;
                        sleep(RESENDDELAY);
                    } 
                }
            }
            catch (Exception $e) {

	            $logger->fatal("Hiba a banki felület elérésében [" . $workflowName . "]: " 
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