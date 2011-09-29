<?php
	/*
	 * PDF
	 */
	
	require_once('lib/php/pdf/tcpdf/config/lang/eng.php');
	require_once('lib/php/pdf/tcpdf/tcpdf.php');
	
	session_start();
	
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
	
	$szam = '';
	
	for($i=0;$i<12;$i++){
		$szam .= rand(0,9);
	}
	
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
	
	
	
	$pdf->Output($nev . '.pdf', 'D');
	
	/*
	 * PDF VÉGE
	 */
	
?>