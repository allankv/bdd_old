<?php
class SubcategoryReferenceLogic {
    var $mainAtt = 'subcategoryreference';
    public function search($q) {
        $ar = SubcategoryReferenceAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idsubcategoryreference+"","label"=>$ar->subcategoryreference,"value"=>$ar->subcategoryreference);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = SubcategoryReferenceAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new SubcategoryReferenceAR();
        $rs = array();

        $ar->subcategoryreference = $field;
        $ar->idsubcategoryreference = $id;

        if(isset($ar->idsubcategoryreference)) {
            $returnAR = SubcategoryReferenceAR::model()->findByPk($ar->idsubcategoryreference);
        }else {
            $ar->subcategoryreference = trim($ar->subcategoryreference);
            $returnAR = SubcategoryReferenceAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->subcategoryreference."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idsubcategoryreference;
            $rs['field'] = $returnAR->subcategoryreference;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = SubcategoryReferenceAR::model();
        $ar->subcategoryreference = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idsubcategoryreference == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idsubcategoryreference;
            $rs['field'] = $rs['ar']->subcategoryreference;
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
