<?php

/*

H�romszerepl�s fizet�si tranzakci� ind�t�sa illetve az eredm�ny
meggjelen�t�se PHP k�rnyezetb�l.

Az ind�t�st a process met�dus v�gzi, mely az OTP Internetes Fizet�si Fel�let
oldal�ra tov�bb�tja a kliens k�r�st, mik�zben elind�tja a
WebShopClient SOAP fel�let�n kereszt�l t�rt�n� tranzakci�t.

A vev� �t�r�ny�t�sa egy HTTP redirect header-t tartalmaz� v�lasz �ssze�ll�t�s�val
�s elk�ld�s�ve� t�rt�nik. A fizet�si tranzakci� banki fel�leten t�rt�n� ind�t�sa
ekkor kezd�dik. Vagyis nincs sz� igazi p�rhuzamoss�gr�l, csup�n arr�l, hogy
a vev� �ltal ind�tott HTTP k�r�s - b�r a kliens oldali b�ng�sz�t �t�r�ny�tja
a banki fel�letre - a val�s�gban j�val tov�bb dolgoz�dik fel, s majd akkor �r
v�get, mikor a bank feldolgozza a vev� oldali fel�leten megadott k�rtyaadatokkal
v�grehajtand� terhel�st.

Megjegyz�s: a BackUrl-t k�ld�sn�l dinamikusan �ll�tjuk �ssze �gy,
hogy erre a szervletre mutasson, �s tartalmazza a tranzakci� adatait (posId
�s tranzakci� id) valamint egy jelz�t, hogy a k�r�snek egy sikeroldalt kell
megjelen�tenie, �s nem fizet�si folyamatot ind�tania. E sikeroldal
megjelen�t�s�t a processDirectedToBackUrl v�gzi el.

A v�lasz feldolgoz�s�t a processDirectedToBackUrl met�dus v�gzi, amit - ahogy
a neve is mutatja - a backUrl-lel megc�mzett programk�dban c�lszer� megh�vni.
A processDirectedToBackUrl met�dus alap�rtelmezett m�k�d�se:
- Lek�rdezi a tranzakci� eredm�ny�t a tranzakcioStatuszLekerdezes szolg�ltat�s
h�v�ssal, �s kielemzi a lek�rdezett fizet�si tranzakci� adatait.
- Amennyiben a fizet�si tranzakci� sikeresen lefutott, a kliens oldal 
a "webshop_success_answerpage_url" param�terben megadott url-re fog ker�lni, 
mely url-be rendre az al�bbi �rt�kek fognak behelyettes�t�dni: posId, 
tranzakci� azonos�t�, authoriz�ci�s k�d.
- Amennyiben a fizet�si tranzakci� sikertelen�l futott le (k�rtyaterhel�si
hiba, id�t�ll�p�s vagy egy�b hiba miatt), akkor a "webshop_failed_answerpage_url" 
param�terben megadott url-re fog ker�lni a vez�rl�s, a posId, tranzakci� azonos�t� 
�s hibak�d behelyettes�t�d�se ut�n.
- Amennyiben a fizet�si tranzakci�t az �gyf�l elutas�totta sikertelen�l futott le, 
akkor a "webshop_cancelled_answerpage_url" param�terben megadott url-re fog ker�lni 
a vez�rl�s, a posId, tranzakci� azonos�t� behelyettes�t�d�se ut�n.
- Egy�b esetben (megszakadt kommunik�ci�, vagy a v�lasz feldolgoz�s
hib�t jelez) a webshop_unknown_answerpage_url param�terben megadott url-re 
fog ker�lni a vez�rl�s, a posId �s tranzakci� azonos�t� behelyettes�t�d�se ut�n.
A vez�rl�s�tad�s t�rt�nhet a PHP include utas�t�s�val vagy b�ng�sz� oldali
redirect�l�ssal.

A vonatkoz� param�terek a haromszereplosshop.conf f�jlban konfigur�lhat�ak.

A processDirectedToBackUrl met�dus megfelel� param�terez�se mellett a vez�rl�s�tad�s 
l�p�s kihagyhat�. Ilyenkor a met�dus visszat�r�si �rt�ke haszn�lhat�, mely a 
fizet�si tranzakci� v�lasz�t tartalmazza. Ugyancsak hozz�f�rhet� a fizet�si v�lasz
objektum akkor, ha a fenti url jelleg� param�ter lok�lis php k�dra t�rt�n�
hivatkoz�st tartalmaznak, amit a kontroller include-olhat.

A feldolgoz�s t�mogatja a k�tl�pcs�s fizet�si m�dot: ha param�terk�nt �tad�sra
ker�l a ketlepcsosFizetes jelz�, akkor annak logikai �rt�ke explicit m�don
�tad�sra ker�l a Bank fel� k�ld�tt k�r�sben.

A forr�sk�d demonstr�ci�s jelleg�, szabadon m�dos�that�.

@author Bodn�r Imre, IQSYS
@version 3.3.1

*/

