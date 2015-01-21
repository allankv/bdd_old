<?php
include_once 'InstitutionCodeLogic.php';
include_once 'ScientificNameLogic.php';

include_once 'KingdomLogic.php';
include_once 'PhylumLogic.php';
include_once 'ClassLogic.php';
include_once 'OrderLogic.php';
include_once 'FamilyLogic.php';
include_once 'GenusLogic.php';
include_once 'SubgenusLogic.php';
include_once 'SpecificEpithetLogic.php';

include_once 'TaxonomicElementLogic.php';
include_once 'MediaLogic.php';
include_once 'ReferenceLogic.php';
include_once 'PublicationReferenceLogic.php';
include_once 'PaperLogic.php';
include_once 'IDKeyLogic.php';


class SpeciesLogic {
    public function filter($filter) {
        $c = array();
        $rs = array();

        //Taxa filter
        $kingdomWhere = '';
        $phylumWhere ='';
        $classWhere = '';
        $orderWhere = '';
        $familyWhere = '';
        $genusWhere = '';
        $subgenusWhere = '';
        $specificEpithetWhere = '';

        //Main fields filter
        $scientificNameWhere = '';
        $institutionCodeWhere = '';
        
        $usesWhere = '';
        
        if($filter['list']!=null) {
            foreach ($filter['list'] as &$v) {

                //Taxa
                if($v['controller']=='kingdom') {
                    $kingdomWhere = $kingdomWhere==''?'':$kingdomWhere.' OR ';
                    $kingdomWhere = $kingdomWhere.' t.idkingdom = '.$v['id'];
                }
                if($v['controller']=='phylum') {
                    $phylumWhere = $phylumWhere==''?'':$phylumWhere.' OR ';
                    $phylumWhere = $phylumWhere.' t.idphylum = '.$v['id'];
                }
                if($v['controller']=='class') {
                    $classWhere = $classWhere==''?'':$classWhere.' OR ';
                    $classWhere = $classWhere.' t.idclass = '.$v['id'];
                }
                if($v['controller']=='order') {
                    $orderWhere = $orderWhere==''?'':$orderWhere.' OR ';
                    $orderWhere = $orderWhere.' t.idorder = '.$v['id'];
                }
                if($v['controller']=='family') {
                    $familyWhere = $familyWhere==''?'':$familyWhere.' OR ';
                    $familyWhere = $familyWhere.' t.idfamily = '.$v['id'];
                }
                if($v['controller']=='genus') {
                    $genusWhere = $genusWhere==''?'':$genusWhere.' OR ';
                    $genusWhere = $genusWhere.' t.idgenus = '.$v['id'];
                }
                if($v['controller']=='subgenus') {
                    $subgenusWhere = $subgenusWhere==''?'':$subgenusWhere.' OR ';
                    $subgenusWhere = $subgenusWhere.' t.idsubgenus = '.$v['id'];
                }
                if($v['controller']=='specificepithet') {
                    $specificEpithetWhere = $specificEpithetWhere==''?'':$specificEpithetWhere.' OR ';
                    $specificEpithetWhere = $specificEpithetWhere.' t.idspecificepithet = '.$v['id'];
                }

                //Main fields
                if($v['controller']=='scientificname') {
                    $scientificNameWhere = $scientificNameWhere==''?'':$scientificNameWhere.' OR ';
                    $scientificNameWhere = $scientificNameWhere.' scn.idscientificname = '.$v['id'];
                }
               
                /*if($v['controller']=='uses') {
                    $usesWhere = $usesWhere==''?'':$usesWhere.' OR ';
                    $usesWhere = $usesWhere.' sp.uses ilike \'%'.$v['name'].'%\'';
                }
                */
                if($v['controller']=='uses') {
                    $usesWhere = $usesWhere==''?'':$titleWhere.' OR ';
                    $usesWhere = $usesWhere.' sp.uses ilike \'%'.$v['id'].'%\''.' OR difference(sp.uses, \''.$v['id'].'\') > 3';                
	            }  
              
                
             if($v['controller']=='folklore') {
                    $folkloreWhere = $folkloreWhere==''?'':$folkloreWhere.' OR ';
                    $folkloreWhere = $folkloreWhere.' sp.folklore ilike \'%'.$v['name'].'%\'';
                }
                
             if($v['controller']=='benefits') {
                    $benefitsWhere = $benefitsWhere==''?'':$benefitsWhere.' OR ';
                    $benefitsWhere = $benefitsWhere.' sp.benefits ilike \'%'.$v['name'].'%\'';
                }
                
             if($v['controller']=='institutioncode') {
                    $institutionCodeWhere = $institutionCodeWhere==''?'':$institutionCodeWhere.' OR ';
                    $institutionCodeWhere = $institutionCodeWhere.' sp.idinstitutioncode = '.$v['id'];
                }
            }
        }
        // se o where de cada entidades nao estiver vazias, coloca AND antes

        //Main fields
        $institutionCodeWhere = $institutionCodeWhere!=''?' AND ('.$institutionCodeWhere.') ':'';
        $scientificNameWhere = $scientificNameWhere!=''?' AND ('.$scientificNameWhere.') ':'';
        $usesWhere = $usesWhere!=''?' AND ('.$usesWhere.') ':'';
        
         $benefitsWhere = $benefitsWhere!=''?' AND ('.$benefitsWhere.') ':'';
         
         $folkloreWhere = $folkloreWhere!=''?' AND ('.$folkloreWhere.') ':'';
          
        //Taxa
        $kingdomWhere = $kingdomWhere!=''?' AND ('.$kingdomWhere.') ':'';
        $phylumWhere = $phylumWhere!=''?' AND ('.$phylumWhere.') ':'';
        $classWhere = $classWhere!=''?' AND ('.$classWhere.') ':'';
        $orderWhere = $orderWhere!=''?' AND ('.$orderWhere.') ':'';
        $familyWhere = $familyWhere!=''?' AND ('.$familyWhere.') ':'';
        $genusWhere = $genusWhere!=''?' AND ('.$genusWhere.') ':'';
        $subgenusWhere = $subgenusWhere!=''?' AND ('.$subgenusWhere.') ':'';
        $specificEpithetWhere = $specificEpithetWhere!=''?' AND ('.$specificEpithetWhere.') ':'';


        // parametros da consulta
        $c['select'] = 'SELECT sp.idspecies, scn.scientificname, inst.institutioncode ';
        $c['from'] = ' FROM species sp ';
        $c['join'] = $c['join'].' LEFT JOIN institutioncode inst ON sp.idinstitutioncode = inst.idinstitutioncode ';
        $c['join'] = $c['join'].' LEFT JOIN taxonomicelement t ON sp.idtaxonomicelement = t.idtaxonomicelement  ';
        $c['join'] = $c['join'].' LEFT JOIN scientificname scn ON t.idscientificname = scn.idscientificname  ';
        $c['where'] = ' WHERE 1 = 1 '.$institutionCodeWhere.$scientificNameWhere.
               $folkloreWhere.$benefitsWhere.$kingdomWhere.$phylumWhere.$classWhere.$orderWhere.$familyWhere.$genusWhere.$subgenusWhere.$specificEpithetWhere.$usesWhere;
                
        $idGroup = Yii::app()->user->getGroupId();
		
    	if ($idGroup!=2){
        	 $groupSQL = ' AND (idgroup='.$idGroup.') ';
        }
        
		$c['where'] =  $c['where'].$groupSQL;

        $c['orderby'] = ' ORDER BY scn.scientificname, sp.idspecies ';
        $c['limit'] = ' limit '.$filter['limit'];
        $c['offset'] = ' offset '.$filter['offset'];

        // junta tudo
        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['orderby'].$c['limit'].$c['offset'];
        $rs['sql'] = $sql;
        // faz consulta e manda para list
        $rs['list'] = WebbeeController::executaSQL($sql);
        // altera parametros de consulta para fazer o Count
        $c['select'] = 'SELECT count(*) ';
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
        // faz consulta do Count e manda para count
        $rs['count'] = WebbeeController::executaSQL($sql);
        return $rs;
    }
    
public function subSearch($q,$field) {
  		$mainAtt = $field;
        $ar = SpeciesAR::model();
        $q = trim($q);
        $group = Yii::app()->user->getGroupId();
       
        $criteria = new CDbCriteria();
               
        $criteria->condition = "($mainAtt ilike '%$q%' OR difference($mainAtt, '$q') > 3)";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
       
        return $rs;
    }
    
