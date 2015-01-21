<?php
class SourceAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'source';
    }
    public function rules() {
        return array(
                array('source', 'required'),
                array('source', 'unique'),
        );
    }
    public function relations() {
        return array(
                'referenceelement' => array(self::HAS_MANY, 'ReferenceAR', 'idsource'),
        );
    }
    public function attributeLabels() {
        return array(
                'idsource'=>'Source ID',
                'source'=>'Source',
        );
    }
}