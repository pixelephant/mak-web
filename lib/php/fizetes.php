<?php 

require 'Wixel/gump.class.php';
require 'class.db.php';
require 'class.mak.php';

session_start();

$main = new mak(false);

$main->close();

?>