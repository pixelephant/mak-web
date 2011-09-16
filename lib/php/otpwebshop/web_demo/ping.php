<?php

/*

Banki rendszer elérhetõségének tesztelése PHP környezetbõl. Az indítást a
process metódus végzi, mely a banki SOAP felület közvetlen meghívásával
végez ping utasítást. 

A forráskód demonstrációs jellegû, szabadon módosítható.

@author Bodnár Imre, IQSys
@version 3.3.1

*/

if (!defined('WEBSHOP_LIB_DIR')) define('WEBSHOP_LIB_DIR', dirname(__FILE__) . '/../lib');

require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/WebShopService.php');

/**
* @desc Banki rendszer elérhetõségének tesztelése
*/
function process() {
    $service = new WebShopService();
    return $service->ping();                    
}


require_once('_header_footer.php');
demo_header($_REQUEST['func']);
demo_menu();
demo_title(); 

flush();

$response = process();

?>

<?php if ($response) { ?>
    <h2 class="siker">A Banki felület elérhetõ.</h2>
<?php } else { ?>
    <h2 class="hiba">A Banki felület nem érhetõ el!</h2>
<?php } ?>