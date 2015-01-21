<?php
class WeatherConditionLogic {
    var $mainAtt = 'weathercondition';
    public function search($q) {
        $ar = WeatherConditionAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idweathercondition+"","label"=>$ar->weathercondition,"value"=>$ar->weathercondition);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = WeatherConditionAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new WeatherConditionAR();
        $rs = array();

        $ar->weathercondition = $field;
        $ar->idweathercondition = $id;

        if(isset($ar->idweathercondition)) {
            $returnAR = WeatherConditionAR::model()->findByPk($ar->idweathercondition);
        }else {
            $ar->weathercondition = trim($ar->weathercondition);
            $returnAR = WeatherConditionAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->weathercondition."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idweathercondition;
            $rs['field'] = $returnAR->weathercondition;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = WeatherConditionAR::model();
        $ar->weathercondition = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idweathercondition == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idweathercondition;
            $rs['field'] = $rs['ar']->weathercondition;
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
