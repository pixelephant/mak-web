<?php 
session_start();

require 'Wixel/gump.class.php';
require 'class.db.php';
require 'class.mak.php';

$main = new mak(false);

if(isset($_POST['logout'])){

	session_unset();
	session_destroy();
	$_SESSION = array();
	
	if(isset($_COOKIE['user_id']) && isset($_COOKIE['keresztnev']) && isset($_COOKIE['tagsag'])){
		$minuszEgyHonap = -60 * 60 * 24 * 30 + time();
		setcookie('user_id','',$minuszEgyHonap);
		setcookie('keresztnev','',$minuszEgyHonap);
		setcookie('tagsag','',$minuszEgyHonap);
	}
	
	echo 'sikeres';

}else{

	$time = $_POST['time'];
	$email = $_POST['email'];
	$pass = $_POST['phash'];
	
	$adat = $main->get_login($email);
	
	$pass_enc = sha1($adat[0]['jelszo'].$time);
	
	if($pass_enc == $pass){
		$_SESSION['user_id'] = $adat[0]['id'];
		if($adat[0]['nem'] == 'C'){
			$_SESSION['keresztnev'] = $adat[0]['kapcsolattarto_keresztnev'];
		}else{
			$_SESSION['keresztnev'] = $adat[0]['keresztnev']; 
		}
		$_SESSION['tagsag'] = $adat[0]['tagtipus'];
		
		if(isset($_POST['remember']) && $_POST['remember'] == 'checked'){
			$egyHonap = 60 * 60 * 24 * 30 + time();
			setcookie('user_id',$_SESSION['user_id'],$egyHonap);
			setcookie('keresztnev',$_SESSION['keresztev'],$egyHonap);
			setcookie('tagsag',$_SESSION['tagsag'],$egyHonap);
		}
		
		echo 'sikeres';
	}else{
		echo 'sikertelen';
	}

}
$main->close();
?>