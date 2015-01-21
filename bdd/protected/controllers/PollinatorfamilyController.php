<?php
include 'logic/PollinatorFamilyLogic.php';
include 'SuggestionController.php';
class PollinatorfamilyController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new PollinatorFamilyLogic();

        //Call parent function
        parent::filters();
    }

    public function actionSaveMediaNN() {
        $logic = new PollinatorFamilyLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveMediaNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteMediaNN($_POST['idElement'], $_POST['idElement']);
    }
    public function actionGetNNByMedia() {
        $logic = new PollinatorFamilyLogic();
        $ar = MediaAR::model();
        $ar->idmedia = $_POST['idTarget'];
        $pollinatorfamilyList = $logic->getPollinatorFamilyByMedia($ar);
        $rs = array();
        foreach ($pollinatorfamilyList as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idpollinatorfamily;
            $o['name'] = $ar->pollinatorfamily;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }

    public function actionSaveReferenceNN() {
        $logic = new PollinatorFamilyLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveReferenceNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteReferenceNN($_POST['idItem'], $_POST['idElement']);
    }
    public function actionGetNNByReference() {
        $logic = new PollinatorFamilyLogic();
        $ar = ReferenceAR::model();
        $ar->idreferenceelement = $_POST['idTarget'];
        $pollinatorfamilyList = $logic->getPollinatorFamilyByReference($ar);
        $rs = array();
        foreach ($pollinatorfamilyList as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idpollinatorfamily;
            $o['name'] = $ar->pollinatorfamily;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }

    public function actionSaveSpeciesNN() {
        $logic = new PollinatorFamilyLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveSpeciesNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteSpeciesNN($_POST['idItem'], $_POST['idElement']);
    }

    public function actionGetNNBySpecies() {
        $logic = new PollinatorFamilyLogic();
        $ar = SpeciesAR::model();
        $ar->idspecies = $_POST['idTarget'];
        $pollinatorfamilyList = $logic->getPollinatorFamilyBySpecies($ar);
        $rs = array();
        foreach ($pollinatorfamilyList as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idpollinatorfamily;
            $o['name'] = $ar->pollinatorfamily;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }
}
