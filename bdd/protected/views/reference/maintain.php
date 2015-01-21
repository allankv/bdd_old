<?php include_once("protected/extensions/config.php"); ?>
<script type="text/javascript" src="js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="js/upload.js"></script>
<script type="text/javascript" src="js/jquery.jstepper.js"></script>
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
    .parseBibCitInputText {
	    width: inherit;
    }
</style>

<script>
    var creatorList = new Array();
    var keywordList = new Array();
    var biomeList = new Array();
    var plantspeciesList = new Array();
    var plantfamilyList = new Array();
    var plantcommonnameList = new Array();
    var pollinatorspeciesList = new Array();
    var pollinatorfamilyList = new Array();
    var pollinatorcommonnameList = new Array();
    var afiliationList = new Array();
    
    $(document).ready(bootReference);
    //Date and time formatter
    /*jQuery(function($){
        $("#ReferenceAR_date").mask("9999/99/99");
        $("#ReferenceAR_date").datepicker({ dateFormat: 'yy/mm/dd' });
        $("#ReferenceAR_available").mask("9999/99/99");
        $("#ReferenceAR_available").datepicker({ dateFormat: 'yy/mm/dd' });
    });*/
    
    jQuery(function($){
    	$("#ReferenceAR_datedigitized").mask("9999/99/99");
    	$("#ReferenceAR_datedigitized").datepicker({ dateFormat: 'yy/mm/dd' });
    	$("#ReferenceAR_publicationyear").mask("9999");
    	$("#parsePublicationYear").mask("9999");
	});

    function bootReference(){
    	configAutocompleteNN('#ReferenceAR_idreferenceelement', '#CreatorAR_creator', 'creator', 'Reference');
        configAutocompleteNN('#ReferenceAR_idreferenceelement', '#KeywordAR_keyword', 'keyword', 'Reference');
        configAutocompleteNN('#ReferenceAR_idreferenceelement', '#BiomeAR_biome', 'biome', 'Reference');
        configAutocompleteNN('#ReferenceAR_idreferenceelement', '#PlantSpeciesAR_plantspecies', 'plantspecies', 'Reference');
        configAutocompleteNN('#ReferenceAR_idreferenceelement', '#PlantFamilyAR_plantfamily', 'plantfamily', 'Reference');
        configAutocompleteNN('#ReferenceAR_idreferenceelement', '#PlantCommonNameAR_plantcommonname', 'plantcommonname', 'Reference');
        configAutocompleteNN('#ReferenceAR_idreferenceelement', '#PollinatorSpeciesAR_pollinatorspecies', 'pollinatorspecies', 'Reference');
        configAutocompleteNN('#ReferenceAR_idreferenceelement', '#PollinatorFamilyAR_pollinatorfamily', 'pollinatorfamily', 'Reference');
        configAutocompleteNN('#ReferenceAR_idreferenceelement', '#PollinatorCommonNameAR_pollinatorcommonname', 'pollinatorcommonname', 'Reference');
        configAutocompleteNN('#ReferenceAR_idreferenceelement', '#AfiliationAR_afiliation', 'afiliation', 'Reference');
        
        configAutocomplete('#ReferenceAR_idpublisher','#PublisherAR_publisher', 'publisher');
        configAutocomplete('#ReferenceAR_idsource','#SourceAR_source', 'source');

        //configAutocomplete('#ReferenceAR_idcategoryreference','#CategoryReferenceAR_categoryreference', 'categoryreference');
        //configAutocomplete('#ReferenceAR_idsubcategoryreference','#SubcategoryReferenceAR_subcategoryreference', 'subcategoryreference');
        //Autocomplete icons
        var btnAutocomplete ="<div class='btnAutocomplete' style='width:20px;'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-comment'></span></li></ul></div>";
       // $('#autocompleteCategory').append('<a href="javascript:suggest(\'#ReferenceAR_idcategoryreference\',\'#CategoryReferenceAR_categoryreference\', \'categoryreference\');">'+btnAutocomplete+'</a>');
       // $('#autocompleteSubcategory').append('<a href="javascript:suggest(\'#ReferenceAR_idsubcategoryreference\',\'#SubcategoryReferenceAR_subcategoryreference\', \'subcategoryreference\');">'+btnAutocomplete+'</a>');
        $('#autocompleteCreator').append('<a href="javascript:suggestNN(\'#CreatorAR_creator\', \'creator\', \'reference\');">'+btnAutocomplete+'</a>');
        $('#autocompleteKeyword').append('<a href="javascript:suggestNN(\'#KeywordAR_keyword\', \'keyword\', \'reference\');">'+btnAutocomplete+'</a>');
        $('#autocompleteBiome').append('<a href="javascript:suggestNN(\'#BiomeAR_biome\', \'biome\', \'reference\');">'+btnAutocomplete+'</a>');
        $('#autocompletePlantSpecies').append('<a href="javascript:suggestNN(\'#PlantSpeciesAR_plantspecies\', \'plantspecies\', \'reference\');">'+btnAutocomplete+'</a>');
        $('#autocompletePlantFamily').append('<a href="javascript:suggestNN(\'#PlantFamilyAR_plantfamily\', \'plantfamily\', \'reference\');">'+btnAutocomplete+'</a>');
        $('#autocompletePlantCommonName').append('<a href="javascript:suggestNN(\'#PlantCommonNameAR_plantcommonname\', \'plantcommonname\', \'reference\');">'+btnAutocomplete+'</a>'); 
        $('#autocompletePollinatorSpecies').append('<a href="javascript:suggestNN(\'#PollinatorSpeciesAR_pollinatorspecies\', \'pollinatorspecies\', \'reference\');">'+btnAutocomplete+'</a>');
        $('#autocompletePollinatorFamily').append('<a href="javascript:suggestNN(\'#PollinatorFamilyAR_pollinatorfamily\', \'pollinatorfamily\', \'reference\');">'+btnAutocomplete+'</a>');
        $('#autocompletePollinatorCommonName').append('<a href="javascript:suggestNN(\'#PollinatorCommonNameAR_pollinatorcommonname\', \'pollinatorcommonname\', \'reference\');">'+btnAutocomplete+'</a>');
        $('#autocompleteAfiliation').append('<a href="javascript:suggestNN(\'#AfiliationAR_afiliation\', \'afiliation\', \'reference\');">'+btnAutocomplete+'</a>'); 
        
        $('#autocompletePublisher').append('<a href="javascript:suggest(\'#ReferenceAR_idpublisher\',\'#PublisherAR_publisher\', \'publisher\');">'+btnAutocomplete+'</a>');
        $('#autocompleteSource').append('<a href="javascript:suggest(\'#ReferenceAR_idsource\',\'#SourceAR_source\', \'source\');">'+btnAutocomplete+'</a>');
        //Help tooltip for Autocomplete Icons
        var acContent = "Click to choose from a list of records";
        $('.acIcon').poshytip({
            className: 'tip-twitter',
            content: acContent,
            alignTo: 'target',
            alignX: 'right',
            alignY: 'center',
            offsetX: 10,
            offsetY: 0
        });
        //Configs
        configInitial();
        configNotify();
        configIcons();
        configUpload('#ReferenceAR_idfile');        
}

