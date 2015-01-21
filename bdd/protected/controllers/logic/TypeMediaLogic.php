<?php
class TypeMediaLogic {
    var $mainAtt = 'typemedia';
    public function search($q) {
        $ar = TypeMediaAR::model();
        $q = trim(addslashes($q));
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function suggestion($q) {
        $ar = TypeMediaAR::model();
        $q = trim(addslashes($q));
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getTypeMedia($ar) {
        if(isset($ar->idtypemedia)) {
            return TypeMediaAR::model()->findByPk($ar->idtypemedia);
        }else {
            $ar->typemedia = trim(addslashes($ar->typemedia));
            return TypeMediaAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->typemedia."')");
        }
    }
    public function save($ar) {
        $rs = array ();
        $ar->typemedia = trim(addslashes($ar->typemedia));
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idtypemedia==null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;
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
