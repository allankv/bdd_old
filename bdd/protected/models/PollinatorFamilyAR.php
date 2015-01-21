<?php
class PollinatorFamilyAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'pollinatorfamily';
    }
    public function rules() {
        return array(
                array('pollinatorfamily','required'),
                array('pollinatorfamily','unique'),
        );
    }
    public function relations() {
        return array(
                'referenceelement' => array(self::MANY_MANY, 'ReferenceAR', 'referencepollinatorfamily(idreferenceelement, idpollinatorfamily)'),
        );
    }
    public function attributeLabels() {
        return array(
                'idpollinatorfamily' => 'PollinatorFamily ID',
                'pollinatorfamily' => 'Pollinator family'
        );
    }
}
