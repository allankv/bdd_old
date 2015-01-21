<?php
ini_set('memory_limit', '2621M');
require_once 'resources/Classes/PHPExcel/Shared/ZipStreamWrapper.php';
include_once 'resources/Classes/PHPExcel/Shared/CodePage.php';
include_once 'resources/Classes/PHPExcel/Shared/OLE.php';
include_once 'resources/Classes/PHPExcel/Shared/Date.php';
include_once 'resources/Classes/PHPExcel/Shared/Drawing.php';
include_once 'resources/Classes/PHPExcel/Shared/Escher/DgContainer/SpgrContainer/SpContainer.php';
include_once 'resources/Classes/PHPExcel/Shared/Escher/DgContainer/SpgrContainer.php';
include_once 'resources/Classes/PHPExcel/Shared/Escher/DggContainer/BstoreContainer/BSE/Blip.php';
include_once 'resources/Classes/PHPExcel/Shared/Escher/DggContainer/BstoreContainer/BSE.php';
include_once 'resources/Classes/PHPExcel/Shared/Escher/DggContainer/BstoreContainer.php';
include_once 'resources/Classes/PHPExcel/Shared/Escher/DggContainer.php';
include_once 'resources/Classes/PHPExcel/Shared/Escher/DgContainer.php';
include_once 'resources/Classes/PHPExcel/Shared/Escher.php';
include_once 'resources/Classes/PHPExcel/Shared/Excel5.php';
include_once 'resources/Classes/PHPExcel/Shared/File.php';
include_once 'resources/Classes/PHPExcel/Shared/Font.php';
include_once 'resources/Classes/PHPExcel/Shared/PasswordHasher.php';
include_once 'resources/Classes/PHPExcel/Shared/OLERead.php';
include_once 'resources/Classes/PHPExcel/Shared/String.php';
//include_once 'resources/Classes/PHPExcel/Shared/XMLWriter.php';
include_once 'resources/Classes/PHPExcel/Shared/OLE/PPS.php';
include_once 'resources/Classes/PHPExcel/Shared/OLE/PPS/File.php';
include_once 'resources/Classes/PHPExcel/Shared/OLE/PPS/Root.php';
include_once 'resources/Classes/PHPExcel/Shared/OLE/ChainedBlockStream.php';
require_once 'resources/Classes/PHPExcel/IOFactory.php';
//$this->includeRecurse('resources/Classes/PHPExcel');
//$this->includeRecurse('resources/Classes/PHPExcel/CachedObjectStorage');
require_once 'resources/Classes/PHPExcel/Reader/IReadFilter.php';
require_once 'resources/Classes/PHPExcel/Reader/IReader.php';
require_once 'resources/Classes/PHPExcel/Reader/Excel5/Escher.php';
require_once 'resources/Classes/PHPExcel/Reader/Excel5.php';
require_once 'resources/Classes/PHPExcel/Reader/DefaultReadFilter.php';
require_once 'resources/Classes/PHPExcel/Reader/Excel2007.php';
require_once 'resources/Classes/PHPExcel/Reader/Excel2003XML.php';
require_once 'resources/Classes/PHPExcel/Reader/OOCalc.php';
require_once 'resources/Classes/PHPExcel/Reader/SYLK.php';
require_once 'resources/Classes/PHPExcel/Reader/Serialized.php';
require_once 'resources/Classes/PHPExcel/Reader/CSV.php';
require_once 'resources/Classes/PHPExcel/IComparable.php';
require_once 'resources/Classes/PHPExcel/Worksheet.php';
require_once 'resources/Classes/PHPExcel/ReferenceHelper.php';
require_once 'resources/Classes/PHPExcel/CachedObjectStorage/CacheBase.php';
require_once 'resources/Classes/PHPExcel/CachedObjectStorage/ICache.php';
require_once 'resources/Classes/PHPExcel/CachedObjectStorage/Memory.php';
require_once 'resources/Classes/PHPExcel/CachedObjectStorageFactory.php';
//include_once 'resources/Classes/PHPExcel/Worksheet/.php';
include_once 'resources/Classes/PHPExcel/Worksheet/HeaderFooter.php';
include_once 'resources/Classes/PHPExcel/Worksheet/PageMargins.php';
include_once 'resources/Classes/PHPExcel/Worksheet/PageSetup.php';
include_once 'resources/Classes/PHPExcel/Worksheet/Protection.php';
include_once 'resources/Classes/PHPExcel/Worksheet/RowDimension.php';
include_once 'resources/Classes/PHPExcel/Worksheet/ColumnDimension.php';
include_once 'resources/Classes/PHPExcel/Worksheet/SheetView.php';
include_once 'resources/Classes/PHPExcel/DocumentProperties.php';
include_once 'resources/Classes/PHPExcel/DocumentSecurity.php';
include_once 'resources/Classes/PHPExcel/Style/Font.php';
include_once 'resources/Classes/PHPExcel/Style/Fill.php';
include_once 'resources/Classes/PHPExcel/Style/Borders.php';
include_once 'resources/Classes/PHPExcel/Style/Alignment.php';
include_once 'resources/Classes/PHPExcel/Style/Border.php';
include_once 'resources/Classes/PHPExcel/Style/Color.php';
include_once 'resources/Classes/PHPExcel/Style/Conditional.php';
include_once 'resources/Classes/PHPExcel/Style/NumberFormat.php';
include_once 'resources/Classes/PHPExcel/Style/Protection.php';
include_once 'resources/Classes/PHPExcel/Style.php';
include_once 'resources/Classes/PHPExcel/WorksheetIterator.php';
include_once 'resources/Classes/PHPExcel/Cell/IValueBinder.php';
include_once 'resources/Classes/PHPExcel/Cell/DataType.php';
include_once 'resources/Classes/PHPExcel/Cell/DataValidation.php';
include_once 'resources/Classes/PHPExcel/Cell/DefaultValueBinder.php';
include_once 'resources/Classes/PHPExcel/Cell.php';
//$this->includeRecurse('resources/Classes/PHPExcel/Calculation'); Pode dar erro incluir o .txt (?)
include_once 'resources/Classes/PHPExcel/Calculation/Exception.php';
include_once 'resources/Classes/PHPExcel/Calculation/ExceptionHandler.php';
include_once 'resources/Classes/PHPExcel/Calculation/FormulaParser.php';
include_once 'resources/Classes/PHPExcel/Calculation/FormulaToken.php';
include_once 'resources/Classes/PHPExcel/Calculation/Function.php';
include_once 'resources/Classes/PHPExcel/Calculation/Functions.php';
include_once 'resources/Classes/PHPExcel/Calculation.php';
include_once 'resources/Classes/PHPExcel/Autoloader.php';
include_once 'resources/Classes/PHPExcel/Comment.php';
include_once 'resources/Classes/PHPExcel/NamedRange.php';
include_once 'resources/Classes/PHPExcel/RichText/ITextElement.php';
include_once 'resources/Classes/PHPExcel/RichText/TextElement.php';
include_once 'resources/Classes/PHPExcel/RichText/Run.php';
include_once 'resources/Classes/PHPExcel/RichText.php';
include_once 'resources/Classes/PHPExcel/Settings.php';
include_once 'resources/Classes/PHPExcel/HashTable.php';
include_once 'resources/Classes/PHPExcel/Writer/IWriter.php';
include_once 'resources/Classes/PHPExcel/Writer/HTML.php';
include_once 'resources/Classes/PHPExcel/Writer/PDF.php';
include_once 'resources/Classes/PHPExcel/Writer/Serialized.php';
include_once 'resources/Classes/PHPExcel/Writer/Excel5/BIFFwriter.php';
include_once 'resources/Classes/PHPExcel/Writer/Excel5/Escher.php';
include_once 'resources/Classes/PHPExcel/Writer/Excel5/Font.php';
include_once 'resources/Classes/PHPExcel/Writer/Excel5/Parser.php';
include_once 'resources/Classes/PHPExcel/Writer/Excel5/Workbook.php';
include_once 'resources/Classes/PHPExcel/Writer/Excel5/Worksheet.php';
include_once 'resources/Classes/PHPExcel/Writer/Excel5/Xf.php';
include_once 'resources/Classes/PHPExcel/Writer/Excel5.php';
include_once 'resources/Classes/PHPExcel/Writer/Excel2007/WriterPart.php';
include_once 'resources/Classes/PHPExcel/Writer/Excel2007/Comments.php';
include_once 'resources/Classes/PHPExcel/Writer/Excel2007/ContentTypes.php';
include_once 'resources/Classes/PHPExcel/Writer/Excel2007/DocProps.php';
include_once 'resources/Classes/PHPExcel/Writer/Excel2007/Drawing.php';
include_once 'resources/Classes/PHPExcel/Writer/Excel2007/Rels.php';
include_once 'resources/Classes/PHPExcel/Writer/Excel2007/StringTable.php';
include_once 'resources/Classes/PHPExcel/Writer/Excel2007/Style.php';
include_once 'resources/Classes/PHPExcel/Writer/Excel2007/Theme.php';
include_once 'resources/Classes/PHPExcel/Writer/Excel2007/Workbook.php';
include_once 'resources/Classes/PHPExcel/Writer/Excel2007/Worksheet.php';
include_once 'resources/Classes/PHPExcel/Writer/Excel2007.php';
include_once 'resources/Classes/PHPExcel/Shared/XMLWriter.php';
include_once 'resources/Classes/PHPExcel/CachedObjectStorage/PHPTemp.php';


