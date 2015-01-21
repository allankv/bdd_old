<?php
include 'logic/RecordedByLogic.php';
include 'SuggestionController.php';
class RecordedbyController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new RecordedByLogic();

        //Call parent function
        parent::filters();
    }

    public function actionSaveOccurrenceElementNN() {
        $logic = new RecordedByLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveOccurrenceElementNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteOccurrenceElementNN($_POST['idItem'], $_POST['idElement']);
        //}
    }
    public function actionGetNNByOccurrenceElement() {
        $logic = new RecordedByLogic();
        $ar = OccurrenceElementAR::model();
        $ar->idoccurrenceelement = $_POST['idTarget'];
        $listName = $logic->getRecordedByByOccurrenceElement($ar);
        $rs = array();
        foreach ($listName as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idrecordedby;
            $o['name'] = $ar->recordedby;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }
}
