<?php

class associatedmedia extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'associatedmedia';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'idrecordlevelelements0' => array(self::BELONGS_TO, 'Recordlevelelements', 'idrecordlevelelements'),
        );
    }
    public function attributeLabels() {
        return array(
                'idassociatedmedia' => 'Idassociatedmedia',
                'associatedmedia' => 'Associatedmedia',
                'idrecordlevelelements' => 'Idrecordlevelelements',
        );
    }
}