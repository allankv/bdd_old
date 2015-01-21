<?php
class CreatorAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'creator';
    }
    public function rules() {
        return array(
                array('creator','length','max'=>100),
                array('creator', 'unique'),
        );
    }
    public function relations() {
        return array(
                'referenceelement' => array(self::MANY_MANY, 'ReferenceAR', 'referencecreator(idreferenceelement, idcreator)'),
                'media' => array(self::MANY_MANY, 'MediaAR', 'mediacreator(idmedia, idcreator)'),
                'species' => array(self::MANY_MANY, 'SpeciesAR', 'speciescreator(idspecies, idcreator)'),
        );
    }
    public function attributeLabels() {
        return array(
                'idcreator' => 'Creator ID',
                'creator' => 'Authors',
        );
    }
}
