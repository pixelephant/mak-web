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
			<h1>Keresési találatok</h1>
			<div id="advanced-search">
				<form id="advanced-search-form" action="#" method="#">
					<input type="text" name="advanced-search-input" id="advanced-search-input" value="Keresési kifejezés" />
					<input class="yellow-button" type="submit" value="Keresés" />
					<div>
						<label for="only-segely">Segélyszolgálatban</label><input type="checkbox" name="only-segely" id="only-segely" checked="checked" />
						<label for="only-szerviz">Szerviz Pontokban</label><input type="checkbox" name="only-szerviz" id="only-szerviz" checked="checked" />
						<label for="only-kozlek">Közlekedésbiztonságban</label><input type="checkbox" name="only-kozlek" id="only-kozlek" checked="checked" />
						<label for="only-enauto">Én Autóklubomban</label><input type="checkbox" name="only-enauto" id="only-enauto" checked="checked" />
					</div>
				</form>
			</div>
			<ul id="results">
				<li>
					<h3><a href="#">Találti oldal neve</a></h3>
					<div>Lorem ipsum <span class="mark">dolor sit amet</span>, consectetur adipiscing elit. Lorem ipsum <span class="mark">dolor sit amet</span>, consectetur adipiscing elit. Lorem ipsum <span class="mark">dolor sit amet</span>, consectetur adipiscing elit. </div>
				</li>
				<li>
					<h3><a href="#">Találti oldal neve</a></h3>
					<div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum <span class="mark">dolor sit amet</span>, consectetur adipiscing elit. </div>
				</li>
				<li>
					<h3><a href="#">Találti oldal neve</a></h3>
					<div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum <span class="mark">dolor sit amet</span>, consectetur adipiscing elit. Lorem ipsum <span class="mark">dolor sit amet</span>, consectetur adipiscing elit. Lorem ipsum <span class="mark">dolor sit amet</span>, consectetur adipiscing elit. </div>
				</li>
				<li>
					<h3><a href="#">Találti oldal neve</a></h3>
					<div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. </div>
				</li>
			</ul>
			
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
		<script type="text/javascript" src="lib/js/szervizpont.js">
		</script>
		<script>
var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
s.parentNode.insertBefore(g,s)}(document,'script'));
		</script>
	</body>
</html>