function configInitial() {
	
	$("#saveBtn").button();

    // Evento onclick do botao save
    $("#saveBtn").click(function() {
        $('html, body').animate({scrollTop: 0}, 'slow');
        $('#saveBtn').button('option', 'label', 'Processing');
        $('#saveBtn').attr('checked', true);
        save();
    });
    
    $("#parseBibCitBtn").button();
    
    $("#parseBibCitBtn").click(function() {    
		if ($('#ReferenceAR_bibliographiccitation')[0].value != '') {
			var auxiliar = $('#ReferenceAR_bibliographiccitation')[0].value.split("");
			if (auxiliar[auxiliar.length - 1] != '.') {
				$('#ReferenceAR_bibliographiccitation')[0].value += '.';
			}
		
			var publicationYearString = $('#ReferenceAR_bibliographiccitation')[0].value.match(/[0-9][0-9]*/);
			if (publicationYearString != null) {
				publicationYearString = publicationYearString[0];
				var aux = $('#ReferenceAR_bibliographiccitation')[0].value.split(publicationYearString + '.', 2);
				var authorsString = $.trim(aux[0]);
				aux = aux[1];
				aux = aux.replace(/\./, ";.,");
				aux = aux.split(";.,");
				var titleString = $.trim(aux[0]);
				aux = aux.join("").replace(titleString, "");
				aux = aux.replace(/[,|\.]/, ";.,");
				aux = aux.split(";.,");
				var sourceString = $.trim(aux[0]);
				var observationString = $.trim(aux[1]);
	
				$('#parseAuthors').val(authorsString);
				$('#parsePublicationYear').val(publicationYearString);
				$('#parseTitle').val(titleString);
				$('#parseSource').val(sourceString);
				$('#parseObservation').val(observationString);
					
			    $('#parseBibCitBox').dialog("open");	
			} else {
				alert('Please insert a valid year in the bibliographic citation field.');
			}	
	    } else {
	        alert('Please insert a valid bibliographic citation.');
	    }
    });
    
    $('#parseBibCitBox').dialog({
    	title: 'Parsing bibliographic citation',
    	height: 300,
    	width: 600,
    	autoOpen: false,
    	show: {
	    	effect: "blind"
    	},
    	hide: {
	    	effect: "explode"
    	},
    	buttons: {
	    	"Confirm": function() {
	    		clickedParseBibliographic = true;
	    	
				$('#ReferenceAR_publicationyear').val($('#parsePublicationYear').val());
				$('#ReferenceAR_title').val($('#parseTitle').val());
				$('#ReferenceAR_observation').val($('#parseObservation').val());
				
				$('#SourceAR_source').val($('#parseSource').val());
				if ($('#parseSource').val() != '') showDialogsParse("#ReferenceAR_idsource", "#SourceAR_source", "source");
				
				var authors = $("#parseAuthors").val().split(";");
				for (var i = 0; i < authors.length; i++) {
					if (authors[i] != '') {
						// creatorListParse é uma lita que contém os nomes dos autores colocados no campo Bibliographic Citation
						// esta lista está no arquivo Maintain.js
						creatorListParse.push($.trim(authors[i]));
					}
				}
				creatorListParse.reverse();
				
				$("#ReferenceAR_bibliographiccitation").val('muahaha');
				$("#ReferenceAR_bibliographiccitation").val($("#parseAuthors").val() + '. ' + $('#parsePublicationYear').val() + '. ' + $('#parseTitle').val() + '. ' + $('#parseSource').val() + '. ' + $('#parseObservation').val() + '.');
				
		    	$(this).dialog("close");
	    	},
	    	Cancel: function() {
		    	$(this).dialog("close");
	    	}
    	}
    	
    });
}

