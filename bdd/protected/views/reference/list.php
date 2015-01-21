<?php include_once("protected/extensions/config.php"); ?>
<script type="text/javascript" src="js/lightbox/referenceselements.js"></script>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/loadfields.js"></script>
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
    $(document).ready(bootReference);

    $('#searchField').keypress(function(event){

        if (event.keyCode == 10 || event.keyCode == 13) 
            event.preventDefault();

      });
    
    var start;
    var end;
    var max;
    var interval;
    var handleSize;
    var filterList;
    var related;

    
    if (related == 'no')
    {
        var refFilterList = new Array();
        var pubFilterList = new Array();
        var paperFilterList = new Array();
        var keyFilterList = new Array();
    }

    // Inicia configuracoes Javascript
    function bootReference(){
        start = 0;
        end = 10;
        interval = 10;
        handleSize = 50;
        related = "<?php echo $related; ?>";

        configCatComplete('#id','#searchField', 'reference','#filterList');
        configIcons();
        filter();
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
        if (senderValue == null) {start = 0;}
        
        if (related == 'ref') {filterList = refFilterList;}
        else if (related == 'paper') {filterList = paperFilterList;}
        else if (related == 'pub') {filterList = pubFilterList;}
        else if (related == 'key') {filterList = keyFilterList;}

        $.ajax({ type:'POST',
            url:'index.php?r=reference/filter',
            data: {'limit':interval,'offset':start,'list':jFilterList, 'refFilterList':filterList},
            dataType: "json",
            success:function(json) {

                var rs = new Object();

                $("#refLines").html('');

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

                slider();
                
                rs = json.result;
                for(var i in rs){
                    insertReferenceLine(rs[i]);
                }

                //Config hover
                configIcons();
            }
        });
    }
    function insertReferenceLine(rs){
        var line ='<tr id="id__ID_" title="_TITLE_"><td style="width:20px;text-indent:0;">_ISPRIVATE_</td><td>_TITLE_</td><td style="width:120px;text-align:center;">_TYPEREFERENCE_</td><td style="width:160px;text-align:center;text-indent:0px;">_BUTTONS_</td></tr>';
        var aux = line;
        //
        //aux = aux.replace('_ID_',rs.idreference);
        //aux = aux.replace('_TITLE_','Category: '+rs.categoryreference+'<br/>Subcategory: '+rs.subcategoryreference+'<br/>Source: '+rs.source);
        //aux = aux.replace('_ISPRIVATE_',rs.isrestricted?'<img src="images/main/private.gif"/>':'');
        //aux = aux.replace('_TITLE_',rs.title);
        //aux = aux.replace('_TYPEREFERENCE_',rs.typereference);

        var cref = '';
        var scref = '';
        var source = '';
        var type = '';

        if (rs.categoryreference == null)
            {cref = 'None';}
            else {cref = rs.categoryreference;}
        if (rs.subtypereference == null)
            {scref = 'None';}
            else {scref = rs.subtypereference;}
        if (rs.source == null)
            {source = 'None';}
            else {source = rs.source;}
        if (rs.typereference == null)
            {type = 'None';}
            else {type = rs.typereference;}

        //var btnEdit = '<a href="index.php?r=reference/goToMaintain&id='+rs.idreference+'"><img src="images/main/edit.png" style="border:0px;" title="Update"/></a> | ';
        //var btnDelete = '<a href="javascript:deleteReferenceRecord('+rs.idreference+');"><img src="images/main/canc.gif" style="border:0px;" title="Delete"/></a> | ';
        //var btnEdit = '<ul id="icons"><li class="optionIcon ui-state-default ui-corner-all" title="Edit Reference Record"><a href="index.php?r=reference/goToMaintain&id='+rs.idreference+'"><span class="ui-icon ui-icon-document"></span></a></li>';
        //var btnDelete = '<li class="optionIcon ui-state-default ui-corner-all" title="Delete Reference Record"><a href="javascript:deleteReferenceRecord('+rs.idreference+');"><span class="ui-icon ui-icon-trash"></span></a></li></ul>';
        //var btnRelate = '<a href=\'javascript:relateReferenceRecord('+rs.idreference+')\'><img src=\'images/galleria/check.jpeg\' width=20px/></a>';
        var btnDownload = '';
        //var btnRestricted = '<ul id="icons"><li class="ui-state-default ui-corner-all" title="Restricted Reference Record"><span class="ui-icon ui-icon-locked"></span></a></li></ul>';
        var btnPrivate = "<div class='btnPrivate'><ul class='iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Private Specimen Record'><span class='ui-icon ui-icon-locked'></span></li></ul></div>";
        var btnShow = "<div class='btnShow' style='margin-left: 17px;'><a href='index.php?r=reference/goToShow&id="+rs.idreference+"'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Show Reference Record'><span class='ui-icon ui-icon-search'></span></li></ul></a></div>";
        var btnUpdate = "<div class='btnUpdate' style='margin-left: 0px;'><a href='index.php?r=reference/goToMaintain&id="+rs.idreference+"'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Update Reference Record'><span class='ui-icon ui-icon-pencil'></span></li></ul></a></div>";
        var btnDelete = "<div class='btnDelete' style='margin-left: 35px;'><a href='javascript:deleteReferenceRecord("+rs.idreference+");'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Delete Reference Record'><span class='ui-icon ui-icon-trash'></span></li></ul></a></div><div style='clear:both'></div>";
        var btnRelate = "<div class='btnRelate'><a href='javascript:relateReferenceRecord("+rs.idreference+");'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Relate Reference Record'><span class='ui-icon ui-icon-check'></span></li></ul></a></div>";
        var btnRelatePaper = "<div class='btnRelate'><a href='javascript:relatePaperRecord("+rs.idreference+");'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Relate Reference Record'><span class='ui-icon ui-icon-check'></span></li></ul></a></div>";
        var btnRelatePub = "<div class='btnRelate'><a href='javascript:relatePubReferenceRecord("+rs.idreference+");'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Relate Reference Record'><span class='ui-icon ui-icon-check'></span></li></ul></a></div>";
        var btnRelateKey = "<div class='btnRelate'><a href='javascript:relateKeyRecord("+rs.idreference+");'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Relate Reference Record'><span class='ui-icon ui-icon-check'></span></li></ul></a></div>";


        aux = aux.replace('_ID_',rs.idreference);
        aux = aux.replace('_TITLE_','Category: '+cref+'<br/>Subcategory: '+scref+'<br/>Source: '+source);
        aux = aux.replace('_ISPRIVATE_',rs.isrestricted?btnPrivate:'');
        aux = aux.replace('_TITLE_',rs.title);
        aux = aux.replace('_TYPEREFERENCE_',scref);

        
        //If there's a file, show a download button
        if (rs.file != null && rs.path != null)
        {
            //btnDownload = '<li class="optionIcon ui-state-default ui-corner-all" title="Download File"><a href=\''+rs.path+'/'+rs.file+'\' target=\'_blank\'><span class="ui-icon ui-icon-disk"></span></a></li>';
            //btnUpdate = "<div class='btnUpdate' style='margin-left:34px'>" + btnUpdate.slice(23);
            btnDelete = "<div class='btnDelete' style='margin-left:0px'>" + btnDelete.slice(50);
            btnDownload = "<div class='btnDownload'><a href='"+rs.path+rs.file+"' target=\'_blank\'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Download File'><span class='ui-icon ui-icon-disk'></span></li></ul></a></div>";
        }

        if(related=="ref"){
            aux = aux.replace('_BUTTONS_',btnRelate);
        }
        else if (related == 'paper'){
            aux = aux.replace('_BUTTONS_',btnRelatePaper);
        }
        else if (related == 'pub'){
            aux = aux.replace('_BUTTONS_',btnRelatePub);
        }
        else if (related == 'key'){
            aux = aux.replace('_BUTTONS_',btnRelateKey);
        }

        else{
            aux = aux.replace('_BUTTONS_',btnShow+btnUpdate+btnDownload+btnDelete);
        }


        $("#refLines").append(aux);
        if (related == 'no')
            {
            $('#id_'+rs.idreference).poshytip({
            className: 'tip-twitter',
            showTimeout: 500,
            alignTo: 'target',
            alignX: 'left',
            alignY: 'center',
            offsetX:10,
            content: function(updateCallback) {

                $.ajax({ type:'POST',
                url:'index.php?r=reference/getTip',
                data: {'idreference':rs.idreference},
                dataType: "json",
                success:function(json) {

                    var reference = json.sp[0];

                    //Format the tooltip
                    var tooltip = '<div class="tipDiv"><div class="tipKey">Publication year</div><div class="tipValue">'+reference.publicationyear+'</div><div style="clear:both"></div><div class="tipKey">Bibliographic citation</div><div class="tipValue">'+reference.bibliographiccitation+'</div><div style="clear:both"></div><div class="tipKey">Subject</div><div class="tipValue">'+reference.subject+'</div><div style="clear:both"></div></div>';

                    // Call updateCallback() to update the content in the main tooltip
                    updateCallback(tooltip);
                }});

		return '<div class="tipDiv" style="height:70px;">Loading metadata...</div>';
            }
            });
        }
    }
    function deleteReferenceRecord(idreference)
    {
        if( confirm("Are you sure you would like to permanently delete this reference record?"))
        {
            //Hide poshytip
            $('#id_'+idreference).poshytip('hide');
            setTimeout(function(){
                $('#id_'+idreference).poshytip('destroy');
            }, 500);

            //Delete record
            deleteRecord(idreference,'reference');

            //Reload data
            filter('remove');
        }

    }

    function relateReferenceRecord(idreference)
    {
        //Push onto the filter list
        refFilterList.push(idreference);

        //Push onto the action list
        var jsonItem =
            {
                "id":idreference,
                "action":"save"
            };
        refActionList.push(jsonItem);

        filter('relate');

    }
    function relatePubReferenceRecord(idreference)
    {
        //Push onto the filter list
        pubFilterList.push(idreference);

        //Push onto the action list
        var jsonItem =
            {
                "id":idreference,
                "action":"save"
            };
        pubActionList.push(jsonItem);

        filter('relate');

    }
    function relatePaperRecord(idreference)
    {
        //Push onto the filter list
        paperFilterList.push(idreference);

        //Push onto the action list
        var jsonItem =
            {
                "id":idreference,
                "action":"save"
            };
        paperActionList.push(jsonItem);

        filter('relate');

    }
    function relateKeyRecord(idreference)
    {
        //Push onto the filter list
        keyFilterList.push(idreference);

        //Push onto the action list
        var jsonItem =
            {
                "id":idreference,
                "action":"save"
            };
        keyActionList.push(jsonItem);

        filter('relate');

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
            url:'index.php?r=reference/printList',
            data: {
            	'list':jFilterList, 
            	'refFilterList':filterList
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
<h1 style="padding-left:10px; float:left;"><?php echo Yii::t('yii', 'List reference records'); ?></h1>
<div style="clear:both;"></div>
<p><?php echo Yii::t('yii', 'Use this tool to search through all reference records in the BDD database and view, edit or delete any of them. You may also specify filters to narrow the list of references shown.'); ?></p>
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

<div id="relateRef" align="right"></div>

<div id="rs" class="item">
    <table id="tablelist" class="list">
        <thead>
            <tr>
                <th>   </th> <th>Title</th> <th style="text-align:center;">Subtype</th> <th>Options</th>
            </tr>
        </thead>
        <tbody id="refLines">
        <tbody>
    </table>
    <div class="legendbar">
    <?php if ($related == 'true') {
        echo '<div class="relateIconLegend">'; showIcon("Relate Reference Record", "ui-icon-check", 0); echo '</div>';
        echo '<div class="relateIconLegendText">Relate Reference Record</div>';
        echo '<div class="privateIconLegend">'; showIcon("Private Record", "ui-icon-locked", 0); echo '</div>';
        echo '<div class="privateIconLegendText">Private Record</div>';
        echo '<div style="clear:both"></div>';

    } else {
    	echo '<div class="showIconLegend" style="margin-left:15px;">'; showIcon("Show Reference Record", "ui-icon-search", 0); echo '</div>';
        echo '<div class="showIconLegendText">Show Record</div>';
        echo '<div class="updateIconLegend" style="margin-left:0px;">'; showIcon("Update Reference Record", "ui-icon-pencil", 0); echo '</div>';
        echo '<div class="updateIconLegendText">Update Record</div>';
        echo '<div class="deleteIconLegend">'; showIcon("Delete Reference Record", "ui-icon-trash", 0); echo '</div>';
        echo '<div class="deleteIconLegendText">Delete Record</div>';
        echo '<div class="downloadIconLegend">'; showIcon("Download File", "ui-icon-disk", 0); echo '</div>';
        echo '<div class="downloadIconLegendText">Download File</div>';
        echo '<div class="privateIconLegend">'; showIcon("Private Record", "ui-icon-locked", 0); echo '</div>';
        echo '<div class="privateIconLegendText">Private Record</div>';
        echo '<div style="clear:both"></div>';} ?>
    </div>
</div>