    public function search($q) {

        /*
        //Main fields
        $institutionCodeLogic = new InstitutionCodeLogic();
        $institutionCodeList = $institutionCodeLogic->search($q);
        $scientificNameLogic = new ScientificNameLogic();
        $scientificNameList = $scientificNameLogic->search($q);
        
        //Taxa
        $kingdomLogic = new KingdomLogic();
        $kingdomList = $kingdomLogic->search($q);
        $phylumLogic = new PhylumLogic();
        $phylumList = $phylumLogic->search($q);
        $classLogic = new ClassLogic();
        $classList = $classLogic->search($q);
        $orderLogic = new OrderLogic();
        $orderList = $orderLogic->search($q);
        $familyLogic = new FamilyLogic();
        $familyList = $familyLogic->search($q);
        $genusLogic = new GenusLogic();
        $genusList = $genusLogic->search($q);
        $subgenusLogic = new SubgenusLogic();
        $subgenusList = $subgenusLogic->search($q);
        $specificEpithetLogic = new SpecificEpithetLogic();
        $specificEpithetList = $specificEpithetLogic->search($q);*/

        //Temporary fix - need to change search function - using searchList for now
        //Main fields
        $institutionCodeLogic = new InstitutionCodeLogic();
        $institutionCodeList = $institutionCodeLogic->searchList($q);
        $scientificNameLogic = new ScientificNameLogic();
        $scientificNameList = $scientificNameLogic->searchList($q);

        //Taxa
        $kingdomLogic = new KingdomLogic();
        $kingdomList = $kingdomLogic->searchList($q);
        $phylumLogic = new PhylumLogic();
        $phylumList = $phylumLogic->searchList($q);
        $classLogic = new ClassLogic();
        $classList = $classLogic->searchList($q);
        $orderLogic = new OrderLogic();
        $orderList = $orderLogic->searchList($q);
        $familyLogic = new FamilyLogic();
        $familyList = $familyLogic->searchList($q);
        $genusLogic = new GenusLogic();
        $genusList = $genusLogic->searchList($q);
        $subgenusLogic = new SubgenusLogic();
        $subgenusList = $subgenusLogic->searchList($q);
        $specificEpithetLogic = new SpecificEpithetLogic();
        $specificEpithetList = $specificEpithetLogic->searchList($q);


        $rs = array();

        //Main fields

        foreach($institutionCodeList as $n=>$ar) {
            $rs[] = array("controller" => "institutioncode","id" => $ar->idinstitutioncode,"label" => $ar->institutioncode,"category" => "Institution code");
        }
        foreach($scientificNameList as $n=>$ar) {
            $rs[] = array("controller" => "scientificname","id" => $ar->idscientificname,"label" => $ar->scientificname,"category" => "Scientific name");
        }
        
        /*
        $id = uniqid();
        
        $usesList = $this->searchListUses($q);
       
        
     	foreach($usesList as $n=>$ar) {
     	     
     		
     	     		         
            $rs[] = array("controller" => "uses","id" =>$id,"label" =>$ar->uses,"category" => "Uses");
        }*/
        
    	$return = $this->subSearch($q,'uses');
    	if (count($return)>0){
    			
    			$rs[] = array("controller" => "uses","id" => $q,"label" => $q, "category" => "Uses");
    	}
    	
	    $return = $this->subSearch($q,'benefits');
	    	if (count($return)>0){
    			
    			$rs[] = array("controller" => "benefits","id" => $q,"label" => $q, "category" => "Benefits");
    	}
        
    	
    	$return = $this->subSearch($q,'folklore');
	    	if (count($return)>0){
    			
    			$rs[] = array("controller" => "folklore","id" => $q,"label" => $q, "category" => "Folklore");
    	}
    	
    

		
        //Taxa

        foreach($specificEpithetList as $n=>$ar) {
            $rs[] = array("controller" => "specificepithet","id" => $ar->idspecificepithet,"label" => $ar->specificepithet,"category" => "Specific epithet");
        }
        foreach($subgenusList as $n=>$ar) {
            $rs[] = array("controller" => "subgenus","id" => $ar->idsubgenus,"label" => $ar->subgenus,"category" => "Subgenus");
        }
        foreach($genusList as $n=>$ar) {
            $rs[] = array("controller" => "genus","id" => $ar->idgenus,"label" => $ar->genus,"category" => "Genus");
        }
        foreach($familyList as $n=>$ar) {
            $rs[] = array("controller" => "family","id" => $ar->idfamily,"label" => $ar->family,"category" => "Family");
        }
        foreach($orderList as $n=>$ar) {
            $rs[] = array("controller" => "order","id" => $ar->idorder,"label" => $ar->order,"category" => "Order");
        }
        foreach($classList as $n=>$ar) {
            $rs[] = array("controller" => "class","id" => $ar->idclass,"label" => $ar->class,"category" => "Class");
        }
        foreach($phylumList as $n=>$ar) {
            $rs[] = array("controller" => "phylum","id" => $ar->idphylum,"label" => $ar->phylum,"category" => "Phylum");
        }
        foreach($kingdomList as $n=>$ar) {
            $rs[] = array("controller" => "kingdom","id" => $ar->idkingdom,"label" => $ar->kingdom,"category" => "Kingdom");
        }


        return $rs;
    }
    public function getSpecies($ar) {
        return $this->fillDependency($ar->findByPk($ar->idspecies));
    }
    public function fillDependency($ar) {
        if($ar->institutioncode==null)
            $ar->institutioncode = new InstitutionCodeAR();
        if($ar->taxonomicelement==null)
            $ar->taxonomicelement = new TaxonomicElementAR();
        
        $l = new TaxonomicElementLogic();
        $ar->taxonomicelement = $l->fillDependency($ar->taxonomicelement);
        
        return $ar;
    }

