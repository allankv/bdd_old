<?php
class SurroundingsCultureAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'surroundingsculture';
    }
    public function rules() {
        return array(
                array('surroundingsculture', 'required'),
                array('surroundingsculture', 'unique'),
        );
    }
    public function relations() {
        return array(
                'monitoring' => array(self::HAS_MANY, 'MonitoringAR', 'idsurroundingsculture'),
        );
    }
    public function attributeLabels() {
        return array(
                'idsurroundingsculture' => 'Surroundings culture ID',
                'surroundingsculture' => 'Surroundings culture',
        );
    }
}