<?php
class LocalityLogic {
    var $mainAtt = 'locality';
    public function searchList($q) {
        $ar = LocalityAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function search($q) {
        $ar = LocalityAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idlocality+"","label"=>$ar->locality,"value"=>$ar->locality);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = LocalityAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new LocalityAR();
        $rs = array();

        $ar->locality = $field;
        $ar->idlocality = $id;

        if(isset($ar->idlocality)) {
            $returnAR = LocalityAR::model()->findByPk($ar->idlocality);
        }else {
            $ar->locality = trim($ar->locality);
            $returnAR = LocalityAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->locality."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idlocality;
            $rs['field'] = $returnAR->locality;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = LocalityAR::model();
        $ar->locality = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idlocality == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idlocality;
            $rs['field'] = $rs['ar']->locality;
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
