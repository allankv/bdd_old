<?php
class IslandGroupAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'islandgroup';
    }
    public function rules() {
        return array(
                array('islandgroup', 'required'),
                array('islandgroup', 'unique'),
        );
    }
    public function relations() {
        return array(
                'localityelement' => array(self::HAS_MANY, 'LocalityElementAR', 'idislandgroup'),
        );
    }
    public function attributeLabels() {
        return array(
                'idislandgroup'=>'islandgroup ID',
                'islandgroup'=>'Island group',
        );
    }
}