<?php

if (!defined('WEBSHOP_LIB_DIR')) define('WEBSHOP_LIB_DIR', dirname(__FILE__) . '/../..');

$phpversion = phpversion();

require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/model/WebShopFizetesAdatokLista.php');
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/model/WebShopFizetesAdatok.php');
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/model/WebShopFizetesValasz.php');
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/WebShopXmlUtils.php' . $phpversion{0});

/**
 * Tranzakci�nk�nti napl� f�jl k�sz�t�se a h�rom- �s k�tszerepl�s
 * fizet�si tranzakci�khoz.
 * 
 * @author Bodn�r Imre / IQSYS
 * @version 3.3.1
 */
class TransactionLogger {

    var $logDir;
    var $logDirSuccess;
    var $logDirFailed;
    
    var $logger;
    
    /**
     * Tranzakci�s napl�z� l�trehoz�sa
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
     * @desc A tranzakci�s log �llom�ny nev�nek �s el�r�si �tvonal�nak
     * meghat�roz�sa. Az �llom�ny neve utal a tranzakci� azonos�t�j�ra
     * �s az ind�t� bolt azonos�t�j�ra. 
     * Ha tranzakci� ind�t�sr�l van sz�, �j f�jln�v ker�l k�pz�sre, 
     * esetleges _x postfix gener�l�s�val, ahol x eg�sz sz�m.
     * Ha tranzakci� befejez�d�sr�l van sz�, akkor a tranzakci� 
     * ind�t�s�hoz tartoz� adatokat tartalmaz� f�jl neve ker�l meghat�roz�sra. 
     * 
     * @param string $azonosito fizet�si tranzakci� azonos�t�
     * @param string $posId	shopId
     * @param string $logFileName a l�trehozand� log file neve. Null, ha a 
     *               met�dus hat�rozza meg az $azonosito �s $posId alapj�n
     * @param strgin $uj igaz, ha �j f�jl l�trehoz�s�r�l van sz�, p�ld�l 
     *                   a fizet�si tranzakci� ind�t�s�n�l vagy 
     *                   mozgat�sn�l	
     * @param string $logDir a c�lk�nyvt�r neve
     * @return string a "gener�lt" f�jl n�v
     */
    function getLogFileName($azonosito, $posId, $logFileName, $uj, $logDir) {
        
    	/* K�nyvt�r l�rtehoz�sa, ha sz�ks�ges */
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
                
        /* Fel kell k�sz�lni arra, hogy az adott n�ven m�r l�tezik f�jl */
        $logFile = $logDir . "/" . $logFileName;
        $i = 0;
        while ($uj && file_exists($logFile)) {
        	$i++;
            $logFile = $logDir . "/" . $logFileName . "_" . $i;
        }

        return $i == 0 ? $logFileName : $logFileName . "_" . $i;
    }
   
