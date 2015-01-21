<?php
class IDKeyLogic {
    public function saveSpeciesNN($idreference, $idspecies) {
        if(SpeciesIDKeyAR::model()->find(" idspecies=$idspecies AND idreferenceelement=$idreference ")==null) {
            $ar = SpeciesIDKeyAR::model();
            $ar->idspecies = $idspecies;
            $ar->idreferenceelement = $idreference;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteSpeciesNN($idreference, $idspecies) {
        $ar = SpeciesIDKeyAR::model();
        $ar = $ar->find(" idspecies=$idspecies AND idreferenceelement=$idreference ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteSpecies($idspecies) {
        $ar = SpeciesIDKeyAR::model();
        $arList = $ar->findAll(" idspecies=$idspecies ");
        foreach ($arList as $n=>$ar)
            $ar->delete();
    }
}
?>
