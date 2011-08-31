<?php
include('../inc.functions.php');

print_header('mak » Mak Almenu');

if (isset($_GET['msg'])) echo '<p id="msg">'.$_GET['msg'].'</p>';

/* Default search criteria (may be overriden by search form) */
$conds = 'TRUE';
include('inc.search2.php');

/* Default paging criteria (may be overriden by paging functions) */
$start     = 0;
$per_page  = 50;
$count_sql = 'SELECT COUNT(id) AS tot FROM `mak_almenu` WHERE ' . $conds;
include('../inc.paging.php');

/* Get selected entries! */
$sql = "SELECT * FROM `mak_almenu` WHERE $conds " . get_order('mak_almenu') . " LIMIT $start,$per_page";

echo '<table>
  <tr>
    <th>Id ' . put_order('id') . '</th>
    <th>Url ' . put_order('url') . '</th>
    <th>Almenu ' . put_order('almenu') . '</th>
    <th>Kategoria Id ' . put_order('kategoria_id') . '</th>
    <th>Title ' . put_order('title') . '</th>
    <th>Keywords ' . put_order('keywords') . '</th>
    <th>Description ' . put_order('description') . '</th>
    <th>Sorrend ' . put_order('sorrend') . '</th>
    <th>Modositas ' . put_order('modositas') . '</th>
    <th colspan="2" style="text-align:center">Actions</th>
  </tr>
';

$r = mysql_query($sql) or trigger_error(mysql_error());
while($row = mysql_fetch_array($r)) {
	echo '  <tr>
    <td>' . htmlentities($row['id']) . '</td>
    <td>' . htmlentities($row['url']) . '</td>
    <td>' . htmlentities($row['almenu']) . '</td>
    <td>' . htmlentities($row['kategoria_id']) . '</td>
    <td>' . htmlentities($row['title']) . '</td>
    <td>' . htmlentities($row['keywords']) . '</td>
    <td>' . htmlentities($row['description']) . '</td>
    <td>' . htmlentities($row['sorrend']) . '</td>
    <td>' . htmlentities(humanize($row['modositas'])) . '</td>
    <td><a href="crud_almenu.php?id=' . $row['id'] . '">Edit</a></td>
    <td><a href="crud_almenu.php?delete=1&amp;id=' . $row['id'] . '" onclick="return confirm(\'Are you sure?\')">Delete</a></td>
  </tr>' . "
";
}

echo "</table>\n\n";

include('../inc.paging.php');

echo '<p><a href="crud_almenu.php">New entry</a></p>';

print_footer();
?>