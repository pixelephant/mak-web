<?php

/*

Fizet�si tranzakci� lek�rdez�s ind�t�sa PHP k�rnyezetb�l. Az ind�t�st a
process met�dus v�gzi, mely a banki SOAP fel�let k�zvetlen megh�v�s�val
elind�tja a tranzakci� lek�rdez�st.

Ne feledj�k, hogy a tranzakci�k "ut�lagos" lek�rdez�se nem k�t�dik a vev�h�z,
hiszen tiszt�n bolti / adminisztrat�v jelleg� tev�kenys�gr�l van sz�.

A forr�sk�d demonstr�ci�s jelleg�, szabadon m�dos�that�.

@author Bodn�r Imre, IQSYS
@version 3.3.1

*/

if (!defined('WEBSHOP_LIB_DIR')) define('WEBSHOP_LIB_DIR', dirname(__FILE__) . '/../lib');

require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/WebShopService.php');
//require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/WebShopServiceSimulator.php');
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/RequestUtils.php');

/**
 * Fizet�si tranzakci�k lek�rdez�s�nek ind�t�sa, a bank oldali
 * kommunik�ci� lebonyol�t�s�val.
 *
 * @return WResponse a fizet�si tranzakci� lek�rdez�s banki fel�let �ltal visszaadott
 * v�lasz�t reprezent�l� value object.
 */
function process() {

    $posId = RequestUtils::safeParam($_REQUEST, 'posId');
    $tranzAzon = RequestUtils::safeParam($_REQUEST, 'tranzakcioAzonosito');
    $maxRekordSzam = RequestUtils::safeParam($_REQUEST, 'maxRekordSzam');

    $idoszakElejeChecked = RequestUtils::getBooleanValue($_REQUEST['idoszakEleje']);
    $idoszakVegeChecked = RequestUtils::getBooleanValue($_REQUEST['idoszakVege']);

    if ($idoszakElejeChecked)
        global $idoszakEleje;
        $idoszakEleje = mktime(
            RequestUtils::safeParam($_REQUEST, 'idoszakEleje_ora'),
            RequestUtils::safeParam($_REQUEST, 'idoszakEleje_perc'),
            0,
            RequestUtils::safeParam($_REQUEST, 'idoszakEleje_honap'),
            RequestUtils::safeParam($_REQUEST, 'idoszakEleje_nap'),
            RequestUtils::safeParam($_REQUEST, 'idoszakEleje_ev')) ;
    if ($idoszakVegeChecked)
        global $idoszakVege;
        $idoszakVege = mktime(
            RequestUtils::safeParam($_REQUEST, 'idoszakVege_ora'),
            RequestUtils::safeParam($_REQUEST, 'idoszakVege_perc'),
            59,
            RequestUtils::safeParam($_REQUEST, 'idoszakVege_honap'),
            RequestUtils::safeParam($_REQUEST, 'idoszakVege_nap'),
            RequestUtils::safeParam($_REQUEST, 'idoszakVege_ev'));

    $service = new WebShopService();

    $response = $service->tranzakcioStatuszLekerdezes(
        $posId,
        $tranzAzon,
        $maxRekordSzam,
        $idoszakElejeChecked ? $idoszakEleje : NULL,
        $idoszakVegeChecked ? $idoszakVege : NULL);

    return $response;
}

?>