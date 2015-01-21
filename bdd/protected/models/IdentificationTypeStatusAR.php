<?php
class IdentificationTypeStatusAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'identificationtypestatus';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'typestatusnn' => array(self::BELONGS_TO, 'TypeStatusAR', 'idtypestatus'),
                'identificationelementnn' => array(self::BELONGS_TO, 'identificationElementAR', 'ididentificationelement'),
        );
    }
    public function attributeLabels() {
        return array(
                'idtypestatus' => 'Type status ID',
                'ididentificationelement' => 'Identification element ID',
        );
    }
}