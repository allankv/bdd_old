<?php

include 'logic/TypeStatusLogic.php';
include 'SuggestionController.php';

class TypestatusController extends SuggestionController {

    public function filters() {
        //Personalize parameters
        $this->logic = new TypeStatusLogic();

        //Call parent function
        parent::filters();
    }

    public function actionSaveIdentificationElementNN() {
        $logic = new TypeStatusLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveIdentificationElementNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteIdentificationElementNN($_POST['idItem'], $_POST['idElement']);
        //}
    }

    public function actionGetNNByIdentificationElement() {
        $logic = new TypeStatusLogic();
        $ar = IdentificationElementAR::model();
        $ar->ididentificationelement = $_POST['idTarget'];
        $listName = $logic->getTypeStatusByIdentificationElement($ar);
        $rs = array();
        foreach ($listName as $n => $ar) {
            $o = array();
            $o['id'] = $ar->idtypestatus;
            $o['name'] = $ar->typestatus;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }

}
