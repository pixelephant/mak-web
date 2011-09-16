<?php 
    /**
    * @desc Példa olyan eredmény oldalra, melyre a háromszereplõs
    * fizetés sikertelen lefutása után történik a vezérlásátadás
    * böngészõ oldali redirect utasítással.
    * 
    * Ilyenkor csupán három request GET paraméter áll rendelkezésre,
    * azokkal a nevekkel, amik a ketszereplosshop.conf fájlban
    * találhatók, melyek alapértelmezés szerint:
    * - posId
    * - tranzakcioAzonosito
    * - hibakod
    * 
    * E három paraméter azonban elég arra, hogy igény esetén lekérdezhetõ
    * majd megjeleníthetõ legyen a tranzakció összes adata. Ehhez használható
    * közvetlenül a WebShopService->tranzakcioStatuszLekerdezes
    * metódus, de ennél egyszerûbben kezelhetõ a fiz3_control.php példában szereplõ
    * processDirectedToBackUrl() függvényhívás is! (Utóbbi használja a 
    * fent említett REQUEST paramétereket!)
    */

    if (!defined('WEBSHOP_LIB_DIR')) define('WEBSHOP_LIB_DIR', dirname(__FILE__) . '/../lib');

    require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/ErrorMessages.php');
   
    require_once('_header_footer.php');
    demo_header('fiz3_main');
    demo_menu();
    demo_title(); 
?>

<h2 class="hiba">
   <?php if ($_REQUEST['hibakod']) 
        echo "Sikertelen (teszt) vásárlás";
      else
        echo "A (teszt) vásárlás nem indult el vagy a banki válasz nem elértelmezhetõ.";
   ?>
</h2>

<table class="eredmenytabla1">
  <tr>
    <th>Tranzakció azonositó:</th>
    <td><?php echo $_REQUEST['tranzakcioAzonosito'] ?></td>
  </tr>
  <tr>
    <th>Shop ID:</th>
    <td><?php echo $_REQUEST['posId'] ?></td>
  </tr>
  <?php if ($_REQUEST['hibakod']) { ?>
  <tr>
    <th>Hibakód:</th>
    <td>
        <?php 
            $errorMsg = getMessageText($_REQUEST['hibakod']);
            echo $_REQUEST['hibakod'] . ($errorMsg ? " - " . $errorMsg : "");
        ?>
    </td>
  </tr>
  <?php } ?>
</table>

<?php demo_footer(); ?>