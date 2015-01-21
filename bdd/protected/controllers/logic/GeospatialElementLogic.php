<?php
include_once 'GeoreferenceSourceLogic.php';
class GeospatialElementLogic {
    public function fillDependency($ar) {
        if($ar->georeferenceverificationstatus==null) {
            $ar->georeferenceverificationstatus = GeoreferenceVerificationStatusGeospatialAR::model();
        }
        return $ar;
    }
    public function save($ar) {
        $rs = array ();
        $rs['success'] = true;
        $rs['operation'] = $ar->idgeospatialelement == null?'create':'update';
        $ar->setIsNewRecord($rs['operation']=='create');
        $rs['msg'] = $rs['operation'].' success';
        $ar->idgeospatialelement = $ar->getIsNewRecord()?null:$ar->idgeospatialelement;

        $ar->save(false);
        return $ar->idgeospatialelement;
    }
    public function delete($id) {
        $ar = GeospatialElementAR::model();
        $ar = $ar->findByPk($id);
        $l = new GeoreferenceSourceLogic();
        $l->deleteGeospatialRecord($id);
        $ar->delete();
    }
    public function setAttributes($p) {
        $ar = GeospatialElementAR::model();
        $p['idgeoreferenceverificationstatus']=$p['idgeoreferenceverificationstatus']==''?null:$p['idgeoreferenceverificationstatus'];
        $p['decimallatitude']=$p['decimallatitude']==''?null:$p['decimallatitude'];
        $p['decimallongitude']=$p['decimallongitude']==''?null:$p['decimallongitude'];
        $ar->setAttributes($p,false);
        return $this->fillDependency($ar);
    }
}
?>
