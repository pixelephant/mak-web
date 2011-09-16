<?php

if (!defined('WEBSHOP_LIB_DIR')) define('WEBSHOP_LIB_DIR', dirname(__FILE__) . '/../../..');

require_once(WEBSHOP_LIB_DIR . '/nusphere/nusoap/nusoap.php');
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/model/WorkflowState.php');
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/ConfigUtils.php');

/**
* A WebShop PHP kliens �ltal haszn�lt utility oszt�ly
* a kliens oldali SOAP kommunk�ci�hoz, PHP4 k�rnyezetben.
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
    * @return soapclient A banki fel�lethez illeszked� SOAP kliens.
    */
    function createSoapClient($properties) {
        $client = new soapclient(
            ConfigUtils::safeConfigParam($properties, PROPERTY_OTPMWSERVERURL), 
            false, 
	        ConfigUtils::safeConfigParam($properties, PROPERTY_HTTPSPROXYHOST), 
            ConfigUtils::safeConfigParam($properties, PROPERTY_HTTPSPROXYPORT), 
            ConfigUtils::safeConfigParam($properties, PROPERTY_HTTPSPROXYUSER), 
            ConfigUtils::safeConfigParam($properties, PROPERTY_HTTPSPROXYPASSWORD),
            660,
            660);

        return $client;      
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
        $soapClient->call(
            "ping", array(), $soapClient->endpoint, "urn:ping");
        if ($soapClient->fault) {
	        $logger->fatal("Hiba a banki fel�let el�r�s�ben [ping]: " 
                . $soapClient->getError()
                . "\nSOAP valasz:\n" . $soapClient->responseData);
            $logger->debug($soapClient->debug_str);
        }
        else {
	        $err = $soapClient->getError();
	        if ($err) {
                $logger->fatal("Hiba a banki fel�let el�r�s�ben [ping]: " . $err);
                $logger->debug($soapClient->debug_str);
            }
            else {
                $result = true;
            }                    
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
            $workflowState = $soapClient->call(
                "startWorkflowSynch", 
                array(
                    "arg0" => $workflowName,
                    "arg1" => $inputXml,
                ), 
                $soapClient->endpoint, 
                "urn:startWorkflowSynch");
                
            $resendAllowed = false;
                
            if ($soapClient->fault) {
    	        $logger->fatal(
                    "Hiba a banki fel�let el�r�s�ben [" . $workflowName . "]: " 
                    . $soapClient->getError()
                    . "\nSOAP valasz:\n" . $soapClient->responseData);
                $logger->debug($soapClient->getDebug());
                
                if ($retryCount < RESENDCOUNT) {
                    if (stristr($soapClient->getError(), RESEND_ERRORPATTERN) !== false) {
                        // Pillanatnyi t�lterhel�s miatti visszautas�t�s a banki oldalon
                        $resendAllowed = true;
                        sleep(RESENDDELAY);
                    } 
                }
                
            }
            else {
    	        $err = $soapClient->getError();
    	        if ($err) {
    	            $http = $soapClient->http;
                    $incomingHeaders = is_null($http) ? null : $http->incoming_headers;
                    $logger->fatal(
                        "Hiba a banki fel�let el�r�s�ben [" . $workflowName . "]: " 
                        . $err
                        . (!is_null($incomingHeaders) ? "\nresponse header\n" . print_r($incomingHeaders, true) : "")
                        . "\nresponse:\n" . $soapClient->responseData);
                    $logger->debug($soapClient->getDebug());
                }
                else {
                    // Sikeres v�grehajt�s
                    $workflowState = new WorkflowState($workflowState);
                }
            }

        } while ($resendAllowed && $retryCount++ < RESENDCOUNT);
        
        return $workflowState;
    }

}

?>