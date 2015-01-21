<?php

include_once("protected/controllers/logic/print/Print.php");

require_once("protected/extensions/tcpdf/config/lang/eng.php");
require_once("protected/extensions/tcpdf/tcpdf.php");

// Extend the TCPDF class to create custom Header and Footer
class ReferencePDF extends TCPDF {

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
		$this->Cell(0, 2, '  Reference Record', 0, 1, 'L', false, '', 0, false, 'T', 'M');
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
		$this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
	}
}

class ReferenceListPDF extends TCPDF {

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
		$this->Cell(0, 2, '  Reference list', 0, 1, 'L', false, '', 0, false, 'T', 'M');
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
		$this->Cell(0, 1, 'List of Reference Records', 'B', 1, 'L', false, '', 0, false, 'T', 'M');
		$this->Ln(5);
        // Colors, line width and bold font
        $this->SetFillColor(244, 239, 217);
        $this->SetTextColor(136, 85, 34);
        $this->SetDrawColor(246, 168, 40);
        $this->SetLineWidth(0.3);
        $this->SetFont('Helvetica', 'B', 12);
        // Header
        $w = array(70, 30, 80);
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
			$rowcount = max($this->getNumLines($row[0], $w[0]), $this->getNumLines($row[1], $w[1]), $this->getNumLines($row[2], $w[2]));
		 
			$startY = $this->GetY();
		 
			if (($startY + $rowcount * 6) + $dimensions['bm'] > ($dimensions['hk'])) {
					//$this->Cell(array_sum($w), 0, '', '');
					$this->addPage();
			}
		 
			//cell height is 6 times the max number of cells
			$this->MultiCell($w[0], $rowcount * 6, $row[0], 'LRTB', 'L', 0, 0);
			$this->MultiCell($w[1], $rowcount * 6, $row[1], 'LRTB', 'C', 0, 0);
			$this->MultiCell($w[2], $rowcount * 6, $row[2], 'LRTB', 'L', 0, 0);
		 
            $this->Ln();
        }
    }
}

class ReferencePrint extends Printer {

	private function generateTableMainInformation($reference) {
	// define line break
	$lnbk = '
		<tr>
			<td colspan="3"></td>
		</tr>
	';

	// begin table
	$tbl = '
	<table class="dataTable">
		<tr>
	 		<th class="tableTitle" colspan="3">Main Information</th>
	 	</tr>
	';
	
	// line break
	$tbl .= $lnbk;
	
	// table content
	$tblcontent = "";
	
	//------------------------------------------------------------+
	
	$keyword = "";
    foreach ($reference->keyword as $value) {
        $keyword .= $value->keyword . "; ";
    }
    $keyword = substr($keyword, 0, -2);
	
	$creator = "";
    foreach ($reference->creator as $value) {
        $creator .= $value->creator . "; ";
    }
    $creator = substr($creator, 0, -2) ;
	
	if ($reference->subtypereference->subtypereference || $reference->title || $keyword || $creator || $reference->publicationyear || 
		$reference->source->source) {
	
		$tblcontent .= $this->addRow(CHtml::activeLabelEx(SubtypeReferenceAR::model(), 'subtypereference'), $reference->subtypereference->subtypereference);
		$tblcontent .= $this->addRow(CHtml::activeLabelEx($reference, "title"), $reference->title);
		$tblcontent .= $this->addRow(CHtml::activeLabel(KeywordAR::model(), 'keyword'), $keyword);
		$tblcontent .= $this->addRow(CHtml::activeLabel(CreatorAR::model(), 'creator'), $creator);
		$tblcontent .= $this->addRow(CHtml::activeLabel($reference, 'publicationyear'), $reference->publicationyear);
		$tblcontent .= $this->addRow(CHtml::activeLabel(SourceAR::model(), 'source'), $reference->source->source);
	}
	
	//------------------------------------------------------------+

	if ($tblcontent) {
		$tbl .= $tblcontent;
		// end table
		$tbl .= '</table>';
	} else {
		$tbl = "";
	}
	
	return  $tbl;
}
	
