<?php 

ob_start();

	$minuszEgyHonap = -60 * 60 * 24 * 30 + time();

	$_SESSION = array();
	setcookie('PHPSESSID','',$minuszEgyHonap);
	session_regenerate_id(true);
	session_destroy();
	session_unset();
	$_SESSION['logout'] = 'logout';
	
	if (ini_get("session.use_cookies")) {
	    $params = session_get_cookie_params();
	    setcookie(session_name(), '', time() - 42000,
	        $params["path"], $params["domain"],
	        $params["secure"], $params["httponly"]
	    );
	}
	
	
	if(isset($_COOKIE['user_id']) && isset($_COOKIE['keresztnev']) && isset($_COOKIE['tagsag'])){
		setcookie('user_id','',$minuszEgyHonap);
		setcookie('keresztnev','',$minuszEgyHonap);
		setcookie('tagsag','',$minuszEgyHonap);
	}

header("Location: /mak");

ob_end_flush();
	
?>