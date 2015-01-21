<?php
class RelatedNameLogic {
    var $mainAtt = 'relatedname';
    public function search($q) {
        $ar = RelatedNameAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        $result = array();
        $ln= array ("key"=>"","value"=>$q." <br>(New)</br>");
            $result[] = $ln;
        foreach ($rs as $n=>$ar) {
            $ln= array ("key"=>"".$ar->idrelatedname,"value"=>$ar->relatedname);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = RelatedNameAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new RelatedNameAR();
        $rs = array();

        $ar->relatedname = $field;
        $ar->idrelatedname = $id;

        if(isset($ar->idrelatedname)) {
            $returnAR = RelatedNameAR::model()->findByPk($ar->idrelatedname);
        }else {
            $ar->relatedname = trim($ar->relatedname);
            $returnAR = RelatedNameAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->relatedname."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idrelatedname;
            $rs['field'] = $returnAR->relatedname;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = RelatedNameAR::model();
        $ar->relatedname = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idrelatedname == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idrelatedname;
            $rs['field'] = $rs['ar']->relatedname;
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
    public function getRelatedNameBySpecies($ar) {
        $nnList = SpeciesRelatedNameAR::model()->findAll('idspecies='.$ar->idspecies);
        $relatedNameList = array();
        foreach ($nnList as $n=>$ar) {
            $relatedNameList[] = RelatedNameAR::model()->findByPk($ar->idrelatedname);
        }
        return $relatedNameList;
    }
    public function saveSpeciesNN($idRelatedName,$idSpecies) {
        if(SpeciesRelatedNameAR::model()->find("idrelatedname=$idRelatedName AND idspecies=$idSpecies")==null) {
            $ar = SpeciesRelatedNameAR::model();
            $ar->idrelatedname = $idRelatedName;
            $ar->idspecies = $idSpecies;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteSpeciesNN($idRelatedName,$idSpecies) {
        $ar = SpeciesRelatedNameAR::model();
        $ar = $ar->find(" idrelatedname=$idRelatedName AND idspecies=$idSpecies ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteSpeciesRecord($id){
        $ar = SpeciesRelatedNameAR::model();
        $arList = $ar->findAll(" idspecies=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }
}
?>
