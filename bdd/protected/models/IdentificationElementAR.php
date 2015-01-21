<?php
class IdentificationElementAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'identificationelement';
    }
    public function rules() {
        return array(
        );
    }
    public function relations() {
        return array(
                'specimen' => array(self::HAS_ONE, 'SpecimenAR', 'ididentificationelement'),
                'identificationqualifier' => array(self::BELONGS_TO, 'IdentificationQualifierAR', 'ididentificationqualifier'),
                //'referenceselement' => array(self::MANY_MANY, 'referenceselements', 'referencesidentification(ididentificationelements, idreferenceselements)'),
                'identifiedby' => array(self::MANY_MANY, 'IdentifiedByAR', 'identificationidentifiedby(ididentificationelement, ididentifiedby)'),
                //'occurrenceelement' => array(self::MANY_MANY, 'occurrenceelements', 'previousidentifications(ididentificationelements, idoccurrenceelements)'),
                'typestatus' => array(self::MANY_MANY, 'TypeStatusAR', 'identificationtypestatus(ididentificationelement, idtypestatus)'),
        );
    }
    public function attributeLabels() {
        return array(
                'ididentificationelement' => 'Identification element ID',
                'ididentificationqualifier' => 'Identification qualifier ID',
                'dateidentified' => 'Date identified',
                'identificationremark' => 'Identification remarks',
        );
    }
}