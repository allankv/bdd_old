<?php

class UserPanelLogic {

    public function getCollectionCodes($ic) {

        // parametros da consulta
        $c['select'] = 'SELECT DISTINCT coll.collectioncode, r.idcollectioncode ';
        $c['from'] = ' FROM specimen sp ';
        $c['join'] = $c['join'].' LEFT JOIN recordlevelelement r ON sp.idrecordlevelelement = r.idrecordlevelelement ';
        $c['join'] = $c['join'].' LEFT JOIN institutioncode inst ON r.idinstitutioncode = inst.idinstitutioncode ';
        $c['join'] = $c['join'].' LEFT JOIN collectioncode coll ON r.idcollectioncode = coll.idcollectioncode ';
        $c['where'] = ' WHERE r.idinstitutioncode = '.$ic['idinstitutioncode'];
        
     	$idGroup = Yii::app()->user->getGroupId();
		//$groupSQL = ' AND (sp.idgroup='.$idGroup.') ';
    	if ($idGroup!=2){
        	 $groupSQL = ' AND (sp.idgroup='.$idGroup.') ';
        }
        
        // junta tudo
        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$groupSQL;
        // faz consulta e manda para list
        $rs['list'] = WebbeeController::executaSQL($sql);
        // altera parametros de consulta para fazer o Count
        $c['select'] = 'SELECT count(DISTINCT coll.collectioncode) ';
        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$groupSQL;
        // faz consulta do Count e manda para count
        $rs['count'] = WebbeeController::executaSQL($sql);
        return $rs;
    }

    public function getSpecimenInfo($filter) {

        // parametros da consulta
        $c['select'] = 'SELECT c.country, s.stateprovince, m.municipality, b.basisofrecord, inst.institutioncode, coll.collectioncode, scn.scientificname, geo.decimallatitude, geo.decimallongitude ';
        $c['from'] = ' FROM specimen sp ';
        $c['join'] = $c['join'].' LEFT JOIN recordlevelelement r ON sp.idrecordlevelelement = r.idrecordlevelelement ';
        $c['join'] = $c['join'].' LEFT JOIN localityelement loc ON sp.idlocalityelement = loc.idlocalityelement ';
        $c['join'] = $c['join'].' LEFT JOIN country c ON loc.idcountry = c.idcountry ';
        $c['join'] = $c['join'].' LEFT JOIN stateprovince s ON loc.idstateprovince = s.idstateprovince ';
        $c['join'] = $c['join'].' LEFT JOIN municipality m ON loc.idmunicipality = m.idmunicipality ';
        $c['join'] = $c['join'].' LEFT JOIN basisofrecord b ON r.idbasisofrecord = b.idbasisofrecord ';
        $c['join'] = $c['join'].' LEFT JOIN institutioncode inst ON r.idinstitutioncode = inst.idinstitutioncode ';
        $c['join'] = $c['join'].' LEFT JOIN collectioncode coll ON r.idcollectioncode = coll.idcollectioncode ';
        $c['join'] = $c['join'].' LEFT JOIN taxonomicelement t ON sp.idtaxonomicelement = t.idtaxonomicelement  ';
        $c['join'] = $c['join'].' LEFT JOIN scientificname scn ON t.idscientificname = scn.idscientificname  ';
        $c['join'] = $c['join'].' LEFT JOIN geospatialelement geo ON sp.idgeospatialelement = geo.idgeospatialelement  ';
        $c['where'] = ' WHERE r.idinstitutioncode = '.$filter['idinstitutioncode'].' AND r.idcollectioncode = '.$filter['idcollectioncode'];

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
    
    
    //Not done
    public function getInteractionInfo($ic) {

        // parametros da consulta
        $c['select'] = 'SELECT DISTINCT coll.collectioncode ';
        $c['from'] = ' FROM specimen sp ';
        $c['join'] = $c['join'].' LEFT JOIN recordlevelelement r ON sp.idrecordlevelelement = r.idrecordlevelelement ';
        $c['join'] = $c['join'].' LEFT JOIN institutioncode inst ON r.idinstitutioncode = inst.idinstitutioncode ';
        $c['join'] = $c['join'].' LEFT JOIN collectioncode coll ON r.idcollectioncode = coll.idcollectioncode ';
        $c['where'] = ' WHERE r.idinstitutioncode = '.$ic['idinstitutioncode'];

        // junta tudo
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
        // faz consulta e manda para list
        $rs['list'] = WebbeeController::executaSQL($sql);
        // altera parametros de consulta para fazer o Count
        $c['select'] = 'SELECT count(DISTINCT coll.collectioncode) ';
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];
        // faz consulta do Count e manda para count
        $rs['count'] = WebbeeController::executaSQL($sql);
        return $rs;
    }
}
?>