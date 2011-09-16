<?php

if (!defined('WEBSHOP_LIB_DIR')) define('WEBSHOP_LIB_DIR', dirname(__FILE__) . '/../..');

require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/DefineConst.php');

/**
* A SimpleShop PHP �s a WebShop PHP kliens �ltal haszn�lt utility oszt�ly
* XML sz�vegek �s DomDocument objektumok kezel�s�re, PHP5 k�rnyezetben.
* 
* @version 3.3.1
* @author Bodn�r Imre / IQSYS
*/
class WebShopXmlUtils {

    /**
    * @desc Banki tranzakci�hoz tartoz� �res input xml v�z l�trehoz�sa:
    * <StartWorkflow>
    *   <TemplateName>$templateName</TemplateName>
    *   <Variables/>
    * </StartWorkflow>
    * 
    * @param string $templateName az ind�and� tranzakci� neve (sz�veges k�dja)
    * @param DomNode $variables referencia az input xml-ben l�trehozott
    * Varaibles tag-re.
    * 
    * @return DomDocument a l�trehozott objektum
    */
    function getRequestSkeleton($templateName, &$variables) {
        $dom = new DomDocument('1.0', WF_INPUTXML_ENCODING);
        $root = $dom->createElement('StartWorkflow');
        $dom->appendChild($root);

        $root->appendChild($dom->createElement('TemplateName', $templateName));

        $variables = $dom->createElement('Variables');
        $root->appendChild($variables);

        return $dom;
    }

    /**
    * @desc Banki tranzakci�hoz tartoz� input xml kieg�sz�t�se egy 
    * input v�ltoz� �rt�kkel. A v�ltoz� �rt�knek olyan karakter
    * k�dol�s�nak kell lennie, ami a WS_CUSTOMERPAGE_CHAR_ENCODING
    * konstansban defini�l�sra ker�lt (a default �rt�k az ISO-8859-2).
    * 
    * Megj: PHP 4.x alatt a namespace-t nem t�mogatja a met�dus!
    * 
    * @param DomDocument $dom maga az input xml
    * @param DomNode $variables az xml Variables tag-je
    * @param string name a beillesztend� v�ltoz� neve
    * @param string value a beillesztend� v�ltoz� �rt�ke.
    */
    function addParameter($dom, $variables, $name, $value) {
        $node = null;
        if (is_bool($value)) {
            $value = $value ? REQUEST_TRUE_CONST : REQUEST_FALSE_CONST;
        }
        
        if (!is_null($value)) {
            $value = iconv(WS_CUSTOMERPAGE_CHAR_ENCODING, $dom->actualEncoding, $value);            
        }
        
        if ($dom->documentElement->namespaceURI) {
            $node = $dom->createElementNS($dom->documentElement->namespaceURI, $name);
            $node->prefix = $dom->documentElement->prefix;
        }
        else {
            $node = $dom->createElement($name);
        }
        $node->appendChild($dom->createTextNode($value));
        
        $variables->appendChild($node);
    }

    /**
    * @desc Adott xml node els� adott nev� child node-j�nak lek�rdez�se.
    * 
    * @param DomNode $record
    * @param string $childName
    * 
    * @return DomNode az adott nev� Node / Element vagy NULL
    */
    function getChildElement($record, $childName) {
        $result = NULL;
        $childNodes = $record->childNodes;
        for($i = 0; !is_null($childNodes) && $i<= $childNodes->length && is_null($result); $i++){
            $item = $childNodes->item($i);
            if ($item->nodeName == $childName) 
                $result = $childNodes->item($i);
        }
        return $result;
    }
    
