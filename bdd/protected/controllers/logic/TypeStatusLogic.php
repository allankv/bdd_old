<?php
class TypeStatusLogic {
    var $mainAtt = 'typestatus';
    public function search($q) {
        $ar = TypeStatusAR::model();
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
            $ln= array ("key"=>"".$ar->idtypestatus,"value"=>$ar->typestatus);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = TypeStatusAR::model();
        $q = trim(addslashes($q));
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new TypeStatusAR();
        $rs = array();

        $ar->typestatus = $field;
        $ar->idtypestatus = $id;


        if(isset($ar->idtypestatus)) {
            $returnAR = TypeStatusAR::model()->findByPk($ar->idtypestatus);
        }else {
            $ar->typestatus = trim(addslashes($ar->typestatus));
            $returnAR = TypeStatusAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->typestatus."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idtypestatus;
            $rs['field'] = $returnAR->typestatus;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;
    }
    public function save($q) {
        $rs = array ();
        $ar = new TypeStatusAR();
        $ar->typestatus = trim(addslashes($q));
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idtypestatus == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idtypestatus;
            $rs['field'] = $rs['ar']->typestatus;
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
    public function getTypeStatusByCuratorialElement($ar) {
        $nnList = CuratorialTypeStatusAR::model()->findAll('idcuratorialelement='.$ar->idcuratorialelement);
        $typestatusList = array();
        foreach ($nnList as $n=>$ar) {
            $typestatusList[] = TypeStatusAR::model()->findByPk($ar->idtypestatus);
        }
        return $typestatusList;
    }
    public function saveCuratorialElementNN($idTypeStatus,$idCuratorialElement) {
        if(CuratorialTypeStatusAR::model()->find("idtypestatus=$idTypeStatus AND idcuratorialelement=$idCuratorialElement")==null) {
            $ar = CuratorialTypeStatusAR::model();
            $ar->idtypestatus = $idTypeStatus;
            $ar->idcuratorialelement = $idCuratorialElement;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteCuratorialElementNN($idTypeStatus,$idCuratorialElement) {
        $ar = CuratorialTypeStatusAR::model();
        $ar = $ar->find(" idtypestatus=$idTypeStatus AND idcuratorialelement=$idCuratorialElement ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteCuratorialRecord($id){
        $ar = CuratorialTypeStatusAR::model();
        $arList = $ar->findAll(" idcuratorialelement=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }
    public function getTypeStatusByIdentificationElement($ar) {
        $nnList = IdentificationTypeStatusAR::model()->findAll('ididentificationelement='.$ar->ididentificationelement);
        $typestatusList = array();
        foreach ($nnList as $n=>$ar) {
            $typestatusList[] = TypeStatusAR::model()->findByPk($ar->idtypestatus);
        }
        return $typestatusList;
    }
    public function saveIdentificationElementNN($idTypeStatus,$idIdentificationElement) {
        if(IdentificationTypeStatusAR::model()->find("idtypestatus=$idTypeStatus AND ididentificationelement=$idIdentificationElement")==null) {
            $ar = IdentificationTypeStatusAR::model();
            $ar->idtypestatus = $idTypeStatus;
            $ar->ididentificationelement = $idIdentificationElement;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteIdentificationElementNN($idTypeStatus,$idIdentificationElement) {
        $ar = IdentificationTypeStatusAR::model();
        $ar = $ar->find(" idtypestatus=$idTypeStatus AND ididentificationelement=$idIdentificationElement ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteIdentificationRecord($id){
        $ar = IdentificationTypeStatusAR::model();
        $arList = $ar->findAll(" ididentificationelement=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }
}
?>
