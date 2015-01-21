<?php
class LocalityGeoreferencedByAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'localitygeoreferencedby';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'georeferencedbynn' => array(self::BELONGS_TO, 'GeoreferencedByAR', 'idgeoreferencedby'),
                'localityelementnn' => array(self::BELONGS_TO, 'LocalityElementAR', 'idlocalityelement'),
        );
    }
    public function attributeLabels() {
        return array(
                'idgeoreferencedby' => 'Georeferenced by ID',
                'idlocalityelement' => 'Locality element ID',
        );
    }
}