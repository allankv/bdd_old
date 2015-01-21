<?php
class ReferenceBiomeAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'referencebiome';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'biomenn' => array(self::BELONGS_TO, 'BiomeAR', 'idbiome'),
                'referencenn' => array(self::BELONGS_TO, 'ReferenceAR', 'idreferenceelement'),
        );
    }
    public function attributeLabels() {
        return array(
                'idbiome' => 'Biome ID',
                'idreferenceelement' => 'Reference ID',
        );
    }
}
