<?php
include 'logic/GeoreferencedByLogic.php';
include 'SuggestionController.php';
class GeoreferencedbyController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new GeoreferencedByLogic();

        //Call parent function
        parent::filters();
    }
    public function actionSaveLocalityElementNN() {
        $logic = new GeoreferencedByLogic();
        print_r($_POST);
        if ($_POST['action'] == 'save')
            $logic->saveLocalityElementNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteLocalityElementNN($_POST['idItem'], $_POST['idElement']);
    }
    public function actionGetNNByLocalityElement() {
        $logic = new GeoreferencedByLogic();
        $ar = LocalityElementAR::model();
        $ar->idlocalityelement = $_POST['idTarget'];
        $listName = $logic->getGeoreferencedByByLocalityElement($ar);
        $rs = array();
        foreach ($listName as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idgeoreferencedby;
            $o['name'] = $ar->georeferencedby;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }
}
