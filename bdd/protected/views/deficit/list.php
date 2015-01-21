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
    $(document).ready(bootDeficit);

    var start = 0;
    var end = 10;
    var max = 10;
    var interval = 10;
    var handleSize = 50;

    // Inicia configuracoes Javascript
    function bootDeficit(){
        configCatComplete('#id','#searchField', 'deficit','#filterList');
        configIcons();
        filter();
        slider();
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
            url:'index.php?r=deficit/filter',
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
        var line ='<tr id="id__ID_" ><td style="width:20px; text-indent:0;">_ISPRIVATE_</td><td style="text-indent:5px;">_COMMONNAME_</td><td style="width:120px; text-align:center;">_FIELDNUMBER_</td><td style="width:160px; text-align:center; text-indent:0px;">_BUTTONS_</td></tr>';
        var aux = line;

        var btnPrivate = "<div class='btnPrivate'><ul class='iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Private Deficit Record'><span class='ui-icon ui-icon-locked'></span></li></ul></div>";
        var btnUpdate = "<div class='btnUpdate'><a href='index.php?r=deficit/goToMaintain&id="+rs.iddeficit+"'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Update Deficit Record'><span class='ui-icon ui-icon-pencil'></span></li></ul></a></div>";
        var btnDelete = "<div class='btnDelete'><a href='javascript:deleteDeficitRecord("+rs.iddeficit+");'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Delete Deficit Record'><span class='ui-icon ui-icon-trash'></span></li></ul></a></div><div style='clear:both'></div>";
        var btnShow = "<div class='btnShow'><a href='index.php?r=deficit/goToShow&id="+rs.iddeficit+"'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Show Deficit Record'><span class='ui-icon ui-icon-search'></span></li></ul></a></div>";
        
        aux = aux.replace('_ID_',rs.iddeficit);
        aux = aux.replace('_FIELDNUMBER_',rs.fieldnumber==null?'':rs.fieldnumber);
        aux = aux.replace('_ISPRIVATE_',rs.isrestricted?btnPrivate:'');
        aux = aux.replace('_COMMONNAME_',rs.commonnamefocalcrop==null?'':rs.commonnamefocalcrop);      
        aux = aux.replace('_BUTTONS_',btnShow+btnUpdate+btnDelete);

        //var btnEdit = '<a href="index.php?r=deficit/goToMaintain&id='+rs.id+'"><img src="images/main/edit.png" style="border:0px;" title="Update"/></a> | ';
        //var btnReference = '<a href="#"><img src="images/main/doc.png" style="border:0px;" title="References"/></a> | ';
        //var btnMedia = '<a href="#"><img src="images/main/images.gif" style="border:0px;" title="Medias"/></a> | ';
        //var btnInteraction = '<a href="#"><img src="images/main/ic_alvo.gif" style="border:0px;" title="Interaction"/></a> | ';
        //var btnDelete = '<a href="#" onclick="javascript:deleteDeficitRecord('+rs.id+');"><img src="images/main/canc.gif" style="border:0px;" title="Delete"/></a> | ';


        $("#lines").append(aux);
        $('#id_'+rs.iddeficit).poshytip({
            className: 'tip-twitter',
            showTimeout: 500,
            alignTo: 'target',
            alignX: 'left',
            alignY: 'center',
            offsetX:10,
            content: function(updateCallback) {
		$.ajax({    type:'POST',
                            url:'index.php?r=deficit/getTip',
                            data: {'iddeficit':rs.iddeficit},
                            dataType: "json",
                            success:function(json) {
                                
                                var deficit = json.sp[0];

                                var tip = '<div class="tipDiv">'+(deficit.country==null?'':'<div class="tipKey">Country</div><div class="tipValue">'+deficit.country+'</div><div style="clear:both"></div>')+
                                
                                (deficit.stateprovince==null?'':'<div class="tipKey">State or Province</div><div class="tipValue">'+deficit.stateprovince+'</div><div style="clear:both"></div>')+
                                (deficit.county==null?'':'<div class="tipKey">County</div><div class="tipValue">'+deficit.county+'</div><div style="clear:both"></div>')+
                                (deficit.municipality==null?'':'<div class="tipKey">Municipality</div><div class="tipValue">'+deficit.municipality+'</div><div style="clear:both"></div>')+
                                (deficit.locality==null?'':'<div class="tipKey">Locality</div><div class="tipValue">'+deficit.locality+'</div><div style="clear:both"></div>')+
                                (deficit.site_==null?'':'<div class="tipKey">Site</div><div class="tipValue">'+deficit.site_+'</div><div style="clear:both"></div>')+
                                (deficit.scientificname==null?'':'<div class="tipKey">Scientific Name</div><div class="tipValue">'+deficit.scientificname+'</div><div style="clear:both"></div>');

                                updateCallback(tip);
                            }
                        });
                return '<div class="tipDiv">Loading metadata...</div>';
            }
        });
    }
    function deleteDeficitRecord (iddeficit)
    {
        if (confirm("Are you sure you would like to permanently delete this deficit record?"))
            {
                //Remove record
                deleteRecord(iddeficit,'deficit');

                //Hide poshytip
                $('#id_'+iddeficit).poshytip('hide');
                setTimeout(function(){
	                $('#id_'+iddeficit).poshytip('destroy');
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
            url:'index.php?r=deficit/printList',
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
<h1 style="padding-left:10px; float:left;"><?php echo Yii::t('yii', 'List deficit records'); ?></h1>
<div style="clear:both;"></div>
<p><?php echo Yii::t('yii', 'Use this tool to search through all pollinator deficit records in the BDD database and edit or delete any of them.'); ?></p>
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
        <thead><tr><th></th><th style="text-align:left;">Common name of focal crop</th><th>Field number</th><th>Options</th></tr>
        </thead>
        <tbody id="lines"></tbody>
    </table>    
    <div class="legendbar">        
        <div class="showIconLegend"><?php showIcon("Show Deficit Record", "ui-icon-search", 0); ?></div>
        <div class="showIconLegendText">Show Record</div>
        <div class="updateIconLegend"><?php showIcon("Update Deficit Record", "ui-icon-pencil", 0); ?></div>
        <div class="updateIconLegendText">Update Record</div>
        <div class="deleteIconLegend"><?php showIcon("Delete Deficit Record", "ui-icon-trash", 0); ?></div>
        <div class="deleteIconLegendText">Delete Record</div>
        <div class="privateIconLegend"><?php showIcon("Private Record", "ui-icon-locked", 0); ?></div>
        <div class="privateIconLegendText">Private Record</div>
        <div style="clear:both"></div>
    </div>    
</div>