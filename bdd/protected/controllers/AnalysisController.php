<?php
include 'logic/AnalysisLogic.php';
include 'logic/print/AnalysisPrint.php';


class AnalysisController extends CController {
    public $defaultAction='goToAnalysis';
    public function actionGoToAnalysis() {
        $this->render('analysis');
    }
    public function actionFilter() {
        $l = new AnalysisLogic();
        $filter = array('limit'=>$_POST['limit'],'offset'=>$_POST['offset'],'list'=>$_POST['list']);
        $rs = array();

        $spList = $l->filter($filter);
        $list = array();
        foreach($spList['list'] as $n=>$ar) {
            $list[] = array("isrestricted" => $ar['isrestricted'],//$ar->isrestricted,
                    "id" => $ar['idspecimen'],
                    "catalognumber" => $ar['catalognumber'],
                    "scientificname" => $ar['scientificname'],
                    "institution" => $ar['institutioncode'],
                    "collection" => $ar['collectioncode'],
                     "kingdom" => $ar['kingdom'],
	            	"phylum" => $ar['phylum'],
	            	"class" => $ar['class'],
	            	"order" => $ar['order'],
	            	"family" => $ar['family'],
	            	"genus" => $ar['genus'],
	            	"subgenus" => $ar['subgenus'],
	            	"specificepithet" => $ar['specificepithet'],
	            	"infraspecificepithet" => $ar['infraspecificepithet'],
	            	"scientificname" => $ar['scientificname']
            );
        }

        $rs['result'] = $list;
        $rs['count'] = $spList['count'][0]['count'];
        echo CJSON::encode($rs);
    }
    public function actionSearch() {
        $logic = new AnalysisLogic();
        $rs = $logic->search($_GET['term']);
        echo CJSON::encode($rs);
    }
    public function actionGetBasisOfRecord() {
        $l = new AnalysisLogic();
        $filter = array('list'=>$_POST['list']);
        $rs = array();

        $spList = $l->basisOfRecord($filter);
        $list = array();
        $total = $spList['total'];
        $total = $total[0]['count'];
        foreach($spList['list'] as $n=>$ar) {
        	if ($ar['basisofrecord']) {     
	            $list[] = array(
	            	"basisofrecord" => $ar['basisofrecord'],
	                "count" => $ar['count'],
	                "perc" => round(100*$ar['count']/$total, 2)."%"
	            );
           	} 
        }
        $rs['result'] = $list;
        echo CJSON::encode($rs);
    }
    public function actionGetInstitutionCode() {
        $l = new AnalysisLogic();
        $filter = array('list'=>$_POST['list']);
        $rs = array();

        $spList = $l->institutioncode($filter);
        $list = array();
        $total = $spList['total'];
        $total = $total[0]['count'];
        foreach($spList['list'] as $n=>$ar) {
        	if ($ar['institutioncode']) {     
	            $list[] = array(
	            	"institutioncode" => $ar['institutioncode'],
	                "count" => $ar['count'],
	                "perc" => round(100*$ar['count']/$total, 2)."%"
	            );
           	} 
        }
        $rs['result'] = $list;
        echo CJSON::encode($rs);
    }
    public function actionGetCollectionCode() {
        $l = new AnalysisLogic();
        $filter = array('list'=>$_POST['list']);
        $rs = array();

        $spList = $l->collectionCode($filter);
        $list = array();
        $total = $spList['total'];
        $total = $total[0]['count'];
        foreach($spList['list'] as $n=>$ar) {
        	if ($ar['collectioncode']) {     
	            $list[] = array(
	            	"collectioncode" => $ar['collectioncode'],
	                "count" => $ar['count'],
	                "perc" => round(100*$ar['count']/$total, 2)."%"
	            );
           	} 
        }
        $rs['result'] = $list;
        echo CJSON::encode($rs);
    }
    public function actionGetTaxon() {
    	$rs = array();
        $l = new AnalysisLogic();
        $filter = array('list'=>$_POST['list']);
		
		$type = $_POST['type']=="NULL"?null:$_POST['type'];
		$idkingdom = $_POST['idkingdom']=="NULL"?null:$_POST['idkingdom'];
        $idphylum = $_POST['idphylum']=="NULL"?null:$_POST['idphylum'];
        $idclass = $_POST['idclass']=="NULL"?null:$_POST['idclass'];
        $idorder = $_POST['idorder']=="NULL"?null:$_POST['idorder'];
        $idfamily = $_POST['idfamily']=="NULL"?null:$_POST['idfamily'];
        $idgenus = $_POST['idgenus']=="NULL"?null:$_POST['idgenus'];
        $idsubgenus = $_POST['idsubgenus']=="NULL"?null:$_POST['idsubgenus'];
        $idspecificepithet = $_POST['idspecificepithet']=="NULL"?null:$_POST['idspecificepithet'];
        $idinfraspecificepithet = $_POST['idinfraspecificepithet']=="NULL"?null:$_POST['idinfraspecificepithet'];
        
        $taxon = $l->taxon($filter, $type, $idkingdom, $idphylum, $idclass, $idorder, $idfamily, $idgenus, $idsubgenus, $idspecificepithet, $idinfraspecificepithet);
        
        $rs['result'] = $taxon;
        echo CJSON::encode($rs);
    }

