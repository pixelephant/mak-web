<?php

/*

Banki rendszer el�rhet�s�g�nek tesztel�se PHP k�rnyezetb�l. Az ind�t�st a
process met�dus v�gzi, mely a banki SOAP fel�let k�zvetlen megh�v�s�val
v�gez ping utas�t�st. 

A forr�sk�d demonstr�ci�s jelleg�, szabadon m�dos�that�.

@author Bodn�r Imre, IQSys
@version 3.3.1

*/

if (!defined('WEBSHOP_LIB_DIR')) define('WEBSHOP_LIB_DIR', dirname(__FILE__) . '/../lib');

require_once(WEBSHOP_LIB_DIR . '/iqsys/otpwebshop/WebShopService.php');

/**
* @desc Banki rendszer el�rhet�s�g�nek tesztel�se
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
    <h2 class="siker">A Banki fel�let el�rhet�.</h2>
<?php } else { ?>
    <h2 class="hiba">A Banki fel�let nem �rhet� el!</h2>
<?php } ?>