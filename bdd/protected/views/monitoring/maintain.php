<?php
$cs=Yii::app()->clientScript;
$cs->registerScriptFile("js/jquery/jquery.min.js",CClientScript::POS_BEGIN);
$cs->registerScriptFile("js/lightbox/lightbox.js",CClientScript::POS_BEGIN);
$cs->registerCssFile("css/lightbox.css");
//$cs->registerScriptFile("js/lightbox/recordlevelelements.js",CClientScript::POS_HEAD);
//$cs->registerScriptFile("js/lightbox/localityelements.js",CClientScript::POS_HEAD);
$cs->registerScriptFile("js/validation/validationdata.js",CClientScript::POS_BEGIN);
$cs->registerScriptFile("js/Maintain.js",CClientScript::POS_BEGIN);
$cs->registerScriptFile("js/Geo.js",CClientScript::POS_BEGIN);
$cs->registerScriptFile("js/validation/jquery.numeric.pack.js",CClientScript::POS_BEGIN);
$cs->registerScriptFile("js/jquery.jstepper.js",CClientScript::POS_BEGIN);
$cs->registerCssFile("js/tips/tip-twitter/tip-twitter.css");
$cs->registerScriptFile("js/tips/jquery.poshytip.min.js",CClientScript::POS_END);
include "protected/extensions/config.php";

$cs->registerScriptFile("js/autocomplete.js",CClientScript::POS_END);
$cs->registerScriptFile("js/loadfields.js",CClientScript::POS_END);
?>

<link href="css/jquery.jnotify.css" rel="stylesheet" type="text/css" />
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/ui-lightness/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>
<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
<script src="js/jquery.jnotify.js" type="text/javascript"></script>
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
<style type="text/css">
    #slider {
        margin: 10px;
    }
    input.ui-button {
        padding: .4em 1em; width:182px; margin-left:10px;
    }
    .tablelabelcel {
    	width:210px;
    }
    #project-label {
        color: #AA5511;
        margin-bottom: 1em;
    }
    #project-level {
        color: #AA5511;
        font-weight: bold;
    }
    #project-icon {
        float: right;
        height: 32px;
    }
    #project-description {
        margin: 0;
        padding: 0;
        font-size: small;
    }
</style>

