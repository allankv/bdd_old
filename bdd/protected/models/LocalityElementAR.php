<?php

class LocalityElementAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'localityelement';
    }
    public function rules() {
        return array(
                array('minimumelevationinmeters','length','max'=>20),
                array('maximumelevationinmeters','length','max'=>20),
                array('minimumdepthinmeters','length','max'=>20),
                array('maximumdepthinmeters','length','max'=>20),
                array('coordinateprecision','length','max'=>256),
                array('footprintsrs','length','max'=>256),
                array('minimumdistanceabovesurfaceinmeters, maximumdistanceabovesurfaceinmeters', 'numerical'),
        );
    }
    public function relations() {
        return array(
                'georeferencedby' => array(self::MANY_MANY, 'GeoreferencedByAR', 'localitygeoreferencedby(idlocalityelement, idgeoreferencedby)'),
                'georeferenceverificationstatus' => array(self::BELONGS_TO, 'GeoreferenceVerificationStatusAR', 'idgeoreferenceverificationstatus'),
                'habitat' => array(self::BELONGS_TO, 'HabitatAR', 'idhabitat'),
                'municipality' => array(self::BELONGS_TO, 'MunicipalityAR', 'idmunicipality'),
                'waterbody' => array(self::BELONGS_TO, 'WaterBodyAR', 'idwaterbody'),
                'stateprovince' => array(self::BELONGS_TO, 'StateProvinceAR', 'idstateprovince'),
                'locality' => array(self::BELONGS_TO, 'LocalityAR', 'idlocality'),
                'islandgroup' => array(self::BELONGS_TO, 'IslandGroupAR', 'idislandgroup'),
                'island' => array(self::BELONGS_TO, 'IslandAR', 'idisland'),
                'county' => array(self::BELONGS_TO, 'CountyAR', 'idcounty'),
                'country' => array(self::BELONGS_TO, 'CountryAR', 'idcountry'),
                'site_' => array(self::BELONGS_TO, 'Site_AR', 'idsite_'),
                'continent' => array(self::BELONGS_TO, 'ContinentAR', 'idcontinent'),
                'specimen' => array(self::HAS_MANY, 'SpecimenAR', 'idlocalityelement'),
                'monitoring' => array(self::HAS_MANY, 'MonitoringAR', 'idlocalityelement'),
                //'geospatialelement' => array(self::HAS_MANY, 'geospatialelements', 'idlocalityelements'),
                'georeferencesource' => array(self::MANY_MANY, 'GeoreferenceSourceAR', 'localitygeoreferencesource(idlocalityelement, idgeoreferencesource)'),
                //'media' => array(self::HAS_MANY, 'MediaAR', 'idmedia'),
        );
    }
    public function attributeLabels() {
        return array(
                'idlocalityelement' => 'Locality element ID',
                'idlocality' => 'Locality ID',
                'idwaterbody' => 'Waterbody ID',
                'idislandgroup' => 'Islandgroup ID',
                'idisland' => 'Island ID',
                'idcounty' => 'County ID',
                'idstateprovince' => 'Stateprovince ID',
                'idcountry' => 'Country ID',
                'idcontinent' => 'Continent ID',
                'minimumelevationinmeters' => 'Minimum elevation in meters',
                'maximumelevationinmeters' => 'Maximum elevation in meters',
                'minimumdepthinmeters' => 'Minimum depth in meters',
                'maximumdepthinmeters' => 'Maximum depth in meters',
                'verbatimlocality' => 'Verbatim locality',
                'minimumdistanceabovesurfaceinmeters' => 'Min. distance above surface in meters',
                'maximumdistanceabovesurfaceinmeters' => 'Max. distance above surface in meters',
                'locationaccordingto' => 'Location according to',
                'locationremark' => 'Location remarks',
                'verbatimdepth' => 'Verbatim depth',
                'idmunicipality' => 'Municipality ID',
                'idhabitat' => 'Habitat ID',
                'verbatimelevation' => 'Verbatim elevation',
                'verbatimsrs' => 'Verbatim SRS',
                'coordinateprecision' => 'Coordinate precision',
                'footprintsrs' => 'Footprint SRS',
                'highergeograph' => 'Higher geography', //??
                'idgeoreferenceverificationstatus' => 'Georeference verification status ID',
        );
    }
}