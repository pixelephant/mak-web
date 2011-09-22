<?php

/*

Háromszereplõs fizetési tranzakció indítása illetve az eredmény
meggjelenítése PHP környezetbõl.

Az indítást a process metódus végzi, mely az OTP Internetes Fizetési Felület
oldalára továbbítja a kliens kérést, miközben elindítja a
WebShopClient SOAP felületén keresztül történõ tranzakciót.

A vevõ átírányítása egy HTTP redirect header-t tartalmazó válasz összeállításával
és elküldéséveé történik. A fizetési tranzakció banki felületen történõ indítása
ekkor kezdõdik. Vagyis nincs szó igazi párhuzamosságról, csupán arról, hogy
a vevõ által indított HTTP kérés - bár a kliens oldali böngészõt átírányítja
a banki felületre - a valóságban jóval tovább dolgozódik fel, s majd akkor ér
véget, mikor a bank feldolgozza a vevõ oldali felületen megadott kártyaadatokkal
végrehajtandó terhelést.

Megjegyzés: a BackUrl-t küldésnél dinamikusan állítjuk össze úgy,
hogy erre a szervletre mutasson, és tartalmazza a tranzakció adatait (posId
és tranzakció id) valamint egy jelzõt, hogy a kérésnek egy sikeroldalt kell
megjelenítenie, és nem fizetési folyamatot indítania. E sikeroldal
megjelenítését a processDirectedToBackUrl végzi el.

A válasz feldolgozását a processDirectedToBackUrl metódus végzi, amit - ahogy
a neve is mutatja - a backUrl-lel megcímzett programkódban célszerû meghívni.
A processDirectedToBackUrl metódus alapértelmezett mûködése:
- Lekérdezi a tranzakció eredményét a tranzakcioStatuszLekerdezes szolgáltatás
hívással, és kielemzi a lekérdezett fizetési tranzakció adatait.
- Amennyiben a fizetési tranzakció sikeresen lefutott, a kliens oldal 
a "webshop_success_answerpage_url" paraméterben megadott url-re fog kerülni, 
mely url-be rendre az alábbi értékek fognak behelyettesítõdni: posId, 
tranzakció azonosító, authorizációs kód.
- Amennyiben a fizetési tranzakció sikertelenül futott le (kártyaterhelési
hiba, idõtúllépés vagy egyéb hiba miatt), akkor a "webshop_failed_answerpage_url" 
paraméterben megadott url-re fog kerülni a vezérlés, a posId, tranzakció azonosító 
és hibakód behelyettesítõdése után.
- Amennyiben a fizetési tranzakciót az ügyfél elutasította sikertelenül futott le, 
akkor a "webshop_cancelled_answerpage_url" paraméterben megadott url-re fog kerülni 
a vezérlés, a posId, tranzakció azonosító behelyettesítõdése után.
- Egyéb esetben (megszakadt kommunikáció, vagy a válasz feldolgozás
hibát jelez) a webshop_unknown_answerpage_url paraméterben megadott url-re 
fog kerülni a vezérlés, a posId és tranzakció azonosító behelyettesítõdése után.
A vezérlésátadás történhet a PHP include utasításával vagy böngészõ oldali
redirectálással.

A vonatkozó paraméterek a haromszereplosshop.conf fájlban konfigurálhatóak.

A processDirectedToBackUrl metódus megfelelõ paraméterezése mellett a vezérlésátadás 
lépés kihagyható. Ilyenkor a metódus visszatérési értéke használható, mely a 
fizetési tranzakció válaszát tartalmazza. Ugyancsak hozzáférhetõ a fizetési válasz
objektum akkor, ha a fenti url jellegû paraméter lokális php kódra történõ
hivatkozást tartalmaznak, amit a kontroller include-olhat.

A feldolgozás támogatja a kétlépcsõs fizetési módot: ha paraméterként átadásra
kerül a ketlepcsosFizetes jelzõ, akkor annak logikai értéke explicit módon
átadásra kerül a Bank felé küldött kérésben.

A forráskód demonstrációs jellegû, szabadon módosítható.

@author Bodnár Imre, IQSYS
@version 3.3.1

*/

define('SIMPLESHOP_CONFIGURATION', '../config/mak.conf');

if (!defined('WEBSHOP_LIB_DIR')) define('WEBSHOP_LIB_DIR', dirname(__FILE__) . '/../lib');

require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/WebShopService.php');
//require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/WebShopServiceSimulator.php');
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/RequestUtils.php');
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/ConfigUtils.php');

