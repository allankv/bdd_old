<?php

class UserMenuPublic extends CWidget
{
//	public function init()
//	{
//		if(isset($_POST['command']) && $_POST['command']==='logout')
//		{
//			Yii::app()->user->logout();
//			$this->controller->redirect(Yii::app()->homeUrl);
//		}
//		$this->title=CHtml::encode(Yii::app()->user->name);
//	}
//
//	protected function renderContent()
//	{
//		$this->render('userMenu');
//	}

        public function run() {
            $this->render('userMenuPublic');
        }
}
?>