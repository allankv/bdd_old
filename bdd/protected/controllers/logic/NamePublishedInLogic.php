<?php
class NamePublishedInLogic {
    var $mainAtt = 'namepublishedin';
    public function search($q) {
        $ar = NamePublishedInAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idnamepublishedin+"","label"=>$ar->namepublishedin,"value"=>$ar->namepublishedin);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = NamePublishedInAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new NamePublishedInAR();
        $rs = array();

        $ar->namepublishedin = $field;
        $ar->idnamepublishedin = $id;

        if(isset($ar->idnamepublishedin)) {
            $returnAR = NamePublishedInAR::model()->findByPk($ar->idnamepublishedin);
        }else {
            $ar->namepublishedin = trim($ar->namepublishedin);
            $returnAR = NamePublishedInAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->namepublishedin."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idnamepublishedin;
            $rs['field'] = $returnAR->namepublishedin;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;
    }
    public function save($field) {
        $rs = array ();
        $ar = NamePublishedInAR::model();
        $ar->namepublishedin = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idnamepublishedin == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idnamepublishedin;
            $rs['field'] = $rs['ar']->namepublishedin;
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
