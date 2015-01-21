<?php
class MunicipalityLogic {
    var $mainAtt = 'municipality';
    public function searchList($q) {
        $ar = MunicipalityAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function search($q) {
        $ar = MunicipalityAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idmunicipality+"","label"=>$ar->municipality,"value"=>$ar->municipality);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = MunicipalityAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new MunicipalityAR();
        $rs = array();

        $ar->municipality = $field;
        $ar->idmunicipality = $id;

        if(isset($ar->idmunicipality)) {
            $returnAR = MunicipalityAR::model()->findByPk($ar->idmunicipality);
        }else {
            $ar->municipality = trim($ar->municipality);
            $returnAR = MunicipalityAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->municipality."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idmunicipality;
            $rs['field'] = $returnAR->municipality;
            $rs['ar'] = $returnAR;
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }
    
    public function save($field) {
        $rs = array ();
        $ar = MunicipalityAR::model();
        $ar->municipality = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idmunicipality == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idmunicipality;
            $rs['field'] = $rs['ar']->municipality;
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
            $rs['operation'] = $ar->idmunicipality == null?'create':'update';
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
