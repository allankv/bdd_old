<?php
include_once 'RecordedByLogic.php';
include_once 'PreparationLogic.php';
include_once 'IndividualLogic.php';
include_once 'AssociatedSequenceLogic.php';
include_once 'SexLogic.php';

class OccurrenceElementLogic {
	 var $mainAtt = 'catalognumber';
	 
	 
    public function fillDependency($ar) {
        if($ar->behavior==null) {
            $ar->behavior = BehaviorAR::model();
        }
        if($ar->lifestage==null) {
            $ar->lifestage = LifeStageAR::model();
        }
        if($ar->disposition==null) {
            $ar->disposition = DispositionOccurrenceAR::model();
        }
        if($ar->reproductivecondition==null) {
            $ar->reproductivecondition = ReproductiveConditionAR::model();
        }
        if($ar->establishmentmean==null) {
            $ar->establishmentmean = EstablishmentMeanAR::model();
        }
        if($ar->sex==null) {
            $ar->sex = SexAR::model();
        }
        return $ar;
    }
    public function save($ar) {
        $rs = array ();
/*
        $ar->idoccurrenceelement = $ar->idoccurrenceelement==''?null:$ar->idoccurrenceelement;
        $ar->individualcount = $ar->individualcount==''?null:$ar->individualcount;
        $ar->iddisposition = $ar->iddisposition==''?null:$ar->iddisposition;
        $ar->idestablishmentmean = $ar->idestablishmentmean==''?null:$ar->idestablishmentmean;
        $ar->idbehavior = $ar->idbehavior==''?null:$ar->idbehavior;
        $ar->idreproductivecondition = $ar->idreproductivecondition==''?null:$ar->idreproductivecondition;
        $ar->idlifestage = $ar->idlifestage==''?null:$ar->idlifestage;
        $ar->idsex = $ar->idsex==''?null:$ar->idsex;
*/
        $rs['success'] = true;
        $rs['operation'] = $ar->idoccurrenceelement == null?'create':'update';
        $ar->setIsNewRecord($rs['operation']=='create');
        $rs['msg'] = $rs['operation'].' success';
        $ar->idoccurrenceelement = $ar->getIsNewRecord()?null:$ar->idoccurrenceelement;
        $ar->save();
        return $ar->idoccurrenceelement;
    }
    public function delete($id) {
        $ar = OccurrenceElementAR::model();
        $ar = $ar->findByPk($id);
        $l = new RecordedByLogic();
        $l->deleteOccurrenceRecord($id);
        $l = new PreparationLogic();
        $l->deleteOccurrenceRecord($id);
        $l = new IndividualLogic();
        $l->deleteOccurrenceRecord($id);
        $l = new AssociatedSequenceLogic();
        $l->deleteOccurrenceRecord($id);
        $ar->delete();
    }
    public function setAttributes($p) {
        $ar = OccurrenceElementAR::model();
        $p['idoccurrenceelement']=$p['idoccurrenceelement']==''?null:$p['idoccurrenceelement'];
        $p['iddisposition']=$p['iddisposition']==''?null:$p['iddisposition'];
        $p['idestablishmentmean']=$p['idestablishmentmean']==''?null:$p['idestablishmentmean'];
        $p['idbehavior']=$p['idbehavior']==''?null:$p['idbehavior'];
        $p['idreproductivecondition']=$p['idreproductivecondition']==''?null:$p['idreproductivecondition'];
        $p['idlifestage']=$p['idlifestage']==''?null:$p['idlifestage'];
        $p['idsex']=$p['idsex']==''?null:$p['idsex'];
        $ar->setAttributes($p,false);
        return $this->fillDependency($ar);
    }
    
public function search($q) {
        $ar = OccurrenceElementAR::model();
        $q = trim($q);
        $group = Yii::app()->user->getGroupId();
        $criteria = new CDbCriteria();
        $criteria->condition = "(specimen.idgroup='$group') and ($this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3)";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->with('specimen')->findAll($criteria);
        return $rs;
    }
    
   // recordnumber,othercatalognumber
    
public function searchOthercatalognumber($q) {
        $ar = OccurrenceElementAR::model();
        $q = trim($q);
        $group = Yii::app()->user->getGroupId();
        $criteria = new CDbCriteria();
        $criteria->condition = "(specimen.idgroup='$group') and (othercatalognumber ilike '%$q%' OR difference(othercatalognumber, '$q') > 3)";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->with('specimen')->findAll($criteria);
        return $rs;
    }
    
public function searchRecordnumber($q) {
        $ar = OccurrenceElementAR::model();
        $q = trim($q);
        $group = Yii::app()->user->getGroupId();
        $criteria = new CDbCriteria();
        $criteria->condition = "(specimen.idgroup='$group') and (recordnumber ilike '%$q%' OR difference(recordnumber, '$q') > 3)";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->with('specimen')->findAll($criteria);
        return $rs;
    }
}
?>
