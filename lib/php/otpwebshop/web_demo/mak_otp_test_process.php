<?php
session_start();
require_once("../simpleshop/mak_otp_test_control.php");

$successPosResponseCodes = array(
                    "000", "00", "001", "002", "003", "004",
                    "005", "006", "007", "008", "009", "010");

if($_GET['fizetesi_mod'] == 'bank_kartya'){
	if (array_key_exists("fizetesValasz", $_REQUEST)) {
		//echo '1';
	    $a = processDirectedToBackUrl(true);
	    /*print_r($a);
	    echo $a->osszeg.' Ft<br />';
	    echo $a->shopMegjegyzes.'<br />';
	    echo $a->statuszKod;*/
	}
	else {
		//echo '2';
	    process();
	}
}else{
	if (array_key_exists("fizetesValasz", $_REQUEST)) {
		//echo '3';
	    $a = processDirectedToBackUrl(true);
	    //print_r($a);
	    echo $a->osszeg.' Ft<br />';
	    echo $a->shopMegjegyzes.'<br />';
	    //echo $a->statuszKod.'<br />';
	    
	    if(in_array($a->posValaszkod,$successPosResponseCodes)){
	    	echo 'Sikeres';
	    }else{
	    		echo 'Sikertelen';
	    }
	}else{
		//echo '4';
		echo 'Egyéb fizetési mód';
	}
}

?>