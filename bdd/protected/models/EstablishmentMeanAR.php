<?php
class EstablishmentMeanAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'establishmentmean';
    }
    public function rules() {
        return array(
                array('establishmentmean','length','max'=>36),
                array('establishmentmean', 'required'),
                array('establishmentmean', 'unique'),
        );
    }
    public function relations() {
        return array(
                'occurrenceelement' => array(self::HAS_MANY, 'OccurrenceElementAR', 'idestablishmentmean'),
        );
    }
    public function attributeLabels() {
        return array(
                'idestablishmentmean' => 'Establishment mean ID',
                'establishmentmean' => 'Establishment means',
        );
    }
}