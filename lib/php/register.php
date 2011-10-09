<?php 

include 'Wixel/gump.class.php';

include 'class.db.php';
include 'class.mak.php';

$autoklub_email = 'info@autoklub.hu';

session_start();

$main = new mak(false);

$form = array();
$member = array();
$adatok = array();
$fizetes = array();

parse_str($_POST['formData'], $form);
parse_str($_POST['memberData'], $member);
parse_str($_POST['paymentData'], $fizetes);
parse_str($_POST['komfortData'], $komfort);
parse_str($_POST['standardData'], $standard);

$form = GUMP::sanitize($form);
$member = GUMP::sanitize($member);
$fizetes = GUMP::sanitize($fizetes);
$komfort = GUMP::sanitize($komfort);
$standard = GUMP::sanitize($standard);

/*
 * Természetes személy regisztrációja
 */

if(!empty($form)){

	if($form['registerRadio'] == 'nat'){
	
		$adatok['vezeteknev'] = ucwords($form['natFName']);
		$adatok['keresztnev'] = ucwords($form['natLName']);
		$adatok['nem'] = $form['natGender'];
		$adatok['szuletesi_datum'] = $form['natDate'];
		$adatok['allando_irsz'] = $form['natZip'];
		$adatok['allando_helyseg'] = $form['natCity'];	
		
		$adatok['allando_kozterulet'] = $form['natAddress'];
		$adatok['allando_kozterulet_jellege'] = $form['natAddressType'];
		$adatok['allando_hazszam'] = $form['natAddressNumber'];
		$adatok['allando_epulet'] = $form['natAddressBuilding'];
		$adatok['allando_lepcsohaz'] = $form['natAddressStairs'];
		$adatok['allando_emelet'] = $form['natAddressLevel'];
		$adatok['allando_ajto'] = $form['natAddressDoor'];
				
		$nev = $adatok['vezeteknev'] . " " . $adatok['keresztnev'];
	}
	
	/*
	 * Cég regisztrációja
	 */
	
	if($form['registerRadio'] == 'co'){
	
		$adatok['cegnev'] = $form['coName'];
		$adatok['alapitas_eve'] = $form['coDate'];
		$adatok['allando_irsz'] = $form['coZip'];
		$adatok['allando_helyseg'] = $form['coCity'];	
		
		$adatok['allando_kozterulet'] = $form['coAddress'];
		$adatok['allando_kozterulet_jellege'] = $form['coAddressType'];
		$adatok['allando_hazszam'] = $form['coAddressNumber'];
		$adatok['allando_epulet'] = $form['coAddressBuilding'];
		$adatok['allando_lepcsohaz'] = $form['coAddressStairs'];
		$adatok['allando_emelet'] = $form['coAddressLevel'];
		$adatok['allando_ajto'] = $form['coAddressDoor'];
		
		$adatok['kapcsolattarto_vezeteknev'] = ucwords($form['coCoName']);
		//$adatok['kapcsolattarto_keresztnev'] = $form['coCoLName'];
		
		$adatok['kapcsolattarto_email'] = $form['coCoMail'];
		$adatok['kapcsolattarto_telefon'] = $form['coCoPhone'];
		
		//$nev = $adatok['kapcsolattarto_vezeteknev'] . " " . $adatok['kapcsolattarto_keresztnev'] . " - " . $adatok['cegnev'];
		$nev = $adatok['kapcsolattarto_vezeteknev'] . " - " . $adatok['cegnev'];
	
	}
	
	/*
	if(strlen($form['phone']) == 10){
		$adatok['vezetekes_telefon'] = $form['phone'];
	}
	
	if(strlen($form['phone']) == 11){
		$adatok['mobil_telefon'] = $form['phone'];
	}
	*/
	
	$adatok['e_mail'] = $form['email'];
	$adatok['jelszo'] = sha1($form['pass']);
	$adatok['felhasznalonev'] = $form['email'];
	
	$adatok['dijkategoria'] = 0;
	
	if($form['memberRadio'] == 'new'){
		$valasz = $main->insert_felhasznalo($adatok);
	}
	
	if($form['memberRadio'] == 'old'){
	
		$cond['tagsagi_szam'] = $form['cardNum'];
		$cond['e_mail'] = $form['email'];
		
		$valasz = $main->update_felhasznalo($adatok,$cond);
	}
	
	if($valasz == 'Sikeres'){
	
		/*
		 * Siker esetén e-mail küldés
		 */
		
		require_once("phpmailer/phpmailer.inc.php");
		
		$mail = new PHPMailer();
		
		$link = 'http://sfvm104.serverfarm.hu/mak/regisztraciomegerositese?email=' . $adatok['e_mail'] . '&azonosito=' . sha1(sha1($adatok['e_mail']) . $adatok['jelszo']);
		
		//$mail->IsSMTP(); // SMTP használata
		$mail->CharSet = 'UTF-8';
		$mail->From = "nevalaszolj@autoklub.hu";
		$mail->FromName = "Magyar Autóklub weboldala";
		//$mail->Host = "smtp1.site.com;smtp2.site.com";  // SMTP szerverek címe
		$mail->AddAddress($adatok['e_mail'], $nev);
		$mail->AddReplyTo($autoklub_email, "Magyar Autóklub");
		$mail->WordWrap = 50;
		
		$mail->IsHTML(true);    // HTML e-mail
		$mail->Subject = "Magyar Autóklub - sikeres regisztráció a weboldalra";
		$mail->Body = 'Köszönjük, hogy regisztrált weboldalunkra! <br />Kérjük, az alábbi <a href="' . $link . '">linkre kattintva</a> erősítse meg a regisztrációt!';
		
		if($mail->Send() === FALSE){
			$valasz = 'Sikertelen e-mail küldés!';
		}
	
	}

}else{

	if(!isset($_POST['email']) || $_POST['email'] == ''){
		$valasz = 'sikertelen';
		return FALSE;
	}
	
	$adatok = array();
	
	$dijkategoria['diszkontMember'] = '2';
	$dijkategoria['standardMember'] = '3';
	$dijkategoria['komfortMember'] = '4';
	
	$fizetesimetodus['cheque']  = '07';
	$fizetesimetodus['transfer']  = '07';
	$fizetesimetodus['card']  = '01';
	
	$fizetesNev['cheque'] = 'Csekk';
	$fizetesNev['transfer'] = 'Átutalás';
	$fizetesNev['card'] = 'Bankkártya';
	
	$cond['e_mail'] = $_POST['email'];

	$adatok['belepes_datuma'] = date("Y-m-d");
	$adatok['dijkategoria'] = $dijkategoria[$member['membershipRadio']];
	$adatok['statusz'] = $fizetesimetodus[$fizetes['paymentmethodRadio']];
	$adatok['tagtipus'] = 1;
	
	if($adatok['dijkategoria'] == 4){
		$adatok['rendszam'] = $komfort['komfortPlateHuInput'];
		$adatok['gyartasi_ev'] = date("Y") - $komfort['carAge'];
		$adatok['tipus_sap'] = $komfort['type'];
		$adatok['gyartmany_sap'] = $komfort['brand'];
		
		$_SESSION['chassis'] = $komfort['chassis'];
	}
	
	if($adatok['dijkategoria'] == 3 && isset($standard['plateTypeRadio'])){
		if($standard['plateTypeRadio'] == 'standardPlateHu'){
			$adatok['rendszam'] = $standard['standardPlateHuInput'];
		}else{
			$adatok['rendszam'] = $standard['standardPlateFoInput'];
		}
	}
	
	$valasz = $main->update_felhasznalo($adatok,$cond);

	$_SESSION['lastEmail'] = $cond['e_mail'];
	
	/*
	 * Fizetési mód értesítő
	 */
	
	require_once("phpmailer/phpmailer.inc.php");
		
	$mail = new PHPMailer();
	
	$link = 'http://sfvm104.serverfarm.hu/mak/regisztraciomegerositese?email=' . $adatok['e_mail'] . '&azonosito=' . sha1(sha1($adatok['e_mail']) . $adatok['jelszo']);
	
	//$mail->IsSMTP(); // SMTP használata
	$mail->CharSet = 'UTF-8';
	$mail->From = "regisztracio@autoklub.hu";
	$mail->FromName = "Magyar Autóklub weboldala";
	//$mail->Host = "smtp1.site.com;smtp2.site.com";  // SMTP szerverek címe
	$mail->AddAddress('0antalbalazs0@gmail.com','Infó');
	$mail->AddReplyTo($autoklub_email, "Magyar Autóklub");
	$mail->WordWrap = 50;
	
	$mail->IsHTML(true);    // HTML e-mail
	$mail->Subject = "Magyar Autóklub - fizetési igény";
	$mail->Body = 'Az alábbi azonosítóval rendelkező felhasználó: ' . $cond['e_mail'] . '<br />' . ucfirst(str_replace("Member","",$member['membershipRadio'])) . ' tagságának kiegyenlítésére az alábbi fizetési módot választotta: ' . $fizetesNev[$fizetes['paymentmethodRadio']];
	
	if($mail->Send() === FALSE){
		$valasz = 'Sikertelen e-mail küldés!';
	}

}

echo strtolower($valasz);

$main->close();
?>