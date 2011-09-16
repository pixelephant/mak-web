<?php

define('WEBSHOP_LIB_VER', '3.3.1RC1');

if (!defined('WEBSHOP_LIB_DIR')) define('WEBSHOP_LIB_DIR', dirname(__FILE__) . '/../..');

if (!defined('WEBSHOP_CONF_DIR')) define('WEBSHOP_CONF_DIR', dirname(__FILE__) . '/../../../config');
define('WEBSHOPSERVICE_CONFIGURATION', WEBSHOP_CONF_DIR . '/otp_webshop_client.conf');

define('LOG4PHP_DIR', WEBSHOP_LIB_DIR . '/apache/log4php');
define('LOG4PHP_CONFIGURATION', WEBSHOPSERVICE_CONFIGURATION);

$phpversion = phpversion();
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/factory/WResponse.php');
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/RequestUtils.php');
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/WebShopXmlUtils.php' . $phpversion{0});
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/SignatureUtils.php' . $phpversion{0});
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/SoapUtils.php' . $phpversion{0});
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/TransactionLogger.php');
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/DefineConst.php');
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/ConfigUtils.php');

require_once(LOG4PHP_DIR . '/LoggerManager.php');

/**
 * WebShop szolgáltatások meghívása a Bank SOAP felületének közvetlen elérésével.
 *
 * A WebShop-ok részére készített PHP eljárás gyûjtemény. 
 * 
 * A web-alkalmazást lokákisal, WebShop-onként kell telepíteni.Ezek az
 * alkalmazások hívják meg az OTP middleware rendszerének megfelelö WebShop
 * folyamatait: 
 * - ping 
 * - tranzakció azonosító generálás 
 * - háromszereplös fizetési folyamat indítása 
 * - kétszereplös fizetési folyamat indítása 
 * - tranzakció adatok, tranzakció státusz lekérdezése
 * - kétlépcsõs fizetési tranzakció lezárása
 *
 * A fenti szolgáltatások közvetlen módon, az úgynevezett OTP MWAccess felületen
 * is meghívhatóak, de ott lényegesen összetettebb feladat hárul a WebShop
 * kliens oldali fejéesztökre. A kliens oldali WebShop szerver az alábbi
 * funkciók végrehajtásával könnyíti a fejlsztést: - nem kell folyamatokat
 * indító xml-eket összellítani és nem kell válasz xml- eket értelmezni.
 * Egyszerüen mezöszinten kell megadni a bemenö adatokat, és ugyancsak
 * mezöszinten érhetöek eé a válasz adatai. - az alkalmazás automatikusan
 * legenerálja a digitális aláírást azoknál a müveleteknél, ahol ez szükséges. -
 * automatikusan naplózásra kerülnek a kommunikáció elemei: a kapcsolódási
 * paraméterek, a bejövö és kimenö SOAP kérések, a folyamat input- és answer
 * xml- jei. A naplózás részletessége konfigurálható.
 *
 * @version 3.3.1
 * @author Bodnár Imre / IQSYS
 */
class WebShopService {

    /**
    * Log4php naplózó objektum.
    * 
    * @var mixed
    */
    var $logger;
    
    /**
    * Az otp_webshop_client.conf konfigurációs fájl tartalma.
    * 
    * @var array
    */
    var $property;

    /**
    * A bankkal kommunikáló SOAP kliens.
    * 
    * $var mixed
    */
    var $soapClient;
    
    /**
    * Az utoljára indított banki tranzakcióhoz tartozó inputXml szöveges tartalma
    * 
    * @var string
    */
    var $lastInputXml = NULL;

    /**
    * Az utoljára indított banki tranzakcióhoz tartozó outputXml szöveges tartalma
    * 
    * @var string
    */
    var $lastOutputXml = NULL;

    /**
    * A banki tranzakciókhoz tartozó "beszédes nevek", mellyekkel naplózásra kerülnek
    * 
    * @var array
    */
    var $operationLogNames = array(
        "tranzakcioAzonositoGeneralas" => "tranzakcioAzonositoGeneralas",
        "fizetesiTranzakcioKetszereplos" => "fizetesiTranzakcioKetszereplos",
        "fizetesiTranzakcio" => "fizetesiTranzakcio",
        "tranzakcioStatuszLekerdezes" => "tranzakcioStatuszLekerdezes",
        "ketlepcsosFizetesLezaras" => "ketlepcsosFizetesLezaras",
    );
        
    /**
    * Konstruktor.
    * 
    * - inicializálódik a log4php
    * - beolvasásra került a konfigurációs állomány
    * - példányosodik a SOAP kliens
    */
    function WebShopService() {
        $this->logger =& LoggerManager::getLogger("WebShopClient");
        $this->logger->debug("OTPWebShopService (PHP) példányosítás...");
        
        $this->property = parse_ini_file(WEBSHOPSERVICE_CONFIGURATION);

        $this->logger->debug("OTPMW szerver url: " . ConfigUtils::getConfigParam($this->property, PROPERTY_OTPMWSERVERURL));

        if (ConfigUtils::getConfigParam($this->property, PROPERTY_HTTPSPROXYHOST)) {
            $this->logger->debug("Kliens https proxy host: " . ConfigUtils::getConfigParam($this->property, PROPERTY_HTTPSPROXYHOST));
        }
        if (ConfigUtils::getConfigParam($this->property, PROPERTY_HTTPSPROXYPORT)) {
            $this->logger->debug("Kliens https proxy port: " . ConfigUtils::getConfigParam($this->property, PROPERTY_HTTPSPROXYPORT));
        }
        if (ConfigUtils::getConfigParam($this->property, PROPERTY_HTTPSPROXYUSER)) {
            $this->logger->debug("Kliens https proxy user: " . ConfigUtils::getConfigParam($this->property, PROPERTY_HTTPSPROXYUSER));
        }
        if (ConfigUtils::getConfigParam($this->property, PROPERTY_HTTPSPROXYPASSWORD)) {
            $this->logger->debug("Kliens https proxy password: " . "******");
        }
        
        $this->soapClient = SoapUtils::createSoapClient($this->property);
    }
    
