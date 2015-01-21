<?php
class SpeciesAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'species';
    }
    public function rules() {
        return array(
                array('idinstitutioncode', 'required','message'=>'The field Institution Code is required.'),
        );
    }
    public function relations() {
        return array(
                'institutioncode' => array(self::BELONGS_TO, 'InstitutionCodeAR', 'idinstitutioncode'),
                'language' => array(self::BELONGS_TO, 'LanguageAR', 'idlanguage'),
                'taxonomicelement' => array(self::BELONGS_TO, 'TaxonomicElementAR', 'idtaxonomicelement'),
                'reference' => array(self::MANY_MANY, 'ReferenceAR', 'speciesreference(idspecies, idreferenceelement)', 'joinType' => 'INNER JOIN'),
                'publicationreference' => array(self::MANY_MANY, 'ReferenceAR', 'speciespublicationreference(idspecies, idreferenceelement)', 'joinType' => 'INNER JOIN'),
                'paper' => array(self::MANY_MANY, 'ReferenceAR', 'speciespaper(idspecies, idreferenceelement)', 'joinType' => 'INNER JOIN'),
                //'identificationkey' => array(self::MANY_MANY, 'ReferenceAR', 'speciesidentificationkey(idspecies, idreferenceelement)', 'joinType' => 'INNER JOIN'),
                'media' => array(self::MANY_MANY, 'MediaAR', 'speciesmedia(idspecies, idmedia)', 'joinType' => 'INNER JOIN'),
                'creator' => array(self::MANY_MANY, 'CreatorAR', 'speciescreator(idspecies, idcreator)', 'joinType' => 'INNER JOIN'),
                'synonym' => array(self::MANY_MANY, 'SynonymAR', 'speciessynonym(idspecies, idsynonym)', 'joinType' => 'INNER JOIN'),
                'relatedname' => array(self::MANY_MANY, 'RelatedNameAR', 'speciesrelatedname(idspecies, idrelatedname)', 'joinType' => 'INNER JOIN'),
                'contributor' => array(self::MANY_MANY, 'ContributorAR', 'speciescontributor(idspecies, idcontributor)', 'joinType' => 'INNER JOIN'),
        		'groups' => array(self::BELONGS_TO, 'groups', 'idGroup'),
        );
    }
    public function attributeLabels() {
        return array(
            'abstract' => 'Abstract',
            'annualcycle' => 'Annual Cycle',
            'authoryearsofscientificname' => 'Author Year of Scientific Name',
            'behavior' => 'Behavior',
            'benefits' => 'Benefits',
            'briefdescription' => 'Brief Description',
            'chromosomicnumber' => 'Chromosomic Number',
            'comprehensivedescription' => 'Comprehensive Description',
            'conservationstatus' => 'Conservation Status',
            'datecreated' => 'Date Created',
            'datelastmodified' => 'Date Last Modified',
            'distribution' => 'Distribution',
            'ecologicalsignificance' => 'Ecological Significance',
            'endemicity' => 'Endemicity',
            'feeding' => 'Feeding',
            'folklore' => 'Folklore',
            'lsid' => 'LSID',
            'habit' => 'Habit',
            'habitat' => 'Habitat',
            'interactions' => 'Interactions',
            'invasivenessdata' => 'Invasiveness Data',
            'legislation' => 'Legislation',
            'lifecycle' => 'Life Cycle',
            'lifeexpectancy' => 'Life Expectancy',
            'management' => 'Management',
            'migratorydata' => 'Migratory Data',
            'moleculardata' => 'Molecular Data',
            'morphology' => 'Morphology',
            'occurrence' => 'Occurrence',
            'otherinformationsources' => 'Other Information Sources',
            'populationbiology' => 'Population Biology',
            'reproduction' => 'Reproduction',
            'scientificdescription' => 'Scientific Description',
            'size' => 'Size',
            'targetaudiences' => 'Target Audience',
            'territory' => 'Territory',
            'threatstatus' => 'Threat Status',
            'typification' => 'Typification',
            'unstructureddocumentation' => 'Unstructured Documentation',
            'unstructurednaturalhistory' => 'Unstructured Natural History',
            'uses' => 'Uses',
            'version' => 'Version',

        );
    }
}