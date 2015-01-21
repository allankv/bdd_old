<?php
class SoilPreparationLogic {
    var $mainAtt = 'soilpreparation';
    public function search($q) {
        $ar = SoilPreparationAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idsoilpreparation+"","label"=>$ar->soilpreparation,"value"=>$ar->soilpreparation);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = SoilPreparationAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new SoilPreparationAR();
        $rs = array();

        $ar->soilpreparation = $field;
        $ar->idsoilpreparation = $id;

        if(isset($ar->idsoilpreparation)) {
            $returnAR = SoilPreparationAR::model()->findByPk($ar->idsoilpreparation);
        }else {
            $ar->soilpreparation = trim($ar->soilpreparation);
            $returnAR = SoilPreparationAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->soilpreparation."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idsoilpreparation;
            $rs['field'] = $returnAR->soilpreparation;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = SoilPreparationAR::model();
        $ar->soilpreparation = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idsoilpreparation == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idsoilpreparation;
            $rs['field'] = $rs['ar']->soilpreparation;
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
