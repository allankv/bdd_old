<?php
class ScientificNameAuthorshipLogic {
    var $mainAtt = 'scientificnameauthorship';
    public function search($q) {
        $ar = ScientificNameAuthorshipAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idscientificnameauthorship+"","label"=>$ar->scientificnameauthorship,"value"=>$ar->scientificnameauthorship);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = ScientificNameAuthorshipAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new ScientificNameAuthorshipAR();
        $rs = array();

        $ar->scientificnameauthorship = $field;
        $ar->idscientificnameauthorship = $id;

        if(isset($ar->idscientificnameauthorship)) {
            $returnAR = ScientificNameAuthorshipAR::model()->findByPk($ar->idscientificnameauthorship);
        }else {
            $ar->scientificnameauthorship = trim($ar->scientificnameauthorship);
            $returnAR = ScientificNameAuthorshipAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->scientificnameauthorship."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idscientificnameauthorship;
            $rs['field'] = $returnAR->scientificnameauthorship;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;
    }
    public function save($field) {
        $rs = array ();
        $ar = ScientificNameAuthorshipAR::model();
        $ar->scientificnameauthorship = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idscientificnameauthorship == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idscientificnameauthorship;
            $rs['field'] = $rs['ar']->scientificnameauthorship;
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
