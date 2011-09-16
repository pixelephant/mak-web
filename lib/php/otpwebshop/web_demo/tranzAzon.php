<?php

/*

Fizet�si tranzakci� azonos�t� gener�l�s PHP k�rnyezetb�l. Az ind�t�st a
process met�dus v�gzi, mely a banki SOAP fel�let k�zvetlen megh�v�s�val
elind�tja a gener�l� tranzakci�t. A kliens oldali b�ng�sz�
mindaddig az oldal let�lt�s�re fog v�rakozni, m�g a tranzakci� be nem
fejez�d�tt - a v�rakok�zi id� jellemz�en 0-1 m�sodperc.

A forr�sk�d demonstr�ci�s jelleg�, szabadon m�dos�that�.

@author Bodn�r Imre, IQSys
@version 3.3

*/

if (!defined('WEBSHOP_LIB_DIR')) define('WEBSHOP_LIB_DIR', dirname(__FILE__) . '/../lib');

require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/WebShopService.php');

/**
* @desc Tranzakci� gener�l�s ind�t�sa
*/
function process() {

    $service = new WebShopService();

    $posId = $_REQUEST["posId"];

    $response =  $service->tranzakcioAzonositoGeneralas($posId);

    if ($response) {
        syslog(LOG_NOTICE, "Tranzakcio generalas keres kuldes: " . $posId . " - " . implode($response->getMessages()));
    }
    else {
        syslog(LOG_ERR, "Tranzakcio generalas keres kuldes: " . $posId . " - NEM ERTELMEZHETO VALASZ!");
    }
 
    return $response;        
}


require_once('_header_footer.php');
demo_header($_REQUEST['func']);
demo_menu();
demo_title(); 

/*
        require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/util/SignatureUtils.php' . $phpversion{0});
    $service = new WebShopService();

        $signatureFields = array(0 => '#02299991');
        $signatureText = SignatureUtils::getSignatureText($signatureFields);

        $pkcs8PrivateKey = SignatureUtils::loadPrivateKey($service->getPrivKeyFileName($service->property, $posId));
        $signature = SignatureUtils::generateSignature($signatureText, $pkcs8PrivateKey);

return;        
*/
$response = process();

?>

<?php if (!is_null($response) && $response->isFinished()) { 
        if ($response->isSuccessful()) { ?>
    <h2 class="siker">Sikeres azonos�t� gener�l�s</h2>
        <?php } else { ?>
    <h2 class="hiba">Sikertelen azonos�t� gener�l�s</h2>
<?php      }
    } else { ?>
    <h2 class="hiba">A gener�l�s nem v�grehajthat� vagy a v�lasz nem �rtelmezhet�!</h2>
<?php
   }
?>

<h3>Banki v�laszk�d: <?php echo implode(', ', $response->getMessages()) ?></h3>

<table class="eredmenytabla1">
  <tr>
    <th>Shop ID:</th>
    <td><?php echo $_REQUEST['posId'] ?></td>
  </tr>
  <?php 
    if (!is_null($response) && $response->isSuccessful()) {  
        $answer = $response->getAnswer(); 
  ?>
      <tr>
        <th>Gener�lt tranzakci� azonos�t�:</th>
        <td><?php echo $answer->getAzonosito() ?></td>
      </tr>
      <tr>
        <th>Id�b�lyeg:</th>
        <td><?php echo $answer->getTeljesites() ?></td>
      </tr>
  <?php } ?>
</table>