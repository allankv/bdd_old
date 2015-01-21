<?php
class MainPlantSpeciesInHedgeLogic {
    var $mainAtt = 'mainplantspeciesinhedge';
    public function search($q) {
        $ar = MainPlantSpeciesInHedgeAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idmainplantspeciesinhedge+"","label"=>$ar->mainplantspeciesinhedge,"value"=>$ar->mainplantspeciesinhedge);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = MainPlantSpeciesInHedgeAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new MainPlantSpeciesInHedgeAR();
        $rs = array();

        $ar->mainplantspeciesinhedge = $field;
        $ar->idmainplantspeciesinhedge = $id;

        if(isset($ar->idmainplantspeciesinhedge)) {
            $returnAR = MainPlantSpeciesInHedgeAR::model()->findByPk($ar->idmainplantspeciesinhedge);
        }else {
            $ar->mainplantspeciesinhedge = trim($ar->mainplantspeciesinhedge);
            $returnAR = MainPlantSpeciesInHedgeAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->mainplantspeciesinhedge."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idmainplantspeciesinhedge;
            $rs['field'] = $returnAR->mainplantspeciesinhedge;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = MainPlantSpeciesInHedgeAR::model();
        $ar->mainplantspeciesinhedge = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idmainplantspeciesinhedge == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idmainplantspeciesinhedge;
            $rs['field'] = $rs['ar']->mainplantspeciesinhedge;
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
