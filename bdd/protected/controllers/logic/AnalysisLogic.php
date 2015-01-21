<?php
include_once 'InstitutionCodeLogic.php';
include_once 'CollectionCodeLogic.php';
include_once 'ScientificNameLogic.php';
include_once 'BasisOfRecordLogic.php';

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

include_once 'InteractionTypeLogic.php';

class AnalysisLogic {
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
        
        // parametros da consulta
        $c['select'] = 'SELECT r.isrestricted, sp.idspecimen,k.kingdom, p.phylum, cla.class, ord.order, fam.family, gen.genus, sub.subgenus, spec.specificepithet, ispec.infraspecificepithet, scn.scientificname, o.catalognumber, inst.institutioncode, coll.collectioncode ';
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
        $c['join'] = $c['join'].' LEFT JOIN scientificname scn ON t.idscientificname = scn.idscientificname  ';
        $c['where'] = ' WHERE 1 = 1 '.$institutionCodeWhere.$collectionCodeWhere.$scientificNameWhere.$basisOfRecordWhere.$catalogNumberWhere.
                $kingdomWhere.$phylumWhere.$classWhere.$orderWhere.$familyWhere.$genusWhere.$subgenusWhere.$specificEpithetWhere.
                $countryWhere.$stateProvinceWhere.$countyWhere.$municipalityWhere.$localityWhere;
        $c['orderby'] = ' ORDER BY scn.scientificname, o.catalognumber, sp.idspecimen ';
        $c['limit'] = ' limit '.$filter['limit'];
        $c['offset'] = ' offset '.$filter['offset'];

