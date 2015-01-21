<?php
class HabitatLogic {
    var $mainAtt = 'habitat';
    public function search($q) {
        $ar = HabitatAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idhabitat+"","label"=>$ar->habitat,"value"=>$ar->habitat);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = HabitatAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new HabitatAR();
        $rs = array();

        $ar->habitat = $field;
        $ar->idhabitat = $id;

        if(isset($ar->idhabitat)) {
            $returnAR = HabitatAR::model()->findByPk($ar->idhabitat);
        }else {
            $ar->habitat = trim($ar->habitat);
            $returnAR = HabitatAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->habitat."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idhabitat;
            $rs['field'] = $returnAR->habitat;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = HabitatAR::model();
        $ar->habitat = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idhabitat == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idhabitat;
            $rs['field'] = $rs['ar']->habitat;
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
