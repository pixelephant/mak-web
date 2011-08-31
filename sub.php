<?php 
include 'lib/php/skeleton_sub.php';
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
<link rel="stylesheet" href="lib/css/sub.css" />
<?php endblock() ?>

<?php startblock('header') ?>
<?php include 'header.php'; ?>
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
		<span>Szerviz Pontok</span>
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

<?php startblock('left-menu') ?>
<h2 id="segelyszolgalat">
	<img src="img/segelyszolgalat.png" alt="Segélyszolgálat" />
Segélyszolgálat</h2>
<h3 id="helyszinihibaelharitas">Helyszíni hibaelhárítás</h3>
<ul class="links">
	<li>
		<a href="#">Általános teljeskörű segítség</a>
	</li>
	<li>
		<a href="#">Gyorssegély</a>
	</li>
	<li>
		<a href="#">Akkusegély</a>
	</li>
</ul>
<h3 id="automentes">Autómentés</h3>
<div class="links">
	<li>
		<a href="#">Autószállítás szervizbe</a>
	</li>
	<li>
		<a href="#">Hazaszállítás külföldről</a>
	</li>
	<li>
		<a href="#">Tárolás</a>
	</li>
	<li>
		<a href="#">Roncsoltatás</a>
	</li>
	<li>
		<a href="#">Nehezített mentés</a>
	</li>
</div>
<h3 id="assistance">Assistance</h3>
<div class="links">
	<li>
		<a href="#">Taxi, bérautó</a>
	</li>
	<li>
		<a href="#">Utaztatás</a>
	</li>
	<li>
		<a href="#">Szállás</a>
	</li>
</div>
<?php endblock() ?>

<?php startblock('subcontact')?>
<div id="subcontact">
	<h3>1/111-111</h3>
	<h4>segelyszolgalat@autoklub.hu</h4>
</div>
<?php endblock() ?>

<?php startblock('ad') ?>
<a target="_blank" href="http://www.arceurope.com/EN/memberservices.aspx"><img class="ad" src="img/arc.jpg" alt="ARC europe - Show your card!" /></a>
<a target="_blank" href="http://www.erscharter.eu/"><img class="ad" src="img/ersc.jpg" alt="European road safety charter" /></a>
<a target="_blank" href="https://www.generali.hu/GeneraliBiztosito.aspx"><img class="ad" src="img/generali.jpg" alt="Generali biztosító" /></a>
<iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fpages%2FFrontline-m%25C3%25A9dia-Kft%2F134495689944678&amp;width=200&amp;colorscheme=light&amp;show_faces=true&amp;border_color=black&amp;stream=true&amp;header=true&amp;height=427" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:200px; height:427px; background:white; margin: 0 auto; display: block;" allowTransparency="true"></iframe>
<?php endblock() ?>

<?php startblock('3d')?>
	<div class="layer1"></div>
	<div class="layer2"></div>
<?php endblock() ?>

<?php startblock('h1')?>
	Helyszíni hibaelhárítás
<?php endblock() ?>

