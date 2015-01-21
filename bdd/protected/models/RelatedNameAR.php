<?php
class RelatedNameAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'relatedname';
    }
    public function rules() {
        return array(
                array('relatedname','length','max'=>100),
                array('relatedname', 'unique'),
        );
    }
    public function relations() {
        return array(
                'species' => array(self::MANY_MANY, 'SpeciesAR', 'speciesrelatedname(idspecies, idrelatedname)'),
        );
    }
    public function attributeLabels() {
        return array(
                'idrelatedname' => 'Related Name ID',
                'relatedname' => 'Related Names',
        );
    }
}