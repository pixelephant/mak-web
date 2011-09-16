<?php

if (!defined('WEBSHOP_LIB_DIR')) define('WEBSHOP_LIB_DIR', dirname(__FILE__) . '/../..');

require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/DefineConst.php');

/**
* A SimpleShop PHP és a WebShop PHP kliens által használt utility osztály
* XML szövegek és DomDocument objektumok kezelésére, PHP4 környezetben.
* 
* @version 3.3.1
* @author Bodnár Imre / IQSYS
*/
class WebShopXmlUtils {

    /**
    * @desc Banki tranzakcióhoz tartozó üres input xml váz létrehozása:
    * <StartWorkflow>
    *   <TemplateName>$templateName</TemplateName>
    *   <Variables/>
    * </StartWorkflow>
    * 
    * @param string $templateName az indíandó tranzakció neve (szöveges kódja)
    * @param DomNode $variables referencia az input xml-ben létrehozott
    * Varaibles tag-re.
    * 
    * @return DomDocument a létrehozott objektum
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
    * @desc Banki tranzakcióhoz tartozó input xml kiegészítése egy 
    * input változó értékkel. A változó értéknek olyan karakter
    * kódolásúnak kell lennie, ami a WS_CUSTOMERPAGE_CHAR_ENCODING
    * konstansban definiálásra került (a default érték az ISO-8859-2).
    * 
    * Megj: PHP 4.x alatt a namespace-t nem támogatja a metódus!
    * 
    * @param DomDocument $dom maga az input xml
    * @param DomNode $variables az xml Variables tag-je
    * @param string name a beillesztendõ változó neve
    * @param string value a beillesztendõ változó értéke.
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
    * @desc Adott xml node elsõ adott nevû child node-jának lekérdezése.
    * 
    * @param DomNode $record
    * @param string $childName
    * 
    * @return DomNode az adott nevû Node / Element vagy NULL
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
    * @desc Adott xml node adott nevû child node-ja szöveges 
    * tartalmának lekérdezése. Az eredmény összefûzve tartalmazza 
    * az XML_TEXT_NODE típusú child node-k értékét.
    * 
    * @param DomNode $record a szülõ node
    * @param string $childNode a child node neve
    * 
    * @return string a child node szöveges tartalma
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
    * @desc XPath kifejezés kiértékelése, mely egy
    * adott elemtõl indul és egy elemre vonatkozik. 
    * Lista esetén az elsõ elem kerül a válaszba.
    * 
    * @param DOMDocument / DOMNode $node a kiértékelés helye
    * @param string $xpath xpath kifejezés
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
    * @desc XPath kifejezés kiértékelése, mely egy
    * adott elemtõl indul és elemekre listájára vonatkozik. 
    * 
    * @param DOMDocument / DOMNode $node a kiértékelés helye
    * @param string $xpath xpath kifejezés
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
    * @desc A banki tranzakció output xml-jének értelmezése, 
    * adott WResponse objektum feltöltése.
    * 
    * @param string $responseStr output xml szövege
    * @param WResponse feltöltendõ response objektum
    */
    function parseOutputXml ($responseStr, &$wresponse) {
        $wresponse->response = $responseStr;
        $wresponse->responseDOM = domxml_open_mem($responseStr);

        $doc = $wresponse->responseDOM;
        $path = $doc->xpath_new_context();        
        
        // Válaszkódok listájának elõállítása
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

        // Tájékoztató kódok listájának elõállítása
        $infoElements = $path->xpath_eval('//answer/infolist/info');
        foreach ($infoElements->nodeset as $infoElement) {
            $info = WebShopXmlUtils::getElementText($infoElement);
            $wresponse->infos[] = $info;
        }
    }
  
    /**
    * DomDocument szöveges reprezentációja
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