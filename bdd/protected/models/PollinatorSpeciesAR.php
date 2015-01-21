<?php
class PollinatorSpeciesAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'pollinatorspecies';
    }
    public function rules() {
        return array(
                array('pollinatorspecies','required'),
                array('pollinatorspecies','unique'),
        );
    }
    public function relations() {
        return array(
                'referenceelement' => array(self::MANY_MANY, 'ReferenceAR', 'referencepollinatorspecies(idreferenceelement, idpollinatorspecies)'),
        );
    }
    public function attributeLabels() {
        return array(
                'idpollinatorspecies' => 'PollinatorSpecies ID',
                'pollinatorspecies' => 'Pollinator species'
        );
    }
}
