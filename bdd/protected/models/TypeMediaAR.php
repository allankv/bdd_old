<?php
class TypeMediaAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'typemedia';
    }
    public function rules() {
        return array(
                array('typemedia','length','max'=>80),
                array('typemedia','unique'),
                array('typemedia','required'),
        );
    }
    public function relations() {
        return array(
                'media' => array(self::HAS_MANY, 'MediaAR', 'idtypemedia'),
        );
    }
    public function attributeLabels() {
        return array(
                'idtypemedia' => 'Type media ID',
                'typemedia' => 'Type',
        );
    }
}