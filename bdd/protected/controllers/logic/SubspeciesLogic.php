<?php
class SubspeciesLogic {
    var $mainAtt = 'subspecies';
    public function searchList($q) {
        $ar = SubspeciesAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function search($q) {
        $ar = SubspeciesAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idsubspecies+"","label"=>$ar->subspecies,"value"=>$ar->subspecies);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = SubspeciesAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new SubspeciesAR();
        $rs = array();

        $ar->subspecies = $field;
        $ar->idsubspecies = $id;

        if(isset($ar->idsubspecies)) {
            $returnAR = SubspeciesAR::model()->findByPk($ar->idsubspecies);
        }else {
            $ar->subspecies = trim($ar->subspecies);
            $returnAR = SubspeciesAR::model()->find("$this->mainAtt='".$ar->subspecies."'");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idsubspecies;
            $rs['field'] = $returnAR->subspecies;
            $rs['ar'] = $returnAR;
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }
    public function save($field) {
        $rs = array ();
        $ar = SubspeciesAR::model();
        $ar->subspecies = trim($field);

        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idsubspecies == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idsubspecies;
            $rs['field'] = $rs['ar']->subspecies;
            $rs['ar'] = $rs['ar']->getAttributes();
            
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
