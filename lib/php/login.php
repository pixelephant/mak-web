<?php 
session_start();

require 'Wixel/gump.class.php';
require 'class.db.php';
require 'class.mak.php';

$main = new mak(false);

if(isset($_POST['logout']) && $_POST['logout'] == 'logout'){

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
	
	echo 'sikeres';
	return true;

}elseif(isset($_POST['forgotten'])){
	if($_POST['forgotten'] != ''){
	
		$email = trim($_POST['forgotten']);
		$felhasznalo = $main->get_login($email);
		
		if($felhasznalo['count'] == 0 || $felhasznalo === FALSE){
			echo 'sikertelen1';
			return FALSE;
		}else{
			$cond['e_mail'] = $email;
			
			$jelszo = $main->randomString();
			$adat['jelszo'] = sha1($jelszo);
			
			if($main->update_felhasznalo($adat,$cond) === 'Sikeres'){

				/*
				 * Név összeállítása a levélhez
				 */
			
				if($felhasznalo[0]['nem'] == 'C'){
					$nev = $felhasznalo[0]['kapcsolattarto_vezeteknev'] . ' ' . $felhasznalo[0]['kapcsolattarto_keresztnev'];
				}else{
					$nev = $felhasznalo[0]['elonev'] . ' ' . $felhasznalo[0]['vezeteknev'] . ' ' . $felhasznalo[0]['keresztnev'];
				}
			
				/*
				 * Siker esetén e-mail küldés
				 */
			
				require_once("phpmailer/phpmailer.inc.php");
				
				$mail = new PHPMailer();
				
				//$mail->IsSMTP(); // SMTP használata
				$mail->CharSet = 'UTF-8';
				$mail->From = "elfelejtett@autoklub.hu";
				$mail->FromName = "Magyar Autóklub weboldala";
				//$mail->Host = "smtp1.site.com;smtp2.site.com";  // SMTP szerverek címe
				$mail->AddAddress($email, $nev);
				$mail->AddReplyTo('elfelejtett@autoklub.hu', "Magyar Autóklub");
				$mail->WordWrap = 50;
				
				$mail->IsHTML(true);    // HTML e-mail
				$mail->Subject = "Magyar Autóklub - Elfelejtett jelszó";
				$mail->Body = 'Új jelszava: ' . $jelszo;
				
				if($mail->Send() === FALSE){
					echo 'sikertelen3';
					return FALSE;
				}else{
					echo 'sikeres';
					return TRUE;
				}
			}else{
				echo 'sikertelen2';
				return FALSE;
			}
			
		}
	}
}else{
	/*
	 * A kliens oldalon is használt titkosítással
	 * előállítjuk az összehasonlításhoz használt
	 * stringet
	 */

	$time = $_POST['time'];
	$email = $_POST['email'];
	$pass = $_POST['phash'];
	
	$adat = $main->get_login($email);
	
	$pass_enc = sha1($adat[0]['jelszo'].$time);
	
	if($pass_enc == $pass){
		$_SESSION['user_id'] = $adat[0]['id'];
		$_SESSION['nem'] = $adat[0]['nem'];
		if($adat[0]['nem'] == 'C'){
			if($adat[0]['kapcsolattarto_vezeteknev'] != ''){
				$_SESSION['keresztnev'] = $adat[0]['kapcsolattarto_vezeteknev'];
			}else{
				$_SESSION['keresztnev'] = $adat[0]['cegnev'];
			}
		}else{
			$_SESSION['keresztnev'] = $adat[0]['keresztnev']; 
		}
		$_SESSION['tagsag'] = $adat[0]['dijkategoria'];
		
		if(isset($_POST['remember']) && $_POST['remember'] == 'checked'){
			$egyHonap = 60 * 60 * 24 * 30 + time();
			setcookie('user_id',$_SESSION['user_id'],$egyHonap);
			setcookie('keresztnev',$_SESSION['keresztev'],$egyHonap);
			setcookie('tagsag',$_SESSION['tagsag'],$egyHonap);
		}
		echo 'sikeres';
	}else{
		echo 'sikertelen';
	}

}
$main->close();
?>