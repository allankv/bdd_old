<?php
class PublisherLogic {
    var $mainAtt = 'publisher';
    public function search($q) {
        $ar = PublisherAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idpublisher+"","label"=>$ar->publisher,"value"=>$ar->publisher);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = PublisherAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new PublisherAR();
        $rs = array();

        $ar->publisher = $field;
        $ar->idpublisher = $id;

        if(isset($ar->idpublisher)) {
            $returnAR = PublisherAR::model()->findByPk($ar->idpublisher);
        }else {
            $ar->publisher = trim($ar->publisher);
            $returnAR = PublisherAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->publisher."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idpublisher;
            $rs['field'] = $returnAR->publisher;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = PublisherAR::model();
        $ar->publisher = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idpublisher == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idpublisher;
            $rs['field'] = $rs['ar']->publisher;
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
