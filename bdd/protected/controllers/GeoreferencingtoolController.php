<?php
include_once 'logic/CountryLogic.php';
include_once 'logic/StateProvinceLogic.php';
include_once 'logic/MunicipalityLogic.php';
include_once 'logic/WaterBodyLogic.php';
include_once 'logic/SpecimenLogic.php';
class GeoreferencingtoolController extends CController {
    public $defaultAction='index';
    public function actionIndex(){
        $this->renderPartial('iFrame', array('model'=>$_model));
    }
    public function actionGoToMaintain() {    
    	if($_GET['id']!=null && SpecimenAR::model()->findByPk($_GET['id'])!=null) {
            $spm = SpecimenAR::model()->findByPk($_GET['id']);
        }else {
            $spm = new SpecimenAR();
        }
        $logic = new SpecimenLogic();
        $spm = $logic->fillDependency($spm);                
       $this->render('maintain', array(
            'localityElement'=>$spm->localityelement,
            'geospatialElement'=>$spm->geospatialelement
            ));
    }
    public function actionMinimapIFrame(){
        $this->renderPartial('minimapIFrame', array('uncertainty'=>$_GET['uncertainty'],'lat'=>$_GET['lat'],'lng'=>$_GET['lng']));
    }
    public function actionRender() {
        $_model = new GeoreferencingToolFM();

        $this->renderPartial('index', array('model'=>$_model,'uncertainty'=>$_GET['uncertainty'],'lat'=>$_GET['lat'],'lng'=>$_GET['lng']));
    }
    public function actionGetBiogeomancer(){    	
    	$locality = str_replace(" ", "+", trim($_GET['locality']));
    	$state = str_replace(" ", "+", trim($_GET['state']));
    	$country = str_replace(" ", "+", trim($_GET['country']));
    	$xml = file_get_contents(
    		utf8_decode("http://bg.berkeley.edu:8080/ws/single?locality=".$locality."&sp=".$state."&country=".$country."&header=true"));
    	$callback = new xml2array(utf8_decode($xml));
		$biogeomancer = $callback->getResult();
		$rs = array();
		if($biogeomancer['biogeomancer']['georeference']!=null){
			if(array_key_exists('dwc:decimalLatitude',$biogeomancer['biogeomancer']['georeference'])){		    
				$aux['decimallatitude'] = $biogeomancer['biogeomancer']['georeference']['dwc:decimalLatitude']['#text'];
				$aux['decimallongitude'] = $biogeomancer['biogeomancer']['georeference']['dwc:decimalLongitude']['#text'];
				$aux['geodeticdatum'] = $biogeomancer['biogeomancer']['georeference']['dwc:geodeticDatum']['#text'];
				$aux['uncertainty'] = $biogeomancer['biogeomancer']['georeference']['dwc:coordinateUncertaintyInMeters']['#text'];
			    $rs['georeference'][]=$aux;
			}else{
				foreach($biogeomancer['biogeomancer']['georeference'] as $item) {
					$aux['decimallatitude'] = $item['dwc:decimalLatitude']['#text'];
					$aux['decimallongitude'] = $item['dwc:decimalLongitude']['#text'];
					$aux['geodeticdatum'] = $item['dwc:geodeticDatum']['#text'];
					$aux['uncertainty'] = $item['dwc:coordinateUncertaintyInMeters']['#text'];
				    $rs['georeference'][]=$aux;
	            }
			}
			$rs['sucess']=true;
		}else $rs['sucess']=false; 				

    	echo CJSON::encode($rs);
    }
    public function actionGetGeolocate(){    	
    	$locality = str_replace(" ", "+", trim($_GET['locality']));
    	$state = str_replace(" ", "+", trim($_GET['state']));
    	$country = str_replace(" ", "+", trim($_GET['country']));
    	$json = file_get_contents("http://www.museum.tulane.edu/webservices/geolocatesvcv2/glcwrap.aspx?Country=".$country."&Locality=".$locality."&state=".$state."&ftm=json");
    	echo $json;
    	
    }
    public function actionGeocodingGeonames(){    	
    	$lat = str_replace(" ", "+", trim($_GET['lat']));
    	$lng = str_replace(" ", "+", trim($_GET['lng']));
    	$rs = utf8_decode(file_get_contents(
    		utf8_decode("http://api.geonames.org/findNearbyPlaceNameJSON?lat=".$lat."&lng=".$lng."&username=demo")));
		$biogeomancer = $aux->getResult();

    	echo CJSON::encode($biogeomancer);
    }
    
