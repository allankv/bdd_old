<?php
class CultivarLogic {
    var $mainAtt = 'cultivar';
    public function search($q) {
        $ar = CultivarAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idcultivar+"","label"=>$ar->cultivar,"value"=>$ar->cultivar);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = CultivarAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new CultivarAR();
        $rs = array();

        $ar->cultivar = $field;
        $ar->idcultivar = $id;

        if(isset($ar->idcultivar)) {
            $returnAR = CultivarAR::model()->findByPk($ar->idcultivar);
        }else {
            $ar->cultivar = trim($ar->cultivar);
            $returnAR = CultivarAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->cultivar."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idcultivar;
            $rs['field'] = $returnAR->cultivar;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = CultivarAR::model();
        $ar->cultivar = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idcultivar == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idcultivar;
            $rs['field'] = $rs['ar']->cultivar;
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
