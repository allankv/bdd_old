<?php
class IslandLogic {
    var $mainAtt = 'island';
    public function search($q) {
        $ar = IslandAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idisland+"","label"=>$ar->island,"value"=>$ar->island);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = IslandAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new IslandAR();
        $rs = array();

        $ar->island = $field;
        $ar->idisland = $id;

        if(isset($ar->idisland)) {
            $returnAR = IslandAR::model()->findByPk($ar->idisland);
        }else {
            $ar->island = trim($ar->island);
            $returnAR = IslandAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->island."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idisland;
            $rs['field'] = $returnAR->island;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = IslandAR::model();
        $ar->island = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idisland == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idisland;
            $rs['field'] = $rs['ar']->island;
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
