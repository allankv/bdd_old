<?php

include 'logic/IndividualLogic.php';
include 'SuggestionController.php';

class IndividualController extends SuggestionController {

    public function filters() {
        //Personalize parameters
        $this->logic = new IndividualLogic();

        //Call parent function
        parent::filters();
    }

    public function actionSaveOccurrenceElementNN() {
        $logic = new IndividualLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveOccurrenceElementNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteOccurrenceElementNN($_POST['idItem'], $_POST['idElement']);
        //}
    }

    public function actionGetNNByOccurrenceElement() {
        $logic = new IndividualLogic();
        $ar = OccurrenceElementAR::model();
        $ar->idoccurrenceelement = $_POST['idTarget'];
        $listName = $logic->getIndividualByOccurrenceElement($ar);
        $rs = array();
        foreach ($listName as $n => $ar) {
            $o = array();
            $o['id'] = $ar->idindividual;
            $o['name'] = $ar->individual;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }

}
