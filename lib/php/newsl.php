<?php 

require 'Wixel/gump.class.php';
require 'class.db.php';
require 'class.mak.php';

$main = new mak();

$email = trim($_POST['email']);

if($email == ''){
	return false;
}

echo $main->insert_hirlevel($email);

$main->close();

?>