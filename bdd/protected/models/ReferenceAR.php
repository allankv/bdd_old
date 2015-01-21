<?php
class ReferenceAR extends CActiveRecord {
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return 'referenceelement';
    }
    public function rules() {
        return array(
                array('title','length','max'=>100),
                array('subject','length','max'=>100),                
                array('title', 'required','message'=>'The field Title is required.'),
                
                //array('idtypereference', 'required','message'=>'The field Type is required.'),
                //array('idsubtypereference', 'required','message'=>'The field Subtype is required.'),
                //array('idcategoryreference', 'required','message'=>'The field Category is required.'),
                //array('subject', 'required','message'=>'The field Subject is required.'),
        );
    }
    public function relations() {
        return array(
                //'specimen' => array(self::MANY_MANY, 'SpecimenAR', 'specimenreference(idspecimen, idreference)'),
                //'typereference' => array(self::BELONGS_TO, 'TypeReferenceAR', 'idtypereference'),
                'subtypereference' => array(self::BELONGS_TO, 'SubtypeReferenceAR', 'idsubtypereference'),
                //'subcategoryreference' => array(self::BELONGS_TO, 'SubcategoryReferenceAR', 'idsubcategoryreference'),
                //'categoryreference' => array(self::BELONGS_TO, 'CategoryReferenceAR', 'idcategoryreference'),
                'language' => array(self::BELONGS_TO, 'LanguageAR', 'idlanguage'),
                'creator' => array(self::MANY_MANY, 'CreatorAR', 'referencecreator(idreferenceelement, idcreator)', 'joinType' => 'INNER JOIN'),
                'keyword' => array(self::MANY_MANY, 'KeywordAR', 'referencekeyword(idreferenceelement, idkeyword)', 'joinType' => 'INNER JOIN'),
                'biome' => array(self::MANY_MANY, 'BiomeAR', 'referencebiome(idreferenceelement, idbiome)', 'joinType' => 'INNER JOIN'),
                'plantspecies' => array(self::MANY_MANY, 'PlantSpeciesAR', 'referenceplantspecies(idreferenceelement, idplantspecies)', 'joinType' => 'INNER JOIN'),
                'plantfamily' => array(self::MANY_MANY, 'PlantFamilyAR', 'referenceplantfamily(idreferenceelement, idplantfamily)', 'joinType' => 'INNER JOIN'),
                'plantcommonname' => array(self::MANY_MANY, 'PlantCommonNameAR', 'referenceplantcommonname(idreferenceelement, idplantcommonname)', 'joinType' => 'INNER JOIN'),
                'pollinatorspecies' => array(self::MANY_MANY, 'PollinatorSpeciesAR', 'referencepollinatorspecies(idreferenceelement, idpollinatorspecies)', 'joinType' => 'INNER JOIN'),
                'pollinatorfamily' => array(self::MANY_MANY, 'PollinatorFamilyAR', 'referencepollinatorfamily(idreferenceelement, idpollinatorfamily)', 'joinType' => 'INNER JOIN'),
                'pollinatorcommonname' => array(self::MANY_MANY, 'PollinatorCommonNameAR', 'referencepollinatorcommonname(idreferenceelement, idpollinatorcommonname)', 'joinType' => 'INNER JOIN'),
                'afiliation' => array(self::MANY_MANY, 'AfiliationAR', 'referenceafiliation(idreferenceelement, idafiliation)', 'joinType' => 'INNER JOIN'),
                'fileformat' => array(self::BELONGS_TO, 'FileFormatAR', 'idfileformat'),
                'file'=>array(self::BELONGS_TO, 'FileAR', 'idfile'),
                'publisher' => array(self::BELONGS_TO, 'PublisherAR', 'idpublisher'),
                'source' => array(self::BELONGS_TO, 'SourceAR', 'idsource'),
         		'groups' => array(self::BELONGS_TO, 'groups', 'idgroup'),
        );
    }
    public function attributeLabels() {
        return array(
                'idreferenceelement' => 'Idreferenceelement',
                'idaccrualmethod' => 'Idaccrualmethod',
                'idaccrualperiodicity' => 'Idaccrualperiodicity',
                'idaccrualpolicy' => 'Idaccrualpolicy',
                'idaudience' => 'Idaudience',
                'idcontributor' => 'Idcontributor',
                'idcreator' => 'Idcreator',
                'idkeyword' => 'Idkeyword',
                'idinstructionalmethod' => 'Idinstructionalmethod',
                'idlanguage' => 'Idlanguage',
                'idpublisher' => 'Idpublisher',
                'idtypereference' => 'Idtypereference',
                'title' => 'Title',
                'subject' => 'Subject',
                'description' => 'Description',
                'source' => 'Source',
                'relation' => 'Relation',
                'coverage' => 'Coverage',
                'rights' => 'Rights',
                'date' => 'Date digitized',
                'format' => 'Format',
                'identifier' => 'Identifier',
                'provenance' => 'Provenance',
                'rightsholder' => 'Rights holder',
                'accessrights' => 'Access rights',
                'bibliographiccitation' => 'Bibliographic citation',
                'idlicenses'=>'Idlicenses',
                'idfileformats'=>'Idfileformats',
                'available'=>'Date available',
                'modified'=>'Modified',
                'abstract'=>'Abstract',
                'created'=>'Created',
                'url'=>'URL',
                'rightsstatement'=>'Rights statement',
                'standard'=>'Standard',
                'extent'=>'Extent',
                'doi'=>'DOI',
                'isbnissn'=>'ISBN/ISSN',
                'datedigitized' => 'Date digitized',
                'publicationyear' => 'Publication year',
         		'idgroup' => 'idgroup',
        );
    }
}