    /**
     * Egy adott fizetési tranzakcióhoz tartozó privát kulcs állomány elérési
     * útvonalának beállítása a konfigurációs paraméterek alapján. Ha adott
     * posId (bolt azonosító) esetén a konfigurációs állomány tartalmaz
     * otp.webshop.PRIVATE_KEY_posId=[elérési út] bejegyzést, akkor az eljárás
     * ezt a bejegyzést adja válaszul. Egyébként a
     * otp.webshop.PRIVATE_KEY_FILE=[elérési út] bejegyzésben szereplõt. Az elsõ
     * módszerrel lehet multishop-ot kialakítani, vagyis olyan WebShop boolt
     * oldali szervert, amely több bolt kérését is ki tudja szolgálni, és
     * boltonként (szükségszerûen) eltérõ privát kulcs alapján történik a
     * digitális aláírás.
     *
     * @param properties
     *            A shop-hoz tartozó konfigurációs beállítások (array)
     * @param posId
     *            A tranzakciót indító shop azonosítója
     * @return A megadott shop-hoz tartozó privát kulcs elérési útvonala
     */
    function getPrivKeyFileName($properties, $posId) {
        $privKeyFileName = ConfigUtils::getConfigParam($properties, PROPERTY_PRIVATEKEYFILE, $posId);
        if (!file_exists($privKeyFileName)) {
            $this->logger->fatal("A privát kulcs fájl nem található: " . $privKeyFileName);
        }
        return $privKeyFileName;
    }
    
    /**
     * Egy adott fizetési tranzakcióhoz tartozó tranzakciós napló állomány
     * elérési útvonalainak beállítása a konfigurációs paraméterek alapján. Ha
     * adott posId (bolt azonosító) esetén a konfigurációs állomány tartalmaz
     * otp.webshop.TRANSACTION_LOG_DIR_posId=[elérési út] bejegyzést, akkor az
     * eljárás ezt a bejegyzést adja válaszul. Egyébként a
     * otp.webshop.otp.webshop.TRANSACTION_LOG_DIR=[elérési út] bejegyzésben
     * szereplõt elérési útvonalat. Az elsõ módszerrel lehet multishop-ot
     * kialakítani, vagyis olyan WebShop bolt oldali szervert, amely több bolt
     * kérését is ki tudja szolgálni, és boltonként más könyvtárba történik a
     * tranzakciók naplózása.
     * Ugyanez a képzési szabály igaz a otp.webshop.transaction_log_dir.SUCCESS_DIR
     * és otp.webshop.transaction_log_dir.FAILED_DIR paraméterekre is.
     *
     * @param properties
     *            A shop-hoz tartozó konfigurációs beállítások
     * @param posId
     *            A tranzakciót indító shop azonosítója
     * @return A megadott shop-hoz tartozó tranzakciós napló állományok
     *         könyvtárainak elérési útvonala: az alapértelmezett könyvtár,
     *         a sikeres illetve sikertelen tranzakciók könyvtára
     */
    function getTranLogDir($properties, $posId) {
        $tranLogDir = ConfigUtils::getConfigParam($properties, PROPERTY_TRANSACTIONLOGDIR, $posId);
        $tranLogSuccessDir = ConfigUtils::getConfigParam($properties, PROPERTY_TRANSACTIONLOG_SUCCESS_DIR, $posId);
        $tranLogFailedDir = ConfigUtils::getConfigParam($properties, PROPERTY_TRANSACTIONLOG_FAILED_DIR, $posId);
        return array ($tranLogDir, $tranLogSuccessDir, $tranLogFailedDir);
    }

    /**
     * @desc A banki felület Ping szolgáltatásának meghívása. 
     * Mivel tranzakció indítás nem történik, a sikeres ping
     * esetén sem garantált az, hogy az egyes fizetési tranzakciók
     * sikeresen el is indíthatók -  csupán az biztos, hogy a
     * hálózati architektúrán keresztül sikeresen elérhetõ a
     * banki felület. 
     * 
     * Digitális aláírás nem képzödik.
     * 
     * @return boolean true sikeres ping-etés esetén, egyébként false.
     */
    function ping() {
        $this->logger->debug("ping indul...");
        $result = SoapUtils::ping($this->soapClient, $this->logger);
        $this->logger->debug("ping befejezödött.");
        return $result;
    }
    