    public function actionGetCountry() {
        $l = new AnalysisLogic();
        $filter = array('list'=>$_POST['list']);
        $rs = array();

        $spList = $l->country($filter);
        $list = array();
        $total = $spList['total'];
        $total = $total[0]['count'];
        foreach($spList['list'] as $n=>$ar) {
        	if ($ar['country']) {     
	            $list[] = array(
	            	"country" => $ar['country'],
	                "count" => $ar['count'],
	                "perc" => round(100*$ar['count']/$total, 2)."%"
	            );
           	}
           	else {
           		$list[] = array(
	            	"country" => "No country",
	                "count" => $ar['count'],
	                "perc" => round(100*$ar['count']/$total, 2)."%"
	            );
           	} 
        }
        $rs['result'] = $list;
        echo CJSON::encode($rs);
    }
    public function actionGetTime() {
        $l = new AnalysisLogic();
        $filter = array('list'=>$_POST['list']);

        $rs = $l->time($filter);

        echo CJSON::encode($rs);
    }
    public function filters() {
        return array(
                'accessControl', // perform access control for CRUD operations
        );
    }
    public function accessRules() {
        return array(
                array('deny',
                        'users'=>array('?'),
                ),
        );
    }
    
    public function actionPrintBasisOfRecord() {
   		// get table content
        $l = new AnalysisLogic();
        $filter = array('list'=>$_POST['list']);
        $rs = array();

        $spList = $l->basisOfRecord($filter);
        $list = array();
        $total = $spList['total'];
        $total = $total[0]['count'];
        foreach($spList['list'] as $n=>$ar) {
        	if ($ar['basisofrecord']) {
	            $list[] = array(
	            	"basisofrecord" => $ar['basisofrecord'],
	                "count" => $ar['count'],
	                "perc" => round(100*$ar['count']/$total, 2)."%"
	            );
           	} 
        }
        $rs['result'] = $list;
        
        // get chart image
        $imageData = $_POST['chart'];
        $filteredData = substr($imageData, strpos($imageData, ",")+1);
        $rs['chart'] = base64_decode($filteredData);

        // print        
        $print = new AnalysisPrint();
		$pathToPdf = $print->printAnalysis($rs, 'basisofrecord', $_POST['colors']);
		echo CJSON::encode($pathToPdf);
    }
    
