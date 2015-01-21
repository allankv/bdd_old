<?php
class NomenclaturalCodeLogic {
    var $mainAtt = 'nomenclaturalcode';
    public function search($q) {
        $ar = NomenclaturalCodeAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idnomenclaturalcode+"","label"=>$ar->nomenclaturalcode,"value"=>$ar->nomenclaturalcode);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = NomenclaturalCodeAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {
        
        $ar = new NomenclaturalCodeAR();
        $rs = array();

        $ar->nomenclaturalcode = $field;
        $ar->idnomenclaturalcode = $id;

        if(isset($ar->idnomenclaturalcode)) {
            $returnAR = NomenclaturalCodeAR::model()->findByPk($ar->idnomenclaturalcode);
        }else {
            $ar->nomenclaturalcode = trim($ar->nomenclaturalcode);
            $returnAR = NomenclaturalCodeAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->nomenclaturalcode."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idnomenclaturalcode;
            $rs['field'] = $returnAR->nomenclaturalcode;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;
    }
    public function save($field) {
        $rs = array ();
        $ar = NomenclaturalCodeAR::model();
        $ar->nomenclaturalcode = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idnomenclaturalcode == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idnomenclaturalcode;
            $rs['field'] = $rs['ar']->nomenclaturalcode;
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