// Acao de salva
function save(){
$.ajax({ type:'POST',
    url:'index.php?r=reference/save',
    data: $("#form").serialize(),
    dataType: "json",
    success:function(json) {
        if (json.success) {
        	if ($('#ReferenceAR_idreferenceelement').val() == '') {
        		$('#ReferenceAR_title').val('');     		
            }
            saveNN(json.id);
        }          

        showMessage(json.msg, json.success, false);
        $("#saveBtn").button("option", "label", "Save" );
        $('#saveBtn').attr("checked", false);
        $("#saveBtn").button("refresh");

        //Hide taxonomic tip
        $('#taxsuggest').poshytip('hide').poshytip('destroy').replaceWith('');
    }
});
}

</script>

<div id="Notification"></div>

<?php echo CHtml::beginForm('', 'post', array('id' => 'form')); ?>
<?php echo CHtml::activeHiddenField($reference, 'idreferenceelement'); ?>
<?php echo CHtml::activeHiddenField($reference, 'idfile'); ?>

<!-- TEXTO INTRODUTORIO -->

<div class="introText">
    <h1><?php echo $reference->idreferenceelement != null ? Yii::t('yii', 'Update an existing specimen reference record') : Yii::t('yii', 'Create a new specimen reference record'); ?></h1>
    <p><?php echo Yii::t('yii', "Use this tool to save records of references to modern biological specimens and information such as authorship, copyright and content data. This set of fields is based on international standards, such as Darwin Core, Dublin Core and their extensions."); ?></p>
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
                <td class="tablefieldcel">
