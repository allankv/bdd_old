<?php
class BasisOfRecordLogic {
    var $mainAtt = 'basisofrecord';
    public function getBasisOfRecord($ar) {
        if(isset($ar->idbasisofrecord)) {
            return BasisOfRecordAR::model()->findByPk($ar->idbasisofrecord);
        }else {
            $ar->basisofrecord = trim($ar->basisofrecord);
            return BasisOfRecordAR::model()->find("UPPER($this->mainAtt)=UPPER('".$ar->basisofrecord."')");
        }
    }
    public function search($q) {
        $ar = BasisOfRecordAR::model();
        $q = trim($q);
        $criteria = new CDbCriteria();
        $criteria->condition = "$this->mainAtt ilike '%$q%' OR difference($this->mainAtt, '$q') > 3";
        $criteria->limit = 20;
        $criteria->order = "$this->mainAtt";
        $rs = $ar->findAll($criteria);
        return $rs;
    }
}
?>
