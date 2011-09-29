<?php

if (!defined('WEBSHOP_LIB_DIR')) define('WEBSHOP_LIB_DIR', dirname(__FILE__) . '/../..');

$phpversion = phpversion();
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/model/WebShopFizetesValasz.php');
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/WebShopXmlUtils.php' . $phpversion{0});

/**
* Kétszereplõs fizetés illetve kétlépcsõs fizetés lezárás 
* válasz XML-jének feldolgozásása és a megfelelõ value object elõállítása.
* 
* @author Bodnár Imre
* @version 3.3.1
*/
class WAnswerOfWebShopFizetesKetszereplos {

    /**
    * Kétszereplõs fizetés illetve kétlépcsõs fizetés lezárás 
    * válasz XML-jének feldolgozásása és a megfelelõ value object elõállítása.
    * 
    * @param DomDocument $answer A tranzakciós válasz xml
    * @return WebShopFizetesValasz a válasz tartalma, 
    *         vagy NULL üres/hibás válasz esetén
    */
    function load($answer) {
        $webShopFizetesValasz = new WebShopFizetesValasz();
       
        $record = WebShopXmlUtils::getNodeByXPath($answer, '//answer/resultset/record');
        if (!is_null($record)) {
            $webShopFizetesValasz->setPosId(WebShopXmlUtils::getElementText($record, "posid"));
            $webShopFizetesValasz->setAzonosito(WebShopXmlUtils::getElementText($record, "transactionid"));
            $webShopFizetesValasz->setTeljesites(WebShopXmlUtils::getElementText($record, "timestamp"));
            $webShopFizetesValasz->setValaszKod(WebShopXmlUtils::getElementText($record, "posresponsecode"));
            $webShopFizetesValasz->setAuthorizaciosKod(WebShopXmlUtils::getElementText($record, "authorizationcode"));
        }
        
        return $webShopFizetesValasz;
    }

}

?>