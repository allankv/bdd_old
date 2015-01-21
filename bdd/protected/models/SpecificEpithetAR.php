<?php

class SpecificEpithetAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'specificepithet';
    }
    public function rules() {
        return array(
                array('specificepithet', 'required'),
                array('specificepithet', 'unique'),
        );
    }
    public function relations() {
        return array(
                'taxonomicelement'=>array(self::HAS_MANY, 'TaxonomicElementAR', 'idspecificepithet'),
        );
    }
    public function attributeLabels() {
        return array(
                'specificepithet' => 'Specific epithet',
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