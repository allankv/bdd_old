<?php
class OriginalNameUsageLogic {
    var $mainAtt = 'originalnameusage';
    public function search($q) {
        $ar = OriginalNameUsageAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idoriginalnameusage+"","label"=>$ar->originalnameusage,"value"=>$ar->originalnameusage);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = OriginalNameUsageAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new OriginalNameUsageAR();
        $rs = array();

        $ar->originalnameusage = $field;
        $ar->idoriginalnameusage = $id;

        if(isset($ar->idoriginalnameusage)) {
            $returnAR = OriginalNameUsageAR::model()->findByPk($ar->idoriginalnameusage);
        }else {
            $ar->originalnameusage = trim($ar->originalnameusage);
            $returnAR = OriginalNameUsageAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->originalnameusage."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idoriginalnameusage;
            $rs['field'] = $returnAR->originalnameusage;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;
    }
    public function save($field) {
        $rs = array ();
        $ar = OriginalNameUsageAR::model();
        $ar->originalnameusage = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idoriginalnameusage == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idoriginalnameusage;
            $rs['field'] = $rs['ar']->originalnameusage;
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
