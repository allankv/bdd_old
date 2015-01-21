<?php
class TypePlantingLogic {
    var $mainAtt = 'typeplanting';
    public function search($q) {
        $ar = TypePlantingAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idtypeplanting+"","label"=>$ar->typeplanting,"value"=>$ar->typeplanting);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = TypePlantingAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new TypePlantingAR();
        $rs = array();

        $ar->typeplanting = $field;
        $ar->idtypeplanting = $id;

        if(isset($ar->idtypeplanting)) {
            $returnAR = TypePlantingAR::model()->findByPk($ar->idtypeplanting);
        }else {
            $ar->typeplanting = trim($ar->typeplanting);
            $returnAR = TypePlantingAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->typeplanting."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idtypeplanting;
            $rs['field'] = $returnAR->typeplanting;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = TypePlantingAR::model();
        $ar->typeplanting = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idtypeplanting == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idtypeplanting;
            $rs['field'] = $rs['ar']->typeplanting;
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
}
?>