    /**
     * WEBSHOPTRANZAZONGENERALAS folyamat szinkron indítása. 
     * 
     * @param string $posId 
     *        webshop azonosító
     * 
     * @return WResponse a tranzakció válaszát reprezentáló value object.
     *         Sikeres végrehajtás esetén a válasz adatokat WebShopTranzAzon
     *         objektum reprezentálja.
     *         Kommunikációs hiba esetén a finished flag false értékû lesz!
     */
    function tranzakcioAzonositoGeneralas($posId) {
        $this->logger->debug($this->operationLogNames["tranzakcioAzonositoGeneralas"] . " indul...");
        
        $dom = WebShopXmlUtils::getRequestSkeleton(WF_TRANZAZONGENERALAS, $variables);
        WebShopXmlUtils::addParameter($dom, $variables, CLIENTCODE, CLIENTCODE_VALUE);
        WebShopXmlUtils::addParameter($dom, $variables, POSID, $posId);
        
        $signatureFields = array(0 => $posId);
        $signatureText = SignatureUtils::getSignatureText($signatureFields);

        $pkcs8PrivateKey = SignatureUtils::loadPrivateKey($this->getPrivKeyFileName($this->property, $posId));
        $signature = SignatureUtils::generateSignature($signatureText, $pkcs8PrivateKey, $this->property, $this->logger);

        WebShopXmlUtils::addParameter($dom, $variables, CLIENTSIGNATURE, $signature);
        
        $this->lastInputXml = WebShopXmlUtils::xmlToString($dom);
        $this->logger->debug($this->operationLogNames["tranzakcioAzonositoGeneralas"] . " keres:\n" . WebShopXmlUtils::xmlToString($dom));     
                
        $workflowState = SoapUtils::startWorkflowSynch(WF_TRANZAZONGENERALAS, $this->lastInputXml, $this->soapClient, $this->logger);
        $response = new WResponse(WF_TRANZAZONGENERALAS, $workflowState);

	    $this->logger->info($this->operationLogNames["tranzakcioAzonositoGeneralas"] . " folyamat azonosito: " 
	        . $response->getInstanceId());

	    // a folyamat válaszának naplózása
	    if ($response->isFinished()) {
	        $responseDom = $response->getResponseDOM(); 
            $this->lastOutputXml = WebShopXmlUtils::xmlToString($responseDom);                  
            $this->logger->debug($this->operationLogNames["tranzakcioAzonositoGeneralas"] . " valasz:\n" 
	            . trim($this->lastOutputXml));
	    }
	    else {
	        $this->logger->error($this->operationLogNames["tranzakcioAzonositoGeneralas"] . " hiba!");
            $this->logger->error($workflowState);      
	    }

	    $this->logger->debug($this->operationLogNames["tranzakcioAzonositoGeneralas"] . " befejezodott.");

        return $response;
    }

