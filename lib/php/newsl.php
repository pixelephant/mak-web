<?php 

require 'Wixel/gump.class.php';
require 'class.db.php';
require 'class.mak.php';

$main = new mak();

$email = trim($_POST['email']);

if($email == ''){
	return false;
}

$a = $main->insert_hirlevel($email);

if($a == 'Sikeres'){
	echo '<span class="success">Sikeres feliratkozás!</span>';
}else{
	echo '<span class="error">Sikertelen feliratkozás!</span>';
}

$main->close();

?>