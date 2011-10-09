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
	 * Adatok
	 */
	
	$nev = $felh[0]['elonev'] . " " .$felh[0]['vezeteknev'] . " " . $felh[0]['keresztnev'];
	$szuletes = $felh[0]['szuletesi_datum'];
	$irsz = $felh[0]['allando_irsz'];
	$helyseg = $felh[0]['allando_helyseg'];
	$kozterulet = $felh[0]['allando_kozterulet'] . " " . $felh[0]['allando_kozterulet_jellege'];
	$hazszam = $felh[0]['allando_hazszam'];
	
	$rendszam = $felh[0]['rendszam'];
	$gy = $felh[0]['gyartmany_sap'];
	$t = $felh[0]['tipus_sap'];
	
	$gyartm['mak_marka.sap_kod'] = $gy;
	$gyartm['mak_tipus.sap_kod'] = $t;
	
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
	$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:8pt;">'.$nev.'</p>';
	$pdf->writeHTMLCell(0,0,33,68,$html);
	//NEV

	//SZULETES
	//$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:12pt;">'.$nev.'||'.$name.'</p>';
	$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:8pt;">'.$szuletes.'</p>';
	$pdf->writeHTMLCell(0,0,124,68,$html);
	//SZULETES

	//IRSZ
	//$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:12pt;">'.$nev.'||'.$name.'</p>';
	$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:8pt;">'.$irsz.'</p>';
	$pdf->writeHTMLCell(0,0,31,72,$html);
	
	$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:8pt;">'.$helyseg.'</p>';
	$pdf->writeHTMLCell(0,0,61,72,$html);
	
	$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:8pt;">'.$kozterulet.'</p>';
	$pdf->writeHTMLCell(0,0,100,72,$html);
	
	$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:8pt;">'.$hazszam.'</p>';
	$pdf->writeHTMLCell(0,0,135,72,$html);
	
	$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:8pt;">'.$rendszam.'</p>';
	$pdf->writeHTMLCell(0,0,72,84.5,$html);
	
	$alvazszam = $_SESSION['chassis'];
	
	$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:8pt;">'.$alvazszam.'</p>';
	$pdf->writeHTMLCell(0,0,148,84.5,$html);
	
	$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:8pt;">'.$gyatmany.'</p>';
	$pdf->writeHTMLCell(0,0,48,88.5,$html);
	
	$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:8pt;">'.$tipus.'</p>';
	$pdf->writeHTMLCell(0,0,85,88.5,$html);
	
	//Dátum
	
	$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:8pt;">'.date("Y").'</p>';
	$pdf->writeHTMLCell(0,0,61,125,$html);
	
	$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:8pt;">'.date("m").'</p>';
	$pdf->writeHTMLCell(0,0,79.5,125,$html);
	
	$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:8pt;">'.date("d").'</p>';
	$pdf->writeHTMLCell(0,0,94,125,$html);
	
	$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:8pt;">'. date("Y") + 1 .'</p>';
	$pdf->writeHTMLCell(0,0,61,129,$html);
	
	$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:8pt;">'.date("m").'</p>';
	$pdf->writeHTMLCell(0,0,79.5,129,$html);
	
	$html = '<p stroke="0.2" fill="true" strokecolor="black" color="black" style="font-family:arial;font-weight:bold;font-size:8pt;">'.date("d").'</p>';
	$pdf->writeHTMLCell(0,0,94,129,$html);
	
	$main->close();
	
	$filenev = 'kotvenyek/' . $_SESSION['lastEmail'] . '.pdf';
	
	
	$pdf->Output($filenev, 'F');
	
	/*
	 * PDF VÉGE
	 */
	
?>