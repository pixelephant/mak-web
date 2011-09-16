<?php

if (!defined('WEBSHOP_LIB_DIR')) define('WEBSHOP_LIB_DIR', dirname(__FILE__) . '/../..');

$phpversion = phpversion();

require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/model/WebShopFizetesAdatokLista.php');
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/model/WebShopFizetesAdatok.php');
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/model/WebShopFizetesValasz.php');
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/WebShopXmlUtils.php' . $phpversion{0});

/**
 * Tranzakciónkénti napló fájl készítése a három- és kétszereplõs
 * fizetési tranzakciókhoz.
 * 
 * @author Bodnár Imre / IQSYS
 * @version 3.3.1
 */
class TransactionLogger {

    var $logDir;
    var $logDirSuccess;
    var $logDirFailed;
    
    var $logger;
    
    /**
     * Tranzakciós naplózó létrehozása
     */
    function TransactionLogger($logDir, $logger) {

        reset($logDir);
        $this->logDir = (is_null(current($logDir)) ? "" : trim(current($logDir)));
        $this->logDirSuccess = (next($logDir) && !is_null(current($logDir)) 
            ? trim(current($logDir)) : $this->logDir);
        $this->logDirFailed = (next($logDir) && !is_null(current($logDir)) 
            ? trim(current($logDir)) : $this->logDir);
        $this->logger = $logger;
    }
    
    /**
     * @desc A tranzakciós log állomány nevének és elérési útvonalának
     * meghatározása. Az állomány neve utal a tranzakció azonosítójára
     * és az indító bolt azonosítójára. 
     * Ha tranzakció indításról van szó, új fájlnév kerül képzésre, 
     * esetleges _x postfix generálásával, ahol x egész szám.
     * Ha tranzakció befejezõdésrõl van szó, akkor a tranzakció 
     * indításához tartozó adatokat tartalmazó fájl neve kerül meghatározásra. 
     * 
     * @param string $azonosito fizetési tranzakció azonosító
     * @param string $posId	shopId
     * @param string $logFileName a létrehozandó log file neve. Null, ha a 
     *               metódus határozza meg az $azonosito és $posId alapján
     * @param strgin $uj igaz, ha új fájl létrehozásáról van szó, példál 
     *                   a fizetési tranzakció indításánál vagy 
     *                   mozgatásnál	
     * @param string $logDir a célkönyvtár neve
     * @return string a "generált" fájl név
     */
    function getLogFileName($azonosito, $posId, $logFileName, $uj, $logDir) {
        
    	/* Könyvtár lértehozása, ha szükséges */
        if (file_exists($logDir)) {
        	if (!is_dir($logDir)) {
        		$this->logger->warn(
                    "Ervenytelen tranzakcio log konyvtar: " . $logDir);
            }
        }
        else {
            $this->logger->warn(
                "A tranzakcio log konyvtar nem letezik: " . $logDir);

            $success = mkdir($logDir, 0710);
            if (!success) {
                $this->logger->warn(
                    "A tranzakcio log konyvtar nem hozhato letre: " . $logDir);
            }            
        }
        
        if (is_null($logFileName)) {
            $logFileName = 
                $posId . "_" . $azonosito . ".log";
        }
                
        /* Fel kell készülni arra, hogy az adott néven már létezik fájl */
        $logFile = $logDir . "/" . $logFileName;
        $i = 0;
        while ($uj && file_exists($logFile)) {
        	$i++;
            $logFile = $logDir . "/" . $logFileName . "_" . $i;
        }

        return $i == 0 ? $logFileName : $logFileName . "_" . $i;
    }
   
    /**
     * Objektum string reprezentálása.
     * Annyiban tér el a toString() által visszaadott adattól, hogy
     * null érték esetén üres string a visszatérési érték, és nem
     * a "null" szöveg
     * 
     * @param value érték
     * @return string reprezentáció
     */
    function nvl($value) {
        return (is_null($value) ? "" : $value);
    }

    
    /**
    * @desc Szöveg kiírása fájlba.
    */
    function filePutContents($fileName, $data, $flags, $fileDir) {
        $resource=@fopen($fileDir . "/" . $fileName, $flags);   
        if (!$resource) {
            return false;
        }
        else {
            $success = fwrite($resource, $data);
            fclose($resource);
            return $success;   
        }
    }
   
