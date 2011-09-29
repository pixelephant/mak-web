<?php

$phpversion = phpversion();

if (!defined('WEBSHOP_LIB_DIR')) define('WEBSHOP_LIB_DIR', dirname(__FILE__) . '/../..');
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/WebShopService.php');
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/model/WorkflowState.php');

define('PROPERTY_SIMULATEDXMLDIR', "otp.webshop.SIMULATED_XML_DIR"); 

/**
 * WebShop PHP szimulátor - Fizetõfelület Banki oldalának szimulálása.
 *
 * A WebShop-ok részére készített PHP alkalmazás csomag része. 
 * Ez az alkalmazás csupán szimulálja az OTP Bank rendszerének megfelelö WebShop
 * folyamat-hívását: 
 * - ping 
 * - tranzakció azonosító generálás 
 * - háromszereplös fizetési folyamat indítása 
 * - kétszereplös fizetési folyamat indítása 
 * - tranzakció adatok, tranzakció státusz lekérdezése
 * - kétlépcsõs fizetés lezárás
 *
 * A fenti szolgáltatások az OTP MWAccess felület hívását csupán szimulálják, az egyes
 * kérésekre adandó válaszokat ugyanis fájlból olvassák ki. A Banki felület nem kerül
 * megszólításra.
 * 
 * A fájlok elnevezési konvenciójának a [tranzakciónev]_output.xml kell lenni,
 * ahol a [tranzakciónev] lehet WEBSHOPTRANZAZONGENERALAS, 
 * WEBSHOPTRANZAKCIOLEKERDEZES, WEBSHOPFIZETES, WEBSHOPFIZETESKETSZEREPLOS 
 * és WEBSHOPFIZETESLEZARAS.  
 * A könyvtárat, melyben ezek a fájlok elhelyezend?k, a konfigurációs állomány
 * otp.webshop.SIMULATED_XML_DIR bejegyzésében kell megadni, követve a szokásos
 * elérési útvonal megadási szabályokat.
 * 
 * @version 3.3.1
 * @author Bodnár Imre / IQSYS
 */
class WebShopServiceSimulator extends WebShopService {

    /**
    * @desc Konstruktor
    */
    function WebShopServiceSimulator() {
        $this->logger =& LoggerManager::getLogger("WebShopClient");
        $this->logger->debug("OTPWebShopService (PHP) szimulator peldanyositas...");
       
        $this->property = parse_ini_file(WEBSHOPSERVICE_CONFIGURATION);
        
        $this->operationLogNames = array(
            "tranzakcioAzonositoGeneralas" => "tranzakcioAzonositoGeneralas" . " *** SZIMULATOR ***",
            "fizetesiTranzakcioKetszereplos" => "fizetesiTranzakcioKetszereplos" . " *** SZIMULATOR ***",
            "fizetesiTranzakcio" => "fizetesiTranzakcio" . " *** SZIMULATOR ***",
            "tranzakcioStatuszLekerdezes" => "tranzakcioStatuszLekerdezes" . " *** SZIMULATOR ***",
            "ketlepcsosFizetesLezaras" => "ketlepcsosFizetesLezaras" . " *** SZIMULATOR ***",
        );
    }

    /**
    * @desc Szimulált WorkflowState elõállítása.
    * A result tartalma fájlból kerül beolvasásra,
    * mely fájl neve a 
    * PROPERTY_SIMULATEDXMLDIR + "/" + $workflowName + "_output.xml";
    * lesz.
    * A Banki tranzakció azonosító az aktuális idõ alapján generált érték.
    * 
    * @return WorkflowState szimulált válasz.
    */
    function getSimulatedWorkflowState($workflowName, $inputXml) {
        $workflowState = new WorkflowState(NULL);
        $workflowState->templateName = $workflowName;
        $workflowState->instanceId = date("YmdHis");
        $workflowState->startTime = date("YmdHis") . " 000";
        $workflowState->endTime = $workflowState->startTime;
        $workflowState->timeout = false;

        $simXmlFolder = $this->property[PROPERTY_SIMULATEDXMLDIR];
        $simXmlFile = $simXmlFolder . "/" . $workflowName . "_output.xml";
        $workflowState->result = file_get_contents($simXmlFile);            
        if ($workflowState->result === FALSE) {
            $this->logger->error("Szimulator XML output nem talalhato: " . $simXmlFile);
            $workflowState->completed = false;
        }
        else {
            $workflowState->completed = true;
        }            
        return $workflowState;
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
        $this->logger->debug("ping *** SZIMULATOR *** indul...");
        $this->logger->debug("ping  *** SZIMULATOR *** befejezödött.");
        return true;
    }
    
    /**
     * Tranzakció indítása. 
     */
    function startWorkflowSynch($workflowName, $inputXml) {
        return $this->getSimulatedWorkflowState($workflowName, $inputXml);
    }

}

?>