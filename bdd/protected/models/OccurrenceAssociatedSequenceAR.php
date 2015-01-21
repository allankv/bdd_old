<?php
class OccurrenceAssociatedSequenceAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'occurrenceassociatedsequence';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'associatedsequencenn' => array(self::BELONGS_TO, 'AssociatedSequenceAR', 'idassociatedsequence'),
                'occurrenceelementnn' => array(self::BELONGS_TO, 'OccurrenceElementAR', 'idoccurrenceelement'),
        );
    }
    public function attributeLabels() {
        return array(
                'idoccurrenceelement' => 'Occurrence element ID',
                'idassociatedsequence' => 'Associated sequence ID',
        );
    }
}