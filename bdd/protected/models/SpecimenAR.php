<?php
class SpecimenAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'specimen';
    }
    public function rules() {
    }
    public function relations() {
        return array(
                'recordlevelelement' => array(self::BELONGS_TO, 'RecordLevelElementAR', 'idrecordlevelelement'),
                'eventelement' => array(self::BELONGS_TO, 'EventElementAR', 'ideventelement'),                
                'curatorialelement' => array(self::BELONGS_TO, 'CuratorialElementAR', 'idcuratorialelement'),
                'occurrenceelement' => array(self::BELONGS_TO, 'OccurrenceElementAR', 'idoccurrenceelement'),
                //'monitoring' => array(self::BELONGS_TO, 'MonitoringAR', 'idmonitoring'),
                'taxonomicelement' => array(self::BELONGS_TO, 'TaxonomicElementAR', 'idtaxonomicelement'),
                'localityelement' => array(self::BELONGS_TO, 'LocalityElementAR', 'idlocalityelement'),
                'identificationelement' => array(self::BELONGS_TO, 'IdentificationElementAR', 'ididentificationelement'),
                'geospatialelement' => array(self::BELONGS_TO, 'GeospatialElementAR', 'idgeospatialelement'),
                //'referenceselement' => array(self::MANY_MANY, 'referenceselementAR', 'referencerecordlevel(idreferenceselements, idrecordlevelelements)'),
                'media' => array(self::MANY_MANY, 'MediaAR', 'specimenmedia(idspecimen, idmedia)', 'joinType' => 'INNER JOIN'),
        		'groups' => array(self::BELONGS_TO, 'groups', 'idGroup'),
        );
    }
    public function attributeLabels() {
        return array(
            // So tem IDs, nao ira aparecer para o usuario
        );
    }
}