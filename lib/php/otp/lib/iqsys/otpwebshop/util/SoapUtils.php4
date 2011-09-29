<?php

if (!defined('WEBSHOP_LIB_DIR')) define('WEBSHOP_LIB_DIR', dirname(__FILE__) . '/../../..');

require_once(WEBSHOP_LIB_DIR . '/nusphere/nusoap/nusoap.php');
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/model/WorkflowState.php');
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/ConfigUtils.php');

/**
* A WebShop PHP kliens által használt utility osztály
* a kliens oldali SOAP kommunkációhoz, PHP4 környezetben.
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
    * @return soapclient A banki felülethez illeszkedõ SOAP kliens.
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
     * @desc A banki felület Ping szolgáltatásának meghívása. 
     * 
     * @param SoapClient $soapClient SOAP kliens
     * @param LoggerManager $logger log4php naplózó
     * @return boolean true sikeres ping-etés esetén, egyébként false.
     */
    function ping($soapClient, $logger) {

        $result = false;
        $soapClient->call(
            "ping", array(), $soapClient->endpoint, "urn:ping");
        if ($soapClient->fault) {
	        $logger->fatal("Hiba a banki felület elérésében [ping]: " 
                . $soapClient->getError()
                . "\nSOAP valasz:\n" . $soapClient->responseData);
            $logger->debug($soapClient->debug_str);
        }
        else {
	        $err = $soapClient->getError();
	        if ($err) {
                $logger->fatal("Hiba a banki felület elérésében [ping]: " . $err);
                $logger->debug($soapClient->debug_str);
            }
            else {
                $result = true;
            }                    
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
                    "Hiba a banki felület elérésében [" . $workflowName . "]: " 
                    . $soapClient->getError()
                    . "\nSOAP valasz:\n" . $soapClient->responseData);
                $logger->debug($soapClient->getDebug());
                
                if ($retryCount < RESENDCOUNT) {
                    if (stristr($soapClient->getError(), RESEND_ERRORPATTERN) !== false) {
                        // Pillanatnyi túlterhelés miatti visszautasítás a banki oldalon
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
                        "Hiba a banki felület elérésében [" . $workflowName . "]: " 
                        . $err
                        . (!is_null($incomingHeaders) ? "\nresponse header\n" . print_r($incomingHeaders, true) : "")
                        . "\nresponse:\n" . $soapClient->responseData);
                    $logger->debug($soapClient->getDebug());
                }
                else {
                    // Sikeres végrehajtás
                    $workflowState = new WorkflowState($workflowState);
                }
            }

        } while ($resendAllowed && $retryCount++ < RESENDCOUNT);
        
        return $workflowState;
    }

}

?>