<?php

class TapirController extends CController
{
      	public $defaultAction='tapir';

	public function actionTapir()
	{
                Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
		$this->render('tapir', array());
	}
        
        /*
	 * Controller method for set language session parameter
	 */
	public function actionSiteLanguage() {
		$this->render('sitelanguage');
	}
}