<?php
class OriginSeedsAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'originseeds';
    }
    public function rules() {
        return array(
                array('originseeds', 'required'),
                array('originseeds', 'unique'),
        );
    }
    public function relations() {
        return array(
                'deficit' => array(self::HAS_MANY, 'DeficitAR', 'idoriginseeds'),
        );
    }
    public function attributeLabels() {
        return array(
                'idoriginseeds' => 'Origin of seeds ID',
                'originseeds' => 'Origin of seeds',
        );
    }
}
?>