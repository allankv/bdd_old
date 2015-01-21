<?php
class CaptureDeviceLogic {
    var $mainAtt = 'capturedevice';
    public function search($q) {
        $ar = CaptureDeviceAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idcapturedevice+"","label"=>$ar->capturedevice,"value"=>$ar->capturedevice);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = CaptureDeviceAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new CaptureDeviceAR();
        $rs = array();

        $ar->capturedevice = $field;
        $ar->idcapturedevice = $id;

        if(isset($ar->idcapturedevice)) {
            $returnAR = CaptureDeviceAR::model()->findByPk($ar->idcapturedevice);
        }else {
            $ar->capturedevice = trim($ar->capturedevice);
            $returnAR = CaptureDeviceAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->capturedevice."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idcapturedevice;
            $rs['field'] = $returnAR->capturedevice;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = CaptureDeviceAR::model();
        $ar->capturedevice = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idcapturedevice == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idcapturedevice;
            $rs['field'] = $rs['ar']->capturedevice;
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
