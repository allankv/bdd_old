<?php
class TreatmentAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'treatment';
    }
    public function rules() {
        return array(
                array('treatment', 'required'),
                array('treatment', 'unique'),
        );
    }
    public function relations() {
        return array(
                'deficit' => array(self::HAS_MANY, 'DeficitAR', 'idtreatment'),
        );
    }
    public function attributeLabels() {
        return array(
                'idtreatment' => 'Treatment ID',
                'treatment' => 'Treatment',
        );
    }
}
?>