    public function actionMinimap() {
        $this->renderPartial('minimap', array('uncertainty'=>$_GET['uncertainty'],'lat'=>$_GET['lat'],'lng'=>$_GET['lng']));
    }
    public function actionApresentation() {        
        $this->render('apresentation');
    }
    public function actionSave() {
        $c = new CountryLogic();
        $s = new StateProvinceLogic();
        $m = new MunicipalityLogic();
        $w = new WaterBodyLogic();       
        
        $rs['country'] = $c->getJSON($_POST['country'], null);
        $rs['stateprovince'] = $s->getJSON($_POST['stateprovince'], null);
        $rs['municipality'] = $m->getJSON($_POST['municipality'], null);
        $rs['waterbody'] = $w->getJSON($_POST['waterbody'], null);
        
        if (!$rs['country']['success']) {
        	$ar = new CountryAR();
        	
        	$ar->country = $_POST['country'];
			$ar->googlevalidation = $_POST['country_g'];
        	$ar->geonamesvalidation = $_POST['country_n'];
        	$ar->biogeomancervalidation = $_POST['country_b'];
        	
        	$rs['country'] = $c->saveBGT($ar);
        }
        else {
        	$ar = $rs['country']['ar'];
        	
        	$ar->googlevalidation = $_POST['country_g'];
        	$ar->geonamesvalidation = $_POST['country_n'];
        	$ar->biogeomancervalidation = $_POST['country_b'];
        	
        	$rs['country'] = $c->saveBGT($ar);
        }
        
        if (!$rs['stateprovince']['success']) {
        	$ar = new StateProvinceAR();
        	
        	$ar->stateprovince = $_POST['stateprovince'];
			$ar->googlevalidation = $_POST['stateprovince_g'];
        	$ar->geonamesvalidation = $_POST['stateprovince_n'];
        	$ar->biogeomancervalidation = $_POST['stateprovince_b'];
        	
        	$rs['stateprovince'] = $s->saveBGT($ar);
        }
        else {
        	$ar = $rs['stateprovince']['ar'];
        	
        	$ar->googlevalidation = $_POST['stateprovince_g'];
        	$ar->geonamesvalidation = $_POST['stateprovince_n'];
        	$ar->biogeomancervalidation = $_POST['stateprovince_b'];
        	
        	$rs['stateprovince'] = $s->saveBGT($ar);
        }
        
        if (!$rs['municipality']['success']) {
        	$ar = new MunicipalityAR();
        	
        	$ar->municipality = $_POST['municipality'];
			$ar->googlevalidation = $_POST['municipality_g'];
        	$ar->geonamesvalidation = $_POST['municipality_n'];
        	$ar->biogeomancervalidation = $_POST['municipality_b'];
        	
        	$rs['municipality'] = $m->saveBGT($ar);
        }
        else {
        	$ar = $rs['municipality']['ar'];
        	
			$ar->googlevalidation = $_POST['municipality_g'];
        	$ar->geonamesvalidation = $_POST['municipality_n'];
        	$ar->biogeomancervalidation = $_POST['municipality_b'];
        	
        	$rs['municipality'] = $m->saveBGT($ar);
        }
        
        if (!$rs['waterbody']['success']) {
        	$ar = new WaterBodyAR();
        	
        	$ar->waterbody = $_POST['waterbody'];
        	$ar->geonamesvalidation = $_POST['waterbody_n'];
        	
        	$rs['waterbody'] = $w->saveBGT($ar);
        }
        else {
        	$ar = $rs['waterbody']['ar'];
        	
        	$ar->geonamesvalidation = $_POST['waterbody_n'];
        	
        	$rs['waterbody'] = $w->saveBGT($ar);
        }
        
        echo CJSON::encode($rs);
    }
    public function actionFromSpecimen() {
        $_model = new georeferencingtool;
        $_model->setAttributes($_POST['georeferencingtool']);
        $_model->locality = localities::model();
        $_recordlevelelements = recordlevelelements::model();
        $_recordlevelelements->setAttributes($_POST['recordlevelelements']);
        if ($_model->latitude==null) {
            var_dump($_model->latitude);
            $this->renderPartial('index', array('model'=>$_model, 'recordlevelelements'=>$_recordlevelelements));
        }
        else {
            $this->redirect('index.php?r=recordlevelelements/create');
        }
    }
    public function actionToSpecimen() {
        $this->renderPartial('index.php?r=recordlevelelements/create', array('recordlevelelements'=>$_recordlevelelements));
    }
    public function actionGetGeoDataWS(){
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        $request_url = "http://maps.google.com/maps/api/geocode/json?latlng=".$latitude.",".$longitude."&sensor=false";
        $result;
        $contryName;
        $stateName;
        $municipalityName;
        if($xml->status=="OK") {
            foreach($xml->result[0]->address_component as $node) {
                if($node->type=="country") {
                    $contryName=$node->long_name;
                }
                if($node->type=="administrative_area_level_1") {
                    $stateName=$node->long_name;
                }
                if($node->type=="locality") {
                    $municipalityName = $node->long_name;
                }
            }
            $result = $contryName."|".$stateName."|".$municipalityName;
        }else
            $result="|||";

        echo $result;
    }
    public function actionGetListLocality() {
        $name = $_GET['q'];
        // this was set with the "max" attribute of the CAutoComplete widget
        $limit = min($_GET['limit'], 20);
        $criteria = new CDbCriteria;
        $criteria->condition = "locality LIKE :sterm OR difference(locality, :pureterm) > 3";
        $criteria->params = array(":sterm"=>"%$name%",":pureterm"=>"$name");
        $criteria->limit = $limit;
        $criteria->order = "locality";
        //$resp = localities::model()->findAll($criteria);
        $resp = localities::model()->findAll("locality LIKE '%".$name."%' OR difference(locality, '".$name."') > 3");
        $returnVal = '';
        foreach($resp as $loc) {
            $returnVal .= $loc->getAttribute('idlocality').'|'
                    .$loc->getAttribute('locality')."\n";
        }
        echo $returnVal;
    }
    public function filters() {
        return array(
                'accessControl', // perform access control for CRUD operations
        );
    }
    /*public function accessRules() {
        return array(
                array('allow',
                        'actions'=>array('@'),
                        'users'=>array('@'),
                )
        );
    }*/
    public function accessRules() {
        return array(
                array('deny',
                        'users'=>array('?'),
                ),
        );
    }
}


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