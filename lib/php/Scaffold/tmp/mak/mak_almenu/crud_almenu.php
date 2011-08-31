<?php
include('../inc.functions.php');

if (isset($_GET['delete'])) {
	mysql_query("DELETE FROM `mak_almenu` WHERE `id` = '$_GET[id]}'");
	$msg = (mysql_affected_rows() ? 'Row deleted.' : 'Nothing deleted.');
	header('Location: index.php?msg='.$msg);
}

$id = (isset($_GET['id']) ? $_GET['id'] : 0);
$action = ($id ? 'Editing' : 'Add new') . ' entry';

if (isset($_POST['submitted'])) {
	foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); }
	$sql = "REPLACE INTO `mak_almenu` (`id`, `url`, `almenu`, `kategoria_id`, `title`, `keywords`, `description`, `sorrend`, `modositas`) VALUES ('$id', '$_POST[url]', '$_POST[almenu]', '$_POST[kategoria_id]', '$_POST[title]', '$_POST[keywords]', '$_POST[description]', '$_POST[sorrend]', '$_POST[modositas_year]-$_POST[modositas_mth]-$_POST[modositas_day]');";
	mysql_query($sql) or die(mysql_error());
	$msg = (mysql_affected_rows()) ? 'Edited row.' : 'Nothing changed.';
	header('Location: index.php?msg='.$msg);
}


print_header("mak » Mak Almenu » $action");

$row = mysql_fetch_array ( mysql_query("SELECT * FROM `mak_almenu` WHERE `id` = '$id' "));
?>
<form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
<fieldset>
<legend>Add / Edit</legend>
<div>
<ul>
  <li><label><span>Url:</span>
    <input type="text" name="url" value="<?= (isset($row['url']) ? stripslashes($row['url']) : '') ?>" /></label></li>
  <li><label><span>Almenu:</span>
    <input type="text" name="almenu" value="<?= (isset($row['almenu']) ? stripslashes($row['almenu']) : '') ?>" /></label></li>
  <li><label><span>Kategoria Id:</span>
    <input type="text" name="kategoria_id" value="<?= (isset($row['kategoria_id']) ? stripslashes($row['kategoria_id']) : '') ?>" /></label></li>
  <li><label><span>Title:</span>
    <input type="text" name="title" value="<?= (isset($row['title']) ? stripslashes($row['title']) : '') ?>" /></label></li>
  <li><label><span>Keywords:</span>
    <input type="text" name="keywords" value="<?= (isset($row['keywords']) ? stripslashes($row['keywords']) : '') ?>" /></label></li>
  <li><label><span>Description:</span>
    <input type="text" name="description" value="<?= (isset($row['description']) ? stripslashes($row['description']) : '') ?>" /></label></li>
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