<?php
class SpeciesPaperAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'speciespaper';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'speciesnn' => array(self::BELONGS_TO, 'SpeciesAR', 'idspecies'),
                'referencenn' => array(self::BELONGS_TO, 'ReferenceAR', 'idreferenceelement'),
        );
    }
    public function attributeLabels() {
        return array(
                'idspecies' => 'Species ID',
                'idreferenceelement' => 'Reference ID',
        );
    }
}