<?php
class SupportTypeAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'supporttype';
    }
    public function rules() {
        return array(
                array('supporttype', 'required'),
                array('supporttype', 'unique'),
        );
    }
    public function relations() {
        return array(
                'monitoring' => array(self::HAS_MANY, 'MonitoringAR', 'idsupporttype'),
        );
    }
    public function attributeLabels() {
        return array(
                'idsupporttype' => 'Support type ID',
                'supporttype' => 'Support type',
        );
    }
}