<?php 
    /**
    * @desc Példa olyan eredmény oldalra, melyre a háromszereplõs
    * fizetés sikeres lefutása után történik a vezérlásátadás
    * böngészõ oldali redirect utasítással.
    * 
    * Ilyenkor csupán három request GET paraméter áll rendelkezésre,
    * azokkal a nevekkel, amik a ketszereplosshop.conf fájlban
    * találhatók, melyek alapértelmezés szerint:
    * - posId
    * - tranzakcioAzonosito
    * - authKod
    * 
    * E három paraméter azonban elég arra, hogy igény esetén lekérdezhetõ
    * majd megjeleníthetõ legyen a tranzakció összes adata. Ehhez használható
    * közvetlenül a WebShopService->tranzakcioStatuszLekerdezes
    * metódus, de ennél egyszerûbben kezelhetõ a fiz3_control.php példában szereplõ
    * processDirectedToBackUrl() függvényhívás is! (Utóbbi használja a 
    * fent említett REQUEST paramétereket!)
    */

    require_once('_header_footer.php');
    demo_header('fiz3_main');
    demo_menu();
    demo_title(); 
?>

<h2 class="siker">Sikeres (teszt) vásárlás</h2>

<table class="eredmenytabla1">
  <tr>
    <th>Tranzakció azonositó:</td>
    <td><?php echo $_REQUEST['posId'] ?></th>
  </tr>
  <tr>
    <th>Shop ID:</td>
    <td><?php echo $_REQUEST['tranzakcioAzonosito'] ?></th>
  </tr>
  <tr>
    <th>Authorizációs kód:</th>
    <td><?php echo $_REQUEST['authKod'] ?></td>
  </tr>
</table>

<?php demo_footer(); ?>