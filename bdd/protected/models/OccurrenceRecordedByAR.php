<?php
class OccurrenceRecordedByAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'occurrencerecordedby';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'recordedbynn' => array(self::BELONGS_TO, 'RecordedByAR', 'idrecordedby'),
                'occurrenceelementnn' => array(self::BELONGS_TO, 'OccurrenceElementAR', 'idoccurrenceelement'),
        );
    }
    public function attributeLabels() {
        return array(
                'idrecordedby' => 'Recorded by ID',
                'idoccurrenceelement' => 'Occurrence element ID',
        );
    }
}