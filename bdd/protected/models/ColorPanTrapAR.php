<?php
class ColorPanTrapAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'colorpantrap';
    }
    public function rules() {
        return array(
                array('colorpantrap', 'required'),
                array('colorpantrap', 'unique'),
        );
    }
    public function relations() {
        return array(
                'monitoring' => array(self::HAS_MANY, 'MonitoringAR', 'idcolorpantrap'),
        );
    }
    public function attributeLabels() {
        return array(
                'idcolorpantrap' => 'Color pan trap ID',
                'colorpantrap' => 'Color pan trap',
        );
    }
}