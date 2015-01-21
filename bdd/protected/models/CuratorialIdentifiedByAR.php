<?php
class CuratorialIdentifiedByAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'curatorialidentifiedby';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'identifiedbynn' => array(self::BELONGS_TO, 'IdentifiedByAR', 'ididentifiedby'),
                'curatorialelementnn' => array(self::BELONGS_TO, 'CuratorialElementAR', 'idcuratorialelement'),
        );
    }
    public function attributeLabels() {
        return array(
                'ididentifiedby' => 'Identified by ID',
                'idcuratorialelement' => 'Curatorial element ID',
        );
    }
}