  /**
   * @desc Háromszereplõs fizetési tranzakció indításának naplózása.
   *
   * @param posId webshop azonosító
   * @param azonosito fizetési tranzakció azonosító
   * @param osszeg fizetendö összeg 
   * @param devizanem fizetendö devizanem
   * @param nyelvkod a megjelenítendö vevö oldali felület nyelve
   * @param nevKell a megjelenítendö vevö oldali felületen be kell kérni a vevö nevét
   * @param orszagKell a megjelenítendö vevö oldali felületen be kell kérni a vevö címének "ország részét"
   * @param megyeKell a megjelenítendö vevö oldali felületen be kell kérni a vevö címének "megye részét"
   * @param telepulesKell a megjelenítendö vevö oldali felületen be kell kérni a vevö címének "település részét"
   * @param iranyitoszamKell a megjelenítendö vevö oldali felületen be kell kérni  a vevö címének "irányítószám részét"
   * @param utcaHazszamKell a megjelenítendö vevö oldali felületen be kell  kérni a vevö címének "utca/házszám részét"
   * @param mailCimKell a megjelenítendö vevö oldali felületen be kellûkérni a vevö e-mail címét
   * @param kozlemenyKell a megjelenítendö vevö oldali felületen fel kell kínálni a közlemény megadásának lehetöségét
   * @param vevoVisszaigazolasKell a tranzakció eredményét a vevö oldalon meg kell jeleníteni (azaz nem a backURL-re kell irányítani)
   * @param ugyfelRegisztracioKell ha a regisztraltUgyfelId értéke nem üres, akkor megadja, hogy a megadott azonosító újonnan regisztrálandó-e, vagy már regisztrálásra került az OTP Internetes Fizetõ felületén. 
   * @param regisztraltUgyfelId az OTP fizetõfelületen regisztrálandó vagy regisztrált  ügyfél azonosító kódja. 
   * @param shopMegjegyzes a webshop megjegyzése a tranzakcióhoz a vevö részére
   * @param backURL a tranzakció végrehajtása után erre az internet címre kell irányítani a vevö oldalon az ügyfelet (ha a vevoVisszaigazolasKell hamis)
   * @param string $logFileName a létrehozandó log file neve. Null, ha a metódus határozza meg az $azonosito és $posId alapján
   * 
   * @access public
   */
    function logHaromszereplosFizetesInditas(
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
            $ketlepcsosFizetes,
            $logFileName = null) {
    	
       if (!is_null($azonosito) && (trim($azonosito) != "")) {
            $logFileName = $this->getLogFileName($azonosito, $posId, $logFileName, true, $this->logDir); 

            $logContent = "Haromszereplos fizetesi tranzakcio" . "\n"
                . "\nInditas: " . date(LOG_DATE_FORMAT, time()) . "\n" 
                . "\nIndito adatok" . "\n"
                . "  posId: " . $posId . "\n"
                . "  azonosito: " . $azonosito . "\n"
                . "  osszeg: " . $osszeg . "\n"
                . "  devizanem: " . $devizanem . "\n"
                . "  nyelvkod: " . $nyelvkod . "\n"
                . "  nevKell: " . $nevKell . "\n"
                . "  orszagKell: " . $orszagKell . "\n"
                . "  megyeKell: " . $megyeKell . "\n"
                . "  telepulesKell: " . $telepulesKell . "\n"
                . "  iranyitoszamKell: " . $iranyitoszamKell . "\n"
                . "  utcaHazszamKell: " . $utcaHazszamKell . "\n"
                . "  mailCimKell: " . $mailCimKell . "\n"
                . "  kozlemenyKell: " . $kozlemenyKell . "\n"
                . "  vevoVisszaigazolasKell: " . $vevoVisszaigazolasKell . "\n"
                . "  ugyfelRegisztracioKell: " . $ugyfelRegisztracioKell . "\n"
                . "  regisztraltUgyfelId: " . $regisztraltUgyfelId . "\n"
                . "  shopMegjegyzes: " . $shopMegjegyzes . "\n"
                . "  backURL: " . $backURL . "\n"
                . "  ketlepcsosFizetes: " . $ketlepcsosFizetes . "\n";	

            if (!$this->filePutContents($logFileName, $logContent, "w+b", $this->logDir)) {
                $this->logger->warn("Hiba tortent a tranzakcios naplo fajl letrehozasa " 
                    . "vagy irasa kozben: " . $logFileName);
            }
        }
        else {
        	$this->logger->warn("A tranzakcio adatai nem naplozhatoak, a fizetesi azonosito nincs megadva.");
        }
    }

