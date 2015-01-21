<?php include_once("protected/extensions/config.php"); ?>
<script type="text/javascript" src="js/List.js"></script>

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
<script>
    $(document).ready(bootSpecies);

    var start = 0;
    var end = 10;
    var max = 10;
    var interval = 10;
    var handleSize = 50;

    // Inicia configuracoes Javascript
    function bootSpecies(){

        configCatComplete('#id','#searchField', 'species','#filterList');
        configIcons();
        filter();
        //slider();
        $("#printButton").button();
        
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
            offsetX: 35
        });
    }
    function filter(senderValue){

        //If it's BOOT or a filter, reset the offset to 0. Otherwise, leave it as is.
        if (senderValue == null)
            {start = 0;}

        $.ajax({ type:'POST',
            url:'index.php?r=species/filter',
            data: {'limit':interval,'offset':start,'list':jFilterList},
            dataType: "json",
            success:function(json) {
                var rs = new Object();
                $("#lines").html('');

                //Get values for the slider
                max = parseInt(json.count);

                if (start > max)
                    {start = 0;}

                $('#start').html(start);

                end = start + interval;

                if (end>max)
                        {end = max;}

                $('#end').html(end);
                $('#max').html(max);

                //max = parseInt(json.count);
                //$('#start').html(start>max?0:start);
                //$('#end').html(end>max?max:end);
                //$('#max').html(max);
                slider();
                //$( "#slider" ).slider({range: true,min: 0,max: max,values: [$('#start').html(), $('#end').html()]});

                rs = json.result;

                for(var i in rs){                    
                    insertLine(rs[i]);
                }

                //Config icons for hover effect
                configIcons();
            }
        });
    }
    function insertLine(rs){
        var line ='<tr id="id__ID_" title="_TITLE_"><td style="width:20px; text-indent:0;">_ISPRIVATE_</td><td style="text-indent:5px;">_LASTTAXA_</td><td style="width:120px; text-align:center;">_INSTITUTIONCODE_</td><td style="width:160px; text-align:center; text-indent:0px;">_BUTTONS_</td></tr>';
        var aux = line;

        //var btnRestricted = '<ul id="icons"><li class="ui-state-default ui-corner-all" title="Restricted Specimen Record"><span class="ui-icon ui-icon-locked"></span></a></li></ul>';
        //var btnEdit = '<ul id="icons"><li class="optionIcon ui-state-default ui-corner-all" title="Update Specimen Record"><a href="index.php?r=specimen/goToMaintain&id='+rs.id+'"><span class="ui-icon ui-icon-document"></span></a></li>';
        //var btnDelete = '<li class="optionIcon ui-state-default ui-corner-all" title="Delete Specimen Record"><a href="javascript:deleteSpecimenRecord('+rs.id+');"><span class="ui-icon ui-icon-trash"></span></a></li></ul>';

        var btnPrivate = "<div class='btnPrivate'><ul class='iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Private Species Record'><span class='ui-icon ui-icon-locked'></span></li></ul></div>";
        var btnShow = "<div class='btnShow'><a href='index.php?r=species/goToShow&id="+rs.id+"'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Show Species Record'><span class='ui-icon ui-icon-search'></span></li></ul></a></div>";
        var btnUpdate = "<div class='btnUpdate'><a href='index.php?r=species/goToMaintain&id="+rs.id+"'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Update Species Record'><span class='ui-icon ui-icon-pencil'></span></li></ul></a></div>";
        var btnDelete = "<div class='btnDelete'><a href='javascript:deleteSpeciesRecord("+rs.id+");'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Delete Species Record'><span class='ui-icon ui-icon-trash'></span></li></ul></a></div><div style='clear:both'></div>";        
        
        aux = aux.replace('_ID_',rs.id);
        aux = aux.replace('_TITLE_','Institution: '+rs.institution);
        aux = aux.replace('_ISPRIVATE_',rs.isrestricted?btnPrivate:'');
        aux = aux.replace('_LASTTAXA_',rs.scientificname);
        aux = aux.replace('_INSTITUTIONCODE_',rs.institutioncode);
        aux = aux.replace('_BUTTONS_',btnShow+btnUpdate+btnDelete);

        //var btnEdit = '<a href="index.php?r=specimen/goToMaintain&id='+rs.id+'"><img src="images/main/edit.png" style="border:0px;" title="Update"/></a> | ';
        //var btnReference = '<a href="#"><img src="images/main/doc.png" style="border:0px;" title="References"/></a> | ';
        //var btnMedia = '<a href="#"><img src="images/main/images.gif" style="border:0px;" title="Medias"/></a> | ';
        //var btnInteraction = '<a href="#"><img src="images/main/ic_alvo.gif" style="border:0px;" title="Interaction"/></a> | ';
        //var btnDelete = '<a href="#" onclick="javascript:deleteSpecimenRecord('+rs.id+');"><img src="images/main/canc.gif" style="border:0px;" title="Delete"/></a> | ';


        $("#lines").append(aux);
        $('#id_'+rs.id).poshytip({
            className: 'tip-twitter',
            showTimeout: 500,
            alignTo: 'target',
            alignX: 'left',
            alignY: 'center',
            offsetX:10,
            content: function(updateCallback) {
		$.ajax({    type:'POST',
                            url:'index.php?r=species/getTip',
                            data: {'idspecies':rs.id},
                            dataType: "json",
                            success:function(json) {
                                
                                var species = json.sp[0];

                                var tip = '<div class="tipDiv"><div class="tipKey">Institution Code</div><div class="tipValue">'+species.institutioncode+'</div><div style="clear:both"></div></div>';//<div class="tipKey">Collection Code</div><div class="tipValue">'+species.collectioncode+'</div><div style="clear:both"></div></div>';

                                updateCallback(tip);
                            }
                        });
                return '<div class="tipDiv">Loading metadata...</div>';
            }
        });
    }
    function deleteSpeciesRecord (idspecies)
    {
        if (confirm("Are you sure you would like to permanently delete this species record?"))
            {
                //Remove record
                deleteRecord(idspecies,'species');

                //Hide poshytip
                $('#id_'+idspecies).poshytip('hide');
                setTimeout(function(){
	                $('#id_'+idspecies).poshytip('destroy');
	            }, 500);

                //Refresh data
                filter('delete');
            }
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
    function print() {
    	var windowReference = window.open('index.php?r=loadingfile/goToShow');
	    $.ajax({
        	type:'POST',
            url:'index.php?r=species/printList',
            data: {
            	'list':jFilterList
            },
            dataType: "json",
            success:function(json) {
	            windowReference.location = json;
            }
        });
    }
</script>

<div class="introText">
<div style="float:left;"><?php echo CHtml::image("images/help/iconelist.png"); ?></div>
<h1 style="padding-left:10px; float:left;"><?php echo Yii::t('yii', 'List species records'); ?></h1>
<div style="clear:both;"></div>
<p><?php echo Yii::t('yii', 'Use this tool to search through all species records in the BDD database and edit or delete any of them. Moreover, this tool includes quick links to create and edit links between existing Species Records and one or more Interaction, Reference, and Media Records.'); ?></p>
</div>

<?php echo CHtml::beginForm(); ?>
<div class="filter">
    <div class="filterLabel"><?php echo 'Filter';?></div>
    <div class="filterMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=filter',array('rel'=>'lightbox', 'style'=>'margin: 0px 10px 0px 0px;')); ?></div>
    <div class="filterInterval">
    Filtered from <b><span id="start"></span></b> to <b><span id="end"></span></b> of <b><span id="max"></span></b>
    </div>
    <div style="clear:both"></div>

    <div class="filterField">
    <input type="text" id="searchField" style="border: 1px solid #DDDDDD;background: #FFFFFF;color: #013605;font-size: 1.3em;" />
    <input type="hidden" id="id"/>
    </div>
    <div class="slider" id="slider"></div>
    <div style="clear:both"></div>
    <input id="printButton" type="button" style="float: right;" value="Print" onclick="print()">
    <div style="clear:both"></div>
    <div class="filterList">
    <div id="filterList"></div>
    </div>
</div>
<?php echo CHtml::endForm(); ?>

<div id="rs" class="item">
    <table id="tablelist" class="list"">
        <thead><tr><th></th><th style="text-align:left;">Taxonomic elements</th><th>Institution Code</th><th>Options</th></tr>
        </thead>
        <tbody id="lines"></tbody>
    </table>    
    <div class="legendbar">
    	<div class="showIconLegend"><?php showIcon("Show Species Record", "ui-icon-search", 0); ?></div>
        <div class="showIconLegendText">Show Record</div> 
        <div class="updateIconLegend"><?php showIcon("Update Species Record", "ui-icon-pencil", 0); ?></div>
        <div class="updateIconLegendText">Update Record</div>
        <div class="deleteIconLegend"><?php showIcon("Delete Species Record", "ui-icon-trash", 0); ?></div>
        <div class="deleteIconLegendText">Delete Record</div>
        <div class="privateIconLegend"><?php showIcon("Private Record", "ui-icon-locked", 0); ?></div>
        <div class="privateIconLegendText">Private Record</div>
        <div style="clear:both"></div>
    </div>    
</div>