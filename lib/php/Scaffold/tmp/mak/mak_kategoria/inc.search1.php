<form action="<?= $_SERVER['REQUEST_URI'] ?>" method="get">
<fieldset>
<legend><a href="#" onclick="$('#search-form').slideToggle()">Search</a></legend>
<div id="search-form" style="display:none">
<ul>
  <li><label><span>Kategoria Nev:</span>
    <?= search_options('kategoria_nev', (isset($_GET['kategoria_nev_opts']) ? stripslashes($_GET['kategoria_nev_opts']) : '')) ?></label>
    <input type="text" name="kategoria_nev" value="<?= (isset($_GET['kategoria_nev']) ? stripslashes($_GET['kategoria_nev']) : '') ?>" /></li>
  <li><label><span>Azonosito:</span>
    <?= search_options('azonosito', (isset($_GET['azonosito_opts']) ? stripslashes($_GET['azonosito_opts']) : '')) ?></label>
    <input type="text" name="azonosito" value="<?= (isset($_GET['azonosito']) ? stripslashes($_GET['azonosito']) : '') ?>" /></li>
  <li><label><span>Email:</span>
    <?= search_options('email', (isset($_GET['email_opts']) ? stripslashes($_GET['email_opts']) : '')) ?></label>
    <input type="text" name="email" value="<?= (isset($_GET['email']) ? stripslashes($_GET['email']) : '') ?>" /></li>
  <li><label><span>Telefon:</span>
    <?= search_options('telefon', (isset($_GET['telefon_opts']) ? stripslashes($_GET['telefon_opts']) : '')) ?></label>
    <input type="text" name="telefon" value="<?= (isset($_GET['telefon']) ? stripslashes($_GET['telefon']) : '') ?>" /></li>
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
$opts = array('id_opts', 'kategoria_nev_opts', 'azonosito_opts', 'email_opts', 'telefon_opts', 'sorrend_opts', 'modositas_opts');
/* Sorround "contains" search term between %% */
foreach ($opts as $o) {
	if (isset($_GET[$o]) && $_GET[$o] == 'like') {
		$v = substr($o, 0, -5);
		$_GET[$v] = '%' . $_GET[$v] . '%';
	}
}

if (search_by('id'))
	$conds .= " AND id {$_GET['id_opts']} '{$_GET['id']}'";
if (search_by('kategoria_nev'))
	$conds .= " AND kategoria_nev {$_GET['kategoria_nev_opts']} '{$_GET['kategoria_nev']}'";
if (search_by('azonosito'))
	$conds .= " AND azonosito {$_GET['azonosito_opts']} '{$_GET['azonosito']}'";
if (search_by('email'))
	$conds .= " AND email {$_GET['email_opts']} '{$_GET['email']}'";
if (search_by('telefon'))
	$conds .= " AND telefon {$_GET['telefon_opts']} '{$_GET['telefon']}'";
if (search_by('sorrend'))
	$conds .= " AND sorrend {$_GET['sorrend_opts']} '{$_GET['sorrend']}'";
if (search_by('modositas'))
	$conds .= " AND modositas {$_GET['modositas_opts']} '{$_GET['modositas']}'";
?>