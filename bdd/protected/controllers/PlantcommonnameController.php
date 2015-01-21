<?php
include 'logic/PlantCommonNameLogic.php';
include 'SuggestionController.php';
class PlantcommonnameController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new PlantCommonNameLogic();

        //Call parent function
        parent::filters();
    }

    public function actionSaveMediaNN() {
        $logic = new PlantCommonNameLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveMediaNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteMediaNN($_POST['idElement'], $_POST['idElement']);
    }
    public function actionGetNNByMedia() {
        $logic = new PlantCommonNameLogic();
        $ar = MediaAR::model();
        $ar->idmedia = $_POST['idTarget'];
        $plantcommonnameList = $logic->getPlantCommonNameByMedia($ar);
        $rs = array();
        foreach ($plantcommonnameList as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idplantcommonname;
            $o['name'] = $ar->plantcommonname;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }

    public function actionSaveReferenceNN() {
        $logic = new PlantCommonNameLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveReferenceNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteReferenceNN($_POST['idItem'], $_POST['idElement']);
    }
    public function actionGetNNByReference() {
        $logic = new PlantCommonNameLogic();
        $ar = ReferenceAR::model();
        $ar->idreferenceelement = $_POST['idTarget'];
        $plantcommonnameList = $logic->getPlantCommonNameByReference($ar);
        $rs = array();
        foreach ($plantcommonnameList as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idplantcommonname;
            $o['name'] = $ar->plantcommonname;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }

    public function actionSaveSpeciesNN() {
        $logic = new PlantCommonNameLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveSpeciesNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteSpeciesNN($_POST['idItem'], $_POST['idElement']);
    }

    public function actionGetNNBySpecies() {
        $logic = new PlantCommonNameLogic();
        $ar = SpeciesAR::model();
        $ar->idspecies = $_POST['idTarget'];
        $plantcommonnameList = $logic->getPlantCommonNameBySpecies($ar);
        $rs = array();
        foreach ($plantcommonnameList as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idplantcommonname;
            $o['name'] = $ar->plantcommonname;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }
}
