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
<?php include 'header.php';?>
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
		<div class="slide first" id="makslide">
			<h2>Magyar Autóklub</h2>
			<h3>A hűséges Partner</h3>
			<div id="picto">
				<a href=""><img src="img/pikto-02.jpg" alt="" />Segélyszolgálat</a>
				<a href=""><img src="img/pikto-01.jpg" alt="" />Szerviz Pontok</a>
				<a href=""><img src="img/pikto-04.jpg" alt="" />Közlekedésbiztonság</a>
				<a href=""><img src="img/pikto-03.jpg" alt="" />Travel</a>
			</div>
			<img id="makauto" src="img/slider/makauto.png" alt="" />
		</div>
		<div class="slide">
			<div class="text">
				<h2>Miért érdemes klubtagnak lenni?</h2>
				<p>Mert ez az egyetlen "Klub" az országban, amely már 111 éve kínálja az autósok százezreinek a népszerű és széles körű szolgáltatásait, piaci verseny közepette.</p>
				<ul>
					<li><a class="link" href="regisztralas">Regisztráció</a></li>
					<li><a class="link" href="klubtagsag/klubtagsag#K%C3%A1rtyat%C3%ADpusok">Tagság típsuok</a></li>
					<li><a class="link" href="klubtagsag/klubtagsag#Kedvezm%C3%A9nyek%20%C3%A9s%20jogosults%C3%A1gok">Kedvezmények</a></li>
				</ul>
			</div>
			<img src="img/slider/audi.png" alt="Audio" width="200" />
		</div>
		<div class="slide">
			<div class="text">
				<h2>Hűsítő hétvége akció</h2>
				<p>A meleg napokra való tekintettel hűsító ajándékokkal várjuk kedves vendégeinket minden Szerviz Pontunkban.</p>
				<ul>
					<li><a class="link" href="#">Szerviz Pontok</a></li>
					<li><a class="link" href="#">Kapcsolat</a></li>
				</ul>
			</div>
			<img src="img/slider/szervizpont.png" alt="Hűsítő hétvége" width="200" />
		</div>
		<div class="slide">
			<div class="text">
				<h2>188-as hívószám éjjel nappal hívható!</h2>
				<p>A Magyar Autóklub Országos Segélyszolgálata a nap 24 órájában, az ország egész területén áll a bajbajutott autósok rendelkezésére városban és országúton egyaránt.</p>
				<ul>
					<li><a class="link" href="#">Szállítási díjtábálázat</a></li>
					<li><a class="link" href="#">Segélyhívószámunk - 188</a></li>
				</ul>
			</div>
			<img src="img/slider/szerviz.png" alt="Szervíz" width="200" />
		</div>

	<div class="slide">
			<div class="text">
				<h2>Utazzon velünk Spanyolországba!</h2>
				<p>Madrid Spanyolország fővárosa, 3,3 millió lakosával (a külvárosokkal együtt 6,5 millió fő a lakossága) az ország legnagyobb városa, és egyben az Európai Unió harmadik legnépesebb városa (London és Berlin után).</p>
				<ul>
					<li><a class="link" href="#">Ajánlat megtekintése</a></li>
					<li><a class="link" href="#">A szálloda honlapja</a></li>	
				</ul>
			</div>
			<img src="img/slider/travel.png" alt="Travel" width="200" />
		</div>

	<div class="slide">
			<div class="text">
				<h2>KRESZ oktatás gyerekeknek</h2>
				<p>A Magyar Autóklub felvállalta az általános iskolák diákjainak a közlekedésbiztonságra való nevelésének lehetőségét, tanórán kívüli oktatási formában.</p>
				<ul>
					<li><a class="link" href="kozlekedesbiztonsag/rendezvenyek#Ki%20a%20mester%20k%C3%A9t%20ker%C3%A9ken">Ki a mester két keréken</a></li>
					<li><a class="link" href="#">Fékezd magad</a></li>
					<li><a class="link" href="#">Jelentkezés</a></li>
				</ul>
			</div>
			<img src="img/slider/kozlbizt.png" alt="Közlekedésbiztonság" width="200" />
		</div>

	<div class="slide">
			<div class="text">
				<h2>Gyere velünk a Szigetre!</h2>
				<p>Minden kétséget kizáróan Prince monstre nagyszínpados koncertje lesz az idei Sziget nulladik napjának legnagyobb attrakciója.</p>
				<ul>
					<li><a class="link" href="#">Jegyek akár fél áron</a></li>
					<li><a class="link" href="regisztralas">Légy te is klubtag</a></li>
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
<?php 	
	echo $main->render_felso_menu('');
?>
<?php endblock() ?>

<?php startblock('newsletter') ?>
<?php include 'newsletter.php';?>
<?php endblock() ?>

<?php startblock('ad') ?>
<?php 
	echo $main->render_hirdetes($page,$subpage,$tartalom,$subsubpage);
	echo $main->render_poll();
?>
<?php endblock() ?>

<?php startblock('content') ?>
<div class="block">
	<h2>Klubtagság</h2>
	<img src="img/landing/klubtagsag.jpg" alt="Klubtagság" />
	<p>Az Autóklub tagja lehet minden természetes és jogi személy vagy jogi személyiséggel nem rendelkező szervezet (a továbbiakban együtt: jogi személy), aki/amely a belépési szándékát kinyilvánítja, elfogadja a Klub Alapszabályát és a részére megállapított tagdíjat megfizeti 
	A klubba belépni Ügyfélszolgálati (Autoclub Travel) Irodákban, a Műszaki Állomásokon, a Közlekedésbiztonsági és Oktatási Parkban, valamint az interneten lehet.</p>
	<ul>
		<li><a class="link" href="klubtagsag/klubtagsag/">Kártyatípusaink</a></li>
		<li><a class="link" href="#">Miért érdemes?</a></li>
		<li><a class="link" href="regisztralas">Online regisztrálás</a></li>
	</ul>
