<!DOCTYPE HTML>
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html class="no-js" lang="en">
	<!--<![endif]-->
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" href="/favicon.ico">
		<link rel="apple-touch-icon" href="/apple-touch-icon.png">
		<meta charset="UTF-8">
		<meta content="Kulcsszó1, Kulcsszó2, Kulcsszó3" name="keywords"><meta content="Description szövege jön ide..." name="description">
		
		<title>Én Autóklubbom- Magyar Autóklub</title>		
		<link rel="stylesheet" href="lib/css/reset.css" />
		<link rel="stylesheet" href="lib/css/main.css" />
		<link rel="stylesheet" href="lib/css/sub.css" />
		<script src="lib/js/modernizr-2.min.js"></script>
	</head>
	<body id="profil">
	<div id="wrap">
	<?php include "header.php" ?>
	<nav>
		<?php include "nav.php" ?>
	</nav>
	<section id="main" class="wrapper">
		<aside>
			<?php include "newsletter.php" ?>
			<h2 id="myautoklub">
				<img src="img/myautoklub.png" alt="MyAutóklub" />
				MyAutóklub
			</h2>
			<h3 id="profilszerkesztes">Profil szerkesztése</h3>
			<ul class="links">
				<li>
					<a href="#">Általános adatok</a>
				</li>
				<li>
					<a href="#">Gépjármű adatok</a>
				</li>
				<li>
					<a href="#">Kártya</a>
				</li>
			</ul>
			<h3 id="hirfolyam">Hírfolyam</h3>
			<ul class="links">
				<li>
					<a href="#">Hírek</a>
				</li>
				<li>
					<a href="#">Kedvezmények</a>
				</li>
				<li>
					<a href="#">Nyereményjátékok</a>
				</li>
			</ul>
			<h3 id="autos-elet">Autós Élet</h3>
			<ul class="links">
				<li>
					<a href="#">2010</a>
				</li>
				<li>
					<a href="#">2011</a>
				</li>
			</ul>
			<div id="countdown">
				<h3>Tagságomból hátra van még</h3>
				<p id="timeleft" class="timeleft"></p>
			</div>
			<?php include "ad.php" ?>
		</aside>
		<section id="content">
		<article>
			<h1>Szervizpontok</h1>
			<div id="map"></div>
		</article>
		<?php include "breadcrumb.php" ?>
		</section>
	</section>
	<?php include "cta.php" ?>
	<footer>
		<?php include "footer.php" ?>
	</footer>
	</div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js">
		</script>
		<script>
window.jQuery || document.write('<script src="lib/js/jquery-1.6.2.js">\x3C/script>')
		</script>
		<script type="text/javascript" src="lib/js/main.js">
		</script>
		<script type="text/javascript" src="lib/js/my.js">
		</script>
		<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=true"></script>
		<script type="text/javascript" src="lib/js/szervizpontok.js">
		</script>
		<script>
var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
s.parentNode.insertBefore(g,s)}(document,'script'));
		</script>
	</body>
</html>