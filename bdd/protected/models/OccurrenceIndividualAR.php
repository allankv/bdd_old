<?php
class OccurrenceIndividualAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'occurrenceindividual';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'individualnn' => array(self::BELONGS_TO, 'IndividualAR', 'idindividual'),
                'occurrenceelementnn' => array(self::BELONGS_TO, 'OccurrenceElementAR', 'idoccurrenceelement'),
        );
    }
    public function attributeLabels() {
        return array(
                'idindividual' => 'Individual ID',
                'idoccurrenceelement' => 'Occurrence element ID',
        );
    }
}