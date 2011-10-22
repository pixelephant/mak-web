<?php 
ob_start();
/*
 * Sikeres OTP Bankon keresztüli fizetésnél
 * erre az oldalra tér vissza a felhasználó.
 * Az oldalon automatikusan fájl letöltés 
 * ablak nyílik az ideiglenes kártyával.
 * Komfort tagság esetén a biztosítási kötvény
 * is generálásra kerül.
 */
require 'lib/php/Wixel/gump.class.php';
require 'lib/php/class.db.php';
require 'lib/php/class.mak.php';

session_start();

$main = new mak(false);

/*
 * Sikeres fizetés
 */ 

if(isset($_GET['status']) && $_GET['status'] == 'success' && isset($_SESSION['lastEmail'])){

	$text[2] = '<strong>Tisztelt Klubtagunk !</strong><br />
	Örömmel üdvözöljük klubtagjaink sorában és tájékoztatjuk, hogy  ideiglenes tagsági kártyáját máris kinyomtathatja,  tagsága ezennel érvényes. Végleges tagsági kártyájának gyártását megrendeltük, amit rövidesen postára adunk az Ön által megadott lakcímre.<br />';

	$text[3] = '<strong>Tisztelt Klubtagunk !</strong><br />
	Örömmel üdvözöljük klubtagjaink sorában és tájékoztatjuk, hogy  ideiglenes tagsági kártyáját kinyomtathatja, tagsága ezennel érvényes, máris igénybe veheti a Standard tagsághoz járó teljes körű szolgáltatásainkat. Végleges tagsági kártyájának gyártását megrendeltük, amit rövidesen postára adunk az Ön által megadott lakcímre.<br />';
	
	$text[4] = '<strong>Tisztelt Klubtagunk !</strong><br />
	Örömmel üdvözöljük klubtagjaink sorában és tájékoztatjuk, hogy  ideiglenes tagsági kártyáját kinyomtathatja, tagsága ezennel érvényes, máris igénybe veheti a Komfort tagsághoz járó szolgáltatásainkat, kivéve az assistance jellegűeket,  melyek a kötvényen szereplő dátumtól – azaz holnap 0 órától – állnak az Ön rendelkezésére. Végleges tagsági kártyájának gyártását megrendeltük, amit rövidesen postára adunk az Ön által megadott lakcímre.<br />';
	
	$adat['befizetes_datuma'] = date("Y-m-d");
	$adat['ervenyesseg_datuma'] = date("Y-m-d",strtotime("+1 year"));
	$adat['statusz'] = '01';
	$adat['megerositve'] = '1';
	
	$cond['e_mail'] = $_SESSION['lastEmail'];
	
	$a = $main->update_felhasznalo($adat,$cond);

	$uzenet = '<strong>Sikeres bankkártyás fizetés!</strong><br />';
	
	$felh = $main->get_felhasznalo($cond);
	
	$uzenet .= '<br />' . $text[$felh[0]['dijkategoria']];
	
	$_SESSION['user_id'] = $felh[0]['id'];
	
	if($felh[0]['nem'] == 'C'){
		$_SESSION['keresztnev'] = $felh[0]['kapcsolattarto_vezeteknev'];
	}else{
		$_SESSION['keresztnev'] = $felh[0]['keresztnev'];
	}
	
	$_SESSION['tagsag'] = $felh[0]['dijkategoria'];
	$_SESSION['vezeteknev'] = $felh[0]['vezeteknev'];
	$_SESSION['cegnev'] = $felh[0]['cegnev'];
	$_SESSION['nem'] = $felh[0]['nem'];
	
	$pdf = $_SESSION['lastEmail'];
	
	$link = '<a href="ideigleneskartyak/' . $pdf . '.pdf">Ideiglenes tagsági kártya letöltése</a>';
	
	/*
	 * Komfort tagoknak biztosítási kötvény generálása
	 */
	
	if($_SESSION['tagsag'] == 4){
	
		$link .= '<br /><a href="kotvenyek/' . $pdf . '.pdf">Biztosítási kötvény letöltése</a>';
	
	}
	
	//include 'proba.php';
}else{
		
	/*
	 * E-mail küldése sikertelen bankkártyás fizetés tényéről
	 */

	require_once("lib/php/phpmailer/phpmailer.inc.php");
		
	$mail = new PHPMailer();
	
	//$mail->IsSMTP(); // SMTP használata
	$mail->CharSet = 'UTF-8';
	$mail->From = "regisztracio@autoklub.hu";
	$mail->FromName = "Magyar Autóklub weboldala";
	//$mail->Host = "smtp1.site.com;smtp2.site.com";  // SMTP szerverek címe
	$mail->AddAddress('0antalbalazs0@gmail.com','Infó');
	$mail->AddReplyTo($autoklub_email, "Magyar Autóklub");
	$mail->WordWrap = 50;
	
	$mail->IsHTML(true);    // HTML e-mail
	$mail->Subject = "Magyar Autóklub - fizetési igény";
	$mail->Body = 'Az alábbi azonosítóval rendelkező felhasználó: ' . $_SESSION['lastEmail'] . '<br /> sikertelen bankkártyás fizetést hajtott végre!' ;
	
	if($mail->Send() === FALSE){
		//$valasz = 'Sikertelen e-mail küldés!';
	}

	$uzenet = 'Sikertelen fizetés!';

}

