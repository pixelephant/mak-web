<?php 

require 'Wixel/gump.class.php';
require 'class.db.php';
require 'class.mak.php';

session_start();

$main = new mak(false);

if($_GET['status'] == 'success'){

	$adat['befizetes_datuma'] = date("Y-m-d");
	$adat['ervenyesseg_datuma'] = date("Y-m-d",strtotime("+1 year"));
	$adat['statusz'] = '01';
	
	$cond['id'] = $_SESSION['user_id'];
	
	$a = $main->update_felhasznalo($adat,$cond);

	
	
}

$main->close();

?>