    public function actionPrintInstitutionCode() {
   		// get table content
        $l = new AnalysisLogic();
        $filter = array('list'=>$_POST['list']);
        $rs = array();

        $spList = $l->institutioncode($filter);
        $list = array();
        $total = $spList['total'];
        $total = $total[0]['count'];
        foreach($spList['list'] as $n=>$ar) {
        	if ($ar['institutioncode']) {
	            $list[] = array(
	            	"institutioncode" => $ar['institutioncode'],
	                "count" => $ar['count'],
	                "perc" => round(100*$ar['count']/$total, 2)."%"
	            );
           	} 
        }
        $rs['result'] = $list;
        
        // get chart image
        $imageData = $_POST['chart'];
        $filteredData = substr($imageData, strpos($imageData, ",")+1);
        $rs['chart'] = base64_decode($filteredData);

        // print        
        $print = new AnalysisPrint();
		$pathToPdf = $print->printAnalysis($rs, 'institutioncode', $_POST['colors']);
		echo CJSON::encode($pathToPdf);
    }
    
    public function actionPrintCollectionCode() {
   		// get table content
        $l = new AnalysisLogic();
        $filter = array('list'=>$_POST['list']);
        $rs = array();

        $spList = $l->collectionCode($filter);
        $list = array();
        $total = $spList['total'];
        $total = $total[0]['count'];
        foreach($spList['list'] as $n=>$ar) {
        	if ($ar['collectioncode']) {
	            $list[] = array(
	            	"collectioncode" => $ar['collectioncode'],
	                "count" => $ar['count'],
	                "perc" => round(100*$ar['count']/$total, 2)."%"
	            );
           	} 
        }
        $rs['result'] = $list;
        
        // get chart image
        $imageData = $_POST['chart'];
        $filteredData = substr($imageData, strpos($imageData, ",")+1);
        $rs['chart'] = base64_decode($filteredData);
        
        // print        
        $print = new AnalysisPrint();
		$pathToPdf = $print->printAnalysis($rs, 'collectioncode', $_POST['colors']);
		echo CJSON::encode($pathToPdf);
    }
    
    public function actionGetDataQualityInfo() {
	    $l = new AnalysisLogic();
	    $filter = array('list'=>$_POST['list']);
	    
	    $result = $l->getDataQualityInfo($filter);
	    $rs['total'] = $result['total'][0]['count'];
	    $rs['referenced'] = $result['referenced'][0]['count'];
	    $rs['colvalid'] = $result['colvalid'][0]['count'];
	    $rs['eventdate'] = $result['eventdate'][0]['count'];
	    $rs['geouncertainty'] = $result['geouncertainty'][0]['count'];
	    
	    $rs['sql'] = $result['sql'];
	    $rs['filter'] = $filter;
	    
	    echo CJSON::encode($rs);
    }
    
    public function actionPrintDataQuality() {
    	$rs = array();
    
        // get chart image
        $imageData = $_POST['chartDQ1'];
        $filteredData = substr($imageData, strpos($imageData, ",")+1);
        $rs['chartDQ1'] = base64_decode($filteredData);

        $imageData = $_POST['chartDQ2'];
        $filteredData = substr($imageData, strpos($imageData, ",")+1);
        $rs['chartDQ2'] = base64_decode($filteredData);
        
        $imageData = $_POST['chartDQ3'];
        $filteredData = substr($imageData, strpos($imageData, ",")+1);
        $rs['chartDQ3'] = base64_decode($filteredData);
        
        $imageData = $_POST['chartDQ4'];
        $filteredData = substr($imageData, strpos($imageData, ",")+1);
        $rs['chartDQ4'] = base64_decode($filteredData);
        
        $imageData = $_POST['chartDQ5'];
        $filteredData = substr($imageData, strpos($imageData, ",")+1);
        $rs['chartDQ5'] = base64_decode($filteredData);

        // print        
        $print = new AnalysisPrint();
		$pathToPdf = $print->printDataQuality($rs);
		echo CJSON::encode($pathToPdf);
    }
    
