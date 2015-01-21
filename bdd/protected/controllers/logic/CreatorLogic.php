<?php
class CreatorLogic {
    var $mainAtt = 'creator';
    public function searchList($q) {
        $ar = CreatorAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function search($q) {
        $ar = CreatorAR::model();
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
            $ln= array ("key"=>"".$ar->idcreator,"value"=>$ar->creator);
            $result[] = $ln;
        }

        return $result;
    }
    public function searchEqual($q) {
        $ar = CreatorAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '$q'";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        

        return $rs;
    }
    public function suggestion($q) {
        $ar = CreatorAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new CreatorAR();
        $rs = array();

        $ar->creator = $field;
        $ar->idcreator = $id;

        if(isset($ar->idcreator)) {
            $returnAR = CreatorAR::model()->findByPk($ar->idcreator);
        }else {
            $ar->creator = trim($ar->creator);
            $returnAR = CreatorAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->creator."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idcreator;
            $rs['field'] = $returnAR->creator;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = CreatorAR::model();
        $ar->creator = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idcreator == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idcreator;
            $rs['field'] = $rs['ar']->creator;
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
    public function getCreatorByMedia($ar) {
        $nnList = MediaCreatorAR::model()->findAll('idmedia='.$ar->idmedia);
        $creatorList = array();
        foreach ($nnList as $n=>$ar) {
            $creatorList[] = CreatorAR::model()->findByPk($ar->idcreator);
        }
        return $creatorList;
    }
    public function saveMediaNN($idCreator,$idMedia) {
        if(MediaCreatorAR::model()->find("idcreator=$idCreator AND idmedia=$idMedia")==null) {
            $ar = MediaCreatorAR::model();
            $ar->idcreator = $idCreator;
            $ar->idmedia = $idMedia;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteMediaNN($idCreator,$idMedia) {
        $ar = MediaCreatorAR::model();
        $ar = $ar->find(" idcreator=$idCreator AND idmedia=$idMedia ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteMediaRecord($id){
        $ar = MediaCreatorAR::model();
        $arList = $ar->findAll(" idmedia=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }

    public function getCreatorByReference($ar) {
        $nnList = ReferenceCreatorAR::model()->findAll('idreferenceelement='.$ar->idreferenceelement);
        $creatorList = array();
        foreach ($nnList as $n=>$ar) {
            $creatorList[] = CreatorAR::model()->findByPk($ar->idcreator);
        }
        return $creatorList;
    }
    public function saveReferenceNN($idCreator,$idReference) {
        if(ReferenceCreatorAR::model()->find("idcreator=$idCreator AND idreferenceelement=$idReference")==null) {
            $ar = ReferenceCreatorAR::model();
            $ar->idcreator = $idCreator;
            $ar->idreferenceelement = $idReference;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteReferenceNN($idCreator,$idReference) {
        $ar = ReferenceCreatorAR::model();
        $ar = $ar->find(" idcreator=$idCreator AND idreferenceelement=$idReference ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteReferenceRecord($id){
        $ar = ReferenceCreatorAR::model();
        $arList = $ar->findAll(" idreferenceelement=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }

    public function getCreatorBySpecies($ar) {
        $nnList = SpeciesCreatorAR::model()->findAll('idspecies='.$ar->idspecies);
        $creatorList = array();
        foreach ($nnList as $n=>$ar) {
            $creatorList[] = CreatorAR::model()->findByPk($ar->idcreator);
        }
        return $creatorList;
    }
    public function saveSpeciesNN($idCreator,$idSpecies) {
        if(SpeciesCreatorAR::model()->find("idcreator=$idCreator AND idspecies=$idSpecies")==null) {
            $ar = SpeciesCreatorAR::model();
            $ar->idcreator = $idCreator;
            $ar->idspecies = $idSpecies;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteSpeciesNN($idCreator,$idSpecies) {
        $ar = SpeciesCreatorAR::model();
        $ar = $ar->find(" idcreator=$idCreator AND idspecies=$idSpecies ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteSpeciesRecord($id){
        $ar = SpeciesCreatorAR::model();
        $arList = $ar->findAll(" idspecies=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }
}
?>
