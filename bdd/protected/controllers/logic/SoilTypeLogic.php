<?php
class SoilTypeLogic {
    var $mainAtt = 'soiltype';
    public function search($q) {
        $ar = SoilTypeAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idsoiltype+"","label"=>$ar->soiltype,"value"=>$ar->soiltype);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = SoilTypeAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new SoilTypeAR();
        $rs = array();

        $ar->soiltype = $field;
        $ar->idsoiltype = $id;

        if(isset($ar->idsoiltype)) {
            $returnAR = SoilTypeAR::model()->findByPk($ar->idsoiltype);
        }else {
            $ar->soiltype = trim($ar->soiltype);
            $returnAR = SoilTypeAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->soiltype."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idsoiltype;
            $rs['field'] = $returnAR->soiltype;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = SoilTypeAR::model();
        $ar->soiltype = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idsoiltype == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idsoiltype;
            $rs['field'] = $rs['ar']->soiltype;
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
