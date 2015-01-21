<?php
class TypeHoldingLogic {
    var $mainAtt = 'typeholding';
    public function search($q) {
        $ar = TypeHoldingAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idtypeholding+"","label"=>$ar->typeholding,"value"=>$ar->typeholding);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = TypeHoldingAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new TypeHoldingAR();
        $rs = array();

        $ar->typeholding = $field;
        $ar->idtypeholding = $id;

        if(isset($ar->idtypeholding)) {
            $returnAR = TypeHoldingAR::model()->findByPk($ar->idtypeholding);
        }else {
            $ar->typeholding = trim($ar->typeholding);
            $returnAR = TypeHoldingAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->typeholding."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idtypeholding;
            $rs['field'] = $returnAR->typeholding;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = TypeHoldingAR::model();
        $ar->typeholding = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idtypeholding == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idtypeholding;
            $rs['field'] = $rs['ar']->typeholding;
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
