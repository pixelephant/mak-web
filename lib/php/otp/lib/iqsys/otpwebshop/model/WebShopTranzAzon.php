<?php

/**
* Fizet�si tranzakci� azonos�t� gener�l�s (WEBSHOPTRANZAZONGENERALAS)
* v�lasz adat�nak value object reprezent�ci�ja.
* 
* @author Bodn�r Imre - IQSYS
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