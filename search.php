<?php 
/*
 * Keresés oldal
 */
include 'lib/php/Wixel/gump.class.php';

include 'lib/php/class.db.php';
include 'lib/php/class.mak.php';

session_start();

error_reporting(0);

$main = new mak(false);

if(isset($_POST['search'])){
	$search = trim($_POST['search']);
}

if(isset($_POST['advanced-search-input'])){
	$search = trim($_POST['advanced-search-input']);
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
		<title>Keresés - Magyar Autóklub</title>		
		<link rel="stylesheet" href="lib/css/reset.css" />
		<link rel="stylesheet" href="lib/css/main.css" />
		<link rel="stylesheet" href="lib/css/sub.css" />
		<link rel="stylesheet" href="lib/css/advanced.css" />
		<link rel="stylesheet" href="lib/smoothness/style.css" />
		<script src="lib/js/modernizr-2.min.js"></script>
	</head>
	<body id="kereses"
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
			echo $main->render_felso_menu();
		?>
	</nav>
	<section id="main" class="wrapper">
		<aside>
			<?php include "newsletter.php" ?>
			<div id="subcontact">
				<h3>1/111-111</h3>
				<h4>web@autoklub.hu</h4>
			</div>
			<?php 
				echo $main->render_hirdetes('kereses','','','');
			?>
		</aside>
		<section id="content">
		<article>
			<h1>Keresési találatok</h1>
			<article>
				<div id="advanced-search">
				<form id="advanced-search-form" action="" method="POST">
					<input type="text" name="advanced-search-input" id="advanced-search-input" value="<?php echo $search; ?>" />
					<input class="yellow-button" type="submit" value="Keresés" />
					<div>
						<p class="choose">Válasszon ki egy vagy több kategóriát, ahol keresni szeretne!</p>
						<?php echo $main->render_search_checkbox(); ?>
					</div>
				</form>
			</div>
			<ul id="results">
				<?php echo $main->render_search_results($search,$_POST); ?>
			</ul>
			</article>
		</article>					
		</section>
	</section>
	<?php include "cta.php" ?>
	<footer>
		<div class="footerIn">
			<div class="wrapper">
				<div id="footerNav">
					<?php echo $main->render_also_menu();?>
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