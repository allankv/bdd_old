<?php

include_once("protected/controllers/logic/print/Print.php");

require_once("protected/extensions/tcpdf/config/lang/eng.php");
require_once("protected/extensions/tcpdf/tcpdf.php");

// Extend the TCPDF class to create custom Header and Footer
class MediaPDF extends TCPDF {

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
		$this->Cell(0, 2, '  Media Resource', 0, 1, 'L', false, '', 0, false, 'T', 'M');
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

class MediaListPDF extends TCPDF {

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
		$this->Cell(0, 2, '  Media list', 0, 1, 'L', false, '', 0, false, 'T', 'M');
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
		$this->Cell(0, 1, 'List of Media Records', 'B', 1, 'L', false, '', 0, false, 'T', 'M');
		$this->Ln(5);
        // Colors, line width and bold font
        $this->SetFillColor(244, 239, 217);
        $this->SetTextColor(136, 85, 34);
        $this->SetDrawColor(246, 168, 40);
        $this->SetLineWidth(0.3);
        $this->SetFont('Helvetica', 'B', 12);
        // Header
        $w = array(68, 28, 28, 28, 28);
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
			$rowcount = max($this->getNumLines($row[0], $w[0]), $this->getNumLines($row[1], $w[1]), $this->getNumLines($row[2], $w[2]), $this->getNumLines($row[3], $w[3]), $this->getNumLines($row[4], $w[4]));
		 
			$startY = $this->GetY();
		 
			if (($startY + $rowcount * 6) + $dimensions['bm'] > ($dimensions['hk'])) {
					$this->Cell(array_sum($w), 0, '', '');
					$this->Ln();
			}
		 
			//cell height is 6 times the max number of cells
			$this->MultiCell($w[0], $rowcount * 6, $row[0], 'LRTB', 'L', 0, 0);
			$this->MultiCell($w[1], $rowcount * 6, $row[1], 'LRTB', 'C', 0, 0);
			$this->MultiCell($w[2], $rowcount * 6, $row[2], 'LRTB', 'C', 0, 0);
			$this->MultiCell($w[3], $rowcount * 6, $row[3], 'LRTB', 'C', 0, 0);
			$this->MultiCell($w[4], $rowcount * 6, $row[4], 'LRTB', 'C', 0, 0);
		 
            $this->Ln();
        }
    }
}

