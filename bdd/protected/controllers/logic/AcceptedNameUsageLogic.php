<?php
class AcceptedNameUsageLogic {
    var $mainAtt = 'acceptednameusage';
    public function search($q) {
        $ar = AcceptedNameUsageAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idacceptednameusage+"","label"=>$ar->acceptednameusage,"value"=>$ar->acceptednameusage);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = AcceptedNameUsageAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new AcceptedNameUsageAR();
        $rs = array();

        $ar->acceptednameusage = $field;
        $ar->idacceptednameusage = $id;

        if(isset($ar->idacceptednameusage)) {
            $returnAR = AcceptedNameUsageAR::model()->findByPk($ar->idacceptednameusage);
        }else {
            $ar->acceptednameusage = trim($ar->acceptednameusage);
            $returnAR = AcceptedNameUsageAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->acceptednameusage."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idacceptednameusage;
            $rs['field'] = $returnAR->acceptednameusage;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = AcceptedNameUsageAR::model();
        $ar->acceptednameusage = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idacceptednameusage == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idacceptednameusage;
            $rs['field'] = $rs['ar']->acceptednameusage;
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
