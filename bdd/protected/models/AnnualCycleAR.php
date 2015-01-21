<?php

class AnnualCycleAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'annualcycle';
    }
    public function rules() {
        return array(
                array('annualcycle','length','max'=>50),
        );
    }
    public function relations() {
        return array(
                'specieelement' => array(self::HAS_MANY, 'SpecieElementAR', 'idannualcycle'),
        );
    }
    public function attributeLabels() {
        return array(
                'idannualcycle' => 'Annual cycle ID',
                'annualcycle' => 'Annual cycle',
        );
    }
}