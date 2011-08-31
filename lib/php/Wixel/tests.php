#!/usr/bin/php -q
<?php

require "gump.class.php";

$rules = array(
	'missing'   	=> 'required',
	'email'     	=> 'valid_email',
	'max_len'   	=> 'max_len,1',
	'min_len'   	=> 'min_len,4',
	'exact_len' 	=> 'exact_len,10',
	'alpha'	       	=> 'alpha',
	'alpha_numeric' => 'alpha_numeric',
	'alpha_dash'	=> 'alpha_dash',
	'numeric'		=> 'numeric',
	'integer'		=> 'integer',
	'boolean'		=> 'boolean',
	'float'			=> 'float',
	'valid_url'		=> 'valid_url',
	'url_exists'	=> 'url_exists',
	'valid_ip'		=> 'valid_ip'
);

$invalid_data = array(
	'missing'   	=> '',
	'email'     	=> "not a valid email\r\n",
	'max_len'   	=> "1234567890",
	'min_len'   	=> "1",
	'exact_len' 	=> "123456",
	'alpha'	       	=> "*(^*^*&",
	'alpha_numeric' => "abcdefg12345+\r\n\r\n\r\n",
	'alpha_dash'	=> "ab<script>alert(1);</script>cdefg12345-_+",
	'numeric'		=> "one, two\r\n",
	'integer'		=> "1,003\r\n\r\n\r\n\r\n",
	'boolean'		=> "this is not a boolean\r\n\r\n\r\n\r\n",
	'float'			=> "not a float\r\n",
	'valid_url'		=> "\r\n\r\nhttp://add",
	'url_exists'	=> "http://asdasdasd354.gov",
	'valid_ip'		=> "google.com"
);

$valid_data = array(
	'missing'   	=> 'This is not missing',
	'email'     	=> 'sean@wixel.net',
	'max_len'   	=> '1',
	'min_len'   	=> '1234',
	'exact_len' 	=> '1234567890',
	'alpha'	       	=> 'abcdefg',
	'alpha_numeric' => 'abcdefg12345',
	'alpha_dash'	=> 'abcdefg12345-_',
	'numeric'		=> 2.00,
	'integer'		=> 3,
	'boolean'		=> FALSE,
	'float'			=> 10.10,
	'valid_url'		=> 'http://wixel.net',
	'url_exists'	=> 'http://wixel.net',	
	'valid_ip'		=> '69.163.138.62'
);

echo "\nBEFORE SANITIZE:\n\n";

//print_r($invalid_data);

echo "\nAFTER SANITIZE:\n\n";

//print_r(GUMP::sanitize($invalid_data));

echo "\nTHESE ALL FAIL:\n\n";

print_r(GUMP::validate($invalid_data, $rules));

/*if(GUMP::validate($valid_data, $rules))
{
  echo "\nTHESE ALL SUCCEED:\n\n";
  
  print_r($valid_data);
}*/

echo "\nDONE\n\n";