<?php
include 'logic/CreatorLogic.php';
include 'SuggestionController.php';
class CreatorController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new CreatorLogic();

        //Call parent function
        parent::filters();
    }

    public function actionSaveMediaNN() {
        $logic = new CreatorLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveMediaNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteMediaNN($_POST['idElement'], $_POST['idElement']);
    }
    public function actionGetNNByMedia() {
        $logic = new CreatorLogic();
        $ar = MediaAR::model();
        $ar->idmedia = $_POST['idTarget'];
        $creatorList = $logic->getCreatorByMedia($ar);
        $rs = array();
        foreach ($creatorList as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idcreator;
            $o['name'] = $ar->creator;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }

    public function actionSaveReferenceNN() {
        $logic = new CreatorLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveReferenceNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteReferenceNN($_POST['idItem'], $_POST['idElement']);
    }
    public function actionGetNNByReference() {
        $logic = new CreatorLogic();
        $ar = ReferenceAR::model();
        $ar->idreferenceelement = $_POST['idTarget'];
        $creatorList = $logic->getCreatorByReference($ar);
        $rs = array();
        foreach ($creatorList as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idcreator;
            $o['name'] = $ar->creator;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }

    public function actionSaveSpeciesNN() {
        $logic = new CreatorLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveSpeciesNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteSpeciesNN($_POST['idItem'], $_POST['idElement']);
    }

    public function actionGetNNBySpecies() {
        $logic = new CreatorLogic();
        $ar = SpeciesAR::model();
        $ar->idspecies = $_POST['idTarget'];
        $creatorList = $logic->getCreatorBySpecies($ar);
        $rs = array();
        foreach ($creatorList as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idcreator;
            $o['name'] = $ar->creator;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }
}
