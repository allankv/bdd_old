<?php

class LogoutController extends CController {
	const PAGE_SIZE=10;
    public $defaultAction='logout';
    public function actionLogout() {
    	Yii::app()->request->cookies->clear();
    }
}

?>
