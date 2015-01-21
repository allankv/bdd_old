<?php
class ReferencePlantCommonNameAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'referenceplantcommonname';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'plantcommonnamenn' => array(self::BELONGS_TO, 'PlantCommonNameAR', 'idplantcommonname'),
                'referencenn' => array(self::BELONGS_TO, 'ReferenceAR', 'idreferenceelement'),
        );
    }
    public function attributeLabels() {
        return array(
                'idplantcommonname' => 'Plant Common Name ID',
                'idreferenceelement' => 'Reference ID',
        );
    }
}
