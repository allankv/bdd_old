<?php

class OrderAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'order';
    }
    public function rules() {
        return array(
                array('order', 'required'),
                array('order', 'unique'),
        );
    }
    public function relations() {
        return array(
                'taxonomicelement'=>array(self::HAS_MANY, 'TaxonomicElementAR', 'idorder'),
        );
    }
    public function attributeLabels() {
        return array(
                'idorder'=>'Idorder',
                'order'=>'Order',
        );
    }
    public function behaviors() {
        return array(
                // Classname => path to Class
                'ActiveRecordLogableBehavior'=>'application.behaviors.ActiveRecordLogableBehavior',
        );
    }
}