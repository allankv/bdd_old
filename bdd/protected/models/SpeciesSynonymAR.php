<?php
class SpeciesSynonymAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'speciessynonym';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'synonymnn' => array(self::BELONGS_TO, 'SynonymAR', 'idsynonym'),
                'speciesnn' => array(self::BELONGS_TO, 'SpeciesAR', 'idspecies'),
        );
    }
    public function attributeLabels() {
        return array(
                'idsynonym' => 'Synonym ID',
                'idspecies' => 'Species ID',
        );
    }
}