<?php

class NamePublishedInAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'namepublishedin';
    }
    public function rules() {
        return array(
                array('namepublishedin','length','max'=>120),
                array('namepublishedin','required'),
                array('namepublishedin','unique'),
        );
    }
    public function relations() {
        return array(
                'taxonomicelement' => array(self::HAS_MANY, 'TaxonomicElementAR', 'idnamepublishedin'),
        );
    }
    public function attributeLabels() {
        return array(
                'idnamepublishedin' => 'Idnamepublishedin',
                'namepublishedin' => 'Name published in',
        );
    }
}