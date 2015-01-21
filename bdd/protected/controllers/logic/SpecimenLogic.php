<?php
include_once 'InstitutionCodeLogic.php';
include 'CollectionCodeLogic.php';
include_once 'ScientificNameLogic.php';
include 'BasisOfRecordLogic.php';

include_once 'KingdomLogic.php';
include_once 'PhylumLogic.php';
include_once 'ClassLogic.php';
include_once 'OrderLogic.php';
include_once 'FamilyLogic.php';
include_once 'GenusLogic.php';
include_once 'SubgenusLogic.php';
include_once 'SpecificEpithetLogic.php';

include_once 'CountryLogic.php';
include_once 'StateProvinceLogic.php';
include_once 'CountyLogic.php';
include_once 'MunicipalityLogic.php';
include_once 'LocalityLogic.php';

include 'RecordLevelElementLogic.php';
include 'OccurrenceElementLogic.php';
include_once 'TaxonomicElementLogic.php';
include 'CuratorialElementLogic.php';
include 'IdentificationElementLogic.php';
include 'EventElementLogic.php';
include 'LocalityElementLogic.php';
include 'GeospatialElementLogic.php';
include_once 'MediaLogic.php';
include_once 'ReferenceLogic.php';
include_once 'InteractionLogic.php';
//include_once 'DataqualityLogic.php';

class SpecimenLogic {
	
	public function subSearchNN($q,$field,$view) {
  		/*$mainAtt = $field;
  		$nome = $view.'AR';
        $ar = new $nome();
        $q = strtolower(trim($q));
        $criteria = new CDbCriteria();
        
        $criteria->condition = "$mainAtt ilike '%$q%' OR difference($mainAtt, '$q') > 2";
    
        $criteria->limit = 100;
        $criteria->order = "$this->mainAtt";*/
		
		$sql = "select * from $view where ($field ilike '%$q%')";
        $rs = WebbeeController::executaSQL($sql);
       
      
        return $rs;
    }
    
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

        //Locality filter
        $countryWhere = '';
        $stateProvinceWhere = '';
        $countyWhere = '';
        $municipalityWhere = '';
        $localityWhere = '';


        //Main fields filter
        $basisOfRecordWhere = '';
        $catalogNumberWhere = '';
        $scientificNameWhere = '';
        $institutionCodeWhere = '';
        $collectionCodeWhere = '';
        
        
        //NXN
        $recordedbyWhere = '';
        $collectionCodeWhere = '';
        $preparationWhere = '';
        
        
        //recordnumber
        $recordnumberWhere = '';

        //othercatalognumber
        $othercatalognumberWhere = '';
        
        
      $idGroup = Yii::app()->user->getGroupId();
		
   		if ($idGroup!=2){
        	 $groupSQL = ' AND (idgroup='.$idGroup.') ';
        }
        
        
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

                //Locality
                if($v['controller']=='country') {
                    $countryWhere = $countryWhere==''?'':$countryWhere.' OR ';
                    $countryWhere = $countryWhere.' l.idcountry = '.$v['id'];
                }
                if($v['controller']=='stateprovince') {
                    $stateProvinceWhere = $stateProvinceWhere==''?'':$stateProvinceWhere.' OR ';
                    $stateProvinceWhere = $stateProvinceWhere.' l.idstateprovince = '.$v['id'];
                }
                if($v['controller']=='county') {
                    $countyWhere = $countyWhere==''?'':$countyWhere.' OR ';
                    $countyWhere = $countyWhere.' l.idcounty = '.$v['id'];
                }
                if($v['controller']=='municipality') {
                    $municipalityWhere = $municipalityWhere==''?'':$municipalityWhere.' OR ';
                    $municipalityWhere = $municipalityWhere.' l.idmunicipality = '.$v['id'];
                }
                if($v['controller']=='locality') {
                    $localityWhere = $localityWhere==''?'':$localityWhere.' OR ';
                    $localityWhere = $localityWhere.' l.idlocality = '.$v['id'];
                }

			
			

