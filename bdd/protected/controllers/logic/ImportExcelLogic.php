<?php
require_once ('resources/Excel/reader.php');
include_once 'SpecimenLogic.php';

class ImportExcelLogic {
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

    var $colinteractiontype=109;
    var $colinteractionrelatedinformation=110;

    var $sp2=111;
    var $sp1=1;

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
    public $spdelete = 0;
    public $spfail = 0;
    public $intcreate = 0;
    public $intupdate = 0;
    public $linebranco = 0;

    // construtor: data e hora do inicio do processo.
    public function __construct() {
        $this->datahora = date ("jmYHis");
    }

    /*
    * *** IMPORTAR ***
    */
    public function readSpreadsheet($file) {
        if(trim($file->extension)=='xls') {
            $objReader = new Spreadsheet_Excel_Reader();
            $objReader->setOutputEncoding("CP-1251");            //$objReader->setOutputEncoding("LATIN-1");
            $objReader->read(trim($file->path.'/'.$file->filesystemname));
            $this->objWorksheet = $objReader;
            //echo ('linebranco: '); var_dump($this->logic->linebranco); echo ('<br>');
            //echo ('numRows: '); var_dump($this->objWorksheet->sheets[0]["numRows"]); echo ('<br>');
            $validate = $this->validateModel();
            if($validate)
                $this->import();
            else
                return false;
        }else {
            $this->log[] = '<span style=\"color: red; font-weight: bold;\">ERROR:</span><span style=\"color: red;\"> File is not of valid format. Please use only Excel (.xls) files.</span>';
            return false;
        }
    }
    public function validateModel() {
        $objPHPexcelM = new Spreadsheet_Excel_Reader();
        $objPHPexcelM->setOutputEncoding("UTF-8");
        $objPHPexcelM->read('images/uploaded/spreadsheetsync_model.xls');
        $objWorksheetM = $objPHPexcelM;
        $validate = true;
        for($i=1; $i <= $this->sp2+$this->colfootprintspatialfit; $i++)
            if($objWorksheetM->sheets[0]["cells"][3][$i] != $this->objWorksheet->sheets[0]["cells"][3][$i])
                $validate = false;
        if (!$validate)
            $this->log[] = '<span style=\"color: red; font-weight: bold;\">ERROR:</span><span style=\"color: red;\"> File not valid. Please use the sheet model available for download.</span>';
        return $validate;
        //return true;
    }
    public function import() {

        try {
            for($i = $this->firstLine; $i<=$this->objWorksheet->sheets[0]["numRows"] ; $i++) {  //$this->linebranco<15
                if(!$this->isSpEmpty($this->sp1,$i) || !$this->isSpEmpty($this->sp2,$i))
                    $this->insertLine($i);
                else $this->linebranco++;
            }
            //$this->log[] = ($this->objWorksheet->sheets[0]["numRows"])-($this->firstLine)-($this->linhabranco).' rows (not empty).';
            if($this->spcreate > 0)
                $this->log[] = $this->spcreate.' specimen records created.';
            if($this->spupdate > 0)
                $this->log[] = $this->spupdate.' specimen records updated.';
            if($this->spdelete > 0)
                $this->log[] = $this->spdelete.' specimen records deleted.';
            if($this->intcreate > 0)
                $this->log[] = $this->intcreate.' interaction records created.';
            if($this->intupdate > 0)
                $this->log[] = $this->intupdate.' interaction records updated.';
            if($this->spfail > 0)
                $this->log[] = $this->spfail.' specimen records not inserted (failed).';
            if ($this->spcreate==0 && $this->spupdate==0 && $this->spdelete==0 && $this->intcreate==0 && $this->intupdate==0 && $this->spfail==0)
                $this->log[] = 'NO records were created, updated, deleted or failed. Was the spreadsheet empty?';
        } catch (Exception $e) {
            var_dump($e->getMessage());
            $this->log[] = '<span style=\"color: red; font-weight: bold;\">ERROR:</span><span style=\"color: red;\"> Some error occurred. Make sure the file is valid and try again.</span>';
        }
    }
    public function insertLine($line) {
        //throw new Exception('<span style=\"color: red; font-weight: bold;\">ERROR:</span><span style=\"color: red;\"> File not valid.</span>');
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
        if($sp2Valid&&$sp1Valid&&$sp1&&$sp2)
            if($this->isInteractionValid($line))
                $this->insertInteractionLine($sp1, $sp2, $line);
    }
    public function isSpValid($sp, $line) {
        /*Verifica se existe algum campo obrigatorio nao preenchido ou nao formatado (data, campos numericos)*/
        if(!$this->isSpEmpty($sp, $line)) {
            // valida campos necessarios
            if(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colbasisofrecord]) != '') {
                if(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colinstitutioncode]) != '') {
                    if(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colcollectioncode]) != '') {
                        if(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colcatalognumber]) != '') {
                            if(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colscientificname]) != '' ||
                                    trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colgenus]) != '' ||
                                    trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colfamily]) != '') {
                                return true;
                                /*if(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->coloccurrencedetails]) != '') {

                                } else {
                                    $this->log[] = "<span style=\"color: red; font-weight: bold;\">ERROR:<\span><span style=\"color: red;\"> Required field 'related information' in line ".$line.', specimen '.($sp==$this->sp1?1:2).' , Specimen'.$sp==$this->sp1?'1':'2'.' is empty.</span>';
                                    return false;
                                } */
                            } else {
                                $this->log[] = "<span style=\"color: red; font-weight: bold;\">ERROR:</span><span style=\"color: red;\"> Required field 'scientific name' in line ".$line.', specimen '.($sp==$this->sp1?1:2).'  is empty.</span>';
                                return false;
                            }
                        } else {
                            $this->log[] = "<span style=\"color: red; font-weight: bold;\">ERROR:</span><span style=\"color: red;\"> Required field 'catalog number' in line ".$line.', specimen '.($sp==$this->sp1?1:2).'  is empty.</span>';
                            return false;
                        }
                    } else {
                        $this->log[] = "<span style=\"color: red; font-weight: bold;\">ERROR:</span><span style=\"color: red;\"> Required field 'collection code' in line ".$line.', specimen '.($sp==$this->sp1?1:2).'  is empty.</span>';
                        return false;
                    }
                } else {
                    $this->log[] = "<span style=\"color: red; font-weight: bold;\">ERROR:</span><span style=\"color: red;\"> Required field 'institution code' in line ".$line.', specimen '.($sp==$this->sp1?1:2).'  is empty.</span>';
                    return false;
                }
            } else {
                $this->log[] = "<span style=\"color: red; font-weight: bold;\">ERROR:</span><span style=\"color: red;\"> Required field 'basis of record' in line ".$line.', specimen '.($sp==$this->sp1?1:2).' is empty.</span>';
                return false;
            }
        }else {
            return false;
        }
    }
    public function isInteractionValid($line) {
        /*Verifica se tipo de interacao existe*/
        if(!$this->isInteractionEmpty($line)) {
            //find
            //if retorna null -> return false, manda pro log.
            //log => dois tipos de erro > valor vazio ou que nao faz parte de vcbulario controlado
            if(trim($this->objWorksheet->sheets[0]["cells"][$line][$this->colinteractiontype]) == '') {
                $this->log[] = "<span style=\"color: red; font-weight: bold;\">ERROR:</span><span style=\"color: red;\"> Required field 'Interaction type' in line ".$line.' is empty.</span>';
                return false;
            } else return true;
        }else {
            return false;
        }
    }
    public function isSpEmpty($sp, $line) {
        //verifica se NENHUM dos campos obrigatorios esta preenchido
        if(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colbasisofrecord]) == '' &&
                trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colinstitutioncode]) == '' &&
                trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colcollectioncode]) == '' &&
                trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colcatalognumber]) == '' &&
                trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colscientificname]) == '' /*&&
                trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->coloccurrencedetails]) == ''*/) {
            return true;
        }else {
            return false;
        }

    }
    public function isInteractionEmpty($line) {
        //verifica se NENHUM dos campos obrigatorios esta preenchidos
        if(trim($this->objWorksheet->sheets[0]["cells"][$line][$this->colinteractiontype]) == '' &&
                trim($this->objWorksheet->sheets[0]["cells"][$line][$this->colinteractionrelatedinformation]) == '') {
            $this->intbranco++;
            return true;
        }else
            return false;
    }
    public function insertSpLine($sp, $line) {
        /*Insere um Sp*/
        $gui = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colinstitutioncode]));
        $gui = $gui.':'.utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colcollectioncode]));
        $gui = $gui.':'.utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colcatalognumber]));
        $spLogic = new SpecimenLogic();
        $spcm = $spLogic->getSpecimenByGUI($gui);
        //$this->log[]='Linha: '.$line.'\t Specimen: '.($sp==$this->sp1?1:2).'\t GUI: '.$spcm->recordlevelelement->globaluniqueidentifier.' = '.$gui;

        /*Verifica DELETE*/
        if (strtoupper(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->coldelete]))=='YES') {
            if ($spcm) {
                $spLogic->delete($spcm->idspecimen);
                $this->spdelete++;
            }
            return false;
        }

        $spcm = $spcm==null?$spLogic->fillDependency(new SpecimenAR()):$spcm;

        //RECORD LEVEL
        if(strtoupper(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colprivate]))=='YES')
            $spcm->recordlevelelement->isrestricted=true;
        include_once 'BasisOfRecordLogic.php';
        $n1 = new BasisOfRecordAR();
        $n1->basisofrecord = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colbasisofrecord]));
        $logic = new BasisOfRecordLogic();
        $aux = $logic->getBasisOfRecord($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->recordlevelelement->idbasisofrecord = $n1->idbasisofrecord;
        } else {
            $this->log[] = "<span style=\"color: red; font-weight: bold;\">ERROR:</span><span style=\"color: red;\"> Required field 'Basis of record' in line ".$line.', specimen '.($sp==$this->sp1?1:2).', is not valid.</span>';
            return false;
        }
        include_once 'InstitutionCodeLogic.php';
        $n1 = new InstitutionCodeAR();
        $n1->institutioncode = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colinstitutioncode]));
        $logic = new InstitutionCodeLogic();
        $aux = $logic->getInstitutionCode($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->recordlevelelement->idinstitutioncode = $n1->idinstitutioncode;
            $spcm->recordlevelelement->institutioncode = $n1;
        } else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->recordlevelelement->idinstitutioncode = $rs['ar']->idinstitutioncode;
            else {
                $this->log[] = "<span style=\"color: red; font-weight: bold;\">ERROR:</span><span style=\"color: red;\"> Required field 'Institution code' in line ".$line.', specimen '.($sp==$this->sp1?1:2).', is not valid.</span>';
                return false;
            }
        }
        include_once 'CollectionCodeLogic.php';
        $n1 = new CollectionCodeAR();
        $n1->collectioncode = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colcollectioncode]));
        $logic = new CollectionCodeLogic();
        $aux = $logic->getCollectionCode($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->recordlevelelement->idcollectioncode = $n1->idcollectioncode;
            $spcm->recordlevelelement->collectioncode = $n1;
        } else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->recordlevelelement->idcollectioncode = $rs['ar']->idcollectioncode;
            else {
                $this->log[] = "<span style=\"color: red; font-weight: bold;\">ERROR:</span><span style=\"color: red;\"> Required field 'Collection code' in line ".$line.', specimen '.($sp==$this->sp1?1:2).', is not valid.</span>';
                return false;
            }
        }
        include_once 'TypeLogic.php';
        $n1 = new TypeAR();
        $n1->type = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->coltype]));
        $logic = new TypeLogic();
        $aux = $logic->getType($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->recordlevelelement->idtype = $n1->idtype;
        } else if ($n1->type == '')
            $spcm->recordlevelelement->idtype = null;
        include_once 'OwnerInstitutionLogic.php';
        $n1 = new OwnerInstitutionAR();
        $n1->ownerinstitution = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colownerinstitutioncode]));
        $logic = new OwnerInstitutionLogic();
        $aux = $logic->getOwnerInstitution($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->recordlevelelement->idownerinstitution = $n1->idownerinstitution;
        } else if ($n1->ownerinstitution == '')
            $spcm->recordlevelelement->idownerinstitution = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->recordlevelelement->idownerinstitution = $rs['ar']->idownerinstitution;
        }
        include_once 'DatasetLogic.php';
        $n1 = new DatasetAR();
        $n1->dataset = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->coldataset]));
        $logic = new DatasetLogic();
        $aux = $logic->getDataset($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->recordlevelelement->iddataset = $n1->iddataset;
        } else if ($n1->dataset == '')
            $spcm->recordlevelelement->iddataset = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->recordlevelelement->iddataset = $rs['ar']->iddataset;
        }
        $spcm->recordlevelelement->informationwithheld = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colinformationwithheld]));
        $spcm->recordlevelelement->datageneralization = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->coldatageneralization]));
        $spcm->recordlevelelement->rights = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colrights]));
        $spcm->recordlevelelement->rightsholder = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colrightsholder]));
        $spcm->recordlevelelement->accessrights = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colaccessrights]));


        //TAXONOMIC
        include_once 'ScientificNameLogic.php';
        $n1 = new ScientificNameAR();
        $n1->scientificname = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colscientificname]));
        $logic = new ScientificNameLogic();
        $aux = $logic->getScientificName($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->taxonomicelement->idscientificname = $n1->idscientificname;
        } else if ($n1->scientificname == '')
            $spcm->taxonomicelement->idscientificname = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->taxonomicelement->idscientificname = $rs['ar']->idscientificname;
        }
        include_once 'KingdomLogic.php';
        $n1 = new KingdomAR();
        $n1->kingdom = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colkingdom]));
        $logic = new KingdomLogic();
        $aux = $logic->getKingdom($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->taxonomicelement->idkingdom = $n1->idkingdom;
        } else if ($n1->kingdom == '')
            $spcm->taxonomicelement->idkingdom = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->taxonomicelement->idkingdom = $rs['ar']->idkingdom;
        }
        include_once 'PhylumLogic.php';
        $n1 = new PhylumAR();
        $n1->phylum = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colphylum]));
        $logic = new PhylumLogic();
        $aux = $logic->getPhylum($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->taxonomicelement->idphylum = $n1->idphylum;
        } else if ($n1->phylum == '')
            $spcm->taxonomicelement->idphylum = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->taxonomicelement->idphylum = $rs['ar']->idphylum;
        }
        include_once 'ClassLogic.php';
        $n1 = new ClassAR();
        $n1->class = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colclass]));
        $logic = new ClassLogic();
        $aux = $logic->getClass($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->taxonomicelement->idclass = $n1->idclass;
        } else if ($n1->class == '')
            $spcm->taxonomicelement->idclass = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->taxonomicelement->idclass = $rs['ar']->idclass;
        }
        include_once 'OrderLogic.php';
        $n1 = new OrderAR();
        $n1->order = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colorder]));
        $logic = new OrderLogic();
        $aux = $logic->getOrder($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->taxonomicelement->idorder = $n1->idorder;
        } else if ($n1->order == '')
            $spcm->taxonomicelement->idorder = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->taxonomicelement->idorder = $rs['ar']->idorder;
        }
        include_once 'FamilyLogic.php';
        $n1 = new FamilyAR();
        $n1->family = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colfamily]));
        $logic = new FamilyLogic();
        $aux = $logic->getFamily($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->taxonomicelement->idfamily = $n1->idfamily;
        } else if ($n1->family == '')
            $spcm->taxonomicelement->idfamily = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->taxonomicelement->idfamily = $rs['ar']->idfamily;
        }
        include_once 'GenusLogic.php';
        $n1 = new GenusAR();
        $n1->genus = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colgenus]));
        $logic = new GenusLogic();
        $aux = $logic->getGenus($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->taxonomicelement->idgenus = $n1->idgenus;
        } else if ($n1->genus == '')
            $spcm->taxonomicelement->idgenus = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->taxonomicelement->idgenus = $rs['ar']->idgenus;
        }
        include_once 'SubgenusLogic.php';
        $n1 = new SubgenusAR();
        $n1->subgenus = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colsubgenus]));
        $logic = new SubgenusLogic();
        $aux = $logic->getSubgenus($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->taxonomicelement->idsubgenus = $n1->idsubgenus;
        } else if ($n1->subgenus == '')
            $spcm->taxonomicelement->idsubgenus = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->taxonomicelement->idsubgenus = $rs['ar']->idsubgenus;
        }
        include_once 'SpecificEpithetLogic.php';
        $n1 = new SpecificEpithetAR();
        $n1->specificepithet = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colspecificepithet]));
        $logic = new SpecificEpithetLogic();
        $aux = $logic->getSpecificEpithet($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->taxonomicelement->idspecificepithet = $n1->idspecificepithet;
        } else if ($n1->specificepithet == '')
            $spcm->taxonomicelement->idspecificepithet = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->taxonomicelement->idspecificepithet = $rs['ar']->idspecificepithet;
        }
        include_once 'TaxonRankLogic.php';
        $n1 = new TaxonRankAR();
        $n1->taxonrank = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->coltaxonrank]));
        $logic = new TaxonRankLogic();
        $aux = $logic->getTaxonRank($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->taxonomicelement->idtaxonrank = $n1->idtaxonrank;
        } else if ($n1->taxonrank == '')
            $spcm->taxonomicelement->idtaxonrank = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->taxonomicelement->idtaxonrank = $rs['ar']->idtaxonrank;
        }
        include_once 'InfraspecificEpithetLogic.php';
        $n1 = new InfraspecificEpithetAR();
        $n1->infraspecificepithet = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colinfraspecificepithet]));
        $logic = new InfraspecificEpithetLogic();
        $aux = $logic->getInfraspecificEpithet($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->taxonomicelement->idinfraspecificepithet = $n1->idinfraspecificepithet;
        } else if ($n1->infraspecificepithet == '')
            $spcm->taxonomicelement->idinfraspecificepithet = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->taxonomicelement->idinfraspecificepithet = $rs['ar']->idinfraspecificepithet;
        }
        include_once 'ScientificNameAuthorshipLogic.php';
        $n1 = new ScientificNameAuthorshipAR();
        $n1->scientificnameauthorship = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colscientificnameauthorship]));
        $logic = new ScientificNameAuthorshipLogic();
        $aux = $logic->getScientificNameAuthorship($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->taxonomicelement->idscientificnameauthorship = $n1->idscientificnameauthorship;
        } else if ($n1->scientificnameauthorship == '')
            $spcm->taxonomicelement->idscientificnameauthorship = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->taxonomicelement->idscientificnameauthorship = $rs['ar']->idscientificnameauthorship;
        }
        include_once 'NomenclaturalCodeLogic.php';
        $n1 = new NomenclaturalCodeAR();
        $n1->nomenclaturalcode = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colnomenclaturalcode]));
        $logic = new NomenclaturalCodeLogic();
        $aux = $logic->getNomenclaturalCode($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->taxonomicelement->idnomenclaturalcode = $n1->idnomenclaturalcode;
        } else if ($n1->nomenclaturalcode == '')
            $spcm->taxonomicelement->idnomenclaturalcode = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->taxonomicelement->idnomenclaturalcode = $rs['ar']->idnomenclaturalcode;
        }
        include_once 'TaxonConceptLogic.php';
        $n1 = new TaxonConceptAR();
        $n1->taxonconcept = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->coltaxonconcept]));
        $logic = new TaxonConceptLogic();
        $aux = $logic->getTaxonConcept($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->taxonomicelement->idtaxonconcept = $n1->idtaxonconcept;
        } else if ($n1->taxonconcept == '')
            $spcm->taxonomicelement->idtaxonconcept = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->taxonomicelement->idtaxonconcept = $rs['ar']->idtaxonconcept;
        }
        include_once 'AcceptedNameUsageLogic.php';
        $n1 = new AcceptedNameUsageAR();
        $n1->acceptednameusage = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colacceptednameusage]));
        $logic = new AcceptedNameUsageLogic();
        $aux = $logic->getAcceptedNameUsage($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->taxonomicelement->idacceptednameusage = $n1->idacceptednameusage;
        } else if ($n1->acceptednameusage == '')
            $spcm->taxonomicelement->idacceptednameusage = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->taxonomicelement->idacceptednameusage = $rs['ar']->idacceptednameusage;
        }
        include_once 'ParentNameUsageLogic.php';
        $n1 = new ParentNameUsageAR();
        $n1->parentnameusage = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colparentnameusage]));
        $logic = new ParentNameUsageLogic();
        $aux = $logic->getParentNameUsage($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->taxonomicelement->idparentnameusage = $n1->idparentnameusage;
        } else if ($n1->parentnameusage == '')
            $spcm->taxonomicelement->idparentnameusage = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->taxonomicelement->idparentnameusage = $rs['ar']->idparentnameusage;
        }
        include_once 'OriginalNameUsageLogic.php';
        $n1 = new OriginalNameUsageAR();
        $n1->originalnameusage = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->coloriginalnameusage]));
        $logic = new OriginalNameUsageLogic();
        $aux = $logic->getOriginalNameUsage($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->taxonomicelement->idoriginalnameusage = $n1->idoriginalnameusage;
        } else if ($n1->originalnameusage == '')
            $spcm->taxonomicelement->idoriginalnameusage = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->taxonomicelement->idoriginalnameusage = $rs['ar']->idoriginalnameusage;
        }
        include_once 'NameAccordingToLogic.php';
        $n1 = new NameAccordingToAR();
        $n1->nameaccordingto = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colnameaccordingto]));
        $logic = new NameAccordingToLogic();
        $aux = $logic->getNameAccordingTo($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->taxonomicelement->idnameaccordingto = $n1->idnameaccordingto;
        } else if ($n1->nameaccordingto == '')
            $spcm->taxonomicelement->idnameaccordingto = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->taxonomicelement->idnameaccordingto = $rs['ar']->idnameaccordingto;
        }
        include_once 'NamePublishedInLogic.php';
        $n1 = new NamePublishedInAR();
        $n1->namepublishedin = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colnamepublishedin]));
        $logic = new NamePublishedInLogic();
        $aux = $logic->getNamePublishedIn($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->taxonomicelement->idnamepublishedin = $n1->idnamepublishedin;
        } else if ($n1->namepublishedin == '')
            $spcm->taxonomicelement->idnamepublishedin = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->taxonomicelement->idnamepublishedin = $rs['ar']->idnamepublishedin;
        }
        include_once 'TaxonomicStatusLogic.php';
        $n1 = new TaxonomicStatusAR();
        $n1->taxonomicstatus = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->coltaxonomicstatus]));
        $logic = new TaxonomicStatusLogic();
        $aux = $logic->getTaxonomicStatus($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->taxonomicelement->idtaxonomicstatus = $n1->idtaxonomicstatus;
        } else if ($n1->taxonomicstatus == '')
            $spcm->taxonomicelement->idtaxonomicstatus = null;
        $spcm->taxonomicelement->nomenclaturalstatus = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colnomenclaturalstatus]));
        $spcm->taxonomicelement->taxonremark = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->coltaxonremarks]));
        $spcm->taxonomicelement->verbatimtaxonrank = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colverbatimtaxonrank]));
        $spcm->taxonomicelement->vernacularname = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colvernacularname]));


        // OCCURRENCE
        include_once 'DispositionLogic.php';
        $n1 = new DispositionAR();
        $n1->disposition = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->coldisposition]));
        $logic = new DispositionLogic();
        $aux = $logic->getDisposition($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->occurrenceelement->iddisposition = $n1->iddisposition;
        } else if ($n1->disposition == '')
            $spcm->occurrenceelement->iddisposition = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->occurrenceelement->iddisposition = $rs['ar']->iddisposition;
        }
        include_once 'SexLogic.php';
        $n1 = new SexAR();
        $n1->sex = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colsex]));
        $logic = new SexLogic();
        $aux = $logic->getSex($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->occurrenceelement->idsex = $n1->idsex;
        } else if ($n1->sex == '')
            $spcm->occurrenceelement->idsex = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->occurrenceelement->idsex = $rs['ar']->idsex;
        }
        include_once 'LifeStageLogic.php';
        $n1 = new LifeStageAR();
        $n1->lifestage = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->collifestage]));
        $logic = new LifeStageLogic();
        $aux = $logic->getLifeStage($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->occurrenceelement->idlifestage = $n1->idlifestage;
        } else if ($n1->lifestage == '')
            $spcm->occurrenceelement->idlifestage = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->occurrenceelement->idlifestage = $rs['ar']->idlifestage;
        }
        include_once 'BehaviorLogic.php';
        $n1 = new BehaviorAR();
        $n1->behavior = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colbehavior]));
        $logic = new BehaviorLogic();
        $aux = $logic->getBehavior($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->occurrenceelement->idbehavior = $n1->idbehavior;
        } else if ($n1->behavior == '')
            $spcm->occurrenceelement->idbehavior = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->occurrenceelement->idbehavior = $rs['ar']->idbehavior;
        }
        include_once 'ReproductiveConditionLogic.php';
        $n1 = new ReproductiveConditionAR();
        $n1->reproductivecondition = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colreproductivecondition]));
        $logic = new ReproductiveConditionLogic();
        $aux = $logic->getReproductiveCondition($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->occurrenceelement->idreproductivecondition = $n1->idreproductivecondition;
        } else if ($n1->reproductivecondition == '')
            $spcm->occurrenceelement->idreproductivecondition = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->occurrenceelement->idreproductivecondition = $rs['ar']->idreproductivecondition;
        }
        include_once 'EstablishmentMeanLogic.php';
        $n1 = new EstablishmentMeanAR();
        $n1->establishmentmean = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colestablishmentmean]));
        $logic = new EstablishmentMeanLogic();
        $aux = $logic->getEstablishmentMean($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->occurrenceelement->idestablishmentmean = $n1->idestablishmentmean;
        } else if ($n1->establishmentmean == '')
            $spcm->occurrenceelement->idestablishmentmean = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->occurrenceelement->idestablishmentmean = $rs['ar']->idestablishmentmean;
        }
        $aux = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colindividualcount]));
        if (is_numeric($aux) || $aux == '') {
            $spcm->occurrenceelement->individualcount = $aux != '' ? $aux:null;
        } else $this->log[] = "<span style=\"color: orange; font-weight: bold;\">WARNING:</span><span style=\"color: orange;\"> Field 'Individual count' in line ".$line.', specimen '.($sp==$this->sp1?1:2).', is not of valid format (value ignored).</span>';
        $spcm->occurrenceelement->recordnumber = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colrecordnumber]));
        $spcm->occurrenceelement->occurrencedetail = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->coloccurrencedetails]));
        $spcm->occurrenceelement->catalognumber = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colcatalognumber]));
        $spcm->occurrenceelement->occurrencestatus = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->coloccurrencestatus]));
        $spcm->occurrenceelement->othercatalognumber = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colothercatalognumbers]));
        $spcm->occurrenceelement->occurrenceremark = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->coloccurrenceremarks]));

        //IDENTIFICATION
        include_once 'IdentificationQualifierLogic.php';
        $n1 = new IdentificationQualifierAR();
        $n1->identificationqualifier = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colidentificationqualifier]));
        $logic = new IdentificationQualifierLogic();
        $aux = $logic->getIdentificationQualifier($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->identificationelement->ididentificationqualifier = $n1->ididentificationqualifier;
        } else if ($n1->identificationqualifier == '')
            $spcm->identificationelement->ididentificationqualifier = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->identificationelement->ididentificationqualifier = $rs['ar']->ididentificationqualifier;
        }
        $input = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->coldateidentified]));
        $time = strtotime($input);
        $is_valid = date('Y/m/d', $time) == $input;
        $spcm->identificationelement->dateidentified = date('Y/m/d', $time) == $input ? $input : null;
        $spcm->identificationelement->identificationremark = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colidentificationremarks]));


        //EVENT
        include_once 'SamplingProtocolLogic.php';
        $n1 = new SamplingProtocolAR();
        $n1->samplingprotocol = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colsamplingprotocol]));
        $logic = new SamplingProtocolLogic();
        $aux = $logic->getSamplingProtocol($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->eventelement->idsamplingprotocol = $n1->idsamplingprotocol;
        } else if ($n1->samplingprotocol == '')
            $spcm->eventelement->idsamplingprotocol = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->eventelement->idsamplingprotocol = $rs['ar']->idsamplingprotocol;
        }
        include_once 'HabitatLogic.php';
        $n1 = new HabitatAR();
        $n1->habitat = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colhabitat]));
        $logic = new HabitatLogic();
        $aux = $logic->getHabitat($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->eventelement->idhabitat = $n1->idhabitat;
        } else if ($n1->habitat == '')
            $spcm->eventelement->idhabitat = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->eventelement->idhabitat = $rs['ar']->idhabitat;
        }
        $spcm->eventelement->samplingeffort = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colsamplingeffort]));
        /*$input = $this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->coleventdate];
        $time = strtotime($input);
        echo('\$input = '.$input.' <br>');
        echo('\$time = '.$time.' <br>');
        $date = date('Y/m/d', $input);
        echo ('date(\$time) = '.$date.'<br>');
        $spcm->eventelement->eventdate = date('Y/m/d', $time) == $input ? $input : null;
        $spcm->eventelement->eventtime = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->coleventtime]));*/
        $spcm->eventelement->fieldnumber = utf8_encode($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colfieldnumber]);
        $spcm->eventelement->fieldnote = utf8_encode($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colfieldnotes]);
        $spcm->eventelement->verbatimeventdate = utf8_encode($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colverbatimeventdate]);
        $spcm->eventelement->eventremark = utf8_encode($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->coleventremarks]);

        //LOCALITY
        include_once 'ContinentLogic.php';
        $n1 = new ContinentAR();
        $n1->continent = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colcontinent]));
        $logic = new ContinentLogic();
        $aux = $logic->getContinent($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->localityelement->idcontinent = $n1->idcontinent;
        } else if ($n1->continent == '')
            $spcm->localityelement->idcontinent = null;
        /*else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->localityelement->idcontinent = $rs['ar']->idcontinent;
        }*/
        include_once 'WaterBodyLogic.php';
        $n1 = new WaterBodyAR();
        $n1->waterbody = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colwaterbody]));
        $logic = new WaterBodyLogic();
        $aux = $logic->getWaterBody($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->localityelement->idwaterbody = $n1->idwaterbody;
        } else if ($n1->waterbody == '')
            $spcm->localityelement->idwaterbody = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->localityelement->idwaterbody = $rs['ar']->idwaterbody;
        }
        include_once 'IslandGroupLogic.php';
        $n1 = new IslandGroupAR();
        $n1->islandgroup = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colislandgroup]));
        $logic = new IslandGroupLogic();
        $aux = $logic->getIslandGroup($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->localityelement->idislandgroup = $n1->idislandgroup;
        } else if ($n1->islandgroup == '')
            $spcm->localityelement->idislandgroup = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->localityelement->idislandgroup = $rs['ar']->idislandgroup;
        }
        include_once 'IslandLogic.php';
        $n1 = new IslandAR();
        $n1->island = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colisland]));
        $logic = new IslandLogic();
        $aux = $logic->getIsland($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->localityelement->idisland = $n1->idisland;
        } else if ($n1->island == '')
            $spcm->localityelement->idisland = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->localityelement->idisland = $rs['ar']->idisland;
        }
        include_once 'CountryLogic.php';
        $n1 = new CountryAR();
        $n1->country = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colcountry]));
        $logic = new CountryLogic();
        $aux = $logic->getCountry($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->localityelement->idcountry = $n1->idcountry;
        } else if ($n1->country == '')
            $spcm->localityelement->idcountry = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->localityelement->idcountry = $rs['ar']->idcountry;
        }
        include_once 'StateProvinceLogic.php';
        $n1 = new StateProvinceAR();
        $n1->stateprovince = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colstateprovince]));
        $logic = new StateProvinceLogic();
        $aux = $logic->getStateProvince($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->localityelement->idstateprovince = $n1->idstateprovince;
        } else if ($n1->stateprovince == '')
            $spcm->localityelement->idstateprovince = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->localityelement->idstateprovince = $rs['ar']->idstateprovince;
        }
        include_once 'MunicipalityLogic.php';
        $n1 = new MunicipalityAR();
        $n1->municipality = utf8_encode(utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colmunicipality])));
        $logic = new MunicipalityLogic();
        $aux = $logic->getMunicipality($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->localityelement->idmunicipality = $n1->idmunicipality;
        } else if ($n1->municipality == '')
            $spcm->localityelement->idmunicipality = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->localityelement->idmunicipality = $rs['ar']->idmunicipality;
        }
        include_once 'CountyLogic.php';
        $n1 = new CountyAR();
        $n1->county = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colcounty]));
        $logic = new CountyLogic();
        $aux = $logic->getCounty($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->localityelement->idcounty = $n1->idcounty;
        } else if ($n1->county == '')
            $spcm->localityelement->idcounty = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->localityelement->idcounty = $rs['ar']->idcounty;
        }
        include_once 'LocalityLogic.php';
        $n1 = new LocalityAR();
        $n1->locality = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->collocality]));
        $logic = new LocalityLogic();
        $aux = $logic->getLocality($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->localityelement->idlocality = $n1->idlocality;
        } else if ($n1->locality == '')
            $spcm->localityelement->idlocality = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->localityelement->idlocality = $rs['ar']->idlocality;
        }

        $aux = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colmaximumdistanceabovesurfaceinmeters]));
        if (is_numeric($aux) || $aux == '') {
            $spcm->localityelement->maximumdistanceabovesurfaceinmeters = $aux != '' ? $aux:null;
        } else $this->log[] = "<span style=\"color: orange; font-weight: bold;\">WARNING:</span><span style=\"color: orange;\"> Field 'Maximum distance above surface in meters' in line ".$line.', specimen '.($sp==$this->sp1?1:2).', is not of valid format (value ignored).</span>';
        $aux = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colminimumdistanceabovesurfaceinmeters]));
        if (is_numeric($aux) || $aux == '') {
            $spcm->localityelement->minimumdistanceabovesurfaceinmeters = $aux != '' ? $aux:null;
        } else $this->log[] = "<span style=\"color: orange; font-weight: bold;\">WARNING:</span><span style=\"color: orange;\"> Field 'Minimum distance above surface in meters' in line ".$line.', specimen '.($sp==$this->sp1?1:2).', is not of valid format (value ignored).</span>';
        $spcm->localityelement->minimumelevationinmeters = $this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colminimumelevationinmeters];
        $spcm->localityelement->maximumelevationinmeters = $this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colmaximumelevationinmeters];
        $spcm->localityelement->minimumdepthinmeters = $this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colminimumdepthinmeters];
        $spcm->localityelement->maximumdepthinmeters = $this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colmaximumdepthinmeters];
        $spcm->localityelement->verbatimelevation = $this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colverbatimelevation];
        $spcm->localityelement->verbatimdepth = $this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colverbatimdepth];
        $spcm->localityelement->locationaccordingto = $this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->collocationaccordingto];
        $spcm->localityelement->coordinateprecision = $this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colcoordinateprecision];
        $spcm->localityelement->footprintsrs = $this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colfootprintsrs];
        $spcm->localityelement->verbatimlocality = $this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colverbatimlocality];
        $spcm->localityelement->verbatimsrs = $this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colverbatimsrs];
        $spcm->localityelement->locationremark = $this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->collocationremarks];


        //GEOSPATIAL
        include_once 'GeoreferenceVerificationStatusLogic.php';
        $n1 = new GeoreferenceVerificationStatusAR();
        $n1->georeferenceverificationstatus = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colverificationstatus]));
        $logic = new GeoreferenceVerificationStatusLogic();
        $aux = $logic->getGeoreferenceVerificationStatus($n1);
        if ($aux!=null) {
            $n1 = $aux;
            $spcm->geospatialelement->idgeoreferenceverificationstatus = $n1->idgeoreferenceverificationstatus;
        } else if ($n1->georeferenceverificationstatus == '')
            $spcm->geospatialelement->idgeoreferenceverificationstatus = null;
        else {
            $rs = $logic->save($n1);
            if ($rs['success'])
                $spcm->geospatialelement->idgeoreferenceverificationstatus = $rs['ar']->idgeoreferenceverificationstatus;
        }
        $aux = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->coldecimallatitude]));
        if (is_numeric($aux) || $aux == '') {
            $spcm->geospatialelement->decimallatitude = $aux != '' ? str_replace(',', '.', $aux):null;
        } else $this->log[] = "<span style=\"color: orange; font-weight: bold;\">WARNING:</span><span style=\"color: orange;\"> Field 'Decimal latitude' in line ".$line.', specimen '.($sp==$this->sp1?1:2).', is not of valid format (value ignored). ['.$aux.']</span>';
        $aux = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->coldecimallongitude]));
        if (is_numeric($aux) || $aux == '') {
            $spcm->geospatialelement->decimallongitude = $aux != '' ? str_replace(',', '.', $aux):null;
        } else $this->log[] = "<span style=\"color: orange; font-weight: bold;\">WARNING:</span><span style=\"color: orange;\"> Field 'Decimal longitude' in line ".$line.', specimen '.($sp==$this->sp1?1:2).', is not of valid format (value ignored).</span>';
        $spcm->geospatialelement->geodeticdatum = $this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colgeodeticdatum];
        $aux = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colcoordinateuncertainty]));
        if (is_numeric($aux) || $aux == '') {
            $spcm->geospatialelement->coordinateuncertaintyinmeters = $aux != '' ? str_replace(',', '.', $aux):null;
        } else $this->log[] = "<span style=\"color: orange; font-weight: bold;\">WARNING:</span><span style=\"color: orange;\"> Field 'Coordinate uncertainty in meters' in line ".$line.', specimen '.($sp==$this->sp1?1:2).', is not of valid format (value ignored).'.$aux.'</span>';
        $spcm->geospatialelement->pointradiusspatialfit = $this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colpointradiusspatialfit];
        $spcm->geospatialelement->verbatimcoordinate = $this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colverbatimcoordinates];
        $spcm->geospatialelement->verbatimlatitude = $this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colverbatimlatitude];
        $spcm->geospatialelement->verbatimlongitude = $this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colverbatimlongitude];
        $spcm->geospatialelement->verbatimcoordinatesystem = $this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colverbatimcoordinatesystem];
        $spcm->geospatialelement->georeferenceprotocol = $this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colgeoreferenceprotocol];
        $spcm->geospatialelement->georeferenceremark = $this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colgeoreferenceremarks];
        $spcm->geospatialelement->footprintwkt = $this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colfootprintwkt];
        $spcm->geospatialelement->footprintspatialfit = $this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colfootprintspatialfit];


        //SALVAR

        $rs = $spLogic->save($spcm);
        if($rs['success']) {
            if($rs['operation']=='created') {
                //$this->log[] = $spcm->recordlevelelement->globaluniqueidentifier;
                $this->spcreate++;
            }
            else  if ($rs['operation']=='updated') $this->spupdate++;
            $this->insertNNFields($sp, $line, $spcm);
        } else {
            $this->spfail++;
            /*if(count($rs['msg'])>0)
                foreach ($rs['msg'] as $i)
                    $this->log[] = var_dump($i);*/
        }

        return $spcm;
    }

    public function insertNNFields($sp, $line, $spcm) {
        //CAMPOS NN

        $fieldExcel = utf8_encode($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->coldynamicproperties]);
        $n2 = explode(';', $fieldExcel);
        include_once 'DynamicPropertyLogic.php';
        $logic = new DynamicPropertyLogic();
        $listExcel = array();
        foreach ($n2 as $i) {
            $n1 = new DynamicPropertyAR();
            $n1->dynamicproperty = trim($i);
            $aux = $logic->getDynamicProperty($n1);
            if (!$aux) {
                $rs = $logic->save($n1);
                if($rs['success']==false)
                    $rs['ar'] = new DynamicPropertyAR();
                $n1 = $rs['ar'];
            }
            else $n1 = $aux;
            $listExcel[] = $n1;
            if($n1->iddynamicproperty)
                $logic->saveRecordLevelElementNN($n1->iddynamicproperty, $spcm->idrecordlevelelement);
        }
        $listDB = $logic->getDynamicPropertyByRecordLevelElement($spcm->recordlevelelement);
        foreach ($listDB as $DB) {
            $flagexiste = false;
            foreach ($listExcel as $Excel)
                if ($DB->iddynamicproperty == $Excel->iddynamicproperty)
                    $flagexiste = true;
            if(!$flagexiste)
                $logic->deleteRecordLevelElementNN($DB->iddynamicproperty, $spcm->idrecordlevelelement);
        }

        $fieldExcel = utf8_encode($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colindividual]);
        $n2 = explode(';', $fieldExcel);
        include_once 'IndividualLogic.php';
        $logic = new IndividualLogic();
        $listExcel = array();
        foreach ($n2 as $i) {
            $n1 = new IndividualAR();
            $n1->individual = trim($i);
            $aux = $logic->getIndividual($n1);
            if (!$aux) {
                $rs = $logic->save($n1);
                if($rs['success']==false)
                    $rs['ar'] = new IndividualAR();
                $n1 = $rs['ar'];
            }
            else $n1 = $aux;
            $listExcel[] = $n1;
            if($n1->idindividual)
                $logic->saveOccurrenceElementNN($n1->idindividual, $spcm->idoccurrenceelement);
        }
        $listDB = $logic->getIndividualByOccurrenceElement($spcm);
        foreach ($listDB as $DB) {
            $flagexiste = false;
            foreach ($listExcel as $Excel)
                if ($DB->idindividual == $Excel->idindividual)
                    $flagexiste = true;
            if(!$flagexiste)
                $logic->deleteOccurrenceElementNN($DB->idindividual, $spcm->idoccurrenceelement);
        }

        $fieldExcel = utf8_encode($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colpreparations]);
        $n2 = explode(';', $fieldExcel);
        include_once 'PreparationLogic.php';
        $logic = new PreparationLogic();
        $listExcel = array();
        foreach ($n2 as $i) {
            $n1 = new PreparationAR();
            $n1->preparation = trim($i);
            $aux = $logic->getPreparation($n1);
            if (!$aux) {
                $rs = $logic->save($n1);
                if($rs['success']==false)
                    $rs['ar'] = new PreparationAR();
                $n1 = $rs['ar'];
            }
            else $n1 = $aux;
            $listExcel[] = $n1;
            if($n1->idpreparation)
                $logic->saveOccurrenceElementNN($n1->idpreparation, $spcm->idoccurrenceelement);
        }
        $listDB = $logic->getPreparationByOccurrenceElement($spcm);
        foreach ($listDB as $DB) {
            $flagexiste = false;
            foreach ($listExcel as $Excel)
                if ($DB->idpreparation == $Excel->idpreparation)
                    $flagexiste = true;
            if(!$flagexiste)
                $logic->deleteOccurrenceElementNN($DB->idpreparation, $spcm->idoccurrenceelement);
        }

        $fieldExcel = utf8_encode($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colrecordedby]);
        $n2 = explode(';', $fieldExcel);
        include_once 'RecordedByLogic.php';
        $logic = new RecordedByLogic();
        $listExcel = array();
        foreach ($n2 as $i) {
            $n1 = new RecordedByAR();
            $n1->recordedby = trim($i);
            $aux = $logic->getRecordedBy($n1);
            if (!$aux) {
                $rs = $logic->save($n1);
                if($rs['success']==false)
                    $rs['ar'] = new RecordedByAR();
                $n1 = $rs['ar'];
            }
            else $n1 = $aux;
            $listExcel[] = $n1;
            if($n1->idrecordedby)
                $logic->saveOccurrenceElementNN($n1->idrecordedby, $spcm->idoccurrenceelement);
        }
        $listDB = $logic->getRecordedByByOccurrenceElement($spcm->occurrenceelement);
        foreach ($listDB as $DB) {
            $flagexiste = false;
            foreach ($listExcel as $Excel) {
                if ($DB->idrecordedby == $Excel->idrecordedby)
                    $flagexiste = true;
            }
            if(!$flagexiste)
                $logic->deleteOccurrenceElementNN($DB->idrecordedby, $spcm->idoccurrenceelement);
        }

        $fieldExcel = utf8_encode($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colassociatedsequence]);
        $n2 = explode(';', $fieldExcel);
        include_once 'AssociatedSequenceLogic.php';
        $logic = new AssociatedSequenceLogic();
        $listExcel = array();
        foreach ($n2 as $i) {
            $n1 = new AssociatedSequenceAR();
            $n1->associatedsequence = trim($i);
            $aux = $logic->getAssociatedSequence($n1);
            if (!$aux) {
                $rs = $logic->save($n1);
                if($rs['success']==false)
                    $rs['ar'] = new AssociatedSequenceAR();
                $n1 = $rs['ar'];
            }
            else $n1 = $aux;
            $listExcel[] = $n1;
            if($n1->idassociatedsequence)
                $logic->saveOccurrenceElementNN($n1->idassociatedsequence, $spcm->idoccurrenceelement);
        }
        $listDB = $logic->getAssociatedSequenceByOccurrenceElement($spcm);
        foreach ($listDB as $DB) {
            $flagexiste = false;
            foreach ($listExcel as $Excel)
                if ($DB->idassociatedsequence == $Excel->idassociatedsequence)
                    $flagexiste = true;
            if(!$flagexiste)
                $logic->deleteOccurrenceElementNN($DB->idassociatedsequence, $spcm->idoccurrenceelement);
        }

        $fieldExcel = utf8_encode($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colidentifiedby]);
        $n2 = explode(';', $fieldExcel);
        include_once 'IdentifiedByLogic.php';
        $logic = new IdentifiedByLogic();
        $listExcel = array();
        foreach ($n2 as $i) {
            $n1 = new IdentifiedByAR();
            $n1->identifiedby = trim($i);
            $aux = $logic->getIdentifiedBy($n1);
            if (!$aux) {
                $rs = $logic->save($n1);
                if($rs['success']==false)
                    $rs['ar'] = new IdentifiedByAR();
                $n1 = $rs['ar'];
            }
            else $n1 = $aux;
            $listExcel[] = $n1;
            if($n1->ididentifiedby)
                $logic->saveIdentificationElementNN($n1->ididentifiedby, $spcm->ididentificationelement);
        }
        $listDB = $logic->getIdentifiedByByIdentificationElement($spcm);
        foreach ($listDB as $DB) {
            $flagexiste = false;
            foreach ($listExcel as $Excel)
                if ($DB->ididentifiedby == $Excel->ididentifiedby)
                    $flagexiste = true;
            if(!$flagexiste)
                $logic->deleteIdentificationElementNN($DB->ididentifiedby, $spcm->ididentificationelement);
        }

        $fieldExcel = utf8_encode($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->coltypestatus]);
        $n2 = explode(';', $fieldExcel);
        include_once 'TypeStatusLogic.php';
        $logic = new TypeStatusLogic();
        $listExcel = array();
        foreach ($n2 as $i) {
            $n1 = new TypeStatusAR();
            $n1->typestatus = trim($i);
            $aux = $logic->getTypeStatus($n1);
            if (!$aux) {
                $rs = $logic->save($n1);
                if($rs['success']==false)
                    $rs['ar'] = new TypeStatusAR();
                $n1 = $rs['ar'];
            }
            else $n1 = $aux;
            $listExcel[] = $n1;
            if($n1->idtypestatus)
                $logic->saveIdentificationElementNN($n1->idtypestatus, $spcm->ididentificationelement);
        }
        $listDB = $logic->getTypeStatusByIdentificationElement($spcm);
        foreach ($listDB as $DB) {
            $flagexiste = false;
            foreach ($listExcel as $Excel)
                if ($DB->idtypestatus == $Excel->idtypestatus)
                    $flagexiste = true;
            if(!$flagexiste)
                $logic->deleteIdentificationElementNN($DB->idtypestatus, $spcm->ididentificationelement);
        }

        $fieldExcel = utf8_encode($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colgeoreferencedby]);
        $n2 = explode(';', $fieldExcel);
        include_once 'GeoreferencedByLogic.php';
        $logic = new GeoreferencedByLogic();
        $listExcel = array();
        foreach ($n2 as $i) {
            $n1 = new GeoreferencedByAR();
            $n1->georeferencedby = trim($i);
            $aux = $logic->getGeoreferencedBy($n1);
            if (!$aux) {
                $rs = $logic->save($n1);
                if($rs['success']==false)
                    $rs['ar'] = new GeoreferencedByAR();
                $n1 = $rs['ar'];
            }
            else $n1 = $aux;
            $listExcel[] = $n1;
            if($n1->idgeoreferencedby)
                $logic->saveLocalityElementNN($n1->idgeoreferencedby, $spcm->idlocalityelement);
        }
        $listDB = $logic->getGeoreferencedByByLocalityElement($spcm);
        foreach ($listDB as $DB) {
            $flagexiste = false;
            foreach ($listExcel as $Excel)
                if ($DB->idgeoreferencedby == $Excel->idgeoreferencedby)
                    $flagexiste = true;
            if(!$flagexiste)
                $logic->deleteLocalityElementNN($DB->idgeoreferencedby, $spcm->idlocalityelement);
        }


        $fieldExcel = utf8_encode($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colgeoreferencesources]);
        $n2 = explode(';', $fieldExcel);
        include_once 'GeoreferenceSourceLogic.php';
        $logic = new GeoreferenceSourceLogic();
        $listExcel = array();
        foreach ($n2 as $i) {
            $n1 = new GeoreferenceSourceAR();
            $n1->georeferencesource = trim($i);
            $aux = $logic->getGeoreferenceSource($n1);
            if (!$aux) {
                $rs = $logic->save($n1);
                if($rs['success']==false)
                    $rs['ar'] = new GeoreferenceSourceAR();
                $n1 = $rs['ar'];
            }
            else $n1 = $aux;
            $listExcel[] = $n1;
            if($n1->idgeoreferencesource) {
                $logic->saveGeospatialElementNN($n1->idgeoreferencesource, $spcm->idgeospatialelement);
                $logic->saveLocalityElementNN($n1->idgeoreferencesource, $spcm->idlocalityelement);
            }
        }
        $listDB = $logic->getGeoreferenceSourceByLocalityElement($spcm);
        foreach ($listDB as $DB) {
            $flagexiste = false;
            foreach ($listExcel as $Excel)
                if ($DB->idgeoreferencesource == $Excel->idgeoreferencesource)
                    $flagexiste = true;
            if(!$flagexiste)
                $logic->deleteLocalityElementNN($DB->idgeoreferencesource, $spcm->idlocalityelement);
        }
        $listDB = $logic->getGeoreferenceSourceByGeospatialElement($spcm);
        foreach ($listDB as $DB) {
            $flagexiste = false;
            foreach ($listExcel as $Excel)
                if ($DB->idgeoreferencesource == $Excel->idgeoreferencesource)
                    $flagexiste = true;
            if(!$flagexiste)
                $logic->deleteGeospatialElementNN($DB->idgeoreferencesource, $spcm->idgeospatialelement);
        }

    }

    public function insertInteractionLine($sp1, $sp2, $line) {
        /*Insere um Interaction*/
        $n1 = new InteractionTypeAR();
        $n1->interactiontype = utf8_encode(trim($this->objWorksheet->sheets[0]["cells"][$line][$sp+$this->colinteractiontype]));
        $logic = new InteractionTypeLogic();
        $inttype = $logic->getInteractionType($n1);
        if ($inttype==null) {
            $this->log[] = "<span style=\"color: red; font-weight: bold;\">ERROR:</span><span style=\"color: red;\"> Required field 'Interaction type' in line ".$line.', specimen '.($sp==$this->sp1?1:2).', is not valid.</span>';
            return false;
        }

        $intLogic = new InteractionLogic();
        $int = $intLogic->getInteraction($sp1, $sp2, $inttype);
        /*
        if ($int->idinteraction == null)
            $sql = 'INSERT INTO interaction(idspecimen1, idspecimen2, idinteractiontype, interactionrelatedinformation) 
                        VALUES (\''.$sp1->idspecimen.'\' ,\''.$sp2->idspecimen.'\' ,\''.$inttype->idinteractiontype.'\' ,\''.$this->objWorksheet->sheets[0]["cells"][$line][$this->colinteractionrelatedinformation].'\');';

        else 
            $sql = 'UPDATE interaction
                    SET idspecimen1=\''.$sp1->idspecimen.'\', idspecimen2=\''.$sp2->idspecimen.'\', idinteractiontype=\''.$inttype->idinteractiontype.'\', 
                        interactionrelatedinformation=\''.$this->objWorksheet->sheets[0]["cells"][$line][$this->colinteractionrelatedinformation].'\'
                    WHERE idinteraction=\''.$int->idinteraction.'\';';
        $rs = WebbeeController::executaSQL($sql);
        */
        $int->idspecimen1 = $sp1->idspecimen;
        $int->idspecimen2 = $sp2->idspecimen;
        $int->idinteractiontype = $inttype->idinteractiontype;
        $int->interactionrelatedinformation = $this->objWorksheet->sheets[0]["cells"][$line][$this->colinteractionrelatedinformation];

        $rs = $intLogic->save($int);

        if($rs['success'])
            if($rs['operation']=='created') {
                //$this->log[] =
                $this->intcreate++;
            }
            else  $this->intupdate++;
    }
}
?>