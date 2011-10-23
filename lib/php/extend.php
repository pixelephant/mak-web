<?php 

require 'Wixel/gump.class.php';
require 'class.db.php';
require 'class.mak.php';

require_once("phpmailer/phpmailer.inc.php");

session_start();

$main = new mak();

$mak_email = '0antalbalazs0@gmail.com';

if($_POST['action'] == 'extendMail'){
	
	$cond['id'] = $_SESSION['user_id'];
	
	$col = 'ervenyesseg_datuma,tranzakcio_kodja,befizetes_datuma,tagsagi_szam,elonev,vezeteknev,keresztnev,nem,cegnev,e_mail,';
	$col .= 'levelezesi_irsz,levelezesi_helyseg,levelezesi_kozterulet,levelezesi_hazszam,allando_irsz,allando_helyseg,allando_kozterulet,allando_hazszam';
	
	$felh = $main->get_felhasznalo($cond,$col);

	if($felh[0]['nem'] == 'C'){
		$nev = $felh[0]['cegnev'];
	}else{
		$nev = $felh[0]['elonev'] . " " . $felh[0]['vezeteknev'] . " " . $felh[0]['keresztnev'];
	}
	
	$mail = new PHPMailer();
	
	//$mail->IsSMTP(); // SMTP használata
	$mail->From = "weboldal@autoklub.hu";
	$mail->FromName = "Magyar Autóklub weboldala";
	//$mail->Host = "smtp1.site.com;smtp2.site.com";  // SMTP szerverek címe
	$mail->AddAddress($mak_email, 'MAK');
	$mail->AddReplyTo('noreply@mak.hu', "Magyar Autóklub");
	$mail->WordWrap = 50;
	
	$mail->IsHTML(true);    // HTML e-mail
	$mail->Subject = "Hosszabbítási probléma a weboldalon";
	$mail->Body = $nev . ", e-mail: " . $felh[0]['e_mail'] . ", id: " . $cond['id'];
	
	if($mail->Send() === FALSE){
		$valasz = 'sikertelen';
	}else{
		$valasz = 'sikeres';
	}
	
	echo $valasz;
	return FALSE;
}


$tagsag = array();
$tagsag['diszkontMember'] = '2';
$tagsag['standardMember'] = '3';
$tagsag['komfortMember'] = '4';

$fizetesNev['cheque'] = 'Csekk';
$fizetesNev['transfer'] = 'Átutalás';
$fizetesNev['card'] = 'Bankkártya';

parse_str($_POST['paymentData'], $fizetes);

$fizetes = GUMP::sanitize($fizetes);

if(!$fizetes['terms1'] == 'on' || !$fizetes['terms2'] == 'on'){
	echo 'Nem fogadta el a feltételeket!';
	return FALSE;
}

$cond['id'] = $_SESSION['user_id'];

$col = 'ervenyesseg_datuma,tranzakcio_kodja,befizetes_datuma,tagsagi_szam,elonev,vezeteknev,keresztnev,nem,cegnev,e_mail,';
$col .= 'levelezesi_irsz,levelezesi_helyseg,levelezesi_kozterulet,levelezesi_hazszam,allando_irsz,allando_helyseg,allando_kozterulet,allando_hazszam';

$felh = $main->get_felhasznalo($cond,$col);

if($felh[0]['tranzakcio_kodja'] == "2" && $felh[0]['befizetes_datuma'] == "0000-00-00" ){
	echo 'Sikertelen';
	return FALSE;
}

if($felh[0]['ervenyesseg_datuma'] == '0000-00-00' || $felh[0]['ervenyesseg_datuma'] < date("Y-m-d")){
	$data['ervenyesseg_datuma'] = date("Y-m-d", strtotime("+1 year"));
}else{
	$datum = explode("-",$felh[0]['ervenyesseg_datuma']);
	$data['ervenyesseg_datuma'] = ((int)$datum[0] + 1) . "-" . $datum[1] . "-" . $datum[2];
}

unset($_SESSION['lastEmail']);
if($fizetes['paymentmethodRadio'] == 'card'){
	$_SESSION['lastEmail'] = $felh[0]['e_mail'];
}

$data['befizetett_osszeg'] = $fizetes['osszeg'];
$data['tranzakcio_kodja'] = '2';
$data['befizetes_datuma'] = '0000-00-00';
$data['feltetelek_ido'] = date( 'Y-m-d H:i:s', strtotime('now'));
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
		$mail->Body = $nev . " ,címe: " . $cim . ", tagságának kiegyenlítésére az alábbi fizetési módot választotta: " . $fizetesNev[$fizetes['paymentmethodRadio']];
		
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
	$data['ervenyesseg_datuma'] = date("Y-m-d", strtotime("+1 year"));
	$data['feltetelek_ido'] = date( 'Y-m-d H:i:s', strtotime('now'));
	
	if($data['dijkategoria'] == '4'){
		parse_str($_POST['komfortData'], $komfort);
		
		$data['rendszam'] = $komfort['komfortPlateHuInput'];
		$data['alvazszam'] = $komfort['chassis'];
		$data['gyartasi_ev'] = date("Y") - $komfort['carAge'];
		$data['gyartmany_sap'] = $komfort['brand'];
		$data['tipus_sap'] = $komfort['type'];
	}
	
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
		$mail->Body = $nev . ", címe: " . $cim . ". Új tagsági szint: " . $tagtipus . ", tagságának kiegyenlítésére az alábbi fizetési módot választotta: " . $fizetesNev[$fizetes['paymentmethodRadio']];
		
		if($mail->Send() === FALSE){
			$valasz = 'Sikertelen e-mail küldés!';
		}
		
		echo $valasz;
	
		if($fizetes['terms3'] == 'on'){
			$a = $main->get_hirlevel_email($felh[0]['e_mail']);
			if($a['count'] == 0 || $a === false){
				$main->insert_hirlevel($felh[0]['e_mail'],$data['dijkategoria']);
			}
		}
		
}

$main->close();

?>