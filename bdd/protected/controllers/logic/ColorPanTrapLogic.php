<?php
class ColorPanTrapLogic {
    var $mainAtt = 'colorpantrap';
    public function search($q) {
        $ar = ColorPanTrapAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idcolorpantrap+"","label"=>$ar->colorpantrap,"value"=>$ar->colorpantrap);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = ColorPanTrapAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new ColorPanTrapAR();
        $rs = array();

        $ar->colorpantrap = $field;
        $ar->idcolorpantrap = $id;

        if(isset($ar->idcolorpantrap)) {
            $returnAR = ColorPanTrapAR::model()->findByPk($ar->idcolorpantrap);
        }else {
            $ar->colorpantrap = trim($ar->colorpantrap);
            $returnAR = ColorPanTrapAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->colorpantrap."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idcolorpantrap;
            $rs['field'] = $returnAR->colorpantrap;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = ColorPanTrapAR::model();
        $ar->colorpantrap = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idcolorpantrap == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idcolorpantrap;
            $rs['field'] = $rs['ar']->colorpantrap;
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
