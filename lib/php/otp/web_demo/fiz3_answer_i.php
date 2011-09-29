<?php 
    /**
    * @desc P�lda olyan eredm�ny oldalra, melyre a k�tszerepl�s
    * fizet�s sikeres v�grehajt�sa ut�n t�rt�nik a vez�rl�s�tad�s
    * PHP k�dbeli include / require utas�t�ssal.
    * 
    * Az �llom�nyt a p�ld�nkban a fiz2_control.php include-olja,
    * a ketszereplosshop.conf f�jl megfelel� konfigur�l�sa eset�n.
    * Ilyenkor k�t global l�that�s�g� PHP objektum v�ltoz� �ll
    * rendelkez�sre, mely tartalmazza a fizet�s �sszes v�laszadat�t:
    * - tranzAdatok: WebShopFizetesValasz t�pus� objektum, a 
    *   v�s�rl�shoz tartoz� v�laszobjektum (value object)
    * 
    * Megjegyz�s: a fizet�si tranzakci� eredm�nye (tranzAdatok) a 
    * Tranzakci�  lek�rdez�s funkci� megh�v�s�val ker�l lek�rdez�sre.
    * A v�lasz feldolgoz�s�t eszerint kell elv�gezni: a v�s�sl�s
    * akkor sikeres, ha a POS v�laszk�d 000-010 k�zti �rt�k,
    * �s az authoriz�ci�s k�d nem �res.
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
    <h2 class="hiba">A tranzakci� nem hajt�dott v�gre, a banki v�lasz v�lasz nem �rhet� el vagy nem �rtelmezhet�.</h2>
<?php } else if ($tranzAdatok->isSuccessful()) { ?>
    <?php if ($tranzAdatok->isCsakRegisztracio()) { ?>
        <h2 class="siker">Sikeres (teszt) regisztr�l�s</h2>
    <?php } else { ?>
        <h2 class="siker">Sikeres (teszt) v�s�rl�s</h2>
    <?php } ?>
<?php } else { ?>
    <h2 class="hiba">Sikertelen (teszt) v�s�rl�s</h2>
<?php } ?>

<?php if (!is_null($tranzAdatok)) { ?>

    <table class="eredmenytabla1">
      <tr>
        <th>Tranzakci� azonosit�:</th>
        <td><?php echo $tranzAdatok->getAzonosito() ?></td>
      </tr>
      <tr>
        <th>Shop ID:</th>
        <td><?php echo $tranzAdatok->getPosId() ?></td>
      </tr>

      <tr>
        <th>St�tusz k�d:</th>
        <td><?php echo $tranzAdatok->getStatuszKod() ?></td>
      </tr>
      <tr>
        <th>(POS) V�lasz k�d:</th>
        <td>
            <?php if (!$tranzAdatok->isSuccessful()) { 
                    $errorMsg = getMessageText($tranzAdatok->getPosValaszkod());
               }
               echo $tranzAdatok->getPosValaszkod() . ($errorMsg ? " - " . $errorMsg : "");
            ?>
        </td>
      </tr>
      <tr>
        <th>Teljesites id�pontja:</th>
        <td><?php echo $tranzAdatok->getTeljesites() ?></td>
      </tr>
    </table>  
    
    <?php if ($tranzAdatok->getStatuszKod() == "VEVOOLDAL_VISSZAVONT") return; ?>
    
    <table class="eredmenytabla1">
        <?php if (!$tranzAdatok->isCsakRegisztracio() && $tranzAdatok->isSuccessful()) { ?>
          <tr>
            <th>Authoriz�ci�s k�d:</th>
            <td><?php echo $tranzAdatok->getAuthorizaciosKod() ?></td>
          </tr>
        <?php } ?>

        <?php if (!$tranzAdatok->isCsakRegisztracio()) { ?>
            
            <?php if ($tranzAdatok->isNevKell()) { ?>
            <tr>
                <th>N�v</th>
                <td><?php echo $tranzAdatok->getNev() == null ? "" : $tranzAdatok->getNev() ?></td>
            </tr>
            <?php } ?>


            <?php if ($tranzAdatok->isOrszagKell()) { ?>
            <tr>
                <th>Orsz�g</th>
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
                <th>Telep�les</th>
                <td><?php echo $tranzAdatok->getVaros() == null ? "" : $tranzAdatok->getVaros() ?></td>
            </tr>
            <?php } ?>

            <?php if ($tranzAdatok->isUtcaHazszamKell()) { ?>
            <tr>
                <th>Utca / h�zsz�m</th>
                <td><?php echo $tranzAdatok->getUtcaHazszam() == null ? "" : $tranzAdatok->getUtcaHazszam() ?></td>
            </tr>
            <?php } ?>

            <?php if ($tranzAdatok->isIranyitoszamKell()) { ?>
            <tr>
                <th>Ir�ny�t�sz�m</th>
                <td><?php echo $tranzAdatok->getIranyitoszam() == null ? "" : $tranzAdatok->getIranyitoszam() ?></td>
            </tr>
            <?php } ?>

            <?php if ($tranzAdatok->isKozlemenyKell()) { ?>
            <tr>
                <th>K�zlem�ny</th>
                <td><?php echo $tranzAdatok->getKozlemeny() == null ? "" : $tranzAdatok->getKozlemeny() ?></td>
            </tr>
            <?php } ?>
        
        
        <?php } ?>

    </table>

<?php } else { ?>

    <table class="eredmenytabla1">
      <tr>
        <th>Tranzakci� azonosit�:</th>
        <td><?php echo $_REQUEST['tranzakcioAzonosito'] ?></td>
      </tr>
      <tr>
        <th>Shop ID:</th>
        <td><?php echo $_REQUEST['posId'] ?></td>
      </tr>
    </table>

<?php } ?>
<?php demo_footer(); ?>