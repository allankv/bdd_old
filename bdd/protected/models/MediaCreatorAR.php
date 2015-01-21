<?php
class MediaCreatorAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'mediacreator';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'creatornn' => array(self::BELONGS_TO, 'CreatorAR', 'idcreator'),
                'mediann' => array(self::BELONGS_TO, 'MediaAR', 'idmedia'),
        );
    }
    public function attributeLabels() {
        return array(
                'idcreator' => 'Creator ID',
                'idmedia' => 'Media ID',
        );
    }
}