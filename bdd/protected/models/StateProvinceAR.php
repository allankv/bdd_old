<?php
class StateProvinceAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'stateprovince';
    }
    public function rules() {
        return array(
                array('stateprovince', 'required'),
                array('stateprovince', 'unique'),
        );
    }
    public function relations() {
        return array(
                'localityelement' => array(self::HAS_MANY, 'LocalityElementAR', 'idstateprovince'),
        );
    }
    public function attributeLabels() {
        return array(
                'idstateprovince'=>'Idstateprovince',
                'stateprovince'=>'State or province',
        );
    }
}