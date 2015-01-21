<?php
class ReferencePollinatorFamilyAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'referencepollinatorfamily';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'pollinatorfamilynn' => array(self::BELONGS_TO, 'PollinatorFamilyAR', 'idpollinatorfamily'),
                'referencenn' => array(self::BELONGS_TO, 'ReferenceAR', 'idreferenceelement'),
        );
    }
    public function attributeLabels() {
        return array(
                'idpollinatorfamily' => 'Pollinator Family ID',
                'idreferenceelement' => 'Reference ID',
        );
    }
}

