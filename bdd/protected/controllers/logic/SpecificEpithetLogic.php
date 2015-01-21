<?php
class SpecificEpithetLogic {
    var $mainAtt = 'specificepithet';
    public function searchList($q) {
        $ar = SpecificEpithetAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function search($q) {
        $ar = SpecificEpithetAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idspecificepithet+"","label"=>$ar->specificepithet,"value"=>$ar->specificepithet);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = SpecificEpithetAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new SpecificEpithetAR();
        $rs = array();

        $ar->specificepithet = $field;
        $ar->idspecificepithet = $id;

        if(isset($ar->idspecificepithet)) {
            $returnAR = SpecificEpithetAR::model()->findByPk($ar->idspecificepithet);
        }else {
            $ar->specificepithet = trim($ar->specificepithet);
            $returnAR = SpecificEpithetAR::model()->find("$this->mainAtt='".$ar->specificepithet."'");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idspecificepithet;
            $rs['field'] = $returnAR->specificepithet;
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
        $ar = SpecificEpithetAR::model();
        $ar->specificepithet = trim($field);
        $ar->colvalidation = $colvalidation;
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idspecificepithet == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idspecificepithet;
            $rs['field'] = $rs['ar']->specificepithet;
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
