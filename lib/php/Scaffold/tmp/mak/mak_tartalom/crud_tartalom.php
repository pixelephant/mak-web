<?php
include('../inc.functions.php');

if (isset($_GET['delete'])) {
	mysql_query("DELETE FROM `mak_tartalom` WHERE `id` = '$_GET[id]}'");
	$msg = (mysql_affected_rows() ? 'Row deleted.' : 'Nothing deleted.');
	header('Location: index.php?msg='.$msg);
}

$id = (isset($_GET['id']) ? $_GET['id'] : 0);
$action = ($id ? 'Editing' : 'Add new') . ' entry';

if (isset($_POST['submitted'])) {
	foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); }
	$sql = "REPLACE INTO `mak_tartalom` (`id`, `almenu_id`, `cim`, `szoveg`, `kep`, `alt`, `sorrend`, `modositas`) VALUES ('$id', '$_POST[almenu_id]', '$_POST[cim]', '$_POST[szoveg]', '$_POST[kep]', '$_POST[alt]', '$_POST[sorrend]', '$_POST[modositas_year]-$_POST[modositas_mth]-$_POST[modositas_day]');";
	mysql_query($sql) or die(mysql_error());
	$msg = (mysql_affected_rows()) ? 'Edited row.' : 'Nothing changed.';
	header('Location: index.php?msg='.$msg);
}


print_header("mak » Mak Tartalom » $action");

$row = mysql_fetch_array ( mysql_query("SELECT * FROM `mak_tartalom` WHERE `id` = '$id' "));
?>
<form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
<fieldset>
<legend>Add / Edit</legend>
<div>
<ul>
  <li><label><span>Almenu Id:</span>
    <input type="text" name="almenu_id" value="<?= (isset($row['almenu_id']) ? stripslashes($row['almenu_id']) : '') ?>" /></label></li>
  <li><label><span>Cim:</span>
    <input type="text" name="cim" value="<?= (isset($row['cim']) ? stripslashes($row['cim']) : '') ?>" /></label></li>
  <li><label><span>Szoveg:</span>
    <textarea name="szoveg" cols="40" rows="10"><?= (isset($row['szoveg']) ? stripslashes($row['szoveg']) : '') ?></textarea></label></li>
  <li><label><span>Kep:</span>
    <input type="text" name="kep" value="<?= (isset($row['kep']) ? stripslashes($row['kep']) : '') ?>" /></label></li>
  <li><label><span>Alt:</span>
    <input type="text" name="alt" value="<?= (isset($row['alt']) ? stripslashes($row['alt']) : '') ?>" /></label></li>
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