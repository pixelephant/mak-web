<?php

if (!defined('WEBSHOP_LIB_DIR')) define('WEBSHOP_LIB_DIR', dirname(__FILE__) . '/../..');

$phpversion = phpversion();
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/model/WebShopFizetesValasz.php');
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/WebShopXmlUtils.php' . $phpversion{0});

/**
* K�tszerepl�s fizet�s illetve k�tl�pcs�s fizet�s lez�r�s 
* v�lasz XML-j�nek feldolgoz�s�sa �s a megfelel� value object el��ll�t�sa.
* 
* @author Bodn�r Imre
* @version 3.3.1
*/
class WAnswerOfWebShopFizetesKetszereplos {

    /**
    * K�tszerepl�s fizet�s illetve k�tl�pcs�s fizet�s lez�r�s 
    * v�lasz XML-j�nek feldolgoz�s�sa �s a megfelel� value object el��ll�t�sa.
    * 
    * @param DomDocument $answer A tranzakci�s v�lasz xml
    * @return WebShopFizetesValasz a v�lasz tartalma, 
    *         vagy NULL �res/hib�s v�lasz eset�n
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