<?php
include 'CategoryReferenceLogic.php';
include 'SubtypeReferenceLogic.php';
include_once 'KeywordLogic.php';
include_once 'AfiliationLogic.php';
include_once 'BiomeLogic.php';
include_once 'PlantSpeciesLogic.php';
include_once 'PlantFamilyLogic.php';
include_once 'PlantCommonNameLogic.php';
include_once 'PollinatorSpeciesLogic.php';
include_once 'PollinatorFamilyLogic.php';
include_once 'PollinatorCommonNameLogic.php';
include_once 'CreatorLogic.php';
include_once 'SpecimenLogic.php';
include_once 'SpeciesLogic.php';

class ReferenceLogic {
	
	
	public function getXml () {   
    	$doc = new DOMDocument(); 
		$root = $doc->createElementNS('http://www.w3.org/2001/XMLSchema-instance', 'dc:DCRecordSet');
		$root = $doc->appendChild($root);
		$root->setAttributeNS('http://www.w3.org/2000/xmlns/' ,'xmlns:dc', 'http://200.144.182.25/schemas/dublincore/simpledc20021212.xsd');
//		$root->setAttributeNS('http://www.w3.org/2001/XMLSchema-instance', 'schemaLocation', 'http://dublincore.org/schemas/xmls/qdc/dc.xsd');
		
		$rs = WebbeeController::executaSQL('select * from reference_dc where idgroup = '.Yii::app()->user->getGroupId());
		
		foreach($rs as $n=>$ar) {
                    
			$newRec = $doc->createElement("dc:DCRecord"); 
			
			$title = $doc->createElement( "dc:title" ); 
			$title->appendChild($doc->createTextNode($ar['title'])); 		
			$newRec->appendChild($title); 
					
			$creator = $doc->createElement( "dc:creator" ); 
			$creator->appendChild($doc->createTextNode($ar['creator'])); 		
			$newRec->appendChild($creator); 
			
			$subject = $doc->createElement( "dc:subject" ); 
			$subject->appendChild($doc->createTextNode($ar['subject'])); 		
			$newRec->appendChild($subject); 
				
			$description = $doc->createElement( "dc:description" ); 
			$description->appendChild($doc->createTextNode($ar['abstract'].' '.$ar['bibliographiccitation'])); 		
			$newRec->appendChild($description);
			
			$publisher = $doc->createElement( "dc:publisher" ); 
			$publisher->appendChild($doc->createTextNode($ar['publisher'])); 		
			$newRec->appendChild($publisher); 
			
			$identifier = $doc->createElement( "dc:identifier" ); 
			$identifier->appendChild($doc->createTextNode($ar['isbnissn'])); 		
			$newRec->appendChild($identifier); 
			
			$contributor = $doc->createElement( "dc:contributor" ); 
			$contributor->appendChild($doc->createTextNode($ar['afiliation'])); 		
			$newRec->appendChild($contributor); 
			
			$date = $doc->createElement( "dc:date" ); 
			$date->appendChild($doc->createTextNode($ar['modified'])); 		
			$newRec->appendChild($date); 
			
			$type = $doc->createElement( "dc:type" ); 
			$type->appendChild($doc->createTextNode($ar['subtypereference'])); 		
			$newRec->appendChild($type); 
	
			$format = $doc->createElement( "dc:format" ); 
			$format->appendChild($doc->createTextNode($ar['fileformat'])); 		
			$newRec->appendChild($format);
	
			$source = $doc->createElement( "dc:source" ); 
			$source->appendChild($doc->createTextNode($ar['source'])); 		
			$newRec->appendChild($source); 
	
			$language = $doc->createElement( "dc:language" ); 
			$language->appendChild($doc->createTextNode($ar['language'])); 		
			$newRec->appendChild($language); 
	
			$relation = $doc->createElement( "dc:relation" ); 
			$relation->appendChild($doc->createTextNode('')); 		
			$newRec->appendChild($relation); 
	
			$coverage = $doc->createElement( "dc:coverage" ); 
			$coverage->appendChild($doc->createTextNode('')); 		
			$newRec->appendChild($coverage); 
			
			$rights = $doc->createElement( "dc:rights" ); 
			$rights->appendChild($doc->createTextNode('')); 		
			$newRec->appendChild($rights); 
			
			$root->appendChild($newRec); 
		}				
		$rs = $doc->saveXML(); 
		$file = "tmp/bdd-reference-dc-".time().".xml";
		$doc->save($file);
		
		return $file;
    }
    
    
    
public function subSearchNN($q,$field,$view) {
  		$mainAtt = $field;
  		$nome = $view.'AR';
        $ar = new $nome();
        $q = trim($q);
        $criteria = new CDbCriteria();
        
        $criteria->condition = "$mainAtt ilike '%$q%' OR difference($mainAtt, '$q') > 3";
    
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
       
      
        return $rs;
    }
    
public function subSearch($q,$field) {
  		$mainAtt = $field;
        $ar = ReferenceViewAR::model();
        $q = trim($q);
        $group = Yii::app()->user->getGroupId();
        $criteria = new CDbCriteria();
        if ($field<>'publicationyear'){
        	$criteria->condition = "(idgroup=".$group.") and ($mainAtt ilike '%$q%' OR difference($mainAtt, '$q') > 3)";
        }
        else {
        	
        	$criteria->condition = "$mainAtt = $q";
        }
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
       
        return $rs;
    }
    
