<?php
class AccrualPeriodicityAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'accrualperiodicity';
    }
    public function rules() {
        return array(
                array('accrualperiodicity','length','max'=>100),
                array('accrualperiodicity', 'unique'),
        );
    }
    public function relations() {
        return array(
                'referenceelement' => array(self::HAS_MANY, 'ReferenceElementAR', 'idaccrualperiodicity'),
        );
    }
    public function attributeLabels() {
        return array(
                'idaccrualperiodicity' => 'Accural periodicity ID',
                'accrualperiodicity' => 'Accrual periodicity',
        );
    }
}