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


require_once 'resources/Classes/PHPExcel.php';

class SpreadsheetsyncLogic {
    // variaveis de controle da planilha
    var $colbasisofrecord=1;
    var $colinstitutioncode=2;
    var $colcollectioncode=3;
    var $colcatalognumber=4;
    var $colinformationwithheld=5;
    var $colremarks=6;
    var $colscientificname=7;
    var $colkingdom=8;
    var $colphylum=9;
    var $colclass=10;
    var $colorder=11;
    var $colfamily=12;
    var $colgenus=13;
    var $colspecificepithet=14;
    var $colinfraspecificrank=15;
    var $colinfraspecificepithet=16;
    var $colauthoryearscientificname=17;
    var $colnomenclaturalcode=18;
    var $colidentificationqualifier=19;
    var $colcontinent=20;
    var $colwaterbody=21;
    var $colislandgroup=22;
    var $colisland=23;
    var $colcountry=24;
    var $colstateorprovince=25;
    var $colcounty=26;
    var $collocality=27;
    var $colminimumelevationinmeters=28;
    var $colmaximumelevationinmeters=29;
    var $colminimumdepthinmeters=30;
    var $colmaximumdepthinmeters=31;
    var $colcollectingmethod=32;
    var $colvaliddistributionflag=33;
    var $colearliestdatecollected=34;
    var $collatestdatecollected=35;
    var $coldayofyear=36;
    var $colcollector=37;
    var $colsex=38;
    var $collifestage=39;
    var $colattributes=40;
    var $colimageurl=41;
    var $colrelatedinformation=42;
    var $coldecimallatitude=43;
    var $coldecimallongitude=44;
    var $colgeodeticdatum=45;
    var $colcoordinateuncertaintyinmeters=46;
    var $colpointradiusspatialfit=47;
    var $colverbatimcoordinates=48;
    var $colverbatimlatitude=49;
    var $colverbatimlongitude=50;
    var $colverbatimcoordinatesystem=51;
    var $colgeoreferenceprotocol=52;
    var $colgeoreferencesources=53;
    var $colverificationstatus=54;
    var $colgeospatialremarks=55;
    var $colfootprintwkt=56;
    var $colfootprintspatialfit=57;
    var $colcatalognumbercur=58;
    var $colidentifiedby=59;
    var $coldateidentified=60;
    var $colcollectornumber=61;
    var $colfieldnumber=62;
    var $colfieldnotes=63;
    var $colverbatimcollectingdate=64;
    var $colverbatimelevation=65;
    var $colverbatimdepth=66;
    var $colpreparations=67;
    var $coltypestatus=68;
    var $colgenbanknumber=69;
    var $colothercatalognumbers=70;
    var $colrelatedcatalogeditems=71;
    var $coldisposition=72;
    var $colindividualcount=73;

    var $colinteractiontype=73;
    var $colinteractionrelatedinformation=74;

    var $sp2=74;
    var $sp1=-1;

    var $firstLine = 12;

    private $reader;
    public $listSpecimens;
    public $listSpecimensAlone;
    public $listInteractions;
    public $listXLS;
    public $log;
    public $datahora;
    public $objWorksheet;
    public $spcreate = 0;
    public $spupdate = 0;
    public $intcreate = 0;
    public $intupdate = 0;
    public $linhabranco = 0;

    // construtor: data e hora do inicio do processo.
    public function __construct() {
        $this->datahora = date ("jmYHis");
    }
    // come�a a escrever na planilha temporaria criada...
    function includeRecurse($dirName) {
        if(!is_dir($dirName))
            return false;
        $dirHandle = opendir($dirName);
        while(false !== ($incFile = readdir($dirHandle))) {
            if($incFile != "."
                    && $incFile != "..") {
                if(is_file("$dirName/$incFile"))
                    include_once("$dirName/$incFile");
                elseif(is_dir("$dirName/$incFile"))
                    $this->includeRecurse("$dirName/$incFile");
            }
        }
        closedir($dirHandle);
    }
    function includePHPExcel() {
        //incluir PHPExcel
        /*require_once 'resources/Classes/PHPExcel/Shared/ZipStreamWrapper.php';
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
        include_once 'resources/Classes/PHPExcel/Cell/IValueBinder.php';*/
        //$this->includeRecurse('resources/Classes/PHPExcel/Cell');
        /*include_once 'resources/Classes/PHPExcel/Cell.php';
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


        require 'resources/Classes/PHPExcel.php';
        */
        //include 'resources/Classes/PHPExcel/Autoloader.php';

    }

    /*
    * *** EXPORTAR ***
    */

    // le todos os Especimes
    public function readSpecieList() {
        $this->log[] = 'Reading specimen records.';

        $modSp = SpecimenAR::model();
        $this->listSpecimens = $modSp->findAll();

        $this->log[] = count($this->listSpecimens).' specimen records found.';
    }

    // separa os especimes que tem interacao dos que nao tem
    public function interactionCorrelation() {
        $this->log[] = 'Analyzing correlation between specimen and interaction records.';

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

        $this->log[] = count($this->listInteractions).' interaction records found.';
        $this->log[] = count($this->listSpecimensAlone).' specimens without interaction records found.';
    }

    public function writeSpreadsheet() {
        $this->log[] = 'Writing spreadsheet...';

        require_once 'resources/Classes/PHPExcel.php';

        $objPHPexcel = PHPExcel_IOFactory::load('images/uploaded/grantee_model.xls');
        $this->objWorksheet = $objPHPexcel->getActiveSheet();

        $linha = $this->firstLine;
        foreach($this->listInteractions as $int) {
            $this->writeInteractionLine($int, $linha);
            $linha++;
        }

        foreach($this->listSpecimensAlone as $sp) {
            $this->writeSpLine($this->sp1,$sp, $linha);
            $linha++;
        }

        $this->objWorksheet->getStyle('A'.$this->firstLine.':ER'.$linha)->getProtection()->setLocked(
                PHPExcel_Style_Protection::PROTECTION_UNPROTECTED
        );
        $this->objWorksheet->getStyle('A'.$this->firstLine.':ER'.$linha)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->objWorksheet->getStyle('A'.$this->firstLine.':ER'.$linha)->getFont()->setSize(10);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPexcel, 'Excel5');
        $objWriter->save('assets/bdd_backup'.$this->datahora.'.xls');