    /**
     * Háromszereplõs fizetési folyamat (WEBSHOPFIZETES) szinkron indítása.
     *
     * @param string $posId 
     *        webshop azonosító
     * @param string $tranzakcioAzonosito 
     *        fizetési tranzakció azonosító
     * @param mixed $osszeg 
     *        Fizetendö összeg, (num, max. 13+2), opcionális tizedesponttal.
     *        Nulla is lehet, ha a regisztraltUgyfelId paraméter ki van
     *        töltve, és az ugyfelRegisztracioKell értéke igaz. Így kell
     *        ugyanis jelezni azt, hogy nem tényleges vásárlási tranzakciót
     *        kell indítani, hanem egy ügyfél regisztrálást, vagyis az
     *        ügyfél kártyaadatainak bekérést és eltárolását a banki
     *        oldalon.
     * @param string $devizanem 
     *            fizetendö devizanem
     * @param string $nyelvkod 
     *            a megjelenítendö vevö oldali felület nyelve
     * @param mixed $nevKell
     *            a megjelenítendö vevö oldali felületen be kell kérni a vevö
     *            nevét
     * @param mixed $orszagKell
     *            a megjelenítendö vevö oldali felületen be kell kérni a vevö
     *            címének "ország részét"
     * @param mixed $megyeKell
     *            a megjelenítendö vevö oldali felületen be kell kérni a vevö
     *            címének "megye részét"
     * @param mixed $telepulesKell
     *            a megjelenítendö vevö oldali felületen be kell kérni a vevö
     *            címének "település részét"
     * @param mixed $iranyitoszamKell
     *            a megjelenítendö vevö oldali felületen be kell kérni a vevö
     *            címének "irányítószám részét"
     * @param mixed $utcaHazszamKell
     *            a megjelenítendö vevö oldali felületen be kell kérni a vevö
     *            címének "utca/házszám részét"
     * @param mixed $mailCimKell
     *            a megjelenítendö vevö oldali felületen be kellûkérni a vevö
     *            e-mail címét
     * @param mixed $kozlemenyKell
     *            a megjelenítendö vevö oldali felületen fel kell kínálni a
     *            közlemény megadásának lehetöségét
     * @param mixed $vevoVisszaigazolasKell
     *            a tranzakció eredményét a vevö oldalon meg kell jeleníteni
     *            (azaz nem a backURL-re kell irányítani)
     * @param mixed $ugyfelRegisztracioKell
     *            ha a regisztraltUgyfelId értéke nem üres, akkor megadja, hogy
     *            a megadott azonosító újonnan regisztrálandó-e, vagy már
     *            regisztrálásra került az OTP Internetes Fizetõ felületén.
     *            Elõbbi esetben a kliens oldali böngészõben olyan fizetõ oldal
     *            fog megjelenni, melyen meg kell adni az azonosítóhoz tartozó
     *            jelszót, illetve a kártyaadatokat. Utóbbi esetben csak az
     *            azonosítóhoz tartozó jelszó kerül beolvasásra az értesítési
     *            címen kívül. Ha a regisztraltUgyfelId értéke üres, a pamaréter
     *            értéke nem kerül felhasználásra.
     * @param string $regisztraltUgyfelId
     *            az OTP fizetõfelületen regisztrálandó vagy regisztrált ügyfél
     *            azonosító kódja.
     * @param string $shopMegjegyzes
     *            a webshop megjegyzése a tranzakcióhoz a vevö részére
     * @param string $backURL
     *            a tranzakció végrehajtása után erre az internet címre kell
     *            irányítani a vevö oldalon az ügyfelet (ha a
     *            vevoVisszaigazolasKell hamis)
     * @param mixed $ketlepcsosFizetes
     * 			  megadja, hogy kétlépcsõs fizetés indítandó-e.
     *            True érték esetén a fizetési tranzakció kétlépcsõs lesz, 
     *            azaz a terhelendõ összeg csupán zárolásra kerül, 
     *            s úgy is marad a bolt által indított lezáró tranzakció 
     *            indításáig avagy a zárolás elévüléséig.
     *            Az alapértelmezett (üres) érték a Bank oldalon rögzített 
     *            alapértelmezett módot jelöli.       
     *
     * @return WResponse a tranzakció válaszát reprezentáló value object.
     *         Sikeres végrehajtás esetén a válasz adatokat WebShopFizetesAdatok
     *         objektum reprezentálja.
     *         Kommunikációs hiba esetén a finished flag false értékû lesz!
     */
    function fizetesiTranzakcio(
            $posId,
            $azonosito, 
            $osszeg, 
            $devizanem, 
            $nyelvkod,
            $nevKell, 
            $orszagKell, 
            $megyeKell,
            $telepulesKell, 
            $iranyitoszamKell,
            $utcaHazszamKell, 
            $mailCimKell,
            $kozlemenyKell, 
            $vevoVisszaigazolasKell,
            $ugyfelRegisztracioKell, 
            $regisztraltUgyfelId,
            $shopMegjegyzes, 
            $backURL,
            $ketlepcsosFizetes = NULL) {

        $this->logger->debug($this->operationLogNames["fizetesiTranzakcio"] . " indul...");

        $dom = WebShopXmlUtils::getRequestSkeleton(WF_HAROMSZEREPLOSFIZETES, $variables);

        // default értékek feldolgozása
        if (is_null($devizanem) || (trim($devizanem) == "")) {
            $devizanem = DEFAULT_DEVIZANEM;
        }

        /* paraméterek beillesztése */
        WebShopXmlUtils::addParameter($dom, $variables, CLIENTCODE, CLIENTCODE_VALUE);
        WebShopXmlUtils::addParameter($dom, $variables, POSID, $posId);
        WebShopXmlUtils::addParameter($dom, $variables, TRANSACTIONID, $azonosito);
        WebShopXmlUtils::addParameter($dom, $variables, AMOUNT, $osszeg);
        WebShopXmlUtils::addParameter($dom, $variables, EXCHANGE, $devizanem);
        WebShopXmlUtils::addParameter($dom, $variables, LANGUAGECODE, $nyelvkod);

        WebShopXmlUtils::addParameter($dom, $variables, NAMENEEDED, RequestUtils::booleanToString($nevKell));
        WebShopXmlUtils::addParameter($dom, $variables, COUNTRYNEEDED, RequestUtils::booleanToString($orszagKell));
        WebShopXmlUtils::addParameter($dom, $variables, COUNTYNEEDED, RequestUtils::booleanToString($megyeKell));
        WebShopXmlUtils::addParameter($dom, $variables, SETTLEMENTNEEDED, RequestUtils::booleanToString($telepulesKell));
        WebShopXmlUtils::addParameter($dom, $variables, ZIPCODENEEDED, RequestUtils::booleanToString($iranyitoszamKell));
        WebShopXmlUtils::addParameter($dom, $variables, STREETNEEDED, RequestUtils::booleanToString($utcaHazszamKell));
        WebShopXmlUtils::addParameter($dom, $variables, MAILADDRESSNEEDED, RequestUtils::booleanToString($mailCimKell));
        WebShopXmlUtils::addParameter($dom, $variables, NARRATIONNEEDED, RequestUtils::booleanToString($kozlemenyKell));
        WebShopXmlUtils::addParameter($dom, $variables, CONSUMERRECEIPTNEEDED, RequestUtils::booleanToString($vevoVisszaigazolasKell));

        WebShopXmlUtils::addParameter($dom, $variables, BACKURL, $backURL);

        WebShopXmlUtils::addParameter($dom, $variables, SHOPCOMMENT, $shopMegjegyzes);

        WebShopXmlUtils::addParameter($dom, $variables, CONSUMERREGISTRATIONNEEDED, $ugyfelRegisztracioKell);
        WebShopXmlUtils::addParameter($dom, $variables, CONSUMERREGISTRATIONID, $regisztraltUgyfelId);

        WebShopXmlUtils::addParameter($dom, $variables, TWOSTAGED, RequestUtils::booleanToString($ketlepcsosFizetes, NULL));

        /* aláírás kiszámítása és paraméterként beszúrása */
        $signatureFields = array(0 => 
            $posId, $azonosito, $osszeg, $devizanem, $regisztraltUgyfelId);
        $signatureText = SignatureUtils::getSignatureText($signatureFields);

        $pkcs8PrivateKey = SignatureUtils::loadPrivateKey($this->getPrivKeyFileName($this->property, $posId));
        $signature = SignatureUtils::generateSignature($signatureText, $pkcs8PrivateKey, $this->property, $this->logger);

        WebShopXmlUtils::addParameter($dom, $variables, CLIENTSIGNATURE, $signature);

        $this->lastInputXml = WebShopXmlUtils::xmlToString($dom);
        $this->logger->info($this->operationLogNames["fizetesiTranzakcio"] . " keres: " . $posId . " / " . $azonosito);
        $this->logger->debug($this->operationLogNames["fizetesiTranzakcio"] . " keres:\n" . $this->lastInputXml);

        /* Tranzakció adatainak naplózása egy külön fájlba */
        $transLogger = new TransactionLogger(
                    $this->getTranLogDir($this->property, $posId), $this->logger);

        $transLogger->logHaromszereplosFizetesInditas($posId, $azonosito, 
                $osszeg, $devizanem, $nyelvkod, $nevKell, $orszagKell,
                $megyeKell, $telepulesKell, $iranyitoszamKell,
                $utcaHazszamKell, $mailCimKell, $kozlemenyKell,
                $vevoVisszaigazolasKell, $ugyfelRegisztracioKell,
                $regisztraltUgyfelId, $shopMegjegyzes, $backURL,
                $ketlepcsosFizetes);
        
        /* A tranzakció indítása */
        $startTime = time();
        $workflowState = SoapUtils::startWorkflowSynch(WF_HAROMSZEREPLOSFIZETES, $this->lastInputXml, $this->soapClient, $this->logger);
        
        if (!is_null($workflowState)) {
            $response = new WResponse(WF_HAROMSZEREPLOSFIZETES, $workflowState);
        }
        else {
            $this->logger->warn($this->operationLogNames["fizetesiTranzakcio"] . " folyamat megszakadt: " 
                . $azonosito . ", pollozás indul..."); 
            // A tranzakció megszakadt, a banki felület válaszát nem
            // tudta a kliens fogadni
            $poll = true;
            $resendDelay = 20;
            do {
                $tranzAdatok = $this->tranzakcioPoll($posId, $azonosito, $startTime);
                if ($tranzAdatok === false) {
                    // nem sikerült a lekérdezés, újrapróbálkozunk
                    $poll = true;
                    $this->logger->error($this->operationLogNames["fizetesiTranzakcio"] . " poll hiba, azonosito: " . $azonosito);
                }
                else {
                    if ($tranzAdatok->isFizetesFeldolgozasAlatt()) {
                        // a tranzakció feldolgozás alatt van
                        // mindenképp érdemes kicsit várni, és újra pollozni
                    }
                    else {
                        // a tranzakció feldolgozása befejezõdött 
                        // (lehet sikeres vagy sikertelen az eredmény)
                        $poll = false;
                        $response = new WResponse(WF_HAROMSZEREPLOSFIZETES, null);
                        $this->logger->info($this->operationLogNames["fizetesiTranzakcio"] . " poll befejezve: " 
                            . $azonosito); 
                        // a folyamat válaszának naplózása
                        $response->loadAnswerModel($tranzAdatok, $tranzAdatok->isSuccessful(), $tranzAdatok->getPosValaszkod());  
                        $transLogger->logHaromszereplosFizetesBefejezes($azonosito, $posId, $response);
                        return $response;
                    }
                }
                $retryCount++;
                sleep($resendDelay);
            } while ($poll && ($startTime + 660 > time()));
            // pollozunk, amíg van értelme, de legfeljebb 11 percig! 
            
            $this->logger->info($this->operationLogNames["fizetesiTranzakcio"] 
                . $azonosito . ", pollozás befejezve..."); 
        }
  
        // a folyamat válaszának naplózása
        if ($response->isFinished()) {
            $this->logger->info($this->operationLogNames["fizetesiTranzakcio"] . " folyamat azonosito: " 
                . $response->getInstanceId());
            $responseDom = $response->getResponseDOM();
            $this->lastOutputXml = WebShopXmlUtils::xmlToString($responseDom);
            $this->logger->debug($this->operationLogNames["fizetesiTranzakcio"] . " valasz:\n" 
                . trim($this->lastOutputXml));
            $transLogger->logHaromszereplosFizetesBefejezes($azonosito, $posId, $response);
        }
        else {
            $this->logger->error($this->operationLogNames["fizetesiTranzakcio"] . " hiba, azonosito: " . $azonosito);
            $this->logger->error($workflowState);
        }
                
        $this->logger->debug($this->operationLogNames["fizetesiTranzakcio"] . " befejezodott.");

        return $response;
    }
    
