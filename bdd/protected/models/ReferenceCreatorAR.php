<?php
class ReferenceCreatorAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'referencecreator';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'creatornn' => array(self::BELONGS_TO, 'CreatorAR', 'idcreator'),
                'referencenn' => array(self::BELONGS_TO, 'ReferenceAR', 'idreferenceelement'),
        );
    }
    public function attributeLabels() {
        return array(
                'idcreator' => 'Creator ID',
                'idreferenceelement' => 'Reference ID',
        );
    }
}

