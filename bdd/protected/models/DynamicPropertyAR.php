<?php
class DynamicPropertyAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'dynamicproperty';
    }
    public function rules() {
        return array(
                array('dynamicproperty','required'),
                array('dynamicproperty','unique'),
        );
    }
    public function relations() {
        return array(
                'recordlevelelement' => array(self::MANY_MANY, 'RecordLevelElementAR', 'recordleveldynamicproperty(idrecordlevelelement, iddynamicproperty)'),
        );
    }
    public function attributeLabels() {
        return array(
                'iddynamicproperty' => 'Dynamic property ID',
                'dynamicproperty' => 'Dynamic properties'
        );
    }
}