<?php 
    require_once('_header_footer.php');
    demo_header($_REQUEST['func']);
    demo_menu();
    demo_title(); 
?>

<h2>Hiba t�rt�nt a v�s�rl�s ind�t�sa vagy adatainak feldolgoz�sa sor�n.</h2>

<table>
  <tr>
    <td class="label">Tranzakci� azonosit�: </td>
    <td><?php echo $_REQUEST["tranzakcioAzonosito"] ?></td>
  </tr>
  <tr>
    <td class="label">Hibak�d: </td>
    <td> A fizet�s sikeress�g�t a bolti rendszer nem tudja meg�llap�tani...</td>
  </tr>
</table>

<?php demo_footer($_REQUEST['func']); ?>