<?php include_once("protected/extensions/config.php"); ?>
<script type="text/javascript" src="js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="js/upload.js"></script>
<script type="text/javascript" src="js/jquery.jstepper.js"></script>
<script type="text/javascript" src="js/upload.js"></script>
<script type="text/javascript" src="js/validation/jquery.numeric.pack.js"></script>
<script type="text/javascript" src="js/Maintain.js"></script>
<link rel="stylesheet" href="http://www.emposha.com/demo/fcbkcomplete_2/style.css" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" src="js/jquery.fcbkcomplete.js"></script>
<link href="js/valums/client/fileuploader.css" rel="stylesheet" type="text/css">
<script src="js/valums/client/fileuploader.js" type="text/javascript"></script>

<style type="text/css">
    #slider {
        margin: 10px;
    }
</style>
<script>
    //var creatorList = new Array();
    
    $(document).ready(bootReference);
    
    function bootReference(){
        //Configs
        configInitial();
        configNotify();
        configIcons();
        configUploadShow('#ReferenceAR_idfile'); 
        configHideShowButtons();   
        configPrintButton();    
	}

	// Configuracoes iniciais
    function configInitial() {
        $("#editBtn").button();

        // Evento onclick do botao edit
        $("#editBtn").click(function(){
             window.location = "index.php?r=reference/goToMaintain&id="+$("#ReferenceAR_idreferenceelement").val();
         });
    }
     function configHideShowButtons() {
    	$("#hideBtn").button();
    	$("#showBtn").button();    
    		
        $("#hideBtn").click(function(){
            $("td.tablefieldcel:empty").parent().hide();
            $("div.accordionRight:empty").parent().hide();
            $("#hideBtn").parent().hide();
            $("#showBtn").parent().show();
            $("#showBtn").attr("checked", true);
            $("#hideBtn").attr("checked", true);
            hideEmptyBlocks();
        });
        
        $("#showBtn").click(function(){
            $("td.tablefieldcel:empty").parent().show();
            $("div.accordionRight:empty").parent().show();
            $("#hideBtn").parent().show();
            $("#showBtn").parent().hide();
            $("#showBtn").attr("checked", true);
            $("#hideBtn").attr("checked", true);
            showEmptyBlocks();
        });
        
        //empty fields starts hidden
        $("td.tablefieldcel:empty").parent().hide();
        $("div.accordionRight:empty").parent().hide();
        $("#hideBtn").parent().hide();
        $("#showBtn").parent().show();
        $("#showBtn").attr("checked", true);
        $("#hideBtn").attr("checked", true);
        hideEmptyBlocks();
    }
    
    function hideEmptyBlocks() {
        if($.trim($(".normalFieldsTable > tbody > tr > td.tablefieldcel:parent").html())=='') {
            $(".normalFields").hide();
        }
    }
    
    function showEmptyBlocks() {
	    $(".normalFields").show();    
    }
    
    function configPrintButton() {
    	$("#printButton").button();
	    $("#printButton").click(function() {
	    	var windowReference = window.open('index.php?r=loadingfile/goToShow');
		   //printPDF(<?php echo $reference->idreferenceelement?>); 
		   $.ajax({ type:'GET',
                    url:'index.php?r=reference/print',
                    data: {
                    	"id": $("#ReferenceAR_idreferenceelement").val()
                    },
                    dataType: "json",
                    success:function(json) {
	                    windowReference.location = json;
                    }
           });
	    });
    }
    
    function printPDF(idreference) {
    	window.open("index.php?r=reference/goToPrint&id="+idreference);
    }

</script>

<div id="Notification"></div>

<?php echo CHtml::beginForm('', 'post', array('id' => 'form')); ?>
<?php echo CHtml::activeHiddenField($reference, 'idreferenceelement'); ?>
<?php echo CHtml::activeHiddenField($reference, 'idfile'); ?>

<!-- TEXTO INTRODUTORIO -->

<div class="introText">
    <h1><?php echo Yii::t('yii', 'View an existing specimen reference record'); ?></h1>
    <p><?php echo Yii::t('yii', "Use this tool to view records of references to modern biological specimens and information such as authorship, copyright and content data. This set of fields is based on international standards, such as Darwin Core, Dublin Core and their extensions."); ?></p>
</div>

<div class="yiiForm">
    <div class="attention">
<?php echo CHtml::image('images/main/attention.png', '', array('border' => '0px')) . "&nbsp;&nbsp;" . Yii::t('yii', "Main Fields"); ?>
        (<span style="color: red; font-weight: bold;"><?php echo Yii::t('yii', "Fields with * are required"); ?></span>)
    </div>
    
    <table cellspacing="0" cellpadding="0" align="center" class="tablerequired" style="margin-bottom:12px;">
        <!--***** SUBTYPE field ******-->
        <div class="tablerow" id='divsubtypereference'>
            <tr>
                <td class="tablelabelcel">
