<?php
	
include_once("protected/controllers/logic/print/Print.php");

require_once("protected/extensions/tcpdf/config/lang/eng.php");
require_once("protected/extensions/tcpdf/tcpdf.php");

// Extend the TCPDF class to create custom Header and Footer
class InteractionPDF extends TCPDF {
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
		$this->Cell(0, 2, '  Interaction record', 0, 1, 'L', false, '', 0, false, 'T', 'M');
		// Line
		$this->SetFont('helvetica', '', 5);
		$this->Cell(0, 1, '', 'B', 1, 'L', false, '', 0, false, 'T', 'M');
	}

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
}

class InteractionListPDF extends TCPDF {

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
		$this->Cell(0, 2, '  Interaction list', 0, 1, 'L', false, '', 0, false, 'T', 'M');
		// Line
		$this->SetFont('helvetica', '', 5);
		$this->Cell(0, 1, '', 'B', 1, 'L', false, '', 0, false, 'T', 'M');
	}

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
    public function ColoredTable($header,$data) {
    	// Line
    	$this->SetTextColor(0, 128, 0);
    	$this->SetDrawColor(0, 128, 0);
    	$this->SetLineWidth(0.8);
		$this->SetFont('helvetica', 'B', 16);
		$this->Cell(0, 1, 'List of Interaction Records', 'B', 1, 'L', false, '', 0, false, 'T', 'M');
		$this->Ln(5);
        // Colors, line width and bold font
        $this->SetFillColor(244, 239, 217);
        $this->SetTextColor(136, 85, 34);
        $this->SetDrawColor(246, 168, 40);
        $this->SetLineWidth(0.3);
        $this->SetFont('Helvetica', 'B', 10);
        // Header
        $w = array(36, 36, 36, 36, 36);
        
        $this->Cell(72, 8, 'Specimen 1', 1, 0, 'C', 1);
        $this->Cell($w[2], 16, $header[2], 1, 0, 'C', 1);
        $this->Cell(72, 8, 'Specimen 2', 1, 0, 'C', 1);
        $this->Ln();
        $this->Cell($w[0], 8, $header[0], 1, 0, 'C', 1);
        $this->Cell($w[1], 8, $header[1], 1, 0, 'C', 1);
        $this->Cell(36, 8, '', 'LBR', 0, 'C', 0);
        $this->Cell($w[3], 8, $header[3], 1, 0, 'C', 1);
        $this->Cell($w[4], 8, $header[4], 1, 0, 'C', 1);

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
			$rowcount = max($this->getNumLines($row[0], $w[0]), $this->getNumLines($row[1], $w[1]), $this->getNumLines($row[2], $w[2]), $this->getNumLines($row[3], $w[3]), $this->getNumLines($row[4], $w[4]));
		 
			$startY = $this->GetY();
		 
			if (($startY + $rowcount * 6) + $dimensions['bm'] > ($dimensions['hk'])) {
					//$this->Cell(array_sum($w), 0, '', '');
					$this->addPage();
			}
		 
			//cell height is 6 times the max number of cells
			$this->MultiCell($w[0], $rowcount * 6, $row[0], 'LRTB', 'C', 0, 0);
			$this->MultiCell($w[1], $rowcount * 6, $row[1], 'LRTB', 'C', 0, 0);
			$this->MultiCell($w[2], $rowcount * 6, $row[2], 'LRTB', 'C', 0, 0);
			$this->MultiCell($w[3], $rowcount * 6, $row[3], 'LRTB', 'C', 0, 0);
			$this->MultiCell($w[4], $rowcount * 6, $row[4], 'LRTB', 'C', 0, 0);
		 
            $this->Ln();
        }
    }
}

class InteractionPrint extends Printer {
	
	private function generateTableInteraction($interaction) {
	// define line break
	$lnbk = '
		<tr>
			<td colspan="3"></td>
		</tr>
	';

	// Specimen 1 table
	$tbl = '
	<table class="dataTable">
		<tr>
	 		<th class="tableTitle" colspan="3">Specimen 1</th>
	 	</tr>
	';
	$tbl .= $lnbk;
	
	$tbl .= $this->addRow("Institution", $interaction->specimen1->recordlevelelement->institutioncode->institutioncode);
	$tbl .= $this->addRow("Collection", $interaction->specimen1->recordlevelelement->collectioncode->collectioncode);
	$tbl .= $this->addRow("Catalog Number", $interaction->specimen1->occurrenceelement->catalognumber);
	$tbl .= $this->addRow("Taxonomic Element", $interaction->specimen1->taxonomicelement->scientificname->scientificname);
		
	$tbl .= $lnbk;		
	$tbl .= '</table>';
	
	
	// Specimen 2 table
	$tbl .= '
	<table class="dataTable">
		<tr>
	 		<th class="tableTitle" colspan="3">Specimen 2</th>
	 	</tr>
	';
	$tbl .= $lnbk;
	
	$tbl .= $this->addRow("Institution", $interaction->specimen2->recordlevelelement->institutioncode->institutioncode);
	$tbl .= $this->addRow("Collection", $interaction->specimen2->recordlevelelement->collectioncode->collectioncode);
	$tbl .= $this->addRow("Catalog Number", $interaction->specimen2->occurrenceelement->catalognumber);
	$tbl .= $this->addRow("Taxonomic Element", $interaction->specimen2->taxonomicelement->scientificname->scientificname);
		
	$tbl .= $lnbk;	
	$tbl .= '</table>';
	
	// Interaction table
	$tbl .= '
	<table class="dataTable">
		<tr>
	 		<th class="tableTitle" colspan="3">Interaction</th>
	 	</tr>
	';
	$tbl .= $lnbk;
	
	$tbl .= $this->addRow("Interaction Type", $interaction->interactiontype->interactiontype);
	$tbl .= $this->addRow("Interaction Related Information", $interaction->interactionrelatedinformation);
	
	$tbl .= $lnbk;	
	$tbl .= '</table>';
	
	return  $tbl;;
}
	
