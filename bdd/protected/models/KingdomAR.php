<?php
class KingdomAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'kingdom';
    }
    public function rules() {
        return array(
                array('kingdom', 'required'),
                array('kingdom', 'unique'),
        );
    }
    public function relations() {
        return array(
                'taxonomicelement'=>array(self::HAS_MANY, 'TaxonomicElementAR', 'idkingdom'),
        );
    }
    public function attributeLabels() {
        return array(
                'idkingdom'=>'Idkingdom',
                'kingdom'=>'Kingdom',
        );
    }
    public function behaviors() {
        return array(
                // Classname => path to Class
                'ActiveRecordLogableBehavior'=>
                'application.behaviors.ActiveRecordLogableBehavior',
        );
    }
}