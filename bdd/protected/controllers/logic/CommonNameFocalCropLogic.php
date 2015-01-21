<?php
class CommonNameFocalCropLogic {
    var $mainAtt = 'commonnamefocalcrop';
    public function searchList($q) {
        $ar = CommonNameFocalCropAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function search($q) {
        $ar = CommonNameFocalCropAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idcommonnamefocalcrop+"","label"=>$ar->commonnamefocalcrop,"value"=>$ar->commonnamefocalcrop);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = CommonNameFocalCropAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new CommonNameFocalCropAR();
        $rs = array();

        $ar->commonnamefocalcrop = $field;
        $ar->idcommonnamefocalcrop = $id;

        if(isset($ar->idcommonnamefocalcrop)) {
            $returnAR = CommonNameFocalCropAR::model()->findByPk($ar->idcommonnamefocalcrop);
        }else {
            $ar->commonnamefocalcrop = trim($ar->commonnamefocalcrop);
            $returnAR = CommonNameFocalCropAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->commonnamefocalcrop."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idcommonnamefocalcrop;
            $rs['field'] = $returnAR->commonnamefocalcrop;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = CommonNameFocalCropAR::model();
        $ar->commonnamefocalcrop = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idcommonnamefocalcrop == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idcommonnamefocalcrop;
            $rs['field'] = $rs['ar']->commonnamefocalcrop;
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
