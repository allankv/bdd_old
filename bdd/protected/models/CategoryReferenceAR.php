<?php
class CategoryReferenceAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'categoryreference';
    }
    public function rules() {
        return array(
                array('categoryreference','length','max'=>64),
                array('categoryreference','required'),
                array('categoryreference', 'unique'),
        );
    }
    public function relations() {
        return array(
                'referenceelement' => array(self::HAS_MANY, 'ReferenceAR', 'idcategoryreference'),
        );
    }
    public function attributeLabels() {
        return array(
                'idcategoryreference' => 'Category reference ID',
                'categoryreference' => 'Category',
        );
    }
}