<?php startblock('sections')?>
<section>
	<h2>Általános teljeskörű segítség</h2>
	<p>A Magyar Autóklub 1965 óta működtet helyszíni hibaelhárítási szolgáltatást, amely most is az egyetlen, saját flottával, döntő többségében mestervizsgával rendelkező alkalmazottakkal rendelkező, ISO 9001:2008 minősítésű, országos hálózatban nyújtott segélyszolgálat. A gépkocsik hibaelhárítást szolgáló műszaki felszereltsége és a több mint száz munkatárs folyamatos képzése a legjobb európai sikeres hibaelhárítási arányokat teszi lehetővé idehaza.  A motornak a  hiba feltárását például a Klub munkatársai is számítógépes programmal  végzik és rögzítik. A GPS kapcsolatrendszer, az elektronikus esetkezelés a diszpécser központtal és az üzemvitel évek óta  fejlesztés alatt áll az egyre bővülő igények, a szolgáltatás minőségi követelményeinek kielégítése céljából.</p>
    <img src="img/altalanos.jpg" alt="Általános segély" />
    <div class="gallery">
    	<a rel="altalanos" href="img/gallery/altalanos-01.jpg"><img src="img/gallery/altalanos-01-tn.jpg" alt="" /></a>
    	<a rel="altalanos" href="img/gallery/altalanos-05.jpg"><img src="img/gallery/altalanos-05-tn.jpg" alt="" /></a>
    	<a rel="altalanos" href="img/gallery/altalanos-03.jpg"><img src="img/gallery/altalanos-03-tn.jpg" alt="" /></a>
    	<a rel="altalanos" href="img/gallery/altalanos-04.jpg"><img src="img/gallery/altalanos-04-tn.jpg" alt="" /></a>
    	<!--<a rel="altalanos" href="img/gallery/altalanos-05.jpg"><img src="img/gallery/altalanos-05-tn.jpg" alt="" /></a>-->
    </div>
</section>
<div class="hr"></div>
<section>
	<h2>Gyorssegély</h2>
	<p>A klubtagok előtt jól ismert és közkedvelt szolgáltatás az ún. országúti és városi segélyszolgálat. Ennek keretében helyszíni hibaelhárítást végeznek a Klub sárga angyalai az év minden napján, éjjel-nappal az ország bármely részén. A helyszini hibamegállapítást nagy mértékben segíti a Panasonic fedélzeti számítógéppel összekapcsolt MACS 45 univerzális autódiagnosztikai eszköz , amely jelenleg az egyik legkorszerűbb, a fejlett társkluboknál is alkalmazott eszköz. Ez többek között lehetővé teszi, hogy ne szemrevételezéssel, tapasztalati megfigyeléssel határozza meg a szolgáltató, hogy a gépjárművel tovább lehet-e haladni, legalább a legközelebbi szervizbe. A széleskörű hibaelhárítási tevékenység során a sárga angyalok fődarabokat (fék, futómű, stb.) nem bontathatnak meg, de a legfeljebb 45 perces munkaidőben igencsak sokféle meghibásodást tudnak elhárítani, természetesen kizárva azokat az eseteket, amikor gyári előírás és/vagy garancia tiltja a hibalehárítást.
	</p>
	<img src="img/gyorssegely.jpg" alt="Gyorssegély" />
</section>
<div class="hr"></div>
<section>
	<h2>Akkusegély</h2>
	<p>Új szolgáltatást indított az Autóklub segélyszolgálata a klubtagoknak a Robert Bosch Kft-vel és a Sza-Co Kft-vel együttműködve.  A segélyszolgálati gépkocsikban 44Ah, 60Ah és 72Ah új akkumulátorok vannak, amelyeket jutányos, piaci versenyelőnyös árakon ajánlja a Klub a bajba jutott autósoknak. Az akkumulátorokat a helyszínen kicserélik a segélyszolgálat munkatársai. A klubtagok nemcsak az akkumulátort vásárolhatják meg kedvezményes áron, hanem engedményt kapnak a tagsági díjból is, sőt az akkusegély szolgáltatás (helyszíni kiszállás, beüzemelés) ára is kedvezményes. Takarítson meg akár több ezer forintot!</p>
	<img src="img/akkusegely.jpg" alt="Akkusegély" />
</section>
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
			<a class="button" href="register.php"><span>Regisztrálás</span> <em></em></a>
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
		<p><span>Magyar Autóklub</span>&lowast;<span> Budapest, Rómer Flóris u. 8.</span> &lowast;<span>1/111-1111</span>&lowast;<span class="">web@autoklub.hu</span></p>
		<div class="misc">
			<a href="#">Ászf</a>
			<a href="#">Impresszum</a>
			<a href="#">Médiaajánlat</a>
		</div>
	</div>
</div>
<?php endblock() ?>