<?php echo CHtml::activeDropDownList($reference, 'idsubtypereference', CHtml::listData(SubtypeReferenceAR::model()->findAll(" 1=1 ORDER BY subtypereference "), 'idsubtypereference', 'subtypereference'), array('empty' => '-')); ?>
                </td>
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
                <td class="tablefieldcel">
<?php echo CHtml::activeTextField($reference, 'title', array('class' => 'textboxtext')); ?>
                </td>
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
                    <td class="tablefieldcel">
<?php echo CHtml::activeHiddenField(KeywordAR::model(), 'idkeyword'); ?>
<?php echo CHtml::activeTextField(KeywordAR::model(), 'keyword', array('class' => 'textboxtext')); ?>
                    </td>
                    <td id="autocompleteKeyword" class="acIcon">
                    </td>
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
                    <td class="tablefieldcel">
<?php echo CHtml::activeHiddenField(CreatorAR::model(), 'idcreator'); ?>
<?php echo CHtml::activeTextField(CreatorAR::model(), 'creator', array('class' => 'textboxtext')); ?>
                    </td>
                    <td id="autocompleteCreator" class="acIcon">
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
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($reference,'publicationyear', array('class'=>'timeordate')); ?>
                <span style="font-size: 10px;"> YYYY</span>
            </td>
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
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($reference, 'idsource'); ?>
                    <?php echo $reference->source == null ? CHtml::activeTextField(SourceAR::model(), 'source', array('class'=>'textboxtext')) : CHtml::activeTextField($reference->source, 'source', array('class'=>'textboxtext')) ;?>
                </div>
            </td>
            <td class="acIcon" id="autocompleteSource">
            </td>
        </tr>
    </div>


    </table>
	
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
                    <td class="tablefieldcel">
<?php echo CHtml::activeDropDownList($reference, 'idlanguage', CHtml::listData(LanguageAR::model()->findAll(), 'idlanguage', 'language'), array('empty' => '-')); ?>
                    </td>
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
                    <td class="tablefieldcel">
<?php echo CHtml::activeHiddenField(AfiliationAR::model(), 'idafiliation'); ?>
<?php echo CHtml::activeTextField(AfiliationAR::model(), 'afiliation', array('class' => 'textboxtext')); ?>
                    </td>   
                    <td id="autocompleteAfiliation" class="acIcon">
                    </td>
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
            <td class="tablefieldcel">
                <?php //echo CHtml::activeHiddenField($reference, 'idpublisher'); ?>
                <?php //echo CHtml::activeTextField($reference->publisher, 'publisher', array('class' => 'textboxtext')); ?>
                <?php //echo CHtml::activeHiddenField(PublisherAR::model(), 'idpublisher'); ?>
                <?php //echo CHtml::activeTextField(PublisherAR::model(), 'publisher', array('class' => 'textboxtext')); ?>
                <?php echo CHtml::activeHiddenField($reference,'idpublisher'); ?>
                <?php echo $reference->publisher == null ? CHtml::activeTextField(PublisherAR::model(), 'publisher', array('class'=>'textboxtext')) : CHtml::activeTextField($reference->publisher, 'publisher', array('class'=>'textboxtext')) ;?>
            </td>
            <td class="acIcon" id="autocompletePublisher">
            </td>
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
                    <td class="tablefieldcel">
