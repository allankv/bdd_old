<?php
include_once 'SpecimenLogic.php';
include_once 'InteractionTypeLogic.php';
include_once 'LifeStageLogic.php';
class InteractionLogic {
    public function filter($filter) {
        $c = array();
        $rs = array();
        // flag para fazer ou nao join do lifeStage
        $lifeStageJoin = false;
        // where de cada entidade com OR entre
        $lifeStageWhere = '';
        $scientificNameWhere = '';
        $institutionCodeWhere = '';
        $interactionTypeWhere = '';
        if($filter['list']!=null) {
            foreach ($filter['list'] as &$v) {
                if($v['controller']=='lifestage') {
                    $lifeStageJoin = true;
                    $lifeStageWhere = $lifeStageWhere==''?'':$lifeStageWhere.' OR ';
                    $lifeStageWhere = $lifeStageWhere.' l1.idlifestage = '.$v['id'].' OR l2.idlifestage = '.$v['id'];
                }
                if($v['controller']=='scientificname') {
                    $scientificNameWhere = $scientificNameWhere==''?'':$scientificNameWhere.' OR ';
                    $scientificNameWhere = $scientificNameWhere.' scn1.idscientificname = '.$v['id'].' OR scn2.idscientificname = '.$v['id'];
                }
                if($v['controller']=='institutioncode') {
                    $institutionCodeWhere = $institutionCodeWhere==''?'':$institutionCodeWhere.' OR ';
                    $institutionCodeWhere = $institutionCodeWhere.' r1.idinstitutioncode = '.$v['id'].' OR r2.idinstitutioncode = '.$v['id'];
                }
                if($v['controller']=='interactiontype') {
                    $interactionTypeWhere = $interactionTypeWhere==''?'':$interactionTypeWhere.' OR ';
                    $interactionTypeWhere = $interactionTypeWhere.' int.idinteractiontype = '.$v['id'];
                }
            }
        }
        // se o where de cada entidades nao estiver vazias, coloca AND antes
        $institutionCodeWhere = $institutionCodeWhere!=''?' AND ('.$institutionCodeWhere.') ':'';
        $scientificNameWhere = $scientificNameWhere!=''?' AND ('.$scientificNameWhere.') ':'';
        $lifeStageWhere = $lifeStageWhere!=''?' AND ('.$lifeStageWhere.') ':'';
        $interactionTypeWhere = $interactionTypeWhere!=''?' AND ('.$interactionTypeWhere.') ':'';
        // parametros da consulta
        $c['select'] = 'SELECT int.isrestricted, int.idinteraction,
            scn1.scientificname as scientificname1, scn2.scientificname as scientificname2,
            o1.catalognumber as catalognumber1, o2.catalognumber as catalognumber2,
            institution1.institutioncode as institutioncode1, institution2.institutioncode as institutioncode2, 
            collection1.collectioncode as collectioncode1, collection2.collectioncode as collectioncode2,
            type.interactiontype ';
        $c['from'] = ' FROM interaction int ';
        $c['join'] = $c['join'].' LEFT JOIN interactiontype type ON int.idinteractiontype = type.idinteractiontype ';
        $c['join'] = $c['join'].' LEFT JOIN specimen sp1 ON int.idspecimen1 = sp1.idspecimen ';
        $c['join'] = $c['join'].' LEFT JOIN specimen sp2 ON int.idspecimen2 = sp2.idspecimen ';
        $c['join'] = $c['join'].' LEFT JOIN recordlevelelement r1 ON sp1.idrecordlevelelement = r1.idrecordlevelelement ';
        $c['join'] = $c['join'].' LEFT JOIN recordlevelelement r2 ON sp2.idrecordlevelelement = r2.idrecordlevelelement ';
        $c['join'] = $c['join'].' LEFT JOIN institutioncode institution1 ON r1.idinstitutioncode = institution1.idinstitutioncode ';
        $c['join'] = $c['join'].' LEFT JOIN institutioncode institution2 ON r2.idinstitutioncode = institution2.idinstitutioncode ';
        $c['join'] = $c['join'].' LEFT JOIN collectioncode collection1 ON r1.idcollectioncode = collection1.idcollectioncode ';
        $c['join'] = $c['join'].' LEFT JOIN collectioncode collection2 ON r2.idcollectioncode = collection2.idcollectioncode ';
        $c['join'] = $c['join'].' LEFT JOIN occurrenceelement o1 ON sp1.idoccurrenceelement = o1.idoccurrenceelement ';
        $c['join'] = $c['join'].' LEFT JOIN occurrenceelement o2 ON sp2.idoccurrenceelement = o2.idoccurrenceelement ';
        $c['join'] = $lifeStageJoin?$c['join'].' LEFT JOIN lifestage l1 ON o1.idlifestage = l1.idlifestage  ':$c['join'];
        $c['join'] = $lifeStageJoin?$c['join'].' LEFT JOIN lifestage l2 ON o2.idlifestage = l2.idlifestage  ':$c['join'];
        $c['join'] = $c['join'].' LEFT JOIN taxonomicelement t1 ON sp1.idtaxonomicelement = t1.idtaxonomicelement  ';
        $c['join'] = $c['join'].' LEFT JOIN taxonomicelement t2 ON sp2.idtaxonomicelement = t2.idtaxonomicelement  ';
        $c['join'] = $c['join'].' LEFT JOIN scientificname scn1 ON t1.idscientificname = scn1.idscientificname  ';
        $c['join'] = $c['join'].' LEFT JOIN scientificname scn2 ON t2.idscientificname = scn2.idscientificname  ';
        $c['where'] = ' WHERE 1 = 1 '.$institutionCodeWhere.$scientificNameWhere.$lifeStageWhere.$interactionTypeWhere;
        $c['orderby'] = ' ORDER BY scn1.scientificname, scn2.scientificname, o1.catalognumber, int.idinteraction ';
        $c['limit'] = ' limit '.$filter['limit'];
        $c['offset'] = ' offset '.$filter['offset'];
        
        $idGroup = Yii::app()->user->getGroupId();
		//$groupSQL = ' AND (int.idgroup='.$idGroup.') ';
		
    	if ($idGroup!=2){
        	 $groupSQL = ' AND (int.idgroup='.$idGroup.') ';
       	 }
       		 
		$c['where'] =  $c['where'].$groupSQL;

        // junta tudo
        $sql = $c['select'].$c['from'].$c['join'].$c['where'].$c['orderby'].$c['limit'].$c['offset'];
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
    public function search($q) {

        /*
        $institutionCodeLogic = new InstitutionCodeLogic();
        $institutionCodeList = $institutionCodeLogic->search($q);
        $lifeStageLogic = new LifeStageLogic();
        $lifeStageList = $lifeStageLogic->search($q);
        $scientificNameLogic = new ScientificNameLogic();
        $scientificNameList = $scientificNameLogic->search($q);
        $interactionTypeLogic = new InteractionTypeLogic();
        $interactionTypeList = $interactionTypeLogic->search($q);*/


        //Temporary - need to change search function - using searchList for now
        $institutionCodeLogic = new InstitutionCodeLogic();
        $institutionCodeList = $institutionCodeLogic->searchList($q);
        $lifeStageLogic = new LifeStageLogic();
        $lifeStageList = $lifeStageLogic->searchList($q);
        $scientificNameLogic = new ScientificNameLogic();
        $scientificNameList = $scientificNameLogic->searchList($q);
        $interactionTypeLogic = new InteractionTypeLogic();
        $interactionTypeList = $interactionTypeLogic->search($q);



        $rs = array();
        foreach($scientificNameList as $n=>$ar) {
            $rs[] = array("controller" => "scientificname","id" => $ar->idscientificname,"label" => $ar->scientificname,"category" => "Scientific name");
        }
        foreach($institutionCodeList as $n=>$ar) {
            $rs[] = array("controller" => "institutioncode","id" => $ar->idinstitutioncode,"label" => $ar->institutioncode,"category" => "Institution code");
        }
        foreach($lifeStageList as $n=>$ar) {
            $rs[] = array("controller" => "lifestage","id" => $ar->idlifestage,"label" => $ar->lifestage,"category" => "Life stage");
        }
        foreach($interactionTypeList as $n=>$ar) {
            $rs[] = array("controller" => "interactiontype","id" => $ar->idinteractiontype,"label" => $ar->interactiontype,"category" => "Interaction type");
        }
        return $rs;
    }
    public function save($ar) {
        $ar->modified=date('Y-m-d G:i:s');
        $ar->idgroup = Yii::app()->user->getGroupId();
        $rs = array ();
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idinteraction == null?'created':'updated';
            $ar->setIsNewRecord($rs['operation']=='created');
            $aux = array();
            $aux[] = 'Successfully '.$rs['operation'].' interaction record<br/>"'.$ar->specimen1->taxonomicelement->scientificname->scientificname.' '.$ar->interactiontype->interactiontype.' '.$ar->specimen2->taxonomicelement->scientificname->scientificname.'"';
            $rs['msg'] = $aux;
            $ar->idinteraction = $ar->getIsNewRecord()?null:$ar->idinteraction;
            $ar->save();
            $rs['ar'] = $ar;
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
        $ar = InteractionAR::model();
        $ar = $ar->findByPk($id);
        $ar->delete();
    }
    public function deleteSpecimenRecord($id) {
        $ar = InteractionAR::model();
        $arList = $ar->findAll(" idspecimen1=$id OR idspecimen2=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }
    public function fillDependency($ar) {
        if($ar->specimen1==null)
            $ar->specimen1 = SpecimenAR::model();
        if($ar->specimen2==null)
            $ar->specimen2 = SpecimenAR::model();
        if($ar->interactiontype==null)
            $ar->interactiontype = InteractionTypeAR::model();

        $l = new SpecimenLogic();
        $ar->specimen1 = $l->fillDependency($ar->specimen1);
        $ar->specimen2 = $l->fillDependency($ar->specimen2);
        return $ar;
    }
    public function getInteraction($sp1, $sp2, $inttype) {
        $int = InteractionAR::model()->find('idinteractiontype=:int AND idspecimen1=:sp1 AND idspecimen2 =:sp2', array (':int'=>$inttype->idinteractiontype, ':sp1'=>$sp1->idspecimen, ':sp2'=>$sp2->idspecimen));
        return $int==null?new InteractionAR():$int;
    }
    public function getTip($filter)
    {
        $c = array();
        $rs = array();

        // parametros da consulta
        $c['select'] = 'SELECT int.idinteraction,
            institution1.institutioncode as institutioncode1, institution2.institutioncode as institutioncode2,
            collection1.collectioncode as collectioncode1, collection2.collectioncode as collectioncode2 ';
        $c['from'] = ' FROM interaction int ';
        $c['join'] = $c['join'].' LEFT JOIN specimen sp1 ON int.idspecimen1 = sp1.idspecimen ';
        $c['join'] = $c['join'].' LEFT JOIN specimen sp2 ON int.idspecimen2 = sp2.idspecimen ';
        $c['join'] = $c['join'].' LEFT JOIN recordlevelelement r1 ON sp1.idrecordlevelelement = r1.idrecordlevelelement ';
        $c['join'] = $c['join'].' LEFT JOIN recordlevelelement r2 ON sp2.idrecordlevelelement = r2.idrecordlevelelement ';
        $c['join'] = $c['join'].' LEFT JOIN institutioncode institution1 ON r1.idinstitutioncode = institution1.idinstitutioncode ';
        $c['join'] = $c['join'].' LEFT JOIN institutioncode institution2 ON r2.idinstitutioncode = institution2.idinstitutioncode ';
        $c['join'] = $c['join'].' LEFT JOIN collectioncode collection1 ON r1.idcollectioncode = collection1.idcollectioncode ';
        $c['join'] = $c['join'].' LEFT JOIN collectioncode collection2 ON r2.idcollectioncode = collection2.idcollectioncode ';
        $c['where'] = ' WHERE int.idinteraction = '.$filter['idinteraction'];
        // junta tudo
        $sql = $c['select'].$c['from'].$c['join'].$c['where'];

        // faz consulta e manda para list
        $rs = WebbeeController::executaSQL($sql);

        return $rs;
    }
}
?>