    public function save($ar) {
        //Set last modified date
        //$ar->recordlevelelement->modified=date('Y-m-d G:i:s');
        $ar->idgroup = Yii::app()->user->getGroupId();
        $ar->datecreated = $ar->datecreated==''?null:$ar->datecreated;
        $ar->datelastmodified = $ar->datelastmodified==''?null:$ar->datelastmodified;

        //Set the highest classification
        $higherclassification .= ($ar->taxonomicelement->kingdom->kingdom <> "" ? $ar->taxonomicelement->kingdom->kingdom.";" : "");
        $higherclassification .= ($ar->taxonomicelement->phylum->phylum <> "" ? $ar->taxonomicelement->phylum->phylum.";" : "");
        $higherclassification .= ($ar->taxonomicelement->class->class <> "" ? $ar->taxonomicelement->class->class.";" : "");
        $higherclassification .= ($ar->taxonomicelement->order->order <> "" ? $ar->taxonomicelement->order->order.";" : "");
        $higherclassification .= ($ar->taxonomicelement->family->family <> "" ? $ar->taxonomicelement->family->family.";" : "");
        $higherclassification .= ($ar->taxonomicelement->genus->genus <> "" ? $ar->taxonomicelement->genus->genus.";" : "");
        $higherclassification .= ($ar->taxonomicelement->subgenus->subgenus <> "" ? $ar->taxonomicelement->subgenus->subgenus.";" : "");
        $higherclassification = preg_replace("/;$/", "", $higherclassification);
        $higherclassification = preg_replace("/^;/", "", $higherclassification);
        $ar->taxonomicelement->higherclassification = $higherclassification;

        $rs = array ();
        
        if($ar->validate() && $ar->taxonomicelement->validate()) {

            $logic = new TaxonomicElementLogic();
            $ar->idtaxonomicelement = $logic->save($ar->taxonomicelement);

            $rs['success'] = true;
            $rs['operation'] = $ar->idspecies == null?'created':'updated';
            $ar->setIsNewRecord($rs['operation']=='created');
            $aux = array();

            //Global Unique Identifier Success message
            //$aux[] = 'Successfully '.$rs['operation'].' species record <br/>Institution Code: '.$ar->institutioncode->institutioncode.'<br/>Collection Code: '.$ar->recordlevelelement->collectioncode->collectioncode.'<br/>Catalog Number: '.$ar->occurrenceelement->catalognumber;
            $aux[] = 'Successfully '.$rs['operation'].' species record <br/>Institution Code: '.$ar->institutioncode->institutioncode;
            $rs['msg'] = $aux;

            $ar->idspecies = $ar->getIsNewRecord()?null:$ar->idspecies;
            $ar->save(false);
            $rs['ar'] = $ar;
            return $rs;
            
        }else {
            
            $erros = array ();
            /*foreach($ar->getErrors() as $n=>$mensagem):
                if($mensagem[0]!="") {
                    $erros[] = $mensagem[0];
            }
            endforeach;*/
            $ar->taxonomicelement->validate();
            foreach($ar->taxonomicelement->getErrors() as $n=>$mensagem):
                if($mensagem[0]!="") {
                    $erros[] = $mensagem[0];
            }
            endforeach;

            $ar->validate();
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
        $taxonomic = new TaxonomicElementLogic();
        $media = new MediaLogic();
        $reference = new ReferenceLogic();
        $paper = new PaperLogic();
        $pubRef = new PublicationReferenceLogic();
        $idkey = new IDKeyLogic();

        $media->deleteSpecies($id);
        $reference->deleteSpecies($id);
        $paper->deleteSpecies($id);
        $pubRef->deleteSpecies($id);
        $idkey->deleteSpecies($id);


        $ar = SpeciesAR::model();
        $ar->idspecies = $id;
        $ar = $this->getSpecies($ar);
        $ar->delete();
        $taxonomic->delete($ar->idtaxonomicelement);
    }


    public function getMedia($filter) {
        $c = array();
        $rs = array();

        // parametros da consulta
        $c['select'] = 'SELECT media.idmedia, media.title, file.path, file.filesystemname, cm.categorymedia, scm.subcategorymedia ';
        $c['from'] = ' FROM speciesmedia spmedia ';
        $c['join'] = $c['join'].' LEFT JOIN media ON spmedia.idmedia = media.idmedia ';
        $c['join'] = $c['join'].' LEFT JOIN file ON media.idfile = file.idfile ';
        $c['join'] = $c['join'].' LEFT JOIN categorymedia cm ON media.idcategorymedia = cm.idcategorymedia ';
        $c['join'] = $c['join'].' LEFT JOIN subcategorymedia scm ON media.idsubcategorymedia = scm.idsubcategorymedia ';
        $c['where'] = ' WHERE spmedia.idspecies ='.$filter['idspecies'];

        // junta tudo
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
        // faz consulta e manda para list
        $rs['list'] = WebbeeController::executaSQL($sql);
        // altera parametros de consulta para fazer o Count
        $c['select'] = 'SELECT count(*) ';
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
        // faz consulta do Count e manda para count
        $rs['count'] = WebbeeController::executaSQL($sql);
        return $rs;
    }

    public function removeMedia($filter) {
        $c = array();
        $rs = array();

        // parametros da consulta
        $c['delete'] = 'DELETE';
        $c['from'] = ' FROM speciesmedia spmedia ';
        $c['where'] = ' WHERE spmedia.idspecies ='.$filter['idspecies'].' and spmedia.idmedia ='.$filter['idmedia'];

        // junta tudo
        $sql = $c['delete'].$c['from'].$c['where'];
        // faz consulta e manda para list
        $rs['list'] = WebbeeController::executaSQL($sql);
        // altera parametros de consulta para fazer o Count
        $c['select'] = 'SELECT count(*) ';
        $sql = $c['select'].$c['from'].$c['where'];
        // faz consulta do Count e manda para count
        $rs['count'] = WebbeeController::executaSQL($sql);
        return $rs;
    }
    public function getReference($filter) {
        $c = array();
        $rs = array();

        // parametros da consulta
        $c['select'] = 'SELECT ref.idreferenceelement, ref.title, ref.isrestricted, tr.typereference ';
        $c['from'] = ' FROM speciesreference spref ';
        $c['join'] = $c['join'].' LEFT JOIN referenceelement ref ON spref.idreferenceelement = ref.idreferenceelement ';
        $c['join'] = $c['join'].' LEFT JOIN typereference tr ON ref.idtypereference = tr.idtypereference ';
        $c['where'] = ' WHERE spref.idspecies ='.$filter['idspecies'];

        // junta tudo
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
        // faz consulta e manda para list
        $rs['list'] = WebbeeController::executaSQL($sql);
        // altera parametros de consulta para fazer o Count
        $c['select'] = 'SELECT count(*) ';
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
        // faz consulta do Count e manda para count
        $rs['count'] = WebbeeController::executaSQL($sql);
        return $rs;
    }

    public function removeReference($filter) {
        $c = array();
        $rs = array();

        // parametros da consulta
        $c['delete'] = 'DELETE';
        $c['from'] = ' FROM speciesreference spref ';
        $c['where'] = ' WHERE spref.idspecies ='.$filter['idspecies'].' and spref.idreferenceelement ='.$filter['idreference'];

        // junta tudo
        $sql = $c['delete'].$c['from'].$c['where'];
        // faz consulta e manda para list
        $rs['list'] = WebbeeController::executaSQL($sql);
        // altera parametros de consulta para fazer o Count
        $c['select'] = 'SELECT count(*) ';
        $sql = $c['select'].$c['from'].$c['where'];
        // faz consulta do Count e manda para count
        $rs['count'] = WebbeeController::executaSQL($sql);
        return $rs;
    }

    public function getPubReference($filter) {
        $c = array();
        $rs = array();

        // parametros da consulta
        $c['select'] = 'SELECT ref.idreferenceelement, ref.title, ref.isrestricted, tr.typereference ';
        $c['from'] = ' FROM speciespublicationreference spref ';
        $c['join'] = $c['join'].' LEFT JOIN referenceelement ref ON spref.idreferenceelement = ref.idreferenceelement ';
        $c['join'] = $c['join'].' LEFT JOIN typereference tr ON ref.idtypereference = tr.idtypereference ';
        $c['where'] = ' WHERE spref.idspecies ='.$filter['idspecies'];

        // junta tudo
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
        // faz consulta e manda para list
        $rs['list'] = WebbeeController::executaSQL($sql);
        // altera parametros de consulta para fazer o Count
        $c['select'] = 'SELECT count(*) ';
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
        // faz consulta do Count e manda para count
        $rs['count'] = WebbeeController::executaSQL($sql);
        return $rs;
    }

    public function removePubReference($filter) {
        $c = array();
        $rs = array();

        // parametros da consulta
        $c['delete'] = 'DELETE';
        $c['from'] = ' FROM speciespublicationreference spref ';
        $c['where'] = ' WHERE spref.idspecies ='.$filter['idspecies'].' and spref.idreferenceelement ='.$filter['idreference'];

        // junta tudo
        $sql = $c['delete'].$c['from'].$c['where'];
        // faz consulta e manda para list
        $rs['list'] = WebbeeController::executaSQL($sql);
        // altera parametros de consulta para fazer o Count
        $c['select'] = 'SELECT count(*) ';
        $sql = $c['select'].$c['from'].$c['where'];
        // faz consulta do Count e manda para count
        $rs['count'] = WebbeeController::executaSQL($sql);
        return $rs;
    }

    public function getPaper($filter) {
        $c = array();
        $rs = array();

        // parametros da consulta
        $c['select'] = 'SELECT ref.idreferenceelement, ref.title, ref.isrestricted, tr.typereference ';
        $c['from'] = ' FROM speciespaper spref ';
        $c['join'] = $c['join'].' LEFT JOIN referenceelement ref ON spref.idreferenceelement = ref.idreferenceelement ';
        $c['join'] = $c['join'].' LEFT JOIN typereference tr ON ref.idtypereference = tr.idtypereference ';
        $c['where'] = ' WHERE spref.idspecies ='.$filter['idspecies'];

        // junta tudo
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
        // faz consulta e manda para list
        $rs['list'] = WebbeeController::executaSQL($sql);
        // altera parametros de consulta para fazer o Count
        $c['select'] = 'SELECT count(*) ';
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
        // faz consulta do Count e manda para count
        $rs['count'] = WebbeeController::executaSQL($sql);
        return $rs;
    }

    public function removePaper($filter) {
        $c = array();
        $rs = array();

        // parametros da consulta
        $c['delete'] = 'DELETE';
        $c['from'] = ' FROM speciespaper spref ';
        $c['where'] = ' WHERE spref.idspecies ='.$filter['idspecies'].' and spref.idreferenceelement ='.$filter['idreference'];

        // junta tudo
        $sql = $c['delete'].$c['from'].$c['where'];
        // faz consulta e manda para list
        $rs['list'] = WebbeeController::executaSQL($sql);
        // altera parametros de consulta para fazer o Count
        $c['select'] = 'SELECT count(*) ';
        $sql = $c['select'].$c['from'].$c['where'];
        // faz consulta do Count e manda para count
        $rs['count'] = WebbeeController::executaSQL($sql);
        return $rs;
    }
    public function getKey($filter) {
        $c = array();
        $rs = array();

        // parametros da consulta
        $c['select'] = 'SELECT ref.idreferenceelement, ref.title, ref.isrestricted, tr.typereference ';
        $c['from'] = ' FROM speciesidkey spref ';
        $c['join'] = $c['join'].' LEFT JOIN referenceelement ref ON spref.idreferenceelement = ref.idreferenceelement ';
        $c['join'] = $c['join'].' LEFT JOIN typereference tr ON ref.idtypereference = tr.idtypereference ';
        $c['where'] = ' WHERE spref.idspecies ='.$filter['idspecies'];

        // junta tudo
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
        // faz consulta e manda para list
        $rs['list'] = WebbeeController::executaSQL($sql);
        // altera parametros de consulta para fazer o Count
        $c['select'] = 'SELECT count(*) ';
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
        // faz consulta do Count e manda para count
        $rs['count'] = WebbeeController::executaSQL($sql);
        return $rs;
    }

    public function removeKey($filter) {
        $c = array();
        $rs = array();

        // parametros da consulta
        $c['delete'] = 'DELETE';
        $c['from'] = ' FROM speciesidkey spref ';
        $c['where'] = ' WHERE spref.idspecies ='.$filter['idspecies'].' and spref.idreferenceelement ='.$filter['idreference'];

        // junta tudo
        $sql = $c['delete'].$c['from'].$c['where'];
        // faz consulta e manda para list
        $rs['list'] = WebbeeController::executaSQL($sql);
        // altera parametros de consulta para fazer o Count
        $c['select'] = 'SELECT count(*) ';
        $sql = $c['select'].$c['from'].$c['where'];
        // faz consulta do Count e manda para count
        $rs['count'] = WebbeeController::executaSQL($sql);
        return $rs;
    }


    public function deleteMedia($idmedia) {
        $ar = SpeciesMediaAR::model();
        $arList = $ar->findAll(" idmedia=$idmedia ");
        foreach ($arList as $n=>$ar)
            $ar->delete();
    }
    public function deleteReference($idreference) {
        $ar = SpeciesReferenceAR::model();
        $arList = $ar->findAll(" idreferenceelement=$idreference ");
        foreach ($arList as $n=>$ar)
            $ar->delete();
    }
    public function getTip($filter)
    {
        $c = array();
        $rs = array();

        // parametros da consulta
        $c['select'] = 'SELECT inst.institutioncode ';
        $c['from'] = ' FROM species sp ';
        $c['join'] = $c['join'].' LEFT JOIN institutioncode inst ON sp.idinstitutioncode = inst.idinstitutioncode ';
        $c['where'] = ' WHERE sp.idspecies = '.$filter['idspecies'];

        // junta tudo
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
        // faz consulta e manda para list
        $rs = WebbeeController::executaSQL($sql);

        return $rs;
    }

public function searchListUses($q) {
        $ar = SpeciesAR::model();
        $q = trim($q);
        $idgrupo = Yii::app()->user->getGroupId();
        $criteria = new CDbCriteria();
        $criteria->condition = "idgroup = $idgrupo and uses ilike '%$q%' OR difference(uses, '$q') > 3";
       // $criteria->limit = 20;
        $criteria->order = "uses";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    
public function searchListfolklore($q) {
        $ar = SpeciesAR::model();
        $q = trim($q);
        $idgrupo = Yii::app()->user->getGroupId();
        $criteria = new CDbCriteria();
        $criteria->condition = "idgroup = $idgrupo and folklore ilike '%$q%' OR difference(folklore, '$q') > 3";
        //$criteria->limit = 20;
        $criteria->order = "folklore";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    
public function searchListbenefits($q) {
        $ar = SpeciesAR::model();
        $q = trim($q);
        $idgrupo = Yii::app()->user->getGroupId();
        $criteria = new CDbCriteria();
        $criteria->condition = "idgroup =  $idgrupo and benefits ilike '%$q%' OR difference(benefits, '$q') > 3";
        ///$criteria->limit = 20;
        $criteria->order = "benefits";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    
  
}
?>
