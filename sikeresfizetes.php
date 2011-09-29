<?php 

require 'lib/php/Wixel/gump.class.php';
require 'lib/php/class.db.php';
require 'lib/php/class.mak.php';

session_start();

$main = new mak(false);

/*
 * Sikeres fizetés
 */

if(isset($_GET['status']) && $_GET['status'] == 'success'){

	$adat['befizetes_datuma'] = date("Y-m-d");
	//$adat['ervenyesseg_datuma'] = date("Y-m-d",strtotime("+1 year"));
	$adat['statusz'] = '01';
	$adat['megerositve'] = '1';
	
	$cond['e_mail'] = $_SESSION['lastEmail'];
	
	$a = $main->update_felhasznalo($adat,$cond);

	$uzenet = 'Sikeres bankkártyás fizetés!';

	$felh = $main->get_felhasznalo($cond);
	
	$_SESSION['user_id'] = $felh[0]['id'];
	$_SESSION['keresztnev'] = $felh[0]['keresztnev'] . $felh[0]['kapcsolattarto_keresztnev'];
	$_SESSION['tagtipus'] = $felh[0]['tagtipus'];
	
	/*
	 * PDF
	 */
	
	require_once('lib/php/pdf/tcpdf/config/lang/eng.php');
	require_once('lib/php/pdf/tcpdf/tcpdf.php');
	
	class MYPDF extends TCPDF {
	    public function Header() {
	    
	    	$this->setJPEGQuality(100);
	
	        $bMargin = $this->getBreakMargin();
	
	        $auto_page_break = $this->AutoPageBreak;
	
	        $this->SetAutoPageBreak(false, 0);
	        
	        $img_file = 'visszaigazolas.jpg';
	
	        $this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 150, '', false, false, 0);
	        
	        $this->SetAutoPageBreak($auto_page_break, $bMargin);
	        
	        $this->setPageMark();
	    }
	}
	
	//$_REQUEST['nev'] = "Árvíztűrő tükörfúrógép";
	
	//$nev = iconv('UTF-8','Windows-1250',$_REQUEST['nev']);
	
	$nev = utf8_encode($_REQUEST['nev']);
	
	//$nev = utf8_encode("Árvíztűrő tükörfúrógép");
	//$nev = iconv("iso-8859-2","utf-8","Árvíztűrő tükörfúrógép");
	//$nev = "Árvíztűrő tükörfúrógép";
	
	$szam = '';
	
	for($i=0;$i<12;$i++){
		$szam .= rand(0,9);
	}
	
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);
	//$pdf = new MYPDF(PDF_PAGE_ORIENTATION, 'mm', PDF_PAGE_FORMAT, true, 'ISO-8859-2', false);
	
	$pdf->setJPEGQuality(100);
	
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('MAK');
	$pdf->SetTitle('Title');
	$pdf->SetSubject('Szábdzsekt');
	$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
	
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
	
	$pdf->SetMargins(5, 20, 5);
	
	$pdf->SetAutoPageBreak(TRUE, 20);
	
	//$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	
	$pdf->setLanguageArray($l);
	
	$pdf->setFontSubsetting(true);
	
	$pdf->SetFont('Arial', '', 12, '', true);
	
	$pdf->AddPage();
	
	//NEV
	//$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:12pt;">'.$nev.'||'.$name.'</p>';
	$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:12pt;">'.$nev.'</p>';
	$pdf->writeHTMLCell(0,0,140,257,$html);
	//NEV
	
	//AZONOSITO
	$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:12pt;">'.$szam.'</p>';
	$pdf->writeHTMLCell(0,0,140,266,$html);
	//AZONOSITO
	
	$pdf->Output('example_002.pdf', 'D');
	
	/*
	 * PDF VÉGE
	 */
	
}
?>
<!DOCTYPE HTML>
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html class="no-js" lang="en">
	<!--<![endif]-->
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" href="/favicon.ico">
		<link rel="apple-touch-icon" href="/apple-touch-icon.png">
		<meta charset="UTF-8">
		<meta content="Kulcsszó1, Kulcsszó2, Kulcsszó3" name="keywords"><meta content="Description szövege jön ide..." name="description">
		<base href="http://sfvm104.serverfarm.hu/mak/" />
		<title>Bank kártyás fizetés - Magyar Autóklub</title>		
		<link rel="stylesheet" href="lib/css/reset.css" />
		<link rel="stylesheet" href="lib/css/main.css" />
		<link rel="stylesheet" href="lib/css/sub.css" />
		<link rel="stylesheet" href="lib/smoothness/style.css" />
		<link rel="stylesheet" href="lib/css/register.css" />
		<script src="lib/js/modernizr-2.min.js"></script>
	</head>
	<body id="sikeresfizetes"
	<?php 
	if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != ''){
		echo ' class="logined"';
	}
	?>
	>
	<?php include 'modal.php';?>
	<div id="wrap">
		<div class="header-wrap">
			<div class="header-outer">
				<header class="wrapper">
					<?php include "header.php" ?> 
				</header>
			</div>
		</div>
	<nav>
		<?php
			echo $main->render_felso_menu('');
		?>
	</nav>
	<section id="main" class="wrapper">
		<aside>
			<?php include "newsletter.php" ?>
			<h2 id="">Bankkártyás fizetés</h2>
			<div id="subcontact">
				<h3>1/111-111</h3>
				<h4>web@autoklub.hu</h4>
			</div>
			<?php 
				echo $main->render_hirdetes('sikeresfizetes','','','');
			?>
		</aside>
		<section id="content">
			<h1>Bankkártyás fizetés</h1>
			<p><?php echo $uzenet;?></p>
		</section>
	</section>
	<?php include "cta.php" ?>
	<footer>
		<div class="footerIn">
			<div class="wrapper">
				<div id="footerNav">
					<?php 
						echo $main->render_also_menu();
					?>
				</div>
			</div>
		</div>
		<div id="fotterMiscWrap">	
			<div id="footerMisc">
				<?php include 'footer.php';?>
			</div>
		</div>
	</footer>
	</div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js">
		</script>
		<script>
window.jQuery || document.write('<script src="lib/js/jquery-1.6.2.js">\x3C/script>')
		</script>
		<script type="text/javascript" src="lib/js/ui-1.8.15.js">
		</script>
		<script type="text/javascript" src="lib/js/main.js">
		</script>
		<script type="text/javascript" src="lib/js/sub.js">
		</script>
		<script type="text/javascript">
			
		</script>
		<script>
var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
s.parentNode.insertBefore(g,s)}(document,'script'));
		</script>
	</body>
</html>
<?php 
$main->close();
?>