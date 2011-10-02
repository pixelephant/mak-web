<?php 

session_start();
ob_start();

$user = $_POST['user'];
$pass = $_POST['pass'];
$action = $_POST['action'];

if($action == 'login'){
	if($user == 'autoklub' && $pass == 'autoklub'){
		$_SESSION['admin_user'] = 1;
		$_SESSION['admin_edit'] = 'true';
		echo 'sikeres';
		return true;
	}
	
	if($user == 'vendeg' && $pass == 'vendeg'){
		$_SESSION['admin_user'] = 2;
		$_SESSION['admin_edit'] = 'false';
		echo 'sikeres';
		return true;
	}
	
	echo 'sikertelen';
	return false;
	
}else{
	session_unset();
	session_destroy();
	header("Location: ../login.php");
}

ob_end_flush();
?>