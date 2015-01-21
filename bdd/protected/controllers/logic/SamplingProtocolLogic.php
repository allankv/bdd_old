<?php
class SamplingProtocolLogic {
    var $mainAtt = 'samplingprotocol';
    public function search($q) {
        $ar = SamplingProtocolAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;        
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idsamplingprotocol+"","label"=>$ar->samplingprotocol,"value"=>$ar->samplingprotocol);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = SamplingProtocolAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }    
    public function getJSON($field, $id) {

        $ar = new SamplingProtocolAR();
        $rs = array();

        $ar->samplingprotocol = $field;
        $ar->idsamplingprotocol = $id;

        if(isset($ar->idsamplingprotocol)){
            $returnAR = SamplingProtocolAR::model()->findByPk($ar->idsamplingprotocol);
        }else{
            $ar->samplingprotocol = trim($ar->samplingprotocol);
            $returnAR = SamplingProtocolAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->samplingprotocol."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idsamplingprotocol;
            $rs['field'] = $returnAR->samplingprotocol;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;
    }
    public function save($field) {
        $rs = array ();
        $ar = SamplingProtocolAR::model();
        $ar->samplingprotocol = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idsamplingprotocol == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idsamplingprotocol;
            $rs['field'] = $rs['ar']->samplingprotocol;
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
