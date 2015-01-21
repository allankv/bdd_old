<?php
class SurroundingsVegetationAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'surroundingsvegetation';
    }
    public function rules() {
        return array(
                array('surroundingsvegetation', 'required'),
                array('surroundingsvegetation', 'unique'),
        );
    }
    public function relations() {
        return array(
                'monitoring' => array(self::HAS_MANY, 'MonitoringAR', 'idsurroundingsvegetation'),
        );
    }
    public function attributeLabels() {
        return array(
                'idsurroundingsvegetation' => 'Surroundings vegetation ID',
                'surroundingsvegetation' => 'Surroundings vegetation',
        );
    }
}