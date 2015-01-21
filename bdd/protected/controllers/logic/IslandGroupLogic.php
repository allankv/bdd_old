<?php
class IslandGroupLogic {
    var $mainAtt = 'islandgroup';
    public function search($q) {
        $ar = IslandGroupAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idislandgroup+"","label"=>$ar->islandgroup,"value"=>$ar->islandgroup);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = IslandGroupAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new IslandGroupAR();
        $rs = array();

        $ar->islandgroup = $field;
        $ar->idislandgroup = $id;

        if(isset($ar->idislandgroup)) {
            $returnAR = IslandGroupAR::model()->findByPk($ar->idislandgroup);
        }else {
            $ar->islandgroup = trim($ar->islandgroup);
            $returnAR = IslandGroupAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->islandgroup."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idislandgroup;
            $rs['field'] = $returnAR->islandgroup;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = IslandGroupAR::model();
        $ar->islandgroup = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idislandgroup == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idislandgroup;
            $rs['field'] = $rs['ar']->islandgroup;
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
