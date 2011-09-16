<?php

/**
* A WEBSHOPTRANZAKCIOLEKERDEZES tranzakci�s v�lasz xml-t
* reprezent�l� value object.
* 
* @author Bodn�r Imre
* @version 3.3.1
*/
class WebShopFizetesAdatokLista {

    /**
    * Vonatkoz� bolt posId-je.
    * 
    * @var string
    */
    var $posId;

    /**
    * A lek�rdezett tranzakci�k adatait reprezent�l�
    * WebShopFizetesAdatok objektumok list�ja.
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
    * @desc Fizet�s adatok t�mb t�rol�sa (referencia szerint)
    */
    function setWebShopFizetesAdatok(&$webShopFizetesAdatok) {
        $this->webShopFizetesAdatok = &$webShopFizetesAdatok;
    }

}

?>