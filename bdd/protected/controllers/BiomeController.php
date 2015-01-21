<?php
include 'logic/BiomeLogic.php';
include 'SuggestionController.php';
class BiomeController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new BiomeLogic();

        //Call parent function
        parent::filters();
    }

    public function actionSaveMediaNN() {
        $logic = new BiomeLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveMediaNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteMediaNN($_POST['idElement'], $_POST['idElement']);
    }
    public function actionGetNNByMedia() {
        $logic = new BiomeLogic();
        $ar = MediaAR::model();
        $ar->idmedia = $_POST['idTarget'];
        $biomeList = $logic->getBiomeByMedia($ar);
        $rs = array();
        foreach ($biomeList as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idbiome;
            $o['name'] = $ar->biome;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }

    public function actionSaveReferenceNN() {
        $logic = new BiomeLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveReferenceNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteReferenceNN($_POST['idItem'], $_POST['idElement']);
    }
    public function actionGetNNByReference() {
        $logic = new BiomeLogic();
        $ar = ReferenceAR::model();
        $ar->idreferenceelement = $_POST['idTarget'];
        $biomeList = $logic->getBiomeByReference($ar);
        $rs = array();
        foreach ($biomeList as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idbiome;
            $o['name'] = $ar->biome;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }

    public function actionSaveSpeciesNN() {
        $logic = new BiomeLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveSpeciesNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteSpeciesNN($_POST['idItem'], $_POST['idElement']);
    }

    public function actionGetNNBySpecies() {
        $logic = new BiomeLogic();
        $ar = SpeciesAR::model();
        $ar->idspecies = $_POST['idTarget'];
        $biomeList = $logic->getBiomeBySpecies($ar);
        $rs = array();
        foreach ($biomeList as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idbiome;
            $o['name'] = $ar->biome;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }
}
