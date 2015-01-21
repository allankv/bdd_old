<?php
class SupportTypeLogic {
    var $mainAtt = 'supporttype';
    public function search($q) {
        $ar = SupportTypeAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;        
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function suggestion($q) {
        $ar = SupportTypeAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }    
    public function getSupportType($ar) {
        if(isset($ar->idsupporttype)){
            return SupportTypeAR::model()->findByPk($ar->idsupporttype);
        }else{
            $ar->supporttype = trim($ar->supporttype);
            return SupportTypeAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->supporttype."')");
        }    
    }
    public function save($ar) {
        $rs = array ();
        $ar->supporttype = trim($ar->supporttype);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idsupporttype == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;            
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
