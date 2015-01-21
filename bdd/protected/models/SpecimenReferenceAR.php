<?php
class SpecimenReferenceAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'specimenreference';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'specimennn' => array(self::BELONGS_TO, 'SpecimenAR', 'idspecimen'),
                'referencenn' => array(self::BELONGS_TO, 'ReferenceAR', 'idreferenceelement'),
        );
    }
    public function attributeLabels() {
        return array(
                'idspecimen' => 'Specimen ID',
                'idreferenceelement' => 'Reference ID',
        );
    }
}