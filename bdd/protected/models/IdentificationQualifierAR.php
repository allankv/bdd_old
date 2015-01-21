<?php
class IdentificationQualifierAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'identificationqualifier';
    }
    public function rules() {
        return array(
                array('identificationqualifier','required'),
                array('identificationqualifier','unique'),
        );
    }
    public function relations() {
        return array(
                'identificationelement' => array(self::HAS_MANY, 'IdentificationElementAR', 'ididentificationqualifier'),
        );
    }
    public function attributeLabels() {
        return array(
                'ididentificationqualifier'=>'Identification qualifier ID',
                'identificationqualifier'=>'Identification qualifier',
        );
    }
}