    public function search($q) {
    	
    	
    	
    	////TITLE
    	$rs = array();
    	$return = $this->subSearch($q,'title');
    	if (count($return)>0){
    			
    			$rs[] = array("controller" => "title","id" => $q,"label" => $q, "category" => "Title");
    	}
    	
    	////DOI
    	
    	$return = $this->subSearch($q,'doi');
    	if (count($return)>0){
    			
    			$rs[] = array("controller" => "doi","id" => $q,"label" => $q, "category" => "Doi");
    	}
    	
    	////isbnissn
    	
    	$return = $this->subSearch($q,'isbnissn');
    	if (count($return)>0){
    			
    			$rs[] = array("controller" => "isbnissn","id" => $q,"label" => $q, "category" => "ISBN-ISSN");
    	}
    	
    	////language
    	
    	$return = $this->subSearch($q,'language');
    	if (count($return)>0){
    			
    			$rs[] = array("controller" => "language","id" => $q,"label" => $q, "category" => "Language");
    	}
    	
    	///subtype
    	$return = $this->subSearch($q,'subtypereference');
    	if (count($return)>0){
    			
    			$rs[] = array("controller" => "subtypereference","id" => $q,"label" => $q, "category" => "SubType");
    	}
    	///abstract
    	$return = $this->subSearch($q,'abstract');
    	if (count($return)>0){
    			
    			$rs[] = array("controller" => "abstract","id" => $q,"label" => $q, "category" => "Abstract");
    	}
   		 ///publicationyear
   		 if (is_numeric($q)){
	    	$return = $this->subSearch($q,'publicationyear');
	    	
	    	if (count($return)>0){
	    			
	    			$rs[] = array("controller" => "publicationyear","id" => $q,"label" => $q, "category" => "Publication Year");
	    	}
   		 }
    	
    	///keywords
    	$return = $this->subSearchNN($q,'keyword','ReferenceKeywordsView');
    	if (count($return)>0){
    			
    			$rs[] = array("controller" => "keyword","id" => $q,"label" => $q, "category" => "Keywords");
    	}
    	
    ///creators
    	$return = $this->subSearchNN($q,'creator','ReferenceCreatorsView');
    	if (count($return)>0){
    			
    			$rs[] = array("controller" => "author","id" => $q,"label" => $q, "category" => "Authors");
    	}
        
       
        return $rs;
    }
    
