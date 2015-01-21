<?php
class TreatmentLogic {
    var $mainAtt = 'treatment';
    public function search($q) {
        $ar = TreatmentAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idtreatment+"","label"=>$ar->treatment,"value"=>$ar->treatment);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = TreatmentAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new TreatmentAR();
        $rs = array();

        $ar->treatment = $field;
        $ar->idtreatment = $id;

        if(isset($ar->idtreatment)) {
            $returnAR = TreatmentAR::model()->findByPk($ar->idtreatment);
        }else {
            $ar->treatment = trim($ar->treatment);
            $returnAR = TreatmentAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->treatment."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idtreatment;
            $rs['field'] = $returnAR->treatment;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = TreatmentAR::model();
        $ar->treatment = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idtreatment == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idtreatment;
            $rs['field'] = $rs['ar']->treatment;
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
