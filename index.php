<?php 
include 'lib/php/skeleton_index.php';

include 'lib/php/Wixel/gump.class.php';

include 'lib/php/class.db.php';
include 'lib/php/class.mak.php';

$main = new mak(false);
?>

<?php startblock('title') ?>
Főoldal
<?php endblock() ?>

<?php startblock('description') ?>
Autóklub
<?php endblock() ?>

<?php startblock('keywords') ?>
autoklub,mak
<?php endblock() ?>

<?php startblock('additional-javascript')?>

<?php endblock() ?>

<?php startblock('additional-css') ?>

<?php endblock() ?>

<?php startblock('header') ?>
<h1><a href="index.php">Magyar Autóklub</a></h1>
<div id="headerButtons">
	<div id="loginContainer">
		<a href="#" id="segelyButton"><img src="img/pictogram-01.png" alt="Segélyszolgálat" /></a>
		<a href="#" id="szervizButton"><img src="img/pictogram-03.png" alt="Szervizpontok" /></a>
		<a href="#" id="kozlekButton"><img src="img/pictogram-04.png" alt="Közlekedésbiztonság" /></a>
		<a href="#" id="travelButton"><img src="img/pictogram-02.png" alt="Travel" /></a>
		<a href="#" data-reveal-id="loginModal" id="loginButton"><span>Bejelentkezés</span><em></em></a>
		<div id="loginModal" class="reveal-modal">
			<form id="loginform" action="#">
					<h2>Bejelentkezés</h2>
			        <fieldset>
			        	<div class="row">
			        		<label for="loginEmail">Email cím</label>
				            <input type="text" name="loginEmail" class="required email" id="loginEmail" />
			        	</div>
			        	<div class="row">
			        		<label for="loginPassword">Jelszó</label>
				            <input class="required" type="password" name="loginPassword" id="loginPassword" />
			        	</div>
			        </fieldset>
			        <input type="submit" id="loginSubmit" value="Belépés" />
			        <label id="chl" for="checkbox"><input type="checkbox" id="rememberme" />Emlékezz rám</label>
					<div>
						<a href="#">Regisztrálás</a>
						<a href="#">Elfelejtett jelszó?</a>
					</div>
			</form>
			<a class="close-reveal-modal">&#215;</a>
		</div>
	</div>				
</div>
<script type="text/javascript" src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script>
<a id="skypeButton" href="skype:zoltan_dublin?call"><img src="http://mystatus.skype.com/smallclassic/zoltan_dublin" style="border: none;" width="114" height="20" alt="My status" /></a>
<?php endblock() ?>

