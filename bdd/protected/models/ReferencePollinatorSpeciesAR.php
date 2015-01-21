<?php
class ReferencePollinatorSpeciesAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'referencepollinatorspecies';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'pollinatorspeciesnn' => array(self::BELONGS_TO, 'PollinatorSpeciesAR', 'idpollinatorspecies'),
                'referencenn' => array(self::BELONGS_TO, 'ReferenceAR', 'idreferenceelement'),
        );
    }
    public function attributeLabels() {
        return array(
                'idpollinatorspecies' => 'Pollinator Species ID',
                'idreferenceelement' => 'Reference ID',
        );
    }
}

