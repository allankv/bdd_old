<?php
class WaterBodyLogic {
    var $mainAtt = 'waterbody';
    public function search($q) {
        $ar = WaterBodyAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idwaterbody+"","label"=>$ar->waterbody,"value"=>$ar->waterbody);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = WaterBodyAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new WaterBodyAR();
        $rs = array();

        $ar->waterbody = $field;
        $ar->idwaterbody = $id;

        if(isset($ar->idwaterbody)) {
            $returnAR = WaterBodyAR::model()->findByPk($ar->idwaterbody);
        }else {
            $ar->waterbody = trim($ar->waterbody);
            $returnAR = WaterBodyAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->waterbody."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idwaterbody;
            $rs['field'] = $returnAR->waterbody;
            $rs['ar'] = $returnAR;
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }
    
    public function save($field) {
        $rs = array ();
        $ar = WaterBodyAR::model();
        $ar->waterbody = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idwaterbody == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idwaterbody;
            $rs['field'] = $rs['ar']->waterbody;
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

    public function saveBGT($ar) {
        $rs = array();
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idwaterbody == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;
            
            return $rs;
        }
        else {
            $erros = array();
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
