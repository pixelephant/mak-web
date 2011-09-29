<?php

/*

K�tl�pcs�s fizet�si tranzakci� lez�r�s�nak ind�t�sa PHP k�rnyezetb�l.
A v�grehajt�st a process met�dus v�gzi, mely a banki SOAP fel�let k�zvetlen
megh�v�s�val elind�tja a a fizet�s lez�r�si tranzakci�t. A kliens oldali b�ng�sz�
mindaddig az oldal let�lt�s�re fog v�rakozni, m�g a tranzakci� be nem
fejez�d�tt - a v�rakok�zi id� jellemz�en 1-2 m�sodperc.

Az ind�t�st k�vet�en a process met�dus alap�rtelmezett m�k�d�se:
- Amennyiben a tranzakci� sikeresen lefutott, �s a v�lasz feldolgoz�sa
sem jelez hib�t, a kliens oldal a "webshop_success_answerpage_url"
param�terben megadott url-re fog ker�lni, mely url-be rendre az al�bbi
�rt�kek fognak behelyettes�t�dni: posId, tranzakci� azonos�t�, authoriz�ci�s
k�d.
- Amennyiben a tranzakci� sikertelen�l futott le, akkor a
"webshop_failed_answerpage_url" param�terben megadott url-re fog ker�lni
a vez�rl�s, a posId, tranzakci� azonos�t� �s hibak�d behelyettes�t�d�se ut�n.
- Egy�b esetben (megszakadt kommunik�ci�, vagy a v�lasz feldolgoz�s
hib�t jelez) a webshop_unknown_answerpage_url param�terben megadott url-re
fog ker�lni a vez�rl�s, a posId �s tranzakci� azonos�t� behelyettes�t�d�se ut�n.
A vez�rl�s�tad�s t�rt�nhet a PHP include utas�t�s�val vagy b�ng�sz� oldali
redirect�l�ssal.

A vonatkoz� param�terek a ketlepcsoslezaras.conf konfigur�lhat�ak.

A process met�dus megfelel� param�terez�se mellett a vez�rl�s�tad�s l�p�s
kihagyhat�. Ilyenkor a met�dus visszat�r�si �rt�ke haszn�lhat�, mely a
Banki fel�let teljes v�lasz�t tartalmazza.

Ne feledj�k, hogy a lez�r�s m�velete nem k�t�dik a vev�h�z,
hiszen tiszt�n bolti / adminisztrat�v jelleg� tev�kenys�gr�l van sz�.

A forr�sk�d demonstr�ci�s jelleg�, szabadon m�dos�that�.

@author Bodn�r Imre, IQSYS
@version 3.3

*/

define('SIMPLESHOP_CONFIGURATION', '../config/ketlepcsoslezaras.conf');

if (!defined('WEBSHOP_LIB_DIR')) define('WEBSHOP_LIB_DIR', dirname(__FILE__) . '/../lib');

require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/WebShopService.php');
//require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/WebShopServiceSimulator.php');
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/ConfigUtils.php');

/**
* @desc K�tl�pcs�s fizet�s lez�r�si tranzakci� ind�t�sa, a bank oldali
* kommunik�ci� lebonyol�t�s�val �s a bolt oldali (b�ng�sz�) fel�let
* megfelel� �tir�ny�t�s�val. Ne feledj�k, hogy ez a m�velet nem k�t�dik
* a vev�h�z, hiszen tiszt�n bolti / adminisztrat�v jelleg� tev�kenys�gr�l
* van sz�.
*
* Automatikus redirekt�l�s / include-ol�s eset�n defini�l�sra ker�l� �rt�kek
* illetve global v�ltoz�k:
* "response" => WResponse t�pus� objektum, mely a fizet�si tranzakci�hoz
*               tartoz� �sszes v�laszadatot tartalmazza
* "tranzAdatok" => WebShopFizetesValasz t�pus� objektum, a sikeres
*                  v�s�rl�shoz tartoz� v�laszobjektum (value object)
*
* @param $doRedirect a fizet�si tranzakci� v�grehajt�sa ut�n v�gre kell-e
* hajtani az eredm�nyoldalakra t�rt�n� redirect / include l�p�seket a
* ketszereplosshop.conf (vagy a 'SIMPLESHOP_CONFIGURATION'-ban megadott)
* �llom�nyban le�rt url-ek alapj�n. [Alap�rtelmezett �rt�k: true]
*
* @return a fizet�si tranzakci� banki fel�let �ltal visszaadott �s
* �rtelmezett �rt�ke, WResponse t�pus� objektum.
*/
function process($doRedirect = true) {

    global $response;

    $service = new WebShopService();

    $posId = RequestUtils::safeParam($_REQUEST, "posId");
    $tranzAzon = RequestUtils::safeParam($_REQUEST, "tranzakcioAzonosito");

    global $response;
    if (!is_null($tranzAzon) && (trim($tranzAzon) != "")) {

        // Fizet�si tranzakci� lez�r�s ind�t�sa
        syslog(LOG_NOTICE, "Ketlepcsos fizetes lezaras kuldes: " . $posId . " - " . $tranzAzon);

        $response = $service->fizetesiTranzakcioLezaras(
            $posId,
            $tranzAzon,
            RequestUtils::safeParam($_REQUEST, "jovahagyo"));

        /*********
         Itt a helye a shop-specifikus eredm�ny feldolgoz�snak / t�rol�snak
         ********/
    }
    else {
        /* Sikertelen volt a tranzakci� azonos�t�s */
    }

    if ($response) {
        global $tranzAdatok;
        $tranzAdatok = $response->getAnswer();
        syslog(LOG_NOTICE, "Ketlepcsos fizetes lezara keres kuldes: " . $posId . " - " . $tranzAzon . " - " . implode($response->getMessages()));
    }
    else {
        syslog(LOG_ERR, "Ketlepcsos fizetes lezara keres kuldes: " . $posId . " - " . $tranzAzon . " - NEM ERTELMEZHETO VALASZ!");
    }

    if ($doRedirect) processRedirect($posId, $tranzAzon, $response);

    return $response;
}

