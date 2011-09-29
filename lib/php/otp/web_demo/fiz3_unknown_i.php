<?php 
    require_once('_header_footer.php');
    demo_header($_REQUEST['func']);
    demo_menu();
    demo_title(); 
?>

<h2>Hiba történt a vásárlás indítása vagy adatainak feldolgozása során.</h2>

<table>
  <tr>
    <td class="label">Tranzakció azonositó: </td>
    <td><?php echo $_REQUEST["tranzakcioAzonosito"] ?></td>
  </tr>
  <tr>
    <td class="label">Hibakód: </td>
    <td> A fizetés sikerességét a bolti rendszer nem tudja megállapítani...</td>
  </tr>
</table>

<?php demo_footer($_REQUEST['func']); ?>