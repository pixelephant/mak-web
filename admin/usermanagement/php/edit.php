<?php 

session_start();

include '../../../lib/php/Wixel/gump.class.php';
include '../../../lib/php/class.db.php';
include '../../../lib/php/class.mak.php';

if($_SESSION['admin_edit'] != 'true'){
	echo 'Nincs joga szerkeszteni!';
	return false;
}

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

/*
 * Törlés
 */

if($_POST['oper'] == 'del'){

	$adat['id'] = $_POST['id'];

	echo $main->delete_felhasznalo($adat);

}

/*
 * Nem szerkeszthető listázás
 */

if($_POST['action'] == 'getuser'){
	
	$cond['id'] = $_POST['id'];
	
	$a = $main->get_felhasznalo($cond);
	
	if($a === FALSE || $a['count'] == 0){
		echo 'Sikertelen';
	}else{
		$html = '';
		foreach($a[0] as $nev => $ertek){
			if($nev != 'jelszo'){
				$html .= ucfirst(str_replace("_"," ",$nev)) . ": " . $ertek . '<br />';
			}
		}
		
		echo $html;
	
	}

}

?>
