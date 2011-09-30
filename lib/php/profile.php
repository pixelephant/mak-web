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
			
			$adatok['allando_kozterulet'] = $form['natAddress'];
			$adatok['allando_kozterulet_jellege'] = $form['natAddressType'];
			$adatok['allando_hazszam'] = $form['natAddressNumber'];
			$adatok['allando_epulet'] = $form['natAddressBuilding'];
			$adatok['allando_lepcsohaz'] = $form['natAddressStairs'];
			$adatok['allando_emelet'] = $form['natAddressLevel'];
			$adatok['allando_ajto'] = $form['natAddressDoor'];

			$adatok['levelezesi_irsz'] = $form['natZipMailing'];
			$adatok['levelezesi_helyseg'] = $form['natCityMailing'];	
			
			$adatok['levelezesi_kozterulet'] = $form['natAddressMailing'];
			$adatok['levelezesi_kozterulet_jellege'] = $form['natAddressTypeMailing'];
			$adatok['levelezesi_hazszam'] = $form['natAddressMailingNumber'];
			$adatok['levelezesi_epulet'] = $form['natAddressMailingBuilding'];
			$adatok['levelezesi_lepcsohaz'] = $form['natAddressMailingStairs'];
			$adatok['levelezesi_emelet'] = $form['natAddressMailingLevel'];
			$adatok['levelezesi_ajto'] = $form['natAddressMailingDoor'];
				
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
			
			$adatok['allando_kozterulet'] = $form['coAddress'];
			$adatok['allando_kozterulet_jellege'] = $form['coAddressType'];
			$adatok['allando_hazszam'] = $form['coAddressNumber'];
			$adatok['allando_epulet'] = $form['coAddressBuilding'];
			$adatok['allando_lepcsohaz'] = $form['coAddressStairs'];
			$adatok['allando_emelet'] = $form['coAddressLevel'];
			$adatok['allando_ajto'] = $form['coAddressDoor'];
			
			$adatok['levelezesi_irsz'] = $form['coZipMailing'];
			$adatok['levelezesi_helyseg'] = $form['coCityMailing'];	
			
			$adatok['levelezesi_kozterulet'] = $form['coAddressMailing'];
			$adatok['levelezesi_kozterulet_jellege'] = $form['coAddressTypeMailing'];
			$adatok['levelezesi_hazszam'] = $form['coAddressMailingNumber'];
			$adatok['levelezesi_epulet'] = $form['coAddressMailingBuilding'];
			$adatok['levelezesi_lepcsohaz'] = $form['coAddressMailingStairs'];
			$adatok['levelezesi_emelet'] = $form['coAddressMailingLevel'];
			$adatok['levelezesi_ajto'] = $form['coAddressMailingDoor'];
				
			$adatok['kapcsolattarto_vezeteknev'] = $form['coCoFName'];
			//$adatok['kapcsolattarto_keresztnev'] = $form['coCoLName'];
			
			$nev = $adatok['kapcsolattarto_vezeteknev'] . " " . $adatok['kapcsolattarto_keresztnev'] . " - " . $adatok['cegnev'];
		
		}
		
		$adatok['elso_forgalom'] = $form['firstDate'];
		$adatok['gyartasi_ev'] = $form['manufYear'];
		$adatok['gyartmany_sap'] = $form['brand'];
		$adatok['tipus_sap'] = $form['type'];
		$adatok['forgalmi_engedely'] = $form['regCert'];
		$adatok['muszaki_vizsga'] = $form['techExp'];
		
		if($form['licensePlate'] != ''){
			$adatok['rendszam'] = str_replace("-","",$form['licensePlate']);
			$adatok['rendszam_valtas'] = date("Y-m-d");
		}
		
		$adatok['elso_forgalom_2'] = $form['firstDate2'];
		$adatok['gyartasi_ev_2'] = $form['manufYear2'];
		$adatok['gyartmany_sap_2'] = $form['brand2'];
		$adatok['tipus_sap_2'] = $form['type2'];
		$adatok['forgalmi_engedely_2'] = $form['regCert2'];
		$adatok['muszaki_vizsga_2'] = $form['techExp2'];
		
		if($form['licensePlate2'] != ''){
			$adatok['rendszam_2'] = str_replace("-","",$form['licensePlate2']);
		}
		
		if($form['email'] != ''){
			$adatok['e_mail'] = $form['email'];
			$adatok['felhasznalonev'] = $form['email'];
		}
		
		$adatok['e_mail_2'] = $form['email2'];
		
		$adatok['vezetekes_telefon'] = $form['phone'];
		$adatok['mobil_telefon'] = $form['mobile'];
		
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