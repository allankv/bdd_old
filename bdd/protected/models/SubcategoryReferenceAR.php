<?php
class SubcategoryReferenceAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'subcategoryreference';
    }
    public function rules() {
        return array(
                array('subcategoryreference','length','max'=>64),
                array('subcategoryreference','required'),
                array('subcategoryreference', 'unique'),
            );
    }
    public function relations() {
        return array(
                'referenceelement' => array(self::HAS_MANY, 'ReferenceAR', 'idsubcategoryreference'),
        );
    }
    public function attributeLabels() {
        return array(
                'subcategoryreference' => 'Subcategory',

        );
    }
}