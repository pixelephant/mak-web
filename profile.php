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
		<!--<link rel="stylesheet" href="lib/css/my.css" />-->
		<link rel="stylesheet" href="lib/css/register.css" />
		<script src="lib/js/modernizr-2.min.js"></script>
	</head>
	<body id="profil">
	<div id="wrap">
		<div id="loginModal" class="reveal-modal">
			<form id="loginform" action="#">
					<h2>Bejelentkezés</h2>
					<div class="hr"></div>
			        	<div id="login-form-inner">
			        		<div class="row">
			        		<label for="loginEmail">Email cím</label>
				            <input type="text" name="loginEmail" class="required email" id="loginEmail" />
							</div>
							<div class="row">
								<label for="loginPassword">Jelszó</label>
								<input class="required" type="password" name="loginPassword" id="loginPassword" />
								<a id="forgotten" href="#">Elfelejtett a jelszavát?</a>
							</div>
							<div id="login-error"></div>
			        	</div>
			        <div class="hr"></div>
					<div class="bottomrow">
						<input class="yellow-button" type="submit" id="loginSubmit" value="Bejelentkezem" />
				        <label id="chl" for="rememberme"><input type="checkbox" id="rememberme" />Emlékezz rám</label>
						<div id="firsttime">
							<a href="regisztralok">Először jár nálunk? Regisztráljon!</a>
						</div>
					</div>
			</form>
			<a class="close-reveal-modal">&#215;</a>
		</div>
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
			<h1>Profil szerkesztés</h1>
			<form id="editform" action="#" method="">
				<fieldset>
					<h3>Személyes adatok</h3>
					<div class="row">
						<label for="natZip">Irányítószám</label>
						<input value="1111" class="zip required" size="4" minlength="4" maxlength="4" class="digits required" type="text" name="natZip" id="natZip" />
					</div>
					<div class="row">
						<label for="natCity">Település</label>
						<input value="Budapest" class="required" type="text" name="natCity" id="natCity" />
					</div>
					<div class="row">
						<label for="natAddress">Cím</label>
						<input value="Rónyai Lajos utca 9" class="required" type="text" name="natAddress" id="natAddress" />
					</div>
					<div class="row">
						<label for="email">Email cím</label>
						<input value="sanyi@sany.hu"  class="required email" type="text" name="email" id="email" />
						<img src="img/info.png" alt="" class="info" title="Ezen a címen fogjuk a kapcsolatot tartani Önnel, valamint ezzel tud majd a Saját Autóklubomba belépni." />
					</div>
					<div class="row">
						<label for="phone">Telefonszám</label>
						<input value="0611111111" class="required digits" type="text" name="phone" id="phone" />
						<img src="img/info.png" alt="" class="info" title="Az elvárt formátum : 06301111111" />
					</div>
					<div class="row">
						<label for="pass">Jelszó</label>
						<input value="12345" class="required" minlength="5" type="password" name="pass" id="pass" />
						<img src="img/info.png" alt="" class="info" title="Ezzel a jelszóval tud majd a Saját Autóklubomba belépni." />
					</div>
					<div class="row">
						<label for="passRe">Jelszó újra</label>
						<input value="12345" class="required" minlength="5" type="password" name="passRe" id="passRe" />
					</div>			
				</fieldset>
				<input type="submit" value="Mentés" />
			</form>
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
		<script>
var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
s.parentNode.insertBefore(g,s)}(document,'script'));
		</script>
	</body>
</html>