                //Main fields
                if($v['controller']=='basisofrecord') {
                    $basisOfRecordWhere = $basisOfRecordWhere==''?'':$basisOfRecordWhere.' OR ';
                    $basisOfRecordWhere = $basisOfRecordWhere.' r.idbasisofrecord = '.$v['id'];
                }
                if($v['controller']=='catalognumber') {
                    $catalogNumberWhere = $catalogNumberWhere==''?'':$catalogNumberWhere.' OR ';
                    $catalogNumberWhere = $catalogNumberWhere.' o.catalognumber like \'%'.$v['name'].'%\' ';
                }
                if($v['controller']=='scientificname') {
                    $scientificNameWhere = $scientificNameWhere==''?'':$scientificNameWhere.' OR ';
                    $scientificNameWhere = $scientificNameWhere.' scn.idscientificname = '.$v['id'];
                }
                if($v['controller']=='institutioncode') {
                    $institutionCodeWhere = $institutionCodeWhere==''?'':$institutionCodeWhere.' OR ';
                    $institutionCodeWhere = $institutionCodeWhere.' r.idinstitutioncode = '.$v['id'];
                }
                if($v['controller']=='collectioncode') {
                    $collectionCodeWhere = $collectionCodeWhere==''?'':$collectionCodeWhere.' OR ';
                    $collectionCodeWhere = $collectionCodeWhere.' r.idcollectioncode = '.$v['id'];
                }
            	 if($v['controller']=='recordnumber') {
                    $recordnumberWhere = $recordnumberWhere==''?'':$recordnumberWhere.' OR ';
                    $recordnumberWhere = $recordnumberWhere.' o.recordnumber like \'%'.$v['id'].'%\'';
                }
            
