<?php
class PublisherAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'publisher';
    }
    public function rules() {
        return array(
                array('publisher', 'required'),
                array('publisher', 'unique'),
        );
    }
    public function relations() {
        return array(
                'referenceelement' => array(self::HAS_MANY, 'ReferenceAR', 'idpublisher'),
        );
    }
    public function attributeLabels() {
        return array(
                'idpublisher'=>'Publisher ID',
                'publisher'=>'Publisher',
        );
    }
}