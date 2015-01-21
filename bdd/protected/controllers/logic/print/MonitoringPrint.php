<?php

include_once("protected/controllers/logic/print/Print.php");

require_once("protected/extensions/tcpdf/config/lang/eng.php");
require_once("protected/extensions/tcpdf/tcpdf.php");

// Extend the TCPDF class to create custom Header and Footer
class MonitoringPDF extends TCPDF {

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
		$this->Cell(0, 2, '  Registro de Monitoramento', 0, 1, 'L', false, '', 0, false, 'T', 'M');
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

class MonitoringListPDF extends TCPDF {

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
		$this->Cell(0, 2, '  Monitoring list', 0, 1, 'L', false, '', 0, false, 'T', 'M');
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
		$this->Cell(0, 1, 'List of Monitoring Records', 'B', 1, 'L', false, '', 0, false, 'T', 'M');
		$this->Ln(5);
        // Colors, line width and bold font
        $this->SetFillColor(244, 239, 217);
        $this->SetTextColor(136, 85, 34);
        $this->SetDrawColor(246, 168, 40);
        $this->SetLineWidth(0.3);
        $this->SetFont('Helvetica', 'B', 10);
        // Header
        $w = array(50, 50, 40, 40);
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
			$this->MultiCell($w[0], $rowcount * 6, $row[0], 'LRTB', 'C', 0, 0);
			$this->MultiCell($w[1], $rowcount * 6, $row[1], 'LRTB', 'C', 0, 0);
			$this->MultiCell($w[2], $rowcount * 6, $row[2], 'LRTB', 'C', 0, 0);
			$this->MultiCell($w[3], $rowcount * 6, $row[3], 'LRTB', 'C', 0, 0);
		 
            $this->Ln();
        }
    }
}

class MonitoringPrint extends Printer {
	