        $idGroup = Yii::app()->user->getGroupId();
		//$groupSQL = ' AND (sp.idgroup='.$idGroup.') ';
    	if ($idGroup!=2){
        	 $groupSQL = ' AND (sp.idgroup='.$idGroup.') ';
        }
		$c['where'] =  $c['where'].$groupSQL;
		
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
    public function basisOfRecord($filter) {
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
		
		
        
        // faz consulta do Count e manda para count
        // parametros da consulta
        
        $c['from'] = ' FROM specimen sp ';
        $c['join'] = $c['join'].' LEFT JOIN recordlevelelement r ON sp.idrecordlevelelement = r.idrecordlevelelement ';
        $c['join'] = $c['join'].' LEFT JOIN basisofrecord b ON r.idbasisofrecord = b.idbasisofrecord ';
        $c['join'] = $c['join'].' LEFT JOIN institutioncode inst ON r.idinstitutioncode = inst.idinstitutioncode ';
        $c['join'] = $c['join'].' LEFT JOIN collectioncode coll ON r.idcollectioncode = coll.idcollectioncode ';
        $c['join'] = $c['join'].' LEFT JOIN occurrenceelement o ON sp.idoccurrenceelement = o.idoccurrenceelement ';
        $c['join'] = $c['join'].' LEFT JOIN localityelement l ON sp.idlocalityelement = l.idlocalityelement ';
        $c['join'] = $c['join'].' LEFT JOIN taxonomicelement t ON sp.idtaxonomicelement = t.idtaxonomicelement  ';
        $c['join'] = $c['join'].' LEFT JOIN scientificname scn ON t.idscientificname = scn.idscientificname  ';
        $c['where'] = ' WHERE 1 = 1 '.$institutionCodeWhere.$collectionCodeWhere.$scientificNameWhere.$basisOfRecordWhere.$catalogNumberWhere.
                $kingdomWhere.$phylumWhere.$classWhere.$orderWhere.$familyWhere.$genusWhere.$subgenusWhere.$specificEpithetWhere.
                $countryWhere.$stateProvinceWhere.$countyWhere.$municipalityWhere.$localityWhere;
        $c['orderby'] = ' ORDER BY count(b.basisofrecord) DESC ';
        $c['group'] = ' group by b.basisofrecord ';

        $idGroup = Yii::app()->user->getGroupId();
		//$groupSQL = ' AND (sp.idgroup='.$idGroup.') ';
    	if ($idGroup!=2){
        	 $groupSQL = ' AND (sp.idgroup='.$idGroup.') ';
        }
		$c['where'] =  $c['where'].$groupSQL;
		
        // junta tudo
        $c['select'] = 'SELECT count(*) ';
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
        $rs['total'] = WebbeeController::executaSQL($sql);
        $c['select'] = 'SELECT b.basisofrecord, count(b.basisofrecord) ';
        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['group'].$c['orderby'];
        // faz consulta e manda para list
        $rs['list'] = WebbeeController::executaSQL($sql);
        return $rs;
    }
    public function institutionCode($filter) {
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
		
		
        
        // faz consulta do Count e manda para count
        // parametros da consulta
        
        $c['from'] = ' FROM specimen sp ';
        $c['join'] = $c['join'].' LEFT JOIN recordlevelelement r ON sp.idrecordlevelelement = r.idrecordlevelelement ';
        $c['join'] = $c['join'].' LEFT JOIN basisofrecord b ON r.idbasisofrecord = b.idbasisofrecord ';
        $c['join'] = $c['join'].' LEFT JOIN institutioncode inst ON r.idinstitutioncode = inst.idinstitutioncode ';
        $c['join'] = $c['join'].' LEFT JOIN collectioncode coll ON r.idcollectioncode = coll.idcollectioncode ';
        $c['join'] = $c['join'].' LEFT JOIN occurrenceelement o ON sp.idoccurrenceelement = o.idoccurrenceelement ';
        $c['join'] = $c['join'].' LEFT JOIN localityelement l ON sp.idlocalityelement = l.idlocalityelement ';
        $c['join'] = $c['join'].' LEFT JOIN taxonomicelement t ON sp.idtaxonomicelement = t.idtaxonomicelement  ';
        $c['join'] = $c['join'].' LEFT JOIN scientificname scn ON t.idscientificname = scn.idscientificname  ';
        $c['where'] = ' WHERE 1 = 1 '.$institutionCodeWhere.$collectionCodeWhere.$scientificNameWhere.$basisOfRecordWhere.$catalogNumberWhere.
                $kingdomWhere.$phylumWhere.$classWhere.$orderWhere.$familyWhere.$genusWhere.$subgenusWhere.$specificEpithetWhere.
                $countryWhere.$stateProvinceWhere.$countyWhere.$municipalityWhere.$localityWhere;
        $c['orderby'] = ' ORDER BY count(inst.institutioncode) DESC ';
        $c['group'] = ' group by inst.institutioncode ';
        
		$idGroup = Yii::app()->user->getGroupId();
		//$groupSQL = ' AND (sp.idgroup='.$idGroup.') ';
    	if ($idGroup!=2){
        	 $groupSQL = ' AND (sp.idgroup='.$idGroup.') ';
        }
		$c['where'] =  $c['where'].$groupSQL;
		
        // junta tudo
        $c['select'] = 'SELECT count(*) ';
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
        $rs['total'] = WebbeeController::executaSQL($sql);
        $c['select'] = 'SELECT inst.institutioncode, count(inst.institutioncode) ';
        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['group'].$c['orderby'];
        // faz consulta e manda para list
        $rs['list'] = WebbeeController::executaSQL($sql);
        return $rs;
    }
    public function collectionCode($filter) {
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
		
		
        
        // faz consulta do Count e manda para count
        // parametros da consulta
        
        $c['from'] = ' FROM specimen sp ';
        $c['join'] = $c['join'].' LEFT JOIN recordlevelelement r ON sp.idrecordlevelelement = r.idrecordlevelelement ';
        $c['join'] = $c['join'].' LEFT JOIN basisofrecord b ON r.idbasisofrecord = b.idbasisofrecord ';
        $c['join'] = $c['join'].' LEFT JOIN institutioncode inst ON r.idinstitutioncode = inst.idinstitutioncode ';
        $c['join'] = $c['join'].' LEFT JOIN collectioncode coll ON r.idcollectioncode = coll.idcollectioncode ';
        $c['join'] = $c['join'].' LEFT JOIN occurrenceelement o ON sp.idoccurrenceelement = o.idoccurrenceelement ';
        $c['join'] = $c['join'].' LEFT JOIN localityelement l ON sp.idlocalityelement = l.idlocalityelement ';
        $c['join'] = $c['join'].' LEFT JOIN taxonomicelement t ON sp.idtaxonomicelement = t.idtaxonomicelement  ';
        $c['join'] = $c['join'].' LEFT JOIN scientificname scn ON t.idscientificname = scn.idscientificname  ';
        $c['where'] = ' WHERE 1 = 1 '.$institutionCodeWhere.$collectionCodeWhere.$scientificNameWhere.$basisOfRecordWhere.$catalogNumberWhere.
                $kingdomWhere.$phylumWhere.$classWhere.$orderWhere.$familyWhere.$genusWhere.$subgenusWhere.$specificEpithetWhere.
                $countryWhere.$stateProvinceWhere.$countyWhere.$municipalityWhere.$localityWhere;
        $c['orderby'] = ' ORDER BY count(coll.collectioncode) DESC ';
        $c['group'] = ' group by coll.collectioncode ';

        $idGroup = Yii::app()->user->getGroupId();
		//$groupSQL = ' AND (sp.idgroup='.$idGroup.') ';
    	if ($idGroup!=2){
        	 $groupSQL = ' AND (sp.idgroup='.$idGroup.') ';
        }
		$c['where'] =  $c['where'].$groupSQL;
		
        // junta tudo
        $c['select'] = 'SELECT count(*) ';
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
        $rs['total'] = WebbeeController::executaSQL($sql);
        $c['select'] = 'SELECT coll.collectioncode, count(coll.collectioncode) ';
        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['group'].$c['orderby'];
        // faz consulta e manda para list
        $rs['list'] = WebbeeController::executaSQL($sql);
        return $rs;
    }
    public function taxon($filter, $type, $idkingdom, $idphylum, $idclass, $idorder, $idfamily, $idgenus, $idsubgenus, $idspecificepithet, $idinfraspecificepithet) {
    	if ($type <= 9) {
	    	$c = array();
	    	$taxon = array();
	
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
	    
	    	// Defini�‹o dos par‰metros
	    	if ($type == 9) {
	    		$taxonWhere = ' AND (k.idkingdom '.($idkingdom==null?'IS NULL':'= '.$idkingdom).') AND (p.idphylum '.($idphylum==null?'IS NULL':'= '.$idphylum).') AND (cla.idclass '.($idclass==null?'IS NULL':'= '.$idclass).') AND (ord.idorder '.($idorder==null?'IS NULL':'= '.$idorder).') AND (fam.idfamily '.($idfamily==null?'IS NULL':'= '.$idfamily).') AND (gen.idgenus '.($idgenus==null?'IS NULL':'= '.$idgenus).') AND (sub.idsubgenus '.($idsubgenus==null?'IS NULL':'= '.$idsubgenus).') AND (spec.idspecificepithet '.($idspecificepithet==null?'IS NULL':'= '.$idspecificepithet).') AND (ispec.idinfraspecificepithet '.($idinfraspecificepithet==null?'IS NULL':'= '.$idinfraspecificepithet).') ';
	            $taxonGroupBy = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, fam.idfamily, fam.family, gen.genus, gen.idgenus, sub.idsubgenus, sub.subgenus, spec.idspecificepithet, spec.specificepithet, ispec.idinfraspecificepithet, ispec.infraspecificepithet, scn.idscientificname, scn.scientificname ';
	            $taxonSelect = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, fam.idfamily, fam.family, gen.genus, gen.idgenus, sub.idsubgenus, sub.subgenus, spec.idspecificepithet, spec.specificepithet, ispec.idinfraspecificepithet, ispec.infraspecificepithet, scn.idscientificname, scn.scientificname, count(*) ';
	            $taxonOrderBy = ' count(*) ';
	    	}
	    	else if ($type == 8) {
	    		$taxonWhere = ' AND (k.idkingdom '.($idkingdom==null?'IS NULL':'= '.$idkingdom).') AND (p.idphylum '.($idphylum==null?'IS NULL':'= '.$idphylum).') AND (cla.idclass '.($idclass==null?'IS NULL':'= '.$idclass).') AND (ord.idorder '.($idorder==null?'IS NULL':'= '.$idorder).') AND (fam.idfamily '.($idfamily==null?'IS NULL':'= '.$idfamily).') AND (gen.idgenus '.($idgenus==null?'IS NULL':'= '.$idgenus).') AND (sub.idsubgenus '.($idsubgenus==null?'IS NULL':'= '.$idsubgenus).') AND (spec.idspecificepithet '.($idspecificepithet==null?'IS NULL':'= '.$idspecificepithet).') ';
	            $taxonGroupBy = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, fam.idfamily, fam.family, gen.genus, gen.idgenus, sub.idsubgenus, sub.subgenus, spec.idspecificepithet, spec.specificepithet, ispec.idinfraspecificepithet, ispec.infraspecificepithet ';
	            $taxonSelect = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, fam.idfamily, fam.family, gen.genus, gen.idgenus, sub.idsubgenus, sub.subgenus, spec.idspecificepithet, spec.specificepithet, ispec.idinfraspecificepithet, ispec.infraspecificepithet, count(*) ';
	            $taxonOrderBy = ' count(*) ';
	    	}
	    	else if ($type == 7) {
	    		$taxonWhere = ' AND (k.idkingdom '.($idkingdom==null?'IS NULL':'= '.$idkingdom).') AND (p.idphylum '.($idphylum==null?'IS NULL':'= '.$idphylum).') AND (cla.idclass '.($idclass==null?'IS NULL':'= '.$idclass).') AND (ord.idorder '.($idorder==null?'IS NULL':'= '.$idorder).') AND (fam.idfamily '.($idfamily==null?'IS NULL':'= '.$idfamily).') AND (gen.idgenus '.($idgenus==null?'IS NULL':'= '.$idgenus).') AND (sub.idsubgenus '.($idsubgenus==null?'IS NULL':'= '.$idsubgenus).') ';
	            $taxonGroupBy = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, fam.idfamily, fam.family, gen.genus, gen.idgenus, sub.idsubgenus, sub.subgenus, spec.idspecificepithet, spec.specificepithet ';
	            $taxonSelect = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, fam.idfamily, fam.family, gen.genus, gen.idgenus, sub.idsubgenus, sub.subgenus, spec.idspecificepithet, spec.specificepithet, count(*) ';
	            $taxonOrderBy = ' count(*) ';
	    	}
	    	else if ($type == 6) {
	    		$taxonWhere = ' AND (k.idkingdom '.($idkingdom==null?'IS NULL':'= '.$idkingdom).') AND (p.idphylum '.($idphylum==null?'IS NULL':'= '.$idphylum).') AND (cla.idclass '.($idclass==null?'IS NULL':'= '.$idclass).') AND (ord.idorder '.($idorder==null?'IS NULL':'= '.$idorder).') AND (fam.idfamily '.($idfamily==null?'IS NULL':'= '.$idfamily).') AND (gen.idgenus '.($idgenus==null?'IS NULL':'= '.$idgenus).') ';
	            $taxonGroupBy = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, fam.idfamily, fam.family, gen.genus, gen.idgenus, sub.idsubgenus, sub.subgenus ';
	            $taxonSelect = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, fam.idfamily, fam.family, gen.genus, gen.idgenus, sub.idsubgenus, sub.subgenus, count(*) ';
	            $taxonOrderBy = ' count(*) ';
	    	}
	    	else if ($type == 5) {
	    		$taxonWhere = ' AND (k.idkingdom '.($idkingdom==null?'IS NULL':'= '.$idkingdom).') AND (p.idphylum '.($idphylum==null?'IS NULL':'= '.$idphylum).') AND (cla.idclass '.($idclass==null?'IS NULL':'= '.$idclass).') AND (ord.idorder '.($idorder==null?'IS NULL':'= '.$idorder).') AND (fam.idfamily '.($idfamily==null?'IS NULL':'= '.$idfamily).') ';
	            $taxonGroupBy = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, fam.idfamily, fam.family, gen.genus, gen.idgenus ';
	            $taxonSelect = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, fam.idfamily, fam.family, gen.genus, gen.idgenus, count(*) ';
	            $taxonOrderBy = ' count(*) ';
	    	}
	    	else if ($type == 4) {
	    		$taxonWhere = ' AND (k.idkingdom '.($idkingdom==null?'IS NULL':'= '.$idkingdom).') AND (p.idphylum '.($idphylum==null?'IS NULL':'= '.$idphylum).') AND (cla.idclass '.($idclass==null?'IS NULL':'= '.$idclass).') AND (ord.idorder '.($idorder==null?'IS NULL':'= '.$idorder).') ';
	            $taxonGroupBy = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, fam.idfamily, fam.family ';
	            $taxonSelect = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, fam.idfamily, fam.family, count(*) ';
	            $taxonOrderBy = ' count(*) ';
	    	}
	    	else if ($type == 3) {
	    		$taxonWhere = ' AND (k.idkingdom '.($idkingdom==null?'IS NULL':'= '.$idkingdom).') AND (p.idphylum '.($idphylum==null?'IS NULL':'= '.$idphylum).') AND (cla.idclass '.($idclass==null?'IS NULL':'= '.$idclass).') ';
	            $taxonGroupBy = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order ';
	            $taxonSelect = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, count(*) ';
	            $taxonOrderBy = ' count(*) ';
	    	}
	    	else if ($type == 2) {
	            $taxonWhere = ' AND (k.idkingdom '.($idkingdom==null?'IS NULL':'= '.$idkingdom).') AND (p.idphylum '.($idphylum==null?'IS NULL':'= '.$idphylum).') ';
	            $taxonGroupBy = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class ';
	            $taxonSelect = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, count(*) ';
	            $taxonOrderBy = ' count(*) ';
	        }
	        else if ($type == 1) {
	            $taxonWhere = ' AND (k.idkingdom '.($idkingdom==null?'IS NULL':'= '.$idkingdom).') ';
	            $taxonGroupBy = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum ';
	            $taxonSelect = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, count(*) ';
	            $taxonOrderBy = ' count(*) ';
	        }
	        else if ($type == 0) {
	            $taxonGroupBy = ' k.idkingdom, k.kingdom ';
	            $taxonSelect = ' k.idkingdom, k.kingdom, count(*) ';
	            $taxonOrderBy = ' count(*) ';
	        }
	        
	        $c['from'] = ' FROM specimen sp ';
	        $c['join'] = $c['join'].' LEFT JOIN recordlevelelement r ON sp.idrecordlevelelement = r.idrecordlevelelement ';
	        $c['join'] = $c['join'].' LEFT JOIN basisofrecord b ON r.idbasisofrecord = b.idbasisofrecord ';
	        $c['join'] = $c['join'].' LEFT JOIN institutioncode inst ON r.idinstitutioncode = inst.idinstitutioncode ';
	        $c['join'] = $c['join'].' LEFT JOIN collectioncode coll ON r.idcollectioncode = coll.idcollectioncode ';
	        $c['join'] = $c['join'].' LEFT JOIN occurrenceelement o ON sp.idoccurrenceelement = o.idoccurrenceelement ';
	        $c['join'] = $c['join'].' LEFT JOIN localityelement l ON sp.idlocalityelement = l.idlocalityelement ';
	        $c['join'] = $c['join'].' LEFT JOIN taxonomicelement t ON sp.idtaxonomicelement = t.idtaxonomicelement ';
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
	        
	        $c['where'] = ' WHERE 1 = 1 '.$taxonWhere.$institutionCodeWhere.$collectionCodeWhere.$scientificNameWhere.$basisOfRecordWhere.$catalogNumberWhere.$kingdomWhere.$phylumWhere.$classWhere.$orderWhere.$familyWhere.$genusWhere.$subgenusWhere.$specificEpithetWhere. $countryWhere.$stateProvinceWhere.$countyWhere.$municipalityWhere.$localityWhere;
	        $c['orderby'] = ' ORDER BY '.$taxonOrderBy.' DESC ';
	        $c['group'] = ' GROUP BY '.$taxonGroupBy;
	             
	        $idGroup = Yii::app()->user->getGroupId();
			//$groupSQL = ' AND (sp.idgroup='.$idGroup.') ';
    		if ($idGroup!=2){
        	 $groupSQL = ' AND (sp.idgroup='.$idGroup.') ';
       		 }
			$c['where'] =  $c['where'].$groupSQL;
		
			$c['select'] = 'SELECT count(*) ';
	        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
	        $total = WebbeeController::executaSQL($sql);
	        $total = (float)$total[0]['count'];
	        $c['select'] = 'SELECT '.$taxonSelect;   
	        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['group'].$c['orderby'];        
	        $array = WebbeeController::executaSQL($sql);
	
	       	foreach ($array as $ia => $a) {
	       		if ($type == 9) {
	       			$ar = array('id'=>'10'.($a['idkingdom']==null?'_NULL':'_'.$a['idkingdom']).($a['idphylum']==null?'_NULL':'_'.$a['idphylum']).($a['idclass']==null?'_NULL':'_'.$a['idclass']).($a['idorder']==null?'_NULL':'_'.$a['idorder']).($a['idfamily']==null?'_NULL':'_'.$a['idfamily']).($a['idgenus']==null?'_NULL':'_'.$a['idgenus']).($a['idsubgenus']==null?'_NULL':'_'.$a['idsubgenus']).($a['idspecificepithet']==null?'_NULL':'_'.$a['idspecificepithet']).($a['idinfraspecificepithet']==null?'_NULL':'_'.$a['idinfraspecificepithet']).($a['idscientificname']==null?'_NULL':'_'.$a['idscientificname']), 'name'=>($a['idscientificname']==null?'<strong>No Scientific Name</strong><br>('.$a['count'].', '.round(100*$a['count']/$total, 2).'%)':'<strong>Scientific Name</strong><br>'.$a['scientificname'].'<br>('.$a['count'].', '.round(100*$a['count']/$total, 2).'%)'));
	       		}
	       		else if ($type == 8) {
	       			$ar = array('id'=>'9'.($a['idkingdom']==null?'_NULL':'_'.$a['idkingdom']).($a['idphylum']==null?'_NULL':'_'.$a['idphylum']).($a['idclass']==null?'_NULL':'_'.$a['idclass']).($a['idorder']==null?'_NULL':'_'.$a['idorder']).($a['idfamily']==null?'_NULL':'_'.$a['idfamily']).($a['idgenus']==null?'_NULL':'_'.$a['idgenus']).($a['idsubgenus']==null?'_NULL':'_'.$a['idsubgenus']).($a['idspecificepithet']==null?'_NULL':'_'.$a['idspecificepithet']).($a['idinfraspecificepithet']==null?'_NULL':'_'.$a['idinfraspecificepithet']), 'name'=>($a['idinfraspecificepithet']==null?'<strong>No Infraspecific Epithet</strong><br>('.$a['count'].', '.round(100*$a['count']/$total, 2).'%)':'<strong>Infraspecific Epithet</strong><br>'.$a['infraspecificepithet'].'<br>('.$a['count'].', '.round(100*$a['count']/$total, 2).'%)'));
	       		}
	       		else if ($type == 7) {
	       			$ar = array('id'=>'8'.($a['idkingdom']==null?'_NULL':'_'.$a['idkingdom']).($a['idphylum']==null?'_NULL':'_'.$a['idphylum']).($a['idclass']==null?'_NULL':'_'.$a['idclass']).($a['idorder']==null?'_NULL':'_'.$a['idorder']).($a['idfamily']==null?'_NULL':'_'.$a['idfamily']).($a['idgenus']==null?'_NULL':'_'.$a['idgenus']).($a['idsubgenus']==null?'_NULL':'_'.$a['idsubgenus']).($a['idspecificepithet']==null?'_NULL':'_'.$a['idspecificepithet']), 'name'=>($a['idspecificepithet']==null?'<strong>No Specific Epithet</strong><br>('.$a['count'].', '.round(100*$a['count']/$total, 2).'%)':'<strong>Specific Epithet</strong><br>'.$a['specificepithet'].'<br>('.$a['count'].', '.round(100*$a['count']/$total, 2).'%)'));
	       		}
	       		else if ($type == 6) {
	       			$ar = array('id'=>'7'.($a['idkingdom']==null?'_NULL':'_'.$a['idkingdom']).($a['idphylum']==null?'_NULL':'_'.$a['idphylum']).($a['idclass']==null?'_NULL':'_'.$a['idclass']).($a['idorder']==null?'_NULL':'_'.$a['idorder']).($a['idfamily']==null?'_NULL':'_'.$a['idfamily']).($a['idgenus']==null?'_NULL':'_'.$a['idgenus']).($a['idsubgenus']==null?'_NULL':'_'.$a['idsubgenus']), 'name'=>($a['idsubgenus']==null?'<strong>No Subgenus</strong><br>('.$a['count'].', '.round(100*$a['count']/$total, 2).'%)':'<strong>Subgenus</strong><br>'.$a['subgenus'].'<br>('.$a['count'].', '.round(100*$a['count']/$total, 2).'%)'));
	       		}
	       		else if ($type == 5) {
	       			$ar = array('id'=>'6'.($a['idkingdom']==null?'_NULL':'_'.$a['idkingdom']).($a['idphylum']==null?'_NULL':'_'.$a['idphylum']).($a['idclass']==null?'_NULL':'_'.$a['idclass']).($a['idorder']==null?'_NULL':'_'.$a['idorder']).($a['idfamily']==null?'_NULL':'_'.$a['idfamily']).($a['idgenus']==null?'_NULL':'_'.$a['idgenus']), 'name'=>($a['idgenus']==null?'<strong>No Genus</strong><br>('.$a['count'].', '.round(100*$a['count']/$total, 2).'%)':'<strong>Genus</strong><br>'.$a['genus'].'<br>('.$a['count'].', '.round(100*$a['count']/$total, 2).'%)'));
	       		}
	       		else if ($type == 4) {
	       			$ar = array('id'=>'5'.($a['idkingdom']==null?'_NULL':'_'.$a['idkingdom']).($a['idphylum']==null?'_NULL':'_'.$a['idphylum']).($a['idclass']==null?'_NULL':'_'.$a['idclass']).($a['idorder']==null?'_NULL':'_'.$a['idorder']).($a['idfamily']==null?'_NULL':'_'.$a['idfamily']), 'name'=>($a['idfamily']==null?'<strong>No Family</strong><br>('.$a['count'].', '.round(100*$a['count']/$total, 2).'%)':'<strong>Family</strong><br>'.$a['family'].'<br>('.$a['count'].', '.round(100*$a['count']/$total, 2).'%)'));
	       		}
	       		else if ($type == 3) {
	       			$ar = array('id'=>'4'.($a['idkingdom']==null?'_NULL':'_'.$a['idkingdom']).($a['idphylum']==null?'_NULL':'_'.$a['idphylum']).($a['idclass']==null?'_NULL':'_'.$a['idclass']).($a['idorder']==null?'_NULL':'_'.$a['idorder']), 'name'=>($a['idorder']==null?'<strong>No Order</strong><br>('.$a['count'].', '.round(100*$a['count']/$total, 2).'%)':'<strong>Order</strong><br>'.$a['order'].'<br>('.$a['count'].', '.round(100*$a['count']/$total, 2).'%)'));
	       		}
	       		else if ($type == 2) {
	       			$ar = array('id'=>'3'.($a['idkingdom']==null?'_NULL':'_'.$a['idkingdom']).($a['idphylum']==null?'_NULL':'_'.$a['idphylum']).($a['idclass']==null?'_NULL':'_'.$a['idclass']), 'name'=>($a['idclass']==null?'<strong>No Class</strong><br>('.$a['count'].', '.round(100*$a['count']/$total, 2).'%)':'<strong>Class</strong><br>'.$a['class'].'<br>('.$a['count'].', '.round(100*$a['count']/$total, 2).'%)'));
	       		}
	       		else if ($type == 1) {
	       			$ar = array('id'=>'2'.($a['idkingdom']==null?'_NULL':'_'.$a['idkingdom']).($a['idphylum']==null?'_NULL':'_'.$a['idphylum']), 'name'=>($a['idphylum']==null?'<strong>No Phylum</strong><br>('.$a['count'].', '.round(100*$a['count']/$total, 2).'%)':'<strong>Phylum</strong><br>'.$a['phylum'].'<br>('.$a['count'].', '.round(100*$a['count']/$total, 2).'%)'));
	       		}
	       		else if ($type == 0) {
	       			$ar = array('id'=>'1'.($a['idkingdom']==null?'_NULL':'_'.$a['idkingdom']), 'name'=>($a['idkingdom']==null?'<strong>No Kingdom</strong><br>('.$a['count'].', '.round(100*$a['count']/$total, 2).'%)':'<strong>Kingdom</strong><br>'.$a['kingdom'].'<br>('.$a['count'].', '.round(100*$a['count']/$total, 2).'%)'));
	       		}
	
	   			$taxon[] = $ar;
	   		}
	   		return $taxon;
   		}
   		else {
   			return null;
   		}
    }
    public function country($filter) {
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
		
		
        
        // faz consulta do Count e manda para count
        // parametros da consulta
        
        $c['from'] = ' FROM specimen sp ';
        $c['join'] = $c['join'].' LEFT JOIN recordlevelelement r ON sp.idrecordlevelelement = r.idrecordlevelelement ';
        $c['join'] = $c['join'].' LEFT JOIN basisofrecord b ON r.idbasisofrecord = b.idbasisofrecord ';
        $c['join'] = $c['join'].' LEFT JOIN institutioncode inst ON r.idinstitutioncode = inst.idinstitutioncode ';
        $c['join'] = $c['join'].' LEFT JOIN collectioncode coll ON r.idcollectioncode = coll.idcollectioncode ';
        $c['join'] = $c['join'].' LEFT JOIN occurrenceelement o ON sp.idoccurrenceelement = o.idoccurrenceelement ';
        $c['join'] = $c['join'].' LEFT JOIN localityelement l ON sp.idlocalityelement = l.idlocalityelement ';
        $c['join'] = $c['join'].' LEFT JOIN country c ON l.idcountry = c.idcountry ';
        $c['join'] = $c['join'].' LEFT JOIN taxonomicelement t ON sp.idtaxonomicelement = t.idtaxonomicelement  ';
        $c['join'] = $c['join'].' LEFT JOIN scientificname scn ON t.idscientificname = scn.idscientificname  ';
        $c['where'] = ' WHERE 1 = 1 '.$institutionCodeWhere.$collectionCodeWhere.$scientificNameWhere.$basisOfRecordWhere.$catalogNumberWhere.
                $kingdomWhere.$phylumWhere.$classWhere.$orderWhere.$familyWhere.$genusWhere.$subgenusWhere.$specificEpithetWhere.
                $countryWhere.$stateProvinceWhere.$countyWhere.$municipalityWhere.$localityWhere;
        $c['orderby'] = ' ORDER BY count(c.country) DESC ';
        $c['group'] = ' group by c.country ';

        $idGroup = Yii::app()->user->getGroupId();
		//$groupSQL = ' AND (sp.idgroup='.$idGroup.') ';
    	if ($idGroup!=2){
        	 $groupSQL = ' AND (sp.idgroup='.$idGroup.') ';
        }
		$c['where'] =  $c['where'].$groupSQL;
		
        // junta tudo
        $c['select'] = 'SELECT count(*) ';
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
        $rs['total'] = WebbeeController::executaSQL($sql);
        $c['select'] = 'SELECT c.country, count(*) ';
        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['group'].$c['orderby'];      
        // faz consulta e manda para list
        $rs['list'] = WebbeeController::executaSQL($sql);
        return $rs;
    }
    public function time($filter) {
        $c = array();
        $rs = array();
        
		// Taxa filter
        $kingdomWhere = '';
        $phylumWhere ='';
        $classWhere = '';
        $orderWhere = '';
        $familyWhere = '';
        $genusWhere = '';
        $subgenusWhere = '';
        $specificEpithetWhere = '';

        // Locality filter
        $countryWhere = '';
        $stateProvinceWhere = '';
        $countyWhere = '';
        $municipalityWhere = '';
        $localityWhere = '';

        // Main fields filter
        $basisOfRecordWhere = '';
        $catalogNumberWhere = '';
        $scientificNameWhere = '';
        $institutionCodeWhere = '';
        $collectionCodeWhere = '';
        
        // Interaction filter
        $interactionTypeWhere = '';

		if ($filter['list'] != null) {
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
                
                // Interaction
                if($v['controller']=='interactiontype') {
                    $interactionTypeWhere = $interactionTypeWhere==''?'':$interactionTypeWhere.' OR ';
                    $interactionTypeWhere = $interactionTypeWhere.' i.idinteractiontype = '.$v['id'];
                }
            }
        }
        // se o where de cada entidades nao estiver vazias, coloca AND antes