        $this->log[] = 'Spreadsheet finished.';
    }

    public function writeSpLine($sp, $spcm, $linha) {
        $rec = RecordLevelElementAR::model()->findByPk($spcm->idrecordlevelelement);
        $rec = $rec == null?RecordLevelElementAR::model():$rec;
        $tax = TaxonomicElementAR::model()->findByPk($spcm->idtaxonomicelement);
        $tax = $tax == null?TaxonomicElementAR::model():$tax;
        $occ = OccurrenceElementAR::model()->findByPk($spcm->idoccurrenceelement);
        $occ = $occ == null?OccurrenceElementAR::model():$occ;
        $loc = LocalityElementAR::model()->findByPk($spcm->idlocalityelement);
        $loc = $loc == null?LocalityElementAR::model():$loc;
        $eve = EventElementAR::model()->findByPk($spcm->ideventelement);
        $eve = $eve== null?EventElementAR::model():$eve;
        $geo = GeospatialElementAR::model()->findByPk($spcm->idgeospatialelement);
        $geo = $geo== null?GeospatialElementAR::model():$geo;
        $ide = IdentificationElementAR::model()->findByPk($spcm->ididentificationelement);
        $ide = $ide== null?IdentificationElementAR::model():$ide;

        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colbasisofrecord, $linha)->setValue(BasisOfRecordAR::model()->findByPK($rec->idbasisofrecord)->basisofrecord);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colinstitutioncode, $linha)->setValue(InstitutionCodeAR::model()->findByPK($rec->idinstitutioncode)->institutioncode);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colcollectioncode, $linha)->setValue(CollectionCodeAR::model()->findByPK($rec->idcollectioncode)->collectioncode);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colcatalognumber, $linha)->setValue($occ->catalognumber);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colinformationwithheld, $linha)->setValue($rec->informationwithheld);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colremarks, $linha)->setValue($occ->occurrenceremarks);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colscientificname, $linha)->setValue(ScientificNameAR::model()->findByPK($tax->idscientificname)->scientificname);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colkingdom, $linha)->setValue(KingdomAR::model()->findByPK($tax->idkingdom)->kingdom);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colphylum, $linha)->setValue(PhylumAR::model()->findByPK($tax->idphylum)->phylum);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colclass, $linha)->setValue(ClassAR::model()->findByPK($tax->idclass)->class);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colorder, $linha)->setValue(OrderAR::model()->findByPK($tax->idorder)->order);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colfamily, $linha)->setValue(FamilyAR::model()->findByPK($tax->idfamily)->family);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colgenus, $linha)->setValue(GenusAR::model()->findByPK($tax->idgenus)->genus);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colspecificepithet, $linha)->setValue(SpecificEpithetAR::model()->findByPK($tax->idspecificepithet)->specificepithet);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colinfraspecificrank, $linha)->setValue(TaxonRankAR::model()->findByPK($tax->idtaxonrank)->taxonrank);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colinfraspecificepithet, $linha)->setValue(InfraspecificEpithetAR::model()->findByPK($tax->idinfraspecificepithet)->idinfraspecificepithet);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colauthoryearscientificname, $linha)->setValue(ScientificNameAuthorshipAR::model()->findByPK($tax->idscientificnameauthorship)->scientificnameauthorship);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colnomenclaturalcode, $linha)->setValue(NomenclaturalCodeAR::model()->findByPK($tax->idnomenclaturalcode)->nomenclaturalcode);
        //$this->objWorksheet->getCellByColumnAndRow($sp+$this->colidentificationqualifier, $linha)->setValue(IdentificationQualifierAR::model()->findByPK($tax->ididentificationqualifier)->identificationqualifier);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colcontinent, $linha)->setValue(ContinentAR::model()->findByPK($loc->idcontinent)->continent);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colwaterbody, $linha)->setValue(WaterBodyAR::model()->findByPK($loc->idwaterbody)->waterbody);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colislandgroup, $linha)->setValue(IslandGroupAR::model()->findByPK($loc->idislandgroup)->islandgroup);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colisland, $linha)->setValue(IslandAR::model()->findByPK($loc->idisland)->island);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colcountry, $linha)->setValue(CountryAR::model()->findByPK($loc->idcountry)->country);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colstateorprovince, $linha)->setValue(StateProvinceAR::emodel()->findByPK($loc->idstateprovince)->stateprovince);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colcounty, $linha)->setValue(CountyAR::model()->findByPK($loc->idcounty)->county);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->collocality, $linha)->setValue(LocalityAR::model()->findByPK($loc->idlocality)->locality);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colminimumelevationinmeters, $linha)->setValue($loc->minimumelevationinmeters);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colmaximumelevationinmeters, $linha)->setValue($loc->maximumelevationinmeters);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colminimumdepthinmeters, $linha)->setValue($loc->minimumdepthinmeters);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colmaximumdepthinmeters, $linha)->setValue($loc->maximumdepthinmeters);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colcollectingmethod, $linha)->setValue(SamplingProtocolAR::model()->findByPK($eve->idsamplingprotocol)->samplingprotocol);
        //$this->objWorksheet->getCellByColumnAndRow($sp+$this->colvaliddistributionflag, $linha)->setValue(EstablishmentMeanAR::model()->findByPK($occ->idestablishmentmean)->establishmentmean);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colearliestdatecollected, $linha)->setValue($eve->eventdate);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->collatestdatecollected, $linha)->setValue($eve->eventdate);
        //$this->objWorksheet->getCellByColumnAndRow($sp+$this->coldayofyear, $linha)->setValue(basisofrecords::model()->findByPK($spcm->idbasisofrecord)->basisofrecord);
        //$this->objWorksheet->getCellByColumnAndRow($sp+$this->colcollector, $linha)->setValue(basisofrecords::model()->findByPK($spcm->idbasisofrecord)->basisofrecord);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colsex, $linha)->setValue(SexAR::model()->findByPK($occ->idsex)->sex);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->collifestage, $linha)->setValue(LifeStageAR::model()->findByPK($occ->idlifestage)->lifestage);
        
        //$this->objWorksheet->getCellByColumnAndRow($sp+$this->colattributes, $linha)->setValue($spcm->dynamicproperty);
        
        //$this->objWorksheet->getCellByColumnAndRow($sp+$this->colimageurl, $linha)->setValue(basisofrecords::model()->findByPK($spcm->idbasisofrecord)->basisofrecord);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colrelatedinformation, $linha)->setValue($occ->occurrencedetail);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->coldecimallatitude, $linha)->setValue($geo->decimallatitude);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->coldecimallongitude, $linha)->setValue($geo->decimallongitude);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colgeodeticdatum, $linha)->setValue($geo->geodeticdatum);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colcoordinateuncertaintyinmeters, $linha)->setValue($geo->coordinateuncertaintyinmeters);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colpointradiusspatialfit, $linha)->setValue($geo->pointradiusspatialfit);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colverbatimcoordinates, $linha)->setValue($geo->verbatimcoordinate);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colverbatimlatitude, $linha)->setValue($geo->verbatimlatitude);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colverbatimlongitude, $linha)->setValue($geo->verbatimlongitude);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colverbatimcoordinatesystem, $linha)->setValue($geo->verbatimcoordinatesystem);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colgeoreferenceprotocol, $linha)->setValue($geo->georeferenceprotocol);
        //$this->objWorksheet->getCellByColumnAndRow($sp+$this->colgeoreferencesources, $linha)->setValue($geo->georeferencesources);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colverificationstatus, $linha)->setValue(GeoreferenceVerificationStatusAR::model()->findByPK($geo->idgeoreferenceverificationstatus)->georeferenceverificationstatus);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colgeospatialremarks, $linha)->setValue($geo->georeferenceremark);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colfootprintwkt, $linha)->setValue($geo->footprintwkt);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colfootprintspatialfit, $linha)->setValue($geo->footprintspatialfit);
        //$this->objWorksheet->getCellByColumnAndRow($sp+$this->colcatalognumbercur, $linha)->setValue(basisofrecords::model()->findByPK($spcm->idbasisofrecord)->basisofrecord);
        //$this->objWorksheet->getCellByColumnAndRow($sp+$this->colidentifiedby, $linha)->setValue(basisofrecords::model()->findByPK($spcm->idbasisofrecord)->basisofrecord);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->coldateidentified, $linha)->setValue($ide->dateidentified);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colcollectornumber, $linha)->setValue($occ->recordnumber);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colfieldnumber, $linha)->setValue($eve->fieldnumber);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colfieldnotes, $linha)->setValue($eve->fieldnote);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colverbatimcollectingdate, $linha)->setValue($eve->verbatimeventdate);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colverbatimelevation, $linha)->setValue($loc->verbatimelevation);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colverbatimdepth, $linha)->setValue($loc->verbatimdepth);
        //$this->objWorksheet->getCellByColumnAndRow($sp+$this->colpreparations, $linha)->setValue($loc->idbasisofrecord)->basisofrecord);
        //$this->objWorksheet->getCellByColumnAndRow($sp+$this->coltypestatus, $linha)->setValue(basisofrecords::model()->findByPK($spcm->idbasisofrecord)->basisofrecord);
        //$this->objWorksheet->getCellByColumnAndRow($sp+$this->colgenbanknumber, $linha)->setValue(basisofrecords::model()->findByPK($spcm->idbasisofrecord)->basisofrecord);
        //$this->objWorksheet->getCellByColumnAndRow($sp+$this->colothercatalognumbers, $linha)->setValue(basisofrecords::model()->findByPK($spcm->idbasisofrecord)->basisofrecord);
        //$this->objWorksheet->getCellByColumnAndRow($sp+$this->colrelatedcatalogeditems, $linha)->setValue(basisofrecords::model()->findByPK($spcm->idbasisofrecord)->basisofrecord);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->coldisposition, $linha)->setValue(DispositionAR::model()->findByPK($occ->iddisposition)->disposition);
        $this->objWorksheet->getCellByColumnAndRow($sp+$this->colindividualcount, $linha)->setValue($occ->individualcount);
    }

    public function writeInteractionLine($int, $linha) {
        $sp1 = SpecimenAR::model()->findByPK($int->idspecimen1);
        $this->writeSpLine($this->sp1, $sp1, $linha);
        $sp2 = SpecimenAR::model()->findByPK($int->idspecimen2);
        $this->writeSpLine($this->sp2, $sp2, $linha);

        $this->objWorksheet->getCellByColumnAndRow($this->colinteractiontype, $linha)->setValue(InteractionTypeAR::model()->findByPk($int->idinteractiontype)->interactiontype);
        $this->objWorksheet->getCellByColumnAndRow($this->colinteractionrelatedinformation, $linha)->setValue($int->interactionrelatedinformation);

    }

    /*
    * *** IMPORTAR ***
    */
    public function readSpreadsheet($file) {
        $this->includePHPExcel();
        if(trim($file->extension)=='xls') {
            $objReader = PHPExcel_IOFactory::createReader('Excel5');
            $objReader->setReadDataOnly(true);
            $objReader->setReadFilter(new FilterSpreadsheet());
            $objPHPexcel = $objReader->load(trim($file->path.'/'.$file->filesystemname));
            $this->objWorksheet = $objPHPexcel->getActiveSheet();
            if($this->validateModel())
                $this->import();
            else
                return false;
        }else {
            $this->log[] = '<span style=\"color: red; font-weight: bold;\">ERROR:</span><span style=\"color: red;\"> File is not of valid format.</span>';
            return false;
        }
    }
    public function validateModel() {
        $objPHPexcelM = PHPExcel_IOFactory::load('images/uploaded/grantee_model.xls');
        $objWorksheetM = $objPHPexcelM->getActiveSheet();
        if($objWorksheetM->getCellByColumnAndRow(2, 3)->getValue() == $this->objWorksheet->getCellByColumnAndRow(2, 3)->getValue() &&
                $objWorksheetM->getCellByColumnAndRow(3, 3)->getValue() == $this->objWorksheet->getCellByColumnAndRow(3, 3)->getValue() &&
                $objWorksheetM->getCellByColumnAndRow(4, 3)->getValue() == $this->objWorksheet->getCellByColumnAndRow(4, 3)->getValue() &&
                $objWorksheetM->getCellByColumnAndRow(5, 3)->getValue() == $this->objWorksheet->getCellByColumnAndRow(5, 3)->getValue() &&
                $objWorksheetM->getCellByColumnAndRow(6, 3)->getValue() == $this->objWorksheet->getCellByColumnAndRow(6, 3)->getValue() &&
                $objWorksheetM->getCellByColumnAndRow(7, 3)->getValue() == $this->objWorksheet->getCellByColumnAndRow(7, 3)->getValue() &&
                $objWorksheetM->getCellByColumnAndRow(8, 3)->getValue() == $this->objWorksheet->getCellByColumnAndRow(8, 3)->getValue() &&
                $objWorksheetM->getCellByColumnAndRow(9, 3)->getValue() == $this->objWorksheet->getCellByColumnAndRow(9, 3)->getValue() &&
                $objWorksheetM->getCellByColumnAndRow(1, 3)->getValue() == $this->objWorksheet->getCellByColumnAndRow(1, 3)->getValue() &&
                $objWorksheetM->getCellByColumnAndRow(8, 3)->getValue() == $this->objWorksheet->getCellByColumnAndRow(8, 3)->getValue() &&
                $objWorksheetM->getCellByColumnAndRow(17, 3)->getValue() == $this->objWorksheet->getCellByColumnAndRow(17, 3)->getValue() &&
                $objWorksheetM->getCellByColumnAndRow(28, 3)->getValue() == $this->objWorksheet->getCellByColumnAndRow(28, 3)->getValue()) {
            return true;
        }else {
            $this->log[] = '<span style=\"color: red; font-weight: bold;\">ERROR:</span><span style=\"color: red;\"> File not valid.</span>';
            return false;
        }
    }
    public function import() {

        for($i = $this->firstLine; $i<=$this->objWorksheet->getHighestRow(); $i++) {
            if(!$this->isSpEmpty($this->sp1,$i) || !$this->isSpEmpty($this->sp2,$i)) //tirei o isInteractionEmpty, e troquei && por ||
                $this->insertLine($i);
            else $this->linhabranco++;
        }
        //$this->log[] = ($this->objWorksheet->getHighestRow())-($this->firstLine)-($this->linhabranco).' rows (not empty).';
        $this->log[] = $this->spcreate.' specimen records created.';
        $this->log[] = $this->spupdate.' specimen records updated.';
        $this->log[] = $this->intcreate.' interaction records created.';
        $this->log[] = $this->intupdate.' interaction records updated.';
    }
    public function insertLine($line) {
        /*Insere uma linha*/
        $sp1Valid = $this->isSpValid($this->sp1, $line);
        $sp2Valid = $this->isSpValid($this->sp2, $line);
        // Sp1
        if($sp1Valid)
            $sp1 = $this->insertSpLine($this->sp1, $line);
        // Sp2
        if($sp2Valid)
            $sp2 = $this->insertSpLine($this->sp2, $line);
        // Interaction
        if($sp2Valid&&$sp1Valid)
            if($this->isInteractionValid($line))
                $this->insertInteractionLine($sp1, $sp2, $line);
    }
    public function isSpValid($sp, $linha) {
        /*Verifica se existe algum campo obrigatorio nao preenchido ou nao formatado (data, campos numericos)*/
        if(!$this->isSpEmpty($sp, $linha)) {
            // valida campos necessarios
            if(trim($this->objWorksheet->getCellByColumnAndRow($sp+$this->colbasisofrecord, $linha)->getValue()) !== '') {
                $basis = trim($this->objWorksheet->getCellByColumnAndRow($sp+$this->colbasisofrecord, $linha)->getValue());
                $db = basisofrecords::model()->find('basisofrecord=:p', array(':p'=>$basis));
                if($db == null) {
                    $this->log[] = "<span style=\"color: red; font-weight: bold;\">ERROR:</span><span style=\"color: red;\"> Required field 'Basis of record' in line ".$linha.' is not valid.</span>';
                    return false;
                }
                else
                if(trim($this->objWorksheet->getCellByColumnAndRow($sp+$this->colinstitutioncode, $linha)->getValue()) !== '') {
                    if(trim($this->objWorksheet->getCellByColumnAndRow($sp+$this->colcollectioncode, $linha)->getValue()) !== '') {
                        if(trim($this->objWorksheet->getCellByColumnAndRow($sp+$this->colcatalognumber, $linha)->getValue()) !== '') {
                            if(trim($this->objWorksheet->getCellByColumnAndRow($sp+$this->colscientificname, $linha)->getValue()) !== '') {
                                return true;
                                /*if(trim($this->objWorksheet->getCellByColumnAndRow($sp+$this->colrelatedinformation, $linha)->getValue()) !== '') {

                                } else {
                                    $this->log[] = "<span style=\"color: red; font-weight: bold;\">ERROR:<\span><span style=\"color: red;\"> Required field 'related information' in line ".$linha.' is empty.</span>';
                                    return false;
                                } */
                            } else {
                                $this->log[] = "<span style=\"color: red; font-weight: bold;\">ERROR:</span><span style=\"color: red;\"> Required field 'scientific name' in line ".$linha.' is empty.</span>';
                                return false;
                            }
                        } else {
                            $this->log[] = "<span style=\"color: red; font-weight: bold;\">ERROR:</span><span style=\"color: red;\"> Required field 'catalog number' in line ".$linha.' is empty.</span>';
                            return false;
                        }
                    } else {
                        $this->log[] = "<span style=\"color: red; font-weight: bold;\">ERROR:</span><span style=\"color: red;\"> Required field 'collection code' in line ".$linha.' is empty.</span>';
                        return false;
                    }
                } else {
                    $this->log[] = "<span style=\"color: red; font-weight: bold;\">ERROR:</span><span style=\"color: red;\"> Required field 'institution code' in line ".$linha.' is empty.</span>';
                    return false;
                }
            } else {
                $this->log[] = "<span style=\"color: red; font-weight: bold;\">ERROR:</span><span style=\"color: red;\"> Required field 'basis of record' in line ".$linha.' is empty.</span>';
                return false;
            }
        }else {
            return false;
        }
    }
    public function isInteractionValid($linha) {
        /*Verifica se tipo de interacao existe*/
        if(!$this->isInteractionEmpty($linha)) {
            //find
            //if retorna null -> return false, manda pro log.
            //log => dois tipos de erro > valor vazio ou que nao faz parte de vcbulario controlado
            if(trim($this->objWorksheet->getCellByColumnAndRow($this->colinteractiontype, $linha)->getValue()) !== '') {
                $int = $this->objWorksheet->getCellByColumnAndRow($this->colinteractiontype, $linha)->getValue();
                $db = interactiontypes::model()->find('interactiontype=:v', array(':v'=>trim($int)));
                if ($db !== null) {
                    return true;
                    //interactionrelatedinformation so e' obrigatorio pra 'interaction data obtained from bibliography'...
                    /*if(trim($this->objWorksheet->getCellByColumnAndRow($this->colinteractionrelatedinformation, $linha)->getValue()) !== '') {
                        return true;
                    } else {
                        $this->log[] = "<span style=\"color: red; font-weight: bold;\">ERROR:<\span><span style=\"color: red;> Required field 'Interaction related information' in line ".$linha.' is empty.<\span>';
                        return false;
                    }*/
                } else {
                    $this->log[] = "<span style=\"color: red; font-weight: bold;\">ERROR:</span><span style=\"color: red;\"> 'Interaction type' in line ".$linha.' is not valid.</span>';
                    return false;
                }
            } else {
                $this->log[] = "<span style=\"color: red; font-weight: bold;\">ERROR:</span><span style=\"color: red;\"> Required field 'Interaction type' in line ".$linha.' is empty.</span>';
                return false;
            }
        }else {
            return false;
        }
    }
    public function isSpEmpty($sp, $linha) {
        //verifica se algum campo obrigatorio nao esta preenchido
        if(trim($this->objWorksheet->getCellByColumnAndRow($sp+$this->colbasisofrecord, $linha)->getValue()) == '' &&
                trim($this->objWorksheet->getCellByColumnAndRow($sp+$this->colinstitutioncode, $linha)->getValue()) == '' &&
                trim($this->objWorksheet->getCellByColumnAndRow($sp+$this->colcollectioncode, $linha)->getValue()) == '' &&
                trim($this->objWorksheet->getCellByColumnAndRow($sp+$this->colcatalognumber, $linha)->getValue()) == '' &&
                trim($this->objWorksheet->getCellByColumnAndRow($sp+$this->colscientificname, $linha)->getValue()) == '' /*&&
                trim($this->objWorksheet->getCellByColumnAndRow($sp+$this->colrelatedinformation, $linha)->getValue()) == ''*/) {
            return true;
        }else {
            return false;
        }

    }
    public function isInteractionEmpty($linha) {
        /*verifica se NENHUM dos campos obrigatorios estao preenchidos*/
        if(trim($this->objWorksheet->getCellByColumnAndRow($this->colinteractiontype, $linha)->getValue()) == '' &&
                trim($this->objWorksheet->getCellByColumnAndRow($this->colinteractionrelatedinformation, $linha)->getValue()) == '') {
            $this->intbranco++;
            return true;
        }else
            return false;
    }
    public function insertSpLine($sp, $linha) {
        /*Insere um Sp*/
        $gui = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colinstitutioncode, $linha)->getValue();
        $gui = $gui.':'.$this->objWorksheet->getCellByColumnAndRow($sp+$this->colcollectioncode, $linha)->getValue();
        $gui = $gui.':'.$this->objWorksheet->getCellByColumnAndRow($sp+$this->colcatalognumber, $linha)->getValue();
        $rec = recordlevelelements::model()->find('globaluniqueidentifier=:v',array(':v'=>$gui));
        if($rec==null) {
            $rec = new recordlevelelements();
            $rec->setIsNewRecord(true);
            $this->spcreate++;
        }else {
            $rec->setIsNewRecord(false);
            $this->spupdate++;
        }
        $rec->globaluniqueidentifier = $gui;

        $n1 = basisofrecords::model()->find('basisofrecord=:p' , array(':p'=>trim($this->objWorksheet->getCellByColumnAndRow($sp+$this->colbasisofrecord, $linha)->getValue())));
        if($n1 == null) {
            $n1 = new basisofrecords();
            $n1->setIsNewRecord(true);
            $n1->basisofrecord = trim($this->objWorksheet->getCellByColumnAndRow($sp+$this->colbasisofrecord, $linha)->getValue());
            $n1->save();
        }
        $rec->idbasisofrecord = $n1->idbasisofrecord;

        $n1 = institutioncodes::model()->find('institutioncode=:p' , array(':p'=>trim($this->objWorksheet->getCellByColumnAndRow($sp+$this->colinstitutioncode, $linha)->getValue())));
        if($n1 == null) {
            $n1 = new institutioncodes();
            $n1->setIsNewRecord(true);
            $n1->institutioncode = trim($this->objWorksheet->getCellByColumnAndRow($sp+$this->colinstitutioncode, $linha)->getValue());
            $n1->save();
        }
        $rec->idinstitutioncode = $n1->idinstitutioncode;

        $n1 = collectioncodes::model()->find('collectioncode=:p' , array(':p'=>$this->objWorksheet->getCellByColumnAndRow($sp+$this->colcollectioncode, $linha)->getValue()));
        if($n1 == null) {
            $n1 = new collectioncodes();
            $n1->setIsNewRecord(true);
            $n1->collectioncode = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colcollectioncode, $linha)->getValue();
            $n1->save();
        }
        $rec->idcollectioncode = $n1->idcollectioncode;
        $rec->informationwithheld = trim($this->objWorksheet->getCellByColumnAndRow($sp+$this->colinformationwithheld, $linha)->getValue());
        $rec->dynamicproperties = trim($this->objWorksheet->getCellByColumnAndRow($sp+$this->colattributes, $linha)->getValue());
        //basisofrecords::model()->findByPK($rec->idbasisofrecord)->basisofrecord = $this->objWorksheet->getCellByColumnAndRow($sp+$this->coldayofyear, $linha)->getValue();
        //basisofrecords::model()->findByPK($rec->idbasisofrecord)->basisofrecord = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colcollector, $linha)->getValue();
        //basisofrecords::model()->findByPK($rec->idbasisofrecord)->basisofrecord = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colcollector, $linha)->getValue();
        //basisofrecords::model()->findByPK($rec->idbasisofrecord)->basisofrecord = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colimageurl, $linha)->getValue();
        //basisofrecords::model()->findByPK($rec->idbasisofrecord)->basisofrecord = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colcatalognumbercur, $linha)->getValue();
        //basisofrecords::model()->findByPK($rec->idbasisofrecord)->basisofrecord = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colidentifiedby, $linha)->getValue();
        //basisofrecords::model()->findByPK($rec->idbasisofrecord)->basisofrecord = $this->objWorksheet->getCellByColumnAndRow($sp+$this->coltypestatus, $linha)->getValue();
        //basisofrecords::model()->findByPK($rec->idbasisofrecord)->basisofrecord = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colgenbanknumber, $linha)->getValue();
        //basisofrecords::model()->findByPK($rec->idbasisofrecord)->basisofrecord = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colothercatalognumbers, $linha)->getValue();
        //basisofrecords::model()->findByPK($rec->idbasisofrecord)->basisofrecord = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colrelatedcatalogeditems, $linha)->getValue();

        // OCCURRENCE
        $disp = disposition::model()->find('disposition=:p' , array(':p'=>trim($this->objWorksheet->getCellByColumnAndRow($sp+$this->coldisposition, $linha)->getValue())));
        if($disp == null) {
            $disp = new disposition();
            $disp->setIsNewRecord(true);
            $disp->disposition = trim($this->objWorksheet->getCellByColumnAndRow($sp+$this->coldisposition, $linha)->getValue());
            $disp->save();
        }

        $sex = sexes::model()->find('sex=:p' , array(':p'=>trim($this->objWorksheet->getCellByColumnAndRow($sp+$this->colsex, $linha)->getValue())));
        if($sex == null) {
            $sex = new sexes();
            $sex->setIsNewRecord(true);
            $sex->sex = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colsex, $linha)->getValue();
            $sex->save();
        }

        $life = lifestages::model()->find('lifestage=:p' , array(':p'=>trim($this->objWorksheet->getCellByColumnAndRow($sp+$this->collifestage, $linha)->getValue())));
        if($life == null) {
            $life = new lifestages();
            $life->setIsNewRecord(true);
            $life->lifestage = trim($this->objWorksheet->getCellByColumnAndRow($sp+$this->collifestage, $linha)->getValue());
            $life->save();
        }

        $occ = occurrenceelements::model()->findByPk($rec->idoccurrenceelements);
        if($occ == null) {
            $occ = new occurrenceelements();
            $occ->setIsNewRecord(true);
        }else {
            $occ->setIsNewRecord(false);
        }
        $occ->iddisposition = $disp->iddisposition;
        $occ->idsex = $sex->idsex;
        $occ->idlifestage = $life->idlifestage;
        $var = trim($this->objWorksheet->getCellByColumnAndRow($sp+$this->colindividualcount, $linha)->getValue());
        if (is_numeric($var) || $var == '') {
            $occ->individualcount = $var;
        } else $this->log[] = "<span style=\"color: orange; font-weight: bold;\">WARNING:</span><span style=\"color: orange;\"> Field 'Individual count' in line ".$linha.' is not of valid format (value ignored).</span>';
        $occ->recordnumber = trim($this->objWorksheet->getCellByColumnAndRow($sp+$this->colcollectornumber, $linha)->getValue());
        $occ->occurrencedetails = trim($this->objWorksheet->getCellByColumnAndRow($sp+$this->colrelatedinformation, $linha)->getValue());
        $occ->catalognumber = trim($this->objWorksheet->getCellByColumnAndRow($sp+$this->colcatalognumber, $linha)->getValue());
        $occ->occurrenceremarks = trim($this->objWorksheet->getCellByColumnAndRow($sp+$this->colremarks, $linha)->getValue());
        $occ->save();

        $rec->idoccurrenceelements = $occ->idoccurrenceelements;

        //TAXONOMIC
        $sciname = scientificnames::model()->find('scientificname=:p' , array(':p'=>trim($this->objWorksheet->getCellByColumnAndRow($sp+$this->colscientificname, $linha)->getValue())));
        if($sciname== null) {
            $sciname = new scientificnames();
            $sciname->setIsNewRecord(true);
            $sciname->scientificname = trim($this->objWorksheet->getCellByColumnAndRow($sp+$this->colscientificname, $linha)->getValue());
            $sciname->save();
        }
        $king = kingdoms::model()->find('kingdom=:p' , array(':p'=>trim($this->objWorksheet->getCellByColumnAndRow($sp+$this->colkingdom, $linha)->getValue())));
        if($king == null) {
            $king = new kingdoms();
            $king->setIsNewRecord(true);
            $king->kingdom = trim($this->objWorksheet->getCellByColumnAndRow($sp+$this->colkingdom, $linha)->getValue());
            $king->save();
        }
        $phyl = phylums::model()->find('phylum=:p' , array(':p'=>$this->objWorksheet->getCellByColumnAndRow($sp+$this->colphylum, $linha)->getValue()));
        if($phyl == null) {
            $phyl = new phylums();
            $phyl->setIsNewRecord(true);
            $phyl->phylum = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colphylum, $linha)->getValue();
            $phyl->save();
        }
        $class = classes::model()->find('class=:p' , array(':p'=>$this->objWorksheet->getCellByColumnAndRow($sp+$this->colclass, $linha)->getValue()));
        if($class == null) {
            $class = new classes();
            $class->setIsNewRecord(true);
            $class->class = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colclass, $linha)->getValue();
            $class->save();
        }
        $order = orders::model()->find('\'order\'=:p' , array(':p'=>$this->objWorksheet->getCellByColumnAndRow($sp+$this->colorder, $linha)->getValue()));
        if($order == null) {
            $order = new orders();
            $order->setIsNewRecord(true);
            $order->order = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colorder, $linha)->getValue();
            $order->save();
        }
        $fam = families::model()->find('family=:p' , array(':p'=>$this->objWorksheet->getCellByColumnAndRow($sp+$this->colfamily, $linha)->getValue()));
        if($fam == null) {
            $fam = new families();
            $fam->setIsNewRecord(true);
            $fam->family = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colfamily, $linha)->getValue();
            $fam->save();
        }
        $gen = genus::model()->find('genus=:p' , array(':p'=>$this->objWorksheet->getCellByColumnAndRow($sp+$this->colgenus, $linha)->getValue()));
        if($gen == null) {
            $gen = new genus();
            $gen->setIsNewRecord(true);
            $gen->genus = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colgenus, $linha)->getValue();
            $gen->save();
        }
        $spep = specificepithets::model()->find('specificepithet=:p' , array(':p'=>$this->objWorksheet->getCellByColumnAndRow($sp+$this->colspecificepithet, $linha)->getValue()));
        if($spep == null) {
            $spep = new specificepithets();
            $spep->setIsNewRecord(true);
            $spep->specificepithet = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colspecificepithet, $linha)->getValue();
            $spep->save();
        }
        $txrnk = taxonranks::model()->find('taxonrank=:p' , array(':p'=>$this->objWorksheet->getCellByColumnAndRow($sp+$this->colinfraspecificrank, $linha)->getValue()));
        if($txrnk == null) {
            $txrnk = new taxonranks();
            $txrnk->setIsNewRecord(true);
            $txrnk->taxonrank = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colinfraspecificrank, $linha)->getValue();
            $txrnk->save();
        }
        $infep = infraspecificepithets::model()->find('infraspecificepithet=:p' , array(':p'=>$this->objWorksheet->getCellByColumnAndRow($sp+$this->colinfraspecificepithet, $linha)->getValue()));
        if($infep == null) {
            $infep = new infraspecificepithets();
            $infep->setIsNewRecord(true);
            $infep->infraspecificepithet = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colinfraspecificepithet, $linha)->getValue();
            $infep->save();
        }
        $scauth = scientificnameauthorship::model()->find('scientificnameauthorship=:p' , array(':p'=>$this->objWorksheet->getCellByColumnAndRow($sp+$this->colauthoryearscientificname, $linha)->getValue()));
        if($scauth == null) {
            $scauth = new scientificnameauthorship();
            $scauth->setIsNewRecord(true);
            $scauth->scientificnameauthorship = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colauthoryearscientificname, $linha)->getValue();
            $scauth->save();
        }
        $nmcode = nomenclaturalcodes::model()->find('nomenclaturalcode=:p' , array(':p'=>$this->objWorksheet->getCellByColumnAndRow($sp+$this->colnomenclaturalcode, $linha)->getValue()));
        if($nmcode == null) {
            $nmcode = new nomenclaturalcodes();
            $nmcode->setIsNewRecord(true);
            $nmcode->nomenclaturalcode = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colnomenclaturalcode, $linha)->getValue();
            $nmcode->save();
        }

        $tax = taxonomicelements::model()->findByPk($rec->idtaxonomicelements);
        if($tax == null) {
            $tax = new taxonomicelements();
            $tax->setIsNewRecord(true);
        }else {
            $tax->setIsNewRecord(false);
        }
        $tax->idscientificname = $sciname->idscientificname;
        $tax->idkingdom = $king->idkingdom;
        $tax->idphylum = $phyl->idphylum;
        $tax->idclass = $class->idclass;
        $tax->idorder = $order->idorder;
        $tax->idfamily = $fam->idfamily;
        $tax->idgenus = $gen->idgenus;
        $tax->idspecificepithet = $spep->idspecificepithet;
        $tax->idtaxonrank = $txrnk->idtaxonrank;
        $tax->idinfraspecificepithet = $infep->idinfraspecificepithet;
        $tax->idscientificnameauthorship = $scauth->idscientificnameauthorship;
        $tax->idnomenclaturalcode = $nmcode->idnomenclaturalcode;
        //identificationqualifiers::model()->findByPK($tax->ididentificationqualifier)->identificationqualifier = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colidentificationqualifier, $linha)->getValue();

        $higherclassification .= ($tax->idkingdom <> NULL ? $king->kingdom.";" : "");
        $higherclassification .= ($tax->idphylum <> NULL ? $phyl->phylum.";" : "");
        $higherclassification .= ($tax->idclass <> NULL ? $class->class.";" : "");
        $higherclassification .= ($tax->idorder <> NULL ? $order->order.";" : "");
        $higherclassification .= ($tax->idfamily <> NULL ? $fam->family.";" : "");
        $higherclassification .= ($tax->idgenus <> NULL ? $gen->genus.";" : "");

        $higherclassification = preg_replace("/;$/", "", $higherclassification);
        $higherclassification = preg_replace("/^;/", "", $higherclassification);

        $tax->higherclassification = $higherclassification;

        $tax->save();

        $rec->idtaxonomicelements = $tax->idtaxonomicelements;

        //LOCALITY
        $cont = continents::model()->find('continent=:p' , array(':p'=>$this->objWorksheet->getCellByColumnAndRow($sp+$this->colcontinent, $linha)->getValue()));
        if($cont == null) {
            $cont = new continents();
            $cont->setIsNewRecord(true);
            $cont->continent = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colcontinent, $linha)->getValue();
            $cont->save();
        }
        $wtbod = waterbodies::model()->find('waterbody=:p' , array(':p'=>$this->objWorksheet->getCellByColumnAndRow($sp+$this->colwaterbody, $linha)->getValue()));
        if($wtbod == null) {
            $wtbod = new waterbodies();
            $wtbod->setIsNewRecord(true);
            $wtbod->waterbody = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colwaterbody, $linha)->getValue();
            $wtbod->save();
        }
        $isgrp = islandgroups::model()->find('islandgroup=:p' , array(':p'=>$this->objWorksheet->getCellByColumnAndRow($sp+$this->colislandgroup, $linha)->getValue()));
        if($isgrp == null) {
            $isgrp = new islandgroups();
            $isgrp->setIsNewRecord(true);
            $isgrp->islandgroup = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colislandgroup, $linha)->getValue();
            $isgrp->save();
        }
        $isld = islands::model()->find('island=:p' , array(':p'=>$this->objWorksheet->getCellByColumnAndRow($sp+$this->colisland, $linha)->getValue()));
        if($isld == null) {
            $isld = new islands();
            $isld->setIsNewRecord(true);
            $isld->island = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colisland, $linha)->getValue();
            $isld->save();
        }
        $countr = countries::model()->find('country=:p' , array(':p'=>$this->objWorksheet->getCellByColumnAndRow($sp+$this->colcountry, $linha)->getValue()));
        if($countr == null) {
            $countr = new countries();
            $countr->setIsNewRecord(true);
            $countr->country = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colcountry, $linha)->getValue();
            $countr->save();
        }
        $stpr = stateprovinces::model()->find('stateprovince=:p' , array(':p'=>$this->objWorksheet->getCellByColumnAndRow($sp+$this->colstateorprovince, $linha)->getValue()));
        if($stpr == null) {
            $stpr = new stateprovinces();
            $stpr->setIsNewRecord(true);
            $stpr->stateprovince = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colstateorprovince, $linha)->getValue();
            $stpr->save();
        }
        $municipality = municipality::model()->find('municipality=:p' , array(':p'=>$this->objWorksheet->getCellByColumnAndRow($sp+$this->colcounty, $linha)->getValue()));
        if($municipality == null) {
            $municipality = new municipality();
            $municipality->setIsNewRecord(true);
            $municipality->municipality = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colcounty, $linha)->getValue();
            $municipality->save();
        }
        $local = localities::model()->find('locality=:p' , array(':p'=>$this->objWorksheet->getCellByColumnAndRow($sp+$this->collocality, $linha)->getValue()));
        if($local == null) {
            $local = new localities();
            $local->setIsNewRecord(true);
            $local->locality = $this->objWorksheet->getCellByColumnAndRow($sp+$this->collocality, $linha)->getValue();
            $local->save();
        }

        $loc = localityelements::model()->findByPk($rec->idlocalityelements);
        if($loc == null) {
            $loc = new localityelements();
            $loc->setIsNewRecord(true);
        }else {
            $loc->setIsNewRecord(false);
        }

        $loc->idcontinent = $cont->idcontinent;
        $loc->idwaterbody = $wtbod->idwaterbody;
        $loc->idislandgroup = $isgrp->idislandgroup;
        $loc->idisland = $isld->idisland;
        $loc->idcountry = $countr->idcountry;
        $loc->idstateprovince = $stpr->idstateprovince;
        $loc->idmunicipality = $municipality->idmunicipality;
        $loc->idlocality = $local->idlocality;

        $var = trim($this->objWorksheet->getCellByColumnAndRow($sp+$this->colminimumelevationinmeters, $linha)->getValue());
        if (is_numeric($var) || $var == '') {
            $loc->minimumelevationinmeters = $var;
        } else $this->log[] = "<span style=\"color: orange; font-weight: bold;\">WARNING:</span><span style=\"color: orange;\"> Field 'Minimum elevation in meters' in line ".$linha.' is not of valid format (value ignored).</span>';
        $var = trim($this->objWorksheet->getCellByColumnAndRow($sp+$this->colminimumdepthinmeters, $linha)->getValue());
        if (is_numeric($var) || $var == '') {
            $loc->minimumdepthinmeters = $var;
        } else $this->log[] = "<span style=\"color: orange; font-weight: bold;\">WARNING:</span><span style=\"color: orange;\"> Field 'Minimum depth in meters' in line ".$linha.' is not of valid format (value ignored).</span>';
        $var = trim($this->objWorksheet->getCellByColumnAndRow($sp+$this->colmaximumelevationinmeters, $linha)->getValue());
        if (is_numeric($var) || $var == '') {
            $loc->maximumelevationinmeters = $var;
        } else $this->log[] = "<span style=\"color: orange; font-weight: bold;\">WARNING:</span><span style=\"color: orange;\"> Field 'Maximum elevation in meters' in line ".$linha.' is not of valid format (value ignored).</span>';
        $var = trim($this->objWorksheet->getCellByColumnAndRow($sp+$this->colmaximumdepthinmeters, $linha)->getValue());
        if (is_numeric($var) || $var == '') {
            $loc->maximumdepthinmeters = $var;
        } else $this->log[] = "<span style=\"color: orange; font-weight: bold;\">WARNING:</span><span style=\"color: orange;\"> Field 'Maximum depth in meters' in line ".$linha.' is not of valid format (value ignored).</span>';
        $loc->verbatimelevation = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colverbatimelevation, $linha)->getValue();
        $loc->verbatimdepth = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colverbatimdepth, $linha)->getValue();
        //$loc->idbasisofrecord)->basisofrecord = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colpreparations, $linha)->getValue();
        $loc->save();

        $rec->idlocalityelements = $loc->idlocalityelements;

        //EVENT
        $n1 = samplingprotocols::model()->find('samplingprotocol=:p' , array(':p'=>$this->objWorksheet->getCellByColumnAndRow($sp+$this->colcollectingmethod, $linha)->getValue()));
        if($n1 == null) {
            $n1 = new samplingprotocols();
            $n1->setIsNewRecord(true);
            $n1->samplingprotocol = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colcollectingmethod, $linha)->getValue();
            $n1->save();
        }

        $eve = eventelements::model()->findByPk($rec->ideventelements);
        if($eve == null) {
            $eve = new eventelements();
            $eve->setIsNewRecord(true);
        }else {
            $eve->setIsNewRecord(false);
        }

        $eve->idsamplingprotocol = $n1->idsamplingprotocol;
        //establishmentmeans::model()->findByPK($eve->idestablishmentmeans)->basisofrecord = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colvaliddistributionflag, $linha)->getValue();
        //$eve->eventdate = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colearliestdatecollected, $linha)->getValue();
        //$eve->eventdate = $this->objWorksheet->getCellByColumnAndRow($sp+$this->collatestdatecollected, $linha)->getValue();
        $eve->fieldnumber = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colfieldnumber, $linha)->getValue();
        $eve->fieldnotes = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colfieldnotes, $linha)->getValue();
        $eve->verbatimeventdate = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colverbatimcollectingdate, $linha)->getValue();
        $eve->save();

        $rec->ideventelements = $eve->ideventelements;


        //GEOSPATIAL
        $n1 = georeferenceverificationstatus::model()->find('georeferenceverificationstatus=:p' , array(':p'=>$this->objWorksheet->getCellByColumnAndRow($sp+$this->colverificationstatus, $linha)->getValue()));
        if($n1 == null) {
            $n1 = new georeferenceverificationstatus();
            $n1->setIsNewRecord(true);
            $n1->georeferenceverificationstatus = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colverificationstatus, $linha)->getValue();
            $n1->save();
        }

        $geo = geospatialelements::model()->findByPk($rec->idgeospatialelements);
        if($geo == null) {
            $geo = new geospatialelements();
            $geo->setIsNewRecord(true);
        }else {
            $geo->setIsNewRecord(false);
        }

        $geo->idgeoreferenceverificationstatus = $n1->idgeoreferenceverificationstatus;
        $geo->decimallatitude = $this->objWorksheet->getCellByColumnAndRow($sp+$this->coldecimallatitude, $linha)->getValue();
        $geo->decimallongitude = $this->objWorksheet->getCellByColumnAndRow($sp+$this->coldecimallongitude, $linha)->getValue();
        $geo->geodeticdatum = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colgeodeticdatum, $linha)->getValue();
        $geo->coordinateuncertaintyinmeters = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colcoordinateuncertaintyinmeters, $linha)->getValue();
        $geo->pointradiusspatialfit = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colpointradiusspatialfit, $linha)->getValue();
        $geo->verbatimcoordinates = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colverbatimcoordinates, $linha)->getValue();
        $geo->verbatimlatitude = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colverbatimlatitude, $linha)->getValue();
        $geo->verbatimlongitude = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colverbatimlongitude, $linha)->getValue();
        $geo->verbatimcoordinatesystem = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colverbatimcoordinatesystem, $linha)->getValue();
        $geo->georeferenceprotocol = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colgeoreferenceprotocol, $linha)->getValue();
        //$geo->georeferencesources = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colgeoreferencesources, $linha)->getValue();
        $geo->georeferenceremarks = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colgeospatialremarks, $linha)->getValue();
        $geo->footprintwkt = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colfootprintwkt, $linha)->getValue();
        $geo->footprintspatialfit = $this->objWorksheet->getCellByColumnAndRow($sp+$this->colfootprintspatialfit, $linha)->getValue();
        $geo->save();

        $rec->idgeospatialelements = $geo->idgeospatialelements;

        /*$ide = identificationelements::model()->findByPk($rec->ididentificationelements);
        if($ide == null) {
            $ide = new identificationelements();
            $ide->setIsNewRecord(true);
        }else {
            $ide->setIsNewRecord(false);
        }
        $ide->dateidentified = $this->objWorksheet->getCellByColumnAndRow($sp+$this->coldateidentified, $linha)->getValue();

        $ide->save();

        $rec->ididentificationelements = $ide->ididentificationelements;
        */
        $rec->modified = date('Y-m-d G:i:s');

        $rec->save();
        return $rec;


    }
    public function insertInteractionLine($sp1, $sp2, $linha) {
        /*Insere um Interaction*/

        $inttype = interactiontypes::model()->find('interactiontype=:int', array(':int'=>trim($this->objWorksheet->getCellByColumnAndRow($this->colinteractiontype, $linha)->getValue())));


        $int = interactionelements::model()->find('idinteractiontype=:int and idspecimens1=:sp1 and idspecimens2 =:sp2', array (':int'=>$inttype->idinteractiontype, ':sp1'=>$sp1->idrecordlevelelements, ':sp2'=>$sp2->idrecordlevelelements));
        if ($int == null) {
            $int = new interactionelements();
            $int->setIsNewRecord(true);
            $this->intcreate++;
            $int->idinteractiontype = $inttype->idinteractiontype;
            $int->idspecimens1 = $sp1->idrecordlevelelements;
            $int->idspecimens2 = $sp2->idrecordlevelelements;
        }else {
            $int->setIsNewRecord(false);
            $this->intupdate++;
        }

        $int->interactionrelatedinformation = $this->objWorksheet->getCellByColumnAndRow($this->colinteractionrelatedinformation, $linha)->getValue();
        $int->save();

    }
}
class FilterSpreadsheet implements PHPExcel_Reader_IReadFilter {
    function __construct() {
        $this->includeRecurse('resources/Classes/PHPExcel/Cell');
    }
    function includeRecurse($dirName) {
        if(!is_dir($dirName))
            return false;
        $dirHandle = opendir($dirName);
        while(false !== ($incFile = readdir($dirHandle))) {
            if($incFile != "."
                    && $incFile != "..") {
                if(is_file("$dirName/$incFile"))
                    include_once("$dirName/$incFile");
                elseif(is_dir("$dirName/$incFile"))
                    $this->includeRecurse("$dirName/$incFile");
            }
        }
        closedir($dirHandle);
    }
    public function readCell($column, $row, $worksheetName = '') {
        // Read title row and rows 20 - 30
        if ($row == 1 || ($row >= 1 && $row <= 500)) {
            return true;
        }

        return false;
    }
}
?>