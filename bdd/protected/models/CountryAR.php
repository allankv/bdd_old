<?php
class CountryAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'country';
    }
    public function rules() {
        return array(
                array('country', 'required'),
                array('country', 'unique'),
        );
    }
    public function relations() {
        return array(
            'localityelement' => array(self::HAS_MANY, 'LocalityElementAR', 'idcountry'),
        );
    }
    public function attributeLabels() {
        return array(
                'idcountry'=>'Country ID',
                'country'=>'Country',
        );
    }
}