/**
* @desc Háromszereplõs fizetési tranzakció indítása, a bank oldali
* kommunikáció lebonyolításával és a vevõ oldali (böngészõ) felület
* megfelelõ átirányításával.
* 
* Automatikus redirektálás / include-olás esetén definiálásra kerülõ értékek
* illetve global változók:
* "response" => WResponse típusú objektum, mely a fizetési tranzakcióhoz
*               tartozó összes válaszadatot tartalmazza
* "tranzAdatok" => WebShopFizetesValasz típusú objektum, a 
*                  vásárláshoz tartozó válaszobjektum (value object)
* 
* @return a fizetési tranzakció banki felület által visszaadott és 
* értelmezett értéke, WResponse típusú objektum. 
*/
function process() {

    ob_start();

    $config = parse_ini_file(SIMPLESHOP_CONFIGURATION);
    $service = new WebShopService();

    // Paraméterek összegyûjtése a kérésbõl
    $posId = RequestUtils::safeParam($_REQUEST, 'posId');
    //$podId = $boltid;
    $tranzAzon = RequestUtils::safeParam($_REQUEST, 'tranzakcioAzonosito');
    $nyelvkod = RequestUtils::safeParam($_REQUEST, 'nyelvkod');
    $nev = $_REQUEST['name'];
    //$nyelvkod = $nyelv;

    if (is_null($tranzAzon) || (trim($tranzAzon) == "")) {
        $tranzAzonResponse =  $service->tranzakcioAzonositoGeneralas($posId);
        if ($tranzAzonResponse->hasSuccessfulAnswer) {
            $tranzAzon = $tranzAzonResponse->answerModel->getAzonosito();
        }
    }
    
    if (is_null($tranzAzon) || (trim($tranzAzon) == "")) {
        processDirectedToBackUrl();
        return;
    }
    
    // Ügyfél átirányítása a vevõ oldali felületre
    $custPageTemplate = $config['webshop_customerpage_url'];
    $custPageTemplate = ConfigUtils::substConfigValue($custPageTemplate,
        array("0" => urlencode($posId),
              "1" => urlencode($tranzAzon),
              "2" => urlencode($nyelvkod)));

    header("Connection: close");
    header("Location: " . $custPageTemplate);
    header("Content-Length: " . ob_get_length());
    ob_end_flush();
    flush();

    // BackURL manipláció
    $backUrl = $_REQUEST['backURL'];
    if (!is_null($backUrl) && trim($backUrl) != '') {
        if (ConfigUtils::getConfigParamBool($config, 'append_trandata_to_backurl', $posId, true)) {
            $backUrl =
                RequestUtils::addUrlQuery($backUrl,
                    array('fizetesValasz' => 'true',
                          'posId' => $posId,
                          'tranzakcioAzonosito' => $tranzAzon,
                          'nev' => $nev));
        }
    }

    syslog(LOG_NOTICE, "Haromszereplos fizetes keres kuldes: " . $posId . " - " . $tranzAzon);

    global $response;
    
    //Balazs
    $kartya['bronz'] = '5000';
	$kartya['ezust'] = '7500';
	$kartya['arany'] = '10000';
    
    //$_REQUEST['osszeg'] = $kartya[$_REQUEST['kartya']];
    
    // Fizetési tranzakció elindítása
    /*
    $response = $service->fizetesiTranzakcio(
        $posId,
        $tranzAzon,
        RequestUtils::safeParam($_REQUEST, 'osszeg'),
        RequestUtils::safeParam($_REQUEST, 'devizanem'),
        $nyelvkod,
        RequestUtils::safeParam($_REQUEST, 'nevKell'),
        RequestUtils::safeParam($_REQUEST, 'orszagKell'),
        RequestUtils::safeParam($_REQUEST, 'megyeKell'),
        RequestUtils::safeParam($_REQUEST, 'telepulesKell'),
        RequestUtils::safeParam($_REQUEST, 'iranyitoszamKell'),
        RequestUtils::safeParam($_REQUEST, 'utcaHazszamKell'),
        RequestUtils::safeParam($_REQUEST, 'mailCimKell'),
        RequestUtils::safeParam($_REQUEST, 'kozlemenyKell'),
        RequestUtils::safeParam($_REQUEST, 'vevoVisszaigazolasKell'),
        RequestUtils::safeParam($_REQUEST, 'ugyfelRegisztracioKell'),
        RequestUtils::safeParam($_REQUEST, 'regisztraltUgyfelId'),
        RequestUtils::safeParam($_REQUEST, 'shopMegjegyzes'),
        $backUrl,
        RequestUtils::safeParam($_REQUEST, "ketlepcsosFizetes"));
		*/
    //Balazs
    
     	$response = $service->fizetesiTranzakcio(
        $posId,
        $tranzAzon,
        $_REQUEST['osszeg'],
        RequestUtils::safeParam($_REQUEST, 'devizanem'),
        $nyelvkod,
        RequestUtils::safeParam($_REQUEST, 'nevKell'),
        RequestUtils::safeParam($_REQUEST, 'orszagKell'),
        RequestUtils::safeParam($_REQUEST, 'megyeKell'),
        RequestUtils::safeParam($_REQUEST, 'telepulesKell'),
        RequestUtils::safeParam($_REQUEST, 'iranyitoszamKell'),
        RequestUtils::safeParam($_REQUEST, 'utcaHazszamKell'),
        RequestUtils::safeParam($_REQUEST, 'mailCimKell'),
        RequestUtils::safeParam($_REQUEST, 'kozlemenyKell'),
        RequestUtils::safeParam($_REQUEST, 'vevoVisszaigazolasKell'),
        RequestUtils::safeParam($_REQUEST, 'ugyfelRegisztracioKell'),
        RequestUtils::safeParam($_REQUEST, 'regisztraltUgyfelId'),
        'Fizetés: '.utf8_decode($_REQUEST['uzenet']),
        $backUrl,
        RequestUtils::safeParam($_REQUEST, "ketlepcsosFizetes"));   
        
    /*********
     Itt a helye a shop-specifikus eredmény feldolgozásnak / tárolásnak
     ********/
        
        $_SESSION['response'] = $response;

    if ($response) {
        syslog(LOG_NOTICE, "Haromszereplos fizetes keres kuldes: " . $posId . " - " . $tranzAzon . " - " . implode($response->getMessages()));
    }
    else {
        syslog(LOG_ERR, "Haromszereplos fizetes keres kuldes: " . $posId . " - " . $tranzAzon . " - NEM ERTELMEZHETO VALASZ!");
    }
    
    return $response;
}

