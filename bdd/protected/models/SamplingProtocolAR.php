<?php
class SamplingProtocolAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'samplingprotocol';
    }
    public function rules() {
        return array(
                array('samplingprotocol','length','max'=>60),
                array('samplingprotocol', 'required'),
                array('samplingprotocol', 'unique'),
        );
    }
    public function relations() {
        return array(
                'eventelement' => array(self::HAS_MANY, 'EventElementAR', 'idsamplingprotocol'),
        );
    }
    public function attributeLabels() {
        return array(
                'idsamplingprotocol' => 'Sampling protocol ID',
                'samplingprotocol' => 'Sampling protocol',
        );
    }
}