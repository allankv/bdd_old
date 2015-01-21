<?php
class BiomeLogic {
    var $mainAtt = 'biome';
    public function searchList($q) {
        $ar = BiomeAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function search($q) {
        $ar = BiomeAR::model();
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
            $ln= array ("key"=>"".$ar->idbiome,"value"=>$ar->biome);
            $result[] = $ln;
        }

        return $result;
    }
    public function suggestion($q) {
        $ar = BiomeAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 1";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getJSON($field, $id) {

        $ar = new BiomeAR();
        $rs = array();

        $ar->biome = $field;
        $ar->idbiome = $id;

        if(isset($ar->idbiome)) {
            $returnAR = BiomeAR::model()->findByPk($ar->idbiome);
        }else {
            $ar->biome = trim($ar->biome);
            $returnAR = BiomeAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->biome."')");
        }

        if($returnAR!=null) {
            $rs['success'] = true;
            $rs['id'] = $returnAR->idbiome;
            $rs['field'] = $returnAR->biome;
            $rs['ar'] = $returnAR->getAttributes();
        }else {
            $rs['success'] = false;
        }

        return $rs;

    }

    //public function save($ar) {
    public function save($field) {
        $rs = array ();
        $ar = BiomeAR::model();
        $ar->biome = trim($field);
        if($ar->validate()) {
            $rs['success'] = true;
            $rs['operation'] = $ar->idbiome == null?'create':'update';
            $ar->setIsNewRecord($rs['operation']=='create');
            $ar->save();
            $rs['ar'] = $ar;

            $rs['id'] = $rs['ar']->idbiome;
            $rs['field'] = $rs['ar']->biome;
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
    public function getBiomeByMedia($ar) {
        $nnList = MediaBiomeAR::model()->findAll('idmedia='.$ar->idmedia);
        $biomeList = array();
        foreach ($nnList as $n=>$ar) {
            $biomeList[] = BiomeAR::model()->findByPk($ar->idbiome);
        }
        return $biomeList;
    }
    public function saveMediaNN($idBiome,$idMedia) {
        if(MediaBiomeAR::model()->find("idbiome=$idBiome AND idmedia=$idMedia")==null) {
            $ar = MediaBiomeAR::model();
            $ar->idbiome = $idBiome;
            $ar->idmedia = $idMedia;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteMediaNN($idBiome,$idMedia) {
        $ar = MediaBiomeAR::model();
        $ar = $ar->find(" idbiome=$idBiome AND idmedia=$idMedia ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteMediaRecord($id){
        $ar = MediaBiomeAR::model();
        $arList = $ar->findAll(" idmedia=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }

    public function getBiomeByReference($ar) {
        $nnList = ReferenceBiomeAR::model()->findAll('idreferenceelement='.$ar->idreferenceelement);
        $biomeList = array();
        foreach ($nnList as $n=>$ar) {
            $biomeList[] = BiomeAR::model()->findByPk($ar->idbiome);
        }
        return $biomeList;
    }
    public function saveReferenceNN($idBiome,$idReference) {
        if(ReferenceBiomeAR::model()->find("idbiome=$idBiome AND idreferenceelement=$idReference")==null) {
            $ar = ReferenceBiomeAR::model();
            $ar->idbiome = $idBiome;
            $ar->idreferenceelement = $idReference;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteReferenceNN($idBiome,$idReference) {
        $ar = ReferenceBiomeAR::model();
        $ar = $ar->find(" idbiome=$idBiome AND idreferenceelement=$idReference ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteReferenceRecord($id){
        $ar = ReferenceBiomeAR::model();
        $arList = $ar->findAll(" idreferenceelement=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }

    public function getBiomeBySpecies($ar) {
        $nnList = SpeciesBiomeAR::model()->findAll('idspecies='.$ar->idspecies);
        $biomeList = array();
        foreach ($nnList as $n=>$ar) {
            $biomeList[] = BiomeAR::model()->findByPk($ar->idbiome);
        }
        return $biomeList;
    }
    public function saveSpeciesNN($idBiome,$idSpecies) {
        if(SpeciesBiomeAR::model()->find("idbiome=$idBiome AND idspecies=$idSpecies")==null) {
            $ar = SpeciesBiomeAR::model();
            $ar->idbiome = $idBiome;
            $ar->idspecies = $idSpecies;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteSpeciesNN($idBiome,$idSpecies) {
        $ar = SpeciesBiomeAR::model();
        $ar = $ar->find(" idbiome=$idBiome AND idspecies=$idSpecies ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteSpeciesRecord($id){
        $ar = SpeciesBiomeAR::model();
        $arList = $ar->findAll(" idspecies=$id ");
        foreach ($arList as $n=>$ar) {
            $ar->delete();
        }
    }
}
?>
