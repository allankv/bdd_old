<?php
class SexLogic {
    var $mainAtt = 'sex';
    public function search($q) {
        $ar = SexAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idsex+"","label"=>$ar->sex,"value"=>$ar->sex);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = SexAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new SexAR();
        $rs = array();

        $ar->sex = $field;
        $ar->idsex = $id;

        if(isset($ar->idsex)) {
            $returnAR = SexAR::model()->findByPk($ar->idsex);
        }else {
            $ar->sex = trim($ar->sex);
            $returnAR = SexAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->sex."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idsex;
            $rs['field'] = $returnAR->sex;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;
    }
    public function save($field) {
        $rs = array ();
        $ar = SexAR::model();
        $ar->sex = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idsex == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idsex;
            $rs['field'] = $rs['ar']->sex;
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
