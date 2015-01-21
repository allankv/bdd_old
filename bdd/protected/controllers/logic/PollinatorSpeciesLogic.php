<?php
class PollinatorSpeciesLogic {
    var $mainAtt = 'pollinatorspecies';
    public function searchList($q) {
        $ar = PollinatorSpeciesAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function search($q) {
        $ar = PollinatorSpeciesAR::model();
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
            $ln= array ("key"=>"".$ar->idpollinatorspecies,"value"=>$ar->pollinatorspecies);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = PollinatorSpeciesAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new PollinatorSpeciesAR();
        $rs = array();

        $ar->pollinatorspecies = $field;
        $ar->idpollinatorspecies = $id;

        if(isset($ar->idpollinatorspecies)) {
            $returnAR = PollinatorSpeciesAR::model()->findByPk($ar->idpollinatorspecies);
        }else {
            $ar->pollinatorspecies = trim($ar->pollinatorspecies);
            $returnAR = PollinatorSpeciesAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->pollinatorspecies."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idpollinatorspecies;
            $rs['field'] = $returnAR->pollinatorspecies;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = PollinatorSpeciesAR::model();
        $ar->pollinatorspecies = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idpollinatorspecies == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idpollinatorspecies;
            $rs['field'] = $rs['ar']->pollinatorspecies;
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
    public function getPollinatorSpeciesByMedia($ar) {
        $nnList = MediaPollinatorSpeciesAR::model()->findAll('idmedia='.$ar->idmedia);
        $pollinatorspeciesList = array();
        foreach ($nnList as $n=>$ar) {
            $pollinatorspeciesList[] = PollinatorSpeciesAR::model()->findByPk($ar->idpollinatorspecies);
        }
        return $pollinatorspeciesList;
    }
    public function saveMediaNN($idPollinatorSpecies,$idMedia) {
        if(MediaPollinatorSpeciesAR::model()->find("idpollinatorspecies=$idPollinatorSpecies AND idmedia=$idMedia")==null) {
            $ar = MediaPollinatorSpeciesAR::model();
            $ar->idpollinatorspecies = $idPollinatorSpecies;
            $ar->idmedia = $idMedia;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteMediaNN($idPollinatorSpecies,$idMedia) {
        $ar = MediaPollinatorSpeciesAR::model();
        $ar = $ar->find(" idpollinatorspecies=$idPollinatorSpecies AND idmedia=$idMedia ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteMediaRecord($id){
        $ar = MediaPollinatorSpeciesAR::model();
        $arList = $ar->findAll(" idmedia=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }

    public function getPollinatorSpeciesByReference($ar) {
        $nnList = ReferencePollinatorSpeciesAR::model()->findAll('idreferenceelement='.$ar->idreferenceelement);
        $pollinatorspeciesList = array();
        foreach ($nnList as $n=>$ar) {
            $pollinatorspeciesList[] = PollinatorSpeciesAR::model()->findByPk($ar->idpollinatorspecies);
        }
        return $pollinatorspeciesList;
    }
    public function saveReferenceNN($idPollinatorSpecies,$idReference) {
        if(ReferencePollinatorSpeciesAR::model()->find("idpollinatorspecies=$idPollinatorSpecies AND idreferenceelement=$idReference")==null) {
            $ar = ReferencePollinatorSpeciesAR::model();
            $ar->idpollinatorspecies = $idPollinatorSpecies;
            $ar->idreferenceelement = $idReference;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteReferenceNN($idPollinatorSpecies,$idReference) {
        $ar = ReferencePollinatorSpeciesAR::model();
        $ar = $ar->find(" idpollinatorspecies=$idPollinatorSpecies AND idreferenceelement=$idReference ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteReferenceRecord($id){
        $ar = ReferencePollinatorSpeciesAR::model();
        $arList = $ar->findAll(" idreferenceelement=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }

    public function getPollinatorSpeciesBySpecies($ar) {
        $nnList = SpeciesPollinatorSpeciesAR::model()->findAll('idspecies='.$ar->idspecies);
        $pollinatorspeciesList = array();
        foreach ($nnList as $n=>$ar) {
            $pollinatorspeciesList[] = PollinatorSpeciesAR::model()->findByPk($ar->idpollinatorspecies);
        }
        return $pollinatorspeciesList;
    }
    public function saveSpeciesNN($idPollinatorSpecies,$idSpecies) {
        if(SpeciesPollinatorSpeciesAR::model()->find("idpollinatorspecies=$idPollinatorSpecies AND idspecies=$idSpecies")==null) {
            $ar = SpeciesPollinatorSpeciesAR::model();
            $ar->idpollinatorspecies = $idPollinatorSpecies;
            $ar->idspecies = $idSpecies;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteSpeciesNN($idPollinatorSpecies,$idSpecies) {
        $ar = SpeciesPollinatorSpeciesAR::model();
        $ar = $ar->find(" idpollinatorspecies=$idPollinatorSpecies AND idspecies=$idSpecies ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteSpeciesRecord($id){
        $ar = SpeciesPollinatorSpeciesAR::model();
        $arList = $ar->findAll(" idspecies=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }
}
?>
