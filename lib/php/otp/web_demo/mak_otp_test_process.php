<?php
session_start();
ob_start();
require_once("../simpleshop/mak_otp_test_control.php");

$successPosResponseCodes = array(
                    "000", "00", "001", "002", "003", "004",
                    "005", "006", "007", "008", "009", "010");

if($_GET['paymentmethod'] == 'on'){
	if (array_key_exists("fizetesValasz", $_REQUEST)) {
		echo '1';
	    $a = processDirectedToBackUrl(true);
	    /*print_r($a);
	    echo $a->osszeg.' Ft<br />';
	    echo $a->shopMegjegyzes.'<br />';
	    echo $a->statuszKod;*/
	}
	else {
		echo '2';
	    process();
	}
}else{
	if (array_key_exists("fizetesValasz", $_REQUEST)) {
		echo '3';
	    processDirectedToBackUrl(true);
	    
	    print_r($_SESSION);
	    print_r($a);
	    echo $a->osszeg.' Ft<br />';
	    echo $a->shopMegjegyzes.'<br />';
	    //echo $a->statuszKod.'<br />';
	    
	    if(in_array($a->posValaszkod,$successPosResponseCodes)){
	    	//header('Location: segelyszolgalat');
	    	echo 'Sikeres';
	    }else{
	    		echo 'Sikertelen';
	    }
	}else{
		//echo '4';
		echo 'Egy�b fizet�si m�d';
	}
}

ob_end_flush();
?>