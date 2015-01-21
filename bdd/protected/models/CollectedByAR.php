<?php
class CollectedByAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'collectedby';
    }
    public function rules() {
        return array(
                array('collectedby', 'required'),
                array('collectedby', 'unique'),
        );
    }
    public function relations() {
        return array(
                'recordlevelelement' => array(self::HAS_MANY, 'RecordLevelElementAR', 'idcollectedby'),
        );
    }
    public function attributeLabels() {
        return array(
                'idcollectedby' => 'Collected by ID',
                'collectedby' => 'Collected by',
        );
    }
}