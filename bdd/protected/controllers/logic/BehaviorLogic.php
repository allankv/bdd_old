<?php
class BehaviorLogic {
    var $mainAtt = 'behavior';
    public function search($q) {
        $ar = BehaviorAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;        
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idbehavior+"","label"=>$ar->behavior,"value"=>$ar->behavior);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = BehaviorAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }    
    public function getJSON($field, $id) {

        $ar = new BehaviorAR();
        $rs = array();

        $ar->behavior = $field;
        $ar->idbehavior = $id;

        if(isset($ar->idbehavior)){
            $returnAR = BehaviorAR::model()->findByPk($ar->idbehavior);
        }else{
            $ar->behavior = trim($ar->behavior);
            $returnAR = BehaviorAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->behavior."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idbehavior;
            $rs['field'] = $returnAR->behavior;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;
    }
    public function save($field) {
        $rs = array ();
        $ar = BehaviorAR::model();
        $ar->behavior = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idbehavior == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idbehavior;
            $rs['field'] = $rs['ar']->behavior;
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
