<?php
class FormatMediaAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'formatmedia';
    }
    public function rules() {
        return array(
                array('formatmedia','length','max'=>16),
        );
    }
    public function relations() {
        return array(
                'media' => array(self::HAS_MANY, 'MediaAR', 'idformatmedia'),
        );
    }
    public function attributeLabels() {
        return array(
                'idformatmedia' => 'Format media ID',
                'formatmedia' => 'Format',
        );
    }
}