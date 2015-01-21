<?php

include 'logic/PreparationLogic.php';
include 'SuggestionController.php';

class PreparationController extends SuggestionController {

    public function filters() {
        //Personalize parameters
        $this->logic = new PreparationLogic();

        //Call parent function
        parent::filters();
    }

    public function actionSaveOccurrenceElementNN() {
        $logic = new PreparationLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveOccurrenceElementNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteOccurrenceElementNN($_POST['idItem'], $_POST['idElement']);
        //}
    }

    public function actionGetNNByOccurrenceElement() {
        $logic = new PreparationLogic();
        $ar = OccurrenceElementAR::model();
        $ar->idoccurrenceelement = $_POST['idTarget'];
        $listName = $logic->getPreparationByOccurrenceElement($ar);
        $rs = array();
        foreach ($listName as $n => $ar) {
            $o = array();
            $o['id'] = $ar->idpreparation;
            $o['name'] = $ar->preparation;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }

}
