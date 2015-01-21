<?php include_once("protected/extensions/config.php"); ?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="js/validation/jquery.numeric.pack.js"></script>
<script type="text/javascript" src="js/jquery.jstepper.js"></script>
<script type="text/javascript" src="js/loadfields.js"></script>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/List.js"></script>
<script type="text/javascript" src="js/Maintain.js"></script>
<link rel="stylesheet" href="http://www.emposha.com/demo/fcbkcomplete_2/style.css" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" src="js/jquery.fcbkcomplete.js"></script>

<style type="text/css">
	td.tablelabelcel {
		width: 130px;
	}
</style>

<script type="text/javascript">
    // Arrays para armazenar listas de NxN
    // Nome padrao: controllerList
    var creatorList = new Array();
    var contributorList = new Array();
    var relatedNameList = new Array();
    var synonymList = new Array();

    //Tooltip for NxN fields
    var helpTip = '<div style="font-weight:normal;"><b>ENTRY LIST</b><br />In this field, you can create a list of entries.</div>';

    $(document).ready(bootSpecies);
    function bootSpecies() {
        //Configs
        configEditButton();
        configAccordion();
        configHideShowButtons();
        configPrintButton();
    }
    
    // Configuracoes iniciais
    function configEditButton() {
        $("#editBtn").button();
	    $("#editBtn").click(function(){
	        window.location = "index.php?r=species/goToMaintain&id="+$("#SpeciesAR_idspecies").val();
	    });
    
    }
        
    function configAccordion() {
        // Cria accordions apartir das divs
        $( "#informationAccordion").accordion({collapsible: true,autoHeight: false,navigation: true});
        $( "#taxonomicElementsAccordion").accordion({collapsible: true,autoHeight: false,navigation: true});
        $( "#speciesMediaAccordion" ).accordion({collapsible: true,autoHeight: false,navigation: true});
        $( "#speciesReferenceAccordion" ).accordion({collapsible: true,autoHeight: false,navigation: true});
        $( "#speciesPublicationReferenceAccordion" ).accordion({collapsible: true,autoHeight: false,navigation: true});
        $( "#speciesPaperAccordion" ).accordion({collapsible: true,autoHeight: false,navigation: true});
        $( "#speciesIdentificationKeyAccordion" ).accordion({collapsible: true,autoHeight: false,navigation: true});

        // Fecha todas
        $( "#informationAccordion").accordion("activate" ,false);
        $( "#taxonomicElementsAccordion").accordion("activate" ,false);
        $( "#speciesMediaAccordion" ).accordion("activate" ,false);
        $( "#speciesReferenceAccordion" ).accordion("activate" ,false);
        $( "#speciesPublicationReferenceAccordion" ).accordion("activate" ,false);
        $( "#speciesPaperAccordion" ).accordion("activate" ,false);
        $( "#speciesIdentificationKeyAccordion" ).accordion("activate" ,false);
    }
    
    function configHideShowButtons() {
    	$("#hideBtn").button();
    	$("#showBtn").button();    
    		
        $("#hideBtn").click(function(){
            $("td.tablefieldcel:empty").parent().hide();
            $("#hideBtn").parent().hide();
            $("#showBtn").parent().show();
            $("#showBtn").attr("checked", true);
            $("#hideBtn").attr("checked", true);
        });
        
        $("#showBtn").click(function(){
            $("td.tablefieldcel:empty").parent().show();
            $("#hideBtn").parent().show();
            $("#showBtn").parent().hide();
            $("#showBtn").attr("checked", true);
            $("#hideBtn").attr("checked", true);
        });
        
        //empty fields starts hidden
        $("td.tablefieldcel:empty").parent().hide();
        $("#hideBtn").parent().hide();
        $("#showBtn").parent().show();
        $("#showBtn").attr("checked", true);
        $("#hideBtn").attr("checked", true);
    }
    
    function configPrintButton() {
    	$("#printButton").button();
	    $("#printButton").click(function() {
	    	var windowReference = window.open('index.php?r=loadingfile/goToShow');
		   //printPDF(<?php echo $spc->idspecies?>); 
		   $.ajax({ type:'GET',
                    url:'index.php?r=species/print',
                    data: {
                    	"id": $('#SpeciesAR_idspecies').val()
                    },
                    dataType: "json",
                    success:function(json) {
	                    windowReference.location = json;
                    }
           });
	    });
    }
    
    function printPDF(idspc) {
    	window.open("index.php?r=species/goToPrint&id="+idspc);
    }

</script>

<div id="Notification"></div>

