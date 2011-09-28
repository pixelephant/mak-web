<?php 

include 'lib/php/Wixel/gump.class.php';

include 'lib/php/class.db.php';
include 'lib/php/class.mak.php';

session_start();

$main = new mak(false);

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
		<link rel="shortcut icon" href="/favicon.ico">
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
	<body id="register">
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
			<h2 id="">Regisztráció</h2>
			<h3 class="active">1. Alapadatok</h3>
			<h3 class="">2. Kártyaválasztás</h3>
			<h3 class="">3. Gépjármű adatok</h3>
			<h3 class="">4. Végelgesítés és fizetés</h3>
			<div id="subcontact">
				<h3>1/111-111</h3>
				<h4>web@autoklub.hu</h4>
			</div>
			<?php 
				echo $main->render_hirdetes('regisztralas','','','');
				echo $main->render_poll();
			?>
		</aside>
		<section id="content">
			<h1></h1>
			<form class="step1" id="registerform" action="#">
				<h2>1. lépés - Alapadatok megadása</h2>
				<fieldset id="membership">
					<h3>Tagja már a Magyar Autóklubnak?</h3>
					<div class="row">
						<label for="old">Igen<input autofocus="autofocus" class="required" type="radio" name="group1" id="old" />
						</label>
						<label for="new">Nem<input type="radio" name="group1" id="new" checked="checked" /></label>
					</div>
					<div id="oldMember">
						<div class="row">
							<label for="cardNum1">Kártyaszám</label>
							<input type="text" name="cardNum1" id="cardNum1" size="5" minlength="5" maxlength="5" />
							<strong class="dash"> - </strong>
							<input type="text" name="cardNum2" id="cardNum2" size="5" minlength="5" maxlength="5" />
							<img src="img/info.png" alt="" class="info" title="A kártyáján szereplő 10 jegyű azonosító szám" />
						</div>
						<div class="row">
							<label for="oldEmail">Email cím</label>
							<input class="email" type="text" name="oldEmail" id="oldEmail" />
							<img src="img/info.png" alt="" class="info" title="Az email cím, amit a belépésnél adott meg." />
						</div>
					</div>
				</fieldset>
				
				<fieldset id="sex">
					<h3>Regisztráló</h3>
					<div class="row">
						<label for="co">Cég<input class="required" type="radio" name="group2" id="co" /></label>
						<label for="nat">Természetes személy<input type="radio" name="group2" id="nat" /></label>
					</div>
				</fieldset>
												
				<fieldset id="coSet">
					<h3>Cégadatok</h3>
					
					<div class="row">
						<label for="coName">Cégnév</label>
						<input class="required" type="text" name="coName" id="coName" />
					</div>
					<div class="row">
						<label for="coZip">Székhely irányítószáma</label>
						<input class="zip digits" size="4" minlength="4" maxlength="4" type="text" name="coZip" id="coZip" />
						<label id="coZipError" class="error" style="display: none;">Nem valós irányítószám!</label>
					</div>
					<div class="row">
						<label for="coCity">Székhely települése</label>
						<input type="text" name="coCity" id="coCity" />
					</div>
					<div class="row">
						<label for="coAddress">Székhely címe</label>
						<input type="text" name="coAddress" id="coAddress" />
					</div>
					<div class="row">
						<label for="coCoName">Kapcsolattartó neve</label>
						<input type="text" name="coCoName" id="coCoName" />
						<img src="img/info.png" alt="" class="info" title="Nem kötelező megadni." />
					</div>
					
					<div class="row">
						<label for="coCoMail">Kapcsolattartó email címe</label>
						<input type="text" class="email" name="coCoMail" id="coCoMail" />
						<img src="img/info.png" alt="" class="info" title="Nem kötelező megadni." />
					</div>
					<div class="row">
						<label for="coCoPhone">Kapcsolattartó telefonszáma</label>
						<input type="text" class="digits" name="coCoPhone" id="coCoPhone" />
						<img src="img/info.png" alt="" class="info" title="Nem kötelező megadni." />
					</div>
				</fieldset>
				
				<fieldset id="natSet">
					<h3>Személyes adatok</h3>
					<div class="row">
						<label for="natPrefix">Prefix</label>
						<select name="natPrefix" id="natPrefix">
							<option value="0">-</option>
							<option value="1">Dr.</option>
							<option value="2">Phd</option>
						</select>
					</div>
					<div class="row">
						<label for="natGender">Neme</label>
						<select name="natGender" id="natGender">
							<option value="N">Nő</option>
							<option value="F">Férfi</option>
						</select>
					</div>
					<div class="row">
						<label for="natFName">Vezetéknév</label>
						<input class="required" type="text" name="natFName" id="natFName" />
					</div>
					<div class="row">
						<label for="natLName">Keresztnév</label>
						<input class="required" type="text" name="natLName" id="natLName" />
					</div>
					<div class="row">
						<label for="natDate">Születési dátum</label>
						<input type="text" id="natDate" name="natDate" class="datepicker dateISO required" />
					</div>
					<div class="row">
						<label for="natZip">Irányítószám</label>
						<input class="zip digits required" size="4" minlength="4" maxlength="4" type="text" name="natZip" id="natZip" />
						<label id="natZipError" class="error" style="display: none;">Nem valós irányítószám!</label>
					</div>
					<div class="row">
						<label for="natCity">Település</label>
						<input class="required" type="text" name="natCity" id="natCity" />
					</div>
					<div class="row">
						<label for="natAddress">Cím</label>
						<input class="required" type="text" name="natAddress" id="natAddress" />
					</div>
				</fieldset>
				
				<fieldset>
					<h3>Elérhetőség</h3>
					<div class="row">
						<label for="email">Email cím</label>
						<input class="required email" type="text" name="email" id="email" />
						<img src="img/info.png" alt="" class="info" title="Ezen a címen fogjuk a kapcsolatot tartani Önnel, valamint ezzel tud majd az Én Autóklubomba belépni." />
					</div>
					<!-- >div class="row">
						<label for="phone">Telefonszám</label>
						<input class="required digits" type="text" name="phone" id="phone" />
						<img src="img/info.png" alt="" class="info" title="Az elvárt formátum : 06301111111" />
					</div-->
				</fieldset>
				
				<fieldset>
					<h3>Jelszó választás</h3>
					<div class="row">
						<label for="pass">Jelszó</label>
						<input class="required" minlength="5" type="password" name="pass" id="pass" />
						<img src="img/info.png" alt="" class="info" title="Ezzel a jelszóval tud majd az Én Autóklubomba belépni." />
					</div>
					<div class="row">
						<label for="passRe">Jelszó újra</label>
						<input class="required" minlength="5" type="password" name="passRe" id="passRe" />
					</div>				
				</fieldset>
				
				<fieldset>
				<h3>Feltételek</h3>
				<div class="row">
					<label for="terms">Elfogadom a <a class="link" target="_blank" href="aszf">feltételeket</a></label>
					<input class="required" type="checkbox" name="terms" id="terms" />
				</div>
				</fieldset>
				<input id="toStep2" type="submit" value="Regisztrálás a weboldalra" />
			</form>
			<form action="#" id="memberform" class="step2">
				<h2>2. lépés - Klubtagsági szint kiválasztása</h2>
				<fieldset>
					<h3>Tagsági szint <span class="sum"></span></h3>
					<div class="row">
						<label for="diszkontMember">Diszkont tagság</label>
						<input data-price="1000" type="radio" name="membership" id="diszkontMember" />
					</div>
					<div class="row">
						<label for="standardMember">Standard tagság</label>
						<input data-price="10000" type="radio" name="membership" id="standardMember" />
					</div>
					<div class="row">
						<label for="komfortMember">Komfort tagság</label>
						<input data-price="100000" type="radio" name="membership" id="komfortMember" />
					</div>
				</fieldset>
				<input type="submit" value="Tovább" id="toStep3"/>
			</form>
			<form id="standardform" action="#" method="#" class="step3">
				<h2>3. lépés - Gépjármű adatok megadása</h2>
				<fieldset>
					<h3>Forgalmi rendszám</h3>
					<div class="row">
						<label for="standardPlateHu">Magyar</label>
						<input type="radio" name="platetype" id="standardPlateHu" />
					</div>
					<div class="row">
						<label for="standardPlateFo">Külföldi</label>
						<input type="radio" name="platetype" id="standardPlateFo" />
					</div>
				</fieldset>
				<fieldset>
					<h3>Forgalmi rendszám megadása</h3>
					<div class="row" id="standardPlateHuInputRow">
						<label for="standardPlateHuInput">Forgalmi rendszám</label>
						<input type="text" name="standardPlateHuInput" id="standardPlateHuInput" />
						<img src="img/info.png" alt="" class="info" title="Formátum : AAA111" />
					</div>
					<div class="row" id="standardPlateFoInputRow">
						<label for="standardPlateFoInput">Forgalmi rendszám</label>
						<input type="text" name="standardPlateFoInput" id="standardPlateFoInput" />
					</div>
				</fieldset>
				<input type="submit" value="Fizetés és véglegesítés" id="toStep4" />
			</form>
			<form id="komfortform" action="#" method="#" class="step3">
				<h2>3. lépés - Gépjármú adatok megadása</h2>
				<fieldset>
					<h3>Géjármű adatai</h3>
					<div class="row">
						<label for="komfortPlateHuInput">Rendszám</label>
						<input type="text" class="required" name="komfortPlateHuInput" id="komfortPlateHuInput" />
						<img src="img/info.png" alt="" class="info" title="Formátum : AAA-111" />
					</div>
					<div class="row">
						<label for="carAge">Kor</label>
						<input type="text" name="carAge" id="carAge" class="required" />
					</div>
				</fieldset>
				<input type="submit" value="Fizetés és véglegesítés" id="toStep4" />
			</form>
			<form id="paymentform" action="http://sfvm104.serverfarm.hu/mak/lib/php/otp/web_demo/mak_otp_test_process.php" method="get" class="step4">
				<h2>4. lépés - Fizetési mód kiválasztása</h2>
				<fieldset id="modechoose">
					<h3>Mód választása</h3>
					<div class="row">
						<label class="yellow-button" for="card">Bankkártya</label>
						<br />
						<input type="radio" name="paymentmethod" id="card" />
					</div>
					<div class="row">
						<label class="yellow-button" for="transfer">Banki átutalás</label>
						<br />
						<input type="radio" name="paymentmethod" id="transfer" />
					</div>
					<div class="row">
						<label class="yellow-button" for="cheque">Csekk</label>
						<br />
						<input type="radio" name="paymentmethod" id="cheque" />
					</div>
					<!-- Bankkártyás fizetés -->
					<input type="hidden" name="posId" value="#02299991" size="40" maxlength="15" class="text"/>
					<input type="hidden" name="nyelvkod" value="hu" size="5" maxlength="2" class="text"/>
					<input type="hidden" name="tranzakcioAzonosito" size="40" maxlength="32" class="text"/>
					<input type="hidden" name="backURL" value="http://sfvm104.serverfarm.hu/mak/lib/php/otp/web_demo/mak_otp_test_process.php" class="text"/>
					<input type="hidden" name="osszeg" id="osszeg" value="" size="40" maxlength="15" class="text"/>
					<input type="hidden" name="uzenet" id="uzenet" value="üzenet_otphez" size="40" maxlength="15" class="text"/>
					<input type="hidden" name="name" id="name" value=" " size="40" class="text"/>
					
				</fieldset>
				<fieldset id="chequeDetails" class="detail">
					<h3>Csekkes fizetés <span class="sum"></span></h3>
					<div class="row">Majd kap számlát.</div>
				</fieldset>
				<fieldset id="transferDetails" class="detail">
					<h3>Banki átutalással való fizetés <span class="sum"></span></h3>
					<div class="row">Ide utalja : 1111111-1-1111111-1-1-</div>
				</fieldset>
				<fieldset id="cardDetails" class="detail">
					<h3>Bankkártyás fizetés <span class="sum"></span></h3>
					<div class="row">Átirányítjuk...</div>
				</fieldset>
				<span id="message"></span>
				<input type="submit" value="Véglegesítés" />
			</form>		
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
		<script type="text/javascript" src="lib/js/register.js">
		</script>
		<script>
var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
s.parentNode.insertBefore(g,s)}(document,'script'));
		</script>
	</body>
</html>