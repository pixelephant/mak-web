<?php

/**
* Fizet�si tranzakci� ind�t�- �s v�lasz adatait tartalmaz�
* value object. A WEBSHOPTRANZAKCIOLEKERDEZES tranzakci�s v�lasz xml
* feldolgoz�sakor keletkezik, lek�rdezett t�telenk�nt egy darab.
* 
* @author Bodn�r Imre
* @version 3.3.1
*/
class WebShopFizetesAdatok {

    var $shopNev;
    var $nyelvkod;
    var $nevKell;
    var $telepulesKell;
    var $authorizaciosKod;
    var $utcaHazszam;
    var $megye;
    var $iranyitoszamKell;
    var $osszeg;
    var $devizanem;
    var $orszag;
    var $statuszKod;
    var $megyeKell;
    var $kozlemeny;
    var $mailCim;
    var $varos;
    var $teljesites;
    var $iranyitoszam;
    var $kozlemenyKell;
    var $posValaszkod;
    var $shopMegjegyzes;
    var $nev;
    var $shopLogoUrl;
    var $orszagKell;
    var $azonosito;
    var $vevoVisszaigazolasKell;
    var $mailCimKell;
    var $backURL;
    var $posId;
    var $utcaHazszamKell;
    var $ugyfelRegisztracioKell;
    var $regisztraltUgyfelId;
    var $teljesCim;
    var $telefon;

    var $ketszereplos;
    
    function getShopNev() {
        return $this->shopNev;
    }

    function setShopNev($shopNev) {
        $this->shopNev = $shopNev;
    }

    function getNyelvkod() {
        return $this->nyelvkod;
    }

    function setNyelvkod($nyelvkod) {
        $this->nyelvkod = $nyelvkod;
    }

    function isNevKell() {
        return $this->nevKell;
    }

    function setNevKell($nevKell) {
        $this->nevKell = $nevKell;
    }

    function isTelepulesKell() {
        return $this->telepulesKell;
    }

    function setTelepulesKell($telepulesKell) {
        $this->telepulesKell = $telepulesKell;
    }

    function getAuthorizaciosKod() {
        return $this->authorizaciosKod;
    }

    function setAuthorizaciosKod($authorizaciosKod) {
        $this->authorizaciosKod = $authorizaciosKod;
    }

    function getUtcaHazszam() {
        return $this->utcaHazszam;
    }

    function setUtcaHazszam($utcaHazszam) {
        $this->utcaHazszam = $utcaHazszam;
    }

    function getMegye() {
        return $this->megye;
    }

    function setMegye($megye) {
        $this->megye = $megye;
    }

    function isIranyitoszamKell() {
        return $this->iranyitoszamKell;
    }

    function setIranyitoszamKell($iranyitoszamKell) {
        $this->iranyitoszamKell = $iranyitoszamKell;
    }

    function getOsszeg() {
        return $this->osszeg;
    }

    function setOsszeg($osszeg) {
        $this->osszeg = $osszeg;
    }

    function getDevizanem() {
        return $this->devizanem;
    }

    function setDevizanem($devizanem) {
        $this->devizanem = $devizanem;
    }

    function getOrszag() {
        return $this->orszag;
    }

    function setOrszag($orszag) {
        $this->orszag = $orszag;
    }

    function getStatuszKod() {
        return $this->statuszKod;
    }

    function setStatuszKod($statuszKod) {
        $this->statuszKod = $statuszKod;
    }

    function isMegyeKell() {
        return $this->megyeKell;
    }

    function setMegyeKell($megyeKell) {
        $this->megyeKell = $megyeKell;
    }

    function getKozlemeny() {
        return $this->kozlemeny;
    }

    function setKozlemeny($kozlemeny) {
        $this->kozlemeny = $kozlemeny;
    }

    function getMailCim() {
        return $this->mailCim;
    }

    function setMailCim($mailCim) {
        $this->mailCim = $mailCim;
    }

    function getVaros() {
        return $this->varos;
    }

    function setVaros($varos) {
        $this->varos = $varos;
    }

    function getTeljesites() {
        return $this->teljesites;
    }

    function setTeljesites($teljesites) {
        $this->teljesites = $teljesites;
    }

    function getIranyitoszam() {
        return $this->iranyitoszam;
    }

    function setIranyitoszam($iranyitoszam) {
        $this->iranyitoszam = $iranyitoszam;
    }

    function isKozlemenyKell() {
        return $this->kozlemenyKell;
    }

    function setKozlemenyKell($kozlemenyKell) {
        $this->kozlemenyKell = $kozlemenyKell;
    }

    function getPosValaszkod() {
        return $this->posValaszkod;
    }

    function setPosValaszkod($posValaszkod) {
        $this->posValaszkod = $posValaszkod;
    }

