<?php
class OccurrenceElementAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'occurrenceelement';
    }
    public function rules() {
        return array(
                array('catalognumber','length','max'=>256),
                array('recordnumber','length','max'=>256),
                array('occurrencestatus','length','max'=>56),
                array('catalognumber', 'required','message'=>'The field Catalog number is required.'),
                array('individualcount', 'numerical', 'integerOnly'=>true),
        );
    }
    public function relations() {
        return array(
                'specimen' => array(self::HAS_ONE, 'SpecimenAR', 'idoccurrenceelement'),
                'monitoring' => array(self::HAS_ONE, 'MonitoringAR', 'idoccurrenceelement'),
                'sex' => array(self::BELONGS_TO, 'SexAR', 'idsex'),
                'lifestage' => array(self::BELONGS_TO, 'LifeStageAR', 'idlifestage'),
                'reproductivecondition' => array(self::BELONGS_TO, 'ReproductiveConditionAR', 'idreproductivecondition'),
                'behavior' => array(self::BELONGS_TO, 'BehaviorAR', 'idbehavior'),
                'establishmentmean' => array(self::BELONGS_TO, 'EstablishmentMeanAR', 'idestablishmentmean'),
                'disposition' => array(self::BELONGS_TO, 'DispositionOccurrenceAR', 'iddisposition'),
                'associatedsequence' => array(self::MANY_MANY, 'AssociatedSequenceAR', 'occurrenceassociatedsequence(idassociatedsequence, idoccurrenceelement)'),
                'individual' => array(self::MANY_MANY, 'IndividualAR', 'occurrenceindividual(idindividual, idoccurrenceelement)'),
                'recordedby' => array(self::MANY_MANY, 'RecordedByAR', 'occurrencerecordedby(idrecordedby, idoccurrenceelement)'),
                'preparation' => array(self::MANY_MANY, 'PreparationAR', 'occurrencepreparation(idpreparation, idoccurrenceelement)'),
        );
    }
    public function attributeLabels() {
        return array(
                'idoccurrenceelement' => 'Occurrence elements ID',
                'catalognumber' => 'Catalog number',
                'occurrencedetail' => 'Occurrence details',
                'occurrenceremark' => 'Occurrence remarks',
                'recordnumber' => 'Record number',
                'individualcount' => 'Individual count',
                'occurrencestatus' => 'Occurrence status',
                'iddisposition' => 'Disposition',
                'idestablishmentmeans' => 'Establishment means',
                'idbehavior' => 'Behavior',
                'idreproductivecondition' => 'Reproductive condition',
                'idlifestage' => 'Life stage',
                'idsex' => 'Sex',
                'othercatalognumber' => 'Other catalog numbers'
        );
    }
}