require_once 'resources/Classes/PHPExcel.php';
/*
require_once 'resources/Excel/Writer.php';
require_once 'resources/Excel/reader.php';
*/
class ExportExcelLogic {
    // variaveis de controle da planilha
    var $coldelete=0;
    var $colprivate=1;
    var $colbasisofrecord=2;
    var $colinstitutioncode=3;
    var $colcollectioncode=4;
    var $colcatalognumber=5;
    var $colscientificname=6;
    var $coltype=7;
    var $colownerinstitutioncode=8;
    var $coldataset=9;
    var $colrights=10;
    var $colrightsholder=11;
    var $colaccessrights=12;
    var $colinformationwithheld=13;
    var $coldatageneralization=14;
    var $coldynamicproperties=15;
    var $colkingdom=16;
    var $colphylum=17;
    var $colclass=18;
    var $colorder=19;
    var $colfamily=20;
    var $colgenus=21;
    var $colsubgenus=22;
    var $colspecificepithet=23;
    var $colinfraspecificepithet=24;
    var $coltaxonrank=25;
    var $colscientificnameauthorship=26;
    var $colnomenclaturalcode=27;
    var $coltaxonconcept=28;
    var $colnomenclaturalstatus=29;
    var $colacceptednameusage=30;
    var $colparentnameusage=31;
    var $coloriginalnameusage=32;
    var $colnameaccordingto=33;
    var $colnamepublishedin=34;
    var $colvernacularname=35;
    var $coltaxonomicstatus=36;
    var $colverbatimtaxonrank=37;
    var $coltaxonremarks=38;
    var $colindividual=39;
    var $colindividualcount=40;
    var $colsex=41;
    var $colbehavior=42;
    var $collifestage=43;
    var $coldisposition=44;
    var $colreproductivecondition=45;
    var $colestablishmentmean=46;
    var $colrecordedby=47;
    var $colrecordnumber=48;
    var $colothercatalognumbers=49;
    var $colpreparations=50;
    var $colassociatedsequence=51;
    var $coloccurrencedetails=52;
    var $coloccurrenceremarks=53;
    var $coloccurrencestatus=54;
    var $coldateidentified=55;
    var $colidentificationqualifier=56;
    var $colidentifiedby=57;
    var $coltypestatus=58;
    var $colidentificationremarks=59;
    var $colsamplingprotocol=60;
    var $colsamplingeffort=61;
    var $colhabitat=62;
    var $colverbatimeventdate=63;
    var $coleventtime=64;
    var $coleventdate=65;
    var $colfieldnumber=66;
    var $colfieldnotes=67;
    var $coleventremarks=68;
    var $coldecimallatitude=69;
    var $coldecimallongitude=70;
    var $colcontinent=71;
    var $colcountry=72;
    var $colstateprovince=73;
    var $colcounty=74;
    var $colmunicipality=75;
    var $collocality=76;
    var $colwaterbody=77;
    var $colislandgroup=78;
    var $colisland=79;
    var $collocationaccordingto=80;
    var $colcoordinateprecision=81;
    var $collocationremarks=82;
    var $colminimumelevationinmeters=83;
    var $colmaximumelevationinmeters=84;
    var $colminimumdepthinmeters=85;
    var $colmaximumdepthinmeters=86;
    var $colminimumdistanceabovesurfaceinmeters=87;
    var $colmaximumdistanceabovesurfaceinmeters=88;
    var $colverbatimdepth=89;
    var $colverbatimelevation=90;
    var $colverbatimlocality=91;
    var $colverbatimsrs=92;
    var $colgeoreferencedby=93;
    var $colgeoreferencesources=94;
    var $colfootprintsrs=95;
    var $colcoordinateuncertainty=96;
    var $colgeodeticdatum=97;
    var $colpointradiusspatialfit=98;
    var $colverbatimcoordinates=99;
    var $colverbatimlatitude=100;
    var $colverbatimlongitude=101;
    var $colverbatimcoordinatesystem=102;
    var $colgeoreferenceprotocol=103;
    var $colverificationstatus=104;
    var $colgeoreferenceremarks=105;
    var $colfootprintwkt=106;
    var $colfootprintspatialfit=107;