class MediaPrint extends Printer {
	private function generateTableMainInformation($media) {
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
	
	if ($media->title || $media->caption || $media->typemedia->typemedia || $media->subtype->subtype || $media->categorymedia->categorymedia ||
		$media->subcategorymedia->subcategorymedia) {
	
		$tblcontent .= $this->addRow(CHtml::activeLabel($media, "title"), $media->title);
		$tblcontent .= $this->addRow(CHtml::activeLabel($media,'caption'), $media->caption);
		$tblcontent .= $this->addRow(CHtml::activeLabel(TypeMediaAR::model(),'typemedia'), $media->typemedia->typemedia);
		$tblcontent .= $this->addRow(CHtml::activeLabel(SubtypeAR::model(),'subtype'), $media->subtype->subtype);
		$tblcontent .= $this->addRow(CHtml::activeLabel(CategoryMediaAR::model(),'categorymedia'), $media->categorymedia->categorymedia);
		$tblcontent .= $this->addRow(CHtml::activeLabel(SubcategoryMediaAR::model(),'subcategorymedia'), $media->subcategorymedia->subcategorymedia);
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
	
	private function generateTableOtherInformation($media) {
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
	
	$tags = "";
    foreach ($media->tag as $value) {
        $tags .= $value->tag . "; ";
    }
    $tags = substr($tags, 0, -2);
	
	$creator = "";
    foreach ($media->creator as $value) {
        $creator .= $value->creator . "; ";
    }
    $creator = substr($creator, 0, -2);
	
	if ($media->extent || $media->language->language || $media->description || $tags || $media->capturedevice->capturedevice ||
		$creator || $media->metadataprovider->metadataprovider || $media->timedigitized || $media->datedigitized || $media->copyrightowner ||
		$media->copyrightstatement || $media->formatmedia->formatmedia || $media->attributionlinkurl || $media->attributionlogourl || 
		$media->attributionstatement || $media->accesspoint || $media->accessurl || $media->dateavailable || $media->comment) {
	
		$tblcontent .= $this->addRow(CHtml::activeLabel($media,"extent"), $media->extent);
		$tblcontent .= $this->addRow(CHtml::activeLabel(LanguageAR::model(), 'language'), $media->language->language);
		$tblcontent .= $this->addRow(CHtml::activeLabel($media, 'description'), $media->description);
		$tblcontent .= $this->addRow(CHtml::activeLabel(TagAR::model(),'tag'), $tags);
		$tblcontent .= $this->addRow(CHtml::activeLabel(CaptureDeviceAR::model(),'capturedevice'), $media->capturedevice->capturedevice);
		$tblcontent .= $this->addRow(CHtml::activeLabel(CreatorAR::model(),'creator'), $creator);
		$tblcontent .= $this->addRow(CHtml::activeLabel(MetadataProviderAR::model(),'metadataprovider'), $media->metadataprovider->metadataprovider);
		$tblcontent .= $this->addRow(CHtml::activeLabel($media,"timedigitized").' (24 hh:mm:ss)', $media->timedigitized);
		$tblcontent .= $this->addRow(CHtml::activeLabel($media,"datedigitized").' (YYYY/MM/DD)', $media->datedigitized);
		$tblcontent .= $this->addRow(CHtml::activeLabel($media,"copyrightowner"), $media->copyrightowner);
		
		$tblcontent .= $this->addRow(CHtml::activeLabel($media,"copyrightstatement"), $media->copyrightstatement);
		$tblcontent .= $this->addRow(CHtml::activeLabel(FormatMediaAR::model(), 'formatmedia'), $media->formatmedia->formatmedia);
		$tblcontent .= $this->addRow(CHtml::activeLabel($media,"attributionlinkurl"), $media->attributionlinkurl);
		$tblcontent .= $this->addRow(CHtml::activeLabel($media,"attributionlogourl"), $media->attributionlogourl);
		$tblcontent .= $this->addRow(CHtml::activeLabel($media,"attributionstatement"), $media->attributionstatement);
		$tblcontent .= $this->addRow(CHtml::activeLabel($media,"accesspoint"), $media->accesspoint);
		$tblcontent .= $this->addRow(CHtml::activeLabel($media,"accessurl"), $media->accessurl);
		$tblcontent .= $this->addRow(CHtml::activeLabel($media,"dateavailable").' (YYYY/MM/DD)', $media->dateavailable);
		$tblcontent .= $this->addRow(CHtml::activeLabel($media, 'comment'), $media->comment);
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
	
	/*private function generateTableList($rs) {
		// section Title
		$tbl = '
			<table class="dataTable">
				<tr>
			 		<th class="tableTitle" colspan="5">List of Media Records</th>
			 	</tr>
			 	<tr>
					<td colspan="5"></td>
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
			 			<th>Category</th>
			 			<th>Subcategory</th>
			 			<th>Type</th>
			 			<th>Subtype</th>
			 		</tr>
			';		
			
			foreach ($rs['result'] as $media) {
				$tblcontent .= $this->addRowListMedia($media);
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
			foreach ($rs['result'] as $media) {
				$data .= $media['title'].';'.$media['categorymedia'].';'.$media['subcategorymedia'].';'.$media['typemedia'].';'.$media['subtype']."\n";
			}	
		}
		return $data;
	}
	
	public function printMedia($media) {
		// create new PDF document
		$pdf = new MediaPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Biodiversity Data Digitizer');
		$pdf->SetTitle('Media Resource Id='.$media->idmedia);
		$pdf->SetSubject('Media Resource');
		$pdf->SetKeywords('BDD, media');
		
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
		
		$tbl .= $this->generateTableMainInformation($media);
		$tbl .= $this->generateTableOtherInformation($media);
		$pdf->writeHTML($tbl, true, false, false, false, '');
		
		// ---------------------------------------------------------
		
		//Close and output PDF document
		$file = "tmp/bdd-media-".$media->idmedia.".pdf";
		$pdf->Output($file, 'F');
		
		//============================================================+
		// END OF FILE
		//============================================================+
				
		return $file;


	}
	
	public function printMediaList($rs) {		
		// create new PDF document
		$pdf = new MediaListPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Biodiversity Data Digitizer');
		$pdf->SetTitle('Media List');
		$pdf->SetSubject('List of media records');
		$pdf->SetKeywords('BDD, media');
		
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
		$header = array('Title', 'Category', 'Subcategory', 'Type', 'Subtype');
		
		//Data loading
		$txt = "tmp/bdd-mediaList-data.txt";
		$file = fopen($txt,"w");
		fwrite($file, $this->generateDataList($rs));
		fclose($file);
		
		$data = $pdf->LoadData($txt);
		
		// print colored table
		$pdf->ColoredTable($header, $data);
		
		// ---------------------------------------------------------
		
		//Close and output PDF document
		
		$pathToFile = "tmp/bdd-mediaList-".time().".pdf";

		$pdf->Output($pathToFile, 'F');		
		
		//============================================================+
		// END OF FILE
		//============================================================+
				
		return $pathToFile;
	}
}

?>