   /**
    * Háromszereplõs fizetési tranzakció befejezõdésének naplózása.
    *
    * @param string $azonosito fizetési tranzakció azonosító
    * @param string $posId shopID bolt azonosít
    * @param WResponse $response a fizetési tranzakció válasza
    * @param boolean $moveFile mozgassa-e a fájlt a végrehajtás után
    * @param string $logFileName a létrehozandó log file neve. 
    *        Null, ha a metódus határozza meg az $azonosito és $posId alapján
    */
    function logHaromszereplosFizetesBefejezes(
            $azonosito,
            $posId,
    		$response,
            $moveFile = true,
            $logFileName = null) {

       if (is_null($response) || !$response->isFinished()) {
            $this->logger->warn(
                "A tranzakcio adatai nem naplozhatoak, a valasz ures: " . $azonosito);
       }
       else if (!is_null($azonosito) && (trim($azonosito) != "")) {
            $logFileName = $this->getLogFileName($azonosito, $posId, $logFileName, false, $this->logDir); 

            $logContent = 
                "\nBefejezes: " . date(LOG_DATE_FORMAT, time()) . "\n" 
                . "\nValasz: " . implode(", " , $response->getMessages()) . "\n";

            $fizetesAdatok = $response->getAnswer();

            if (!is_null($fizetesAdatok)) {

                $logContent .=
                    "\nValasz adatok" . "\n"
                    . "  posId: " . $fizetesAdatok->getPosId() . "\n"
                    . "  azonosito: " . $fizetesAdatok->getAzonosito() . "\n"
                    . "  posValaszkod: " . $fizetesAdatok->getPosValaszkod() . "\n"
                    . "  authorizaciosKod: " . $fizetesAdatok->getAuthorizaciosKod() . "\n"
                    . "  statuszKod: " . $fizetesAdatok->getStatuszKod() . "\n"
                    . "  teljesites: " . $fizetesAdatok->getTeljesites() . "\n"
                    . "  nev: " . $fizetesAdatok->getNev() . "\n"
                    . "  orszag: " . $fizetesAdatok->getOrszag() . "\n"
                    . "  megye: " . $fizetesAdatok->getMegye() . "\n"
                    . "  varos: " . $fizetesAdatok->getVaros() . "\n"
                    . "  iranyitoszam: " . $fizetesAdatok->getIranyitoszam() . "\n"
                    . "  utcaHazszam: " . $fizetesAdatok->getUtcaHazszam() . "\n"
                    . "  mailCim: " . $fizetesAdatok->getMailCim() . "\n"
                    . "  kozlemeny: " . $fizetesAdatok->getKozlemeny() . "\n";
            }


            if (!$this->filePutContents($logFileName, $logContent, "a+b", $this->logDir)) {
                $this->logger->warn("Hiba tortent a tranzakcios naplo fajl letrehozasa " 
                    . "vagy irasa kozben: " . $logFileName);
            }
            else if ($moveFile){
                $newLoc = $response->isSuccessful() ? $this->logDirSuccess : $this->logDirFailed;
                if (!is_null($newLoc)) {
                    rename($this->logDir . "/" . $logFileName, 
                        $newLoc . "/" . $this->getLogFileName($azonosito, $posId, $logFileName, true, $newLoc));
                }
            }
        }
        else {
            $this->logger->warn("A tranzakcio adatai nem naplozhatoak," 
                . " az azonosito nincs megadva.");
            
        }
    }
    
