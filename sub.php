<?php 
include 'lib/php/skeleton_sub.php';

include 'lib/php/Wixel/gump.class.php';

include 'lib/php/class.db.php';
include 'lib/php/class.mak.php';

$main = new mak(false);

$page = trim($_GET['page']);
$subpage = trim($_GET['subpage']);
$tartalom = trim($_GET['tartalom']);
$subsubpage = trim($_GET['subsubpage']);

$parameterek = $main->get_parameterek_urlbol($page,$subpage,$tartalom,$subsubpage);

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

<?php startblock('body-data') ?>
<?php 
	if(isset($parameterek['lat']) && isset($parameterek['lng'])){
		echo 'data-lat="' . $parameterek['lat'] . '" data-lng="' . $parameterek['lng'] . '"';	
	}
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
	echo $main->render_aloldal_bal_menu($page,$subpage,$tartalom);
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
	echo $main->render_section($page,$subpage,$tartalom,$subsubpage);
?>
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

<?php 
$main->close();
?>