<?php
class DatasetLogic {
    var $mainAtt = 'dataset';
    public function search($q) {
        $ar = DatasetAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;        
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->iddataset+"","label"=>$ar->dataset,"value"=>$ar->dataset);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = DatasetAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }    
    public function getJSON($field, $id) {

        $ar = new DatasetAR();
        $rs = array();

        $ar->dataset = $field;
        $ar->iddataset = $id;

        if(isset($ar->iddataset)){
            $returnAR = DatasetAR::model()->findByPk($ar->iddataset);
        }else{
            $ar->dataset = trim($ar->dataset);
            $returnAR = DatasetAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->dataset."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->iddataset;
            $rs['field'] = $returnAR->dataset;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;
    }
    public function save($field) {
        $rs = array ();
        $ar = DatasetAR::model();
        $ar->dataset = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['success'] = true;
            $rs['operation'] = $ar->iddataset == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->iddataset;
            $rs['field'] = $rs['ar']->dataset;
            $rs['ar'] = $rs['ar']->getAttributes();

            return $rs;
        }else{
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
