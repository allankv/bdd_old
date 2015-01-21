<?php
class ReferenceKeywordAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'referencekeyword';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'keywordnn' => array(self::BELONGS_TO, 'KeywordAR', 'idkeyword'),
                'referencenn' => array(self::BELONGS_TO, 'ReferenceAR', 'idreferenceelement'),
        );
    }
    public function attributeLabels() {
        return array(
                'idkeyword' => 'Keyword ID',
                'idreferenceelement' => 'Reference ID',
        );
    }
}