             	if($v['controller']=='othercatalognumber') {
                    $othercatalognumberWhere = $othercatalognumberWhere==''?'':$othercatalognumberWhere.' OR ';
                    $othercatalognumberWhere = $othercatalognumberWhere.' o.othercatalognumber like \'%'.$v['id'].'%\'';
                }
                
                           
                //NXN
             	if($v['controller']=='recordedby') {
            			$list = $this->subSearchNN($v['id'],'recordedby','OccurrenceelementRecordedbyView');
            			
            			$array = array();
            			if (is_array($list)){
            				foreach($list as $l){
            					if ($l['idgroup']==$idGroup){
            						$array [] = $l['idoccurrenceelement'];
            					} 
            				}
            				
            			}
            			$arrayStr = implode(",",$array);
            			
            			
                    	$recordedbyWhere = $recordedbyWhere==''?'':$recordedbyWhere.' OR ';
                    	$recordedbyWhere = $recordedbyWhere.' o.idoccurrenceelement in ('. $arrayStr.') ';                              
            	}
            
            	
            if($v['controller']=='preparation') {
            			$list = $this->subSearchNN($v['id'],'preparation','OccurrenceelementPreparationView');
            			
            			$array = array();
            			if (is_array($list)){
            				foreach($list as $l){
            					if ($l['idgroup']==$idGroup){
            						$array [] = $l['idoccurrenceelement'];
            					} 
            				}
            				
            			}
            			$arrayStr = implode(",",$array);
            			
            			
                    	$preparationWhere = $preparationWhere==''?'':$preparationWhere.' OR ';
                    	$preparationWhere = $preparationWhere.' o.idoccurrenceelement in ('. $arrayStr.') ';                              
            	}
            }
        }
        // se o where de cada entidades nao estiver vazias, coloca AND antes

        
        //Main fields
        $institutionCodeWhere = $institutionCodeWhere!=''?' AND ('.$institutionCodeWhere.') ':'';
        $collectionCodeWhere = $collectionCodeWhere!=''?' AND ('.$collectionCodeWhere.') ':'';
        $scientificNameWhere = $scientificNameWhere!=''?' AND ('.$scientificNameWhere.') ':'';
        $basisOfRecordWhere = $basisOfRecordWhere!=''?' AND ('.$basisOfRecordWhere.') ':'';
        $catalogNumberWhere = $catalogNumberWhere!=''?' AND ('.$catalogNumberWhere.') ':'';
        
        ///recordnumber
       // $recordnumberWhere = $recordnumberWhere!=''?' AND ('.$recordnumberWhere.') ':'';

        //Locality
        $countryWhere = $countryWhere!=''?' AND ('.$countryWhere.') ':'';
        $stateProvinceWhere = $stateProvinceWhere!=''?' AND ('.$stateProvinceWhere.') ':'';
        $countyWhere = $countyWhere!=''?' AND ('.$countyWhere.') ':'';
        $municipalityWhere = $municipalityWhere!=''?' AND ('.$municipalityWhere.') ':'';
        $localityWhere = $localityWhere!=''?' AND ('.$localityWhere.') ':'';

        //Taxa
        $kingdomWhere = $kingdomWhere!=''?' AND ('.$kingdomWhere.') ':'';
        $phylumWhere = $phylumWhere!=''?' AND ('.$phylumWhere.') ':'';
        $classWhere = $classWhere!=''?' AND ('.$classWhere.') ':'';
        $orderWhere = $orderWhere!=''?' AND ('.$orderWhere.') ':'';
        $familyWhere = $familyWhere!=''?' AND ('.$familyWhere.') ':'';
        $genusWhere = $genusWhere!=''?' AND ('.$genusWhere.') ':'';
        $subgenusWhere = $subgenusWhere!=''?' AND ('.$subgenusWhere.') ':'';
        $specificEpithetWhere = $specificEpithetWhere!=''?' AND ('.$specificEpithetWhere.') ':'';

        
        
        //NXN
        $recordedbyWhere = $recordedbyWhere!=''?' AND ('.$recordedbyWhere.') ':'';
        $preparationWhere = $preparationWhere!=''?' AND ('.$preparationWhere.') ':'';

        
        $recordnumberWhere =  $recordnumberWhere!=''?' AND ('.$recordnumberWhere.') ':'';
        $othercatalognumberWhere =  $othercatalognumberWhere!=''?' AND ('.$othercatalognumberWhere.') ':'';
        
        // parametros da consulta
        $c['select'] = 'SELECT r.isrestricted, sp.idspecimen, o.catalognumber, inst.institutioncode, coll.collectioncode, k.kingdom, p.phylum, cla.class, ord.order, fam.family, gen.genus, sub.subgenus, spec.specificepithet, ispec.infraspecificepithet, scn.scientificname, 
        o.recordnumber, o.othercatalognumber';
        $c['from'] = ' FROM specimen sp ';
        $c['join'] = $c['join'].' LEFT JOIN recordlevelelement r ON sp.idrecordlevelelement = r.idrecordlevelelement ';
        $c['join'] = $c['join'].' LEFT JOIN institutioncode inst ON r.idinstitutioncode = inst.idinstitutioncode ';
        $c['join'] = $c['join'].' LEFT JOIN collectioncode coll ON r.idcollectioncode = coll.idcollectioncode ';
        $c['join'] = $c['join'].' LEFT JOIN occurrenceelement o ON sp.idoccurrenceelement = o.idoccurrenceelement ';
        $c['join'] = $c['join'].' LEFT JOIN localityelement l ON sp.idlocalityelement = l.idlocalityelement ';
        $c['join'] = $c['join'].' LEFT JOIN taxonomicelement t ON sp.idtaxonomicelement = t.idtaxonomicelement  ';
		$c['join'] = $c['join'].' LEFT JOIN kingdom k ON t.idkingdom = k.idkingdom ';
	    $c['join'] = $c['join'].' LEFT JOIN phylum p ON t.idphylum = p.idphylum ';
	    $c['join'] = $c['join'].' LEFT JOIN class cla ON t.idclass = cla.idclass ';
	    $c['join'] = $c['join'].' LEFT JOIN "order" ord ON t.idorder = ord.idorder ';
	    $c['join'] = $c['join'].' LEFT JOIN family fam ON t.idfamily = fam.idfamily ';
	    $c['join'] = $c['join'].' LEFT JOIN genus gen ON t.idgenus = gen.idgenus ';
	    $c['join'] = $c['join'].' LEFT JOIN subgenus sub ON t.idsubgenus = sub.idsubgenus ';
	    $c['join'] = $c['join'].' LEFT JOIN specificepithet spec ON t.idspecificepithet = spec.idspecificepithet ';
	    $c['join'] = $c['join'].' LEFT JOIN infraspecificepithet ispec ON t.idinfraspecificepithet = ispec.idinfraspecificepithet ';
	    $c['join'] = $c['join'].' LEFT JOIN scientificname scn ON t.idscientificname = scn.idscientificname ';
        $c['where'] = ' WHERE 1 = 1 '.$institutionCodeWhere.$collectionCodeWhere.$scientificNameWhere.$basisOfRecordWhere.$catalogNumberWhere.
                $kingdomWhere.$phylumWhere.$classWhere.$orderWhere.$familyWhere.$genusWhere.$subgenusWhere.$specificEpithetWhere.
                $countryWhere.$stateProvinceWhere.$countyWhere.$municipalityWhere.$localityWhere.$recordedbyWhere.$preparationWhere.$othercatalognumberWhere.$recordnumberWhere;
        $c['orderby'] = ' ORDER BY scn.scientificname, o.catalognumber, sp.idspecimen ';
        $c['limit'] = ' limit '.$filter['limit'];
        $c['offset'] = ' offset '.$filter['offset'];

        
      
        
		$c['where'] =  $c['where'].$groupSQL;
        

        // junta tudo
        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['orderby'].$c['limit'].$c['offset'];
      
       

        // faz consulta e manda para list
        $rs['list'] = WebbeeController::executaSQL($sql);
        // altera parametros de consulta para fazer o Count
        $c['select'] = 'SELECT count(*) ';
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
        // faz consulta do Count e manda para count
        $rs['count'] = WebbeeController::executaSQL($sql);
        return $rs;
    }
    public function search($q) {

        /*
        //Main fields
        $institutionCodeLogic = new InstitutionCodeLogic();
        $institutionCodeList = $institutionCodeLogic->searchList($q);
        $collectionCodeLogic = new CollectionCodeLogic();
        $collectionCodeList = $collectionCodeLogic->search($q);
        $scientificNameLogic = new ScientificNameLogic();
        $scientificNameList = $scientificNameLogic->search($q);
        $basisOfRecordLogic = new BasisOfRecordLogic();
        $basisOfRecordList = $basisOfRecordLogic->search($q);


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
        $specificEpithetList = $specificEpithetLogic->search($q);


        //Locality
        $countryLogic = new CountryLogic();
        $countryList = $countryLogic->search($q);
        $stateProvinceLogic = new StateProvinceLogic();
        $stateProvinceList = $stateProvinceLogic->search($q);
        $countyLogic = new CountyLogic();
        $countyList = $countyLogic->search($q);
        $municipalityLogic = new MunicipalityLogic();
        $municipalityList = $municipalityLogic->search($q);
        $localityLogic = new LocalityLogic();
        $localityList = $localityLogic->search($q);*/


        //Temporary - need to change the Search function, using searchList instead
        //Main fields
        $institutionCodeLogic = new InstitutionCodeLogic();
        $institutionCodeList = $institutionCodeLogic->searchList($q);
        $collectionCodeLogic = new CollectionCodeLogic();
        $collectionCodeList = $collectionCodeLogic->searchList($q);
        $scientificNameLogic = new ScientificNameLogic();
        $scientificNameList = $scientificNameLogic->searchList($q);
        $basisOfRecordLogic = new BasisOfRecordLogic();
        $basisOfRecordList = $basisOfRecordLogic->search($q);
		

        //ocorrence
        $catalogNumberOccurrenceElementLogic = new OccurrenceElementLogic();
        $catalogNumberOccurrenceElementList = $catalogNumberOccurrenceElementLogic->search($q);
        
        
        
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


        //Locality
        $countryLogic = new CountryLogic();
        $countryList = $countryLogic->searchList($q);
        $stateProvinceLogic = new StateProvinceLogic();
        $stateProvinceList = $stateProvinceLogic->searchList($q);
        $countyLogic = new CountyLogic();
        $countyList = $countyLogic->searchList($q);
        $municipalityLogic = new MunicipalityLogic();
        $municipalityList = $municipalityLogic->searchList($q);
        $localityLogic = new LocalityLogic();
        $localityList = $localityLogic->searchList($q);

		
		
        $rs = array();

        //NXN
        
    	///recordedby
    	$return = $this->subSearchNN($q,'recordedby','OccurrenceelementRecordedbyView');
    	if (count($return)>0){
    			
    			$rs[] = array("controller" => "recordedby","id" => $q,"label" => $q, "category" => "Recorded By");
    	}
    	
    	///preparation
    	$return = $this->subSearchNN($q,'preparation','OccurrenceelementPreparationView');
    	if (count($return)>0){
    			
    			$rs[] = array("controller" => "preparation","id" => $q,"label" => $q, "category" => "Preparation ");
    	}
    	
    	
    	  //ocorrence
        $OccurrenceElementLogic = new OccurrenceElementLogic();
        $recordnumberList = $OccurrenceElementLogic->searchRecordnumber($q);
        $othercatalognumber = $OccurrenceElementLogic->searchOthercatalognumber($q);
        
        
        
    	//recordnumber,othercatalognumber 
   		foreach($recordnumberList as $n=>$ar) {
            $rs[] = array("controller" => "recordnumber","id" => $ar->recordnumber,"label" => $ar->recordnumber,"category" => "Record Number");
        }
        
    	foreach($othercatalognumber as $n=>$ar) {
            $rs[] = array("controller" => "othercatalognumber","id" => $ar->othercatalognumber,"label" => $ar->othercatalognumber,"category" => "Other Catalog Number");
        }
        
        
    	
        //Main fields

        foreach($basisOfRecordList as $n=>$ar) {
            $rs[] = array("controller" => "basisofrecord","id" => $ar->idbasisofrecord,"label" => $ar->basisofrecord,"category" => "Basis of record");
        }
        foreach($institutionCodeList as $n=>$ar) {
            $rs[] = array("controller" => "institutioncode","id" => $ar->idinstitutioncode,"label" => $ar->institutioncode,"category" => "Institution code");
        }
        foreach($collectionCodeList as $n=>$ar) {
            $rs[] = array("controller" => "collectioncode","id" => $ar->idcollectioncode,"label" => $ar->collectioncode,"category" => "Collection code");
        }

        //$rs[] = array("controller" => "catalognumber","id" => $q,"label" => $q, "category" => "Catalog Number");

        foreach($catalogNumberOccurrenceElementList as $n=>$ar) {
            $rs[] = array("controller" => "catalognumber","id" => $ar->idoccurrenceelement,"label" => $ar->catalognumber,"category" => "Catalog Number");
        }
        
     	foreach($scientificNameList as $n=>$ar) {
            $rs[] = array("controller" => "scientificname","id" => $ar->idscientificname,"label" => $ar->scientificname,"category" => "Scientific name");
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


        //Locality

        foreach($countryList as $n=>$ar) {
            $rs[] = array("controller" => "country","id" => $ar->idcountry,"label" => $ar->country,"category" => "Country");
        }
        foreach($stateProvinceList as $n=>$ar) {
            $rs[] = array("controller" => "stateprovince","id" => $ar->idstateprovince,"label" => $ar->stateprovince,"category" => "State or province");
        }
        foreach($countyList as $n=>$ar) {
            $rs[] = array("controller" => "county","id" => $ar->idcounty,"label" => $ar->county,"category" => "County");
        }
        foreach($municipalityList as $n=>$ar) {
            $rs[] = array("controller" => "municipality","id" => $ar->idmunicipality,"label" => $ar->municipality,"category" => "Municipality");
        }
        foreach($localityList as $n=>$ar) {
            $rs[] = array("controller" => "locality","id" => $ar->idlocality,"label" => $ar->locality,"category" => "Locality");
        }

       
        

        return $rs;
    }
    public function save($ar) {
    	$ar->idgroup = Yii::app()->user->getGroupId();
        $ar->recordlevelelement->modified=date('Y-m-d G:i:s');
        $ar->eventelement->eventtime = $ar->eventelement->eventtime==''?null:$ar->eventelement->eventtime;
        $gui = $ar->recordlevelelement->institutioncode->institutioncode.':'.$ar->recordlevelelement->collectioncode->collectioncode.':'.$ar->occurrenceelement->catalognumber;
        if($ar->idspecimen==null)
            $ar->recordlevelelement->globaluniqueidentifier = $gui;
        else {
            if($ar->recordlevelelement->globaluniqueidentifier != $gui)
                $ar->recordlevelelement->globaluniqueidentifier = $gui;
            else $ar->recordlevelelement->globaluniqueidentifier = 'temp';
        }
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
        
        $ar->recordlevelelement->idrecordlevelelement = $ar->idrecordlevelelement;
        $ar->occurrenceelement->idoccurrenceelement = $ar->idoccurrenceelement;
        $ar->identificationelement->ididentificationelement = $ar->ididentificationelement;
        $ar->eventelement->ideventelement = $ar->ideventelement;
        $ar->taxonomicelement->idtaxonomicelement = $ar->idtaxonomicelement;
        $ar->localityelement->idlocalityelement = $ar->idlocalityelement;
        $ar->geospatialelement->idgeospatialelement = $ar->idgeospatialelement; 
        
        $highergeograph .= ($ar->localityelement->continent->continent <> "" ? $ar->localityelement->continent->continent.";" : "");
        $highergeograph .= ($ar->localityelement->waterbody->waterbody <> "" ? $ar->localityelement->waterbody->waterbody.";" : "");
        $highergeograph .= ($ar->localityelement->islandgroup->islandgroup <> "" ? $ar->localityelement->islandgroup->islandgroup.";" : "");
        $highergeograph .= ($ar->localityelement->island->island <> "" ? $ar->localityelement->island->island.";" : "");
        $highergeograph .= ($ar->localityelement->country->country <> "" ? $ar->localityelement->country->country.";" : "");
        $highergeograph .= ($ar->localityelement->stateprovince->stateprovince <> "" ? $ar->localityelement->stateprovince->stateprovince.";" : "");
        $highergeograph .= ($ar->localityelement->county->county <> "" ? $ar->localityelement->county->county.";" : "");
        $highergeograph .= ($ar->localityelement->municipality->municipality <> "" ? $ar->localityelement->municipality->municipality.";" : "");
        $highergeograph = preg_replace("/;$/", "", $highergeograph);
        $highergeograph = preg_replace("/^;/", "", $highergeograph);
        $ar->localityelement->highergeograph = $highergeograph;

        $rs = array ();
        if($ar->recordlevelelement->validate()&&$ar->occurrenceelement->validate()&&$ar->curatorialelement->validate()&&$ar->identificationelement->validate()&&$ar->eventelement->validate()&&$ar->geospatialelement->validate()&&$ar->taxonomicelement->validate()) {
            $ar->recordlevelelement->globaluniqueidentifier = $gui;
            $logic = new RecordLevelElementLogic();
            $ar->idrecordlevelelement = $logic->save($ar->recordlevelelement);
            $logic = new OccurrenceElementLogic();
            $ar->idoccurrenceelement = $logic->save($ar->occurrenceelement);
            $logic = new CuratorialElementLogic();
            $ar->idcuratorialelement = $logic->save($ar->curatorialelement);
            $logic = new IdentificationElementLogic();
            $ar->ididentificationelement = $logic->save($ar->identificationelement);
            $logic = new EventElementLogic();
            $ar->ideventelement = $logic->save($ar->eventelement);
            $logic = new TaxonomicElementLogic();
            $ar->idtaxonomicelement = $logic->save($ar->taxonomicelement);
            $logic = new LocalityElementLogic();
            $ar->idlocalityelement = $logic->save($ar->localityelement);
            $logic = new GeospatialElementLogic();
            $ar->idgeospatialelement = $logic->save($ar->geospatialelement);

            $rs['success'] = true;
            $rs['operation'] = $ar->idspecimen == null?'created':'updated';
            $ar->setIsNewRecord($rs['operation']=='created');
            $aux = array();

            //$aux[] = 'Successfully '.$rs['operation'].' specimen record';
            //$aux[] = 'Institution Code: '.$ar->recordlevelelement->institutioncode->institutioncode;
            //$aux[] = 'Collection Code: '.$ar->recordlevelelement->collectioncode->collectioncode;
            //$aux[] = 'Catalog Number: '.$ar->occurrenceelement->catalognumber;
            $aux[] = 'Successfully '.$rs['operation'].' specimen record <br/>Institution Code: '.$ar->recordlevelelement->institutioncode->institutioncode.'<br/>Collection Code: '.$ar->recordlevelelement->collectioncode->collectioncode.'<br/>Catalog Number: '.$ar->occurrenceelement->catalognumber;
            $rs['msg'] = $aux;
            $ar->idspecimen = $ar->getIsNewRecord()?null:$ar->idspecimen;

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
            $ar->recordlevelelement->validate();
            foreach($ar->recordlevelelement->getErrors() as $n=>$mensagem):
                if($mensagem[0]!="") {
                    $erros[] = $mensagem[0];
            }
            endforeach;
            $ar->occurrenceelement->validate();
            foreach($ar->occurrenceelement->getErrors() as $n=>$mensagem):
                if($mensagem[0]!="") {
                    $erros[] = $mensagem[0];
            }
            endforeach;
            $ar->curatorialelement->validate();
            foreach($ar->curatorialelement->getErrors() as $n=>$mensagem):
                if($mensagem[0]!="") {
                    $erros[] = $mensagem[0];
            }
            endforeach;
            $ar->identificationelement->validate();
            foreach($ar->identificationelement->getErrors() as $n=>$mensagem):
                if($mensagem[0]!="") {
                    $erros[] = $mensagem[0];
            }
            endforeach;
            $ar->eventelement->validate();
            foreach($ar->eventelement->getErrors() as $n=>$mensagem):
                if($mensagem[0]!="") {
                    $erros[] = $mensagem[0];
            }
            endforeach;
            $ar->taxonomicelement->validate();
            foreach($ar->taxonomicelement->getErrors() as $n=>$mensagem):
                if($mensagem[0]!="") {
                    $erros[] = $mensagem[0];
            }
            endforeach;
            foreach($ar->localityelement->getErrors() as $n=>$mensagem):
                if($mensagem[0]!="") {
                    $erros[] = $mensagem[0];
            }
            endforeach;
            $ar->geospatialelement->validate();
            foreach($ar->geospatialelement->getErrors() as $n=>$mensagem):
                if($mensagem[0]!="") {
                    $erros[] = $mensagem[0];
            }
            endforeach;
            $rs['success'] = false;
            $rs['msg'] = $erros;
            return $rs;
        }
    }
    
public function deleteProcessReferences($idSP){
    	
    	$ar = ProcessSpecimensExecutionAR::model()->deleteAllByAttributes(
		    array('id_specimen'=>$idSP));
		    
		$logs = Log_dqAR::model()->findAllByAttributes(
		    array('id_specimen'=>$idSP));

		if (is_array($logs)){
		foreach($logs as $l){
			 
		    $ar = Log_dq_fieldsAR::model()->deleteAllByAttributes(
		    array('id_log_dq'=>$l['id']));
			
		}}
		
		$ar = Log_dqAR::model()->deleteAllByAttributes(
		    array('id_specimen'=>$idSP));
		    
		   
           
    }
    
    public function delete($id) {
		
        $this->deleteProcessReferences($id);
        
        $recordlevel = new RecordLevelElementLogic();
        $occurrence = new OccurrenceElementLogic();
        $curatorial = new CuratorialElementLogic();
        $identification = new IdentificationElementLogic();
        $event = new EventElementLogic();
        $taxonomic = new TaxonomicElementLogic();
        $locality = new LocalityElementLogic();
        $geospatial = new GeospatialElementLogic();
        $media = new MediaLogic();
        $reference = new ReferenceLogic();

        $media->deleteSpecimen($id);
        $reference->deleteSpecimen($id);

        $ar = SpecimenAR::model();
        $ar->idspecimen = $id;
        $ar = $this->getSpecimen($ar);
        $l = new InteractionLogic();
        $l->deleteSpecimenRecord($id);
        $ar->delete();
        $recordlevel->delete($ar->idrecordlevelelement);
        $occurrence->delete($ar->idoccurrenceelement);
        $curatorial->delete($ar->idcuratorialelement);
        $identification->delete($ar->ididentificationelement);
        $event->delete($ar->ideventelement);
        $taxonomic->delete($ar->idtaxonomicelement);
        $locality->delete($ar->idlocalityelement);
        $geospatial->delete($ar->idgeospatialelement);
    }
    public function getSpecimen($ar) {
        return $this->fillDependency($ar->findByPk($ar->idspecimen));
    }
    public function fillDependency($ar) {        
        if($ar->recordlevelelement==null)
            $ar->recordlevelelement = new RecordLevelElementAR();
        if($ar->occurrenceelement==null)
            $ar->occurrenceelement = new OccurrenceElementAR();
        if($ar->taxonomicelement==null)
            $ar->taxonomicelement = new TaxonomicElementAR();
        if($ar->curatorialelement==null)
            $ar->curatorialelement = new CuratorialElementAR();
        if($ar->identificationelement==null)
            $ar->identificationelement = new IdentificationElementAR();
        if($ar->eventelement==null)
            $ar->eventelement = new EventElementAR();
        if($ar->geospatialelement==null)
            $ar->geospatialelement = new GeospatialElementAR();
        if($ar->localityelement==null)
            $ar->localityelement = new LocalityElementAR();

        $l = new RecordLevelElementLogic();
        $ar->recordlevelelement = $l->fillDependency($ar->recordlevelelement);
        $l = new OccurrenceElementLogic();
        $ar->occurrenceelement = $l->fillDependency($ar->occurrenceelement);
        $l = new TaxonomicElementLogic();
        $ar->taxonomicelement = $l->fillDependency($ar->taxonomicelement);
        $l = new CuratorialElementLogic();
        $ar->curatorialelement = $l->fillDependency($ar->curatorialelement);
        $l = new IdentificationElementLogic();
        $ar->identificationelement = $l->fillDependency($ar->identificationelement);
        $l = new EventElementLogic();
        $ar->eventelement = $l->fillDependency($ar->eventelement);
        $l = new LocalityElementLogic();
        $ar->localityelement = $l->fillDependency($ar->localityelement);
        $l = new GeospatialElementLogic();
        $ar->geospatialelement = $l->fillDependency($ar->geospatialelement);

        return $ar;
    }

    public function getMedia($filter) {
        $c = array();
        $rs = array();

        // parametros da consulta
        $c['select'] = 'SELECT media.idmedia, media.title, file.path, file.filesystemname, cm.categorymedia, scm.subcategorymedia ';
        $c['from'] = ' FROM specimenmedia spmedia ';
        $c['join'] = $c['join'].' LEFT JOIN media ON spmedia.idmedia = media.idmedia ';
        $c['join'] = $c['join'].' LEFT JOIN file ON media.idfile = file.idfile ';
        $c['join'] = $c['join'].' LEFT JOIN categorymedia cm ON media.idcategorymedia = cm.idcategorymedia ';
        $c['join'] = $c['join'].' LEFT JOIN subcategorymedia scm ON media.idsubcategorymedia = scm.idsubcategorymedia ';
        $c['where'] = ' WHERE spmedia.idspecimen ='.$filter['idspecimen'];

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
        $c['from'] = ' FROM specimenmedia spmedia ';
        $c['where'] = ' WHERE spmedia.idspecimen ='.$filter['idspecimen'].' and spmedia.idmedia ='.$filter['idmedia'];

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
        $c['from'] = ' FROM specimenreference spref ';
        $c['join'] = $c['join'].' LEFT JOIN referenceelement ref ON spref.idreferenceelement = ref.idreferenceelement ';
        $c['join'] = $c['join'].' LEFT JOIN typereference tr ON ref.idtypereference = tr.idtypereference ';
        $c['where'] = ' WHERE spref.idspecimen ='.$filter['idspecimen'];

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
        $c['from'] = ' FROM specimenreference spref ';
        $c['where'] = ' WHERE spref.idspecimen ='.$filter['idspecimen'].' and spref.idreferenceelement ='.$filter['idreference'];

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

    public function getSpecimenByGUI($gui) {
        //retorna AR com o gui especificado ou, caso nao exista, AR vazio (nao retorna NULL!)
        $sql = 'SELECT idspecimen, sp.idrecordlevelelement, idoccurrenceelement, idtaxonomicelement, idcuratorialelement, ididentificationelement, ideventelement, idgeospatialelement, idlocalityelement FROM specimen AS sp LEFT JOIN recordlevelelement r ON sp.idrecordlevelelement = r.idrecordlevelelement WHERE UPPER(r.globaluniqueidentifier) = UPPER(\''.$gui.'\')';
        $rs = WebbeeController::executaSQL($sql);
        /*$criteria = new CDbCriteria();
        $criteria->join = 'LEFT JOIN recordlevelelement ON t.idrecordlevelelement = recordlevelelement.idrecordlevelelement';
        $criteria->condition = 'recordlevelelement.globaluniqueidentifier = \''.$gui.'\'';
        $ar = SpecimenAR::model()->find($criteria);*/
        if ($rs[0] == null) {
            $ar = null;
            /*$ar = new SpecimenAR();

            //var_dump($ar->recordlevelelement->globaluniqueidentifier.' = '.$gui.' rs[0] = ');
            //var_dump($rs[0]);
            $ar = $ar::model();
            var_dump($ar->recordlevelelement->globaluniqueidentifier.', idrecordlevel = '.$ar->idrecordlevelelement.', idspecimen = '.$ar->idspecimen.'<\n>');
            $ar = $this->fillDependency($ar);*/
        } else {
            $ar = new SpecimenAR();
            $ar->idspecimen = $rs[0]['idspecimen'];
            $ar->idrecordlevelelement = $rs[0]['idrecordlevelelement'];
            $ar->idoccurrenceelement = $rs[0]['idoccurrenceelement'];
            $ar->idtaxonomicelement = $rs[0]['idtaxonomicelement'];
            $ar->ididentificationelement = $rs[0]['ididentificationelement'];
            $ar->ideventelement = $rs[0]['ideventelement'];
            $ar->idgeospatialelement = $rs[0]['idgeospatialelement'];
            $ar->idlocalityelement = $rs[0]['idlocalityelement'];
            $ar->idcuratorialelement = $rs[0]['idcuratorialelement'];
            //$ar->setAttributes($rs[0]);
            $ar = $this->getSpecimen($ar);
        }
        return $ar;
    }
    public function deleteMedia($idmedia) {
        $ar = SpecimenMediaAR::model();
        $arList = $ar->findAll(" idmedia=$idmedia ");
        foreach ($arList as $n=>$ar)
            $ar->delete();
    }
    public function deleteReference($idreference) {
        $ar = SpecimenReferenceAR::model();
        $arList = $ar->findAll(" idreferenceelement=$idreference ");
        foreach ($arList as $n=>$ar)
            $ar->delete();
    }
    public function getTip($filter)
    {
        $c = array();
        $rs = array();

        // parametros da consulta
        $c['select'] = 'SELECT inst.institutioncode, coll.collectioncode ';
        $c['from'] = ' FROM specimen sp ';
        $c['join'] = $c['join'].' LEFT JOIN recordlevelelement r ON sp.idrecordlevelelement = r.idrecordlevelelement ';
        $c['join'] = $c['join'].' LEFT JOIN institutioncode inst ON r.idinstitutioncode = inst.idinstitutioncode ';
        $c['join'] = $c['join'].' LEFT JOIN collectioncode coll ON r.idcollectioncode = coll.idcollectioncode ';
        $c['where'] = ' WHERE sp.idspecimen = '.$filter['idspecimen'];

        // junta tudo
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
        // faz consulta e manda para list
        $rs = WebbeeController::executaSQL($sql);

        return $rs;
    }
}


?>
