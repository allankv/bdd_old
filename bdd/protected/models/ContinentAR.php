<?php
class ContinentAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'continent';
    }
    public function rules() {
        return array(
                array('continent', 'required'),
                array('continent', 'exist'),
        );
    }
    public function relations() {
        return array(
                'localityelement' => array(self::HAS_MANY, 'LocalityElementAR', 'idcontinent'),
        );
    }
    public function attributeLabels() {
        return array(
                'idcontinent'=>'Continent ID',
                'continent'=>'Continent',
        );
    }
}