<?php startblock('promo-slider') ?>
<div id="leftSlider">
<h2>Segélyszolgálat</h2>
<p>Ingyenesen hívható telefonszám. <br /> A nap 24 órájában rendelkezésre állunk!</p>
<img src="img/188.png" alt="Segélyhívószámunk: 188" />
</div>
<div id="rightSlider">
<div class="glow">
	<div id="slider" class="wrapper">
		<div class="slide first">
			<div class="text">
				<h2>Miért érdemes klubtagnak lenni?</h2>
				<p>Mert ez az egyetlen "Klub" az országban, amely már 111 éve kínálja az autósok százezreinek a népszerű és széles körű szolgáltatásait, piaci verseny közepette.</p>
				<ul>
					<li><a href="#">Regisztráció</a></li>
					<li><a href="#">Tagság típsuok</a></li>
					<li><a href="#">Kedvezmények</a></li>
				</ul>
			</div>
			<img src="img/slider/audi.png" alt="Audio" width="200" />
		</div>
		<div class="slide">
			<div class="text">
				<h2>Hűsítő hétvége akció</h2>
				<p>A meleg napokra való tekintettel hűsító ajándékokkal várjuk kedves vendégeinket minden Szerviz Pontunkban.</p>
				<ul>
					<li><a href="#">Szerviz Pontok</a></li>
					<li><a href="#">Kapcsolat</a></li>
				</ul>
			</div>
			<img src="img/slider/szervizpont.png" alt="Hűsítő hétvége" width="200" />
		</div>
		<div class="slide">
			<div class="text">
				<h2>188-as hívószám éjjel nappal hívható!</h2>
				<p>A Magyar Autóklub Országos Segélyszolgálata a nap 24 órájában, az ország egész területén áll a bajbajutott autósok rendelkezésére városban és országúton egyaránt.</p>
				<ul>
					<li><a href="#">Szállítási díjtábálázat</a></li>
					<li><a href="#">Segélyhívószámunk - 188</a></li>
				</ul>
			</div>
			<img src="img/slider/szerviz.png" alt="Szervíz" width="200" />
		</div>

	<div class="slide">
			<div class="text">
				<h2>Utazzon velünk Spanyolországba!</h2>
				<p>Madrid Spanyolország fővárosa, 3,3 millió lakosával (a külvárosokkal együtt 6,5 millió fő a lakossága) az ország legnagyobb városa, és egyben az Európai Unió harmadik legnépesebb városa (London és Berlin után).</p>
				<ul>
					<li><a href="#">Ajánlat megtekintése</a></li>
					<li><a href="#">A szálloda honlapja</a></li>	
				</ul>
			</div>
			<img src="img/slider/travel.png" alt="Travel" width="200" />
		</div>

	<div class="slide">
			<div class="text">
				<h2>KRESZ oktatás gyerekeknek</h2>
				<p>A Magyar Autóklub felvállalta az általános iskolák diákjainak a közlekedésbiztonságra való nevelésének lehetőségét, tanórán kívüli oktatási formában.</p>
				<ul>
					<li><a href="#">Ki a mester két keréken</a></li>
					<li><a href="#">Fékezd magad</a></li>
					<li><a href="#">Jelentkezés</a></li>
				</ul>
			</div>
			<img src="img/slider/kozlbizt.png" alt="Közlekedésbiztonság" width="200" />
		</div>

	<div class="slide">
			<div class="text">
				<h2>Gyere velünk a Szigetre!</h2>
				<p>Minden kétséget kizáróan Prince monstre nagyszínpados koncertje lesz az idei Sziget nulladik napjának legnagyobb attrakciója.</p>
				<ul>
					<li><a href="#">Jegyek akár fél áron</a></li>
					<li><a href="#">Légy te is klubtag</a></li>
				</ul>
			</div>
			<img src="img/slider/young.png" alt="Sziget fesztivál" width="200" />
		</div>
	</div>
	
	<div id="sliderNav">
		
	</div>
	</div>
</div>
<?php endblock() ?>

<?php startblock('nav') ?>
<ul id="ldd_menu" class="ldd_menu wrapper">
	<li id="home-menu"><span><a href="index.php">Főoldal</a></span></li>
<!--<li><span><a href="#">Aktualitások</a></span></li>-->
<?php 	
	echo $main->render_felso_menu();
?>	
<li id="travel-menu">
	<span>Travel</span>
</li>
<li class="search">
	<input type="text" name="search" id="search" placeholder="Keresés..." />
</li>
	</ul>
<?php endblock() ?>

<?php startblock('newsletter') ?>
<div class="newsletter">
	<a href="http://facebook.com" id="facebook"><img height="40" src="img/fb.png" alt="Facebook" /></a>
	<a href="http://twitter.com" id="twitter"><img height="40" src="img/tw.png" alt="Twitter" /></a>
	<a id="newsletterbutton" href="#"><span>Hírlevél</span> <em></em></a>
	<form action="#">
		<div>
		<input type="text" class="required email" name="newsletter-mail" id="newsletter-mail" placeholder="Email cím" />
		<input type="submit" value="Feliratkozom" />
		</div>
	</form>
</div>
<div class="hr"></div>
<?php endblock() ?>

