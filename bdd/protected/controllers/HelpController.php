<?php

class HelpController extends CController
{
	public function actionIndex()
	{
                //Yii::app()->setLanguage(Yii::app()->user->sitelanguage);
                
                $helpfield = $_GET['helpfield'];

                /*references*/
                $tdwg = "TDWG Darwin Core Standard - http://rs.tdwg.org/dwc/index.htm";
                $dublin = "Dublin Core - http://dublincore.org";
                $mrtg = "MRTG XML Schema - http://www.keytonature.eu/wiki/MRTG";
                $plinian = "Plinian Core - http://pliniancore.org";
                $eol = "Encyclopedia of Life - http://www.eol.org";

                switch ($helpfield) {

                  /*Record-level elements*/

                  case 'type':{
                      $title = "Type";
                      $message = "The nature or genre of the resource. For Darwin Core, recommended best practice is to use the name of the class that defines the root of the record.";
                      $comment = 'Examples: "StillImage", "MovingImage", "Sound", "PhysicalObject", "Event". For discussion see http://code.google.com/p/darwincore/wiki/RecordLevelTerms';
                      $reference = $dublin;
                      break;
                      }
                  case 'basisofrecord':{
                      $title = "Basis of record";
                      $message = "The specific nature of the data record - a subtype of the dcterms:type. Recommended best practice is to use a controlled vocabulary such as the Darwin Core Type Vocabulary (http://rs.tdwg.org/dwc/terms/type-vocabulary/index.htm).";
                      $comment = 'Examples: "PreservedSpecimen", FossilSpecimen", LivingSpecimen", "HumanObservation", "MachineObservation". For discussion see http://code.google.com/p/darwincore/wiki/RecordLevelTerms';
                      $reference = $tdwg;
                      break;
                      }
                  case 'institutioncode':{
                      $title = "Institution code";
                      $message = "The name (or acronym) in use by the institution having custody of the object(s) or information referred to in the record.";
                      $comment = 'Examples: "MVZ", "FMNH", "AKN-CLO", "University of California Museum of Paleontology (UCMP)". For discussion see http://code.google.com/p/darwincore/wiki/RecordLevelTerms';
                      $reference = $tdwg;
                      break;
                      }
                  case 'ownerinstitution':{
                      $title = "Owner institution code";
                      $message = "The name (or acronym) in use by the institution having ownership of the object(s) or information referred to in the record.";
                      $comment = 'Examples: "NPS", "APN", "InBio". For discussion see http://code.google.com/p/darwincore/wiki/RecordLevelTerms';
                      $reference = $tdwg;
                      break;
                      }
                  case 'collectioncode':{
                      $title = "Collection code";
                      $message = "The name, acronym, coden, or initialism identifying the collection or data set from which the record was derived.";
                      $comment = 'Examples: "Mammals", "Hildebrandt", "eBird". For discussion see http://code.google.com/p/darwincore/wiki/RecordLevelTerms';
                      $reference = $tdwg;
                      break;
                      }
                  case 'dataset':{
                      $title = "Dataset";
                      $message = "An identifier for the set of data. May be a global unique identifier or an identifier specific to a collection or institution.";
                      $comment = 'For discussion see http://code.google.com/p/darwincore/wiki/RecordLevelTerms';
                      $reference = $tdgw;
                      break;
                      }
                  case 'eventdate':{
                      $title = "Event date";
                      $message = "The date in which an Event occurred. For occurrences, this is the date when the event was recorded. Not suitable for a time in a geological context.";
                      $comment = 'For discussion see http://code.google.com/p/darwincore/wiki/Event';
                      $reference = $tdwg;
                      break;
                      }
                  case 'rights':{
                      $title = "Rights";
                      $message = "Information about rights held in and over the resource. Typically, rights information includes a statement about various property rights associated with the resource, including intellectual property rights.";
                      $comment = 'Example: "Content licensed under Creative Commons Attribution 3.0 United States License". For discussion see http://code.google.com/p/darwincore/wiki/RecordLevelTerms';
                      $reference = $dublin;
                      break;
                      }
                  case 'rightsholder':{
                      $title = "Rights holder";
                      $message = "A person or organization owning or managing rights over the resource.";
                      $comment = 'Example: "The Regents of the University of California.". For discussion see http://code.google.com/p/darwincore/wiki/RecordLevelTerms';
                      $reference = $dublin;
                      break;
                      }
                  case 'accessrights':{
                      $title = "Access rights";
                      $message = "Information about who can access the resource or an indication of its security status. Access Rights may include information regarding access or restrictions based on privacy, security, or other policies.";
                      $comment = 'Example: "not-for-profit use only". For discussion see http://code.google.com/p/darwincore/wiki/RecordLevelTerms';
                      $reference = $dublin;
                      break;
                      }
                  case 'bibliographiccitation':{
                      $title = "Bibliographic citation";
                      $message = "A bibliographic reference for the resource as a statement indicating how this record should be cited (attributed) when used. Recommended practice is to include sufficient bibliographic detail to identify the resource as unambiguously as possible.";
                      $comment = 'Examples: "Ctenomys sociabilis (MVZ 165861)" for a specimen, "Oliver P. Pearson. 1985. Los tuco-tucos (genera Ctenomys) de los Parques Nacionales Lanin y Nahuel Huapi, Argentina Historia Natural, 5(37):337-343." for a Taxon. For discussion see http://code.google.com/p/darwincore/wiki/RecordLevelTerms';
                      $reference = $dublin;
                      break;
                      }
                  case 'informationwithheld':{
                      $title = "Information withheld";
                      $message = "Additional information that exists, but that has not been shared in the given record.";
                      $comment = 'Examples: "location information not given for endangered species", "collector identities withheld", "ask about tissue samples". For discussion see http://code.google.com/p/darwincore/wiki/RecordLevelTerms';
                      $reference = $tdwg;
                      break;
                      }
                  case 'datageneralization':{
                      $title = "Data generalizations";
                      $message = "Actions taken to make the shared data less specific or complete than in its original form. Suggests that alternative data of higher quality may be available on request.";
                      $comment = 'Example: "Coordinates generalized from original GPS coordinates to the nearest half degree grid cell". For discussion see http://code.google.com/p/darwincore/wiki/RecordLevelTerms';
                      $reference = $tdwg;
                      break;
                      }
                  case 'dynamicproperty':{
                      $title = "Dynamic properties";
                      $message = "A list (concatenated and separated) of additional measurements, facts, characteristics, or assertions about the record. Meant to provide a mechanism for structured content such as key-value pairs.";
                      $comment = 'Examples: "tragusLengthInMeters=0.014; weightInGrams=120", "heightInMeters=1.5", "natureOfID=expert identification; identificationEvidence=cytochrome B sequence", "relativeHumidity=28; airTemperatureInC=22; sampleSizeInKilograms=10", "aspectHeading=277; slopeInDegrees=6", "iucnStatus=vulnerable; taxonDistribution=Neuquen, Argentina". For discussion see http://code.google.com/p/darwincore/wiki/RecordLevelTerms';
                      $reference = $tdwg;
                      break;
                      }

                  /*Occurrence elements*/
                  case 'occurrencedetail':{
                      $title = "Occurrence details";
                      $message = "A reference (publication, URI) to the most detailed information available about the Occurrence.";
                      $comment = 'Example: "http://mvzarctos.berkeley.edu/guid/MVZ:Mamm:165861". For discussion see http://code.google.com/p/darwincore/wiki/Occurrence';
                      $reference = $tdwg;
                      break;
                      }
                  case 'preparation':{
                      $title = "Preparations";
                      $message = "A list (concatenated and separated) of preparations and preservation methods for a specimen.";
                      $comment = 'Examples: "skin; skull; skeleton", "whole animal (ETOH); tissue (EDTA)", "fossil", "cast", "photograph", "DNA extract". For discussion see http://code.google.com/p/darwincore/wiki/Occurrence';
                      $reference = $tdwg;
                      break;
                      }
                  case 'othercatalognumber':{
                      $title = "Other catalog numbers";
                      $message = "A list (concatenated and separated) of previous or alternate fully qualified catalog numbers or other human-used identifiers for the same Occurrence, whether in the current or any other data set or collection.";
                      $comment = 'Example: "FMNH:Mammal:1234", "NPS YELLO6778; MBG 33424". For discussion see http://code.google.com/p/darwincore/wiki/Occurrence';
                      $reference = $tdwg;
                      break;
                      }
                  case 'recordedby':{
                      $title = "Recorded by";
                      $message = "A list (concatenated and separated) of names of people, groups, or organizations responsible for recording the original Occurrence. The primary collector or observer, especially one who applies a personal identifier (recordNumber), should be listed first.";
                      $comment = 'Example: "Oliver P. Pearson; Anita K. Pearson" where the value in recordNumber "OPP 7101" corresponds to the number for the specimen in the field catalog (collector number) of Oliver P. Pearson. For discussion see http://code.google.com/p/darwincore/wiki/Occurrence';
                      $reference = $tdwg;
                      break;
                      }
                  case 'individual':{
                      $title = "Individual";
                      $message = "An identifier for an individual or named group of individual organisms represented in the Occurrence. Meant to accommodate resampling of the same individual or group for monitoring purposes. May be a global unique identifier or an identifier specific to a data set.";
                      $comment = 'Examples: "U.amer. 44", "Smedley", "Orca J 23". For discussion see http://code.google.com/p/darwincore/wiki/Occurrence';
                      $reference = $tdwg;
                      break;
                      }

                  case 'occurrenceremark':{
                      $title = "Occurrence remarks";
                      $message = "Comments or notes about the Occurrence.";
                      $comment = 'Example: "found dead on road". For discussion see http://code.google.com/p/darwincore/wiki/Occurrence';
                      $reference = $tdwg;
                      break;
                      }
                  case 'occurrencestatus':{
                      $title = "Occurrence status";
                      $message = "A statement about the presence or absence of a Taxon at a Location.";
                      $comment = 'Examples: "present", "absent". For discussion see http://code.google.com/p/darwincore/wiki/Occurrence';
                      $reference = $tdwg;
                      break;
                      }
                  case 'sex':{
                      $title = "Sex";
                      $message = "The sex of the biological individual(s) represented in the Occurrence.";
                      $comment = 'Examples: "female", "hermaphrodite". For discussion see http://code.google.com/p/darwincore/wiki/Occurrence';
                      $reference = $tdwg;
                      break;
                      }
                  case 'disposition':{
                      $title = "Disposition";
                      $message = "The current state of a specimen with respect to the collection identified in collectionCode or collectionID.";
                      $comment = 'Examples: "in collection", "missing", "voucher elsewhere", "duplicates elsewhere". For discussion see http://code.google.com/p/darwincore/wiki/Occurrence';
                      $reference = $tdwg;
                      break;
                      }
                  case 'establishmentmean':{
                      $title = "Establishment means";
                      $message = "The process by which the biological individual(s) represented in the Occurrence became established at the location.";
                      $comment = 'Examples: "cultivated", "invasive", "escaped from captivity", "wild", "native". For discussion see http://code.google.com/p/darwincore/wiki/Occurrence';
                      $reference = $tdwg;
                      break;
                      }
                  case 'behavior':{
                      $title = "Behavior";
                      $message = "A description of the behavior shown by the subject at the time the Occurrence was recorded.";
                      $comment = 'Examples: "roosting", "foraging", "running". For discussion see http://code.google.com/p/darwincore/wiki/Occurrence';
                      $reference = $tdwg;
                      break;
                      }
                  case 'reproductivecondition':{
                      $title = "Reproductive condition";
                      $message = "The reproductive condition of the biological individual(s) represented in the Occurrence.";
                      $comment = 'Examples" "non-reproductive", "pregnant", "in bloom", "fruit-bearing". For discussion see http://code.google.com/p/darwincore/wiki/Occurrence';
                      $reference = $tdwg;
                      break;
                      }
                  case 'lifestage':{
                      $title = "Life stage";
                      $message = "The age class or life stage of the biological individual(s) at the time the Occurrence was recorded.";
                      $comment = 'Examples: "egg", "eft", "juvenile", "adult". For discussion see http://code.google.com/p/darwincore/wiki/Occurrence';
                      $reference = $tdwg;
                      break;
                      }

                  /*Curatorial elements*/
                  case 'catalognumber':{
                      $title = "Catalog number";
                      $message = "An identifier (preferably unique) for the record within the data set or collection.";
                      $comment = 'Examples: "2008.1334", "145732a", "145732". For discussion see http://code.google.com/p/darwincore/wiki/Occurrence';
                      $reference = $tdwg;
                      break;
                      }
                  case 'recordnumber':{
                      $title = "Record number";
                      $message = "An identifier given to the Occurrence at the time it was recorded. Often serves as a link between field notes and an Occurrence record, such as a specimen collector's number.";
                      $comment = 'Example: "OPP 7101". For discussion see http://code.google.com/p/darwincore/wiki/Occurrence';
                      $reference = $tdwg;
                      break;
                      }
                  case 'fieldnumber':{
                      $title = "Field number";
                      $message = "An identifier given to the event in the field. Often serves as a link between field notes and the Event.";
                      $comment = 'Example: "RV Sol 87-03-08". For discussion see http://code.google.com/p/darwincore/wiki/Event';
                      $reference = $tdwg;
                      break;
                      }
                  case 'individualcount':{
                      $title = "Individual count";
                      $message = "The number of individuals represented present at the time of the Occurrence.";
                      $comment = 'Examples: "1", "25". For discussion see http://code.google.com/p/darwincore/wiki/Occurrence';
                      $reference = $tdwg;
                      break;
                      }
                  case 'fieldnote':{
                      $title = "Field notes";
                      $message = "One of a) an indicator of the existence of, b) a reference to (publication, URI), or c) the text of notes taken in the field about the Event.";
                      $comment = 'Example: "notes available in Grinnell-Miller Library". For discussion see http://code.google.com/p/darwincore/wiki/Event';
                      $reference = $tdwg;
                      break;
                      }
                  case 'verbatimeventdate':{
                      $title = "Verbatim event date";
                      $message = "The verbatim original representation of the date and time information for an Event.";
                      $comment = 'Examples: "spring 1910", "Marzo 2002", "1999-03-XX", "17IV1934". For discussion see http://code.google.com/p/darwincore/wiki/Event';
                      $reference = $tdwg;
                      break;
                      }
                  case 'verbatimelevation':{
                      $title = "Verbatim elevation";
                      $message = "The original description of the elevation (altitude, usually above sea level) of the Location.";
                      $comment = 'Example: "100-200 m". For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }
                  case 'verbatimdepth':{
                      $title = "Verbatim depth";
                      $message = "The original description of the depth below the local surface.";
                      $comment = 'Example: "100-200 m". For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }
                  case 'typestatus':{
                      $title = "Type status";
                      $message = "A list (concatenated and separated) of nomenclatural types (type status, typified scientific name, publication) applied to the subject.";
                      $comment = 'Example: "holotype of Ctenomys sociabilis. Pearson O. P., and M. I. Christie. 1985. Historia Natural, 5(37):388". For discussion see http://code.google.com/p/darwincore/wiki/Identification';
                      $reference = $tdwg;
                      break;
                      }
                  case 'associatedsequence':{
                      $title = "Associated sequences";
                      $message = "A list (concatenated and separated) of identifiers (publication, global unique identifier, URI) of genetic sequence information associated with the Occurrence.";
                      $comment = 'Example: "GenBank: U34853.1". For discussion see http://code.google.com/p/darwincore/wiki/Occurrence';
                      $reference = $tdwg;
                      break;
                      }
                  /*case 'disposition':{
                      $title = "Disposition";
                      $message = "The current state of a specimen with respect to the collection identified in collectionCode or collectionID.";
                      $comment = 'Examples: "in collection", "missing", "voucher elsewhere", "duplicates elsewhere". For discussion see http://code.google.com/p/darwincore/wiki/Occurrence';
                      $reference = $tdwg;
                      break;
                      }*/ /*ja tem igual em Occurrence*/
                  case 'dateidentified':{
                      $title = "Date identified";
                      $message = "The date on which the subject was identified as representing the Taxon. Recommended best practice is to use an encoding scheme, such as ISO 8601:2004(E).";
                      $comment = 'Examples: "1963-03-08T14:07-0600" is 8 Mar 1963 2:07pm in the time zone six hours earlier than UTC, "2009-02-20T08:40Z" is 20 Feb 2009 8:40am UTC, "1809-02-12" is 12 Feb 1809, "1906-06" is Jun 1906, "1971" is just that year, "2007-03-01T13:00:00Z/2008-05-11T15:30:00Z" is the interval between 1 Mar 2007 1pm UTC and 11 May 2008 3:30pm UTC, "2007-11-13/15" is the interval between 13 Nov 2007 and 15 Nov 2007. For discussion see http://code.google.com/p/darwincore/wiki/Identification';
                      $reference = $tdwg;
                      break;
                      }


                  /**Taxonomic elements**/
                      
                  case 'kingdom':{
                      $title = "Kingdom";
                      $message = "The full scientific name of the kingdom in which the taxon is classified.";
                      $comment = 'Example: "Animalia", "Plantae". For discussion see http://code.google.com/p/darwincore/wiki/Taxon';
                      $reference = $tdwg;
                      break;
                      }
                  case 'phylum':{
                      $title = "Phylum";
                      $message = "The full scientific name of the phylum or division in which the taxon is classified.";
                      $comment = 'Example: "Chordata" (phylum), "Bryophyta" (division). For discussion see http://code.google.com/p/darwincore/wiki/Taxon';
                      $reference = $tdwg;
                      break;
                      }
                  case 'class':{
                      $title = "Class";
                      $message = "The full scientific name of the class in which the taxon is classified.";
                      $comment = 'Example: "Mammalia", "Hepaticopsida". For discussion see http://code.google.com/p/darwincore/wiki/Taxon';
                      $reference = $tdwg;
                      break;
                      }
                  case 'order':{
                      $title = "Order";
                      $message = "The full scientific name of the order in which the taxon is classified.";
                      $comment = 'Example: "Carnivora", "Monocleales". For discussion see http://code.google.com/p/darwincore/wiki/Taxon';
                      $reference = $tdwg;
                      break;
                      }
                  case 'family':{
                      $title = "Family";
                      $message = "The full scientific name of the family in which the taxon is classified.";
                      $comment = 'Example: "Felidae", "Monocleaceae". For discussion see http://code.google.com/p/darwincore/wiki/Taxon';
                      $reference = $tdwg;
                      break;
                      }
                  case 'genus':{
                      $title = "Genus";
                      $message = "The full scientific name of the genus in which the taxon is classified.";
                      $comment = 'Example: "Puma", "Monoclea". For discussion see http://code.google.com/p/darwincore/wiki/Taxon';
                      $reference = $tdwg;
                      break;
                      }
                  case 'subgenus':{
                      $title = "Subgenus";
                      $message = "The full scientific name of the subgenus in which the taxon is classified. Values should include the genus to avoid homonym confusion.";
                      $comment = 'Example: "Strobus (Pinus)", "Puma (Puma)" "Loligo (Amerigo)", "Hieracium subgen. Pilosella". For discussion see http://code.google.com/p/darwincore/wiki/Taxon';
                      $reference = $tdwg;
                      break;
                      }

                  case 'specificepithet':{
                      $title = "Specific epithet";
                      $message = 'The name of the first or species epithet of the scientific name.';
                      $comment = 'Example: "concolor", "gottschei". For discussion see http://code.google.com/p/darwincore/wiki/Taxon';
                      $reference = $tdwg;
                      break;
                      }
                  case 'infraspecificepithet':{
                      $title = "Infraspecific epithet";
                      $message = 'The name of the lowest or terminal infraspecific epithet of the scientificName, excluding any rank designation.';
                      $comment = 'Example: "concolor", "oxyadenia", "sayi". For discussion see http://code.google.com/p/darwincore/wiki/Taxon';
                      $reference = $tdwg;
                      break;
                      }
                  case 'scientificname':{
                      $title = "Scientific name";
                      $message = "The full scientific name, with authorship and date information if known. When forming part of an Identification, this should be the name in lowest level taxonomic rank that can be determined. This term should not contain identification qualifications, which should instead be supplied in the IdentificationQualifier term.";
                      $comment = 'Examples: "Coleoptera" (order), "Vespertilionidae" (family), "Manis" (genus), "Ctenomys sociabilis" (genus + specificEpithet), "Ambystoma tigrinum diaboli" (genus + specificEpithet + infraspecificEpithet), "Roptrocerus typographi (Györfi, 1952)" (genus + specificEpithet + scientificNameAuthorship), "Quercus agrifolia var. oxyadenia (Torr.) J.T. Howell" (genus + specificEpithet + taxonRank + infraspecificEpithet + scientificNameAuthorship). For discussion see http://code.google.com/p/darwincore/wiki/Taxon';
                      $reference = $tdwg;
                      break;
                      }
                  case 'taxonrank':{
                      $title = "Taxon rank";
                      $message = "The taxonomic rank of the most specific name in the scientific name.";
                      $comment = 'Examples: "subspecies", "varietas", "forma", "species", "genus". For discussion see http://code.google.com/p/darwincore/wiki/Taxon';
                      $reference = $tdwg;
                      break;
                      }
                  case 'scientificnameauthorship':{
                      $title = "Scientific name authorship";
                      $message = "The authorship information for the scientificName formatted according to the conventions of the applicable nomenclaturalCode.";
                      $comment = 'Example: "(Torr.) J.T. Howell", "(Martinovský) Tzvelev", "(Györfi, 1952)". For discussion see http://code.google.com/p/darwincore/wiki/Taxon';
                      $reference = $tdwg;
                      break;
                      }
                  
                  /*
                  case 'authoryearscientname':{
                      $title = "Author year scient. name";
                      $message = "the author of the scientificname and the year of publication, if known. More than one author can be listed in a concatenated string. Should be formatted with parentheses and year according to the conventions of the applicable nomenclatural code.";
                      $comment = "";
                      break;
                      }
                  */
                      
                  case 'nomenclaturalcode':{
                      $title = "Nomenclatural code";
                      $message = "The nomenclatural code (or codes in the case of an ambiregnal name) under which the scientificName is constructed.";
                      $comment = 'Examples: "ICBN", "ICZN", "BC", "ICNCP", "BioCode", "ICZN; ICBN". For discussion see http://code.google.com/p/darwincore/wiki/Taxon';
                      $reference = $tdwg;
                      break;
                      }

                  case 'acceptednameusage':{
                      $title = "Accepted name usage";
                      $message = "The full name, with authorship and date information if known, of the currently valid (zoological) or accepted (botanical) taxon.";
                      $comment = 'Example: "Tamias minimus" valid name for "Eutamias minimus". For discussion see http://code.google.com/p/darwincore/wiki/Taxon';
                      $reference = $tdwg;
                      break;
                      }
                  case 'parentnameusage':{
                      $title = "Parent name usage";
                      $message = "The full name, with authorship and date information if known, of the direct, most proximate higher-rank parent taxon (in a classification) of the most specific element of the scientific name.";
                      $comment = 'Examples: "Rubiaceae", "Gruiformes", "Testudinae". For discussion see http://code.google.com/p/darwincore/wiki/Taxon';
                      $reference = $tdwg;
                      break;
                      }
                  case 'originalnameusage':{
                      $title = "Original name usage";
                      $message = "The taxon name, with authorship and date information if known, as it originally appeared when first established under the rules of the associated nomenclaturalCode. The basionym (botany) or basonym (bacteriology) of the scientificName or the senior/earlier homonym for replaced names.";
                      $comment = 'Example: "Pinus abies", "Gasterosteus saltatrix Linnaeus 1768". For discussion see http://code.google.com/p/darwincore/wiki/Taxon';
                      $reference = $tdwg;
                      break;
                      }
                  case 'nameaccordingto':{
                      $title = "Name according to";
                      $message = 'The reference to the source in which the specific taxon concept circumscription is defined or implied - traditionally signified by the Latin "sensu" or "sec." (from secundum, meaning "according to"). For taxa that result from identifications, a reference to the keys, monographs, experts and other sources should be given.';
                      $comment = 'Example: "McCranie, J. R., D. B. Wake, and L. D. Wilson. 1996. The taxonomic status of Bolitoglossa schmidti, with comments on the biology of the Mesoamerican salamander Bolitoglossa dofleini (Caudata: Plethodontidae). Carib. J. Sci. 32:395-398.", "Werner Greuter 2008", "Lilljeborg 1861, Upsala Univ. Arsskrift, Math. Naturvet., pp. 4, 5". For discussion see http://code.google.com/p/darwincore/wiki/Taxon';
                      $reference = $tdwg;
                      break;
                      }
                  case 'namepublishedin':{
                      $title = "Name published in";
                      $message = "A reference for the publication in which the scientificName was originally established under the rules of the associated nomenclaturalCode.";
                      $comment = 'Examples: "Pearson O. P., and M. I. Christie. 1985. Historia Natural, 5(37):388", "Forel, Auguste, Diagnosies provisoires de quelques espèces nouvelles de fourmis de Madagascar, récoltées par M. Grandidier., Annales de la Societe Entomologique de Belgique, Comptes-rendus des Seances 30, 1886". For discussion see http://code.google.com/p/darwincore/wiki/Taxon';
                      $reference = $tdwg;
                      break;
                      }
                  case 'taxonconcept':{
                      $title = "Taxon concept";
                      $message = "An identifier for the taxonomic concept to which the record refers - not for the nomenclatural details of a taxon.";
                      $comment = 'Example: "8fa58e08-08de-4ac1-b69c-1235340b7001". For discussion see http://code.google.com/p/darwincore/wiki/Taxon';
                      $reference = $tdwg;
                      break;
                      }
                  case 'nomenclaturalstatus':{
                      $title = "Nomenclatural status";
                      $message = "The status related to the original publication of the name and its conformance to the relevant rules of nomenclature. It is based essentially on an algorithm according to the business rules of the code. It requires no taxonomic opinion.";
                      $comment = 'Examples: "nom. ambig.", "nom. illeg.", "nom. subnud.". For discussion see http://code.google.com/p/darwincore/wiki/Taxon';
                      $reference = $tdwg;
                      break;
                      }
                  case 'vernacularname':{
                      $title = "Venacular name";
                      $message = "A common or vernacular name.";
                      $comment = 'Example: "Andean Condor", "Condor Andino", "American Eagle", "Gänsegeier". For discussion see http://code.google.com/p/darwincore/wiki/Taxon';
                      $reference = $tdwg;
                      break;
                      }
                  case 'verbatimtaxonrank':{
                      $title = "Verbatim taxon rank";
                      $message = "The taxonomic rank of the most specific name in the scientificName as it appears in the original record.";
                      $comment = 'Examples: "Agamospecies", "sub-lesus", "prole", "apomict", "nothogrex", "sp.", "subsp.", "var.". For discussion see http://code.google.com/p/darwincore/wiki/Taxon';
                      $reference = $tdwg;
                      break;
                      }
                  case 'taxonomicstatus':{
                      $title = "Taxonomic status";
                      $message = "The status of the use of the scientificName as a label for a taxon. Requires taxonomic opinion to define the scope of a taxon. Rules of priority then are used to define the taxonomic status of the nomenclature contained in that scope, combined with the experts opinion. It must be linked to a specific taxonomic reference that defines the concept.";
                      $comment = 'Example: "invalid", "misapplied", "homotypic synonym", "accepted". For discussion see http://code.google.com/p/darwincore/wiki/Taxon';
                      $reference = $tdwg;
                      break;
                      }
                  case 'taxonremark':{
                      $title = "Taxon remarks";
                      $message = "Comments or notes about the taxon or name.";
                      $comment = 'Example: "this name is a misspelling in common use". For discussion see http://code.google.com/p/darwincore/wiki/Taxon';
                      $reference = $tdwg;
                      break;
                      }
                  case 'taxonname':{
                      $title = "Taxon name";
                      $message = "A scientific biological name. An object that represents a single scientific biological name that either is governed by or appears to be governed by one of the biological codes of nomenclature.";
                      $comment = '';
                      $reference = $tdwg;
                      break;
                  }

                  /**Identification qualifier**/
                  case 'identificationqualifier':{
                      $title = "Identification qualif.";
                      $message = "A brief phrase or a standard term ('cf.', 'aff.') to express the determiner's doubts about the Identification.";
                      $comment = 'Examples: 1) For the determination "Quercus aff. agrifolia var. oxyadenia", identificationQualifier would be "aff. agrifolia var. oxyadenia" with accompanying values "Quercus" in genus, "agrifolia" in specificEpithet, "oxyadenia" in infraspecificEpithet, and "var." in rank. 2) For the determination "Quercus agrifolia cf. var. oxyadenia", identificationQualifier would be "cf. var. oxyadenia " with accompanying values "Quercus" in genus, "agrifolia" in specificEpithet, "oxyadenia" in infraspecificEpithet, and "var." in rank. For discussion see http://code.google.com/p/darwincore/wiki/Identification';
                      $reference = $tdwg;
                      break;
                      }
                  case 'identificationremark':{
                      $title = "Identification remarks";
                      $message = "Comments or notes about the Identification.";
                      $comment = 'Example: "Distinguished between Anthus correndera and Anthus hellmayri based on the comparative lengths of the uñas.". For discussion see http://code.google.com/p/darwincore/wiki/Identification';
                      $reference = $tdwg;
                      break;
                      }
                  case 'identifiedby':{
                      $title = "Identified by";
                      $message = "A list (concatenated and separated) of names of people, groups, or organizations who assigned the Taxon to the subject.";
                      $comment = 'Example: "James L. Patton", "Theodore Pappenfuss; Robert Macey". For discussion see http://code.google.com/p/darwincore/wiki/Identification';
                      $reference = $tdwg;
                      break;
                      }

                  /*Event elements*/
                  case 'samplingprotocol':{
                      $title = "Sampling protocol";
                      $message = "The name of, reference to, or description of the method or protocol used during an Event.";
                      $comment = 'Examples: "UV light trap", "mist net", "bottom trawl", "ad hoc observation", "point count", "Penguins from space: faecal stains reveal the location of emperor penguin colonies, http://dx.doi.org/10.1111/j.1466-8238.2009.00467.x", "Takats et al. 2001. Guidelines for Nocturnal Owl Monitoring in North America. Beaverhill Bird Observatory and Bird Studies Canada, Edmonton, Alberta. 32 pp.", "http://www.bsc-eoc.org/download/Owl.pdf". For discussion see http://code.google.com/p/darwincore/wiki/Event';
                      $reference = $tdwg;
                      break;
                      }
                  case 'samplingeffort':{
                      $title = "Sampling effort";
                      $message = "The amount of effort expended during an Event.";
                      $comment = 'Example: "40 trap-nights", "10 observer-hours; 10 km by foot; 30 km by car". For discussion see http://code.google.com/p/darwincore/wiki/Event';
                      $reference = $tdwg;
                      break;
                      }
                  case 'eventtime':{
                      $title = "Event time";
                      $message = "The time in which an Event occurred.";
                      $comment = 'For discussion see http://code.google.com/p/darwincore/wiki/Event';
                      $reference = $tdwg;
                      break;
                      }
                  case 'eventremark':{
                      $title = "Event remarks";
                      $message = "Comments or notes about the Event.";
                      $comment = 'Example: "after the recent rains the river is nearly at flood stage". For discussion see http://code.google.com/p/darwincore/wiki/Event';
                      $reference = $tdwg;
                      break;
                      }

                  /**Locality elements**/

                  case 'municipality':{
                      $title = "Municipality";
                      $message = "The full, unabbreviated name of the next smaller administrative region than county (city, municipality, etc.) in which the Location occurs. Do not use this term for a nearby named place that does not contain the actual location.";
                      $comment = 'Examples: "Holzminden". For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }

                  case 'locality':{
                      $title = "Locality";
                      $message = "The specific description of the place. Less specific geographic information can be provided in other geographic terms (higherGeography, continent, country, stateProvince, county, municipality, waterBody, island, islandGroup). This term may contain information modified from the original to correct perceived errors or standardize the description.";
                      $comment = 'Example: "Bariloche, 25 km NNE via Ruta Nacional 40 (=Ruta 237)". For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }
                  case 'highergeography':{
                      $title = "Higher geography";
                      $message = "A list (concatenated and separated) of geographic names less specific than the information captured in the locality term.";
                      $comment = 'Example: "South America; Argentina; Patagonia; Parque Nacional Nahuel Huapi; Neuquén; Los Lagos" with accompanying values "South America" in Continent, "Argentina" in Country, "Neuquén" in StateProvince, and Los Lagos in County. For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }
                  case 'waterbody':{
                      $title = "Water body";
                      $message = "The name of the water body in which the Location occurs.";
                      $comment = 'Example: "Indian Ocean", "Baltic Sea". For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }
                  case 'islandgroup':{
                      $title = "Island group";
                      $message = "The name of the island group in which the Location occurs.";
                      $comment = 'Example: "Alexander Archipelago". For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }
                  case 'island':{
                      $title = "Island";
                      $message = "The name of the island on or near which the Location occurs.";
                      $comment = 'Example: "Isla Victoria". For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }
                  case 'county':{
                      $title = "County";
                      $message = "The full, unabbreviated name of the next smaller administrative region than stateProvince (county, shire, department, etc.) in which the Location occurs.";
                      $comment = 'Examples: "Missoula", "Los Lagos", "Mataró". For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }
                  case 'stateorprovince':{
                      $title = "State or province";
                      $message = "The name of the next smaller administrative region than country (state, province, canton, department, region, etc.) in which the Location occurs.";
                      $comment = 'Examples: "Montana", "Minas Gerais", "Córdoba". For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }
                  case 'country':{
                      $title = "Country";
                      $message = "The name of the country or major administrative unit in which the Location occurs. Recommended best practice is to use a controlled vocabulary such as the Getty Thesaurus of Geographic Names.";
                      $comment = 'Examples: "Denmark", "Colombia", "España". For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }
                  case 'continent':{
                      $title = "Continent";
                      $message = "The name of the continent in which the Location occurs.";
                      $comment = 'Example: "Antarctica". For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }
                  case 'georeferencedby':{
                      $title = "Georeferenced by";
                      $message = "A list (concatenated and separated) of names of people, groups, or organizations who determined the georeference (spatial representation) the Location.";
                      $comment = 'Example: "Kristina Yamamoto (MVZ); Janet Fang (MVZ)", "Brad Millen (ROM)". For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }
                  case 'lifeexpectancy':{
                      $title = "Life expectancy";
                      $message = "The expected longevity of the species.";
                      $comment = '';
                      $reference = $eol;
                      break;
                  }
                  case 'minimumelevationinmeters':{
                      $title = "Minimum elevation in meters";
                      $message = "The lower limit of the range of elevation (altitude, usually above sea level), in meters.";
                      $comment = 'Example: "100". For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }
                  case 'maximumelevationinmeters':{
                      $title = "Maximum elevation in meters";
                      $message = "The upper limit of the range of elevation (altitude, usually above sea level), in meters.";
                      $comment = 'Example: "200". For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }
                  case 'minimumdepthinmeters':{
                      $title = "Minimum depth in meters";
                      $message = "The lesser depth of a range of depth below the local surface, in meters.";
                      $comment = 'Example: "100". For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }
                  case 'maximumdepthinmeters':{
                      $title = "Maximum depth in meters";
                      $message = "The greater depth of a range of depth below the local surface, in meters.";
                      $comment = 'Example: "200". For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }
                  case 'minimumdistanceabovesurfaceinmeters':{
                      $title = "Minimum distance above surface in meters";
                      $message = "The lesser distance in a range of distance from a reference surface in the vertical direction, in meters. Use positive values for locations above the surface, negative values for locations below. If depth measures are given, the reference surface is the location given by the depth, otherwise the reference surface is the location given by the elevation.";
                      $comment = 'Example: 1.5 meter sediment core from the bottom of a lake (at depth 20m) at 300m elevation; VerbatimElevation: "300m" MinimumElevationInMeters: "300", MaximumElevationInMeters: "300", VerbatimDepth: "20m", MinumumDepthInMeters: "20", MaximumDepthInMeters: "20", DistanceAboveSurfaceInMetersMinimum: "0", DistanceAboveSurfaceInMetersMaximum: "-1.5". For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }
                  case 'maximumdistanceabovesurfaceinmeters':{
                      $title = "Maximum distance above surface in meters";
                      $message = "The greater distance in a range of distance from a reference surface in the vertical direction, in meters. Use positive values for locations above the surface, negative values for locations below. If depth measures are given, the reference surface is the location given by the depth, otherwise the reference surface is the location given by the elevation.";
                      $comment = 'Example: 1.5 meter sediment core from the bottom of a lake (at depth 20m) at 300m elevation; VerbatimElevation: "300m" MinimumElevationInMeters: "300", MaximumElevationInMeters: "300", VerbatimDepth: "20m", MinumumDepthInMeters: "20", MaximumDepthInMeters: "20", DistanceAboveSurfaceInMetersMinimum: "0", DistanceAboveSurfaceInMetersMaximum: "-1.5". For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }
                  case 'morphology':{
                      $title = "Morphology";
                      $message = "Description of the form and structure of the species and its specific structural features.";
                      $comment = '';
                      $reference = $eol;
                      break;
                  }
                  case 'locationaccordingto':{
                      $title = "Location according to";
                      $message = "Information about the source of this Location information. Could be a publication (gazetteer), institution, or team of individuals.";
                      $comment = 'Example: "Getty Thesaurus of Geographic Names", "GADM". For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }
                  case 'locationremark':{
                      $title = "Location remarks";
                      $message = "Comments or notes about the Location.";
                      $comment = 'Example: "under water since 2005". For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }
                  case 'size':{
                      $title = "Size";
                      $message = "The dimensions of the species (length, width, height, etc).";
                      $comment = '';
                      $reference = '';
                      break;
                  }
                  case 'verbatimlocality':{
                      $title = "Verbatim locality";
                      $message = "The original textual description of the place.";
                      $comment = 'Example: "25 km NNE Bariloche por R. Nac. 237". For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }
                  case 'coordinateprecision':{
                      $title = "Coordinate precision";
                      $message = "A decimal representation of the precision of the coordinates given in the decimalLatitude and decimalLongitude.";
                      $comment = 'Examples: "0.00001" (normal GPS limit for decimal degrees), "0.000278" (nearest second), "0.01667" (nearest minute), "1.0" (nearest degree). For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }
                  case 'footprintsrs':{
                      $title = "Footprint SRS";
                      $message = "A Well-Known Text (WKT) representation of the Spatial Reference System (SRS) for the footprintWKT of the Location. Do not use this term to describe the SRS of the decimalLatitude and decimalLongitude, even if it is the same as for the footprintWKT - use the geodeticDatum instead.";
                      $comment = 'Example: The WKT for the standard WGS84 SRS (EPSG:4326) is "GEOGCS["GCS_WGS_1984", DATUM["D_WGS_1984", SPHEROID["WGS_1984",6378137,298.257223563]], PRIMEM["Greenwich",0],UNIT["Degree",0.0174532925199433]]" without the enclosing quotes. For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }
                  case 'verbatimsrs':{
                      $title = "Verbatim SRS";
                      $message = "The ellipsoid, geodetic datum, or spatial reference system (SRS) upon which coordinates given in verbatimLatitude and verbatimLongitude, or verbatimCoordinates are based. Recommended best practice is use the EPSG code as a controlled vocabulary to provide an SRS, if known. Otherwise use a controlled vocabulary for the name or code of the geodetic datum, if known. Otherwise use a controlled vocabulary for the name or code of the ellipsoid, if known. If none of these is known, use the value 'unknown'.";
                      $comment = 'Examples: "EPSG:4326", "WGS84", "NAD27", "Campo Inchauspe", "European 1950", "Clarke 1866". For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }

                  /**Geospatial elements**/
                  
                  case 'decimallongitude':{
                      $title = "Decimal longitude";
                      $message = "The geographic longitude (in decimal degrees, using the spatial reference system given in geodeticDatum) of the geographic center of a Location. Positive values are east of the Greenwich Meridian, negative values are west of it. Legal values lie between -180 and 180, inclusive.";
                      $comment = 'Example: "-121.1761111". For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }
                  case 'decimallatitude':{
                      $title = "Decimal latitude";
                      $message = "The geographic latitude (in decimal degrees, using the spatial reference system given in geodeticDatum) of the geographic center of a Location. Positive values are north of the Equator, negative values are south of it. Legal values lie between -90 and 90, inclusive.";
                      $comment = 'Example: "-41.0983423". For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }
                  case 'coordinateuncertaintyinmeters':{
                      $title = "Coordinate uncertainty";
                      $message = "The horizontal distance (in meters) from the given decimalLatitude and decimalLongitude describing the smallest circle containing the whole of the Location. Leave the value empty if the uncertainty is unknown, cannot be estimated, or is not applicable (because there are no coordinates). Zero is not a valid value for this term.";
                      $comment = 'Example: "30" (reasonable lower limit of a GPS reading under good conditions if the actual precision was not recorded at the time), "71" (uncertainty for a UTM coordinate having 100 meter precision and a known spatial reference system). For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }
                  case 'geodeticdatum':{
                      $title = "Geodetic datum";
                      $message = "The ellipsoid, geodetic datum, or spatial reference system (SRS) upon which the geographic coordinates given in decimalLatitude and decimalLongitude as based. Recommended best practice is use the EPSG code as a controlled vocabulary to provide an SRS, if known. Otherwise use a controlled vocabulary for the name or code of the geodetic datum, if known. Otherwise use a controlled vocabulary for the name or code of the ellipsoid, if known. If none of these is known, use the value 'unknown'.";
                      $comment = 'Examples: "EPSG:4326", "WGS84", "NAD27", "Campo Inchauspe", "European 1950", "Clarke 1866". For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }
                  case 'pointradiusspatialfit':{
                      $title = "Point radius spatial fit";
                      $message = "The ratio of the area of the point-radius (decimalLatitude, decimalLongitude, coordinateUncertaintyInMeters) to the area of the true (original, or most specific) spatial representation of the Location. Legal values are 0, greater than or equal to 1, or undefined. A value of 1 is an exact match or 100% overlap. A value of 0 should be used if the given point-radius does not completely contain the original representation. The pointRadiusSpatialFit is undefined (and should be left blank) if the original representation is a point without uncertainty and the given georeference is not that same point (without uncertainty). If both the original and the given georeference are the same point, the pointRadiusSpatialFit is 1.";
                      $comment = 'Detailed explanations with graphical examples can be found in the "Guide to Best Practices for Georeferencing", Chapman and Wieczorek, eds. 2006 (http://www.gbif.org/prog/digit/Georeferencing). For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }
                  case 'verbatimcoordinate':{
                      $title = "Verbatim coordinates";
                      $message = "The verbatim original spatial coordinates of the Location. The coordinate ellipsoid, geodeticDatum, or full Spatial Reference System (SRS) for these coordinates should be stored in verbatimSRS and the coordinate system should be stored in verbatimCoordinateSystem.";
                      $comment = 'Examples: "41 05 54S 121 05 34W", "17T 630000 4833400". For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }
                  case 'verbatimlatitude':{
                      $title = "Verbatim latitude";
                      $message = "The verbatim original latitude of the Location. The coordinate ellipsoid, geodeticDatum, or full Spatial Reference System (SRS) for these coordinates should be stored in verbatimSRS and the coordinate system should be stored in verbatimCoordinateSystem.";
                      $comment = 'Example: "41 05 54.03S". For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }
                  case 'verbatimlongitude':{
                      $title = "Verbatim longitude";
                      $message = "The verbatim original longitude of the Location. The coordinate ellipsoid, geodeticDatum, or full Spatial Reference System (SRS) for these coordinates should be stored in verbatimSRS and the coordinate system should be stored in verbatimCoordinateSystem.";
                      $comment = 'Example: "121d 10\' 34" W". For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }
                  case 'verbatimcoordinatesystem':{
                      $title = "Verbatim coordinate system";
                      $message = "The spatial coordinate system for the verbatimLatitude and verbatimLongitude or the verbatimCoordinates of the Location.";
                      $comment = 'Examples: "decimal degrees", "degrees decimal minutes", "degrees minutes seconds", "UTM". For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }
                  case 'georeferenceprotocol':{
                      $title = "Georeference protocol";
                      $message = "A description or reference to the methods used to determine the spatial footprint, coordinates, and uncertainties.";
                      $comment = 'Examples: "Guide to Best Practices for Georeferencing" (Chapman and Wieczorek, eds. 2006), Global Biodiversity Information Facility.", "MaNIS/HerpNet/ORNIS Georeferencing Guidelines", "BioGeomancer". For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }
                  case 'georeferencesource':{
                      $title = "Georeference sources";
                      $message = "A list (concatenated and separated) of maps, gazetteers, or other resources used to georeference the Location, described specifically enough to allow anyone in the future to use the same resources.";
                      $comment = 'Examples: "USGS 1:24000 Florence Montana Quad; Terrametrics 2008 on Google Earth". For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }
                  case 'georeferenceverificationstatus':{
                      $title = "Verification status";
                      $message = "A categorical description of the extent to which the georeference has been verified to represent the best possible spatial description.";
                      $comment = 'Examples: "requires verification", "verified by collector", "verified by curator". For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }
                  case 'georeferenceremark':{
                      $title = "Georeference remarks";
                      $message = "Notes or comments about the spatial description determination, explaining assumptions made in addition or opposition to the those formalized in the method referred to in georeferenceProtocol.";
                      $comment = 'Example: "assumed distance by road (Hwy. 101)". For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }
                  case 'footprintwkt':{
                      $title = "Footprint WKT";
                      $message = "A Well-Known Text (WKT) representation of the shape (footprint, geometry) that defines the Location. A Location may have both a point-radius representation (see decimalLatitude) and a footprint representation, and they may differ from each other.";
                      $comment = 'Example: the one-degree bounding box with opposite corners at (longitude=10, latitude=20) and (longitude=11, latitude=21) would be expressed in well-known text as POLYGON ((10 20, 11 20, 11 21, 10 21, 10 20)). For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }
                  case 'footprintspatialfit':{
                      $title = "Footprint spatial fit";
                      $message = "The ratio of the area of the footprint (footprintWKT) to the area of the true (original, or most specific) spatial representation of the Location. Legal values are 0, greater than or equal to 1, or undefined. A value of 1 is an exact match or 100% overlap. A value of 0 should be used if the given footprint does not completely contain the original representation. The footprintSpatialFit is undefined (and should be left blank) if the original representation is a point and the given georeference is not that same point. If both the original and the given georeference are the same point, the footprintSpatialFit is 1.";
                      $comment = 'Detailed explanations with graphical examples can be found in the "Guide to Best Practices for Georeferencing", Chapman and Wieczorek, eds. 2006 (http://www.gbif.org/prog/digit/Georeferencing). For discussion see http://code.google.com/p/darwincore/wiki/Location';
                      $reference = $tdwg;
                      break;
                      }


                  /**New Reference Elements**/
                  case 'accrualmethod':{
                      $title = "Accrual method";
                      $message = "The method by which items are added to a collection.";
                      $comment = '';
                      $reference = $dublin;
                      break;
                      }
                  case 'authoryearofscientificname':{
                      $title = "Author Year of Scientific Name";
                      $message = "Author and year of Scientific name publication.";
                      $comment = '';
                      $reference = $tdwg;
                      break;
                  }
                  case 'accrualperiodicity':{
                      $title = "Accrual periodicity";
                      $message = "The frequency with which items are added to a collection.";
                      $comment = '';
                      $reference = $dublin;
                      break;
                      }
                  case 'accrualpolicy':{
                      $title = "Accrual policy";
                      $message = "The policy governing the addition of items to a collection.";
                      $comment = '';
                      $reference = $dublin;
                      break;
                      }
                  case 'audience':{
                      $title = "Audience";
                      $message = "A class of entity for whom the resource is intended or useful.";
                      $comment = '';
                      $reference = $dublin;
                      break;
                      }
                  case 'benefits':{
                      $title = "Benefits";
                      $message = "The economic importance of the species for humans.";
                      $comment = '';
                      $reference = $eol;
                      break;
                  }
                  case 'briefdescription':{
                      $title = "Brief Description";
                      $message = "Brief description, presented in a simple technical language, to distinguish the species from other close or similar ones.";
                      $comment = '';
                      $reference = $plinian;
                      break;
                  }
                  case 'comprehensivedescription':{
                      $title = "Comprehensive Description";
                      $message = "Description of the species including the relevant details (living, behavior, etc).";
                      $comment = '';
                      $reference = '';
                      break;
                  }
                  case 'conservationstatus':{
                      $title = "Conservation Status";
                      $message = "Indicates whether the group is still extant (that is, members of it are still alive) and if yes, how likely the group is to become extinct in the near future.";
                      $comment = '';
                      $reference = 'International Union for Conservation of Nature - http://www.iucn.org';
                      break;
                  }
                  case 'contributor':{
                      $title = "Contributors";
                      $message = "An entity responsible for making contributions to the resource.";
                      $comment = 'Examples of a Contributor include a person, an organization, or a service. Typically, the name of a Contributor should be used to indicate the entity.';
                      $reference = $dublin;
                      break;
                      }
                  case 'creator':{
                      $title = "Creator";
                      $message = "An entity primarily responsible for making the resource.";
                      $comment = 'Examples of a Creator include a person, an organization, or a service. Typically, the name of a Creator should be used to indicate the entity.';
                      $reference = $dublin;
                      break;
                      }
                  case 'datecreated':{
                      $title = "Date Created";
                      $message = "Date/time when the intellectual content (project, term, description, etc.) was created.";
                      $comment = '';
                      $reference = $dublin;
                      break;
                  }
                  case 'datelastmodified':{
                      $title = "Date Last Modified";
                      $message = "Date/time when the last modification of the object was made.";
                      $comment = '';
                      $reference = $dublin;
                      break;
                  }
                  case 'distribution':{
                      $title = "Distribution";
                      $message = "Comment about the distribution of the species based on information from the collection sites of the studied specimens.";
                      $comment = '';
                      $reference = $plinian;
                      break;
                  }
                  case 'ecologicalsignificance':{
                      $title = "Ecological Significance";
                      $message = "The role of the species in its environment.";
                      $comment = '';
                      $reference = '';
                      break;
                  }
                  case 'endemicity':{
                      $title = "Endemicity";
                      $message = "Endemicity describes species that are native to a particular geographic area or continent. Endemicity usually occurs in areas that are isolated in some way.";
                      $comment = '';
                      $reference = $plinian;
                      break;
                  }
                  case 'feeding':{
                      $title = "Feeding";
                      $message = "Information related to supply food for the development and sustenance of the individual and/or its offspring.";
                      $comment = '';
                      $reference = $plinian;
                      break;
                  }
                  case 'folklore':{
                      $title = "Folklore";
                      $message = "Known myths or legends that people or literature contribute about the species.";
                      $comment = '';
                      $reference = $plinian;
                      break;
                  }
                  case 'habit':{
                      $title = "Habit";
                      $message = "Specific behavioral characteristics and instinctive actions.";
                      $comment = '';
                      $reference = '';
                      break;
                  }
                  case 'habitat':{
                      $title = "Habitat";
                      $message = "General description of the sites where the species is found (ecosystem, forest, environment or microhabitat).";
                      $comment = '';
                      $reference = $plinian;
                      break;
                  }
                  case 'interactions':{
                      $title = "Interactions";
                      $message = "Mutual or reciprocal actions or influences. For example, predation, parasitism, mutualism, etc. Relations with products grown and stored by man (plagues) are also included.";
                      $comment = '';
                      $reference = $plinian;
                      break;
                  }
                  case 'instructionalmethod':{
                      $title = "Instructional method";
                      $message = "A process, used to engender knowledge, attitudes and skills, that the described resource is designed to support.";
                      $comment = 'Instructional Method will typically include ways of presenting instructional materials or conducting instructional activities, patterns of learner-to-learner and learner-to-instructor interactions, and mechanisms by which group and individual levels of learning are measured. Instructional methods include all aspects of the instruction and learning processes from planning and implementation through evaluation and feedback.';
                      $reference = $dublin;
                      break;
                      }
                  case 'language':{
                      $title = "Language";
                      $message = "A language of the resource.";
                      $comment = 'Recommended best practice is to use a controlled vocabulary such as RFC 4646 [RFC4646].';
                      $reference = $dublin;
                      break;
                      }
                  case 'legislation':{
                      $title = "Legislation";
                      $message = "A national or regional proposed law or group of laws.";
                      $comment = '';
                      $reference = $plinian;
                      break;
                      }
                  case 'lifecycle':{
                      $title = "Life Cycle";
                      $message = "Life history of a living organism: The course of developmental changes in an organism from fertilized zygote to maturity or stages through which an organism passes.";
                      $comment = '';
                      $reference = $plinian;
                      break;
                  }
                  case 'lsid':{
                      $title = "LSID";
                      $message = "Life Science Identifiers is a unique identifier for some data, and the LSID protocol specifies a standard way to locate the data.";
                      $comment = 'An LSID is represented as a Uniform Resource Name (URN).';
                      $reference = '';
                      break;
                  }
                  case 'management':{
                      $title = "Management";
                      $message = "Breeding and cultivation Control.";
                      $comment = '';
                      $reference = $plinian;
                      break;
                  }
                  case 'moleculardata':{
                      $title = "Molecular Data";
                      $message = "Information about molecular taxonomy obtained from the author or the literature.";
                      $comment = '';
                      $reference = $plinian;
                      break;
                  }
                  case 'otherinformationsources':{
                      $title = "Other Information Sources";
                      $message = "Any other information source of interest, recommended by kind of user (recommended literatures, URL).";
                      $comment = '';
                      $reference = $plinian;
                      break;
                  }
                  case 'populationbiology':{
                      $title = "Population Biology";
                      $message = "Information about the number of individuals per area or time unit.";
                      $comment = '';
                      $reference = $plinian;
                      break;
                  }
                  case 'publisher':{
                      $title = "Publisher";
                      $message = "An entity responsible for making the resource available.";
                      $comment = 'Examples of a Publisher include a person, an organization, or a service. Typically, the name of a Publisher should be used to indicate the entity.';
                      $reference = $dublin;
                      break;
                      }
                  case 'reproduction':{
                      $title = "Reproduction";
                      $message = "Data about reproduction of the species in wildlife or in captivity.";
                      $comment = '';
                      $reference = $plinian;
                      break;
                  }
                  case 'relatedname':{
                      $title = "Related Name";
                      $message = 'Alternative taxonomic opinions about the valid names of the "parents" and "children" taxa of the species.';
                      $comment = '';
                      $reference = $eol;
                      break;
                  }
                  case 'scientificdescription':{
                      $title = "Scientific Description";
                      $message = "Description to distinguish the species from other close or similar ones.";
                      $comment = '';
                      $reference = $plinian;
                      break;
                  }
                  case 'synonym':{
                      $title = "Synonyms";
                      $message = "Different names for this taxon.";
                      $comment = "This concept is a placeholder field.";
                      $reference = $plinian;
                      break;
                  }
                  case 'targetaudiences':{
                      $title = "Target Audience";
                      $message = "Users to which the information is addressed. The defined audiences are: Biodiversity researchers, teachers and students, decision makers, professionals from another areas and general public.";
                      $comment = '';
                      $reference = $plinian;
                      break;
                  }
                  case 'territory':{
                      $title = "Territory";
                      $message = "Information associated mostly to vertebrates, referring to the territorial extension of the individual or group in terms of its activities (feeding, mating, etc).";
                      $comment = '';
                      $reference = $plinian;
                      break;
                  }
                  case 'title':{
                      $title = "Title";
                      $message = "A name given to the resource.";
                      $comment = '';
                      $reference = $dublin;
                      break;
                      }
                  case 'threatstatus':{
                      $title = "Threat status";
                      $message = "Conservation status.";
                      $comment = '';
                      $reference = $plinian;
                      break;
                  }
                  case 'typification':{
                      $title = "Typification";
                      $message = "Citation of type material according to TCS: http://www.tdwg.org/activities/tnc/tcs-schema-repository/";
                      $comment = '';
                      $reference = $plinian;
                      break;
                  }
                  case 'uses':{
                      $title = "Uses";
                      $message = "Known or potential uses of the species, at a direct economic level, as instruments of education, prospecting, eco-tourism, etc. It includes published material or suggestions from the author or others. In any event, the source must be explicitly quoted.";
                      $comment = '';
                      $reference = $plinian;
                      break;
                  }
                  case 'version':{
                      $title = "Version";
                      $message = "Information of the current version.";
                      $comment = '';
                      $reference = $plinian;
                      break;
                  }
                  case 'subject':{
                      $title = "Subject";
                      $message = "The topic of the resource.";
                      $comment = 'Typically, the subject will be represented using keywords, key phrases, or classification codes. To describe the spatial or temporal topic of the resource, use the Coverage element.';
                      $reference = $dublin;
                      break;
                      }
                  case 'description':{
                      $title = "Description";
                      $message = "An account of the resource.";
                      $comment = 'Description may include but is not limited to: an abstract, a table of contents, a graphical representation, or a free-text account of the resource.';
                      $reference = $dublin;
                      break;
                      }
                  case 'source':{
                      $title = "Source";
                      $message = "A related resource from which the described resource is derived.";
                      $comment = 'The described resource may be derived from the related resource in whole or in part. Recommended best practice is to identify the related resource by means of a string conforming to a formal identification system.';
                      $reference = $dublin;
                      break;
                      }
                  case 'relation':{
                      $title = "Relation";
                      $message = "A related resource.";
                      $comment = 'Recommended best practice is to identify the related resource by means of a string conforming to a formal identification system.';
                      $reference = $dublin;
                      break;
                      }
                  case 'coverage':{
                      $title = "Coverage";
                      $message = "The spatial or temporal topic of the resource, the spatial applicability of the resource, or the jurisdiction under which the resource is relevant.";
                      $comment = 'Spatial topic and spatial applicability may be a named place or a location specified by its geographic coordinates. Temporal topic may be a named period, date, or date range. A jurisdiction may be a named administrative entity or a geographic place to which the resource applies. Recommended best practice is to use a controlled vocabulary such as the Thesaurus of Geographic Names [TGN]. Where appropriate, named places or time periods can be used in preference to numeric identifiers such as sets of coordinates or date ranges.';
                      $reference = $dublin;
                      break;
                      }
                  case 'date':{
                      $title = "Date";
                      $message = "A point or period of time associated with an event in the lifecycle of the resource.";
                      $comment = 'Date may be used to express temporal information at any level of granularity. Recommended best practice is to use an encoding scheme, such as the W3CDTF profile of ISO 8601 [W3CDTF].';
                      $reference = $dublin;
                      break;
                      }
                  case 'format':{
                      $title = "Format";
                      $message = "The file format, physical medium, or dimensions of the resource.";
                      $comment = 'Examples of dimensions include size and duration. Recommended best practice is to use a controlled vocabulary such as the list of Internet Media Types [MIME].';
                      $reference = $dublin;
                      break;
                      }
                  case 'identifier':{
                      $title = "Identifier";
                      $message = "An unambiguous reference to the resource within a given context.";
                      $comment = 'Recommended best practice is to identify the resource by means of a string conforming to a formal identification system.';
                      $reference = $dublin;
                      break;
                      }
                  case 'provenance':{
                      $title = "Provenance";
                      $message = "A statement of any changes in ownership and custody of the resource since its creation that are significant for its authenticity, integrity, and interpretation.";
                      $comment = 'The statement may include a description of any changes successive custodians made to the resource.';
                      $reference = $dublin;
                      break;
                      }
                  case 'license':{
                      $title = "License";
                      $message = "A legal document giving official permission to do something with the resource.";
                      $comment = '';
                      $reference = $dublin;
                      break;
                      }
                  case 'fileformat':{
                      $title = "File format";
                      $message = "A digital resource format.";
                      $comment = 'Examples include the formats defined by the list of Internet Media Types.';
                      $reference = $dublin;
                      break;
                      }
                  case 'modified':{
                      $title = "Modified";
                      $message = "Date on which the resource was changed.";
                      $comment = '';
                      $reference = $dublin;
                      break;
                      }
                  case 'annual':{
                      $title = "Annual Cycle";
                      $message = "Recurrent biological phenomena correlated with climatic conditions, as bird migration or plant flowering.";
                      $comment = '';
                      $reference = $plinian;
                      break;
                  }
                  case 'abstract':{
                      $title = "Abstract";
                      $message = "General description of the taxon. This concept could point out any information about the taxon. Its main goal is summarize the most relevant or attractive characteristics of this taxon to the general public.";
                      $comment = '';
                      $reference = $plinian;
                      break;
                      }
                  case 'created':{
                      $title = "Created";
                      $message = "Date of creation of the resource.";
                      $comment = '';
                      $reference = $dublin;
                      break;
                      }
                  case 'URI':{
                      $title = "URI";
                      $message = "The set of identifiers constructed according to the generic syntax for Uniform Resource Identifiers as specified by the Internet Engineering Task Force.";
                      $comment = '';
                      $reference = $dublin;
                      break;
                      }
                  case 'rightsstatement':{
                      $title = "Rights statement";
                      $message = "A statement about the intellectual property rights (IPR) held in or over a Resource, a legal document giving official permission to do something with a resource, or a statement about access rights.";
                      $comment = '';
                      $reference = $dublin;
                      break;
                      }
                  case 'standard':{
                      $title = "Standard";
                      $message = "A basis for comparison; a reference point against which other things can be evaluated.";
                      $comment = '';
                      $reference = $dublin;
                      break;
                      }

                  /*New Media*/
                  case 'titlemedia':{
                      $title = "Title";
                      $message = "Concise title, name, or label of institution, resource collection, or individual resource. This field should include the complete title with all the subtitles, if any.";
                      $comment = 'The title facilitates interactions with humans: e.g. the title would be used as display text of hyperlinks or to provide a choice of images through pick list. The title is therefore highly desirable and an effort should be made to provide it where not already available. The taxon name(s) will form a good substitute title.';
                      $reference = $dublin;
                      break;
                      }
                  case 'caption':{
                      $title = "Caption";
                      $message = "As alternative or in addition to description, a caption is free-form text to be displayed together with (rather than instead of) a resource that is suitable for captions (especially images).";
                      $comment = 'Often only one of description or caption is present; choose the concept most appropriate for your metadata.';
                      $reference = $mrtg;
                      break;
                  }
                  case 'typemedia':{
                     $title = "Type";
                     $message = "Any dcmi type term from http://dublincore.org/documents/dcmi-type-vocabulary/  may be used. Recommended terms are Collection, StillImage, Sound, MovingImage, InteractiveResource, Text.";
                     $comment = 'A Collection should be given type http://purl.org/dc/dcmitype/Collection. If the resource is a Collection, this item does not identify what types of objects it may contain. Following the DC recommendations at http://purl.org/dc/dcmitype/Text, images of text should be marked as Text.';
                     $reference = $dublin;
                     break;
                  }
                  case 'subtype':{
                      $title = "Subtype";
                      $message = "Any of Drawing, Painting, Logo, Icon, Illustration, Graphic, Photograph, Animation, Film, SlideShow, DesignPlan, Diagram, Map, MusicalNotation, IdentificationKey, ScannedText, RecordedText, RecordedOrganism, TaxonPage, MultimediaLearningObject, VirtualRealityEnvironment, GlossaryPage. These values may either be used in their literal form, or with their full namespace";
                      $comment = 'This does not apply to Collection objects. The vocabulary may be extended by users provided they identify the term by a URI which is not in the mrtg namespace (for example, using "http://my.inst.org/namespace/metadata/subtype/repair-manual". Conforming applications may choose to ignore these.';
                      $reference = $mrtg;
                      break;
                  }
                  case 'typereference':{
                     $title = "Type";
                     $message = "Any dcmi type term from http://dublincore.org/documents/dcmi-type-vocabulary/  may be used. Recommended terms are Collection, StillImage, Sound, MovingImage, InteractiveResource, Text.";
                     $comment = 'A Collection should be given type http://purl.org/dc/dcmitype/Collection. If the resource is a Collection, this item does not identify what types of objects it may contain. Following the DC recommendations at http://purl.org/dc/dcmitype/Text, images of text should be marked as Text.';
                     $reference = $dublin;
                     break;
                  }
                  case 'subtypereference':{
                      $title = "Subtype";
                      $message = "Any of Drawing, Painting, Logo, Icon, Illustration, Graphic, Photograph, Animation, Film, SlideShow, DesignPlan, Diagram, Map, MusicalNotation, IdentificationKey, ScannedText, RecordedText, RecordedOrganism, TaxonPage, MultimediaLearningObject, VirtualRealityEnvironment, GlossaryPage. These values may either be used in their literal form, or with their full namespace";
                      $comment = 'This does not apply to Collection objects. The vocabulary may be extended by users provided they identify the term by a URI which is not in the mrtg namespace (for example, using "http://my.inst.org/namespace/metadata/subtype/repair-manual". Conforming applications may choose to ignore these.';
                      $reference = $mrtg;
                      break;
                  }
                  case 'categoryreference':{
                      $title = "Category";
                      $message = "Specification of 'subtype' field. Category of the content of the media in regards to the specimen it is related to. For organizational purposes.";
                      $comment = "A photograph of a detail in a specimen's wing could be categorized under 'wing' or 'front', in case it is a frontal picture. Use to organize media files in one collection.";
                      $reference = '';
                      break;
                  }
                  case 'subcategoryreference':{
                      $title = "Subcategory";
                      $message = "Specification of 'category' field. Subcategory of the content of the media in regards to the specimen it is related to. For organizational purposes.";
                      $comment = "Example: A front picture of a detail in a specimen's wing could be categorized under 'wing' and subcategorized under 'front'. Use to organize multiple media files in one collection.";
                      $reference = '';
                      break;
                  }
                  case 'extent':{
                      $title = "Extent";
                      $message = "The size, dimensions, or duration of the media resource.";
                      $comment = 'Best practices are: Extent as length/running time should use standard abbreviations of the metadata language (for English "20 s", "54 min"). Extent of images or video may be given as pixel size ("2000 x 1500 px"), or as file size (using kB, kByte, MB, MByte).';
                      $reference = $dublin;
                      break;
                  }
                  case 'language':{
                      $title = "Language";
                      $message = "Language(s) of resource itself represented in ISO639-1 or -3";
                      $comment = 'An image may contain language such as superimposed labels. If an image is of a natural scene or organism, without any language included, the resource is language-neutral (ISO code “zxx”). Resources with present but unknown language are to be coded as undetermined (ISO code “und”). Resources only containing scientific organism names should be coded as "zxx-x-taxon" (do not use the incorrect “la” for Latin). If there is no language code available, you must use the ISO extension mechanisms (x-XXX or XXXXXXX, CITE).';
                      $reference = $dublin;
                      break;
                  }
                  case 'dateavailable':{
                      $title = "Date available";
                      $message = "The date (often a range) that the resource became or will become available. The date and time must comply with the W3 datetime practice, which requires that date and time representation correspond to ISO 8601:1998, but with year fields always comprising 4 digits. This makes datetime records compliant with 8601:2004 MRTG datetime values may also follow 8601:2004 for ranges by separating two IS0 8601 datetime fields by a solidus (forward slash, '/'). See also the wikipedia IS0 8601 entry for further explanation and examples.";
                      $comment = '';
                      $reference = $dublin;
                      break;
                  }
                  case 'descriptionmedia':{
                      $title = "Description";
                      $message = "Description of collection or individual resource, containing the Who, What, When, Where and Why as free-form text.";
                      $comment = 'It optionally allows to present detailed information and will in most cases be shown together with the resource title. If both description and caption (see below) are present, a description is typically displayed instead of the resource. Should be a good proxy for the underlying media resource. Interpretation depends on type.';
                      $reference = $dublin;
                      break;
                  }
                  case 'tag':{
                      $title = "Tag";
                      $message = "General keywords or tags.";
                      $comment = 'Tags may be multi-worded phrases. Where scientific names, common names, geographic locations, etc. are separable, these should go into the more specific metadata items provided further below. Examples: "flower diagram". Character or part keywords like "leaf", "flower color" are especially desirable.';
                      $reference = $mrtg;
                      break;
                  }
                  case 'capturedevice':{
                      $title = "Capture device";
                      $message = "Free form text describing the device or devices used to create the resource.";
                      $comment = 'It is best practice to record the device; this may include a combination such as camera plus lens, or camera plus microscope. Examples: "Canon Supershot 2000", "Makroscan Scanner 2000", "Zeiss Axioscope with Camera IIIu", "SEM (Scanning Electron Microscope)".';
                      $reference = $mrtg;
                      break;
                  }
                  case 'creatormedia':{
                      $title = "Creator";
                      $message = "The person or organization responsible for creating the media resource";
                      $comment = 'The value may be simple text or a nested object representing the details of a CI_ResponsibleParty. Note that the Creator need not be the Copyright Owner';
                      $reference = $dublin;
                      break;
                  }
                  case 'publishedsource':{
                    $title = "Published source";
                    $message = "An identifiable source from which the described resources was derived. It may be digital, but in any case should be a source for which the originator intended long-term availability.";
                    $comment = 'If image, key, etc. was taken from (i.e. digitized) or was also published in a digital or printed publication. Do not put generally "related" publications in here. This field normally contains a free-form text description; it may be a URI: (“digitally-published://ISBN=961-90008-7-0”) if this resource is also described separately in the data exchange. Can be repeatedable if a montage of images.';
                    $reference = $dublin;
                    break;
                  }
                  case 'provider':{
                    $title = "Provider";
                    $message = "Person or organization responsible for compiling and presenting the record. FIXME: DEFINITION OF PROVIDER AND METADATA PROVIDER IS IDENTICAL";
                    $comment = '';
                    $reference = $mrtg;
                    break;
                  }
                  case 'metadataprovider':{
                        $title = "Metadata provider";
                        $message = "Person or organization responsible for compiling and presenting the record.";
                        $comment = '';
                        $reference = $mrtg;
                        break;
                  }
                  case 'datedigitized':{
                        $title = "Date digitized";
                        $message = "Date the first digital version was created, where different Date Original (e.g. where photographic prints have been scanned). The date and time must comply with the W3 datetime practice, which requires that date and time representation correspond to ISO 8601:1998, but with year fields always comprising 4 digits. This makes datetime records compliant with 8601:2004 MRTG datetime values may also follow 8601:2004 for ranges by separating two IS0 8601 datetime fields by a solidus ('forward slash', /). See also the wikipedia IS0 8601 entry for further explanation and examples.";
                        $comment = 'This is often not the file creation or modification date. Use the international (ISO/xml) format yyyy-mm-ddThh:mm (e. g. "2007-12-31" or "2007-12-31T14:59"). Where available, timezone information should be added. In the case of digital images containing EXIF, whereas the exif capture date does not contain time zone information, exif GPSDateStamp and GPSTimeStamp may be relevant as these include time-zone information. Compare also MWG (2008), which has best practice on handling time-zone-less EXIF date/time data.';
                        $reference = $mrtg; /*k2n, na real*/
                        break;
                  }
                  case 'timedigitized':{
                        $title = "Time digitized";
                        $message = "Time the first digital version was created, where different Time Original (e.g. where photographic prints have been scanned). The date and time must comply with the W3 datetime practice, which requires that date and time representation correspond to ISO 8601:1998, but with year fields always comprising 4 digits. This makes datetime records compliant with 8601:2004 MRTG datetime values may also follow 8601:2004 for ranges by separating two IS0 8601 datetime fields by a solidus ('forward slash', /). See also the wikipedia IS0 8601 entry for further explanation and examples.";
                        $comment = 'This is often not the file creation or modification date. Use the international (ISO/xml) format yyyy-mm-ddThh:mm (e. g. "2007-12-31" or "2007-12-31T14:59"). Where available, timezone information should be added. In the case of digital images containing EXIF, whereas the exif capture date does not contain time zone information, exif GPSDateStamp and GPSTimeStamp may be relevant as these include time-zone information. Compare also MWG (2008), which has best practice on handling time-zone-less EXIF date/time data.';
                        $reference = $mrtg; /*k2n, na real*/
                        break;
                  }
                  case 'copyrightowner':{
                        $title = "Copyright owner";
                        $message = "The name of the owner of the copyright. 'Unknown' is an acceptable value.";
                        $comment = '';
                        $reference = $mrtg; /*xmp, na real*/
                        break;
                  }
                  case 'copyrightstatement':{
                        $title = "Copyright statement";
                        $message = "Information about rights held in and over the resource. A full-text, readable copyright statement, as required by the national legislation of the copyright holder. On collections, this applies to all contained objects, unless the object itself has a different statement. Examples: “Copyright XY 2008, all rights reserved”, “© 2008 XY Museum” , 'Public Domain.' Do not place just the name of the copyright holder here!";
                        $comment = 'This expressed rights over resource, not over the metadata text.';
                        $reference = $dublin;
                        break;
                  }
                  case 'formatmedia':{
                        $title = "Format";
                        $message = "The technical format of the resource (file format or physical medium).";
                        $comment = 'Three types of values are acceptable: (a) any MIME type; (b) common file extensions like txt, doc, odf, jpg/jpeg, png, pdf; (c) the following special values: Data-CD, Audio-CD, Video-CD, Data-DVD, Audio-DVD, Video-DVD-PAL, Video-DVD-NTSC, photographic slide, photographic print.';
                        $reference = $dublin;
                        break;
                  }
                  case 'attributionlinkurl':{
                        $title = "Attribution link URL";
                        $message = "The URL where information about ownership, attribution, etc. of the resource may be found.";
                        $comment = 'This URL may be used in creating a clickable logo. Providers should consider making this link as specific and useful to consumers as possible, e.g., linking to a metadata page of the specific image resource rather than to a generic page describing the owner or provider of a resource.';
                        $reference = $mrtg;
                        break;
                  }
                  case 'attributionlogourl':{
                        $title = "Attribution logo URL";
                        $message = "The URL of icon or logo image to appear in source attribution.";
                        $comment = 'Entering this URL into a browser should only result in the icon (not in a webpage including the icon).';
                        $reference = $mrtg;
                        break;
                  }
                  case 'attributionstatement':{
                        $title = "Attribution statement";
                        $message = "Free text for 'please cite this as...'";
                        $comment = '';
                        $reference = $mrtg; /*Iptc4xmp, na real*/
                        break;
                  }
                  case 'accesspoint':{
                        $title = "Access point";
                        $message = "Reference to an instance of a class describing network access to the media resource, or related resources, that the metadata describes. What constitutes a class is dependent on the representation (i.e. XML Schema, RDF, etc.)";
                        $comment = 'Use with the properties below. In particular, there is little point to having an instance of this class without a value for the Access URL and perhaps the Format. Implementers in specific constraint languages such as XML Schema or OWL may wish to make those two properties mandatory on instances.';
                        $reference = $mrtg;
                        break;
                  }
                  case 'accessurl':{
                        $title = "Access URL";
                        $message = "URL of the resource itself";
                        $comment = 'For individual resources only. Use this field if only one quality level is available (as it is typical for taxon pages or keys!) Value might point to something offline, such as a published CD, etc.';
                        $reference = $mrtg;
                        break;
                  }
                  case 'comment':{
                        $title = "Comments";
                        $message = "Any comment provided on the subject featured in the media item.";
                        $comment = '';
                        $reference = $mrtg;
                        break;
                  }
                  case 'categoryreference':{
                        $title = "Category";
                        $message = "Specification of 'subtype' field. Category of the content of the reference in regards to the specimen it is related to. For organizational purposes.";
                        $comment = '';
                        break;
                  }
                  case 'subcategoryreference':{
                        $title = "Subcategory";
                        $message = "Specification of 'category' field. Subcategory of the content of the reference in regards to the specimen it is related to. For organizational purposes.";
                        $comment = '';
                        break;
                  }
                  case 'privaterecord':{
                        $title = "Private Records";
                        $message = "Check to search only for records marked as private.";
                        $comment = "Private records aren't published in the TAPIR provider, being only accessible in BDD.";
                        break;
                  }
                  case 'withfile':{
                        $title = "With File";
                        $message = "Check to search only for records with attached (associated) files.";
                        $comment = '';
                        break;
                  }
                  case 'filter':{
                        $title = "Search filter";
                        $message = "Use this to filter your search by Basis of Record, Institution Code, Collection Code, Catalog Number, Scientific Name, Taxonomic ranks, and Locality.";
                        $comment = '';
                        break;
                  }

                  /*Spreadsheetsync fields*/
                  case 'delete':{
                        $title = "Delete";
                        $message = "For use with BDD tool. Input 'yes' to delete the specimen record from the database. WARNING: do not simply delete the row in the sheet if you want the record to be erased from the virtual database.";
                        break;
                  }
                  case 'private':{
                        $title = "Private";
                        $message = "Input 'yes' if you wish to make this record private. This way, only people with access to the BDD will have access to this record; in other words, it will not be published publicly.";
                        $comment = "Private records aren't published in the TAPIR provider, being only accessible in BDD.";
                        break;
                  }
                  
                  /*Monitoring fields*/
                  case 'idgeral':{
                  		$title = "ID Geral";
                  		$message = "Identification number of the lines (specimens) from one to infinity.";
                  		$comment = 'Examples: "1", "2", "3", "4", ...';
	                  	break;
                  }
                  case 'collector':{
                  		$title = "Collector";
                  		$message = "Refers to the individual who collected the specimens directly from the Pan trap.";
                  		$comment = "";
	                  	break;
                  }
                  case 'digitizer':{
                  		$title = "Digitizer";
                  		$message = "Refers to the individual who registered the data on this website.";
                  		$comment = "";
	                  	break;
                  }
                  case 'culture':{
                  		$title = "Culture";
                  		$message = "Refers to the monitored culture.";
                  		$comment = 'Examples: "tomatoe", "eggplant", "carrot".';
	                  	break;
                  }
                  case 'cultivar':{
                  		$title = "Farm";
                  		$message = "Refers to the characteristics that define the farm. Denomination of the agricultural plant's type (ex.: Tomatoe Hib Sensus), agro-industrial logos (ex.: Agroceres).";
                  		$comment = 'If it is a transgenic farm, include "T" in the end of the description. Example: "Hib Sensus".';
	                  	break;
                  }
                  case 'surroundingsvegetation':{
                  		$title = "Surroundings vegetation";
                  		$message = "Type of the natural vegetation of the area based on pre-established standards.";
                  		$comment = 'Example: "Semideciduous forest".';
	                  	break;
                  }
                  case 'installationdate':{
                  		$title = "Installation date";
                  		$message = "Initial day's date of the Pan trap's performance.";
                  		$comment = 'Format: YYYY/MM/DD';
	                  	break;
                  }
                  case 'installationtime':{
                  		$title = "Installation time";
                  		$message = "Initial day's time of the Pan trap's performance.";
                  		$comment = 'Format: 24 hh:mm:ss';
	                  	break;
                  }
                  case 'collectdate':{
                  		$title = "Collect date";
                  		$message = "Final day's date of the Pan trap's performance.";
                  		$comment = 'Format: YYYY/MM/DD';
	                  	break;
                  }
                  case 'collecttime':{
                  		$title = "Collect time";
                  		$message = "Final day's time of the Pan trap's performance.";
                  		$comment = 'Format: 24 hh:mm:ss';
	                  	break;
                  }
                  case 'surroundingsculture':{
                  		$title = "Surroundings culture";
                  		$message = "Identify if the Pan trap is inserted into the culture or into its environment.";
                  		$comment = '';
	                  	break;
                  }
                  case 'plotnumber':{
                  		$title = "Plot number";
                  		$message = "Identification number of the plot.";
                  		$comment = '';
	                  	break;
                  }
                  case 'amostralnumber':{
                  		$title = "Amostral number";
                  		$message = "Identification number of the amostral number.";
                  		$comment = '';
	                  	break;
                  }
                  case 'supporttype':{
                  		$title = "Support type";
                  		$message = "Type of support used for the establishment of the Pan trap, as pre-established standards.";
                  		$comment = '';
	                  	break;
                  }
                  case 'weight':{
	                  $title = "Weight";
	                  $message = "Weight of the specimen in the specified unit.";
	                  $comment = '';
	                  break;
                  }
                  case 'height':{
	                  $title = "Height";
	                  $message = "Height of the specimen in the specified unit.";
	                  $comment = '';
	                  break;
                  }
                  case 'width':{
	                  $title = "Width";
	                  $message = "Width of the specimen in the specified unit.";
	                  $comment = '';
	                  break;
                  }
                  case 'length':{
	                  $title = "Length";
	                  $message = "Length of the specimen in the specified unit.";
	                  $comment = '';
	                  break;
                  }
                  case 'colorpantrap':{
	                  $title = "Pan trap color";
	                  $message = "Color of the Pan trap.";
	                  $comment = '';
	                  break;
                  }
                  case 'floorheight':{
	                  $title = "Height from the floor";
	                  $message = "Height from the floor in the specified unit.";
	                  $comment = '';
	                  break;
                  }
                  case 'predominantbiome':{
	                  $title = "Predominant biome";
	                  $message = "Predominant biome of the location where the Pan trap was placed.";
	                  $comment = '';
	                  break;
                  }
                  case 'technicalcollection':{
	                  $title = "Collection technique";
	                  $message = "Technique used in the sample's collection.";
	                  $comment = '';
	                  break;
                  }
                  /* Codigo para Help do Georeferencing tool... usando HTML no meio */
                  case 'geotool':{
                        $title = "Georeferencing tool";
                        $message = "This web-based resource allows the user, by means of an interactive three-dimensional map based on the Google Earth API - Application Programming Interface - to obtain the name of the country, state and city as well as the latitude, longitude and altitude of a location by clicking on its position on the map.";
                        $comment = 'System Requirements:
                            <p align="left">Google Earth Plug-in
                            <ul><li><a href="http://www.google.com/earth/explore/products/plugin.html" target="_blank" style="text-decoration:underline;">Click here to install the Google Earth Plug-in.</a></li></ul></p>

                            <p align="left">Operating Systems Supported
                            <ul><li>Microsoft Windows 2000</li>
                            <li>Microsoft Windows XP</li>
                            <li>Microsoft Windows Vista</li>
                            <li>Apple Mac OS X 10.4 and higher (Intel and PowerPC)</li></ul></p>

                            <p align="left">Browsers Supported
                            <ul><li>Google Chrome 1.0+</li>
                            <li>Internet Explorer 6+</li>
                            <li>Firefox 3.0+</li>
                            <li>Flock 1.0+</li>
                            <li>Safari 3.1+</li></ul></p>';
                        break;
                  }

                }
		$this->renderPartial('index', array(
                               'title' => $title,
                               'message'=>$message,
                               'comment'=>$comment,
                               'reference'=>$reference));
        }


	/*
	 * Controller method for set language session parameter
	 */
	public function actionSiteLanguage() {
		//$this->render('sitelanguage');
	}
}
