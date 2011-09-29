<?php

/*

Fizetési tranzakció lekérdezés indítása PHP környezetbõl. Az indítást a
process metódus végzi, mely a banki SOAP felület közvetlen meghívásával
elindítja a tranzakció lekérdezést.

Ne feledjük, hogy a tranzakciók "utólagos" lekérdezése nem kötõdik a vevõhöz,
hiszen tisztán bolti / adminisztratív jellegû tevékenységrõl van szó.

A forráskód demonstrációs jellegû, szabadon módosítható.

@author Bodnár Imre, IQSYS
@version 3.3.1

*/

if (!defined('WEBSHOP_LIB_DIR')) define('WEBSHOP_LIB_DIR', dirname(__FILE__) . '/../lib');

require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/WebShopService.php');
//require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/WebShopServiceSimulator.php');
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/RequestUtils.php');

/**
 * Fizetési tranzakciók lekérdezésének indítása, a bank oldali
 * kommunikáció lebonyolításával.
 *
 * @return WResponse a fizetési tranzakció lekérdezés banki felület által visszaadott
 * válaszát reprezentáló value object.
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