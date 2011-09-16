<?php 
    /**
    * @desc Példa olyan eredmény oldalra, melyre a kétlépcsõs
    * fizetés lezárás sikeres végrehajtása után történik a vezérlásátadás
    * PHP kódbeli include / require utasítással.
    * 
    * A kód lényegében megegyezik a kétszereplõs fizetés eredményét
    * megjelenítõ fiz2_answer_i.php kódra, hiszen ugyanolyan típusú
    * banki válasz adatot kell megjeleníteni, mint abban.
    * 
    * Az állományt a példánkban a tranzLezaras_control.php include-olja,
    * a ketlepcsoslezaras.conf fájl megfelelõ konfigurálása esetén.
    * Ilyenkor két global láthatóságú PHP objektum változó áll
    * rendelkezésre, mely tartalmazza a fizetés összes válaszadatát:
    * - response: WResponse típusú objektum, mely a fizetési 
    *   tranzakcióhoz tartozó összes válaszadatot tartalmazza
    * - tranzAdatok: WebShopFizetesValasz típusú objektum, a sikeres 
    *   vásárláshoz tartozó válaszobjektum (value object)
    * 
    */

    if (!defined('WEBSHOP_LIB_DIR')) define('WEBSHOP_LIB_DIR', dirname(__FILE__) . '/../lib');

    require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/ErrorMessages.php');

    require_once('_header_footer.php');
    demo_header($_REQUEST['func']);
    demo_menu();
    demo_title(); 
    
    global $response; 
    global $tranzAdatok;
?>

<?php if (is_null($response) || !$response->isFinished()) { ?>
    <h2 class="hiba">A lezárás nem hajtódott végre vagy a banki válasz nem értelmezhetõ.</h2>
<?php } else if ($response->isSuccessful()) { ?>
    <h2 class="siker">A lezárás sikeresen végrehajtódott.</h2>
<?php } else { ?>
    <h2 class="hiba">Hiba a tranzakció lezárás során, banki válaszkód: <?php echo implode(', ', $response->getMessages()) ?></h2>
<?php } ?>

<?php if (!is_null($tranzAdatok)) { ?>

    <table class="eredmenytabla1">
      <?php if ($response->isSuccessful()) { ?>
          <tr>
            <th>Tranzakció azonositó:</th>
            <td><?php echo $tranzAdatok->getAzonosito() ?></td>
          </tr>
          <tr>
            <th>Shop ID:</th>
            <td><?php echo $tranzAdatok->getPosId() ?></td>
          </tr>

          <tr>
            <th>Teljesites idõpontja:</th>
            <td><?php echo $tranzAdatok->getTeljesites() ?></td>
          </tr>
          <tr>
            <th>Válaszkód:</th>
            <td><?php echo $tranzAdatok->getValaszKod() ?></td>
          </tr>
          <tr>
            <th>Authorizációs kód:</th>
            <td><?php echo $tranzAdatok->getAuthorizaciosKod() ?></td>
          </tr>
      <?php } else { ?>
          <tr>
            <th>Hibakód:</th>
            <td>
                <?php foreach ($response->getErrors() as $error) { 
                        $errorMsg = getMessageText($error);
                ?>
                    <p>    
                       <?php echo $error . ($errorMsg ? " - " . $errorMsg : "") ?>
                    </p>
                <?php } ?>
            </td>
          </tr>
      <?php } ?>
    </table>

<?php } else { ?>

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

<?php } ?>

<?php demo_footer(); ?>