        // Main fields
        $institutionCodeWhere = $institutionCodeWhere!=''?' AND ('.$institutionCodeWhere.') ':'';
        $collectionCodeWhere = $collectionCodeWhere!=''?' AND ('.$collectionCodeWhere.') ':'';
        $scientificNameWhere = $scientificNameWhere!=''?' AND ('.$scientificNameWhere.') ':'';
        $basisOfRecordWhere = $basisOfRecordWhere!=''?' AND ('.$basisOfRecordWhere.') ':'';
        $catalogNumberWhere = $catalogNumberWhere!=''?' AND ('.$catalogNumberWhere.') ':'';

        // Locality
        $countryWhere = $countryWhere!=''?' AND ('.$countryWhere.') ':'';
        $stateProvinceWhere = $stateProvinceWhere!=''?' AND ('.$stateProvinceWhere.') ':'';
        $countyWhere = $countyWhere!=''?' AND ('.$countyWhere.') ':'';
        $municipalityWhere = $municipalityWhere!=''?' AND ('.$municipalityWhere.') ':'';
        $localityWhere = $localityWhere!=''?' AND ('.$localityWhere.') ':'';

        // Taxa
        $kingdomWhere = $kingdomWhere!=''?' AND ('.$kingdomWhere.') ':'';
        $phylumWhere = $phylumWhere!=''?' AND ('.$phylumWhere.') ':'';
        $classWhere = $classWhere!=''?' AND ('.$classWhere.') ':'';
        $orderWhere = $orderWhere!=''?' AND ('.$orderWhere.') ':'';
        $familyWhere = $familyWhere!=''?' AND ('.$familyWhere.') ':'';
        $genusWhere = $genusWhere!=''?' AND ('.$genusWhere.') ':'';
        $subgenusWhere = $subgenusWhere!=''?' AND ('.$subgenusWhere.') ':'';
        $specificEpithetWhere = $specificEpithetWhere!=''?' AND ('.$specificEpithetWhere.') ':'';
        
        // Interaction
        $interactionTypeWhere = $interactionTypeWhere!=''?' AND ('.$interactionTypeWhere.') ':'';

        $c['from'] = ' from log';
        $c['group'] = ' group by date, type, module ';
        $c['orderby'] = ' order by date asc ';
		
		// Para Specimen
		$c['join'] = $c['join'].' LEFT JOIN specimen sp ON log.id = sp.idspecimen ';
        $c['join'] = $c['join'].' LEFT JOIN recordlevelelement r ON sp.idrecordlevelelement = r.idrecordlevelelement ';
        $c['join'] = $c['join'].' LEFT JOIN basisofrecord b ON r.idbasisofrecord = b.idbasisofrecord ';
        $c['join'] = $c['join'].' LEFT JOIN institutioncode inst ON r.idinstitutioncode = inst.idinstitutioncode ';
        $c['join'] = $c['join'].' LEFT JOIN collectioncode coll ON r.idcollectioncode = coll.idcollectioncode ';
        $c['join'] = $c['join'].' LEFT JOIN occurrenceelement o ON sp.idoccurrenceelement = o.idoccurrenceelement ';
        $c['join'] = $c['join'].' LEFT JOIN localityelement l ON sp.idlocalityelement = l.idlocalityelement ';
        $c['join'] = $c['join'].' LEFT JOIN country c ON l.idcountry = c.idcountry ';
        $c['join'] = $c['join'].' LEFT JOIN taxonomicelement t ON sp.idtaxonomicelement = t.idtaxonomicelement  ';
        $c['join'] = $c['join'].' LEFT JOIN scientificname scn ON t.idscientificname = scn.idscientificname  ';
		
        $c['select'] = 'select date, type, module, count(*) ';
        $c['where'] = " where type = 'create' and module = 'specimen' ".$institutionCodeWhere.$collectionCodeWhere.$scientificNameWhere.$basisOfRecordWhere.$catalogNumberWhere.
                $kingdomWhere.$phylumWhere.$classWhere.$orderWhere.$familyWhere.$genusWhere.$subgenusWhere.$specificEpithetWhere.
                $countryWhere.$stateProvinceWhere.$countyWhere.$municipalityWhere.$localityWhere;
        
                $idGroup = Yii::app()->user->getGroupId();
		//$groupSQL = ' AND (log.idgroup='.$idGroup.') ';
    	if ($idGroup!=2){
        	 $groupSQL = ' AND (log.idgroup='.$idGroup.') ';
        }
		$c['where'] =  $c['where'].$groupSQL;
		
        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['group'].$c['orderby'];
        $createSP = WebbeeController::executaSQL($sql);
        
        $c['select'] = 'select date, type, module, count(*) ';
        $c['where'] = " where type = 'update' and module = 'specimen' ".$institutionCodeWhere.$collectionCodeWhere.$scientificNameWhere.$basisOfRecordWhere.$catalogNumberWhere.
                $kingdomWhere.$phylumWhere.$classWhere.$orderWhere.$familyWhere.$genusWhere.$subgenusWhere.$specificEpithetWhere.
                $countryWhere.$stateProvinceWhere.$countyWhere.$municipalityWhere.$localityWhere;
        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['group'].$c['orderby'];
        $updateSP = WebbeeController::executaSQL($sql);
        
        $c['select'] = 'select date, type, module, count(*) ';
        $c['where'] = " where type = 'delete' and module = 'specimen' ".$institutionCodeWhere.$collectionCodeWhere.$scientificNameWhere.$basisOfRecordWhere.$catalogNumberWhere.
                $kingdomWhere.$phylumWhere.$classWhere.$orderWhere.$familyWhere.$genusWhere.$subgenusWhere.$specificEpithetWhere.
                $countryWhere.$stateProvinceWhere.$countyWhere.$municipalityWhere.$localityWhere;
   		        
        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['group'].$c['orderby'];
        $deleteSP = WebbeeController::executaSQL($sql);
        
        // Para Interaction
		$c['join'] = $c['join'].' LEFT JOIN interaction i ON log.id = i.idinteraction ';
        $c['join'] = $c['join'].' LEFT JOIN interactiontype it ON i.idinteractiontype = it.idinteractiontype ';

        $c['select'] = 'select date, type, module, count(*) ';
        $c['where'] = " where type = 'create' and module = 'interaction' ".$interactionTypeWhere;
      
