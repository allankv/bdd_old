<?php

include 'logic/IdentifiedByLogic.php';
include 'SuggestionController.php';

class IdentifiedbyController extends SuggestionController {

    public function filters() {
        //Personalize parameters
        $this->logic = new IdentifiedByLogic();

        //Call parent function
        parent::filters();
    }

    public function actionSaveIdentificationElementNN() {
        $logic = new IdentifiedByLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save'){
             
        $logic->saveIdentificationElementNN($_POST['idItem'], $_POST['idElement']);
        }
        else if ($_POST['action'] == 'delete'){
            $logic->deleteIdentificationElementNN($_POST['idItem'], $_POST['idElement']);
        }
        //}
    }

    public function actionGetNNByIdentificationElement() {
        $logic = new IdentifiedByLogic();
        $ar = IdentificationElementAR::model();
        $ar->ididentificationelement = $_POST['idTarget'];
        $listName = $logic->getIdentifiedByByIdentificationElement($ar);
        $rs = array();
        foreach ($listName as $n => $ar) {
            $o = array();
            $o['id'] = $ar->ididentifiedby;
            $o['name'] = $ar->identifiedby;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }

}
