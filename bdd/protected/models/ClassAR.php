<?php
class ClassAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'class';
    }
    public function rules() {
        return array(
                array('class', 'required'),
                array('class', 'unique'),

        );
    }
    public function relations() {
        return array(
                'taxonomicelement'=>array(self::HAS_MANY, 'TaxonomicElementAR', 'idclass'),
        );
    }
    public function attributeLabels() {
        return array(
                'idclass'=>'Class ID',
                'class'=>'Class',
        );
    }
    /*
	 * Metodo que registra log no banco
    */
    public function behaviors() {
        return array(
                // Classname => path to Class
                'ActiveRecordLogableBehavior'=>
                'application.behaviors.ActiveRecordLogableBehavior',
        );
    }
}