<?php echo CHtml::activeHiddenField(BiomeAR::model(), 'idbiome'); ?>
<?php echo CHtml::activeTextField(BiomeAR::model(), 'biome', array('class' => 'textboxtext')); ?>
                    </td>
                    <td id="autocompleteBiome" class="acIcon">
                    </td>
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
                    <td class="tablefieldcel">
<?php echo CHtml::activeHiddenField(PlantSpeciesAR::model(), 'idplantspecies'); ?>
<?php echo CHtml::activeTextField(PlantSpeciesAR::model(), 'plantspecies', array('class' => 'textboxtext')); ?>
                    </td>   
                    <td id="autocompletePlantSpecies" class="acIcon">
                    </td>
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
                    <td class="tablefieldcel">
<?php echo CHtml::activeHiddenField(PlantFamilyAR::model(), 'idplantfamily'); ?>
<?php echo CHtml::activeTextField(PlantFamilyAR::model(), 'plantfamily', array('class' => 'textboxtext')); ?>
                    </td>   
                    <td id="autocompletePlantFamily" class="acIcon">
                    </td>
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
                    <td class="tablefieldcel">
<?php echo CHtml::activeHiddenField(PlantCommonNameAR::model(), 'idplantcommonname'); ?>
<?php echo CHtml::activeTextField(PlantCommonNameAR::model(), 'plantcommonname', array('class' => 'textboxtext')); ?>
                    </td>   
                    <td id="autocompletePlantCommonName" class="acIcon">
                    </td>
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
                    <td class="tablefieldcel">
<?php echo CHtml::activeHiddenField(PollinatorSpeciesAR::model(), 'idpollinatorspecies'); ?>
<?php echo CHtml::activeTextField(PollinatorSpeciesAR::model(), 'pollinatorspecies', array('class' => 'textboxtext')); ?>
                    </td>   
                    <td id="autocompletePollinatorSpecies" class="acIcon">
                    </td>
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
                    <td class="tablefieldcel">
<?php echo CHtml::activeHiddenField(PollinatorFamilyAR::model(), 'idpollinatorfamily'); ?>
<?php echo CHtml::activeTextField(PollinatorFamilyAR::model(), 'pollinatorfamily', array('class' => 'textboxtext')); ?>
                    </td>   
                    <td id="autocompletePollinatorFamily" class="acIcon">
                    </td>
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
                    <td class="tablefieldcel">
<?php echo CHtml::activeHiddenField(PollinatorCommonNameAR::model(), 'idpollinatorcommonname'); ?>
<?php echo CHtml::activeTextField(PollinatorCommonNameAR::model(), 'pollinatorcommonname', array('class' => 'textboxtext')); ?>
                    </td>   
                    <td id="autocompletePollinatorCommonName" class="acIcon">
                    </td>
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
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($reference,'datedigitized', array('class'=>'timeordate')); ?>
                <span style="font-size: 10px;"> YYYY/MM/DD</span>
            </td>
            <td class="acIcon"></td>
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
                <td class="tablefieldcel">
<?php echo CHtml::activeTextField($reference, 'subject', array('class' => 'textboxtext')); ?>
                </td>
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
                    <td class="tablefieldcel">
<?php echo CHtml::activeTextArea($reference, 'abstract', array('class' => 'textarea')); ?>
                    </td>
                    <td class="acIcon">
                    </td>
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
                    <td class="tablefieldcel">
<?php echo CHtml::activeTextArea($reference, 'observation', array('class' => 'textarea')); ?>
                    </td>
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
                    <td class="tablefieldcel">
<?php echo CHtml::activeTextField($reference, 'isbnissn', array('class' => 'textboxtext')); ?>
                    </td>
                    <td class="acIcon">
                    </td>
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
                    <td class="tablefieldcel">
