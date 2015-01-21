<?php
class ReferenceAfiliationAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'referenceafiliation';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'afiliationnn' => array(self::BELONGS_TO, 'AfiliationAR', 'idafiliation'),
                'referencenn' => array(self::BELONGS_TO, 'ReferenceAR', 'idreferenceelement'),
        );
    }
    public function attributeLabels() {
        return array(
                'idafiliation' => 'Afiliation ID',
                'idreferenceelement' => 'Reference ID',
        );
    }
}