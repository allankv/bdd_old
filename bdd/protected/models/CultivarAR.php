<?php
class CultivarAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'cultivar';
    }
    public function rules() {
        return array(
                array('cultivar', 'required'),
                array('cultivar', 'unique'),
        );
    }
    public function relations() {
        return array(
                'monitoring' => array(self::HAS_MANY, 'MonitoringAR', 'idcultivar'),
        );
    }
    public function attributeLabels() {
        return array(
                'idcultivar' => 'Cultivar ID',
                'cultivar' => 'Cultivar',
        );
    }
}