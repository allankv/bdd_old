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
    $(document).ready(bootFilter);

    var start = 0;
    var end = 10;
    var max = 10;
    var interval = 10;
    var handleSize = 50;

    // Inicia configuracoes Javascript
    function bootFilter(){
    	configFilter('#id','#searchField', 'admin','#filterList');
        configIcons();
        filter();
       
       
        //Help message for the filter textbox help tool 
        var helpTip = '<div style="font-weight:normal;">Use this box to filter the results below</div>';

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

        if (senderValue == null) {
        	start = 0;
        }

        $.ajax({
        	type:'POST',
            url:'index.php?r=admin/filterGroups',
            data: {'limit':interval, 'offset':start, 'list':jFilterList},
            dataType: "json",
            success:function(json) {
                var rs = new Object();
                $("#lines").html('');

                max = parseInt(json.count);

                if (start > max) {
                	start = 0;
                }

                $('#start').html(start);

                end = start + interval;

                if (end > max) { 
                	end = max;
                }

                $('#end').html(end);
                $('#max').html(max);

                slider();

                rs = json.result;

                for(var i in rs) {                    
                    insertLine(rs[i]);
                }

                configIcons();
            }
        });
    }
    function insertLine(rs){
        var line ='<tr id="id__ID_"><td style="text-indent:5px;">_NAME_</td><td style="width:160px; text-align:center; text-indent:0px;">_BUTTONS_</td></tr>';
        var aux = line;

                
        var btnUpdate = "<div class='btnUpdate'><a href='index.php?r=admin/goToMaintainGroup&id="+rs.id+"'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Update Specimen Record'><span class='ui-icon ui-icon-pencil'></span></li></ul></a></div>";
        var btnDelete = "<div class='btnDelete'><a href='javascript:deleteGroupRecord("+rs.id+");'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Delete Specimen Record'><span class='ui-icon ui-icon-trash'></span></li></ul></a></div><div style='clear:both'></div>";
        
		//console.log(rs);

        aux = aux.replace('_ID_',rs.id);
        
        aux = aux.replace('_NAME_',rs.name);
        //aux = aux.replace('_BUTTONS_',btnUpdate+btnDelete);

        if ((rs.id>2)){
        	aux = aux.replace('_BUTTONS_',btnUpdate+btnDelete);
        }
        else {
        	aux = aux.replace('_BUTTONS_',btnUpdate);
        }
        
       
        $("#lines").append(aux);
        
    }
    function deleteGroupRecord (idgroup)
    {
        if (confirm("Are you sure you would like to permanently delete this record?"))
            {
                //Remove record
                deleteRecord(idgroup,'admin');

               
                setTimeout(function(){
                	//Refresh data
                	filter();
	            }, 1000);

                
                
            }
    }
    function slider(idDQ){

        $("#slider").slider({
            range: false,
            min:0,
            max:max - interval,
            value:start,
            stop: function(event, ui) {
                start = ui.value;
                end = start + interval;
                filter('slider',idDQ);
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

<div class="introText">
<div style="float:left;"><?php echo CHtml::image("images/help/iconelist.png"); ?></div>
<h1 style="padding-left:10px; float:left;"><?php echo Yii::t('yii', 'List groups records'); ?></h1>
<div style="clear:both;"></div>
<p><?php echo Yii::t('yii', 'Use this tool to search through all group records in the BDD database and edit or delete any of them.'); ?></p>
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
    <div class="filterList">
    <div id="filterList"></div>
    </div>
</div>
<?php echo CHtml::endForm(); ?>

<div id="rs" class="item">
    <table id="tablelist" class="list">
        <thead><tr><th style="text-align:left;">Groups Name</th><th>Options</th></tr>
        </thead>
        <tbody id="lines"></tbody>
    </table>    
    <div class="legendbar">
        <div class="updateIconLegend"><?php showIcon("Update Specimen Record", "ui-icon-pencil", 0); ?></div>
        <div class="updateIconLegendText">Update Record</div>
        <div class="deleteIconLegend"><?php showIcon("Delete Specimen Record", "ui-icon-trash", 0); ?></div>
        <div class="deleteIconLegendText">Delete Record</div>
        <div class="privateIconLegend"><?php showIcon("Private Record", "ui-icon-locked", 0); ?></div>
        <div class="privateIconLegendText">Private Record</div>
        <div style="clear:both"></div>
    </div>    
</div>

<script>
function configFilter(id,field,controller,_filterList){
	
    $(field).catcomplete({
        source: 'index.php?r='+controller+'/GroupSearch',
        minLength: 2,
        select: function( event, ui ) {
            addToList(ui.item.id,ui.item.label,ui.item.controller,ui.item.category,_filterList);
            $(field).val('');
            $(id).val('');
        }
    });
}

function deleteRecord (id, controller) {
    $.ajax({
        type:'POST',
        url:'index.php?r='+controller+'/DeleteGroup',
        data: {
            "id":id
        },
        success:function(data){
            if (data==1){
				alert('Successfully deleted group record');
            }
            else if (data==-1){
            	alert("You can't delete this group because there is/are user(s) in this group.");
            }
        }
    });
}

</script>