<?php
class SubgenusLogic {
    var $mainAtt = 'subgenus';
    public function searchList($q) {
        $ar = SubgenusAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function search($q) {
        $ar = SubgenusAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idsubgenus+"","label"=>$ar->subgenus,"value"=>$ar->subgenus);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = SubgenusAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new SubgenusAR();
        $rs = array();

        $ar->subgenus = $field;
        $ar->idsubgenus = $id;

        if(isset($ar->idsubgenus)) {
            $returnAR = SubgenusAR::model()->findByPk($ar->idsubgenus);
        }else {
            $ar->subgenus = trim($ar->subgenus);
            $returnAR = SubgenusAR::model()->find("$this->mainAtt='".$ar->subgenus."'");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idsubgenus;
            $rs['field'] = $returnAR->subgenus;
            $rs['ar'] = $returnAR;
        }else {
            $rs['success'] = false;
        }

        return $rs;
    }
    public function save($field, $colvalidation=false) {

    	if ($colvalidation == "") $colvalidation = false;
    	else if ($colvalidation == "true") $colvalidation = true;
    	else if ($colvalidation == "false") $colvalidation = false;
    
        $rs = array ();
        $ar = SubgenusAR::model();
        $ar->subgenus = trim($field);
        $ar->colvalidation = $colvalidation;
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idsubgenus == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idsubgenus;
            $rs['field'] = $rs['ar']->subgenus;
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
