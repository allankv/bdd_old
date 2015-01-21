<?php
class CanonicalAuthorshipAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'canonicalauthorship';
    }
    public function rules() {
        return array(
                array('canonicalauthorship','length','max'=>100),
                array('canonicalauthorship', 'required'),
                array('canonicalauthorship', 'unique'),
        );
    }
    public function relations() {
        return array(
                'canonicalname' => array(self::HAS_MANY, 'CanonicalNameAR', 'idcanonicalauthorship'),
        );
    }
    public function attributeLabels() {
        return array(
                'idcanonicalauthorship' => 'Canonical authorship ID',
                'canonicalauthorship' => 'Canonical authorship',
        );
    }
}