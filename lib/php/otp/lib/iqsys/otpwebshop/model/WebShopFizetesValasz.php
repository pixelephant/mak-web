<?php

/**
* @desc A k�tszerepl�s fizet�si tranzakci� illetve 
* a k�tl�pcs�s fizet�s lez�r�sa tranzakci� v�laszadatait
* tartalmaz� bean / value object.
* 
* @author Bodn�r Imre - IQSYS
* @version 3.3.1
*/
class WebShopFizetesValasz {

    /**
    * @desc Shop azonos�t�, mely megegyezik a inputban megadott �rt�kkel.
    * 
    * @var string
    */
    var $posId;
    
    /**
    * @desc Fizet�si tranzakci� azonos�t�, megegyezik az inputban megadott fizet�si tranzakci� azonos�t�val.
    * 
    * @var string
    */
    var $azonosito;

    /**
    * @desc A teljes�t�s id�pecs�tje megadja a fizet�si tranzakci� v�g�nek (lez�r�s�nak) id�pontj�t. 
    * Sikeres �s sikertelen v�s�rl�sok eset�n is kit�lt�sre ker�l.
    * 
    * @var string
    */
    var $teljesites;

    /**
    * @desc A v�laszk�d a fizet�si tranzakci� �eredm�nye�. 
    * Sikeres v�s�rl�s eset�n egy h�romjegy� numerikus k�d a 000-010 �rt�ktartom�nyb�l. 
    * Sikertelen v�s�rl�s eset�n, amennyiben a hiba (vagy elutas�t�s) a terhel�s m�velete sor�n t�rt�nik 
    * (a k�rtyavezet� rendszerben), szint�n egy h�romjegy� numerikus k�d jelenik meg, mely a 010 �rt�kn�l nagyobb. 
    * Egy�b hiba (vagy elutas�t�s) eset�n a v�laszk�d egy olyan alfanumerikus "olvashat�" k�d, 
    * mely a hiba (vagy elutas�t�s) ok�t adja meg.
    * 
    * @var string
    */
    var $valaszKod;
    
    /**
    * @desc Authoriz�ci�s k�d, a POS-os v�s�rl�shoz tartoz� authoriz�ci�s enged�ly sz�m. 
    * Csak sikereses v�s�rl�si tranzakci�k eset�n ker�l kit�lt�sre. 
    * Az adat a k�rtyavezet� rendszer v�lasza a  v�s�rl�shoz tartoz� k�rtyaterhel�si m�velethez, 
    * egyfajta azonos�t� / hiteles�t� k�d, s mint ilyen, a vev� oldali fel�leten is megjelenik, 
    * valamint a bolt is megkapja v�laszadatk�nt. Ez a k�d mindk�t f�l sz�m�ra t�roland� adat!
    */
    var $authorizaciosKod;

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

    function getValaszKod() {
        return $this->valaszKod;
    }

    function setValaszKod($valaszKod) {
        $this->valaszKod = $valaszKod;
    }

    function getAuthorizaciosKod() {
        return $this->authorizaciosKod;
    }

    function setAuthorizaciosKod($authorizaciosKod) {
        $this->authorizaciosKod = $authorizaciosKod;
    }

}

?>