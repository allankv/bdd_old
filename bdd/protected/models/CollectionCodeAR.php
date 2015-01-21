<?php
class CollectionCodeAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'collectioncode';
    }
    public function rules() {
        return array(
                array('collectioncode', 'required'),
                array('collectioncode', 'unique'),
        );
    }
    public function relations() {
        return array(
                'recordlevelelement' => array(self::HAS_MANY, 'RecordLevelElementAR', 'idcollectioncode'),
        );
    }
    public function attributeLabels() {
        return array(
                'idcollectioncode'=>'Collection code ID',
                'collectioncode'=>'Collection code',
        );
    }
}