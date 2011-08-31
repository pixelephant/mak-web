<?php 
include 'lib/php/skeleton_index.php';
?>

<?php startblock('title') ?>
Segélyszolgálat
<?php endblock() ?>

<?php startblock('description') ?>
leírása
<?php endblock() ?>

<?php startblock('keywords') ?>
kulcsszavai
<?php endblock() ?>

<?php startblock('additional-javascript')?>

<?php endblock() ?>

<?php startblock('additional-css') ?>

<?php endblock() ?>

<?php startblock('header') ?>
<?php include 'header.php'; ?>
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
	<li id="segely-menu">
		<span>Segélyszolgálat</span>
		<div class="ldd_submenu">
			<div class="arrow"></div>
			<div class="in">
				<ul>
					<li class="ldd_heading">Helyszíni hibaelhárítás</li>
					<li><a href="sub.php">Gyorssegély</a></li>
					<li><a href="sub.php">Akkusegély</a></li>
					<li><a href="sub.php">Általános segély</a></li>
				</ul>
				<ul>
					<li class="ldd_heading">Autómentés</li>
					<li><a href="sub.php">Helyszíni autómentés</a></li>
					<li><a href="sub.php">Autószállítás szervízbe</a></li>
					<li><a href="sub.php">Hazaszállítás külföldről</a></li>
					<li><a href="sub.php">Tárolás</a></li>
					<li><a href="sub.php">Roncsoltatás</a></li>
					<li><a href="sub.php">Nehezített mentés/daruzás</a></li>
				</ul>
				<ul>
					<li class="ldd_heading">Assistance</li>
					<li><a href="sub.php">Taxi</a></li>
					<li><a href="sub.php">Bérautó</a></li>
					<li><a href="sub.php">Utaztatás</a></li>
					<li><a href="sub.php">Szállás</a></li>
					<li><a href="sub.php">Jogsegély</a></li>
					<li><a href="sub.php">Pénzügyi segítség</a></li>
					<li><a href="sub.php">Műszaki tanácsadás</a></li>
					<li><a href="sub.php">Egyéb szolgáltatások</a></li>
				</ul>
			</div>
		</div>
	</li>
	<li id="szerviz-menu">
		<span>Szerviz Pont Hálózat</span>
		<div class="ldd_submenu">
			<div class="arrow"></div>
			<div class="in">
				<ul>
					<li class="ldd_heading">Vizsgáztatás</li>
					<li><a href="sub.php">Eredetiség vizsgálat</a></li>
					<li><a href="sub.php">Műszaki vizsga</a></li>
					<li><a href="sub.php">Veterán vizsga</a></li>
					<li><a href="sub.php">Díjak kedvezmények</a></li>
					<li><a href="sub.php">Vizsgáló állomások (kereső)</a></li>
				</ul>
				<ul>
					<li class="ldd_heading">Autójavítás</li>
					<li><a href="sub.php">Általános tudnivalók</a></li>
					<li><a href="sub.php">Vizsgáló állomások</a></li>
					<li><a href="sub.php">Díjak, kedvezmények</a></li>
				</ul>
			</div>
		</div>
			</li>
	<li id="kozlek-menu">
		<span>Közlekedésbiztonság</span>
		<div class="ldd_submenu">
			<div class="arrow"></div>
			<div class="in">
				<ul>
					<li class="ldd_heading">Oktatás-képzés</li>
					<li><a href="sub.php">Járművezető képzés</a></li>
					<li><a href="sub.php">Vezetéstechnikai képzés</a></li>
					<li><a href="sub.php">Diák oktatás</a></li>
				</ul>
				<ul>
					<li class="ldd_heading">Rendezvények</li>
					<li><a href="sub.php">Roadshow</a></li>
					<li><a href="sub.php">Mobil rendezvény</a></li>
					<li><a href="sub.php">Ki a mester két keréken</a></li>					
					<li><a href="sub.php">Közlekedésbiztonsági Park</a></li>
				</ul>
				<ul>
					<li class="ldd_heading">Tanácsok</li>
					<li><a href="sub.php">Utazási tanácsok</a></li>
					<li><a href="sub.php">Biztonsági tanácsok</a></li>
				</ul>
			</div>
		</div>
	</li>
	<li id="en-menu">
		<span>Én Autóklubom</span>
		<div class="ldd_submenu">
			<div class="arrow"></div>
			<div class="in">
				<ul>
					<li class="ldd_heading">Klubtagság</li>
					<li><a href="sub.php">Kártyatípusok</a></li>
					<li><a href="sub.php">Részletes leírás</a></li>
				</ul>
				<ul>
					<li class="ldd_heading">Érdekképviselet</li>
					<li><a href="sub.php">Jogi tudástár</a></li>
					<li><a href="sub.php">Jogi tanácsadás</a></li>
					<li><a href="sub.php">Műszaki tanácsadás</a></li>
					<li><a href="sub.php">KRESZ</a></li>
					<li><a href="sub.php">GYIK</a></li>
				</ul>
				<ul>
					<li class="ldd_heading">Young &amp; Mobile</li>
					<li><a href="sub.php">1</a></li>
					<li><a href="sub.php">2</a></li>
				</ul>
				
			</div>
	</li>
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

<?php startblock('footer')?>
<div class="wrapper">
	<div id="footerNav">
		<ul class="first">
			<li class="heading tagsag">Klubtagság</li>
			<li>Kártya összehasonlítás</li>
			<li>Részletes leírás</li>
		</ul>
		<ul>
			<li class="heading segely">Segélyszolgálat</li>
			<li><a href="#">Helyszíni hibaelhárítás</a></li>
			<li><a href="">Autómentés</a></li>
			<li><a href="">Assistance</a></li>
		</ul>
		<ul>
			<li class="heading szerviz">Szerviz Pontok</li>
			<li><a href="">Vizsgáztatás</a></li>
			<li><a href="">Autójavítá</a>s</li>
		</ul>
		<ul>
			<li class="heading kozlekedes">Közlekedésbiztonság</li>
			<li><a href="">Oktatás-képzés</a></li>
			<li><a href="">Rendezvények</a></li>
			<li><a href="">Tanácsok</a></li>
		</ul>
		<ul>
			<li class="heading erdek">Érdekképvislet</li>
			<li><a href="">Tudástár</a></li>
			<li><a href="">Tanácsadó pontok</a></li>
			<li><a href="">Általános segély</a></li>
		</ul>
		<ul class="last">
			<li class="heading travel">Travel</li>
			<li><a href="">Külföldi utak</a></li>
			<li><a href="">Belföldi utak</a></li>
			<li><a href="">Exkluzív utak</a></li>
		</ul>
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
<?php endblock() ?>			