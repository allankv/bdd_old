<?php
class ReproductiveConditionLogic {
    var $mainAtt = 'reproductivecondition';
    public function search($q) {
        $ar = ReproductiveConditionAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;        
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idreproductivecondition+"","label"=>$ar->reproductivecondition,"value"=>$ar->reproductivecondition);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = ReproductiveConditionAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }    
    public function getJSON($field, $id) {

        $ar = new ReproductiveConditionAR();
        $rs = array();

        $ar->reproductivecondition = $field;
        $ar->idreproductivecondition = $id;

        if(isset($ar->idreproductivecondition)){
            $returnAR = ReproductiveConditionAR::model()->findByPk($ar->idreproductivecondition);
        }else{
            $ar->reproductivecondition = trim($ar->reproductivecondition);
            $returnAR = ReproductiveConditionAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->reproductivecondition."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idreproductivecondition;
            $rs['field'] = $returnAR->reproductivecondition;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;
    }
    public function save($field) {
        $rs = array ();
        $ar = ReproductiveConditionAR::model();
        $ar->reproductivecondition = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idreproductivecondition == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idreproductivecondition;
            $rs['field'] = $rs['ar']->reproductivecondition;
            $rs['ar'] = $rs['ar']->getAttributes();
  
            return $rs;
        }else{
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
