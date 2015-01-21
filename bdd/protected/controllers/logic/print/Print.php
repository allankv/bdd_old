<?php
class Printer {
	protected function addRow($label, $content) {
		$row = "";
		if ($content) {
			$row = '
			<tr>
				<td class="tableleftcel">'.$label.'</td>
				<td class="tablemiddlecel">:</td>
				<td class="tablerightcel">'.$content.'</td>
			</tr>
			';
		}
		return $row;
	}
	
	protected function addRowReference($referenceItem) {
		$row = '
		<tr>
			<td style="width: 438px; text-align: left;">'.$referenceItem['title'].'</td>
			<td style="width: 80px;">'.$referenceItem['subtypereference'].'</td>
			<td style="width: 120px;">'.$referenceItem['publicationyear'].'</td>
		</tr>
		';
		return $row;
	}
	
	protected function addRowMedia($mediaItem) {
		$row = '
		<tr>
			<td style="text-align: left;">'.$mediaItem['title'].'</td>
			<td>'.$mediaItem['categorymedia'].'</td>
			<td>'.$mediaItem['subcategorymedia'].'</td>
			<td>'.$mediaItem['typemedia'].'</td>
			<td>'.$mediaItem['subtype'].'</td>
		</tr>
		';
		return $row;
	}
	
	protected function getCss() {
		$css = "
		<style>
		    .tableTitle {
		    	border-bottom: 3px solid green;
			    color: green;
			    font-family: Helvetica;
			    font-size: 50px;
			    font-weight: bold;
			    text-align: left;
		    }
		    .tableleftcel {
		    	color: sienna;
		    	font-family: Helvetica;
		    	font-size: 35px;
		    	text-align: right;
		    	width: 250px;
		    }
		    .tablemiddlecel {
		    	font-family: Helvetica;
		    	text-align: center;
		    	width: 35px;
		    }
		    .tablerightcel {
		    	font-family: Helvetica;
		    	font-size: 35px;
		    	text-align: left;
		    }
		    .tableList {
		    	padding:5px 5px 5px 5px;
		    }
		    .tableList tr th {
		    	font-family: Helvetica;
		    	text-align: center;
		    	background-color: #F4EFD9;
			    border: 1px solid #F6A828;
			    color: #885522;
			    font-size: 10pt;
			    font-weight: bold;
			    padding: 6px;
		    }
		    .tableList tr td {
		    	border: 1px solid #DDDDDD;
		    	font-family: Helvetica;
		    	text-align: center;
		    	font-size: 35px;
		    }
		</style>
		";
	
		return $css;
	}
}
?>