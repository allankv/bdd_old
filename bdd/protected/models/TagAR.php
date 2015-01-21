<?php

class TagAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'tag';
    }
    public function rules() {
        return array(
                array('tag','length','max'=>50),
                array('tag', 'unique'),

        );
    }
    public function relations() {
        return array(
                'media' => array(self::MANY_MANY, 'MediaAR', 'mediatag(idtag, idmedia)'),
        );
    }
    public function attributeLabels() {
        return array(
                'idtag' => 'Idtag',
                'tag' => 'Tags',
        );
    }
}