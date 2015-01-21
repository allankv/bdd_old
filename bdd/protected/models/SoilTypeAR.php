<?php
class SoilTypeAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'soiltype';
    }
    public function rules() {
        return array(
                array('soiltype', 'required'),
                array('soiltype', 'unique'),
        );
    }
    public function relations() {
        return array(
                'deficit' => array(self::HAS_MANY, 'DeficitAR', 'idsoiltype'),
        );
    }
    public function attributeLabels() {
        return array(
                'idsoiltype' => 'Soil type ID',
                'soiltype' => 'Soil type',
        );
    }
}
?>