<?php

session_start();

include 'Wixel/gump.class.php';

include 'class.db.php';
include 'class.mak.php';

$main = new mak(false);

$autoselet = explode("/",$_POST['id']);

$evfolyam = $autoselet[0];
$lapszam = $autoselet[1];

$ae = $main->get_autoselet($evfolyam,$lapszam);

echo $ae[0]['embed_kod'];

$main->close();
?>