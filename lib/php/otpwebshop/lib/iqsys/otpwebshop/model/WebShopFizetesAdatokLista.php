<?php

/**
* A WEBSHOPTRANZAKCIOLEKERDEZES tranzakciós válasz xml-t
* reprezentáló value object.
* 
* @author Bodnár Imre
* @version 3.3.1
*/
class WebShopFizetesAdatokLista {

    /**
    * Vonatkozó bolt posId-je.
    * 
    * @var string
    */
    var $posId;

    /**
    * A lekérdezett tranzakciók adatait reprezentáló
    * WebShopFizetesAdatok objektumok listája.
    * 
    * @var array
    */
    var $webShopFizetesAdatok;

    function getPosId() {
        return $this->posId;
    }

    function setPosId($posId) {
        $this->posId = $posId;
    }

    function getWebShopFizetesAdatok() {
        return $this->webShopFizetesAdatok;
    }

    /**
    * @desc Fizetés adatok tömb tárolása (referencia szerint)
    */
    function setWebShopFizetesAdatok(&$webShopFizetesAdatok) {
        $this->webShopFizetesAdatok = &$webShopFizetesAdatok;
    }

}

?>