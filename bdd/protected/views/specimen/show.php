<?php include_once("protected/extensions/config.php"); ?>

<script type="text/javascript" src="js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="js/validation/jquery.numeric.pack.js"></script>
<script type="text/javascript" src="js/jquery.jstepper.js"></script>
<script type="text/javascript" src="js/loadfields.js"></script>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/Geo.js"></script>
<script type="text/javascript" src="js/Taxon.js"></script>
<script type="text/javascript" src="js/Maintain.js"></script>
<!--<script type="text/javascript" src="js/specimen.sliding.form.js"></script>
<link rel="stylesheet" type="text/css" href="css/specimen.sliding.form.css"/>-->
<link rel="stylesheet" href="http://www.emposha.com/demo/fcbkcomplete_2/style.css" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" src="js/jquery.fcbkcomplete.js"></script>

<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="js/jquery.color.js"></script>
<!--<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>-->
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
    #taxonomicHierarchy {
        background-color: whiteSmoke;
        border: 2px solid #CCC;
        border-radius: 10px 10px 10px 10px;
        margin-bottom: 10px;
        margin-top: 10px;
        padding: 11px 11px;
    }
    #taxonomicHierarchy table {
        background-color: transparent;
        width: 500px;
        position: relative;
        top: 50%;
        left: 50%;
        margin-left: -250px;
    }
    .table-leftcel {
        text-align: right;
        width: 225px;
        font-weight: bold;
    }
    .table-middlecel {
        text-align: center;
    }
    .table-rightcel {
        width: 225px;
        text-align: left;
    }
    #tableLocality-leftcel {
        text-align: right;
        font-weight: bold;
        padding-top: 5px;
        padding-bottom: 5px;
        width: 130px;
    }
    #tableLocality-middlecel {
        text-align: center;
        padding-top: 5px;
        padding-bottom: 5px;
    }
    #tableLocality-rightcel {
        text-align: left;
        padding-top: 5px;
        padding-bottom: 5px;
    }
    #recordOccurrenceInfo table {
        border-collapse: collapse;
        text-align: center;
        font-size: 10pt;
    }
    #recordOccurrenceInfo table th {
        font-weight: bold;
        color: #852;
        background-color: #F4EFD9;
        border: 1px solid #F6A828;
        padding: 4px;
    }
    #recordOccurrenceInfo table td {
        border: 1px solid #DDD;
        padding: 3px;
    }
    #locationMap {
	    width:400px; 
	    height: 300px;
	    position:relative; 
	    float:left;
	    margin-top:10px; 
	    margin-bottom:10px;
    }
    #locationInfo {
        background-color: #F4EFD9;
        border: 1px solid #F6A828;
        border-radius: 10px 10px 10px 10px;
        margin-bottom: 10px;
        margin-top: 10px;
        padding: 11px 11px;
        position: relative;
        float: left;
        margin-left: 15px;
        width: 235px;
        height: 276px;
    }
    .fieldsTable {
	    width: 580px;
	    margin-left: 20px;
    }
    .mainFieldsTable {
	    width: 580px;
	    margin-left: 20px;
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
        configHideShowButtons();
        buildHierarchyTree();
        recordOccurrenceInfo();
        locationInfo();
        configMap();
        configEditButton();
        
        configPrintBtn();
        //geocoding($('#GeospatialElementAR_decimallatitude').val(),$('#GeospatialElementAR_decimallongitude').val());
        //configLocation();

    }
    

    function configMap(){
        
        var latitude = $("#decimallatituderow td.tablefieldcel").html();
        var longitude = $("#decimallongituderow td.tablefieldcel").html();
        var latlng = new google.maps.LatLng(latitude, longitude);
        var divc = document.getElementById('locationMap');
        
        var map = new google.maps.Map(divc, {
            center: latlng,
            zoom: 12,
            mapTypeId: google.maps.MapTypeId.SATELLITE
        });
        
        var marker = new google.maps.Marker({
            position: latlng,
            map: map
        });
        
    }
    // Configuracoes iniciais
    function configInitial() {      
        $("#saveBtn").button();
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
        $( "#taxonomicElementsAccordion").accordion("activate" ,true);
        $( "#geospatialElementsAccordion" ).accordion("activate" ,true);
        $( "#localityElementsAccordion" ).accordion("activate" ,true);
        $( "#recordLevelElementsAccordion" ).accordion("activate" ,true);
        $( "#occurrenceElementsAccordion" ).accordion("activate" ,true);
        $( "#eventElementsAccordion" ).accordion("activate" ,true);
        //$( "#curatorialElementsAccordion" ).accordion("activate" ,false);
        $( "#identificationElementsAccordion" ).accordion("activate" ,true);
        $( "#specimenMediaAccordion" ).accordion("activate" ,true);
        $( "#specimenReferenceAccordion" ).accordion("activate" ,true);
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
    
    function configHideShowButtons() {
        $("#hide").click(function(){
            $("td.tablefieldcel:empty").parent().hide();
            hideEmptyBlocks();
            $("#hide").hide();
            $("#show").show();
        });
        $("#show").click(function(){
            showEmptyBlocks();
            $("td.tablefieldcel:empty").parent().show();
            // morphospeciesrow remains hidden if it is empty
            if($("tr#morphospeciesrow td.tablefieldcel").html() == '') {
                $("#morphospeciesrow").hide();
            }
            $("#hide").show();
            $("#show").hide();
        });
        
        //empty fields starts hidden
        $("td.tablefieldcel:empty").parent().hide();
        hideEmptyBlocks();
        $("#hide").hide();
        $("#show").show();
    }
    
    function configEditButton() {
         $("#editButton").click(function(){
             window.location = "index.php?r=specimen/goToMaintain&id="+$("#SpecimenAR_idspecimen").val();
         });
    }
    
    function hideEmptyBlocks() {
        // recordlevelelement has 4 blocks
        for (i = 1; i < 5; i++) {
            if($.trim($("#recordlevelblock_"+i+" > tbody > tr > td.tablefieldcel:parent").html())=='') {
                $("#recordlevelblock_"+i+"").hide();
            }
        }
        // taxonomic has 4 blocks
        for (i = 1; i < 5; i++) {
            if($.trim($("#taxonomicblock_"+i+" > tbody > tr > td.tablefieldcel:parent").html())=='') {
                $("#taxonomicblock_"+i+"").hide();
            }
        }
        // location elements has 14 blocks
        for (i = 1; i < 15; i++) {
            if($.trim($("#locationelementsblock_"+i+" > tbody > tr > td.tablefieldcel:parent").html())=='') {
                $("#locationelementsblock_"+i+"").hide();
            }
        }
        if($.trim($("#locationelementsblock_1 > tbody > tr > td.tablefieldcel:parent").html())=='') {
                $(".mainFieldsTable").hide();
        }
        // occurrence elements has 3 blocks
        for (i = 1; i < 4; i++) {
            if($.trim($("#occurrenceelementsblock_"+i+" > tbody > tr > td.tablefieldcel:parent").html())=='') {
                $("#occurrenceelementsblock_"+i+"").hide();
            }
        }
        // identification elements has 1 block
        if($.trim($("#identificationelementsblock_1 > tbody > tr > td.tablefieldcel:parent").html())=='') {
            $("#identificationelementsblock_1").hide();
        }
        // event elements has 1 block
        if($.trim($("#eventelementsblock_1 > tbody > tr > td.tablefieldcel:parent").html())=='') {
            $("#eventelementsblock_1").hide();
        }
    }
    function showEmptyBlocks() {
        // record level has 5 blocks
        for (i = 1; i < 6; i++) {
            $("#recordlevelblock_"+i+"").show();
        }
        // taxonomic has 4 blocks
        for (i = 1; i < 5; i++) {
            $("#taxonomicblock_"+i+"").show();
        }
        // location elements has 14 blocks
        for (i = 1; i < 15; i++) {
            $("#locationelementsblock_"+i+"").show();
        }
        $(".mainFieldsTable").show();
        // occurrence elements has 3 blocks
        for (i = 1; i < 4; i++) {
            $("#occurrenceelementsblock_"+i+"").show();
        }
        // identification elements has 1 block
        $("#identificationelementsblock_1").show();
        // event elements has 1 block
        $("#eventelementsblock_1").show();
    }
    
    function buildHierarchyTree() {
        var taxonomicHierarchy = new Object();
        taxonomicHierarchy['Kingdom'] = $("tr#kingdomrow td.tablefieldcel").html();
        taxonomicHierarchy['Phylum'] = $("tr#phylumrow td.tablefieldcel").html();
        taxonomicHierarchy['Class'] = $("tr#classrow td.tablefieldcel").html();
        taxonomicHierarchy['Order'] = $("tr#orderrow td.tablefieldcel").html();
        taxonomicHierarchy['Family'] = $("tr#familyrow td.tablefieldcel").html();
        taxonomicHierarchy['Genus'] = $("tr#genusrow td.tablefieldcel").html();
        taxonomicHierarchy['Subgenus'] = $("tr#subgenusrow td.tablefieldcel").html();
        taxonomicHierarchy['Specific epithet'] = $("tr#specificepithetrow td.tablefieldcel").html();
        taxonomicHierarchy['Infraspecific epithet'] = $("tr#intraspecificepithetrow td.tablefieldcel").html();
        taxonomicHierarchy['Scientific name'] = $("tr#scientificnamerow td.tablefieldcel").html();
        
        if (taxonomicHierarchy['Scientific name'] != '') $("#moreSpecificTaxon").append(taxonomicHierarchy['Scientific name'] + ' (Scientific name)' );
        else if (taxonomicHierarchy['Infraspecific epithet'] != '') $("#moreSpecificTaxon").append(taxonomicHierarchy['Infraspecific epithet'] + ' (Infraspecific epithet)');
        else if (taxonomicHierarchy['Specific epithet'] != '') $("#moreSpecificTaxon").append(taxonomicHierarchy['Specific epithet'] + ' (Specific epithet)');
        else if (taxonomicHierarchy['Subgenus'] != '') $("#moreSpecificTaxon").append(taxonomicHierarchy['Subgenus'] + ' (Subgenus)'); 
        else if (taxonomicHierarchy['Genus'] != '') $("#moreSpecificTaxon").append(taxonomicHierarchy['Genus'] + ' (Genus)');
        else if (taxonomicHierarchy['Family'] != '') $("#moreSpecificTaxon").append(taxonomicHierarchy['Family'] + ' (Family)');
        else if (taxonomicHierarchy['Order'] != '') $("#moreSpecificTaxon").append(taxonomicHierarchy['Order'] + ' (Order)');
        else if (taxonomicHierarchy['Class'] != '') $("#moreSpecificTaxon").append(taxonomicHierarchy['Class'] + ' (Class)');
        else if (taxonomicHierarchy['Phylum'] != '') $("#moreSpecificTaxon").append(taxonomicHierarchy['Phylum'] + ' (Phylum)');
        else if (taxonomicHierarchy['Kingdom'] != '') $("#moreSpecificTaxon").append(taxonomicHierarchy['Kingdom'] + ' (Kingdom)');       
        
        for (var k in taxonomicHierarchy) {
            if (taxonomicHierarchy[k] != '') {
                $("#taxonomicHierarchy table").append('<tr><td class="table-leftcel">' + k + '</td><td class="table-middlecel"> : </td><td class="table-rightcel">' + taxonomicHierarchy[k] + '</td></tr>');
            }
        }   
    }
    
    
    function recordOccurrenceInfo() {
        var recordOccurrenceInfo = new Object();
        recordOccurrenceInfo['Basis of record'] = $("#basisofrecordrow td.tablefieldcel").html();
        recordOccurrenceInfo['Institution code'] = $("#institutioncoderow td.tablefieldcel").html();
        recordOccurrenceInfo['Collection code'] = $("#collectioncoderow td.tablefieldcel").html();
        recordOccurrenceInfo['Catalog number'] = $("#catalognumberrow td.tablefieldcel").html();
        
        $("#recordOccurrenceInfo table").append('<tr><td>' + recordOccurrenceInfo['Basis of record'] + '</td><td>' + recordOccurrenceInfo['Institution code'] + '</td><td>' + recordOccurrenceInfo['Collection code'] + '</td><td>' + recordOccurrenceInfo['Catalog number'] + '</td></tr>');
    }
    
    function locationInfo() {
        var locationInfo = new Object();
        locationInfo['Decimal latitude'] = $("#decimallatituderow td.tablefieldcel").html();
        locationInfo['Decimal longitude'] = $("#decimallongituderow td.tablefieldcel").html();
        locationInfo['Coordinate uncertainty in meters'] = $("#coordinateuncertaintyinmetersrow td.tablefieldcel").html();
        locationInfo['Geodetic datum'] = $("#geodeticdatumrow td.tablefieldcel").html();
        locationInfo['Country'] = $("#countryrow td.tablefieldcel").html();
        locationInfo['State or province'] = $("#stateprovincerow td.tablefieldcel").html();
        locationInfo['Municipality'] = $("#municipalityrow td.tablefieldcel").html();
        locationInfo['Water body'] = $("#waterbodyrow td.tablefieldcel").html();
        
        if (locationInfo['Decimal latitude'] == "" || locationInfo['Decimal longitude'] == "") {
	    	$("#locationMap").hide();
	    	$("#locationInfo").hide(); 
        } else {
	        for (var k in  locationInfo) {
	            if ( locationInfo[k] != '') {
	                $("#locationInfo table").append('<tr><td id="tableLocality-leftcel">' + k + '</td><td id="tableLocality-middlecel"> : </td><td id="tableLocality-rightcel">' +  locationInfo[k] + '</td></tr>');
	            }
	        }
	        //$("#locationMap").html('<img id="staticMap" src="http://maps.google.com/maps/api/staticmap?center='+locationInfo['Decimal latitude']+','+locationInfo['Decimal longitude']+'&zoom=10&maptype=satellite&size=500x300&sensor=false"></img>');
        }
    }
    
    function configPrintBtn() {
	    $("#printButton").click(function() {
	    	var windowReference = window.open('index.php?r=loadingfile/goToShow');
		   //printPDF(<?php echo $spm->idspecimen?>); 
		   $.ajax({ type:'GET',
                    url:'index.php?r=specimen/print',
                    data: {
                    	"id": $('#SpecimenAR_idspecimen').val()
                    },
                    dataType: "json",
                    success:function(json) {
                    	windowReference.location = json;
                    }
           });

	    });
    }
    
    function printPDF(idspm) {
    	window.open("index.php?r=specimen/goToPrint&id="+idspm);
    }
    
</script>

<div id="Notification"></div>

<div class="introText">
    <h1><?php echo Yii::t('yii', 'View an existing specimen record');?></h1>
    <p><?php echo Yii::t('yii', "Use this tool to view records based on modern biological specimens' information, their spatiotemporal occurrence, and their supporting evidence housed in collections (physical or digital). This set of fields is based on international standards, such as Darwin Core, Dublin Core and their extensions."); ?><BR></p>

    <div class="attention">
        <?php echo CHtml::image('images/main/attention.png', '', array('border' => '0px')) . "&nbsp;" . Yii::t('yii', "Main Fields"); ?>
        (<span style="color: red; font-weight: bold;"><?php echo Yii::t('yii', "Fields with * are required"); ?></span>)
    </div>
</div>

<div class="yiiForm" style="width:85%;">
	
	<div id="mainInfo" class="introText">
	    <div id="moreSpecificTaxon" style="font-size: 16px; color: green; text-align: left; letter-spacing: 1px; font-weight: bold; margin-top:20px;"></div>
	    
	    <div id="taxonomicHierarchy">
	        <table></table>
	    </div>
	    <div style="clear:both"></div>
	    
	    <div id="recordOccurrenceInfo">
	        <table style="width:100%">
	            <tr>
	                <th>Basis of record</th>
	                <th>Institution code</th>
	                <th>Collection code</th>
	                <th>Catalog number</th>
	            </tr>
	        </table>
	    </div>
	    <div style="clear:both"></div>
	    
	    <div id="locationMap"></div>
	    <div id="locationInfo">
	        <table style="background-color:transparent; margin-top: 25px; width: 95%;"></table>
	    </div>
	    <div style="clear:both"></div>
	
	</div>
	<div id="showHideBtn" class="saveButton" style="clear:both; width:88.6%;">
	    <button id="show" style="margin-right:40%;">Show empty fields</button>
	    <button id="hide" style="margin-right:40%;">Hide empty fields</button>
	</div>
	
	<div class="yiiForm" style="width:90%;">
	
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
	    <div class="tablerow"  id="recordLevelElementsAccordion">
	        <h3><a href="#">Record-level</a></h3>
	        <div>
	            <?php
	            echo Yii::app()->controller->renderPartial('/recordlevelelement/show', array(
	                'recordLevelElement' => $spm->recordlevelelement,
	            ));
	            ?>
	        </div>
	    </div>
	    <div class="tablerow"  id="taxonomicElementsAccordion">
	        <h3><a href="#">Taxonomic</a></h3>
	        <div>
	            <?php
	            echo Yii::app()->controller->renderPartial('/taxonomictool/show', array(
	                'taxonomicElement' => $spm->taxonomicelement,
	            ));
	            ?>
	        </div>
	    </div>
	    <div class="tablerow"  id="localityElementsAccordion">
	        <h3><a href="#">Location Elements</a></h3>
	        <div>
	            <?php
	            echo Yii::app()->controller->renderPartial('/georeferencingtool/show', array(
	                'localityElement' => $spm->localityelement,
	                'geospatialElement' => $spm->geospatialelement
	            ));
	            ?>
	        </div>
	    </div>
	    <div  id="occurrenceElementsAccordion">
	        <h3><a href="#">Occurrence Elements</a></h3>
	        <div>
	            <?php
	            echo Yii::app()->controller->renderPartial('/occurrenceelement/show', array(
	                'occurrenceElement' => $spm->occurrenceelement,
	            ));
	            ?>
	        </div>
	    </div>
	    <div class="tablerow"  id="identificationElementsAccordion">
	        <h3><a href="#">Identification Elements</a></h3>
	        <div>
	            <?php
	            echo Yii::app()->controller->renderPartial('/identificationelement/show', array(
	                'identificationElement' => $spm->identificationelement,
	            ));
	            ?>
	        </div>
	    </div>                
	    <div class="tablerow"  id="eventElementsAccordion">
	        <h3><a href="#">Event Elements</a></h3>
	        <div>
	            <?php
	            echo Yii::app()->controller->renderPartial('/eventelement/show', array(
	                'eventElement' => $spm->eventelement,
	            ));
	            ?>
	        </div>
	    </div>
	    <div class="tablerow"  id="specimenMediaAccordion">
	        <h3><a href="#">Related Media Records</a></h3>
	        <div>
	            <?php
	            echo Yii::app()->controller->renderPartial('/specimenmedia/show', array(
	                'specimenMedia' => $spm,
	            ));
	            ?>
	        </div>
	    </div>
	    <div class="tablerow"  id="specimenReferenceAccordion">
	        <h3><a href="#">Related Reference Records</a></h3>
	        <div>
	            <?php
	            echo Yii::app()->controller->renderPartial('/specimenreference/show', array(
	                'specimenRef' => $spm,
	            ));
	            ?>
	        </div>
	    </div>
	    <?php echo CHtml::endForm(); ?>  
	    
	    <div class="privateRecord">
	        <div class="title"><?php echo $spm->recordlevelelement->isrestricted ? "This is a private record." : "This is not a private record." ; ?></div>
	        <div class="icon"><?php if ($spm->recordlevelelement->isrestricted) showIcon("Private Record", "ui-icon-locked", 0); else showIcon("Not Private Record", "ui-icon-unlocked", 0) ; ?></div>
	    </div>
	    
	    <div class="saveButton">
	        <div><?php echo CHtml::activeHiddenField($spm, 'idspecimen'); ?></div>
	        <button id="printButton">Print</button>
	        <button id="editButton">Edit</button>
	    </div>
	</div>
</div>