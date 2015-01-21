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

include 'CountryLogic.php';
include 'StateProvinceLogic.php';
include 'CountyLogic.php';
include 'MunicipalityLogic.php';
include 'LocalityLogic.php';

include 'RecordLevelElementLogic.php';
include 'OccurrenceElementLogic.php';
include_once 'TaxonomicElementLogic.php';
include 'LocalityElementLogic.php';
include 'GeospatialElementLogic.php';

include_once 'DenominationLogic.php';
include_once 'CultureLogic.php';
include_once 'TechnicalCollectionLogic.php';


class MonitoringLogic {
    public function fillDependency($ar) {
        if($ar->recordlevelelement==null)
            $ar->recordlevelelement = new RecordLevelElementAR();
        if($ar->occurrenceelement==null)
            $ar->occurrenceelement = new OccurrenceElementAR();
        if($ar->taxonomicelement==null)
            $ar->taxonomicelement = new TaxonomicElementAR();
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
        $l = new LocalityElementLogic();
        $ar->localityelement = $l->fillDependency($ar->localityelement);
        $l = new GeospatialElementLogic();
        $ar->geospatialelement = $l->fillDependency($ar->geospatialelement);

        if($ar->denomination==null) {
            $ar->denomination = DenominationAR::model();
        }
        if($ar->technicalcollection==null) {
            $ar->technicalcollection = TechnicalCollectionAR::model();
        }
        if($ar->digitizer==null) {
            $ar->digitizer = DigitizerAR::model();
        }
        if($ar->culture==null) {
            $ar->culture = CultureAR::model();
        }
        if($ar->cultivar==null) {
            $ar->cultivar = CultivarAR::model();
        }
        if($ar->predominantbiome==null) {
            $ar->predominantbiome = PredominantBiomeAR::model();
        }
        if($ar->surroundingsculture==null) {
            $ar->surroundingsculture = SurroundingsCultureAR::model();
        }
        if($ar->surroundingsvegetation==null) {
            $ar->surroundingsvegetation = SurroundingsVegetationAR::model();
        }
        if($ar->colorpantrap==null) {
            $ar->colorpantrap = ColorPanTrapAR::model();
        }
        if($ar->supporttype==null) {
            $ar->supporttype = SupportTypeAR::model();
        }
        if($ar->collector==null) {
            $ar->collector = CollectorAR::model();
        }
        return $ar;
    }
    public function save($ar) {
        $ar->recordlevelelement->modified=date('Y-m-d G:i:s');
        $ar->idgroup = Yii::app()->user->getGroupId();
        $gui = $ar->recordlevelelement->institutioncode->institutioncode.':'.$ar->recordlevelelement->collectioncode->collectioncode.':'.$ar->occurrenceelement->catalognumber;
        if($ar->idmonitoring==null)
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
        
        $ar->installationdate = $ar->installationdate==''?null:$ar->installationdate;
        $ar->collectdate = $ar->collectdate==''?null:$ar->collectdate;
        $ar->collecttime = $ar->collecttime==''?null:$ar->collecttime;
        $ar->installationtime = $ar->installationtime==''?null:$ar->installationtime;  
        
        $ar->plotnumber = $ar->plotnumber==''?null:$ar->plotnumber;         
        $ar->amostralnumber = $ar->amostralnumber==''?null:$ar->amostralnumber;         
        $ar->floorheight = $ar->floorheight==''?null:$ar->floorheight;         

        $ar->weight = $ar->weight==''?null:$ar->weight;
        $ar->width = $ar->width==''?null:$ar->width;         
        $ar->length = $ar->length==''?null:$ar->length;         
        $ar->height = $ar->height==''?null:$ar->height;         
        
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
        if($ar->recordlevelelement->validate()&&$ar->occurrenceelement->validate()&&$ar->geospatialelement->validate()&&$ar->taxonomicelement->validate()) {
            $ar->recordlevelelement->globaluniqueidentifier = $gui;
            $logic = new RecordLevelElementLogic();
            $ar->idrecordlevelelement = $logic->save($ar->recordlevelelement);
            $logic = new OccurrenceElementLogic();
            $ar->idoccurrenceelement = $logic->save($ar->occurrenceelement);
            $logic = new TaxonomicElementLogic();
            $ar->idtaxonomicelement = $logic->save($ar->taxonomicelement);
            $logic = new LocalityElementLogic();
            $ar->idlocalityelement = $logic->save($ar->localityelement);
            $logic = new GeospatialElementLogic();
            $ar->idgeospatialelement = $logic->save($ar->geospatialelement);
            
            $rs['success'] = true;
            $rs['operation'] = $ar->idmonitoring == null?'created':'updated';
            $ar->setIsNewRecord($rs['operation']=='created');
            $aux = array();

            //$aux[] = 'Successfully '.$rs['operation'].' specimen record';
            //$aux[] = 'Institution Code: '.$ar->recordlevelelement->institutioncode->institutioncode;
            //$aux[] = 'Collection Code: '.$ar->recordlevelelement->collectioncode->collectioncode;
            //$aux[] = 'Catalog Number: '.$ar->occurrenceelement->catalognumber;
            $aux[] = 'Successfully '.$rs['operation'].' specimen record <br/>Institution Code: '.$ar->recordlevelelement->institutioncode->institutioncode.'<br/>Collection Code: '.$ar->recordlevelelement->collectioncode->collectioncode.'<br/>Catalog Number: '.$ar->occurrenceelement->catalognumber;
            $rs['msg'] = $aux;
            $ar->idmonitoring = $ar->getIsNewRecord()?null:$ar->idmonitoring;

            $ar->save();

            $rs['ar'] = $ar;
            return $rs;
        }else {
            $erros = array ();
            
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
    public function delete($id) {
        $recordlevel = new RecordLevelElementLogic();
        $occurrence = new OccurrenceElementLogic();
        $taxonomic = new TaxonomicElementLogic();
        $locality = new LocalityElementLogic();
        $geospatial = new GeospatialElementLogic();

        $ar = MonitoringAR::model();
        $ar->idmonitoring = $id;
        $ar = $this->getMonitoring($ar);
        $ar->delete();
        $recordlevel->delete($ar->idrecordlevelelement);
        $occurrence->delete($ar->idoccurrenceelement);
        $taxonomic->delete($ar->idtaxonomicelement);
        $locality->delete($ar->idlocalityelement);
        $geospatial->delete($ar->idgeospatialelement);
    }
    public function getMonitoring($ar) {
        return $this->fillDependency($ar->findByPk($ar->idmonitoring));
    }
    public function setAttributes($p) {
        $ar = MonitoringAR::model();
        $p['idmonitoring']=$p['idmonitoring']==''?null:$p['idmonitoring'];
        $p['installationdate']=$p['installationdate']==''?null:$p['installationdate'];
        $p['collectdate']=$p['collectdate']==''?null:$p['collectdate'];
        $p['collecttime']=$p['collecttime']==''?null:$p['collecttime'];
        $p['plotnumber']=$p['plotnumber']==''?null:$p['plotnumber'];
        $p['amostralnumber']=$p['amostralnumber']==''?null:$p['amostralnumber'];
        $p['floorheight']=$p['floorheight']==''?null:$p['floorheight'];
        $p['weight']=$p['weight']==''?null:$p['weight'];
        $p['width']=$p['width']==''?null:$p['width'];
        $p['length']=$p['length']==''?null:$p['length'];
        $p['height']=$p['height']==''?null:$p['height'];
        $p['iddenomination']=$p['iddenomination']==''?null:$p['iddenomination'];
        $p['idtechnicalcollection']=$p['idtechnicalcollection']==''?null:$p['idtechnicalcollection'];
        $p['iddigitizer']=$p['iddigitizer']==''?null:$p['iddigitizer'];
        $p['idculture']=$p['idculture']==''?null:$p['idculture'];
        $p['idcultivar']=$p['idcultivar']==''?null:$p['idcultivar'];
        $p['idpredominantbiome']=$p['idpredominantbiome']==''?null:$p['idpredominantbiome'];
        $p['idsurroundingsculture']=$p['idsurroundingsculture']==''?null:$p['idsurroundingsculture'];
        $p['idcolorpantrap']=$p['idcolorpantrap']==''?null:$p['idcolorpantrap'];
        $p['idsupporttype']=$p['idsupporttype']==''?null:$p['idsupporttype'];
        $p['idcollector']=$p['idcollector']==''?null:$p['idcollector'];
        $ar->setAttributes($p,false);
        return $this->fillDependency($ar);
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
        
        $denominationWhere = '';
        $cultureWhere = '';
        $technicalCollectionWhere = '';

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
                    $catalogNumberWhere = $catalogNumberWhere.' o.catalognumber ilike \'%'.$v['id'].'%\''.' OR difference(o.catalognumber, \''.$v['id'].'\') > 3';
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
                
                if($v['controller']=='denomination') {
                    $denominationWhere = $denominationWhere==''?'':$denominationWhere.' OR ';
                    $denominationWhere = $denominationWhere.' mon.iddenomination = '.$v['id'];
                }
                if($v['controller']=='culture') {
                    $cultureWhere = $cultureWhere==''?'':$cultureWhere.' OR ';
                    $cultureWhere = $cultureWhere.' mon.idculture = '.$v['id'];
                }
                if($v['controller']=='technicalcollection') {
                    $technicalCollectionWhere = $technicalCollectionWhere==''?'':$technicalCollectionWhere.' OR ';
                    $technicalCollectionWhere = $technicalCollectionWhere.' mon.idtechnicalcollection = '.$v['id'];
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
        
        $denominationWhere = $denominationWhere!=''?' AND ('.$denominationWhere.') ':'';
        $cultureWhere = $cultureWhere!=''?' AND ('.$cultureWhere.') ':'';
        $technicalCollectionWhere = $technicalCollectionWhere!=''?' AND ('.$technicalCollectionWhere.') ':'';

        // parametros da consulta
        $c['select'] = 'SELECT r.isrestricted, mon.idmonitoring, scn.scientificname, o.catalognumber, inst.institutioncode, coll.collectioncode, den.denomination, cul.culture, tech.technicalcollection, mor.morphospecies ';
        $c['from'] = ' FROM monitoring mon ';
        $c['join'] = $c['join'].' LEFT JOIN recordlevelelement r ON mon.idrecordlevelelement = r.idrecordlevelelement ';
        $c['join'] = $c['join'].' LEFT JOIN basisofrecord b ON r.idbasisofrecord = b.idbasisofrecord ';
        $c['join'] = $c['join'].' LEFT JOIN institutioncode inst ON r.idinstitutioncode = inst.idinstitutioncode ';
        $c['join'] = $c['join'].' LEFT JOIN collectioncode coll ON r.idcollectioncode = coll.idcollectioncode ';
        $c['join'] = $c['join'].' LEFT JOIN occurrenceelement o ON mon.idoccurrenceelement = o.idoccurrenceelement ';
        $c['join'] = $c['join'].' LEFT JOIN localityelement l ON mon.idlocalityelement = l.idlocalityelement ';
        $c['join'] = $c['join'].' LEFT JOIN taxonomicelement t ON mon.idtaxonomicelement = t.idtaxonomicelement  ';
        $c['join'] = $c['join'].' LEFT JOIN scientificname scn ON t.idscientificname = scn.idscientificname  ';
        $c['join'] = $c['join'].' LEFT JOIN denomination den ON mon.iddenomination = den.iddenomination  ';
        $c['join'] = $c['join'].' LEFT JOIN culture cul ON mon.idculture = cul.idculture  ';
        $c['join'] = $c['join'].' LEFT JOIN technicalcollection tech ON mon.idtechnicalcollection = tech.idtechnicalcollection  ';
        $c['join'] = $c['join'].' LEFT JOIN morphospecies mor ON mor.idmorphospecies = t.idmorphospecies  ';

        $idGroup = Yii::app()->user->getGroupId();
        
   		if ($idGroup!=2){
        	 $groupSQL = ' AND (mon.idgroup='.$idGroup.') ';
        }
        
		
		
        $c['where'] = ' WHERE 1 = 1 '.$institutionCodeWhere.$collectionCodeWhere.$scientificNameWhere.$basisOfRecordWhere.$catalogNumberWhere.
                $kingdomWhere.$phylumWhere.$classWhere.$orderWhere.$familyWhere.$genusWhere.$subgenusWhere.$specificEpithetWhere.
                $countryWhere.$stateProvinceWhere.$countyWhere.$municipalityWhere.$localityWhere.$denominationWhere.$cultureWhere.$technicalCollectionWhere.$groupSQL;
        $c['orderby'] = ' ORDER BY scn.scientificname, o.catalognumber, mon.idmonitoring ';
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
    public function search($q) {
        
        /*
        //Main fields
        $institutionCodeLogic = new InstitutionCodeLogic();
        $institutionCodeList = $institutionCodeLogic->search($q);
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

        //Temporary - change search function - using searchList for now
        //Main fields
        $institutionCodeLogic = new InstitutionCodeLogic();
        $institutionCodeList = $institutionCodeLogic->searchList($q);
        $collectionCodeLogic = new CollectionCodeLogic();
        $collectionCodeList = $collectionCodeLogic->searchList($q);
        $scientificNameLogic = new ScientificNameLogic();
        $scientificNameList = $scientificNameLogic->searchList($q);
        $basisOfRecordLogic = new BasisOfRecordLogic();
        $basisOfRecordList = $basisOfRecordLogic->search($q);
        
        $denominationLogic = new DenominationLogic();
        $denominationList = $denominationLogic->searchList($q);
        $cultureLogic = new CultureLogic();
        $cultureList = $cultureLogic->searchList($q);
        $technicalCollectionLogic = new TechnicalCollectionLogic();
        $technicalCollectionList = $technicalCollectionLogic->searchList($q);


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

        //Main fields

        foreach($basisOfRecordList as $n=>$ar) {
            $rs[] = array("controller" => "basisofrecord","id" => $ar->idbasisofrecord,"label" => $ar->basisofrecord,"category" => "Base de registro");
        }
        foreach($institutionCodeList as $n=>$ar) {
            $rs[] = array("controller" => "institutioncode","id" => $ar->idinstitutioncode,"label" => $ar->institutioncode,"category" => "Codigo da instituicao");
        }
        foreach($collectionCodeList as $n=>$ar) {
            $rs[] = array("controller" => "collectioncode","id" => $ar->idcollectioncode,"label" => $ar->collectioncode,"category" => "Codigo da colecao");
        }

        $rs[] = array("controller" => "catalognumber","id" => $q,"label" => $q, "category" => "Numero de catalogo");

        foreach($scientificNameList as $n=>$ar) {
            $rs[] = array("controller" => "scientificname","id" => $ar->idscientificname,"label" => $ar->scientificname,"category" => "Nome cientifico");
        }
        
        foreach($denominationList as $n=>$ar) {
            $rs[] = array("controller" => "denomination","id" => $ar->iddenomination,"label" => $ar->denomination,"category" => "Denominacao");
        }
        
        foreach($cultureList as $n=>$ar) {
            $rs[] = array("controller" => "culture","id" => $ar->idculture,"label" => $ar->culture,"category" => "Cultura");
        }
        
        foreach($technicalCollectionList as $n=>$ar) {
            $rs[] = array("controller" => "technicalcollection","id" => $ar->idtechnicalcollection,"label" => $ar->technicalcollection,"category" => "Tecnica de coleta");
        }

        //Taxa

        foreach($specificEpithetList as $n=>$ar) {
            $rs[] = array("controller" => "specificepithet","id" => $ar->idspecificepithet,"label" => $ar->specificepithet,"category" => "Epiteto especifico");
        }
        foreach($subgenusList as $n=>$ar) {
            $rs[] = array("controller" => "subgenus","id" => $ar->idsubgenus,"label" => $ar->subgenus,"category" => "Subgenero");
        }
        foreach($genusList as $n=>$ar) {
            $rs[] = array("controller" => "genus","id" => $ar->idgenus,"label" => $ar->genus,"category" => "Genero");
        }
        foreach($familyList as $n=>$ar) {
            $rs[] = array("controller" => "family","id" => $ar->idfamily,"label" => $ar->family,"category" => "Familia");
        }
        foreach($orderList as $n=>$ar) {
            $rs[] = array("controller" => "order","id" => $ar->idorder,"label" => $ar->order,"category" => "Ordem");
        }
        foreach($classList as $n=>$ar) {
            $rs[] = array("controller" => "class","id" => $ar->idclass,"label" => $ar->class,"category" => "Classe");
        }
        foreach($phylumList as $n=>$ar) {
            $rs[] = array("controller" => "phylum","id" => $ar->idphylum,"label" => $ar->phylum,"category" => "Filo");
        }
        foreach($kingdomList as $n=>$ar) {
            $rs[] = array("controller" => "kingdom","id" => $ar->idkingdom,"label" => $ar->kingdom,"category" => "Reino");
        }


        //Locality

        foreach($countryList as $n=>$ar) {
            $rs[] = array("controller" => "country","id" => $ar->idcountry,"label" => $ar->country,"category" => "Pais");
        }
        foreach($stateProvinceList as $n=>$ar) {
            $rs[] = array("controller" => "stateprovince","id" => $ar->idstateprovince,"label" => $ar->stateprovince,"category" => "Estado ou provincia");
        }
        foreach($countyList as $n=>$ar) {
            $rs[] = array("controller" => "county","id" => $ar->idcounty,"label" => $ar->county,"category" => "County");
        }
        foreach($municipalityList as $n=>$ar) {
            $rs[] = array("controller" => "municipality","id" => $ar->idmunicipality,"label" => $ar->municipality,"category" => "Municipalidade");
        }
        foreach($localityList as $n=>$ar) {
            $rs[] = array("controller" => "locality","id" => $ar->idlocality,"label" => $ar->locality,"category" => "Localidade");
        }



        return $rs;
    }
    public function getTip($filter)
    {
        $c = array();
        $rs = array();

        // parametros da consulta
        $c['select'] = 'SELECT inst.institutioncode, tech.technicalcollection, cul.culture ';
        $c['from'] = ' FROM monitoring mon ';
        $c['join'] = $c['join'].' LEFT JOIN recordlevelelement r ON mon.idrecordlevelelement = r.idrecordlevelelement ';
        $c['join'] = $c['join'].' LEFT JOIN institutioncode inst ON r.idinstitutioncode = inst.idinstitutioncode ';
        $c['join'] = $c['join'].' LEFT JOIN technicalcollection tech ON mon.idtechnicalcollection = tech.idtechnicalcollection ';
        $c['join'] = $c['join'].' LEFT JOIN culture cul ON mon.idculture = cul.idculture ';
        $c['where'] = ' WHERE mon.idmonitoring = '.$filter['idmonitoring'];

        // junta tudo
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
        // faz consulta e manda para list
        $rs = WebbeeController::executaSQL($sql);

        return $rs;
    }
    public function searchLocalScientificName($q, $l, $onlyValid) {
        $q = trim($q);
        $onlyValid = $onlyValid ? ' and colvalidation = true ' : '';
        $rs = array();

        if (preg_match("/([a-z]|[A-Z])[a-z]* sp(([ .]([0-9][0-9]*)?)|([0-9][0-9]*)?|(. ([0-9][0-9]*)?)|(p.?))/", $q) && !preg_match("/([a-z]|[A-Z])[a-z]* sp([a-o]|[q-z])[a-z]*/", $q)) {
            //$rs[] = array("id" => 0, "rank" => 'genus', "label" => "Funcionou", "desc" => "(36)", "level" => 'Morphospecies', "icon" => "images/specimen/ITIS.gif", "valid" => false);
            $r = split(" ", $q, 2);
            $g = $r[0];
            $g[0] = strtoupper($g[0]);
            $m = ($r[1] == 'sp' || $r[1] == 'sp.' || $r[1] == 'spp') ? 'spp.' : $r[1];

            if ($m != 'spp.') {
                $arr = str_split($m); //transforma a string $m na array $arr
                $n = count($arr); //$n = numero de elementos da array $arr
                foreach ($arr as $k => $v) {
                    if (!preg_match("/[0-9][0-9]*/", $v))
                        unset($arr[$k]);
                }
                $m = "sp." . implode("", $arr);
            }

            $gm = $g." ".$m;
            //$rs[] = array("id" => 0, "rank" => 'genus', "label" => $gm, "desc" => "(36)", "level" => 'Morphospecies', "icon" => "images/specimen/ITIS.gif", "valid" => false);

            
            $sql = "select * from genus where genus = '$g'";
            $hasGenus = WebbeeController::executaSQL($sql);
            if (empty($hasGenus))
            	$rs[] = array("id" => null, "rank" => 'New', "label" => $gm, "desc" => 'New morphospecies?', "level" => 'New', "icon" => "images/specimen/new.png", "valid" => false);
            
            $sql = "select * from genus where levenshtein(UPPER(genus),UPPER('$g'))<$l $onlyValid order by colvalidation DESC, levenshtein(UPPER(genus),UPPER('$g')) offset 0 limit 50 ";
            $res = WebbeeController::executaSQL($sql);
            // percorre generos
            foreach ($res as $linha) {
                $sql2 = "select count(*) as n, m.idmorphospecies as id from specimen s LEFT JOIN taxonomicelement t ON s.idtaxonomicelement = t.idtaxonomicelement LEFT JOIN morphospecies m ON
                     t.idmorphospecies = m.idmorphospecies WHERE m.morphospecies ='" . $linha['genus'] . ' ' . $m . "' group by m.idmorphospecies";
                // procuro relacoes com morphospecies
                $numero = WebbeeController::executaSQL($sql2);

                $sql3 = "select count(*) as n, idmorphospecies as id from morphospecies WHERE morphospecies ='" . $linha['genus'] . ' ' . $m . "' group by idmorphospecies";
                $numero2 = WebbeeController::executaSQL($sql3);
                $n3 = 0;
                $idm = 0;
                foreach ($numero2 as $n2) {
                    $n3 = $n2['n'];
                    $idm = $n2['id'];
                }
                //Nao houver relacao
                if (empty($numero)) {
                    // nao ha morfoespecie
                    if ($n3 == 0) {
                        $rs[] = array("id" => null, "rank" => 'genus', "label" => $linha['genus'] . ' ' . $m, "desc" => 'Morphospecies', "level" => 'New', "icon" => ($linha['colvalidation'] == true ? "images/specimen/ITIS.gif" : "images/specimen/notvalid.png"), "valid" => $linha['colvalidation']);
                    } else {
                        $rs[] = array("id" => $idm, "rank" => 'genus', "label" => $linha['genus'] . ' ' . $m, "desc" => 'Morphospecies', "level" => 0, "icon" => ($linha['colvalidation'] == true ? "images/specimen/ITIS.gif" : "images/specimen/notvalid.png"), "valid" => $linha['colvalidation']);
                    }
                } else {
                    foreach ($numero as $n) {
                        $rs[] = array("id" => $n['id'], "rank" => 'genus', "label" => $linha['genus'] . ' ' . $m, "desc" => 'Morphospecies', "level" => $n['n'], "icon" => ($linha['colvalidation'] == true ? "images/specimen/ITIS.gif" : "images/specimen/notvalid.png"), "valid" => $linha['colvalidation']);
                    }
                }
            }            
        } else {
            if (!$onlyValid)
                $rs[] = array("id" => null, "rank" => 'New', "label" => $q, "desc" => 'New taxon name?', "level" => 'New', "icon" => "images/specimen/new.png", "valid" => false);
            $sql = "select * from scientificname where levenshtein(UPPER(scientificname),UPPER('$q'))<$l $onlyValid order by colvalidation DESC, levenshtein(UPPER(scientificname),UPPER('$q')) offset 0 limit 50 ";
            $res = WebbeeController::executaSQL($sql);
            foreach ($res as $linha) {
                $rs[] = array("id" => $linha['idscientificname'], "rank" => 'scientificname', "label" => $linha['scientificname'], "desc" => ($linha['colvalidation'] == true ? 'Valid name' : 'Not valid name'), "level" => 'Scientific Name', "icon" => ($linha['colvalidation'] == true ? "images/specimen/ITIS.gif" : "images/specimen/notvalid.png"), "valid" => $linha['colvalidation']);
            }
        }
        return $rs;
    }
}
?>
