<?php
class LocalityGeoreferenceSourceAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'localitygeoreferencesource';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'georeferencedsourcenn' => array(self::BELONGS_TO, 'GeoreferenceSourceAR', 'idgeoreferencesource'),
                'localityelementnn' => array(self::BELONGS_TO, 'LocalityElementAR', 'idlocalityelement'),
        );
    }
    public function attributeLabels() {
        return array(
                'idgeoreferencesource' => 'Georeferenced by ID',
                'idlocalityelement' => 'Locality element ID',
        );
    }
}