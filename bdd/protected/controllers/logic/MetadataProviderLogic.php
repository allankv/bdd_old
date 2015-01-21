<?php
class MetadataProviderLogic {
    var $mainAtt = 'metadataprovider';
    public function search($q) {
        $ar = MetadataProviderAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();

        foreach ($rs as $n=>$ar) {
            $ln= array ("id"=>$ar->idmetadataprovider+"","label"=>$ar->metadataprovider,"value"=>$ar->metadataprovider);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = MetadataProviderAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new MetadataProviderAR();
        $rs = array();

        $ar->metadataprovider = $field;
        $ar->idmetadataprovider = $id;

        if(isset($ar->idmetadataprovider)) {
            $returnAR = MetadataProviderAR::model()->findByPk($ar->idmetadataprovider);
        }else {
            $ar->metadataprovider = trim($ar->metadataprovider);
            $returnAR = MetadataProviderAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->metadataprovider."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idmetadataprovider;
            $rs['field'] = $returnAR->metadataprovider;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = MetadataProviderAR::model();
        $ar->metadataprovider = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idmetadataprovider == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idmetadataprovider;
            $rs['field'] = $rs['ar']->metadataprovider;
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
