<?php
class CountryLogic {
    var $mainAtt = 'country';
    public function searchList($q) {
        $ar = CountryAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function search($q) {
        $ar = CountryAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idcountry+"","label"=>$ar->country,"value"=>$ar->country);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = CountryAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new CountryAR();
        $rs = array();

        $ar->country = $field;
        $ar->idcountry = $id;

        if(isset($ar->idcountry)) {
            $returnAR = CountryAR::model()->findByPk($ar->idcountry);
        }else {
            $ar->country = trim($ar->country);
            $returnAR = CountryAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->country."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idcountry;
            $rs['field'] = $returnAR->country;
            $rs['ar'] = $returnAR;
        }else {
            $rs['success'] = false;
        }

        return $rs;
    }
    
    public function save($field) {
        $rs = array ();
        $ar = CountryAR::model();
        $ar->country = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idcountry == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idcountry;
            $rs['field'] = $rs['ar']->country;
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
            $rs['operation'] = $ar->idcountry == null?'create':'update';
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
