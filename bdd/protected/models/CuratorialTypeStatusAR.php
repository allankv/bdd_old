<?php
class CuratorialTypeStatusAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'curatorialtypestatus';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'typestatusnn' => array(self::BELONGS_TO, 'TypeStatusAR', 'idtypestatus'),
                'curatorialelementnn' => array(self::BELONGS_TO, 'CuratorialElementAR', 'idcuratorialelement'),
        );
    }
    public function attributeLabels() {
        return array(
                'idtypestatus' => 'Type status ID',
                'idcuratorialelement' => 'Curatorial element ID',
        );
    }
}