	private function generateTableOtherInformation($reference) {
	// define line break
	$lnbk = '
		<tr>
			<td colspan="3"></td>
		</tr>
	';

	// begin table
	$tbl = '
	<table class="dataTable">
		<tr>
			<td colspan="3"></td>
		</tr>
		<tr>
	 		<th class="tableTitle" colspan="3">Other Information</th>
	 	</tr>
	';
	
	// line break
	$tbl .= $lnbk;
	
	// table content
	$tblcontent = "";
	
	//------------------------------------------------------------+
	
	$afiliation = "";
    foreach ($reference->afiliation as $value) {
        $afiliation .= $value->afiliation . "; ";
    }
    $afiliation = substr($afiliation, 0, -2);
    
    $biome = "";
    foreach ($reference->biome as $value) {
        $biome .= $value->biome . "; ";
    }
    $biome = substr($biome, 0, -2);
    
    $plantspecies = "";
    foreach ($reference->plantspecies as $value) {
        $plantspecies .= $value->plantspecies . "; ";
    }
    $plantspecies = substr($plantspecies, 0, -2);
    
    $plantfamily = "";
    foreach ($reference->plantfamily as $value) {
        $plantfamily .= $value->plantfamily . "; ";
    }
    $plantfamily = substr($plantfamily, 0, -2);
    
    $plantcommonname = "";
	foreach ($reference->plantcommonname as $value) {
	    $plantcommonname .= $value->plantcommonname . "; ";
	}
	$plantcommonname = substr($plantcommonname, 0, -2);

	$pollinatorspecies = "";
    foreach ($reference->pollinatorspecies as $value) {
        $pollinatorspecies .= $value->pollinatorspecies . "; ";
    }
    $pollinatorspecies = substr($pollinatorspecies, 0, -2);
    
    $pollinatorfamily = "";
    foreach ($reference->pollinatorfamily as $value) {
        $pollinatorfamily .= $value->pollinatorfamily . "; ";
    }
    $pollinatorfamily = substr($pollinatorfamily, 0, -2);
    
    $pollinatorcommonname = "";
    foreach ($reference->pollinatorcommonname as $value) {
        $pollinatorcommonname .= $value->pollinatorcommonname . "; ";
    }
    $pollinatorcommonname = substr($pollinatorcommonname, 0, -2);
    
	if ($reference->language->language || $afiliation || $reference->publisher->publisher || $biome || $plantspecies || $plantfamily || $plantcommonname ||
		$pollinatorspecies || $pollinatorfamily || $pollinatorcommonname || $reference->datedigitized || $reference->subject || $reference->abstract || 
		$reference->observation || $reference->isbnissn || $reference->url || $reference->doi || $reference->bibliographiccitation || abc9) {
	
		$tblcontent .= $this->addRow(CHtml::activeLabel(LanguageAR::model(), 'language'), $reference->language->language);
		$tblcontent .= $this->addRow(CHtml::activeLabel(AfiliationAR::model(), 'afiliation'), $afiliation);
		$tblcontent .= $this->addRow(CHtml::activeLabel(PublisherAR::model(), 'publisher'), $reference->publisher->publisher);
		$tblcontent .= $this->addRow(CHtml::activeLabel(BiomeAR::model(), 'biome')."s", $biome);
		$tblcontent .= $this->addRow(CHtml::activeLabel(PlantSpeciesAR::model(), 'plantspecies'), $plantspecies);
		$tblcontent .= $this->addRow(CHtml::activeLabel(PlantFamilyAR::model(), 'plantfamily'), $plantfamily);
		$tblcontent .= $this->addRow(CHtml::activeLabel(PlantCommonNameAR::model(), 'plantcommonname'), $plantcommonname);
		$tblcontent .= $this->addRow(CHtml::activeLabel(PollinatorSpeciesAR::model(), 'pollinatorspecies'), $pollinatorspecies);
		$tblcontent .= $this->addRow(CHtml::activeLabel(PollinatorFamilyAR::model(), 'pollinatorfamily'), $pollinatorfamily);
		$tblcontent .= $this->addRow(CHtml::activeLabel(PollinatorCommonNameAR::model(), 'pollinatorcommonname'), $pollinatorcommonname);
		$tblcontent .= $this->addRow(CHtml::activeLabel($reference, 'datedigitized'). '(YYYY/MM/DD)', $reference->datedigitized);
		$tblcontent .= $this->addRow(CHtml::activeLabel($reference, 'subject'), $reference->subject);
		$tblcontent .= $this->addRow(CHtml::activeLabel($reference, 'abstract'), $reference->abstract);
		$tblcontent .= $this->addRow(CHtml::activeLabel($reference, 'observation'), $reference->observation);
		$tblcontent .= $this->addRow(CHtml::activeLabel($reference, 'isbnissn'), $reference->isbnissn);
		$tblcontent .= $this->addRow(CHtml::activeLabel($reference, 'url'), $reference->url);
		$tblcontent .= $this->addRow(CHtml::activeLabel($reference, 'doi'), $reference->doi);
		$tblcontent .= $this->addRow(CHtml::activeLabel($reference, 'bibliographiccitation'), $reference->bibliographiccitation);
		$tblcontent .= $this->addRow(CHtml::activeLabel(FileFormatAR::model(), 'fileformat'), $reference->fileformat->fileformat);
	}
	
	//------------------------------------------------------------+

	if ($tblcontent) {
		$tbl .= $tblcontent;
		// end table
		$tbl .= '</table>';
	} else {
		$tbl = "";
	}
	
	return  $tbl;
}
	
