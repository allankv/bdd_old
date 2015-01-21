<?php

class ParentNameUsageAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'parentnameusage';
    }
    public function rules() {
        return array(
                array('parentnameusage','length','max'=>120),
                array('parentnameusage','required'),
                array('parentnameusage','unique'),
        );
    }
    public function relations() {
        return array(
                'taxonomicelement' => array(self::HAS_MANY, 'TaxonomicElementAR', 'idparentnameusage'),
        );
    }
    public function attributeLabels() {
        return array(
                'idparentnameusage' => 'Idparentnameusage',
                'parentnameusage' => 'Parent name usage',
        );
    }
}