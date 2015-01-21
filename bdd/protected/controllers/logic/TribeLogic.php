<?php
class TribeLogic {
    var $mainAtt = 'tribe';
    public function searchList($q) {
        $ar = TribeAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function search($q) {
        $ar = TribeAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idtribe+"","label"=>$ar->tribe,"value"=>$ar->tribe);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = TribeAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new TribeAR();
        $rs = array();

        $ar->tribe = $field;
        $ar->idtribe = $id;

        if(isset($ar->idtribe)) {
            $returnAR = TribeAR::model()->findByPk($ar->idtribe);
        }else {
            $ar->tribe = trim($ar->tribe);
            $returnAR = TribeAR::model()->find("$this->mainAtt='".$ar->tribe."'");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idtribe;
            $rs['field'] = $returnAR->tribe;
            $rs['ar'] = $returnAR;
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }
    public function save($field) {
        $rs = array ();
        $ar = TribeAR::model();
        $ar->tribe = trim($field);

        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idtribe == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idtribe;
            $rs['field'] = $rs['ar']->tribe;
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
