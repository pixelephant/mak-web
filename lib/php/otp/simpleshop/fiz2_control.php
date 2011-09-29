<?php

/*

Kétszereplõs fizetési tranzakció indítása PHP környezetbõl. Az indítást a
process metódus végzi, mely a banki SOAP felület közvetlen meghívásával
elindítja a kétszereplõs fizetési tranzakciót. A kliens oldali böngészõ
mindaddig az oldal letöltésére fog várakozni, míg a tranzakció be nem
fejezõdött - a várakokázi idõ jellemzõen 1-2 másodperc.

Az indítást követõen a process metódus alapértelmezett mûködése:
- Amennyiben a tranzakció sikeresen lefutott, és a válasz feldolgozása
sem jelez hibát, a kliens oldal a "webshop_success_answerpage_url"
paraméterben megadott url-re fog kerülni, mely url-be rendre az alábbi
értékek fognak behelyettesítõdni: posId, tranzakció azonosító, authorizációs
kód.
- Amennyiben a tranzakció sikertelenül futott le, akkor a 
"webshop_failed_answerpage_url" paraméterben megadott url-re fog kerülni 
a vezérlés, a posId, tranzakció azonosító és hibakód behelyettesítõdése után.
- Egyéb esetben (megszakadt kommunikáció, vagy a válasz feldolgozás
hibát jelez) a webshop_unknown_answerpage_url paraméterben megadott url-re 
fog kerülni a vezérlés, a posId és tranzakció azonosító behelyettesítõdése után.
A vezérlésátadás történhet a PHP include utasításával vagy böngészõ oldali
redirectálással.

A vonatkozó paraméterek a ketszereplosshop.conf fájlban konfigurálhatók.

A process metódus megfelelõ paraméterezése mellett a vezérlésátadás lépés 
kihagyható. Ilyenkor a metódus visszatérési értéke használható, mely a 
Banki felület teljes válaszát tartalmazza. Ugyancsak hozzáférhetõ a fizetési 
válasz objektum akkor, ha a fenti url jellegû paraméter lokális php kódra 
történõ hivatkozást tartalmaznak, amit a kontroller include-olhat.

Az eljárás támogatja a kétlépcsõs fizetési módot: ha paraméterként átadásra
kerül a ketlepcsosFizetes jelzõ, akkor annak logikai értéke explicit módon
átadásra kerül a Bank felé küldött kérésben.

A forráskód demonstrációs jellegû, szabadon módosítható.

@author Bodnár Imre, IQSYS
@version 3.3.1

*/

define('SIMPLESHOP_CONFIGURATION', '../config/ketszereplosshop.conf');

if (!defined('WEBSHOP_LIB_DIR')) define('WEBSHOP_LIB_DIR', dirname(__FILE__) . '/../lib');

require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/WebShopService.php');
//require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/WebShopServiceSimulator.php');
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/ConfigUtils.php');

/**
* @desc Kétszereplõs fizetési tranzakció indítása, a bank oldali
* kommunikáció lebonyolításával és a vevõ oldali (böngészõ) felület
* megfelelõ átirányításával.
* 
* Automatikus redirektálás / include-olás esetén definiálásra kerülõ értékek
* illetve global változók:
* "response" => WResponse típusú objektum, mely a fizetési tranzakcióhoz
*               tartozó összes válaszadatot tartalmazza
* "tranzAdatok" => WebShopFizetesValasz típusú objektum, a sikeres 
*                  vásárláshoz tartozó válaszobjektum (value object)
* 
* @param $doRedirect a fizetési tranzakció végrehajtása után végre kell-e
* hajtani az eredményoldalakra történõ redirect / include lépéseket a
* ketszereplosshop.conf (vagy a 'SIMPLESHOP_CONFIGURATION'-ban megadott)
* állományban leírt url-ek alapján. [Alapértelmezett érték: true]
* 
* @return a fizetési tranzakció banki felület által visszaadott és 
* értelmezett értéke, WResponse típusú objektum. 
*/
function process($doRedirect = true) {

    global $response;
    
    $service = new WebShopService();

    $posId = RequestUtils::safeParam($_REQUEST, "posId");
    $tranzAzon = RequestUtils::safeParam($_REQUEST, "tranzakcioAzonosito");
    if (is_null($tranzAzon) || (trim($tranzAzon) == "")) {               
        $tranzAzonResponse =  $service->tranzakcioAzonositoGeneralas($posId);
        if ($tranzAzonResponse->hasSuccessfulAnswer) {
            $tranzAzon = $tranzAzonResponse->answerModel->getAzonosito();
        }
    }

    global $response;
    if (!is_null($tranzAzon) && (trim($tranzAzon) != "")) {

        // Fizetési tranzakció indítása
        syslog(LOG_NOTICE, "Ketszereplos fizetes keres kuldes: " . $posId . " - " . $tranzAzon);

        $response = $service->fizetesiTranzakcioKetszereplos(
            $posId,
            $tranzAzon,
            RequestUtils::safeParam($_REQUEST,"osszeg"),
            RequestUtils::safeParam($_REQUEST,"devizanem"),
            RequestUtils::safeParam($_REQUEST,"nyelvkod"),
            RequestUtils::safeParam($_REQUEST,"regisztraltUgyfelId"),
            RequestUtils::safeParam($_REQUEST,"kartyaszam"),
            RequestUtils::safeParam($_REQUEST,"cvc2Cvv2"),
            RequestUtils::safeParam($_REQUEST,"kartyaLejarat"),
            RequestUtils::safeParam($_REQUEST,"vevoNev"),
            RequestUtils::safeParam($_REQUEST,"vevoPostaCim"),
            RequestUtils::safeParam($_REQUEST,"vevoIPCim"),
            RequestUtils::safeParam($_REQUEST,"ertesitoMail"),
            RequestUtils::safeParam($_REQUEST,"ertesitoTel"),
            RequestUtils::safeParam($_REQUEST,"ketlepcsosFizetes"));

        /*********
         Itt a helye a shop-specifikus eredmény feldolgozásnak / tárolásnak
         ********/
    }
    else {
        /* Sikertelen volt a tranzakció azonosítás */
    }
    
    if ($response) {
        global $tranzAdatok;
        $tranzAdatok = $response->getAnswer();
        syslog(LOG_NOTICE, "Ketszereplos fizetes keres kuldes: " . $posId . " - " . $tranzAzon . " - " . implode($response->getMessages()));
    }
    else {
        syslog(LOG_ERR, "Ketszereplos fizetes keres kuldes: " . $posId . " - " . $tranzAzon . " - NEM ERTELMEZHETO VALASZ!");
    }

    if ($doRedirect) processRedirect($posId, $tranzAzon, $response);        
    
    return $response;
}

