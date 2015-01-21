<?php
class IdentificationQualifierLogic {
    var $mainAtt = 'identificationqualifier';
    public function search($q) {
        $ar = IdentificationQualifierAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;        
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->ididentificationqualifier+"","label"=>$ar->identificationqualifier,"value"=>$ar->identificationqualifier);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = IdentificationQualifierAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }    
    public function getJSON($field, $id) {

        $ar = new IdentificationQualifierAR();
        $rs = array();

        $ar->identificationqualifier = $field;
        $ar->ididentificationqualifier = $id;


        if(isset($ar->ididentificationqualifier)){
            $returnAR = IdentificationQualifierAR::model()->findByPk($ar->ididentificationqualifier);
        }else{
            $ar->identificationqualifier = trim($ar->identificationqualifier);
            $returnAR = IdentificationQualifierAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->identificationqualifier."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->ididentificationqualifier;
            $rs['field'] = $returnAR->identificationqualifier;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;
    }
    public function save($field) {
        $rs = array ();
        $ar = IdentificationQualifierAR::model();
        $ar->identificationqualifier = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->ididentificationqualifier == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->ididentificationqualifier;
            $rs['field'] = $rs['ar']->identificationqualifier;
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