		$idGroup = Yii::app()->user->getGroupId();
		//$groupSQL = ' AND (log.idgroup='.$idGroup.') ';
    	if ($idGroup!=2){
        	 $groupSQL = ' AND (log.idgroup='.$idGroup.') ';
        }
		$c['where'] =  $c['where'].$groupSQL;
		
        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['group'].$c['orderby'];
        $createINT = WebbeeController::executaSQL($sql);
        
        $c['select'] = 'select date, type, module, count(*) ';
        $c['where'] = " where type = 'update' and module = 'interaction' ".$interactionTypeWhere;
        
        $idGroup = Yii::app()->user->getGroupId();
		//$groupSQL = ' AND (log.idgroup='.$idGroup.') ';
    	if ($idGroup!=2){
        	 $groupSQL = ' AND (log.idgroup='.$idGroup.') ';
        }
		$c['where'] =  $c['where'].$groupSQL;
		
        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['group'].$c['orderby'];
        $updateINT = WebbeeController::executaSQL($sql);
        
        $c['select'] = 'select date, type, module, count(*) ';
        $c['where'] = " where type = 'delete' and module = 'interaction' ".$interactionTypeWhere;
        
        $idGroup = Yii::app()->user->getGroupId();
		//$groupSQL = ' AND (log.idgroup='.$idGroup.') ';
    	if ($idGroup!=2){
        	 $groupSQL = ' AND (log.idgroup='.$idGroup.') ';
        }
		$c['where'] =  $c['where'].$groupSQL;
		
        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['group'].$c['orderby'];
        $deleteINT = WebbeeController::executaSQL($sql);
        
        // Para o restante
        $c['select'] = 'select date, type, module, count(*) ';
        $c['where'] = " where type = 'create' and module <> 'specimen' and module <> 'interaction' ";
        
        $idGroup = Yii::app()->user->getGroupId();
		//$groupSQL = ' AND (log.idgroup='.$idGroup.') ';
    	if ($idGroup!=2){
        	 $groupSQL = ' AND (log.idgroup='.$idGroup.') ';
        }
		$c['where'] =  $c['where'].$groupSQL;
		
        $sql = $c['select'].$c['from'].$c['where'].$c['group'].$c['orderby'];
        $create = WebbeeController::executaSQL($sql);
        
        $c['select'] = 'select date, type, module, count(*) ';
        $c['where'] = " where type = 'update' and module <> 'specimen' and module <> 'interaction' ";
        
        $idGroup = Yii::app()->user->getGroupId();
		//$groupSQL = ' AND (log.idgroup='.$idGroup.') ';
    	if ($idGroup!=2){
        	 $groupSQL = ' AND (log.idgroup='.$idGroup.') ';
        }
		$c['where'] =  $c['where'].$groupSQL;
		
		
        $sql = $c['select'].$c['from'].$c['where'].$c['group'].$c['orderby'];
        $update = WebbeeController::executaSQL($sql);
        
        $c['select'] = 'select date, type, module, count(*) ';
        $c['where'] = " where type = 'delete' and module <> 'specimen' and module <> 'interaction' ";
        
        $idGroup = Yii::app()->user->getGroupId();
		//$groupSQL = ' AND (log.idgroup='.$idGroup.') ';
    	if ($idGroup!=2){
        	 $groupSQL = ' AND (log.idgroup='.$idGroup.') ';
        }
		$c['where'] =  $c['where'].$groupSQL;
		
		
        $sql = $c['select'].$c['from'].$c['where'].$c['group'].$c['orderby'];
        $delete = WebbeeController::executaSQL($sql);
            
        $create = array_merge($create, $createSP, $createINT);
        $update = array_merge($update, $updateSP, $updateINT);
        $delete = array_merge($delete, $deleteSP, $deleteINT);
        
        $array = $create;
        $aux = $delete;
        
        // Create e Delete na mesma data
        for ($i = 0; $i < count($create); $i++) {
        	for ($j = 0; $j < count($delete); $j++) {
        		if ($create[$i]['date'] == $delete[$j]['date'] && $create[$i]['module'] == $delete[$j]['module']) {
        			$array[$i]['count'] = $create[$i]['count'] - $delete[$j]['count'];
					$delete[$j] = null;
        		}
        	}
        }
        
        // Delete em datas sem Create
        for ($i = 0; $i < count($delete); $i++) {
    		if ($delete[$i]) {
    			$delete[$i]['count'] = -(int)$delete[$i]['count'];
    			$array[] = $delete[$i];
    		}
    	}
    	
    	$date = array();
    	$module = array();
    	$records = array(); 
    		
    	for ($i = 0; $i < count($array); $i++) {
    		$date[] = $array[$i]['date'];
    		$module[] = $array[$i]['module'];
     	}
     	
     	// Organiza vetores em ordem crescente de data
     	array_multisort($date, SORT_ASC, $module, SORT_ASC, $array);
    	
    	for ($i = 0; $i < count($date); $i++)  {
    		for ($j = 0; $j < count($array); $j++) {
    			if ($date[$i] == $array[$j]['date'] && $module[$i] == $array[$j]['module']) {
    				$records[] = $array[$j];
    			}
    		}
    	}
    	
    	$delete = $aux;
    	
    	// Acumula registros (o nœmero de registros em uma data depende das datas anteriores)
    	$numrecords = array();
    	
    	for ($i = 0; $i < count($records); $i++) {
    		$m = $records[$i]['module'];
    		
    		if ($numrecords[$m] == null) {
    			$numrecords[$m] = 0;
    		}
    		
    		$numrecords[$m] += (int)$records[$i]['count'];
    		
    		$records[$i]['count'] = $numrecords[$m];
    	}
    	
    	$numrecords = array();
    	
    	for ($i = 0; $i < count($create); $i++) {
    		$m = $create[$i]['module'];
    		
    		if ($numrecords[$m] == null) {
    			$numrecords[$m] = 0;
    		}
    		
    		$numrecords[$m] += (int)$create[$i]['count'];
    		
    		$create[$i]['count'] = $numrecords[$m];
    	}
    	
    	$numrecords = array();
    	
    	for ($i = 0; $i < count($update); $i++) {
    		$m = $update[$i]['module'];
    		
    		if ($numrecords[$m] == null) {
    			$numrecords[$m] = 0;
    		}
    		
    		$numrecords[$m] += (int)$update[$i]['count'];
    		
    		$update[$i]['count'] = $numrecords[$m];
    	}
    	
    	$numrecords = array();
    	
    	for ($i = 0; $i < count($delete); $i++) {
    		$m = $delete[$i]['module'];
    		
    		if ($numrecords[$m] == null) {
    			$numrecords[$m] = 0;
    		}
    		
    		$numrecords[$m] += (int)$delete[$i]['count'];
    		
    		$delete[$i]['count'] = $numrecords[$m];
    	}
        
