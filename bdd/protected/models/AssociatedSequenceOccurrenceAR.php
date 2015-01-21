<?php
class AssociatedSequenceOccurrenceAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'associatedsequence';
    }
    public function rules() {
        return array(
                array('associatedsequence', 'required'),
                array('associatedsequence', 'unique'),
        );
    }
    public function relations() {
        return array(
                'occurrenceelement' => array(self::MANY_MANY, 'OccurrenceElementAR', 'occurrenceassociatedsequence(idoccurrenceelement, idassociatedsequence)'),
        );
    }
    public function attributeLabels() {
        return array(
                'idassociatedsequence' => 'Associated sequence ID',
                'associatedsequence' => 'Associated sequence',
        );
    }
}