<?php
class IdentifiedByCuratorialAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'identifiedby';
    }
    public function rules() {
        return array(
                array('identifiedby','length','max'=>30),
                array('identifiedby', 'required'),
                array('identifiedby', 'unique'),
        );
    }
    public function relations() {
        return array(
                'curatorialelement' => array(self::MANY_MANY, 'CuratorialElementAR', 'curatorialidentifiedby(idcuratorialelement, ididentifiedby)'),
        );
    }
    public function attributeLabels() {
        return array(
                'ididentifiedby' => 'Identified by ID',
                'identifiedby' => 'Identified by',
        );
    }
}