   /**
    * Kétszereplõs fizetési tranzakció indítási adatainak naplózása.
    *
    * @param string $posId tranzakció egyedi azonosítója 
    * @param string $azonosito a shop azonosítója 
    * @param string $osszeg vásárlás összege 
    * @param string $devizanem vásárlás devizaneme 
    * @param string $nyelvkod nyelvkód 
    * @param string $regisztraltUgyfelId 
    * az OTP fizetõfelületen regisztrált ügyfél azonosító kódja. 
    * @param string $kartyaszam    kártyaszám 
    * @param string $cvc2cvv2      CVC2/CVV2 kód 
    * @param string $kartyaLejarat kártya lejárati dátuma, MMyy formában
    * @param string $vevoNev       vevõ neve 
    * @param string $vevoPostaCim  vevõ postai címe 
    * @param string $vevoIPCim     vevõ gépének IP címe 
    * @param string $ertesitoMail  vevõ kiértesítési mailcíme 
    * @param string $ertesitoTel   vevõ kiértesítési telefonszáma 
    * @param string $logFileName a létrehozandó log file neve. Null, ha a metódus határozza meg az $azonosito és $posId alapján
    */
    function logKetszereplosFizetesInditas(
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
            $ketlepcsosFizetes,
            $logFileName = null) {

       if (!is_null($azonosito) && (trim($azonosito) != "")) {
            $logFileName = $this->getLogFileName($azonosito, $posId, $logFileName, true, $this->logDir); 
            
            $logContent = 
                "Ketszereplos fizetesi tranzakcio" . "\n"
                . "\nInditas: " . date(LOG_DATE_FORMAT, time()) . "\n" 
                . "\nIndito adatok" . "\n"
                . "  posId: " . $posId . "\n"
                . "  azonosito: " . $azonosito . "\n"
                . "  osszeg: " . $osszeg . "\n"
                . "  devizanem: " . $devizanem . "\n"
                . "  nyelvkod: " . $nyelvkod . "\n"
                . "  regisztraltUgyfelId: " . $regisztraltUgyfelId . "\n"
                . "  vevoNev: " . $vevoNev . "\n"
                . "  vevoPostaCim: " . $vevoPostaCim . "\n"
                . "  vevoIPCim: " . $vevoIPCim . "\n"
                . "  ertesitoMail: " . $ertesitoMail . "\n"
                . "  ertesitoTel: " . $ertesitoTel . "\n"
                . "  ketlepcsos: " . $ketlepcsosFizetes . "\n";	
                
            if (!$this->filePutContents($logFileName, $logContent, "w+b", $this->logDir)) {
                $this->logger->warn("Hiba tortent a tranzakcios naplo fajl letrehozasa " 
                    . "vagy irasa kozben: " . $logFileName);
            }
       }
        else {
            $this->loggerwarn("A tranzakcio adatai nem naplozhatoak," 
                . " az azonosito nincs megadva.");
            
        }
        
    }

   /**
    * Kétszereplõs fizetési tranzakció befejezõdésének naplózása.
    *
    * @param string $azonosito fizetési tranzakció azonosító
    * @param string $posId shopID bolt azonosító
    * @param WResponse $response a fizetési tranzakció válasza
    * @param boolean $moveFile mozgassa-e a fájlt a végrehajtás után
    * @param string $logFileName a létrehozandó log file neve. Null, ha a metódus határozza meg az $azonosito és $posId alapján
    */
    function logKetszereplosFizetesBefejezes(
            $azonosito,
            $posId,
            $response,
            $moveFile = true,
            $logFileName = null) {

       if (is_null($response) || !$response->isFinished()) {
            $this->logger->warn(
                "A tranzakcio adatai nem naplozhatoak, a valasz ures: " . $azonosito);
       }
       else if (!is_null($azonosito) && (trim($azonosito) != "")) {
            $logFileName = $this->getLogFileName($azonosito, $posId, $logFileName, false, $this->logDir); 

            $valasz = $response->getAnswer();                         
            $logContent = 
                "\nBefejezes: " . date(LOG_DATE_FORMAT, time()) . "\n" 
                . "\nValasz: " . implode(", " , $response->getMessages()) . "\n"
                . "\nValasz adatok" . "\n"
                . "  posId: " . $valasz->getPosId() . "\n"
                . "  azonosito: " . $valasz->getAzonosito() . "\n"
                . "  posValaszkod: " . $valasz->getValaszKod() . "\n"
                . "  authorizaciosKod: " . $valasz->getAuthorizaciosKod() . "\n"
                . "  teljesites: " . $valasz->getTeljesites() . "\n";
                
            if (!$this->filePutContents($logFileName, $logContent, "a+b", $this->logDir)) {
                $this->logger->warn("Hiba tortent a tranzakcios naplo fajl letrehozasa " 
                    . "vagy irasa kozben: " . $logFileName);
            }
            else if ($moveFile) {
                $newLoc = $response->isSuccessful() ? $this->logDirSuccess : $this->logDirFailed;
                if (!is_null($newLoc) && $newLoc != $this->logDir) {
                    $targetFile = $newLoc . "/" . $this->getLogFileName($azonosito, $posId, $logFileName, true, $newLoc);
                    if (file_exists($targetFile) && filesize($targetFile) === 0) {
                        // lockolás végett hoztuk létre, törölhetjük
                        delete($targetFile);
                    }
                    rename($this->logDir . "/" . $logFileName, $targetFile );
                }
            }
        }
        else {
            $this->loggerwarn(
                "A tranzakcio adatai nem naplozhatoak, az azonosito nincs megadva.");
        }
    }

