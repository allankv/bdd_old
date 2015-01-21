<?php
class ReferencePlantFamilyAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'referenceplantfamily';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'plantfamilynn' => array(self::BELONGS_TO, 'PlantFamilyAR', 'idplantfamily'),
                'referencenn' => array(self::BELONGS_TO, 'ReferenceAR', 'idreferenceelement'),
        );
    }
    public function attributeLabels() {
        return array(
                'idplantfamily' => 'Plant Family ID',
                'idreferenceelement' => 'Reference ID',
        );
    }
}