<?php echo CHtml::beginForm('','post',array ('id'=>'form')); ?>
<?php echo CHtml::activeHiddenField($spc,'idspecies');?>
<?php echo CHtml::activeHiddenField($spc,'idtaxonomicelement');?>

<div class="introText">
    <h1><?php echo Yii::t('yii','View an existing species sheet'); ?></h1>
    <p><?php echo Yii::t('yii',"Use this tool to view a sheet of modern biological species' information. This set of fields is based on international standards, such as Plinian Core."); ?></p>
</div>

<div class="yiiForm" style="width:85%">
    <div class="attention">
        <?php echo CHtml::image('images/main/attention.png','',array('border'=>'0px'))."&nbsp;".Yii::t('yii', "Main Fields");?>
        (<span style="color: red; font-weight: bold;"><?php echo Yii::t('yii',"Fields with * are required"); ?></span>)
    </div>
    
    <table cellspacing="0" cellpadding="0" align="center" class="tablerequired" style="margin-bottom:12px; padding-left: 175px;">
        <div class="tablerow" id='divinstitutioncode'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabelEx($spc->institutioncode,'institutioncode');?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=institutioncode',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel"><?php echo $spc->institutioncode->institutioncode;?></td>
                <td class="acIcon">
                </td>
            </tr>
        </div>
        <div class="tablerow" id='divscientificname'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel($spc->taxonomicelement->scientificname,'scientificname');?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=scientificname',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel"><?php echo $spc->taxonomicelement->scientificname->scientificname;?></td>
                <td class="acIcon">
                </td>
            </tr>
        </div>
    </table>
    
    <div id="showHideBtn" class="saveButton" style="clear:both;">
    	<div style="margin-right:40%;"><input type="checkbox" id="showBtn" /><label for="showBtn">Show empty fields</label></div>
    	<div style="margin-right:40%;"><input type="checkbox" id="hideBtn" /><label for="hideBtn">Hide empty fields</label></div>
    </div>

    <!-- ACCORDIONS  -->
    <div id="informationAccordion">
        <h3><a href="#">Species Information</a></h3>
        <div>
            <table cellspacing="0" cellpadding="0" align="center" class="normalFieldsTable" style="background-color: transparent;">
                <div class="tablerow" id='divlanguage'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel(LanguageAR::model(), 'language'); ?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=language',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->language->language; ?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divcreator'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel(CreatorAR::model(),'creator');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=creator',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php
                                $creator = "";
                                foreach ($spc->creator as $value) {
                                    $creator .= $value->creator . "; ";
                                }
                                $creator = substr($creator, 0, -2);
                                echo $creator;
                            ?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divcontributor'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel(ContributorAR::model(),'contributor');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=contributor',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php
                                $contributor = "";
                                foreach ($spc->contributor as $value) {
                                    $contributor .= $value->contributor . "; ";
                                }
                                $contributor = substr($contributor, 0, -2);
                                echo $contributor;
                            ?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divrelatedname'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel(RelatedNameAR::model(),'relatedname');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=relatedname',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php
                                $relatedname = "";
                                foreach ($spc->relatedname as $value) {
                                    $relatedname .= $value->relatedname . "; ";
                                }
                                $relatedname = substr($relatedname, 0, -2);
                                echo $relatedname;
                            ?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divsynonym'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel(SynonymAR::model(),'synonym');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=synonym',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php
                                $synonym = "";
                                foreach ($spc->synonym as $value) {
                                    $synonym .= $value->synonym . "; ";
                                }
                                $synonym = substr($synonym, 0, -2);
                                echo $synonym;
                            ?></td>
                    </tr>
                </div>

                <div class="tablerow" id='divabstract'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'abstract');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=abstract',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->abstract;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divannualcycle'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'annualcycle');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=annual',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->annualcycle;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divauthoryearofscientificname'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'authoryearsofscientificname');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=authoryearofscientificname',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->authoryearofscientificname;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divbehavior'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'behavior');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=behavior',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->behavior;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divbenefits'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'benefits');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=benefits',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->benefits;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divbriefdescription'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'briefdescription');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=briefdescription',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->briefdescription;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divchromosomicnumber'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'chromosomicnumber');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=chromosomicnumber',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->chromosomicnumber;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divcomprehensivedescription'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'comprehensivedescription');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=comprehensivedescription',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->comprehensivedescription;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divconservationstatus'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'conservationstatus');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=conservationstatus',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->conservationstatus;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divdatecreated'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'datecreated');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=datecreated',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->datecreated;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divdatelastmodified'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'datelastmodified');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=datelastmodified',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->datelastmodified;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divdistribution'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'distribution');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=distribution',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->distribution;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divecologicalsignificance'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'ecologicalsignificance');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=ecologicalsignificance',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->ecologicalsignificance;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divendemicity'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'endemicity');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=endemicity',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->endemicity;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divfeeding'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'feeding');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=feeding',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->feeding;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divfolklore'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'folklore');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=folklore',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->folklore;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divlsid'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'lsid');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=lsid',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->lsid;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divhabit'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'habit');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=habit',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->habit;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divhabitat'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'habitat');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=habitat',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->habitat;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divinteractions'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'interactions');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=interactions',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->interactions;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divinvasivenessdata'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'invasivenessdata');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=invasivenessdata',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->invasivenessdata;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divlegislation'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'legislation');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=legislation',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->legislation;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divlifecycle'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'lifecycle');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=lifecycle',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->lifecycle;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divlifeexpectancy'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'lifeexpectancy');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=lifeexpectancy',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->lifeexpectancy;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divmanagement'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'management');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=management',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->management;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divmigratorydata'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'migratorydata');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=migratorydata',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->migratorydata;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divmoleculardata'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'moleculardata');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=moleculardata',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->moleculardata;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divmorphology'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'morphology');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=morphology',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->morphology;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divoccurrence'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'occurrence');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=occurrence',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->occurrence;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divotherinformationsources'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'otherinformationsources');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=otherinformationsources',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->otherinformationsources;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divpopulationbiology'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'populationbiology');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=populationbiology',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->populationbiology;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divreproduction'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'reproduction');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=reproduction',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->reproduction;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divscientificdescription'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'scientificdescription');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=scientificdescription',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->scientificdescription;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divsize'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'size');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=size',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->size;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divtargetaudiences'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'targetaudiences');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=targetaudiences',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->targetaudiences;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divterritory'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'territory');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=territory',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->territory;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divthreatstatus'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'threatstatus');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=threatstatus',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->threatstatus;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divtypification'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'typification');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=typification',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->typification;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divunstructureddocumentation'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'unstructureddocumentation');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=unstructureddocumentation',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->unstructureddocumentation;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divunstructurednaturalhistory'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'unstructurednaturalhistory');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=unstructurednaturalhistory',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->unstructurednaturalhistory;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divuses'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'uses');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=uses',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->uses;?></td>
                    </tr>
                </div>
                <div class="tablerow" id='divversion'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'version');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=version',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel"><?php echo $spc->version;?></td>
                    </tr>
                </div>
            </table>
        </div>
    </div>
    <div id="taxonomicElementsAccordion">
        <h3><a href="#">Taxonomic Elements</a></h3>
        <div>
            <?php
            echo Yii::app()->controller->renderPartial('/speciestaxonomic/show', array(
            'taxonomicElement'=>$spc->taxonomicelement,
            ));
            ?>
        </div>
    </div>
    <div id="speciesMediaAccordion">
        <h3><a href="#">Related Media Records</a></h3>
        <div>
            <?php
            echo Yii::app()->controller->renderPartial('/speciesmedia/show', array(
            'speciesMedia'=>$spc,
            ));
            ?>
        </div>
    </div>
    <div id="speciesReferenceAccordion">
        <h3><a href="#">Related Reference Records</a></h3>
        <div>
            <?php
            echo Yii::app()->controller->renderPartial('/speciesreference/show', array(
            'speciesRef'=>$spc,
            ));
            ?>
        </div>
    </div>
    <div id="speciesPaperAccordion">
        <h3><a href="#">Related Papers</a></h3>
        <div>
            <?php
            echo Yii::app()->controller->renderPartial('/speciespaper/show', array(
            'speciesPaper'=>$spc,
            ));
            ?>
        </div>
    </div>
    <div id="speciesPublicationReferenceAccordion">
        <h3><a href="#">Related Publication References</a></h3>
        <div>
            <?php
            echo Yii::app()->controller->renderPartial('/speciespublicationreference/show', array(
            'speciesPub'=>$spc,
            ));
            ?>
        </div>
    </div>
    <div id="speciesIdentificationKeyAccordion">
        <h3><a href="#">Related Identification Keys</a></h3>
        <div>
            <?php
            echo Yii::app()->controller->renderPartial('/speciesidkey/show', array(
            'speciesKey'=>$spc,
            ));
            ?>
        </div>
    </div>
    <div class="saveButton">
    	<input type="checkbox" id="printButton" /><label for="printButton">Print</label>
        <input type="checkbox" id="editBtn" /><label for="editBtn">Edit</label>
    </div>
</div>

<?php echo CHtml::endForm(); ?>
