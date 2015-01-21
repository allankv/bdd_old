<?php
include 'logic/KeywordLogic.php';
include 'SuggestionController.php';
class KeywordController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new KeywordLogic();

        //Call parent function
        parent::filters();
    }

    public function actionSaveMediaNN() {
        $logic = new KeywordLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveMediaNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteMediaNN($_POST['idElement'], $_POST['idElement']);
    }
    public function actionGetNNByMedia() {
        $logic = new KeywordLogic();
        $ar = MediaAR::model();
        $ar->idmedia = $_POST['idTarget'];
        $keywordList = $logic->getKeywordByMedia($ar);
        $rs = array();
        foreach ($keywordList as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idkeyword;
            $o['name'] = $ar->keyword;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }

    public function actionSaveReferenceNN() {
        $logic = new KeywordLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveReferenceNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteReferenceNN($_POST['idItem'], $_POST['idElement']);
    }
    public function actionGetNNByReference() {
        $logic = new KeywordLogic();
        $ar = ReferenceAR::model();
        $ar->idreferenceelement = $_POST['idTarget'];
        $keywordList = $logic->getKeywordByReference($ar);
        $rs = array();
        foreach ($keywordList as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idkeyword;
            $o['name'] = $ar->keyword;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }

    public function actionSaveSpeciesNN() {
        $logic = new KeywordLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveSpeciesNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteSpeciesNN($_POST['idItem'], $_POST['idElement']);
    }

    public function actionGetNNBySpecies() {
        $logic = new KeywordLogic();
        $ar = SpeciesAR::model();
        $ar->idspecies = $_POST['idTarget'];
        $keywordList = $logic->getKeywordBySpecies($ar);
        $rs = array();
        foreach ($keywordList as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idkeyword;
            $o['name'] = $ar->keyword;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }
}
