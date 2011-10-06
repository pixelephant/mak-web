<?php 
ob_start();

require 'lib/php/Wixel/gump.class.php';
require 'lib/php/class.db.php';
require 'lib/php/class.mak.php';

session_start();

$main = new mak(false);

/*
 * Sikeres fizetés
 */

if(isset($_GET['status']) && $_GET['status'] == 'success'){

	$adat['befizetes_datuma'] = date("Y-m-d");
	//$adat['ervenyesseg_datuma'] = date("Y-m-d",strtotime("+1 year"));
	$adat['statusz'] = '01';
	$adat['megerositve'] = '1';
	
	$cond['e_mail'] = $_SESSION['lastEmail'];
	
	$a = $main->update_felhasznalo($adat,$cond);

	$uzenet = 'Sikeres bankkártyás fizetés!';

	$felh = $main->get_felhasznalo($cond);
	
	$_SESSION['user_id'] = $felh[0]['id'];
	$_SESSION['keresztnev'] = $felh[0]['keresztnev'] . $felh[0]['kapcsolattarto_keresztnev'];
	$_SESSION['tagsag'] = $felh[0]['dijkategoria'];
	$_SESSION['vezeteknev'] = $felh[0]['vezeteknev'];
	$_SESSION['cegnev'] = $felh[0]['cegnev'];
	$_SESSION['nem'] = $felh[0]['nem'];
	
	if($_SESSION['nem'] == 'C'){
		$pdf = $_SESSION['cegnev'];
	}else{
		$pdf = $_SESSION['vezeteknev'] . $_SESSION['keresztnev'];
	}
	
	$link = '<a href="ideigleneskartyak/' . $pdf . '.pdf">Ideiglenes tagsági kártya letöltése</a>';
	
	/*
	 * Komfort tagoknak biztosítási kötvény generálása
	 */
	
	if($_SESSION['tagsag'] == 4){
	
		$link .= '<br /><a href="' . $pdf . '.pdf">Biztosítási kötvény letöltése</a>';
	
	}
	
	//include 'proba.php';
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
		
		if(isset($_GET['status']) && $_GET['status'] == 'success'){
			echo '<script type="text/javascript">window.location = "proba.php"</script>';
		}
		
		?>
	</body>
</html>
<?php 

$main->close();
ob_end_flush();
?>