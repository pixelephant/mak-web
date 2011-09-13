<?php 

include '../../../lib/php/Wixel/gump.class.php';
include '../../../lib/php/class.db.php';
include '../../../lib/php/class.mak.php';

$main = new mak();

/*
 * $_POST-ban kapott változók mentése
 */

$filter_op['cn'] = 'LIKE';
$filter_op['nc'] = 'NOT LIKE';
$filter_op['eq'] = '=';
$filter_op['ne'] = '!=';
$filter_op['bw'] = 'LIKE';
$filter_op['bn'] = 'NOT LIKE';
$filter_op['ew'] = 'LIKE';
$filter_op['en'] = 'NOT LIKE';

$search = $_POST['_search'];
$filters = str_replace("\\","",$_POST['filters']);
$nd = $_POST['nd'];
$page = (int)$_POST['page'];
$q = $_POST['q'];
$rows = (int)$_POST['rows'];
$sidx = $_POST['sidx'];
$sord = $_POST['sord'];

$cond['orderby'] = $sidx . ' ' . $sord;
$col = 'id,mak_url,kep,alt,cel_url,utolso_mutatas';

if($search == 'true'){

	$a = json_decode($filters,true);
	
	foreach($a['rules'] as $k => $v){
		
		$cond[$a['rules'][$k]['field']]['and_or'] = $a['groupOp'];
		$cond[$a['rules'][$k]['field']]['rel'] = $filter_op[$a['rules'][$k]['op']];
		
		switch ($a['rules'][$k]['op']){
			case "cn":
				$cond[$a['rules'][$k]['field']]['val'] = '%'.$a['rules'][$k]['data'].'%';
				break;
			case "bw":
				$cond[$a['rules'][$k]['field']]['val'] = $a['rules'][$k]['data'].'%';
				break;
			case "bn":
				$cond[$a['rules'][$k]['field']]['val'] = $a['rules'][$k]['data'].'%';
				break;
			case "ew":
				$cond[$a['rules'][$k]['field']]['val'] = '%'.$a['rules'][$k]['data'];
				break;
			case "en":
				$cond[$a['rules'][$k]['field']]['val'] = '%'.$a['rules'][$k]['data'];
				break;
			case "nc":
				$cond[$a['rules'][$k]['field']]['val'] = '%'.$a['rules'][$k]['data'].'%';
				break;
			
			default:
				$cond[$a['rules'][$k]['field']]['val'] = $a['rules'][$k]['data'];
		}
	}

}

$hirdetes = $main->get_hirdetes($cond,$col);

/*
 * Összesen hány találati oldal van?
 */

$total = floor( $hirdetes['count'] / $rows);

if($total == 0 && $hirdetes['count'] > 0){
	$total = 1;
}

/*
 * Válasz json összeállítása
 */

$json = '{"page":"' . $page . '",';
$json .= '"total":' . $total . ',';

/*
 * Cellák felépítése
 * 
 * Cella sorrend:
 * id,mak_url,kep,alt,cel_url,utolso_mutatas
 * 
 */

$json .= '"rows":[';

for($i = 0; $i < $hirdetes['count']; $i++){

	$json .= '{"id":"' . $hirdetes[$i]['id'] . '",';
	$json .= '"cell":[';
	
	foreach($hirdetes[$i] as $mezo => $ertek){
		$json .= '"' . $ertek . '",';
	}
	
	$json = substr($json,0,-1);
	
	$json .= ']},';

}

if($hirdetes['count'] > 0){
	$json = substr($json,0,-1);
}

$json .= ']';
$json .= '}';

//'{"page":"1","total":2,"records":"13","rows":[{"id":"13","cell":["13","2007-10-06","Client 3","1000.00","0.00","1000.00",null]},{"id":"12","cell":["12","2007-10-06","Client 2","700.00","140.00","840.00",null]},{"id":"11","cell":["11","2007-10-06","Client 1","600.00","120.00","720.00",null]},{"id":"10","cell":["10","2007-10-06","Client 2","100.00","20.00","120.00",null]},{"id":"9","cell":["9","2007-10-06","Client 1","200.00","40.00","240.00",null]},{"id":"8","cell":["8","2007-10-06","Client 3","200.00","0.00","200.00",null]},{"id":"7","cell":["7","2007-10-05","Client 2","120.00","12.00","134.00",null]},{"id":"6","cell":["6","2007-10-05","Client 1","50.00","10.00","60.00",""]},{"id":"5","cell":["5","2007-10-05","Client 3","100.00","0.00","100.00","no tax at all"]},{"id":"4","cell":["4","2007-10-04","Client 3","150.00","0.00","150.00","no tax"]}],"userdata":{"amount":3220,"tax":342,"total":3564,"name":"Totals:"}}';

$main->close();

echo $json;

?>
