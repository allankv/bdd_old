<?php
class PlantCommonNameLogic {
    var $mainAtt = 'plantcommonname';
    public function searchList($q) {
        $ar = PlantCommonNameAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function search($q) {
        $ar = PlantCommonNameAR::model();
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
            $ln= array ("key"=>"".$ar->idplantcommonname,"value"=>$ar->plantcommonname);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = PlantCommonNameAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new PlantCommonNameAR();
        $rs = array();

        $ar->plantcommonname = $field;
        $ar->idplantcommonname = $id;

        if(isset($ar->idplantcommonname)) {
            $returnAR = PlantCommonNameAR::model()->findByPk($ar->idplantcommonname);
        }else {
            $ar->plantcommonname = trim($ar->plantcommonname);
            $returnAR = PlantCommonNameAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->plantcommonname."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idplantcommonname;
            $rs['field'] = $returnAR->plantcommonname;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = PlantCommonNameAR::model();
        $ar->plantcommonname = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idplantcommonname == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idplantcommonname;
            $rs['field'] = $rs['ar']->plantcommonname;
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
    public function getPlantCommonNameByMedia($ar) {
        $nnList = MediaPlantCommonNameAR::model()->findAll('idmedia='.$ar->idmedia);
        $plantcommonnameList = array();
        foreach ($nnList as $n=>$ar) {
            $plantcommonnameList[] = PlantCommonNameAR::model()->findByPk($ar->idplantcommonname);
        }
        return $plantcommonnameList;
    }
    public function saveMediaNN($idPlantCommonName,$idMedia) {
        if(MediaPlantCommonNameAR::model()->find("idplantcommonname=$idPlantCommonName AND idmedia=$idMedia")==null) {
            $ar = MediaPlantCommonNameAR::model();
            $ar->idplantcommonname = $idPlantCommonName;
            $ar->idmedia = $idMedia;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteMediaNN($idPlantCommonName,$idMedia) {
        $ar = MediaPlantCommonNameAR::model();
        $ar = $ar->find(" idplantcommonname=$idPlantCommonName AND idmedia=$idMedia ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteMediaRecord($id){
        $ar = MediaPlantCommonNameAR::model();
        $arList = $ar->findAll(" idmedia=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }

    public function getPlantCommonNameByReference($ar) {
        $nnList = ReferencePlantCommonNameAR::model()->findAll('idreferenceelement='.$ar->idreferenceelement);
        $plantcommonnameList = array();
        foreach ($nnList as $n=>$ar) {
            $plantcommonnameList[] = PlantCommonNameAR::model()->findByPk($ar->idplantcommonname);
        }
        return $plantcommonnameList;
    }
    public function saveReferenceNN($idPlantCommonName,$idReference) {
        if(ReferencePlantCommonNameAR::model()->find("idplantcommonname=$idPlantCommonName AND idreferenceelement=$idReference")==null) {
            $ar = ReferencePlantCommonNameAR::model();
            $ar->idplantcommonname = $idPlantCommonName;
            $ar->idreferenceelement = $idReference;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteReferenceNN($idPlantCommonName,$idReference) {
        $ar = ReferencePlantCommonNameAR::model();
        $ar = $ar->find(" idplantcommonname=$idPlantCommonName AND idreferenceelement=$idReference ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteReferenceRecord($id){
        $ar = ReferencePlantCommonNameAR::model();
        $arList = $ar->findAll(" idreferenceelement=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }

    public function getPlantCommonNameBySpecies($ar) {
        $nnList = SpeciesPlantCommonNameAR::model()->findAll('idspecies='.$ar->idspecies);
        $plantcommonnameList = array();
        foreach ($nnList as $n=>$ar) {
            $plantcommonnameList[] = PlantCommonNameAR::model()->findByPk($ar->idplantcommonname);
        }
        return $plantcommonnameList;
    }
    public function saveSpeciesNN($idPlantCommonName,$idSpecies) {
        if(SpeciesPlantCommonNameAR::model()->find("idplantcommonname=$idPlantCommonName AND idspecies=$idSpecies")==null) {
            $ar = SpeciesPlantCommonNameAR::model();
            $ar->idplantcommonname = $idPlantCommonName;
            $ar->idspecies = $idSpecies;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteSpeciesNN($idPlantCommonName,$idSpecies) {
        $ar = SpeciesPlantCommonNameAR::model();
        $ar = $ar->find(" idplantcommonname=$idPlantCommonName AND idspecies=$idSpecies ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteSpeciesRecord($id){
        $ar = SpeciesPlantCommonNameAR::model();
        $arList = $ar->findAll(" idspecies=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }
}
?>
