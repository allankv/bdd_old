<?php
class ReferencePollinatorCommonNameAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'referencepollinatorcommonname';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'pollinatorcommonnamenn' => array(self::BELONGS_TO, 'PollinatorCommonNameAR', 'idpollinatorcommonname'),
                'referencenn' => array(self::BELONGS_TO, 'ReferenceAR', 'idreferenceelement'),
        );
    }
    public function attributeLabels() {
        return array(
                'idpollinatorcommonname' => 'Pollinator Common Name ID',
                'idreferenceelement' => 'Reference ID',
        );
    }
}
