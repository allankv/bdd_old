<?php
class ReferencePlantSpeciesAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'referenceplantspecies';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'plantspeciesnn' => array(self::BELONGS_TO, 'PlantSpeciesAR', 'idplantspecies'),
                'referencenn' => array(self::BELONGS_TO, 'ReferenceAR', 'idreferenceelement'),
        );
    }
    public function attributeLabels() {
        return array(
                'idplantspecies' => 'Plant Species ID',
                'idreferenceelement' => 'Reference ID',
        );
    }
}