<script type="text/javascript">
    
    $(document).ready(bootMonitoring);
    function bootMonitoring(){

        

        //Force numeric input
        $("#MonitoringAR_plotnumber").jStepper({minValue:0, disableNonNumeric:true});
        $("#MonitoringAR_amostralnumber").jStepper({minValue:0, disableNonNumeric:true});
        $("#MonitoringAR_floorheight").jStepper({minValue:0, disableNonNumeric:true});
        $("#MonitoringAR_weight").jStepper({minValue:0, disableNonNumeric:true});
        $("#MonitoringAR_width").jStepper({minValue:0, disableNonNumeric:true});
        $("#MonitoringAR_length").jStepper({minValue:0, disableNonNumeric:true});
        $("#MonitoringAR_height").jStepper({minValue:0, disableNonNumeric:true});
        $("#MonitoringAR_idgeral").jStepper({minValue:0, disableNonNumeric:true});
        $("#MonitoringAR_installationtime").mask("99:99:99");
        $("#MonitoringAR_installationdate").mask("9999/99/99");
        $("#MonitoringAR_installationdate").datepicker({ dateFormat: 'yy/mm/dd' });
        $("#MonitoringAR_collecttime").mask("99:99:99");
        $("#MonitoringAR_collectdate").mask("9999/99/99");
        $("#MonitoringAR_collectdate").datepicker({ dateFormat: 'yy/mm/dd' });
        $("#GeospatialElementAR_decimallatitude").jStepper({disableNonNumeric:true, decimalSeparator:"."});
        $("#GeospatialElementAR_decimallongitude").jStepper({disableNonNumeric:true, decimalSeparator:"."});

        // id, field, controller
        configAutocomplete('#MonitoringAR_iddenomination','#DenominationAR_denomination', 'denomination');
        configAutocomplete('#MonitoringAR_idtechnicalcollection','#TechnicalCollectionAR_technicalcollection', 'technicalcollection');
        configAutocomplete('#MonitoringAR_iddigitizer','#DigitizerAR_digitizer', 'digitizer');
        configAutocomplete('#MonitoringAR_idculture','#CultureAR_culture', 'culture');
        configAutocomplete('#MonitoringAR_idcultivar','#CultivarAR_cultivar', 'cultivar');
        configAutocomplete('#MonitoringAR_idpredominantbiome','#PredominantBiomeAR_predominantbiome', 'predominantbiome');
        configAutocomplete('#MonitoringAR_idsurroundingsculture','#SurroundingsCultureAR_surroundingsculture', 'surroundingsculture');
        configAutocomplete('#MonitoringAR_idsurroundingsvegetation','#SurroundingsVegetationAR_surroundingsvegetation', 'surroundingsvegetation');
        configAutocomplete('#MonitoringAR_idcolorpantrap','#ColorPanTrapAR_colorpantrap', 'colorpantrap');
        configAutocomplete('#MonitoringAR_idsupporttype','#SupportTypeAR_supporttype', 'supporttype');
        configAutocomplete('#MonitoringAR_idcollector','#CollectorAR_collector', 'collector');
        configAutocomplete('#RecordLevelElementAR_idinstitutioncode','#InstitutionCodeAR_institutioncode', 'institutioncode');
        configAutocomplete('#RecordLevelElementAR_idcollectioncode','#CollectionCodeAR_collectioncode', 'collectioncode');
        //configAutocomplete('#TaxonomicElementAR_idscientificname','#ScientificNameAR_scientificname', 'scientificname');
        //configAutocomplete('#TaxonomicElementAR_idmorphospecies','#MorphospeciesAR_morphospecies', 'morphospecies');
        configAutocomplete('#LocalityElementAR_idcountry','#CountryAR_country', 'country');
        configAutocomplete('#LocalityElementAR_idstateprovince','#StateProvinceAR_stateprovince', 'stateprovince');
        configAutocomplete('#LocalityElementAR_idcounty','#CountyAR_county', 'county');
        configAutocomplete('#LocalityElementAR_idmunicipality','#MunicipalityAR_municipality', 'municipality');
        configAutocomplete('#LocalityElementAR_idlocality','#LocalityAR_locality', 'locality');
        configAutocomplete('#OccurrenceElementAR_idsex','#SexAR_sex', 'sex');


        //Autocomplete icons
        //Example
        //<td class="acIcon" id="autocomplete"></td>
        var btnAutocomplete ="<div class='btnAutocomplete' style='width:20px;'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-comment'></span></li></ul></div>";

        $('#autocompleteDenomination').append('<a href="javascript:suggest(\'#MonitoringAR_iddenomination\',\'#DenominationAR_denomination\', \'denomination\');">'+btnAutocomplete+'</a>');
        $('#autocompleteTechnicalCollection').append('<a href="javascript:suggest(\'#MonitoringAR_idtechnicalcollection\',\'#TechnicalCollectionAR_technicalcollection\', \'technicalcollection\');">'+btnAutocomplete+'</a>');
        $('#autocompleteDigitizer').append('<a href="javascript:suggest(\'#MonitoringAR_iddigitizer\',\'#DigitizerAR_digitizer\', \'digitizer\');">'+btnAutocomplete+'</a>');
        $('#autocompleteCulture').append('<a href="javascript:suggest(\'#MonitoringAR_idculture\',\'#CultureAR_culture\', \'culture\');">'+btnAutocomplete+'</a>');
        $('#autocompleteCultivar').append('<a href="javascript:suggest(\'#MonitoringAR_idcultivar\',\'#CultivarAR_cultivar\', \'cultivar\');">'+btnAutocomplete+'</a>');
        $('#autocompletePredominantBiome').append('<a href="javascript:suggest(\'#MonitoringAR_idpredominantbiome\',\'#PredominantBiomeAR_predominantbiome\', \'predominantbiome\');">'+btnAutocomplete+'</a>');
        $('#autocompleteSurroundingsCulture').append('<a href="javascript:suggest(\'#MonitoringAR_idsurroundingsculture\',\'#SurroundingsCultureAR_surroundingsculture\', \'surroundingsculture\');">'+btnAutocomplete+'</a>');
        $('#autocompleteSurroundingsVegetation').append('<a href="javascript:suggest(\'#MonitoringAR_idsurroundingsvegetation\',\'#SurroundingsVegetationAR_surroundingsvegetation\', \'surroundingsvegetation\');">'+btnAutocomplete+'</a>');
        $('#autocompleteColorPanTrap').append('<a href="javascript:suggest(\'#MonitoringAR_idcolorpantrap\',\'#ColorPanTrapAR_colorpantrap\', \'colorpantrap\');">'+btnAutocomplete+'</a>');
        $('#autocompleteSupportType').append('<a href="javascript:suggest(\'#MonitoringAR_idsupporttype\',\'#SupportTypeAR_supporttype\', \'supporttype\');">'+btnAutocomplete+'</a>');
        $('#autocompleteCollector').append('<a href="javascript:suggest(\'#MonitoringAR_idcollector\',\'#CollectorAR_collector\', \'collector\');">'+btnAutocomplete+'</a>');
        $('#autocompleteInstitutionCode').append('<a href="javascript:suggest(\'#RecordLevelElementAR_idinstitutioncode\',\'#InstitutionCodeAR_institutioncode\', \'institutioncode\');">'+btnAutocomplete+'</a>');
        $('#autocompleteCollectionCode').append('<a href="javascript:suggest(\'#RecordLevelElementAR_idcollectioncode\',\'#CollectionCodeAR_collectioncode\', \'collectioncode\');">'+btnAutocomplete+'</a>');
        //$('#autocompleteScientificName').append('<a href="javascript:suggest(\'#TaxonomicElementAR_idscientificname\',\'#ScientificNameAR_scientificname\', \'scientificname\');">'+btnAutocomplete+'</a>');
        //$('#autocompleteMorphospecies').append('<a href="javascript:suggest(\'#TaxonomicElementAR_idmorphospecies\',\'#MorphospeciesAR_morphospecies\', \'morphospecies\');">'+btnAutocomplete+'</a>');
        $('#autocompleteCountry').append('<a href="javascript:suggest(\'#LocalityElementAR_idcountry\',\'#CountryAR_country\', \'country\');">'+btnAutocomplete+'</a>');
        $('#autocompleteState').append('<a href="javascript:suggest(\'#LocalityElementAR_idstateprovince\',\'#StateProvinceAR_stateprovince\', \'stateprovince\');">'+btnAutocomplete+'</a>');
        $('#autocompleteCounty').append('<a href="javascript:suggest(\'#LocalityElementAR_idcounty\',\'#CountyAR_county\', \'county\');">'+btnAutocomplete+'</a>');
        $('#autocompleteMunicipality').append('<a href="javascript:suggest(\'#LocalityElementAR_idmunicipality\',\'#MunicipalityAR_municipality\', \'municipality\');">'+btnAutocomplete+'</a>');
        $('#autocompleteLocality').append('<a href="javascript:suggest(\'#LocalityElementAR_idlocality\',\'#LocalityAR_locality\', \'locality\');">'+btnAutocomplete+'</a>');
        $('#autocompleteSex').append('<a href="javascript:suggest(\'#OccurrenceElementAR_idsex\',\'#SexAR_sex\', \'sex\');">'+btnAutocomplete+'</a>');

        //Help tooltip for Autocomplete Icons
        var acContent = "Click to choose from a list of records"

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
        configAccordion();
        configNotify();
        configIcons();
        configAutoComplete();


        //geocoding($('#GeospatialElementAR_decimallatitude').val(),$('#GeospatialElementAR_decimallongitude').val());
        //configLocation();

    }
    function configInitial() {
        $("#saveBtn").button();
        //$("#btnGeoreferencing").button();
        // Evento onclick do botao save
        $("#saveBtn").click(function() {
            $('html, body').animate({scrollTop: 0}, 'slow');
            $('#saveBtn').button('option', 'label', 'Processando');
            $('#saveBtn').attr('checked', true);
            save();
        });
        //$("#btnGeoreferencing").click(function() {
         //   georeferencing();
        //});
        //reverseGeocoding();
        //$("#bgtBtn").button();
        // Evento onclick do botao save
       // $("#bgtBtn").click(function() {
        //    openBGT();
        //});
    }
    function configAccordion() {
        // Cria accordions apartir das divs
        $( "#dadosAmbientaisAccordion").accordion({collapsible: true,autoHeight: false,navigation: true});
        $( "#panTrapsAccordion" ).accordion({collapsible: true,autoHeight: false,navigation: true});
        $( "#taxonomicElementsAccordion" ).accordion({collapsible: true,autoHeight: false,navigation: true});
        $( "#localityElementsAccordion" ).accordion({collapsible: true,autoHeight: false,navigation: true});
        $( "#dadosEspecimeAccordion" ).accordion({collapsible: true,autoHeight: false,navigation: true});

        // Fecha todas
        $( "#dadosAmbientaisAccordion").accordion("activate" ,false);
        $( "#panTrapsAccordion" ).accordion("activate" ,false);
        $( "#taxonomicElementsAccordion" ).accordion("activate" ,false);
        $( "#localityElementsAccordion" ).accordion("activate" ,false);
        $( "#dadosEspecimeAccordion" ).accordion("activate" ,false);
    }

    function showTaxonomicTip(kingdom, phylum, class_, order, family, genus, subgenus, specificepithet, infraspecificepithet)
    {
        $('#taxsuggest').poshytip('hide');
        $('#taxsuggest').poshytip('destroy');

        //Clear the entries if null
        if (order == null)
        {order = '';}
        if (family == null)
        {family = '';}
        if (genus == null)
        {genus = '';}
        if (subgenus == null)
        {subgenus = '';}
        
        var tip = '<div style="font-weight:normal;"><div style="clear:both"></div><div class="tipKey">Order</div><div class="tipValue">'+order+'</div><div style="clear:both"></div><div class="tipKey">Family</div><div class="tipValue">'+family+'</div><div style="clear:both"></div><div class="tipKey">Genus</div><div class="tipValue">'+genus+'</div><div style="clear:both"></div><div class="tipKey">Subgenus</div><div class="tipValue">'+subgenus+'</div><div style="clear:both"></div><div style="clear:both"></div></div>';

        $('#taxsuggest').poshytip({
            className: 'tip-twitter',
            showTimeout: 500,
            alignTo: 'target',
            alignX: 'right',
            alignY: 'center',
            showOn: 'none',
            content: tip
        }).poshytip('show');

        setTimeout(function() {
            $('#taxsuggest').poshytip('hide');
            setTimeout(function(){
                $('#taxsuggest').poshytip('destroy');
            }, 1000);
        }, 5000);
    }

    // Acao de salva
    function save(){
        $.ajax({ type:'POST',
            url:'index.php?r=monitoring/save',
            data: $("#form").serialize(),
            dataType: "json",
            success:function(json) {
            	if (json.success) {
	            	if ($('#MonitoringAR_idmonitoring').val() == '') {
		        		$('#OccurrenceElementAR_catalognumber').val('');     		
		            }
	            }

                showMessage(json.msg, json.success, false);
                $("#saveBtn").button( "option", "label", "Save" );
                $('#saveBtn').attr('checked', false);
                $("#saveBtn").button("refresh");


                //Hide taxonomic tip
                $('#taxsuggest').poshytip('hide').poshytip('destroy');

            }
        });
    }
    function configAutoComplete() {
        $( "#taxonName" ).autocomplete({
		minLength: 1,
		source: 'index.php?r=monitoring/searchLocalScientificName',
		select: function(event, ui ) {
			$("#TaxonomicElementAR_idmorphospecies").val('');
            $("#MorphospeciesAR_morphospecies").val('');
            $("#TaxonomicElementAR_idscientificname").val('');
            $("#ScientificNameAR_scientificname").val('');
            
            if(ui.item.desc=='Morphospecies' || ui.item.desc == 'New morphospecies?') {
                $("#TaxonomicElementAR_idmorphospecies").val(ui.item.id);
                $("#MorphospeciesAR_morphospecies").val(ui.item.label);
                if (ui.item.desc == 'New morphospecies?' || ui.item.level == 'New')
            		showDialogs('#TaxonomicElementAR_idmorphospecies', '#MorphospeciesAR_morphospecies', 'morphospecies');
            } else {
	            $("#TaxonomicElementAR_idscientificname").val(ui.item.id);
	            $("#ScientificNameAR_scientificname").val(ui.item.label);
	            if (ui.item.rank == 'New')
	            	showDialogs('#TaxonomicElementAR_idscientificname', '#ScientificNameAR_scientificname', 'scientificname');
            }
		}			
		}).data( "autocomplete" )._renderItem = function( ul, item ) {
			return $( "<li></li>" ).data( "item.autocomplete", item ).append("<a><span id='project-label'>" +item.label + "</span> (<span id='project-level'>"+item.level+"</span>) <img id='project-icon' src='"+item.icon+"'/><br><span id='project-description'>" + item.desc + "</span></a>" )
				.appendTo( ul );
		};
    }