    public function actionGetTaxonRankInfo() {
	    $l = new AnalysisLogic();
	    $filter = array('list'=>$_POST['list']);
	    
	    $result = $l->getTaxonRankInfo($filter);
	    
	    $rs['total'] = $result['total'][0]['count'];
	    $rs['scientificname'] = $result['scientificname'][0]['count'];
	    $rs['genus'] = $result['genus'][0]['count'];
	    $rs['family'] = $result['family'][0]['count'];
	    $rs['order'] = $result['order'][0]['count'];
	    $rs['class'] = $result['class'][0]['count'];
	    $rs['phylum'] = $result['phylum'][0]['count'];
	    $rs['kingdom'] = $result['kingdom'][0]['count'];
	    $rs['others'] = $result['others'][0]['count'];
	    
	    echo CJSON::encode($rs);
    }
}

    /*
    public function actionGetTaxon() {
        $l = new AnalysisLogic();
        $filter = array('list'=>$_POST['list']);
        $idkingdom = (int)($_POST['idkingdom']=="null"?null:$_POST['idkingdom']);
        $idphylum = (int)($_POST['idphylum']=="null"?null:$_POST['idphylum']);
        $idclass = (int)($_POST['idclass']=="null"?null:$_POST['idclass']);
        $idorder = (int)($_POST['idorder']=="null"?null:$_POST['idorder']);
        $idfamily = (int)($_POST['idfamily']=="null"?null:$_POST['idfamily']);
        $idgenus = (int)($_POST['idgenus']=="null"?null:$_POST['idgenus']);
        $idsubgenus = (int)($_POST['idsubgenus']=="null"?null:$_POST['idsubgenus']);
        $idspecificepithet = (int)($_POST['idspecificepithet']=="null"?null:$_POST['idspecificepithet']);
        $idinfraspecificepithet = (int)($_POST['idinfraspecificepithet']=="null"?null:$_POST['idinfraspecificepithet']);
        $rs = array();

        $spList = $l->taxon($filter, $idkingdom, $idphylum, $idclass, $idorder, $idfamily, $idgenus, $idsubgenus, $idspecificepithet, $idinfraspecificepithet, $idscientificname = null);
        $list = array();
        $total = $spList['total'];
        $total = $total[0]['count'];
        foreach($spList['list'] as $n=>$ar) {
                if ($ar['kingdom'] && $ar['phylum'] && $ar['class'] && $ar['order'] && $ar['family'] && $ar['genus'] && $ar['subgenus'] && $ar['specificepithet'] && $ar['infraspecificepithet'] && $ar['scientificname']) {     
	            $list[] = array(
                        "idkingdom" => $ar['idkingdom'],
	            	"kingdom" => $ar['kingdom'],
                        "idphylum" => $ar['idphylum'],
	            	"phylum" => $ar['phylum'],
                        "idclass" => $ar['idclass'],
	            	"class" => $ar['class'],
                        "idorder" => $ar['idorder'],
	            	"order" => $ar['order'],
                        "idfamily" => $ar['idfamily'],
	            	"family" => $ar['family'],
                        "idgenus" => $ar['idgenus'],
	            	"genus" => $ar['genus'],
                        "idsubgenus" => $ar['idsubgenus'],
	            	"subgenus" => $ar['subgenus'],
                        "idspecificepithet" => $ar['idspecificepithet'],
	            	"specificepithet" => $ar['specificepithet'],
                        "idinfraspecificepithet" => $ar['idinfraspecificepithet'],
	            	"infraspecificepithet" => $ar['infraspecificepithet'],
                        "idscientificname" => $ar['idscientificname'],
	            	"scientificname" => $ar['scientificname'],
	                "count" => $ar['count'],
	                "perc" => round(100*$ar['count']/$total, 2)."%"
	            );
           	}
                else if ($ar['kingdom'] && $ar['phylum'] && $ar['class'] && $ar['order'] && $ar['family'] && $ar['genus'] && $ar['subgenus'] && $ar['specificepithet'] && $ar['infraspecificepithet'] &&!$idinfraspecificepithet) {     
	            $list[] = array(
                        "idkingdom" => $ar['idkingdom'],
	            	"kingdom" => $ar['kingdom'],
                        "idphylum" => $ar['idphylum'],
	            	"phylum" => $ar['phylum'],
                        "idclass" => $ar['idclass'],
	            	"class" => $ar['class'],
                        "idorder" => $ar['idorder'],
	            	"order" => $ar['order'],
                        "idfamily" => $ar['idfamily'],
	            	"family" => $ar['family'],
                        "idgenus" => $ar['idgenus'],
	            	"genus" => $ar['genus'],
                        "idsubgenus" => $ar['idsubgenus'],
	            	"subgenus" => $ar['subgenus'],
                        "idspecificepithet" => $ar['idspecificepithet'],
	            	"specificepithet" => $ar['specificepithet'],
                        "idinfraspecificepithet" => $ar['idinfraspecificepithet'],
	            	"infraspecificepithet" => $ar['infraspecificepithet'],
	                "count" => $ar['count'],
	                "perc" => round(100*$ar['count']/$total, 2)."%"
	            );
           	}
                else if ($ar['kingdom'] && $ar['phylum'] && $ar['class'] && $ar['order'] && $ar['family'] && $ar['genus'] && $ar['subgenus'] && $ar['specificepithet'] &&!$idspecificepithet) {     
	            $list[] = array(
                        "idkingdom" => $ar['idkingdom'],
	            	"kingdom" => $ar['kingdom'],
                        "idphylum" => $ar['idphylum'],
	            	"phylum" => $ar['phylum'],
                        "idclass" => $ar['idclass'],
	            	"class" => $ar['class'],
                        "idorder" => $ar['idorder'],
	            	"order" => $ar['order'],
                        "idfamily" => $ar['idfamily'],
	            	"family" => $ar['family'],
                        "idgenus" => $ar['idgenus'],
	            	"genus" => $ar['genus'],
                        "idsubgenus" => $ar['idsubgenus'],
	            	"subgenus" => $ar['subgenus'],
                        "idspecificepithet" => $ar['idspecificepithet'],
	            	"specificepithet" => $ar['specificepithet'],
	                "count" => $ar['count'],
	                "perc" => round(100*$ar['count']/$total, 2)."%"
	            );
           	}
                else if ($ar['kingdom'] && $ar['phylum'] && $ar['class'] && $ar['order'] && $ar['family'] && $ar['genus'] && $ar['subgenus'] &&!$idsubgenus) {     
	            $list[] = array(
                        "idkingdom" => $ar['idkingdom'],
	            	"kingdom" => $ar['kingdom'],
                        "idphylum" => $ar['idphylum'],
	            	"phylum" => $ar['phylum'],
                        "idclass" => $ar['idclass'],
	            	"class" => $ar['class'],
                        "idorder" => $ar['idorder'],
	            	"order" => $ar['order'],
                        "idfamily" => $ar['idfamily'],
	            	"family" => $ar['family'],
                        "idgenus" => $ar['idgenus'],
	            	"genus" => $ar['genus'],
                        "idsubgenus" => $ar['idsubgenus'],
	            	"subgenus" => $ar['subgenus'],
	                "count" => $ar['count'],
	                "perc" => round(100*$ar['count']/$total, 2)."%"
	            );
           	}
                else if ($ar['kingdom'] && $ar['phylum'] && $ar['class'] && $ar['order'] && $ar['family'] && $ar['genus'] &&!$idgenus) {     
	            $list[] = array(
                        "idkingdom" => $ar['idkingdom'],
	            	"kingdom" => $ar['kingdom'],
                        "idphylum" => $ar['idphylum'],
	            	"phylum" => $ar['phylum'],
                        "idclass" => $ar['idclass'],
	            	"class" => $ar['class'],
                        "idorder" => $ar['idorder'],
	            	"order" => $ar['order'],
                        "idfamily" => $ar['idfamily'],
	            	"family" => $ar['family'],
                        "idgenus" => $ar['idgenus'],
	            	"genus" => $ar['genus'],
	                "count" => $ar['count'],
	                "perc" => round(100*$ar['count']/$total, 2)."%"
	            );
           	}
                else if ($ar['kingdom'] && $ar['phylum'] && $ar['class'] && $ar['order'] && $ar['family'] && !$idfamily) {     
	            $list[] = array(
                        "idkingdom" => $ar['idkingdom'],
	            	"kingdom" => $ar['kingdom'],
                        "idphylum" => $ar['idphylum'],
	            	"phylum" => $ar['phylum'],
                        "idclass" => $ar['idclass'],
	            	"class" => $ar['class'],
                        "idorder" => $ar['idorder'],
	            	"order" => $ar['order'],
                        "idfamily" => $ar['idfamily'],
	            	"family" => $ar['family'],
	                "count" => $ar['count'],
	                "perc" => round(100*$ar['count']/$total, 2)."%"
	            );
           	}
                else if ($ar['kingdom'] && $ar['phylum'] && $ar['class'] && $ar['order'] && !$idorder) {     
	            $list[] = array(
                        "idkingdom" => $ar['idkingdom'],
	            	"kingdom" => $ar['kingdom'],
                        "idphylum" => $ar['idphylum'],
	            	"phylum" => $ar['phylum'],
                        "idclass" => $ar['idclass'],
	            	"class" => $ar['class'],
                        "idorder" => $ar['idorder'],
	            	"order" => $ar['order'],
	                "count" => $ar['count'],
	                "perc" => round(100*$ar['count']/$total, 2)."%"
	            );
           	}
                else if ($ar['kingdom'] && $ar['phylum'] && $ar['class'] && !$idclass) {     
	            $list[] = array(
                        "idkingdom" => $ar['idkingdom'],
	            	"kingdom" => $ar['kingdom'],
                        "idphylum" => $ar['idphylum'],
	            	"phylum" => $ar['phylum'],
                        "idclass" => $ar['idclass'],
	            	"class" => $ar['class'],
	                "count" => $ar['count'],
	                "perc" => round(100*$ar['count']/$total, 2)."%"
	            );
           	}
                else if ($ar['kingdom'] && $ar['phylum'] && !$idphylum) {     
	            $list[] = array(
                        "idkingdom" => $ar['idkingdom'],
	            	"kingdom" => $ar['kingdom'],
                        "idphylum" => $ar['idphylum'],
	            	"phylum" => $ar['phylum'],
	                "count" => $ar['count'],
	                "perc" => round(100*$ar['count']/$total, 2)."%"
	            );
           	}
                else if ($ar['kingdom'] && !$idkingdom) {
                    $list[] = array(
                        "idkingdom" => $ar['idkingdom'],
	            	"kingdom" => $ar['kingdom'],
	                "count" => $ar['count'],
	                "perc" => round(100*$ar['count']/$total, 2)."%"
	            );
                }
                else {
                    
                }
        }
        $rs['result'] = $list;
        echo CJSON::encode($rs);
    }*/
        /*public function actionGetTaxon() {
        $l = new AnalysisLogic();
        $filter = array('list'=>$_POST['list']);
        $rs = array();

        $taxon = $l->taxon($filter);
        $list = array();*/
        //$total = $spList['total'];
        //$total = $total[0]['count'];
        /*foreach($taxon as $ar) {
            $list[] = array(
            	"id" => "idkingdom_".$ar['idkingdom'],
            	"name" => $ar['kingdom'],
            	"children" => $ar['children']
            );
        }*/
        //$rs['result'] = $list;
        //echo CJSON::encode($taxon);
   // }
