<?php
class CategoryMediaLogic {
    var $mainAtt = 'categorymedia';
    public function searchList($q) {
        $ar = CategoryMediaAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function search($q) {
        $ar = CategoryMediaAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idcategorymedia+"","label"=>$ar->categorymedia,"value"=>$ar->categorymedia);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = CategoryMediaAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new CategoryMediaAR();
        $rs = array();

        $ar->categorymedia = $field;
        $ar->idcategorymedia = $id;

        if(isset($ar->idcategorymedia)) {
            $returnAR = CategoryMediaAR::model()->findByPk($ar->idcategorymedia);
        }else {
            $ar->categorymedia = trim($ar->categorymedia);
            $returnAR = CategoryMediaAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->categorymedia."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idcategorymedia;
            $rs['field'] = $returnAR->categorymedia;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = CategoryMediaAR::model();
        $ar->categorymedia = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idcategorymedia == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idcategorymedia;
            $rs['field'] = $rs['ar']->categorymedia;
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
