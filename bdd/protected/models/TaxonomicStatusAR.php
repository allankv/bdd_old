<?php

class TaxonomicStatusAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'taxonomicstatus';
    }
    public function rules() {
        return array(
                array('taxonomicstatus','length','max'=>120),
                array('taxonomicstatus','required'),
                array('taxonomicstatus','exist'),
        );
    }
    public function relations() {
        return array(
                'taxonomicelement' => array(self::HAS_MANY, 'TaxonomicElementAR', 'idtaxonomicstatus'),
        );
    }
    public function attributeLabels() {
        return array(
                'idtaxonomicstatus' => 'Idtaxonomicstatus',
                'taxonomicstatus' => 'Taxonomic status',
        );
    }
}