<?php echo CHtml::activeLabel(SubtypeReferenceAR::model(), 'subtypereference'); ?>
                    <span class="required">*</span>
                </td>
                <td class="tablemiddlecel">
<?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=subtypereference', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel"><?php echo $reference->subtypereference->subtypereference; ?></td>
                <td class="acIcon"></td>
            </tr>
        </div>
        <!--***** TITLE ******-->
        <div class="tablerow" id='divtitle'>
            <tr>
                <td class="tablelabelcel">
<?php echo CHtml::activeLabel($reference, "title"); ?>
                    <span class="required">*</span>
                </td>
                <td class="tablemiddlecel">
<?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=title', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel"><?php echo $reference->title; ?></td>
                <td class="acIcon"></td>
            </tr>
        </div>
        <!--***** KEYWORD ******-->
            <div class="tablerow" id='divkeyword'>
                <tr>
                    <td class="tablelabelcel">
<?php echo CHtml::activeLabel(KeywordAR::model(), 'keyword'); ?>
                    </td>
                    <td class="tablemiddlecel">
<?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=keyword', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php
                                $keyword = "";
                                foreach ($reference->keyword as $value) {
                                    $keyword .= $value->keyword . "; ";
                                }
                                $keyword = substr($keyword, 0, -2);
                                echo $keyword;
                            ?></td>
                    <td class="acIcon"></td>
                </tr>
            </div>
        <!--***** AUTHORS ******-->
            <div class="tablerow" id='divcreator'>
                <tr>
                    <td class="tablelabelcel">
<?php echo CHtml::activeLabel(CreatorAR::model(), 'creator'); ?>
                    </td>
                    <td class="tablemiddlecel">
<?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=creator', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php
                                $creator = "";
                                foreach ($reference->creator as $value) {
                                    $creator .= $value->creator . "; ";
                                }
                                $creator = substr($creator, 0, -2) ;
                                echo $creator;
                            ?></td>
                    <td class="acIcon">
                    </td>
                </tr>
            </div>
            <!--***** PUBLICATION YEAR ******-->
        <div class="tablerow" id='divpublicationyear'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($reference, 'publicationyear');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=publicationyear',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $reference->publicationyear; ?></td>
            <td class="acIcon"></td>
        </tr>
        </div>
            <!--***** SOURCE ******-->
            <div class="tablerow" id='divsource'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel(SourceAR::model(), 'source'); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=source', array('rel' => 'lightbox')); ?>
            </td>
            <td class="tablefieldcel"><?php echo $reference->source->source; ?></td>
            <td class="acIcon"></td>
        </tr>
    </div>


    </table>
    
    <div id="showHideBtn" class="saveButton" style="clear:both;">
    	<div style="margin-right:40%;"><input type="checkbox" id="showBtn" /><label for="showBtn">Show empty fields</label></div>
    	<div style="margin-right:40%;"><input type="checkbox" id="hideBtn" /><label for="hideBtn">Hide empty fields</label></div>
    </div>
	
	<!--***** NORMAL FIELDS ******-->
   	<!--***** LANGUAGE ******-->
    <div class="normalFields">
        <table cellspacing="0" cellpadding="0" align="center" class="normalFieldsTable">
            <div class="tablerow" id='divlanguage'>
                <tr>
                    <td class="tablelabelcel">
<?php echo CHtml::activeLabel(LanguageAR::model(), 'language'); ?>
                    </td>
                    <td class="tablemiddlecel">
<?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=language', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php echo $reference->language->language; ?></td>
                    <td class="acIcon">
                    </td>
                </tr>
            </div>
            <!--***** AFILIATION ******-->
            <div class="tablerow" id='divafiliation'>
                <tr>
                    <td class="tablelabelcel">
<?php echo CHtml::activeLabel(AfiliationAR::model(), 'afiliation'); ?>
                    </td>
                    <td class="tablemiddlecel">
<?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=afiliation', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php
                                $afiliation = "";
                                foreach ($reference->afiliation as $value) {
                                    $afiliation .= $value->afiliation . "; ";
                                }
                                $afiliation = substr($afiliation, 0, -2);
                                echo $afiliation;
                            ?><td class="acIcon"></td>
                </tr>
            <!--***** PUBLISHER ******-->
            <div class="tablerow" id='divpublisher'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel(PublisherAR::model(), 'publisher'); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=publisher', array('rel' => 'lightbox')); ?>
            </td>
            <td class="tablefieldcel"><?php echo $reference->publisher->publisher; ?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
             <!--***** BIOME ******-->
            <div class="tablerow" id='divbiome'>
                <tr>
                    <td class="tablelabelcel">
