<?php
class MainPlantSpeciesInHedgeAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'mainplantspeciesinhedge';
    }
    public function rules() {
        return array(
                array('mainplantspeciesinhedge', 'required'),
                array('mainplantspeciesinhedge', 'unique'),
        );
    }
    public function relations() {
        return array(
                'deficit' => array(self::HAS_MANY, 'DeficitAR', 'idmainplantspeciesinhedge'),
        );
    }
    public function attributeLabels() {
        return array(
                'idmainplantspeciesinhedge' => 'Main plant species in the hedge ID',
                'mainplantspeciesinhedge' => 'Main plant species in the hedge',
        );
    }
}
?>