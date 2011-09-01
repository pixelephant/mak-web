<?php 
include 'lib/php/skeleton_sub.php';

include 'lib/php/Wixel/gump.class.php';

include 'lib/php/class.db.php';
include 'lib/php/class.mak.php';

$main = new mak(false);

$page = trim($_GET['page']);

$parameterek = $main->get_parameterek_urlbol($page);

?>

<?php startblock('title') ?>
<?php 
	echo $parameterek['title'];
?>
<?php endblock() ?>

<?php startblock('description') ?>
<?php 
	echo $parameterek['description'];
?>
<?php endblock() ?>

<?php startblock('keywords') ?>
<?php 
	echo $parameterek['keywords'];
?>
<?php endblock() ?>

<?php startblock('additional-javascript')?>
<?php 
	echo $parameterek['javascript'];
?>
<?php endblock() ?>

<?php startblock('additional-css') ?>
<?php 
	echo $parameterek['css'];
?>
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

<?php startblock('body-id') ?>
<?php 
	echo $page;
?>
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

<?php startblock('left-menu') ?>
<?php 
	echo $main->render_aloldal_bal_menu($page);
?>
<?php endblock() ?>

<?php startblock('subcontact')?>
<div id="subcontact">
	<h3>1/111-111</h3>
	<h4>segelyszolgalat@autoklub.hu</h4>
</div>
<?php endblock() ?>

<?php startblock('ad') ?>
<a target="_blank" href="http://www.arceurope.com/EN/memberservices.aspx"><img class="ad" src="img/ad/arc.gif" alt="ARC europe - Show your card!" /></a>
<a target="_blank" href="http://www.erscharter.eu/"><img class="ad" src="img/ad/ersc.gif" alt="European road safety charter" /></a>
<a target="_blank" href="https://www.generali.hu/GeneraliBiztosito.aspx"><img class="ad" src="img/ad/generali.gif" alt="Generali biztosító" /></a>
<iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fpages%2FFrontline-m%25C3%25A9dia-Kft%2F134495689944678&amp;width=200&amp;colorscheme=light&amp;show_faces=true&amp;border_color=black&amp;stream=true&amp;header=true&amp;height=427" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:200px; height:427px; background:white; margin: 0 auto; display: block;" allowTransparency="true"></iframe>
<?php endblock() ?>

<?php startblock('3d')?>
	<div class="layer1"></div>
	<div class="layer2"></div>
<?php endblock() ?>

<?php startblock('h1')?>
<?php 
	//echo $parameterek['almenu'];
	print_r($parameterek['almenu']);
?>
<?php endblock() ?>

<?php startblock('sections')?>
<?php 
	echo $main->render_aloldal_section($page);
?>
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

<?php 
$main->close();
?>