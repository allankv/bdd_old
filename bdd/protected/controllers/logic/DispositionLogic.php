<?php
class DispositionLogic {
    var $mainAtt = 'disposition';
    public function search($q) {
        $ar = DispositionAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;        
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->iddisposition+"","label"=>$ar->disposition,"value"=>$ar->disposition);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = DispositionAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }    
    public function getJSON($field, $id) {

        $ar = new DispositionAR();
        $rs = array();

        $ar->disposition = $field;
        $ar->iddisposition = $id;

        if(isset($ar->iddisposition)){
            $returnAR = DispositionAR::model()->findByPk($ar->iddisposition);
        }else{
            $ar->disposition = trim($ar->disposition);
            $returnAR = DispositionAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->disposition."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->iddisposition;
            $rs['field'] = $returnAR->disposition;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;
    }
    public function save($field) {
        $rs = array ();
        $ar = DispositionAR::model();
        $ar->disposition = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->iddisposition == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->iddisposition;
            $rs['field'] = $rs['ar']->disposition;
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
