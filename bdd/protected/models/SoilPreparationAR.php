<?php
class SoilPreparationAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'soilpreparation';
    }
    public function rules() {
        return array(
                array('soilpreparation', 'required'),
                array('soilpreparation', 'unique'),
        );
    }
    public function relations() {
        return array(
                'deficit' => array(self::HAS_MANY, 'DeficitAR', 'idsoilpreparation'),
        );
    }
    public function attributeLabels() {
        return array(
                'idsoilpreparation' => 'Soil preparation ID',
                'soilpreparation' => 'Soil preparation',
        );
    }
}
?>