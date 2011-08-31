<?php 

require 'Wixel/gump.class.php';
require 'class.db.php';
require 'class.mak.php';

$main = new mak();

$time = $_POST['time'];
$email = $_POST['loginEmail'];
$pass = $_POST['loginPassword'];

$pass_enc = sha1(sha1('zoltan').$time);

if($email == 'zoltan@autoklub.hu' && $pass_enc==$pass){
	echo 'Sikeres';
}else{
	echo 'Sikertelen';
}

$main->close();


?>