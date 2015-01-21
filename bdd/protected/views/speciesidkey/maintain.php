<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/tablesorter/themes/blue/style.css" />

<?php if ($speciesKey->idspecies != null) {$idspecies = $speciesKey->idspecies;} else {$idspecies = 0;} ?>

<script type="text/javascript">
    $(document).ready(bootSpeciesKey);

    var idspc = <?php echo $idspecies; ?>;
    var keyFilterList = new Array();
    var keyActionList = new Array();

    function bootSpeciesKey()
    {
        if (idspc != 0) {loadKeyArray();}

        $("#keyResultsTable").hide();

        //Create the Relate Key button
        $("#relateKey").button();
        $("#relateKey").click(function() {
            
            //Destroy all dialogs
            destroyDialogs();

            $( '<div id="listRelatedKey"></div>' ).load('index.php?r=reference/goToListRelatedKey').dialog({
                modal:true,
                title: 'Relate Identification Key Records to Species Record',
                show:'fade',
                hide:'fade',
                width: 800,
                height:600,
                buttons: {
                    'Close': function(){
                        $(this).dialog('close');
                        loadKeys();
                    }}
            });
        });
    }
    function loadKeyArray()
    {
        //Get the images for the species id
        $.ajax({ type:'POST',
        url:'index.php?r=species/getKey',
        data: ({'idspecies' : idspc}),
        dataType: "json",
        success:function(json) {

            var rs = new Array();
            rs = json.result;

            for (var i in rs)
                {
                    keyFilterList.push(rs[i].idreference);
                }

            loadKeys();
        }
        });
    }
    function loadKeys()
    {
        //Empty the div
        $('#keys').empty();

        //Get the images for the species id
        $.ajax({ type:'POST',
        url:'index.php?r=reference/showReference',
        data: ({'refShowList' : keyFilterList}),
        dataType: "json",
        success:function(json) {

            //Create the table
            if (json.count > 0)
            {
                $('#keyResultsTable').show();
            }

            var rs = new Array();
            rs = json.result;

            for (var i in rs)
                {
                    insertKeyLine(rs[i]);
                }

            configIcons();
        }
        });
    }
    function insertKeyLine (rs)
    {
        //var line ='<tr id="idkey__ID_" title="_TITLE_"><td align="center">_ISPRIVATE_</td><td align="left">_TITLE_</td><td align="center">_TYPEREFERENCE_</td><td align="center">_BUTTONS_</td></tr>';
        var line ='<tr id="idkey__ID_" title="_TITLE_"><td style="width:20px;text-indent:0;">_ISPRIVATE_</td><td>_TITLE_</td><td style="width:120px;text-align:center;">_TYPEREFERENCE_</td><td style="width:160px;text-align:center;text-indent:0px;">_BUTTONS_</td></tr>';
        var aux = line;

        var cref = '';
        var scref = '';
        var source = '';
        var type = '';

        if (rs.categoryreference == null)
            {cref = 'None';}
            else {cref = rs.categoryreference;}
        if (rs.subcategoryreference == null)
            {scref = 'None';}
            else {scref = rs.subcategoryreference;}
        if (rs.source == null)
            {source = 'None';}
            else {source = rs.source;}
        if (rs.typereference == null)
            {type = 'None';}
            else {type = rs.typereference;}

        var btnPrivate = "<div class='btnPrivate'><ul class='iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Private Species Record'><span class='ui-icon ui-icon-locked'></span></li></ul></div>";
        var btnUpdate = "<div class='btnUpdate'><a href='index.php?r=reference/goToMaintain&id="+rs.idreference+"'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Update Species Record'><span class='ui-icon ui-icon-pencil'></span></li></ul></a></div>";
        var btnShow = "<div class='btnShow' style='margin-left: 20px'><a href='index.php?r=reference/goToShow&id="+rs.idreference+"'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Show Species Record'><span class='ui-icon ui-icon-search'></span></li></ul></a></div>";
        var btnDownload = '';

        aux = aux.replace('_ID_',rs.idreference);
        aux = aux.replace('_TITLE_','Category: '+cref+'<br/>Subcategory: '+scref+'<br/>Source: '+source);
        aux = aux.replace('_ISPRIVATE_',rs.isrestricted?btnPrivate:'');
        aux = aux.replace('_TITLE_',rs.title);
        aux = aux.replace('_TYPEREFERENCE_',type);


        //If there's a file, show a download button
        if (rs.file != null && rs.path != null)
        {
            //btnDownload = '<a href=\''+rs.path+'/'+rs.file+'\' target=\'_blank\'><img src=\'images/galleria/download.jpg\' width=15/></a> | ';
            btnDownload = "<div class='btnDownload'><a href='"+rs.path+"/"+rs.file+"' target=\'_blank\'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Download File'><span class='ui-icon ui-icon-disk'></span></li></ul></a></div>";
        }

        //var btnDelete = '<a href="javascript:removeReferenceRelationship('+rs.idreference+');"><img src="images/main/canc.gif" style="border:0px;" title="Remove Relationship"/></a>';
        var btnDelete = "<div class='btnDelete'><a href='javascript:removeKeyRelationship("+rs.idreference+");'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Remove Species-Reference Relationship'><span class='ui-icon ui-icon-close'></span></li></ul></a></div><div style='clear:both'></div>";
        aux = aux.replace('_BUTTONS_',btnShow+btnUpdate+btnDownload+btnDelete);

        $("#keys").append(aux);

        $('#idkey_'+rs.idreference).poshytip({
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
                    var tooltip = '<div class="tipDiv"><div class="tipKey">Category</div><div class="tipValue">'+reference.categoryreference+'</div><div style="clear:both"></div><div class="tipKey">Subcategory</div><div class="tipValue">'+reference.subcategoryreference+'</div><div style="clear:both"></div><div class="tipKey">Source</div><div class="tipValue">'+reference.source+'</div><div style="clear:both"></div></div>';

                    // Call updateCallback() to update the content in the main tooltip
                    updateCallback(tooltip);
                }});

                return '<div class="tipDiv" style="height:70px;">Loading metadata...</div>';
            }
        });
    }

    function removeKeyRelationship (idreference)
    {
        if (confirm('Are you sure you would like to delete this relationship?'))
        {
            var idRemove = keyFilterList.indexOf(idreference);
            if(idRemove != -1)
            {
                //Take the media record out of the filter list
                keyFilterList.splice(idRemove, 1);

                //Place the action of deleting the media record
                var jsonItem = {
                    "id":idreference,
                    "action":"delete"
                };
                keyActionList.push(jsonItem);

                //Hide poshytip
                $('#idkey_'+idreference).poshytip('hide');

                //Destroy poshytip after 1 second
                setTimeout( function(){
                    $('#idkey_'+idreference).poshytip('destroy');
                }, 1000);

            }

            else
                alert("Error removing the media record.");

            loadKeys();
        }

        if (keyFilterList.length == 0)
            $("#resultsTable").hide();

    }
