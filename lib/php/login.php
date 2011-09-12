<?php 
session_start();

require 'Wixel/gump.class.php';
require 'class.db.php';
require 'class.mak.php';

$main = new mak(false);

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
	echo 'sikeres';
}else{
	echo 'sikertelen';
}

$main->close();
?>