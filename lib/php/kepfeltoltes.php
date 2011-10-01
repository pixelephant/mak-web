<?php 

include 'resizeimage.inc.php';

session_start();

if(($_FILES["file-upload"]["size"] / 1024 > 1) || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/pjpeg")){
	return FALSE;
}

$rimg=new RESIZEIMAGE($_FILES["file-upload"]["tmp_name"]); 
echo $rimg->error(); 
$rimg->resize_percentage(50); 
$rimg->close(); 

move_uploaded_file($rimg,"img/profilkepek/" . sha1($_SESSION['user_id']));

?>