<?php
class ObserverLogic {
    var $mainAtt = 'observer';
    public function search($q) {
        $ar = ObserverAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idobserver+"","label"=>$ar->observer,"value"=>$ar->observer);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = ObserverAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new ObserverAR();
        $rs = array();

        $ar->observer = $field;
        $ar->idobserver = $id;

        if(isset($ar->idobserver)) {
            $returnAR = ObserverAR::model()->findByPk($ar->idobserver);
        }else {
            $ar->observer = trim($ar->observer);
            $returnAR = ObserverAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->observer."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idobserver;
            $rs['field'] = $returnAR->observer;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = ObserverAR::model();
        $ar->observer = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idobserver == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idobserver;
            $rs['field'] = $rs['ar']->observer;
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
