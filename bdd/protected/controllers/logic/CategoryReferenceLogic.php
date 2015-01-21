<?php
class CategoryReferenceLogic {
    var $mainAtt = 'categoryreference';
    public function searchList($q) {
        $ar = CategoryReferenceAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function search($q) {
        $ar = CategoryReferenceAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idcategoryreference+"","label"=>$ar->categoryreference,"value"=>$ar->categoryreference);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = CategoryReferenceAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new CategoryReferenceAR();
        $rs = array();

        $ar->categoryreference = $field;
        $ar->idcategoryreference = $id;

        if(isset($ar->idcategoryreference)) {
            $returnAR = CategoryReferenceAR::model()->findByPk($ar->idcategoryreference);
        }else {
            $ar->categoryreference = trim($ar->categoryreference);
            $returnAR = CategoryReferenceAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->categoryreference."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idcategoryreference;
            $rs['field'] = $returnAR->categoryreference;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = CategoryReferenceAR::model();
        $ar->categoryreference = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idcategoryreference == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idcategoryreference;
            $rs['field'] = $rs['ar']->categoryreference;
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
