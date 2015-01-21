<?php

class PhylumAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'phylum';
    }
    public function rules() {
        return array(
                array('phylum', 'required'),
                array('phylum', 'unique'),
        );
    }
    public function relations() {
        return array(
                'taxonomicelement'=>array(self::HAS_MANY, 'TaxonomicElementAR', 'idphylum'),
        );
    }
    public function attributeLabels() {
        return array(
                'idphylum'=>'Idphylum',
                'phylum'=>'Phylum',
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