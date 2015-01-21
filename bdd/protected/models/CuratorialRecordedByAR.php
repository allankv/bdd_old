<?php
class CuratorialRecordedByAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'curatorialrecordedby';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'recordedbynn' => array(self::BELONGS_TO, 'RecordedByAR', 'idrecordedby'),
                'curatorialelementnn' => array(self::BELONGS_TO, 'CuratorialElementAR', 'idcuratorialelement'),
        );
    }
    public function attributeLabels() {
        return array(
                'idrecordedby' => 'Recorded by ID',
                'idcuratorialelement' => 'Curatorial element ID',
        );
    }
}