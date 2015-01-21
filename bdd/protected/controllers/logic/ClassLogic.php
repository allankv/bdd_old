<?php
class ClassLogic {
    var $mainAtt = 'class';
    public function searchList($q) {
        $ar = ClassAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function search($q) {
        $ar = ClassAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idclass+"","label"=>$ar->class,"value"=>$ar->class);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = ClassAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new ClassAR();
        $rs = array();

        $ar->class = $field;
        $ar->idclass = $id;

        if(isset($ar->idclass)) {
            $returnAR = ClassAR::model()->findByPk($ar->idclass);
        }else {
            $ar->class = trim($ar->class);
            $returnAR = ClassAR::model()->find("$this->mainAtt='".$ar->class."'");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idclass;
            $rs['field'] = $returnAR->class;
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
        $ar = ClassAR::model();
        $ar->class = trim($field);
        $ar->colvalidation = $colvalidation;
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idclass == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idclass;
            $rs['field'] = $rs['ar']->class;
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
