<?php

if (!defined('WEBSHOP_LIB_DIR')) define('WEBSHOP_LIB_DIR', dirname(__FILE__) . '/../..');

$phpversion = phpversion();

require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/model/WebShopFizetesAdatokLista.php');
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/model/WebShopFizetesAdatok.php');
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/WebShopXmlUtils.php' . $phpversion{0});

/**
* Fizet�si tranzakci� lek�rdez�s v�lasz XML-j�nek feldolgoz�s�sa �s
* a megfelel� value object el��ll�t�sa.
* 
* @author Bodn�r Imre
* @version 3.3.1
*/
class WAnswerOfWebShopTrazakcioLekerdezes {

    /**
    * @desc A banki fel�let �ltal visszaadott sz�veges logikai
    * �rt�kb�l boolean t�pus� �rt�k el��ll�t�sa.
    * 
    * A k�pz�s m�dja:
    * "TRUE" sz�veges �rt�k => true logikai �rt�k
    * minden m�s �rt�k => false logikai �rt�k
    */
    function getBooleanValue($value) {
      $result = false;
      if (!is_null($value) && strcasecmp("TRUE", $value) == 0) {
        $result = true;
      }
      return $result;
    }

    /**
    * Fizet�si tranzakci� lek�rdez�s v�lasz XML-j�nek feldolgoz�s�sa �s
    * a megfelel� value object el��ll�t�sa.
    * 
    * @param DomDocument $answer A tranzakci�s v�lasz xml
    * @return WebShopFizetesAdatokLista a v�lasz tartalma, 
    *         vagy NULL �res/hib�s v�lasz eset�n
    */
    function load($answer) {
        $webShopFizetesAdatokLista = new WebShopFizetesAdatokLista();
        
        $lista = array();
        $webShopFizetesAdatokLista->setWebShopFizetesAdatok($lista);
        
        $recordList = WebShopXmlUtils::getNodeArrayByXPath($answer, '//answer/resultset/record');
        foreach ($recordList as $record) {
        
            $webShopFizetesAdatok = new WebShopFizetesAdatok();                        
               
            $webShopFizetesAdatok->setPosId(WebShopXmlUtils::getElementText($record, "posid"));
            $webShopFizetesAdatok->setAzonosito(WebShopXmlUtils::getElementText($record, "transactionid"));
            $webShopFizetesAdatok->setStatuszKod(WebShopXmlUtils::getElementText($record, "state"));
            $webShopFizetesAdatok->setPosValaszkod(WebShopXmlUtils::getElementText($record, "responsecode"));
            $enddate = WebShopXmlUtils::getElementText($record, "enddate");
            if (strlen($enddate) == 14) {
                $dateFields = sscanf($enddate, "%04s%02s%02s%02s%02s%02s");
                $enddate = vsprintf("%04s.%02s.%02s %02s.%02s.%02s 000", $dateFields);
            }
            $webShopFizetesAdatok->setTeljesites($enddate);
            
            $inputPart = WebShopXmlUtils::getNodeByXPath($record, 'params/input');
            
            if (!is_null($inputPart)) {
                $webShopFizetesAdatok->setOsszeg(WebShopXmlUtils::getElementText($inputPart, "amount"));
                $webShopFizetesAdatok->setDevizanem(WebShopXmlUtils::getElementText($inputPart, "exchange"));
                $webShopFizetesAdatok->setNyelvkod(WebShopXmlUtils::getElementText($inputPart, "languagecode"));

                $webShopFizetesAdatok->setNevKell($this->getBooleanValue(WebShopXmlUtils::getElementText($inputPart, "nameneeded")));
                $webShopFizetesAdatok->setOrszagKell($this->getBooleanValue(WebShopXmlUtils::getElementText($inputPart, "countryneeded")));
                $webShopFizetesAdatok->setMegyeKell($this->getBooleanValue(WebShopXmlUtils::getElementText($inputPart, "countyneeded")));
                $webShopFizetesAdatok->setTelepulesKell($this->getBooleanValue(WebShopXmlUtils::getElementText($inputPart, "settlementneeded")));
                $webShopFizetesAdatok->setUtcaHazszamKell($this->getBooleanValue(WebShopXmlUtils::getElementText($inputPart, "streetneeded")));
                $webShopFizetesAdatok->setIranyitoszamKell($this->getBooleanValue(WebShopXmlUtils::getElementText($inputPart, "zipcodeneeded")));
                $webShopFizetesAdatok->setMailCimKell($this->getBooleanValue(WebShopXmlUtils::getElementText($inputPart, "mailaddressneeded")));
                $webShopFizetesAdatok->setKozlemenyKell($this->getBooleanValue(WebShopXmlUtils::getElementText($inputPart, "narrationneeded")));
                $webShopFizetesAdatok->setUgyfelRegisztracioKell($this->getBooleanValue(WebShopXmlUtils::getElementText($inputPart, "consumerregistrationneeded")));
                $webShopFizetesAdatok->setRegisztraltUgyfelId(WebShopXmlUtils::getElementText($inputPart, "consumerregistrationid"));
                $webShopFizetesAdatok->setShopMegjegyzes(WebShopXmlUtils::getElementText($inputPart, "shopcomment"));
                $webShopFizetesAdatok->setBackURL(WebShopXmlUtils::getElementText($inputPart, "backurl"));

                $consumerReceiptNeeded = WebShopXmlUtils::getElementText($inputPart, "consumerreceiptneeded");
                $webShopFizetesAdatok->setVevoVisszaigazolasKell($this->getBooleanValue($consumerReceiptNeeded));
                $webShopFizetesAdatok->setKetszereplos(is_null($consumerReceiptNeeded) || $consumerReceiptNeeded == "");
            }

            $outputPart = WebShopXmlUtils::getNodeByXPath($record, 'params/output');
            if (!is_null($outputPart)) {
                $webShopFizetesAdatok->setAuthorizaciosKod(WebShopXmlUtils::getElementText($outputPart, "authorizationcode"));
                $webShopFizetesAdatok->setNev(WebShopXmlUtils::getElementText($outputPart, "name"));
                $webShopFizetesAdatok->setOrszag(WebShopXmlUtils::getElementText($outputPart, "country"));
                $webShopFizetesAdatok->setMegye(WebShopXmlUtils::getElementText($outputPart, "county"));
                $webShopFizetesAdatok->setVaros(WebShopXmlUtils::getElementText($outputPart, "settlement"));
                $webShopFizetesAdatok->setIranyitoszam(WebShopXmlUtils::getElementText($outputPart, "zipcode"));
                $webShopFizetesAdatok->setUtcaHazszam(WebShopXmlUtils::getElementText($outputPart, "street"));
                $webShopFizetesAdatok->setMailCim(WebShopXmlUtils::getElementText($outputPart, "mailaddress"));
                $webShopFizetesAdatok->setKozlemeny(WebShopXmlUtils::getElementText($outputPart, "narration"));
                $webShopFizetesAdatok->setTeljesCim(WebShopXmlUtils::getElementText($outputPart, "fulladdress"));
                $webShopFizetesAdatok->setTelefon(WebShopXmlUtils::getElementText($outputPart, "telephone"));
            }

            $lista[] = $webShopFizetesAdatok;
        }
        
        usort($lista, "fizetesAdatokCmp");
        
        return $webShopFizetesAdatokLista;
    }

}

/**
* @desc K�t fizet�si tranzakci� v�lasz adatot �sszehasonl�t� 
* f�ggv�ny. Az �sszehasonl�t�s alapja a teljes�t�s d�tuma: a
* kor�bban teljes�tett tranzakci� kisebb, mint a k�s�bb teljes�lt.
* Egy id�ben teljes�lt tranzakci�k eset�n a fizet�si tranzakci�
* azonos�t� a m�rvad�.
*/
function fizetesAdatokCmp($arg1, $arg2) {
    if (is_null($arg1)) return 1;
    if (is_null($arg2)) return -1;
    return strcmp(
        $arg1->getTeljesites() . $arg1->getAzonosito(), 
        $arg2->getTeljesites() . $arg2->getAzonosito() );
}

?>