    var $colinteractiontype=108;
    var $colinteractionrelatedinformation=109;

    var $sp2=110;
    var $sp1=0;

    var $firstLine = 12;

    private $reader;
    public $listSpecimens;
    public $listSpecimensAlone;
    public $listInteractions;
    public $listXLS;
    public $log;
    public $datahora;
    public $objWorksheet;

    // construtor: data e hora do inicio do processo.
    public function __construct() {
        $this->datahora = date ("jmYHis");
    }

    // comeca a escrever na planilha temporaria criada...

    /*
    * *** EXPORTAR ***
    */

    // le todos os Especimes
    public function readSpecimenList($filter) {

        //$modSp = SpecimenAR::model();
        $logic = new SpecimenLogic();
        $rs = $logic->filter($filter);
        $this->log[] = '';
        if (count($rs)>0)
            foreach ($rs['list'] as $i) {
                $this->listSpecimens[] = SpecimenAR::model()->findByPK($i['idspecimen']);
            }
        //$this->listSpecimens = $modSp->findAll();

        $this->log[] = count($this->listSpecimens).' specimen records.';
    }

    // separa os especimes que tem interacao dos que nao tem
    public function interactionCorrelation() {

        $modInt = InteractionAR::model();

        foreach ($this->listSpecimens as $sp) {
            $listInt = $modInt->findAll('idspecimen1='.$sp->idspecimen);
            if(count($listInt)>0) {
                foreach ($listInt as $i) {
                    $this->listInteractions[] = $i;
                }
            }else {
                $listInt2 = $modInt->findAll('idspecimen2='.$sp->idspecimen);
                if(count($listInt2)==0) {
                    $this->listSpecimensAlone[] = $sp;
                }
            }
        }

        $this->log[] = count($this->listInteractions).' interaction records.';
        $this->log[] = count($this->listSpecimensAlone).' specimens without interaction records.';
    }

