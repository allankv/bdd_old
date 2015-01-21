<?php
class TaxonomicStatusLogic {
    var $mainAtt = 'taxonomicstatus';
    public function getTaxonomicStatus($ar) {
        if(isset($ar->idtaxonomicstatus)){
            return TaxonomicStatusAR::model()->findByPk($ar->idtaxonomicstatus);
        }else{
            $ar->taxonomicstatus = trim($ar->taxonomicstatus);
            return TaxonomicStatusAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->taxonomicstatus."')");
        }    
    }
}
?>
