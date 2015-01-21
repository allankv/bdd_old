<?php
class OwnerInstitutionLogic {
    var $mainAtt = 'ownerinstitution';
    public function search($q) {
        $ar = OwnerInstitutionAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;        
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idownerinstitution+"","label"=>$ar->ownerinstitution,"value"=>$ar->ownerinstitution);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = OwnerInstitutionAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }    
    public function getJSON($field, $id) {

        $ar = new OwnerInstitutionAR();
        $rs = array();

        $ar->ownerinstitution = $field;
        $ar->idownerinstitution = $id;

        if(isset($ar->idownerinstitution)){
            $returnAR = OwnerInstitutionAR::model()->findByPk($ar->idownerinstitution);
        }else{
            $ar->ownerinstitution = trim($ar->ownerinstitution);
            $returnAR = OwnerInstitutionAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->ownerinstitution."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idownerinstitution;
            $rs['field'] = $returnAR->ownerinstitution;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;
    }
    public function save($field) {
        $rs = array ();
        $ar = OwnerInstitutionAR::model();
        $ar->ownerinstitution = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idownerinstitution == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idownerinstitution;
            $rs['field'] = $rs['ar']->ownerinstitution;
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
