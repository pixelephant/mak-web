<?php 

require 'Wixel/gump.class.php';
require 'class.db.php';
require 'class.mak.php';

$main = new mak();

$email = trim($_POST['email']);

if($email == ''){
	echo '<span class="error">Sikertelen feliratkozás!</span>';
	return false;
}

$b = $main->get_hirlevel_email($email);

//print_r($b);

if($b['count'] != 0){
	echo '<span class="success">Ön már korábban feliratkozott!</span>'; 
	return FALSE;
}

$a = $main->insert_hirlevel($email);

if($a == 'Sikeres'){
	echo '<span class="success">Sikeres feliratkozás!</span>';
}else{
	echo '<span class="error">Sikertelen feliratkozás!</span>';
}

$main->close();

?>