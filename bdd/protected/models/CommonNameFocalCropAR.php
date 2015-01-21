<?php
class CommonNameFocalCropAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'commonnamefocalcrop';
    }
    public function rules() {
        return array(
                array('commonnamefocalcrop', 'required'),
                array('commonnamefocalcrop', 'unique'),
        );
    }
    public function relations() {
        return array(
                'deficit' => array(self::HAS_MANY, 'DeficitAR', 'idcommonnamefocalcrop'),
        );
    }
    public function attributeLabels() {
        return array(
                'idcommonnamefocalcrop' => 'Common name of focal crop ID',
                'commonnamefocalcrop' => 'Common name of focal crop',
        );
    }
}
?>