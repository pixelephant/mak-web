<?php

$phpversion = phpversion();

if (!defined('WEBSHOP_LIB_DIR')) define('WEBSHOP_LIB_DIR', dirname(__FILE__) . '/../..');
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/WebShopService.php');
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/model/WorkflowState.php');

define('PROPERTY_SIMULATEDXMLDIR', "otp.webshop.SIMULATED_XML_DIR"); 

/**
 * WebShop PHP szimul�tor - Fizet�fel�let Banki oldal�nak szimul�l�sa.
 *
 * A WebShop-ok r�sz�re k�sz�tett PHP alkalmaz�s csomag r�sze. 
 * Ez az alkalmaz�s csup�n szimul�lja az OTP Bank rendszer�nek megfelel� WebShop
 * folyamat-h�v�s�t: 
 * - ping 
 * - tranzakci� azonos�t� gener�l�s 
 * - h�romszerepl�s fizet�si folyamat ind�t�sa 
 * - k�tszerepl�s fizet�si folyamat ind�t�sa 
 * - tranzakci� adatok, tranzakci� st�tusz lek�rdez�se
 * - k�tl�pcs�s fizet�s lez�r�s
 *
 * A fenti szolg�ltat�sok az OTP MWAccess fel�let h�v�s�t csup�n szimul�lj�k, az egyes
 * k�r�sekre adand� v�laszokat ugyanis f�jlb�l olvass�k ki. A Banki fel�let nem ker�l
 * megsz�l�t�sra.
 * 
 * A f�jlok elnevez�si konvenci�j�nak a [tranzakci�nev]_output.xml kell lenni,
 * ahol a [tranzakci�nev] lehet WEBSHOPTRANZAZONGENERALAS, 
 * WEBSHOPTRANZAKCIOLEKERDEZES, WEBSHOPFIZETES, WEBSHOPFIZETESKETSZEREPLOS 
 * �s WEBSHOPFIZETESLEZARAS.  
 * A k�nyvt�rat, melyben ezek a f�jlok elhelyezend?k, a konfigur�ci�s �llom�ny
 * otp.webshop.SIMULATED_XML_DIR bejegyz�s�ben kell megadni, k�vetve a szok�sos
 * el�r�si �tvonal megad�si szab�lyokat.
 * 
 * @version 3.3.1
 * @author Bodn�r Imre / IQSYS
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
    * @desc Szimul�lt WorkflowState el��ll�t�sa.
    * A result tartalma f�jlb�l ker�l beolvas�sra,
    * mely f�jl neve a 
    * PROPERTY_SIMULATEDXMLDIR + "/" + $workflowName + "_output.xml";
    * lesz.
    * A Banki tranzakci� azonos�t� az aktu�lis id� alapj�n gener�lt �rt�k.
    * 
    * @return WorkflowState szimul�lt v�lasz.
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
     * @desc A banki fel�let Ping szolg�ltat�s�nak megh�v�sa. 
     * Mivel tranzakci� ind�t�s nem t�rt�nik, a sikeres ping
     * eset�n sem garant�lt az, hogy az egyes fizet�si tranzakci�k
     * sikeresen el is ind�that�k -  csup�n az biztos, hogy a
     * h�l�zati architekt�r�n kereszt�l sikeresen el�rhet� a
     * banki fel�let. 
     * 
     * Digit�lis al��r�s nem k�pz�dik.
     * 
     * @return boolean true sikeres ping-et�s eset�n, egy�bk�nt false.
     */
    function ping() {
        $this->logger->debug("ping *** SZIMULATOR *** indul...");
        $this->logger->debug("ping  *** SZIMULATOR *** befejez�d�tt.");
        return true;
    }
    
    /**
     * Tranzakci� ind�t�sa. 
     */
    function startWorkflowSynch($workflowName, $inputXml) {
        return $this->getSimulatedWorkflowState($workflowName, $inputXml);
    }

}

?>