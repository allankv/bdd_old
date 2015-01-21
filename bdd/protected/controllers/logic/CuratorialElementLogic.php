<?php
include_once 'RecordedByLogic.php';
include_once 'TypeStatusLogic.php';
include_once 'IdentifiedByLogic.php';
include_once 'AssociatedSequenceLogic.php';
include_once 'PreparationLogic.php';
class CuratorialElementLogic {
    public function fillDependency($ar) {
        if($ar->disposition==null) {
            $ar->disposition = DispositionCuratorialAR::model();
        }
        return $ar;
    }
    public function save($ar) {
        $rs = array ();

        $ar->idcuratorialelement = $ar->idcuratorialelement==''?null:$ar->idcuratorialelement;
        $ar->dateidentified = $ar->dateidentified==''?null:$ar->dateidentified;
        $ar->individualcount = $ar->individualcount==''?null:$ar->individualcount;
        $ar->iddisposition = $ar->iddisposition==''?null:$ar->iddisposition;

        $rs['success'] = true;
        $rs['operation'] = $ar->idcuratorialelement == null?'create':'update';
        $ar->setIsNewRecord($rs['operation']=='create');
        $rs['msg'] = $rs['operation'].' success';
        $ar->idcuratorialelement = $ar->getIsNewRecord()?null:$ar->idcuratorialelement;
        $ar->save();
        return $ar->idcuratorialelement;
    }
    public function delete($id) {
        $ar = CuratorialElementAR::model();
        $ar = $ar->findByPk($id);
        $l = new RecordedByLogic();
        $l->deleteCuratorialRecord($id);
        $l = new TypeStatusLogic();
        $l->deleteCuratorialRecord($id);
        $l = new IdentifiedByLogic();
        $l->deleteCuratorialRecord($id);
        $l = new AssociatedSequenceLogic();
        $l->deleteCuratorialRecord($id);
        $l = new PreparationLogic();
        $l->deleteCuratorialRecord($id);
        $ar->delete();
    }
    public function setAttributes($p) {
        $ar = CuratorialElementAR::model();
        $p['iddisposition']=$p['iddisposition']==''?null:$p['iddisposition'];
        $ar->setAttributes($p,false);
        return $this->fillDependency($ar);
    }
}
?>
