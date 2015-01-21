<?php
class TribeAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'tribe';
    }
    public function rules() {
        return array(
                array('tribe', 'required'),
                array('tribe', 'unique'),
        );
    }
    public function relations() {
        return array(
                'taxonomicelement' => array(self::HAS_MANY, 'TaxonomicElementAR', 'idtribe'),
        );
    }
    public function attributeLabels() {
        return array(
                'idtribe' => 'Tribe ID',
                'tribe' => 'Tribe',
        );
    }
}
?>