<?php
include('../inc.functions.php');

print_header('mak » Mak Tartalom');

if (isset($_GET['msg'])) echo '<p id="msg">'.$_GET['msg'].'</p>';

/* Default search criteria (may be overriden by search form) */
$conds = 'TRUE';
include('inc.search3.php');

/* Default paging criteria (may be overriden by paging functions) */
$start     = 0;
$per_page  = 50;
$count_sql = 'SELECT COUNT(id) AS tot FROM `mak_tartalom` WHERE ' . $conds;
include('../inc.paging.php');

/* Get selected entries! */
$sql = "SELECT * FROM `mak_tartalom` WHERE $conds " . get_order('mak_tartalom') . " LIMIT $start,$per_page";

echo '<table>
  <tr>
    <th>Id ' . put_order('id') . '</th>
    <th>Almenu Id ' . put_order('almenu_id') . '</th>
    <th>Cim ' . put_order('cim') . '</th>
    <th>Szoveg ' . put_order('szoveg') . '</th>
    <th>Kep ' . put_order('kep') . '</th>
    <th>Alt ' . put_order('alt') . '</th>
    <th>Sorrend ' . put_order('sorrend') . '</th>
    <th>Modositas ' . put_order('modositas') . '</th>
    <th colspan="2" style="text-align:center">Actions</th>
  </tr>
';

$r = mysql_query($sql) or trigger_error(mysql_error());
while($row = mysql_fetch_array($r)) {
	echo '  <tr>
    <td>' . htmlentities($row['id']) . '</td>
    <td>' . htmlentities($row['almenu_id']) . '</td>
    <td>' . htmlentities($row['cim']) . '</td>
    <td>' . htmlentities(limit_chars(nl2br($row['szoveg']))) . '</td>
    <td>' . htmlentities($row['kep']) . '</td>
    <td>' . htmlentities($row['alt']) . '</td>
    <td>' . htmlentities($row['sorrend']) . '</td>
    <td>' . htmlentities(humanize($row['modositas'])) . '</td>
    <td><a href="crud_tartalom.php?id=' . $row['id'] . '">Edit</a></td>
    <td><a href="crud_tartalom.php?delete=1&amp;id=' . $row['id'] . '" onclick="return confirm(\'Are you sure?\')">Delete</a></td>
  </tr>' . "
";
}

echo "</table>\n\n";

include('../inc.paging.php');

echo '<p><a href="crud_tartalom.php">New entry</a></p>';

print_footer();
?>