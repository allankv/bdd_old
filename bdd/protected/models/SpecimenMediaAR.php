<?php
class SpecimenMediaAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'specimenmedia';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'specimennn' => array(self::BELONGS_TO, 'SpecimenAR', 'idspecimen'),
                'mediann' => array(self::BELONGS_TO, 'MediaAR', 'idmedia'),
        );
    }
    public function attributeLabels() {
        return array(
                'idspecimen' => 'Specimen ID',
                'idmedia' => 'Media ID',
        );
    }
}