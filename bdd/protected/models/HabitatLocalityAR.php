<?php
class HabitatLocalityAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'habitat';
    }
    public function rules() {
        return array(
                array('habitat','length','max'=>60),
                array('habitat', 'required'),
                array('habitat', 'unique'),
        );
    }
    public function relations() {
        return array(
                'localityelement' => array(self::HAS_MANY, 'LocalityElementAR', 'idhabitat'),
        );
    }
    public function attributeLabels() {
        return array(
                'idhabitat' => 'Habitat ID',
                'habitat' => 'Habitat',
        );
    }
}