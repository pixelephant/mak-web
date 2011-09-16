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
    <th>Tranzakci� azonos�t�:</th>
    <td><?php echo $tranzAzon ?></td>
</tr>
<tr>
    <th>Shop ID:</th>
    <td><?php echo $posId ?></td>
</tr>
<tr>
    <th>Maxim�lis rekordsz�m:</th>
    <td><?php echo $maxRekordSzam ?></td>
</tr>
<?php if ($idoszakElejeChecked) { ?>
    <tr>
        <th>Id�szak eleje:</th>
        <td><?php echo RequestUtils::dateToString($idoszakEleje) ?></td>
    </tr>
<?php } ?>
<?php if ($idoszakVegeChecked) { ?>
    <tr>
        <th>Id�szak eleje:</th>
        <td><?php echo RequestUtils::dateToString($idoszakVege) ?></td>
    </tr>
<?php } ?>
</table>

<?php if (is_null($response) || !$response->isFinished()) { ?>
    <h2 class="hiba">A lek�rdez�s nem hajt�dott v�gre vagy a banki v�lasz nem �rtelmezhet�.</h2>
<?php } else if ($response->isSuccessful()) { ?>
    <h2 class="siker">A lek�rdez�s sikeresen v�grehajt�dott.</h2>
<?php } else { ?>
    <h2 class="hiba">Hiba a lek�rdez�s sor�n, banki v�laszk�d: <?php echo implode(', ', $response->getMessages()) ?></h2>
<?php      
        return;
    } ?>

  <?php
        $lista = $response->getAnswer();
        if (count($lista->getWebShopFizetesAdatok()) == 0) {
  ?>
            A lista �res eredm�nyt tartalmaz.
  <?php
            return;
        }
  ?>

  <table class="eredmenytabla">
    
    <tr>
        <th>&nbsp;</th>
        <th>Tranzakci� azonos�t�</th>
        <th>St�tuszk�d / Auth.k�d</th>
        <th>Id�pont</th>
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
                        <th nowrap width="20%">Tranzakci� azonos�t�</th>
                        <td><?php echo $tranz->getAzonosito() ?></td>
                        <th>�sszeg / devizanem</th>
                        <td><?php echo $tranz->getOsszeg() ?> &nbsp; <?php echo $tranz->getDevizanem() ?> </td>
                    </tr>

                    <tr>
                        <th>Teljes�t�s id�pontja</th>
                        <td><?php echo ($tranz->getTeljesites() == null ? "" : $tranz->getTeljesites()) ?></td>
                        <th>St�tusz k�d</th>
                        <td><?php echo $tranz->getStatuszKod() ?></td>
                    </tr>

                    <?php if (!$csakRegisztralas) { ?>
                        <tr>
                            <th>Authoriz�ci�s k�d</th>
                            <td><?php echo $tranz->getAuthorizaciosKod() == null ? "[Keres elutasitva]" : $tranz->getAuthorizaciosKod() ?></td>
                            <th>POS v�laszk�d</th>
                            <td><?php echo $tranz->getPosValaszkod() ?></td>
                        </tr>
                    <?php } ?>

                    <?php if ($tranz->getRegisztraltUgyfelId() != null
                                && !"".equals($tranz->getRegisztraltUgyfelId())) { ?>
                    <tr>
                        <th>
                            <?php if ($tranz->isUgyfelRegisztracioKell()) { ?>
                                Regisztr�land� �gyf�l id
                            <?php } else { ?>
                                Regisztr�lt �gyf�l id
                            <?php } ?>
                        </th>
                        <td colspan="3"><?php echo $tranz->getRegisztraltUgyfelId() ?></td>
                    </tr>
                    <?php } ?>

                    <?php if (!$tranz->isKetszereplos()) { ?>
                        <tr>
                            <th>Shop megjegyz�s</th>
                            <td colspan="3"><?php echo $tranz->getShopMegjegyzes() == null ? "" : $tranz->getShopMegjegyzes() ?></td>
                        </tr>
                    <?php } ?>
                    
                    <?php if ( (!$csakRegisztralas 
                                    && $tranz->getStatuszKod() != "VEVOOLDAL_VISSZAVONT" 
                                    && $tranz->getStatuszKod() != "VEVOOLDAL_TIMEOUT" 
                                    && $tranz->isErtesitesiCimKell())
                                || $tranz->isKetszereplos()) { ?>

                        <tr>
                            <th colspan="4">�rtes�t�si c�m adatai:</th>
                        </tr>

                        <?php if ($tranz->isNevKell() || $tranz->isKetszereplos()) { ?>
                        <tr>
                            <th>N�v</th>
                            <td colspan="3"><?php echo $tranz->getNev() == null ? "" : $tranz->getNev() ?></td>
                        </tr>
                        <?php } ?>


                        <?php if ($tranz->isOrszagKell()) { ?>
                        <tr>
                            <th>Orsz�g</th>
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
                            <th>Telep�les</th>
                            <td colspan="3"><?php echo $tranz->getVaros() == null ? "" : $tranz->getVaros() ?></td>
                        </tr>
                        <?php } ?>

                        <?php if ($tranz->isUtcaHazszamKell()) { ?>
                        <tr>
                            <th>Utca / h�zsz�m</th>
                            <td colspan="3"><?php echo $tranz->getUtcaHazszam() == null ? "" : $tranz->getUtcaHazszam() ?></td>
                        </tr>
                        <?php } ?>

                        <?php if ($tranz->isIranyitoszamKell()) { ?>
                        <tr>
                            <th>Ir�ny�t�sz�m</th>
                            <td colspan="3"><?php echo $tranz->getIranyitoszam() == null ? "" : $tranz->getIranyitoszam() ?></td>
                        </tr>
                        <?php } ?>

                        <?php if ($tranz->isKetszereplos()) { ?>
                        <tr>
                            <th>Teljes c�m</th>
                            <td colspan="3"><?php echo $tranz->getTeljesCim() == null ? "" : $tranz->getTeljesCim() ?></td>
                        </tr>
                        <tr>
                            <th>Telefon</th>
                            <td colspan="3"><?php echo $tranz->getTelefon() == null ? "" : $tranz->getTelefon() ?></td>
                        </tr>
                        <?php } ?>
                                                
                        <?php if ($tranz->isMailCimKell() || $tranz->isKetszereplos()) { ?>
                        <tr>
                            <th>E-mail c�m</th>
                            <td colspan="3"><?php echo $tranz->getMailCim() == null ? "" : $tranz->getMailCim() ?></td>
                        </tr>
                        <?php } ?>
                        
                        <?php if ($tranz->isKozlemenyKell()) { ?>
                        <tr>
                            <th>K�zlem�ny</th>
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