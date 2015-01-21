<?php

class SubtypeReferenceAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'subtypereference';
    }
    public function rules() {
        return array(
                array('subtypereference','length','max'=>64),
                array('subtypereference','required'),
                array('subtypereference', 'unique'),
        );
    }
    public function relations() {
        return array(
                'referenceelement' => array(self::HAS_MANY, 'ReferenceAR', 'idsubtypereference'),
        );
    }
    public function attributeLabels() {
        return array(
                'subtypereference' => 'Subtype',
        );
    }
}