</script>

<div id="Notification"></div>

<?php echo CHtml::beginForm('','post',array ('id'=>'form')); ?>
<?php echo CHtml::activeHiddenField($monitoring,'idmonitoring');?>
<?php echo CHtml::activeHiddenField($monitoring,'idrecordlevelelement');?>
<?php echo CHtml::activeHiddenField($monitoring->recordlevelelement,'idrecordlevelelement');?>
<?php echo CHtml::activeHiddenField($monitoring->recordlevelelement,'globaluniqueidentifier');?>
<?php echo CHtml::activeHiddenField($monitoring,'idoccurrenceelement');?>
<?php echo CHtml::activeHiddenField($monitoring->occurrenceelement,'idoccurrenceelement');?>
<?php echo CHtml::activeHiddenField($monitoring,'idtaxonomicelement');?>
<?php echo CHtml::activeHiddenField($monitoring,'idlocalityelement');?>
<?php echo CHtml::activeHiddenField($monitoring->localityelement,'idlocalityelement');?>
<?php echo CHtml::activeHiddenField($monitoring,'idgeospatialelement');?>
<?php echo CHtml::activeHiddenField($monitoring->geospatialelement,'idgeospatialelement');?>

<div class="introText">
    <h1><?php echo $monitoring->idmonitoring != null?Yii::t('yii','Atualizar um registro existente de Monitoramento'):Yii::t('yii','Criar um novo registro de Monitoramento'); ?></h1>
    <p><?php echo Yii::t('yii',"Use esta ferramenta para criar e atualizar registros de monitoramento de espécimes biológicas, suas ocorrências espaço-temporais, e suas outras informações."); ?></p>
