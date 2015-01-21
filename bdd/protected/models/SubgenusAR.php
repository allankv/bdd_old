<?php

class SubgenusAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'subgenus';
    }
    public function rules() {
        return array(
                array('subgenus','length','max'=>120),
                array('subgenus', 'required'),
                array('subgenus', 'unique'),
        );
    }

    public function relations() {
        return array(
                'taxonomicelement' => array(self::HAS_MANY, 'TaxonomicElementAR', 'idsubgenus'),
        );
    }
    public function attributeLabels() {
        return array(
                'idsubgenus' => 'Idsubgenus',
                'subgenus' => 'Subgenus',
        );
    }
}