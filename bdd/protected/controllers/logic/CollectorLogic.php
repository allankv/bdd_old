<?php
class CollectorLogic {
    var $mainAtt = 'collector';
    public function search($q) {
        $ar = CollectorAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idcollector+"","label"=>$ar->collector,"value"=>$ar->collector);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = CollectorAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new CollectorAR();
        $rs = array();

        $ar->collector = $field;
        $ar->idcollector = $id;

        if(isset($ar->idcollector)) {
            $returnAR = CollectorAR::model()->findByPk($ar->idcollector);
        }else {
            $ar->collector = trim($ar->collector);
            $returnAR = CollectorAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->collector."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idcollector;
            $rs['field'] = $returnAR->collector;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = CollectorAR::model();
        $ar->collector = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idcollector == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idcollector;
            $rs['field'] = $rs['ar']->collector;
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
