<?php
class DiseaseAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'disease';
    }
    public function rules() {
        return array(
                array('disease','length','max'=>255),
                array('disease','required'),
                array('disease', 'unique'),
        );
    }
    public function relations() {
        return array(
                'specieelement' => array(self::HAS_MANY, 'SpecieElementAR', 'disease_iddisease'),
        );
    }
    public function attributeLabels() {
        return array(
                'iddisease' => 'Disease ID',
                'diseases' => 'Disease',
        );
    }
}