?>
<!DOCTYPE HTML>
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html class="no-js" lang="en">
	<!--<![endif]-->
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
		<link rel="apple-touch-icon" href="/apple-touch-icon.png">
		<meta charset="UTF-8">
		<meta content="Kulcsszó1, Kulcsszó2, Kulcsszó3" name="keywords"><meta content="Description szövege jön ide..." name="description">
		<base href="http://sfvm104.serverfarm.hu/mak/" />
		<title>Bank kártyás fizetés - Magyar Autóklub</title>		
		<link rel="stylesheet" href="lib/css/reset.css" />
		<link rel="stylesheet" href="lib/css/main.css" />
		<link rel="stylesheet" href="lib/css/sub.css" />
		<link rel="stylesheet" href="lib/smoothness/style.css" />
		<link rel="stylesheet" href="lib/css/register.css" />
		<script src="lib/js/modernizr-2.min.js"></script>
	</head>
	<body id="sikeresfizetes"
	<?php 
	if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != ''){
		echo ' class="logined"';
	}
	?>
	>
	<?php include 'modal.php';?>
	<div id="wrap">
		<div class="header-wrap">
			<div class="header-outer">
				<header class="wrapper">
					<?php include "header.php" ?> 
				</header>
			</div>
		</div>
	<nav>
		<?php
			echo $main->render_felso_menu('');
		?>
	</nav>
	<section id="main" class="wrapper">
		<aside>
			<?php include "newsletter.php" ?>
			<h2 id="">Bankkártyás fizetés</h2>
			<div id="subcontact">
				<h3>1/111-111</h3>
				<h4>web@autoklub.hu</h4>
			</div>
			<?php 
				echo $main->render_hirdetes('sikeresfizetes','','','');
			?>
		</aside>
		<section id="content">
			<h1>Bankkártyás fizetés</h1>
			<p><?php echo $uzenet;?></p>
			<p><?php echo $link; ?></p>
		</section>
	</section>
	<?php include "cta.php" ?>
	<footer>
		<div class="footerIn">
			<div class="wrapper">
				<div id="footerNav">
					<?php 
						echo $main->render_also_menu();
					?>
				</div>
			</div>
		</div>
		<div id="fotterMiscWrap">	
			<div id="footerMisc">
				<?php include 'footer.php';?>
			</div>
		</div>
	</footer>
	</div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js">
		</script>
		<script>
window.jQuery || document.write('<script src="lib/js/jquery-1.6.2.js">\x3C/script>')
		</script>
		<script type="text/javascript" src="lib/js/ui-1.8.15.js">
		</script>
		<script type="text/javascript" src="lib/js/main.js">
		</script>
		<script type="text/javascript" src="lib/js/sub.js">
		</script>
		<script type="text/javascript">
			
		</script>
		<script>
var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
s.parentNode.insertBefore(g,s)}(document,'script'));
		</script>
		<?php 
		
		if(isset($_GET['status']) && $_GET['status'] == 'success'  && $_SESSION['lastEmail'] != ''){
			if($_SESSION['tagsag'] == '4'){
				echo '<script type="text/javascript">$.get("kotveny.php", function(){window.location = "proba.php"});</script>';
			}else{
				echo '<script type="text/javascript">window.location = "proba.php";</script>';
			}
		}
		
		?>
	</body>
</html>
<?php 
//unset($_SESSION['lastEmail']);

$main->close();
ob_end_flush();
?>