	/*private function addRowListInteraction($interaction){
		$row = '
		<tr>
			<td>'.$interaction['scientificname1'].'</td>
			<td>'.$interaction['catalognumber1'].'</td>
			<td>'.$interaction['interactiontype'].'</td>
			<td>'.$interaction['scientificname2'].'</td>
			<td>'.$interaction['catalognumber2'].'</td>
		</tr>
		';
		return $row;
	}

	private function generateTableList($rs) {
		// section Title
		$tbl = '
			<table class="dataTable">
				<tr>
			 		<th class="tableTitle" colspan="2">List of Interaction Records</th>
			 	</tr>
			 	<tr>
					<td colspan="2"></td>
				</tr>
			</table>
		';
		
		// begin table content
		$tblcontent = "";
		
		if ($rs['count']) {
			$tblcontent = '
				<table class="tableList">
					<tr>
			 			<th colspan="2">Specimen 1</th>
			 			<th rowspan="2">Interaction Type</th>
			 			<th colspan="2">Specimen 2</th>
			 		</tr>
			 		<tr>
			 			<th>Taxonomic Element</th>
			 			<th>Catalog Number</th>
			 			<th>Taxonomic Element</th>
			 			<th>Catalog Number</th>
			 		</tr>
			';
			foreach ($rs['result'] as $interaction) {
				$tblcontent .= $this->addRowListInteraction($interaction);
			}
		}
			
		if ($tblcontent) {
			$tbl .= $tblcontent;
			// end table
			$tbl .= '</table>';
		} else {
			$tbl = "";
		}
		
		return  $tbl;
	}*/
	
	private function generateDataList($rs) {
		$data = "";
		if ($rs['count']) {
			foreach ($rs['result'] as $interaction) {
				$data .= $interaction['scientificname1'].';'.$interaction['catalognumber1'].';'.$interaction['interactiontype'].';'.$interaction['scientificname2'].';'.$interaction['catalognumber2']."\n";
			}	
		}
		return $data;
	}

	public function printInteraction($interaction) {
		// create new PDF document
		$pdf = new InteractionPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Biodiversity Data Digitizer');
		$pdf->SetTitle('Interaction record Id='.$interaction->idinteraction);
		$pdf->SetSubject('Specimen occurrence record');
		$pdf->SetKeywords('BDD, interaction');
		
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
		
		// get css from protected/controllers/logic/print/Print.php
		$css = $this->getCss();
		
		//============================================================+
		// Build HTML table
		//============================================================+
		
		$tbl = $css;
		
		$tbl .= $this->generateTableInteraction($interaction);
		
		$pdf->writeHTML($tbl, true, false, false, false, '');
		
		// ---------------------------------------------------------
		
		//Close and output PDF document
		$file = "tmp/bdd-interaction-".$interaction->idinteraction.".pdf";
		$pdf->Output($file, 'F');
		
		//============================================================+
		// END OF FILE
		//============================================================+
				
		return $file;

	}
	
	public function printInteractionList($rs) {
		// create new PDF document
		$pdf = new InteractionListPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Biodiversity Data Digitizer');
		$pdf->SetTitle('Interaction List');
		$pdf->SetSubject('List of interaction records');
		$pdf->SetKeywords('BDD, interaction');
		
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
		
		//============================================================+
		// Build table
		//============================================================+
		
		//Column titles
		$header = array('Taxonomic Element', 'Catalog Number', 'Interaction Type', 'Taxonomic Element', 'Catalog Number');
		
		//Data loading
		$txt = "tmp/bdd-interactionList-data.txt";
		$file = fopen($txt,"w");
		fwrite($file, $this->generateDataList($rs));
		fclose($file);
		
		$data = $pdf->LoadData($txt);
		
		// print colored table
		$pdf->ColoredTable($header, $data);
		
		// ---------------------------------------------------------
		
		//Close and output PDF document
		
		$pathToFile = "tmp/bdd-interactionList-".time().".pdf";

		$pdf->Output($pathToFile, 'F');		
		
		//============================================================+
		// END OF FILE
		//============================================================+
				
		return $pathToFile;

	}
}

?>