<?php

/**
* @desc A banki SOAP fel�let startWorkflowSnyc tranzakci� ind�t�s 
* szolg�ltat�s�nak visszat�r�si �rt�k�t reprezent�l� objektum.
* 
* Az NuSoap haszn�lata miatt ker�lt kialak�t�sra, ugyanis az ottani SOAP
* kliens nem objektumk�nt adja vissza a szolg�ltat�s eredm�ny�t,
* hanem asszociat�v t�mbk�nt. Ezt a t�mb�t lehet megadni az objektum
* egyik konstruktor�nak.
* 
* @version 3.3.1
* @author Bodn�r Imre (c) IQSYS Rt.
*/
class WorkflowState {

    var $completed;
    var $timeout;
    var $startTime;
    var $endTime;
    var $result;
    var $instanceId;
    var $templateName;

    /**
    * @desc Asszociat�v t�mb bet�lt�se WorkflowState objektumba.
    * 
    * @param array $stateAsArray bet�ltend� asszociat�v t�mb
    */
    function WorkflowState($stateAsArray) {
        if (is_null($stateAsArray)) return;
        
        $this->completed = $stateAsArray['completed'];
        $this->timeout = $stateAsArray['timeout'];
        $this->startTime = $stateAsArray['startTime'];
        $this->endTime = $stateAsArray['endTime'];
        $this->result = $stateAsArray['result'];
        $this->instanceId = $stateAsArray['instanceId'];
        $this->templateName = $stateAsArray['templateName'];
    }

}