<?php
class GeoreferenceVerificationStatusGeospatialAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'georeferenceverificationstatus';
    }
    public function rules() {
        return array(
                array('georeferenceverificationstatus', 'required'),
                array('georeferenceverificationstatus', 'unique'),
        );
    }
    public function relations() {
        return array(
                //'localityelement' => array(self::HAS_MANY, 'LocalityElementAR', 'idgeoreferenceverificationstatus'),
                'geospatialelement' => array(self::HAS_MANY, 'GeospatialElementAR', 'idgeoreferenceverificationstatus'),
        );
    }
    public function attributeLabels() {
        return array(
                'idgeoreferenceverificationstatus' => 'Verification status ID',
                'georeferenceverificationstatus' => 'Verification status',
        );
    }
}