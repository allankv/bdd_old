<?php
class SurroundingsVegetationLogic {
    var $mainAtt = 'surroundingsvegetation';
    public function search($q) {
        $ar = SurroundingsVegetationAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idsurroundingsvegetation+"","label"=>$ar->surroundingsvegetation,"value"=>$ar->surroundingsvegetation);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = SurroundingsVegetationAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new SurroundingsVegetationAR();
        $rs = array();

        $ar->surroundingsvegetation = $field;
        $ar->idsurroundingsvegetation = $id;

        if(isset($ar->idsurroundingsvegetation)) {
            $returnAR = SurroundingsVegetationAR::model()->findByPk($ar->idsurroundingsvegetation);
        }else {
            $ar->surroundingsvegetation = trim($ar->surroundingsvegetation);
            $returnAR = SurroundingsVegetationAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->surroundingsvegetation."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idsurroundingsvegetation;
            $rs['field'] = $returnAR->surroundingsvegetation;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = SurroundingsVegetationAR::model();
        $ar->surroundingsvegetation = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idsurroundingsvegetation == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idsurroundingsvegetation;
            $rs['field'] = $rs['ar']->surroundingsvegetation;
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
