<?php
class GeoreferenceVerificationStatusLogic {
    var $mainAtt = 'georeferenceverificationstatus';
    public function search($q) {
        $ar = GeoreferenceVerificationStatusAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idgeoreferenceverificationstatus+"","label"=>$ar->georeferenceverificationstatus,"value"=>$ar->georeferenceverificationstatus);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = GeoreferenceVerificationStatusAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new GeoreferenceVerificationStatusAR();
        $rs = array();

        $ar->georeferenceverificationstatus = $field;
        $ar->idgeoreferenceverificationstatus = $id;

        if(isset($ar->idgeoreferenceverificationstatus)) {
            $returnAR = GeoreferenceVerificationStatusAR::model()->findByPk($ar->idgeoreferenceverificationstatus);
        }else {
            $ar->georeferenceverificationstatus = trim($ar->georeferenceverificationstatus);
            $returnAR = GeoreferenceVerificationStatusAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->georeferenceverificationstatus."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idgeoreferenceverificationstatus;
            $rs['field'] = $returnAR->georeferenceverificationstatus;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = GeoreferenceVerificationStatusAR::model();
        $ar->georeferenceverificationstatus = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idgeoreferenceverificationstatus == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idgeoreferenceverificationstatus;
            $rs['field'] = $rs['ar']->georeferenceverificationstatus;
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