/**
 * @desc A kétszereplõs fizetés eredményének megjelenítése a shop oldalon
 * a ketszereplosshop.conf (vagy a 'SIMPLESHOP_CONFIGURATION'-ban megadott)
 * állományban leírt url-ek alapján.
 *
 * A metódus a fizetési tranzakció válaszának megfelelõen
 * jelenít meg egy hiba oldalt vagy eredmény oldalt.
 * 
 * A $_REQUEST-be kerülõ értékek:
 * "response" => WResponse típusú objektum, mely a fizetési tranzakcióhoz
 *               tartozó összes válaszadatot tartalmazza
 * "tranzAdatok" => WebShopFizetesValasz típusú objektum, a sikeres 
 *                  vásárláshoz tartozó válaszobjektum (value object)
 */
function processRedirect($posId, $tranzAzon, $response) {

    $config = parse_ini_file(SIMPLESHOP_CONFIGURATION);

    $successAnswerPage =
        ConfigUtils::getConfigParam($config, 'webshop_success_answerpage_url', $posId);
    $failedAnswerPage =
        ConfigUtils::getConfigParam($config, 'webshop_failed_answerpage_url', $posId);
    $unknownAnswerPage =
        ConfigUtils::getConfigParam($config, 'webshop_unknown_answerpage_url', $posId);

    // Igaz, ha sikertelen volt a tranzakció indítás, vagy a válasz értelmezése
    $isUnknown = true;

    // Igaz, ha a fizetés visszautasításra került a banki oldalon
    $isFailedPayment = false;

    $_REQUEST['response'] = $response;

    if ($response) {
        global $tranzAdatok;
        $tranzAdatok = $response->getAnswer();
        $_REQUEST['tranzAdatok'] = $tranzAdatok;
        
        if ($response->isSuccessful()
                && $response->getAnswer()) {
            // Sikerült a tranzakció indítás 
            $responseCode = $tranzAdatok->getValaszkod();

            $successPosResponseCodes = array(
                "000", "00", "001", "002", "003", "004",
                "005", "006", "007", "008", "009", "010");

            if (in_array($responseCode, $successPosResponseCodes)) {
                // A vásárlás sikeres volt
                $successAnswerPage = ConfigUtils::substConfigValue($successAnswerPage,
                    array("0" => urlencode($posId),
                          "1" => urlencode($tranzAzon),
                          "2" => urlencode($tranzAdatok->getAuthorizaciosKod())));
                RequestUtils::includeOrRedirect($successAnswerPage);
            }
            else {
                // A tranzakció sikertelen volt.
                // Valószínûleg a kártya terhelés nem végezhetõ el
                $failedAnswerPage = ConfigUtils::substConfigValue($failedAnswerPage,
                    array("0" => urlencode($posId),
                          "1" => urlencode($tranzAzon),
                          "2" => urlencode($responseCode)));
                RequestUtils::includeOrRedirect($failedAnswerPage);
            }
        }
        else {
            // A tranzakció sikertelen volt.
            // Valószínûleg a kártya terhelés nem végezhetõ el
            $failedAnswerPage = ConfigUtils::substConfigValue($failedAnswerPage,
                array("0" => urlencode($posId),
                      "1" => urlencode($tranzAzon),
                      "2" => urlencode(implode(',', $response->getMessages()))));
            RequestUtils::includeOrRedirect($failedAnswerPage);
        }
    }
    else {
        // Ha nem sikerült elindítani a folyamatot vagy értelmezni a választ...
        $unknownAnswerPage = ConfigUtils::substConfigValue($unknownAnswerPage,
            array("0" => urlencode($posId),
                  "1" => urlencode($tranzAzon)));
        RequestUtils::includeOrRedirect($unknownAnswerPage);
    }
}

?>