    /**
     * Objektum string reprezent�l�sa.
     * Annyiban t�r el a toString() �ltal visszaadott adatt�l, hogy
     * null �rt�k eset�n �res string a visszat�r�si �rt�k, �s nem
     * a "null" sz�veg
     * 
     * @param value �rt�k
     * @return string reprezent�ci�
     */
    function nvl($value) {
        return (is_null($value) ? "" : $value);
    }

    
    /**
    * @desc Sz�veg ki�r�sa f�jlba.
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
   * @desc H�romszerepl�s fizet�si tranzakci� ind�t�s�nak napl�z�sa.
   *
   * @param posId webshop azonos�t�
   * @param azonosito fizet�si tranzakci� azonos�t�
   * @param osszeg fizetend� �sszeg 
   * @param devizanem fizetend� devizanem
   * @param nyelvkod a megjelen�tend� vev� oldali fel�let nyelve
   * @param nevKell a megjelen�tend� vev� oldali fel�leten be kell k�rni a vev� nev�t
   * @param orszagKell a megjelen�tend� vev� oldali fel�leten be kell k�rni a vev� c�m�nek "orsz�g r�sz�t"
   * @param megyeKell a megjelen�tend� vev� oldali fel�leten be kell k�rni a vev� c�m�nek "megye r�sz�t"
   * @param telepulesKell a megjelen�tend� vev� oldali fel�leten be kell k�rni a vev� c�m�nek "telep�l�s r�sz�t"
   * @param iranyitoszamKell a megjelen�tend� vev� oldali fel�leten be kell k�rni  a vev� c�m�nek "ir�ny�t�sz�m r�sz�t"
   * @param utcaHazszamKell a megjelen�tend� vev� oldali fel�leten be kell  k�rni a vev� c�m�nek "utca/h�zsz�m r�sz�t"
   * @param mailCimKell a megjelen�tend� vev� oldali fel�leten be kell�k�rni a vev� e-mail c�m�t
   * @param kozlemenyKell a megjelen�tend� vev� oldali fel�leten fel kell k�n�lni a k�zlem�ny megad�s�nak lehet�s�g�t
   * @param vevoVisszaigazolasKell a tranzakci� eredm�ny�t a vev� oldalon meg kell jelen�teni (azaz nem a backURL-re kell ir�ny�tani)
   * @param ugyfelRegisztracioKell ha a regisztraltUgyfelId �rt�ke nem �res, akkor megadja, hogy a megadott azonos�t� �jonnan regisztr�land�-e, vagy m�r regisztr�l�sra ker�lt az OTP Internetes Fizet� fel�let�n. 
   * @param regisztraltUgyfelId az OTP fizet�fel�leten regisztr�land� vagy regisztr�lt  �gyf�l azonos�t� k�dja. 
   * @param shopMegjegyzes a webshop megjegyz�se a tranzakci�hoz a vev� r�sz�re
   * @param backURL a tranzakci� v�grehajt�sa ut�n erre az internet c�mre kell ir�ny�tani a vev� oldalon az �gyfelet (ha a vevoVisszaigazolasKell hamis)
   * @param string $logFileName a l�trehozand� log file neve. Null, ha a met�dus hat�rozza meg az $azonosito �s $posId alapj�n
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
    * H�romszerepl�s fizet�si tranzakci� befejez�d�s�nek napl�z�sa.
    *
    * @param string $azonosito fizet�si tranzakci� azonos�t�
    * @param string $posId shopID bolt azonos�t
    * @param WResponse $response a fizet�si tranzakci� v�lasza
    * @param boolean $moveFile mozgassa-e a f�jlt a v�grehajt�s ut�n
    * @param string $logFileName a l�trehozand� log file neve. 
    *        Null, ha a met�dus hat�rozza meg az $azonosito �s $posId alapj�n
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
    * K�tszerepl�s fizet�si tranzakci� ind�t�si adatainak napl�z�sa.
    *
    * @param string $posId tranzakci� egyedi azonos�t�ja 
    * @param string $azonosito a shop azonos�t�ja 
    * @param string $osszeg v�s�rl�s �sszege 
    * @param string $devizanem v�s�rl�s devizaneme 
    * @param string $nyelvkod nyelvk�d 
    * @param string $regisztraltUgyfelId 
    * az OTP fizet�fel�leten regisztr�lt �gyf�l azonos�t� k�dja. 
    * @param string $kartyaszam    k�rtyasz�m 
    * @param string $cvc2cvv2      CVC2/CVV2 k�d 
    * @param string $kartyaLejarat k�rtya lej�rati d�tuma, MMyy form�ban
    * @param string $vevoNev       vev� neve 
    * @param string $vevoPostaCim  vev� postai c�me 
    * @param string $vevoIPCim     vev� g�p�nek IP c�me 
    * @param string $ertesitoMail  vev� ki�rtes�t�si mailc�me 
    * @param string $ertesitoTel   vev� ki�rtes�t�si telefonsz�ma 
    * @param string $logFileName a l�trehozand� log file neve. Null, ha a met�dus hat�rozza meg az $azonosito �s $posId alapj�n
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
    * K�tszerepl�s fizet�si tranzakci� befejez�d�s�nek napl�z�sa.
    *
    * @param string $azonosito fizet�si tranzakci� azonos�t�
    * @param string $posId shopID bolt azonos�t�
    * @param WResponse $response a fizet�si tranzakci� v�lasza
    * @param boolean $moveFile mozgassa-e a f�jlt a v�grehajt�s ut�n
    * @param string $logFileName a l�trehozand� log file neve. Null, ha a met�dus hat�rozza meg az $azonosito �s $posId alapj�n
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
                        // lockol�s v�gett hoztuk l�tre, t�r�lhetj�k
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
     * K�tl�pcs�s fizet�si tranzakci� lez�r�sa ind�t�si adatainak napl�z�sa.
     *
     * @param string $posId tranzakci� egyedi azonos�t�ja 
     * @param string $azonosito a shop azonos�t�ja 
     * @param mixed $jovahagyo j�v�hagy�-e a lez�r�s
     * @param string $logFileName a l�trehozand� log file neve. Null, ha a met�dus hat�rozza meg az $azonosito �s $posId alapj�n
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
     * K�tl�pcs�s fizet�si tranzakci� lez�r�sa befejez�d�s�nek napl�z�sa.
     *
    * @param string $azonosito fizet�si tranzakci� azonos�t�
    * @param string $posId shopID bolt azonos�t�
    * @param WResponse $response a fizet�si tranzakci� v�lasza
    * @param boolean $moveFile mozgassa-e a f�jlt a v�grehajt�s ut�n
    * @param string $logFileName a l�trehozand� log file neve. Null, ha a met�dus hat�rozza meg az $azonosito �s $posId alapj�n
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
                        // lockol�s v�gett hoztuk l�tre, t�r�lhetj�k
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