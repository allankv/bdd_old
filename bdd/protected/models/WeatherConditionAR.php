<?php
class WeatherConditionAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'weathercondition';
    }
    public function rules() {
        return array(
                array('weathercondition', 'required'),
                array('weathercondition', 'unique'),
        );
    }
    public function relations() {
        return array(
                'deficit' => array(self::HAS_MANY, 'DeficitAR', 'idweathercondition'),
        );
    }
    public function attributeLabels() {
        return array(
                'idweathercondition' => 'Weather condition ID',
                'weathercondition' => 'Weather condition',
        );
    }
}
?>