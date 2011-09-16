<?php 
    /**
    * @desc Példa olyan eredmény oldalra, melyre a kétszereplõs
    * fizetés sikeres végrehajtása után történik a vezérlásátadás
    * PHP kódbeli include / require utasítással.
    * 
    * Az állományt a példánkban a fiz2_control.php include-olja,
    * a ketszereplosshop.conf fájl megfelelõ konfigurálása esetén.
    * Ilyenkor két global láthatóságú PHP objektum változó áll
    * rendelkezésre, mely tartalmazza a fizetés összes válaszadatát:
    * - tranzAdatok: WebShopFizetesValasz típusú objektum, a 
    *   vásárláshoz tartozó válaszobjektum (value object)
    * 
    * Megjegyzés: a fizetési tranzakció eredménye (tranzAdatok) a 
    * Tranzakció  lekérdezés funkció meghívásával kerül lekérdezésre.
    * A válasz feldolgozását eszerint kell elvégezni: a vásáslás
    * akkor sikeres, ha a POS válaszkód 000-010 közti érték,
    * és az authorizációs kód nem üres.
    */

    if (!defined('WEBSHOP_LIB_DIR')) define('WEBSHOP_LIB_DIR', dirname(__FILE__) . '/../lib');
    require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/ErrorMessages.php');

    require_once('_header_footer.php');
    demo_header($_REQUEST['func']);
    demo_menu();
    demo_title(); 
    
    global $tranzAdatok;
?>

<?php if (is_null($tranzAdatok)) { ?>
    <h2 class="hiba">A tranzakció nem hajtódott végre, a banki válasz válasz nem érhetõ el vagy nem értelmezhetõ.</h2>
<?php } else if ($tranzAdatok->isSuccessful()) { ?>
    <?php if ($tranzAdatok->isCsakRegisztracio()) { ?>
        <h2 class="siker">Sikeres (teszt) regisztrálás</h2>
    <?php } else { ?>
        <h2 class="siker">Sikeres (teszt) vásárlás</h2>
    <?php } ?>
<?php } else { ?>
    <h2 class="hiba">Sikertelen (teszt) vásárlás</h2>
<?php } ?>

<?php if (!is_null($tranzAdatok)) { ?>

    <table class="eredmenytabla1">
      <tr>
        <th>Tranzakció azonositó:</th>
        <td><?php echo $tranzAdatok->getAzonosito() ?></td>
      </tr>
      <tr>
        <th>Shop ID:</th>
        <td><?php echo $tranzAdatok->getPosId() ?></td>
      </tr>

      <tr>
        <th>Státusz kód:</th>
        <td><?php echo $tranzAdatok->getStatuszKod() ?></td>
      </tr>
      <tr>
        <th>(POS) Válasz kód:</th>
        <td>
            <?php if (!$tranzAdatok->isSuccessful()) { 
                    $errorMsg = getMessageText($tranzAdatok->getPosValaszkod());
               }
               echo $tranzAdatok->getPosValaszkod() . ($errorMsg ? " - " . $errorMsg : "");
            ?>
        </td>
      </tr>
      <tr>
        <th>Teljesites idõpontja:</th>
        <td><?php echo $tranzAdatok->getTeljesites() ?></td>
      </tr>
    </table>  
    
    <?php if ($tranzAdatok->getStatuszKod() == "VEVOOLDAL_VISSZAVONT") return; ?>
    
    <table class="eredmenytabla1">
        <?php if (!$tranzAdatok->isCsakRegisztracio() && $tranzAdatok->isSuccessful()) { ?>
          <tr>
            <th>Authorizációs kód:</th>
            <td><?php echo $tranzAdatok->getAuthorizaciosKod() ?></td>
          </tr>
        <?php } ?>

        <?php if (!$tranzAdatok->isCsakRegisztracio()) { ?>
            
            <?php if ($tranzAdatok->isNevKell()) { ?>
            <tr>
                <th>Név</th>
                <td><?php echo $tranzAdatok->getNev() == null ? "" : $tranzAdatok->getNev() ?></td>
            </tr>
            <?php } ?>


            <?php if ($tranzAdatok->isOrszagKell()) { ?>
            <tr>
                <th>Ország</th>
                <td><?php echo $tranzAdatok->getOrszag() == null ? "" : $tranzAdatok->getOrszag() ?></td>
            </tr>
            <?php } ?>

            <?php if ($tranzAdatok->isMegyeKell()) { ?>
            <tr>
                <th>Megye</th>
                <td><?php echo $tranzAdatok->getMegye() == null ? "" : $tranzAdatok->getMegye() ?></td>
            </tr>
            <?php } ?>

            <?php if ($tranzAdatok->isTelepulesKell()) { ?>
            <tr>
                <th>Települes</th>
                <td><?php echo $tranzAdatok->getVaros() == null ? "" : $tranzAdatok->getVaros() ?></td>
            </tr>
            <?php } ?>

            <?php if ($tranzAdatok->isUtcaHazszamKell()) { ?>
            <tr>
                <th>Utca / házszám</th>
                <td><?php echo $tranzAdatok->getUtcaHazszam() == null ? "" : $tranzAdatok->getUtcaHazszam() ?></td>
            </tr>
            <?php } ?>

            <?php if ($tranzAdatok->isIranyitoszamKell()) { ?>
            <tr>
                <th>Irányítószám</th>
                <td><?php echo $tranzAdatok->getIranyitoszam() == null ? "" : $tranzAdatok->getIranyitoszam() ?></td>
            </tr>
            <?php } ?>

            <?php if ($tranzAdatok->isKozlemenyKell()) { ?>
            <tr>
                <th>Közlemény</th>
                <td><?php echo $tranzAdatok->getKozlemeny() == null ? "" : $tranzAdatok->getKozlemeny() ?></td>
            </tr>
            <?php } ?>
        
        
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