/**
 * @desc A k�tl�pcs�s fizet�s lez�r�s eredm�ny�nek megjelen�t�se a shop oldalon
 * a ketlepcsoslezaras.conf (vagy a 'SIMPLESHOP_CONFIGURATION'-ban megadott)
 * �llom�nyban le�rt url-ek alapj�n.
 *
 * A met�dus a lez�r�si tranzakci� v�lasz�nak megfelel�en
 * jelen�t meg egy hiba oldalt vagy eredm�ny oldalt.
 *
 * A $_REQUEST-be ker�l� �rt�kek:
 * "response" => WResponse t�pus� objektum, mely a fizet�si tranzakci�
 *               lez�r�s�hoz tartoz� banki v�laszadatot reprezent�lja
 * "tranzAdatok" => WebShopFizetesValasz t�pus� objektum, a sikeres
 *                  v�s�rl�shoz tartoz� v�laszobjektum (value object)
 */
function processRedirect($posId, $tranzAzon, $response) {

    $config = parse_ini_file(SIMPLESHOP_CONFIGURATION);

    $successAnswerPage =
        ConfigUtils::getConfigParam($config, 'webshop_success_answerpage_url', $posId);
    $failedAnswerPage =
        ConfigUtils::getConfigParam($config, 'webshop_failed_answerpage_url', $posId);
    $unknownAnswerPage =
        ConfigUtils::getConfigParam($config, 'webshop_unknown_answerpage_url', $posId);

    $_REQUEST['response'] = $response;

    if ($response) {
        global $tranzAdatok;
        $tranzAdatok = $response->getAnswer();
        $_REQUEST['tranzAdatok'] = $tranzAdatok;

        if ($response->isSuccessful()
                && $response->getAnswer()) {
            // Siker�lt a lez�r�s ind�t�s
            $responseCode = $tranzAdatok->getValaszkod();

            $successPosResponseCodes = array(
                "000", "00", "001", "002", "003", "004",
                "005", "006", "007", "008", "009", "010");

            if (in_array($responseCode, $successPosResponseCodes)) {
                // A lez�r�s sikeres volt
                $successAnswerPage = ConfigUtils::substConfigValue($successAnswerPage,
                    array("0" => urlencode($posId),
                          "1" => urlencode($tranzAzon),
                          "2" => urlencode($tranzAdatok->getAuthorizaciosKod())));
                RequestUtils::includeOrRedirect($successAnswerPage);
            }
            else {
                // A lez�r�s sikertelen volt.
                $failedAnswerPage = ConfigUtils::substConfigValue($failedAnswerPage,
                    array("0" => urlencode($posId),
                          "1" => urlencode($tranzAzon),
                          "2" => urlencode($responseCode)));
                RequestUtils::includeOrRedirect($failedAnswerPage);
            }
        }
        else {
            // A lez�r�s sikertelen volt.
            $failedAnswerPage = ConfigUtils::substConfigValue($failedAnswerPage,
                array("0" => urlencode($posId),
                      "1" => urlencode($tranzAzon),
                      "2" => urlencode(implode(',', $response->getMessages()))));
            RequestUtils::includeOrRedirect($failedAnswerPage);
        }
    }
    else {
        // Ha nem siker�lt elind�tani a folyamatot vagy �rtelmezni a v�laszt...
        $unknownAnswerPage = ConfigUtils::substConfigValue($unknownAnswerPage,
            array("0" => urlencode($posId),
                  "1" => urlencode($tranzAzon)));
        RequestUtils::includeOrRedirect($unknownAnswerPage);
    }
}

?>