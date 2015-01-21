<?php
	class CollectorAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'collector';
    }
    public function rules() {
        return array(
                array('collector', 'required'),
                array('collector', 'unique'),
        );
    }
    public function relations() {
        return array(
                'monitoring' => array(self::HAS_MANY, 'MonitoringAR', 'idcollector'),
        );
    }
    public function attributeLabels() {
        return array(
                'idcollector' => 'Collector ID',
                'collector' => 'Collector',
        );
    }
}