<?php include_once("protected/extensions/config.php"); ?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="js/validation/jquery.numeric.pack.js"></script>
<script type="text/javascript" src="js/jquery.jstepper.js"></script>
<script type="text/javascript" src="js/loadfields.js"></script>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/Geo.js"></script>
<script type="text/javascript" src="js/Taxon.js"></script>
<script type="text/javascript" src="js/Maintain.js"></script>
<script type="text/javascript" src="js/specimen.sliding.form.js"></script>
<link rel="stylesheet" type="text/css" href="css/specimen.sliding.form.css"/>
<link rel="stylesheet" href="http://www.emposha.com/demo/fcbkcomplete_2/style.css" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" src="js/jquery.fcbkcomplete.js"></script>

<style type="text/css">
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
    // Arrays para armazenar listas de NxN
    // Nome padrao: controllerList
    // Inicia configuracoes Javascript
    //Force numeric input

    //Tooltip for NxN fields
    var helpTip = '<div style="font-weight:normal;"><b>ENTRY LIST</b><br />In this field, you can create a list of entries.</div>';

    $(document).ready(bootSpecimen);
    function bootSpecimen(){

        configTaxonTool();

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

        //geocoding($('#GeospatialElementAR_decimallatitude').val(),$('#GeospatialElementAR_decimallongitude').val());
        //configLocation();

    }            
    // Configuracoes iniciais
    function configInitial() {      
        $("#saveBtn").button();
        $("#dialogAlert").dialog({
        	dialogClass: "no-close",
            autoOpen: false,
            resizable: false,
            height:200,
            modal: true,
            beforeopen: function (event, ui) { 
            	$(".no-close .noTitleStuff .ui-dialog-titlebar-close").css("display","none");
             },
             position: {
     			my: "center",
     			at: "center",
     			of: window
     		},
            buttons: {
                
            }
        });
         
        $("#btnGeoreferencing").button();
        // Evento onclick do botao save
        $("#saveBtn").click(function() {
            $('html, body').animate({scrollTop: 0}, 'slow');
            $('#saveBtn').button('option', 'label', 'Processing');
            $('#saveBtn').attr('checked', true);
           
            saveTaxon();
        });
        //$("#btnGeoreferencing").click(function() {
        //georeferencing();
        //});
        //reverseGeocoding();
        //$("#bgtBtn").button();
        // Evento onclick do botao save
        //$("#bgtBtn").click(function() {
        //    openBGT();
        //});
    }
    //var listNN = new Array();
    // Acao de salva
    
    
    function save(){
        if($("#TaxonomicElementAR_idmorphospecies").val() == '' && $("#MorphospeciesAR_morphospecies").val() != '') {
            $.ajax({ type:'POST',
                url:'index.php?r=morphospecies/save',
                data: {
                    "field": $("#MorphospeciesAR_morphospecies").val()
                },
                dataType: "json",
                beforeSend: function(){
                	
                 },
                success:function(json) {
                    if(json.success) {
                        $("#TaxonomicElementAR_idmorphospecies").val(json.id);
                    }
                    $.ajax({ type:'POST',
                        url:'index.php?r=specimen/save',
                        data: $("#form").serialize(),
                        dataType: "json",
                        success:function(json) {
                            if(json.success) {
                                if ($('#SpecimenAR_idspecimen').val() == '') {
                                    $('#OccurrenceElementAR_catalognumber').val('');
                                }                      
                                saveSpecimenNN(json.ar.idrecordlevelelement, json.ar.idlocalityelement, json.ar.idoccurrenceelement, json.ar.ididentificationelement)
                                saveRelatedNN(json.ar.idspecimen, "Specimen", 'reference', refActionList);
                                saveRelatedNN(json.ar.idspecimen, "Specimen", 'media', mediaActionList);
                            }

                            showMessage(json.msg, json.success, false);
                            $("#saveBtn").button("option", "label", "Save" );
                            $('#saveBtn').attr("checked", false);
                            $("#saveBtn").button("refresh");

                            $("#dialogAlert").dialog('close');
                            
                            //Hide taxonomic tip
                            $('#taxsuggest').poshytip('hide').poshytip('destroy').replaceWith('');
                        }
                    });
                }
            });
        }else{
            $.ajax({ type:'POST',
                url:'index.php?r=specimen/save',
                data: $("#form").serialize(),
                dataType: "json",
                beforeSend: function(){
                	///$("#contentDialogAlert").html('Please Wait...');
                	
                	$("#dialogAlert").dialog('open');
                	$(".ui-dialog-titlebar").hide();
                 },
                success:function(json) {
                    if(json.success) {
                        if ($('#SpecimenAR_idspecimen').val() == '') {
                            $('#OccurrenceElementAR_catalognumber').val('');
                        }                      
                        saveSpecimenNN(json.ar.idrecordlevelelement, json.ar.idlocalityelement, json.ar.idoccurrenceelement, json.ar.ididentificationelement)
                        saveRelatedNN(json.ar.idspecimen, "Specimen", 'reference', refActionList);
                        saveRelatedNN(json.ar.idspecimen, "Specimen", 'media', mediaActionList);
                    }

                    showMessage(json.msg, json.success, false);
                    $("#saveBtn").button("option", "label", "Save" );
                    $('#saveBtn').attr("checked", false);
                    $("#saveBtn").button("refresh");

                    //Hide taxonomic tip
                    $('#taxsuggest').poshytip('hide').poshytip('destroy').replaceWith('');
                    $("#dialogAlert").dialog('close');
                    
                }
            });
        }
        
    }
    function configAccordion() {
        // Cria accordions apartir das divs
        $( "#taxonomicElementsAccordion").accordion({collapsible: true,autoHeight: false,navigation: true});
        $( "#geospatialElementsAccordion" ).accordion({collapsible: true,autoHeight: false,navigation: true});
        $( "#localityElementsAccordion" ).accordion({collapsible: true,autoHeight: false,navigation: true});
        $( "#recordLevelElementsAccordion" ).accordion({collapsible: true,autoHeight: false,navigation: true});
        $( "#occurrenceElementsAccordion" ).accordion({collapsible: true,autoHeight: false,navigation: true});
        $( "#eventElementsAccordion" ).accordion({collapsible: true,autoHeight: false,navigation: true});
        //$( "#curatorialElementsAccordion" ).accordion({collapsible: true,autoHeight: false,navigation: true});
        $( "#identificationElementsAccordion" ).accordion({collapsible: true,autoHeight: false,navigation: true});
        $( "#specimenMediaAccordion" ).accordion({collapsible: true,autoHeight: false,navigation: true});
        $( "#specimenReferenceAccordion" ).accordion({collapsible: true,autoHeight: false,navigation: true});
        
        // Fecha todas
        $( "#taxonomicElementsAccordion").accordion("activate" ,false);
        $( "#geospatialElementsAccordion" ).accordion("activate" ,false);
        $( "#localityElementsAccordion" ).accordion("activate" ,false);
        $( "#recordLevelElementsAccordion" ).accordion("activate" ,false);
        $( "#occurrenceElementsAccordion" ).accordion("activate" ,false);
        $( "#eventElementsAccordion" ).accordion("activate" ,false);
        //$( "#curatorialElementsAccordion" ).accordion("activate" ,false);
        $( "#identificationElementsAccordion" ).accordion("activate" ,false);
        $( "#specimenMediaAccordion" ).accordion("activate" ,false);
        $( "#specimenReferenceAccordion" ).accordion("activate" ,false);
    }

    function showTaxonomicTip(kingdom, phylum, class_, order, family, genus, subgenus, specificepithet, infraspecificepithet)
    {
        $('#taxsuggest').poshytip('hide');
        $('#taxsuggest').poshytip('destroy');

        //Clear the entries if null
        if (kingdom == null)
        {kingdom = '';}
        if (phylum == null)
        {phylum = '';}
        if (class_ == null)
        {class_ = '';}
        if (order == null)
        {order = '';}
        if (family == null)
        {family = '';}
        if (genus == null)
        {genus = '';}
        if (subgenus == null)
        {subgenus = '';}
        if (specificepithet == null)
        {specificepithet = '';}
        if (infraspecificepithet == null)
        {infraspecificepithet = '';}

        var tip = '<div style="font-weight:normal;"><div class="tipKey">Kingdom</div><div class="tipValue">'+kingdom+'</div><div style="clear:both"></div><div class="tipKey">Phylum</div><div class="tipValue">'+phylum+'</div><div style="clear:both"></div><div class="tipKey">Class</div><div class="tipValue">'+class_+'</div><div style="clear:both"></div><div class="tipKey">Order</div><div class="tipValue">'+order+'</div><div style="clear:both"></div><div class="tipKey">Family</div><div class="tipValue">'+family+'</div><div style="clear:both"></div><div class="tipKey">Genus</div><div class="tipValue">'+genus+'</div><div style="clear:both"></div><div class="tipKey">Subgenus</div><div class="tipValue">'+subgenus+'</div><div style="clear:both"></div><div class="tipKey">Specific Epithet</div><div class="tipValue">'+specificepithet+'</div><div style="clear:both"></div><div class="tipKey">Infraspecific Epithet</div><div class="tipValue">'+infraspecificepithet+'</div><div style="clear:both"></div></div>';

        $('#taxsuggest').poshytip({
            className: 'tip-twitter',
            showTimeout: 500,
            alignTo: 'target',
            alignX: 50,
            alignY: 50,
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

   
    
</script>

<div id="dialogAlert"  style="display:none;">
	
	<div id="contentDialogAlert"  style="font-size:30px; text-align:center"> <br/>  <?php echo CHtml::image('images/29.gif', '', array('border' => '0px'))?> Please Wait...</div>
</div>

<div id="Notification"></div>

<div class="introText">
    <h1><?php echo $spm->idspecimen != null ? Yii::t('yii', 'Update an existing specimen record') : Yii::t('yii', 'Create a new specimen record'); ?></h1>
    <p><?php echo Yii::t('yii', "Use this tool to save records based on modern biological specimens' information, their spatiotemporal occurrence, and their supporting evidence housed in collections (physical or digital). This set of fields is based on international standards, such as Darwin Core, Dublin Core and their extensions."); ?><BR></p>

    <div class="attention">
        <?php echo CHtml::image('images/main/attention.png', '', array('border' => '0px')) . "&nbsp;" . Yii::t('yii', "Main Fields"); ?>
        (<span style="color: red; font-weight: bold;"><?php echo Yii::t('yii', "Fields with * are required"); ?></span>)
    </div>
</div>



<div class="yiiForm" style="width:90%; margin-bottom:20px; margin-left:100px;">
    <div id="contentSpecimen">
        <div id="wrapperSpecimen">
            <div id="steps">

                <?php echo CHtml::beginForm('', 'post', array('id' => 'form')); ?>
                <?php echo CHtml::activeHiddenField($spm, 'idspecimen'); ?>
                <?php echo CHtml::activeHiddenField($spm, 'idrecordlevelelement'); ?>
                <?php echo CHtml::activeHiddenField($spm, 'idoccurrenceelement'); ?>
                <?php echo CHtml::activeHiddenField($spm, 'ididentificationelement'); ?>
                <?php echo CHtml::activeHiddenField($spm, 'ideventelement'); ?>
                <?php echo CHtml::activeHiddenField($spm, 'idtaxonomicelement'); ?>
                <?php echo CHtml::activeHiddenField($spm, 'idlocalityelement'); ?>
                <?php echo CHtml::activeHiddenField($spm, 'idgeospatialelement'); ?>
                <div class="staticMap">
                </div>
                <fieldset class="step">
                    <legend>Record-level Elements</legend>
                    <div>
                        <?php
                        echo Yii::app()->controller->renderPartial('/recordlevelelement/maintain', array(
                            'recordLevelElement' => $spm->recordlevelelement,
                        ));
                        ?>
                    </div>
                </fieldset>
                <fieldset class="step">
                    <legend>Taxonomic Elements</legend>
                    <div>
                        <?php
                        echo Yii::app()->controller->renderPartial('/taxonomictool/maintain', array(
                            'taxonomicElement' => $spm->taxonomicelement,
                        ));
                        ?>
                    </div>
                </fieldset>
                <fieldset class="step">
                    <legend>Location Elements</legend>
                    <div>
                        <?php
                        echo Yii::app()->controller->renderPartial('/georeferencingtool/maintain', array(
                            'localityElement' => $spm->localityelement,
                            'geospatialElement' => $spm->geospatialelement
                        ));
                        ?>
                    </div>
                </fieldset>
                <fieldset class="step">
                    <legend>Occurrence Elements</legend>
                    <div>
                        <?php
                        echo Yii::app()->controller->renderPartial('/occurrenceelement/maintain', array(
                            'occurrenceElement' => $spm->occurrenceelement,
                        ));
                        ?>
                    </div>
                </fieldset>
                <fieldset class="step">
                    <legend>Identification Elements</legend>
                    <div>
                        <?php
                        echo Yii::app()->controller->renderPartial('/identificationelement/maintain', array(
                            'identificationElement' => $spm->identificationelement,
                        ));
                        ?>
                    </div>
                </fieldset>
                <fieldset class="step">
                    <legend>Event Elements</legend>
                    <div>
                        <?php
                        echo Yii::app()->controller->renderPartial('/eventelement/maintain', array(
                            'eventElement' => $spm->eventelement,
                        ));
                        ?>
                    </div>
                </fieldset>
                <fieldset class="step">
                    <legend>Related Media Records</legend>
                    <div>
                        <?php
                        echo Yii::app()->controller->renderPartial('/specimenmedia/maintain', array(
                            'specimenMedia' => $spm,
                        ));
                        ?>
                    </div>
                </fieldset>
                <fieldset class="step">
                    <legend>Related Reference Records</legend>
                    <div>
                        <?php
                        echo Yii::app()->controller->renderPartial('/specimenreference/maintain', array(
                            'specimenRef' => $spm,
                        ));
                        ?>
                    </div>
                </fieldset>
                <?php echo CHtml::endForm(); ?>                 
            </div>
            <div id="navigation" style="display:none;">
                <ul>
                    <li class="selected">
                        <a>Record-level</a>
                    </li>
                    <li>
                        <a>Taxonomic</a>
                    </li>
                    <li>
                        <a>Location</a>
                    </li>
                    <li>
                        <a>Occurrence</a>
                    </li>
                    <li>
                        <a>Identification</a>
                    </li>
                    <li>
                        <a>Event</a>
                    </li>
                    <li>
                        <a>Media</a>
                    </li>
                    <li>
                        <a>Reference</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="saveButton" style="width:84.9%; margin: 10px 0 10px 100px;">
    <input type="checkbox" id="saveBtn" /><label for="saveBtn">Save</label>
</div>

