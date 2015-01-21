<?php
class PlantFamilyLogic {
    var $mainAtt = 'plantfamily';
    public function searchList($q) {
        $ar = PlantFamilyAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function search($q) {
        $ar = PlantFamilyAR::model();
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
            $ln= array ("key"=>"".$ar->idplantfamily,"value"=>$ar->plantfamily);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = PlantFamilyAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new PlantFamilyAR();
        $rs = array();

        $ar->plantfamily = $field;
        $ar->idplantfamily = $id;

        if(isset($ar->idplantfamily)) {
            $returnAR = PlantFamilyAR::model()->findByPk($ar->idplantfamily);
        }else {
            $ar->plantfamily = trim($ar->plantfamily);
            $returnAR = PlantFamilyAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->plantfamily."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idplantfamily;
            $rs['field'] = $returnAR->plantfamily;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = PlantFamilyAR::model();
        $ar->plantfamily = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idplantfamily == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idplantfamily;
            $rs['field'] = $rs['ar']->plantfamily;
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
    public function getPlantFamilyByMedia($ar) {
        $nnList = MediaPlantFamilyAR::model()->findAll('idmedia='.$ar->idmedia);
        $plantfamilyList = array();
        foreach ($nnList as $n=>$ar) {
            $plantfamilyList[] = PlantFamilyAR::model()->findByPk($ar->idplantfamily);
        }
        return $plantfamilyList;
    }
    public function saveMediaNN($idPlantFamily,$idMedia) {
        if(MediaPlantFamilyAR::model()->find("idplantfamily=$idPlantFamily AND idmedia=$idMedia")==null) {
            $ar = MediaPlantFamilyAR::model();
            $ar->idplantfamily = $idPlantFamily;
            $ar->idmedia = $idMedia;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteMediaNN($idPlantFamily,$idMedia) {
        $ar = MediaPlantFamilyAR::model();
        $ar = $ar->find(" idplantfamily=$idPlantFamily AND idmedia=$idMedia ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteMediaRecord($id){
        $ar = MediaPlantFamilyAR::model();
        $arList = $ar->findAll(" idmedia=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }

    public function getPlantFamilyByReference($ar) {
        $nnList = ReferencePlantFamilyAR::model()->findAll('idreferenceelement='.$ar->idreferenceelement);
        $plantfamilyList = array();
        foreach ($nnList as $n=>$ar) {
            $plantfamilyList[] = PlantFamilyAR::model()->findByPk($ar->idplantfamily);
        }
        return $plantfamilyList;
    }
    public function saveReferenceNN($idPlantFamily,$idReference) {
        if(ReferencePlantFamilyAR::model()->find("idplantfamily=$idPlantFamily AND idreferenceelement=$idReference")==null) {
            $ar = ReferencePlantFamilyAR::model();
            $ar->idplantfamily = $idPlantFamily;
            $ar->idreferenceelement = $idReference;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteReferenceNN($idPlantFamily,$idReference) {
        $ar = ReferencePlantFamilyAR::model();
        $ar = $ar->find(" idplantfamily=$idPlantFamily AND idreferenceelement=$idReference ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteReferenceRecord($id){
        $ar = ReferencePlantFamilyAR::model();
        $arList = $ar->findAll(" idreferenceelement=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }

    public function getPlantFamilyBySpecies($ar) {
        $nnList = SpeciesPlantFamilyAR::model()->findAll('idspecies='.$ar->idspecies);
        $plantfamilyList = array();
        foreach ($nnList as $n=>$ar) {
            $plantfamilyList[] = PlantFamilyAR::model()->findByPk($ar->idplantfamily);
        }
        return $plantfamilyList;
    }
    public function saveSpeciesNN($idPlantFamily,$idSpecies) {
        if(SpeciesPlantFamilyAR::model()->find("idplantfamily=$idPlantFamily AND idspecies=$idSpecies")==null) {
            $ar = SpeciesPlantFamilyAR::model();
            $ar->idplantfamily = $idPlantFamily;
            $ar->idspecies = $idSpecies;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteSpeciesNN($idPlantFamily,$idSpecies) {
        $ar = SpeciesPlantFamilyAR::model();
        $ar = $ar->find(" idplantfamily=$idPlantFamily AND idspecies=$idSpecies ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteSpeciesRecord($id){
        $ar = SpeciesPlantFamilyAR::model();
        $arList = $ar->findAll(" idspecies=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }
}
?>
