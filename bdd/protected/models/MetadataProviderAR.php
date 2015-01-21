<?php
class MetadataProviderAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'metadataprovider';
    }
    public function rules() {
        return array(
                array('metadataprovider','length','max'=>80),
                array('metadataprovider','unique'),
                array('metadataprovider','required'),
        );
    }
    public function relations() {
        return array(
                'media' => array(self::HAS_MANY, 'MediaAR', 'idmetadataprovider'),
        );
    }
    public function attributeLabels() {
        return array(
                'idmetadataprovider' => 'Metadata provider ID',
                'metadataprovider' => 'Metadata provider',
        );
    }
}