<?php 

require 'lib/php/Wixel/gump.class.php';
require 'lib/php/class.db.php';
require 'lib/php/class.mak.php';

session_start();

$main = new mak(false);

/*
 * Regisztráció megerősítése
 */

if(isset($_GET['email']) && isset($_GET['azonosito'])){
	
	$cond['felhasznalonev'] = trim($_GET['email']);

	$adatok = $main->get_felhasznalo($cond);
	
	$hash = sha1(sha1($cond['felhasznalonev']) . $adatok[0]['jelszo']);
	
	if($hash == $_GET['azonosito']){
		
		$felhasznalo_array['megerositve'] = '1';
	
		if($main->update_felhasznalo($felhasznalo_array, $cond) !== FALSE){
			$uzenet = 'Köszönjük, hogy sikeresen megerősítette a regisztrációt!';
		}else{
			$uzenet = 'Nem sikerült a megerősítés!1';
		}
	}else{
		$uzenet = 'Nem sikerült a megerősítés!2';
	}
}else{
	$uzenet = 'Nem sikerült!';
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
		<title>Regisztráció - Magyar Autóklub</title>		
		<link rel="stylesheet" href="lib/css/reset.css" />
		<link rel="stylesheet" href="lib/css/main.css" />
		<link rel="stylesheet" href="lib/css/sub.css" />
		<link rel="stylesheet" href="lib/smoothness/style.css" />
		<link rel="stylesheet" href="lib/css/register.css" />
		<script src="lib/js/modernizr-2.min.js"></script>
	</head>
	<body id="register"
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
			<h2 id="">Regisztráció megerősítése</h2>
			<div id="subcontact">
				<h3>1/111-111</h3>
				<h4>web@autoklub.hu</h4>
			</div>
			<?php 
				echo $main->render_hirdetes('regisztraciomegerositese','','','');
			?>
		</aside>
		<section id="content">
			<h1>Regisztráció megerősítése</h1>
			<p><?php echo $uzenet;?></p>
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
		<script>
var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
s.parentNode.insertBefore(g,s)}(document,'script'));
		</script>
	</body>
</html>
<?php 
$main->close();
?>