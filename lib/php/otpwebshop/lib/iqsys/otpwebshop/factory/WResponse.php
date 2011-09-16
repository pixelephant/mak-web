<?php 

if (!defined('WEBSHOP_LIB_DIR')) define('WEBSHOP_LIB_DIR', dirname(__FILE__) . '/../..');

$phpversion = phpversion();
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/factory/WSAnswerFactory.php');
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/DefineConst.php');
require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/WebShopXmlUtils.php' . $phpversion{0});

/**
* A banki tranzakci� v�lasz�t reprezent�l� value object.
* Tartalmazza az ind�tott tranzakci�k bank oldali egyedi azonos�t�j�t,
* a v�lasz xml sz�veges �s DomDocument form�j�t, a v�lasz xml annak 
* feldolgoz�s�b�l nyert value object reprezent�ci�j�t, valamint a v�lasz-
* �zenetek list�j�t.
* 
* @author Bodn�r Imre
* @version 3.3.1
*/
class WResponse  {

    /***************
     * Folyamat-p�ld�ny bank oldali azonos�t�ja
     * 
     * @var string
     */
    var $instanceId = NULL;

    /***************
     * A v�lasz teljes �s eredeti sz�vege
     * 
     * @var string
     */
    var $response = NULL;

    /***************
     * A v�lasz xml teljes �s eredeti sz�veg�nek DOM-ja
     * 
     * @var DomDocument
     */
    var $responseDOM = NULL;

    /***************
     * A v�lasz xml value object form�ban
     * 
     * @var mixed
     */
    var $answerModel = NULL;

    /***************
     * A v�lasz feldolgoz�sa sor�n kinyert �zenetk�dok vektora.
     * Sikeres v�grehajt�s eset�n csak a 'SIKER' sz�veget tartalmazza,
     * hib�s lefut�s eset�n az egyes hibak�dokat.
     * 
     * @var array
     */
    var $messages = array();

    /***************
     * A v�lasz feldolgoz�sa sor�n kinyert hibak�dok vektora
     * Sikeres v�grehajt�s eset�n �res,
     * hib�s lefut�s eset�n az egyes hibak�dokat.
     * 
     * @var array
     */
    var $errors = array();
    
    /***************
     * A v�lasz feldolgoz�sa sor�n kinyert inform�ci�s �zenetk�dok vektora.
     * 
     * @var array
     */
    var $infos = array();

    /***************
     * Sikeres volt-e a tranzakci� v�grehajt�sa, azaz az �zenetk�dok 
     * list�ja tartalmazza-e a 'SIKER' sz�veget.
     * 
     * @var boolean
     */
    var $hasSuccessfulAnswer = NULL;
    
    /***************
     * V�grehajt�dott-e a tranzakci� �s rendelkez�sre �ll-e a v�laszadat.
     * Kommunik�ci�s, timeout vagy egy�b hiba eset�n false az �rt�ke
     * 
     * @var boolean
     */
    var $finished = NULL;
    
    /**
    * Konstruktor.
    * 
    * @param string $workflowname az ind�tott tranzakci� k�dja
    * @param WorkflowState $workflowState a banki SOAP fel�let v�lasz�nak
    *        bean reprezenz�ci�ja
    */
    function WResponse ($workflowname, $workflowState) {
        if (is_null($workflowState)) return;
        $this->instanceId = $workflowState->instanceId;
        $this->finished = ($workflowState->completed && ! $workflowState->timeout);

        if ($this->finished) {
            WebShopXmlUtils::parseOutputXml($workflowState->result, $this);
            $answerFactory = WSAnswerFactory::getAnswerFactory($workflowname);
            $this->answerModel = $answerFactory->load($this->responseDOM);
        }    
    }