<?php echo CHtml::activeLabel(BiomeAR::model(), 'biome')."s"; ?>
                    </td>
                    <td class="tablemiddlecel">
<?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=biome', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php
                                $biome = "";
                                foreach ($reference->biome as $value) {
                                    $biome .= $value->biome . "; ";
                                }
                                $biome = substr($biome, 0, -2);
                                echo $biome;
                            ?></td>
                    <td class="acIcon"></td>
                </tr>
            </div>
         <!--***** PLANT SPECIES ******-->
            <div class="tablerow" id='divplantspecies'>
                <tr>
                    <td class="tablelabelcel">
<?php echo CHtml::activeLabel(PlantSpeciesAR::model(), 'plantspecies'); ?>
                    </td>
                    <td class="tablemiddlecel">
<?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=plantspecies', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php
                                $plantspecies = "";
                                foreach ($reference->plantspecies as $value) {
                                    $plantspecies .= $value->plantspecies . "; ";
                                }
                                $plantspecies = substr($plantspecies, 0, -2);
                                echo $plantspecies;
                            ?></td>   
                    <td class="acIcon"></td>
                </tr>
            </div>
          <!--***** PLANT FAMILY ******-->
            <div class="tablerow" id='divplantfamily'>
                <tr>
                    <td class="tablelabelcel">
<?php echo CHtml::activeLabel(PlantFamilyAR::model(), 'plantfamily'); ?>
                    </td>
                    <td class="tablemiddlecel">
<?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=plantfamily', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php
                                $plantfamily = "";
                                foreach ($reference->plantfamily as $value) {
                                    $plantfamily .= $value->plantfamily . "; ";
                                }
                                $plantfamily = substr($plantfamily, 0, -2);
                                echo $plantfamily;
                            ?></td>   
                    <td class="acIcon"></td>
                </tr>
            </div>
          <!--***** PLANT COMMON NAME ******-->
            <div class="tablerow" id='divplantcommonname'>
                <tr>
                    <td class="tablelabelcel">
<?php echo CHtml::activeLabel(PlantCommonNameAR::model(), 'plantcommonname'); ?>
                    </td>
                    <td class="tablemiddlecel">
<?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=plantcommonname', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php
                                $plantcommonname = "";
                                foreach ($reference->plantcommonname as $value) {
                                    $plantcommonname .= $value->plantcommonname . "; ";
                                }
                                $plantcommonname = substr($plantcommonname, 0, -2);
                                echo $plantcommonname;
                            ?></td>   
                    <td class="acIcon"></td>
                </tr>
            </div>
          <!--***** POLLINATOR SPECIES ******-->
            <div class="tablerow" id='divpollinatorspecies'>
                <tr>
                    <td class="tablelabelcel">
<?php echo CHtml::activeLabel(PollinatorSpeciesAR::model(), 'pollinatorspecies'); ?>
                    </td>
                    <td class="tablemiddlecel">
<?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=pollinatorspecies', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php
                                $pollinatorspecies = "";
                                foreach ($reference->pollinatorspecies as $value) {
                                    $pollinatorspecies .= $value->pollinatorspecies . "; ";
                                }
                                $pollinatorspecies = substr($pollinatorspecies, 0, -2);
                                echo $pollinatorspecies;
                            ?></td>   
                    <td class="acIcon"></td>
                </tr>
            </div>
          <!--***** POLLINATOR FAMILY ******-->
            <div class="tablerow" id='divpollinatorfamily'>
                <tr>
                    <td class="tablelabelcel">
<?php echo CHtml::activeLabel(PollinatorFamilyAR::model(), 'pollinatorfamily'); ?>
                    </td>
                    <td class="tablemiddlecel">
<?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=pollinatorfamily', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php
                                $pollinatorfamily = "";
                                foreach ($reference->pollinatorfamily as $value) {
                                    $pollinatorfamily .= $value->pollinatorfamily . "; ";
                                }
                                $pollinatorfamily = substr($pollinatorfamily, 0, -2);
                                echo $pollinatorfamily;
                            ?></td>   
                    <td class="acIcon"></td>
                </tr>
            </div>
          <!--***** POLLINATOR COMMON NAME ******-->
            <div class="tablerow" id='divpollinatorcommonname'>
                <tr>
                    <td class="tablelabelcel">
<?php echo CHtml::activeLabel(PollinatorCommonNameAR::model(), 'pollinatorcommonname'); ?>
                    </td>
                    <td class="tablemiddlecel">
