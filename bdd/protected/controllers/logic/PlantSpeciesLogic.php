<?php
class PlantSpeciesLogic {
    var $mainAtt = 'plantspecies';
    public function searchList($q) {
        $ar = PlantSpeciesAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function search($q) {
        $ar = PlantSpeciesAR::model();
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
            $ln= array ("key"=>"".$ar->idplantspecies,"value"=>$ar->plantspecies);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = PlantSpeciesAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new PlantSpeciesAR();
        $rs = array();

        $ar->plantspecies = $field;
        $ar->idplantspecies = $id;

        if(isset($ar->idplantspecies)) {
            $returnAR = PlantSpeciesAR::model()->findByPk($ar->idplantspecies);
        }else {
            $ar->plantspecies = trim($ar->plantspecies);
            $returnAR = PlantSpeciesAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->plantspecies."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idplantspecies;
            $rs['field'] = $returnAR->plantspecies;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = PlantSpeciesAR::model();
        $ar->plantspecies = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idplantspecies == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idplantspecies;
            $rs['field'] = $rs['ar']->plantspecies;
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
    public function getPlantSpeciesByMedia($ar) {
        $nnList = MediaPlantSpeciesAR::model()->findAll('idmedia='.$ar->idmedia);
        $plantspeciesList = array();
        foreach ($nnList as $n=>$ar) {
            $plantspeciesList[] = PlantSpeciesAR::model()->findByPk($ar->idplantspecies);
        }
        return $plantspeciesList;
    }
    public function saveMediaNN($idPlantSpecies,$idMedia) {
        if(MediaPlantSpeciesAR::model()->find("idplantspecies=$idPlantSpecies AND idmedia=$idMedia")==null) {
            $ar = MediaPlantSpeciesAR::model();
            $ar->idplantspecies = $idPlantSpecies;
            $ar->idmedia = $idMedia;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteMediaNN($idPlantSpecies,$idMedia) {
        $ar = MediaPlantSpeciesAR::model();
        $ar = $ar->find(" idplantspecies=$idPlantSpecies AND idmedia=$idMedia ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteMediaRecord($id){
        $ar = MediaPlantSpeciesAR::model();
        $arList = $ar->findAll(" idmedia=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }

    public function getPlantSpeciesByReference($ar) {
        $nnList = ReferencePlantSpeciesAR::model()->findAll('idreferenceelement='.$ar->idreferenceelement);
        $plantspeciesList = array();
        foreach ($nnList as $n=>$ar) {
            $plantspeciesList[] = PlantSpeciesAR::model()->findByPk($ar->idplantspecies);
        }
        return $plantspeciesList;
    }
    public function saveReferenceNN($idPlantSpecies,$idReference) {
        if(ReferencePlantSpeciesAR::model()->find("idplantspecies=$idPlantSpecies AND idreferenceelement=$idReference")==null) {
            $ar = ReferencePlantSpeciesAR::model();
            $ar->idplantspecies = $idPlantSpecies;
            $ar->idreferenceelement = $idReference;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteReferenceNN($idPlantSpecies,$idReference) {
        $ar = ReferencePlantSpeciesAR::model();
        $ar = $ar->find(" idplantspecies=$idPlantSpecies AND idreferenceelement=$idReference ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteReferenceRecord($id){
        $ar = ReferencePlantSpeciesAR::model();
        $arList = $ar->findAll(" idreferenceelement=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }

    public function getPlantSpeciesBySpecies($ar) {
        $nnList = SpeciesPlantSpeciesAR::model()->findAll('idspecies='.$ar->idspecies);
        $plantspeciesList = array();
        foreach ($nnList as $n=>$ar) {
            $plantspeciesList[] = PlantSpeciesAR::model()->findByPk($ar->idplantspecies);
        }
        return $plantspeciesList;
    }
    public function saveSpeciesNN($idPlantSpecies,$idSpecies) {
        if(SpeciesPlantSpeciesAR::model()->find("idplantspecies=$idPlantSpecies AND idspecies=$idSpecies")==null) {
            $ar = SpeciesPlantSpeciesAR::model();
            $ar->idplantspecies = $idPlantSpecies;
            $ar->idspecies = $idSpecies;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteSpeciesNN($idPlantSpecies,$idSpecies) {
        $ar = SpeciesPlantSpeciesAR::model();
        $ar = $ar->find(" idplantspecies=$idPlantSpecies AND idspecies=$idSpecies ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteSpeciesRecord($id){
        $ar = SpeciesPlantSpeciesAR::model();
        $arList = $ar->findAll(" idspecies=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }
}
?>
