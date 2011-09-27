<?php 

require 'Wixel/gump.class.php';
require 'class.db.php';
require 'class.mak.php';

session_start();

$main = new mak(false);

$tagsag['diszkontMember'] = 2;
$tagsag['standardMember'] = 3;
$tagsag['komfortMember'] = 4;

$mak_email = '0antalbalazs0@gmail.com';

parse_str($_POST['paymentData'], $fizetes);

$fizetes = GUMP::sanitize($fizetes);

$cond['id'] = $_SESSION['user_id'];

$col = 'ervenyesseg_datuma,tranzakcio_kodja,befizetes_datuma,tagsagi_szam,elonev,vezeteknev,keresztnev,nem,cegnev,';
$col .= 'levelezesi_irsz,levelezesi_helyseg,levelezesi_kozterulet,levelezesi_hazszam,allando_irsz,allando_helyseg,allando_kozterulet,allando_hazszam';

$felh = $main->get_felhasznalo($cond,$col);

if($felh[0]['tranzakcio_kodja'] == "2" && $felh[0]['befizetes_datuma'] == "0000-00-00" ){
	echo 'Sikertelen';
	return FALSE;
}

if($felh[0]['ervenyesseg_datuma'] != '0000-00-00'){
	$datum = explode("-",$felh[0]['ervenyesseg_datuma']);
	$data['ervenyesseg_datuma'] = ((int)$datum[0] + 1) . "-" . $datum[1] . "-" . $datum[2];
}else{
	$data['ervenyesseg_datuma'] = date("Y-m-d", strtotime("+1 year"));
}

$data['befizetett_osszeg'] = $fizetes['osszeg'];
$data['tranzakcio_kodja'] = '2';
$data['befizetes_datuma'] = '0000-00-00';

/*
 * Hosszabbítás
 */

if(isset($_POST['paymentData']) && !isset($_POST['memberData']) && $_POST['action'] == 'extend'){

	$valasz = $main->update_felhasznalo($data,$cond);
	
		/*
		 * Siker esetén e-mail küldés
		 */
		
		if($felh[0]['nem'] == 'C'){
			$nev = $felh[0]['cegnev'];
		}else{
			$nev = $felh[0]['elonev'] . " " . $felh[0]['vezeteknev'] . " " . $felh[0]['keresztnev'];
		}
		
		if($felh[0]['levelezesi_irsz'] == ''){
			$cim = $felh[0]['allando_irsz'] . " " . $felh[0]['allando_helyseg'] . " " . $felh[0]['allando_kozterulet'] . " " . $felh[0]['allando_hazszam'];
		}else{
			$cim = $felh[0]['levelezesi_irsz'] . " " . $felh[0]['levelezesi_helyseg'] . " " . $felh[0]['levelezesi_kozterulet'] . " " . $felh[0]['levelezesi_hazszam'];
		}
	
		require_once("phpmailer/phpmailer.inc.php");
		
		$mail = new PHPMailer();
		
		
		//$mail->IsSMTP(); // SMTP használata
		$mail->From = "weboldal@autoklub.hu";
		$mail->FromName = "Magyar Autóklub weboldala";
		//$mail->Host = "smtp1.site.com;smtp2.site.com";  // SMTP szerverek címe
		$mail->AddAddress($mak_email, 'MAK');
		$mail->AddReplyTo('noreply@mak.hu', "Magyar Autóklub");
		$mail->WordWrap = 50;
		
		$mail->IsHTML(true);    // HTML e-mail
		$mail->Subject = "Taghosszabbítás a weboldalon";
		$mail->Body = $nev . " ,címe: " . $cim;
		
		if($mail->Send() === FALSE){
			$valasz = 'Sikertelen e-mail küldés!';
		}
		
		echo $valasz;

}

/*
 * Upgrade
 */

if(isset($_POST['paymentData']) && isset($_POST['memberData']) && $_POST['action'] == 'level'){

	parse_str($_POST['memberData'], $member);

	$member = GUMP::sanitize($member);
	
	$data['dijkategoria'] = $tagsag[$member['membershipRadio']];

	$valasz = $main->update_felhasznalo($data,$cond);

		/*
		 * Siker esetén e-mail küldés
		 */
		
		if($felh[0]['nem'] == 'C'){
			$nev = $felh[0]['cegnev'];
		}else{
			$nev = $felh[0]['elonev'] . " " . $felh[0]['vezeteknev'] . " " . $felh[0]['keresztnev'];
		}
		
		if($felh[0]['levelezesi_irsz'] == ''){
			$cim = $felh[0]['allando_irsz'] . " " . $felh[0]['allando_helyseg'] . " " . $felh[0]['allando_kozterulet'] . " " . $felh[0]['allando_hazszam'];
		}else{
			$cim = $felh[0]['levelezesi_irsz'] . " " . $felh[0]['levelezesi_helyseg'] . " " . $felh[0]['levelezesi_kozterulet'] . " " . $felh[0]['levelezesi_hazszam'];
		}
	
		$tagtipus = ucfirst(str_replace("Member","",$member['membershipRadio']));
		
		require_once("phpmailer/phpmailer.inc.php");
		
		$mail = new PHPMailer();
		
		//$mail->IsSMTP(); // SMTP használata
		$mail->From = "weboldal@autoklub.hu";
		$mail->FromName = "Magyar Autóklub weboldala";
		//$mail->Host = "smtp1.site.com;smtp2.site.com";  // SMTP szerverek címe
		$mail->AddAddress($mak_email, 'MAK');
		$mail->AddReplyTo('noreply@mak.hu', "Magyar Autóklub");
		$mail->WordWrap = 50;
		
		$mail->IsHTML(true);    // HTML e-mail
		$mail->Subject = "Szintváltás a weboldalon";
		$mail->Body = $nev . " ,címe: " . $cim . ". Új tagsági szint: " . $tagtipus;
		
		if($mail->Send() === FALSE){
			$valasz = 'Sikertelen e-mail küldés!';
		}
		
		echo $valasz;
	
}

$main->close();

?>