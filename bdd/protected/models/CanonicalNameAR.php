<?php
class CanonicalNameAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'canonicalname';
    }
    public function rules() {
        return array(
                array('canonicalname', 'numerical', 'integerOnly'=>true),
        );
    }
    public function relations() {
        return array(
                'specieelement' => array(self::HAS_MANY, 'SpecieElementAR', 'idcanonicalname'),
                'canonicalauthorship' => array(self::BELONGS_TO, 'CanonicalAuthorshipAR', 'idcanonicalauthorship'),
        );
    }
    public function attributeLabels() {
        return array(
                'idcanonicalname' => 'Canonical name ID',
                'idcanonicalauthorship' => 'Canonical authorship ID',
                'canonicalname' => 'Canonical name',
        );
    }
}