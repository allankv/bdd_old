<?php
include 'logic/AfiliationLogic.php';
include 'SuggestionController.php';
class AfiliationController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new AfiliationLogic();

        //Call parent function
        parent::filters();
    }

    public function actionSaveMediaNN() {
        $logic = new AfiliationLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveMediaNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteMediaNN($_POST['idElement'], $_POST['idElement']);
    }
    public function actionGetNNByMedia() {
        $logic = new AfiliationLogic();
        $ar = MediaAR::model();
        $ar->idmedia = $_POST['idTarget'];
        $afiliationList = $logic->getAfiliationByMedia($ar);
        $rs = array();
        foreach ($afiliationList as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idafiliation;
            $o['name'] = $ar->afiliation;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }

    public function actionSaveReferenceNN() {
        $logic = new AfiliationLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveReferenceNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteReferenceNN($_POST['idItem'], $_POST['idElement']);
    }
    public function actionGetNNByReference() {
        $logic = new AfiliationLogic();
        $ar = ReferenceAR::model();
        $ar->idreferenceelement = $_POST['idTarget'];
        $afiliationList = $logic->getAfiliationByReference($ar);
        $rs = array();
        foreach ($afiliationList as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idafiliation;
            $o['name'] = $ar->afiliation;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }

    public function actionSaveSpeciesNN() {
        $logic = new AfiliationLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveSpeciesNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteSpeciesNN($_POST['idItem'], $_POST['idElement']);
    }

    public function actionGetNNBySpecies() {
        $logic = new AfiliationLogic();
        $ar = SpeciesAR::model();
        $ar->idspecies = $_POST['idTarget'];
        $afiliationList = $logic->getAfiliationBySpecies($ar);
        $rs = array();
        foreach ($afiliationList as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idafiliation;
            $o['name'] = $ar->afiliation;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }
}
