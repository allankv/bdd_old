<?php
include_once 'logic/KingdomLogic.php';
include_once 'logic/PhylumLogic.php';
include_once 'logic/ClassLogic.php';
include_once 'logic/OrderLogic.php';
include_once 'logic/FamilyLogic.php';
include_once 'logic/GenusLogic.php';
include_once 'logic/SubgenusLogic.php';
include_once 'logic/SpecificEpithetLogic.php';
include_once 'logic/InfraspecificEpithetLogic.php';
include_once 'logic/ScientificNameLogic.php';
include_once 'logic/TaxonRankLogic.php';
class xml2array {
 
	function xml2array($xml) {
		if (is_string($xml)) {
			$this->dom = new DOMDocument;
			$this->dom->loadXml($xml);
		}
 
		return FALSE;
	}
 
	function _process($node) { 
		$occurance = array();
 
		if($node->hasChildNodes()){		
			foreach($node->childNodes as $child) {
				$occurance[$child->nodeName]++;
			}
		}
 
		if($node->nodeType == XML_TEXT_NODE) { 
			$result = html_entity_decode(htmlentities($node->nodeValue, ENT_COMPAT, 'UTF-8'), 
                                     ENT_COMPAT,'ISO-8859-15');
		} 
		else {
			if($node->hasChildNodes()){
				$children = $node->childNodes;
 
				for($i=0; $i<$children->length; $i++) {
					$child = $children->item($i);
 
					if($child->nodeName != '#text') {
						if($occurance[$child->nodeName] > 1) {
							$result[$child->nodeName][] = $this->_process($child);
						}
						else {
							$result[$child->nodeName] = $this->_process($child);
						}
					}
					else if ($child->nodeName == '#text') {
						$text = $this->_process($child);
 
						if (trim($text) != '') {
							$result[$child->nodeName] = $this->_process($child);
						}
					}
				}
			} 
 
			if($node->hasAttributes()) { 
				$attributes = $node->attributes;
 
				if(!is_null($attributes)) {
					foreach ($attributes as $key => $attr) {
						$result["@".$attr->name] = $attr->value;
					}
				}
			}
		}
 
		return $result;
	}
 
	function getResult() {
		return $this->_process($this->dom);
	}
}

/* Todo: criar um arquivo para o XML to JSON */

