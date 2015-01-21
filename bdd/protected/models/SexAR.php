<?php
class SexAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'sex';
    }
    public function rules() {
        return array(
                array('sex', 'required'),
        );
    }
    public function relations() {
        return array(
                'occurrenceelement' => array(self::HAS_MANY, 'OccurrenceElementAR', 'idsex'),
        );
    }
    public function attributeLabels() {
        return array(
                'idsex' => 'Sex ID',
                'sex' => 'Sex',
        );
    }
}