    /**
    * @desc Adott xml node adott nev� child node-ja sz�veges 
    * tartalm�nak lek�rdez�se. Az eredm�ny �sszef�zve tartalmazza 
    * az XML_TEXT_NODE t�pus� child node-k �rt�k�t.
    * 
    * @param DomNode $record a sz�l� node
    * @param string $childNode a child node neve
    * 
    * @return string a child node sz�veges tartalma
    */
    function getElementText($record, $childName) {
        $result = NULL;
        $childNode = self::getChildElement($record, $childName);
        if (!is_null($childNode)) $result = $childNode->textContent;
        return iconv($record->ownerDocument->actualEncoding, WS_CUSTOMERPAGE_CHAR_ENCODING, $result);
    }

    /**
    * @desc XPath kifejez�s ki�rt�kel�se, mely egy
    * adott elemt�l indul �s egy elemre vonatkozik. 
    * Lista eset�n az els� elem ker�l a v�laszba.
    * 
    * @param DOMDocument / DOMNode $node a ki�rt�kel�s helye
    * @param string $xpath xpath kifejez�s
    */
    function getNodeByXPath($node, $xpath) {
        $doc = NULL;
        if (is_a($node, 'DOMDocument')) {
            $doc = $node;
            $node = $node->documentElement;   
        }
        else {
            $doc = $node->ownerDocument;
        }
        
        $path = new DOMXPath($doc);
        $record = $path->query($xpath, $node);

        if (is_a($record, 'DOMNodeList') && ($record->length > 0)) 
            $record = $record->item(0);

        return $record;
    }

    /**
    * @desc XPath kifejez�s ki�rt�kel�se, mely egy
    * adott elemt�l indul �s elemekre list�j�ra vonatkozik. 
    * 
    * @param DOMDocument / DOMNode $node a ki�rt�kel�s helye
    * @param string $xpath xpath kifejez�s
    */
    function getNodeArrayByXPath($node, $xpath) {
        $doc = NULL;
        if (is_a($node, 'DOMDocument')) {
            $doc = $node;
            $node = $node->documentElement;   
        }
        else {
            $doc = $node->ownerDocument;
        }
        
        $path = new DOMXPath($doc);
        $recordList = $path->query($xpath, $node);

        $result = array();
        if (is_a($recordList, 'DOMNodeList')) {
            for ($i=0; $i < $recordList->length; $i++) {
                $result[] = $recordList->item($i);
            }
        }
        else if (is_a($recordList, 'DOMNode')) {
            $result[] = $recordList;
        }

        return $result;
    }
    
    /**
    * @desc A banki tranzakci� output xml-j�nek �rtelmez�se, 
    * adott WResponse objektum felt�lt�se.
    * 
    * @param string $responseStr output xml sz�vege
    * @param WResponse felt�ltend� response objektum
    */
    function parseOutputXml ($responseStr, $wresponse) {
        $wresponse->response = $responseStr;
        $wresponse->responseDOM = new DomDocument();
        $wresponse->responseDOM->loadXML($wresponse->response);
        
        $path = new DOMXPath($wresponse->responseDOM);
        
        // V�laszk�dok list�j�nak el��ll�t�sa
        $wresponse->hasSuccessfulAnswer = false;
        $messageElements = $path->query('//answer/messagelist/message');
        for ($i = 0; $i < $messageElements->length; $i++) {
            $messageElement = $messageElements->item($i);
            $message = $messageElement->nodeValue;
            $wresponse->messages[] = $message;
            if ($message != WF_SUCCESS_TEXTS) {
                $wresponse->errors[] = $message;
            }
            else {
                $wresponse->hasSuccessfulAnswer = true;
            }
        }

        // T�j�koztat� k�dok list�j�nak el��ll�t�sa
        $infoElements = $path->query('//answer/infolist/info');
        for ($i = 0; $i < $infoElements->length; $i++) {
            $infoElement = $infoElements->item($i);
            $info = $infoElement->nodeValue;
            $wresponse->infos[] = $info;
        }
    }
  
    /**
    * DomDocument sz�veges reprezent�ci�ja
    * 
    * @param DomDocument $dom 
    * 
    * @return string $dom->saveXML()
    */
    function xmlToString($dom) {
        return $dom->saveXML();
    }
  
}

?>