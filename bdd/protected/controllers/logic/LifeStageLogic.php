<?php
class LifeStageLogic {
    var $mainAtt = 'lifestage';
    public function searchList($q) {
        $ar = LifeStageAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;        
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function search($q) {
        $ar = LifeStageAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idlifestage+"","label"=>$ar->lifestage,"value"=>$ar->lifestage);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = LifeStageAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }    
    public function getJSON($field, $id) {

        $ar = new LifeStageAR();
        $rs = array();

        $ar->lifestage = $field;
        $ar->idlifestage = $id;

        if(isset($ar->idlifestage)){
            $returnAR = LifeStageAR::model()->findByPk($ar->idlifestage);
        }else{
            $ar->lifestage = trim($ar->lifestage);
            $returnAR = LifeStageAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->lifestage."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idlifestage;
            $rs['field'] = $returnAR->lifestage;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;
    }
    public function save($field) {
        $rs = array ();
        $ar = LifeStageAR::model();
        $ar->lifestage = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idlifestage == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idlifestage;
            $rs['field'] = $rs['ar']->lifestage;
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
}
?>
