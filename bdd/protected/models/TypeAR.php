<?php
class TypeAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'type';
    }
    public function rules() {
        return array(
                array('type','length','max'=>100),
                array('type', 'exist'),
        );
    }
    public function relations() {
        return array(
                'recordlevelelement' => array(self::HAS_MANY, 'RecordLevelElementAR', 'idtype'),
                'media' => array(self::HAS_MANY, 'Media', 'idtype'),
        );
    }
    public function attributeLabels() {
        return array(
                'idtype' => 'Type ID',
                'type' => 'Type',
        );
    }
}