    function getShopMegjegyzes() {
        return $this->shopMegjegyzes;
    }

    function setShopMegjegyzes($shopMegjegyzes) {
        $this->shopMegjegyzes = $shopMegjegyzes;
    }

    function getNev() {
        return $this->nev;
    }

    function setNev($nev) {
        $this->nev = $nev;
    }

    function getShopLogoUrl() {
        return $this->shopLogoUrl;
    }

    function setShopLogoUrl($shopLogoUrl) {
        $this->shopLogoUrl = $shopLogoUrl;
    }

    function isOrszagKell() {
        return $this->orszagKell;
    }

    function setOrszagKell($orszagKell) {
        $this->orszagKell = $orszagKell;
    }

    function getAzonosito() {
        return $this->azonosito;
    }

    function setAzonosito($azonosito) {
        $this->azonosito = $azonosito;
    }

    function isVevoVisszaigazolasKell() {
        return $this->vevoVisszaigazolasKell;
    }

    function setVevoVisszaigazolasKell($vevoVisszaigazolasKell) {
        $this->vevoVisszaigazolasKell = $vevoVisszaigazolasKell;
    }

    function isMailCimKell() {
        return $this->mailCimKell;
    }

    function setMailCimKell($mailCimKell) {
        $this->mailCimKell = $mailCimKell;
    }

    function getBackURL() {
        return $this->backURL;
    }

    function setBackURL($backURL) {
        $this->backURL = $backURL;
    }

    function getPosId() {
        return $this->posId;
    }

    function setPosId($posId) {
        $this->posId = $posId;
    }

    function isUtcaHazszamKell() {
        return $this->utcaHazszamKell;
    }

    function setUtcaHazszamKell($utcaHazszamKell) {
        $this->utcaHazszamKell = $utcaHazszamKell;
    }

    function isUgyfelRegisztracioKell() {
        return $this->ugyfelRegisztracioKell;
    }

    function setUgyfelRegisztracioKell($ugyfelRegisztracioKell) {
        $this->ugyfelRegisztracioKell = $ugyfelRegisztracioKell;
    }

    function getRegisztraltUgyfelId() {
        return $this->regisztraltUgyfelId;
    }

    function setRegisztraltUgyfelId($regisztraltUgyfelId) {
        $this->regisztraltUgyfelId = $regisztraltUgyfelId;
    }

    function isKetszereplos() {
        return $this->ketszereplos;
    }

    function setKetszereplos($ketszereplos) {
        $this->ketszereplos = $ketszereplos;
    }

    function getTeljesCim() {
        return $this->teljesCim;
    }

    function setTeljesCim($teljesCim) {
        $this->teljesCim = $teljesCim;
    }

    function getTelefon() {
        return $this->telefon;
    }

    function setTelefon($telefon) {
        $this->telefon = $telefon;
    }
    
    /**
    * @desc Megadja, hogy a tranzakci� csak regisztr�l�s m�veletre vonatkozik-e
    */
    function isCsakRegisztracio() {
        return ($this->isUgyfelRegisztracioKell() && ("0" == $this->getOsszeg()));
    }
    
    /**
    * @desc Megadja, hogy t�rt�nt-e b�rmilyen �rtes�t�si c�m megad�s a fizet�s sor�n.
    * Igaz, ha legal�bb egy �rtes�t�si adatra vonatkoz� ...Kell input v�ltoz� igaz volt
    */
    function isErtesitesiCimKell() {
        return (
            $this->nevKell || $this->orszagKell 
                || $this->megyeKell || $this->telepulesKell 
                || $this->utcaHazszamKell || $this->iranyitoszamKell);
    }
    
    /**
    * @desc Megadja, hogy a k�rtyarendszerben sikeresen megt�rt�nt a fizet�si k�r�s befogad�sa.
    * Nem k�tl�pcs�s fizet�s eset�n ez a sikeres v�s�rl�st jelenti.
    */
    function isSuccessful() {
        return in_array($this->posValaszkod, array('000', '001','002', '003','004', '005','006', '007','008', '009', '010'))
            || ($this->ugyfelRegisztracioKell && "0" == $this->osszeg && "FELDOLGOZVA" == $this->statuszKod);
    }
    
    /**
    * @desc Megadja, hogy a h�romszerepl�s fizet�s feldolgoz�s alatti st�tuszban van-e,
    * azaz a st�tuszk�d "VEVOOLDAL_INPUTVARAKOZAS" vagy "FELDOLGOZAS_ALATT"
    */
    function isFizetesFeldolgozasAlatt() {
        return ("FELDOLGOZAS_ALATT" == $this->statuszKod) || ("VEVOOLDAL_INPUTVARAKOZAS" == $this->statuszKod);
    }
  
}

?>