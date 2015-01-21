<?php
class BehaviorAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'behavior';
    }
    public function rules() {
        return array(
                array('behavior','required'),
                array('behavior', 'unique'),
        );
    }
    public function relations() {
        return array(
                'occurrenceelement' => array(self::HAS_MANY, 'OccurrenceElementAR', 'idbehavior'),
        );
    }
    public function attributeLabels() {
        return array(
                'idbehavior' => 'Behavior ID',
                'behavior' => 'Behavior',
        );
    }
}