<?php startblock('ad') ?>
<a target="_blank" href="http://www.arceurope.com/EN/memberservices.aspx"><img class="ad" src="img/ad/arc.gif" alt="ARC europe - Show your card!" /></a>
<a target="_blank" href="http://www.erscharter.eu/"><img class="ad" src="img/ad/ersc.gif" alt="European road safety charter" /></a>
<a target="_blank" href="https://www.generali.hu/GeneraliBiztosito.aspx"><img class="ad" src="img/ad/generali.gif" alt="Generali biztosító" /></a>
<iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fpages%2FFrontline-m%25C3%25A9dia-Kft%2F134495689944678&amp;width=200&amp;colorscheme=light&amp;show_faces=true&amp;border_color=black&amp;stream=true&amp;header=true&amp;height=427" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:200px; height:427px; background:white; margin: 0 auto; display: block;" allowTransparency="true"></iframe>
<?php endblock() ?>

<?php startblock('content') ?>
<div class="block">
	<h2>Klubtagság</h2>
	<img src="img/landing/klubtagsag.jpg" alt="Klubtagság" />
	<p>Az Autóklub tagja lehet minden természetes és jogi személy vagy jogi személyiséggel nem rendelkező szervezet (a továbbiakban együtt: jogi személy), aki/amely a belépési szándékát kinyilvánítja, elfogadja a Klub Alapszabályát és a részére megállapított tagdíjat megfizeti 
	A klubba belépni Ügyfélszolgálati (Autoclub Travel) Irodákban, a Műszaki Állomásokon, a Közlekedésbiztonsági és Oktatási Parkban, valamint az interneten lehet.</p>
	<ul>
		<li><a href="#">Kártyatípusaink</a></li>
		<li><a href="#">Miért érdemes?</a></li>
		<li><a href="#">Online regisztrálás</a></li>
	</ul>
</div>
<div class="block right">
	<h2>Szerviz Pontok</h2>
	<img src="img/landing/szervizpont.jpg" alt="Szervizpontok" />
	<p>A gépjárművek és pótkocsijukidőszakos műszaki vizsgálatáról szóló 2009/40 EK irányelv szabályainak magyar jogrendbe való integrálása [5/1990. (IV. 12.) KöHÉM és a 77/2009 (XII. 15.) KHEM-IRM-KvVM rendeletek] alapján 2010. január 1-jétől jelentősen módosult a járművek műszaki vizsgálatának rendje.
	Az egyablakos ügyintézés megvalósításának első jelentős lépéseként a környezetvédelmi felülvizsgálat a műszaki vizsga részét képezi, ezáltal adott a lehetőség, hogy a környezetvédelmi és a műszaki követelmények megfelelőségének ellenőrzése egy helyszínen, egy eljárásban történjen, ebből következően lényegesen rövidebb idő alatt valósuljanak meg.</p>
	<ul>
		<li><a href="#">Térkép</a></li>
		<li><a href="#">Szolgáltatások</a></li>
	</ul>
</div>
<div class="hr"></div>
<div class="block">
	<h2>Segélyszolgálat</h2>
	<img src="img/landing/segelyszolgalat.jpg" alt="Segélszolgálat" />
	<p>A Magyar Autóklub Országos Segélyszolgálata a nap 24 órájában, az ország egész területén áll a bajbajutott autósok rendelkezésére városban és országúton egyaránt. Korszerű informatikai eszközökkel rendelkező diszpécser központunk és megfelelően átgondolt területi eloszlásunk biztosítja az Ön részére a legrövidebb időn belül történő kiérkezésünket.
	
	 Sárga angyalaink 80 db korszerűen felszerelt segélyszolgálati gépkocsival igyekeznek a legmagasabb technikai színvonalon segítséget nyújtani Önnek, és megpróbálják még a helyszínen helyreállítani járműve menetkészségét; szükség esetén a járművet a legközelebbi szervizbe, vagy az Ön által igényelt helyszínre szállítják.</p>
	<ul>
		<li><a href="#">Sárga angyalok</a></li>
		<li><a href="#">Bosch akkusegély</a></li>
		<li><a href="#">Díjtételek</a></li>
	</ul>