include 'logic/TaxonomicToolLogic.php'; 
class TaxonomictoolController extends CController {
    const PAGE_SIZE=10;
    public $defaultAction='goToTaxonomicTool';
    /*public function actionGoToList() {
        $this->render('list', array(
            'related'=>'false',
            ));
    }
    public function actionGoToTaxonomicTool() {        
       $this->renderPartial('index', array(
            //'related'=> 'true',
            ));
    }
    public function actionGoToMaintain() {        
       $this->render('maintain', array( 
            //'related'=> 'true',
            ));
    }*/
    public function actionGetTaxonByID() {
        $logic = new TaxonomicToolLogic();

        echo CJSON::encode($logic->getTaxonByID($_POST['id']));
    }
    public function actionSearch() {
        $logic = new TaxonomicToolLogic();
        $rs = array();
        if($_GET['source']=='local' && $_GET['type']=='fuzzy'){
			$rs = $logic->searchLocalFuzzy($_GET['term']);
        }else if($_GET['source']=='col' && $_GET['type']=='equal'){
        	$rs = $logic->searchColEqual($_GET['term']);
        }else if($_GET['source']=='col' && $_GET['type']=='ilike'){
        	$rs = $logic->searchColILike($_GET['term']);
        }else if($_GET['source']=='col' && $_GET['type']=='fuzzy'){
        	$rs = $logic->searchColFuzzy($_GET['term']);
        }		
        echo CJSON::encode($rs);
    }
    public function actionSearchLocal() {
        $logic = new TaxonomicToolLogic();
        $rs = array();        
		$rs = $logic->searchLocal($_GET['term'],3, false);
        
        echo CJSON::encode($rs);
    }
    public function actionHierarchyValidation() {
        $logic = new TaxonomicToolLogic();       
        $rs = array();        
		$rs = $logic->hierarchyValidation($_POST);  		
  		
        echo CJSON::encode($rs);
    }
    public function actionValidate() {
        $logic = new TaxonomicToolLogic();
        $rs = array();        
		$rs = $logic->validate($_POST['term'],$_POST['rank']);
        
        echo CJSON::encode($rs);
    }
    public function actionLocalSuggestions(){
        $logic = new TaxonomicToolLogic();
        $rs = array();        
		$rs = $logic->searchLocal($_POST['term'],4, true);
        
        echo CJSON::encode($rs);
    }
    public function actionColSuggestions(){
        $logic = new TaxonomicToolLogic();
        $rs = array();        
		$rs = $logic->searchCol($_POST['term']);
        
        echo CJSON::encode($rs);
    }
    public function actionSearchLocalHierarchy(){
        $logic = new TaxonomicToolLogic();        
		$rs = $logic->searchLocalHierarchy($_POST['term'],$_POST['rank'],$_POST['source']);
        if($rs){
        	$rs['sucess']=true;
        }else{
        	$rs['sucess']=false;
        }
        echo CJSON::encode($rs);
    }
    public function actionSearchColHierarchy(){
        $logic = new TaxonomicToolLogic();        
		$rs = $logic->searchColHierarchy($_POST['term'],$_POST['rank'],$_POST['source']);
        
        echo CJSON::encode($rs);
    }    
    public function actionGetEol(){
    	$rs = file_get_contents('http://www.eol.org/api/pages/1.0/1045608?common_names=1&details=1&images=75&subjects=all&text=75&videos=75&format=json&version=1.0');
    	//$aux = new xml2array(utf8_decode($rs));

    	echo $rs;
    }
    public function actionSave() {
	    $k = new KingdomLogic();
	    $p = new PhylumLogic();
	    $c = new ClassLogic();
	    $o = new OrderLogic();
	    $f = new FamilyLogic();
	    $g = new GenusLogic();
	    $sg = new SubgenusLogic();
	    $se = new SpecificEpithetLogic();
	    $ise = new InfraspecificEpithetLogic();
	    $sn = new ScientificNameLogic();
	    $tr = new TaxonRankLogic();

	    $rs['kingdom'] = $k->getJSON($_POST['kingdom'], null);
	    $rs['phylum'] = $p->getJSON($_POST['phylum'], null);
	    $rs['class'] = $c->getJSON($_POST['class'], null);
	    $rs['order'] = $o->getJSON($_POST['order'], null);
	    $rs['family'] = $f->getJSON($_POST['family'], null);
	    $rs['genus'] = $g->getJSON($_POST['genus'], null);
	    $rs['subgenus'] = $sg->getJSON($_POST['subgenus'], null);
	    $rs['specificepithet'] = $se->getJSON($_POST['specificepithet'], null);
	    $rs['infraspecificepithet'] = $ise->getJSON($_POST['infraspecificepithet'], null);
	    $rs['scientificname'] = $sn->getJSON($_POST['scientificname'], null);
	    $rs['taxonrank'] = $tr->getJSON($_POST['taxonrank'], null);

	    if (!$rs['kingdom']['success']) {	    	
	    	$rs['kingdom'] = $k->save($_POST['kingdom'], $_POST['kingdom_colvalidation']);
	    }
	    
	    if (!$rs['phylum']['success']) {	    	
	    	$rs['phylum'] = $p->save($_POST['phylum'], $_POST['phylum_colvalidation']);
	    }
	    
	    if (!$rs['class']['success']) {	    	
	    	$rs['class'] = $c->save($_POST['class'], $_POST['class_colvalidation']);
	    }
	    
	    if (!$rs['order']['success']) {	    	
	    	$rs['order'] = $o->save($_POST['order'], $_POST['order_colvalidation']);
	    }
	    
	    if (!$rs['family']['success']) {
	    	$rs['family'] = $f->save($_POST['family'], $_POST['family_colvalidation']);
	    }
	    
	    if (!$rs['genus']['success']) {	    	
	    	$rs['genus'] = $g->save($_POST['genus'], $_POST['genus_colvalidation']);
	    }

	    if (!$rs['subgenus']['success']) {	    	
	    	$rs['subgenus'] = $sg->save($_POST['subgenus'], $_POST['subgenus_colvalidation']);
	    }
	    
	    if (!$rs['specificepithet']['success']) {	    	
	    	$rs['specificepithet'] = $se->save($_POST['specificepithet'], $_POST['specificepithet_colvalidation']);
	    }
	    
	    if (!$rs['infraspecificepithet']['success']) {	    	
	    	$rs['infraspecificepithet'] = $ise->save($_POST['infraspecificepithet'], $_POST['infraspecificepithet_colvalidation']);
	    }
	    
	    if (!$rs['scientificname']['success']) {	    	
	    	$rs['scientificname'] = $sn->save($_POST['scientificname'], $_POST['scientificname_colvalidation']);
	    }
	    
	    if (!$rs['taxonrank']['success']) {	    	
	    	$rs['taxonrank'] = $tr->save($_POST['taxonrank']);
	    }
	    
	    echo CJSON::encode($rs);
	}
    public function accessRules() {
        return array(
                array('deny',
                        'users'=>array('?'),
                ),
        );
    }
}
