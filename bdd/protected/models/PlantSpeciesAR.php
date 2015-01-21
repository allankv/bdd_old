<?php
class PlantSpeciesAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'plantspecies';
    }
    public function rules() {
        return array(
                array('plantspecies','required'),
                array('plantspecies','unique'),
        );
    }
    public function relations() {
        return array(
                'referenceelement' => array(self::MANY_MANY, 'ReferenceAR', 'referenceplantspecies(idreferenceelement, idplantspecies)'),
        );
    }
    public function attributeLabels() {
        return array(
                'idplantspecies' => 'PlantSpecies ID',
                'plantspecies' => 'Plant species'
        );
    }
}
