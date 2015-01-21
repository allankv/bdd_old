<?php
class DigitizerAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'digitizer';
    }
    public function rules() {
        return array(
                array('digitizer', 'required'),
                array('digitizer', 'unique'),
        );
    }
    public function relations() {
        return array(
                'monitoring' => array(self::HAS_MANY, 'MonitoringAR', 'iddigitizer'),
        );
    }
    public function attributeLabels() {
        return array(
                'iddigitizer' => 'Digitizer ID',
                'digitizer' => 'Digitizer',
        );
    }
}