    /**
     * WEBSHOPTRANZAKCIOLEKERDEZES folyamat szinkron indítása.
     * 
     * @param string $posId webshop azonosító
     * @param string $azonosito lekérdezendõ tranzakció azonosító
     * @param mixed $maxRekordSzam maximális rekordszám (int / string)
     * @param mixed $idoszakEleje lekérdezendõ idõszak eleje 
     *        ÉÉÉÉ.HH.NN ÓÓ:PP:MM alakú string érték vagy int timestamp
     * @param mixed $idoszakEleje lekérdezendõ idõszak vége
     *        ÉÉÉÉ.HH.NN ÓÓ:PP:MM alakú string érték vagy int timestamp
     * 
     * @return WResponse a tranzakció válaszát reprezentáló value object.
     *         Sikeres végrehajtás esetén a válasz adatokat WebShopAdatokLista
     *         objektum reprezentálja.
     *         Kommunikációs hiba esetén a finished flag false értékû lesz!
     */
    function tranzakcioStatuszLekerdezes(
            $posId,
            $azonosito, 
            $maxRekordSzam, 
            $idoszakEleje,
            $idoszakVege) {
                
        $this->logger->debug($this->operationLogNames["tranzakcioStatuszLekerdezes"] . " indul...");

        $dom = WebShopXmlUtils::getRequestSkeleton(WF_TRANZAKCIOSTATUSZ, $variables);

        $idoszakEleje = RequestUtils::dateToString($idoszakEleje);
        $idoszakVege = RequestUtils::dateToString($idoszakVege);
        
        /* paraméterek beillesztése */
        WebShopXmlUtils::addParameter($dom, $variables, CLIENTCODE, CLIENTCODE_VALUE);
        WebShopXmlUtils::addParameter($dom, $variables, POSID, $posId);
        WebShopXmlUtils::addParameter($dom, $variables, TRANSACTIONID, $azonosito);
        WebShopXmlUtils::addParameter($dom, $variables, QUERYMAXRECORDS, $maxRekordSzam);
        WebShopXmlUtils::addParameter($dom, $variables, QUERYSTARTDATE, $idoszakEleje);
        WebShopXmlUtils::addParameter($dom, $variables, QUERYENDDATE, $idoszakVege);

        /* aláírás kiszámítása és paraméterként beszúrása */
        $signatureFields = array(0 => 
            $posId, $azonosito, 
            $maxRekordSzam, $idoszakEleje, $idoszakVege );
        $signatureText = SignatureUtils::getSignatureText($signatureFields);

        $pkcs8PrivateKey = SignatureUtils::loadPrivateKey($this->getPrivKeyFileName($this->property, $posId));
        $signature = SignatureUtils::generateSignature($signatureText, $pkcs8PrivateKey, $this->property, $this->logger);

        WebShopXmlUtils::addParameter($dom, $variables, CLIENTSIGNATURE, $signature);

        $this->lastInputXml = WebShopXmlUtils::xmlToString($dom);
        $this->logger->debug($this->operationLogNames["tranzakcioStatuszLekerdezes"] . " keres:\n" . $this->lastInputXml);

        /* a folyamat indítása */
        $workflowState = SoapUtils::startWorkflowSynch(WF_TRANZAKCIOSTATUSZ, $this->lastInputXml, $this->soapClient, $this->logger);
        $response = new WResponse(WF_TRANZAKCIOSTATUSZ, $workflowState);

        /* a folyamat válaszának naplózása */
        if ($response->isFinished()) {
            $this->logger->info($this->operationLogNames["tranzakcioStatuszLekerdezes"] . " folyamat azonosito: " 
                . $response->getInstanceId());
            $responseDom = $response->getResponseDOM();
            $this->lastOutputXml = WebShopXmlUtils::xmlToString($responseDom);
            $this->logger->debug($this->operationLogNames["tranzakcioStatuszLekerdezes"] . " valasz:\n" 
                . trim($this->lastOutputXml));
        }
        else {
            $this->logger->error($this->operationLogNames["tranzakcioStatuszLekerdezes"] . " hiba!");
            $this->logger->error($workflowState);            
        }

        $this->logger->debug($this->operationLogNames["tranzakcioStatuszLekerdezes"] . " befejezodott.");

        return $response;
    }
    
