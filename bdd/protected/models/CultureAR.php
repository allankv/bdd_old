<?php
class CultureAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'culture';
    }
    public function rules() {
        return array(
                array('culture', 'required'),
                array('culture', 'unique'),
        );
    }
    public function relations() {
        return array(
                'monitoring' => array(self::HAS_MANY, 'MonitoringAR', 'idculture'),
        );
    }
    public function attributeLabels() {
        return array(
                'idculture' => 'Culture ID',
                'culture' => 'Culture',
        );
    }
}