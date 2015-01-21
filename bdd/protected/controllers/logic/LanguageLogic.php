<?php
class LanguageLogic {
    var $mainAtt = 'language';
    public function getLanguage($ar) {
        if(isset($ar->idlanguage)){
            return LanguageAR::model()->findByPk($ar->idlanguage);
        }else{
            $ar->language = trim(addslashes($ar->language));
            return LanguageAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->language."')");
        }    
    }
}
?>
