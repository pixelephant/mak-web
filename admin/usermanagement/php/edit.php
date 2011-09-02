<?php 

include '../../../lib/php/Wixel/gump.class.php';
include '../../../lib/php/class.db.php';
include '../../../lib/php/class.mak.php';

/*
 * Melyik mező azonosítja a rekordot
 */
$id = 'tagsagi_szam';

$main = new mak(false);

if($_POST['oper'] == 'edit'){

	/*
	 * Editálás
	 */
	
	$cond[$id] = trim($_POST['id']); 
	
	$adatok = $_POST;
	unset($adatok['oper']);
	unset($adatok['id']);
	
	$a = $main->update_felhasznalo($adatok,$cond);
	
	echo $a;
}

if($_POST['oper'] == 'add'){

	/*
	 * Új felhasználó hozzáadása
	 */

	 
	$adatok = $_POST;
	unset($adatok['oper']);
	unset($adatok['id']);
	
	$a = $main->insert_felhasznalo($adatok);
	
	echo $a;

}

?>
