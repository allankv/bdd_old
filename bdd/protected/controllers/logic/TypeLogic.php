<?php
class TypeLogic {
    var $mainAtt = 'type';
    public function getType($ar) {
        if(isset($ar->idtype)){
            return TypeAR::model()->findByPk($ar->idtype);
        }else{
            $ar->type = trim($ar->type);
            return TypeAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->type."')");
        }    
    }
}
?>
