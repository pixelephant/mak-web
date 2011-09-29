<?php

if (!defined('WEBSHOP_LIB_DIR')) define('WEBSHOP_LIB_DIR', dirname(__FILE__) . '/../..');

$phpversion = phpversion();
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/model/WebShopFizetesAdatok.php');
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/WebShopXmlUtils.php' . $phpversion{0});

/**
* H�romszerepl�s fizet�s v�lasz XML-j�nek feldolgoz�s�sa �s
* a megfelel� value object el��ll�t�sa.
* 
* @author Bodn�r Imre
* @version 3.3.1
*/
class WAnswerOfWebShopFizetes {

    /**
    * H�romszerepl�s fizet�s v�lasz XML-j�nek feldolgoz�s�sa �s
    * a megfelel� value object el��ll�t�sa.
    * 
    * @param DomDocument $answer A tranzakci�s v�lasz xml
    * @return WebShopFizetesAdatok a v�lasz tartalma, 
    *         vagy NULL �res/hib�s v�lasz eset�n
    */
    function load($answer) {

        $webShopFizetesAdatok = NULL;
        
        $record = WebShopXmlUtils::getNodeByXPath($answer, '//answer/resultset/record');
        if (!is_null($record)) {
                
            $webShopFizetesAdatok = new WebShopFizetesAdatok();

            $webShopFizetesAdatok->setPosId(WebShopXmlUtils::getElementText($record, "posid"));
            $webShopFizetesAdatok->setAzonosito(WebShopXmlUtils::getElementText($record, "transactionid"));
            $webShopFizetesAdatok->setAuthorizaciosKod(WebShopXmlUtils::getElementText($record, "authorizationcode"));
            $webShopFizetesAdatok->setTeljesites(WebShopXmlUtils::getElementText($record, "timestamp"));

            $webShopFizetesAdatok->setNev(WebShopXmlUtils::getElementText($record, "name"));
            $webShopFizetesAdatok->setOrszag(WebShopXmlUtils::getElementText($record, "country"));
            $webShopFizetesAdatok->setMegye(WebShopXmlUtils::getElementText($record, "county"));
            $webShopFizetesAdatok->setVaros(WebShopXmlUtils::getElementText($record, "settlement"));
            $webShopFizetesAdatok->setIranyitoszam(WebShopXmlUtils::getElementText($record, "zipcode"));
            $webShopFizetesAdatok->setUtcaHazszam(WebShopXmlUtils::getElementText($record, "street"));
            $webShopFizetesAdatok->setMailCim(WebShopXmlUtils::getElementText($record, "mailaddress"));
            $webShopFizetesAdatok->setKozlemeny(WebShopXmlUtils::getElementText($record, "narration"));
        }
        
        return $webShopFizetesAdatok;
    }

}

?>