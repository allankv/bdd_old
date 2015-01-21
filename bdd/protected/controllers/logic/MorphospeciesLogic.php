<?php
include 'TaxonomicToolLogic.php';

class MorphospeciesLogic {

    var $mainAtt = 'morphospecies';

    public function searchList($q) {
        $ar = MorphospeciesAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }

    public function search($q) {
        $mList = $this->searchList($q);
        $rs = array();
        foreach ($mList as $n => $ar) {
            $rs[] = array("controller" => "morphospecies", "id" => $ar->idmorphospecies, "label" => $ar->morphospecies, "category" => "Morphospecies");
        }
        return $rs;
    }

    public function suggestion($q) {
        $ar = MorphospeciesAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }

    public function getJSON($field, $id) {

        $ar = new MorphospeciesAR();
        $rs = array();

        $ar->morphospecies = $field;
        $ar->idmorphospecies = $id;

        if (isset($ar->idmorphospecies)) {
            $returnAR = MorphospeciesAR::model()->findByPk($ar->idmorphospecies);
        } else {
            $ar->morphospecies = trim($ar->morphospecies);
            $returnAR = MorphospeciesAR::model()->find("$this->mainAtt='" . $ar->morphospecies . "'");
        }

        if ($returnAR != null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idmorphospecies;
            $rs['field'] = $returnAR->morphospecies;
            $rs['ar'] = $returnAR;
        } else {
            $rs['success'] = false;
        }

        return $rs;
    }

