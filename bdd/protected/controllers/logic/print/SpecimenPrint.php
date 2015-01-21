<?php

include_once("protected/controllers/logic/print/Print.php");

include_once("protected/controllers/logic/SpecimenLogic.php");
include_once("protected/controllers/logic/ReferenceLogic.php");
include_once("protected/controllers/logic/MediaLogic.php");

require_once("protected/extensions/tcpdf/config/lang/eng.php");
require_once("protected/extensions/tcpdf/tcpdf.php");

// Extend the TCPDF class to create custom Header and Footer
class SpecimenPDF extends TCPDF {
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
		$this->Cell(0, 2, '  Specimen occurrence record', 0, 1, 'L', false, '', 0, false, 'T', 'M');
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

// Extend the TCPDF class to create custom Header and Footer
class SpecimenListPDF extends TCPDF {

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
		$this->Cell(0, 2, '  Specimen list', 0, 1, 'L', false, '', 0, false, 'T', 'M');
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
		$this->Cell(0, 1, 'List of Specimen Records', 'B', 1, 'L', false, '', 0, false, 'T', 'M');
		$this->Ln(5);
        // Colors, line width and bold font
        $this->SetFillColor(244, 239, 217);
        $this->SetTextColor(136, 85, 34);
        $this->SetDrawColor(246, 168, 40);
        $this->SetLineWidth(0.3);
        $this->SetFont('Helvetica', 'B', 12);
        // Header
        $w = array(75, 35, 35, 35);
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
			$rowcount = max($this->getNumLines($row[0], $w[0]), $this->getNumLines($row[1], $w[1]), $this->getNumLines($row[2], $w[2]), $this->getNumLines($row[3], $w[3]));
		 
			$startY = $this->GetY();
		 
			if (($startY + $rowcount * 6) + $dimensions['bm'] > ($dimensions['hk'])) {
					//$this->Cell(array_sum($w), 0, '', '');
					$this->addPage();
			}
		 
			//cell height is 6 times the max number of cells
			$this->MultiCell($w[0], $rowcount * 6, $row[0], 'LRTB', 'L', 0, 0);
			$this->MultiCell($w[1], $rowcount * 6, $row[1], 'LRTB', 'C', 0, 0);
			$this->MultiCell($w[2], $rowcount * 6, $row[2], 'LRTB', 'C', 0, 0);
			$this->MultiCell($w[3], $rowcount * 6, $row[3], 'LRTB', 'C', 0, 0);
		 
            $this->Ln();
        }
    }
}

class SpecimenPrint extends Printer {
	