<?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=pollinatorcommonname', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php
                                $pollinatorcommonname = "";
                                foreach ($reference->pollinatorcommonname as $value) {
                                    $pollinatorcommonname .= $value->pollinatorcommonname . "; ";
                                }
                                $pollinatorcommonname = substr($pollinatorcommonname, 0, -2);
                                echo $pollinatorcommonname;
                            ?></td>   
                    <td class="acIcon"></td>
                </tr>
            </div>
            <!--***** DATE DIGITIZED ******-->
            <div class="tablerow" id='divdatedigitized'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($reference, 'datedigitized');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=datedigitized',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $reference->datedigitized; ?></td>
            <td><span style="font-size: 10px;"> YYYY/MM/DD</span></td>
        </tr>
        </div>
        <!--***** SUBJECT ******-->
        <div class="tablerow" id='divsubject'>
            <tr>
                <td class="tablelabelcel">
<?php echo CHtml::activeLabel($reference, 'subject'); ?>
                </td>
                <td class="tablemiddlecel">
<?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=subject', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel"><?php echo $reference->subject; ?></td>
                <td class="acIcon"></td>
            </tr>
        </div>
                <!--***** ABSTRACT ******-->
            <div class="tablerow" id='divabstract'>
                <tr>
                    <td class="tablelabelcel">
<?php echo CHtml::activeLabel($reference, 'abstract'); ?>
                    </td>
                    <td class="tablemiddlecel">
<?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=abstract', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php echo $reference->abstract; ?></td>
                    <td class="acIcon"></td>
                </tr>
            </div>
            <!--***** OBSERVATION ******-->
            <div class="tablerow" id='divobservation'>
                <tr>
                    <td class="tablelabelcel">
<?php echo CHtml::activeLabel($reference, 'observation'); ?>
                    </td>
                    <td class="tablemiddlecel">
<?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=observation', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php echo $reference->observation; ?></td>
                    <td class="acIcon">
                    </td>
                </tr>
            </div>
            <!--***** ISBNISSN ******-->
            <div class="tablerow" id='divisbnissn'>
                <tr>
                    <td class="tablelabelcel">
<?php echo CHtml::activeLabel($reference, 'isbnissn'); ?>
                    </td>
                    <td class="tablemiddlecel">
<?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=isbnissn', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php echo $reference->isbnissn; ?></td>
                    <td class="acIcon"></td>
                </tr>
            </div>
           <!--***** URL ******-->
            <div class="tablerow" id='divurl'>
                <tr>
                    <td class="tablelabelcel">
<?php echo CHtml::activeLabel($reference, 'url'); ?>
                    </td>
                    <td class="tablemiddlecel">
<?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=url', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php echo $reference->url; ?></td>
                    <td class="acIcon"></td>
                </tr>
            </div>
            <!--***** DOI ******-->
            <div class="tablerow" id='divdoi'>
                <tr>
                    <td class="tablelabelcel">
<?php echo CHtml::activeLabel($reference, 'doi'); ?>
                    </td>
                    <td class="tablemiddlecel">
<?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=doi', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php echo $reference->doi; ?></td>
                    <td class="acIcon"></td>
                </tr>
            </div>
            <!--***** BIBLIOGRAPHIC CITATION ******-->
            <div class="tablerow" id='divbibliographiccitation'>
                <tr>
                    <td class="tablelabelcel">
<?php echo CHtml::activeLabel($reference, 'bibliographiccitation'); ?>
                    </td>
                    <td class="tablemiddlecel">
<?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=bibliographiccitation', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php echo $reference->bibliographiccitation; ?></td>
                    <td class="acIcon"></td>
                </tr>
            </div>
            <!--***** FILE FORMAT ******-->
            <div class="tablerow" id='divfileformat'>
                <tr>
                    <td class="tablelabelcel">
<?php echo CHtml::activeLabel(FileFormatAR::model(), 'fileformat'); ?>
                    </td>
                    <td class="tablemiddlecel">
<?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=fileformat', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php echo $reference->fileformat->fileformat; ?></td>
                    <td class="acIcon">
                    </td>
                </tr>
            </div>
        </table>
    </div>
	<div class="privateRecord" id="file">		
		<noscript>			
			<p>Please enable JavaScript to use file uploader.</p>
		</noscript>
		<p id="noFile" display="none">There is no uploaded file.<p>         
	</div>	
	<div class="privateRecord" id="fileStatus"></div>	

    <div class="privateRecord">
        <div class="title"><?php echo $reference->isrestricted ? "This is a private record." : "This is not a private record." ; ?></div>
        <div class="icon"><?php if ($reference->isrestricted) showIcon("Private Record", "ui-icon-locked", 0); else showIcon("Not Private Record", "ui-icon-unlocked", 0) ; ?></div>
    </div>

    <div class="saveButton">
	    <input type="checkbox" id="printButton" /><label for="printButton">Print</label>
        <input type="checkbox" id="editBtn" /><label for="editBtn">Edit</label>
    </div>
</div>

<?php echo CHtml::endForm(); 

?>