    public function writeSpreadsheet($cols) {

        //require_once 'resources/Classes/PHPExcel.php';
        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array( ' memoryCacheSize '  => '64MB' );
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);

        $objPHPexcel = PHPExcel_IOFactory::load('images/uploaded/spreadsheetsync_export.xls');

        $this->objWorksheet = $objPHPexcel->getActiveSheet();

        $this->objWorksheet->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->objWorksheet->getDefaultStyle()->getFont()->setName('Calibri');

        $line = $this->firstLine;
        if($this->listInteractions!=null)
            foreach($this->listInteractions as $int) {
                $this->writeInteractionLine($int, $line);
                $line++;
            }
        if ($this->listSpecimensAlone!=null)
            foreach($this->listSpecimensAlone as $sp) {
                $this->writeSpLine($this->sp1,$sp, $line);
                $line++;
            }

        //FILTRO: Ocultar colunas
        for($i=0; $i<=$this->colfootprintspatialfit; $i++) {
            $this->objWorksheet->getColumnDimensionByColumn($this->sp1+$i)->setVisible(false);
            $this->objWorksheet->getColumnDimensionByColumn($this->sp2+$i)->setVisible(false);
        }
        foreach($cols as $collumn) {
            $this->objWorksheet->getColumnDimensionByColumn($this->sp1+$collumn)->setVisible(true);
            $this->objWorksheet->getColumnDimensionByColumn($this->sp2+$collumn)->setVisible(true);
        }

