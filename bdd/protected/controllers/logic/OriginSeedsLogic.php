<?php
class OriginSeedsLogic {
    var $mainAtt = 'originseeds';
    public function search($q) {
        $ar = OriginSeedsAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idoriginseeds+"","label"=>$ar->originseeds,"value"=>$ar->originseeds);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = OriginSeedsAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new OriginSeedsAR();
        $rs = array();

        $ar->originseeds = $field;
        $ar->idoriginseeds = $id;

        if(isset($ar->idoriginseeds)) {
            $returnAR = OriginSeedsAR::model()->findByPk($ar->idoriginseeds);
        }else {
            $ar->originseeds = trim($ar->originseeds);
            $returnAR = OriginSeedsAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->originseeds."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idoriginseeds;
            $rs['field'] = $returnAR->originseeds;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = OriginSeedsAR::model();
        $ar->originseeds = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idoriginseeds == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idoriginseeds;
            $rs['field'] = $rs['ar']->originseeds;
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
