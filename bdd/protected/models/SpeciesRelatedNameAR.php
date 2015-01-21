<?php
class SpeciesRelatedNameAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'speciesrelatedname';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'relatednamenn' => array(self::BELONGS_TO, 'RelatedNameAR', 'idrelatedname'),
                'speciesnn' => array(self::BELONGS_TO, 'SpeciesAR', 'idspecies'),
        );
    }
    public function attributeLabels() {
        return array(
                'idrelatedname' => 'Related Name ID',
                'idspecies' => 'Species ID',
        );
    }
}