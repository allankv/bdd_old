<?php
class TypeStatusAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'typestatus';
    }
    public function rules() {
        return array(
                array('typestatus','length','max'=>30),
                array('typestatus', 'required'),
                array('typestatus', 'unique'),
        );
    }
    public function relations() {
        return array(
                'curatorialelement' => array(self::MANY_MANY, 'CuratorialElementAR', 'curatorialtypestatus(idcuratorialelement, idtypestatus)'),
                'identificationelement' => array(self::MANY_MANY, 'IdentificationElementAR', 'identificationtypestatus(ididentificationelement, idtypestatus)'),
        );
    }
    public function attributeLabels() {
        return array(
                'idtypestatus' => 'Type status ID',
                'typestatus' => 'Type status',
        );
    }
}