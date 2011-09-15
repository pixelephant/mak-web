<?php 

include 'Wixel/gump.class.php';

include 'class.db.php';
include 'class.mak.php';

$main = new mak(false);

$cond['e_mail'] = trim($_POST['email']);

$regelt = $main->get_felhasznalo($cond,'regisztracio_ideje');
		
if($regelt[0]['regisztracio_ideje'] != '0000-00-00 00:00:00'){
	echo 'false';
}else{
	echo 'true';
}

$main->close();

?>