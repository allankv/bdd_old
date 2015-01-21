<?php
class CaptureDeviceAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'capturedevice';
    }
    public function rules() {
        return array(
                array('capturedevice','length','max'=>50),
                array('capturedevice', 'unique'),
        );
    }
    public function relations() {
        return array(
                'media' => array(self::HAS_MANY, 'MediaAR', 'idcapturedevice'),
        );
    }
    public function attributeLabels() {
        return array(
                'idcapturedevice' => 'Capture device ID',
                'capturedevice' => 'Capture device',
        );
    }
}