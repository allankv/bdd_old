<?php
class AccrualPolicyAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'accrualpolicy';
    }
    public function rules() {
        return array(
                array('accrualpolicy','length','max'=>100),
                array('accrualpolicy', 'unique'),
        );
    }
    public function relations() {
        return array(
                'referenceelement' => array(self::HAS_MANY, 'ReferenceElementAR', 'idaccrualpolicy'),
        );
    }
    public function attributeLabels() {
        return array(
                'idaccrualpolicy' => 'Accrual policy ID',
                'accrualpolicy' => 'Accrual policy',
        );
    }
}