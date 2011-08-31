<form action="<?= $_SERVER['REQUEST_URI'] ?>" method="get">
<fieldset>
<legend><a href="#" onclick="$('#search-form').slideToggle()">Search</a></legend>
<div id="search-form" style="display:none">
<ul>
  <li><label><span>Almenu Id:</span>
    <?= search_options('almenu_id', (isset($_GET['almenu_id_opts']) ? stripslashes($_GET['almenu_id_opts']) : '')) ?></label>
    <input type="text" name="almenu_id" value="<?= (isset($_GET['almenu_id']) ? stripslashes($_GET['almenu_id']) : '') ?>" /></li>
  <li><label><span>Cim:</span>
    <?= search_options('cim', (isset($_GET['cim_opts']) ? stripslashes($_GET['cim_opts']) : '')) ?></label>
    <input type="text" name="cim" value="<?= (isset($_GET['cim']) ? stripslashes($_GET['cim']) : '') ?>" /></li>
  <li><label><span>Szoveg:</span>
    <?= search_options('szoveg', (isset($_GET['szoveg_opts']) ? stripslashes($_GET['szoveg_opts']) : '')) ?></label>
    <textarea name="szoveg" cols="40" rows="10"><?= (isset($_GET['szoveg']) ? stripslashes($_GET['szoveg']) : '') ?></textarea></li>
  <li><label><span>Kep:</span>
    <?= search_options('kep', (isset($_GET['kep_opts']) ? stripslashes($_GET['kep_opts']) : '')) ?></label>
    <input type="text" name="kep" value="<?= (isset($_GET['kep']) ? stripslashes($_GET['kep']) : '') ?>" /></li>
  <li><label><span>Alt:</span>
    <?= search_options('alt', (isset($_GET['alt_opts']) ? stripslashes($_GET['alt_opts']) : '')) ?></label>
    <input type="text" name="alt" value="<?= (isset($_GET['alt']) ? stripslashes($_GET['alt']) : '') ?>" /></li>
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
$opts = array('id_opts', 'almenu_id_opts', 'cim_opts', 'szoveg_opts', 'kep_opts', 'alt_opts', 'sorrend_opts', 'modositas_opts');
/* Sorround "contains" search term between %% */
foreach ($opts as $o) {
	if (isset($_GET[$o]) && $_GET[$o] == 'like') {
		$v = substr($o, 0, -5);
		$_GET[$v] = '%' . $_GET[$v] . '%';
	}
}

if (search_by('id'))
	$conds .= " AND id {$_GET['id_opts']} '{$_GET['id']}'";
if (search_by('almenu_id'))
	$conds .= " AND almenu_id {$_GET['almenu_id_opts']} '{$_GET['almenu_id']}'";
if (search_by('cim'))
	$conds .= " AND cim {$_GET['cim_opts']} '{$_GET['cim']}'";
if (search_by('szoveg'))
	$conds .= " AND szoveg {$_GET['szoveg_opts']} '{$_GET['szoveg']}'";
if (search_by('kep'))
	$conds .= " AND kep {$_GET['kep_opts']} '{$_GET['kep']}'";
if (search_by('alt'))
	$conds .= " AND alt {$_GET['alt_opts']} '{$_GET['alt']}'";
if (search_by('sorrend'))
	$conds .= " AND sorrend {$_GET['sorrend_opts']} '{$_GET['sorrend']}'";
if (search_by('modositas'))
	$conds .= " AND modositas {$_GET['modositas_opts']} '{$_GET['modositas']}'";
?>