<?php

session_start();

include 'Wixel/gump.class.php';
include 'class.db.php';
include 'class.mak.php';

$main = new mak(false);

$valasz = $_POST['valasz'];
$valasz = substr($valasz,-1);

//echo $valasz;

echo $main->poll($valasz);

$main->close();

?>