<?php
class ProviderAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'provider';
    }
    public function rules() {
        return array(
                array('provider','length','max'=>80),
                array('provider','unique'),
                array('provider','required'),
        );
    }
    public function relations() {
        return array(
                'media' => array(self::HAS_MANY, 'MediaAR', 'idprovider'),
        );
    }
    public function attributeLabels() {
        return array(
                'idprovider' => 'Provider ID',
                'provider' => 'Provider',
        );
    }
}