<?php
class GeoreferencedByAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'georeferencedby';
    }
    public function rules() {
        return array(
                array('georeferencedby','length','max'=>256),
                array('georeferencedby', 'unique' ),
        );
    }
    public function relations() {
        return array(
                'localityelement' => array(self::MANY_MANY, 'LocalityElementAR', 'localitygeoreferencedby(idlocalityelement, idgeoreferencedby)'),
        );
    }
    public function attributeLabels() {
        return array(
                'idgeoreferencedby' => 'Georeferenced by ID',
                'georeferencedby' => 'Georeferenced by',
        );
    }
}