<?php
class WaterBodyAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'waterbody';
    }
    public function rules() {
        return array(
                array('waterbody', 'required'),
                array('waterbody', 'unique'),
        );
    }
    public function relations() {
        return array(
                'localityelement' => array(self::HAS_MANY, 'LocalityElementAR', 'idwaterbody'),
        );
    }
    public function attributeLabels() {
        return array(
                'idwaterbody'=>'waterbody ID',
                'waterbody'=>'Water body',
        );
    }
}