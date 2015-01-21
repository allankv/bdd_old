<?php
class EstablishmentMeanLogic {
    var $mainAtt = 'establishmentmean';
    public function search($q) {
        $ar = EstablishmentMeanAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;        
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idestablishmentmean+"","label"=>$ar->establishmentmean,"value"=>$ar->establishmentmean);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = EstablishmentMeanAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }    
    public function getJSON($field, $id) {

        $ar = new EstablishmentMeanAR();
        $rs = array();

        $ar->establishmentmean = $field;
        $ar->idestablishmentmean = $id;

        if(isset($ar->idestablishmentmean)){
            $returnAR = EstablishmentMeanAR::model()->findByPk($ar->idestablishmentmean);
        }else{
            $ar->establishmentmean = trim($ar->establishmentmean);
            $returnAR = EstablishmentMeanAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->establishmentmean."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idestablishmentmean;
            $rs['field'] = $returnAR->establishmentmean;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;
    }
    public function save($field) {
        $rs = array ();
        $ar = EstablishmentMeanAR::model();
        $ar->establishmentmean = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idestablishmentmean == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idestablishmentmean;
            $rs['field'] = $rs['ar']->establishmentmean;
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
