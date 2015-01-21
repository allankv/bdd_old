<?php
class PredominantBiomeLogic {
    var $mainAtt = 'predominantbiome';
    public function search($q) {
        $ar = PredominantBiomeAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idpredominantbiome+"","label"=>$ar->predominantbiome,"value"=>$ar->predominantbiome);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = PredominantBiomeAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new PredominantBiomeAR();
        $rs = array();

        $ar->predominantbiome = $field;
        $ar->idpredominantbiome = $id;

        if(isset($ar->idpredominantbiome)) {
            $returnAR = PredominantBiomeAR::model()->findByPk($ar->idpredominantbiome);
        }else {
            $ar->predominantbiome = trim($ar->predominantbiome);
            $returnAR = PredominantBiomeAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->predominantbiome."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idpredominantbiome;
            $rs['field'] = $returnAR->predominantbiome;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = PredominantBiomeAR::model();
        $ar->predominantbiome = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idpredominantbiome == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idpredominantbiome;
            $rs['field'] = $rs['ar']->predominantbiome;
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
