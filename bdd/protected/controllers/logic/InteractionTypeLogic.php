<?php
class InteractionTypeLogic {
    var $mainAtt = 'interactiontype';
    public function search($q) {
        $ar = InteractionTypeAR::model();
        $q = trim(addslashes($q));
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
    public function getInteractionType($ar) {
        if(isset($ar->idinteractiontype)) {
            return InteractionTypeAR::model()->findByPk($ar->idinteractiontype);
        }else {
            $ar->interactiontype = trim(addslashes($ar->interactiontype));
            return InteractionTypeAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->interactiontype."')");
        }
    }
}
?>
