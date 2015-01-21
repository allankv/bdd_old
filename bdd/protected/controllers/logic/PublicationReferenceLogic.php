<?php
class PublicationReferenceLogic {
    public function saveSpeciesNN($idreference, $idspecies) {
        if(SpeciesPublicationReferenceAR::model()->find(" idspecies=$idspecies AND idreferenceelement=$idreference ")==null) {
            $ar = SpeciesPublicationReferenceAR::model();
            $ar->idspecies = $idspecies;
            $ar->idreferenceelement = $idreference;
            $ar->setIsNewRecord(true);
            $ar->save(false);
        }
    }
    public function deleteSpeciesNN($idreference, $idspecies) {
        $ar = SpeciesPublicationReferenceAR::model();
        $ar = $ar->find(" idspecies=$idspecies AND idreferenceelement=$idreference ");
        if($ar!=null) {
            $ar->delete();
        }
    }
    public function deleteSpecies($idspecies) {
        $ar = SpeciesPublicationReferenceAR::model();
        $arList = $ar->findAll(" idspecies=$idspecies ");
        foreach ($arList as $n=>$ar)
            $ar->delete();
    }
}
?>
