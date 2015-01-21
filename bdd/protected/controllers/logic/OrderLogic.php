<?php
class OrderLogic {
    var $mainAtt = '"order"';
    public function searchList($q) {
        $ar = OrderAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function search($q) {
        $ar = OrderAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idorder+"","label"=>$ar->order,"value"=>$ar->order);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = OrderAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new OrderAR();
        $rs = array();

        $ar->order = $field;
        $ar->idorder = $id;

        if(isset($ar->idorder)) {
            $returnAR = OrderAR::model()->findByPk($ar->idorder);
        }else {
            $ar->order = trim($ar->order);
            $returnAR = OrderAR::model()->find("$this->mainAtt='".$ar->order."'");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idorder;
            $rs['field'] = $returnAR->order;
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
        $ar = OrderAR::model();
        $ar->order = trim($field);
        $ar->colvalidation = $colvalidation;
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idorder == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idorder;
            $rs['field'] = $rs['ar']->order;
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
