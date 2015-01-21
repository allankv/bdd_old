<?php
class CollectionCodeLogic {
    var $mainAtt = 'collectioncode';
    public function searchList($q) {
        $ar = CollectionCodeAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function search($q) {
        $ar = CollectionCodeAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idcollectioncode+"","label"=>$ar->collectioncode,"value"=>$ar->collectioncode);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = CollectionCodeAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new CollectionCodeAR();
        $rs = array();

        $ar->collectioncode = $field;
        $ar->idcollectioncode = $id;

        if(isset($ar->idcollectioncode)) {
            $returnAR = CollectionCodeAR::model()->findByPk($ar->idcollectioncode);
        }else {
            $ar->collectioncode = trim($ar->collectioncode);
            $returnAR = CollectionCodeAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->collectioncode."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idcollectioncode;
            $rs['field'] = $returnAR->collectioncode;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = CollectionCodeAR::model();
        $ar->collectioncode = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idcollectioncode == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idcollectioncode;
            $rs['field'] = $rs['ar']->collectioncode;
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
