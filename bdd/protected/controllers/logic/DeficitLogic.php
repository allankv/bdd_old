<?php
include 'CommonNameFocalCropLogic.php';
include 'LocalityElementLogic.php';
include 'GeospatialElementLogic.php';

include 'CountryLogic.php';
include 'StateProvinceLogic.php';
include 'CountyLogic.php';
include 'MunicipalityLogic.php';
include 'LocalityLogic.php';
include 'Site_Logic.php';

include_once 'ScientificNameLogic.php';

class DeficitLogic {
    public function filter($filter) {
        $c = array();
        $rs = array();
        
        // where de cada entidade com OR entre
        $fieldNumberWhere = '';
        $commonNameFocalCropWhere = '';
        
        $countryWhere = '';
        $stateProvinceWhere = '';
        $countyWhere = '';
        $municipalityWhere = '';
        $localityWhere = '';
        $siteWhere = '';
        
        $scientificNameWhere = '';

        if($filter['list']!=null) {
            foreach ($filter['list'] as &$v) {
                if($v['controller']=='fieldnumber') {
                    $fieldNumberWhere = $fieldNumberWhere==''?'':$fieldNumberWhere.' OR ';
                    $fieldNumberWhere = $fieldNumberWhere.' d.fieldnumber ilike \'%'.$v['id'].'%\''.' OR difference(d.fieldnumber, \''.$v['id'].'\') > 3';
                }
                if($v['controller']=='commonnamefocalcrop') {
                    $commonNameFocalCropWhere = $commonNameFocalCropWhere==''?'':$commonNameFocalCropWhere.' OR ';
                    $commonNameFocalCropWhere = $commonNameFocalCropWhere.' d.idcommonnamefocalcrop = '.$v['id'];
                }
                
                if($v['controller']=='country') {
                    $countryWhere = $countryWhere==''?'':$countryWhere.' OR ';
                    $countryWhere = $countryWhere.' loc.idcountry = '.$v['id'];
                }
                if($v['controller']=='stateprovince') {
                    $stateProvinceWhere = $stateProvinceWhere==''?'':$stateProvinceWhere.' OR ';
                    $stateProvinceWhere = $stateProvinceWhere.' loc.idstateprovince = '.$v['id'];
                }
                if($v['controller']=='county') {
                    $countyWhere = $countyWhere==''?'':$countyWhere.' OR ';
                    $countyWhere = $countyWhere.' loc.idcounty = '.$v['id'];
                }
                if($v['controller']=='municipality') {
                    $municipalityWhere = $municipalityWhere==''?'':$municipalityWhere.' OR ';
                    $municipalityWhere = $municipalityWhere.' loc.idmunicipality = '.$v['id'];
                }
                if($v['controller']=='locality') {
                    $localityWhere = $localityWhere==''?'':$localityWhere.' OR ';
                    $localityWhere = $localityWhere.' loc.idlocality = '.$v['id'];
                }
                if($v['controller']=='site_') {
                    $siteWhere = $siteWhere==''?'':$siteWhere.' OR ';
                    $siteWhere = $siteWhere.' loc.idsite_ = '.$v['id'];
                }
                if($v['controller']=='scientificname') {
                    $scientificNameWhere = $scientificNameWhere==''?'':$scientificNameWhere.' OR ';
                    $scientificNameWhere = $scientificNameWhere.' d.idscientificname = '.$v['id'];
                }
                
                
            }
        }
               // se o where de cada entidades nao estiver vazias, coloca AND antes
        $fieldNumberWhere = $fieldNumberWhere!=''?' AND ('.$fieldNumberWhere.') ':'';
        $commonNameFocalCropWhere = $commonNameFocalCropWhere!=''?' AND ('.$commonNameFocalCropWhere.') ':'';
        
        $countryWhere = $countryWhere!=''?' AND ('.$countryWhere.') ':'';
        $stateProvinceWhere = $stateProvinceWhere!=''?' AND ('.$stateProvinceWhere.') ':'';
        $countyWhere = $countyWhere!=''?' AND ('.$countyWhere.') ':'';
        $municipalityWhere = $municipalityWhere!=''?' AND ('.$municipalityWhere.') ':'';
        $localityWhere = $localityWhere!=''?' AND ('.$localityWhere.') ':'';
        $siteWhere = $siteWhere!=''?' AND ('.$siteWhere.') ':'';
        
        $scientificNameWhere = $scientificNameWhere!=''?' AND ('.$scientificNameWhere.') ':'';

        // parametros da consulta
        //$c['select'] = 'SELECT distinct ON (ref.iddeficitelement) ref.iddeficitelement, ref.isrestricted, ref.title, ref.source, cr.categorydeficit, typedeficit.typedeficit, creator.creator, scr.subcategorydeficit, file.filesystemname, file.path ';
        //$c['from'] = ' FROM deficitelement as ref ';
        //$c['select'] = 'SELECT distinct ON (refview.iddeficitelement) *';
        $c['select'] = 'SELECT * ';
        $c['from'] = ' FROM deficit as d ';
        $c['join'] = $c['join'].' LEFT JOIN commonnamefocalcrop cn ON d.idcommonnamefocalcrop = cn.idcommonnamefocalcrop ';
        $c['join'] = $c['join'].' LEFT JOIN localityelement loc ON d.idlocalityelement = loc.idlocalityelement ';
        $c['join'] = $c['join'].' LEFT JOIN country c ON loc.idcountry = c.idcountry ';
        $c['join'] = $c['join'].' LEFT JOIN stateprovince sp ON loc.idstateprovince = sp.idstateprovince ';
        $c['join'] = $c['join'].' LEFT JOIN county cy ON loc.idcounty = cy.idcounty ';
        $c['join'] = $c['join'].' LEFT JOIN municipality m ON loc.idmunicipality = m.idmunicipality ';
        $c['join'] = $c['join'].' LEFT JOIN locality l ON loc.idlocality = l.idlocality ';
        $c['join'] = $c['join'].' LEFT JOIN site_ s ON loc.idsite_ = s.idsite_ ';
        $c['join'] = $c['join'].' LEFT JOIN scientificname scn ON d.idscientificname = scn.idscientificname ';

        $c['where'] = ' WHERE 1 = 1 '.$fieldNumberWhere.$commonNameFocalCropWhere.$countryWhere.$stateProvinceWhere.$countyWhere.$municipalityWhere.$localityWhere.$siteWhere.$scientificNameWhere;
        
        $idGroup = Yii::app()->user->getGroupId();
		
    	if ($idGroup!=2){
        	 $groupSQL = ' AND (idgroup='.$idGroup.') ';
        }
        
		$c['where'] =  $c['where'].$groupSQL;
		
        $c['orderby'] = ' ORDER BY d.fieldnumber ';
        $c['limit'] = ' limit '.$filter['limit'];
        $c['offset'] = ' offset '.$filter['offset'];
        // junta tudo
        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['orderby'].$c['limit'].$c['offset'];
        // faz consulta e manda para list
        //echo
// die($sql);       
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
    public function search($q) {


        /*$commonNameFocalCropLogic = new CommonNameFocalCropLogic();
        $commonNameFocalCropList = $commonNameFocalCropLogic->search($q);
        
        $countryLogic = new CountryLogic();
        $countryList = $countryLogic->search($q);
        $stateProvinceLogic = new StateProvinceLogic();
        $stateProvinceList = $stateProvinceLogic->search($q);
        $countyLogic = new CountyLogic();
        $countyList = $countyLogic->search($q);
        $municipalityLogic = new MunicipalityLogic();
        $municipalityList = $municipalityLogic->search($q);
        $localityLogic = new LocalityLogic();
        $localityList = $localityLogic->search($q);
        $siteLogic = new Site_Logic();
        $siteList = $siteLogic->search($q);
        
        $scientificNameLogic = new ScientificNameLogic();
        $scientificNameList = $scientificNameLogic->search($q);*/


        //Temporary - change search function - using searchList for now
        $commonNameFocalCropLogic = new CommonNameFocalCropLogic();
        $commonNameFocalCropList = $commonNameFocalCropLogic->searchList($q);

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
        $siteLogic = new Site_Logic();
        $siteList = $siteLogic->searchList($q);

        $scientificNameLogic = new ScientificNameLogic();
        $scientificNameList = $scientificNameLogic->searchList($q);
        
        $rs = array();
        
        $rs[] = array("controller" => "fieldnumber","id" => $q,"label" => $q, "category" => "Field Number");
        
        foreach($commonNameFocalCropList as $n=>$ar) {
            $rs[] = array("controller" => "commonnamefocalcrop","id" => $ar->idcommonnamefocalcrop,"label" => $ar->commonnamefocalcrop,"category" => "Common name of focal crop");
        }
		
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
        foreach($siteList as $n=>$ar) {
            $rs[] = array("controller" => "site_","id" => $ar->idsite_,"label" => $ar->site_,"category" => "Site");
        }
        
        foreach($scientificNameList as $n=>$ar) {
            $rs[] = array("controller" => "scientificname","id" => $ar->idscientificname,"label" => $ar->scientificname,"category" => "Scientific name");
        }
  
        return $rs;
    }
    public function save($ar) {
        ///$ar->modified=date('Y-m-d G:i:s');
        $ar->idgroup = Yii::app()->user->getGroupId();
        $ar->date = $ar->date==''?null:$ar->date;
        $ar->timeatstart = $ar->timeatstart==''?null:$ar->timeatstart;
        $ar->plantingdate = $ar->plantingdate==''?null:$ar->plantingdate;
        $ar->fieldnumber = $ar->fieldnumber==''?null:$ar->fieldnumber;        
        $ar->year = $ar->year==''?null:$ar->year;
        $ar->recordingnumber = $ar->recordingnumber==''?null:$ar->recordingnumber;
        $ar->plotnumber = $ar->plotnumber==''?null:$ar->plotnumber;
        $ar->numberflowersobserved = $ar->numberflowersobserved==''?null:$ar->numberflowersobserved;
        $ar->apismellifera = $ar->apismellifera==''?null:$ar->apismellifera;
        $ar->bumblebees = $ar->bumblebees==''?null:$ar->bumblebees;
        $ar->otherbees = $ar->otherbees==''?null:$ar->otherbees;
        $ar->other = $ar->other==''?null:$ar->other;
        $ar->distancebetweenrows = $ar->distancebetweenrows==''?null:$ar->distancebetweenrows;
        $ar->distanceamongplantswithinrows = $ar->distanceamongplantswithinrows==''?null:$ar->distanceamongplantswithinrows;
        
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
        if($ar->validate() &&         
        $ar->geospatialelement->validate() && 
        $ar->localityelement->validate() ) {
        	
        	$logic = new LocalityElementLogic();
            $ar->idlocalityelement = $logic->save($ar->localityelement);
            $logic = new GeospatialElementLogic();
            $ar->idgeospatialelement = $logic->save($ar->geospatialelement);
        
            $rs['success'] = true;
            $rs['operation'] = $ar->iddeficit == null?'created':'updated';
            $ar->setIsNewRecord($rs['operation']=='created');
            $aux = array();
            $aux[] = 'Successfully '.$rs['operation'].' deficit record with field number <b>'.$ar->fieldnumber.' </b> ';
            $rs['msg'] = $aux;
            $ar->iddeficit = $ar->getIsNewRecord()?null:$ar->iddeficit;
            $ar->save();
            $rs['id'] = $ar->iddeficit;
            return $rs;
        }
        else {
            $erros = array();
            foreach($ar->getErrors() as $n=>$mensagem):
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
    public function delete($id) {
    	$locality = new LocalityElementLogic();
        $geospatial = new GeospatialElementLogic();
    
        $ar = DeficitAR::model();
        $ar = $ar->findByPk($id);
        $ar->delete();
        $locality->delete($ar->idlocalityelement);
        $geospatial->delete($ar->idgeospatialelement);
    }
    public function fillDependency($ar) {
        if($ar->commonnamefocalcrop==null)
            $ar->commonnamefocalcrop = CommonNameFocalCropAR::model();
        if($ar->localityelement==null)
            $ar->localityelement = LocalityElementAR::model();
        if($ar->geospatialelement==null)
            $ar->geospatialelement = GeospatialElementAR::model();
        if($ar->typeholding==null)
            $ar->typeholding = TypeHoldingAR::model();
        if($ar->topograficalsituation==null)
            $ar->topograficalsituation = TopograficalSituationAR::model();
         if($ar->soiltype==null)
            $ar->soiltype = SoilTypeAR::model();
         if($ar->soilpreparation==null)
            $ar->soilpreparation = SoilPreparationAR::model();
         if($ar->mainplantspeciesinhedge==null)
            $ar->mainplantspeciesinhedge = MainPlantSpeciesInHedgeAR::model();
         if($ar->scientificname==null)
            $ar->scientificname = ScientificNameAR::model();
         if($ar->productionvariety==null)
            $ar->productionvariety = ProductionVarietyAR::model();
         if($ar->originseeds==null)
            $ar->originseeds = OriginSeedsAR::model();
         if($ar->typeplanting==null)
            $ar->typeplanting = TypePlantingAR::model();
         if($ar->typestand==null)
            $ar->typestand = TypeStandAR::model();
         if($ar->focuscrop==null)
            $ar->focuscrop = FocusCropAR::model();
         if($ar->treatment==null)
            $ar->treatment = TreatmentAR::model();
         if($ar->observer==null)
            $ar->observer = ObserverAR::model();
         if($ar->weathercondition==null)
            $ar->weathercondition = WeatherConditionAR::model();
          
          $l = new LocalityElementLogic();
          $ar->localityelement = $l->fillDependency($ar->localityelement);
          $l = new GeospatialElementLogic();
          $ar->geospatialelement = $l->fillDependency($ar->geospatialelement);

          return $ar;
    }
    public function getTip($filter)
    {
        $c = array();
        $rs = array();

        // parametros da consulta
        $c['select'] = 'SELECT * ';
        $c['from'] = ' FROM deficit d ';
        $c['join'] = $c['join'].' LEFT JOIN commonnamefocalcrop cn ON d.idcommonnamefocalcrop = cn.idcommonnamefocalcrop ';
        $c['join'] = $c['join'].' LEFT JOIN localityelement loc ON d.idlocalityelement = loc.idlocalityelement ';
        $c['join'] = $c['join'].' LEFT JOIN country c ON loc.idcountry = c.idcountry ';
        $c['join'] = $c['join'].' LEFT JOIN stateprovince sp ON loc.idstateprovince = sp.idstateprovince ';
        $c['join'] = $c['join'].' LEFT JOIN county cy ON loc.idcounty = cy.idcounty ';
        $c['join'] = $c['join'].' LEFT JOIN municipality m ON loc.idmunicipality = m.idmunicipality ';
        $c['join'] = $c['join'].' LEFT JOIN locality l ON loc.idlocality = l.idlocality ';
        $c['join'] = $c['join'].' LEFT JOIN site_ s ON loc.idsite_ = s.idsite_ ';
        $c['join'] = $c['join'].' LEFT JOIN scientificname scn ON d.idscientificname = scn.idscientificname ';

        $c['where'] = ' WHERE d.iddeficit = '.$filter['iddeficit'];
        // junta tudo
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];

        $rs = WebbeeController::executaSQL($sql);

        return $rs;
    }
}
?>
