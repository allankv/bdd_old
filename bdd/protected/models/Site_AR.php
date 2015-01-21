<?php
class Site_AR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'site_';
    }
    public function rules() {
        return array(
                array('site_', 'required'),
                array('site_', 'unique'),
        );
    }
    public function relations() {
        return array(
            'localityelement' => array(self::HAS_MANY, 'LocalityElementAR', 'idsite_'),
        );
    }
    public function attributeLabels() {
        return array(
                'idsite_'=>'Site ID',
                'site_'=>'Site',
        );
    }
}