    public function filter($filter) {
    	                		
        $c = array();
        $rs = array();
        // where de cada entidade com OR entre
        $creatorWhere = '';
        $titleWhere = '';
        $typeReferenceWhere = '';
		$doiWhere = '';
		$isbnissnWhere = '';
		$languageWhere = '';
		$abstractWhere = '';
		$publicationyearWhere = '';
		$creatorWhere = '';
		$keywordWhere = '';
		
        //Filter already related References
        $relatedRefWhere = '';

        if($filter['list']!=null) {     
            foreach ($filter['list'] as &$v) {
                if($v['controller']=='title') {
                    $titleWhere = $titleWhere==''?'':$titleWhere.' OR ';
                    $titleWhere = $titleWhere.' refview.title ilike \'%'.$v['id'].'%\''.' OR difference(refview.title, \''.$v['id'].'\') > 3';                
	            }    
	            
	            if($v['controller']=='doi') {
                    $doiWhere = $doiWhere==''?'':$doiWhere.' OR ';
                    $doiWhere = $doiWhere.' refview.doi ilike \'%'.$v['id'].'%\''.' OR difference(refview.doi, \''.$v['id'].'\') > 3';                
	            }  

	            if($v['controller']=='isbnissn') {
                    $isbnissnWhere = $isbnissnWhere==''?'':$isbnissnWhere.' OR ';
                    $isbnissnWhere = $isbnissnWhere.' refview.isbnissn ilike \'%'.$v['id'].'%\''.' OR difference(refview.isbnissn, \''.$v['id'].'\') > 3';                
	            } 
	            
	            if($v['controller']=='language') {
                    $languageWhere = $languageWhere==''?'':$languageWhere.' OR ';
                    $languageWhere = $languageWhere.' refview.language ilike \'%'.$v['id'].'%\''.' OR difference(refview.language, \''.$v['id'].'\') > 3';                
	            } 
	            
	            
                if($v['controller']=='subtypereference') {
                    	$typeReferenceWhere = $typeReferenceWhere==''?'':$typeReferenceWhere.' OR ';
                    	$typeReferenceWhere = $typeReferenceWhere.' refview.subtypereference ilike \'%'.$v['id'].'%\''.' OR difference(refview.subtypereference, \''.$v['id'].'\') > 3';                              
            	}
            	
            	if($v['controller']=='abstract') {
                    	$abstractWhere = $abstractWhere==''?'':$abstractWhere.' OR ';
                    	$abstractWhere = $abstractWhere.' refview.abstract ilike \'%'.$v['id'].'%\''.' OR difference(refview.abstract, \''.$v['id'].'\') > 3';                              
            	}
            	
            	if($v['controller']=='publicationyear') {
                    	$publicationyearWhere = $publicationyearWhere==''?'':$publicationyearWhere.' OR ';
                    	$publicationyearWhere = $publicationyearWhere.' refview.publicationyear ='. $v['id'];                              
            	}
            	
            	if($v['controller']=='keyword') {
            			$list = $this->subSearchNN($v['id'],'keyword','ReferenceKeywordsView');
            			
            			$array = array();
            			if (is_array($list)){
            				foreach($list as $l){
            					$array [] = $l['idreferenceelement']; 
            				}
            				
            			}
            			$arrayStr = implode(",",$array);
                    	$keywordWhere = $keywordWhere==''?'':$keywordWhere.' OR ';
                    	$keywordWhere = $keywordWhere.' refview.idreferenceelement in ('. $arrayStr.') ';                              
            	}
            	
           		 if($v['controller']=='author') {
            			$list = $this->subSearchNN($v['id'],'creator','ReferenceCreatorsView');
            			
            			$array = array();
            			if (is_array($list)){
            				foreach($list as $l){
            					$array [] = $l['idreferenceelement']; 
            				}
            				
            			}
            			$arrayStr = implode(",",$array);
                    	$creatorWhere = $creatorWhere==''?'':$creatorWhere.' OR ';
                    	$creatorWhere = $creatorWhere.' refview.idreferenceelement in ('. $arrayStr.') ';                              
            	}
            	
        	}
        }

        

        // se o where de cada entidades nao estiver vazias, coloca AND antes
        $titleWhere = $titleWhere!=''?' AND ('.$titleWhere.') ':'';
        $doiWhere = $doiWhere!=''?' AND ('.$doiWhere.') ':'';
       	$isbnissnWhere = $isbnissnWhere!=''?' AND ('.$isbnissnWhere.') ':'';
       	$languageWhere = $languageWhere!=''?' AND ('.$languageWhere.') ':'';
        $typeReferenceWhere = $typeReferenceWhere!=''?' AND ('.$typeReferenceWhere.') ':'';
     	$abstractWhere = $abstractWhere!=''?' AND ('.$abstractWhere.') ':'';
     	$publicationyearWhere = $publicationyearWhere!=''?' AND ('.$publicationyearWhere.') ':'';
		$keywordWhere = $keywordWhere!=''?' AND ('.$keywordWhere.') ':'';
		$creatorWhere = $creatorWhere!=''?' AND ('.$creatorWhere.') ':'';
      
        $c['select'] = 'SELECT * ';
        $c['from'] = ' FROM reference_view refview ';

        $idGroup = Yii::app()->user->getGroupId();
       
        if ($idGroup!=2){
        	 $groupSQL = ' AND (idgroup='.$idGroup.') ';
        }
        
        $c['where'] = ' WHERE 1 = 1 '.$titleWhere.$doiWhere.$isbnissnWhere.$languageWhere.$typeReferenceWhere.$publicationyearWhere.$abstractWhere;
        $c['where'] = $c['where'].$keywordWhere.$creatorWhere.$groupSQL;
        $c['orderby'] = ' ORDER BY refview.title ';
        $c['limit'] = ' limit '.$filter['limit'];
        $c['offset'] = ' offset '.$filter['offset'];
        // junta tudo
        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['orderby'].$c['limit'].$c['offset'];
		
       
        // faz consulta e manda para list
        //echo 
        //$sql = 'select * from ('.$sql.') as a order by a.title';
        $rs['list'] = WebbeeController::executaSQL($sql);
        // altera parametros de consulta para fazer o Count
        //$c['select'] = 'SELECT count(*) ';
        $sql = 'SELECT COUNT(*) FROM ('.$c['select'].$c['from'].$c['join'].$c['where'].') as a';
        // faz consulta do Count e manda para count
        //echo $sql;die();
        $rs['count'] = WebbeeController::executaSQL($sql);
        return $rs;
    
    }
    public function showReference ($filter)
    {
        $showReferenceWhere = '';

        if($filter['refShowList'] != null)
        {
            foreach ($filter['refShowList'] as $key => $value)
            {
                $showReferenceWhere = $showReferenceWhere==''?'':$showReferenceWhere.' OR ';
                $showReferenceWhere = $showReferenceWhere.' ref.idreferenceelement = '.$value;
            }
        }

        else
            $showReferenceWhere = ' ref.idreferenceelement = 0';

        $showReferenceWhere = $showReferenceWhere!=''?' AND ('.$showReferenceWhere.') ':'';
        // parametros da consulta
        $c['select'] = 'SELECT ref.idreferenceelement, ref.isrestricted, ref.title, subtypereference.subtypereference, ref.publicationyear, file.filesystemname, file.path ';
        $c['from'] = ' FROM referenceelement ref ';
        $c['join'] = $c['join'].' LEFT JOIN subtypereference ON ref.idsubtypereference = subtypereference.idsubtypereference ';
        $c['join'] = $c['join'].' LEFT JOIN file ON ref.idfile = file.idfile ';
        $idGroup = Yii::app()->user->getGroupId();
        
    	if ($idGroup!=2){
        	 $groupSQL = ' AND (idgroup='.$idGroup.') ';
        }
        
        $c['where'] = ' WHERE 1 = 1 '.$showReferenceWhere.$groupSQL;
        $c['orderby'] = ' ORDER BY ref.title ';
        // junta tudo
        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['orderby'];
        // faz consulta e manda para list
        //echo $sql;die();
        $rs['list'] = WebbeeController::executaSQL($sql);
        // altera parametros de consulta para fazer o Count
        $c['select'] = 'SELECT count(*) ';
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
        // faz consulta do Count e manda para count
        $rs['count'] = WebbeeController::executaSQL($sql);
        return $rs;

    }
  
