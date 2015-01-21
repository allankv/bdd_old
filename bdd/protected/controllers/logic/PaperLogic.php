<?php
class PaperLogic {
    public function saveSpeciesNN($idreference, $idspecies) {
        if(SpeciesPaperAR::model()->find(" idspecies=$idspecies AND idreferenceelement=$idreference ")==null) {
            $ar = SpeciesPaperAR::model();
            $ar->idspecies = $idspecies;
            $ar->idreferenceelement = $idreference;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteSpeciesNN($idreference, $idspecies) {
        $ar = SpeciesPaperAR::model();
        $ar = $ar->find(" idspecies=$idspecies AND idreferenceelement=$idreference ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteSpecies($idspecies) {
        $ar = SpeciesPaperAR::model();
        $arList = $ar->findAll(" idspecies=$idspecies ");
        foreach ($arList as $n=>$ar)
            $ar->delete();
    }
}
?>
