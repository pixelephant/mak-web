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

$form = GUMP::sanitize($form);
$member = GUMP::sanitize($member);
$fizetes = GUMP::sanitize($fizetes);

/*
 * Természetes személy regisztrációja
 */

if(!empty($form)){

	if($form['registerRadio'] == 'nat'){
	
		$adatok['vezeteknev'] = $form['natFName'];
		$adatok['keresztnev'] = $form['natLName'];
		$adatok['nem'] = $form['natGender'];
		$adatok['szuletesi_datum'] = $form['natDate'];
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
		$adatok['alapitas_eve'] = $form['coDate'];
		$adatok['allando_irsz'] = $form['coZip'];
		$adatok['allando_helyseg'] = $form['coCity'];	
		
		$space = strrpos($form['coAddress']," ");
		
		$adatok['allando_kozterulet'] = substr($form['coAddress'],0,$space);
		$adatok['allando_hazszam'] = substr($form['coAddress'],$space);
		
		$adatok['kapcsolattarto_vezeteknev'] = $form['coCoName'];
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
		$mail->From = "regisztracio@autoklub.hu";
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
	
	$valasz = $main->update_felhasznalo($adatok,$cond);

	$_SESSION['lastEmail'] = $cond['e_mail'];
	
	/*
	 * Fizetési mód értesítő
	 */
	
	require_once("phpmailer/phpmailer.inc.php");
		
	$mail = new PHPMailer();
	
	$link = 'http://sfvm104.serverfarm.hu/mak/regisztraciomegerositese?email=' . $adatok['e_mail'] . '&azonosito=' . sha1(sha1($adatok['e_mail']) . $adatok['jelszo']);
	
	//$mail->IsSMTP(); // SMTP használata
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