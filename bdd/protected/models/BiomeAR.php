<?php
class BiomeAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'biome';
    }
    public function rules() {
        return array(
                array('biome','required'),
                array('biome','unique'),
        );
    }
    public function relations() {
        return array(
                'referenceelement' => array(self::MANY_MANY, 'ReferenceAR', 'referencebiome(idreferenceelement, idbiome)'),
        );
    }
    public function attributeLabels() {
        return array(
                'idbiome' => 'Biome ID',
                'biome' => 'Biome'
        );
    }
}
