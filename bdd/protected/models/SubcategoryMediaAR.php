<?php
class SubcategoryMediaAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'subcategorymedia';
    }
    public function rules() {
        return array(
                array('subcategorymedia','length','max'=>128),
                array('subcategorymedia','unique'),
                array('subcategorymedia','required'),
        );
    }
    public function relations() {
        return array(
                'media' => array(self::HAS_MANY, 'MediaAR', 'idsubcategorymedia'),
        );
    }
    public function attributeLabels() {
        return array(
                'idsubcategorymedia' => 'Subcategory ID',
                'subcategorymedia' => 'Subcategory',
        );
    }
}