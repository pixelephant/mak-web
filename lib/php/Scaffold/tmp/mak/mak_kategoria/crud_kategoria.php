<?php
include('../inc.functions.php');

if (isset($_GET['delete'])) {
	mysql_query("DELETE FROM `mak_kategoria` WHERE `id` = '$_GET[id]}'");
	$msg = (mysql_affected_rows() ? 'Row deleted.' : 'Nothing deleted.');
	header('Location: index.php?msg='.$msg);
}

$id = (isset($_GET['id']) ? $_GET['id'] : 0);
$action = ($id ? 'Editing' : 'Add new') . ' entry';

if (isset($_POST['submitted'])) {
	foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); }
	$sql = "REPLACE INTO `mak_kategoria` (`id`, `kategoria_nev`, `azonosito`, `email`, `telefon`, `sorrend`, `modositas`) VALUES ('$id', '$_POST[kategoria_nev]', '$_POST[azonosito]', '$_POST[email]', '$_POST[telefon]', '$_POST[sorrend]', '$_POST[modositas_year]-$_POST[modositas_mth]-$_POST[modositas_day]');";
	mysql_query($sql) or die(mysql_error());
	$msg = (mysql_affected_rows()) ? 'Edited row.' : 'Nothing changed.';
	header('Location: index.php?msg='.$msg);
}


print_header("mak » Mak Kategoria » $action");

$row = mysql_fetch_array ( mysql_query("SELECT * FROM `mak_kategoria` WHERE `id` = '$id' "));
?>
<form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
<fieldset>
<legend>Add / Edit</legend>
<div>
<ul>
  <li><label><span>Kategoria Nev:</span>
    <input type="text" name="kategoria_nev" value="<?= (isset($row['kategoria_nev']) ? stripslashes($row['kategoria_nev']) : '') ?>" /></label></li>
  <li><label><span>Azonosito:</span>
    <input type="text" name="azonosito" value="<?= (isset($row['azonosito']) ? stripslashes($row['azonosito']) : '') ?>" /></label></li>
  <li><label><span>Email:</span>
    <input type="text" name="email" value="<?= (isset($row['email']) ? stripslashes($row['email']) : '') ?>" /></label></li>
  <li><label><span>Telefon:</span>
    <input type="text" name="telefon" value="<?= (isset($row['telefon']) ? stripslashes($row['telefon']) : '') ?>" /></label></li>
  <li><label><span>Sorrend:</span>
    <input type="text" name="sorrend" value="<?= (isset($row['sorrend']) ? stripslashes($row['sorrend']) : '') ?>" /></label></li>
  <li><label><span>Modositas:</span>
    <?= input_date('modositas', (isset($row['modositas']) ? stripslashes($row['modositas']) : '')) ?></label></li>
</ul>
<p><input type="hidden" value="1" name="submitted" />
  <input type="submit" value="Add / Edit" /></p>
</div>
</fieldset>
</form>
<?
print_footer();
?>