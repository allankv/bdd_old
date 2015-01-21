<?php

class SubtribeAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'subtribe';
    }
    public function rules() {
        return array(
                array('subtribe', 'required'),
                array('subtribe', 'unique'),
        );
    }
    public function relations() {
        return array(
                'taxonomicelement' => array(self::HAS_MANY, 'TaxonomicElementAR', 'idsubtribe'),
        );
    }
    public function attributeLabels() {
        return array(
                'idsubtribe' => 'Subtribe ID',
                'subtribe' => 'Subtribe',
        );
    }
}

?>