<?php

include_once("protected/controllers/logic/print/Print.php");

include_once("protected/controllers/logic/SpeciesLogic.php");
include_once("protected/controllers/logic/MediaLogic.php");
include_once("protected/controllers/logic/ReferenceLogic.php");

require_once("protected/extensions/tcpdf/config/lang/eng.php");
require_once("protected/extensions/tcpdf/tcpdf.php");

// Extend the TCPDF class to create custom Header and Footer
class SpeciesPDF extends TCPDF {

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
		$this->Cell(0, 2, '  Species occurrence record', 0, 1, 'L', false, '', 0, false, 'T', 'M');
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

class SpeciesListPDF extends TCPDF {

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
		$this->Cell(0, 2, '  Species list', 0, 1, 'L', false, '', 0, false, 'T', 'M');
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
		$this->Cell(0, 1, 'List of Species Records', 'B', 1, 'L', false, '', 0, false, 'T', 'M');
		$this->Ln(5);
        // Colors, line width and bold font
        $this->SetFillColor(244, 239, 217);
        $this->SetTextColor(136, 85, 34);
        $this->SetDrawColor(246, 168, 40);
        $this->SetLineWidth(0.3);
        $this->SetFont('Helvetica', 'B', 12);
        // Header
        $w = array(100, 80);
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
			$rowcount = max($this->getNumLines($row[0], $w[0]), $this->getNumLines($row[1], $w[1]));
		 
			$startY = $this->GetY();
		 
			if (($startY + $rowcount * 6) + $dimensions['bm'] > ($dimensions['hk'])) {
					//$this->Cell(array_sum($w), 0, '', '');
					$this->addPage();
			}
		 
			//cell height is 6 times the max number of cells
			$this->MultiCell($w[0], $rowcount * 6, $row[0], 'LRTB', 'L', 0, 0);
			$this->MultiCell($w[1], $rowcount * 6, $row[1], 'LRTB', 'C', 0, 0);
		 
            $this->Ln();
        }
    }
}

class SpeciesPrint extends Printer {
	
