<?php
include 'logic/PlantFamilyLogic.php';
include 'SuggestionController.php';
class PlantfamilyController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new PlantFamilyLogic();

        //Call parent function
        parent::filters();
    }

    public function actionSaveMediaNN() {
        $logic = new PlantFamilyLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveMediaNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteMediaNN($_POST['idElement'], $_POST['idElement']);
    }
    public function actionGetNNByMedia() {
        $logic = new PlantFamilyLogic();
        $ar = MediaAR::model();
        $ar->idmedia = $_POST['idTarget'];
        $plantfamilyList = $logic->getPlantFamilyByMedia($ar);
        $rs = array();
        foreach ($plantfamilyList as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idplantfamily;
            $o['name'] = $ar->plantfamily;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }

    public function actionSaveReferenceNN() {
        $logic = new PlantFamilyLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveReferenceNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteReferenceNN($_POST['idItem'], $_POST['idElement']);
    }
    public function actionGetNNByReference() {
        $logic = new PlantFamilyLogic();
        $ar = ReferenceAR::model();
        $ar->idreferenceelement = $_POST['idTarget'];
        $plantfamilyList = $logic->getPlantFamilyByReference($ar);
        $rs = array();
        foreach ($plantfamilyList as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idplantfamily;
            $o['name'] = $ar->plantfamily;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }

    public function actionSaveSpeciesNN() {
        $logic = new PlantFamilyLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveSpeciesNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteSpeciesNN($_POST['idItem'], $_POST['idElement']);
    }

    public function actionGetNNBySpecies() {
        $logic = new PlantFamilyLogic();
        $ar = SpeciesAR::model();
        $ar->idspecies = $_POST['idTarget'];
        $plantfamilyList = $logic->getPlantFamilyBySpecies($ar);
        $rs = array();
        foreach ($plantfamilyList as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idplantfamily;
            $o['name'] = $ar->plantfamily;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }
}
