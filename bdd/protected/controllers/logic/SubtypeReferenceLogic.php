<?php
class SubtypeReferenceLogic {
    var $mainAtt = 'subtypereference';
    public function search($q) {
        $ar = SubtypeReferenceAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function suggestion($q) {
        $ar = SubtypeReferenceAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new SubtypeReferenceAR();
        $rs = array();

        $ar->subtypereference = $field;
        $ar->idsubtypereference = $id;

        if(isset($ar->idsubtypereference)) {
            $returnAR = SubtypeReferenceAR::model()->findByPk($ar->idsubtypereference);
        }else {
            $ar->subtypereference = trim($ar->subtypereference);
            $returnAR = SubtypeReferenceAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->subtypereference."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idsubtypereference;
            $rs['field'] = $returnAR->subtypereference;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = SubtypeReferenceAR::model();
        $ar->subtypereference = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idsubtypereference == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idsubtypereference;
            $rs['field'] = $rs['ar']->subtypereference;
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
