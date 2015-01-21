<?php
class TypeHoldingAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'typeholding';
    }
    public function rules() {
        return array(
                array('typeholding', 'required'),
                array('typeholding', 'unique'),
        );
    }
    public function relations() {
        return array(
                'deficit' => array(self::HAS_MANY, 'DeficitAR', 'idtypeholding'),
        );
    }
    public function attributeLabels() {
        return array(
                'idtypeholding' => 'Type of holding ID',
                'typeholding' => 'Type of holding',
        );
    }
}
?>