<?php
class RecordedByAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'recordedby';
    }
    public function rules() {
        return array(
                array('recordedby', 'required'),
                array('recordedby', 'unique'),
        );
    }
    public function relations() {
        return array(
                'occurrenceelement' => array(self::MANY_MANY, 'OccurrenceElementAR', 'occurrencerecordedby(idrecordedby, idoccurrenceelements)'),
                'curatorialelement' => array(self::MANY_MANY, 'CuratorialElementAR', 'curatorialrecordedby(idrecordedby, idcuratorialelements)'),
        );
    }
    public function attributeLabels() {
        return array(
                'idrecordedby' => 'Recorded by ID',
                'recordedby' => 'Recorded by',
        );
    }
}