</script>

<!-- The RELATE button -->
<center>
<input id="relateKey" type="button" value="Relate Identification Key Records" onclick="" />
</center>

<!-- Div for the Reference List Related page -->
<div id="listRelatedKey"></div>

<!--Add lines-->
<!--<div id="resultsTable">
<table class="list" width="500px" style="table-layout:fixed;">
        <thead>
            <tr>
                <th width="30px">  </th>
                <th width="270px">Title</th>
                <th width="100px">Type</th>
                <th width="100px">Options</th>
            </tr>
        </thead>
        <tbody id="references">
        <tbody>
</table>

<div class="legendbar" align="center">
    <img src="images/main/edit.png" style="border:0px;" title="Update"/> Update | <img src="images/galleria/download.jpg" width="15" title="Download file"/> Download File | <img src="images/main/canc.gif" title="Remove Relationship"/> Remove Relationship | <img src="images/main/private.gif" title="Is Private"/> Is Private
</div>
</div>-->

<div id="keyResultsTable" class="item">
    <table id="tablelist" class="list">
        <thead>
            <tr>
                <th>   </th> <th>Title</th> <th style="text-align:center;">Type</th> <th>Options</th>
            </tr>
        </thead>
        <tbody id="keys">
        </tbody>
    </table>
    <div class="legendbar">
    	<div class="showIconLegend" style="margin-left: 5px;"><?php showIcon("Show Reference Record", "ui-icon-search", 0); ?></div>
        <div class="showIconLegendText">Show Record</div>
        <div class="updateIconLegend"><?php showIcon("Update Reference Record", "ui-icon-pencil", 0); ?></div>
        <div class="updateIconLegendText">Update Record</div>
        <div class="deleteIconLegend"><?php showIcon("Remove Relationship", "ui-icon-close", 0); ?></div>
        <div class="deleteIconLegendText">Remove Relationship</div>
        <div class="downloadIconLegend"><?php showIcon("Download File", "ui-icon-disk", 0); ?></div>
        <div class="downloadIconLegendText">Download</div>
        <div class="privateIconLegend"><?php showIcon("Private Record", "ui-icon-locked", 0); ?></div>
        <div class="privateIconLegendText">Private Record</div>
        <div style="clear:both"></div>
    </div>
</div>