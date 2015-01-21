<?php include_once("protected/extensions/config.php"); ?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="js/Maintain.js"></script>
<script type="text/javascript" src="js/List.js"></script>
<link rel="stylesheet" type="text/css" href="js/tablesorter/themes/blue/style.css" />

<style type="text/css">
    #slider {
		margin: 10px;
	}
    .ui-autocomplete-category {
        color: orange;
        font-weight: bold;
        padding: .2em .4em;
        margin: .8em 0 .2em;
        line-height: 1.5;
    }
    .ui-autocomplete {
        max-height: 300px;
        overflow-y: auto;
    }
    ul#icons li {
            cursor: pointer;
            float: left;
            list-style: none outside none;
            margin: 2px;
            padding: 4px;
            position: relative;
    }
</style>
<script type="text/javascript">
    var start = 0;
    var end = 10;
    var max = 10;
    var interval = 10;
    var handleSize = 50;

    $(document).ready(bootSpecimen);
    // Inicia configuracoes Javascript
    function bootSpecimen(){
        configCatComplete('#id','#searchField', 'specimen','#filterList');        
        filter();
        //slider();
        configInitial();
        configNotify();
        configIcons();

        //Help message for the filter textbox help tooltip
        var helpTip = '<div style="font-weight:normal;">Use this box to filter the results below. Different terms for different categories (e.g.: Institution Code and Collection Code) will result in an AND search. Different terms for the same category, however, will result in an OR search.</div>';

        //Set the help tooltip for the Filter textbox
        $('#searchField').poshytip({
            className: 'tip-twitter',
            content: helpTip,
            showOn: 'focus',
            alignTo: 'target',
            alignX: 'left',
            alignY: 'center',
            offsetX: 10
        });
    }
    // Configuracoes iniciais
    function configInitial() {
        $("#saveBtn").button();
        // Evento onclick do botao save
        $("#saveBtn").click(function() {
			$('html, body').animate({scrollTop: 0}, 'slow');
            $('#saveBtn').button('option', 'label', 'Processing');
            $('#saveBtn').attr('checked', true);
            save();
        });

        if($('#InteractionAR_idspecimen1').val()=='') {
            $('#interaction').hide('slide');
            $('#interactionLeft').css("opacity", "1");
            $('#interactionMiddle').css("opacity", "0.5");
            $('#interactionRight').css("opacity", "0.5");
        }
        else {
            $('#specimenFilters').hide('slide');
            $('#interaction').hide('slide');
            $('#interactionLeft').css("opacity", "1");
            $('#interactionMiddle').css("opacity", "1");
            $('#interactionRight').css("opacity", "1");
        }
    }
    // Acao de salva
    function save(){
        $.ajax({ type:'POST',
            url:'index.php?r=interaction/save',
            data: $("#form").serialize(),
            dataType: "json",
            success:function(json) {
            	if (json.success) {
	            	if ($('#InteractionAR_idinteraction').val() == '') {
	            		$('#InteractionAR_idinteractiontype').val('');
	            		$('#interactiontype').html('');            		
	                }
                }
           	
                showMessage(json.msg, json.success, false);
                $("#saveBtn").button( "option", "label", "Save" );
                $('#saveBtn').attr('checked', false);
                $("#saveBtn").button("refresh");
                unselectInteraction();
            }
        });
		
    }
    function filter(senderValue){
        //If it's BOOT or a filter, reset the offset to 0. Otherwise, leave it as is.
        if (senderValue == null)
            {start = 0;}
            
        if(($('#InteractionAR_idspecimen1').val()==''||$('#InteractionAR_idspecimen1').val()==null)||($('#InteractionAR_idspecimen2').val()==''||$('#InteractionAR_idspecimen2').val()==null)){
            $.ajax({ type:'POST',
                url:'index.php?r=specimen/filter',
                data: {'limit':interval,'offset':start,'list':jFilterList},
                dataType: "json",
                success:function(json) {
                    var rs = new Object();
                    $("#lines").html('');
                    max = parseInt(json.count);
                    $('#start').html(start>max?0:start);
                    $('#end').html(end>max?max:end);
                    $('#max').html(max);
                    slider();
                    //$( "#slider" ).slider({range: true,min: 0,max: max,values: [$('#start').html(), $('#end').html()]});

                    rs = json.result;
                    for(var i in rs){
                        insertLine(rs[i]);
                    }
                    $("#select").buttonset();
                }
            });
        }
    }
    function selectSpecimen1(id){
        $('#InteractionAR_idspecimen1').val(id);
        $.ajax({ type:'POST',
            url:'index.php?r=specimen/getSpecimen',
            data: {'id':id},
            dataType: "json",
            success:function(json) {
                $('#institutioncode_specimen1').html(json.institutionCode.institutioncode);
                $('#collectioncode_specimen1').html(json.collectionCode.collectioncode);
                $('#catalognumber_specimen1').html(json.occurrenceElement.catalognumber);
                $('#taxon_specimen1').html(json.scientificName.scientificname);
            }
        });
        filter();
		
        if($('#InteractionAR_idinteractiontype').val()=='') {
            if ($('#specimenFilters').css("display") != "none") {
                $('#specimenFilters').hide('slide');
            }
            if ($('#interaction').css("display") == "none") {
                $('#interaction').show('slide');
            }
            $('#interactionLeft').css("opacity", "0.5");
            $('#interactionMiddle').css("opacity", "1");
            $('#interactionRight').css("opacity", "0.5");
        }
        else if($('#InteractionAR_idspecimen2').val()=='') {
            $('#interactionLeft').css("opacity", "0.5");
            $('#interactionMiddle').css("opacity", "0.5");
            $('#interactionRight').css("opacity", "1");
        }
        else {
            if ($('#specimenFilters').css("display") != "none") {
                $('#specimenFilters').hide('slide');
            }
            if ($('#interaction').css("display") != "none") {
                $('#interaction').hide('slide');
            }
            $('#interactionLeft').css("opacity", "1");
            $('#interactionMiddle').css("opacity", "1");
            $('#interactionRight').css("opacity", "1");
        }
    }
    function unselectSpecimen1(){
        $('#InteractionAR_idspecimen1').val('');
        $('#institutioncode_specimen1').html('');
        $('#collectioncode_specimen1').html('');
        $('#catalognumber_specimen1').html('');
        $('#taxon_specimen1').html('');
        filter();
		
        if ($('#specimenFilters').css("display") == "none") {
                $('#specimenFilters').show('slide');
        }
        if ($('#interaction').css("display") != "none") {
                $('#interaction').hide('slide');
        }
        $('#interactionLeft').css("opacity", "1");
        $('#interactionMiddle').css("opacity", "0.5");
        $('#interactionRight').css("opacity", "0.5");
    }
	
    function selectInteraction(){
        $('#interactionrelatedinformation').html($('#InteractionAR_interactionrelatedinformation').val());
        var id = $('#InteractionAR_idinteractiontype').val();
        $.ajax({ type:'POST',
            url:'index.php?r=interaction/getInteractionType',
            data: {'id':id},
            dataType: "json",
            success:function(json) {
                $('#interactiontype').html(json.interactiontype);
            }
        });
		
        if($('#InteractionAR_idspecimen2').val()=='') {
                if ($('#specimenFilters').css("display") == "none") {
                        $('#specimenFilters').show('slide');
                }
                if ($('#interaction').css("display") != "none") {
                        $('#interaction').hide('slide');
                }
                $('#interactionLeft').css("opacity", "0.5");
                $('#interactionMiddle').css("opacity", "0.5");
                $('#interactionRight').css("opacity", "1");
        }
        else {
                if ($('#specimenFilters').css("display") != "none") {
                        $('#specimenFilters').hide('slide');
                }
                if ($('#interaction').css("display") != "none") {
                        $('#interaction').hide('slide');
                }
                $('#interactionLeft').css("opacity", "1");
                $('#interactionMiddle').css("opacity", "1");
                $('#interactionRight').css("opacity", "1");
        }
    }
    function unselectInteraction(){
        if($('#InteractionAR_idspecimen1').val()!='') {
            if ($('#specimenFilters').css("display") != "none") {
                    $('#specimenFilters').hide('slide');
            }
            if ($('#interaction').css("display") == "none") {
                    $('#interaction').show('slide');
            }
            $('#interactionLeft').css("opacity", "0.5");
            $('#interactionMiddle').css("opacity", "1");
            $('#interactionRight').css("opacity", "0.5");
        }
    }
    function selectSpecimen2(id){
        $('#InteractionAR_idspecimen2').val(id);
        $.ajax({ type:'POST',
            url:'index.php?r=specimen/getSpecimen',
            data: {'id':id},
            dataType: "json",
            success:function(json) {
                $('#institutioncode_specimen2').html(json.institutionCode.institutioncode);
                $('#collectioncode_specimen2').html(json.collectionCode.collectioncode);
                $('#catalognumber_specimen2').html(json.occurrenceElement.catalognumber);
                $('#taxon_specimen2').html(json.scientificName.scientificname);
            }
        });
        filter();
        if ($('#specimenFilters').css("display") != "none") {
                $('#specimenFilters').hide('slide');
        }
        if ($('#interaction').css("display") != "none") {
                $('#interaction').hide('slide');
        }
        $('#interactionLeft').css("opacity", "1");
        $('#interactionMiddle').css("opacity", "1");
        $('#interactionRight').css("opacity", "1");
    }
    function unselectSpecimen2(){
        if($('#InteractionAR_idspecimen1').val()!='') {
            $('#InteractionAR_idspecimen2').val('');
            $('#institutioncode_specimen2').html('');
            $('#collectioncode_specimen2').html('');
            $('#catalognumber_specimen2').html('');
            $('#taxon_specimen2').html('');
            filter();

            if ($('#specimenFilters').css("display") == "none") {
                    $('#specimenFilters').show('slide');
            }
            if ($('#interaction').css("display") != "none") {
                    $('#interaction').hide('slide');
            }
            $('#interactionLeft').css("opacity", "0.5");
            $('#interactionMiddle').css("opacity", "0.5");
            $('#interactionRight').css("opacity", "1");
        }
    }
    function unselectSpecimen2FromList() {
        $('#InteractionAR_idspecimen2').val('');
        $('#institutioncode_specimen2').html('');
        $('#collectioncode_specimen2').html('');
        $('#catalognumber_specimen2').html('');
        $('#taxon_specimen2').html('');
        filter();

        $('#interactionLeft').css("opacity", "1");
        $('#interactionMiddle').css("opacity", "0.5");
        $('#interactionRight').css("opacity", "0.5");
    }
    function insertLine(rs){
        var line ='<tr id="gui__ID_"><td style="width:20px;text-indent:0;">_ISPRIVATE_</td><td>_LASTTAXA_</td><td style="width:120px;text-align:center;">_CATALOGNUMBER_</td><td style="width:160px;text-align:center;text-indent:0px;">_BUTTONS_</td></tr>';
        var aux = line;

        var btnPrivate = "<div class='btnPrivate'><ul class='iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Private Specimen Record'><span class='ui-icon ui-icon-locked'></span></li></ul></div>";

        aux = aux.replace('_ID_',rs.id);        
        aux = aux.replace('_ISPRIVATE_',rs.isrestricted?btnPrivate:'');
        
        var taxon;
        if (rs.scientificname != '' && rs.scientificname != null) {
        	taxon = rs.scientificname + " (Scientific Name)";
        }
        else if (rs.infraspecificepithet != '' && rs.infraspecificepithet != null) {
        	taxon = rs.infraspecificepithet + " (Infraspecific Epithet)";
        }
        else if (rs.specificepithet != '' && rs.specificepithet != null) {
        	taxon = rs.specificepithet + " (Specific Epithet)";
        }
        else if (rs.subgenus != '' && rs.subgenus != null) {
        	taxon = rs.subgenus + " (Subgenus)";
        }
        else if (rs.genus != '' && rs.genus != null) {
        	taxon = rs.genus + " (Genus)";
        }
        else if (rs.family != '' && rs.family != null) {
        	taxon = rs.family + " (Family)";
        }
        else if (rs.order != '' && rs.order != null) {
        	taxon = rs.order + " (Order)";
        }
        else if (rs.class != '' && rs.class != null) {
        	taxon = rs.class + " (Class)";
        }
        else if (rs.phylum != '' && rs.phylum != null) {
        	taxon = rs.phylum + " (Phylum)";
        }
        else if (rs.kingdom != '' && rs.kingdom != null) {
        	taxon = rs.kingdom + " (Kingdom)";
        }

        
        aux = aux.replace('_LASTTAXA_',taxon);
        aux = aux.replace('_CATALOGNUMBER_',rs.catalognumber);

        if($('#InteractionAR_idspecimen1').val()==''||$('#InteractionAR_idspecimen1').val()==null){
            if($('#InteractionAR_idspecimen2').val()==rs.id){
                var specimenBtn = '<input type="checkbox" value="list" onclick=\'unselectSpecimen2FromList();\' id="'+rs.id+'" name="select" CHECKED/><label for="'+rs.id+'">Specimen 2</label>';
            }else{
                var specimenBtn = '<input type="checkbox" value="list" onclick=\'selectSpecimen1('+rs.id+');\' id="'+rs.id+'" name="select" /><label for="'+rs.id+'">Specimen 1</label>';
            }
        } else{
            if($('#InteractionAR_idspecimen2').val()==''||$('#InteractionAR_idspecimen2').val()==null){
                if($('#InteractionAR_idspecimen1').val()==rs.id){
                    var specimenBtn = '<input type="checkbox" value="list" onclick=\'unselectSpecimen1();\' id="'+rs.id+'" name="select" CHECKED/><label for="'+rs.id+'">Specimen 1</label>';
                }else{
                    var specimenBtn = '<input type="checkbox" value="list" onclick=\'selectSpecimen2('+rs.id+');\' id="'+rs.id+'" name="select" /><label for="'+rs.id+'">Specimen 2</label>';
                }
            }
        }                
        aux = aux.replace('_BUTTONS_',specimenBtn);

        $("#lines").append(aux);        
    }
    function slider2(){
        $("#slider").slider({
            range: true,
            min: 0,
            max: max,
            values: [start, end],
            stop: function(event, ui) {
                start = ui.values[0];
                end = ui.values[1];
                filter();
            },
            slide:function(event, ui) {
                $('#start').html(ui.values[0]);
                $('#end').html(ui.values[1]);
            }
        });
    }
    function slider(){

        $("#slider").slider({
            range: false,
            min:0,
            max:max - interval,
            value:start,
            stop: function(event, ui) {
                start = ui.value;
                end = start + interval;
                filter('slider');
            },



            slide:function(event, ui) {
                $('#start').html(ui.value);
                $('#end').html((ui.value + interval));
            }
        }).find( ".ui-slider-handle" ).css({
				width: handleSize
			});

    }