    /**
     * Kétszereplõs fizetési tranzakció (WEBSHOPFIZETESKETSZEREPLOS) indítása.
     *
     * @param string $posId
     *            tranzakció egyedi azonosítója (alfanum, max. 32, azonos a 3
     *            szereplõsnél bevezetettel)
     * @param string $azonosito
     *            a shop azonosítója (num, max. 6, azonos a 3 szereplõsnél
     *            bevezetettel)
     * @param mixed $osszeg
     *            vásárlás összege (num, max. 13+2), opcionális tizedesponttal
     * @param string $devizanem
     *            vásárlás devizaneme (opcionális, azonos a 3 szereplõsnél
     *            bevezetettel)
     * @param stirng $nyelvkod
     *            nyelvkód (azonos a 3 szereplõsnél bevezetettel)
     * @param string $regisztraltUgyfelId
     *            az OTP fizetõfelületen regisztrált ügyfél azonosító kódja.
     *            Kitöltése esetén a kartyaszam, cvc2cvv2, kartyaLejarat adatok
     *            nem kerülnek feldolgozásra, hanem a banki oldalon az adott
     *            azonosítóhoz eltárolt kártyaadatok kerülnek behelyettesítésre
     * @param string $kartyaszam
     *            kártyaszám (azonos a 3 szereplõsnél bevezetettel)
     * @param string $cvc2cvv2
     *            CVC2/CVV2 kód (azonos a 3 szereplõsnél bevezetettel)
     * @param string $kartyaLejarat
     *            kártya lejárati dátuma, MMyy formában
     * @param string $vevoNev
     *            vevõ neve (alfanum, max. 50, opcionális, csak logozandó)
     * @param string $vevoPostaCim
     *            vevõ postai címe (alfanum, max. 100, opcionális)
     * @param string $vevoIPCim
     *            vevõ gépének IP címe (alfanum, max. 15, opcionális)
     * @param string $ertesitoMail
     *            vevõ kiértesítési mailcíme (alfanum, max. 50, opcionális, ha
     *            van, akkor mail küldendõ a tranzakció eredményérõl erre a
     *            címre)
     * @param string $ertesitoTel
     *            vevõ kiértesítési telefonszáma (alfanum, max. 20, opcionális,
     *            ha van, akkor SMS küldendõ a tranzakció eredményérõl erre a
     *            telefonszámra)
     * @param mixed $ketlepcsosFizetes
     * 			  megadja, hogy kétlépcsõs fizetés indítandó-e.
     *            True érték esetén a fizetési tranzakció kétlépcsõs lesz, 
     *            azaz a terhelendõ összeg csupán zárolásra kerül, 
     *            s úgy is marad a bolt által indított lezáró tranzakció 
     *            indításáig avagy a zárolás elévüléséig.
     *            Az alapértelmezett (üres) érték a Bank oldalon rögzített 
     *            alapértelmezett módot jelöli.       
     * 
     * @return WResponse a tranzakció válaszát reprezentáló value object.
     *         Sikeres végrehajtás esetén a válasz adatokat WebShopFizetesValasz
     *         objektum reprezentálja.
     *         Kommunikációs hiba esetén a finished flag false értékû lesz!
     */
    function fizetesiTranzakcioKetszereplos(
            $posId,
            $azonosito, 
            $osszeg, 
            $devizanem, 
            $nyelvkod,
            $regisztraltUgyfelId, 
            $kartyaszam, 
            $cvc2cvv2,
            $kartyaLejarat, 
            $vevoNev, 
            $vevoPostaCim,
            $vevoIPCim, 
            $ertesitoMail, 
            $ertesitoTel,
            $ketlepcsosFizetes = NULL) {

        $this->logger->debug($this->operationLogNames["fizetesiTranzakcioKetszereplos"] . " indul...");

        $dom = WebShopXmlUtils::getRequestSkeleton(WF_KETSZEREPLOSFIZETES, $variables);

        // default értékek feldolgozása
        if (is_null($devizanem) || (trim($devizanem) == "")) {
            $devizanem = DEFAULT_DEVIZANEM;
        }

        /* paraméterek beillesztése */
        WebShopXmlUtils::addParameter($dom, $variables, CLIENTCODE, CLIENTCODE_VALUE);
        WebShopXmlUtils::addParameter($dom, $variables, POSID, $posId);
        WebShopXmlUtils::addParameter($dom, $variables, TRANSACTIONID, $azonosito);
        WebShopXmlUtils::addParameter($dom, $variables, AMOUNT, $osszeg);
        WebShopXmlUtils::addParameter($dom, $variables, EXCHANGE, $devizanem);
        WebShopXmlUtils::addParameter($dom, $variables, LANGUAGECODE, $nyelvkod);
        WebShopXmlUtils::addParameter($dom, $variables, CONSUMERREGISTRATIONID, $regisztraltUgyfelId);
        WebShopXmlUtils::addParameter($dom, $variables, CARDNUMBER, $kartyaszam);
        WebShopXmlUtils::addParameter($dom, $variables, CVCCVV, $cvc2cvv2);
        WebShopXmlUtils::addParameter($dom, $variables, EXPIRATIONDATE, $kartyaLejarat);
        WebShopXmlUtils::addParameter($dom, $variables, NAME, $vevoNev);
        WebShopXmlUtils::addParameter($dom, $variables, FULLADDRESS, $vevoPostaCim);
        WebShopXmlUtils::addParameter($dom, $variables, IPADDRESS, $vevoIPCim);
        WebShopXmlUtils::addParameter($dom, $variables, MAILADDRESS, $ertesitoMail);
        WebShopXmlUtils::addParameter($dom, $variables, TELEPHONE, $ertesitoTel);
        WebShopXmlUtils::addParameter($dom, $variables, TWOSTAGED, RequestUtils::booleanToString($ketlepcsosFizetes));

        /* aláírás kiszámítása és paraméterként beszúrása */
        $signatureFields = array(0 => 
            $posId, $azonosito, $osszeg, $devizanem,
            $kartyaszam, $cvc2cvv2, $kartyaLejarat, $regisztraltUgyfelId);
        $signatureText = SignatureUtils::getSignatureText($signatureFields);

        $pkcs8PrivateKey = SignatureUtils::loadPrivateKey($this->getPrivKeyFileName($this->property, $posId));
        $signature = SignatureUtils::generateSignature($signatureText, $pkcs8PrivateKey, $this->property, $this->logger);

        WebShopXmlUtils::addParameter($dom, $variables, CLIENTSIGNATURE, $signature);

        $this->lastInputXml = WebShopXmlUtils::xmlToString($dom);
        $this->logger->info($this->operationLogNames["fizetesiTranzakcioKetszereplos"] . " keres: " . $posId . " / " . $azonosito);
        $this->logger->debug($this->operationLogNames["fizetesiTranzakcioKetszereplos"] . " keres:\n" . $this->lastInputXml);

        /* Tranzakció adatainak naplózása egy külön fájlba */
        $transLogger = new TransactionLogger(
                    $this->getTranLogDir($this->property, $posId), $this->logger);

        $transLogger->logKetszereplosFizetesInditas($posId, $azonosito, $osszeg,
                    $devizanem, $nyelvkod, $regisztraltUgyfelId, $kartyaszam,
                    $cvc2cvv2, $kartyaLejarat, $vevoNev, $vevoPostaCim, $vevoIPCim,
                    $ertesitoMail, $ertesitoTel, $ketlepcsosFizetes);

        /* Tranzakció indítása */
        $workflowState = SoapUtils::startWorkflowSynch(WF_KETSZEREPLOSFIZETES, $this->lastInputXml, $this->soapClient, $this->logger);
        $response = new WResponse(WF_KETSZEREPLOSFIZETES, $workflowState);

        /* a folyamat válaszának naplózása */
        if ($response->isFinished()) {
            $this->logger->info($this->operationLogNames["fizetesiTranzakcioKetszereplos"] . " folyamat azonosito: " 
                . $response->getInstanceId());
            $responseDom = $response->getResponseDOM();
            $this->lastOutputXml = WebShopXmlUtils::xmlToString($responseDom);
 	        $this->logger->debug($this->operationLogNames["fizetesiTranzakcioKetszereplos"] . " valasz:\n" 
                . trim($this->lastOutputXml));
            $transLogger->logKetszereplosFizetesBefejezes($azonosito, $posId, $response);
        }
        else {
            $this->logger->error($this->operationLogNames["fizetesiTranzakcioKetszereplos"] . " hiba, azonosito: " . $azonosito);  
            $this->logger->error($workflowState);
        }

        $this->logger->debug($this->operationLogNames["fizetesiTranzakcioKetszereplos"] . " befejezodott.");

        return $response;
    }
  
