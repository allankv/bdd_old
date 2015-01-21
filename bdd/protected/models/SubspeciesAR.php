<?php

class SubspeciesAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'subspecies';
    }
    public function rules() {
        return array(
                array('subspecies', 'required'),
                array('subspecies', 'unique'),
        );
    }
    public function relations() {
        return array(
                'taxonomicelement' => array(self::HAS_MANY, 'TaxonomicElementAR', 'idsubspecies'),
        );
    }
    public function attributeLabels() {
        return array(
                'idsubspecies' => 'Subspecies ID',
                'subspecies' => 'Subspecies',
        );
    }
}

?>