<?php
class SpeciesContributorAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'speciescontributor';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'contributornn' => array(self::BELONGS_TO, 'ContributorAR', 'idcontributor'),
                'speciesnn' => array(self::BELONGS_TO, 'SpeciesAR', 'idspecies'),
        );
    }
    public function attributeLabels() {
        return array(
                'idcontributor' => 'Contributor ID',
                'idspecies' => 'Species ID',
        );
    }
}