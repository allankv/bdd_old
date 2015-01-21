<?php

class ScientificNameAuthorshipAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'scientificnameauthorship';
    }
    public function rules() {
        return array(
                array('scientificnameauthorship', 'required'),
                array('scientificnameauthorship', 'unique'),
        );
    }
    public function relations() {
        return array(
                'taxonomicelement' => array(self::HAS_MANY, 'TaxonomicElementAR', 'idscientificnameauthorship'),
        );
    }
    public function attributeLabels() {
        return array(
                'idscientificnameauthorship'=>'Idscientificnameauthorship',
                'scientificnameauthorship'=>'Scientific name authorship',
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