<?php

class TaxonomicElementAR extends CActiveRecord {
    public $taxaRequired;
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'taxonomicelement';
    }
    public function rules() {
        return array(
                array('vernacularname','length','max'=>80),
                array('nomenclaturalstatus','length','max'=>60),
                //array('higherclassification', 'required'),
                array('taxaRequired', 'validarTaxaRequired'),                
        );
    }
    public function validarTaxaRequired() {
        if($this->idscientificname == null && $this->idspecificepithet == null && $this->idsubgenus == null && $this->idgenus == null && $this->idfamily == null && $this->idmorphospecies == null)
            $this->addError('taxaRequired','Please enter a value for a taxon more specific than Order or utilize a morphospecies.');
    }
    public function relations() {
        return array(
                'specimen' => array(self::HAS_MANY, 'SpecimenAR', 'idtaxonomicelement'),
                'monitoring' => array(self::HAS_MANY, 'MonitoringAR', 'idtaxonomicelement'),
                'species' => array(self::HAS_MANY, 'SpeciesAR', 'idtaxonomicelement'),
                'taxonomicstatus' => array(self::BELONGS_TO, 'TaxonomicStatusAR', 'idtaxonomicstatus'),
                'subgenus' => array(self::BELONGS_TO, 'SubgenusAR', 'idsubgenus'),
                'taxonconcept' => array(self::BELONGS_TO, 'TaxonConceptAR', 'idtaxonconcept'),
                'namepublishedin' => array(self::BELONGS_TO, 'NamePublishedInAR', 'idnamepublishedin'),
                'nameaccordingto' => array(self::BELONGS_TO, 'NameAccordingToAR', 'idnameaccordingto'),
                'originalnameusage' => array(self::BELONGS_TO, 'OriginalNameUsageAR', 'idoriginalnameusage'),
                'parentnameusage' => array(self::BELONGS_TO, 'ParentNameUsageAR', 'idparentnameusage'),
                'acceptednameusage' => array(self::BELONGS_TO, 'AcceptedNameUsageAR', 'idacceptednameusage'),
                'specificepithet' => array(self::BELONGS_TO, 'SpecificEpithetAR', 'idspecificepithet'),
                'scientificname' => array(self::BELONGS_TO, 'ScientificNameAR', 'idscientificname'),
                'phylum' => array(self::BELONGS_TO, 'PhylumAR', 'idphylum'),
                'order' => array(self::BELONGS_TO, 'OrderAR', 'idorder'),
                'nomenclaturalcode' => array(self::BELONGS_TO, 'NomenclaturalCodeAR', 'idnomenclaturalcode'),
                'kingdom' => array(self::BELONGS_TO, 'KingdomAR', 'idkingdom'),
                'taxonrank' => array(self::BELONGS_TO, 'TaxonRankAR', 'idtaxonrank'),
                'infraspecificepithet' => array(self::BELONGS_TO, 'InfraspecificEpithetAR', 'idinfraspecificepithet'),
                'genus' => array(self::BELONGS_TO, 'GenusAR', 'idgenus'),
                'family' => array(self::BELONGS_TO, 'FamilyAR', 'idfamily'),
                'class' => array(self::BELONGS_TO, 'ClassAR', 'idclass'),
                'scientificnameauthorship' => array(self::BELONGS_TO, 'ScientificNameAuthorshipAR', 'idscientificnameauthorship'),
                'referenceelement' => array(self::MANY_MANY, 'ReferenceAR', 'referencestaxonomic(idtaxonomicelements, idreferenceselements)'),
                'occurrenceelement' => array(self::MANY_MANY, 'OccurrenceElementAR', 'associatedtaxa(idtaxonomicelements, idoccurrenceelements)'),
                'morphospecies' => array(self::BELONGS_TO, 'MorphospeciesAR', 'idmorphospecies'),
                'tribe' => array(self::BELONGS_TO, 'TribeAR', 'idtribe'),
                'subtribe' => array(self::BELONGS_TO, 'SubtribeAR', 'idsubtribe'),
                'speciesname' => array(self::BELONGS_TO, 'SpeciesNameAR', 'idspeciesname'),
                'subspecies' => array(self::BELONGS_TO, 'SubspeciesAR', 'idsubspecies'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
                'idtaxonomicelements' => 'Idtaxonomicelements',
                'idscientificname' => 'Idscientificname',
                'idkingdom' => 'Idkingdom',
                'idphylum' => 'Idphylum',
                'idclass' => 'Idclass',
                'idorder' => 'Idorder',
                'idfamily' => 'Idfamily',
                'idgenus' => 'Idgenus',
                'idspecificepithet' => 'Idspecificepithet',
                'idinfraspecificepithet' => 'Idinfraspecificepithet',
                'idtaxonrank' => 'Idtaxonrank',
                'idscientificnameauthorship' => 'Idscientificnameauthorship',
                'idnomenclaturalcode' => 'Idnomenclaturalcode',
                'higherclassification' => 'Higherclassification',
                'verbatimtaxonrank' => 'Verbatim taxon rank',
                'vernacularname' => 'Vernacular name',
                'nomenclaturalstatus' => 'Nomenclatural status',
                'taxonremark' => 'Taxon remarks',
                'idacceptednameusage' => 'Idacceptednameusage',
                'idparentnameusage' => 'Idparentnameusage',
                'idoriginalnameusage' => 'Idoriginalnameusage',
                'idnameaccordingto' => 'Idnameaccordingto',
                'idnamepublishedin' => 'Idnamepublishedin',
                'idtaxonconcept' => 'Idtaxonconcept',
                'idsubgenus' => 'Idsubgenus',
                'idtaxonomicstatus' => 'Idtaxonomicstatus',
                'idmorphospecies' =>  'Idmorphospecies',
                'idtribe' =>  'Idtribe',
                'idsubtribe' =>  'Idsubtribe',
                'idspeciesname' =>  'Idspeciesname',
                'idsubspecies' =>  'Idsubspecies',
                
        );
    }
}

?>