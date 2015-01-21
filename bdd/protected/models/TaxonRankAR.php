<?php

class TaxonRankAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'taxonrank';
    }
    public function rules() {
        return array(
                array('taxonrank', 'required'),
                array('taxonrank', 'unique'),
        );
    }
    public function relations() {
        return array(
                'taxonomicelement' => array(self::HAS_MANY, 'TaxonomicElementAR', 'idtaxonrank'),
        );
    }
    public function attributeLabels() {
        return array(
                'idtaxonrank' => 'Idtaxonrank',
                'taxonrank' => 'Taxon rank',
        );
    }
}