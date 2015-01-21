<?php
class IndividualAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'individual';
    }
    public function rules() {
        return array(
                array('individual','length','max'=>30),
                array('individual', 'required'),
                array('individual', 'unique'),
        );
    }
    public function relations() {
        return array(
                'occurrenceelement' => array(self::MANY_MANY, 'OccurrenceElementAR', 'occurrenceindividual(idoccurrenceelement, idindividual)'),
        );
    }
    public function attributeLabels() {
        return array(
                'idindividual' => 'Individual ID',
                'individual' => 'Individual',
        );
    }
}