    /**
     * Kétlépcsõs fizetési tranzakció lezárásának (WEBSHOPFIZETESLEZARAS) indítása.
     *
     * @param string $posId
     *            a shop azonosítója 
     * @param string $azonosito
     *            a lezárandó fizetési tranzakció egyedi azonosítója 
     * @param mixed $jovahagyo
     * 			  megadja, hogy a lezárás jóváhagyó vagy tiltó jellegû, 
     *            azaz a kétlépcsõs fizetés során zárolt összeg ténylegesen
     *            be kell-e terhelni a vevõ számláján, avagy stornózni
     *            kell a tételt.
     * 
     * @return WResponse a tranzakció válaszát reprezentáló value object.
     *         Sikeres végrehajtás esetén a válasz adatokat WebShopFizetesValasz
     *         objektum reprezentálja.
     *         Kommunikációs hiba esetén a finished flag false értékû lesz!
     */
    function fizetesiTranzakcioLezaras(
            $posId,
            $azonosito, 
            $jovahagyo) {

        $this->logger->debug($this->operationLogNames["ketlepcsosFizetesLezaras"] . " indul...");

        $dom = WebShopXmlUtils::getRequestSkeleton(WF_KETLEPCSOSFIZETESLEZARAS, $variables);

        /* paraméterek beillesztése */
        WebShopXmlUtils::addParameter($dom, $variables, CLIENTCODE, CLIENTCODE_VALUE);
        WebShopXmlUtils::addParameter($dom, $variables, POSID, $posId);
        WebShopXmlUtils::addParameter($dom, $variables, TRANSACTIONID, $azonosito);
        WebShopXmlUtils::addParameter($dom, $variables, APPROVED, RequestUtils::booleanToString($jovahagyo));
        
        /* aláírás kiszámítása és paraméterként beszúrása */
        $signatureFields = array(0 => $posId, $azonosito);
        $signatureText = SignatureUtils::getSignatureText($signatureFields);

        $pkcs8PrivateKey = SignatureUtils::loadPrivateKey($this->getPrivKeyFileName($this->property, $posId));
        $signature = SignatureUtils::generateSignature($signatureText, $pkcs8PrivateKey, $this->property, $this->logger);

        WebShopXmlUtils::addParameter($dom, $variables, CLIENTSIGNATURE, $signature);

        $this->lastInputXml = WebShopXmlUtils::xmlToString($dom);
        $this->logger->debug($this->operationLogNames["ketlepcsosFizetesLezaras"] . " keres:\n" . $this->lastInputXml);

        /* Tranzakció adatainak naplózása egy külön fájlba */
        $transLogger = new TransactionLogger(
                    $this->getTranLogDir($this->property, $posId), $this->logger);

        $transLogger->logFizetesLezarasInditas($posId, $azonosito, $jovahagyo);

        /* Tranzakció indítása */
        $workflowState = SoapUtils::startWorkflowSynch(WF_KETLEPCSOSFIZETESLEZARAS, $this->lastInputXml, $this->soapClient, $this->logger);
        $response = new WResponse(WF_KETLEPCSOSFIZETESLEZARAS, $workflowState);

        /* a folyamat válaszának naplózása */
        if ($response->isFinished()) {
            $this->logger->info($this->operationLogNames["ketlepcsosFizetesLezaras"] . " folyamat azonosito: " 
                . $response->getInstanceId());
 	        $this->lastOutputXml = WebShopXmlUtils::xmlToString($response->getResponseDOM());
            $this->logger->debug($this->operationLogNames["fizetesiTranzakcioLezaras"] . " valasz:\n" 
                . trim($this->lastOutputXml));
            $transLogger->logKetszereplosFizetesBefejezes($azonosito, $posId, $response);
        }
        else {
            $this->logger->error($this->operationLogNames["ketlepcsosFizetesLezaras"] . " hiba, azonosito: " . $azonosito);  
            $this->logger->error($workflowState);
        }

        $this->logger->debug($this->operationLogNames["ketlepcsosFizetesLezaras"] . " befejezodott.");

        return $response;
    }

