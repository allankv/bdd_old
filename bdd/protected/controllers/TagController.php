<?php
include 'logic/TagLogic.php';
include 'SuggestionController.php';
class TagController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new TagLogic();

        //Call parent function
        parent::filters();
    }
    public function actionSaveMediaNN() {
        $logic = new TagLogic();
        //foreach ($_POST['list'] as $value) {
        if ($_POST['action'] == 'save')
            $logic->saveMediaNN($_POST['idItem'], $_POST['idElement']);
        else if ($_POST['action'] == 'delete')
            $logic->deleteMediaNN($_POST['idItem'], $_POST['idElement']);
    }
    public function actionGetNNByMedia() {
        $logic = new TagLogic();
        $ar = MediaAR::model();
        $ar->idmedia = $_POST['idTarget'];
        $tagList = $logic->getTagByMedia($ar);
        $rs = array();
        foreach ($tagList as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idtag;
            $o['name'] = $ar->tag;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }
}
