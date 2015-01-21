<?php
class CuratorialPreparationAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'curatorialpreparation';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'preparationnn' => array(self::BELONGS_TO, 'PreparationAR', 'idpreparation'),
                'curatorialelementnn' => array(self::BELONGS_TO, 'CuratorialElementAR', 'idcuratorialelement'),
        );
    }
    public function attributeLabels() {
        return array(
                'idcuratorialelement' => 'Curatorial element ID',
                'idpreparation' => 'Preparation ID',
        );
    }
}