	/*private function addRowListReference($reference) {
		$row = '
		<tr>
			<td style="text-align: left;">'.$reference['title'].'</td>
			<td>'.$reference['subtypereference'].'</td>
		</tr>
		';
		return $row;
	}
	
	private function generateTableList($rs) {
		// section Title
		$tbl = '
			<table class="dataTable">
				<tr>
			 		<th class="tableTitle" colspan="2">List of Reference Records</th>
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
			 			<th>Title</th>
			 			<th>Subtype</th>
			 		</tr>
			';
			foreach ($rs['result'] as $reference) {
				$tblcontent .= $this->addRowListReference($reference);
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
			foreach ($rs['result'] as $reference) {
				$data .= $reference['title'].';'.$reference['subtypereference'].';'.$reference['bibliographiccitation']."\n";
			}	
		}
		return $data;
	}
	
	public function printReference($reference) {
		// create new PDF document
		$pdf = new ReferencePDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Biodiversity Data Digitizer');
		$pdf->SetTitle('Reference Record Id='.$reference->idreferenceelement);
		$pdf->SetSubject('Reference Record');
		$pdf->SetKeywords('BDD, reference, bibliographic');
		
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
		// Main Information
		//============================================================+
		
		$tbl = $css;
		
		$tbl .= $this->generateTableMainInformation($reference);
		$tbl .= $this->generateTableOtherInformation($reference);
		$pdf->writeHTML($tbl, true, false, false, false, '');
		
		// ---------------------------------------------------------
		
		//Close and output PDF document
		
		$file = "tmp/bdd-reference-".$reference->idreferenceelement.".pdf";
		$pdf->Output($file, 'F');
		
		//============================================================+
		// END OF FILE
		//============================================================+
				
		return $file;
	}
	
	public function printReferenceList($rs) {
		// create new PDF document
		$pdf = new ReferenceListPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Biodiversity Data Digitizer');
		$pdf->SetTitle('Reference List');
		$pdf->SetSubject('List of reference records');
		$pdf->SetKeywords('BDD, reference');
		
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
		$header = array('Title', 'Subtype', 'Bibliographic citation');
		
		//Data loading
		$txt = "tmp/bdd-referenceList-data.txt";
		$file = fopen($txt,"w");
		fwrite($file, $this->generateDataList($rs));
		fclose($file);
		
		$data = $pdf->LoadData($txt);
		
		// print colored table
		$pdf->ColoredTable($header, $data);
		
		// ---------------------------------------------------------
		
		//Close and output PDF document
		
		$pathToFile = "tmp/bdd-referenceList-".time().".pdf";

		$pdf->Output($pathToFile, 'F');		
		
		//============================================================+
		// END OF FILE
		//============================================================+
				
		return $pathToFile;

	}
}
?>