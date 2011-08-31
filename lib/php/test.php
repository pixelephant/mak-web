<?php 
	
	//header('Content-Type: text/html; charset=utf-8');

	include_once 'class.db.php';
	include_once 'class.mak.php';
	include_once 'Wixel/gump.class.php';
	
	$a = new mak(true);
/*
	$tartalom_array['oldal'] = 'main';
	$tartalom_array['cim'] = 'Insert tartalom';
	echo 'Csuhajjé árvíztűrő tükörfúrógép';
	$tartalom_array['szoveg'] = 'Csuhajjé árvíztűrő tükörfúrógép';
	$tartalom_array['kep'] = 'funpic.jpg';
	$tartalom_array['alt'] = 'Fánpik';
	
	print_r($a->insert_tartalom($tartalom_array));
	
	$sql = "INSERT INTO mak_tartalom (cim,szoveg) VALUES ('Cím','Árvíztűrő tükörfúrógép')";
	
	$a->query($sql);
	*/
	/*$keres = 'Ez a';
	
	print_r($a->get_tartalom_kereses($keres));
	*/
	
	$adatok['tagsagi_szam'] = '11111111111';
	$adatok['e_mail'] = 'test@mak.hu';
	
	$b = $a->get_adatok_regisztraciohoz($adatok);
	/*
	foreach($b as $k => $v){
		if($k !== 'count'){
			$b[$k][0] = addcslashes($v, "\v\t\n\r\f\"\\/");
			//$b[$k][0] = addslashes($v);
		}
	}
	*/
	/*
	print_r($b);
	
	$c = (json_encode($b));
	
	print_r($c);
	
	$c = addslashes($c);
	
	print_r($c);
	*/
	
	print_r(json_encode($b));
	
	$a->close();
	
?>