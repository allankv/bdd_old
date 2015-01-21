<?php

include 'logic/AssociatedSequenceLogic.php';
include 'SuggestionController.php';

class AssociatedsequenceController extends SuggestionController {

    public function filters() {
        //Personalize parameters
        $this->logic = new AssociatedSequenceLogic();

        //Call parent function
        parent::filters();
    }

    public function actionSaveOccurrenceElementNN() {
        $logic = new AssociatedSequenceLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveOccurrenceElementNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteOccurrenceElementNN($_POST['idItem'], $_POST['idElement']);
        //}
    }

    public function actionGetNNByOccurrenceElement() {
        $logic = new AssociatedSequenceLogic();
        $ar = OccurrenceElementAR::model();
        $ar->idoccurrenceelement = $_POST['idTarget'];
        $listName = $logic->getAssociatedSequenceByOccurrenceElement($ar);
        $rs = array();
        foreach ($listName as $n => $ar) {
            $o = array();
            $o['id'] = $ar->idassociatedsequence;
            $o['name'] = $ar->associatedsequence;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }

}