    public function save($field) {

        $rs = array();
        $ar = MorphospeciesAR::model();
        $ar->morphospecies = trim($field);
	    $ar->idgroup = Yii::app()->user->getGroupId();
       
        if ($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = 'create';
            $ar->setIsNewRecord($rs['operation'] == 'create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idmorphospecies;
            $rs['field'] = $rs['ar']->morphospecies;
            $rs['ar'] = $rs['ar']->getAttributes();

            return $rs;
        } else {
            $erros = array();
            foreach ($ar->getErrors() as $n => $mensagem):
                if ($mensagem[0] != "") {
                    $erros[] = $mensagem[0];
                }
            endforeach;
            $rs['success'] = false;
            $rs['msg'] = $erros;
            return $rs;
        }
    }

    //utilizar apenas para identificar SPN
    public function identify($idmorphospecies, $species, $idspecies, $valid) {
        if ($idspecies == '') {
            $sp = new ScientificNameLogic();
            $rs = $sp->save($species, $valid);
            $idspecies = $rs["id"];
        }
        $sql = "UPDATE taxonomicelement SET colvalidation = $valid, idmorphospecies = NULL, idscientificname = $idspecies WHERE idmorphospecies = $idmorphospecies AND (colvalidation = TRUE OR colvalidation IS NULL)";
        WebbeeController::executaSQL($sql);
        $sql = "UPDATE taxonomicelement SET colvalidation = FALSE, idmorphospecies = NULL, idscientificname = $idspecies WHERE idmorphospecies = $idmorphospecies and (colvalidation = FALSE OR colvalidation IS NULL)";
        WebbeeController::executaSQL($sql);
    }
    
    public function identify_child($idmorphospecies, $species, $idspecies, $valid, $idtaxonomicelement) {
        if ($idspecies == '') {
            $sp = new ScientificNameLogic();
            $rs = $sp->save($species, $valid);
            $idspecies = $rs["id"];
        }
        $sql = "UPDATE taxonomicelement SET colvalidation = $valid, idmorphospecies=NULL, idscientificname=$idspecies WHERE idtaxonomicelement = $idtaxonomicelement AND (colvalidation = TRUE OR colvalidation IS NULL)";
        WebbeeController::executaSQL($sql);
        $sql = "UPDATE taxonomicelement SET colvalidation = FALSE, idmorphospecies=NULL, idscientificname=$idspecies WHERE idtaxonomicelement = $idtaxonomicelement AND (colvalidation = FALSE OR colvalidation IS NULL)";
        WebbeeController::executaSQL($sql);
    }

    public function filter($filter) {
        $c = array();
        $rs = array();

        //Taxa filter
        $c['where'] = ' where t.idtaxonomicelement>0 ';
        $mWhere = '';
        if ($filter['list'] != null) {
            foreach ($filter['list'] as &$v) {
                $mWhere = $mWhere == '' ? '' : $mWhere . ' OR ';
                $mWhere = $mWhere . ' m.idmorphospecies = ' . $v['id'];
            }
        }
        $c['where'] = $mWhere == '' ? $c['where'] : $c['where'] . ' AND ';
        $c['where'] = $c['where'] . $mWhere;

        // parametros da consulta

    	$idGroup = Yii::app()->user->getGroupId();
        
    	if ($idGroup!=2){
        	 $groupSQL = ' AND (s.idgroup='.$idGroup.') ';
       	}
       	
       	
        $c['select'] = 'SELECT count(*) as n, m.idmorphospecies as id, m.morphospecies as morphospecies ';
        $c['from'] = ' FROM morphospecies m ';

        $c['join'] = $c['join'] . ' INNER JOIN taxonomicelement t ON m.idmorphospecies = t.idmorphospecies ';
        $c['join'] = $c['join'] . ' INNER JOIN specimen s ON s.idtaxonomicelement = t.idtaxonomicelement  '.$groupSQL;
        /* $c['where'] = ' WHERE 1 = 1 '.$institutionCodeWhere.$collectionCodeWhere.$scientificNameWhere.$basisOfRecordWhere.$catalogNumberWhere.
          $kingdomWhere.$phylumWhere.$classWhere.$orderWhere.$familyWhere.$genusWhere.$subgenusWhere.$specificEpithetWhere.
          $countryWhere.$stateProvinceWhere.$countyWhere.$municipalityWhere.$localityWhere; */
        $c['groupby'] = ' GROUP BY m.morphospecies, m.idmorphospecies ';
        $c['orderby'] = ' ORDER BY m.morphospecies ';
        $c['limit'] = ' limit ' . $filter['limit'];
        $c['offset'] = ' offset ' . $filter['offset'];


        
       		 
        //$groupSQL = ' AND (m.idgroup='.$idGroup.') ';
        $c['where'] =  $c['where'];//.$groupSQL;

        // junta tudo
        $sql = $c['select'] . $c['from'] . $c['join'] . $c['where'] . $c['groupby'] . $c['orderby'] . $c['limit'] . $c['offset'];

		//print_r($sql);
		//exit;
        // faz consulta e manda para list
        $rs['list'] = WebbeeController::executaSQL($sql);
        // altera parametros de consulta para fazer o Count
        $c['select'] = 'SELECT count(*) from (select distinct on (m.idmorphospecies) * ';
        $sql = $c['select'] . $c['from'] . $c['join'] . $c['where'] .$groupSQL. ') as m';
        $rs['sql'] = $sql;
        // faz consulta do Count e manda para count
        $rs['count'] = WebbeeController::executaSQL($sql);
        return $rs;
    }

    public function searchLocal($q, $l, $onlyValid) {
        $q = trim($q);
        $onlyValid = $onlyValid ? ' and colvalidation = true ' : '';
        $rs = array();
        
        // procurar primeiro palavras iguais
        $sql = "select * from scientificname where scientificname = '$q' $onlyValid order by colvalidation DESC, levenshtein(UPPER(scientificname),UPPER('$q')) offset 0 limit 50 ";
        $res = WebbeeController::executaSQL($sql); // $res é um array com o resultado da consulta SQL
        $result = $res[0]; // como $res só tem um resultado (na posição 0), guardo ele em uma outra variável $result (que tbm é um array)
        if (empty($res) || $result['colvalidation'] == false) {
        	$rs[] = array("id" => null, "rank" => 'New', "label" => $q, "desc" => 'New scientific name?', "level" => 'New', "icon" => "images/specimen/new.png", "valid" => false);
        }
        // procurar similaridades
        $sql = "select * from scientificname where levenshtein(UPPER(scientificname),UPPER('$q'))<$l $onlyValid order by colvalidation DESC, levenshtein(UPPER(scientificname),UPPER('$q')) offset 0 limit 50 ";
        $res = WebbeeController::executaSQL($sql);
        foreach ($res as $linha) {
            $rs[] = array("id" => $linha['idscientificname'], "rank" => 'scientificname', "label" => $linha['scientificname'], "desc" => ($linha['colvalidation'] == true ? 'Valid name' : 'Not valid name'), "level" => 'Scientific Name', "icon" => ($linha['colvalidation'] == true ? "images/specimen/ITIS.gif" : "images/specimen/notvalid.png"), "valid" => $linha['colvalidation']);
        }
        return $rs;
    }
    
    public function searchCol($q) {
        $sql = "select record_id, name, lsid, taxon from taxa where taxon = 'Species' and is_accepted_name = 1 and levenshtein(name,'$q')<3 order by levenshtein(name,'$q') offset 0 limit 20 ";
        $logic = new TaxonomicToolLogic();
        $res = $logic->execColSql($sql);
        $rs = array();
        while ($linha = pg_fetch_array($res)) {
            $rs[] = array("id" => $linha['record_id'], "label" => $linha['name'], "desc" => 'description: ' . $linha['lsid'], "level" => $linha['taxon'], "icon" => "images/specimen/ITIS.gif");
        }
        return $rs;
    }
    
    public function searchColEqual($q) {
        $sql = "select record_id, name, lsid, taxon from taxa where taxon = 'Species' and name = '$q' and is_accepted_name = 1 order by similarity(name,'$q') DESC offset 0 limit 20 ";
        $logic = new TaxonomicToolLogic();
        $res = $logic->execColSql($sql);
        $rs = array();
        while ($linha = pg_fetch_array($res)) {
            $rs[] = array("id" => $linha['record_id'], "label" => $linha['name'], "desc" => 'description: ' . $linha['lsid'], "level" => $linha['taxon'], "icon" => "images/specimen/ITIS.gif");
        }
        return $rs;
    }

    public function filter_child($filter) {
        $rs = array();
        $c = array();
        
        $c['limit'] = ' limit ' . $filter['limit'];
        $c['offset'] = ' offset ' . $filter['offset'];
        
        $idGroup = Yii::app()->user->getGroupId();
        
        if ($idGroup!=2){
        	 $groupSQL = ' AND (s.idgroup='.$idGroup.') ';
       	}
       	
        $c['sql'] = "SELECT idspecimen AS id, s.idtaxonomicelement AS idtaxonomicelement, collectioncode, catalognumber, institutioncode, morphospecies 
        FROM taxonomicelement t, specimen s, recordlevelelement r, collectioncode c, occurrenceelement o, institutioncode i, morphospecies m 
        WHERE t.idmorphospecies = " . (int) $filter['idmorphospecies'] . " AND 
                s.idrecordlevelelement = r.idrecordlevelelement AND r.idcollectioncode = c.idcollectioncode AND o.idoccurrenceelement = s.idoccurrenceelement AND s.idtaxonomicelement = t.idtaxonomicelement AND r.idinstitutioncode = i.idinstitutioncode 
                AND m.idmorphospecies = t.idmorphospecies  ".$groupSQL;
        
        $sql = $c['sql'] . $c['limit'] . $c['offset'];
        
        $rsSpecimen = WebbeeController::executaSQL($sql);
        
        $rsSpecimenAux = array();
        foreach($rsSpecimen as $ar) {
	        array_push($rsSpecimenAux, array_merge($ar, array("controller" => 'specimen')));
        }
        
        $c['sql'] = "SELECT idmonitoring AS id, mn.idtaxonomicelement AS idtaxonomicelement, collectioncode, catalognumber, institutioncode, morphospecies FROM taxonomicelement t, monitoring mn, recordlevelelement r, collectioncode c, occurrenceelement o, institutioncode i, morphospecies m WHERE t.idmorphospecies = " . (int) $filter['idmorphospecies'] . " AND 
                mn.idrecordlevelelement = r.idrecordlevelelement AND r.idcollectioncode = c.idcollectioncode AND o.idoccurrenceelement = mn.idoccurrenceelement AND mn.idtaxonomicelement = t.idtaxonomicelement AND r.idinstitutioncode = i.idinstitutioncode 
                AND m.idmorphospecies = t.idmorphospecies ";
        
        $sql = $c['sql'] . $c['limit'] . $c['offset'];
        
        $rsMonitoring = WebbeeController::executaSQL($sql);
        
        $rsMonitoringAux = array();
        foreach($rsMonitoring as $ar) {
	        array_push($rsMonitoringAux, array_merge($ar, array("controller" => 'monitoring')));
        }
        
        $rs['list'] = array_merge($rsSpecimenAux, $rsMonitoringAux);
       
        $c['sql'] = "SELECT count (*) FROM taxonomicelement t, specimen s, recordlevelelement r, collectioncode c, occurrenceelement o, institutioncode i, morphospecies m WHERE t.idmorphospecies = " . (int) $filter['idmorphospecies'] . " AND 
                s.idrecordlevelelement = r.idrecordlevelelement AND r.idcollectioncode = c.idcollectioncode AND o.idoccurrenceelement = s.idoccurrenceelement AND s.idtaxonomicelement = t.idtaxonomicelement AND r.idinstitutioncode = i.idinstitutioncode 
                AND m.idmorphospecies = t.idmorphospecies ";
        
        $sql = $c['sql'] . $c['limit'] . $c['offset'];
        
        $countSpecimens = WebbeeController::executaSQL($sql);
        
        $c['sql'] = "SELECT count (*) FROM taxonomicelement t, monitoring mn, recordlevelelement r, collectioncode c, occurrenceelement o, institutioncode i, morphospecies m WHERE t.idmorphospecies = " . (int) $filter['idmorphospecies'] . " AND 
                mn.idrecordlevelelement = r.idrecordlevelelement AND r.idcollectioncode = c.idcollectioncode AND o.idoccurrenceelement = mn.idoccurrenceelement AND mn.idtaxonomicelement = t.idtaxonomicelement AND r.idinstitutioncode = i.idinstitutioncode 
                AND m.idmorphospecies = t.idmorphospecies ";
        
        $sql = $c['sql'] . $c['limit'] . $c['offset'];
        
        $countMonitoring = WebbeeController::executaSQL($sql);
        
        $rs['count'] = $countSpecimens[0]['count'] + $countMonitoring[0]['count'];
        
        return $rs;
    }

}

?>