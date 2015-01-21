<?php
class KingdomLogic {
    var $mainAtt = 'kingdom';
    public function searchList($q) {
        $ar = KingdomAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function search($q) {
        $ar = KingdomAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idkingdom+"","label"=>$ar->kingdom,"value"=>$ar->kingdom);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = KingdomAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new KingdomAR();
        $rs = array();

        $ar->kingdom = $field;
        $ar->idkingdom = $id;
        
        if(isset($ar->idkingdom)) {
            $returnAR = KingdomAR::model()->findByPk($ar->idkingdom);
        }else {
            $ar->kingdom = trim($ar->kingdom);
            $returnAR = KingdomAR::model()->find("$this->mainAtt='".$ar->kingdom."'");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idkingdom;
            $rs['field'] = $returnAR->kingdom;
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
        $ar = KingdomAR::model();
        $ar->kingdom = trim($field);
        $ar->colvalidation = $colvalidation;
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idkingdom == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idkingdom;
            $rs['field'] = $rs['ar']->kingdom;
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
