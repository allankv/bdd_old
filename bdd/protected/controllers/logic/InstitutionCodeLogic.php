<?php
class InstitutionCodeLogic {
    var $mainAtt = 'institutioncode';
    public function searchList($q) {
        $ar = InstitutionCodeAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function search($q) {
        $ar = InstitutionCodeAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idinstitutioncode+"","label"=>$ar->institutioncode,"value"=>$ar->institutioncode);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = InstitutionCodeAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new InstitutionCodeAR();
        $rs = array();

        $ar->institutioncode = $field;
        $ar->idinstitutioncode = $id;

        if(isset($ar->idinstitutioncode)) {
            $returnAR = InstitutionCodeAR::model()->findByPk($ar->idinstitutioncode);
        }else {
            $ar->institutioncode = trim($ar->institutioncode);
            $returnAR = InstitutionCodeAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->institutioncode."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idinstitutioncode;
            $rs['field'] = $returnAR->institutioncode;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = InstitutionCodeAR::model();
        $ar->institutioncode = trim($field);

        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idinstitutioncode == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idinstitutioncode;
            $rs['field'] = $rs['ar']->institutioncode;
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
