<?php
include 'logic/DynamicPropertyLogic.php';
include 'SuggestionController.php';
class DynamicpropertyController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new DynamicPropertyLogic();

        //Call parent function
        parent::filters();
    }
    public function actionSaveRecordLevelElementNN() {
        $logic = new DynamicPropertyLogic();
        print_r($_POST);
        if ($_POST['action'] == 'save')
            $logic->saveRecordLevelElementNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteRecordLevelElementNN($_POST['idItem'], $_POST['idElement']);
    }

    public function actionGetNNByRecordLevelElement() {
        $logic = new DynamicPropertyLogic();
        $ar = RecordLevelElementAR::model();
        $ar->idrecordlevelelement = $_POST['idTarget'];
        $listName = $logic->getDynamicPropertyByRecordLevelElement($ar);
        $rs = array();
        foreach ($listName as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->iddynamicproperty;
            $o['name'] = $ar->dynamicproperty;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }
}
