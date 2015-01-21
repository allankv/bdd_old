<?php
class IdentifiedByAR extends CActiveRecord {
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
                'identificationelement' => array(self::MANY_MANY, 'IdentificationElementAR', 'identificationidentifiedby(ididentificationelement, ididentifiedby)'),
        );
    }
    public function attributeLabels() {
        return array(
                'ididentifiedby' => 'Type status ID',
                'identifiedby' => 'Type status',
        );
    }
}