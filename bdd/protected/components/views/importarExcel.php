<style type="text/css">
    <!--
    .statheader{
        font-size: 15px;
        font-weight: bold;
        letter-spacing:1px;
        border-bottom:1px dashed red;
        padding-bottom:3px;
        vertical-align: middle;
        width:90%;
        margin-bottom:15px;
        color:green;
    }
    .statnumber{
        font-size: 14px;
        color:green;
        font-weight: bold;
        width:60px;
        text-align:center;
        height:30px;
    }
    .statlabel{

    }

    .menulinkuser{

    }

    -->
</style>



<!--
<br/>

Geral
<br/>InstituiÔøΩÔøΩes
<br/>ColeÔøΩÔøΩes


<br/>-->

<?php
class importarExcel {
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

    var $colinteractiontype=74;
    var $colinteractionrelatedinformation=75;

    var $sp2=75;
    var $sp1=0;

    var $reader;
//$recordlevelelements = recordlevelelements::model();

    public function importarExcel() {
       
        require_once 'Excel/reader.php';
       
        $this->reader = new Spreadsheet_Excel_Reader();
       
        $this->reader->setOutputEncoding("UTF-8");
        $this->reader->read("protected/components/views/20100703_BDD_ibpucv_total.xls");
       
        $especie1 = recordlevelelements::model();
        $especie2 = recordlevelelements::model();

        // loop para linhas da tabela, a partir da 4 linha.
        for ($i = 12;
        $i <= $this->reader->sheets[0]["numRows"];
        $i++) {
            //echo trim($this->reader->sheets[0]["cells"][$i][$this->coldecimallatitude+$this->sp1]);
            // verifica se especie 1 nao est√° vazio na linha atual ($i)
            if(!$this->isSpVazio($i,$this->sp1)) {
                // verifica se todos os campos obrigat√≥rios nao estao preenchidos
                $sp1validade = $this->validarSp($i,$this->sp1);
                if(trim($sp1validade)!='ok') {
                    echo $sp1validade."<br>";
                    // se estiver v√°lido...
                }else {
                    $globaUniqueId = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colinstitutioncode+$this->sp1])).':'.CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colcollectioncode+$this->sp1])).':'.CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colcatalognumber+$this->sp1]));
                    $spExiste = $this->existeRegistro($globaUniqueId);
                    if(isset ($spExiste)) {
                        $especie1 = $spExiste;
                        $especie1->setIsNewRecord(false);
                        $especie1->idbasisofrecord = $this->getIdBasisOfRecord($i,$this->sp1)->idbasisofrecord;
                        $especie1->modified = date('Y-m-d G:i:s');
                        $especie1->informationwithheld = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colinformationwithheld+$this->sp1]));
                        $especie1->dynamicproperties = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colattributes+$this->sp1]));
                        $this->setOccurrenceElements($especie1->idoccurrenceelements,$i,$this->sp1); // necessariamente ja existe (catalog num)
                        $this->setTaxonomicElements($especie1->idtaxonomicelements,$i,$this->sp1); // necessariamente ja existe (scientific name)
                        
                        if(isset($especie1->idcuratorialelements)) {
                            $this->setCuratorialElements($especie1->idcuratorialelements,$i,$this->sp1);
                        }else {
                            if(!$this->isCuratorialVazio($i,$this->sp1)) {
                                $especie1->idcuratorialelements = $this->getIdCuratorialElements($i,$this->sp1)->idcuratorialelements;
                            }
                        }
                        if(isset($especie1->ididentificationelements)) {
                            $this->setIdentificationElements($especie1->ididentificationelements,$i,$this->sp1);
                        }else {
                            if(!$this->isIdentificationVazio($i,$this->sp1)) {
                                $especie1->ididentificationelements = $this->getIdIdentificationElements($i,$this->sp1)->ididentificationelements;
                            }
                        }
                        if(isset($especie1->ideventelements)) {
                            $this->setEventElements($especie1->ideventelements,$i,$this->sp1);
                        }else {
                            if(!$this->isEventVazio($i,$this->sp1)) {
                                $especie1->ideventelements = $this->getIdEventElements($i,$this->sp1)->ideventelements;
                            }
                        }
                        if(isset($especie1->idlocalityelements)) {
                            $this->setIdLocalityElements($especie1->idlocalityelements,$i,$this->sp1);
                        }else {
                            if(!$this->isLocalityVazio($i,$this->sp1)) {
                                $especie1->idlocalityelements = $this->getIdLocalityElements($i,$this->sp1)->idlocalityelements;
                            }
                        }
                        if(isset($especie1->idgeospatialelements)) {
                            $this->setGeospatialElements($especie1->idgeospatialelements,$i,$this->sp1);
                        }else {
                            if(!$this->isGeospatialVazio($i,$this->sp1)) {
                                $especie1->idgeospatialelements = $this->getIdGeospatialElements($i,$this->sp1)->idgeospatialelements;
                            }
                        }
                        echo 'Linha '.$i.' - <b>Espécime 1</b> '.$globaUniqueId.' <b>alterado</b> corretamente. <br>';
                        
                            $especie1->save();
                        
                        // se nao existe, cria um novo...
                    }else {
                        $especie1 = recordlevelelements::model();
                        $especie1->idinstitutioncode = $this->getIdInstitutionCode($i,$this->sp1)->idinstitutioncode;
                        $especie1->idcollectioncode = $this->getIdCollectionCode($i,$this->sp1)->idcollectioncode;
                        $especie1->idbasisofrecord = $this->getIdBasisOfRecord($i,$this->sp1)->idbasisofrecord;
                        $especie1->modified = date('Y-m-d G:i:s');
                        $especie1->informationwithheld = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colinformationwithheld+$this->sp1]));
                        $especie1->dynamicproperties = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colattributes+$this->sp1]));
                        $especie1->idoccurrenceelements = $this->getIdOccurrenceElements($i,$this->sp1)->idoccurrenceelements;
                        $especie1->idtaxonomicelements = $this->getIdTaxonomicElements($i,$this->sp1)->idtaxonomicelements;
                        if(!$this->isCuratorialVazio($i,$this->sp1)){
                             $especie1->idcuratorialelements = $this->getIdCuratorialElements($i,$this->sp1)->idcuratorialelements;
                        }
                        if(!$this->isIdentificationVazio($i,$this->sp1))
                            $especie1->ididentificationelements = $this->getIdIdentificationElements($i,$this->sp1)->ididentificationelements;

                        if(!$this->isEventVazio($i,$this->sp1))
                            $especie1->ideventelements = $this->getIdEventElements($i,$this->sp1)->ideventelements;

                        if(!$this->isLocalityVazio($i,$this->sp1))
                            $especie1->idlocalityelements = $this->getIdLocalityElements($i,$this->sp1)->idlocalityelements;

                        if(!$this->isGeospatialVazio($i,$this->sp1))
                            $especie1->idgeospatialelements = $this->getIdGeospatialElements($i,$this->sp1)->idgeospatialelements;

                        $especie1->globaluniqueidentifier = $globaUniqueId;
                        echo 'Linha '.$i.' - <b>Espécime 1</b> '.$globaUniqueId.' <b>inserido</b> corretamente. <br>';

                        $especie1->idrecordlevelelements=null;
                        $especie1->setIsNewRecord(true);
                        $especie1->insert();
                    }
                }
            }

            if(!$this->isSpVazio($i,$this->sp2)) {
                // verifica se todos os campos obrigat√≥rios nao estao preenchidos
                $sp2validade = $this->validarSp($i,$this->sp2);
                if(trim($sp2validade)!='ok') {
                    echo $sp2validade."<br>";
                    // se estiver v√°lido...
                }else {

                    $globaUniqueId = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colinstitutioncode+$this->sp2])).':'.CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colcollectioncode+$this->sp2])).':'.CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colcatalognumber+$this->sp2]));

                    $spExiste = recordlevelelements::model();
                    $spExiste = $this->existeRegistro($globaUniqueId);

                    if(isset ($spExiste)) {
                        $especie2 = $spExiste;
                        $especie2->setIsNewRecord(false);
                        $especie2->idbasisofrecord = $this->getIdBasisOfRecord($i,$this->sp2)->idbasisofrecord;
                        $especie2->modified = date('Y-m-d G:i:s');
                        $especie2->informationwithheld = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colinformationwithheld+$this->sp2]));
                        $especie2->dynamicproperties = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colattributes+$this->sp2]));
                        $this->setOccurrenceElements($especie2->idoccurrenceelements,$i,$this->sp2); // necessariamente ja existe (catalog num)
                        $this->setTaxonomicElements($especie2->idtaxonomicelements,$i,$this->sp2); // necessariamente ja existe (scientific name)
                        if(isset($especie2->idcuratorialelements)) {
                            $this->setCuratorialElements($especie2->idcuratorialelements,$i,$this->sp2);
                        }else {
                            if(!$this->isCuratorialVazio($i,$this->sp2)) {
                                $especie2->idcuratorialelements = $this->getIdCuratorialElements($i,$this->sp2)->idcuratorialelements;
                            }
                        }
                        if(isset($especie2->ididentificationelements)) {
                            $this->setIdentificationElements($especie2->ididentificationelements,$i,$this->sp2);
                        }else {
                            if(!$this->isIdentificationVazio($i,$this->sp2)) {
                                $especie2->ididentificationelements = $this->getIdIdentificationElements($i,$this->sp2)->ididentificationelements;
                            }
                        }
                        if(isset($especie2->ideventelements)) {
                            $this->setEventElements($especie2->ideventelements,$i,$this->sp2);
                        }else {
                            if(!$this->isEventVazio($i,$this->sp2)) {
                                $especie2->ideventelements = $this->getIdEventElements($i,$this->sp2)->ideventelements;
                            }
                        }
                        if(isset($especie2->idlocalityelements)) {
                            $this->setIdLocalityElements($especie2->idlocalityelements,$i,$this->sp2);
                        }else {
                            if(!$this->isLocalityVazio($i,$this->sp2)) {
                                $especie2->idlocalityelements = $this->getIdLocalityElements($i,$this->sp2)->idlocalityelements;
                            }
                        }
                        if(isset($especie2->idgeospatialelements)) {
                            $this->setGeospatialElements($especie2->idgeospatialelements,$i,$this->sp2);
                        }else {
                            if(!$this->isGeospatialVazio($i,$this->sp2)) {
                                $especie2->idgeospatialelements = $this->getIdGeospatialElements($i,$this->sp2)->idgeospatialelements;
                            }
                        }
                        $especie2->save();
                        echo 'Linha '.$i.' - <b>Espécime 2</b> '.$globaUniqueId.' <b>alterado</b> corretamente. <br>';
                        // se nao existe, cria um novo...
                    }else {
                        $especie2 = recordlevelelements::model();
                        $especie2->idinstitutioncode = $this->getIdInstitutionCode($i,$this->sp2)->idinstitutioncode;
                        $especie2->idcollectioncode = $this->getIdCollectionCode($i,$this->sp2)->idcollectioncode;
                        $especie2->idbasisofrecord = $this->getIdBasisOfRecord($i,$this->sp2)->idbasisofrecord;
                        $especie2->modified = date('Y-m-d G:i:s');
                        $especie2->informationwithheld = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colinformationwithheld+$this->sp2]));
                        $especie2->dynamicproperties = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colattributes+$this->sp2]));
                        $especie2->idoccurrenceelements = $this->getIdOccurrenceElements($i,$this->sp2)->idoccurrenceelements;
                        $especie2->idtaxonomicelements = $this->getIdTaxonomicElements($i,$this->sp2)->idtaxonomicelements;
                        if(!$this->isCuratorialVazio($i,$this->sp2))
                            $especie2->idcuratorialelements = $this->getIdCuratorialElements($i,$this->sp2)->idcuratorialelements;

                        if(!$this->isIdentificationVazio($i,$this->sp2))
                            $especie2->ididentificationelements = $this->getIdIdentificationElements($i,$this->sp2)->ididentificationelements;

                        if(!$this->isEventVazio($i,$this->sp2))
                            $especie2->ideventelements = $this->getIdEventElements($i,$this->sp2)->ideventelements;

                        if(!$this->isLocalityVazio($i,$this->sp2))
                            $especie2->idlocalityelements = $this->getIdLocalityElements($i,$this->sp2)->idlocalityelements;

                        if(!$this->isGeospatialVazio($i,$this->sp2))
                            $especie2->idgeospatialelements = $this->getIdGeospatialElements($i,$this->sp2)->idgeospatialelements;

                        $especie2->globaluniqueidentifier = $globaUniqueId;

                        $especie2->idrecordlevelelements = null;
                        $especie2->setIsNewRecord(true);
                        $especie2->insert();
                        echo 'Linha '.$i.' - <b>Espécime 2</b> '.$especie2->globaluniqueidentifier.' <b>inserido</b> corretamente. <br>';
                    }
                }
            }
            // verifica se interacao, sp1 ou sp2 nao estao vazios na linha atual ($i)

            if(!$this->isInteractionVazio($i)) {
                $interactionvalidade = $this->validarInteraction($i);

                if(trim($interactionvalidade)!='ok') {
                    echo $interactionvalidade."<br>";
                }else {

                    $interaction = interactionelements::model();
                    $idinteractiontype = $this->getIdInteractionType($i)->idinteractiontype;

                    $intExiste = $this->existeInteracao($especie1->idrecordlevelelements,$especie2->idrecordlevelelements,$idinteractiontype);

                    if(isset ($intExiste)) {
                        $interaction = $intExiste;
                        $interaction->setIsNewRecord(false);
                        $interaction->modified = date('Y-m-d G:i:s');
                        $interaction->interactionrelatedinformation = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colinteractionrelatedinformation]));

                        $interaction->save();
                        echo 'Linha '.$i.' - <b>Interação</b> entre '.$especie1->globaluniqueidentifier.' e '.$especie2->globaluniqueidentifier.' <b>alterado</b> corretamente. <br>';
                        // se nao existe, cria um novo...
                    }else {
                        $interaction->idspecimens1 = $especie1->idrecordlevelelements;
                        $interaction->idspecimens2 = $especie2->idrecordlevelelements;
                        $interaction->interactionrelatedinformation = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colinteractionrelatedinformation]));
                        $interaction->idinteractiontype = $this->getIdInteractionType($i)->idinteractiontype;
                        $interaction->modified = date('Y-m-d G:i:s');

                        $interaction->idinteractionelements = null;
                        $interaction->setIsNewRecord(true);
                        $interaction->insert();
                        echo 'Linha '.$i.' - <b>Interação</b> entre '.$especie1->globaluniqueidentifier.' e '.$especie2->globaluniqueidentifier.' <b>inserido</b> corretamente. <br>';
                    }
                }
            }
        }
    }


    public function getIdInteractionType($i) {
        $reg = interactiontypes::model()->find('UPPER(interactiontype)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colinteractiontype]))));
        if(isset($reg)) {
            return $reg;
        }else {
            $reg = interactiontypes::model();
            $reg->interactiontype = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colinteractiontype]));
            $reg->idinteractiontype = null;
            $reg->setIsNewRecord(true);
            $reg->insert();
            return $reg;
        }
    }
    public function getIdTaxonomicElements($i,$sp) {
        $reg = taxonomicelements::model();

        $reg->idscientificname = $this->getIdScientificName($i,$this->sp)->idscientificname;
        $reg->idkingdom = $this->getIdKingdom($i,$this->sp)->idkingdom;
        $reg->idphylum = $this->getIdPhylum($i,$this->sp)->idphylum;
        $reg->idclass = $this->getIdClass($i,$this->sp)->idclass;
        $reg->idorder = $this->getIdOrder($i,$this->sp)->idorder;
        $reg->idfamily = $this->getIdFamily($i,$this->sp)->idfamily;
        $reg->idgenus = $this->getIdGenus($i,$this->sp)->idgenus;
        $reg->idspecificepithet = $this->getIdSpecificEpithet($i,$this->sp)->idspecificepithet;
        $reg->idinfraspecificepithet = $this->getIdInfraspecificEpithet($i,$this->sp)->idinfraspecificepithet;
        $reg->idtaxonrank = $this->getIdTaxonRank($i,$this->sp)->idtaxonrank; //infrarank
        $reg->idscientificnameauthorship = $this->getIdScientificNameAuthorship($i,$this->sp)->idscientificnameauthorship; //AuthorYearOfScientificName
        $reg->idnomenclaturalcode = $this->getIdNomenclaturalCode($i,$this->sp)->idnomenclaturalcode;

        $reg->higherclassification = '';
        $kingdom = kingdoms::model();
        $phylum = phylums::model();
        $class = classes::model();
        $order = orders::model();
        $family = families::model();
        $genus = genus::model();

        $higherclassification .= ($reg->idkingdom <> "" ? $kingdom->findByPk($reg->idkingdom)->getAttribute('kingdom').";" : "");
        $higherclassification .= ($reg->idphylum <> "" ? $phylum->findByPk($reg->idphylum)->getAttribute('phylum').";" : "");
        $higherclassification .= ($reg->idclass <> "" ? $class->findByPk($reg->idclass)->getAttribute('class').";" : "");
        $higherclassification .= ($reg->idorder <> "" ? $order->findByPk($reg->idorder)->getAttribute('order').";" : "");
        $higherclassification .= ($reg->idfamily <> "" ? $family->findByPk($reg->idfamily)->getAttribute('family').";" : "");
        $higherclassification .= ($reg->idgenus <> "" ? $genus->findByPk($reg->idgenus)->getAttribute('genus').";" : "");

        $higherclassification = preg_replace("/;$/", "", $higherclassification);
        $higherclassification = preg_replace("/^;/", "", $higherclassification);

        $reg->higherclassification = $higherclassification;

        $reg->idtaxonomicelements = null;
        $reg->setIsNewRecord(true);
        $reg->insert();

        return $reg;
    }
    public function getIdOccurrenceElements($i,$sp) {
        $reg = occurrenceelements::model();

        $reg->catalognumber = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colcatalognumber+$sp]));
        $reg->occurrenceremarks = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colremarks+$sp]));
        $reg->occurrencedetails = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colrelatedinformation+$sp]));
        $reg->othercatalognumber = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colothercatalognumbers+$sp]));
        $reg->iddisposition = $this->getIdDisposition($i,$this->sp)->iddisposition;
        $reg->idestablishmentmeans = $this->getIdStablishmentMeans($i,$this->sp)->idestablishmentmeans;//Valid Distrib... flag
        $reg->idlifestage = $this->getIdLifeStage($i,$this->sp)->idlifestage;
        $reg->idsex = $this->getIdSex($i,$this->sp)->idsex;
        $reg->recordnumber = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colcollectornumber+$sp]));
        $reg->idoccurrenceelements = null;
        $reg->setIsNewRecord(true);
        $reg->insert();

        // Identified by Save
        $recby = recordedby::model()->find('UPPER(recordedby)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colcollector+$sp]))));
        if(isset ($recby)) {
            $recbyocc = recordedbyoccurrence::model()->find('idrecordedby=:rec AND idoccurrenceelements=:occ',array(':rec'=>($recby->idrecordedby),':occ'=>($reg->idoccurrenceelements)));

            if(!isset ($recbyocc)) {
                $recbyocc = recordedbyoccurrence::model();
                $recbyocc->idrecordedby = $recby->idrecordedby;
                $recbyocc->idoccurrenceelements = $reg->idoccurrenceelements;
                $recbyocc->setIsNewRecord(true);
                $recbyocc->insert();
            }
        }else {
            $recby = recordedby::model();
            $recby->recordedby = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colcollector+$sp]));
            $recby->idrecordedby = null;
            $recby->setIsNewRecord(true);
            $recby->insert();
            $recbyocc = recordedbyoccurrence::model();
            $recbyocc->idrecordedby = $recby->idrecordedby;
            $recbyocc->idoccurrenceelements = $reg->idoccurrenceelements;
            $recbyocc->setIsNewRecord(true);
            $recbyocc->insert();
        }

        return $reg;

    }
    public function getIdGeospatialElements($i,$sp) {
        $reg = geospatialelements::model();

        $reg->idgeoreferenceverificationstatus = $this->getIdGeoreferenceVerificationStatus($i,$this->sp)->idgeoreferenceverificationstatus;

        $reg->decimallongitude = str_replace(',', '.', trim($this->reader->sheets[0]["cells"][$i][$this->coldecimallongitude+$sp]));
        $reg->decimallatitude = str_replace(',', '.', trim($this->reader->sheets[0]["cells"][$i][$this->coldecimallatitude+$sp]));
        $reg->coordinateuncertaintyinmeters = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colcoordinateuncertaintyinmeters+$sp]));
        $reg->georeferenceremarks = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colgeospatialremarks+$sp]));
        $reg->geodeticdatum = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colgeodeticdatum+$sp]));
        $reg->pointradiusspatialfit = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colpointradiusspatialfit+$sp]));
        $reg->verbatimcoordinates = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colverbatimcoordinates+$sp]));
        $reg->verbatimlatitude = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colverbatimlatitude+$sp]));
        $reg->verbatimlongitude = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colverbatimlongitude+$sp]));
        $reg->verbatimcoordinatesystem = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colverbatimcoordinatesystem+$sp]));
        $reg->georeferenceprotocol = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colgeoreferenceprotocol+$sp]));
        $reg->footprintwkt = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colfootprintwkt+$sp]));
        $reg->footprintspatialfit = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colfootprintspatialfit+$sp]));

        $reg->idgeospatialelements = null;
        $reg->setIsNewRecord(true);
        $reg->insert();

        // Georeference source
        $source = georeferencesourcesgeo::model()->find('UPPER(georeferencesources)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colgeoreferencesources+$sp]))));
        if(isset ($source)) {
            $sourcegeo = georeferencesourcesgeospatial::model();
            $sourcegeo->idgeoreferencesources = $source->idgeoreferencesources;
            $sourcegeo->idgeospatialelements = $reg->idgeospatialelements;
            $sourcegeo->setIsNewRecord(true);
            $sourcegeo->insert();

        }else {
            $source = georeferencesourcesgeo::model();
            $source->georeferencesources = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colgeoreferencesources+$sp]));
            $source->idgeoreferencesource = null;
            $source->setIsNewRecord(true);
            $source->insert();
            $sourcegeo = georeferencesourcesgeospatial::model();
            $sourcegeo->idgeoreferencesources = $source->idgeoreferencesources;
            $sourcegeo->idgeospatialelements = $reg->idgeospatialelements;
            $sourcegeo->setIsNewRecord(true);
            $sourcegeo->insert();
        }

        return $reg;
    }
    public function isGeospatialVazio($i,$sp) {
        return trim($this->reader->sheets[0]["cells"][$i][$this->coldecimallongitude+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->coldecimallatitude+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->colcoordinateuncertaintyinmeters+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->colgeospatialremarks+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->colgeodeticdatum+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->colpointradiusspatialfit+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->colverbatimcoordinates+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->colverbatimlatitude+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->colverbatimlongitude+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->colverbatimcoordinatesystem+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->colgeoreferenceprotocol+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->colverificationstatus+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->colfootprintspatialfit+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->colgeoreferencesources+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->colfootprintwkt+$sp])==''?true:false;
    }
    public function setGeospatialElements($id,$i,$sp) {
        $reg = geospatialelements::model()->findByPk($id);
        $reg->setIsNewRecord(false);

        $reg->idgeoreferenceverificationstatus = $this->getIdGeoreferenceVerificationStatus($i,$this->sp)->idgeoreferenceverificationstatus;

        $reg->decimallongitude = trim($this->reader->sheets[0]["cells"][$i][$this->coldecimallongitude+$sp]);
        $reg->decimallatitude = trim($this->reader->sheets[0]["cells"][$i][$this->coldecimallatitude+$sp]);
        $reg->coordinateuncertaintyinmeters = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colcoordinateuncertaintyinmeters+$sp]));
        $reg->georeferenceremarks = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colgeospatialremarks+$sp]));
        $reg->geodeticdatum = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colgeodeticdatum+$sp]));
        $reg->pointradiusspatialfit = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colpointradiusspatialfit+$sp]));
        $reg->verbatimcoordinates = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colverbatimcoordinates+$sp]));
        $reg->verbatimlatitude = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colverbatimlatitude+$sp]));
        $reg->verbatimlongitude = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colverbatimlongitude+$sp]));
        $reg->verbatimcoordinatesystem = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colverbatimcoordinatesystem+$sp]));
        $reg->georeferenceprotocol = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colgeoreferenceprotocol+$sp]));
        $reg->footprintwkt = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colfootprintwkt+$sp]));
        $reg->footprintspatialfit = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colfootprintspatialfit+$sp]));

        // Georeference source Save
        $source = georeferencesourcesgeo::model()->find('UPPER(georeferencesources)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colgeoreferencesources+$sp]))));
        if(isset ($source)) {
            $sourcegeo = georeferencesourcesgeospatial::model()->find('idgeoreferencesources=:sour AND idgeospatialelements=:geo',array(':sour'=>($source->idgeoreferencesources),':geo'=>($reg->idgeospatialelements)));
            if(!isset ($sourcegeo)) {
                $sourcegeo = georeferencesourcesgeospatial::model();
                $sourcegeo->idgeoreferencesources = $source->idgeoreferencesources;
                $sourcegeo->idgeospatialelements = $reg->idgeospatialelements;
                $sourcegeo->setIsNewRecord(true);
                $sourcegeo->save();
            }
        }else {
            $source->georeferencesources = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colgeoreferencesources+$sp]));
            $source->setIsNewRecord(true);
            $source->save();
            $sourcegeo = georeferencesourcesgeospatial::model();
            $sourcegeo->idgeoreferencesources = $identby->idgeoreferencesources;
            $sourcegeo->idgeospatialelements = $reg->idgeospatialelements;
            $sourcegeo->setIsNewRecord(true);
            $sourcegeo->save();
        }

        $reg->save();

        return $reg;
    }
    public function getIdGeoreferenceVerificationStatus($i,$sp) {
        $reg = georeferenceverificationstatus::model()->find('UPPER(georeferenceverificationstatus)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colverificationstatus+$sp]))));
        if(isset($reg)) {
            return $reg;
        }else {
            $reg = georeferenceverificationstatus::model();
            $reg->georeferenceverificationstatus = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colverificationstatus+$sp]));
            $reg->idgeoreferenceverificationstatus = null;
            $reg->setIsNewRecord(true);
            $reg->insert();
            return $reg;
        }
    }
    public function getIdLocalityElements($i,$sp) {
        $reg = localityelements::model();

        $reg->idcontinent = $this->getIdContinent($i,$this->sp)->idcontinent;
        $reg->idwaterbody = $this->getIdWaterBody($i,$this->sp)->idwaterbody;
        $reg->idislandgroup = $this->getIdIslandGroup($i,$this->sp)->idislandgroup;
        $reg->idisland = $this->getIdIsland($i,$this->sp)->idisland;
        $reg->idcountry = $this->getIdCountry($i,$this->sp)->idcountry;
        $reg->idstateprovince = $this->getIdStateProvince($i,$this->sp)->idstateprovince;
        $reg->idcounty = $this->getIdCounty($i,$this->sp)->idcounty;
        $reg->idlocality = $this->getIdLocality($i,$this->sp)->idlocality;
        $reg->minimumelevationinmeters = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colminimumelevationinmeters+$sp]));
        $reg->maximumelevationinmeters = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colmaximumelevationinmeters+$sp]));
        $reg->minimumdepthinmeters = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colminimumdepthinmeters+$sp]));
        $reg->maximumdepthinmeters = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colmaximumdepthinmeters+$sp]));

        $continet = continents::model();
        $waterbody = waterbodies::model();
        $islandgroup = islandgroups::model();
        $island = islands::model();
        $country = countries::model();
        $stateprovince = stateprovinces::model();
        $county = counties::model();

        $highergeograph = ($reg->idcontinent <> "" ? $continet->findByPk($reg->idcontinent)->getAttribute('continent').";" : "");
        $highergeograph .= ($reg->idwaterbody <> "" ? $waterbody->findByPk($reg->idwaterbody)->getAttribute('waterbody').";" : "");
        $highergeograph .= ($reg->idislandgroup <> "" ? $islandgroup->findByPk($reg->idislandgroup)->getAttribute('islandgroup').";" : "");
        $highergeograph .= ($reg->idisland <> "" ? $island->findByPk($reg->idisland)->getAttribute('island').";" : "");
        $highergeograph .= ($reg->idcountry<> "" ? $country->findByPk($reg->idcountry)->getAttribute('country').";" : "");
        $highergeograph .= ($reg->idstateprovince <> "" ? $stateprovince->findByPk($reg->idstateprovince)->getAttribute('stateprovince').";" : "");
        $highergeograph .= ($reg->idcounty <> "" ? $county->findByPk($reg->idcounty)->getAttribute('county').";" : "");

        $highergeograph = preg_replace("/;$/", "", $highergeograph);
        $highergeograph = preg_replace("/^;/", "", $highergeograph);

        $reg->highergeograph= $highergeograph;

        $reg->idlocalityelements = null;
        $reg->setIsNewRecord(true);
        $reg->insert();

        return $reg;
    }
    public function isLocalityVazio($i,$sp) {
        return trim($this->reader->sheets[0]["cells"][$i][$this->colminimumelevationinmeters+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->colmaximumelevationinmeters+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->colminimumdepthinmeters+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->colmaximumdepthinmeters+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->colcontinent+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->colwaterbody+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->colisland+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->colislandgroup+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->colcountry+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->colstateorprovince+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->colcounty+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->collocality+$sp])==''?true:false;
    }
    public function setIdLocalityElements($id,$i,$sp) {
        $reg = localityelements::model()->findByPk($id);
        $reg->setIsNewRecord(false);

        $reg->idcontinent = $this->getIdContinent($i,$this->sp)->idcontinent;
        $reg->idwaterbody = $this->getIdWaterBody($i,$this->sp)->idwaterbody;
        $reg->idislandgroup = $this->getIdIslandGroup($i,$this->sp)->idislandgroup;
        $reg->idisland = $this->getIdIsland($i,$this->sp)->idisland;
        $reg->idcountry = $this->getIdCountry($i,$this->sp)->idcountry;
        $reg->idstateprovince = $this->getIdStateProvince($i,$this->sp)->idstateprovince;
        $reg->idcounty = $this->getIdCounty($i,$this->sp)->idcounty;
        $reg->idlocality = $this->getIdLocality($i,$this->sp)->idlocality;
        $reg->minimumelevationinmeters = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colminimumelevationinmeters+$sp]));
        $reg->maximumelevationinmeters = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colmaximumelevationinmeters+$sp]));
        $reg->minimumdepthinmeters = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colminimumdepthinmeters+$sp]));
        $reg->maximumdepthinmeters = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colmaximumdepthinmeters+$sp]));

        $reg->highergeograph = '';
        $continet = continents::model();
        $waterbody = waterbodies::model();
        $islandgroup = islandgroups::model();
        $island = islands::model();
        $country = countries::model();
        $stateprovince = stateprovinces::model();
        $county = counties::model();

        $highergeograph .= ($reg->idcontinent <> "" ? $continet->findByPk($reg->idcontinent)->getAttribute('continent').";" : "");
        $highergeograph .= ($reg->idwaterbody <> "" ? $waterbody->findByPk($reg->idwaterbody)->getAttribute('waterbody').";" : "");
        $highergeograph .= ($reg->idislandgroup <> "" ? $islandgroup->findByPk($reg->idislandgroup)->getAttribute('islandgroup').";" : "");
        $highergeograph .= ($reg->idisland <> "" ? $island->findByPk($reg->idisland)->getAttribute('island').";" : "");
        $highergeograph .= ($reg->idcountry<> "" ? $country->findByPk($reg->idcountry)->getAttribute('country').";" : "");
        $highergeograph .= ($reg->idstateprovince <> "" ? $stateprovince->findByPk($reg->idstateprovince)->getAttribute('stateprovince').";" : "");
        $highergeograph .= ($reg->idcounty <> "" ? $county->findByPk($reg->idcounty)->getAttribute('county').";" : "");

        $highergeograph = preg_replace("/;$/", "", $highergeograph);
        $highergeograph = preg_replace("/^;/", "", $highergeograph);

        $reg->highergeograph = $highergeograph;
        $reg->save();

        return $reg;
    }
    public function getIdLocality($i,$sp) {
        $reg = localities::model()->find('UPPER(locality)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->collocality+$sp]))));
        if(isset($reg)) {
            return $reg;
        }else {
            $reg = localities::model();
            $reg->locality = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->collocality+$sp]));
            $reg->idlocality = null;
            $reg->setIsNewRecord(true);
            $reg->insert();
            return $reg;
        }
    }
    public function getIdWaterBody($i,$sp) {
        $reg = waterbodies::model()->find('UPPER(waterbody)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colwaterbody+$sp]))));
        if(isset($reg)) {
            return $reg;
        }else {
            $reg = waterbodies::model();
            $reg->waterbody = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colwaterbody+$sp]));
            $reg->idwaterbody = null;
            $reg->setIsNewRecord(true);
            $reg->insert();
            return $reg;
        }
    }
    public function getIdIslandGroup($i,$sp) {
        $reg = islandgroups::model()->find('UPPER(islandgroup)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colislandgroup+$sp]))));
        if(isset($reg)) {
            return $reg;
        }else {
            $reg = islandgroups::model();
            $reg->islandgroup = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colislandgroup+$sp]));
            $reg->idislandgroup = null;
            $reg->setIsNewRecord(true);
            $reg->insert();
            return $reg;
        }
    }
    public function getIdIsland($i,$sp) {
        $reg = islands::model()->find('UPPER(island)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colisland+$sp]))));
        if(isset($reg)) {
            return $reg;
        }else {
            $reg = islands::model();
            $reg->island = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colisland+$sp]));
            $reg->idisland = null;
            $reg->setIsNewRecord(true);
            $reg->insert();
            return $reg;
        }
    }
    public function getIdCounty($i,$sp) {
        $reg = counties::model()->find('UPPER(county)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colcounty+$sp]))));
        if(isset($reg)) {
            return $reg;
        }else {
            $reg = counties::model();
            $reg->county = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colcounty+$sp]));
            $reg->idcounty = null;
            $reg->setIsNewRecord(true);
            $reg->insert();
            return $reg;
        }
    }
    public function getIdStateProvince($i,$sp) {
        $reg = stateprovinces::model()->find('UPPER(stateprovince)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colstateorprovince+$sp]))));
        if(isset($reg)) {
            return $reg;
        }else {
            $reg = stateprovinces::model();
            $reg->stateprovince = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colstateorprovince+$sp]));
            $reg->idstateprovince = null;
            $reg->setIsNewRecord(true);
            $reg->insert();
            return $reg;
        }
    }
    public function getIdCountry($i,$sp) {
        $reg = countries::model()->find('UPPER(country)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colcountry+$sp]))));
        if(isset($reg)) {
            return $reg;
        }else {
            $reg = countries::model();
            $reg->country = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colcountry+$sp]));
            $reg->idcountry = null;
            $reg->setIsNewRecord(true);
            $reg->insert();
            return $reg;
        }
    }
    public function getIdContinent($i,$sp) {
        $reg = continents::model()->find('UPPER(continent)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colcontinent+$sp]))));
        if(isset($reg)) {
            return $reg;
        }else {
            $reg = continents::model();
            $reg->continent = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colcontinent+$sp]));
            $reg->idcontinet = null;
            $reg->setIsNewRecord(true);
            $reg->save();
            return $reg;
        }
    }
    public function getIdEventElements($i,$sp) {
        $reg = eventelements::model();

        $reg->idsamplingprotocol = $this->getIdSamplingProtocol($i, $sp)->idsamplingprotocol;
        $reg->verbatimeventdate = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colearliestdatecollected+$sp]).' - '.trim($this->reader->sheets[0]["cells"][$i][$this->collatestdatecollected+$sp]));
        
        $lastdatetime = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->collatestdatecollected+$sp]))!=''?split(' ',CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->collatestdatecollected+$sp]))):null;
        $dateArray = $lastdatetime!=null?split('/',$lastdatetime[0]):null;
        $ano = $dateArray!=null?(int)$dateArray[2]:null;
        $ano = $ano!=null?$ano<=99&&$ano>20?$ano+1900:$ano+2000:null;
        $date = $dateArray!=null?$ano.'-'.$dateArray[1].'-'.$dateArray[0]:null;
        $reg->eventdate = $date;
        $reg->eventtime = $lastdatetime!=null?$lastdatetime[1]:null;

        $reg->ideventelements = null;
        $reg->setIsNewRecord(true);
        $reg->save();

        return $reg;
    }
    public function isEventVazio($i,$sp) {
        return trim($this->reader->sheets[0]["cells"][$i][$this->colidentificationqualifier+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->collatestdatecollected+$sp])==''
                ?true:false;
    }
    public function setEventElements($id,$i,$sp) {
        $reg = eventelements::model()->findByPk($id);
        $reg->setIsNewRecord(false);

        $reg->idsamplingprotocol = $this->getIdSamplingProtocol($i, $sp)->idsamplingprotocol;
        $reg->verbatimeventdate = trim($this->reader->sheets[0]["cells"][$i][$this->colearliestdatecollected+$sp]).' - '.trim($this->reader->sheets[0]["cells"][$i][$this->collatestdatecollected+$sp]);
        $lastdatetime = trim($this->reader->sheets[0]["cells"][$i][$this->collatestdatecollected+$sp])!=''?split(' ',trim($this->reader->sheets[0]["cells"][$i][$this->collatestdatecollected+$sp])):null;
        $dateArray = $lastdatetime!=null?split('/',$lastdatetime[0]):null;
        $ano = $dateArray!=null?(int)$dateArray[2]:null;
        //$ano = $ano!=null?$ano<=99&&$ano>20?$ano+1900:$ano+2000:null;
        $date = $dateArray!=null?$ano.'-'.$dateArray[1].'-'.$dateArray[0]:null;
        $reg->eventdate = $date;
        $reg->eventtime = $lastdatetime!=null?$lastdatetime[1]:null;

        $reg->save();

        return $reg;
    }
    public function getIdSamplingProtocol($i,$sp) {
        $reg = samplingprotocols::model()->find('UPPER(samplingprotocol)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colcollectingmethod+$sp]))));
        if(isset($reg)) {
            return $reg;
        }else {
            $reg = samplingprotocols::model();
            $reg->samplingprotocol = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colcollectingmethod+$sp]));
            $reg->idsamplingprotocol = null;
            $reg->setIsNewRecord(true);
            $reg->insert();
            return $reg;
        }
    }
    public function getIdIdentificationElements($i,$sp) {
        $reg = identificationelements::model();
        $reg->ididentificationelements = null;
        $reg->setIsNewRecord(true);
        $reg->ididentificationqualifier = $this->getIdIdentificationQualifier($i,$sp)->ididentificationqualifier;
        $reg->insert();

        return $reg;
    }
    public function getIdIdentificationQualifier($i,$sp) {
        $reg = identificationqualifiers::model()->find('UPPER(identificationqualifier)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colidentificationqualifier+$sp]))));
        if(isset($reg)) {
            return $reg;
        }else {
            $reg = identificationqualifiers::model();
            $reg->identificationqualifier = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colidentificationqualifier+$sp]));
            $reg->ididentificationqualifier = null;
            $reg->setIsNewRecord(true);
            $reg->insert();
            return $reg;
        }
    }
    public function isIdentificationVazio($i,$sp) {
        return trim($this->reader->sheets[0]["cells"][$i][$this->colidentificationqualifier+$sp])==''?true:false;
    }
    public function setIdentificationElements($id,$i,$sp) {
        $reg = identificationelements::model()->findByPk($id);
        $reg->setIsNewRecord(false);
        $reg->ididentificationqualifier = $this->getIdIdentificationQualifier($i,$sp)->ididentificationqualifier;

        $reg->save();

        return $reg;
    }
    public function getIdCuratorialElements($i,$sp) {
        $reg = curatorialelements::model();
        $reg->idcuratorialelements = null;
        $reg->setIsNewRecord(true);

        $reg->dateidentified = trim($this->reader->sheets[0]["cells"][$i][$this->coldateidentified+$sp])!=''?trim($this->reader->sheets[0]["cells"][$i][$this->coldateidentified+$sp]):null;
        $reg->fieldnumber = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colfieldnumber+$sp]));
        $reg->fieldnotes = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colfieldnotes+$sp]));
        $reg->verbatimeventdate = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colverbatimcollectingdate+$sp]));
        $reg->verbatimelevation = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colverbatimelevation+$sp]));
        $reg->verbatimdepth = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colverbatimdepth+$sp]));
        $reg->individualcount = ereg('([0-9])*', trim($this->reader->sheets[0]["cells"][$i][$this->colindividualcount+$sp]))?trim($this->reader->sheets[0]["cells"][$i][$this->colindividualcount+$sp]):'';
        $reg->iddispositioncur = $this->getIdDisposition($i, $sp)->iddisposition;

        $reg->insert();

        // Identified by Save
        $identby = identifiedbycur::model()->find('UPPER(identifiedby)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colidentifiedby+$sp]))));
        if(isset ($identby)) {

            $identbycuratorial = identifiedbycuratorial::model();
            $identbycuratorial->ididentifiedby = $identby->ididentifiedby;
            $identbycuratorial->idcuratorialelements = $reg->idcuratorialelements;
            $identbycuratorial->setIsNewRecord(true);
            $identbycuratorial->save();

        }else {
            $identby = identifiedbycur::model();
            $identby->identifiedby = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colidentifiedby+$sp]));
            $identby->setIsNewRecord(true);
            $identby->save();
            $identbycuratorial = identifiedbycuratorial::model();
            $identbycuratorial->ididentifiedby = $identby->ididentifiedby;
            $identbycuratorial->idcuratorialelements = $reg->idcuratorialelements;
            $identbycuratorial->setIsNewRecord(true);
            $identbycuratorial->save();
        }
        // Preparations Save
        $prep = preparationscur::model()->find('UPPER(preparations)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colpreparations+$sp]))));
        if(isset ($prep)) {
            $preparationscuratorial = preparationscuratorial::model();
            $preparationscuratorial->idpreparations = $prep->idpreparations;
            $preparationscuratorial->idcuratorialelements = $reg->idcuratorialelements;
            $preparationscuratorial->setIsNewRecord(true);            
            $preparationscuratorial->save();            
        }else {
            $prep = preparationscur::model();
            $prep->preparations = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colpreparations+$sp]));
            $prep->setIsNewRecord(true);
            $prep->save();
            $preparationscuratorial = preparationscuratorial::model();
            $preparationscuratorial->idpreparations = $prep->idpreparations;
            $preparationscuratorial->idcuratorialelements = $reg->idcuratorialelements;
            $preparationscuratorial->setIsNewRecord(true);
            $preparationscuratorial->save();
        }
        // Type Status Save
        $type = typestatus::model()->find('UPPER(typestatus)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->coltypestatus+$sp]))));
        if(isset ($type)) {
            $typecur = typestatuscuratorial::model();
            $typecur->idtypestatus = $type->idtypestatus;
            $typecur->idcuratorialelements = $reg->idcuratorialelements;
            $typecur->setIsNewRecord(true);
            $typecur->save();
        }else {
            $type = typestatus::model();
            $type->typestatus = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->coltypestatus+$sp]));
            $type->setIsNewRecord(true);
            $type->save();
            $typecur = typestatuscuratorial::model();
            $typecur->idtypestatus = $type->idtypestatus;
            $typecur->idcuratorialelements = $reg->idcuratorialelements;
            $typecur->setIsNewRecord(true);
            $typecur->save();
        }
        // Associated Sequences Save
        $ass = associatedsequencescur::model()->find('UPPER(associatedsequences)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colgenbanknumber+$sp]))));
        if(isset ($ass)) {
            $asscur = associatedsequencescuratorial::model();
            $asscur->idassociatedsequences = $ass->idassociatedsequences;
            $asscur->idcuratorialelements = $reg->idcuratorialelements;
            $asscur->setIsNewRecord(true);
            $asscur->save();
        }else {
            $ass = associatedsequencescur::model();
            $ass->associatedsequences = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colgenbanknumber+$sp]));
            $ass->setIsNewRecord(true);
            $ass->save();
            $asscur = associatedsequencescuratorial::model();
            $asscur->idassociatedsequences  = $ass->idassociatedsequences;
            $asscur->idcuratorialelements = $reg->idcuratorialelements;
            $asscur->setIsNewRecord(true);
            $asscur->save();
        }
       
        return $reg;
    }
    public function isCuratorialVazio($i,$sp) {
        return trim($this->reader->sheets[0]["cells"][$i][$this->colidentifiedby+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->colpreparations+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->coltypestatus+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->colgenbanknumber+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->coldateidentified+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->colfieldnumber+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->colfieldnotes+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->colverbatimcollectingdate+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->colverbatimelevation+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->colverbatimdepth+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->colindividualcount+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->coldisposition+$sp])==''?true:false;
    }
    public function setCuratorialElements($id,$i,$sp) {
        $reg = curatorialelements::model()->findByPk($id);
        $reg->setIsNewRecord(false);

        // Identified by Save
        $identby = identifiedbycur::model()->find('UPPER(identifiedby)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colidentifiedby+$sp]))));
        if(isset ($identby)) {
            $identbycuratorial = identifiedbycuratorial::model()->find('ididentifiedby=:ident AND idcuratorialelements=:cur',array(':ident'=>($identby->ididentifiedby),':cur'=>($reg->idcuratorialelements)));

            if(!isset ($identbycuratorial)) {
                $identbycuratorial = identifiedbycuratorial::model();
                $identbycuratorial->ididentifiedby = $identby->ididentifiedby;
                $identbycuratorial->idcuratorialelements = $reg->idcuratorialelements;
                $identbycuratorial->setIsNewRecord(true);
                $identbycuratorial->save();
            }
        }else {
            $identby = identifiedbycur::model();
            $identby->identifiedby = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colidentifiedby+$sp]));
            $identby->setIsNewRecord(true);
            $identby->save();
            $identbycuratorial = identifiedbycuratorial::model();
            $identbycuratorial->ididentifiedby = $identby->ididentifiedby;
            $identbycuratorial->idcuratorialelements = $reg->idcuratorialelements;
            $identbycuratorial->setIsNewRecord(true);
            $identbycuratorial->save();
        }
        // Preparations Save
        $prep = preparationscur::model()->find('UPPER(preparations)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colpreparations+$sp]))));
        if(isset ($prep)) {
            $preparationscuratorial = preparationscuratorial::model()->find('idpreparations=:prep AND idcuratorialelements=:cur',array(':prep'=>($prep->idpreparations),':cur'=>($reg->idcuratorialelements)));
            if(!isset ($preparationscuratorial)) {
                $preparationscuratorial = preparationscuratorial::model();
                $preparationscuratorial->idpreparations = $prep->idpreparations;
                $preparationscuratorial->idcuratorialelements = $reg->idcuratorialelements;
                $preparationscuratorial->setIsNewRecord(true);
                $preparationscuratorial->save();
            }
        }else {
            $prep = preparationscur::model();
            $prep->preparations = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colpreparations+$sp]));
            $prep->setIsNewRecord(true);
            $prep->save();
            $preparationscuratorial = preparationscuratorial::model();
            $preparationscuratorial->idpreparations = $prep->idpreparations;
            $preparationscuratorial->idcuratorialelements = $reg->idcuratorialelements;
            $preparationscuratorial->setIsNewRecord(true);
            $preparationscuratorial->save();
        }
        // Type Status Save
        $type = typestatus::model()->find('UPPER(typestatus)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->coltypestatus+$sp]))));
        if(isset ($type)) {
            $typecur = typestatuscuratorial::model()->find('idtypestatus=:type AND idcuratorialelements=:cur',array(':type'=>($type->idtypestatus),':cur'=>($reg->idcuratorialelements)));
            if(!isset ($typecur)) {
                $typecur = typestatuscuratorial::model();
                $typecur->idtypestatus = $type->idtypestatus;
                $typecur->idcuratorialelements = $reg->idcuratorialelements;
                $typecur->setIsNewRecord(true);
                $typecur->save();
            }
        }else {
            $type = typestatus::model();
            $type->typestatus = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->coltypestatus+$sp]));
            $type->setIsNewRecord(true);
            $type->save();
            $typecur = typestatuscuratorial::model();
            $typecur->idtypestatus = $type->idtypestatus;
            $typecur->idcuratorialelements = $reg->idcuratorialelements;
            $typecur->setIsNewRecord(true);
            $typecur->save();
        }
        // Associated Sequences Save
        $ass = associatedsequencescur::model()->find('UPPER(associatedsequences)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colgenbanknumber+$sp]))));
        if(isset ($ass)) {
            $asscur = associatedsequencescuratorial::model()->find('idassociatedsequences=:ass AND idcuratorialelements=:cur',array(':ass'=>($ass->idassociatedsequences),':cur'=>($reg->idcuratorialelements)));
            if(!isset ($asscur)) {
                $asscur = associatedsequencescuratorial::model();
                $asscur->idassociatedsequences = $ass->idassociatedsequences;
                $asscur->idcuratorialelements = $reg->idcuratorialelements;
                $asscur->setIsNewRecord(true);
                $asscur->save();
            }
        }else {
            $ass = associatedsequencescur::model();
            $ass->associatedsequences = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colgenbanknumber+$sp]));
            $ass->setIsNewRecord(true);
            $ass->save();
            $asscur = associatedsequencescuratorial::model();
            $asscur->idassociatedsequences  = $ass->idassociatedsequences;
            $asscur->idcuratorialelements = $reg->idcuratorialelements;
            $asscur->setIsNewRecord(true);
            $asscur->save();
        }
        $reg->dateidentified = trim($this->reader->sheets[0]["cells"][$i][$this->coldateidentified+$sp])!=''?trim($this->reader->sheets[0]["cells"][$i][$this->coldateidentified+$sp]):null;
        $reg->fieldnumber = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colfieldnumber+$sp]));
        $reg->fieldnotes = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colfieldnotes+$sp]));
        $reg->verbatimeventdate = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colverbatimcollectingdate+$sp]));
        $reg->verbatimelevation = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colverbatimelevation+$sp]));
        $reg->verbatimdepth = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colverbatimdepth+$sp]));
        $reg->individualcount = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->tcolindividualcount+$sp]));
        $reg->iddispositioncur = $this->getIdDisposition($i, $sp)->iddisposition;

        $reg->save();

        return $reg;
    }
    public function setTaxonomicElements($id,$i,$sp) {
        $reg = taxonomicelements::model()->findByPk($id);
        $reg->setIsNewRecord(false);

        $reg->idscientificname = $this->getIdScientificName($i,$this->sp)->idscientificname;
        $reg->idkingdom = $this->getIdKingdom($i,$this->sp)->idkingdom;
        $reg->idphylum = $this->getIdPhylum($i,$this->sp)->idphylum;
        $reg->idclass = $this->getIdClass($i,$this->sp)->idclass;
        $reg->idorder = $this->getIdOrder($i,$this->sp)->idorder;
        $reg->idfamily = $this->getIdFamily($i,$this->sp)->idfamily;
        $reg->idgenus = $this->getIdGenus($i,$this->sp)->idgenus;
        $reg->idspecificepithet = $this->getIdSpecificEpithet($i,$this->sp)->idspecificepithet;
        $reg->idinfraspecificepithet = $this->getIdInfraspecificEpithet($i,$this->sp)->idinfraspecificepithet;
        $reg->idtaxonrank = $this->getIdTaxonRank($i,$this->sp)->idtaxonrank; //infrarank
        $reg->idscientificnameauthorship = $this->getIdScientificNameAuthorship($i,$this->sp)->idscientificnameauthorship; //AuthorYearOfScientificName
        $reg->idnomenclaturalcode = $this->getIdNomenclaturalCode($i,$this->sp)->idnomenclaturalcode;

        $reg->higherclassification = '';
        $kingdom = kingdoms::model();
        $phylum = phylums::model();
        $class = classes::model();
        $order = orders::model();
        $family = families::model();
        $genus = genus::model();

        $higherclassification .= ($reg->idkingdom <> "" ? $kingdom->findByPk($reg->idkingdom)->getAttribute('kingdom').";" : "");
        $higherclassification .= ($reg->idphylum <> "" ? $phylum->findByPk($reg->idphylum)->getAttribute('phylum').";" : "");
        $higherclassification .= ($reg->idclass <> "" ? $class->findByPk($reg->idclass)->getAttribute('class').";" : "");
        $higherclassification .= ($reg->idorder <> "" ? $order->findByPk($reg->idorder)->getAttribute('order').";" : "");
        $higherclassification .= ($reg->idfamily <> "" ? $family->findByPk($reg->idfamily)->getAttribute('family').";" : "");
        $higherclassification .= ($reg->idgenus <> "" ? $genus->findByPk($reg->idgenus)->getAttribute('genus').";" : "");

        $higherclassification = preg_replace("/;$/", "", $higherclassification);
        $higherclassification = preg_replace("/^;/", "", $higherclassification);

        $reg->higherclassification = $higherclassification;
        $reg->save();

        return $reg;

    }
    public function getIdNomenclaturalCode($i,$sp) {
        $reg = nomenclaturalcodes::model()->find('UPPER(nomenclaturalcode)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colnomenclaturalcode+$sp]))));
        if(isset($reg)) {
            return $reg;
        }else {
            $reg = nomenclaturalcodes::model();
            $reg->nomenclaturalcode = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colnomenclaturalcode+$sp]));
            $reg->idnomenclaturalcode = null;
            $reg->setIsNewRecord(true);
            $reg->insert();
            return $reg;
        }
    }
    public function getIdScientificNameAuthorship($i,$sp) {
        $reg = scientificnameauthorship::model()->find('UPPER(scientificnameauthorship)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colscientificnameauthorship+$sp]))));
        if(isset($reg)) {
            return $reg;
        }else {
            $reg = scientificnameauthorship::model();
            $reg->scientificnameauthorship = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colscientificnameauthorship+$sp]));
            $reg->idscientificnameauthorship = null;
            $reg->setIsNewRecord(true);
            $reg->insert();
            return $reg;
        }
    }
    public function getIdTaxonRank($i,$sp) {
        $reg = taxonranks::model()->find('UPPER(taxonrank)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->coltaxonrank+$sp]))));
        if(isset($reg)) {
            return $reg;
        }else {
            $reg = taxonranks::model();
            $reg->taxonrank = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->coltaxonrank+$sp]));
            $reg->idtaxonrank = null;
            $reg->setIsNewRecord(true);
            $reg->insert();
            return $reg;
        }
    }
    public function getIdInfraspecificEpithet($i,$sp) {
        $reg = infraspecificepithets::model()->find('UPPER(infraspecificepithet)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colinfraspecificepithet+$sp]))));
        if(isset($reg)) {
            return $reg;
        }else {
            $reg = infraspecificepithets::model();
            $reg->infraspecificepithet = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colinfraspecificepithet+$sp]));
            $reg->idinfraspecificepithet = null;
            $reg->setIsNewRecord(true);
            $reg->insert();
            return $reg;
        }
    }
    public function getIdSpecificEpithet($i,$sp) {
        $reg = specificepithets::model()->find('UPPER(specificepithet)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colspecificepithet+$sp]))));
        if(isset($reg)) {
            return $reg;
        }else {
            $reg = specificepithets::model();
            $reg->specificepithet = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colspecificepithet+$sp]));
            $reg->idspecificepithet = null;
            $reg->setIsNewRecord(true);
            $reg->insert();
            return $reg;
        }
    }
    public function getIdGenus($i,$sp) {
        $reg = genus::model()->find('UPPER(genus)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colgenus+$sp]))));
        if(isset($reg)) {
            return $reg;
        }else {
            $reg = genus::model();
            $reg->genus = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colgenus+$sp]));
            $reg->idgenus = null;
            $reg->setIsNewRecord(true);
            $reg->insert();
            return $reg;
        }
    }
    public function getIdFamily($i,$sp) {
        $reg = families::model()->find('UPPER(family)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colfamily+$sp]))));
        if(isset($reg)) {
            return $reg;
        }else {
            $reg = families::model();
            $reg->family = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colfamily+$sp]));
            $reg->idfamily = null;
            $reg->setIsNewRecord(true);
            $reg->insert();
            return $reg;
        }
    }
    public function getIdOrder($i,$sp) {
        $reg = orders::model()->find('UPPER("order")=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colorder+$sp]))));
        if(isset($reg)) {
            return $reg;
        }else {
            $reg = orders::model();
            $reg->order = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colorder+$sp]));
            $reg->idorder = null;
            $reg->setIsNewRecord(true);
            $reg->insert();
            return $reg;
        }
    }
    public function getIdClass($i,$sp) {
        $reg = classes::model()->find('UPPER(class)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colclass+$sp]))));
        if(isset($reg)) {
            return $reg;
        }else {
            $reg = classes::model();
            $reg->class = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colclass+$sp]));
            $reg->idclass = null;
            $reg->setIsNewRecord(true);
            $reg->insert();
            return $reg;
        }
    }
    public function getIdPhylum($i,$sp) {
        $reg = phylums::model()->find('UPPER(phylum)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colphylum+$sp]))));
        if(isset($reg)) {
            return $reg;
        }else {
            $reg = phylums::model();
            $reg->phylum = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colphylum+$sp]));
            $reg->idphylum = null;
            $reg->setIsNewRecord(true);
            $reg->insert();
            return $reg;
        }
    }
    public function getIdKingdom($i,$sp) {
        $reg = kingdoms::model()->find('UPPER(kingdom)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colkingdom+$sp]))));
        if(isset($reg)) {
            return $reg;
        }else {
            $reg = kingdoms::model();
            $reg->kingdom = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colkingdom+$sp]));
            $reg->idkingdom = null;
            $reg->setIsNewRecord(true);
            $reg->insert();
            return $reg;
        }
    }
    public function getIdScientificName($i,$sp) {
        $reg = scientificnames::model()->find('UPPER(scientificname)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colscientificname+$sp]))));
        if(isset($reg)) {
            return $reg;
        }else {
            $reg = scientificnames::model();
            $reg->scientificname = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colscientificname+$sp]));
            $reg->idscientificname = null;
            $reg->setIsNewRecord(true);
            $reg->insert();
            return $reg;
        }
    }
    public function setOccurrenceElements($id,$i,$sp) {
        $reg = occurrenceelements::model()->findByPk($id);
        $reg->setIsNewRecord(false);
        $reg->occurrenceremarks = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colremarks+$sp]));
        $reg->occurrencedetails = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colrelatedinformation+$sp]));
        $reg->othercatalognumber = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colothercatalognumbers+$sp]));
        $reg->iddisposition = $this->getIdDisposition($i,$this->sp)->iddisposition;
        $reg->idestablishmentmeans = $this->getIdStablishmentMeans($i,$this->sp)->idestablishmentmeans;//Valid Distrib... flag
        $reg->idlifestage = $this->getIdLifeStage($i,$this->sp)->idlifestage;
        $reg->idsex = $this->getIdSex($i,$this->sp)->idsex;
        $reg->recordnumber = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colcollectornumber+$sp]));

        // Identified by Save
        $recby = recordedby::model()->find('UPPER(recordedby)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colcollector+$sp]))));
        if(isset ($recby)) {
            $recbyocc = recordedbyoccurrence::model()->find('idrecordedby=:rec AND idoccurrenceelements=:occ',array(':rec'=>($recby->idrecordedby),':occ'=>($reg->idoccurrenceelements)));

            if(!isset ($recbyocc)) {
                $recbyocc = recordedbyoccurrence::model();
                $recbyocc->idrecordedby = $recby->idrecordedby;
                $recbyocc->idoccurrenceelements = $reg->idoccurrenceelements;
                $recbyocc->setIsNewRecord(true);
                $recbyocc->save();
            }
        }else {
            $recby = recordedby::model();
            $recby->recordedby = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colcollector+$sp]));
            $recby->idrecordedby = null;
            $recby->setIsNewRecord(true);
            $recby->insert();
            $recbyocc = recordedbyoccurrence::model();
            $recbyocc->idrecordedby = $recby->idrecordedby;
            $recbyocc->idoccurrenceelements = $reg->idoccurrenceelements;
            $recbyocc->setIsNewRecord(true);
            $recbyocc->insert();
        }

        $reg->update();

        return $reg;

    }
    public function getIdSex($i,$sp) {
        $reg = sexes::model()->find('UPPER(sex)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colsex+$sp]))));
        if(isset($reg)) {
            return $reg;
        }else {
            $reg = sexes::model();
            $reg->sex = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colsex+$sp]));
            $reg->idsex = null;
            $reg->setIsNewRecord(true);
            $reg->insert();
            return $reg;
        }
    }
    public function getIdLifeStage($i,$sp) {
        $reg = lifestages::model()->find('UPPER(lifestage)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->collifestage+$sp]))));
        if(isset($reg)) {
            return $reg;
        }else {
            $reg = lifestages::model();
            $reg->lifestage = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->collifestage+$sp]));
            $reg->idlifestage = null;
            $reg->setIsNewRecord(true);
            $reg->save();
            return $reg;
        }
    }
    public function getIdStablishmentMeans($i,$sp) {
        $reg = establishmentmeans::model()->find('UPPER(establishmentmeans)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colvaliddistributionflag+$sp]))));
        if(isset($reg)) {
            return $reg;
        }else {
            $reg = establishmentmeans::model();
            $reg->establishmentmeans = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colvaliddistributionflag+$sp]));
            $reg->idestablishmentmeans = null;
            $reg->setIsNewRecord(true);
            $reg->save();
            return $reg;
        }
    }
    public function getIdDisposition($i,$sp) {
        $reg = disposition::model()->find('UPPER(disposition)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->coldisposition+$sp]))));
        if(isset($reg)) {
            return $reg;
        }else {
            $reg = disposition::model();
            $reg->disposition = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->coldisposition+$sp]));
            $reg->iddisposition = null;
            $reg->setIsNewRecord(true);
            $reg->save();
            return $reg;
        }
    }
    public function existeInteracao($idsp1, $idsp2, $idt) {
        $reg = interactionelements::model()->find('idspecimens1=:s1 AND idspecimens2=:s2 AND idinteractiontype=:t',array(':s1'=>$idsp1,':s2'=>$idsp2,':t'=>$idt));
        return $reg;

    }
    public function existeRegistro($gui) {
        $reg = recordlevelelements::model()->find('UPPER(globaluniqueidentifier)=UPPER(:gui)',array(':gui'=>$gui));
        return $reg;

    }
    public function getIdCollectionCode($i,$sp) {
        $reg = collectioncodes::model()->find('UPPER(collectioncode)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colcollectioncode+$sp]))));
        if(isset($reg)) {
            return $reg;
        }else {
            $reg = collectioncodes::model();
            $reg->collectioncode = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colcollectioncode+$sp]));
            $reg->idcollectioncode = null;
            $reg->setIsNewRecord(true);
            $reg->insert();
            return $reg;
        }
    }
    public function getIdInstitutionCode($i,$sp) {
        $reg = institutioncodes::model()->find('UPPER(institutioncode)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colinstitutioncode+$sp]))));
        if(isset($reg)) {
            return $reg;
        }else {
            $reg = institutioncodes::model();
            $reg->institutioncode = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colinstitutioncode+$sp]));
            $reg->idinstitutioncode = null;
            $reg->setIsNewRecord(true);
            $reg->insert();
            return $reg;
        }
    }
    public function getIdBasisOfRecord($i,$sp) {
        $reg = basisofrecords::model()->find('UPPER(basisofrecord)=UPPER(:reg)',array(':reg'=>CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colbasisofrecord+$sp]))));
        if(isset($reg)) {
            return $reg;
        }else {
            $reg = basisofrecords::model();
            $reg->basisofrecord = CHtml::encode(trim($this->reader->sheets[0]["cells"][$i][$this->colbasisofrecord+$sp]));
            $reg->idbasisofrecord = null;
            $reg->setIsNewRecord(true);
            $reg->insert();
            return $reg;
        }
    }

    public function validarSp($i,$sp) {
        if(     trim($this->reader->sheets[0]["cells"][$i][$this->colbasisofrecord+$sp])==''||
                trim($this->reader->sheets[0]["cells"][$i][$this->colinstitutioncode+$sp])==''||
                trim($this->reader->sheets[0]["cells"][$i][$this->colcollectioncode+$sp])==''||
                trim($this->reader->sheets[0]["cells"][$i][$this->colcatalognumber+$sp])==''||
                trim($this->reader->sheets[0]["cells"][$i][$this->colscientificname+$sp])=='') {
            /*echo trim($this->reader->sheets[0]["cells"][$i][1]).'1'.
                trim($this->reader->sheets[0]["cells"][$i][2]).'2'.
                trim($this->reader->sheets[0]["cells"][$i][3]).'3'.
                trim($this->reader->sheets[0]["cells"][$i][4]).'4'.
                trim($this->reader->sheets[0]["cells"][$i][5]).'5'.
                trim($this->reader->sheets[0]["cells"][$i][6]).'6'.
                trim($this->reader->sheets[0]["cells"][$i][7]).'7'.
                trim($this->reader->sheets[0]["cells"][$i][8]).'8'.
                trim($this->reader->sheets[0]["cells"][$i][8]).'9';*/
            return '<b>Erro na linha</b>: '.$i.' - '.($sp==0?'Espécie 1':'Espécie 2').'. Todos os campos obrigatórios devem ser preenchidos. ';
        }
        else {
            return 'ok';
        }
    }
    public function validarInteraction($i) {
        if(     trim($this->reader->sheets[0]["cells"][$i][$this->colinteractiontype])==''||
                trim($this->reader->sheets[0]["cells"][$i][$this->colinteractionrelatedinformation])=='') {
            return '<b>Erro na linha</b>: '.$i.' - Interação. Todos os campos obrigatórios devem ser preenchidos. ';
        }
        else {
            if(!$this->validarSP($i,$this->sp1) || !$this->validarSP($i,$this->sp1))
                return '<b>Erro na linha</b>: '.$i.' - Espécie 1 e Espécie 2 devem ser válidas.';
        }
        return 'ok';
    }
    public function isSpVazio($i,$sp) {

        return     trim($this->reader->sheets[0]["cells"][$i][$this->colbasisofrecord+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->colinstitutioncode+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->colcollectioncode+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->colcatalognumber+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->colrelatedinformation+$sp])==''&&
                        trim($this->reader->sheets[0]["cells"][$i][$this->colscientificname+$sp])==''?true:false;
    }

    public function isInteractionVazio($i) {
        if(
        trim($this->reader->sheets[0]["cells"][$i][$this->colinteractiontype])==''&&
                trim($this->reader->sheets[0]["cells"][$i][$this->colinteractionrelatedinformation])=='') {
            return true;
        }
        else {

        }
        return false;
    }
}
new importarExcel();
?>





