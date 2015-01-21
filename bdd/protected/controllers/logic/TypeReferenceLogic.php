<?php
class TypeReferenceLogic {
    var $mainAtt = 'typereference';
    public function search($q) {
        $ar = TypeReferenceAR::model();
        $q = trim(addslashes($q));
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function suggestion($q) {
        $ar = TypeReferenceAR::model();
        $q = trim(addslashes($q));
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getTypeReference($ar) {
        if(isset($ar->idtypereference)) {
            return TypeReferenceAR::model()->findByPk($ar->idtypereference);
        }else {
            $ar->typereference = trim(addslashes($ar->typereference));
            return TypeReferenceAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->typereference."')");
        }
    }
    public function save($ar) {
        $rs = array ();
        $ar->typereference = trim(addslashes($ar->typereference));
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idtypereference==null?'create':'update';
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
