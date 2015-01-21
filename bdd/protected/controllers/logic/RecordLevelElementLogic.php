<?php
include_once 'DynamicPropertyLogic.php';
class RecordLevelElementLogic {
    public function fillDependency($ar) {
        if($ar->basisofrecord==null) {
            $ar->basisofrecord = new BasisOfRecordAR();
        }
        if($ar->institutioncode==null) {
            $ar->institutioncode = new InstitutionCodeAR();
        }
        if($ar->ownerinstitution==null) {
            $ar->ownerinstitution = new OwnerInstitutionAR();
        }
        if($ar->dataset==null) {
            $ar->dataset = new DatasetAR();
        }
        if($ar->collectioncode==null) {
            $ar->collectioncode = new CollectionCodeAR();
        }
        if($ar->type==null) {
            $ar->type = new TypeAR();
        }
        if($ar->language==null) {
            $ar->language = new LanguageAR();
        }
        return $ar;
    }
    public function save($ar) {
        $rs = array ();

        /*$ar->idrecordlevelelement = $ar->idrecordlevelelement==''?null:$ar->idrecordlevelelement;
        $ar->idinstitutioncode = $ar->idinstitutioncode==''?null:$ar->idinstitutioncode;
        $ar->idcollectioncode = $ar->idcollectioncode==''?null:$ar->idcollectioncode;
        $ar->idbasisofrecord = $ar->idbasisofrecord==''?null:$ar->idbasisofrecord;
        $ar->idownerinstitution = $ar->idownerinstitution==''?null:$ar->idownerinstitution;
        $ar->iddataset = $ar->iddataset==''?null:$ar->iddataset;
        $ar->idtype = $ar->idtype==''?null:$ar->idtype;
        $ar->idlanguage = $ar->idlanguage==''?null:$ar->idlanguage;
        */
        $rs['success'] = true;
        $ar->lendingdate = $ar->lendingdate==''?null:$ar->lendingdate;
        $rs['operation'] = $ar->idrecordlevelelement == null?'Create':'Update';
        $ar->setIsNewRecord($rs['operation']=='Create');
        //$aux = array();
        //$aux[] = $rs['operation'].' success';
        //$rs['msg'] = $aux;
        $ar->idrecordlevelelement = $ar->getIsNewRecord()?null:$ar->idrecordlevelelement;
        //var_dump($ar->idrecordlevelelement);
        $ar->save(false);
        return $ar->idrecordlevelelement;
    }
    public function delete($id) {
        $ar = RecordLevelElementAR::model();
        $ar = $ar->findByPk($id);
        $l = new DynamicPropertyLogic();
        $l->deleteRecordLevelRecord($id);
        $ar->delete();
    }
    public function setAttributes($p) {
        $ar = RecordLevelElementAR::model();
        $p['idbasisofrecord']=$p['idbasisofrecord']==''?null:$p['idbasisofrecord'];
        $p['idinstitutioncode']=$p['idinstitutioncode']==''?null:$p['idinstitutioncode'];
        $p['idcollectioncode']=$p['idcollectioncode']==''?null:$p['idcollectioncode'];
        $p['iddataset']=$p['iddataset']==''?null:$p['iddataset'];
        $p['idownerinstitution']=$p['idownerinstitution']==''?null:$p['idownerinstitution'];
        $p['idtype']=$p['idtype']==''?null:$p['idtype'];
        $p['idlanguage']=$p['idlanguage']==''?null:$p['idlanguage'];
        $ar->setAttributes($p,false);
        return $this->fillDependency($ar);
    }
}
?>