    /**
    * @desc WResponse felt�lt�se value object alapj�n 
    */
    function loadAnswerModel($answerModel, $successful, $errorMsg = null) {
        $this->finished = true;
        $this->answerModel = $answerModel;
        $this->hasSuccessfulAnswer = $successful;
        if ($successful) {
            $this->messages[] = "SIKER";
        }
        else {
            if (!is_null($errorMsg)) {
                $this->errors[] = $errorMsg;
                $this->messages[] = $errorMsg;
            }
        }
    }
    
    /***************
     * Eld�nti, hogy a folyamat-p�ld�ny v�lasz�nak messagelist szekci�ja
     * tartalmaz-e hiba�zenetet.
     * Ha a folyamat nem termin�lt, vagy a v�lasz nem megszerezhet�, a v�lasz hamis.
     *
     * @return igaz, ha a hiba�zenetek list�ja nem �res
     */
    function hasErrors() {
        return count($this->messages) > 0;
    }

    /***************
     * A folyamat-p�ld�ny v�lasz�ban a messagelist szekci�nak elemzett 
     * list�j�nak lek�rdez�se. "Elemzett", mert a SIKER k�dot nem 
     * tartalmazza: sikeres lefut�s eset�n ez a lista �res.
     * 
     * @return array �zenetk�d lista
     */
    function getMessages() {
        return $this->messages;
    }
    
    /***************
     * A folyamat-p�ld�ny v�lasz�ban a messagelist szekci�nak elemzett 
     * list�j�nak lek�rdez�se. "Elemzett", mert a SIKER k�dot nem 
     * tartalmazza: sikeres lefut�s eset�n ez a lista �res.
     * 
     * @return array hibak�d lista
     */
    function getErrors() {
        return $this->errors;
    }

    /***************
     * A folyamat-p�ld�ny v�lasz�ban az infolist szekci�nak az elemz�s�t �s
     * bet�lt�s�t v�gz� met�dus.
     * 
     * @return array inform�ci�s �zenetk�d lista
     */
    function getInfos() {
        return $this->infos;
    }

    /***************
     * Igaz, ha a tranzakci�-fut�s befejez�d�tt.
     * Ha true, akkor a v�lasz lehet sikeres vagy hib�s lefut�s� is.
     * Ha  false, akkor kommunik�ci�s vagy egy�b hiba t�rt�nt a 
     * tranzakci� v�grehajt�sa vagy a v�lasz fogad�sa sor�n.
     *
     * @return boolean igaz, ha a tranzakt�l�s befejez�d�tt
     */
    function isFinished() {
        return $this->finished;
    }

    /***************
     * A folyamat-p�ld�ny sikeres befejez�d�s�nek meg�llap�t�sa
     * A folyamat sikeresen termin�lt, ha a v�lasz <messagelist> r�sz�ben szerepel
     * a SIKER �zenet.
     * Ha a folyamat nem termin�lt, vagy a v�lasz nem megszerezhet�, a v�lasz hamis.
     *
     * @return boolean a sikeress�g jelz�je
     */
    function isSuccessful()  {
        return $this->hasSuccessfulAnswer;
    }

    /***************
     * A folyamat-p�ld�ny banki oldali p�ld�ny-azonos�t�j�nak kiolvas�sa
     *
     * @return string p�ld�nyazonos�t� (null, ha nincs megszerezve a p�ld�ny)
     */
    function getInstanceId() {
        return $this->instanceId;
    }

    /***************
     * A v�grehajt�shoz tartoz� v�lasz xml, a megfelel� value object reprezent�ci�ban
     *
     * @return mixed a v�lasz bean kont�nerte
     */
    function getAnswer() {
        return $this->answerModel;
    }

    /***************
     * A v�grehajt�shoz tartoz� v�lasz xml, string reprezent�ci�ban
     *
     * @return string a v�lasz xml
     */
    function getResponse() {
        return $this->response;
    }

    /***************
     * A v�grehajt�shoz tartoz� v�lasz xml, DomDocument form�j�ban
     *
     * @return DomDoument a v�lasz 
     */
    function getResponseDOM() {
        return $this->responseDOM;
    }

}

?>