<?php
class KeywordAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'keyword';
    }
    public function rules() {
        return array(
                array('keyword','length','max'=>100),
                array('keyword', 'unique'),
        );
    }
    public function relations() {
        return array(
                'referenceelement' => array(self::MANY_MANY, 'ReferenceAR', 'referencekeyword(idreferenceelement, idkeyword)'),
        );
    }
    public function attributeLabels() {
        return array(
                'idkeyword' => 'Keyword ID',
                'keyword' => 'Keyword',
        );
    }
}
