<?php
class ProductionVarietyLogic {
    var $mainAtt = 'productionvariety';
    public function search($q) {
        $ar = ProductionVarietyAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idproductionvariety+"","label"=>$ar->productionvariety,"value"=>$ar->productionvariety);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = ProductionVarietyAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new ProductionVarietyAR();
        $rs = array();

        $ar->productionvariety = $field;
        $ar->idproductionvariety = $id;

        if(isset($ar->idproductionvariety)) {
            $returnAR = ProductionVarietyAR::model()->findByPk($ar->idproductionvariety);
        }else {
            $ar->productionvariety = trim($ar->productionvariety);
            $returnAR = ProductionVarietyAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->productionvariety."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idproductionvariety;
            $rs['field'] = $returnAR->productionvariety;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = ProductionVarietyAR::model();
        $ar->productionvariety = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idproductionvariety == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idproductionvariety;
            $rs['field'] = $rs['ar']->productionvariety;
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
