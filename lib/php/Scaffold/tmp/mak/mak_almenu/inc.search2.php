<form action="<?= $_SERVER['REQUEST_URI'] ?>" method="get">
<fieldset>
<legend><a href="#" onclick="$('#search-form').slideToggle()">Search</a></legend>
<div id="search-form" style="display:none">
<ul>
  <li><label><span>Url:</span>
    <?= search_options('url', (isset($_GET['url_opts']) ? stripslashes($_GET['url_opts']) : '')) ?></label>
    <input type="text" name="url" value="<?= (isset($_GET['url']) ? stripslashes($_GET['url']) : '') ?>" /></li>
  <li><label><span>Almenu:</span>
    <?= search_options('almenu', (isset($_GET['almenu_opts']) ? stripslashes($_GET['almenu_opts']) : '')) ?></label>
    <input type="text" name="almenu" value="<?= (isset($_GET['almenu']) ? stripslashes($_GET['almenu']) : '') ?>" /></li>
  <li><label><span>Kategoria Id:</span>
    <?= search_options('kategoria_id', (isset($_GET['kategoria_id_opts']) ? stripslashes($_GET['kategoria_id_opts']) : '')) ?></label>
    <input type="text" name="kategoria_id" value="<?= (isset($_GET['kategoria_id']) ? stripslashes($_GET['kategoria_id']) : '') ?>" /></li>
  <li><label><span>Title:</span>
    <?= search_options('title', (isset($_GET['title_opts']) ? stripslashes($_GET['title_opts']) : '')) ?></label>
    <input type="text" name="title" value="<?= (isset($_GET['title']) ? stripslashes($_GET['title']) : '') ?>" /></li>
  <li><label><span>Keywords:</span>
    <?= search_options('keywords', (isset($_GET['keywords_opts']) ? stripslashes($_GET['keywords_opts']) : '')) ?></label>
    <input type="text" name="keywords" value="<?= (isset($_GET['keywords']) ? stripslashes($_GET['keywords']) : '') ?>" /></li>
  <li><label><span>Description:</span>
    <?= search_options('description', (isset($_GET['description_opts']) ? stripslashes($_GET['description_opts']) : '')) ?></label>
    <input type="text" name="description" value="<?= (isset($_GET['description']) ? stripslashes($_GET['description']) : '') ?>" /></li>
  <li><label><span>Sorrend:</span>
    <?= search_options('sorrend', (isset($_GET['sorrend_opts']) ? stripslashes($_GET['sorrend_opts']) : '')) ?></label>
    <input type="text" name="sorrend" value="<?= (isset($_GET['sorrend']) ? stripslashes($_GET['sorrend']) : '') ?>" /></li>
  <li><label><span>Modositas:</span>
    <?= search_options('modositas', (isset($_GET['modositas_opts']) ? stripslashes($_GET['modositas_opts']) : '')) ?></label>
    <?= input_date('modositas', (isset($_GET['modositas']) ? stripslashes($_GET['modositas']) : '')) ?></li>
</ul>
<p><input type="hidden" value="1" name="submitted" />
  <input type="submit" value="Search" /></p>
</div>
</fieldset>
</form>

<?php
$opts = array('id_opts', 'url_opts', 'almenu_opts', 'kategoria_id_opts', 'title_opts', 'keywords_opts', 'description_opts', 'sorrend_opts', 'modositas_opts');
/* Sorround "contains" search term between %% */
foreach ($opts as $o) {
	if (isset($_GET[$o]) && $_GET[$o] == 'like') {
		$v = substr($o, 0, -5);
		$_GET[$v] = '%' . $_GET[$v] . '%';
	}
}

if (search_by('id'))
	$conds .= " AND id {$_GET['id_opts']} '{$_GET['id']}'";
if (search_by('url'))
	$conds .= " AND url {$_GET['url_opts']} '{$_GET['url']}'";
if (search_by('almenu'))
	$conds .= " AND almenu {$_GET['almenu_opts']} '{$_GET['almenu']}'";
if (search_by('kategoria_id'))
	$conds .= " AND kategoria_id {$_GET['kategoria_id_opts']} '{$_GET['kategoria_id']}'";
if (search_by('title'))
	$conds .= " AND title {$_GET['title_opts']} '{$_GET['title']}'";
if (search_by('keywords'))
	$conds .= " AND keywords {$_GET['keywords_opts']} '{$_GET['keywords']}'";
if (search_by('description'))
	$conds .= " AND description {$_GET['description_opts']} '{$_GET['description']}'";
if (search_by('sorrend'))
	$conds .= " AND sorrend {$_GET['sorrend_opts']} '{$_GET['sorrend']}'";
if (search_by('modositas'))
	$conds .= " AND modositas {$_GET['modositas_opts']} '{$_GET['modositas']}'";
?>