</div>
<div class="block right">
	<h2>Szerviz Pontok</h2>
	<img src="img/landing/szervizpont.jpg" alt="Szervizpontok" />
	<p>A gépjárművek és pótkocsijukidőszakos műszaki vizsgálatáról szóló 2009/40 EK irányelv szabályainak magyar jogrendbe való integrálása [5/1990. (IV. 12.) KöHÉM és a 77/2009 (XII. 15.) KHEM-IRM-KvVM rendeletek] alapján 2010. január 1-jétől jelentősen módosult a járművek műszaki vizsgálatának rendje.
	Az egyablakos ügyintézés megvalósításának első jelentős lépéseként a környezetvédelmi felülvizsgálat a műszaki vizsga részét képezi, ezáltal adott a lehetőség, hogy a környezetvédelmi és a műszaki követelmények megfelelőségének ellenőrzése egy helyszínen, egy eljárásban történjen, ebből következően lényegesen rövidebb idő alatt valósuljanak meg.</p>
	<ul>
		<li><a class="link" href="szervizpontok">Térkép</a></li>
		<li><a class="link" href="#">Szolgáltatások</a></li>
	</ul>
</div>
<div class="hr"></div>
<div class="block">
	<h2>Segélyszolgálat</h2>
	<img src="img/landing/segelyszolgalat.jpg" alt="Segélszolgálat" />
	<p>A Magyar Autóklub Országos Segélyszolgálata a nap 24 órájában, az ország egész területén áll a bajbajutott autósok rendelkezésére városban és országúton egyaránt. Korszerű informatikai eszközökkel rendelkező diszpécser központunk és megfelelően átgondolt területi eloszlásunk biztosítja az Ön részére a legrövidebb időn belül történő kiérkezésünket.
	
	 Sárga angyalaink 80 db korszerűen felszerelt segélyszolgálati gépkocsival igyekeznek a legmagasabb technikai színvonalon segítséget nyújtani Önnek, és megpróbálják még a helyszínen helyreállítani járműve menetkészségét; szükség esetén a járművet a legközelebbi szervizbe, vagy az Ön által igényelt helyszínre szállítják.</p>
	<ul>
		<li><a class="link" href="#">Sárga angyalok</a></li>
		<li><a class="link" href="segelyszolgalat/helyszinihibaelharitas/akkusegely">Bosch akkusegély</a></li>
		<li><a class="link" href="segelyszolgalat/automentes">Díjtételek</a></li>
	</ul>
</div>
<div class="block right">
	<h2>Travel</h2>
	<img src="img/landing/travel.jpg" alt="Travel" />
	<p>Utazási irodánk a Magyar Autóklub megbízható hátterével már az 1960-as évek második felétől foglalkozik utazásszervezéssel. Az évek során meglévő tapasztalinkra támaszkodva igyekszünk az Önök számára mind szélesebb körű szolgáltatásokat nyújtani. Utasainkat országszerte 14 irodánkban várjuk, ahol minden utazással kapcsolatos dolgot egy helyen, hozzáértő kollégák segítségével intézhetnek.</p>
	<ul>
		<li><a class="link" href="#">Kiemelt ajánlataink</a></li>
		<li><a class="link" href="#">Exkluzív kedvezmények</a></li>
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
		<li><a class="link" href="kozlekedesbiztonsag/rendezvenyek/partnertalalkozo">Közlekedésbiztonsági és Oktatási Park</a></li>
		<li><a class="link" href="kozlekedesbiztonsag/rendezvenyek/mobilrendezveny">Rendezvényszervezés</a></li>
		<li><a class="link" href="kozlekedesbiztonsag/rendezvenyek/biztonsagosankozlekedni">Biztonságosan közlekedni egy életúton</a></li>
	</ul>
</div>
<div class="block right">
	<h2>Young &amp; Mobile</h2>
	<img src="img/landing/ym.jpg" alt="Young & Mobile" />
	<p>A Magyar Autóklub - több mint 100 éve a gépjárművel közlekedők érdekképviseletét ellátó egyesület, amely az autósok magánkezdeményezésének eredményeképpen jött létre. Megalakulását az automobilizmus fejlődése és az azzal járó kötelezettségek, valamint a kapcsolódó feladatok végrehajtása tette indokolttá 1900-ban, amit a lefektetett Alapszabály bevezetőjében így fogalmaztak meg elődeink; "...érintkezési pontot kell keresni a társadalommal az automobilizmus szakmai tudományos megismertetése és elterjesztése érdekében...".</p>
	<ul>
		<li><a class="link" href="#">Blog</a></li>
		<li><a class="link" href="#">Exkluzív ajánlatok</a></li>
	</ul>
</div>
<?php endblock() ?>

<?php startblock('breadcrumb')?>
<?php 
	echo $main->render_breadcrumb($page);
?>
<?php endblock() ?>

<?php startblock('cta')?>
<?php include 'cta.php';?>
<?php endblock() ?>

<?php startblock('footer-nav')?>
<?php 
	echo $main->render_also_menu();
?>
<?php endblock() ?>			