<?php
class PollinatorFamilyLogic {
    var $mainAtt = 'pollinatorfamily';
    public function searchList($q) {
        $ar = PollinatorFamilyAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function search($q) {
        $ar = PollinatorFamilyAR::model();
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
            $ln= array ("key"=>"".$ar->idpollinatorfamily,"value"=>$ar->pollinatorfamily);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = PollinatorFamilyAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new PollinatorFamilyAR();
        $rs = array();

        $ar->pollinatorfamily = $field;
        $ar->idpollinatorfamily = $id;

        if(isset($ar->idpollinatorfamily)) {
            $returnAR = PollinatorFamilyAR::model()->findByPk($ar->idpollinatorfamily);
        }else {
            $ar->pollinatorfamily = trim($ar->pollinatorfamily);
            $returnAR = PollinatorFamilyAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->pollinatorfamily."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idpollinatorfamily;
            $rs['field'] = $returnAR->pollinatorfamily;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = PollinatorFamilyAR::model();
        $ar->pollinatorfamily = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idpollinatorfamily == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idpollinatorfamily;
            $rs['field'] = $rs['ar']->pollinatorfamily;
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
    public function getPollinatorFamilyByMedia($ar) {
        $nnList = MediaPollinatorFamilyAR::model()->findAll('idmedia='.$ar->idmedia);
        $pollinatorfamilyList = array();
        foreach ($nnList as $n=>$ar) {
            $pollinatorfamilyList[] = PollinatorFamilyAR::model()->findByPk($ar->idpollinatorfamily);
        }
        return $pollinatorfamilyList;
    }
    public function saveMediaNN($idPollinatorFamily,$idMedia) {
        if(MediaPollinatorFamilyAR::model()->find("idpollinatorfamily=$idPollinatorFamily AND idmedia=$idMedia")==null) {
            $ar = MediaPollinatorFamilyAR::model();
            $ar->idpollinatorfamily = $idPollinatorFamily;
            $ar->idmedia = $idMedia;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteMediaNN($idPollinatorFamily,$idMedia) {
        $ar = MediaPollinatorFamilyAR::model();
        $ar = $ar->find(" idpollinatorfamily=$idPollinatorFamily AND idmedia=$idMedia ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteMediaRecord($id){
        $ar = MediaPollinatorFamilyAR::model();
        $arList = $ar->findAll(" idmedia=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }

    public function getPollinatorFamilyByReference($ar) {
        $nnList = ReferencePollinatorFamilyAR::model()->findAll('idreferenceelement='.$ar->idreferenceelement);
        $pollinatorfamilyList = array();
        foreach ($nnList as $n=>$ar) {
            $pollinatorfamilyList[] = PollinatorFamilyAR::model()->findByPk($ar->idpollinatorfamily);
        }
        return $pollinatorfamilyList;
    }
    public function saveReferenceNN($idPollinatorFamily,$idReference) {
        if(ReferencePollinatorFamilyAR::model()->find("idpollinatorfamily=$idPollinatorFamily AND idreferenceelement=$idReference")==null) {
            $ar = ReferencePollinatorFamilyAR::model();
            $ar->idpollinatorfamily = $idPollinatorFamily;
            $ar->idreferenceelement = $idReference;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteReferenceNN($idPollinatorFamily,$idReference) {
        $ar = ReferencePollinatorFamilyAR::model();
        $ar = $ar->find(" idpollinatorfamily=$idPollinatorFamily AND idreferenceelement=$idReference ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteReferenceRecord($id){
        $ar = ReferencePollinatorFamilyAR::model();
        $arList = $ar->findAll(" idreferenceelement=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }

    public function getPollinatorFamilyBySpecies($ar) {
        $nnList = SpeciesPollinatorFamilyAR::model()->findAll('idspecies='.$ar->idspecies);
        $pollinatorfamilyList = array();
        foreach ($nnList as $n=>$ar) {
            $pollinatorfamilyList[] = PollinatorFamilyAR::model()->findByPk($ar->idpollinatorfamily);
        }
        return $pollinatorfamilyList;
    }
    public function saveSpeciesNN($idPollinatorFamily,$idSpecies) {
        if(SpeciesPollinatorFamilyAR::model()->find("idpollinatorfamily=$idPollinatorFamily AND idspecies=$idSpecies")==null) {
            $ar = SpeciesPollinatorFamilyAR::model();
            $ar->idpollinatorfamily = $idPollinatorFamily;
            $ar->idspecies = $idSpecies;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteSpeciesNN($idPollinatorFamily,$idSpecies) {
        $ar = SpeciesPollinatorFamilyAR::model();
        $ar = $ar->find(" idpollinatorfamily=$idPollinatorFamily AND idspecies=$idSpecies ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteSpeciesRecord($id){
        $ar = SpeciesPollinatorFamilyAR::model();
        $arList = $ar->findAll(" idspecies=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }
}
?>
