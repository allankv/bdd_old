<?php
class MultiLanguage {

	//Return Site Language
	public function getSiteLanguage() {
		return Yii::app()->getLanguage();
	}

	//Set session language variable	
	public function setSiteLanguage($language) {
		$language = ($language === null) ? Yii::app()->getLanguage() : $language;
		//if (!Yii::app()->user->isGuest)
                Yii::app()->user->sitelanguage = $language;
		Yii::app()->setLanguage($language);
		return true;
	}	
}
?>