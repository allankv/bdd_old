<?php
class Site_Logic {
    var $mainAtt = 'site_';
    public function searchList($q) {
        $ar = Site_AR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function search($q) {
        $ar = Site_AR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idsite_+"","label"=>$ar->site_,"value"=>$ar->site_);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = Site_AR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new Site_AR();
        $rs = array();

        $ar->site_ = $field;
        $ar->idsite_ = $id;

        if(isset($ar->idsite_)) {
            $returnAR = Site_AR::model()->findByPk($ar->idsite_);
        }else {
            $ar->site_ = trim($ar->site_);
            $returnAR = Site_AR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->site_."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idsite_;
            $rs['field'] = $returnAR->site_;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = Site_AR::model();
        $ar->site_ = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idsite_ == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idsite_;
            $rs['field'] = $rs['ar']->site_;
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
