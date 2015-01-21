<?php
include 'logic/PlantSpeciesLogic.php';
include 'SuggestionController.php';
class PlantspeciesController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new PlantSpeciesLogic();

        //Call parent function
        parent::filters();
    }

    public function actionSaveMediaNN() {
        $logic = new PlantSpeciesLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveMediaNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteMediaNN($_POST['idElement'], $_POST['idElement']);
    }
    public function actionGetNNByMedia() {
        $logic = new PlantSpeciesLogic();
        $ar = MediaAR::model();
        $ar->idmedia = $_POST['idTarget'];
        $plantspeciesList = $logic->getPlantSpeciesByMedia($ar);
        $rs = array();
        foreach ($plantspeciesList as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idplantspecies;
            $o['name'] = $ar->plantspecies;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }

    public function actionSaveReferenceNN() {
        $logic = new PlantSpeciesLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveReferenceNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteReferenceNN($_POST['idItem'], $_POST['idElement']);
    }
    public function actionGetNNByReference() {
        $logic = new PlantSpeciesLogic();
        $ar = ReferenceAR::model();
        $ar->idreferenceelement = $_POST['idTarget'];
        $plantspeciesList = $logic->getPlantSpeciesByReference($ar);
        $rs = array();
        foreach ($plantspeciesList as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idplantspecies;
            $o['name'] = $ar->plantspecies;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }

    public function actionSaveSpeciesNN() {
        $logic = new PlantSpeciesLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveSpeciesNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteSpeciesNN($_POST['idItem'], $_POST['idElement']);
    }

    public function actionGetNNBySpecies() {
        $logic = new PlantSpeciesLogic();
        $ar = SpeciesAR::model();
        $ar->idspecies = $_POST['idTarget'];
        $plantspeciesList = $logic->getPlantSpeciesBySpecies($ar);
        $rs = array();
        foreach ($plantspeciesList as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idplantspecies;
            $o['name'] = $ar->plantspecies;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }
}