        //FORMATACAO
        $this->objWorksheet->getStyle('A'.$this->firstLine.':HJ'.$line)->getProtection()->setLocked(
                PHPExcel_Style_Protection::PROTECTION_UNPROTECTED
        );

        //$this->objWorksheet->getStyle('A4:HJ'.($this->firstLine-1))->getFont()->getColor()->setARGB('777777');

        //$this->objWorksheet->getStyle('A'.$this->firstLine.':HJ'.$line)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //$this->objWorksheet->getStyle('A'.$this->firstLine.':HJ'.$line)->getFont()->setSize(10);
        //$this->objWorksheet->getStyle('A'.$this->firstLine.':HJ'.$line)->getFont()->setName('Calibri');
        //$this->objWorksheet->getStyle('A'.$this->firstLine.':HJ'.$line)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
        /*
        //$this->objWorksheet->getProtection()->setSheet(true);

        $this->objWorksheet->getDefaultStyle()->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
        */
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel5');
        $objWriter->save('assets/bdd_backup'.$this->datahora.'.xls');

        $this->log[] = 'Spreadsheet finished.';
    }

    public function writeSpLine($sp, $spcm, $line) {
        $rec = RecordLevelElementAR::model()->findByPk($spcm->idrecordlevelelement);
        $rec = $rec == null?new RecordLevelElementAR():$rec;
        $tax = TaxonomicElementAR::model()->findByPk($spcm->idtaxonomicelement);
        $tax = $tax == null?new TaxonomicElementAR():$tax;
        $occ = OccurrenceElementAR::model()->findByPk($spcm->idoccurrenceelement);
        $occ = $occ == null?new OccurrenceElementAR():$occ;
        $loc = LocalityElementAR::model()->findByPk($spcm->idlocalityelement);
        $loc = $loc == null?new LocalityElementAR():$loc;
        $eve = EventElementAR::model()->findByPk($spcm->ideventelement);
        $eve = $eve== null?new EventElementAR():$eve;
        $geo = GeospatialElementAR::model()->findByPk($spcm->idgeospatialelement);
        $geo = $geo== null?new GeospatialElementAR():$geo;
        $ide = IdentificationElementAR::model()->findByPk($spcm->ididentificationelement);
        $ide = $ide== null?new IdentificationElementAR():$ide;

        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colprivate, $line)->setValue($rec->isrestricted?'YES':'NO');
        //RECORD LEVEL
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colbasisofrecord, $line)->setValue(BasisOfRecordAR::model()->findByPK($rec->idbasisofrecord)->basisofrecord);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colinstitutioncode, $line)->setValue(InstitutionCodeAR::model()->findByPK($rec->idinstitutioncode)->institutioncode);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colcollectioncode, $line)->setValue(CollectionCodeAR::model()->findByPK($rec->idcollectioncode)->collectioncode);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->coltype, $line)->setValue(TypeAR::model()->findByPK($rec->idtype)->type);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colownerinstitutioncode, $line)->setValue(OwnerInstitutionAR::model()->findByPK($rec->idownerinstitution)->ownerinstitution);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->coldataset, $line)->setValue(DatasetAR::model()->findByPK($rec->iddataset)->dataset);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colinformationwithheld, $line)->setValue($rec->informationwithheld);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colrights, $line)->setValue($rec->rights);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colrightsholder, $line)->setValue($rec->rightsholder);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colaccessrights, $line)->setValue($rec->accessrights);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->coldatageneralization, $line)->setValue($rec->datageneralization);
        //TAXONOMIC
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colscientificname, $line)->setValue(ScientificNameAR::model()->findByPK($tax->idscientificname)->scientificname);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colkingdom, $line)->setValue(KingdomAR::model()->findByPK($tax->idkingdom)->kingdom);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colphylum, $line)->setValue(PhylumAR::model()->findByPK($tax->idphylum)->phylum);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colclass, $line)->setValue(ClassAR::model()->findByPK($tax->idclass)->class);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colorder, $line)->setValue(OrderAR::model()->findByPK($tax->idorder)->order);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colfamily, $line)->setValue(FamilyAR::model()->findByPK($tax->idfamily)->family);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colgenus, $line)->setValue(GenusAR::model()->findByPK($tax->idgenus)->genus);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colsubgenus, $line)->setValue(SubgenusAR::model()->findByPK($tax->idsubgenus)->subgenus);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colspecificepithet, $line)->setValue(SpecificEpithetAR::model()->findByPK($tax->idspecificepithet)->specificepithet);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->coltaxonrank, $line)->setValue(TaxonRankAR::model()->findByPK($tax->idtaxonrank)->taxonrank);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->coltaxonconcept, $line)->setValue(TaxonConceptAR::model()->findByPK($tax->idtaxonconcept)->taxonconcept);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colinfraspecificepithet, $line)->setValue(InfraspecificEpithetAR::model()->findByPK($tax->idinfraspecificepithet)->infraspecificepithet);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colscientificnameauthorship, $line)->setValue(ScientificNameAuthorshipAR::model()->findByPK($tax->idscientificnameauthorship)->scientificnameauthorship);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colnomenclaturalcode, $line)->setValue(NomenclaturalCodeAR::model()->findByPK($tax->idnomenclaturalcode)->nomenclaturalcode);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colacceptednameusage, $line)->setValue(AcceptedNameUsageAR::model()->findByPK($tax->idacceptednameusage)->acceptednameusage);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colparentnameusage, $line)->setValue(ParentNameUsageAR::model()->findByPK($tax->idparentnameusage)->parentnameusage);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->coloriginalnameusage, $line)->setValue(OriginalNameUsageAR::model()->findByPK($tax->idoriginalnameusage)->originalnameusage);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colnameaccordingto, $line)->setValue(NameAccordingToAR::model()->findByPK($tax->idnameaccordingto)->nameaccordingto);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colnamepublishedin, $line)->setValue(NamePublishedInAR::model()->findByPK($tax->idnamepublishedin)->namepublishedin);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->coltaxonomicstatus, $line)->setValue(TaxonomicStatusAR::model()->findByPK($tax->idtaxonomicstatus)->taxonomicstatus);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colnomenclaturalstatus, $line)->setValue($tax->nomenclaturalstatus);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colvernacularname, $line)->setValue($tax->vernacularname);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colverbatimtaxonrank, $line)->setValue($tax->verbatimtaxonrank);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->coltaxonremarks, $line)->setValue($tax->taxonremark);
        //OCCURRENCE
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colsex, $line)->setValue(SexAR::model()->findByPK($occ->idsex)->sex);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->collifestage, $line)->setValue(LifeStageAR::model()->findByPK($occ->idlifestage)->lifestage);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->coldisposition, $line)->setValue(DispositionAR::model()->findByPK($occ->iddisposition)->disposition);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colbehavior, $line)->setValue(BehaviorAR::model()->findByPK($occ->idbehavior)->behavior);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colreproductivecondition, $line)->setValue(ReproductiveConditionAR::model()->findByPK($occ->idreproductivecondition)->reproductivecondition);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colestablishmentmean, $line)->setValue(EstablishmentMeanAR::model()->findByPK($occ->idestablishmentmean)->establishmentmean);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colcatalognumber, $line)->setValueExplicit($occ->catalognumber, PHPExcel_Cell_DataType::TYPE_STRING);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->coloccurrenceremarks, $line)->setValue($occ->occurrenceremark);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colothercatalognumbers, $line)->setValue($occ->othercatalognumber);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->coloccurrencedetails, $line)->setValue($occ->occurrencedetail);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colindividualcount, $line)->setValue($occ->individualcount);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colrecordnumber, $line)->setValue($occ->recordnumber);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->coloccurrencestatus, $line)->setValue($occ->occurrencestatus);
        //IDENTIFICATION
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colidentificationqualifier, $line)->setValue(IdentificationQualifierAR::model()->findByPK($ide->ididentificationqualifier)->identificationqualifier);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->coldateidentified, $line)->setValue($ide->dateidentified);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colidentificationremarks, $line)->setValue($ide->identificationremark);
        //EVENT
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colsamplingprotocol, $line)->setValue(SamplingProtocolAR::model()->findByPK($eve->idsamplingprotocol)->samplingprotocol);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colhabitat, $line)->setValue(HabitatAR::model()->findByPK($eve->idhabitat)->habitat);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colsamplingeffort, $line)->setValue($eve->samplingeffort);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->coleventtime, $line)->setValue($eve->eventtime);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->coleventdate, $line)->setValue($eve->eventdate);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colfieldnumber, $line)->setValue($eve->fieldnumber);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colfieldnotes, $line)->setValue($eve->fieldnote);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colverbatimeventdate, $line)->setValue($eve->verbatimeventdate);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->coleventremarks, $line)->setValue($eve->eventremark);
        //LOCALITY
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colcontinent, $line)->setValue(ContinentAR::model()->findByPK($loc->idcontinent)->continent);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colwaterbody, $line)->setValue(WaterBodyAR::model()->findByPK($loc->idwaterbody)->waterbody);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colislandgroup, $line)->setValue(IslandGroupAR::model()->findByPK($loc->idislandgroup)->islandgroup);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colisland, $line)->setValue(IslandAR::model()->findByPK($loc->idisland)->island);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colcountry, $line)->setValue(CountryAR::model()->findByPK($loc->idcountry)->country);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colstateprovince, $line)->setValue(StateProvinceAR::model()->findByPK($loc->idstateprovince)->stateprovince);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colcounty, $line)->setValue(CountyAR::model()->findByPK($loc->idcounty)->county);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colmunicipality, $line)->setValue(MunicipalityAR::model()->findByPK($loc->idmunicipality)->municipality);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->collocality, $line)->setValue(LocalityAR::model()->findByPK($loc->idlocality)->locality);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->collocationaccordingto, $line)->setValue($loc->locationaccordingto);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colcoordinateprecision, $line)->setValue($loc->coordinateprecision);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->collocationremarks, $line)->setValue($loc->locationremark);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colminimumelevationinmeters, $line)->setValue($loc->minimumelevationinmeters);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colmaximumelevationinmeters, $line)->setValue($loc->maximumelevationinmeters);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colminimumdepthinmeters, $line)->setValue($loc->minimumdepthinmeters);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colmaximumdepthinmeters, $line)->setValue($loc->maximumdepthinmeters);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colminimumdistanceabovesurfaceinmeters, $line)->setValue($loc->minimumdistanceabovesurfaceinmeters);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colmaximumdistanceabovesurfaceinmeters, $line)->setValue($loc->maximumdistanceabovesurfaceinmeters);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colverbatimdepth, $line)->setValue($loc->verbatimdepth);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colverbatimelevation, $line)->setValue($loc->verbatimelevation);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colverbatimlocality, $line)->setValue($loc->verbatimlocality);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colverbatimsrs, $line)->setValue($loc->verbatimsrs);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colfootprintsrs, $line)->setValue($loc->footprintsrs);
        //GEOSPATIAL
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colverificationstatus, $line)->setValue(GeoreferenceVerificationStatusAR::model()->findByPK($geo->idgeoreferenceverificationstatus)->georeferenceverificationstatus);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->coldecimallatitude, $line)->setValue($geo->decimallatitude);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->coldecimallongitude, $line)->setValue($geo->decimallongitude);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colgeodeticdatum, $line)->setValue($geo->geodeticdatum);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colcoordinateuncertaintyinmeters, $line)->setValue($geo->coordinateuncertaintyinmeters);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colpointradiusspatialfit, $line)->setValue($geo->pointradiusspatialfit);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colverbatimcoordinates, $line)->setValue($geo->verbatimcoordinate);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colverbatimlatitude, $line)->setValue($geo->verbatimlatitude);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colverbatimlongitude, $line)->setValue($geo->verbatimlongitude);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colverbatimcoordinatesystem, $line)->setValue($geo->verbatimcoordinatesystem);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colgeoreferenceprotocol, $line)->setValue($geo->georeferenceprotocol);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colgeoreferenceremarks, $line)->setValue($geo->georeferenceremark);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colfootprintwkt, $line)->setValue($geo->footprintwkt);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colfootprintspatialfit, $line)->setValue($geo->footprintspatialfit);

        //CAMPOS NN
        $aux = RecordLevelDynamicPropertyAR::model()->findAll('idrecordlevelelement=:rec', array(':rec'=>$rec->idrecordlevelelement));
        $n1 = '';
        if (count($aux)>0)
            foreach ($aux as $ar)
                $n1 = $n1.DynamicPropertyAR::model()->findByPK($ar->iddynamicproperty)->dynamicproperty.'; ';
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->coldynamicproperties, $line)->setValue($n1);

        $aux = OccurrenceIndividualAR::model()->findAll('idoccurrenceelement=:occ', array(':occ'=>$occ->idoccurrenceelement));
        $n1 = '';
        if (count($aux)>0)
            foreach ($aux as $ar)
                $n1 = $n1.IndividualAR::model()->findByPK($ar->idindividual)->individual.'; ';
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colindividual, $line)->setValue($n1);

        $aux = OccurrenceRecordedByAR::model()->findAll('idoccurrenceelement=:occ', array(':occ'=>$occ->idoccurrenceelement));
        $n1 = '';
        if (count($aux)>0)
            foreach ($aux as $ar)
                $n1 = $n1.RecordedByAR::model()->findByPK($ar->idrecordedby)->recordedby.'; ';
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colrecordedby, $line)->setValue($n1);

        $aux = OccurrencePreparationAR::model()->findAll('idoccurrenceelement=:occ', array(':occ'=>$occ->idoccurrenceelement));
        $n1 = '';
        if (count($aux)>0)
            foreach ($aux as $ar)
                $n1 = $n1.PreparationAR::model()->findByPK($ar->idpreparation)->preparation.'; ';
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colpreparations, $line)->setValue($n1);

        $aux = OccurrenceAssociatedSequenceAR::model()->findAll('idoccurrenceelement=:occ', array(':occ'=>$occ->idoccurrenceelement));
        $n1 = '';
        if (count($aux)>0)
            foreach ($aux as $ar)
                $n1 = $n1.AssociatedSequenceAR::model()->findByPK($ar->idassociatedsequence)->associatedsequence.'; ';
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colassociatedsequence, $line)->setValue($n1);

        $aux = IdentificationIdentifiedByAR::model()->findAll('ididentificationelement=:ide', array(':ide'=>$ide->ididentificationelement));
        $n1 = '';
        if (count($aux)>0)
            foreach ($aux as $ar)
                $n1 = $n1.IdentifiedByAR::model()->findByPK($ar->ididentifiedby)->identifiedby.'; ';
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colidentifiedby, $line)->setValue($n1);

        $aux = IdentificationTypeStatusAR::model()->findAll('ididentificationelement=:ide', array(':ide'=>$ide->ididentificationelement));
        $n1 = '';
        if (count($aux)>0)
            foreach ($aux as $ar)
                $n1 = $n1.TypeStatusAR::model()->findByPK($ar->idtypestatus)->typestatus.'; ';
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->coltypestatus, $line)->setValue($n1);

        $aux = LocalityGeoreferencedByAR::model()->findAll('idlocalityelement=:loc', array(':loc'=>$loc->idlocalityelement));
        $n1 = '';
        if (count($aux)>0)
            foreach ($aux as $ar)
                $n1 = $n1.GeoreferencedByAR::model()->findByPK($ar->idgeoreferencedby)->georeferencedby.'; ';
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colgeoreferencedby, $line)->setValue($n1);

        $aux = LocalityGeoreferenceSourceAR::model()->findAll('idlocalityelement=:loc', array(':loc'=>$loc->idlocalityelement));
        $aux = $aux==null ? GeospatialGeoreferenceSourceAR::model()->findAll('idgeospatialelement=:geo', array(':geo'=>$geo->idgeospatialelement)) : $aux;
        $n1 = '';
        if (count($aux)>0)
            foreach ($aux as $ar)
                $n1 = $n1.GeoreferenceSourceAR::model()->findByPK($ar->idgeoreferencesource)->georeferencesource.'; ';
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colgeoreferencesources, $line)->setValue($n1);

        $this->objWorksheet->getCellByColumnAndRow($sp+$this->coldelete, $line)->setValue('NO');
    }

    public function writeInteractionLine($int, $line) {
        $sp1 = SpecimenAR::model()->findByPK($int->idspecimen1);
        $this->writeSpLine($this->sp1, $sp1, $line);
        $sp2 = SpecimenAR::model()->findByPK($int->idspecimen2);
        $this->writeSpLine($this->sp2, $sp2, $line);

        $this->objWorksheet->getCellByColumnAndRow($this->colinteractiontype, $line)->setValue(InteractionTypeAR::model()->findByPk($int->idinteractiontype)->interactiontype);
        $this->objWorksheet->getCellByColumnAndRow($this->colinteractionrelatedinformation, $line)->setValue($int->interactionrelatedinformation);

    }
}
?>