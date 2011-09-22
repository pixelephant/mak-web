<?php
//error_reporting(0);
session_start();
require_once("../simpleshop/mak_otp_test_control.php");
include_once '../../class.db.php';
include_once '../../class.mak.php';

$successPosResponseCodes = array(
                    "000", "00", "001", "002", "003", "004",
                    "005", "006", "007", "008", "009", "010");

if($_GET['paymentmethod'] == 'on'){
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
		processDirectedToBackUrl(true);
	    //$a = processDirectedToBackUrl(true);
	    print_r($a);
	    echo $a->osszeg.' Ft<br />';
	    echo $a->shopMegjegyzes.'<br />';
	    echo $a->statuszKod.'<br />';	    
	    
	    $main = new mak(true);
	    
	    if(in_array($a->posValaszkod,$successPosResponseCodes)){
	    	//echo 'Sikeres';
	    	$cond['id'] = $_SESSION['user_id'];
	    	$adat['statusz'] = '01';
	    	$adat['befizetes_datuma'] = date("Y-m-d");
	    	$adat['befizetett_osszeg'] = $a->osszeg;
	    	
	    	echo $main->update_felhasznalo($adat,$cond);
	    }else{
	    	echo 'Sikertelen';
	    }
	    
	    
	}else{
		//echo '4';
		echo 'Egyéb fizetési mód';
	}
}

?>