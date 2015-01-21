<?php
class AudienceAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'audiences';
    }
    public function rules() {
        return array(
                array('audience','length','max'=>100),
                array('audience', 'unique'),
        );
    }
    public function relations() {
        return array(
                'referenceelement' => array(self::HAS_MANY, 'ReferenceElementAR', 'idaudience'),
        );
    }
    public function attributeLabels() {
        return array(
                'idaudience' => 'Audience ID',
                'audience' => 'Audience',
        );
    }
}