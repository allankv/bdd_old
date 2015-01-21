<?php
class TypePlantingAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'typeplanting';
    }
    public function rules() {
        return array(
                array('typeplanting', 'required'),
                array('typeplanting', 'unique'),
        );
    }
    public function relations() {
        return array(
                'deficit' => array(self::HAS_MANY, 'DeficitAR', 'idtypeplanting'),
        );
    }
    public function attributeLabels() {
        return array(
                'idtypeplanting' => 'Type of planting ID',
                'typeplanting' => 'Type of planting',
        );
    }
}
?>