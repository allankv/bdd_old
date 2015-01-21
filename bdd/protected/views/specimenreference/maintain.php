<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/tablesorter/themes/blue/style.css" />
<?php if ($specimenRef->idspecimen != null) {$idspecimen = $specimenRef->idspecimen;} else {$idspecimen = 0;} ?>
<script type="text/javascript">
    $(document).ready(bootSpecimenRef);

    var idspm = <?php echo $idspecimen; ?>;
    var refFilterList = new Array();
    var refActionList = new Array();

    function bootSpecimenRef()
    {
        if (idspm != 0) {loadReferenceArray();}

        $("#resultsTable").hide();

        //Create the Relate Reference button
        $("#relateRef").button();
        $("#relateRef").click(function() {
            //Destroy both dialogs
            $('#listRelatedMedia').dialog('destroy');
            $('#listRelatedMedia').dialog().remove();
            $('#listRelatedMedia').remove();

            $('#listRelatedRef').dialog('destroy');
            $('#listRelatedRef').dialog().remove();
            $('#listRelatedRef').remove();
            $( '<div id="listRelatedRef"></div>' ).load('index.php?r=reference/goToListRelated').dialog({
                modal:true,
                title: 'Relate Reference Records to Specimen Record',
                show:'fade',
                hide:'fade',
                width: 800,
                height:600,
                buttons: {
                    'Close': function(){
                        $(this).dialog('close');
                        loadReferences();
                    }}
            });
        });
    }
    function loadReferenceArray()
    {
        //Get the images for the specimen id
        $.ajax({ type:'POST',
        url:'index.php?r=specimen/getReference',
        data: ({'idspecimen' : idspm}),
        dataType: "json",
        success:function(json) {

            var rs = new Array();
            rs = json.result;

            for (var i in rs)
                {
                    refFilterList.push(rs[i].idreference);
                }

            loadReferences();
        }
        });
    }
    function loadReferences()
    {
        //Empty the div
        $('#references').empty();

        //Get the images for the specimen id
        $.ajax({ type:'POST',
        url:'index.php?r=reference/showReference',
        data: ({'refShowList' : refFilterList}),
        dataType: "json",
        success:function(json) {

            //Create the table
            if (json.count > 0)
            {
                $('#resultsTable').show();
            }

            var rs = new Array();
            rs = json.result;

            for (var i in rs)
                {
                    insertRefLine(rs[i]);
                }

            configIcons();
        }
        });
    }
    function insertRefLine (rs)
    {
        //var line ='<tr id="idref__ID_" title="_TITLE_"><td align="center">_ISPRIVATE_</td><td align="left">_TITLE_</td><td align="center">_TYPEREFERENCE_</td><td align="center">_BUTTONS_</td></tr>';
        var line ='<tr id="idref__ID_" title="_TITLE_"><td style="width:20px;text-indent:0;">_ISPRIVATE_</td><td>_TITLE_</td><td style="width:120px;text-align:center;">_TYPEREFERENCE_</td><td style="width:160px;text-align:center;text-indent:0px;">_BUTTONS_</td></tr>';
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
        if (rs.subtypereference == null)
            {type = 'None';}
            else {type = rs.subtypereference;}

        var btnPrivate = "<div class='btnPrivate'><ul class='iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Private Specimen Record'><span class='ui-icon ui-icon-locked'></span></li></ul></div>";
        var btnUpdate = "<div class='btnUpdate'><a href='index.php?r=reference/goToMaintain&id="+rs.idreference+"'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Update Specimen Record'><span class='ui-icon ui-icon-pencil'></span></li></ul></a></div>";
        var btnShow = "<div class='btnShow' style='margin-left: 15px;'><a href='index.php?r=reference/goToShow&id="+rs.idreference+"'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Update Specimen Record'><span class='ui-icon ui-icon-search'></span></li></ul></a></div>";
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
        var btnDelete = "<div class='btnDelete'><a href='javascript:removeReferenceRelationship("+rs.idreference+");'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Remove Specimen-Reference Relationship'><span class='ui-icon ui-icon-close'></span></li></ul></a></div><div style='clear:both'></div>";
        aux = aux.replace('_BUTTONS_',btnShow+btnUpdate+btnDownload+btnDelete);

        $("#references").append(aux);

        $('#idref_'+rs.idreference).poshytip({
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

    function removeReferenceRelationship (idreference)
    {
        if (confirm('Are you sure you would like to delete this relationship?'))
        {
            var idRemove = refFilterList.indexOf(idreference);
            if(idRemove != -1)
            {
                //Take the media record out of the filter list
                refFilterList.splice(idRemove, 1);

                //Place the action of deleting the media record
                var jsonItem = {
                    "id":idreference,
                    "action":"delete"
                };
                refActionList.push(jsonItem);

                //Hide poshytip
                $('#idref_'+idreference).poshytip('hide');

                //Destroy poshytip after 1 second
                setTimeout( function(){
                    $('#idref_'+idreference).poshytip('destroy');
                }, 1000);

            }

            else
                alert("Error removing the media record.");

            loadReferences();
        }

        if (refFilterList.length == 0)
            $("#resultsTable").hide();

    }

</script>

<div class="mainFieldsTable">
<input id="relateRef" type="button" value="Relate to Reference Records" onclick="" />
</div>

<div id="listRelatedRef"></div>

<div class="overflow">
<div id="resultsTable" class="item">
    <table id="tablelist" class="list">
        <thead>
            <tr>
                <th>   </th> <th>Title</th> <th style="text-align:center;">Subtype</th> <th>Options</th>
            </tr>
        </thead>
        <tbody id="references">
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
</div>