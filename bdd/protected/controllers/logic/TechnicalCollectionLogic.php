<?php
class TechnicalCollectionLogic {
    var $mainAtt = 'technicalcollection';
    public function searchList($q) {
        $ar = TechnicalCollectionAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function search($q) {
        $ar = TechnicalCollectionAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idtechnicalcollection+"","label"=>$ar->technicalcollection,"value"=>$ar->technicalcollection);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = TechnicalCollectionAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new TechnicalCollectionAR();
        $rs = array();

        $ar->technicalcollection = $field;
        $ar->idtechnicalcollection = $id;

        if(isset($ar->idtechnicalcollection)) {
            $returnAR = TechnicalCollectionAR::model()->findByPk($ar->idtechnicalcollection);
        }else {
            $ar->technicalcollection = trim($ar->technicalcollection);
            $returnAR = TechnicalCollectionAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->technicalcollection."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idtechnicalcollection;
            $rs['field'] = $returnAR->technicalcollection;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = TechnicalCollectionAR::model();
        $ar->technicalcollection = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idtechnicalcollection == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idtechnicalcollection;
            $rs['field'] = $rs['ar']->technicalcollection;
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
