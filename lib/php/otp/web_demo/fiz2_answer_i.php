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
    * - response: WResponse t�pus� objektum, mely a fizet�si 
    *   tranzakci�hoz tartoz� �sszes v�laszadatot tartalmazza
    * - tranzAdatok: WebShopFizetesValasz t�pus� objektum, a sikeres 
    *   v�s�rl�shoz tartoz� v�laszobjektum (value object)
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
    <h2 class="hiba">A tranzakci� nem hajt�dott v�gre vagy a banki v�lasz nem �rtelmezhet�.</h2>
<?php } else if ($response->isSuccessful()) { ?>
    <h2 class="siker">Banki v�laszk�d: <?php echo implode(', ', $response->getMessages()) ?></h2>
<?php } else { ?>
    <h2 class="hiba">Banki v�laszk�d: <?php echo implode(', ', $response->getMessages()) ?></h2>
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
        <th>Teljesites id�pontja:</th>
        <td><?php echo $tranzAdatok->getTeljesites() ?></td>
      </tr>
      <tr>
        <th>V�laszk�d:</th>
        <td><?php echo $tranzAdatok->getValaszKod() ?></td>
      </tr>
      <tr>
        <th>Authoriz�ci�s k�d:</th>
        <td><?php echo $tranzAdatok->getAuthorizaciosKod() ?></td>
      </tr>
      <?php if (!$response->isSuccessful()) { ?>
          <tr>
            <th>Hibak�d:</th>
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