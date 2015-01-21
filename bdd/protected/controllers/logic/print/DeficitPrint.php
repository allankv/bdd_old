<?php

include_once("protected/controllers/logic/print/Print.php");

require_once("protected/extensions/tcpdf/config/lang/eng.php");
require_once("protected/extensions/tcpdf/tcpdf.php");

// Extend the TCPDF class to create custom Header and Footer
class DeficitPDF extends TCPDF {

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
		$this->Cell(0, 2, '  Pollination deficit record', 0, 1, 'L', false, '', 0, false, 'T', 'M');
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

class DeficitListPDF extends TCPDF {

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
		$this->Cell(0, 2, '  Deficit list', 0, 1, 'L', false, '', 0, false, 'T', 'M');
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
		$this->Cell(0, 1, 'List of Deficit Records', 'B', 1, 'L', false, '', 0, false, 'T', 'M');
		$this->Ln(5);
        // Colors, line width and bold font
        $this->SetFillColor(244, 239, 217);
        $this->SetTextColor(136, 85, 34);
        $this->SetDrawColor(246, 168, 40);
        $this->SetLineWidth(0.3);
        $this->SetFont('Helvetica', 'B', 12);
        // Header
        $w = array(60, 60, 60);
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
			$this->MultiCell($w[0], $rowcount * 6, $row[0], 'LRTB', 'C', 0, 0);
			$this->MultiCell($w[1], $rowcount * 6, $row[1], 'LRTB', 'C', 0, 0);
			$this->MultiCell($w[2], $rowcount * 6, $row[2], 'LRTB', 'C', 0, 0);
		 
            $this->Ln();
        }
    }
}

class DeficitPrint extends Printer {
	
