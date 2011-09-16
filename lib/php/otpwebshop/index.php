<?php

$dir_path = str_replace( $_SERVER['DOCUMENT_ROOT'], "", dirname(realpath(__FILE__)) ) . DIRECTORY_SEPARATOR; 

echo $dir_path.'<br/>';

echo dirname(__FILE__)

?>