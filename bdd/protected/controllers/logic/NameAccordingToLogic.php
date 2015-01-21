<?php
class NameAccordingToLogic {
    var $mainAtt = 'nameaccordingto';
    public function search($q) {
        $ar = NameAccordingToAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idnameaccordingto+"","label"=>$ar->nameaccordingto,"value"=>$ar->nameaccordingto);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = NameAccordingToAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new NameAccordingToAR();
        $rs = array();

        $ar->nameaccordingto = $field;
        $ar->idnameaccordingto = $id;

        if(isset($ar->idnameaccordingto)) {
            $returnAR = NameAccordingToAR::model()->findByPk($ar->idnameaccordingto);
        }else {
            $ar->nameaccordingto = trim($ar->nameaccordingto);
            $returnAR = NameAccordingToAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->nameaccordingto."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idnameaccordingto;
            $rs['field'] = $returnAR->nameaccordingto;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;
    }
    public function save($field) {
        $rs = array ();
        $ar = NameAccordingToAR::model();
        $ar->nameaccordingto = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idnameaccordingto == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idnameaccordingto;
            $rs['field'] = $rs['ar']->nameaccordingto;
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
