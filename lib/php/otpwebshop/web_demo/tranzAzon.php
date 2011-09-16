<?php

/*

Fizetési tranzakció azonosító generálás PHP környezetbõl. Az indítást a
process metódus végzi, mely a banki SOAP felület közvetlen meghívásával
elindítja a generáló tranzakciót. A kliens oldali böngészõ
mindaddig az oldal letöltésére fog várakozni, míg a tranzakció be nem
fejezõdött - a várakokázi idõ jellemzõen 0-1 másodperc.

A forráskód demonstrációs jellegû, szabadon módosítható.

@author Bodnár Imre, IQSys
@version 3.3

*/

if (!defined('WEBSHOP_LIB_DIR')) define('WEBSHOP_LIB_DIR', dirname(__FILE__) . '/../lib');

require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/WebShopService.php');

/**
* @desc Tranzakció generálás indítása
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
    <h2 class="siker">Sikeres azonosító generálás</h2>
        <?php } else { ?>
    <h2 class="hiba">Sikertelen azonosító generálás</h2>
<?php      }
    } else { ?>
    <h2 class="hiba">A generálás nem végrehajtható vagy a válasz nem értelmezhetõ!</h2>
<?php
   }
?>

<h3>Banki válaszkód: <?php echo implode(', ', $response->getMessages()) ?></h3>

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
        <th>Generált tranzakció azonosító:</th>
        <td><?php echo $answer->getAzonosito() ?></td>
      </tr>
      <tr>
        <th>Idõbélyeg:</th>
        <td><?php echo $answer->getTeljesites() ?></td>
      </tr>
  <?php } ?>
</table>