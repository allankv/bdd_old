<?php
include 'logic/PollinatorCommonNameLogic.php';
include 'SuggestionController.php';
class PollinatorcommonnameController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new PollinatorCommonNameLogic();

        //Call parent function
        parent::filters();
    }

    public function actionSaveMediaNN() {
        $logic = new PollinatorCommonNameLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveMediaNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteMediaNN($_POST['idElement'], $_POST['idElement']);
    }
    public function actionGetNNByMedia() {
        $logic = new PollinatorCommonNameLogic();
        $ar = MediaAR::model();
        $ar->idmedia = $_POST['idTarget'];
        $pollinatorcommonnameList = $logic->getPollinatorCommonNameByMedia($ar);
        $rs = array();
        foreach ($pollinatorcommonnameList as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idpollinatorcommonname;
            $o['name'] = $ar->pollinatorcommonname;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }

    public function actionSaveReferenceNN() {
        $logic = new PollinatorCommonNameLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveReferenceNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteReferenceNN($_POST['idItem'], $_POST['idElement']);
    }
    public function actionGetNNByReference() {
        $logic = new PollinatorCommonNameLogic();
        $ar = ReferenceAR::model();
        $ar->idreferenceelement = $_POST['idTarget'];
        $pollinatorcommonnameList = $logic->getPollinatorCommonNameByReference($ar);
        $rs = array();
        foreach ($pollinatorcommonnameList as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idpollinatorcommonname;
            $o['name'] = $ar->pollinatorcommonname;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }

    public function actionSaveSpeciesNN() {
        $logic = new PollinatorCommonNameLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveSpeciesNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteSpeciesNN($_POST['idItem'], $_POST['idElement']);
    }

    public function actionGetNNBySpecies() {
        $logic = new PollinatorCommonNameLogic();
        $ar = SpeciesAR::model();
        $ar->idspecies = $_POST['idTarget'];
        $pollinatorcommonnameList = $logic->getPollinatorCommonNameBySpecies($ar);
        $rs = array();
        foreach ($pollinatorcommonnameList as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idpollinatorcommonname;
            $o['name'] = $ar->pollinatorcommonname;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }
}