</div>

<div class="yiiForm" style="width:85%">
    <div class="staticMap">
        <!--<span id="loc"></span>-->
        
    </div>
    <div class="attention">
        <?php echo CHtml::image('images/main/attention.png','',array('border'=>'0px'))."&nbsp;".Yii::t('yii', "Main Fields");?>
        (<span style="color: red; font-weight: bold;"><?php echo Yii::t('yii',"Campos com * são obrigatórios"); ?></span>)
    </div>
    <table cellspacing="0" cellpadding="0" align="center" class="tablerequired" style="margin-bottom:12px;">
        <div class="tablerow" id='divbasisofrecord'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::label(Yii::t('yii','Base do Registro'), ""); ?>
                    <span class="required">*</span>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=basisofrecord',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel">
                    <?php echo CHtml::activeDropDownList($monitoring->recordlevelelement, 'idbasisofrecord', CHtml::listData(BasisOfRecordAR::model()->findAll(" 1=1 ORDER BY basisofrecord "), 'idbasisofrecord', 'basisofrecord'), array('empty'=>'-'));?>
                </td>
            </tr>
        </div>
        <div class="tablerow" id='divinstitutioncode'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::label(Yii::t('yii','Código de Instituição'), ""); ?>
                    <span class="required">*</span>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=institutioncode',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                        <?php echo CHtml::activeHiddenField($monitoring->recordlevelelement,'idinstitutioncode');?>
                        <?php echo CHtml::activeTextField($monitoring->recordlevelelement->institutioncode, 'institutioncode',array('class'=>'textboxtext'));?>
                    </div>
                </td>
                <td class="acIcon" id="autocompleteInstitutionCode">
                </td>
            </tr>
        </div>
        <div class="tablerow" id='divcollectioncode'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::label(Yii::t('yii','Código de Coleção'), ""); ?>
                    <span class="required">*</span>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=collectioncode',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                        <?php echo CHtml::activeHiddenField($monitoring->recordlevelelement,'idcollectioncode');?>
                        <?php echo CHtml::activeTextField($monitoring->recordlevelelement->collectioncode, 'collectioncode',array('class'=>'textboxtext'));?>
                    </div>
                </td>
                <td class="acIcon" id="autocompleteCollectionCode">
                </td>
            </tr>
        </div>
        <div class="tablerow" id='divcatalognumber'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::label(Yii::t('yii','Número de Catálogo'), ""); ?>
                    <span class="required">*</span>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=catalognumber',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel">
                    <?php echo CHtml::activeTextField($monitoring->occurrenceelement,'catalognumber',array('class'=>'textboxtext')); ?>
                </td>
            </tr>
        </div>
        <div class="tablerow" id='dividgeral'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','ID Geral'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=idgeral',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($monitoring,'idgeral',array('class'=>'textfield')); ?>
            </td>
            <td class="acIcon"></td>
        </tr>
    </div>
        <div class="tablerow" id='divscientificname'>
            <tr style="display:none">
                <td class="tablelabelcel">
                    <?php echo CHtml::label(Yii::t('yii','Nome Científico'), ""); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=scientificname',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                        <?php echo CHtml::activeHiddenField($monitoring->taxonomicelement,'idscientificname');?>
                        <?php echo CHtml::activeTextField($monitoring->taxonomicelement->scientificname, 'scientificname',array('class'=>'textboxtext'));?>
                    </div>
                </td>
                <td class="acIcon" id="autocompleteScientificName">
                </td>
                <!--<td>
                    <div class="field autocomplete" id="taxsuggest">
                        <input type="button" value="Auto Suggestion Hierarchy" id="btnAutoSuggestionHierarchy">
                    </div>
                </td>-->
            </tr>
        </div>
        <div class="tablerow" id='divmorphospecies'>
            <tr style="display:none">
                <td class="tablelabelcel">
                    <?php echo CHtml::label(Yii::t('yii','Morfoespécie'), ""); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=morphospecies',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                        <?php echo CHtml::activeHiddenField($monitoring->taxonomicelement,'idmorphospecies');?>
                        <?php echo CHtml::activeTextField($monitoring->taxonomicelement->morphospecies, 'morphospecies',array('class'=>'textboxtext'));?>
                    </div>
                </td>
                <td class="acIcon" id="autocompleteMorphospecies">
                </td>
            </tr>
        </div>
        <div class="tablerow" id='divtaxonname'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::label(Yii::t('yii','Nome científico'), ""); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=taxoname',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel">
                    <input id="taxonName" type="text"/ style="width:198px" value="<?php echo $monitoring->taxonomicelement->scientificname->scientificname==''?$monitoring->taxonomicelement->morphospecies->morphospecies:$monitoring->taxonomicelement->scientificname->scientificname;?>">
                </td>
                <td class="acIcon">
                </td>
            </tr>
        </div>
        <tr>
            <td class="tablelabelcel" colspan=4>
            </td>
        </tr>
        <div class="tablerow" id='divdenomination'>
            <tr>
                <td class="tablelabelcel">
                    <?php// echo CHtml::activeLabel($monitoring->denomination, 'denomination');?>
                    <?php echo CHtml::label(Yii::t('yii','Denominação'), ""); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=denomination',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                        <?php echo CHtml::activeHiddenField($monitoring,'iddenomination');?>
                        <?php echo CHtml::activeTextField($monitoring->denomination, 'denomination', array('class'=>'textfield'));?>
                    </div>
                </td>
                <td class="acIcon" id="autocompleteDenomination"></td>
            </tr>
        </div>
        <div class="tablerow" id='divtechnicalcollection'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::label(Yii::t('yii','Técnica de Coleta'), ""); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=technicalcollection',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                        <?php echo CHtml::activeHiddenField($monitoring,'idtechnicalcollection');?>
                        <?php echo CHtml::activeTextField($monitoring->technicalcollection, 'technicalcollection', array('class'=>'textfield'));?>
                    </div>
                </td>
                <td class="acIcon" id="autocompleteTechnicalCollection"></td>
            </tr>
        </div>
        <div class="tablerow" id='divdigitizer'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::label(Yii::t('yii','Digitador'), ""); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=digitizer',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                        <?php echo CHtml::activeHiddenField($monitoring,'iddigitizer');?>
                        <?php echo CHtml::activeTextField($monitoring->digitizer, 'digitizer', array('class'=>'textfield'));?>
                    </div>
                </td>
                <td class="acIcon" id="autocompleteDigitizer"></td>
            </tr>
        </div>
        <div class="tablerow" id='divcollector'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::label(Yii::t('yii','Coletor'), ""); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=collector',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                        <?php echo CHtml::activeHiddenField($monitoring,'idcollector');?>
                        <?php echo CHtml::activeTextField($monitoring->collector, 'collector', array('class'=>'textfield'));?>
                    </div>
                </td>
                <td class="acIcon" id="autocompleteCollector"></td>
            </tr>
        </div>
        <tr>
            <td class="tablelabelcel" colspan=4>
            </td>
        </tr>
        <div class="tablerow" id='divdecimallatitude'>
            <tr>  
                <td class="tablelabelcel">
                    <?php echo CHtml::label(Yii::t('yii','Latitude (Graus Decimais)'), ""); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=decimallatitude',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel">
                    <?php echo CHtml::activeTextField($monitoring->geospatialelement,'decimallatitude',array('class'=>'textboxnumber'));?>
                </td>
                <td>
                </td>
                <td rowspan=2>
                    <div class="field autocomplete">
                        <!--<input type="button" value="BDD Georeferencing Tool" id="bgtBtn">-->
                    </div>
                </td>
            </tr>
        </div>
        <div class="tablerow" id='divdecimallongitude'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::label(Yii::t('yii','Longitude (Graus Decimais)'), ""); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=decimallongitude',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel">
                    <?php echo CHtml::activeTextField($monitoring->geospatialelement,'decimallongitude',array('class'=>'textboxnumber'));?>
                </td>
            </tr>
        </div>
        <!--<tr>
            <td class="tablelabelcel" colspan=4>
            </td>
        </tr>-->
        <div class="tablerow" id='divdecimallongitude'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo '';?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo '';?>                    
                </td>
                <td class="tablefieldcel">
                    
                </td>
            </tr>
        </div>
        <!--<tr>
            <td class="tablelabelcel" colspan=4>
            </td>
        </tr>
        <tr id="locationField">
            <td class="tablelabelcel">
                <?php //echo 'Location'?>
            </td>
            <td class="tablemiddlecel">
            </td>
            <td class="tablefieldcel">
                <?php //echo CHtml::textField('location', '', array('id'=>'location'));?>
            </td>
        </tr>-->      
        <tr id="countryField">
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','País'), ""); ?>
            </td>
            <td class="tablemiddlecel">
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeHiddenField($monitoring->localityelement,'idcountry');?>
                <?php echo CHtml::activeTextField($monitoring->localityelement->country,'country');?>
            </td>
            <td class="acIcon" id="autocompleteCountry">
            </td>
        </tr>
        <tr id="stateProvinceField">
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Estado ou Província'), ""); ?>
            </td>
            <td class="tablemiddlecel">
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeHiddenField($monitoring->localityelement,'idstateprovince');?>
                <?php echo CHtml::activeTextField($monitoring->localityelement->stateprovince,'stateprovince');?>
            </td>
            <td class="acIcon" id="autocompleteState">
            </td>
        </tr>
