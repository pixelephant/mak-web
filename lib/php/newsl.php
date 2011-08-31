<?php 

require 'Wixel/gump.class.php';
require 'class.db.php';
require 'class.mak.php';

$main = new mak();

$email = $_POST['email'];

echo $main->insert_hirlevel($email);

$main->close();

?>