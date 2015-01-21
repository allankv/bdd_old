<?php
class ParentNameUsageLogic {
    var $mainAtt = 'parentnameusage';
    public function search($q) {
        $ar = ParentNameUsageAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idparentnameusage+"","label"=>$ar->parentnameusage,"value"=>$ar->parentnameusage);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = ParentNameUsageAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new ParentNameUsageAR();
        $rs = array();

        $ar->parentnameusage = $field;
        $ar->idparentnameusage = $id;

        if(isset($ar->idparentnameusage)) {
            $returnAR = ParentNameUsageAR::model()->findByPk($ar->idparentnameusage);
        }else {
            $ar->parentnameusage = trim($ar->parentnameusage);
            $returnAR = ParentNameUsageAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->parentnameusage."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idparentnameusage;
            $rs['field'] = $returnAR->parentnameusage;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }
    public function save($field) {
        $rs = array ();
        $ar = ParentNameUsageAR::model();
        $ar->parentnameusage = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idparentnameusage == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idparentnameusage;
            $rs['field'] = $rs['ar']->parentnameusage;
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
