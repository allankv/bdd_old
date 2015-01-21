<?php
class OwnerInstitutionAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'ownerinstitution';
    }
    public function rules() {
        return array(
                array('ownerinstitution', 'required'),
                array('ownerinstitution', 'unique'),
        );
    }
    public function relations() {
        return array(
                'recordlevelelement' => array(self::HAS_MANY, 'RecordLevelElementAR', 'idownerinstitutioncode'),
        );
    }
    public function attributeLabels() {
        return array(
                'idownerinstitution' => 'Owner institution ID',
                'ownerinstitution' => 'Owner institution code',
        );
    }
}