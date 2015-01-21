<?php
class TypeStandLogic {
    var $mainAtt = 'typestand';
    public function search($q) {
        $ar = TypeStandAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idtypestand+"","label"=>$ar->typestand,"value"=>$ar->typestand);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = TypeStandAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new TypeStandAR();
        $rs = array();

        $ar->typestand = $field;
        $ar->idtypestand = $id;

        if(isset($ar->idtypestand)) {
            $returnAR = TypeStandAR::model()->findByPk($ar->idtypestand);
        }else {
            $ar->typestand = trim($ar->typestand);
            $returnAR = TypeStandAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->typestand."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idtypestand;
            $rs['field'] = $returnAR->typestand;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = TypeStandAR::model();
        $ar->typestand = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idtypestand == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idtypestand;
            $rs['field'] = $rs['ar']->typestand;
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
