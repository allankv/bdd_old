<?php
class PlantFamilyAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'plantfamily';
    }
    public function rules() {
        return array(
                array('plantfamily','required'),
                array('plantfamily','unique'),
        );
    }
    public function relations() {
        return array(
                'referenceelement' => array(self::MANY_MANY, 'ReferenceAR', 'referenceplantfamily(idreferenceelement, idplantfamily)'),
        );
    }
    public function attributeLabels() {
        return array(
                'idplantfamily' => 'PlantFamily ID',
                'plantfamily' => 'Plant family'
        );
    }
}

