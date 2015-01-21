<?php

class SearchlocalityController extends CController {
    var $tudo;
    public function actionIndex() {
        //Yii::app()->setLanguage(Yii::app()->user->sitelanguage);

        if($_POST['voltar']) {
            var_dump($_POST);
            //$this->redirect(array('recordlevelelements/create',
              //      'tudo' => $tudo
            //));
        }else {
            $this->tudo = $_POST;
            $this->renderPartial('index', array(
                    'tudo' => $this->tudo
            ));
        }
    }
    public function actionWebservice() {
        Yii::app()->setLanguage(Yii::app()->user->sitelanguage);

        var_dump($_POST);
    }

    /*
	 * Controller method for set language session parameter
    */
    public function actionSiteLanguage() {
        $this->render('sitelanguage');
    }
}