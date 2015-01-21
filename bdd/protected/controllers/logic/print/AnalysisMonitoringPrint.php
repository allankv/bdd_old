<?php

include_once("protected/controllers/logic/print/Print.php");

require_once("protected/extensions/tcpdf/config/lang/eng.php");
require_once("protected/extensions/tcpdf/tcpdf.php");

// Extend the TCPDF class to create custom Header and Footer
class AnalysisMonitoringPDF extends TCPDF {
	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Line
		$this->Cell(0, 0.5, '', 'B', 1, 'L', false, '', 0, false, 'T', 'M');
		// Page number
		$this->SetFont('helvetica', 'I', 8);
		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
	}
	
	// Load table data from file
    public function LoadData($file) {
        // Read file lines
        $lines = file($file);
        $data = array();
        foreach($lines as $line) {
            $data[] = explode(';', chop($line));
        }
        return $data;
    }

    // Colored table
    public function ColoredTable($header, $data) {
        // Colors, line width and bold font
        $this->SetFillColor(244, 239, 217);
        $this->SetTextColor(136, 85, 34);
        $this->SetDrawColor(246, 168, 40);
        $this->SetLineWidth(0.3);
        $this->SetFont('Helvetica', 'B', 12);
        // Header
        $w = array(10, 90, 45, 35);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 8, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln(8.5);
        // Color and font restoration
        $this->SetFillColor(255);
        $this->SetTextColor(0);
        $this->SetDrawColor(221, 221, 221);
        $this->SetFont('Helvetica', '', 10);
        // Data
        $fill = 0;
        
        $dimensions = $this->getPageDimensions();
        foreach($data as $row) {
        
        	$rowcount = 0;
 
			//work out the number of lines required
			$rowcount = max($this->getNumLines($row[1], $w[1]), $this->getNumLines($row[2], $w[2]), $this->getNumLines($row[3], $w[3]));
		 
			$startY = $this->GetY();
		 
			if (($startY + $rowcount * 6) + $dimensions['bm'] > ($dimensions['hk'])) {
					//$this->Cell(array_sum($w), 0, '', '');
					$this->addPage();
			}
		 
			//cell height is 6 times the max number of cells
			$this->SetFillColorArray($this->toRGB($row[0]));
			$this->MultiCell($w[0], $rowcount * 6, '', 'LRTB', 'C', 1, 0);
			$this->MultiCell($w[1], $rowcount * 6, $row[1], 'LRTB', 'L', 0, 0);
			$this->MultiCell($w[2], $rowcount * 6, $row[2], 'LRTB', 'C', 0, 0);
			$this->MultiCell($w[3], $rowcount * 6, $row[3], 'LRTB', 'C', 0, 0);
		 
            $this->Ln();
        }
    }
    
    private function toRGB($Hex){
   
		if (substr($Hex,0,1) == "#")
			$Hex = substr($Hex,1);
			
		$R = substr($Hex,0,2);
		$G = substr($Hex,2,2);
		$B = substr($Hex,4,2);
		
		$R = hexdec($R);
		$G = hexdec($G);
		$B = hexdec($B);
		
		$RGB = array($R, $G, $B);
		
		return $RGB;
	}
}

class BasisOfRecordPDF extends AnalysisMonitoringPDF {
	//Page header
	public function Header() {
		// Logo
		$image_file = 'images/main/logo_bdd.jpg';
		$this->Image($image_file, 15, 5, '', 12.5, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false, false, false);
		// Title
		$this->SetTextColor(255, 163, 25);
		$this->SetFont('helvetica', 'B', 18);
		$this->Cell(0, 8, ' Biodiversity Data Digitizer', 0, 2, 'L', false, '', 0, false, 'T', 'M');
		// Subtitle
		$this->SetTextColor(0, 0, 0);
		$this->SetFont('helvetica', '', 10);
		$this->Cell(0, 2, '  Ferramentas de análise para registros de monitoramento - Base de registro', 0, 1, 'L', false, '', 0, false, 'T', 'M');
		// Line
		$this->SetFont('helvetica', '', 5);
		$this->Cell(0, 1, '', 'B', 1, 'L', false, '', 0, false, 'T', 'M');
	}
}