</div>
<div class="block right">
	<h2>Travel</h2>
	<img src="img/landing/travel.jpg" alt="Travel" />
	<p>Utazási irodánk a Magyar Autóklub megbízható hátterével már az 1960-as évek második felétől foglalkozik utazásszervezéssel. Az évek során meglévő tapasztalinkra támaszkodva igyekszünk az Önök számára mind szélesebb körű szolgáltatásokat nyújtani. Utasainkat országszerte 14 irodánkban várjuk, ahol minden utazással kapcsolatos dolgot egy helyen, hozzáértő kollégák segítségével intézhetnek.</p>
	<ul>
		<li><a href="#">Kiemelt ajánlataink</a></li>
		<li><a href="#">Exkluzív kedvezmények</a></li>
	</ul>
</div>
<div class="hr"></div>
<div class="block">
	<h2>Közlekedésbiztonság</h2>
	<img src="img/landing/kozlekedesbiztonsag.jpg" alt="Közlekedésbiztonság" />
	<p>Az első gépjárművezetői vizsgát 1901. június 14-én ünnepélyes keretek közt tartották a Városligetben.
	
	A Magyar Királyi Automobil Klub intézményes állami képzés bevezetését sürgette.
	
	„Autóvezetésre csakis az jogosult, … aki a vizsgát, vizsgálóbizottság előtt sikerrel leteszi, és akinek képesítéséről a bizottság véleménye alapján a Főkapitányság automobil vezetői jogosítványt állít ki.”
	
	Az idézet tanúsítja, hogy  a Magyar Autóklub autósiskolája vitathatatlanul a legrégebben működő iskola. A közel 110 éves múlt kötelezi iskoláinkat a magas színvonalú oktatásra.</p>
	<ul>
		<li><a href="#">Közlekedésbiztonsági és Oktatási Park</a></li>
		<li><a href="#">Rendezvényszervezés</a></li>
		<li><a href="#">Biztonságosan közlekedni egy életúton</a></li>
	</ul>
</div>
<div class="block right">
	<h2>Young &amp; Mobile</h2>
	<img src="img/landing/ym.jpg" alt="Young & Mobile" />
	<p>A Magyar Autóklub - több mint 100 éve a gépjárművel közlekedők érdekképviseletét ellátó egyesület, amely az autósok magánkezdeményezésének eredményeképpen jött létre. Megalakulását az automobilizmus fejlődése és az azzal járó kötelezettségek, valamint a kapcsolódó feladatok végrehajtása tette indokolttá 1900-ban, amit a lefektetett Alapszabály bevezetőjében így fogalmaztak meg elődeink; "...érintkezési pontot kell keresni a társadalommal az automobilizmus szakmai tudományos megismertetése és elterjesztése érdekében...".</p>
	<ul>
		<li><a href="#">Blog</a></li>
		<li><a href="#">Exkluzív ajánlatok</a></li>
	</ul>
</div>
<?php endblock() ?>

<?php startblock('breadcrumb')?>
<ul id="breadcrumb">
	<li class="first"><a href="#">Főoldal</a></li>
	<li><a href="#">Klubtagság</a></li>
	<li><a href="#">Diszkont kártya</a></li>
	<li><a href="#">Részletes leírás</a></li>
</ul>
<?php endblock() ?>

<?php startblock('cta')?>
<section id="ctaWrap">
	<div id="cta" class="wrapper">
		<h3>Legyen Ön is klubtag!</h3>
		<ul>
			<li>Kedvezményes Assistance szolgáltatás</li>
			<li>Megbízható háttér</li>
			<li>Évszázados tapasztalat</li>
		</ul>
		<div class="a">
			<a class="button" href="register.php"><span>Tagbelépés</span> <em></em></a>
		</div>
	</div>
</section>
<?php endblock() ?>

<?php startblock('footer-nav')?>
<?php 
	echo $main->render_also_menu();
?>
<ul class="last">
	<li class="heading travel">Travel</li>
	<li><a href="">Külföldi utak</a></li>
	<li><a href="">Belföldi utak</a></li>
	<li><a href="">Exkluzív utak</a></li>
</ul>
<?php endblock() ?>			