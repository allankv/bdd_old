<?php
class CountyAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'county';
    }
    public function rules() {
        return array(
                array('county', 'required'),
                array('county', 'unique'),
        );
    }
    public function relations() {
        return array(
            'localityelement' => array(self::HAS_MANY, 'LocalityElementAR', 'idcounty'),
        );
    }
    public function attributeLabels() {
        return array(
                'idcounty'=>'Idcounty',
                'county'=>'County',
        );
    }
}