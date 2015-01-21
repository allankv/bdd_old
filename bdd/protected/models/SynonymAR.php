<?php
class SynonymAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'synonym';
    }
    public function rules() {
        return array(
                array('synonym','length','max'=>100),
                array('synonym', 'unique'),
        );
    }
    public function relations() {
        return array(
                'species' => array(self::MANY_MANY, 'SpeciesAR', 'speciessynonym(idspecies, idsynonym)'),
        );
    }
    public function attributeLabels() {
        return array(
                'idsynonym' => 'Synonym ID',
                'synonym' => 'Synonyms',
        );
    }
}