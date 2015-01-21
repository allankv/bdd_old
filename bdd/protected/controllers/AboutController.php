<?php

class AboutController extends CController
{
	public function actionIndex()
	{
		//Yii::app()->setLanguage(Yii::app()->user->sitelanguage);	
		$this->render('index');
	}
        
        /*
	 * Controller method for set language session parameter
	 */
/*
	public function actionSiteLanguage() {
      		$this->render('sitelanguage');
	}
*/
}