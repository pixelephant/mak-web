<?php
	/*
	 * PDF - biztosítási kötvény előállítása komfort tagok számára
	 */
	
	require_once('lib/php/pdf/tcpdf/config/lang/eng.php');
	require_once('lib/php/pdf/tcpdf/tcpdf.php');
	
	require 'lib/php/Wixel/gump.class.php';
	require 'lib/php/class.db.php';
	require 'lib/php/class.mak.php';
	
	session_start();
	
	$main = new mak(true);
	
	$cond['e_mail'] = $_SESSION['lastEmail'];
	
	$felh = $main->get_felhasznalo($cond);
	
	/*
	 * Adatok
	 */
	
	$nev = $felh[0]['elonev'] . " " .$felh[0]['vezeteknev'] . " " . $felh[0]['keresztnev'];
	
	if($felh[0]['nem'] == 'C'){
		$nev = $felh[0]['cegnev'];
	}
	
	$szuletes = $felh[0]['szuletesi_datum'];
	$irsz = $felh[0]['allando_irsz'];
	$helyseg = $felh[0]['allando_helyseg'];
	$kozterulet = $felh[0]['allando_kozterulet'] . " " . $felh[0]['allando_kozterulet_jellege'];
	$hazszam = $felh[0]['allando_hazszam'];
	
	$rendszam = $felh[0]['rendszam'];
	$alvazszam = $felh[0]['alvazszam'];
	$gy = $felh[0]['gyartmany_sap'];
	$t = $felh[0]['tipus_sap'];
	
	$gyartm['mak_marka.sap_kod'] = $gy;
	$gyartm['mak_gyartmany.sap_kod'] = $t;
	
	$a = $main->get_gyartmany($gyartm);
	
	$gyartmany = $a[0]['marka'];
	$tipus = $a[0]['tipus'];
	
	class MYPDF extends TCPDF {
	    public function Header() {
	    
	    	$this->setJPEGQuality(100);
	
	        $bMargin = $this->getBreakMargin();
	
	        $auto_page_break = $this->AutoPageBreak;
	
	        $this->SetAutoPageBreak(false, 0);
	        
	        $img_file = 'lib/php/pdf/kotveny.jpg';
	
	        $this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 150, '', false, false, 0);
	        
	        $this->SetAutoPageBreak($auto_page_break, $bMargin);
	        
	        $this->setPageMark();
	    }
	}
	
	$pdf = new MYPDF(PDF_PAGE_ORIENTATION, 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);
	//$pdf = new MYPDF(PDF_PAGE_ORIENTATION, 'mm', PDF_PAGE_FORMAT, true, 'ISO-8859-2', false);
	
	$pdf->setJPEGQuality(100);
	
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('MAK');
	$pdf->SetTitle('Biztosítási kötvény');
	$pdf->SetSubject('Biztosítási kötvény');
	$pdf->SetKeywords('Biztosítási kötvény');
	
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
	$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:8pt;">'.$nev.'</p>';
	$pdf->writeHTMLCell(0,0,35,71,$html);
	//NEV

	//SZULETES
	//$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:12pt;">'.$nev.'||'.$name.'</p>';
	$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:8pt;">'.$szuletes.'</p>';
	$pdf->writeHTMLCell(0,0,124,71,$html);
	//SZULETES

	//IRSZ
	//$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:12pt;">'.$nev.'||'.$name.'</p>';
	$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:8pt;">'.$irsz.'</p>';
	$pdf->writeHTMLCell(0,0,36,75,$html);
	
	$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:8pt;">'.$helyseg.'</p>';
	$pdf->writeHTMLCell(0,0,61,75,$html);
	
	$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:8pt;">'.$kozterulet.'</p>';
	$pdf->writeHTMLCell(0,0,95,75,$html);
	
	$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:8pt;">'.$hazszam.'</p>';
	$pdf->writeHTMLCell(0,0,135,75,$html);
	
	$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:8pt;">'.$rendszam.'</p>';
	$pdf->writeHTMLCell(0,0,73,86.5,$html);
	
	$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:8pt;">'.$alvazszam.'</p>';
	$pdf->writeHTMLCell(0,0,148,86.5,$html);
	
	$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:8pt;">'.$gyartmany.'</p>';
	$pdf->writeHTMLCell(0,0,48,90,$html);
	
	$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:8pt;">'.$tipus.'</p>';
	$pdf->writeHTMLCell(0,0,86,90,$html);
	
	//Dátum
	
	$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:8pt;">'.date("Y").'</p>';
	$pdf->writeHTMLCell(0,0,63,125,$html);
	
	$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:8pt;">'.date("m").'</p>';
	$pdf->writeHTMLCell(0,0,81.5,125,$html);
	
	$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:8pt;">'.date("d",strtotime("+1 day")).'</p>';
	$pdf->writeHTMLCell(0,0,96,125,$html);
	
	$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:8pt;">'. date("Y",strtotime("+1 year")) .'</p>';
	$pdf->writeHTMLCell(0,0,63,129,$html);
	
	$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:8pt;">'.date("m").'</p>';
	$pdf->writeHTMLCell(0,0,81.5,129,$html);
	
	$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:8pt;">'.date("d").'</p>';
	$pdf->writeHTMLCell(0,0,96,129,$html);
	
	/*
	 * Keltezés
	 */
	
	$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:12pt;">'.date("Y.m.d").'</p>';
	$pdf->writeHTMLCell(0,0,40,197,$html);
	
	$main->close();
	
	$filenev = 'kotvenyek/' . $_SESSION['lastEmail'] . '.pdf';
	
	unset($_SESSION['lastEmail']);
	
	$pdf->Output($filenev, 'F');
	
	/*
	 * PDF VÉGE
	 */
	
?>