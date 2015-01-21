<?php
class SpeciesNameLogic {
    var $mainAtt = 'speciesname';
    public function searchList($q) {
        $ar = SpeciesNameAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function search($q) {
        $ar = SpeciesNameAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idspeciesname+"","label"=>$ar->speciesname,"value"=>$ar->speciesname);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = SpeciesNameAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new SpeciesNameAR();
        $rs = array();

        $ar->speciesname = $field;
        $ar->idspeciesname = $id;

        if(isset($ar->idspeciesname)) {
            $returnAR = SpeciesNameAR::model()->findByPk($ar->idspeciesname);
        }else {
            $ar->speciesname = trim($ar->speciesname);
            $returnAR = SpeciesNameAR::model()->find("$this->mainAtt='".$ar->speciesname."'");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idspeciesname;
            $rs['field'] = $returnAR->speciesname;
            $rs['ar'] = $returnAR;
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }
    public function save($field) {
        $rs = array ();
        $ar = SpeciesNameAR::model();
        $ar->speciesname = trim($field);

        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idspeciesname == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idspeciesname;
            $rs['field'] = $rs['ar']->speciesname;
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
