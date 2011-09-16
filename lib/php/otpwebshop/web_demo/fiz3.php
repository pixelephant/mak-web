<?php

require_once("../simpleshop/fiz3_control.php");

if (array_key_exists("fizetesValasz", $_REQUEST)) {
    processDirectedToBackUrl(true);
}
else {
    process();
}


?>