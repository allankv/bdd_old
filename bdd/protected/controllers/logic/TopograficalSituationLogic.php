<?php
class TopograficalSituationLogic {
    var $mainAtt = 'topograficalsituation';
    public function search($q) {
        $ar = TopograficalSituationAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idtopograficalsituation+"","label"=>$ar->topograficalsituation,"value"=>$ar->topograficalsituation);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = TopograficalSituationAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new TopograficalSituationAR();
        $rs = array();

        $ar->topograficalsituation = $field;
        $ar->idtopograficalsituation = $id;

        if(isset($ar->idtopograficalsituation)) {
            $returnAR = TopograficalSituationAR::model()->findByPk($ar->idtopograficalsituation);
        }else {
            $ar->topograficalsituation = trim($ar->topograficalsituation);
            $returnAR = TopograficalSituationAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->topograficalsituation."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idtopograficalsituation;
            $rs['field'] = $returnAR->topograficalsituation;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = TopograficalSituationAR::model();
        $ar->topograficalsituation = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idtopograficalsituation == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idtopograficalsituation;
            $rs['field'] = $rs['ar']->topograficalsituation;
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
