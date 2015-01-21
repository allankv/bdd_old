<?php
class PollinatorCommonNameAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'pollinatorcommonname';
    }
    public function rules() {
        return array(
                array('pollinatorcommonname','required'),
                array('pollinatorcommonname','unique'),
        );
    }
    public function relations() {
        return array(
                'referenceelement' => array(self::MANY_MANY, 'ReferenceAR', 'referencepollinatorcommonname(idreferenceelement, idpollinatorcommonname)'),
        );
    }
    public function attributeLabels() {
        return array(
                'idpollinatorcommonname' => 'PollinatorCommonName ID',
                'pollinatorcommonname' => 'Pollinator common name'
        );
    }
}
