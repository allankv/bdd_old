<?php
class MunicipalityAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'municipality';
    }
    public function rules() {
        return array(
                array('municipality','length','max'=>256),
                array('municipality','required'),
                array('municipality','unique'),
        );
    }
    public function relations() {
        return array(
                'localityelement' => array(self::HAS_MANY, 'LocalityElementAR', 'idmunicipality'),
        );
    }
    public function attributeLabels() {
        return array(
                'idmunicipality' => 'Idmunicipality',
                'municipality' => 'Municipality',
        );
    }
}