        // Define par‰metros de sa’da
        $rs['records'] = $records;
        $rs['create'] = $create;
        $rs['update'] = $update;
        $rs['delete'] = $delete;
        return $rs;
    }
    public function search($q) {
        //Main fields
        $institutionCodeLogic = new InstitutionCodeLogic();
        $institutionCodeList = $institutionCodeLogic->searchList($q);
        $collectionCodeLogic = new CollectionCodeLogic();
        $collectionCodeList = $collectionCodeLogic->searchList($q);
        $scientificNameLogic = new ScientificNameLogic();
        $scientificNameList = $scientificNameLogic->searchList($q);
        $basisOfRecordLogic = new BasisOfRecordLogic();
        $basisOfRecordList = $basisOfRecordLogic->search($q);

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
        
        //Interaction
        $interactionTypeLogic = new InteractionTypeLogic();
        $interactionTypeList = $interactionTypeLogic->search($q);

        $rs = array();

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

        $rs[] = array("controller" => "catalognumber","id" => $q,"label" => $q, "category" => "Catalog Number");

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
        
        //Interaction
        
        foreach($interactionTypeList as $n=>$ar) {
            $rs[] = array("controller" => "interactiontype","id" => $ar->idinteractiontype,"label" => $ar->interactiontype,"category" => "Interaction type");
        }

        return $rs;
    }
    
    public function getDataQualityInfo($filter) {
    	$rs = array(); // resposta
    	$c = array(); // sql
    	
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

    	
    	$c['select'] = 'SELECT count(*) ';
	    $c['from'] = ' FROM specimen sp ';
	    
	    // get total de registros
	    $c['join'] = ' LEFT JOIN recordlevelelement r ON sp.idrecordlevelelement = r.idrecordlevelelement ';
        $c['join'] = $c['join'].' LEFT JOIN basisofrecord b ON r.idbasisofrecord = b.idbasisofrecord ';
        $c['join'] = $c['join'].' LEFT JOIN institutioncode inst ON r.idinstitutioncode = inst.idinstitutioncode ';
        $c['join'] = $c['join'].' LEFT JOIN collectioncode coll ON r.idcollectioncode = coll.idcollectioncode ';
        $c['join'] = $c['join'].' LEFT JOIN occurrenceelement o ON sp.idoccurrenceelement = o.idoccurrenceelement ';
        $c['join'] = $c['join'].' LEFT JOIN taxonomicelement t ON sp.idtaxonomicelement = t.idtaxonomicelement  ';
        $c['join'] = $c['join'].' LEFT JOIN scientificname scn ON t.idscientificname = scn.idscientificname  ';
        $c['join'] = $c['join'].' LEFT JOIN localityelement l ON sp.idlocalityelement = l.idlocalityelement ';

        $c['where'] = ' WHERE 1 = 1 ';
        $c['where'] .= $institutionCodeWhere.$collectionCodeWhere.$scientificNameWhere.$basisOfRecordWhere.$catalogNumberWhere.
                $kingdomWhere.$phylumWhere.$classWhere.$orderWhere.$familyWhere.$genusWhere.$subgenusWhere.$specificEpithetWhere.
                $countryWhere.$stateProvinceWhere.$countyWhere.$municipalityWhere.$localityWhere;
        
        $idGroup = Yii::app()->user->getGroupId();
		
   		if ($idGroup!=2){
        	 $groupSQL = ' AND (sp.idgroup='.$idGroup.') ';
        }
        
		$c['where'] =  $c['where'].$groupSQL;
		
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
        $rs['total'] = WebbeeController::executaSQL($sql);
        
        // get total de registros referenciados
        $c['join'] = ' LEFT JOIN localityelement l ON sp.idlocalityelement = l.idlocalityelement ';
        $c['join'] = $c['join'].' LEFT JOIN recordlevelelement r ON sp.idrecordlevelelement = r.idrecordlevelelement ';
        $c['join'] = $c['join'].' LEFT JOIN basisofrecord b ON r.idbasisofrecord = b.idbasisofrecord ';
        $c['join'] = $c['join'].' LEFT JOIN institutioncode inst ON r.idinstitutioncode = inst.idinstitutioncode ';
        $c['join'] = $c['join'].' LEFT JOIN collectioncode coll ON r.idcollectioncode = coll.idcollectioncode ';
        $c['join'] = $c['join'].' LEFT JOIN occurrenceelement o ON sp.idoccurrenceelement = o.idoccurrenceelement ';
        $c['join'] = $c['join'].' LEFT JOIN taxonomicelement t ON sp.idtaxonomicelement = t.idtaxonomicelement  ';
        $c['join'] = $c['join'].' LEFT JOIN scientificname scn ON t.idscientificname = scn.idscientificname  ';

        $c['where'] = ' WHERE (l.googlevalidation = TRUE OR l.geonamesvalidation = TRUE OR l.biogeomancervalidation = TRUE OR l.geolocatevalidation = TRUE) ';
        $c['where'] .= $institutionCodeWhere.$collectionCodeWhere.$scientificNameWhere.$basisOfRecordWhere.$catalogNumberWhere.
                $kingdomWhere.$phylumWhere.$classWhere.$orderWhere.$familyWhere.$genusWhere.$subgenusWhere.$specificEpithetWhere.
                $countryWhere.$stateProvinceWhere.$countyWhere.$municipalityWhere.$localityWhere;
        
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
        $rs['referenced'] = WebbeeController::executaSQL($sql);
        
        // get total de registros v‡lidos segundo o COL
        $c['join'] = ' LEFT JOIN taxonomicelement t ON sp.idtaxonomicelement = t.idtaxonomicelement ';
        $c['join'] = $c['join'].' LEFT JOIN recordlevelelement r ON sp.idrecordlevelelement = r.idrecordlevelelement ';
        $c['join'] = $c['join'].' LEFT JOIN basisofrecord b ON r.idbasisofrecord = b.idbasisofrecord ';
        $c['join'] = $c['join'].' LEFT JOIN institutioncode inst ON r.idinstitutioncode = inst.idinstitutioncode ';
        $c['join'] = $c['join'].' LEFT JOIN collectioncode coll ON r.idcollectioncode = coll.idcollectioncode ';
        $c['join'] = $c['join'].' LEFT JOIN occurrenceelement o ON sp.idoccurrenceelement = o.idoccurrenceelement ';
        $c['join'] = $c['join'].' LEFT JOIN scientificname scn ON t.idscientificname = scn.idscientificname  ';
        $c['join'] = $c['join'].' LEFT JOIN localityelement l ON sp.idlocalityelement = l.idlocalityelement ';
        
        $c['where'] = ' WHERE t.colvalidation = TRUE ';
        $c['where'] .= $institutionCodeWhere.$collectionCodeWhere.$scientificNameWhere.$basisOfRecordWhere.$catalogNumberWhere.
                $kingdomWhere.$phylumWhere.$classWhere.$orderWhere.$familyWhere.$genusWhere.$subgenusWhere.$specificEpithetWhere.
                $countryWhere.$stateProvinceWhere.$countyWhere.$municipalityWhere.$localityWhere;
        
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
        $rs['colvalid'] = WebbeeController::executaSQL($sql);
        
        $rs['sql'] = $sql;
        
        // get total de registros com data de evento
        $c['join'] = ' LEFT JOIN eventelement e ON sp.ideventelement = e.ideventelement ';
        $c['join'] = $c['join'].' LEFT JOIN recordlevelelement r ON sp.idrecordlevelelement = r.idrecordlevelelement ';
        $c['join'] = $c['join'].' LEFT JOIN basisofrecord b ON r.idbasisofrecord = b.idbasisofrecord ';
        $c['join'] = $c['join'].' LEFT JOIN institutioncode inst ON r.idinstitutioncode = inst.idinstitutioncode ';
        $c['join'] = $c['join'].' LEFT JOIN collectioncode coll ON r.idcollectioncode = coll.idcollectioncode ';
        $c['join'] = $c['join'].' LEFT JOIN occurrenceelement o ON sp.idoccurrenceelement = o.idoccurrenceelement ';
        $c['join'] = $c['join'].' LEFT JOIN taxonomicelement t ON sp.idtaxonomicelement = t.idtaxonomicelement ';
        $c['join'] = $c['join'].' LEFT JOIN scientificname scn ON t.idscientificname = scn.idscientificname  ';
        $c['join'] = $c['join'].' LEFT JOIN localityelement l ON sp.idlocalityelement = l.idlocalityelement ';
        
        $c['where'] = ' WHERE e.eventdate IS NOT NULL ';
        $c['where'] .= $institutionCodeWhere.$collectionCodeWhere.$scientificNameWhere.$basisOfRecordWhere.$catalogNumberWhere.
                $kingdomWhere.$phylumWhere.$classWhere.$orderWhere.$familyWhere.$genusWhere.$subgenusWhere.$specificEpithetWhere.
                $countryWhere.$stateProvinceWhere.$countyWhere.$municipalityWhere.$localityWhere;
        
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
        $rs['eventdate'] = WebbeeController::executaSQL($sql);
        
        // get total de registros com incerteza nas coordenadas geogr‡ficas
        $c['join'] = ' LEFT JOIN geospatialelement g ON sp.idgeospatialelement = g.idgeospatialelement ';
        $c['join'] = $c['join'].' LEFT JOIN recordlevelelement r ON sp.idrecordlevelelement = r.idrecordlevelelement ';
        $c['join'] = $c['join'].' LEFT JOIN basisofrecord b ON r.idbasisofrecord = b.idbasisofrecord ';
        $c['join'] = $c['join'].' LEFT JOIN institutioncode inst ON r.idinstitutioncode = inst.idinstitutioncode ';
        $c['join'] = $c['join'].' LEFT JOIN collectioncode coll ON r.idcollectioncode = coll.idcollectioncode ';
        $c['join'] = $c['join'].' LEFT JOIN occurrenceelement o ON sp.idoccurrenceelement = o.idoccurrenceelement ';
        $c['join'] = $c['join'].' LEFT JOIN taxonomicelement t ON sp.idtaxonomicelement = t.idtaxonomicelement ';
        $c['join'] = $c['join'].' LEFT JOIN scientificname scn ON t.idscientificname = scn.idscientificname  ';
        $c['join'] = $c['join'].' LEFT JOIN localityelement l ON sp.idlocalityelement = l.idlocalityelement ';
        
        $c['where'] = ' WHERE g.coordinateuncertaintyinmeters IS NOT NULL ';
        $c['where'] .= $institutionCodeWhere.$collectionCodeWhere.$scientificNameWhere.$basisOfRecordWhere.$catalogNumberWhere.
                $kingdomWhere.$phylumWhere.$classWhere.$orderWhere.$familyWhere.$genusWhere.$subgenusWhere.$specificEpithetWhere.
                $countryWhere.$stateProvinceWhere.$countyWhere.$municipalityWhere.$localityWhere;
        
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
        $rs['geouncertainty'] = WebbeeController::executaSQL($sql);

        return $rs;
    }
    
    public function getTaxonRankInfo($filter) {
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
		
        $c['select'] = 'SELECT count(*) ';
        $c['from'] = ' FROM specimen sp ';
        $c['join'] = $c['join'].' LEFT JOIN recordlevelelement r ON sp.idrecordlevelelement = r.idrecordlevelelement ';
        $c['join'] = $c['join'].' LEFT JOIN basisofrecord b ON r.idbasisofrecord = b.idbasisofrecord ';
        $c['join'] = $c['join'].' LEFT JOIN institutioncode inst ON r.idinstitutioncode = inst.idinstitutioncode ';
        $c['join'] = $c['join'].' LEFT JOIN collectioncode coll ON r.idcollectioncode = coll.idcollectioncode ';
        $c['join'] = $c['join'].' LEFT JOIN occurrenceelement o ON sp.idoccurrenceelement = o.idoccurrenceelement ';
        $c['join'] = $c['join'].' LEFT JOIN localityelement l ON sp.idlocalityelement = l.idlocalityelement ';
        $c['join'] = $c['join'].' LEFT JOIN taxonomicelement t ON sp.idtaxonomicelement = t.idtaxonomicelement  ';
        $c['join'] = $c['join'].' LEFT JOIN scientificname scn ON t.idscientificname = scn.idscientificname  ';
        $c['where'] = ' WHERE 1 = 1 '.$institutionCodeWhere.$collectionCodeWhere.$scientificNameWhere.$basisOfRecordWhere.$catalogNumberWhere.
                $kingdomWhere.$phylumWhere.$classWhere.$orderWhere.$familyWhere.$genusWhere.$subgenusWhere.$specificEpithetWhere.
                $countryWhere.$stateProvinceWhere.$countyWhere.$municipalityWhere.$localityWhere;
        
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
        $rs['total'] = WebbeeController::executaSQL($sql);
        
        $c['taxonRank'] = " AND t.idscientificname IS NOT NULL ";
        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['taxonRank'];
        $rs['scientificname'] = WebbeeController::executaSQL($sql);
        
        $c['taxonRank'] = " AND t.idgenus IS NOT NULL AND t.idscientificname IS NULL ";
        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['taxonRank'];
        $rs['genus'] = WebbeeController::executaSQL($sql);
        
        $c['taxonRank'] = " AND t.idfamily IS NOT NULL AND t.idgenus IS NULL AND t.idscientificname IS NULL ";
        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['taxonRank'];
        $rs['family'] = WebbeeController::executaSQL($sql);
        
        $c['taxonRank'] = " AND t.idorder IS NOT NULL AND t.idfamily IS NULL AND t.idgenus IS NULL AND t.idscientificname IS NULL ";
        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['taxonRank'];
        $rs['order'] = WebbeeController::executaSQL($sql);
        
        $c['taxonRank'] = " AND t.idclass IS NOT NULL AND t.idorder IS NULL AND t.idfamily IS NULL AND t.idgenus IS NULL AND t.idscientificname IS NULL ";
        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['taxonRank'];
        $rs['class'] = WebbeeController::executaSQL($sql);
        
        $c['taxonRank'] = " AND t.idphylum IS NOT NULL AND t.idclass IS NULL AND t.idorder IS NULL AND t.idfamily IS NULL AND t.idgenus IS NULL AND t.idscientificname IS NULL ";
        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['taxonRank'];
        $rs['phylum'] = WebbeeController::executaSQL($sql);
        
        $c['taxonRank'] = " AND t.idkingdom IS NOT NULL AND t.idphylum IS NULL AND t.idclass IS NULL AND t.idorder IS NULL AND t.idfamily IS NULL AND t.idgenus IS NULL AND t.idscientificname IS NULL ";
        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['taxonRank'];
        $rs['kingdom'] = WebbeeController::executaSQL($sql);
        
        $c['taxonRank'] = " AND t.idkingdom IS NULL AND t.idphylum IS NULL AND t.idclass IS NULL AND t.idorder IS NULL AND t.idfamily IS NULL AND t.idgenus IS NULL AND t.idscientificname IS NULL ";
        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['taxonRank'];
        $rs['others'] = WebbeeController::executaSQL($sql);
        
        return $rs;
    }
}

    /*
    public function taxon($filter, $idkingdom, $idphylum, $idclass, $idorder, $idfamily, $idgenus, $idsubgenus, $idspecificepithet, $idinfraspecificepithet, $idscientificname) {
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
        
        // Busca por ID
        if ($idkingdom && $idphylum && $idclass && $idorder && $idfamily && $idgenus && $idsubgenus && $idspecificepithet && $idinfraspecificepithet) {
            $taxonWhere = ' AND (k.idkingdom = '.$idkingdom.') AND (p.idphylum = '.$idphylum.') AND (cla.idclass = '.$idclass.') AND (ord.idorder = '.$idorder.') AND (fam.idfamily = '.$idfamily.') AND (gen.idgenus = '.$idgenus.') AND (sub.idsubgenus = '.$idsubgenus.') AND (spec.idspecificepithet = '.$idspecificepithet.') AND (ispec.idinfraspecificepithet = '.$idinfraspecificepithet.') ';
            $taxonGroupBy = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, fam.idfamily, fam.family, gen.genus, gen.idgenus, sub.idsubgenus, sub.subgenus, spec.idspecificepithet, spec.specificepithet, ispec.idinfraspecificepithet, ispec.infraspecificepithet, scn.idscientificname, scn.scientificname ';
            $taxonSelect = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, fam.idfamily, fam.family, gen.genus, gen.idgenus, sub.idsubgenus, sub.subgenus, spec.idspecificepithet, spec.specificepithet, ispec.idinfraspecificepithet, ispec.infraspecificepithet, scn.idscientificname, scn.scientificname, count(scn.scientificname) ';
            $taxonOrderBy = ' count(scn.scientificname) ';
        }
        else if ($idkingdom && $idphylum && $idclass && $idorder && $idfamily && $idgenus && $idsubgenus && $idspecificepithet) {
            $taxonWhere = ' AND (k.idkingdom = '.$idkingdom.') AND (p.idphylum = '.$idphylum.') AND (cla.idclass = '.$idclass.') AND (ord.idorder = '.$idorder.') AND (fam.idfamily = '.$idfamily.') AND (gen.idgenus = '.$idgenus.') AND (sub.idsubgenus = '.$idsubgenus.') AND (spec.idspecificepithet = '.$idspecificepithet.') ';
            $taxonGroupBy = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, fam.idfamily, fam.family, gen.genus, gen.idgenus, sub.idsubgenus, sub.subgenus, spec.idspecificepithet, spec.specificepithet, ispec.idinfraspecificepithet, ispec.infraspecificepithet ';
            $taxonSelect = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, fam.idfamily, fam.family, gen.genus, gen.idgenus, sub.idsubgenus, sub.subgenus, spec.idspecificepithet, spec.specificepithet, ispec.idinfraspecificepithet, ispec.infraspecificepithet, count(ispec.infraspecificepithet) ';
            $taxonOrderBy = ' count(ispec.infraspecificepithet) ';
        }
        else if ($idkingdom && $idphylum && $idclass && $idorder && $idfamily && $idgenus && $idsubgenus) {
            $taxonWhere = ' AND (k.idkingdom = '.$idkingdom.') AND (p.idphylum = '.$idphylum.') AND (cla.idclass = '.$idclass.') AND (ord.idorder = '.$idorder.') AND (fam.idfamily = '.$idfamily.') AND (gen.idgenus = '.$idgenus.') AND (sub.idsubgenus = '.$idsubgenus.') ';
            $taxonGroupBy = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, fam.idfamily, fam.family, gen.genus, gen.idgenus, sub.idsubgenus, sub.subgenus, spec.idspecificepithet, spec.specificepithet ';
            $taxonSelect = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, fam.idfamily, fam.family, gen.genus, gen.idgenus, sub.idsubgenus, sub.subgenus, spec.idspecificepithet, spec.specificepithet, count(spec.specificepithet) ';
            $taxonOrderBy = ' count(spec.specificepithet) ';
        }
        else if ($idkingdom && $idphylum && $idclass && $idorder && $idfamily && $idgenus) {
            $taxonWhere = ' AND (k.idkingdom = '.$idkingdom.') AND (p.idphylum = '.$idphylum.') AND (cla.idclass = '.$idclass.') AND (ord.idorder = '.$idorder.') AND (fam.idfamily = '.$idfamily.') AND (gen.idgenus = '.$idgenus.') ';
            $taxonGroupBy = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, fam.idfamily, fam.family, gen.genus, gen.idgenus, sub.idsubgenus, sub.subgenus ';
            $taxonSelect = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, fam.idfamily, fam.family, gen.genus, gen.idgenus, sub.idsubgenus, sub.subgenus, count(sub.subgenus) ';
            $taxonOrderBy = ' count(sub.subgenus) ';
        }
        else if ($idkingdom && $idphylum && $idclass && $idorder && $idfamily) {
            $taxonWhere = ' AND (k.idkingdom = '.$idkingdom.') AND (p.idphylum = '.$idphylum.') AND (cla.idclass = '.$idclass.') AND (ord.idorder = '.$idorder.') AND (fam.idfamily = '.$idfamily.') ';
            $taxonGroupBy = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, fam.idfamily, fam.family, gen.genus, gen.idgenus ';
            $taxonSelect = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, fam.idfamily, fam.family, gen.genus, gen.idgenus, count(gen.genus) ';
            $taxonOrderBy = ' count(gen.genus) ';
        }
        else if ($idkingdom && $idphylum && $idclass && $idorder) {
            $taxonWhere = ' AND (k.idkingdom = '.$idkingdom.') AND (p.idphylum = '.$idphylum.') AND (cla.idclass = '.$idclass.') AND (ord.idorder = '.$idorder.') ';
            $taxonGroupBy = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, fam.idfamily, fam.family ';
            $taxonSelect = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, fam.idfamily, fam.family, count(fam.family) ';        
            $taxonOrderBy = ' count(fam.family) ';
        }
        else if ($idkingdom && $idphylum && $idclass) {
            $taxonWhere = ' AND (k.idkingdom = '.$idkingdom.') AND (p.idphylum = '.$idphylum.') AND (cla.idclass = '.$idclass.') ';
            $taxonGroupBy = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order ';
            $taxonSelect = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, count(ord.order) ';
            $taxonOrderBy = ' count(ord.order) ';
        }
        else if ($idkingdom && $idphylum) {
            $taxonWhere = ' AND (k.idkingdom = '.$idkingdom.') AND (p.idphylum = '.$idphylum.') ';
            $taxonGroupBy = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class ';
            $taxonSelect = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, count(cla.class) ';
            $taxonOrderBy = ' count(cla.class) ';
        }
        else if ($idkingdom) {
            $taxonWhere = ' AND (k.idkingdom = '.$idkingdom.') ';
            $taxonGroupBy = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum ';
            $taxonSelect = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, count(p.phylum) ';
            $taxonOrderBy = ' count(p.phylum) ';
        }
        else {
            $taxonGroupBy = ' k.idkingdom, k.kingdom ';
            $taxonSelect = ' k.idkingdom, k.kingdom, count(k.kingdom) ';
            $taxonOrderBy = ' count(k.kingdom) ';
        }
		
        // faz consulta do Count e manda para count
        // parametros da consulta
        
        $c['from'] = ' FROM specimen sp ';
        $c['join'] = $c['join'].' LEFT JOIN recordlevelelement r ON sp.idrecordlevelelement = r.idrecordlevelelement ';
        $c['join'] = $c['join'].' LEFT JOIN basisofrecord b ON r.idbasisofrecord = b.idbasisofrecord ';
        $c['join'] = $c['join'].' LEFT JOIN institutioncode inst ON r.idinstitutioncode = inst.idinstitutioncode ';
        $c['join'] = $c['join'].' LEFT JOIN collectioncode coll ON r.idcollectioncode = coll.idcollectioncode ';
        $c['join'] = $c['join'].' LEFT JOIN occurrenceelement o ON sp.idoccurrenceelement = o.idoccurrenceelement ';
        $c['join'] = $c['join'].' LEFT JOIN localityelement l ON sp.idlocalityelement = l.idlocalityelement ';
        $c['join'] = $c['join'].' LEFT JOIN taxonomicelement t ON sp.idtaxonomicelement = t.idtaxonomicelement ';
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
       // $c['where'] = ' WHERE 1 = 1 '.$institutionCodeWhere.$collectionCodeWhere.$scientificNameWhere.$basisOfRecordWhere.$catalogNumberWhere.
                //$kingdomWhere.$phylumWhere.$classWhere.$orderWhere.$familyWhere.$genusWhere.$subgenusWhere.$specificEpithetWhere.
                //$countryWhere.$stateProvinceWhere.$countyWhere.$municipalityWhere.$localityWhere;
        $c['where'] = ' WHERE 1 = 1 '.$taxonWhere.$institutionCodeWhere.$collectionCodeWhere.$scientificNameWhere.$basisOfRecordWhere.$catalogNumberWhere.
                $kingdomWhere.$phylumWhere.$classWhere.$orderWhere.$familyWhere.$genusWhere.$subgenusWhere.$specificEpithetWhere.
                $countryWhere.$stateProvinceWhere.$countyWhere.$municipalityWhere.$localityWhere;;
        $c['orderby'] = ' ORDER BY '.$taxonOrderBy.' DESC ';
        $c['group'] = ' group by '.$taxonGroupBy;

        // junta tudo
        $c['select'] = 'SELECT count(*) ';
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
        $rs['total'] = WebbeeController::executaSQL($sql);
        $c['select'] = 'SELECT '.$taxonSelect;
        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['group'].$c['orderby'];
        // faz consulta e manda para list
        $rs['list'] = WebbeeController::executaSQL($sql);
        return $rs;
    }
    */
        /*public function taxon($filter) {
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
        */
        // Busca por ID
        /*if ($idkingdom && $idphylum && $idclass && $idorder && $idfamily && $idgenus && $idsubgenus && $idspecificepithet && $idinfraspecificepithet) {
            $taxonWhere = ' AND (k.idkingdom = '.$idkingdom.') AND (p.idphylum = '.$idphylum.') AND (cla.idclass = '.$idclass.') AND (ord.idorder = '.$idorder.') AND (fam.idfamily = '.$idfamily.') AND (gen.idgenus = '.$idgenus.') AND (sub.idsubgenus = '.$idsubgenus.') AND (spec.idspecificepithet = '.$idspecificepithet.') AND (ispec.idinfraspecificepithet = '.$idinfraspecificepithet.') ';
            $taxonGroupBy = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, fam.idfamily, fam.family, gen.genus, gen.idgenus, sub.idsubgenus, sub.subgenus, spec.idspecificepithet, spec.specificepithet, ispec.idinfraspecificepithet, ispec.infraspecificepithet, scn.idscientificname, scn.scientificname ';
            $taxonSelect = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, fam.idfamily, fam.family, gen.genus, gen.idgenus, sub.idsubgenus, sub.subgenus, spec.idspecificepithet, spec.specificepithet, ispec.idinfraspecificepithet, ispec.infraspecificepithet, scn.idscientificname, scn.scientificname, count(scn.scientificname) ';
            $taxonOrderBy = ' count(scn.scientificname) ';
        }
        else if ($idkingdom && $idphylum && $idclass && $idorder && $idfamily && $idgenus && $idsubgenus && $idspecificepithet) {
            $taxonWhere = ' AND (k.idkingdom = '.$idkingdom.') AND (p.idphylum = '.$idphylum.') AND (cla.idclass = '.$idclass.') AND (ord.idorder = '.$idorder.') AND (fam.idfamily = '.$idfamily.') AND (gen.idgenus = '.$idgenus.') AND (sub.idsubgenus = '.$idsubgenus.') AND (spec.idspecificepithet = '.$idspecificepithet.') ';
            $taxonGroupBy = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, fam.idfamily, fam.family, gen.genus, gen.idgenus, sub.idsubgenus, sub.subgenus, spec.idspecificepithet, spec.specificepithet, ispec.idinfraspecificepithet, ispec.infraspecificepithet ';
            $taxonSelect = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, fam.idfamily, fam.family, gen.genus, gen.idgenus, sub.idsubgenus, sub.subgenus, spec.idspecificepithet, spec.specificepithet, ispec.idinfraspecificepithet, ispec.infraspecificepithet, count(ispec.infraspecificepithet) ';
            $taxonOrderBy = ' count(ispec.infraspecificepithet) ';
        }
        else if ($idkingdom && $idphylum && $idclass && $idorder && $idfamily && $idgenus && $idsubgenus) {
            $taxonWhere = ' AND (k.idkingdom = '.$idkingdom.') AND (p.idphylum = '.$idphylum.') AND (cla.idclass = '.$idclass.') AND (ord.idorder = '.$idorder.') AND (fam.idfamily = '.$idfamily.') AND (gen.idgenus = '.$idgenus.') AND (sub.idsubgenus = '.$idsubgenus.') ';
            $taxonGroupBy = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, fam.idfamily, fam.family, gen.genus, gen.idgenus, sub.idsubgenus, sub.subgenus, spec.idspecificepithet, spec.specificepithet ';
            $taxonSelect = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, fam.idfamily, fam.family, gen.genus, gen.idgenus, sub.idsubgenus, sub.subgenus, spec.idspecificepithet, spec.specificepithet, count(spec.specificepithet) ';
            $taxonOrderBy = ' count(spec.specificepithet) ';
        }
        else if ($idkingdom && $idphylum && $idclass && $idorder && $idfamily && $idgenus) {
            $taxonWhere = ' AND (k.idkingdom = '.$idkingdom.') AND (p.idphylum = '.$idphylum.') AND (cla.idclass = '.$idclass.') AND (ord.idorder = '.$idorder.') AND (fam.idfamily = '.$idfamily.') AND (gen.idgenus = '.$idgenus.') ';
            $taxonGroupBy = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, fam.idfamily, fam.family, gen.genus, gen.idgenus, sub.idsubgenus, sub.subgenus ';
            $taxonSelect = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, fam.idfamily, fam.family, gen.genus, gen.idgenus, sub.idsubgenus, sub.subgenus, count(sub.subgenus) ';
            $taxonOrderBy = ' count(sub.subgenus) ';
        }
        else if ($idkingdom && $idphylum && $idclass && $idorder && $idfamily) {
            $taxonWhere = ' AND (k.idkingdom = '.$idkingdom.') AND (p.idphylum = '.$idphylum.') AND (cla.idclass = '.$idclass.') AND (ord.idorder = '.$idorder.') AND (fam.idfamily = '.$idfamily.') ';
            $taxonGroupBy = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, fam.idfamily, fam.family, gen.genus, gen.idgenus ';
            $taxonSelect = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, fam.idfamily, fam.family, gen.genus, gen.idgenus, count(gen.genus) ';
            $taxonOrderBy = ' count(gen.genus) ';
        }
        else if ($idkingdom && $idphylum && $idclass && $idorder) {
            $taxonWhere = ' AND (k.idkingdom = '.$idkingdom.') AND (p.idphylum = '.$idphylum.') AND (cla.idclass = '.$idclass.') AND (ord.idorder = '.$idorder.') ';
            $taxonGroupBy = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, fam.idfamily, fam.family ';
            $taxonSelect = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, fam.idfamily, fam.family, count(fam.family) ';        
            $taxonOrderBy = ' count(fam.family) ';
        }
        else if ($idkingdom && $idphylum && $idclass) {
            $taxonWhere = ' AND (k.idkingdom = '.$idkingdom.') AND (p.idphylum = '.$idphylum.') AND (cla.idclass = '.$idclass.') ';
            $taxonGroupBy = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order ';
            $taxonSelect = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, ord.idorder, ord.order, count(ord.order) ';
            $taxonOrderBy = ' count(ord.order) ';
        }
        else if ($idkingdom && $idphylum) {
            $taxonWhere = ' AND (k.idkingdom = '.$idkingdom.') AND (p.idphylum = '.$idphylum.') ';
            $taxonGroupBy = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class ';
            $taxonSelect = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, cla.idclass, cla.class, count(cla.class) ';
            $taxonOrderBy = ' count(cla.class) ';
        }
        else if ($idkingdom) {
            $taxonWhere = ' AND (k.idkingdom = '.$idkingdom.') ';
            $taxonGroupBy = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum ';
            $taxonSelect = ' k.kingdom, k.idkingdom, p.phylum, p.idphylum, count(p.phylum) ';
            $taxonOrderBy = ' count(p.phylum) ';
        }
        else {
            $taxonGroupBy = ' k.idkingdom, k.kingdom ';
            $taxonSelect = ' k.idkingdom, k.kingdom, count(k.kingdom) ';
            $taxonOrderBy = ' count(k.kingdom) ';
        }*/
        /*
        $taxon = array();
        
        $index = 0;
        
        $taxonGroupBy = ' k.idkingdom, k.kingdom ';
        $taxonSelect = ' k.idkingdom, k.kingdom, count(*) ';
        $taxonOrderBy = ' count(*) ';
        
        $c['from'] = ' FROM specimen sp ';
        $c['join'] = $c['join'].' LEFT JOIN recordlevelelement r ON sp.idrecordlevelelement = r.idrecordlevelelement ';
        $c['join'] = $c['join'].' LEFT JOIN basisofrecord b ON r.idbasisofrecord = b.idbasisofrecord ';
        $c['join'] = $c['join'].' LEFT JOIN institutioncode inst ON r.idinstitutioncode = inst.idinstitutioncode ';
        $c['join'] = $c['join'].' LEFT JOIN collectioncode coll ON r.idcollectioncode = coll.idcollectioncode ';
        $c['join'] = $c['join'].' LEFT JOIN occurrenceelement o ON sp.idoccurrenceelement = o.idoccurrenceelement ';
        $c['join'] = $c['join'].' LEFT JOIN localityelement l ON sp.idlocalityelement = l.idlocalityelement ';
        $c['join'] = $c['join'].' LEFT JOIN taxonomicelement t ON sp.idtaxonomicelement = t.idtaxonomicelement ';
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
        
        $c['where'] = ' WHERE 1 = 1 '.$taxonWhere.$institutionCodeWhere.$collectionCodeWhere.$scientificNameWhere.$basisOfRecordWhere.$catalogNumberWhere.$kingdomWhere.$phylumWhere.$classWhere.$orderWhere.$familyWhere.$genusWhere.$subgenusWhere.$specificEpithetWhere. $countryWhere.$stateProvinceWhere.$countyWhere.$municipalityWhere.$localityWhere;
        $c['orderby'] = ' ORDER BY '.$taxonOrderBy.' DESC ';
        $c['group'] = ' GROUP BY '.$taxonGroupBy;
             
		$c['select'] = 'SELECT count(*) ';
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
        $totalk = WebbeeController::executaSQL($sql);
        $totalk = (float)$totalk[0]['count'];
        $c['select'] = 'SELECT '.$taxonSelect;   
        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['group'].$c['orderby'];        
        $kingdom = WebbeeController::executaSQL($sql);
        
        // Kingdom
       	foreach ($kingdom as $ik => $k) {       		
   			$ar = array('id'=>'0'.($k['idkingdom']==null?'_NULL':'_'.$k['idkingdom']), 'name'=>($k['idkingdom']==null?'<strong>No Kingdom</strong><br>('.$k['count'].', '.round(100*$k['count']/$totalk, 2).'%)':'<strong>Kingdom</strong><br>'.$k['kingdom'].'<br>('.$k['count'].', '.round(100*$k['count']/$totalk, 2).'%)'));
   			$taxon[] = $ar;
   			$index++;

   			$taxonWhere = ' AND (k.idkingdom '.($k['idkingdom']==null?'IS NULL':'= '.$k['idkingdom']).') ';
        	$taxonGroupBy = ' p.idphylum, p.phylum ';
        	$taxonSelect = ' p.idphylum, p.phylum, count(*) ';
        	$taxonOrderBy = ' count(*) ';
        	
        	$c['where'] = ' WHERE 1 = 1 '.$taxonWhere.$institutionCodeWhere.$collectionCodeWhere.$scientificNameWhere.$basisOfRecordWhere.$catalogNumberWhere.$kingdomWhere.$phylumWhere.$classWhere.$orderWhere.$familyWhere.$genusWhere.$subgenusWhere.$specificEpithetWhere. $countryWhere.$stateProvinceWhere.$countyWhere.$municipalityWhere.$localityWhere;
	        $c['orderby'] = ' ORDER BY '.$taxonOrderBy.' DESC ';
	        $c['group'] = ' GROUP BY '.$taxonGroupBy;
	        
	        $c['select'] = 'SELECT count(*) ';
        	$sql = $c['select'].$c['from'].$c['join'].$c['where'];
        	$totalp = WebbeeController::executaSQL($sql);
        	$totalp = (float)$totalp[0]['count'];
	        $c['select'] = 'SELECT '.$taxonSelect;        
	        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['group'].$c['orderby'];	       	
	       	$phylum = WebbeeController::executaSQL($sql);
	       	
	       	// Phylum
	       	foreach ($phylum as $ip => $p) {
       			$ar = array('id'=>'1'.($k['idkingdom']==null?'_NULL':'_'.$k['idkingdom']).($p['idphylum']==null?'_NULL':'_'.$p['idphylum']), 'name'=>($p['idphylum']==null?'<strong>No Phylum</strong><br>('.$p['count'].', '.round(100*$p['count']/$totalp, 2).'%)':'<strong>Phylum</strong><br>'.$p['phylum'].'<br>('.$p['count'].', '.round(100*$p['count']/$totalp, 2).'%)'));
	   			$taxon[$ik]['children'][] = $ar;
	   			$index++;
	   			
	   			/*	   		
	   			$taxonWhere = ' AND (k.idkingdom '.($k['idkingdom']==null?'IS NULL':'= '.$k['idkingdom']).') AND (p.idphylum '.($p['idphylum']==null?'IS NULL':'= '.$p['idphylum']).') ';
	        	$taxonGroupBy = ' cla.idclass, cla.class ';
	        	$taxonSelect = ' cla.idclass, cla.class, count(*) ';
	        	$taxonOrderBy = ' count(*) ';
	        	
	        	$c['where'] = ' WHERE 1 = 1 '.$taxonWhere.$institutionCodeWhere.$collectionCodeWhere.$scientificNameWhere.$basisOfRecordWhere.$catalogNumberWhere.$kingdomWhere.$phylumWhere.$classWhere.$orderWhere.$familyWhere.$genusWhere.$subgenusWhere.$specificEpithetWhere. $countryWhere.$stateProvinceWhere.$countyWhere.$municipalityWhere.$localityWhere;
		        $c['orderby'] = ' ORDER BY '.$taxonOrderBy.' DESC ';
		        $c['group'] = ' GROUP BY '.$taxonGroupBy;		        
		        
		        $c['select'] = 'SELECT count(*) ';
	        	$sql = $c['select'].$c['from'].$c['join'].$c['where'];
	        	$totalcla = WebbeeController::executaSQL($sql);
	        	$totalcla = (float)$totalcla[0]['count'];
		        $c['select'] = 'SELECT '.$taxonSelect;        
		        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['group'].$c['orderby'];	       	
		       	$class = WebbeeController::executaSQL($sql);
		       	
		       	// Class
		       	foreach ($class as $icla => $cla) {
		       		$ar = array('id'=>'idclass_'.($cla['idclass']==null?'NULL'.'_'.$index:$cla['idclass'].'_'.$index), 'name'=>($cla['idclass']==null?'<strong>No Class</strong><br>('.$cla['count'].', '.round(100*$cla['count']/$totalcla, 2).'%)':'<strong>Class</strong><br>'.$cla['class'].'<br>('.$cla['count'].', '.round(100*$cla['count']/$totalcla, 2).'%)'));
	   				$taxon[$ik]['children'][$ip]['children'][] = $ar;
	   				$index++;
	   				
	   				$taxonWhere = ' AND (k.idkingdom '.($k['idkingdom']==null?'IS NULL':'= '.$k['idkingdom']).') AND (p.idphylum '.($p['idphylum']==null?'IS NULL':'= '.$p['idphylum']).') AND (cla.idclass '.($cla['idclass']==null?'IS NULL':'= '.$cla['idclass']).')';
		        	$taxonGroupBy = ' ord.idorder, ord.order ';
		        	$taxonSelect = ' ord.idorder, ord.order, count(*) ';
		        	$taxonOrderBy = ' count(*) ';
		        	
		        	$c['where'] = ' WHERE 1 = 1 '.$taxonWhere.$institutionCodeWhere.$collectionCodeWhere.$scientificNameWhere.$basisOfRecordWhere.$catalogNumberWhere.$kingdomWhere.$phylumWhere.$classWhere.$orderWhere.$familyWhere.$genusWhere.$subgenusWhere.$specificEpithetWhere. $countryWhere.$stateProvinceWhere.$countyWhere.$municipalityWhere.$localityWhere;
			        $c['orderby'] = ' ORDER BY '.$taxonOrderBy.' DESC ';
			        $c['group'] = ' GROUP BY '.$taxonGroupBy;
			        
			        $c['select'] = 'SELECT count(*) ';			        
		        	$sql = $c['select'].$c['from'].$c['join'].$c['where'];
		        	$totalord = WebbeeController::executaSQL($sql);
		        	$totalord = (float)$totalord[0]['count'];
			        $c['select'] = 'SELECT '.$taxonSelect;        
			        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['group'].$c['orderby'];	       	
			       	$order = WebbeeController::executaSQL($sql);
			       	
			       	// Order
			       	foreach ($order as $iord => $ord) {
			       		$ar = array('id'=>'idorder_'.($ord['idorder']==null?'NULL'.'_'.$index:$ord['idorder'].'_'.$index), 'name'=>($ord['idorder']==null?'<strong>No Order</strong><br>('.$ord['count'].', '.round(100*$ord['count']/$totalord, 2).'%)':'<strong>Order</strong><br>'.$ord['order'].'<br>('.$ord['count'].', '.round(100*$ord['count']/$totalord, 2).'%)'));
		   				$taxon[$ik]['children'][$ip]['children'][$icla]['children'][] = $ar;
		   				$index++;
		   				
		   				$taxonWhere = ' AND (k.idkingdom '.($k['idkingdom']==null?'IS NULL':'= '.$k['idkingdom']).') AND (p.idphylum '.($p['idphylum']==null?'IS NULL':'= '.$p['idphylum']).') AND (cla.idclass '.($cla['idclass']==null?'IS NULL':'= '.$cla['idclass']).') AND (ord.idorder '.($ord['idorder']==null?'IS NULL':'= '.$ord['idorder']).')';
			        	$taxonGroupBy = ' fam.idfamily, fam.family ';
			        	$taxonSelect = ' fam.idfamily, fam.family, count(*) ';
			        	$taxonOrderBy = ' count(*) ';
			        	
			        	$c['where'] = ' WHERE 1 = 1 '.$taxonWhere.$institutionCodeWhere.$collectionCodeWhere.$scientificNameWhere.$basisOfRecordWhere.$catalogNumberWhere.$kingdomWhere.$phylumWhere.$classWhere.$orderWhere.$familyWhere.$genusWhere.$subgenusWhere.$specificEpithetWhere. $countryWhere.$stateProvinceWhere.$countyWhere.$municipalityWhere.$localityWhere;
				        $c['orderby'] = ' ORDER BY '.$taxonOrderBy.' DESC ';
				        $c['group'] = ' GROUP BY '.$taxonGroupBy;
				        
				        $c['select'] = 'SELECT count(*) ';			        
			        	$sql = $c['select'].$c['from'].$c['join'].$c['where'];
			        	$totalfam = WebbeeController::executaSQL($sql);
			        	$totalfam = (float)$totalfam[0]['count'];
				        $c['select'] = 'SELECT '.$taxonSelect;        
				        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['group'].$c['orderby'];	       	
				       	$family = WebbeeController::executaSQL($sql);
				       	
				       	// Family
				       	foreach ($family as $ifam => $fam) {
				       		$ar = array('id'=>'idfamily_'.($fam['idfamily']==null?'NULL'.'_'.$index:$fam['idfamily'].'_'.$index), 'name'=>($fam['idfamily']==null?'<strong>No Family</strong><br>('.$fam['count'].', '.round(100*$fam['count']/$totalfam, 2).'%)':'<strong>Family</strong><br>'.$fam['family'].'<br>('.$fam['count'].', '.round(100*$fam['count']/$totalfam, 2).'%)'));
			   				$taxon[$ik]['children'][$ip]['children'][$icla]['children'][$iord]['children'][] = $ar;
			   				$index++;
			   				
			   				$taxonWhere = ' AND (k.idkingdom '.($k['idkingdom']==null?'IS NULL':'= '.$k['idkingdom']).') AND (p.idphylum '.($p['idphylum']==null?'IS NULL':'= '.$p['idphylum']).') AND (cla.idclass '.($cla['idclass']==null?'IS NULL':'= '.$cla['idclass']).') AND (ord.idorder '.($ord['idorder']==null?'IS NULL':'= '.$ord['idorder']).') AND (fam.idfamily '.($fam['idfamily']==null?'IS NULL':'= '.$fam['idfamily']).')';
				        	$taxonGroupBy = ' gen.idgenus, gen.genus ';
							$taxonSelect = ' gen.idgenus, gen.genus, count(*) ';
							$taxonOrderBy = ' count(*) ';
				        	
				        	$c['where'] = ' WHERE 1 = 1 '.$taxonWhere.$institutionCodeWhere.$collectionCodeWhere.$scientificNameWhere.$basisOfRecordWhere.$catalogNumberWhere.$kingdomWhere.$phylumWhere.$classWhere.$orderWhere.$familyWhere.$genusWhere.$subgenusWhere.$specificEpithetWhere. $countryWhere.$stateProvinceWhere.$countyWhere.$municipalityWhere.$localityWhere;
					        $c['orderby'] = ' ORDER BY '.$taxonOrderBy.' DESC ';
					        $c['group'] = ' GROUP BY '.$taxonGroupBy;
					        
					        $c['select'] = 'SELECT count(*) ';			        
				        	$sql = $c['select'].$c['from'].$c['join'].$c['where'];
				        	$totalgen = WebbeeController::executaSQL($sql);
				        	$totalgen = (float)$totalgen[0]['count'];
					        $c['select'] = 'SELECT '.$taxonSelect;        
					        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['group'].$c['orderby'];	       	
					       	$genus = WebbeeController::executaSQL($sql);
					       	
					       	// Genus
					       	foreach ($genus as $igen => $gen) {
					       		$ar = array('id'=>'idgenus_'.($gen['idgenus']==null?'NULL'.'_'.$index:$gen['idgenus'].'_'.$index), 'name'=>($gen['idgenus']==null?'<strong>No Genus</strong><br>('.$gen['count'].', '.round(100*$gen['count']/$totalgen, 2).'%)':'<strong>Genus</strong><br>'.$gen['genus'].'<br>('.$gen['count'].', '.round(100*$gen['count']/$totalgen, 2).'%)'));
				   				$taxon[$ik]['children'][$ip]['children'][$icla]['children'][$iord]['children'][$ifam]['children'][] = $ar;
				   				$index++;
				   				
				   				$taxonWhere = ' AND (k.idkingdom '.($k['idkingdom']==null?'IS NULL':'= '.$k['idkingdom']).') AND (p.idphylum '.($p['idphylum']==null?'IS NULL':'= '.$p['idphylum']).') AND (cla.idclass '.($cla['idclass']==null?'IS NULL':'= '.$cla['idclass']).') AND (ord.idorder '.($ord['idorder']==null?'IS NULL':'= '.$ord['idorder']).') AND (fam.idfamily '.($fam['idfamily']==null?'IS NULL':'= '.$fam['idfamily']).') AND (gen.idgenus '.($gen['idgenus']==null?'IS NULL':'= '.$gen['idgenus']).')';
					        	$taxonGroupBy = ' sub.idsubgenus, sub.subgenus ';
								$taxonSelect = ' sub.idsubgenus, sub.subgenus, count(*) ';
								$taxonOrderBy = ' count(*) ';
					        	
					        	$c['where'] = ' WHERE 1 = 1 '.$taxonWhere.$institutionCodeWhere.$collectionCodeWhere.$scientificNameWhere.$basisOfRecordWhere.$catalogNumberWhere.$kingdomWhere.$phylumWhere.$classWhere.$orderWhere.$familyWhere.$genusWhere.$subgenusWhere.$specificEpithetWhere. $countryWhere.$stateProvinceWhere.$countyWhere.$municipalityWhere.$localityWhere;
						        $c['orderby'] = ' ORDER BY '.$taxonOrderBy.' DESC ';
						        $c['group'] = ' GROUP BY '.$taxonGroupBy;
						        
						        $c['select'] = 'SELECT count(*) ';			        
					        	$sql = $c['select'].$c['from'].$c['join'].$c['where'];
					        	$totalsub = WebbeeController::executaSQL($sql);
					        	$totalsub = (float)$totalsub[0]['count'];
						        $c['select'] = 'SELECT '.$taxonSelect;        
						        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['group'].$c['orderby'];	       	
						       	$subgenus = WebbeeController::executaSQL($sql);
						       	
						       	// Subgenus
						       	foreach ($subgenus as $isub => $sub) {
						       		$ar = array('id'=>'idsubgenus_'.($sub['idsubgenus']==null?'NULL'.'_'.$index:$sub['idsubgenus'].'_'.$index), 'name'=>($sub['idsubgenus']==null?'<strong>No Subgenus</strong><br>('.$sub['count'].', '.round(100*$sub['count']/$totalsub, 2).'%)':'<strong>Subgenus</strong><br>'.$sub['subgenus'].'<br>('.$sub['count'].', '.round(100*$sub['count']/$totalsub, 2).'%)'));
					   				$taxon[$ik]['children'][$ip]['children'][$icla]['children'][$iord]['children'][$ifam]['children'][$igen]['children'][] = $ar;
					   				$index++;
					   				
					   				$taxonWhere = ' AND (k.idkingdom '.($k['idkingdom']==null?'IS NULL':'= '.$k['idkingdom']).') AND (p.idphylum '.($p['idphylum']==null?'IS NULL':'= '.$p['idphylum']).') AND (cla.idclass '.($cla['idclass']==null?'IS NULL':'= '.$cla['idclass']).') AND (ord.idorder '.($ord['idorder']==null?'IS NULL':'= '.$ord['idorder']).') AND (fam.idfamily '.($fam['idfamily']==null?'IS NULL':'= '.$fam['idfamily']).') AND (gen.idgenus '.($gen['idgenus']==null?'IS NULL':'= '.$gen['idgenus']).') AND (sub.idsubgenus '.($sub['idsubgenus']==null?'IS NULL':'= '.$sub['idsubgenus']).')';
						        	$taxonGroupBy = ' spec.idspecificepithet, spec.specificepithet ';
									$taxonSelect = ' spec.idspecificepithet, spec.specificepithet, count(*) ';
									$taxonOrderBy = ' count(*) ';
						        	
						        	$c['where'] = ' WHERE 1 = 1 '.$taxonWhere.$institutionCodeWhere.$collectionCodeWhere.$scientificNameWhere.$basisOfRecordWhere.$catalogNumberWhere.$kingdomWhere.$phylumWhere.$classWhere.$orderWhere.$familyWhere.$genusWhere.$subgenusWhere.$specificEpithetWhere. $countryWhere.$stateProvinceWhere.$countyWhere.$municipalityWhere.$localityWhere;
							        $c['orderby'] = ' ORDER BY '.$taxonOrderBy.' DESC ';
							        $c['group'] = ' GROUP BY '.$taxonGroupBy;
							        
							        $c['select'] = 'SELECT count(*) ';			        
						        	$sql = $c['select'].$c['from'].$c['join'].$c['where'];
						        	$totalspec = WebbeeController::executaSQL($sql);
						        	$totalspec = (float)$totalspec[0]['count'];
							        $c['select'] = 'SELECT '.$taxonSelect;        
							        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['group'].$c['orderby'];	       	
							       	$specificepithet = WebbeeController::executaSQL($sql);
							       	
							       	// Specific epithet
							       	foreach ($specificepithet as $ispec => $spec) {
							       		$ar = array('id'=>'idspecificepithet_'.($spec['idspecificepithet']==null?'NULL'.'_'.$index:$spec['idspecificepithet'].'_'.$index), 'name'=>($spec['idspecificepithet']==null?'<strong>No Specific Epithet</strong><br>('.$spec['count'].', '.round(100*$spec['count']/$totalspec, 2).'%)':'<strong>Specific Epithet</strong><br>'.$spec['specificepithet'].'<br>('.$spec['count'].', '.round(100*$spec['count']/$totalspec, 2).'%)'));
						   				$taxon[$ik]['children'][$ip]['children'][$icla]['children'][$iord]['children'][$ifam]['children'][$igen]['children'][$isub]['children'][] = $ar;
						   				$index++;
						   				
						   				$taxonWhere = ' AND (k.idkingdom '.($k['idkingdom']==null?'IS NULL':'= '.$k['idkingdom']).') AND (p.idphylum '.($p['idphylum']==null?'IS NULL':'= '.$p['idphylum']).') AND (cla.idclass '.($cla['idclass']==null?'IS NULL':'= '.$cla['idclass']).') AND (ord.idorder '.($ord['idorder']==null?'IS NULL':'= '.$ord['idorder']).') AND (fam.idfamily '.($fam['idfamily']==null?'IS NULL':'= '.$fam['idfamily']).') AND (gen.idgenus '.($gen['idgenus']==null?'IS NULL':'= '.$gen['idgenus']).') AND (sub.idsubgenus '.($sub['idsubgenus']==null?'IS NULL':'= '.$sub['idsubgenus']).') AND (spec.idspecificepithet '.($spec['idspecificepithet']==null?'IS NULL':'= '.$spec['idspecificepithet']).')';
							        	$taxonGroupBy = ' ispec.idinfraspecificepithet, ispec.infraspecificepithet ';
										$taxonSelect = ' ispec.idinfraspecificepithet, ispec.infraspecificepithet, count(*) ';
										$taxonOrderBy = ' count(*) ';
							        	
							        	$c['where'] = ' WHERE 1 = 1 '.$taxonWhere.$institutionCodeWhere.$collectionCodeWhere.$scientificNameWhere.$basisOfRecordWhere.$catalogNumberWhere.$kingdomWhere.$phylumWhere.$classWhere.$orderWhere.$familyWhere.$genusWhere.$subgenusWhere.$specificEpithetWhere. $countryWhere.$stateProvinceWhere.$countyWhere.$municipalityWhere.$localityWhere;
								        $c['orderby'] = ' ORDER BY '.$taxonOrderBy.' DESC ';
								        $c['group'] = ' GROUP BY '.$taxonGroupBy;
								        
								        $c['select'] = 'SELECT count(*) ';			        
							        	$sql = $c['select'].$c['from'].$c['join'].$c['where'];
							        	$totalinfra = WebbeeController::executaSQL($sql);
							        	$totalinfra = (float)$totalinfra[0]['count'];
								        $c['select'] = 'SELECT '.$taxonSelect;        
								        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['group'].$c['orderby'];	       	
								       	$infraspecificepithet = WebbeeController::executaSQL($sql);
								       	
								       	// Infraspecific epithet
								       	foreach ($infraspecificepithet as $iinfra => $infra) {
								       		$ar = array('id'=>'idinfraspecificepithet_'.($infra['idinfraspecificepithet']==null?'NULL'.'_'.$index:$infra['idinfraspecificepithet'].'_'.$index), 'name'=>($infra['idinfraspecificepithet']==null?'<strong>No Infraspecific Epithet</strong><br>('.$infra['count'].', '.round(100*$infra['count']/$totalinfra, 2).'%)':'<strong>Infraspecific Epithet</strong><br>'.$infra['infraspecificepithet'].'<br>('.$infra['count'].', '.round(100*$infra['count']/$totalinfra, 2).'%)'));
							   				$taxon[$ik]['children'][$ip]['children'][$icla]['children'][$iord]['children'][$ifam]['children'][$igen]['children'][$isub]['children'][$ispec]['children'][] = $ar;
							   				$index++;
							   				
							   				$taxonWhere = ' AND (k.idkingdom '.($k['idkingdom']==null?'IS NULL':'= '.$k['idkingdom']).') AND (p.idphylum '.($p['idphylum']==null?'IS NULL':'= '.$p['idphylum']).') AND (cla.idclass '.($cla['idclass']==null?'IS NULL':'= '.$cla['idclass']).') AND (ord.idorder '.($ord['idorder']==null?'IS NULL':'= '.$ord['idorder']).') AND (fam.idfamily '.($fam['idfamily']==null?'IS NULL':'= '.$fam['idfamily']).') AND (gen.idgenus '.($gen['idgenus']==null?'IS NULL':'= '.$gen['idgenus']).') AND (sub.idsubgenus '.($sub['idsubgenus']==null?'IS NULL':'= '.$sub['idsubgenus']).') AND (spec.idspecificepithet '.($spec['idspecificepithet']==null?'IS NULL':'= '.$spec['idspecificepithet']).') AND (ispec.idinfraspecificepithet '.($infra['idinfraspecificepithet']==null?'IS NULL':'= '.$infra['idinfraspecificepithet']).')';
								        	$taxonGroupBy = ' scn.idscientificname, scn.scientificname ';
											$taxonSelect = ' scn.idscientificname, scn.scientificname, count(*) ';
											$taxonOrderBy = ' count(*) ';
								        	
								        	$c['where'] = ' WHERE 1 = 1 '.$taxonWhere.$institutionCodeWhere.$collectionCodeWhere.$scientificNameWhere.$basisOfRecordWhere.$catalogNumberWhere.$kingdomWhere.$phylumWhere.$classWhere.$orderWhere.$familyWhere.$genusWhere.$subgenusWhere.$specificEpithetWhere. $countryWhere.$stateProvinceWhere.$countyWhere.$municipalityWhere.$localityWhere;
									        $c['orderby'] = ' ORDER BY '.$taxonOrderBy.' DESC ';
									        $c['group'] = ' GROUP BY '.$taxonGroupBy;
									        
									        $c['select'] = 'SELECT count(*) ';			        
								        	$sql = $c['select'].$c['from'].$c['join'].$c['where'];
								        	$totalscn = WebbeeController::executaSQL($sql);
								        	$totalscn = (float)$totalscn[0]['count'];
									        $c['select'] = 'SELECT '.$taxonSelect;        
									        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['group'].$c['orderby'];	       	
									       	$scientificname = WebbeeController::executaSQL($sql);
									       	
									       	// Scientific name
									       	foreach ($scientificname as $iscn => $scn) {
									       		$ar = array('id'=>'idscientificname_'.($scn['idscientificname']==null?'NULL'.'_'.$index:$scn['idscientificname'].'_'.$index), 'name'=>($scn['idscientificname']==null?'<strong>No Scientific Name</strong><br>('.$scn['count'].', '.round(100*$scn['count']/$totalscn, 2).'%)':'<strong>Scientific Name</strong><br>'.$scn['scientificname'].'<br>('.$scn['count'].', '.round(100*$scn['count']/$totalscn, 2).'%)'));
								   				$taxon[$ik]['children'][$ip]['children'][$icla]['children'][$iord]['children'][$ifam]['children'][$igen]['children'][$isub]['children'][$ispec]['children'][$iinfra]['children'][] = $ar;
								   				$index++;   				
								   			}
							   			}
						   			}
					   			}
				   			}
			   			}
		   			}
		       	}*/
	       /*	}		         
       	}
       	
       	return $taxon;
    }*/
?>
