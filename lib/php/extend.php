<?php 

require 'Wixel/gump.class.php';
require 'class.db.php';
require 'class.mak.php';

session_start();

$main = new mak(false);

$tagsag['diszkontMember'] = 2;
$tagsag['standardMember'] = 3;
$tagsag['komfortMember'] = 4;

parse_str($_POST['paymentData'], $fizetes);

$fizetes = GUMP::sanitize($fizetes);

$cond['id'] = $_SESSION['user_id'];

$data['tranzakcio_kodja'] = '2';
$data['befizetes_datuma'] = '0000-00-00';

/*
 * Hosszabbítás
 */

if(isset($_POST['paymentData']) && !isset($_POST['memberData']) && $_POST['action'] == 'extend'){

	echo $main->update_felhasznalo($data,$cond);

}

/*
 * Upgrade
 */

if(isset($_POST['paymentData']) && isset($_POST['memberData']) && $_POST['action'] == 'level'){

	parse_str($_POST['memberData'], $member);

	$member = GUMP::sanitize($member);
	
	$data['dijkategoria'] = $tagsag[$member['membershipRadio']];

	echo $main->update_felhasznalo($data,$cond);

}

$main->close();

?>