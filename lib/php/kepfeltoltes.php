<?php 
ob_start();

include 'resizeimage.inc.php';

session_start();

if(($_FILES["file-upload"]["size"] / 1024 / 1000 > 1)){
	echo 'túlnagy';
	return FALSE;
}
/*
if(($_FILES["file-upload"]["type"] != "image/jpeg")){
	echo 'rossztipus';
	return FALSE;
}
*/
/*
$rimg=new RESIZEIMAGE($_FILES["file-upload"]["tmp_name"]); 
echo $rimg->error(); 
$rimg->resize_limitwh(160,210); 
$rimg->close(); 
*/
echo $rimg;

echo 'true';

move_uploaded_file($_FILES["file-upload"]["tmp_name"],"../../img/profilkepek/" . sha1($_SESSION['user_id']) . ".jpg");

header("Location: ../../enautoklubom/beallitasok/profil");

ob_end_flush();
?>