class InstitutionCodePDF extends AnalysisMonitoringPDF {
	//Page header
	public function Header() {
		// Logo
		$image_file = 'images/main/logo_bdd.jpg';
		$this->Image($image_file, 15, 5, '', 12.5, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false, false, false);
		// Title
		$this->SetTextColor(255, 163, 25);
		$this->SetFont('helvetica', 'B', 18);
		$this->Cell(0, 8, ' Biodiversity Data Digitizer', 0, 2, 'L', false, '', 0, false, 'T', 'M');
		// Subtitle
		$this->SetTextColor(0, 0, 0);
		$this->SetFont('helvetica', '', 10);
		$this->Cell(0, 2, '  Ferramentas de análise para registros de monitoramento - Código de Instituição', 0, 1, 'L', false, '', 0, false, 'T', 'M');
		// Line
		$this->SetFont('helvetica', '', 5);
		$this->Cell(0, 1, '', 'B', 1, 'L', false, '', 0, false, 'T', 'M');
	}
}

class CollectionCodePDF extends AnalysisMonitoringPDF {
	//Page header
	public function Header() {
		// Logo
		$image_file = 'images/main/logo_bdd.jpg';
		$this->Image($image_file, 15, 5, '', 12.5, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false, false, false);
		// Title
		$this->SetTextColor(255, 163, 25);
		$this->SetFont('helvetica', 'B', 18);
		$this->Cell(0, 8, ' Biodiversity Data Digitizer', 0, 2, 'L', false, '', 0, false, 'T', 'M');
		// Subtitle
		$this->SetTextColor(0, 0, 0);
		$this->SetFont('helvetica', '', 10);
		$this->Cell(0, 2, '  Ferramentas de análise para registros de monitoramento - Código de Coleção', 0, 1, 'L', false, '', 0, false, 'T', 'M');
		// Line
		$this->SetFont('helvetica', '', 5);
		$this->Cell(0, 1, '', 'B', 1, 'L', false, '', 0, false, 'T', 'M');
	}
}

class AnalysisMonitoringPrint extends Printer {
	public function generateData($rs, $lowercase, $colors) {
		$data = "";
		if ($rs['result']) {
			$i = 0;
			foreach ($rs['result'] as $analysis) {
				$data .= $colors[$i].';'.$analysis[$lowercase].';'.$analysis['count'].';'.$analysis['perc']."\n";
				$i++;
			}	
		}
		return $data;
	}
	public function printAnalysis($rs, $lowercase, $colors) {
		// create new PDF document
		switch ($lowercase) {
			case 'basisofrecord':	
				$pdf = new BasisOfRecordPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
				$uppercase = 'Base de Registro';
				break;
			case 'institutioncode':	
				$pdf = new InstitutionCodePDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
				$uppercase = 'Código de Instituição';
				break;
			case 'collectioncode':	
				$pdf = new CollectionCodePDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
				$uppercase = 'Código de Coleção';
				break;	
		}
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Biodiversity Data Digitizer');
		$pdf->SetTitle("Ferramentas de análise - " . $uppercase . " versus Número de Registros de Monitoramento");
		$pdf->SetSubject('Análise estatística - ' . $uppercase);
		$pdf->SetKeywords('BDD, ' . $uppercase . ', '. $lowercase);
		
		// set default header data
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
		
		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
		//set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		
		//set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		
		//set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		
		//set some language-dependent strings
		$pdf->setLanguageArray($l);
		
		// ---------------------------------------------------------
		
		// set font
		$pdf->SetFont('helvetica', '', 12);
		
		// add a page
		$pdf->AddPage();
		
		// print chart image
		$pdf->Image('@'.$rs['chart'], 45, 35);
		
		// print chart title
		$pdf->SetFont('helvetica', 'B', 14);
		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetX(0);
		$pdf->Cell($pdf->getPageWidth(), 0, $uppercase . ' versus Número de Registros de Monitoramento', '', 1, 'C', true, '', 0, false, 'T', 'M');

		//$pdf->addPage();
		
		
		$pdf->setY(130);
		
		//Column titles for the table
		$header = array('', $uppercase, 'Número de registros', 'Porcentagem');
		//Data loading for the table
		$txt = "tmp/bdd-analysismonitoringtools-" . $lowercase . "-data.txt";
		$file = fopen($txt,"w");
		fwrite($file, $this->generateData($rs, $lowercase, $colors));
		fclose($file);
		
		$data = $pdf->LoadData($txt);
		
		// print colored table
		$pdf->ColoredTable($header, $data);
		
		//Close and output PDF document
		
		$file = "tmp/bdd-".$lowercase."monitoring"."-".time().".pdf";
		$pdf->Output($file, 'F');
		
		//============================================================+
		// END OF FILE
		//============================================================+
				
		return $file;
	}
}	

?>