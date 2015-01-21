<?php
class DatasetAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'dataset';
    }
    public function rules() {
        return array(
                array('dataset','length','max'=>100),
                array('dataset','required'),
                array('dataset','unique'),
        );
    }
    public function relations() {
        return array(
                'recordlevelelement' => array(self::HAS_MANY, 'RecordLevelElementAR', 'iddataset'),
        );
    }
    public function attributeLabels() {
        return array(
                'iddataset' => 'Dataset ID',
                'dataset' => 'Dataset',
        );
    }
}