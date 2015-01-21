<?php
class SpeciesMediaAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'speciesmedia';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'speciesnn' => array(self::BELONGS_TO, 'SpeciesAR', 'idspecies'),
                'mediann' => array(self::BELONGS_TO, 'MediaAR', 'idmedia'),
        );
    }
    public function attributeLabels() {
        return array(
                'idspecies' => 'Species ID',
                'idmedia' => 'Media ID',
        );
    }
}