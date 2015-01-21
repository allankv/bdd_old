<?php

class MediaTagAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'mediatag';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'tagnn' => array(self::BELONGS_TO, 'TagAR', 'idtag'),
                'mediann' => array(self::BELONGS_TO, 'MediaAR', 'idmedia'),
        );
    }
    public function attributeLabels() {
        return array(
                'idtag' => 'Idtag',
                'idmedia' => 'Idmedia',
        );
    }
}