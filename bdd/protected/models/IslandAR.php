<?php
class IslandAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'island';
    }
    public function rules() {
        return array(
                array('island', 'required'),
                array('island', 'unique'),
        );
    }
    public function relations() {
        return array(
                'localityelement' => array(self::HAS_MANY, 'LocalityElementAR', 'idisland'),
        );
    }
    public function attributeLabels() {
        return array(
                'idisland'=>'island ID',
                'island'=>'Island',
        );
    }
}