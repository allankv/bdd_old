<?php

class TypeReferenceAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'typereference';
    }
    public function rules() {
        return array(
                array('typereference','length','max'=>100),
                array('typereference', 'unique'),
        );
    }
    public function relations() {
        return array(
                'referenceelement' => array(self::HAS_MANY, 'ReferenceAR', 'idtypereference'),
        );
    }
    public function attributeLabels() {
        return array(
                'idtypereference' => 'Idtypereference',
                'typereference' => 'Type',
        );
    }
}