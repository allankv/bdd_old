<?php

class TaxonConceptAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'taxonconcept';
    }
    public function rules() {
        return array(
                array('taxonconcept','length','max'=>120),
                array('taxonconcept', 'unique'),
        );
    }
    public function relations() {
        return array(
                'taxonomicelement' => array(self::HAS_MANY, 'TaxonomicElementAR', 'idtaxonconcept'),
        );
    }
    public function attributeLabels() {
        return array(
                'idtaxonconcept' => 'Idtaxonconcept',
                'taxonconcept' => 'Taxon concept',
        );
    }
}