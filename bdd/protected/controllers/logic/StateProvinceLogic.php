<?php
class StateProvinceLogic {
    var $mainAtt = 'stateprovince';
    public function searchList($q) {
        $ar = StateProvinceAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function search($q) {
        $ar = StateProvinceAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idstateprovince+"","label"=>$ar->stateprovince,"value"=>$ar->stateprovince);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = StateProvinceAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new StateProvinceAR();
        $rs = array();

        $ar->stateprovince = $field;
        $ar->idstateprovince = $id;

        if(isset($ar->idstateprovince)) {
            $returnAR = StateProvinceAR::model()->findByPk($ar->idstateprovince);
        }else {
            $ar->stateprovince = trim($ar->stateprovince);
            $returnAR = StateProvinceAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->stateprovince."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idstateprovince;
            $rs['field'] = $returnAR->stateprovince;
            $rs['ar'] = $returnAR;
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }
    
    public function save($field) {
        $rs = array ();
        $ar = StateProvinceAR::model();
        $ar->stateprovince = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idstateprovince == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idstateprovince;
            $rs['field'] = $rs['ar']->stateprovince;
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
    
    public function saveBGT($ar) {
        $rs = array();
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idstateprovince == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;
            
            return $rs;
        }
        else {
            $erros = array();
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
