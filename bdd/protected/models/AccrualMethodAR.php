<?php
class AccrualMethodAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'accrualmethod';
    }
    public function rules() {
        return array(
                array('accrualmethod','length','max'=>100),
                array('accrualmethod', 'unique'),
        );
    }
    public function relations() {
        return array(
                'referenceelement' => array(self::HAS_MANY, 'ReferenceElementAR', 'idaccrualmethod'),
        );
    }
    public function attributeLabels() {
        return array(
                'idaccrualmethod' => 'Accrual method ID',
                'accrualmethod' => 'Accrual method',
        );
    }
}