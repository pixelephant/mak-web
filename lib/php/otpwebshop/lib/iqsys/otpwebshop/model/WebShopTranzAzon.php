<?php

/**
* Fizetési tranzakció azonosító generálás (WEBSHOPTRANZAZONGENERALAS)
* válasz adatának value object reprezentációja.
* 
* @author Bodnár Imre - IQSYS
* @version 3.3.1
*/
class WebShopTranzAzon  {
    
    var $posId;
    var $azonosito;
    var $teljesites;

    function getPosId() {
        return $this->posId;
    }

    function setPosId($posId) {
        $this->posId = $posId;
    }

    function getAzonosito() {
        return $this->azonosito;
    }

    function setAzonosito($azonosito) {
        $this->azonosito = $azonosito;
    }

    function getTeljesites() {
        return $this->teljesites;
    }

    function setTeljesites($teljesites) {
        $this->teljesites = $teljesites;
    }

}

?>