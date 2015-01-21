<?php
class LifeStageAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'lifestage';
    }
    public function rules() {
        return array(
                array('lifestage', 'required'),
                array('lifestage', 'unique'),
        );
    }
    public function relations() {
        return array(
                'occurrenceelement' => array(self::HAS_MANY, 'OccurrenceElementAR', 'idlifestage'),
        );
    }
    public function attributeLabels() {
        return array(
                'idlifestage' => 'Life stage ID',
                'lifestage' => 'Life stage',
        );
    }
}