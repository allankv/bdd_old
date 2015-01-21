<?php
class SubcategoryMediaLogic {
    var $mainAtt = 'subcategorymedia';
    public function search($q) {
        $ar = SubcategoryMediaAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idsubcategorymedia+"","label"=>$ar->subcategorymedia,"value"=>$ar->subcategorymedia);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = SubcategoryMediaAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new SubcategoryMediaAR();
        $rs = array();

        $ar->subcategorymedia = $field;
        $ar->idsubcategorymedia = $id;

        if(isset($ar->idsubcategorymedia)) {
            $returnAR = SubcategoryMediaAR::model()->findByPk($ar->idsubcategorymedia);
        }else {
            $ar->subcategorymedia = trim($ar->subcategorymedia);
            $returnAR = SubcategoryMediaAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->subcategorymedia."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idsubcategorymedia;
            $rs['field'] = $returnAR->subcategorymedia;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = SubcategoryMediaAR::model();
        $ar->subcategorymedia = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idsubcategorymedia == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idsubcategorymedia;
            $rs['field'] = $rs['ar']->subcategorymedia;
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
