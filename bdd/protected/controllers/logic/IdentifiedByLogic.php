<?php
class IdentifiedByLogic {
    var $mainAtt = 'identifiedby';
    public function search($q) {
        $ar = IdentifiedByAR::model();
        $q = trim(addslashes($q));
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        $ln= array ("key"=>"","value"=>$q." <br>(New)</br>");
            $result[] = $ln;
        foreach ($rs as $n=>$ar) {
            $ln= array ("key"=>"".$ar->ididentifiedby,"value"=>$ar->identifiedby);
            $result[] = $ln;
        }
        
        return $result;
    }
    public function suggestion($q) {
        $ar = IdentifiedByAR::model();
        $q = trim(addslashes($q));
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new IdentifiedByAR();
        $rs = array();

        $ar->identifiedby = $field;
        $ar->ididentifiedby = $id;


        if(isset($ar->ididentifiedby)) {
            $returnAR = IdentifiedByAR::model()->findByPk($ar->ididentifiedby);
        }else {
            $ar->identifiedby = trim(addslashes($ar->identifiedby));
            $returnAR = IdentifiedByAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->identifiedby."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->ididentifiedby;
            $rs['field'] = $returnAR->identifiedby;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;
    }
    public function save($q) {
        $rs = array ();
        $ar = new IdentifiedByAR();
        $ar->identifiedby = trim(addslashes($q));
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->ididentifiedby == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->ididentifiedby;
            $rs['field'] = $rs['ar']->identifiedby;
            $rs['ar'] = $rs['ar']->getAttributes();

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
    public function getIdentifiedByByCuratorialElement($ar) {
        $nnList = CuratorialIdentifiedByAR::model()->findAll('idcuratorialelement='.$ar->idcuratorialelement);
        $identifiedbyList = array();
        foreach ($nnList as $n=>$ar) {
            $identifiedbyList[] = IdentifiedByAR::model()->findByPk($ar->ididentifiedby);
        }
        return $identifiedbyList;
    }
    public function saveCuratorialElementNN($idIdentifiedBy,$idCuratorialElement) {
        if(CuratorialIdentifiedByAR::model()->find("ididentifiedby=$idIdentifiedBy AND idcuratorialelement=$idCuratorialElement")==null) {
            $ar = CuratorialIdentifiedByAR::model();
            $ar->ididentifiedby = $idIdentifiedBy;
            $ar->idcuratorialelement = $idCuratorialElement;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteCuratorialElementNN($idIdentifiedBy,$idCuratorialElement) {
        $ar = CuratorialIdentifiedByAR::model();
        $ar = $ar->find(" ididentifiedby=$idIdentifiedBy AND idcuratorialelement=$idCuratorialElement ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteCuratorialRecord($id){
        $ar = CuratorialIdentifiedByAR::model();
        $arList = $ar->findAll(" idcuratorialelement=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }
    public function getIdentifiedByByIdentificationElement($ar) {
        $nnList = IdentificationIdentifiedByAR::model()->findAll('ididentificationelement='.$ar->ididentificationelement);
        $identifiedbyList = array();
        foreach ($nnList as $n=>$ar) {
            $identifiedbyList[] = IdentifiedByAR::model()->findByPk($ar->ididentifiedby);
        }
        return $identifiedbyList;
    }
    public function saveIdentificationElementNN($idIdentifiedBy,$idIdentificationElement) {
        if(IdentificationIdentifiedByAR::model()->find("ididentifiedby=$idIdentifiedBy AND ididentificationelement=$idIdentificationElement")==null) {
            $ar = new IdentificationIdentifiedByAR();
            $ar->ididentifiedby = $idIdentifiedBy;
            $ar->ididentificationelement = $idIdentificationElement;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteIdentificationElementNN($idIdentifiedBy,$idIdentificationElement) {
        $ar = IdentificationIdentifiedByAR::model();
        $ar = $ar->find(" ididentifiedby=$idIdentifiedBy AND ididentificationelement=$idIdentificationElement ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteIdentificationRecord($id){
        $ar = IdentificationIdentifiedByAR::model();
        $arList = $ar->findAll(" ididentificationelement=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }
}
?>
