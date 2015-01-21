<?php

class LocalityAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'locality';
    }
    public function rules() {
        return array(
                array('locality', 'required'),
                array('locality', 'unique'),
        );
    }
    public function relations() {
        return array(
                'localityelement' => array(self::HAS_MANY, 'LocalityElementAR', 'idlocality'),
        );
    }
    public function attributeLabels() {
        return array(
                'idlocality'=>'Idlocality',
                'locality'=>'Locality',
        );
    }
}