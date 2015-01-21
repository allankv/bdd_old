<?php
class FocusCropLogic {
    var $mainAtt = 'focuscrop';
    public function search($q) {
        $ar = FocusCropAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idfocuscrop+"","label"=>$ar->focuscrop,"value"=>$ar->focuscrop);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = FocusCropAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new FocusCropAR();
        $rs = array();

        $ar->focuscrop = $field;
        $ar->idfocuscrop = $id;

        if(isset($ar->idfocuscrop)) {
            $returnAR = FocusCropAR::model()->findByPk($ar->idfocuscrop);
        }else {
            $ar->focuscrop = trim($ar->focuscrop);
            $returnAR = FocusCropAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->focuscrop."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idfocuscrop;
            $rs['field'] = $returnAR->focuscrop;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = FocusCropAR::model();
        $ar->focuscrop = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idfocuscrop == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idfocuscrop;
            $rs['field'] = $rs['ar']->focuscrop;
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
