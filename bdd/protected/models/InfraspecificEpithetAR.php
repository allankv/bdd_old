<?php

class InfraspecificEpithetAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'infraspecificepithet';
    }
    public function rules() {
        return array(
                array('infraspecificepithet', 'required'),
                array('infraspecificepithet', 'unique'),
        );
    }
    public function relations() {
        return array(
                'taxonomicelement'=>array(self::HAS_MANY, 'TaxonomicElementAR', 'idinfraspecificepithet'),
        );
    }
    public function attributeLabels() {
        return array(
                'idinfraspecificepithet'=>'Idinfraspecificepithet',
                'infraspecificepithet'=>'Infraspecific epithet',
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