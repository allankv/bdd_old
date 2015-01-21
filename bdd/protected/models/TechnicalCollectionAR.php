<?php
class TechnicalCollectionAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'technicalcollection';
    }
    public function rules() {
        return array(
                array('technicalcollection', 'required'),
                array('technicalcollection', 'unique'),
        );
    }
    public function relations() {
        return array(
                'monitoring' => array(self::HAS_MANY, 'MonitoringAR', 'idtechnicalcollection'),
        );
    }
    public function attributeLabels() {
        return array(
                'idtechnicalcollection' => 'Technical collection ID',
                'technicalcollection' => 'Technical collection',
        );
    }
}