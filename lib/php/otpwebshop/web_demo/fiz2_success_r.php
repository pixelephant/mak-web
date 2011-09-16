<?php 
    /**
    * @desc Példa olyan eredmény oldalra, melyre a kétszereplõs
    * fizetés sikeres végrehajtása után történik a vezérlásátadás
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
    * metódus, de ennél egyszerûbben kezelhetõ a fiz2_control.php példában szereplõ
    * process(false) függvényhívás is! (Utóbbi használja a fent említett REQUEST
    * paramétereket!)
    */

    require_once('_header_footer.php');
    demo_header('fiz2_main');
    demo_menu();
    demo_title(); 
?>

<h2 class="siker">Sikeres (teszt) vásárlás</h2>

<table class="eredmenytabla1">
  <tr>
    <th>Tranzakció azonositó:</th>
    <td><?php echo $_REQUEST['posId'] ?></td>
  </tr>
  <tr>
    <th>Shop ID:</th>
    <td><?php echo $_REQUEST['tranzakcioAzonosito'] ?></td>
  </tr>
  <tr>
    <th>Authorizációs kód:</th>
    <td><?php echo $_REQUEST['authKod'] ?></td>
  </tr>
</table>

<?php demo_footer(); ?>