define('SIMPLESHOP_CONFIGURATION', '../config/mak.conf');

if (!defined('WEBSHOP_LIB_DIR')) define('WEBSHOP_LIB_DIR', dirname(__FILE__) . '/../lib');

require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/WebShopService.php');
//require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/WebShopServiceSimulator.php');
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/RequestUtils.php');
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/ConfigUtils.php');

/**
* @desc H�romszerepl�s fizet�si tranzakci� ind�t�sa, a bank oldali
* kommunik�ci� lebonyol�t�s�val �s a vev� oldali (b�ng�sz�) fel�let
* megfelel� �tir�ny�t�s�val.
* 
* Automatikus redirekt�l�s / include-ol�s eset�n defini�l�sra ker�l� �rt�kek
* illetve global v�ltoz�k:
* "response" => WResponse t�pus� objektum, mely a fizet�si tranzakci�hoz
*               tartoz� �sszes v�laszadatot tartalmazza
* "tranzAdatok" => WebShopFizetesValasz t�pus� objektum, a 
*                  v�s�rl�shoz tartoz� v�laszobjektum (value object)
* 
* @return a fizet�si tranzakci� banki fel�let �ltal visszaadott �s 
* �rtelmezett �rt�ke, WResponse t�pus� objektum. 
*/
function process() {

    ob_start();

    $config = parse_ini_file(SIMPLESHOP_CONFIGURATION);
    $service = new WebShopService();

    // Param�terek �sszegy�jt�se a k�r�sb�l
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
    
    // �gyf�l �tir�ny�t�sa a vev� oldali fel�letre
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

    // BackURL manipl�ci�
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
    
    // Fizet�si tranzakci� elind�t�sa
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
        'Fizet�s: '.utf8_decode($_REQUEST['uzenet']),
        $backUrl,
        RequestUtils::safeParam($_REQUEST, "ketlepcsosFizetes"));   
        
    /*********
     Itt a helye a shop-specifikus eredm�ny feldolgoz�snak / t�rol�snak
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
 * A h�romszerepl�s fizet�s eredm�ny�nek megjelen�t�se a shop oldalon.
 * E megjelen�t�snek akkor van komoly szerepe, amikor a fizet�si tranzakci�ban a
 * <i>vevoVisszaigazolas</i> param�ter �rt�ke hamis volt. Ekkor ugyanis az
 * Internetes Fizet�si Fel�let "tov�bb�r�ny�tja" a v�laszoldal
 * megjelen�t�s�t a <i>backURL</i> �rt�kben �tadott oldalra. Sikeres �s
 * sikertelen tranzakci� eset�n egyar�nt ez az oldal jelenik meg, ez�rt van
 * sz�ks�g dinamikus (a fizet�s eredm�ny�t�l f�gg�) megjelen�t�sre.
 *
 * A met�dus lek�rdezi a fizet�si tranzakci� adat�t, �s annak megfelel�en
 * jelen�ti meg a hiba oldalt vagy az eredm�ny oldalt.
 * 
 * Az include-ol�s eset�n defini�l�sra ker�l� �rt�kek illetve global v�ltoz�k:
 * "tranzAdatok" => WebShopFizetesValasz t�pus� objektum, a 
 *                  v�s�rl�shoz tartoz� v�laszobjektum (value object)
 *
 * @param $doRedirect a fizet�si tranzakci� v�grehajt�sa ut�n v�gre kell-e
 * hajtani az eredm�nyoldalakra t�rt�n� redirect / include l�p�seket a
 * haromszereplosshop.conf (vagy a 'SIMPLESHOP_CONFIGURATION'-ban megadott)
 * �llom�nyban le�rt url-ek alapj�n. [Alap�rtelmezett �rt�k: true]
 * 
 * @return WebShopFizetesAdatok a fizet�si tranzakci� input- �s eredm�ny adatait
 *         tartalmaz� value object. NULL, ha sikertelen volt a tranzakci� 
 *         adatainak lek�rdez�se
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

        // Lek�rdezz�k a fizet�si tranzakci� adatait.
        // A lek�rdezett tranzakci�ra defini�lunk egy id�intervallumot is:
        // [aktu�lis id�pont - 24 �ra ; aktu�lis id�pont + 24 �ra]
        $service = new WebShopService();
        $response = $service->tranzakcioStatuszLekerdezes($posId, $tranzAzon, 1, time() - 60*60*24, time() + 60*60*24);

        if ($response) {

            $answer = $response->getAnswer();
            if ($response->isSuccessful()
                    && $response->getAnswer()
                    && count($answer->getWebShopFizetesAdatok()) > 0) {

                // Siker�lt lek�rdezni az adott tranzakci� adat�t
                $fizetesAdatok = $answer->getWebShopFizetesAdatok();
                $tranzAdatok = current($fizetesAdatok);
                $_REQUEST['tranzAdatok'] = $tranzAdatok;

                syslog(LOG_NOTICE, "Fizetes tranzakcio adat lekerdezes befejezve: " . $posId . " - " . $tranzAzon );

                $responseCode = $tranzAdatok->getPosValaszkod();

                $successPosResponseCodes = array(
                    "000", "00", "001", "002", "003", "004",
                    "005", "006", "007", "008", "009", "010");

                if ($tranzAdatok->isSuccessful()) {
                    // Az �gyf�l megfelel�en kit�lt�tte �s elk�ldte
                    // az adatait, a v�s�rl�s vagy regisztr�l�s sikeres volt
                    $successAnswerPage = ConfigUtils::substConfigValue($successAnswerPage,
                        array("0" => urlencode($posId),
                              "1" => urlencode($tranzAzon),
                              "2" => urlencode($tranzAdatok->getAuthorizaciosKod()),
                        		"3" => urlencode($osszeg)));
                    if ($doRedirect) RequestUtils::includeOrRedirect($successAnswerPage);
                }
                else if ("VISSZAUTASITOTTFIZETES" == $responseCode) {
                    // Az �gyf�l elutas�totta (visszavonta) a v�s�rl�st a vev� oldali fel�leten
                    $cancelledAnswerPage = ConfigUtils::substConfigValue($cancelledAnswerPage,
                        array("0" => urlencode($posId),
                              "1" => urlencode($tranzAzon)));
                    if ($doRedirect) RequestUtils::includeOrRedirect($cancelledAnswerPage);
                }
                else {
                    // Az �gyf�l kit�lt�tte �s elk�ldte az adatait,
                    // de a tranzakci� sikertelen volt.
                    // Val�sz�n�leg a k�rtya terhel�s nem v�gezhet� el
                    $failedAnswerPage = ConfigUtils::substConfigValue($failedAnswerPage,
                        array("0" => urlencode($posId),
                              "1" => urlencode($tranzAzon),
                              "2" => urlencode($responseCode)));
                    if ($doRedirect) RequestUtils::includeOrRedirect($failedAnswerPage);
                }
            }
            else {
                // Ha nem siker�lt lek�rdezni a v�laszt...
                $unknownAnswerPage = ConfigUtils::substConfigValue($unknownAnswerPage,
                    array("0" => urlencode($posId),
                          "1" => urlencode($tranzAzon)));
                if ($doRedirect) RequestUtils::includeOrRedirect($unknownAnswerPage);
            }
        }
        else {
            // Ha nem siker�lt lek�rdezni a v�laszt...
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