<?php

class SpeciesNameAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'speciesname';
    }
    public function rules() {
        return array(
                array('speciesname', 'required'),
                array('speciesname', 'unique'),
        );
    }
    public function relations() {
        return array(
                'taxonomicelement' => array(self::HAS_MANY, 'TaxonomicElementAR', 'idspeciesname'),
        );
    }
    public function attributeLabels() {
        return array(
                'idspeciesname' => 'Species Name ID',
                'speciesname' => 'Species Name',
        );
    }
}

?>