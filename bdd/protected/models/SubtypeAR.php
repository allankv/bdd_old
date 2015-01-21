<?php
class SubtypeAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'subtype';
    }
    public function rules() {
        return array(
                array('subtype','length','max'=>50),
                array('subtype','required'),
                array('subtype','unique'),
        );
    }
    public function relations() {
        return array(
                //'idtypemedia0' => array(self::BELONGS_TO, 'Typemedia', 'idtypemedia'),
                'media' => array(self::HAS_MANY, 'MediaAR', 'idsubtype'),
        );
    }
    public function attributeLabels() {
        return array(
                'idsubtype' => 'Subtype ID',
                'subtype' => 'Subtype',
                'idtypemedia' => 'Idtypemedia',
        );
    }
}