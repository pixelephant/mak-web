<?php

<<<<<<< HEAD
echo '[{"choice":"choice0","votes":"2183"},{"choice":"choice1","votes":"2345"},{"choice":"choice2","votes":"2261"},{"choice":"choice3","votes":"1949"},{"choice":"choice4","votes":"1852"}]';

=======
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
>>>>>>> 6d06f650413e69a7ab3e98020d0ba69384d32ded
?>