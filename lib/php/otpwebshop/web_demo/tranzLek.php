<?php

if (!defined('WEBSHOP_LIB_DIR')) define('WEBSHOP_LIB_ROOT', '../lib');

require_once(WEBSHOP_LIB_ROOT . '/iqsys/otpwebshop/util/RequestUtils.php');

require_once("../simpleshop/tranzLek_control.php");


require_once('_header_footer.php');
demo_header('tranzLek');
demo_menu();
demo_title(); 

$response = process();

$posId = $_REQUEST["posId"];
$tranzAzon = $_REQUEST["tranzakcioAzonosito"];
$maxRekordSzam = $_REQUEST["maxRekordSzam"];

$idoszakElejeChecked = RequestUtils::getBooleanValue($_REQUEST['idoszakEleje']);
$idoszakVegeChecked = RequestUtils::getBooleanValue($_REQUEST['idoszakVege']);

global $idoszakEleje;
global $idoszakVege;

?>

<table class="eredmenytabla1">
<tr>
    <th>Tranzakció azonosító:</th>
    <td><?php echo $tranzAzon ?></td>
</tr>
<tr>
    <th>Shop ID:</th>
    <td><?php echo $posId ?></td>
</tr>
<tr>
    <th>Maximális rekordszám:</th>
    <td><?php echo $maxRekordSzam ?></td>
</tr>
<?php if ($idoszakElejeChecked) { ?>
    <tr>
        <th>Idõszak eleje:</th>
        <td><?php echo RequestUtils::dateToString($idoszakEleje) ?></td>
    </tr>
<?php } ?>
<?php if ($idoszakVegeChecked) { ?>
    <tr>
        <th>Idõszak eleje:</th>
        <td><?php echo RequestUtils::dateToString($idoszakVege) ?></td>
    </tr>
<?php } ?>
</table>

