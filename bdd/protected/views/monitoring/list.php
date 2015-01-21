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
    $(document).ready(bootMonitoring);

    var start = 0;
    var end = 10;
    var max = 10;
    var interval = 10;
    var handleSize = 50;

    // Inicia configuracoes Javascript
    function bootMonitoring(){

        configCatComplete('#id','#searchField', 'monitoring','#filterList');
        configIcons();
        filter();
        //slider();
        $("#printButton").button();
        
        //Help message for the filter textbox help tooltip
        var helpTip = '<div style="font-weight:normal;">Utilize esse campo para filtrar os resultados abaixo. Diferentes termos de diferentes categorias (ex.: Codigo de Instituicao e Codigo de Colecao) resultarao em consultas E. Diferentes termos da mesma categoria, entretanto, resultarao em uma consulta OU.</div>';

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
            url:'index.php?r=monitoring/filter',
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
        var line ='<tr id="id__ID_" title="_TITLE_"><td style="width:20px; text-indent:0;">_ISPRIVATE_</td><td style="text-indent:5px;">_LASTTAXA_</td><td style="text-align:center;">_DENOMINATION_</td><td style="text-align:center;">_COLLECTIONCODE_</td><td style="text-align:center;">_CATALOGNUMBER_</td><td style="text-align:center; text-indent:0px; width: 90px;">_BUTTONS_</td></tr>';
        var aux = line;

        //var btnRestricted = '<ul id="icons"><li class="ui-state-default ui-corner-all" title="Restricted Specimen Record"><span class="ui-icon ui-icon-locked"></span></a></li></ul>';
        //var btnEdit = '<ul id="icons"><li class="optionIcon ui-state-default ui-corner-all" title="Update Specimen Record"><a href="index.php?r=specimen/goToMaintain&id='+rs.id+'"><span class="ui-icon ui-icon-document"></span></a></li>';
        //var btnDelete = '<li class="optionIcon ui-state-default ui-corner-all" title="Delete Specimen Record"><a href="javascript:deleteSpecimenRecord('+rs.id+');"><span class="ui-icon ui-icon-trash"></span></a></li></ul>';

        var btnPrivate = "<div class='btnPrivate'><ul class='iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Private Monitoring Record'><span class='ui-icon ui-icon-locked'></span></li></ul></div>";
        var btnUpdate = "<div class='btnUpdate' style='margin-left: 4px; margin-right:0px;'><a href='index.php?r=monitoring/goToMaintain&id="+rs.id+"'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Update Monitoring Record'><span class='ui-icon ui-icon-pencil'></span></li></ul></a></div>";
        var btnDelete = "<div class='btnDelete' style='margin-left: 4px; margin-right:0px;'><a href='javascript:deleteMonitoringRecord("+rs.id+");'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Delete Monitoring Record'><span class='ui-icon ui-icon-trash'></span></li></ul></a></div><div style='clear:both'></div>";
        var btnShow = "<div class='btnShow' style='margin-left: 4px; margin-right:0px;'><a href='index.php?r=monitoring/goToShow&id="+rs.id+"'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Update Monitoring Record'><span class='ui-icon ui-icon-search'></span></li></ul></a></div>";
       
        aux = aux.replace('_ID_',rs.id);
        aux = aux.replace('_TITLE_','Institution: '+rs.institution);
        aux = aux.replace('_ISPRIVATE_',rs.isrestricted?btnPrivate:'');
        aux = aux.replace('_DENOMINATION_',rs.denomination);
        aux = aux.replace('_COLLECTIONCODE_',rs.collection);
        aux = aux.replace('_CATALOGNUMBER_',rs.catalognumber);
        aux = aux.replace('_BUTTONS_',btnShow+btnUpdate+btnDelete);
        
        if (rs.scientificname != null)
        	aux = aux.replace('_LASTTAXA_',rs.scientificname);
        else
        	aux = aux.replace('_LASTTAXA_',rs.morphospecies);

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
                            url:'index.php?r=monitoring/getTip',
                            data: {'idmonitoring':rs.id},
                            dataType: "json",
                            success:function(json) {
                                
                                var monitoring = json.sp[0];

                                var tip = '<div class="tipDiv"><div class="tipKey">Codigo da Instituicao</div><div class="tipValue">'+monitoring.institutioncode+'</div><div style="clear:both"></div><div class="tipKey">Tecnica de Coleta</div><div class="tipValue">'+monitoring.technicalcollection+'</div><div style="clear:both"></div><div class="tipKey">Cultura</div><div class="tipValue">'+monitoring.culture+'</div><div style="clear:both"></div></div>';

                                updateCallback(tip);
                            }
                        });
                return '<div class="tipDiv">Loading metadata...</div>';
            }
        });
    }
    function deleteMonitoringRecord (idmonitoring)
    {
        if (confirm("Tem certeza que deseja apagar permanentemente este registro de monitoramento?"))
            {
                //Remove record
                deleteRecord(idmonitoring,'monitoring');

                //Hide poshytip
                $('#id_'+idmonitoring).poshytip('hide');
                setTimeout(function(){
	                $('#id_'+idmonitoring).poshytip('destroy');
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
            url:'index.php?r=monitoring/printList',
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
<h1 style="padding-left:10px; float:left;"><?php echo Yii::t('yii', 'Listar registros de monitoramento'); ?></h1>
<div style="clear:both;"></div>
<p><?php echo Yii::t('yii', 'Utilize esta ferramenta para navegar entre todos os registros de monitoramento do BDD e editar ou deletar qualquer um deles.'); ?></p>
</div>

<?php echo CHtml::beginForm(); ?>
<div class="filter">
    <div class="filterLabel"><?php echo 'Filtro';?></div>
    <div class="filterMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=filter',array('rel'=>'lightbox', 'style'=>'margin: 0px 10px 0px 0px;')); ?></div>
    <div class="filterInterval">
    Filtrado de <b><span id="start"></span></b> a <b><span id="end"></span></b> de <b><span id="max"></span></b>
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
        <thead><tr><th></th><th style="text-align:left;">Elementos taxonomicos</th><th>Denominacao</th><th>Codigo da colecao</th><th>Numero de catalogo</th><th>Opcoes</th></tr>
        </thead>
        <tbody id="lines"></tbody>
    </table>    
    <div class="legendbar">        
    	<div class="showIconLegend"><?php showIcon("Vizualizar um registro de monitoramento", "ui-icon-search", 0); ?></div>
        <div class="showIconLegendText">Visualizar registro</div>
        <div class="updateIconLegend"><?php showIcon("Atualizar um registro de monitoramento", "ui-icon-pencil", 0); ?></div>
        <div class="updateIconLegendText">Atualizar registro</div>
        <div class="deleteIconLegend"><?php showIcon("Apagar um registro de monitoramento", "ui-icon-trash", 0); ?></div>
        <div class="deleteIconLegendText">Apagar registro</div>
        <div class="privateIconLegend"><?php showIcon("Registro privado", "ui-icon-locked", 0); ?></div>
        <div class="privateIconLegendText">Registro privado</div>
        <div style="clear:both"></div>
    </div>    
</div>