<!--        
			<tr id="countyField">
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel(CountyAR::model(),'county');?>
            </td>
            <td class="tablemiddlecel">
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeHiddenField($monitoring->localityelement,'idcounty');?>
                <?php echo CHtml::activeTextField($monitoring->localityelement->county,'county');?>
            </td>
            <td class="acIcon" id="autocompleteCounty">
            </td>
        </tr>
-->
        <tr id="municipalityField">
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Município'), ""); ?>
            </td>
            <td class="tablemiddlecel">
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeHiddenField($monitoring->localityelement,'idmunicipality');?>
                <?php echo CHtml::activeTextField($monitoring->localityelement->municipality,'municipality');?>
            </td>
            <td class="acIcon" id="autocompleteMunicipality">
            </td>
        </tr>
        <tr id="localityField">
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Localidade'), ""); ?>
            </td>
            <td class="tablemiddlecel">
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeHiddenField($monitoring->localityelement,'idlocality');?>
                <?php echo CHtml::activeTextField($monitoring->localityelement->locality, 'locality',array('class'=>'textboxtext'));?>
            </td>
            <td class="acIcon" id="autocompleteLocality">
            </td>
        </tr>
        <tr>
            <td class="tablelabelcel" colspan=4>
            </td>
        </tr>
    </table>
    
    <div id="dadosAmbientaisAccordion">
        <h3><a href="#">Dados Ambientais</a></h3>
        <div>
           <table cellspacing="0" cellpadding="0" align="center" class="normalFieldsTable">
    <div class="tablerow" id='divculture'>
        <tr>
            <td class="tablelabelcel">
                <?php// echo CHtml::activeLabel($monitoring->culture, 'culture');?>
                <?php echo CHtml::label(Yii::t('yii','Cultura'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=culture',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($monitoring,'idculture');?>
                    <?php echo CHtml::activeTextField($monitoring->culture, 'culture', array('class'=>'textfield'));?>
                </div>
            </td>
            <td class="acIcon" id="autocompleteCulture"></td>
        </tr>
    </div>
    <div class="tablerow" id='divcultivar'>
        <tr>
            <td class="tablelabelcel">
                <?php// echo CHtml::activeLabel($monitoring->cultivar, 'cultivar');?>
                <?php echo CHtml::label(Yii::t('yii','Cultivar'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=cultivar',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($monitoring,'idcultivar');?>
                    <?php echo CHtml::activeTextField($monitoring->cultivar, 'cultivar', array('class'=>'textfield'));?>
                </div>
            </td>
            <td class="acIcon" id="autocompleteCultivar"></td>
        </tr>
    </div>
    <div class="tablerow" id='divsurroundingsvegetation'>
        <tr>
            <td class="tablelabelcel">
                <?php// echo CHtml::activeLabel($monitoring->surroundingsculture, 'surroundingsculture');?>
                <?php echo CHtml::label(Yii::t('yii','Vegetação Próxima'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=surroundingsvegetation',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                    <?php echo CHtml::activeDropDownList($monitoring, 'idsurroundingsvegetation', CHtml::listData(SurroundingsVegetationAR::model()->findAll(" 1=1 ORDER BY surroundingsvegetation "), 'idsurroundingsvegetation', 'surroundingsvegetation'), array('empty'=>'-'));?>
            </td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divpredominantbiome'>
        <tr>
            <td class="tablelabelcel">
                <?php// echo CHtml::activeLabel($monitoring->predominantbiome, 'predominantbiome');?>
                <?php echo CHtml::label(Yii::t('yii','Bioma Predominante'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=predominantbiome',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                    <?php echo CHtml::activeDropDownList($monitoring, 'idpredominantbiome', CHtml::listData(PredominantBiomeAR::model()->findAll(" 1=1 ORDER BY predominantbiome "), 'idpredominantbiome', 'predominantbiome'), array('empty'=>'-'));?>
            </td>
            <td class="acIcon"></td>
        </tr>
    </div>
</table>
        </div>
    </div>
    <div id="panTrapsAccordion">
        <h3><a href="#">Pan Traps</a></h3>
        <div>
            
<table cellspacing="0" cellpadding="0" align="center" class="normalFieldsTable">
    <div class="tablerow" id='divinstallationdate'>
        <tr>
            <td class="tablelabelcel">
                <?php// echo CHtml::activeLabel($monitoring, "installationdate");?>
                <?php echo CHtml::label(Yii::t('yii','Data da Instalação'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=installationdate',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($monitoring,'installationdate',array('class'=>'timeordate')); ?>
                <span style="font-size: 10px;"> YYYY/MM/DD</span>
            </td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divinstallationtime'>
        <tr>
            <td class="tablelabelcel">
                <?php// echo CHtml::activeLabel($monitoring, "installationtime");?>
                <?php echo CHtml::label(Yii::t('yii','Hora da Instalação'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=installationtime',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($monitoring,'installationtime',array('class'=>'timeordate')); ?>
                <span style="font-size: 10px;">24 hh:mm:ss</span>
            </td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divcollectdate'>
        <tr>
            <td class="tablelabelcel">
                <?php// echo CHtml::activeLabel($monitoring, "collectdate");?>
                <?php echo CHtml::label(Yii::t('yii','Data da Coleta'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=collectdate',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($monitoring,'collectdate',array('class'=>'timeordate')); ?>
                <span style="font-size: 10px;"> YYYY/MM/DD</span>
            </td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divcollecttime'>
        <tr>
            <td class="tablelabelcel">
                <?php// echo CHtml::activeLabel($monitoring, "collecttime");?>
                <?php echo CHtml::label(Yii::t('yii','Hora da Coleta'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=collecttime',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($monitoring,'collecttime',array('class'=>'timeordate')); ?>
                <span style="font-size: 10px;">24 hh:mm:ss</span>
            </td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divsurroundingsculture'>
        <tr>
            <td class="tablelabelcel">
                <?php// echo CHtml::activeLabel($monitoring->surroundingsculture, 'surroundingsculture');?>
                <?php echo CHtml::label(Yii::t('yii','Entorno/Cultura'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=surroundingsculture',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                    <?php echo CHtml::activeDropDownList($monitoring, 'idsurroundingsculture', CHtml::listData(SurroundingsCultureAR::model()->findAll(" 1=1 ORDER BY surroundingsculture"), 'idsurroundingsculture', 'surroundingsculture'), array('empty'=>'-'));?>
            </td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divplotnumber'>
        <tr>
            <td class="tablelabelcel">
                <?php //echo CHtml::activeLabel($monitoring, "plotnumber");?>
                <?php echo CHtml::label(Yii::t('yii','Identificação Número do Plot'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=plotnumber',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($monitoring,'plotnumber',array('class'=>'textfield')); ?>
            </td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divamostralnumber'>
        <tr>
            <td class="tablelabelcel">
                <?php// echo CHtml::activeLabel($monitoring, "amostralnumber");?>
                <?php echo CHtml::label(Yii::t('yii','Identificação Número da Unidade Amostral'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=amostralnumber',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($monitoring,'amostralnumber',array('class'=>'textfield')); ?>
            </td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divcolorpantrap'>
        <tr>
            <td class="tablelabelcel">
                <?php// echo CHtml::activeLabel($monitoring->colorpantrap, 'colorpantrap');?>
                <?php echo CHtml::label(Yii::t('yii','Cor do Pan Trap'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=colorpantrap',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                    <?php echo CHtml::activeDropDownList($monitoring, 'idcolorpantrap', CHtml::listData(ColorPanTrapAR::model()->findAll(" 1=1 ORDER BY colorpantrap"), 'idcolorpantrap', 'colorpantrap'), array('empty'=>'-'));?>
            </td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='supporttype'>
        <tr>
            <td class="tablelabelcel">
                <?php //echo CHtml::activeLabel($monitoring, "plotnumber");?>
                <?php echo CHtml::label(Yii::t('yii','Tipo de Suporte'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=supporttype',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                    <?php echo CHtml::activeDropDownList($monitoring, 'idsupporttype', CHtml::listData(SupportTypeAR::model()->findAll(" 1=1 ORDER BY supporttype"), 'idsupporttype', 'supporttype'), array('empty'=>'-'));?>
            </td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divfloorheight'>
        <tr>
            <td class="tablelabelcel">
                <?php// echo CHtml::activeLabel($monitoring, "floorheight");?>
                <?php echo CHtml::label(Yii::t('yii','Altura do Chão'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=floorheight',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($monitoring,'floorheight',array('class'=>'textfield')); ?>
            </td>
            <td class="acIcon"><span style="font-size: 10px; position: relative; top: 6px;">cm</span></td>
        </tr>
    </div>
</table>
        </div>
    </div>
    <div id="taxonomicElementsAccordion">
        <h3><a href="#">Taxonomia do Espécime</a></h3>
        <div>
        	 <?php
            echo Yii::app()->controller->renderPartial('/monitoringtaxonomic/maintain', array(
            'taxonomicElement'=>$monitoring->taxonomicelement,
            ));
            ?>
            <div class="subgroup"><?php echo Yii::t('yii','Taxa'); ?></div>

<?php echo CHtml::activeHiddenField($monitoring->taxonomicelement,'idtaxonomicelement');?>
<?php echo CHtml::activeHiddenField($monitoring->taxonomicelement,'idtaxonrank');?>
<?php echo CHtml::activeHiddenField($monitoring->taxonomicelement,'idscientificnameauthorship');?>
<?php echo CHtml::activeHiddenField($monitoring->taxonomicelement,'idnomenclaturalcode');?>
<?php echo CHtml::activeHiddenField($monitoring->taxonomicelement,'idacceptednameusage');?>
<?php echo CHtml::activeHiddenField($monitoring->taxonomicelement,'idparentnameusage');?>
<?php echo CHtml::activeHiddenField($monitoring->taxonomicelement,'idoriginalnameusage');?>
<?php echo CHtml::activeHiddenField($monitoring->taxonomicelement,'idnameaccordingto');?>
<?php echo CHtml::activeHiddenField($monitoring->taxonomicelement,'idnamepublishedin');?>
<?php echo CHtml::activeHiddenField($monitoring->taxonomicelement,'idtaxonconcept');?>
<?php echo CHtml::activeHiddenField($monitoring->taxonomicelement,'idtaxonomicstatus');?>

<div style="display: none;" class="boxclean" id="divLimparTaxonomicElements"  >
    <a href="javascript:limparCamposTaxonomicElements()" >
        <?php echo CHtml::image("images/main/eraser.jpg", "",array("style"=>"border:0px;")); ?>&nbsp;
        <?php echo Yii::t('yii','Clean suggested items'); ?>
    </a>
</div>

<table cellspacing="0" cellpadding="0" align="center" class="normalFieldsTable">
    <div class="tablerow" id='divbutton'>
        <tr>
            <td class="tablelabelcel">
                <?php echo ' ';?>
            </td>
            <td class="tablemiddlecel">
                <?php echo ' ';?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <input type="button" value="Clean Hierarchy" id="btnCleanHierarchy">
                </div>
            </td>
        </tr>
    </div>
    <div class="tablerow" id='divorder'>
        <tr>
            <td class="tablelabelcel">
                <?php// echo CHtml::activeLabel(OrderAR::model(), "order");?>
                <?php echo CHtml::label(Yii::t('yii','Ordem'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=order',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($monitoring->taxonomicelement,'idorder');?>
                    <?php echo CHtml::activeTextField($monitoring->taxonomicelement->order, 'order', array('class'=>'textfield'));?>
                </div>
            </td>
            <td class="acIcon" id="autocompleteOrder">
            </td>
        </tr>
    </div>
    <div class="tablerow" id='divfamily'>
        <tr>
            <td class="tablelabelcel">
                <?php //echo CHtml::activeLabel(FamilyAR::model(), "family");?>
                <?php echo CHtml::label(Yii::t('yii','Família'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=family',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($monitoring->taxonomicelement,'idfamily');?>
                    <?php echo CHtml::activeTextField($monitoring->taxonomicelement->family, 'family', array('class'=>'textfield'));?>
                </div>
            </td>
            <td class="acIcon" id="autocompleteFamily">
            </td>
        </tr>
    </div>
    <div class="tablerow" id='divtribe'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Tribo'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=tribe',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($monitoring->taxonomicelement,'idtribe');?>
                    <?php echo CHtml::activeTextField($monitoring->taxonomicelement->tribe, 'tribe', array('class'=>'textfield'));?>
                </div>
            </td>
            <td class="acIcon" id="autocompleteTribe">
            </td>
        </tr>
    </div>
    <div class="tablerow" id='divsubtribe'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Sub-tribo'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=subtribe',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($monitoring->taxonomicelement,'idsubtribe');?>
                    <?php echo CHtml::activeTextField($monitoring->taxonomicelement->subtribe, 'subtribe', array('class'=>'textfield'));?>
                </div>
            </td>
            <td class="acIcon" id="autocompleteSubtribe">
            </td>
        </tr>
    </div>
    <div class="tablerow" id='divgenus'>
        <tr>
            <td class="tablelabelcel">
                <?php //echo CHtml::activeLabel(GenusAR::model(), "genus");?>
                <?php echo CHtml::label(Yii::t('yii','Gênero'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=genus',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($monitoring->taxonomicelement,'idgenus');?>
                    <?php echo CHtml::activeTextField($monitoring->taxonomicelement->genus, 'genus', array('class'=>'textfield'));?>
                </div>
            </td>
            <td class="acIcon" id="autocompleteGenus">
            </td>
        </tr>
    </div>
<!--
    <div class="tablerow" id='divsubgenus'>
        <tr>
            <td class="tablelabelcel">
                <?php //echo CHtml::activeLabel(SubgenusAR::model(), "subgenus");?>
                <?php echo CHtml::label(Yii::t('yii','Sub-gênero'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=subgenus',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($monitoring->taxonomicelement,'idsubgenus');?>
                    <?php echo CHtml::activeTextField($monitoring->taxonomicelement->subgenus, 'subgenus', array('class'=>'textfield'));?>
                </div>
            </td>
            <td class="acIcon" id="autocompleteSubgenus">
            </td>
        </tr>
    </div>
-->
    <div class="tablerow" id='divspeciesname'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Espécie'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=species',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($monitoring->taxonomicelement,'idspeciesname');?>
                    <?php echo CHtml::activeTextField($monitoring->taxonomicelement->speciesname, 'speciesname', array('class'=>'textfield'));?>
                </div>
            </td>
            <td class="acIcon" id="autocompleteSpeciesName">
            </td>
        </tr>
    </div>
    <div class="tablerow" id='divsubspecies'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Sub-espécie'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=subspecies',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($monitoring->taxonomicelement,'idsubspecies');?>
                    <?php echo CHtml::activeTextField($monitoring->taxonomicelement->subspecies, 'subspecies', array('class'=>'textfield'));?>
                </div>
            </td>
            <td class="acIcon" id="autocompleteSubspecies">
            </td>
        </tr>
    </div>
    <div class="tablerow" id='divpopularname'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Nome Popular'), ""); ?>

            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=subtribe',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeTextField($monitoring->taxonomicelement, 'vernacularname', array('class'=>'textfield'));?>
                </div>
            </td>
        </tr>
    </div>

</table>
        </div>
    </div>
    <div id="localityElementsAccordion">
        <h3><a href="#">Localização do Espécime</a></h3>
        <div>
           <table cellspacing="0" cellpadding="0" align="center" class="normalFieldsTable">

    <div class="tablerow" id='divaltitude'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Altitude'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=verbatimelevation',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($monitoring->localityelement, 'verbatimelevation', array('class'=>'textfield'));?>
            </td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divgeodeticdatum'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Datum Geodésico'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=coordinateprecision',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($monitoring->geospatialelement, 'geodeticdatum', array('class'=>'textfield'));?>
            </td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divlocationremark'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Dados Complementares da Localidade'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=coordinateprecision',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($monitoring->localityelement, 'locationremark', array('class'=>'textfield'));?>
            </td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divcoordinateprecision'>
        <tr>
            <td class="tablelabelcel">
                <?php echo 'Precisão GPS'; ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=coordinateprecision',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($monitoring->localityelement, 'coordinateprecision', array('class'=>'textfield'));?>
            </td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divcoordinateprecision'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','GPS Pontos de Referência'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=coordinateprecision',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($monitoring->geospatialelement, 'referencepoints', array('class'=>'textfield'));?>
            </td>
            <td class="acIcon"></td>
        </tr>
    </div>
</table>
        </div>
    </div>
    <div id="dadosEspecimeAccordion">
        <h3><a href="#">Dados Sobre o Espécime</a></h3>
        <div>
            
            <table cellspacing="0" cellpadding="0" align="center" class="normalFieldsTable">

    <div class="tablerow" id='divsex'>
        <tr>
            <td class="tablelabelcel">
                <?php// echo CHtml::activeLabel($monitoring->denomination, 'denomination');?>
                <?php echo CHtml::label(Yii::t('yii','Sexo'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=denomination',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($monitoring->occurrenceelement,'idsex');?>
                    <?php echo CHtml::activeTextField($monitoring->occurrenceelement->sex, 'sex', array('class'=>'textfield'));?>
                </div>
            </td>
            <td class="acIcon" id="autocompleteSex"></td>
        </tr>
    </div>
    <div class="tablerow" id='divweight'>
        <tr>
            <td class="tablelabelcel">
                <?php// echo CHtml::activeLabel($monitoring, "weight");?>
                <?php echo CHtml::label(Yii::t('yii','Peso'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=weight',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($monitoring,'weight',array('class'=>'textfield')); ?>
            </td>
            <td class="acIcon"><span style="font-size: 10px; position: relative; top: 6px;">mg</span></td>
        </tr>
    </div>
    <div class="tablerow" id='divwidth'>
        <tr>
            <td class="tablelabelcel">
                <?php //echo CHtml::activeLabel($monitoring, "width");?>
                <?php echo CHtml::label(Yii::t('yii','Largura'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=width',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($monitoring,'width',array('class'=>'textfield')); ?>
            </td>
            <td class="acIcon"><span style="font-size: 10px; position: relative; top: 6px;">mm</span></td>
        </tr>
    </div>
    <div class="tablerow" id='divlength'>
        <tr>
            <td class="tablelabelcel">
                <?php //echo CHtml::activeLabel($monitoring, "length");?>
                <?php echo CHtml::label(Yii::t('yii','Comprimento'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=length',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($monitoring,'length',array('class'=>'textfield')); ?>
            </td>
            <td class="acIcon"><span style="font-size: 10px; position: relative; top: 6px;">mm</span></td>
        </tr>
    </div>
    <div class="tablerow" id='divheight'>
        <tr>
            <td class="tablelabelcel">
                <?php// echo CHtml::activeLabel($monitoring, "height");?>
                <?php echo CHtml::label(Yii::t('yii','Altura'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=height',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($monitoring,'height',array('class'=>'textfield')); ?>
            </td>
            <td class="acIcon"><span style="font-size: 10px; position: relative; top: 6px;">mm</span></td>
        </tr>
    </div>
</table>
        </div>
    </div>
    <div class="privateRecord">
        <div class="title"><?php echo CHtml::activeCheckBox($monitoring->recordlevelelement, 'isrestricted')."&nbsp;&nbsp;".Yii::t('yii','Selecione para fazer este registro privado')."&nbsp;&nbsp;"; ?></div>
        <div class="icon"><?php showIcon("Private Record", "ui-icon-locked", 0); ?></div>
    </div>
    <div class="saveButton">
        <input type="checkbox" id="saveBtn" /><label for="saveBtn">Salvar</label>
    </div>
</div>

<?php echo CHtml::endForm(); ?>