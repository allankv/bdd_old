<?php
include 'logic/RelatedNameLogic.php';
include 'SuggestionController.php';
class RelatednameController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new RelatedNameLogic();

        //Call parent function
        parent::filters();
    }
    public function actionSaveSpeciesNN() {
        $logic = new RelatedNameLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveSpeciesNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteSpeciesNN($_POST['idItem'], $_POST['idElement']);
    }
    public function actionGetNNBySpecies() {
        $logic = new RelatedNameLogic();
        $ar = SpeciesAR::model();
        $ar->idspecies = $_POST['idTarget'];
        $relatedNameList = $logic->getRelatedNameBySpecies($ar);
        $rs = array();
        foreach ($relatedNameList as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idrelatedname;
            $o['name'] = $ar->relatedname;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }
}
