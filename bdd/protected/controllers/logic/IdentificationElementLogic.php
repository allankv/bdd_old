<?php
include_once 'IdentifiedByLogic.php';
include_once 'TypeStatusLogic.php';
class IdentificationElementLogic {
    public function fillDependency($ar) {
        if($ar->identificationqualifier==null) {
            $ar->identificationqualifier = IdentificationQualifierAR::model();
        }
        return $ar;
    }
    public function save($ar) {
        $rs = array ();
/*
        $ar->ididentificationelement = $ar->ididentificationelement==''?null:$ar->ididentificationelement;
        $ar->ididentificationqualifier = $ar->ididentificationqualifier==''?null:$ar->ididentificationqualifier;
*/
        $ar->dateidentified = $ar->dateidentified==''?null:$ar->dateidentified;
        $rs['success'] = true;
        $rs['operation'] = $ar->ididentificationelement == null?'create':'update';
        $ar->setIsNewRecord($rs['operation']=='create');
        $rs['msg'] = $rs['operation'].' success';
        $ar->ididentificationelement = $ar->getIsNewRecord()?null:$ar->ididentificationelement;
        $ar->save();
        return $ar->ididentificationelement;
    }
    public function delete($id) {
        $ar = IdentificationElementAR::model();
        $ar = $ar->findByPk($id);
        $l = new IdentifiedByLogic();
        $l->deleteIdentificationRecord($id);
        $l = new TypeStatusLogic();
        $l->deleteIdentificationRecord($id);
        $ar->delete();
    }
    public function setAttributes($p) {
        $ar = IdentificationElementAR::model();
        $p['ididentificationqualifier']=$p['ididentificationqualifier']==''?null:$p['ididentificationqualifier'];
        $ar->setAttributes($p,false);
        return $this->fillDependency($ar);
    }
}
?>
