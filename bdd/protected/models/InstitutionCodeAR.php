<?php
class InstitutionCodeAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'institutioncode';
    }
    public function rules() {
        return array(
                array('institutioncode', 'required'),
                array('institutioncode', 'unique'),
        );
    }
    public function relations() {
        return array(
                'recordlevelelement'=>array(self::HAS_MANY, 'RecordLevelElementAR', 'idinstitutioncode'),
                'species'=>array(self::HAS_MANY, 'SpeciesAR', 'idinstitutioncode'),
        );
    }
    public function attributeLabels() {
        return array(
                'idinstitutioncode'=>'Institution code ID',
                'institutioncode'=>'Institution code',
        );
    }
}