</script>

<div id="Notification"></div>

<!-- Texto Introdutorio-->
<div class="introText" style="width:90%;">
    <h1><?php echo $interaction->idinteraction != null?Yii::t('yii','Update an existing interaction record'):Yii::t('yii','Create a new interaction record'); ?></h1>
    <p><?php echo Yii::t('yii','Use this tool to save information regarding the relationship between two occurrence records in the database. To expedite the process, use the search fields to find the specimen records whose interaction you wish to record and specify the Interaction type.'); ?></p>
</div>

<div class="yiiForm" style="width:95%;">

    <?php echo CHtml::beginForm('','post',array ('id'=>'form'));?>
    
    <!-- Specimen 1 -->
    <div id="interactionLeft">
    	<div class="title"><?php echo CHtml::encode(Yii::t('yii','Specimen')); ?> 1</div>
        <div class="icon"><a href="javascript:unselectSpecimen1();"><?php showIcon("Change", "ui-icon-pencil", 1); ?></a></div>
        <div style="clear:both;"></div>
        
        <div class="key"><?php echo Yii::t('yii',"Institution")?></div>
        <div class="value"><span id="institutioncode_specimen1"><?php echo CHtml::encode($interaction->specimen1->recordlevelelement->institutioncode->institutioncode)?></span></div>
        <div style="clear:both;"></div>
        
        <div class="key"><?php echo Yii::t('yii',"Collection")?></div>
        <div class="value"><span id="collectioncode_specimen1"><?php echo CHtml::encode($interaction->specimen1->recordlevelelement->collectioncode->collectioncode)?></span></div>
        <div style="clear:both;"></div>
        
        <div class="key"><?php echo Yii::t('yii',"Catalog Number")?></div>
        <div class="value"><span id="catalognumber_specimen1"><?php echo CHtml::encode($interaction->specimen1->occurrenceelement->catalognumber)?></span></div>
        <div style="clear:both;"></div>
        
        <div class="key"><?php echo Yii::t('yii',"Taxonomic Element")?></div>
        <div class="value"><span id="taxon_specimen1"><?php echo CHtml::encode($interaction->specimen1->taxonomicelement->scientificname->scientificname)?></span></div>
        <div style="clear:both;"></div>
        
		<?php echo CHtml::activeHiddenField($interaction,"idspecimen1")?>
    </div>
    
    <!-- Interaction Get -->
    <div id="interactionMiddle">
    	<div class="title"><?php echo CHtml::encode(Yii::t('yii','Interaction')); ?></div>
        <div class="icon"><a href="javascript:unselectInteraction();"><?php showIcon("Change", "ui-icon-pencil", 1); ?></a></div>
        <div style="clear:both;"></div>
        
        <div class="key"><?php echo CHtml::activeLabel($interaction->interactiontype,'interactiontype'); ?></div>
        <div class="value"><span id="interactiontype"><?php echo CHtml::encode($interaction->interactiontype->interactiontype)?></span></div>
        <div style="clear:both;"></div>
        
        <div class="key"><?php echo CHtml::activeLabel($interaction,'interactionrelatedinformation'); ?></div>
        <div class="value"><span id="interactionrelatedinformation"><?php echo CHtml::encode($interaction->interactionrelatedinformation)?></span></div>
        <div style="clear:both;"></div>
    
        
        <div class="field"><?php //echo CHtml::activeDropDownList($interaction, 'idinteractiontype', CHtml::listData(InteractionTypeAR::model()->findAll(), 'idinteractiontype', 'interactiontype'), array('empty'=>'-'));?></div>
        <div class="label"></div>
        <div class="field"><?php //echo CHtml::activeTextArea($interaction,'interactionrelatedinformation',array('rows'=>8, 'cols'=>150,'style'=>'width:230px;height:60px;')); ?></div>
        
        <?php echo CHtml::activeHiddenField($interaction,"idinteraction")?>
    </div>
    
    <!-- Specimen 2 -->
    <div id="interactionRight">
    	<div class="title"><?php echo CHtml::encode(Yii::t('yii','Specimen')); ?> 2</div>
        <div class="icon"><a href="javascript:unselectSpecimen2();"><?php showIcon("Change", "ui-icon-pencil", 1); ?></a></div>
        <div style="clear:both;"></div>
        
        <div class="key"><?php echo Yii::t('yii',"Institution")?></div>
        <div class="value"><span id="institutioncode_specimen2"><?php echo CHtml::encode($interaction->specimen2->recordlevelelement->institutioncode->institutioncode)?></span></div>
        <div style="clear:both;"></div>
        
        <div class="key"><?php echo Yii::t('yii',"Collection")?></div>
        <div class="value"><span id="collectioncode_specimen2"><?php echo CHtml::encode($interaction->specimen2->recordlevelelement->collectioncode->collectioncode)?></span></div>
        <div style="clear:both;"></div>
        
        <div class="key"><?php echo Yii::t('yii',"Catalog Number")?></div>
        <div class="value"><span id="catalognumber_specimen2"><?php echo CHtml::encode($interaction->specimen2->occurrenceelement->catalognumber)?></span></div>
        <div style="clear:both;"></div>
        
        <div class="key"><?php echo Yii::t('yii',"Taxonomic Element")?></div>
        <div class="value"><span id="taxon_specimen2"><?php echo CHtml::encode($interaction->specimen2->taxonomicelement->scientificname->scientificname)?></span></div>
        <div style="clear:both;"></div>
        
		<?php echo CHtml::activeHiddenField($interaction,"idspecimen2")?>
    </div>
    <div style="clear:both"></div>
    
    <!-- Filters -->
    <div id="specimenFilters">
    <div class="filterLabel" style="margin-left:10px;"><?php echo 'Search';?></div>
    <div class="filterMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=filter',array('rel'=>'lightbox', 'style'=>'margin: 0px 10px 0px 0px;')); ?></div>
    <div class="filterInterval">
    Filtered from <b><span id="start"></span></b> to <b><span id="end"></span></b> of <b><span id="max"></span></b>
    </div>
    <div style="clear:both"></div>

    <div class="filterField">
    <input type="text" id="searchField" style="border: 1px solid #DDDDDD;background: #FFFFFF;color: #013605;font-size: 1.3em;" />
    <input type="hidden" id="id"/>
    </div>
    <div class="slider" id="slider" style="width:560px;"></div>
    <div style="clear:both"></div>
    <div class="filterList">
    <div id="filterList"></div>
    </div>

    <div id="rs">
    <div id="select">
    <table id="tablelist" class="list">
        <thead>
            <tr style="text-align:center;">
                <th></th>
                <th>Taxonomic elements</th>
                <th>Catalog number</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody id="lines"></tbody>
    </table>
    </div>
    </div>

    </div>
    
    <!-- Interaction Set-->
    <div id="interaction">
    
    <div class="interactionFields">
    <div class="key"><?php echo CHtml::activeLabelEx($interaction->interactiontype,'interactiontype'); ?></div>
    <div class="value"><?php echo CHtml::activeDropDownList($interaction, 'idinteractiontype', CHtml::listData(InteractionTypeAR::model()->findAll(), 'idinteractiontype', 'interactiontype'), array('empty'=>'-'));?></div>
    <div style="clear:both;"></div>
    
    <div class="key" style="padding-top:27px;"><?php echo CHtml::activeLabel($interaction,'interactionrelatedinformation'); ?></div>
    <div class="value"><?php echo CHtml::activeTextArea($interaction,'interactionrelatedinformation',array('rows'=>8, 'cols'=>150,'style'=>'width:230px;height:60px;')); ?></div>
    <div style="clear:both;"></div>
    </div>
    
    <div class="icon"><a href="javascript:selectInteraction();"><?php showIcon("Next", "ui-icon-check", 1); ?></a></div>
  
    </div>
    
    <div class="privateRecord">
        <div class="title"><?php echo CHtml::activeCheckBox($interaction, 'isrestricted')."&nbsp;&nbsp;".Yii::t('yii','Check here to make this record private')."&nbsp;&nbsp;"; ?></div>
        <div class="icon" style="right:30%"><?php showIcon("Private Record", "ui-icon-locked", 0); ?></div>
    </div>
    
    <div class="saveButton">
        <input type="checkbox" id="saveBtn" /><label for="saveBtn">Save</label>
    </div>


    <?php echo CHtml::endForm(); ?>
    </div>
<?php
/* Caso algum RecordLevelElement tenha sido selecionado anteriormente, exibe as intera��es relacionadas
if(isset($idrecordlevelelement)) {
    echo Yii::app()->controller->renderPartial('/interactionelements/list', array(
    'interactionelements'=>$interactionelements,
    'interactionelementsList'=>$interactionelementsList,
    'recordlevelelements'=>$recordlevelelements,
    'interactiontypes'=>$interactiontypes,
    'idrecordlevelelement'=>$idrecordlevelelement,
    'pages'=>$pages,
    'exibeControle'=>false,
    'totalRegistros'=>$totalRegistros,
    ));
}*/
?>
