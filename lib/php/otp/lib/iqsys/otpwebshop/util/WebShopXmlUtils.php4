<?php

if (!defined('WEBSHOP_LIB_DIR')) define('WEBSHOP_LIB_DIR', dirname(__FILE__) . '/../..');

require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/DefineConst.php');

/**
* A SimpleShop PHP �s a WebShop PHP kliens �ltal haszn�lt utility oszt�ly
* XML sz�vegek �s DomDocument objektumok kezel�s�re, PHP4 k�rnyezetben.
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
        $dom = domxml_new_doc('1.0');
        $root = $dom->create_element('StartWorkflow');
        $dom->append_child($root);

        $templateNameNode = $root->append_child($dom->create_element('TemplateName'));
        $templateNameNode->append_child($dom->create_text_node($templateName));

        $variables = $dom->create_element('Variables');
        $root->append_child($variables);

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
            $value = iconv(WS_CUSTOMERPAGE_CHAR_ENCODING, WF_INPUTXML_ENCODING, $value);            
        }
        
        $node = $dom->create_element($name);
        $node->append_child($dom->create_text_node($value));
        
        $variables->append_child($node);
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
        foreach ($record->child_nodes() as $item) {
            if ($item->node_name() == $childName) {
                $result = $item;
                break;
            }
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
    function getElementText($record, $childName = NULL) {
        $result = NULL;
        $childNode = (is_null($childName) ? $record : WebShopXmlUtils::getChildElement($record, $childName));
        if (!is_null($childNode)) {
            foreach ($childNode->child_nodes() as $item) {
                if ($item->node_type() == XML_TEXT_NODE)
                    $result .= $item->node_value();
            }
            $dom = $record->owner_document();
            $result = iconv(WF_INPUTXML_ENCODING, WS_CUSTOMERPAGE_CHAR_ENCODING, $result);
        }
        return $result;
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
            $node = $node->document_element();   
        }
        else {
            $doc = $node->owner_document();   
        }

        $path = $doc->xpath_new_context();        
        $nodes = $path->xpath_eval($xpath, $node);
        return empty($nodes->nodeset) ? null : current($nodes->nodeset);
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
            $node = $node->document_element();
        }
        else {
            $doc = $node->owner_document();   
        }

        $path = $doc->xpath_new_context();        
        $nodes = $path->xpath_eval($xpath, $node);
        return $nodes->nodeset;
    }
    
    /**
    * @desc A banki tranzakci� output xml-j�nek �rtelmez�se, 
    * adott WResponse objektum felt�lt�se.
    * 
    * @param string $responseStr output xml sz�vege
    * @param WResponse felt�ltend� response objektum
    */
    function parseOutputXml ($responseStr, &$wresponse) {
        $wresponse->response = $responseStr;
        $wresponse->responseDOM = domxml_open_mem($responseStr);

        $doc = $wresponse->responseDOM;
        $path = $doc->xpath_new_context();        
        
        // V�laszk�dok list�j�nak el��ll�t�sa
        $wresponse->hasSuccessfulAnswer = false;
        $messageElements = $path->xpath_eval('//answer/messagelist/message');
        foreach ($messageElements->nodeset as $messageElement) {
            $message = WebShopXmlUtils::getElementText($messageElement);
            $wresponse->messages[] = $message;
            if ($message != WF_SUCCESS_TEXTS) {
                $wresponse->errors[] = $message;
            }
            else {
                $wresponse->hasSuccessfulAnswer = true;
            }
        }

        // T�j�koztat� k�dok list�j�nak el��ll�t�sa
        $infoElements = $path->xpath_eval('//answer/infolist/info');
        foreach ($infoElements->nodeset as $infoElement) {
            $info = WebShopXmlUtils::getElementText($infoElement);
            $wresponse->infos[] = $info;
        }
    }
  
    /**
    * DomDocument sz�veges reprezent�ci�ja
    * 
    * @param DomDocument $dom 
    * 
    * @return string $dom->dump_mem()
    */
    function xmlToString($dom) {
        return $dom->dump_mem();
    }

}

?>