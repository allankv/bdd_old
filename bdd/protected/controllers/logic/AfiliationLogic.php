<?php
class AfiliationLogic {
    var $mainAtt = 'afiliation';
    public function searchList($q) {
        $ar = AfiliationAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function search($q) {
        $ar = AfiliationAR::model();
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
            $ln= array ("key"=>"".$ar->idafiliation,"value"=>$ar->afiliation);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = AfiliationAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new AfiliationAR();
        $rs = array();

        $ar->afiliation = $field;
        $ar->idafiliation = $id;

        if(isset($ar->idafiliation)) {
            $returnAR = AfiliationAR::model()->findByPk($ar->idafiliation);
        }else {
            $ar->afiliation = trim($ar->afiliation);
            $returnAR = AfiliationAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->afiliation."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idafiliation;
            $rs['field'] = $returnAR->afiliation;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = AfiliationAR::model();
        $ar->afiliation = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idafiliation == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idafiliation;
            $rs['field'] = $rs['ar']->afiliation;
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
    public function getAfiliationByMedia($ar) {
        $nnList = MediaAfiliationAR::model()->findAll('idmedia='.$ar->idmedia);
        $afiliationList = array();
        foreach ($nnList as $n=>$ar) {
            $afiliationList[] = AfiliationAR::model()->findByPk($ar->idafiliation);
        }
        return $afiliationList;
    }
    public function saveMediaNN($idAfiliation,$idMedia) {
        if(MediaAfiliationAR::model()->find("idafiliation=$idAfiliation AND idmedia=$idMedia")==null) {
            $ar = MediaAfiliationAR::model();
            $ar->idafiliation = $idAfiliation;
            $ar->idmedia = $idMedia;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteMediaNN($idAfiliation,$idMedia) {
        $ar = MediaAfiliationAR::model();
        $ar = $ar->find(" idafiliation=$idAfiliation AND idmedia=$idMedia ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteMediaRecord($id){
        $ar = MediaAfiliationAR::model();
        $arList = $ar->findAll(" idmedia=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }

    public function getAfiliationByReference($ar) {
        $nnList = ReferenceAfiliationAR::model()->findAll('idreferenceelement='.$ar->idreferenceelement);
        $afiliationList = array();
        foreach ($nnList as $n=>$ar) {
            $afiliationList[] = AfiliationAR::model()->findByPk($ar->idafiliation);
        }
        return $afiliationList;
    }
    public function saveReferenceNN($idAfiliation,$idReference) {
        if(ReferenceAfiliationAR::model()->find("idafiliation=$idAfiliation AND idreferenceelement=$idReference")==null) {
            $ar = ReferenceAfiliationAR::model();
            $ar->idafiliation = $idAfiliation;
            $ar->idreferenceelement = $idReference;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteReferenceNN($idAfiliation,$idReference) {
        $ar = ReferenceAfiliationAR::model();
        $ar = $ar->find(" idafiliation=$idAfiliation AND idreferenceelement=$idReference ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteReferenceRecord($id){
        $ar = ReferenceAfiliationAR::model();
        $arList = $ar->findAll(" idreferenceelement=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }

    public function getAfiliationBySpecies($ar) {
        $nnList = SpeciesAfiliationAR::model()->findAll('idspecies='.$ar->idspecies);
        $afiliationList = array();
        foreach ($nnList as $n=>$ar) {
            $afiliationList[] = AfiliationAR::model()->findByPk($ar->idafiliation);
        }
        return $afiliationList;
    }
    public function saveSpeciesNN($idAfiliation,$idSpecies) {
        if(SpeciesAfiliationAR::model()->find("idafiliation=$idAfiliation AND idspecies=$idSpecies")==null) {
            $ar = SpeciesAfiliationAR::model();
            $ar->idafiliation = $idAfiliation;
            $ar->idspecies = $idSpecies;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteSpeciesNN($idAfiliation,$idSpecies) {
        $ar = SpeciesAfiliationAR::model();
        $ar = $ar->find(" idafiliation=$idAfiliation AND idspecies=$idSpecies ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteSpeciesRecord($id){
        $ar = SpeciesAfiliationAR::model();
        $arList = $ar->findAll(" idspecies=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }
}
?>