	private function generateTableMainInformation($monitoring) {
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
	 		<th class="tableTitle" colspan="3">Informações Principais</th>
	 	</tr>
	';
	
	// line break
	$tbl .= $lnbk;
	
	// table content
	$tblcontent = "";
	
	//------------------------------------------------------------+
	
	if ($monitoring->recordlevelelement->basisofrecord->basisofrecord || $monitoring->recordlevelelement->institutioncode->institutioncode || 
		$monitoring->recordlevelelement->collectioncode->collectioncode || $monitoring->occurrenceelement->catalognumber || 
		$monitoring->idgeral || $monitoring->taxonomicelement->scientificname->scientificname) {
	
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Base do Registro'), ""), $monitoring->recordlevelelement->basisofrecord->basisofrecord);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Código de Instituição'), ""), $monitoring->recordlevelelement->institutioncode->institutioncode);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Código de Coleção'), ""), $monitoring->recordlevelelement->collectioncode->collectioncode);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Número de Catálogo'), ""), $monitoring->occurrenceelement->catalognumber);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','ID Geral'), ""), $monitoring->idgeral);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Nome Científico'), ""), $monitoring->taxonomicelement->scientificname->scientificname==''?$monitoring->taxonomicelement->morphospecies->morphospecies:$monitoring->taxonomicelement->scientificname->scientificname);
	}
		
	//------------------------------------------------------------+
	
	if ($monitoring->denomination->denomination || $monitoring->technicalcollection->technicalcollection || $monitoring->digitizer->digitizer ||
		$monitoring->collector->collector) {
		
		$tblcontent .= $lnbk;
	
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Denominação'), ""), $monitoring->denomination->denomination);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Técnica de Coleta'), ""), $monitoring->technicalcollection->technicalcollection);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Digitador'), ""), $monitoring->digitizer->digitizer);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Coletor'), ""), $monitoring->collector->collector);
	}
	
	//------------------------------------------------------------+
	
	if ($monitoring->geospatialelement->decimallatitude || $monitoring->geospatialelement->decimallongitude) {
		
		$tblcontent .= $lnbk;
	
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Latitude (Graus Decimais)'), ""), $monitoring->geospatialelement->decimallatitude);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Longitude (Graus Decimais)'), ""), $monitoring->geospatialelement->decimallongitude);
	}
	
	//------------------------------------------------------------+
	
	if ($monitoring->localityelement->country->country || $monitoring->localityelement->stateprovince->stateprovince || 
		$monitoring->localityelement->municipality->municipality || $monitoring->localityelement->locality->locality) {
		
		$tblcontent .= $lnbk;
	
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','País'), ""), $monitoring->localityelement->country->country);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Estado ou Província'), ""), $monitoring->localityelement->stateprovince->stateprovince);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Município'), ""), $monitoring->localityelement->municipality->municipality);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Localidade'), ""), $monitoring->localityelement->locality->locality);
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
	
	private function generateTableDadosAmbientais($monitoring) {
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
	 		<th class="tableTitle" colspan="3">Dados Ambientais</th>
	 	</tr>
	';
	
	// line break
	$tbl .= $lnbk;
	
	// table content
	$tblcontent = "";
	
	//------------------------------------------------------------+
	
	if ($monitoring->culture->culture || $monitoring->cultivar->cultivar || $monitoring->surroundingsvegetation->surroundingsvegetation ||
		$monitoring->predominantbiome->predominantbiome) {
	
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Cultura'), ""), $monitoring->culture->culture);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Cultivar'), ""), $monitoring->cultivar->cultivar);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Vegetação Próxima'), ""), $monitoring->surroundingsvegetation->surroundingsvegetation);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Bioma Predominante'), ""), $monitoring->predominantbiome->predominantbiome);
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
	
	private function generateTablePanTraps($monitoring) {
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
	 		<th class="tableTitle" colspan="3">Pan Traps</th>
	 	</tr>
	';
	
	// line break
	$tbl .= $lnbk;
	
	// table content
	$tblcontent = "";
	
	//------------------------------------------------------------+
	
	if ($monitoring->installationdate || $monitoring->installationtime || $monitoring->collectdate || $monitoring->collecttime ||
		$monitoring->surroundingsculture->surroundingsculture || $monitoring->plotnumber || $monitoring->amostralnumber ||
		$monitoring->colorpantrap->colorpantrap || $monitoring->supporttype->supporttype || $monitoring->floorheight) {
		
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Data da Instalação (AAAA/MM/DD)'), ""), $monitoring->installationdate);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Hora da Instalação (24 hh:mm:ss)'), ""), $monitoring->installationtime);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Data da Coleta (AAAA/MM/DD)'), ""), $monitoring->collectdate);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Hora da Coleta (24 hh:mm:ss)'), ""), $monitoring->collecttime);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Entorno/Cultura'), ""), $monitoring->surroundingsculture->surroundingsculture);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Identificação Número do Plot'), ""), $monitoring->plotnumber);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Identificação Número da Unidade Amostral'), ""), $monitoring->amostralnumber);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Cor do Pan Trap'), ""), $monitoring->colorpantrap->colorpantrap);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Tipo de Suporte'), ""), $monitoring->supporttype->supporttype);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Altura do Chão (cm)'), ""), $monitoring->floorheight);
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
	
	private function generateTableTaxonomia($monitoring) {
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
	 		<th class="tableTitle" colspan="3">Taxonomia do Espécime</th>
	 	</tr>
	';
	
	// line break
	$tbl .= $lnbk;
	
	// table content
	$tblcontent = "";
	
	//------------------------------------------------------------+
	
	if ($monitoring->taxonomicelement->order->order || $monitoring->taxonomicelement->family->family || $monitoring->taxonomicelement->tribe->tribe ||
		$monitoring->taxonomicelement->subtribe->subtribe || $monitoring->taxonomicelement->genus->genus ||
		$monitoring->taxonomicelement->speciesname->speciesname || $monitoring->taxonomicelement->subspecies->subspecies ||
		$monitoring->taxonomicelement->vernacularname) {
		
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Ordem'), ""), $monitoring->taxonomicelement->order->order);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Família'), ""), $monitoring->taxonomicelement->family->family);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Tribo'), ""), $monitoring->taxonomicelement->tribe->tribe);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Sub-tribo'), ""), $monitoring->taxonomicelement->subtribe->subtribe);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Gênero'), ""), $monitoring->taxonomicelement->genus->genus);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Espécie'), ""), $monitoring->taxonomicelement->speciesname->speciesname);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Sub-espécie'), ""), $monitoring->taxonomicelement->subspecies->subspecies);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Nome Popular'), ""), $monitoring->taxonomicelement->vernacularname);
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
	
	private function generateTableLocalizacao($monitoring) {
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
	 		<th class="tableTitle" colspan="3">Localização do Espécime</th>
	 	</tr>
	';
	
	// line break
	$tbl .= $lnbk;
	
	// table content
	$tblcontent = "";
	
	//------------------------------------------------------------+
	
	if ($monitoring->localityelement->verbatimelevation || $monitoring->geospatialelement->geodeticdatum || $monitoring->localityelement->locationremark ||
		$monitoring->localityelement->coordinateprecision || $monitoring->geospatialelement->referencepoints) {
		
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Altitude'), ""), $monitoring->localityelement->verbatimelevation);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Datum Geodésico'), ""), $monitoring->geospatialelement->geodeticdatum);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Dados Complementares da Localidade'), ""), $monitoring->localityelement->locationremark);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Precisão GPS'), ""), $monitoring->localityelement->coordinateprecision);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','GPS Pontos de Referência'), ""), $monitoring->geospatialelement->referencepoints);
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
	
	private function generateTableDadosSobreOEspecime($monitoring) {
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
		 		<th class="tableTitle" colspan="3">Dados Sobre o Espécime</th>
		 	</tr>
		';
		
		// line break
		$tbl .= $lnbk;
		
		// table content
		$tblcontent = "";
		
		//------------------------------------------------------------+
		
		if ($monitoring->occurrenceelement->sex->sex || $monitoring->weight || $monitoring->width ||
			$monitoring->length || $monitoring->height) {
			
			$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Sexo'), ""), $monitoring->occurrenceelement->sex->sex);
			$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Peso'), ""), $monitoring->weight . ' mg');
			$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Largura'), ""), $monitoring->width . ' mm');
			$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Comprimento'), ""), $monitoring->length . ' mm');
			$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Altura'), ""), $monitoring->height . ' mm');
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
	
	/*private function generateTableDados($monitoring) {
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
	 		<th class="tableTitle" colspan="3">Dados Sobre o Espécime</th>
	 	</tr>
	';
	
	// line break
	$tbl .= $lnbk;
	
	// table content
	$tblcontent = "";
	
	//------------------------------------------------------------+
	
	if ($monitoring->occurrenceelement->sex->sex || $monitoring->weight || $monitoring->width || $monitoring->length || $monitoring->height) {
		
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Sexo'), ""), $monitoring->occurrenceelement->sex->sex);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Peso (mg)'), ""), $monitoring->weight);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Largura (mm)'), ""), $monitoring->width);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Comprimento (mm)'), ""), $monitoring->length);
		$tblcontent .= $this->addRow(CHtml::label(Yii::t('yii','Altura (mm)'), ""), $monitoring->height);
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
	
		private function addRowListMonitoring($monitoring) {
		$row = '
		<tr>
			<td>'.$monitoring['scientificname'].'</td>
			<td>'.$monitoring['denomination'].'</td>
			<td>'.$monitoring['collection'].'</td>
			<td>'.$monitoring['catalognumber'].'</td>
		</tr>
		';
		return $row;
	}
	
	private function generateTableList($rs) {
		// section Title
		$tbl = '
			<table class="dataTable">
				<tr>
			 		<th class="tableTitle" colspan="4">Lista de registros de monitoramento</th>
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
			 			<th>Elementos taxonômicos</th>
			 			<th>Denominação</th>
			 			<th>Código da Coleção</th>
			 			<th>Número de Catálogo</th>
			 		</tr>
			';
			foreach ($rs['result'] as $spc) {
				$tblcontent .= $this->addRowListMonitoring($spc);
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
			foreach ($rs['result'] as $monitoring) {
				$taxonName = $monitoring['scientificname'] == null ? $monitoring['morphospecies'] : $monitoring['scientificname'];
				$data .= $taxonName.';'.$monitoring['denomination'].';'.$monitoring['collection'].';'.$monitoring['catalognumber']."\n";
			}	
		}
		return $data;
	}
	
	public function printMonitoring($monitoring) {
		// create new PDF document
		$pdf = new MonitoringPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Biodiversity Data Digitizer');
		$pdf->SetTitle('Monitoring record Id='.$monitoring->idmonitoring);
		$pdf->SetSubject('Monitoring record');
		$pdf->SetKeywords('BDD, monitoring, monitoramento');
		
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
		
		// get css from protected/logic/controller/print/Print.php
		$css = $this->getCss();
		
		//============================================================+
		// Build HTML table
		//============================================================+
		
		$tbl = $css;
		
		$tbl .= $this->generateTableMainInformation($monitoring);
		$tbl .= $this->generateTableDadosAmbientais($monitoring);
		$tbl .= $this->generateTablePanTraps($monitoring);
		$tbl .= $this->generateTableTaxonomia($monitoring);
		$tbl .= $this->generateTableLocalizacao($monitoring);
		$tbl .= $this->generateTableDadosSobreOEspecime($monitoring);
		
		$pdf->writeHTML($tbl, true, false, false, false, '');
		
		// ---------------------------------------------------------
		
		//Close and output PDF document
		$file = "tmp/bdd-monitoring-".$monitoring->idmonitoring.".pdf";
		$pdf->Output($file, 'F');
		
		//============================================================+
		// END OF FILE
		//============================================================+
				
		return $file;

	}
	
	public function printMonitoringList($rs) {
		// create new PDF document
		$pdf = new MonitoringListPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Biodiversity Data Digitizer');
		$pdf->SetTitle('Monitoring List');
		$pdf->SetSubject('List of monitoring records');
		$pdf->SetKeywords('BDD, monitoring');
		
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
		$header = array('Elementos taxonômicos', 'Denominação', 'Código da Coleção', 'Número de Catálogo');
		
		//Data loading
		$txt = "tmp/bdd-monitoringList-data.txt";
		$file = fopen($txt,"w");
		fwrite($file, $this->generateDataList($rs));
		fclose($file);
		
		$data = $pdf->LoadData($txt);
		
		// print colored table
		$pdf->ColoredTable($header, $data);
		
		// ---------------------------------------------------------
		
		//Close and output PDF document
		
		$pathToFile = "tmp/bdd-monitoringList-".time().".pdf";

		$pdf->Output($pathToFile, 'F');		
		
		//============================================================+
		// END OF FILE
		//============================================================+
				
		return $pathToFile;

	}

	
}
	
?>