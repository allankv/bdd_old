<?php
class RecordLevelElementAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'recordlevelelement';
    }
    public function rules() {
        return array(
                array('idcollectioncode', 'required','message'=>'The field Collection code is required.'),
                array('idbasisofrecord', 'required','message'=>'The field Basis of record is required.'),
                array('idbasisofrecord', 'numerical', 'integerOnly'=>true),
                array('idcollectioncode', 'numerical', 'integerOnly'=>true),
                array('idinstitutioncode', 'numerical', 'integerOnly'=>true),
                array('idinstitutioncode', 'required','message'=>'The field Institution code is required.'),
                array('globaluniqueidentifier', 'unique'),
                array('idinstitutioncode', 'numerical', 'integerOnly'=>true),
                array('idlanguage', 'numerical', 'integerOnly'=>true),
                array('idownerinstitution', 'numerical', 'integerOnly'=>true),
                array('iddataset', 'numerical', 'integerOnly'=>true),
                array('idtype', 'numerical', 'integerOnly'=>true),
        );
    }
    public function relations() {
        return array(
                'specimen' => array(self::HAS_ONE, 'SpecimenAR', 'idrecordlevelelement'),
                'monitoring' => array(self::HAS_ONE, 'MonitoringAR', 'idrecordlevelelement'),
                'language' => array(self::BELONGS_TO, 'LanguageAR', 'idlanguage'),
                'type' => array(self::BELONGS_TO, 'TypeAR', 'idtype'),
                'ownerinstitution' => array(self::BELONGS_TO, 'OwnerInstitutionAR', 'idownerinstitution'),
                'dataset' => array(self::BELONGS_TO, 'DatasetAR', 'iddataset'),
                'institutioncode' => array(self::BELONGS_TO, 'InstitutionCodeAR', 'idinstitutioncode'),
                'collectioncode' => array(self::BELONGS_TO, 'CollectionCodeAR', 'idcollectioncode'),
                'basisofrecord' => array(self::BELONGS_TO, 'BasisOfRecordAR', 'idbasisofrecord'),
                'dynamicproperty' => array(self::MANY_MANY, 'DynamicPropertyAR', 'recordleveldynamicproperty(idrecordlevelelement, iddynamicproperty)')
                //'referenceselement' => array(self::MANY_MANY, 'referenceselements', 'referencerecordlevel(idreferenceselements, idrecordlevelelements)'),
                //'mediarecordlevel' => array(self::MANY_MANY, 'mediarecordlevel', 'mediarecordlevel(idmedia, idrecordlevelelements)', 'joinType' => 'INNER JOIN'),
        );
    }
    public function attributeLabels() {
        return array(
                'idrecordlevelelement' => 'Record level elements ID',
                'modified' => 'Modified',
                'idinstitutioncode' => 'Institution code ID',
                'idcollectioncode' => 'Collection code ID',
                'idbasisofrecord' => 'Basis of record ID',
                'informationwithheld' => 'Information withheld',
                'idownerinstitution' => 'Owner institution ID',
                'iddataset' => 'Dataset ID',
                'datageneralization' => 'Data Generalization',
                'globaluniqueidentifier' => 'Global unique identifier',
                'idtypes' => 'Type',
                'idlanguage' => 'Language',
                'rights' => 'Rights',
                'rightsholder' => 'Rights holder',
                'accessrights' => 'Access rights',
                'bibliographiccitation' => 'Bibliographic citation',
                'lending' => 'Lent record',
                'lendingwho' => "Lending's entity",
                'lendingdate' => "Lending's date",
        );
    }
}