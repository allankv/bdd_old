<?php
class OccurrencePreparationAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'occurrencepreparation';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'preparationnn' => array(self::BELONGS_TO, 'PreparationAR', 'idpreparation'),
                'occurrenceelementnn' => array(self::BELONGS_TO, 'OccurrenceElementAR', 'idoccurrenceelement'),
        );
    }
    public function attributeLabels() {
        return array(
                'idoccurrenceelement' => 'Occurrence element ID',
                'idpreparation' => 'Preparation ID',
        );
    }
}