<?php
class EventElementLogic {
    public function fillDependency($ar) {
        if($ar->samplingprotocol==null) {
            $ar->samplingprotocol = SamplingProtocolAR::model();
        }
        if($ar->habitat==null) {
            $ar->habitat = HabitatEventAR::model();
        }
        return $ar;
    }
    public function save($ar) {
        $rs = array ();
/*
        $ar->ideventelement = $ar->ideventelement==''?null:$ar->ideventelement;
        $ar->idsamplingprotocol = $ar->idsamplingprotocol==''?null:$ar->idsamplingprotocol;
        $ar->idhabitat = $ar->idhabitat==''?null:$ar->idhabitat;
        $ar->eventtime = $ar->eventtime==null?'00:00':$ar->eventtime;
*/
        $ar->eventdate = $ar->eventdate==''?null:$ar->eventdate;
        $rs['success'] = true;
        $rs['operation'] = $ar->ideventelement == null?'create':'update';
        $ar->setIsNewRecord($rs['operation']=='create');
        $rs['msg'] = $rs['operation'].' success';
        $ar->ideventelement = $ar->getIsNewRecord()?null:$ar->ideventelement;
        $ar->save();
        return $ar->ideventelement;
    }
    public function delete($id) {
        $ar = EventElementAR::model();
        $ar = $ar->findByPk($id);
        $ar->delete();
    }
    public function setAttributes($p) {
        $ar = EventElementAR::model();        
        $p['idsamplingprotocol']=$p['idsamplingprotocol']==''?null:$p['idsamplingprotocol'];
        $p['idhabitat']=$p['idhabitat']==''?null:$p['idhabitat'];
        $ar->setAttributes($p,false);
        return $this->fillDependency($ar);
    }
}
?>
