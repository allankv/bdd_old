<?php
class RecordedByOccurrenceAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'recordedby';
    }
    public function rules() {
        return array(
                array('recordedby', 'required'),
        );
    }
    public function relations() {
        return array(
                'occurrenceelement' => array(self::MANY_MANY, 'OccurrenceElementAR', 'occurrencerecordedby(idrecordedby, idoccurrenceelements)'),
        );
    }
    public function attributeLabels() {
        return array(
                'idrecordedby' => 'Recorded by ID',
                'recordedby' => 'Recorded by',
        );
    }
}