/**
 * processDirectedToBackUrl
 * A háromszereplõs fizetés eredményének megjelenítése a shop oldalon.
 * E megjelenítésnek akkor van komoly szerepe, amikor a fizetési tranzakcióban a
 * <i>vevoVisszaigazolas</i> paraméter értéke hamis volt. Ekkor ugyanis az
 * Internetes Fizetési Felület "továbbírányítja" a válaszoldal
 * megjelenítését a <i>backURL</i> értékben átadott oldalra. Sikeres és
 * sikertelen tranzakció esetén egyaránt ez az oldal jelenik meg, ezért van
 * szükség dinamikus (a fizetés eredményétõl függõ) megjelenítésre.
 *
 * A metódus lekérdezi a fizetési tranzakció adatát, és annak megfelelõen
 * jeleníti meg a hiba oldalt vagy az eredmény oldalt.
 * 
 * Az include-olás esetén definiálásra kerülõ értékek illetve global változók:
 * "tranzAdatok" => WebShopFizetesValasz típusú objektum, a 
 *                  vásárláshoz tartozó válaszobjektum (value object)
 *
 * @param $doRedirect a fizetési tranzakció végrehajtása után végre kell-e
 * hajtani az eredményoldalakra történõ redirect / include lépéseket a
 * haromszereplosshop.conf (vagy a 'SIMPLESHOP_CONFIGURATION'-ban megadott)
 * állományban leírt url-ek alapján. [Alapértelmezett érték: true]
 * 
 * @return WebShopFizetesAdatok a fizetési tranzakció input- és eredmény adatait
 *         tartalmazó value object. NULL, ha sikertelen volt a tranzakció 
 *         adatainak lekérdezése
 * 
 */