    public function save($ar) {
        $ar->modified=date('Y-m-d G:i:s');
        $ar->datedigitized = $ar->datedigitized ==''?null : $ar->datedigitized;

        $ar->idgroup = Yii::app()->user->getGroupId();
               
        $rs = array ();
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idreferenceelement == null?'created':'updated';
            $ar->setIsNewRecord($rs['operation']=='created');
            $aux = array();
            $aux[] = 'Successfully '.$rs['operation'].' reference record titled <b>'.$ar->title.' </b> ';
            $rs['msg'] = $aux;
            $ar->idreferenceelement = $ar->getIsNewRecord()?null:$ar->idreferenceelement;
            $ar->save();
            $rs['id'] = $ar->idreferenceelement;
            return $rs;
        }else {
            $erros = array ();
            foreach($ar->getErrors() as $n=>$mensagem):
                if($mensagem[0]!="") {
                    $erros[] = $mensagem[0];
            }
            endforeach;
            $rs['success'] = false;
            $rs['msg'] = $erros;
            return $rs;
        }
    }
    public function delete($id) {
        $ar = ReferenceAR::model();
        $ar = $ar->findByPk($id);
        
        $l = new KeywordLogic();
        $l->deleteReferenceRecord($id);
        $l = new AfiliationLogic();
        $l->deleteReferenceRecord($id);
        $l = new BiomeLogic();
        $l->deleteReferenceRecord($id);
        $l = new PlantSpeciesLogic();
        $l->deleteReferenceRecord($id);
        $l = new PlantFamilyLogic();
        $l->deleteReferenceRecord($id);
        $l = new PlantCommonNameLogic();
        $l->deleteReferenceRecord($id);
        $l = new PollinatorSpeciesLogic();
        $l->deleteReferenceRecord($id);
        $l = new PollinatorFamilyLogic();
        $l->deleteReferenceRecord($id);
        $l = new PollinatorCommonNameLogic();
        $l->deleteReferenceRecord($id);
        
        $l = new CreatorLogic();
        $l->deleteReferenceRecord($id);
        
        $l = new SpecimenLogic();
        $l->deleteReference($id);
        $l = new SpeciesLogic();
        $l->deleteReference($id);
        $ar->delete();
    }
    public function fillDependency($ar) {
        //if($ar->file==null)
        //    $ar->file = FileAR::model();
        //if($ar->fileformat==null)
        //    $ar->fileformat = FileFormatAR::model();

        return $ar;
    }
    public function saveSpecimenNN($idreference, $idspecimen) {
        if(SpecimenReferenceAR::model()->find(" idspecimen=$idspecimen AND idreferenceelement=$idreference ")==null) {
            $ar = SpecimenReferenceAR::model();
            $ar->idspecimen = $idspecimen;
            $ar->idreferenceelement = $idreference;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteSpecimenNN($idreference, $idspecimen) {
        $ar = SpecimenReferenceAR::model();
        $ar = $ar->find(" idspecimen=$idspecimen AND idreferenceelement=$idreference ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteSpecimen($idspecimen) {
        $ar = SpecimenReferenceAR::model();
        $arList = $ar->findAll(" idspecimen=$idspecimen ");
        foreach ($arList as $n=>$ar)
            $ar->delete();
    }
    public function saveSpeciesNN($idreference, $idspecies) {
        if(SpeciesReferenceAR::model()->find(" idspecies=$idspecies AND idreferenceelement=$idreference ")==null) {
            $ar = SpeciesReferenceAR::model();
            $ar->idspecies = $idspecies;
            $ar->idreferenceelement = $idreference;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteSpeciesNN($idreference, $idspecies) {
        $ar = SpeciesReferenceAR::model();
        $ar = $ar->find(" idspecies=$idspecies AND idreferenceelement=$idreference ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteSpecies($idspecies) {
        $ar = SpeciesReferenceAR::model();
        $arList = $ar->findAll(" idspecies=$idspecies ");
        foreach ($arList as $n=>$ar)
            $ar->delete();
    }
    public function getTip($filter)
    {
        $c = array();
        $rs = array();

        // parametros da consulta
        $c['select'] = 'SELECT *  ';
        $c['from'] = ' FROM referenceelement ref ';
        //$c['join'] = $c['join'].' LEFT JOIN typereference ON ref.idtypereference = typereference.idtypereference ';
        //$c['join'] = $c['join'].' LEFT JOIN referencecreator refcre ON ref.idreferenceelement = refcre.idreferenceelement ';
        //$c['join'] = $c['join'].' LEFT JOIN creator ON refcre.idcreator = creator.idcreator ';
        //$c['join'] = $c['join'].' LEFT JOIN file ON ref.idfile = file.idfile ';

        $c['where'] = ' WHERE ref.idreferenceelement = '.$filter['idreference'];
        // junta tudo
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];

        $rs = WebbeeController::executaSQL($sql);

        return $rs;
    }
}
?>
