<?php
class RecordLevelDynamicPropertyAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'recordleveldynamicproperty';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'dynamicpropertynn' => array(self::BELONGS_TO, 'DynamicPropertyAR', 'iddynamicproperty'),
                'recordlevelelementnn' => array(self::BELONGS_TO, 'RecordLevelElementAR', 'idrecordlevelelement'),
        );
    }
    public function attributeLabels() {
        return array(
                'idrecordlevelelement' => 'Record level element ID',
                'iddynamicproperty' => 'Dynamic property ID',
        );
    }
}