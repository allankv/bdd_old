<?php
class CategoryMediaAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'categorymedia';
    }
    public function rules() {
        return array(
                array('categorymedia','length','max'=>128),
                array('categorymedia', 'unique'),
        );
    }
    public function relations() {
        return array(
                'media' => array(self::HAS_MANY, 'MediaAR', 'idcategorymedia'),
        );
    }
    public function attributeLabels() {
        return array(
                'idcategorymedia' => 'Category media ID',
                'categorymedia' => 'Category',
        );
    }
}