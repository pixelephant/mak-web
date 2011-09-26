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
		<link rel="stylesheet" href="lib/css/my.css" />
		<script src="lib/js/modernizr-2.min.js"></script>
	</head>
	<body id="hirek">
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
			MyAutóklub</h2>
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
			<h1>Hírek</h1>
			<section>
				<h2>A pórnép szegény fia</h2>
				<h3>2011.09.12 - Magyar Autóklub</h3>
				<p>A <a href="http://hu.wikipedia.org/wiki/Volkswagen_Golf">Golf</a> mindig benchmark volt a kategóriájában, minden piacon jól tartja az értékét és igazi sikermodell a Volkswagennél. A miérteket nem csak mi kutatjuk, hanem a konkurensek is. Ne feledjük, minden autógyár szeretne egy ütőképes Golf konkurenciát gyártani, de igazán nem sikerül. Ennek egyik oka a már megszerzett presztízs és elismerés, a másik sokkal prózaibb: a Golf telitalálat. Az volt az egyes, a kettes és talán a hatos is, bár én a sorozatot csak a hármasig szeretem. A Golfokat valahogy úgy tervezhették, hogy leírták egy lapra, hogy mit kell tudnia, mire fogják használni és ehhez milyen jellemvonások kellenek. Aztán a célhoz próbáltak egy pontos eszközt kifaragni, ami nem több, de nem is kevesebb. Ez sikerült tökéletesen. Megvan a kanál, amivel megesszük a levest kényelmesen, de nem akarunk vele húst szeletelni. Pedig még az is sikerülne.</p>
			    <img src="img/hirek/hirek4.jpg" alt="A pórnép szegény fia" />
			</section>
			<div class="hr"></div>
			<section>
				<h2>Riksát reszel az Audi is</h2>
				<h3>2011.09.12 - Magyar Autóklub</h3>
				<p>Az E1 e-tron gyakorlatilag a Renault Twizy Audi-indigóval átrajzolt másolata. Ugyanolyan keskeny, különálló kerekek közé szorított kabint matricáztak fel örvénymintával, csak kicsit nyúlánkabb formával és feltehetően valamivel igényesebb technikával. Az egymás mögé elhelyezett ülések is a francia mintát követik, bár a bajorok valószínűleg inkább a Messerschmitt Kabinenrollert tekintik a szellemi ősnek.</p>
				<img src="img/hirek/hirek1.jpg" alt="Riksát reszel az Audi is" />
			</section>
			<div class="hr"></div>
			<section>
				<h2>Taníts minket, Mester!</h2>
				<h3>2011.09.12 - Magyar Autóklub</h3>
				<p>1954-től az Alfa Romeo fejlesztő osztályán ügyködött, mint karosszéria szerkezeti konstruktőr, ám onnan hamarosan továbbkerült a sokkal gyakorlatiasabb tesztpilótai pozícióba. Három évvel később Enzo Ferrari csábította magához, vezető mérnökként. Az ő nevéhez fűzhető a háromliteres, V12-es Testa Rossa motor kifejlesztése, amely felváltotta a bonyolult Colombo versenymotorokat. Ez az szív hajtotta a hatvanas évek elején bemutatott új generációs 250 GT sorozatot, amelynek GTE jelű utcai és a rövidített tengelytávú SWB kivitelének fejlesztésében vett részt. Amikor a Jaguar E-Type-al kemény konkurens jelent meg, Bizzarrini az autók aerodinamikájának javításában és a motorok megbízhatóságának (nomeg teljesítményének) növelésében látta a kulcsot. Noha Ferrari a légellenállás csökkentését kuruzslásnak vélte, engedett főmérnökének, aki elkezdte az új versenyautó kifejlesztését. Az első tesztpéldány saját, Boano karosszériás 250 GT-jének ruhája alatt bújt meg - a motort hátrébb tolta és új szárazteknős kenési rendszert fejlesztett ki a Testa Rossa motorhoz. Az 1962-ben bemutatott 250 GTO pillanatok alatt a maranellóiak legkívánatosabb versenyautójává vált; a maga 18 ezer dolláros árával korának egyik legdrágább autójának számított. Az aerodinamikus, hosszú orrú és részben a Kamm-professzor elvei szerint kialakított hátsó felű karosszéria formáját még a mérsékelten autóbolond emberek is egycsapásra felismerik.</p>
				<img src="img/hirek/hirek2.jpg" alt="Taníts minket, Mester!" />
			</section>
			<div class="hr"></div>
			<section>
				<h2>Csalás Aradon</h2>
				<h3>2011.09.12 - Magyar Autóklub</h3>
				<p>Hogy ne kezdődjön minden jól, kiderült, hogy ASI megdőlt a pályabejárási szabályok megsértésével. Romániában a pályák megóvása érdekében mindössze három áthaladás engedélyezett minden gyorsasági szakaszon. Megjegyzem, hogy ez még 50%-kal  több, mint ami a VB-n engedélyezett. ASI-ról korábban is hallani lehetett, hogy szereti roppant alaposan feldolgozni a pályákat. Nálunk viszonylag ritka, ha "tréning-kártyát" adnak, vagy más módon ellenőrzik, hogy a versenyző betartotta-e az engedélyezett áthaladásokat. Nos a román ralibajnokság ebben is eltér a miénktől, és komolyan vették ezt. Képzelem, mit szólt a ténybíró, amikor látta, hogy ASI-ék egyszer csak egy másik páros rajtszámával jelentek meg a gyorsaságinál. A lényeg az, hogy a szabálysértésért büntetés jár. A magyar szabályok szerint ez lehet pénzbüntetés, időbüntetés, vagy akár a rajtengedély megvonása. A román szabályok rigorózusabbak: ott ugrik a rajtengedély, és egy kis 2500 eurós számlát is kap a versenyző. Megjegyzem, hogy állítólag náluk ilyenre még nem került sor. Köszi, hogy sikerült a magyar ralisport jó hírét kelteni...</p>
				<img src="img/hirek/hirek3.jpg" alt="Taníts minket, Mester!" />
			</section>
			<?php include "breadcrumb.php" ?>
			<?php include "pagination.php" ?>
		</article>
		</section>
	</section>
	<?php include "cta.php" ?>
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