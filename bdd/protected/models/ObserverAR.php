<?php
class ObserverAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'observer';
    }
    public function rules() {
        return array(
                array('observer', 'required'),
                array('observer', 'unique'),
        );
    }
    public function relations() {
        return array(
                'deficit' => array(self::HAS_MANY, 'DeficitAR', 'idobserver'),
        );
    }
    public function attributeLabels() {
        return array(
                'idobserver' => 'Observer ID',
                'observer' => 'Observer',
        );
    }
}
?>