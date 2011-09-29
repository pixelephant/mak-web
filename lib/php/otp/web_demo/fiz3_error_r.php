<?php 
    /**
    * @desc P�lda olyan eredm�ny oldalra, melyre a h�romszerepl�s
    * fizet�s sikertelen lefut�sa ut�n t�rt�nik a vez�rl�s�tad�s
    * b�ng�sz� oldali redirect utas�t�ssal.
    * 
    * Ilyenkor csup�n h�rom request GET param�ter �ll rendelkez�sre,
    * azokkal a nevekkel, amik a ketszereplosshop.conf f�jlban
    * tal�lhat�k, melyek alap�rtelmez�s szerint:
    * - posId
    * - tranzakcioAzonosito
    * - hibakod
    * 
    * E h�rom param�ter azonban el�g arra, hogy ig�ny eset�n lek�rdezhet�
    * majd megjelen�thet� legyen a tranzakci� �sszes adata. Ehhez haszn�lhat�
    * k�zvetlen�l a WebShopService->tranzakcioStatuszLekerdezes
    * met�dus, de enn�l egyszer�bben kezelhet� a fiz3_control.php p�ld�ban szerepl�
    * processDirectedToBackUrl() f�ggv�nyh�v�s is! (Ut�bbi haszn�lja a 
    * fent eml�tett REQUEST param�tereket!)
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
        echo "Sikertelen (teszt) v�s�rl�s";
      else
        echo "A (teszt) v�s�rl�s nem indult el vagy a banki v�lasz nem el�rtelmezhet�.";
   ?>
</h2>

<table class="eredmenytabla1">
  <tr>
    <th>Tranzakci� azonosit�:</th>
    <td><?php echo $_REQUEST['tranzakcioAzonosito'] ?></td>
  </tr>
  <tr>
    <th>Shop ID:</th>
    <td><?php echo $_REQUEST['posId'] ?></td>
  </tr>
  <?php if ($_REQUEST['hibakod']) { ?>
  <tr>
    <th>Hibak�d:</th>
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