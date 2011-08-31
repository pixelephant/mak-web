<?php
include('../inc.functions.php');

print_header('mak » Mak Kategoria');

if (isset($_GET['msg'])) echo '<p id="msg">'.$_GET['msg'].'</p>';

/* Default search criteria (may be overriden by search form) */
$conds = 'TRUE';
include('inc.search1.php');

/* Default paging criteria (may be overriden by paging functions) */
$start     = 0;
$per_page  = 50;
$count_sql = 'SELECT COUNT(id) AS tot FROM `mak_kategoria` WHERE ' . $conds;
include('../inc.paging.php');

/* Get selected entries! */
$sql = "SELECT * FROM `mak_kategoria` WHERE $conds " . get_order('mak_kategoria') . " LIMIT $start,$per_page";

echo '<table>
  <tr>
    <th>Id ' . put_order('id') . '</th>
    <th>Kategoria Nev ' . put_order('kategoria_nev') . '</th>
    <th>Azonosito ' . put_order('azonosito') . '</th>
    <th>Email ' . put_order('email') . '</th>
    <th>Telefon ' . put_order('telefon') . '</th>
    <th>Sorrend ' . put_order('sorrend') . '</th>
    <th>Modositas ' . put_order('modositas') . '</th>
    <th colspan="2" style="text-align:center">Actions</th>
  </tr>
';

$r = mysql_query($sql) or trigger_error(mysql_error());
while($row = mysql_fetch_array($r)) {
	echo '  <tr>
    <td>' . htmlentities($row['id']) . '</td>
    <td>' . htmlentities($row['kategoria_nev']) . '</td>
    <td>' . htmlentities($row['azonosito']) . '</td>
    <td>' . htmlentities($row['email']) . '</td>
    <td>' . htmlentities($row['telefon']) . '</td>
    <td>' . htmlentities($row['sorrend']) . '</td>
    <td>' . htmlentities(humanize($row['modositas'])) . '</td>
    <td><a href="crud_kategoria.php?id=' . $row['id'] . '">Edit</a></td>
    <td><a href="crud_kategoria.php?delete=1&amp;id=' . $row['id'] . '" onclick="return confirm(\'Are you sure?\')">Delete</a></td>
  </tr>' . "
";
}

echo "</table>\n\n";

include('../inc.paging.php');

echo '<p><a href="crud_kategoria.php">New entry</a></p>';

print_footer();
?>