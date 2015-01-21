<?php
class FocusCropAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'focuscrop';
    }
    public function rules() {
        return array(
                array('focuscrop', 'required'),
                array('focuscrop', 'unique'),
        );
    }
    public function relations() {
        return array(
                'deficit' => array(self::HAS_MANY, 'DeficitAR', 'idfocuscrop'),
        );
    }
    public function attributeLabels() {
        return array(
                'idfocuscrop' => 'Focus crop ID',
                'focuscrop' => 'Focus crop',
        );
    }
}
?>