	private function generateTableMainInformation($spc) {
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
	
	$tblcontent .= $this->addRow(CHtml::activeLabelEx($spc->institutioncode,'institutioncode'), $spc->institutioncode->institutioncode);
	$tblcontent .= $this->addRow(CHtml::activeLabel($spc->taxonomicelement->scientificname,'scientificname'), $spc->taxonomicelement->scientificname->scientificname);
		
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
	
	private function generateTableSpeciesInformation($spc) {
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
	 		<th class="tableTitle" colspan="3">Species Information</th>
	 	</tr>
	';
	
	// line break
	$tbl .= $lnbk;
	
	// table content
	$tblcontent = "";
	
	//------------------------------------------------------------+
	
	$creator = "";
    foreach ($spc->creator as $value) {
        $creator .= $value->creator . "; ";
    }
    $creator = substr($creator, 0, -2);
    
    $contributor = "";
    foreach ($spc->contributor as $value) {
        $contributor .= $value->contributor . "; ";
    }
    $contributor = substr($contributor, 0, -2);
    
    $relatedname = "";
    foreach ($spc->relatedname as $value) {
        $relatedname .= $value->relatedname . "; ";
    }
    $relatedname = substr($relatedname, 0, -2);
    
    $synonym = "";
    foreach ($spc->synonym as $value) {
        $synonym .= $value->synonym . "; ";
    }
    $synonym = substr($synonym, 0, -2);
	
	if ($spc->language->language || $creator || $contributor || $relatedname || $synonym || $spc->abstract || $spc->annualcycle || 
		$spc->authoryearofscientificname || $spc->behavior || $spc->benefits || $spc->briefdescription || $spc->chromosomicnumber ||
		$spc->comprehensivedescription || $spc->conservationstatus || $spc->datecreated || $spc->datelastmodified || $spc->distribution ||
		$spc->ecologicalsignificance || $spc->endemicity || $spc->feeding || $spc->folklore || $spc->lsid || $spc->habit || $spc->habitat ||
		$spc->interactions || $spc->invasivenessdata || $spc->legislation || $spc->lifecycle || $spc->lifeexpectancy || $spc->management ||
		$spc->migratorydata || $spc->moleculardata || $spc->morphology || $spc->occurrence || $spc->otherinformationsources || $spc->populationbiology ||
		$spc->reproduction || $spc->scientificdescription || $spc->size || $spc->targetaudiences || $spc->territory || $spc->threatstatus ||
		$spc->typification || $spc->unstructureddocumentation || $spc->unstructurednaturalhistory || $spc->uses || $spc->version) {
	
		$tblcontent .= $this->addRow(CHtml::activeLabel(LanguageAR::model(), 'language'), $spc->language->language);
		$tblcontent .= $this->addRow(CHtml::activeLabel(CreatorAR::model(),'creator'), $creator);
		$tblcontent .= $this->addRow(CHtml::activeLabel(ContributorAR::model(),'contributor'), $contributor);
		$tblcontent .= $this->addRow(CHtml::activeLabel(RelatedNameAR::model(),'relatedname'), $relatedname);
		$tblcontent .= $this->addRow(CHtml::activeLabel(SynonymAR::model(),'synonym'), $synonym);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'abstract'), $spc->abstract);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'annualcycle'), $spc->annualcycle);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'authoryearsofscientificname'), $spc->authoryearofscientificname);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'behavior'), $spc->behavior);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'benefits'), $spc->benefits);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'briefdescription'), $spc->briefdescription);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'chromosomicnumber'), $spc->chromosomicnumber);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'comprehensivedescription'), $spc->comprehensivedescription);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'conservationstatus'), $spc->conservationstatus);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'datecreated'), $spc->datecreated);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'datelastmodified'), $spc->datelastmodified);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'distribution'), $spc->distribution);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'ecologicalsignificance'), $spc->ecologicalsignificance);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'endemicity'), $spc->endemicity);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'feeding'), $spc->feeding);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'folklore'), $spc->folklore);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'lsid'), $spc->lsid);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'habit'), $spc->habit);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'habitat'), $spc->habitat);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'interactions'), $spc->interactions);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'invasivenessdata'), $spc->invasivenessdata);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'legislation'), $spc->legislation);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'lifecycle'), $spc->lifecycle);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'lifeexpectancy'), $spc->lifeexpectancy);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'management'), $spc->management);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'migratorydata'), $spc->migratorydata);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'moleculardata'), $spc->moleculardata);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'morphology'), $spc->morphology);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'occurrence'), $spc->occurrence);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'otherinformationsources'), $spc->otherinformationsources);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'populationbiology'), $spc->populationbiology);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'reproduction'), $spc->reproduction);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'scientificdescription'), $spc->scientificdescription);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'size'), $spc->size);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'targetaudiences'), $spc->targetaudiences);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'territory'), $spc->territory);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'threatstatus'), $spc->threatstatus);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'typification'), $spc->typification);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'unstructureddocumentation'), $spc->unstructureddocumentation);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'unstructurednaturalhistory'), $spc->unstructurednaturalhistory);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'uses'), $spc->uses);
		$tblcontent .= $this->addRow(CHtml::activeLabel($spc,'version'), $spc->version);
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
	
	private function generateSpeciesTaxonomic($taxonomicElement) {
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
	 		<th class="tableTitle" colspan="3">Taxonomic Elements</th>
	 	</tr>
	';
	
	// line break
	$tbl .= $lnbk;
	
	// table content
	$tblcontent = "";
	
	//------------------------------------------------------------+
	
	if ($taxonomicElement->kingdom->kingdom || $taxonomicElement->phylum->phylum || $taxonomicElement->class->class || $taxonomicElement->order->order || 
		$taxonomicElement->family->family || $taxonomicElement->genus->genus || $taxonomicElement->subgenus->subgenus || 
		$taxonomicElement->specificepithet->specificepithet || $taxonomicElement->infraspecificepithet->infraspecificepithet) {
	
		$tblcontent .= $this->addRow(CHtml::activeLabel(KingdomAR::model(), 'kingdom'), $taxonomicElement->kingdom->kingdom);
		$tblcontent .= $this->addRow(CHtml::activeLabel(PhylumAR::model(), "phylum"), $taxonomicElement->phylum->phylum);
		$tblcontent .= $this->addRow(CHtml::activeLabel(ClassAR::model(), "class"), $taxonomicElement->class->class);
		$tblcontent .= $this->addRow(CHtml::activeLabel(OrderAR::model(), "order"), $taxonomicElement->order->order);
		$tblcontent .= $this->addRow(CHtml::activeLabel(FamilyAR::model(), "family"), $taxonomicElement->family->family);
		$tblcontent .= $this->addRow(CHtml::activeLabel(GenusAR::model(), "genus"), $taxonomicElement->genus->genus);
		$tblcontent .= $this->addRow(CHtml::activeLabel(SubgenusAR::model(), "subgenus"), $taxonomicElement->subgenus->subgenus);
		$tblcontent .= $this->addRow(CHtml::activeLabel(SpecificEpithetAR::model(), "specificepithet"), $taxonomicElement->specificepithet->specificepithet);
		$tblcontent .= $this->addRow(CHtml::activeLabel(InfraspecificEpithetAR::model(), "infraspecificepithet"), $taxonomicElement->infraspecificepithet->infraspecificepithet);
	
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
	
	private function generateTableMedia($idspecies) {
	
	$l = new SpeciesLogic();
    $filter = array('idspecies'=>$idspecies);
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
	
	private function generateTableReference($idspecies) {
	
	$l = new SpeciesLogic();
    $filter = array('idspecies'=>$idspecies);
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
	
	private function generateTablePaper($idspecies) {
	
	$l = new SpeciesLogic();
    $filter = array('idspecies'=>$idspecies);
    $referenceList = $l->getPaper($filter);
    
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
				<td colspan="3"></td>
			</tr>
			<tr>
		 		<th class="tableTitle" colspan="3">Related Papers</th>
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
	
	private function generateTablePublicationReference($idspecies) {
	
	$l = new SpeciesLogic();
    $filter = array('idspecies'=>$idspecies);
    $referenceList = $l->getPubReference($filter);
    
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
				<td colspan="3"></td>
			</tr>
			<tr>
		 		<th class="tableTitle" colspan="3">Related Publication References</th>
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
	
	private function generateTableIdentificationKey($idspecies) {
	
	$l = new SpeciesLogic();
    $filter = array('idspecies'=>$idspecies);
    $referenceList = $l->getKey($filter);
    
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
				<td colspan="3"></td>
			</tr>
			<tr>
		 		<th class="tableTitle" colspan="3">Related Identification Keys</th>
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
	
	/*
	private function addRowListSpecies($spc) {
		$row = '
		<tr>
			<td>'.$spc['scientificname'].'</td>
			<td>'.$spc['institutioncode'].'</td>
		</tr>
		';
		return $row;
	}
	private function generateTableList($rs) {
		// section Title
		$tbl = '
			<table class="dataTable">
				<tr>
			 		<th class="tableTitle" colspan="2">List of Species Records</th>
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
			 			<th>Taxonomic elements</th>
			 			<th>Institution Code</th>
			 		</tr>
			';
			foreach ($rs['result'] as $spc) {
				$tblcontent .= $this->addRowListSpecies($spc);
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
			foreach ($rs['result'] as $spc) {
				$data .= $spc['scientificname'].';'.$spc['institutioncode']."\n";
			}	
		}
		return $data;
	}
	
	public function printSpecies($spc) {
		// create new PDF document
		$pdf = new SpeciesPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Biodiversity Data Digitizer');
		$pdf->SetTitle('Species occurrence record Id='.$spc->idspecies);
		$pdf->SetSubject('Species occurrence record');
		$pdf->SetKeywords('BDD, species');
		
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
		
		$tbl .= $this->generateTableMainInformation($spc);
		$tbl .= $this->generateTableSpeciesInformation($spc);
		$tbl .= $this->generateSpeciesTaxonomic($spc->taxonomicelement);
		$tbl .= $this->generateTableMedia($spc->idspecies);
		$tbl .= $this->generateTableReference($spc->idspecies);
		$tbl .= $this->generateTablePaper($spc->idspecies);
		$tbl .= $this->generateTablePublicationReference($spc->idspecies);
		$tbl .= $this->generateTableIdentificationKey($spc->idspecies);
		$pdf->writeHTML($tbl, true, false, false, false, '');
		
		// ---------------------------------------------------------
		
		$file = "tmp/bdd-species-".$spc->idspecies.".pdf";
		$pdf->Output($file, 'F');
		
		//============================================================+
		// END OF FILE
		//============================================================+
				
		return $file;
	}
	
	public function printSpeciesList($rs) {
		// create new PDF document
		$pdf = new SpeciesListPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Biodiversity Data Digitizer');
		$pdf->SetTitle('Species List');
		$pdf->SetSubject('List of species occurrence records');
		$pdf->SetKeywords('BDD, species');
		
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
		$header = array('Taxonomic elements', 'Institution Code');
		
		//Data loading
		$txt = "tmp/bdd-speciesList-data.txt";
		$file = fopen($txt,"w");
		fwrite($file, $this->generateDataList($rs));
		fclose($file);
		
		$data = $pdf->LoadData($txt);
		
		// print colored table
		$pdf->ColoredTable($header, $data);
		
		// ---------------------------------------------------------
		
		//Close and output PDF document
		
		$pathToFile = "tmp/bdd-speciesList-".time().".pdf";

		$pdf->Output($pathToFile, 'F');		
		
		//============================================================+
		// END OF FILE
		//============================================================+
				
		return $pathToFile;

	}
}
	
?>