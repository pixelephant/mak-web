<?php 
require_once 'ti.php';
?>
<!DOCTYPE HTML>
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html class="no-js" lang="en">
	<!--<![endif]-->
	<head>
		<base href="http://www.pixelephant.hu/projects/on-going/mak/" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" href="/favicon.ico">
		<link rel="apple-touch-icon" href="/apple-touch-icon.png">
		<meta charset="UTF-8">
		<meta content="<?php startblock('keywords') ?><?php endblock() ?>" name="keywords">
		<meta content="<?php startblock('description') ?><?php endblock() ?>" name="description">
		
		<title><?php startblock('title') ?><?php endblock() ?> - Magyar Autóklub</title>		
		<link rel="stylesheet" href="lib/css/reset.css" />
		<link rel="stylesheet" href="lib/css/main.css" />
		<link rel="stylesheet" href="lib/css/promo.css" />
		<?php startblock('additional-css') ?><?php endblock() ?>
		<script src="lib/js/modernizr-2.min.js"></script>
	</head>
	<body>
	<div id="wrap">
	<div class="header-wrap">
		<div class="header-outer">
		<header class="wrapper">
			<?php startblock('header') ?><?php endblock() ?>
		</header>
		</div>
		<div id="promo-outer">
			<div class="hr"></div>
					<section id="promoSliderWrap" class="">
						<?php startblock('promo-slider') ?><?php endblock() ?>
					</section>
		</div>
	</div>
	<nav>
		<?php startblock('nav') ?><?php endblock() ?>
	</nav>
	<section id="main" class="wrapper">
		<aside>
			<?php startblock('newsletter') ?><?php endblock() ?>
			<?php startblock('ad') ?><?php endblock() ?>
		</aside>
		<section id="content">
			<?php startblock('content') ?><?php endblock() ?>
			<?php startblock('breadcrumb') ?><?php endblock() ?>
		</section>
	</section>
	<?php startblock('cta') ?><?php endblock() ?>
	<!--<section id="breadcrumbWrap">
		<div id="breadcrumb" class="wrapper">
			<ul>
				<li class="first"><a href="#">Főoldal</a></li>
				<li><a href="#">Klubtagság</a></li>
				<li><a href="#">Diszkont kártya</a></li>
				<li><a href="#">Részletes leírás</a></li>
			</ul>
		</div>
	</section>-->
	<footer>
		<div class="wrapper">
			<div id="footerNav">
				<?php startblock('footer-nav')?><?php endblock() ?>
			</div>
			<div id="footerMisc">
				<p><span>Magyar Autóklub</span>&lowast;<span> Budapest, Rómer Flóris u. 8.</span> &lowast;<span>1/111-1111</span>&lowast;<span class="blue"><a href="mailto:web@autoklub.hu">web@autoklub.hu</a></span></p>
				<div class="misc">
					<a href="#">Ászf</a>
					<a href="#">Impresszum</a>
					<a href="#">Médiaajánlat</a>
				</div>
			</div>
		</div>
	</footer>
	</div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js">
		</script>
		<script>
window.jQuery || document.write('<script src="lib/js/jquery-1.6.2.js">\x3C/script>')
		</script>
		<script type="text/javascript" src="lib/js/main.js">
		</script>
		<script type="text/javascript" src="lib/js/promo.js">
		</script>
		<?php startblock('additional-javascript')?><?php endblock() ?>
		<script>
var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
s.parentNode.insertBefore(g,s)}(document,'script'));
		</script>
	</body>
</html>