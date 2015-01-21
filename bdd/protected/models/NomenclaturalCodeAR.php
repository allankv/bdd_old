<?php

class NomenclaturalCodeAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'nomenclaturalcode';
    }
    public function rules() {
        return array(
                array('nomenclaturalcode', 'required'),
                array('nomenclaturalcode', 'unique'),
        );
    }
    public function relations() {
        return array(
                'taxonomicelement'=>array(self::HAS_MANY, 'TaxonomicElementAR', 'idnomenclaturalcode'),
        );
    }
    public function attributeLabels() {
        return array(
                'idnomenclaturalcode'=>'Idnomenclaturalcode',
                'nomenclaturalcode'=>'Nomenclatural code',
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