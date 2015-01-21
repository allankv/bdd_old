<?php
class InfraspecificEpithetLogic {
    var $mainAtt = 'infraspecificepithet';
    public function search($q) {
        $ar = InfraspecificEpithetAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idinfraspecificepithet+"","label"=>$ar->infraspecificepithet,"value"=>$ar->infraspecificepithet);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = InfraspecificEpithetAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new InfraspecificEpithetAR();
        $rs = array();

        $ar->infraspecificepithet = $field;
        $ar->idinfraspecificepithet = $id;

        if(isset($ar->idinfraspecificepithet)) {
            $returnAR = InfraspecificEpithetAR::model()->findByPk($ar->idinfraspecificepithet);
        }else {
            $ar->infraspecificepithet = trim($ar->infraspecificepithet);
            $returnAR = InfraspecificEpithetAR::model()->find("$this->mainAtt='".$ar->infraspecificepithet."'");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idinfraspecificepithet;
            $rs['field'] = $returnAR->infraspecificepithet;
            $rs['ar'] = $returnAR;
        }else {
            $rs['success'] = false;
        }

        return $rs;
    }
    public function save($field, $colvalidation=false) {

    	if ($colvalidation == "") $colvalidation = false;
    	else if ($colvalidation == "true") $colvalidation = true;
    	else if ($colvalidation == "false") $colvalidation = false;
    
        $rs = array ();
        $ar = InfraspecificEpithetAR::model();
        $ar->infraspecificepithet = trim($field);
        $ar->colvalidation = $colvalidation;
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idinfraspecificepithet == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idinfraspecificepithet;
            $rs['field'] = $rs['ar']->infraspecificepithet;
            $rs['ar'] = $rs['ar']->getAttributes();
            
            return $rs;
        }
        else {
            $erros = array();
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
