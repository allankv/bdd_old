<?php

class MorphospeciesAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'morphospecies';
    }
    public function rules() {
        return array(
                array('morphospecies', 'required'),
                array('morphospecies', 'unique'),
        );
    }
    public function relations() {
        return array(
                'taxonomicelement' => array(self::HAS_MANY, 'TaxonomicElementAR', 'idmorphospecies'),
        		'groups' => array(self::BELONGS_TO, 'groups', 'idGroup'),
        );
    }
    public function attributeLabels() {
        return array(
                'idmorphospecies' => 'Morphospecies ID',
                'morphospecies' => 'Morphospecies',
        );
    }
}

?>
