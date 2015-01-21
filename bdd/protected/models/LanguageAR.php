<?php

class LanguageAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'language';
    }
    public function rules() {
        return array(
                array('language','length','max'=>100),
                array('codelanguage','length','max'=>2),
        );
    }
    public function relations() {
        return array(
                'recordlevelelement' => array(self::HAS_MANY, 'RecordLevelElementAR', 'idlanguage'),
                'referenceelement' => array(self::HAS_MANY, 'ReferenceAR', 'idlanguage'),
                'media' => array(self::HAS_MANY, 'MediaAR', 'idlanguage'),
                'species' => array(self::HAS_MANY, 'SpeciesAR', 'idlanguage'),
        );
    }
    public function attributeLabels() {
        return array(
                'idlanguages' => 'Language ID',
                'language' => 'Language',
                'codelanguage' => 'Language Code',
        );
    }
}