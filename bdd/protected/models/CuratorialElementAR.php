<?php
class CuratorialElementAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'curatorialelement';
    }
    public function rules() {
        return array(
                array('individualcount', 'numerical', 'integerOnly'=>true),
        );
    }
    public function relations() {
        return array(
                'specimen' => array(self::HAS_ONE, 'SpecimenAR', 'idcuratorialelement'),
                'preparation' => array(self::MANY_MANY, 'PreparationAR', 'curatorialpreparation(idcuratorialelement, idpreparation)'),
                'disposition' => array(self::BELONGS_TO, 'DispositionCuratorialAR', 'iddisposition'),
                'identifiedby' => array(self::MANY_MANY, 'IdentifiedByAR', 'curatorialidentifiedby(ididentifiedby, idcuratorialelement)'),
                'typestatus' => array(self::MANY_MANY, 'TypeStatusAR', 'curatorialtypestatus(idcuratorialelement, idtypestatus)'),                
                'associatedsequence' => array(self::MANY_MANY, 'AssociatedSequenceAR', 'curatorialassociatedsequence(idcuratorialelements, idassociatedsequence)'),
                'recordedby' => array(self::MANY_MANY, 'RecordedByAR', 'curatorialrecordedby(idcuratorialelement, idrecordedby)'),
        );
    }
    public function attributeLabels() {
        return array(
                'idcuratorialelement' => 'Curatorial element ID',
                'fieldnumber' => 'Field number',
                'fieldnote' => 'Field notes',
                'verbatimeventdate' => 'Verbatim event date',
                'verbatimelevation' => 'Verbatim elevation',
                'verbatimdepth' => 'Verbatim depth',
                'individualcount' => 'Individual count',
                'iddisposition' => 'Disposition ID',
                'dateidentified' => 'Date identified',
        );
    }
}