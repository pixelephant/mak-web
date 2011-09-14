<?php 

include '../../../lib/php/Wixel/gump.class.php';
include '../../../lib/php/class.db.php';
include '../../../lib/php/class.mak.php';

$main = new mak(false);

if(!isset($_POST['darab']) || !isset($_POST['valasz']) || !isset($_POST['kerdes'])){
	return FALSE;
}

$darab = $_POST['darab'];
$valasz = $_POST['valasz'];
$kerdes = $_POST['kerdes'];

echo $main->sorsolas($kerdes,$valasz,$darab);

$main->close();
?>