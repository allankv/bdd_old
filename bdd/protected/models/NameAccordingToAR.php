<?php

class NameAccordingToAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'nameaccordingto';
    }
    public function rules() {
        return array(
                array('nameaccordingto','length','max'=>120),
                array('nameaccordingto','required'),
                array('nameaccordingto','unique'),
        );
    }
    public function relations() {
        return array(
                'taxonomicelement' => array(self::HAS_MANY, 'TaxonomicElementAR', 'idnameaccordingto'),
        );
    }
    public function attributeLabels() {
        return array(
                'idnameaccordingto' => 'Idnameaccordingto',
                'nameaccordingto' => 'Name according to',
        );
    }
}