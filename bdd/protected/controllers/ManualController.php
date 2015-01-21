<?php

class ManualController extends CController {
    const PAGE_SIZE=10;

    /**
     * @var string specifies the default action to be 'list'.
     */
    public $defaultAction='index';    

    /**
     * @return array action filters
     */
    public function filters() {
        //return array(
        //        'accessControl', // perform access control for CRUD operations
        //);
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
                array('allow',
                        'actions'=>array('*'),
                        'users'=>array('*'),
                )
        );
    }

    /**
     * Shows a particular model.
     */
    public function actionIndex() {
        //Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
        $this->redirect('http://bdd.pcs.usp.br/manual.zip');
        $this->render('about');

    }   

}

?>
