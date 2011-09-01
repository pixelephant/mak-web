<?php 

include 'gapi.class.php';

$email = 'pixelephantmedia@gmail.com';
$pass = 'pix3l3phant';
$report_id = '40822650';
    
$start_date = date("Y-m-d",strtotime("-31 days"));
$end_date = date("Y-m-d");

$ga = new gapi($email,$pass);

$ga->requestReportData($report_id,array('date'),array('visits'),array('date'),null,$start_date,$end_date);

$json = '{';
$json .= '"data":[';

$visits = 0;

foreach($ga->getResults() as $result)
{ 
  $json .= '{';
  $json .= '"date":"' . $result->getDate() . '",';
  $json .= '"visits":"' . $result->getVisits() . '"';
  $json .= '},';
  
  $visits += $result->getVisits();
  
}

$json = substr($json,0,-1);

$json .= ']';

$ga->requestReportData($report_id,array('visitorType'),array('avgTimeOnSite','bounces'));
$ga->getResults();

$avg_time = 0;
$bounces = 0;

foreach($ga->getResults() as $result){
	
	$avg_time += $result->getAvgTimeOnSite();
	$bounces += $result->getBounces();

}

$bounce_rate = ($bounces / $visits) * 100;

$json .= ',"avgTime":';
$json .= '"' . ($avg_time / 2) . '"';

$json .= ',"bounces":';
$json .= '"' . $bounce_rate . '"';


$json .= '}';

echo $json;

?>