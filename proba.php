<?php
	/*
	 * PDF
	 */
	
	require_once('lib/php/pdf/tcpdf/config/lang/eng.php');
	require_once('lib/php/pdf/tcpdf/tcpdf.php');
	
	require 'lib/php/Wixel/gump.class.php';
	require 'lib/php/class.db.php';
	require 'lib/php/class.mak.php';
	
	session_start();
	
	$main = new mak();
	
	$cond['e_mail'] = $_SESSION['lastEmail'];
	
	$felh = $main->get_felhasznalo($cond);
	
	/*
	 * Tagsági szám generálása
	 */
	
	if($felh[0]['tagsagi_szam'] != '' && !is_null($felh[0]['tagsagi_szam']) && strlen($felh[0]['tagsagi_szam']) == 10){
		$szam = $felh[0]['tagsagi_szam'];
	}else{

		$col[0] = 'MAX(tagsagi_szam)+1 AS tagsagi_szam';
	
		$sql = "SELECT " . $col[0] . " FROM mak_felhasznalo WHERE tagsagi_szam LIKE '5%'";
		
		$q = $main->query($sql);
		
		$a = $main->results($q,$col);
		
		//print_r($a);
		
		if(is_null($a[0]['tagsagi_szam']) || $a[0]['tagsagi_szam'] == 'NULL'){
			$szam = "5000000001";
		}else{
			$szam = $a[0]['tagsagi_szam'];
		}
		
	}
	
	class MYPDF extends TCPDF {
	    public function Header() {
	    
	    	$this->setJPEGQuality(100);
	
	        $bMargin = $this->getBreakMargin();
	
	        $auto_page_break = $this->AutoPageBreak;
	
	        $this->SetAutoPageBreak(false, 0);
	        
	        $img_file = 'lib/php/pdf/visszaigazolas_' . $_SESSION['tagsag'] . '.jpg';
	
	        $this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 150, '', false, false, 0);
	        
	        $this->SetAutoPageBreak($auto_page_break, $bMargin);
	        
	        $this->setPageMark();
	    }
	}
	
	//$_REQUEST['nev'] = "Árvíztűrő tükörfúrógép";
	
	//$nev = iconv('UTF-8','Windows-1250',$_REQUEST['nev']);
	
	if($_SESSION['nem'] == 'C'){
		$nev = $_SESSION['cegnev'];
	}else{
		$nev = $_SESSION['vezeteknev'] . " " .$_SESSION['keresztnev'];
	}
	
	
	
	//$nev = utf8_encode("Árvíztűrő tükörfúrógép");
	//$nev = iconv("iso-8859-2","utf-8","Árvíztűrő tükörfúrógép");
	//$nev = "Árvíztűrő tükörfúrógép";
	/*
	$szam = '';
	
	for($i=0;$i<12;$i++){
		$szam .= rand(0,9);
	}
	*/
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);
	//$pdf = new MYPDF(PDF_PAGE_ORIENTATION, 'mm', PDF_PAGE_FORMAT, true, 'ISO-8859-2', false);
	
	$pdf->setJPEGQuality(100);
	
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('MAK');
	$pdf->SetTitle('Ideiglenes tagságikártya');
	$pdf->SetSubject('Ideiglenes tagságikártya');
	$pdf->SetKeywords('Ideiglenes tagságikártya');
	
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
	
	$main->close();
	
	$pdf->Output(str_replace(" ","",$nev) . '.pdf', 'FD');
	
	/*
	 * PDF VÉGE
	 */
	
?>