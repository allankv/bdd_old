<?php
include 'logic/GeoreferenceSourceLogic.php';
include 'SuggestionController.php';
class GeoreferenceSourceController extends SuggestionController
{
    public function filters() {
        //Personalize parameters
        $this->logic = new GeoreferenceSourceLogic();

        //Call parent function
        parent::filters();
    }
    public function actionSaveLocalityElementNN() {
        $logic = new GeoreferenceSourceLogic();
        foreach ($_POST['list'] as $value) {
            if($value['action']=='save')
                $logic->saveLocalityElementNN($value['id'],$_POST['id']);
            else if($value['action']=='delete')
                $logic->deleteLocalityElementNN($value['id'],$_POST['id']);
        }
    }
    public function actionGetNNByLocalityElement() {
        $logic = new GeoreferenceSourceLogic();
        $ar = LocalityElementAR::model();
        $ar->idlocalityelement = $_POST['idTarget'];
        $listName = $logic->getGeoreferenceSourceByLocalityElement($ar);
        $rs = array();
        foreach ($listName as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idgeoreferencesource;
            $o['name'] = $ar->georeferencesource;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }
    public function actionSaveGeospatialElementNN() {
        $logic = new GeoreferenceSourceLogic();
        foreach ($_POST['list'] as $value) {
            if($value['action']=='save')
                $logic->saveGeospatialElementNN($value['id'],$_POST['id']);
            else if($value['action']=='delete')
                $logic->deleteGeospatialElementNN($value['id'],$_POST['id']);
        }
    }
    public function actionGetNNByGeospatialElement() {
        $logic = new GeoreferenceSourceLogic();
        $ar = GeospatialElementAR::model();
        $ar->idgeospatialelement = $_POST['idTarget'];
        $listName = $logic->getGeoreferenceSourceByGeospatialElement($ar);
        $rs = array();
        foreach ($listName as $n=>$ar) {
            $o = array();
            $o['id'] = $ar->idgeoreferencesource;
            $o['name'] = $ar->georeferencesource;
            $rs[] = $o;
        }
        echo CJSON::encode($rs);
    }
}
