<?php
include 'logic/SynonymLogic.php';
include 'SuggestionController.php';
class SynonymController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new SynonymLogic();

        //Call parent function
        parent::filters();
    }
    public function actionSaveSpeciesNN() {
        $logic = new SynonymLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveSpeciesNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteSpeciesNN($_POST['idItem'], $_POST['idElement']);
    }
    public function actionGetNNBySpecies() {
        $logic = new SynonymLogic();
        $ar = SpeciesAR::model();
        $ar->idspecies = $_POST['idTarget'];
        $synonymList = $logic->getSynonymBySpecies($ar);
        $rs = array();
        foreach ($synonymList as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idsynonym;
            $o['name'] = $ar->synonym;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }
}
