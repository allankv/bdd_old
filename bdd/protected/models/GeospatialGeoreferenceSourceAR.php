<?php
class GeospatialGeoreferenceSourceAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'geospatialgeoreferencesource';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'georeferencesourcenn' => array(self::BELONGS_TO, 'GeoreferenceSourceGeospatialAR', 'idgeoreferencesource'),
                'geospatialelementnn' => array(self::BELONGS_TO, 'GeospatialElementAR', 'idgeospatialelement'),
        );
    }
    public function attributeLabels() {
        return array(
                'idgeoreferencesource' => 'Georeference source ID',
                'idgeospatialelement' => 'Geospatial element ID',
        );
    }
}