<?php
class SubtribeLogic {
    var $mainAtt = 'subtribe';
    public function searchList($q) {
        $ar = SubtribeAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function search($q) {
        $ar = SubtribeAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idsubtribe+"","label"=>$ar->subtribe,"value"=>$ar->subtribe);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = SubtribeAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new SubtribeAR();
        $rs = array();

        $ar->subtribe = $field;
        $ar->idsubtribe = $id;

        if(isset($ar->idsubtribe)) {
            $returnAR = SubtribeAR::model()->findByPk($ar->idsubtribe);
        }else {
            $ar->subtribe = trim($ar->subtribe);
            $returnAR = SubtribeAR::model()->find("$this->mainAtt='".$ar->subtribe."'");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idsubtribe;
            $rs['field'] = $returnAR->subtribe;
            $rs['ar'] = $returnAR;
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }
    public function save($field) {
        $rs = array ();
        $ar = SubtribeAR::model();
        $ar->subtribe = trim($field);

        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idsubtribe == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idsubtribe;
            $rs['field'] = $rs['ar']->subtribe;
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
