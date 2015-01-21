<?php
class ScientificNameAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'scientificname';
    }
    public function rules() {
        return array(
                array('scientificname', 'required'),
                array('scientificname', 'unique'),
        );
    }
    public function relations() {
        return array(
                'taxonomicelement'=>array(self::HAS_MANY, 'TaxonomicElementAR', 'idscientificname'),
        );
    }
    public function attributeLabels() {
        return array(
                'idscientificname'=>'Scientific name ID',
                'scientificname'=>'Scientific name',
        );
    }
    // Metodo que registra log no banco
    public function behaviors() {
        return array(
                'ActiveRecordLogableBehavior'=>'application.behaviors.ActiveRecordLogableBehavior',
        );
    }
}