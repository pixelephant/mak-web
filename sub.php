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
<?php include 'header.php';?>
<?php endblock() ?>

<?php startblock('body-id') ?>
<?php 
	echo $page;
?>
<?php endblock() ?>

<?php startblock('nav') ?>
<?php 	
	echo $main->render_felso_menu();
?>
<?php endblock() ?>

<?php startblock('newsletter') ?>
<?php include 'newsletter.php';?>
<?php endblock() ?>

<?php startblock('left-menu') ?>
<?php 
	echo $main->render_aloldal_bal_menu($page);
?>
<?php endblock() ?>

<?php startblock('subcontact')?>
<div id="subcontact">
	<h3>
	<?php 
		echo $parameterek['telefon'];
	?>
	</h3>
	<h4>
	<?php 
		echo $parameterek['email'];
	?>
	</h4>
</div>
<?php endblock() ?>

<?php startblock('ad') ?>
<?php include 'ad.php';?>
<?php endblock() ?>

<?php startblock('3d')?>
	<div class="layer1"></div>
	<div class="layer2"></div>
<?php endblock() ?>

<?php startblock('h1')?>
<?php 
	echo $parameterek['almenu'];
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
<?php include 'cta.php';?>
<?php endblock() ?>

<?php startblock('footer-nav')?>
<?php 
	echo $main->render_also_menu();
?>
<?php endblock() ?>

<?php 
$main->close();
?>