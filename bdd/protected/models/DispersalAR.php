<?php
class DispersalAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'dispersal';
    }
    public function rules() {
        return array(
                array('dispersal','length','max'=>255),
                array('dispersal', 'unique'),
        );
    }
    public function relations() {
        return array(
                'specieelement' => array(self::HAS_MANY, 'SpecieElementAR', 'iddispersal'),
        );
    }
    public function attributeLabels() {
        return array(
                'iddispersal' => 'Dispersal ID',
                'dispersal' => 'Dispersal',
        );
    }
}