	private function generateTableMainInformation($deficit) {
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
		
	$tblcontent .= $this->addRow(CHtml::activeLabelEx($deficit, "fieldnumber"), $deficit->fieldnumber);
	$tblcontent .= $this->addRow(CHtml::activeLabel(CommonNameFocalCropAR::model(),'commonnamefocalcrop'), $deficit->commonnamefocalcrop->commonnamefocalcrop);
	$tblcontent .= $this->addRow(CHtml::activeLabel($deficit, "year"), $deficit->year);
	$tblcontent .= $this->addRow(CHtml::activeLabel(FocusCropAR::model(),'focuscrop'), $deficit->focuscrop->focuscrop);
	$tblcontent .= $this->addRow(CHtml::activeLabel($deficit, "size"), $deficit->size);
	$tblcontent .= $this->addRow(CHtml::activeLabel(TreatmentAR::model(),'treatment'), $deficit->treatment->treatment);
	$tblcontent .= $this->addRow(CHtml::activeLabel($deficit, "date"), $deficit->date);
	$tblcontent .= $this->addRow(CHtml::activeLabel(ObserverAR::model(),'observer'), $deficit->observer->observer);
	$tblcontent .= $this->addRow(CHtml::activeLabel($deficit, "recordingnumber"), $deficit->recordingnumber);
	$tblcontent .= $this->addRow(CHtml::activeLabel($deficit, "plotnumber"), $deficit->plotnumber);
	$tblcontent .= $this->addRow(CHtml::activeLabel($deficit, "numberflowersobserved"), $deficit->numberflowersobserved);
	
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
	
	private function generateTableLocation($deficit) {
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
	 		<th class="tableTitle" colspan="3">Location</th>
	 	</tr>
	';
	
	// line break
	$tbl .= $lnbk;
	
	// table content
	$tblcontent = "";
	
	//------------------------------------------------------------+
	
	if ($deficit->localityelement->country->country || $deficit->localityelement->stateprovince->stateprovince || $deficit->localityelement->county->county ||
		$deficit->localityelement->municipality->municipality || $deficit->localityelement->locality->locality || $deficit->localityelement->site_->site_ ||
		$deficit->geospatialelement->decimallatitude || $deficit->geospatialelement->decimallongitude) {
		
		$tblcontent .= $this->addRow(CHtml::activeLabel(CountryAR::model(),'country'), $deficit->localityelement->country->country);
		$tblcontent .= $this->addRow(CHtml::activeLabel(StateProvinceAR::model(),'stateprovince'), $deficit->localityelement->stateprovince->stateprovince);
		$tblcontent .= $this->addRow(CHtml::activeLabel(CountyAR::model(),'county'), $deficit->localityelement->county->county);
		$tblcontent .= $this->addRow(CHtml::activeLabel(MunicipalityAR::model(),'municipality'), $deficit->localityelement->municipality->municipality);
		$tblcontent .= $this->addRow("Locality references", $deficit->localityelement->locality->locality);
		$tblcontent .= $this->addRow(CHtml::activeLabel(Site_AR::model(),'site_'), $deficit->localityelement->site_->site_);
		$tblcontent .= $this->addRow(CHtml::activeLabel($deficit->geospatialelement, "decimallatitude"), $deficit->geospatialelement->decimallatitude);
		$tblcontent .= $this->addRow(CHtml::activeLabel($deficit->geospatialelement, "decimallongitude"), $deficit->geospatialelement->decimallongitude);
	
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
	
	private function generateTableDimension($deficit) {
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
	 		<th class="tableTitle" colspan="3">Dimension</th>
	 	</tr>
	';
	
	// line break
	$tbl .= $lnbk;
	
	// table content
	$tblcontent = "";
	
	//------------------------------------------------------------+
	
	if ($deficit->typeholding->typeholding || $deficit->fieldsize || $deficit->dimension) {
		
		$tblcontent .= $this->addRow(CHtml::activeLabel(TypeHoldingAR::model(),'typeholding'), $deficit->typeholding->typeholding);
		$tblcontent .= $this->addRow(CHtml::activeLabel($deficit, "fieldsize"), $deficit->fieldsize);
		$tblcontent .= $this->addRow(CHtml::activeLabel($deficit, "dimension"), $deficit->dimension);
	
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
	
	private function generateTableTopographyAndSoil($deficit) {
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
	 		<th class="tableTitle" colspan="3">Topography and Soil</th>
	 	</tr>
	';
	
	// line break
	$tbl .= $lnbk;
	
	// table content
	$tblcontent = "";
	
	//------------------------------------------------------------+
	
	if ($deficit->localityelement->verbatimelevation || $deficit->topograficalsituation->topograficalsituation || $deficit->soiltype->soiltype ||
		$deficit->soilpreparation->soilpreparation) {
		
		$tblcontent .= $this->addRow(CHtml::activeLabel($deficit->localityelement, "verbatimelevation"), $deficit->localityelement->verbatimelevation);
		$tblcontent .= $this->addRow(CHtml::activeLabel(TopograficalSituationAR::model(),'topograficalsituation'), $deficit->topograficalsituation->topograficalsituation);
		$tblcontent .= $this->addRow(CHtml::activeLabel(SoilTypeAR::model(),'soiltype'), $deficit->soiltype->soiltype);
		$tblcontent .= $this->addRow(CHtml::activeLabel(SoilPreparationAR::model(),'soilpreparation'), $deficit->soilpreparation->soilpreparation);
		
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
	
	private function generateTableEnvironments($deficit) {
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
	 		<th class="tableTitle" colspan="3">Environments</th>
	 	</tr>
	';
	
	// line break
	$tbl .= $lnbk;
	
	// table content
	$tblcontent = "";
	
	//------------------------------------------------------------+
	
	if ($deficit->hedgesurroundingfield || $deficit->mainplantspeciesinhedge->mainplantspeciesinhedge || $deficit->distanceofnaturalhabitat) {
		
		$tblcontent .= $this->addRow(CHtml::activeLabel($deficit, "hedgesurroundingfield"), $deficit->hedgesurroundingfield = 1 ? "yes" : "no");
		$tblcontent .= $this->addRow(CHtml::activeLabel(MainPlantSpeciesInHedgeAR::model(),'mainplantspeciesinhedge'), $deficit->mainplantspeciesinhedge->mainplantspeciesinhedge);
		$tblcontent .= $this->addRow(CHtml::activeLabel($deficit, "distanceofnaturalhabitat"), $deficit->distanceofnaturalhabitat);
	
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
	
	private function generateTableFocalCrop($deficit) {
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
	 		<th class="tableTitle" colspan="3">Focal Crop</th>
	 	</tr>
	';
	
	// line break
	$tbl .= $lnbk;
	
	// table content
	$tblcontent = "";
	
	//------------------------------------------------------------+
	
	if ($deficit->scientificname->scientificname || $deficit->productionvariety->productionvariety || $deficit->varietypollenizer || $deficit->originseeds->originseeds) {
		
		$tblcontent .= $this->addRow(CHtml::activeLabel(ScientificNameAR::model(),'scientificname'), $deficit->scientificname->scientificname);
		$tblcontent .= $this->addRow(CHtml::activeLabel(ProductionVarietyAR::model(),'productionvariety'), $deficit->productionvariety->productionvariety);
		$tblcontent .= $this->addRow(CHtml::activeLabel($deficit, "varietypollenizer"), $deficit->varietypollenizer);
		$tblcontent .= $this->addRow(CHtml::activeLabel(OriginSeedsAR::model(),'originseeds'), $deficit->originseeds->originseeds);
		
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
	
	private function generateTableCulturalPractices($deficit) {
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
	 		<th class="tableTitle" colspan="3">Cultural Practices</th>
	 	</tr>
	';
	
	// line break
	$tbl .= $lnbk;
	
	// table content
	$tblcontent = "";
	
	//------------------------------------------------------------+
	
	if ($deficit->plantingdate || $deficit->typeplanting->typeplanting || $deficit->plantdensity || $deficit->typestand->typestand ||
		$deficit->ratiopollenizertree || $deficit->distancebetweenrows || $deficit->distanceamongplantswithinrows) {
		
		$tblcontent .= $this->addRow(CHtml::activeLabel($deficit, "plantingdate"), $deficit->plantingdate);
		$tblcontent .= $this->addRow(CHtml::activeLabel(TypePlantingAR::model(),'typeplanting'), $deficit->typeplanting->typeplanting);
		$tblcontent .= $this->addRow(CHtml::activeLabel($deficit, "plantdensity"), $deficit->plantdensity);
		$tblcontent .= $this->addRow(CHtml::activeLabel(TypeStandAR::model(),'typestand'), $deficit->typestand->typestand);
		$tblcontent .= $this->addRow(CHtml::activeLabel($deficit, "ratiopollenizertree"), $deficit->ratiopollenizertree);
		$tblcontent .= $this->addRow(CHtml::activeLabel($deficit, "distancebetweenrows"), $deficit->distancebetweenrows);
		$tblcontent .= $this->addRow(CHtml::activeLabel($deficit, "distanceamongplantswithinrows"), $deficit->distanceamongplantswithinrows);
		
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
	
	private function generateTableRecordingConditions($deficit) {
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
	 		<th class="tableTitle" colspan="3">Recording Conditions</th>
	 	</tr>
	';
	
	// line break
	$tbl .= $lnbk;
	
	// table content
	$tblcontent = "";
	
	//------------------------------------------------------------+
	
	if ($deficit->timeatstart || $deficit->period || $deficit->weathercondition->weathercondition) {
		
		$tblcontent .= $this->addRow(CHtml::activeLabel($deficit, "timeatstart"), $deficit->timeatstart);
		$tblcontent .= $this->addRow(CHtml::activeLabel($deficit, "period"), $deficit->period);
		$tblcontent .= $this->addRow(CHtml::activeLabel(WeatherConditionAR::model(),'weathercondition'), $deficit->weathercondition->weathercondition);
		
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
	
	private function generateTableNumberOfFlowerVisitors($deficit) {
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
	 		<th class="tableTitle" colspan="3">Number of Flower Visitors</th>
	 	</tr>
	';
	
	// line break
	$tbl .= $lnbk;
	
	// table content
	$tblcontent = "";
	
	//------------------------------------------------------------+
	
	if ($deficit->apismellifera || $deficit->bumblebees || $deficit->otherbees || $deficit->other) {
		
		$tblcontent .= $this->addRow(CHtml::activeLabel($deficit, "apismellifera"), $deficit->apismellifera);
		$tblcontent .= $this->addRow(CHtml::activeLabel($deficit, "bumblebees"), $deficit->bumblebees);
		$tblcontent .= $this->addRow(CHtml::activeLabel($deficit, "otherbees"), $deficit->otherbees);
		$tblcontent .= $this->addRow(CHtml::activeLabel($deficit, "other"), $deficit->other);
		
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
	
	/*private function addRowListDeficit($deficit) {
		$row = '
		<tr>
			<td>'.$deficit['commonnamefocalcrop'].'</td>
			<td>'.$deficit['scientificname'].'</td>
			<td>'.$deficit['fieldnumber'].'</td>
		</tr>
		';
		return $row;
	}
	
	private function generateTableList($rs) {
		// section Title
		$tbl = '
			<table class="dataTable">
				<tr>
			 		<th class="tableTitle" colspan="3">List of Deficit Records</th>
			 	</tr>
			 	<tr>
					<td colspan="3"></td>
				</tr>
			</table>
		';
		
		// begin table content
		$tblcontent = "";
		
		if ($rs['count']) {
			$tblcontent = '
				<table class="tableList">
					<tr>
			 			<th>Common name of focal crop</th>
			 			<th>Field Number</th>
			 			<th>Scientific name</th>
			 		</tr>
			';
			foreach ($rs['result'] as $deficit) {
				$tblcontent .= $this->addRowListDeficit($deficit);
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
			foreach ($rs['result'] as $deficit) {
				$data .= $deficit['commonnamefocalcrop'].';'.$deficit['scientificname'].';'.$deficit['fieldnumber']."\n";
			}	
		}
		return $data;
	}

	public function printDeficit($deficit) {
		// create new PDF document
		$pdf = new DeficitPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Biodiversity Data Digitizer');
		$pdf->SetTitle('Pollination deficit record Id='.$deficit->iddeficit);
		$pdf->SetSubject('Pollination deficit record');
		$pdf->SetKeywords('BDD, pollination deficit');
		
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
		
		$tbl .= $this->generateTableMainInformation($deficit);
		$tbl .= $this->generateTableLocation($deficit);
		$tbl .= $this->generateTableDimension($deficit);
		$tbl .= $this->generateTableTopographyAndSoil($deficit);
		$tbl .= $this->generateTableEnvironments($deficit);
		$tbl .= $this->generateTableFocalCrop($deficit);
		$tbl .= $this->generateTableCulturalPractices($deficit);
		$tbl .= $this->generateTableRecordingConditions($deficit);
		$tbl .= $this->generateTableNumberOfFlowerVisitors($deficit);
		
		$pdf->writeHTML($tbl, true, false, false, false, '');
		
		//Close and output PDF document
		$file = "tmp/bdd-deficit-".$deficit->iddeficit.".pdf";
		$pdf->Output($file, 'F');
		
		//============================================================+
		// END OF FILE
		//============================================================+
				
		return $file;

	}
	
	public function printDeficitList($rs) {
		// create new PDF document
		$pdf = new DeficitListPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Biodiversity Data Digitizer');
		$pdf->SetTitle('Deficit List');
		$pdf->SetSubject('List of deficit records');
		$pdf->SetKeywords('BDD, deficit');
		
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
		$header = array('Common name of focal crop', 'Field Number', 'Scientific Name');
		
		//Data loading
		$txt = "tmp/bdd-deficitList-data.txt";
		$file = fopen($txt,"w");
		fwrite($file, $this->generateDataList($rs));
		fclose($file);
		
		$data = $pdf->LoadData($txt);
		
		// print colored table
		$pdf->ColoredTable($header, $data);
		
		// ---------------------------------------------------------
		
		//Close and output PDF document
		
		$pathToFile = "tmp/bdd-deficitList-".time().".pdf";

		$pdf->Output($pathToFile, 'F');		
		
		//============================================================+
		// END OF FILE
		//============================================================+
				
		return $pathToFile;

	}
}

?>