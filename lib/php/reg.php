<?php 

require 'Wixel/gump.class.php';
require 'class.db.php';
require 'class.mak.php';

$main = new mak(false);

/*
 * Regisztráció megerősítése
 */

if(isset($_POST)){

	//A függvény gondoskodik a szükséges biztonságról, így átadható a teljes $_POST tömb
	$a = $main->get_adatok_regisztraciohoz($_POST);
	
	//Mivel egy felhasználó felel meg a kritériumoknak, elég a tömb 0. elemét encode-olni
	echo json_encode($a[0]);

}

$main->close();

?>