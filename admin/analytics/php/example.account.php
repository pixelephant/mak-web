<?php
define('ga_email','pixelephantmedia@gmail.com');
define('ga_password','pix3l3phant');

require 'gapi.class.php';

$ga = new gapi(ga_email,ga_password);

$ga->requestAccountData();

foreach($ga->getResults() as $result)
{
  echo $result . ' (' . $result->getProfileId() . ")<br />";
}