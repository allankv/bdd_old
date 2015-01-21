<?php include_once("protected/extensions/config.php"); ?>
<script type="text/javascript" src="js/lightbox/recordlevelelements.js"></script>
<script type="text/javascript" src="js/deleteelements.js"></script>
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
    $(document).ready(bootInteraction);

    var start = 0;
    var end = 10;
    var max = 10;
    var interval = 10;
    var handleSize = 50;

    // Inicia configuracoes Javascript
    function bootInteraction(){
        configCatComplete('#id','#searchField', 'interaction','#filterList');
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
            url:'index.php?r=interaction/filter',
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

                //Config hover
                configIcons();
            }
        });
    }
    function insertLine(rs){
        var line ='<tr id="id__ID_" title="_TITLE_"><td style="width:20px;text-indent:0;">_ISPRIVATE_</td><td style="padding-left:6px;">_LASTTAXA_1</td><td style="text-align:center;">_CATALOG_1</td><td style="text-align:center;">_INTERACTION_TYPE_</td><td style="padding-left:6px;">_LASTTAXA_2</td><td style="text-align:center;">_CATALOG_2</td><td style="text-align:center;">_BUTTONS_</td></tr>';
        var aux = line;

        //var btnEdit = '<a href="index.php?r=interaction/goToMaintain&id='+rs.id+'"><img src="images/main/edit.png" style="border:0px;" title="Update"/></a> | ';
        //var btnDelete = '<a href="#" onclick="deleteRecord('+rs.id+',\'interaction\');"><img src="images/main/canc.gif" style="border:0px;" title="Delete"/></a> | ';
        //var btnEdit = '<ul id="icons"><li class="optionIcon ui-state-default ui-corner-all" title="Edit Interaction Record"><a href="index.php?r=interaction/goToMaintain&id='+rs.id+'"><span class="ui-icon ui-icon-document"></span></a></li>';
        //var btnDelete = '<li class="optionIcon ui-state-default ui-corner-all" title="Delete Interaction Record"><a href="javascript:deleteInteractionRecord('+rs.id+');"><span class="ui-icon ui-icon-trash"></span></a></li></ul>';
        //var btnRestricted = '<ul id="icons"><li class="ui-state-default ui-corner-all" title="Restricted Interaction Record"><span class="ui-icon ui-icon-locked"></span></a></li></ul>';
        var btnPrivate = "<div class='btnPrivate'><ul class='iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Private Specimen Record'><span class='ui-icon ui-icon-locked'></span></li></ul></div>";
        var btnUpdate = "<div class='btnUpdate';'><a href='index.php?r=interaction/goToMaintain&id="+rs.id+"'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Update Interaction Record'><span class='ui-icon ui-icon-pencil'></span></li></ul></a></div>";
        var btnDelete = "<div class='btnDelete'><a href='javascript:deleteInteractionRecord("+rs.id+");'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Delete Interaction Record'><span class='ui-icon ui-icon-trash'></span></li></ul></a></div><div style='clear:both'></div>";
        var btnShow = "<div class='btnShow' style='margin-left:6px;'><a href='index.php?r=interaction/goToShow&id="+rs.id+"'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Show Interaction Record'><span class='ui-icon ui-icon-search'></span></li></ul></a></div>";

        aux = aux.replace('_ID_',rs.id);//id linha        
        aux = aux.replace('_TITLE_','<h2>Specimen 1</h2>Institution: '+rs.institution1+'<br/>Collection: '+rs.collection1+'<hr/><h2>Specimen 2</h2>Institution: '+rs.institution2+'<br/>Collection: '+rs.collection2);
        aux = aux.replace('_ISPRIVATE_',rs.isrestricted?btnPrivate:'');
        aux = aux.replace('_LASTTAXA_1',rs.scientificname1);
        aux = aux.replace('_LASTTAXA_2',rs.scientificname2);
        aux = aux.replace('_CATALOG_1',rs.catalognumber1);
        aux = aux.replace('_CATALOG_2',rs.catalognumber2);
        aux = aux.replace('_INTERACTION_TYPE_',rs.interactiontype);

        aux = aux.replace('_BUTTONS_',btnShow+btnUpdate+btnDelete);

        $("#lines").append(aux);
        $('#id_'+rs.id).poshytip({
            className: 'tip-twitter',
            showTimeout: 500,
            alignTo: 'target',
            alignX: 'left',
            alignY: 'center',
            offsetX:10,
            content: function(updateCallback) {
                $.ajax({ type:'POST',
                url:'index.php?r=interaction/getTip',
                data: {'idinteraction':rs.id},
                dataType: "json",
                success:function(json) {
                    var interaction = json.sp[0];
                    //Format the tooltip
                    var tooltip = '<div style="color:green">Specimen 1</div><div class="tipDiv"><div class="tipKey">Institution Code</div><div class="tipValue">'+interaction.institutioncode1+'</div><div style="clear:both"></div><div class="tipKey">Collection Code</div><div class="tipValue">'+interaction.collectioncode1+'</div><div style="clear:both"></div></div><div style="color:green; margin-top:10px;">Specimen 2</div><div class="tipDiv"><div class="tipKey">Institution Code</div><div class="tipValue">'+interaction.institutioncode2+'</div><div style="clear:both"></div><div class="tipKey">Collection Code</div><div class="tipValue">'+interaction.collectioncode2+'</div><div style="clear:both"></div></div>';
                    // Call updateCallback() to update the content in the main tooltip
                    updateCallback(tooltip);
                }});

		return '<div class="tipDiv" style="height:98px;">Loading metadata...</div>';
            }
        });        
    }
    function deleteInteractionRecord(idinteraction)
    {
        if( confirm("Are you sure you would like to permanently delete this interaction record?"))
        {
            //Hide poshytip
            $('#id_'+idinteraction).poshytip('hide');
            setTimeout(function(){
                $('#id_'+idinteraction).poshytip('destroy');
            

            //Delete record
            deleteRecord(idinteraction,'interaction');

            //Reload data
            filter('delete');
            }, 500);
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
            url:'index.php?r=interaction/printList',
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
<h1 style="padding-left:10px; float:left;"><?php echo Yii::t('yii', 'List interaction records'); ?></h1>
<div style="clear:both;"></div>
<p><?php echo Yii::t('yii', 'Use this tool to search through all interaction records in the BDD database and view, edit or delete any of them. To begin your search, specify at least the Institution Code and the Collection Code of one of the interacting specimen. Optionally, you may narrow your search by indicating the specimen record’s Basis of Record, the specimen’s Scientific Name, and the Interaction Type.'); ?></p>
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
<?php
echo CHtml::endForm(); ?>

<div id="rs" class="item">
    <table id="tablelist" class="list">
        <thead>
            <tr>
                <th></th>
                <th colspan="2" style="text-align:center;"><?php echo CHtml::encode(Yii::t('yii','Specimen 1')); ?></th>
                <th rowspan="2" style="width:120px;text-align:center;"><?php echo CHtml::encode(Yii::t('yii','Interaction Type')); ?></th>
                <th colspan="2" style="text-align:center;"><?php echo CHtml::encode(Yii::t('yii','Specimen 2')); ?></th>
                <th></th>
            </tr>
            <tr>
                <th></th>
                <th style="text-align:center;"><?php echo CHtml::encode(Yii::t('yii','Taxonomic Element')); ?></th>
                <th style="width:60px;text-align:center;"><?php echo CHtml::encode(Yii::t('yii','Catalog Number')); ?></th>
                <th style="text-align:center;"><?php echo CHtml::encode(Yii::t('yii','Taxonomic Element')); ?></th>
                <th style="width:60px;text-align:center;"><?php echo CHtml::encode(Yii::t('yii','Catalog Number')); ?></th>
                <th style="width:100px;"></th>
            </tr>
        </thead>
        <tbody id="lines">
        <tbody>
    </table>
    <div class="legendbar">
    	<div class="showIconLegend"><?php showIcon("Show Specimen Record", "ui-icon-search", 0); ?></div>
        <div class="showIconLegendText">Show Record</div>
        <div class="updateIconLegend"><?php showIcon("Update Specimen Record", "ui-icon-pencil", 0); ?></div>
        <div class="updateIconLegendText">Update Record</div>
        <div class="deleteIconLegend"><?php showIcon("Delete Specimen Record", "ui-icon-trash", 0); ?></div>
        <div class="deleteIconLegendText">Delete Record</div>
        <div class="privateIconLegend"><?php showIcon("Private Record", "ui-icon-locked", 0); ?></div>
        <div class="privateIconLegendText">Private Record</div>
        <div style="clear:both"></div>
    </div>
</div>