<?php if (is_null($response) || !$response->isFinished()) { ?>
    <h2 class="hiba">A lekérdezés nem hajtódott végre vagy a banki válasz nem értelmezhetõ.</h2>
<?php } else if ($response->isSuccessful()) { ?>
    <h2 class="siker">A lekérdezés sikeresen végrehajtódott.</h2>
<?php } else { ?>
    <h2 class="hiba">Hiba a lekérdezés során, banki válaszkód: <?php echo implode(', ', $response->getMessages()) ?></h2>
<?php      
        return;
    } ?>

  <?php
        $lista = $response->getAnswer();
        if (count($lista->getWebShopFizetesAdatok()) == 0) {
  ?>
            A lista üres eredményt tartalmaz.
  <?php
            return;
        }
  ?>

  <table class="eredmenytabla">
    
    <tr>
        <th>&nbsp;</th>
        <th>Tranzakció azonosító</th>
        <th>Státuszkód / Auth.kód</th>
        <th>Idõpont</th>
    </tr>

    <?php
        $i = 0;
        foreach ($lista->getWebShopFizetesAdatok() as $tranz) {
            $i++;
    ?>

            <tr>
                <th class="<?php echo !$tranz->isSuccessful() ? 'hiba' : '' ?>"><a href="#tran_<?php echo $i ?>" class="index">[<?php echo $i ?>.]</th>
                <td><?php echo $tranz->getAzonosito() ?></td>
                <td><?php echo $tranz->getStatuszKod() ?> <?php echo $tranz->isSuccessful() ? ' / ' . $tranz->getAuthorizaciosKod() : ''?></td>
                <td><?php echo ($tranz->getTeljesites() ? $tranz->getTeljesites() : "" ) ?>&nbsp;</td>
            </tr>
    <?php } ?>

  </table>

  <table class="eredmenytabla">


    <?php
        $i = 0;
        foreach ($lista->getWebShopFizetesAdatok() as $tranz) {
            $i++;

            $csakRegisztralas = ($tranz->isUgyfelRegisztracioKell() && "0" == $tranz->getOsszeg());

    ?>

            <tr>
                <th valign="top" class="<?php echo !$tranz->isSuccessful() ? 'hiba' : '' ?>">
                    <a name="tran_<?php echo $i ?>" id="tran_<?php echo $i ?>"/><?php echo $i ?>.
                </th>
                <td>
                    <table class="eredmenytabla_al">
                    <tr>
                        <th nowrap width="20%">Tranzakció azonosító</th>
                        <td><?php echo $tranz->getAzonosito() ?></td>
                        <th>Összeg / devizanem</th>
                        <td><?php echo $tranz->getOsszeg() ?> &nbsp; <?php echo $tranz->getDevizanem() ?> </td>
                    </tr>

                    <tr>
                        <th>Teljesítés idõpontja</th>
                        <td><?php echo ($tranz->getTeljesites() == null ? "" : $tranz->getTeljesites()) ?></td>
                        <th>Státusz kód</th>
                        <td><?php echo $tranz->getStatuszKod() ?></td>
                    </tr>

                    <?php if (!$csakRegisztralas) { ?>
                        <tr>
                            <th>Authorizációs kód</th>
                            <td><?php echo $tranz->getAuthorizaciosKod() == null ? "[Keres elutasitva]" : $tranz->getAuthorizaciosKod() ?></td>
                            <th>POS válaszkód</th>
                            <td><?php echo $tranz->getPosValaszkod() ?></td>
                        </tr>
                    <?php } ?>

                    <?php if ($tranz->getRegisztraltUgyfelId() != null
                                && !"".equals($tranz->getRegisztraltUgyfelId())) { ?>
                    <tr>
                        <th>
                            <?php if ($tranz->isUgyfelRegisztracioKell()) { ?>
                                Regisztrálandó ügyfél id
                            <?php } else { ?>
                                Regisztrált ügyfél id
                            <?php } ?>
                        </th>
                        <td colspan="3"><?php echo $tranz->getRegisztraltUgyfelId() ?></td>
                    </tr>
                    <?php } ?>

                    <?php if (!$tranz->isKetszereplos()) { ?>
                        <tr>
                            <th>Shop megjegyzés</th>
                            <td colspan="3"><?php echo $tranz->getShopMegjegyzes() == null ? "" : $tranz->getShopMegjegyzes() ?></td>
                        </tr>
                    <?php } ?>
                    
                    <?php if ( (!$csakRegisztralas 
                                    && $tranz->getStatuszKod() != "VEVOOLDAL_VISSZAVONT" 
                                    && $tranz->getStatuszKod() != "VEVOOLDAL_TIMEOUT" 
                                    && $tranz->isErtesitesiCimKell())
                                || $tranz->isKetszereplos()) { ?>

                        <tr>
                            <th colspan="4">Értesítési cím adatai:</th>
                        </tr>

                        <?php if ($tranz->isNevKell() || $tranz->isKetszereplos()) { ?>
                        <tr>
                            <th>Név</th>
                            <td colspan="3"><?php echo $tranz->getNev() == null ? "" : $tranz->getNev() ?></td>
                        </tr>
                        <?php } ?>


                        <?php if ($tranz->isOrszagKell()) { ?>
                        <tr>
                            <th>Ország</th>
                            <td colspan="3"><?php echo $tranz->getOrszag() == null ? "" : $tranz->getOrszag() ?></td>
                        </tr>
                        <?php } ?>

                        <?php if ($tranz->isMegyeKell()) { ?>
                        <tr>
                            <th>Megye</th>
                            <td colspan="3"><?php echo $tranz->getMegye() == null ? "" : $tranz->getMegye() ?></td>
                        </tr>
                        <?php } ?>

                        <?php if ($tranz->isTelepulesKell()) { ?>
                        <tr>
                            <th>Települes</th>
                            <td colspan="3"><?php echo $tranz->getVaros() == null ? "" : $tranz->getVaros() ?></td>
                        </tr>
                        <?php } ?>

                        <?php if ($tranz->isUtcaHazszamKell()) { ?>
                        <tr>
                            <th>Utca / házszám</th>
                            <td colspan="3"><?php echo $tranz->getUtcaHazszam() == null ? "" : $tranz->getUtcaHazszam() ?></td>
                        </tr>
                        <?php } ?>

                        <?php if ($tranz->isIranyitoszamKell()) { ?>
                        <tr>
                            <th>Irányítószám</th>
                            <td colspan="3"><?php echo $tranz->getIranyitoszam() == null ? "" : $tranz->getIranyitoszam() ?></td>
                        </tr>
                        <?php } ?>

                        <?php if ($tranz->isKetszereplos()) { ?>
                        <tr>
                            <th>Teljes cím</th>
                            <td colspan="3"><?php echo $tranz->getTeljesCim() == null ? "" : $tranz->getTeljesCim() ?></td>
                        </tr>
                        <tr>
                            <th>Telefon</th>
                            <td colspan="3"><?php echo $tranz->getTelefon() == null ? "" : $tranz->getTelefon() ?></td>
                        </tr>
                        <?php } ?>
                                                
                        <?php if ($tranz->isMailCimKell() || $tranz->isKetszereplos()) { ?>
                        <tr>
                            <th>E-mail cím</th>
                            <td colspan="3"><?php echo $tranz->getMailCim() == null ? "" : $tranz->getMailCim() ?></td>
                        </tr>
                        <?php } ?>
                        
                        <?php if ($tranz->isKozlemenyKell()) { ?>
                        <tr>
                            <th>Közlemény</th>
                            <td colspan="3"><?php echo $tranz->getKozlemeny() == null ? "" : $tranz->getKozlemeny() ?></td>
                        </tr>
                        <?php } ?>

                    <?php } ?>

                    </table>
</td>
            </tr>
        <?php
        }
    ?>

  </table>

<?php demo_footer(); ?>