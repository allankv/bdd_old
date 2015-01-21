<?php
class IdentificationIdentifiedByAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'identificationidentifiedby';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'identifiedbynn' => array(self::BELONGS_TO, 'IdentifiedByAR', 'ididentifiedby'),
                'identificationelementnn' => array(self::BELONGS_TO, 'identificationElementAR', 'ididentificationelement'),
        );
    }
    public function attributeLabels() {
        return array(
                'ididentifiedby' => 'Identified by ID',
                'ididentificationelement' => 'Identification element ID',
        );
    }
}