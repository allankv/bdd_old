<?php
class PlantCommonNameAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'plantcommonname';
    }
    public function rules() {
        return array(
                array('plantcommonname','required'),
                array('plantcommonname','unique'),
        );
    }
    public function relations() {
        return array(
                'referenceelement' => array(self::MANY_MANY, 'ReferenceAR', 'referenceplantcommonname(idreferenceelement, idplantcommonname)'),
        );
    }
    public function attributeLabels() {
        return array(
                'idplantcommonname' => 'PlantCommonName ID',
                'plantcommonname' => 'Plant common name'
        );
    }
}