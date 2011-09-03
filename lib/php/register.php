<?php 

include 'Wixel/gump.class.php';

include 'class.db.php';
include 'class.mak.php';

$main = new mak(false);

$form = array();
$member = array();

parse_str($_POST['formData'], $form);
parse_str($_POST['memberData'], $member);

print_r($form);
print_r($member);

/*
 * Természetes személy regisztrációja
 */

if($form['registerRadio'] == 'nat'){

}

/*
 * Cég regisztrációja
 */

if($form['registerRadio'] == 'co'){

}


$main->close();
?>