<?php
class GenusAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'genus';
    }
    public function rules() {
        return array(
                array('genus', 'required'),
                array('genus', 'unique'),
        );
    }
    public function relations() {
        return array(
                'taxonomicelement' => array(self::HAS_MANY, 'TaxonomicElementAR', 'idgenus'),
        );
    }
    public function attributeLabels() {
        return array(
                'idgenus' => 'Genus ID',
                'genus' => 'Genus',
        );
    }
}
?>