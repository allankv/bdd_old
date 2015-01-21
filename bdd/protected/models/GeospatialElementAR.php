<?php

class GeospatialElementAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'geospatialelement';
    }
    public function rules() {
        return array(
                array('decimallongitude', 'numerical'),
                array('decimallatitude', 'numerical'),
                array('coordinateuncertaintyinmeters', 'numerical'),
        );
    }
    public function relations() {
        return array(
                'georeferenceverificationstatus' => array(self::BELONGS_TO, 'GeoreferenceVerificationStatusGeospatialAR', 'idgeoreferenceverificationstatus'),
                'specimen' => array(self::HAS_MANY, 'SpecimenAR', 'idgeospatialelement'),
                'monitoring' => array(self::HAS_MANY, 'MonitoringAR', 'idgeospatialelement'),
                'georeferencesource' => array(self::MANY_MANY, 'GeoreferenceSourceAR', 'geospatialgeoreferencesources(idgeospatialelement, idgeoreferencesource)'),
        );
    }
    public function attributeLabels() {
        return array(
                'idgeospatialelement' => 'Geospatial element ID',
                'decimallongitude' => 'Decimal longitude',
                'decimallatitude' => 'Decimal latitude',
                'coordinateuncertaintyinmeters' => 'Coordinate uncertainty in Meters',
                'georeferenceremark' => 'Georeference remarks',
                'geodeticdatum' => 'Geodetic datum',
                'pointradiusspatialfit' => 'Point radius spatial fit',
                'verbatimcoordinate' => 'Verbatim coordinates',
                'verbatimlatitude' => 'Verbatim latitude',
                'verbatimlongitude' => 'Verbatim longitude',
                'verbatimcoordinatesystem' => 'Verbatim coordinate system',
                'georeferenceprotocol' => 'Georeference protocol',
                'footprintwkt' => 'Footprint WKT',
                'footprintspatialfit' => 'Footprint spatial fit',
                'idgeoreferenceverificationstatus' => 'Georeference verification status ID',
        );
    }
}