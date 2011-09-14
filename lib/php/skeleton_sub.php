<?php 
require_once 'ti.php';
session_start();
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
		<link rel="stylesheet" href="lib/css/sub.css" />
		<link rel="stylesheet" href="lib/css/colorbox.css" />
		<?php startblock('additional-css') ?><?php endblock() ?>
		<script src="lib/js/modernizr-2.min.js"></script>
	</head>
	<body class="<?php startblock('body-class') ?><?php endblock() ?>" id="<?php startblock('body-id') ?><?php endblock() ?>-body" <?php startblock('body-data') ?><?php endblock() ?>>
	<div id="wrap">
		<div class="header-wrap">
			<div class="header-outer">
				<header class="wrapper">
					<?php startblock('header') ?><?php endblock() ?>
				</header>
			</div>
		</div>
	<nav>
		<?php startblock('nav') ?><?php endblock() ?>
	</nav>
	<section id="main" class="wrapper">
		<aside>
			<?php startblock('newsletter') ?><?php endblock() ?>
			<?php startblock('left-menu') ?><?php endblock() ?>
			<?php startblock('subcontact')?><?php endblock() ?>
			<?php startblock('ad') ?><?php endblock() ?>
		</aside>
		<section id="content">
			<?php startblock('3d')?><?php endblock() ?>
		<article>
			<h1><?php startblock('h1')?><?php endblock() ?></h1>
			<?php startblock('sections')?><?php endblock() ?>
			<?php startblock('breadcrumb')?><?php endblock() ?>
		</article>
		</section>
	</section>
	<?php startblock('cta')?><?php endblock() ?>
	<footer>
		<div class="footerIn">
			<div class="wrapper">
				<div id="footerNav">
					<?php startblock('footer-nav')?><?php endblock() ?>
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
		<script type="text/javascript" src="lib/js/main.js">
		</script>
		<script type="text/javascript" src="lib/js/colorbox.js">
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