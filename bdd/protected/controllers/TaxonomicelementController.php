<?php
include 'logic/TaxonomicElementLogic.php';
class TaxonomicelementController extends CController {
    const PAGE_SIZE=10;

    public function actionAutoSuggestionHierarchy() {
        $logic = new TaxonomicElementLogic();
        $ar = TaxonomicElementAR::model();
        $ar = $logic->setAttributes($_POST['TaxonomicElementAR']);
        //print_r($_POST['TaxonomicElementAR']);die();
        $arList = $logic->autoSuggestionHierarchy($ar);
        echo CJSON::encode($arList);
    }
    public function actionNSuggestionHierarchy() {        
        $this->renderPartial('autosuggestionhierarchy',array(
                'list'=>$_POST['list'],                
        ));
    }
    public function filters() {
        return array(
                'accessControl', // perform access control for CRUD operations
        );
    }
    public function accessRules() {
        return array(
                array('allow',
                        'actions'=>array('*'),
                        'users'=>array('@'),
                )
        );
    }
}
