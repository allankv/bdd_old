<?php
class PreparationOccurrenceAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'preparation';
    }
    public function rules() {
        return array(
                array('preparation','length','max'=>256,'min'=>2),
                array('preparation', 'required'),
                array('idpreparation', 'unique'),
                array('preparation', 'unique'),                
        );
    }
    public function relations() {
        return array(
                //'curatorialelement' => array(self::MANY_MANY, 'CuratorialElementAR', 'curatorialpreparation(idcuratorialelement, idpreparation)'),
                'occurrenceelement' => array(self::MANY_MANY, 'OccurrenceElementAR', 'occurrencepreparation(idpreparation, idoccurrenceelement)'),
        );
    }
    public function attributeLabels() {
        return array(
                'idpreparation' => 'Preparation ID',
                'preparation' => 'Preparation',
        );
    }
}