function processDirectedToBackUrl($doRedirect = true) {

    $posId = $_REQUEST['posId'];
    
    $posId = '#02299991';
    
    $tranzAzon = $_REQUEST['tranzakcioAzonosito'];

    $config = parse_ini_file(SIMPLESHOP_CONFIGURATION);

    $successAnswerPage =
        ConfigUtils::getConfigParam($config, 'webshop_success_answerpage_url', $posId);
    $cancelledAnswerPage =
        ConfigUtils::getConfigParam($config, 'webshop_cancelled_answerpage_url', $posId);
    $failedAnswerPage =
        ConfigUtils::getConfigParam($config, 'webshop_failed_answerpage_url', $posId);
    $unknownAnswerPage =
        ConfigUtils::getConfigParam($config, 'webshop_unknown_answerpage_url', $posId);

    global $tranzAdatok;
        
    if (!is_null($tranzAzon) && (trim($tranzAzon) != "")) {
        syslog(LOG_NOTICE, "Fizetes tranzakcio adat lekerdezes: " + $tranzAzon);

        // Lekérdezzük a fizetési tranzakció adatait.
        // A lekérdezett tranzakcióra definiálunk egy idõintervallumot is:
        // [aktuális idõpont - 24 óra ; aktuális idõpont + 24 óra]
        $service = new WebShopService();
        $response = $service->tranzakcioStatuszLekerdezes($posId, $tranzAzon, 1, time() - 60*60*24, time() + 60*60*24);

        if ($response) {

            $answer = $response->getAnswer();
            if ($response->isSuccessful()
                    && $response->getAnswer()
                    && count($answer->getWebShopFizetesAdatok()) > 0) {

                // Sikerült lekérdezni az adott tranzakció adatát
                $fizetesAdatok = $answer->getWebShopFizetesAdatok();
                $tranzAdatok = current($fizetesAdatok);
                $_REQUEST['tranzAdatok'] = $tranzAdatok;

                syslog(LOG_NOTICE, "Fizetes tranzakcio adat lekerdezes befejezve: " . $posId . " - " . $tranzAzon );

                $responseCode = $tranzAdatok->getPosValaszkod();

                $successPosResponseCodes = array(
                    "000", "00", "001", "002", "003", "004",
                    "005", "006", "007", "008", "009", "010");

                if ($tranzAdatok->isSuccessful()) {
                    // Az ügyfél megfelelõen kitöltötte és elküldte
                    // az adatait, a vásárlás vagy regisztrálás sikeres volt
                    $successAnswerPage = ConfigUtils::substConfigValue($successAnswerPage,
                        array("0" => urlencode($posId),
                              "1" => urlencode($tranzAzon),
                              "2" => urlencode($tranzAdatok->getAuthorizaciosKod()),
                        		"3" => urlencode($osszeg)));
                    if ($doRedirect) RequestUtils::includeOrRedirect($successAnswerPage);
                }
                else if ("VISSZAUTASITOTTFIZETES" == $responseCode) {
                    // Az ügyfél elutasította (visszavonta) a vásárlást a vevõ oldali felületen
                    $cancelledAnswerPage = ConfigUtils::substConfigValue($cancelledAnswerPage,
                        array("0" => urlencode($posId),
                              "1" => urlencode($tranzAzon)));
                    if ($doRedirect) RequestUtils::includeOrRedirect($cancelledAnswerPage);
                }
                else {
                    // Az ügyfél kitöltötte és elküldte az adatait,
                    // de a tranzakció sikertelen volt.
                    // Valószínûleg a kártya terhelés nem végezhetõ el
                    $failedAnswerPage = ConfigUtils::substConfigValue($failedAnswerPage,
                        array("0" => urlencode($posId),
                              "1" => urlencode($tranzAzon),
                              "2" => urlencode($responseCode)));
                    if ($doRedirect) RequestUtils::includeOrRedirect($failedAnswerPage);
                }
            }
            else {
                // Ha nem sikerült lekérdezni a választ...
                $unknownAnswerPage = ConfigUtils::substConfigValue($unknownAnswerPage,
                    array("0" => urlencode($posId),
                          "1" => urlencode($tranzAzon)));
                if ($doRedirect) RequestUtils::includeOrRedirect($unknownAnswerPage);
            }
        }
        else {
            // Ha nem sikerült lekérdezni a választ...
            $unknownAnswerPage = ConfigUtils::substConfigValue($unknownAnswerPage,
                array("0" => urlencode($posId),
                      "1" => urlencode($tranzAzon)));
            if ($doRedirect) RequestUtils::includeOrRedirect($failedAnswerPage);
        }
    }
    else {
        $unknownAnswerPage = ConfigUtils::substConfigValue($unknownAnswerPage,
            array("0" => urlencode($posId),
                  "1" => urlencode($tranzAzon)));
        if ($doRedirect) RequestUtils::includeOrRedirect($unknownAnswerPage);
    }
    
    return $tranzAdatok;
}

?>