    /**
     * Kétlépcsõs fizetési tranzakció lezárása indítási adatainak naplózása.
     *
     * @param string $posId tranzakció egyedi azonosítója 
     * @param string $azonosito a shop azonosítója 
     * @param mixed $jovahagyo jóváhagyó-e a lezárás
     * @param string $logFileName a létrehozandó log file neve. Null, ha a metódus határozza meg az $azonosito és $posId alapján
     */
     function logFizetesLezarasInditas(
             $posId,
             $azonosito,
             $jovahagyo,
             $logFileName = null) {
         
         if (!is_null($azonosito) && (trim($azonosito) != "")) {
            $logFileName = $this->getLogFileName($azonosito, $posId, $logFileName, false, $this->logDir); 

            $logContent = 
                 "Ketlepcsos fizetes lezaras tranzakcio" . "\n"
                 . "\nInditas: " . date(LOG_DATE_FORMAT, time()) . "\n" 
                 . "\nIndito adatok" . "\n"
                 . "  posId: " . $posId . "\n"
                 . "  azonosito: " . $azonosito . "\n"
                 . "  jovahagyo: " . $jovahagyo . "\n";

            if (!$this->filePutContents($logFileName, $logContent, "a+b", $this->logDir)) {
                $this->logger->warn("Hiba tortent a tranzakcios naplo fajl letrehozasa " 
                    . "vagy irasa kozben: " . $logFileName);
            }
         }
         else {
             $this->logger->warn("A tranzakcio adatai nem naplozhatoak," 
                             . " az azonosito nincs megadva.");
             
         }
         
     }

    /**
     * Kétlépcsõs fizetési tranzakció lezárása befejezõdésének naplózása.
     *
    * @param string $azonosito fizetési tranzakció azonosító
    * @param string $posId shopID bolt azonosító
    * @param WResponse $response a fizetési tranzakció válasza
    * @param boolean $moveFile mozgassa-e a fájlt a végrehajtás után
    * @param string $logFileName a létrehozandó log file neve. Null, ha a metódus határozza meg az $azonosito és $posId alapján
     */
     function logFizetesLezarasBefejezes(
             $azonosito,
             $posId,
             $response,
             $moveFile = true,
             $logFileName = null) {

       if (is_null($response) || !$response->isFinished()) {
            $this->logger->warn(
                "A tranzakcio adatai nem naplozhatoak, a valasz ures: " . $azonosito);
       }
       else if (!is_null($azonosito) && (trim($azonosito) != "")) {
            $logFileName = $this->getLogFileName($azonosito, $posId, $logFileName, false, $this->logDir); 

            $valasz = $response->getAnswer();                         
            $logContent = 
                "\nBefejezes: " . date(LOG_DATE_FORMAT, time()) . "\n" 
                . "\nValasz: " . implode(", " , $response->getMessages()) . "\n"
                . "\nValasz adatok" . "\n"
                . "  posId: " . $valasz->getPosId() . "\n"
                . "  azonosito: " . $valasz->getAzonosito() . "\n"
                . "  posValaszkod: " . $valasz->getValaszKod() . "\n"
                . "  authorizaciosKod: " . $valasz->getAuthorizaciosKod() . "\n"
                . "  teljesites: " . $valasz->getTeljesites() . "\n";
                
            if (!$this->filePutContents($logFileName, $logContent, "a+b", $this->logDir)) {
                $this->logger->warn("Hiba tortent a tranzakcios naplo fajl letrehozasa " 
                    . "vagy irasa kozben: " . $logFileName);
            }
            else if ($moveFile) {
                $newLoc = $response->isSuccessful() ? $this->logDirSuccess : $this->logDirFailed;
                if (!is_null($newLoc) && $newLoc != $this->logDir) {
                    $targetFile = $newLoc . "/" . $this->getLogFileName($azonosito, $posId, $logFileName, true, $newLoc);
                    if (file_exists($targetFile) && filesize($targetFile) === 0) {
                        // lockolás végett hoztuk létre, törölhetjük
                        delete($targetFile);
                    }
                    rename($this->logDir . "/" . $logFileName, $targetFile );
                }
            }
        }
        else {
            $this->loggerwarn(
                "A tranzakcio adatai nem naplozhatoak, az azonosito nincs megadva.");
        }
                 
     }
    
}

?>