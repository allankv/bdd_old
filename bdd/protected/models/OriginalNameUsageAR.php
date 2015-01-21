<?php

class OriginalNameUsageAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'originalnameusage';
    }
    public function rules() {
        return array(
                array('originalnameusage','length','max'=>120),
                array('originalnameusage','required'),
                array('originalnameusage','unique'),
        );
    }
    public function relations() {
        return array(
                'taxonomicelement' => array(self::HAS_MANY, 'TaxonomicElementsAR', 'idoriginalnameusage'),
        );
    }
    public function attributeLabels() {
        return array(
                'idoriginalnameusage' => 'Idoriginalnameusage',
                'originalnameusage' => 'Original name usage',
        );
    }
}