<?php
class PollinatorCommonNameLogic {
    var $mainAtt = 'pollinatorcommonname';
    public function searchList($q) {
        $ar = PollinatorCommonNameAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function search($q) {
        $ar = PollinatorCommonNameAR::model();
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
            $ln= array ("key"=>"".$ar->idpollinatorcommonname,"value"=>$ar->pollinatorcommonname);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = PollinatorCommonNameAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new PollinatorCommonNameAR();
        $rs = array();

        $ar->pollinatorcommonname = $field;
        $ar->idpollinatorcommonname = $id;

        if(isset($ar->idpollinatorcommonname)) {
            $returnAR = PollinatorCommonNameAR::model()->findByPk($ar->idpollinatorcommonname);
        }else {
            $ar->pollinatorcommonname = trim($ar->pollinatorcommonname);
            $returnAR = PollinatorCommonNameAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->pollinatorcommonname."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idpollinatorcommonname;
            $rs['field'] = $returnAR->pollinatorcommonname;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = PollinatorCommonNameAR::model();
        $ar->pollinatorcommonname = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idpollinatorcommonname == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idpollinatorcommonname;
            $rs['field'] = $rs['ar']->pollinatorcommonname;
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
    public function getPollinatorCommonNameByMedia($ar) {
        $nnList = MediaPollinatorCommonNameAR::model()->findAll('idmedia='.$ar->idmedia);
        $pollinatorcommonnameList = array();
        foreach ($nnList as $n=>$ar) {
            $pollinatorcommonnameList[] = PollinatorCommonNameAR::model()->findByPk($ar->idpollinatorcommonname);
        }
        return $pollinatorcommonnameList;
    }
    public function saveMediaNN($idPollinatorCommonName,$idMedia) {
        if(MediaPollinatorCommonNameAR::model()->find("idpollinatorcommonname=$idPollinatorCommonName AND idmedia=$idMedia")==null) {
            $ar = MediaPollinatorCommonNameAR::model();
            $ar->idpollinatorcommonname = $idPollinatorCommonName;
            $ar->idmedia = $idMedia;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteMediaNN($idPollinatorCommonName,$idMedia) {
        $ar = MediaPollinatorCommonNameAR::model();
        $ar = $ar->find(" idpollinatorcommonname=$idPollinatorCommonName AND idmedia=$idMedia ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteMediaRecord($id){
        $ar = MediaPollinatorCommonNameAR::model();
        $arList = $ar->findAll(" idmedia=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }

    public function getPollinatorCommonNameByReference($ar) {
        $nnList = ReferencePollinatorCommonNameAR::model()->findAll('idreferenceelement='.$ar->idreferenceelement);
        $pollinatorcommonnameList = array();
        foreach ($nnList as $n=>$ar) {
            $pollinatorcommonnameList[] = PollinatorCommonNameAR::model()->findByPk($ar->idpollinatorcommonname);
        }
        return $pollinatorcommonnameList;
    }
    public function saveReferenceNN($idPollinatorCommonName,$idReference) {
        if(ReferencePollinatorCommonNameAR::model()->find("idpollinatorcommonname=$idPollinatorCommonName AND idreferenceelement=$idReference")==null) {
            $ar = ReferencePollinatorCommonNameAR::model();
            $ar->idpollinatorcommonname = $idPollinatorCommonName;
            $ar->idreferenceelement = $idReference;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteReferenceNN($idPollinatorCommonName,$idReference) {
        $ar = ReferencePollinatorCommonNameAR::model();
        $ar = $ar->find(" idpollinatorcommonname=$idPollinatorCommonName AND idreferenceelement=$idReference ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteReferenceRecord($id){
        $ar = ReferencePollinatorCommonNameAR::model();
        $arList = $ar->findAll(" idreferenceelement=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }

    public function getPollinatorCommonNameBySpecies($ar) {
        $nnList = SpeciesPollinatorCommonNameAR::model()->findAll('idspecies='.$ar->idspecies);
        $pollinatorcommonnameList = array();
        foreach ($nnList as $n=>$ar) {
            $pollinatorcommonnameList[] = PollinatorCommonNameAR::model()->findByPk($ar->idpollinatorcommonname);
        }
        return $pollinatorcommonnameList;
    }
    public function saveSpeciesNN($idPollinatorCommonName,$idSpecies) {
        if(SpeciesPollinatorCommonNameAR::model()->find("idpollinatorcommonname=$idPollinatorCommonName AND idspecies=$idSpecies")==null) {
            $ar = SpeciesPollinatorCommonNameAR::model();
            $ar->idpollinatorcommonname = $idPollinatorCommonName;
            $ar->idspecies = $idSpecies;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteSpeciesNN($idPollinatorCommonName,$idSpecies) {
        $ar = SpeciesPollinatorCommonNameAR::model();
        $ar = $ar->find(" idpollinatorcommonname=$idPollinatorCommonName AND idspecies=$idSpecies ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteSpeciesRecord($id){
        $ar = SpeciesPollinatorCommonNameAR::model();
        $arList = $ar->findAll(" idspecies=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }
}
?>
