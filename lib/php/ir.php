<?php 

require 'Wixel/gump.class.php';
require 'class.db.php';
require 'class.mak.php';

$main = new mak();

$irsz = $main->get_varos_irsz((int)$_POST['num']);

if($irsz['count'] > 0){
	echo $irsz[0]['varos'];
}

$main->close();

?>