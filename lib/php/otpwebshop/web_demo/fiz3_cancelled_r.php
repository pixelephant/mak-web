<?php 
    /**
    * @desc Példa olyan eredmény oldalra, melyre a háromszereplõs
    * fizetés ügyfél általi visszautasítása után történik a vezérlásátadás
    * böngészõ oldali redirect utasítással.
    * 
    * Ilyenkor csupán két request GET paraméter áll rendelkezésre,
    * azokkal a nevekkel, amik a haromszereplosshop.conf fájlban
    * találhatók, melyek alapértelmezés szerint:
    * - posId
    * - tranzakcioAzonosito
    * 
    * E két paraméter azonban elég arra, hogy igény esetén lekérdezhetõ
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

<h2 class="elutasitott">Az ügyfél elállt a (teszt) vásárlástól</h2>

<table class="eredmenytabla1">
  <tr>
    <th>Tranzakció azonositó:</th>
    <td><?php echo $_REQUEST['tranzakcioAzonosito'] ?></td>
  </tr>
  <tr>
    <th>Shop ID:</th>
    <td><?php echo $_REQUEST['posId'] ?></td>
  </tr>
</table>

<?php demo_footer(); ?>