<?php echo CHtml::activeTextField($reference, 'url', array('class' => 'textboxtext')); ?>
                    </td>
                    <td class="acIcon">
                    </td>
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
                    <td class="tablefieldcel">
<?php echo CHtml::activeTextField($reference, 'doi', array('class' => 'textboxtext')); ?>
                    </td>
                    <td class="acIcon">
                    </td>
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
                    <td class="tablefieldcel">
<?php echo CHtml::activeTextArea($reference, 'bibliographiccitation', array('class' => 'textarea')); ?>
                    </td>
                    <td>
                    	<input type="button" id="parseBibCitBtn" value="Parse"/>
                    </td>
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
                    <td class="tablefieldcel">
<?php echo CHtml::activeDropDownList($reference, 'idfileformat', CHtml::listData(FileFormatAR::model()->findAll(), 'idfileformat', 'fileformat'), array('empty' => '-')); ?>
                    </td>
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
	</div>	
	<div class="privateRecord" id="fileStatus"></div>	

    <div class="privateRecord">
        <div class="title"><?php echo CHtml::activeCheckBox($reference, 'isrestricted') . "&nbsp;&nbsp;" . Yii::t('yii', 'Check here to make this record private') . "&nbsp;&nbsp;"; ?></div>
        <div class="icon"><?php showIcon("Private Record", "ui-icon-locked", 0); ?></div>
    </div>

    <div class="saveButton">
        <input type="checkbox" id="saveBtn" /><label for="saveBtn">Save</label>
    </div>
</div>

<div id="parseBibCitBox">
<table style="background-color: transparent">
	<tr>
		<td class="tablelabelcel">
			<?php echo CHtml::activeLabel(CreatorAR::model(), 'creator'); ?>
	    </td>
	    <td class="tablemiddlecel">
		    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=creator', array('rel' => 'lightbox')); ?>
	    </td>
	    <td class="tablefieldcel">
		    <input type="text" class="parseBibCitInputText" id="parseAuthors"/>
	    </td>
	    <td></td>
	</tr>
	<tr>
        <td class="tablelabelcel">
            <?php echo CHtml::activeLabel($reference, 'publicationyear');?>
        </td>
        <td class="tablemiddlecel">
            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=publicationyear',array('rel'=>'lightbox'));?>
        </td>
        <td class="tablefieldcel">
  		    <input type="text" class="parseBibCitInputText" id="parsePublicationYear"/>
        </td>
        <td><span style="font-size: 10px;"> YYYY</span></td>
    </tr>
    <tr>
        <td class="tablelabelcel">
	        <?php echo CHtml::activeLabel($reference, "title"); ?>
            <span class="required">*</span>
        </td>
        <td class="tablemiddlecel">
	        <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=title', array('rel' => 'lightbox')); ?>
        </td>
        <td class="tablefieldcel">
  		    <input type="text" class="parseBibCitInputText" id="parseTitle"/>
        </td>
        <td></td>
    </tr>
    <tr>
        <td class="tablelabelcel">
            <?php echo CHtml::activeLabel(SourceAR::model(), 'source'); ?>
        </td>
        <td class="tablemiddlecel">
            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=source', array('rel' => 'lightbox')); ?>
        </td>
        <td class="tablefieldcel">
  		    <input type="text" class="parseBibCitInputText" id="parseSource"/>
        </td>
        <td></td>
    </tr>
    <tr>
        <td class="tablelabelcel">
	        <?php echo CHtml::activeLabel($reference, 'observation'); ?>
        </td>
        <td class="tablemiddlecel">
	        <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=observation', array('rel' => 'lightbox')); ?>
        </td>
        <td class="tablefieldcel">
  		    <textarea type="text" class="parseBibCitInputText" id="parseObservation"></textarea>
        </td>
        <td></td>
    </tr>
</table>
</div>

<?php echo CHtml::endForm(); 

?>
