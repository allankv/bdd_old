<?php
class SpeciesCreatorAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'speciescreator';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'creatornn' => array(self::BELONGS_TO, 'CreatorAR', 'idcreator'),
                'speciesnn' => array(self::BELONGS_TO, 'SpeciesAR', 'idspecies'),
        );
    }
    public function attributeLabels() {
        return array(
                'idcreator' => 'Creator ID',
                'idspecies' => 'Species ID',
        );
    }
}