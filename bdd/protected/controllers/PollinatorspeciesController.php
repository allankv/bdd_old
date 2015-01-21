<?php
include 'logic/PollinatorSpeciesLogic.php';
include 'SuggestionController.php';
class PollinatorspeciesController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new PollinatorSpeciesLogic();

        //Call parent function
        parent::filters();
    }

    public function actionSaveMediaNN() {
        $logic = new PollinatorSpeciesLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveMediaNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteMediaNN($_POST['idElement'], $_POST['idElement']);
    }
    public function actionGetNNByMedia() {
        $logic = new PollinatorSpeciesLogic();
        $ar = MediaAR::model();
        $ar->idmedia = $_POST['idTarget'];
        $pollinatorspeciesList = $logic->getPollinatorSpeciesByMedia($ar);
        $rs = array();
        foreach ($pollinatorspeciesList as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idpollinatorspecies;
            $o['name'] = $ar->pollinatorspecies;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }

    public function actionSaveReferenceNN() {
        $logic = new PollinatorSpeciesLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveReferenceNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteReferenceNN($_POST['idItem'], $_POST['idElement']);
    }
    public function actionGetNNByReference() {
        $logic = new PollinatorSpeciesLogic();
        $ar = ReferenceAR::model();
        $ar->idreferenceelement = $_POST['idTarget'];
        $pollinatorspeciesList = $logic->getPollinatorSpeciesByReference($ar);
        $rs = array();
        foreach ($pollinatorspeciesList as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idpollinatorspecies;
            $o['name'] = $ar->pollinatorspecies;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }

    public function actionSaveSpeciesNN() {
        $logic = new PollinatorSpeciesLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveSpeciesNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteSpeciesNN($_POST['idItem'], $_POST['idElement']);
    }

    public function actionGetNNBySpecies() {
        $logic = new PollinatorSpeciesLogic();
        $ar = SpeciesAR::model();
        $ar->idspecies = $_POST['idTarget'];
        $pollinatorspeciesList = $logic->getPollinatorSpeciesBySpecies($ar);
        $rs = array();
        foreach ($pollinatorspeciesList as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idpollinatorspecies;
            $o['name'] = $ar->pollinatorspecies;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }
}
