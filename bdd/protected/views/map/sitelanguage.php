<?php
	$sitelanguage =new MultiLanguage;
	$sitelanguage->setSiteLanguage($_GET['t']);
	Yii::app()->request->redirect('index.php?r=map');
?>