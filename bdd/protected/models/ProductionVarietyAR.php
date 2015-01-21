<?php
class ProductionVarietyAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'productionvariety';
    }
    public function rules() {
        return array(
                array('productionvariety', 'required'),
                array('productionvariety', 'unique'),
        );
    }
    public function relations() {
        return array(
                'deficit' => array(self::HAS_MANY, 'DeficitAR', 'idproductionvariety'),
        );
    }
    public function attributeLabels() {
        return array(
                'idproductionvariety' => 'Production variety ID',
                'productionvariety' => 'Production variety',
        );
    }
}
?>