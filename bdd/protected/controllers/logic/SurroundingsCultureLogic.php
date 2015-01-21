<?php
class SurroundingsCultureLogic {
    var $mainAtt = 'surroundingsculture';
    public function search($q) {
        $ar = SurroundingsCultureAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idsurroundingsculture+"","label"=>$ar->surroundingsculture,"value"=>$ar->surroundingsculture);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = SurroundingsCultureAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new SurroundingsCultureAR();
        $rs = array();

        $ar->surroundingsculture = $field;
        $ar->idsurroundingsculture = $id;

        if(isset($ar->idsurroundingsculture)) {
            $returnAR = SurroundingsCultureAR::model()->findByPk($ar->idsurroundingsculture);
        }else {
            $ar->surroundingsculture = trim($ar->surroundingsculture);
            $returnAR = SurroundingsCultureAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->surroundingsculture."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idsurroundingsculture;
            $rs['field'] = $returnAR->surroundingsculture;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = SurroundingsCultureAR::model();
        $ar->surroundingsculture = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idsurroundingsculture == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idsurroundingsculture;
            $rs['field'] = $rs['ar']->surroundingsculture;
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