	private function generateTableRecordLevelElement($recordLevelElement) {
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
		 		<th class="tableTitle" colspan="3">Record Level Elements</th>
		 	</tr>
		';
		
		// line break
		$tbl .= $lnbk;
		
		// table content
		$tblcontent = "";
		
		//------------------------------------------------------------+
		
		$tblcontent .= $this->addRow(CHtml::activeLabelEx($recordLevelElement->basisofrecord, 'basisofrecord'), $recordLevelElement->basisofrecord->basisofrecord);
		$tblcontent .= $this->addRow(CHtml::activeLabelEx($recordLevelElement->institutioncode, 'institutioncode'), $recordLevelElement->institutioncode->institutioncode);
		$tblcontent .= $this->addRow(CHtml::activeLabelEx($recordLevelElement->collectioncode, 'collectioncode'), $recordLevelElement->collectioncode->collectioncode);
			
		//------------------------------------------------------------+
		
		if ($recordLevelElement->type->type || $recordLevelElement->ownerinstitution->ownerinstitution || $recordLevelElement->dataset->dataset) {
			$tblcontent .= $lnbk;
		}
		
		$tblcontent .= $this->addRow(CHtml::activeLabel(TypeAR::model(), "type"), $recordLevelElement->type->type);
		$tblcontent .= $this->addRow(CHtml::activeLabel($recordLevelElement->ownerinstitution, 'ownerinstitution'), $recordLevelElement->ownerinstitution->ownerinstitution);
		$tblcontent .= $this->addRow(CHtml::activeLabel($recordLevelElement->dataset, 'dataset'), $recordLevelElement->dataset->dataset);
			
		//------------------------------------------------------------+
		
		if ($recordLevelElement->rights || $recordLevelElement->rightsholder || $recordLevelElement->accessrights) {
			$tblcontent .= $lnbk;
		}
		
		$tblcontent .= $this->addRow(CHtml::activeLabel($recordLevelElement, 'rights'), $recordLevelElement->rights);
		$tblcontent .= $this->addRow(CHtml::activeLabel($recordLevelElement, 'rightsholder'), $recordLevelElement->rightsholder);
		$tblcontent .= $this->addRow(CHtml::activeLabel($recordLevelElement, 'accessrights'), $recordLevelElement->accessrights);
		
		//------------------------------------------------------------+
		
		$dynamicproperties = "";
		foreach ($recordLevelElement->dynamicproperty as $value) {
			$dynamicproperties .= $value->dynamicproperty . ", ";
		}
		$dynamicproperties = substr($dynamicproperties, 0, -2);
		
		if ($recordLevelElement->informationwithheld || $recordLevelElement->datageneralization || $dynamicproperties) {
			$tblcontent .= $lnbk;
		}
		
		$tblcontent .= $this->addRow(CHtml::activeLabel($recordLevelElement, 'informationwithheld'), $recordLevelElement->informationwithheld);
		$tblcontent .= $this->addRow(CHtml::activeLabel($recordLevelElement, 'datageneralization'), $recordLevelElement->datageneralization);
		$tblcontent .= $this->addRow(CHtml::activeLabel(DynamicPropertyAR::model(), 'dynamicproperty'), $dynamicproperties);
			
		//------------------------------------------------------------+
		
		if ($recordLevelElement->lending || $recordLevelElement->lendingwho || $recordLevelElement->lendingdate) {
			$tblcontent .= $lnbk;
		}
		
		$tblcontent .= $this->addRow(CHtml::activeLabel($recordLevelElement, 'lending'), $recordLevelElement->lending == 1 ? 'yes' : 'no');
		$tblcontent .= $this->addRow(CHtml::activeLabel($recordLevelElement, 'lendingwho'), $recordLevelElement->lendingwho);
		$tblcontent .= $this->addRow(CHtml::activeLabel($recordLevelElement, 'lendingdate'), $recordLevelElement->lendingdate);
			
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
	
	private function generateTableTaxonomicElement($taxonomicElement) {
		// define line break
		$lnbk = '
			<tr>
				<td colspan="3"></td>
			</tr>
		';
	
		// begin table
		$tbl .= '
		<table class="dataTable">
			<tr>
				<td colspan="3"></td>
			</tr>
			<tr>
		 		<th class="tableTitle" colspan="3">Taxonomic Elements</th>
		 	</tr>
		';
		
		// line break
		$tbl .= $lnbk;
		
		// table content
		$tblcontent = "";
		
		
		//------------------------------------------------------------+
		
		$tblcontent .= $this->addRow(CHtml::activeLabel(KingdomAR::model(), 'kingdom'), $taxonomicElement->kingdom->kingdom);
		$tblcontent .= $this->addRow(CHtml::activeLabel(PhylumAR::model(), "phylum"), $taxonomicElement->phylum->phylum);
		$tblcontent .= $this->addRow(CHtml::activeLabel(ClassAR::model(), "class"), $taxonomicElement->class->class);
		$tblcontent .= $this->addRow(CHtml::activeLabel(OrderAR::model(), "order"), $taxonomicElement->order->order);
		$tblcontent .= $this->addRow(CHtml::activeLabel(FamilyAR::model(), "family"), $taxonomicElement->family->family);
		$tblcontent .= $this->addRow(CHtml::activeLabel(GenusAR::model(), "genus"), $taxonomicElement->genus->genus);
		$tblcontent .= $this->addRow(CHtml::activeLabel(SubgenusAR::model(), "subgenus"), $taxonomicElement->subgenus->subgenus);
		$tblcontent .= $this->addRow(CHtml::activeLabel(SpecificEpithetAR::model(), "specificepithet"), $taxonomicElement->specificepithet->specificepithet);
		$tblcontent .= $this->addRow(CHtml::activeLabel(InfraspecificEpithetAR::model(), "infraspecificepithet"), $taxonomicElement->infraspecificepithet->infraspecificepithet);
		$tblcontent .= $this->addRow('Scientific name', $taxonomicElement->scientificname->scientificname);
		$tblcontent .= $this->addRow(CHtml::activeLabel(MorphospeciesAR::model(), "morphospecies"), $taxonomicElement->morphospecies->morphospecies);
		
		//------------------------------------------------------------+
		
		if ($taxonomicElement->taxonrank->taxonrank || $taxonomicElement->scientificnameauthorship->scientificnameauthorship || $taxonomicElement->nomenclaturalcode->nomenclaturalcode || $taxonomicElement->taxonconcept->taxonconcept || $taxonomicElement->nomenclaturalstatus) {
			$tblcontent .= $lnbk;
		}
		
		$tblcontent .= $this->addRow(CHtml::activeLabel(TaxonRankAR::model(), 'taxonrank'), $taxonomicElement->taxonrank->taxonrank);
		$tblcontent .= $this->addRow(CHtml::activeLabel(ScientificNameAuthorshipAR::model(), "scientificnameauthorship"), $taxonomicElement->scientificnameauthorship->scientificnameauthorship);
		$tblcontent .= $this->addRow(CHtml::activeLabel(NomenclaturalCodeAR::model(), "nomenclaturalcode"), $taxonomicElement->nomenclaturalcode->nomenclaturalcode);
		$tblcontent .= $this->addRow(CHtml::activeLabel(TaxonConceptAR::model(), "taxonconcept"), $taxonomicElement->taxonconcept->taxonconcept);
		$tblcontent .= $this->addRow(CHtml::activeLabel($taxonomicElement, "nomenclaturalstatus"), $taxonomicElement->nomenclaturalstatus);
			
		//------------------------------------------------------------+
		
		if ($taxonomicElement->acceptednameusage->acceptednameusage || $taxonomicElement->parentnameusage->parentnameusage || $taxonomicElement->originalnameusage->originalnameusage || $taxonomicElement->nameaccordingto->nameaccordingto || $taxonomicElement->namepublishedin->namepublishedin || $taxonomicElement->vernacularname) {
			$tblcontent .= $lnbk;
		}
		
		$tblcontent .= $this->addRow(CHtml::activeLabel(AcceptedNameUsageAR::model(), 'acceptednameusage'), $taxonomicElement->acceptednameusage->acceptednameusage);
		$tblcontent .= $this->addRow(CHtml::activeLabel(ParentNameUsageAR::model(), "parentnameusage"), $taxonomicElement->parentnameusage->parentnameusage);
		$tblcontent .= $this->addRow(CHtml::activeLabel(OriginalNameUsageAR::model(), "originalnameusage"), $taxonomicElement->originalnameusage->originalnameusage);
		$tblcontent .= $this->addRow(CHtml::activeLabel(NameAccordingToAR::model(), "nameaccordingto"), $taxonomicElement->nameaccordingto->nameaccordingto);
		$tblcontent .= $this->addRow(CHtml::activeLabel(NamePublishedInAR::model(), "namepublishedin"), $taxonomicElement->namepublishedin->namepublishedin);
		$tblcontent .= $this->addRow(CHtml::activeLabel($taxonomicElement, "vernacularname"), $taxonomicElement->vernacularname);
		
		//------------------------------------------------------------+
		
		if ($taxonomicElement->taxonomicstatus->taxonomicstatus || $taxonomicElement->verbatimtaxonrank || $taxonomicElement->taxonremark) {
			$tblcontent .= $lnbk;
		}
		
		$tblcontent .= $this->addRow(CHtml::activeLabel(TaxonomicStatusAR::model(), "taxonomicstatus"), $taxonomicElement->taxonomicstatus->taxonomicstatus);
		$tblcontent .= $this->addRow(CHtml::activeLabel($taxonomicElement, "verbatimtaxonrank"), $taxonomicElement->verbatimtaxonrank);
		$tblcontent .= $this->addRow(CHtml::activeLabel($taxonomicElement, "taxonremark"), $taxonomicElement->taxonremark);
		
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
	
	private function generateTableLocationElement($localityElement, $geospatialElement) {
		// define line break
		$lnbk = '
			<tr>
				<td colspan="3"></td>
			</tr>
		';
	
		// begin table
		$tbl .= '
		<table class="dataTable">
			<tr>
				<td colspan="3"></td>
			</tr>
			<tr>
		 		<th class="tableTitle" colspan="3">Location Elements</th>
		 	</tr>
		';
		
		// line break
		$tbl .= $lnbk;
		
		// table content
		$tblcontent = "";
		
		
		//------------------------------------------------------------+
		
		$tblcontent .= $this->addRow(CHtml::activeLabel($geospatialElement, 'decimallatitude'), $geospatialElement->decimallatitude);
		$tblcontent .= $this->addRow(CHtml::activeLabel($geospatialElement, 'decimallongitude'), $geospatialElement->decimallongitude);
		$tblcontent .= $this->addRow(CHtml::activeLabel($geospatialElement, "coordinateuncertaintyinmeters"), $geospatialElement->coordinateuncertaintyinmeters);
		$tblcontent .= $this->addRow(CHtml::activeLabel($geospatialElement, "geodeticdatum"), $geospatialElement->geodeticdatum);
		$tblcontent .= $this->addRow(CHtml::activeLabel(CountryAR::model(), 'country'), $localityElement->country->country);
		$tblcontent .= $this->addRow(CHtml::activeLabel(StateProvinceAR::model(), 'stateprovince'), $localityElement->stateprovince->stateprovince);
		$tblcontent .= $this->addRow(CHtml::activeLabel(MunicipalityAR::model(), 'municipality'), $localityElement->municipality->municipality);
		$tblcontent .= $this->addRow(CHtml::activeLabel($localityElement->waterbody, 'waterbody'), $localityElement->waterbody->waterbody);
		
		//------------------------------------------------------------+
		
		if ($geospatialElement->pointradiusspatialfit) {
			$tblcontent .= $lnbk;
		}
		
		$tblcontent .= $this->addRow(CHtml::activeLabel($geospatialElement, "pointradiusspatialfit"), $geospatialElement->pointradiusspatialfit);
		
		//------------------------------------------------------------+	
		
		if ($geospatialElement->verbatimcoordinate || $geospatialElement->verbatimlatitude | $geospatialElement->verbatimlongitude || $geospatialElement->verbatimcoordinatesystem) {
			$tblcontent .= $lnbk;
		}
		
		$tblcontent .= $this->addRow(CHtml::activeLabel($geospatialElement, "verbatimcoordinate"), $geospatialElement->verbatimcoordinate);
		$tblcontent .= $this->addRow(CHtml::activeLabel($geospatialElement, "verbatimlatitude"), $geospatialElement->verbatimlatitude);
		$tblcontent .= $this->addRow(CHtml::activeLabel($geospatialElement, "verbatimlongitude"), $geospatialElement->verbatimlongitude);
		$tblcontent .= $this->addRow(CHtml::activeLabel($geospatialElement, "verbatimcoordinatesystem"), $geospatialElement->verbatimcoordinatesystem);
			
		//------------------------------------------------------------+	
		
		if ($geospatialElement->georeferenceprotocol || $geospatialElement->georeferenceverificationstatus->georeferenceverificationstatus || $geospatialElement->georeferenceremark) {
			$tblcontent .= $lnbk;
		}
		
		$tblcontent .= $this->addRow(CHtml::activeLabel($geospatialElement, "georeferenceprotocol"), $geospatialElement->georeferenceprotocol);
		$tblcontent .= $this->addRow(CHtml::activeLabel($geospatialElement->georeferenceverificationstatus, 'georeferenceverificationstatus'), $geospatialElement->georeferenceverificationstatus->georeferenceverificationstatus);
		$tblcontent .= $this->addRow(CHtml::activeLabel($geospatialElement, "georeferenceremark"), $geospatialElement->georeferenceremark);
	
		//------------------------------------------------------------+	
		
		if ($geospatialElement->footprintwkt || $geospatialElement->footprintspatialfit) {
			$tblcontent .= $lnbk;	
		}
		
		$tblcontent .= $this->addRow(CHtml::activeLabel($geospatialElement, "footprintwkt"), $geospatialElement->footprintwkt);
		$tblcontent .= $this->addRow(CHtml::activeLabel($geospatialElement, "footprintspatialfit"), $geospatialElement->footprintspatialfit);
	
		//------------------------------------------------------------+	
		
		if ($localityElement->county->county || $localityElement->locality->locality) {
			$tblcontent .= $lnbk;
		}
		
		$tblcontent .= $this->addRow(CHtml::activeLabel(CountyAR::model(), 'county'), $localityElement->county->county);
		$tblcontent .= $this->addRow(CHtml::activeLabel(LocalityAR::model(), 'locality'), $localityElement->locality->locality);
		
		//------------------------------------------------------------+	
		
		if ($localityElement->continent->continent || $localityElement->islandgroup->islandgroup || $localityElement->island->island) {
			$tblcontent .= $lnbk;
		}
		
		$tblcontent .= $this->addRow(CHtml::activeLabel(ContinentAR::model(), "continent"), $localityElement->continent->continent);
		$tblcontent .= $this->addRow(CHtml::activeLabel($localityElement->islandgroup, 'islandgroup'), $localityElement->islandgroup->islandgroup);
		$tblcontent .= $this->addRow(CHtml::activeLabel($localityElement->island, 'island'), $localityElement->island->island);
		
		//------------------------------------------------------------+	
		
		if ($localityElement->locationaccordingto || $localityElement->coordinateprecision || $localityElement->locationremark) {
			$tblcontent .= $lnbk;
		}
		
		$tblcontent .= $this->addRow(CHtml::activeLabel($localityElement, 'locationaccordingto'), $localityElement->locationaccordingto);
		$tblcontent .= $this->addRow(CHtml::activeLabel($localityElement, 'coordinateprecision'), $localityElement->coordinateprecision);
		$tblcontent .= $this->addRow(CHtml::activeLabel($localityElement, 'locationremark'), $localityElement->locationremark);
	
		//------------------------------------------------------------+	
	
		if ($localityElement->minimumelevationinmeters || $localityElement->maximumelevationinmeters) {
			$tblcontent .= $lnbk;
		}
		
		$tblcontent .= $this->addRow(CHtml::activeLabel($localityElement, 'minimumelevationinmeters'), $localityElement->minimumelevationinmeters);
		$tblcontent .= $this->addRow(CHtml::activeLabel($localityElement, 'maximumelevationinmeters'), $localityElement->maximumelevationinmeters);
	
		//------------------------------------------------------------+	
	
		if ($localityElement->minimumdepthinmeters || $localityElement->maximumdepthinmeters) {
			$tblcontent .= $lnbk;
		}
		
		$tblcontent .= $this->addRow(CHtml::activeLabel($localityElement, 'minimumdepthinmeters'), $localityElement->minimumdepthinmeters);
		$tblcontent .= $this->addRow(CHtml::activeLabel($localityElement, 'maximumdepthinmeters'), $localityElement->maximumdepthinmeters);
		
		//------------------------------------------------------------+	
		
		if ($localityElement->minimumdistanceabovesurfaceinmeters || $localityElement->maximumdistanceabovesurfaceinmeters) {
			$tblcontent .= $lnbk;
		}
		
		$tblcontent .= $this->addRow(CHtml::activeLabel($localityElement, 'minimumdistanceabovesurfaceinmeters'), $localityElement->minimumdistanceabovesurfaceinmeters);	
		$tblcontent .= $this->addRow(CHtml::activeLabel($localityElement, 'maximumdistanceabovesurfaceinmeters'), $localityElement->maximumdistanceabovesurfaceinmeters);
		
		//------------------------------------------------------------+	
		
		if ($localityElement->verbatimdepth || $localityElement->verbatimelevation || $localityElement->verbatimlocality || $localityElement->verbatimsrs) {
			$tblcontent .= $lnbk;
		}
		
		$tblcontent .= $this->addRow(CHtml::activeLabel($localityElement, 'verbatimdepth'), $localityElement->verbatimdepth);
		$tblcontent .= $this->addRow(CHtml::activeLabel($localityElement, 'verbatimelevation'), $localityElement->verbatimelevation);
		$tblcontent .= $this->addRow(CHtml::activeLabel($localityElement, 'verbatimlocality'), $localityElement->verbatimlocality);
		$tblcontent .= $this->addRow(CHtml::activeLabel($localityElement, 'verbatimsrs'), $localityElement->verbatimsrs);
		
		//------------------------------------------------------------+	
		
		$georeferencedby = "";
	    foreach ($localityElement->georeferencedby as $value) {
	        $georeferencedby .= $value->georeferencedby . ", ";
	    }
	    $georeferencedby = substr($georeferencedby, 0, -2);
	    
	    if ($georeferencedby) {
		    $tblcontent .= $lnbk;
	    }
		
		$tblcontent .= $this->addRow(CHtml::activeLabel(GeoreferencedByAR::model(), "georeferencedby"), $georeferencedby);
	
		//------------------------------------------------------------+	
		
		if ($localityElement->footprintsrs) {
			$tblcontent .= $lnbk;
		}
	
		$tblcontent .= $this->addRow(CHtml::activeLabel($localityElement, 'footprintsrs'), $localityElement->footprintsrs);
	
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
	
	private function generateTableOccurrenceElement($occurrenceElement) {
		// define line break
		$lnbk = '
			<tr>
				<td colspan="3"></td>
			</tr>
		';
	
		// begin table
		$tbl .= '
		<table class="dataTable">
			<tr>
				<td colspan="3"></td>
			</tr>
			<tr>
		 		<th class="tableTitle" colspan="3">Occurrence Elements</th>
		 	</tr>
		';
		
		// line break
		$tbl .= $lnbk;
		
		// table content
		$tblcontent = "";
		
		
		//------------------------------------------------------------+
		
		$individual = "";
	    foreach ($occurrenceElement->individual as $value) {
	        $individual .= $value->individual . ", ";
	    }
	    $individual = substr($individual, 0, -2);
		
		$tblcontent .= $this->addRow(CHtml::activeLabelEx($occurrenceElement,'catalognumber'), $occurrenceElement->catalognumber);
		$tblcontent .= $this->addRow(CHtml::activeLabel(IndividualAR::model(), "individual"), $individual);
		$tblcontent .= $this->addRow(CHtml::activeLabel($occurrenceElement, "individualcount"), $occurrenceElement->individualcount);
		$tblcontent .= $this->addRow(CHtml::activeLabel(SexAR::model(), "sex"), $occurrenceElement->sex->sex);
		$tblcontent .= $this->addRow(CHtml::activeLabel($occurrenceElement->behavior, 'behavior'), $occurrenceElement->behavior->behavior);
		$tblcontent .= $this->addRow(CHtml::activeLabel($occurrenceElement->lifestage,'lifestage'), $occurrenceElement->lifestage->lifestage);
		$tblcontent .= $this->addRow(CHtml::activeLabel($occurrenceElement->disposition, 'disposition'), $occurrenceElement->disposition->disposition);
		$tblcontent .= $this->addRow(CHtml::activeLabel($occurrenceElement->reproductivecondition, 'reproductivecondition'), $occurrenceElement->reproductivecondition->reproductivecondition);
		$tblcontent .= $this->addRow(CHtml::activeLabel($occurrenceElement->establishmentmean, 'establishmentmean'), $occurrenceElement->establishmentmean->establishmentmean);
		
		//------------------------------------------------------------+
		
		$recordedby = "";
	    foreach ($occurrenceElement->recordedby as $value) {
	        $recordedby .= $value->recordedby . ", ";
	    }
	    $recordedby = substr($recordedby, 0, -2);
	    
	    $preparation = "";
		foreach ($occurrenceElement->preparation as $value) {
		    $preparation .= $value->preparation . ", ";
		}
		$preparation = substr($preparation, 0, -2);
		
		$associatedsequence = "";
	    foreach ($occurrenceElement->associatedsequence as $value) {
	        $associatedsequence .= $value->associatedsequence . ", ";
	    }
	    $associatedsequence = substr($associatedsequence, 0, -2);
	    
	    if ($recordedby || $occurrenceElement->recordnumber || $occurrenceElement->othercatalognumber || $preparation || $associatedsequence) {
		    $tblcontent .= $lnbk;
	    }
	    
		$tblcontent .= $this->addRow(CHtml::activeLabel(RecordedByAR::model(), "recordedby"), $recordedby);
		$tblcontent .= $this->addRow(CHtml::activeLabel($occurrenceElement, 'recordnumber'), $occurrenceElement->recordnumber);
		$tblcontent .= $this->addRow(CHtml::activeLabel($occurrenceElement, 'othercatalognumber'), $occurrenceElement->othercatalognumber);
		$tblcontent .= $this->addRow(CHtml::activeLabel(PreparationAR::model(),'preparation'), $preparation);
		$tblcontent .= $this->addRow(CHtml::activeLabel(AssociatedSequenceAR::model(), "associatedsequence"), $associatedsequence);
	
		//------------------------------------------------------------+
		
		if ($occurrenceElement->occurrencedetail || $occurrenceElement->occurrenceremark || $occurrenceElement->occurrencestatus) {
			$tblcontent .= $lnbk;
		}
	
		$tblcontent .= $this->addRow(CHtml::activeLabel($occurrenceElement, 'occurrencedetail'), $occurrenceElement->occurrencedetail);
		$tblcontent .= $this->addRow(CHtml::activeLabel($occurrenceElement, 'occurrenceremark'), $occurrenceElement->occurrenceremark);
		$tblcontent .= $this->addRow(CHtml::activeLabel($occurrenceElement, "occurrencestatus"), $occurrenceElement->occurrencestatus);
		
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
	
	private function generateTableIdentificationElement($identificationElement) {
		// define line break
		$lnbk = '
			<tr>
				<td colspan="3"></td>
			</tr>
		';
	
		// begin table
		$tbl .= '
		<table class="dataTable">
			<tr>
				<td colspan="3"></td>
			</tr>
			<tr>
		 		<th class="tableTitle" colspan="3">Identification Elements</th>
		 	</tr>
		';
		
		// line break
		$tbl .= $lnbk;
		
		// table content
		$tblcontent = "";
		
		
		//------------------------------------------------------------+
		
		$identifiedby = "";
	    foreach ($identificationElement->identifiedby as $value) {
	        $identifiedby .= $value->identifiedby . ", ";
	    }
	    $identifiedby = substr($identifiedby, 0, -2);
	    
	    $typestatus = "";
	    foreach ($identificationElement->typestatus as $value) {
	        $typestatus .= $value->typestatus . ", ";
	    }
	    $typestatus = substr($typestatus, 0, -2);
		
		$tblcontent .= $this->addRow(CHtml::activeLabel($identificationElement, "dateidentified"), $identificationElement->dateidentified);
		$tblcontent .= $this->addRow(CHtml::activeLabel($identificationElement->identificationqualifier, 'identificationqualifier'), $identificationElement->identificationqualifier->identificationqualifier);
		$tblcontent .= $this->addRow(CHtml::activeLabel(IdentifiedByIdentificationAR::model(), "identifiedby"), $identifiedby);
		$tblcontent .= $this->addRow(CHtml::activeLabel(TypeStatusIdentificationAR::model(), "typestatus"), $typestatus);
		$tblcontent .= $this->addRow(CHtml::activeLabel($identificationElement, "identificationremark"), $identificationElement->identificationremark);
		
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
	
	private function generateTableEventElement($eventElement) {
		// define line break
		$lnbk = '
			<tr>
				<td colspan="3"></td>
			</tr>
		';
	
		// begin table
		$tbl .= '
		<table class="dataTable">
			<tr>
				<td colspan="3"></td>
			</tr>
			<tr>
		 		<th class="tableTitle" colspan="3">Occurrence Elements</th>
		 	</tr>
		';
		
		// line break
		$tbl .= $lnbk;
		
		// table content
		$tblcontent = "";
		
		
		//------------------------------------------------------------+
		
		$tblcontent .= $this->addRow(CHtml::activeLabel($eventElement->samplingprotocol, 'samplingprotocol'), $eventElement->samplingprotocol->samplingprotocol);
		$tblcontent .= $this->addRow(CHtml::activeLabel($eventElement, "samplingeffort"), $eventElement->samplingeffort);
		$tblcontent .= $this->addRow(CHtml::activeLabel($eventElement->habitat, 'habitat'), $eventElement->habitat->habitat);
		$tblcontent .= $this->addRow(CHtml::activeLabel($eventElement, "verbatimeventdate"), $eventElement->verbatimeventdate);
		$tblcontent .= $this->addRow(CHtml::activeLabel($eventElement, "eventtime"), $eventElement->eventtime);
		$tblcontent .= $this->addRow(CHtml::activeLabel($eventElement, "eventdate"), $eventElement->eventdate);
		$tblcontent .= $this->addRow(CHtml::activeLabel($eventElement, "fieldnumber"), $eventElement->fieldnumber);
		$tblcontent .= $this->addRow(CHtml::activeLabel($eventElement, "fieldnote"), $eventElement->fieldnote);
		$tblcontent .= $this->addRow(CHtml::activeLabel($eventElement, "eventremark"), $eventElement->eventremark);
		
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
	
	private function generateTableReference($idspecimen) {
		
		$l = new SpecimenLogic();
	    $filter = array('idspecimen'=>$idspecimen);
	    $referenceList = $l->getReference($filter);
	    
	    $l = new ReferenceLogic();
	    $idreference = array();
	    if ($referenceList['count']) {
	    	foreach ($referenceList['list'] as $referenceItem) {
		    	array_push($idreference, $referenceItem['idreferenceelement']); 
	    	}
	    }
	    $filter = array('refShowList'=>$idreference);
	    $referenceList = $l->showReference($filter);
	    
		// section Title
		$tbl = '
			<table class="dataTable">
				<tr>
					<td colspan="3"></td>
				</tr>
				<tr>
			 		<th class="tableTitle" colspan="3">Related Reference Records</th>
			 	</tr>
			 	<tr>
					<td colspan="3"></td>
				</tr>
			</table>
		';
		
		// begin table content
		$tblcontent = "";
		
		if ($referenceList['count'][0]['count']) {
			$tblcontent = '
				<table class="tableList">
					<tr>
			 			<th style="width: 438px">Title</th>
			 			<th style="width: 80px">Subtype</th>
			 			<th style="width: 120px">Publication Year</th>
			 		</tr>
			';
			foreach ($referenceList['list'] as $ref) {
				$tblcontent .= $this->addRowReference($ref);
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
	}
	
	private function generateTableMedia($idspecimen) {
		
		$l = new SpecimenLogic();
	    $filter = array('idspecimen'=>$idspecimen);
	    $mediaList = $l->getMedia($filter);
	    
	    $l = new MediaLogic();
	    $idmedia = array();
	    if ($mediaList['count']) {
	    	foreach ($mediaList['list'] as $mediaItem) {
		    	array_push($idmedia, $mediaItem['idmedia']); 
	    	}
	    }
	    $filter = array('mediaShowList'=>$idmedia);
	    $mediaList = $l->showMedia($filter);
	    
		// section Title
		$tbl = '
			<table class="dataTable">
				<tr>
					<td colspan="5"></td>
				</tr>
				<tr>
					<td colspan="5"></td>
				</tr>
				<tr>
			 		<th class="tableTitle" colspan="5">Related Media Records</th>
			 	</tr>
			 	<tr>
					<td colspan="5"></td>
				</tr>
			</table>
		';
		
		// begin table content
		$tblcontent = "";
		
		if ($mediaList['count'][0]['count']) {
			$tblcontent = '
				<table class="tableList">
					<tr>
			 			<th>Title</th>
			 			<th>Category</th>
			 			<th>Subcategory</th>
			 			<th>Type</th>
			 			<th>Subtype</th>
			 		</tr>
			';
			foreach ($mediaList['list'] as $med) {
				$tblcontent .= $this->addRowMedia($med);
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
	}
	
	/*private function addRowListSpecimen($spm) {
		$taxon;
	    if ($spm['scientificname'] != '' && $spm['scientificname'] != null) {
	    	$taxon = $spm['scientificname'] . " (Scientific Name)";
	    }
	    else if ($spm['infraspecificepithet'] != '' && $spm['infraspecificepithet'] != null) {
	    	$taxon = $spm['infraspecificepithet'] . " (Infraspecific Epithet)";
	    }
	    else if ($spm['specificepithet'] != '' && $spm['specificepithet'] != null) {
	    	$taxon = $spm['specificepithet'] . " (Specific Epithet)";
	    }
	    else if ($spm['subgenus'] != '' && $spm['subgenus'] != null) {
	    	$taxon = $spm['subgenus'] . " (Subgenus)";
	    }
	    else if ($spm['genus'] != '' && $spm['genus'] != null) {
	    	$taxon = $spm['genus'] . " (Genus)";
	    }
	    else if ($spm['family'] != '' && $spm['family'] != null) {
	    	$taxon = $spm['family'] . " (Family)";
	    }
	    else if ($spm['order'] != '' && $spm['order'] != null) {
	    	$taxon = $spm['order'] . " (Order)";
	    }
	    else if ($spm['class'] != '' && $spm['class'] != null) {
	    	$taxon = $spm['class'] . " (Class)";
	    }
	    else if ($spm['phylum'] != '' && $spm['phylum'] != null) {
	    	$taxon = $spm['phylum'] . " (Phylum)";
	    }
	    else if ($spm['kingdom'] != '' && $spm['kingdom'] != null) {
	    	$taxon = $spm['kingdom'] . " (Kingdom)";
	    }
		$row = '
		<tr>
			<td style="text-align: left;">'.$taxon.'</td>
			<td>'.$spm['catalognumber'].'</td>
			<td>'.$spm['institution'].'</td>
			<td>'.$spm['collection'].'</td>
		</tr>
		';
		return $row;
	}

	private function generateTableList($rs) {
		
		// section Title
		$tbl = '
			<table class="dataTable">
				<tr>
			 		<th class="tableTitle" colspan="4">List of Specimen Occurrence Records</th>
			 	</tr>
			 	<tr>
					<td colspan="4"></td>
				</tr>
			</table>
		';
		
		// begin table content
		$tblcontent = "";
		
		if ($rs['count']) {
			$tblcontent = '
				<table class="tableList">
					<tr>
			 			<th>Taxonomic elements</th>
			 			<th>Catalog Number</th>
			 			<th>Institution Code</th>
			 			<th>Collection Code</th>
			 		</tr>
			';
			foreach ($rs['result'] as $spm) {
				$tblcontent .= $this->addRowListSpecimen($spm);
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
			foreach ($rs['result'] as $spm) {
				$taxon;
			    if ($spm['scientificname'] != '' && $spm['scientificname'] != null) {
			    	$taxon = $spm['scientificname'] . " (Scientific Name)";
			    }
			    else if ($spm['infraspecificepithet'] != '' && $spm['infraspecificepithet'] != null) {
			    	$taxon = $spm['infraspecificepithet'] . " (Infraspecific Epithet)";
			    }
			    else if ($spm['specificepithet'] != '' && $spm['specificepithet'] != null) {
			    	$taxon = $spm['specificepithet'] . " (Specific Epithet)";
			    }
			    else if ($spm['subgenus'] != '' && $spm['subgenus'] != null) {
			    	$taxon = $spm['subgenus'] . " (Subgenus)";
			    }
			    else if ($spm['genus'] != '' && $spm['genus'] != null) {
			    	$taxon = $spm['genus'] . " (Genus)";
			    }
			    else if ($spm['family'] != '' && $spm['family'] != null) {
			    	$taxon = $spm['family'] . " (Family)";
			    }
			    else if ($spm['order'] != '' && $spm['order'] != null) {
			    	$taxon = $spm['order'] . " (Order)";
			    }
			    else if ($spm['class'] != '' && $spm['class'] != null) {
			    	$taxon = $spm['class'] . " (Class)";
			    }
			    else if ($spm['phylum'] != '' && $spm['phylum'] != null) {
			    	$taxon = $spm['phylum'] . " (Phylum)";
			    }
			    else if ($spm['kingdom'] != '' && $spm['kingdom'] != null) {
			    	$taxon = $spm['kingdom'] . " (Kingdom)";
			    }
			    
				$data .= $taxon.';'.$spm['catalognumber'].';'.$spm['institution'].';'.$spm['collection']."\n";
			}	
		}
		return $data;
	}
	
	public function printSpecimen($spm) {	
		// create new PDF document
		$pdf = new SpecimenPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Biodiversity Data Digitizer');
		$pdf->SetTitle('Specimen occurrence record Id='.$spm->idspecimen);
		$pdf->SetSubject('Specimen occurrence record');
		$pdf->SetKeywords('BDD, specimen');
		
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
		
		$tbl .= $this->generateTableRecordLevelElement($spm->recordlevelelement);
		$tbl .= $this->generateTableTaxonomicElement($spm->taxonomicelement);
		$tbl .= $this->generateTableLocationElement($spm->localityelement, $spm->geospatialelement);
		$tbl .= $this->generateTableOccurrenceElement($spm->occurrenceelement);
		$tbl .= $this->generateTableIdentificationElement($spm->identificationelement);
		$tbl .= $this->generateTableEventElement($spm->eventelement);
		$tbl .= $this->generateTableMedia($spm->idspecimen);
		$tbl .= $this->generateTableReference($spm->idspecimen);
		
		$pdf->writeHTML($tbl, true, false, false, false, '');
		
		// ---------------------------------------------------------
		
		//Close and output PDF document
		
		$file = "tmp/bdd-specimen-".$spm->idspecimen.".pdf";
		$pdf->Output($file, 'F');
		
		//============================================================+
		// END OF FILE
		//============================================================+
				
		return $file;
	}
	
	public function printSpecimenList($rs) {
		// create new PDF document
		$pdf = new SpecimenListPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Biodiversity Data Digitizer');
		$pdf->SetTitle('Specimen List');
		$pdf->SetSubject('List of specimens occurrence records');
		$pdf->SetKeywords('BDD, specimen, occurrence');
		
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
		$header = array('Taxonomic elements', 'Catalog Number', 'Institution Code', 'Collection Code');
		
		//Data loading
		$txt = "tmp/bdd-specimenList-data.txt";
		$file = fopen($txt,"w");
		fwrite($file, $this->generateDataList($rs));
		fclose($file);
		
		$data = $pdf->LoadData($txt);
		
		// print colored table
		$pdf->ColoredTable($header, $data);
		
		// ---------------------------------------------------------
		
		//Close and output PDF document
		
		$pathToFile = "tmp/bdd-specimenList-".time().".pdf";

		$pdf->Output($pathToFile, 'F');		
		
		//============================================================+
		// END OF FILE
		//============================================================+
				
		return $pathToFile;

	}
}

	
?>