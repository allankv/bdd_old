<?php
class DigitizerLogic {
    var $mainAtt = 'digitizer';
    public function search($q) {
        $ar = DigitizerAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->iddigitizer+"","label"=>$ar->digitizer,"value"=>$ar->digitizer);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = DigitizerAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new DigitizerAR();
        $rs = array();

        $ar->digitizer = $field;
        $ar->iddigitizer = $id;

        if(isset($ar->iddigitizer)) {
            $returnAR = DigitizerAR::model()->findByPk($ar->iddigitizer);
        }else {
            $ar->digitizer = trim($ar->digitizer);
            $returnAR = DigitizerAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->digitizer."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->iddigitizer;
            $rs['field'] = $returnAR->digitizer;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = DigitizerAR::model();
        $ar->digitizer = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->iddigitizer == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->iddigitizer;
            $rs['field'] = $rs['ar']->digitizer;
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
