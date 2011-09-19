<?php 

include 'Wixel/gump.class.php';

include 'class.db.php';
include 'class.mak.php';

session_start();
$main = new mak(false);

if($_POST['action'] == 'brandType'){

	$brand = trim($_POST['brand']);

	$cond['mak_marka.sap_kod'] = $brand;

	if($brand != ''){
		$tipus = $main->get_gyartmany($cond);
	}
	
	if($tipus !== FALSE){
		unset($tipus['count']);
		echo json_encode($tipus);
		return TRUE;
	}else{
		echo 'sikertelen';
		return FALSE;
	}

}else{
	$autoklub_email = 'info@autoklub.hu';

	$form = array();
	$member = array();
	$adatok = array();
	$fizetes = array();
	
	parse_str($_POST['editformData'], $form);
	
	$form = GUMP::sanitize($form);
	
	/*
	 * Természetes személy regisztrációja
	 */
	
	if(!empty($form)){
	
		if($form['registerRadio'] == 'nat'){
		
			$adatok['vezeteknev'] = $form['natFName'];
			$adatok['keresztnev'] = $form['natLName'];
			$adatok['allando_irsz'] = $form['natZip'];
			$adatok['allando_helyseg'] = $form['natCity'];	
			
			$space = strrpos($form['natAddress']," ");
			
			$adatok['allando_kozterulet'] = substr($form['natAddress'],0,$space);
			$adatok['allando_hazszam'] = substr($form['natAddress'],$space);
					
			$nev = $adatok['vezeteknev'] . " " . $adatok['keresztnev'];
		}
		
		/*
		 * Cég regisztrációja
		 */
		
		if($form['registerRadio'] == 'co'){
		
			$adatok['cegnev'] = $form['coName'];
			$adatok['allando_irsz'] = $form['coZip'];
			$adatok['allando_helyseg'] = $form['coCity'];	
			
			$space = strrpos($form['coAddress']," ");
			
			$adatok['allando_kozterulet'] = substr($form['coAddress'],0,$space);
			$adatok['allando_hazszam'] = substr($form['coAddress'],$space);
			
			$adatok['kapcsolattarto_vezeteknev'] = $form['coCoFName'];
			$adatok['kapcsolattarto_keresztnev'] = $form['coCoLName'];
			
			$nev = $adatok['kapcsolattarto_vezeteknev'] . " " . $adatok['kapcsolattarto_keresztnev'] . " - " . $adatok['cegnev'];
		
		}
		
		$adatok['elso_forgalom'] = $form['firstDate'];
		$adatok['gyartasi_ev'] = $form['manufYear'];
		$adatok['gyartmany_sap'] = $form['brand'];
		$adatok['tipus_sap'] = $form['type'];
		
		if($form['licensePlate'] != ''){
			$adatok['rendszam'] = str_replace("-","",$form['licensePlate']);
		}
		
		if($form['email'] != ''){
			$adatok['e_mail'] = $form['email'];
		}
		
		if($form['pass'] != ''){
			$adatok['jelszo'] = sha1($form['pass']);
		}
		
		
		if(!isset($_SESSION['user_id']) || $_SESSION['user_id'] == ''){
			return FALSE;
		}else{
			$cond['id'] = $_SESSION['user_id'];
		}
		
		$cond['e_mail'] = $form['id_mail'];
		
		$valasz = $main->update_felhasznalo($adatok, $cond);
	
		if($valasz == 'Sikeres'){
		
			/*
			 * Siker esetén e-mail küldés
			 */
	/*		
			require_once("phpmailer/phpmailer.inc.php");
			
			$mail = new PHPMailer();
			
			$link = 'http://www.pixelephant.hu/projects/on-going/mak/regisztraciomegerositese?email=' . $adatok['e_mail'] . '&azonosito=' . sha1(sha1($adatok['e_mail']) . $adatok['jelszo']);
			
			//$mail->IsSMTP(); // SMTP használata
			$mail->From = "adatvaltoztatas@autoklub.hu";
			$mail->FromName = "Magyar Autóklub weboldala";
			//$mail->Host = "smtp1.site.com;smtp2.site.com";  // SMTP szerverek címe
			$mail->AddAddress($adatok['e_mail'], $nev);
			$mail->AddReplyTo($autoklub_email, "Magyar Autóklub");
			$mail->WordWrap = 50;
			
			$mail->IsHTML(true);    // HTML e-mail
			$mail->Subject = "Magyar Autóklub - sikeres adatváltoztatás";
			$mail->Body = 'Sikeresen megváltoztatta adatait weboldalunkon.';
			
			if($mail->Send() === FALSE){
				$valasz = 'Sikertelen e-mail küldés!';
			}
		
		}else{
			$valasz = 'Sikertelen frissítés!';*/
		}
	
	}
	
	echo strtolower($valasz);
}

$main->close();
?>