    /**
     * WEBSHOPTRANZAKCIOLEKERDEZES folyamat szinkron indítása pollozás céljából.
     * A bank nem javasolja, hogy pollozásos technikával történjen a fizetési
     * tranzakciók eredményének lekérdezése - mindazonáltal kommunikációs vagy
     * egyéb hiba esetén ez az egyetlen módja annak, hogy a tranzakció válaszát
     * utólag le lehessen kérdezni.
     * 
     * @param string $posId webshop azonosító
     * @param string $azonosito lekérdezendõ tranzakció azonosító
     * @param int $inditas a tranzakció indítása az indító kliens órája szerint 
     *                     (a lekérdezés +-24 órára fog korlátozódni)
     * 
     * @return mixed Sikeres lekérdezés és létezõ tranzakció esetén 
     *               a vonatkozó WebShopFizetesAdatok. A tranzakció állapotát
     *               ez az objektum fogja tartalmazni - ami utalhat például 
     *               vevõ oldali input várakozásra vagy feldolgozott státuszra.
     *               FALSE hibás lekérdezés esetén. (Pl. nem létezik tranzakció)
     */
    function tranzakcioPoll($posId, $azonosito,  $inditas) {

        $maxRekordSzam = "1";
        $idoszakEleje = $inditas - 60*60*24;
        $idoszakVege = $inditas + 60*60*24;
                
        $tranzAdatok = false;                        
        $response = $this->tranzakcioStatuszLekerdezes($posId, $azonosito, $maxRekordSzam, $idoszakEleje, $idoszakVege);
        if ($response) {
            $answer = $response->getAnswer();
            if ($response->isSuccessful()
                    && $response->getAnswer()
                    && count($answer->getWebShopFizetesAdatok()) > 0) {

                // Sikerült lekérdezni az adott tranzakció adatát
                $fizetesAdatok = $answer->getWebShopFizetesAdatok();
                $tranzAdatok = reset($fizetesAdatok);
            }
        }
        return $tranzAdatok;
    }
    
}

?>