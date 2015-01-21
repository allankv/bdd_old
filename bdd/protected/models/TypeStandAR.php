<?php
class TypeStandAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'typestand';
    }
    public function rules() {
        return array(
                array('typestand', 'required'),
                array('typestand', 'unique'),
        );
    }
    public function relations() {
        return array(
                'deficit' => array(self::HAS_MANY, 'DeficitAR', 'idtypestand'),
        );
    }
    public function attributeLabels() {
        return array(
                'idtypestand' => 'Type of stand ID',
                'typestand' => 'Type of stand',
        );
    }
}
?>