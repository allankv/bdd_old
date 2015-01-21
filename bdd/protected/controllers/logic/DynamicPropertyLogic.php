<?php
class DynamicPropertyLogic {
    var $mainAtt = 'dynamicproperty';
    public function search($q) {
        $ar = DynamicPropertyAR::model();
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
            $ln= array ("key"=>"".$ar->iddynamicproperty,"value"=>$ar->dynamicproperty);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = DynamicPropertyAR::model();
        $q = trim(addslashes($q));
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new DynamicPropertyAR();
        $rs = array();

        $ar->dynamicproperty = $field;
        $ar->iddynamicproperty = $id;

        if(isset($ar->iddynamicproperty)) {
            $returnAR = DynamicPropertyAR::model()->findByPk($ar->iddynamicproperty);
        }else {
            $ar->dynamicproperty = trim(addslashes($ar->dynamicproperty));
            $returnAR = DynamicPropertyAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->dynamicproperty."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->iddynamicproperty;
            // condicao
            $rs['field'] = $returnAR->dynamicproperty;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;
    }
    public function save($q) {
        $rs = array ();
        $ar = new DynamicPropertyAR();
        $ar->dynamicproperty = trim(addslashes($q));
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->iddynamicproperty == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->iddynamicproperty;
            $rs['field'] = $rs['ar']->dynamicproperty;
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
    public function getDynamicPropertyByRecordLevelElement($ar) {
        $nnList = RecordLevelDynamicPropertyAR::model()->findAll('idrecordlevelelement='.$ar->idrecordlevelelement);
        $dynamicpropertyList = array();
        foreach ($nnList as $n=>$ar) {
            $dynamicpropertyList[] = DynamicPropertyAR::model()->findByPk($ar->iddynamicproperty);
        }
        return $dynamicpropertyList;
    }
    public function saveRecordLevelElementNN($idDynamicProperty,$idRecordLevelElement) {
        if(RecordLevelDynamicPropertyAR::model()->find("iddynamicproperty=$idDynamicProperty AND idrecordlevelelement=$idRecordLevelElement")==null) {
            $ar = new RecordLevelDynamicPropertyAR();
            $ar->iddynamicproperty = $idDynamicProperty;
            $ar->idrecordlevelelement = $idRecordLevelElement;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteRecordLevelElementNN($idDynamicProperty,$idRecordLevelElement) {
        $ar = RecordLevelDynamicPropertyAR::model();
        $ar = $ar->find(" iddynamicproperty=$idDynamicProperty AND idrecordlevelelement=$idRecordLevelElement ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteRecordLevelRecord($id){
        $ar = RecordLevelDynamicPropertyAR::model();
        $arList = $ar->findAll(" idrecordlevelelement=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }
}
?>
