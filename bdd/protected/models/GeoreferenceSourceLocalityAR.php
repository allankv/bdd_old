<?php
class GeoreferenceSourceLocalityAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'georeferencesource';
    }
    public function rules() {
        return array(
                array('georeferencesource', 'required'),
                array('georeferencesource', 'unique'),
        );
    }
    public function relations() {
        return array(
                'geospatialelement' => array(self::MANY_MANY, 'GeospatialElementAR', 'geospatialgeoreferencesource(idgeospatialelement, idgeoreferencesource)'),
                //'localityelement' => array(self::MANY_MANY, 'LocalityElementAR', 'localitygeoreferencesource(idlocalityelement, idgeoreferencesource)'),
        );
    }
    public function attributeLabels() {
        return array(
                'idgeoreferencesource' => 'Georeference source ID',
                'georeferencesource' => 'Georeference sources',
        );
    }
}