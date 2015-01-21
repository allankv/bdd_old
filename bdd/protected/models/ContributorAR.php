<?php
class ContributorAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'contributor';
    }
    public function rules() {
        return array(
                array('contributor','length','max'=>100),
                array('contributor', 'unique'),
        );
    }
    public function relations() {
        return array(
                'referenceelement' => array(self::HAS_MANY, 'ReferenceElementAR', 'idcontributor'),
                'species' => array(self::MANY_MANY, 'SpeciesAR', 'speciescontributor(idspecies, idcontributor)'),
        );
    }
    public function attributeLabels() {
        return array(
                'idcontributor' => 'Contributor ID',
                'contributor' => 'Contributors',
        );
    }
}