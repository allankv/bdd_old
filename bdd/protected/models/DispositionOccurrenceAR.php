<?php
class DispositionOccurrenceAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'disposition';
    }
    public function rules() {
        return array(
                array('disposition','length','max'=>60),
                array('disposition', 'required'),
                array('disposition', 'unique'),
        );
    }
    public function relations() {
        return array(
                'occurrenceelement' => array(self::HAS_MANY, 'OccurrenceElementAR', 'iddisposition'),
        );
    }
    public function attributeLabels() {
        return array(
                'iddisposition' => 'Disposition ID',
                'disposition' => 'Disposition',
        );
    }
}