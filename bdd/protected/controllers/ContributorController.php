<?php
include 'logic/ContributorLogic.php';
include 'SuggestionController.php';
class ContributorController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new ContributorLogic();

        //Call parent function
        parent::filters();
    }
    public function actionSaveSpeciesNN() {
        $logic = new ContributorLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveSpeciesNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteSpeciesNN($_POST['idItem'], $_POST['idElement']);
    }
    
    public function actionGetNNBySpecies() {
        $logic = new ContributorLogic();
        $ar = SpeciesAR::model();
        $ar->idspecies = $_POST['idTarget'];
        $contributorList = $logic->getContributorBySpecies($ar);
        $rs = array();
        foreach ($contributorList as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idcontributor;
            $o['name'] = $ar->contributor;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }
}
