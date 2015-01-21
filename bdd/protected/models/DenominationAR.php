<?php
class DenominationAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'denomination';
    }
    public function rules() {
        return array(
                array('denomination', 'required'),
                array('denomination', 'unique'),
        );
    }
    public function relations() {
        return array(
                'monitoring' => array(self::HAS_MANY, 'MonitoringAR', 'iddenomination'),
        );
    }
    public function attributeLabels() {
        return array(
                'iddenomination' => 'Denomination ID',
                'denomination' => 'Denomination',
        );
    }
}