<?php
class ReferenceCreatorsViewAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'reference_creators_view';
    }
   
}