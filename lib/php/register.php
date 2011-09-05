<?php 

include 'Wixel/gump.class.php';

include 'class.db.php';
include 'class.mak.php';

$main = new mak(false);

$form = array();
$member = array();
$adatok = array();

parse_str($_POST['formData'], $form);
parse_str($_POST['memberData'], $member);

/*
 * Természetes személy regisztrációja
 */

if($form['registerRadio'] == 'nat'){

	$adatok['vezeteknev'] = $form['natFName'];
	$adatok['keresztnev'] = $form['natLName'];
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
	
	$adatok['kapcsolattarto_vezeteknev'] = $form['coCoFName'];
	$adatok['kapcsolattarto_keresztnev'] = $form['coCoLName'];
	
	$nev = $adatok['kapcsolattarto_vezeteknev'] . " " . $adatok['kapcsolattarto_keresztnev'] . " - " . $adatok['cegnev'];

}

if(strlen($form['phone']) == 10){
	$adatok['vezetekes_telefon'] = $form['phone'];
}

if(strlen($form['phone']) == 11){
	$adatok['mobil_telefon'] = $form['phone'];
}

$adatok['e_mail'] = $form['email'];
$adatok['jelszo'] = sha1($form['pass']);
$adatok['felhasznalonev'] = $form['email'];

if($form['memberRadio'] == 'new'){
	$a = $main->insert_felhasznalo($adatok);
}

if($form['memberRadio'] == 'old'){
	$cond['tagsagi_szam'] = $form['cardNum'];
	$cond['e_mail'] = $form['email'];
	$a = $main->update_felhasznalo($adatok,$cond);
}

if($a == 'Sikeres'){

/*
 * Siker esetén e-mail küldés
 */

}

echo strtolower($a);

$main->close();
?>	