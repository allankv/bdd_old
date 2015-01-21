
<?php include_once("protected/extensions/config.php"); ?>
<script type="text/javascript" src="js/Maintain.js"></script>
<script type="text/javascript" src="js/List.js"></script>

<link rel="stylesheet" type="text/css" href="css/jquery.countdown.css" />
<script type="text/javascript" src="js/jquery.countdown.min.js"></script>

<style>
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
    .ui-button-text {
        font-size: 12px;
        padding: 5px 26px 5px 5px;
    }
    div.hasCountdown {
        width:550px;
        margin-left:149px;
        background-color:#F9F9F9;
        border:0px solid #F6A828;
    }
    .countdown_show3 .countdown_section {
        width: 160px;
        margin-right:5px;
        background-color:#F8F7F4;
        color:#885522;
        border-radius: 0.4em 0.4em 0.4em 0.4em;
        -moz-border-radius-topleft: 0.4em;
        -moz-border-radius-topright: 0.4em;
        -moz-border-radius-bottomleft: 0.4em;
        -moz-border-radius-bottomright: 0.4em;
        border:1px solid #DDCCAA;
        -moz-box-shadow: 3px 3px 5px #CCAA77;
        -webkit-box-shadow: 3px 3px 5px #CCAA77;
        box-shadow: 3px 3px 5px #CCAA77;
    }
    .countdown_holding .countdown_section {
        background-color: #F4EFD9;
    }
    .countdown_holding span {
        background-color: #F4EFD9;
    }
    .countdown_descr {
        font-weight: bold;
        padding-top:10px;
        padding-bottom:10px;
        width:100px;
        margin-left:197px;
    }
</style>
<script>
	
    var start = 0;
    var end = 10;
    var max = 10;
    var interval = 10;
    var handleSize = 20;
    var maxrecordsperfile = 3000;

    $(document).ready(bootExport);
    function bootExport(){
        configNotify();
        configIcons();
        $('#log').hide();
        $('#divlink').hide();
        $('#result').hide();
        configCatComplete('#id','#searchField', 'monitoring','#filterList');
        filter();
        slider();

        //Help message for the filter textbox help tooltip
        var helpTip = '<div style="font-weight:normal;">Use this box to filter the results below. Different terms for different categories (e.g.: Institution Code and Collection Code) will result in an AND search. Different terms for the same category, however, will result in an OR search.</div>';

        //Set the help tooltip for the Filter textbox
        $('#searchField').poshytip({
            className: 'tip-twitter',
            content: helpTip,
            showOn: 'focus',
            alignTo: 'target',
            alignX: 'right',
            alignY: 'center',
            offsetX: 15
        });

        $("#startExportButton").button();
        $('#exportMiddle').css("opacity", "0.5");
        $('#exportRight').css("opacity", "0.5");
        $('#exportColumns').hide('slide');
        $('#exportEnd').hide('slide');

        $("#checkedColumns").html(109);
        $("#checkAll").button();
        $("#checkAll").click(function() {
            $(".check").attr('checked', true);
            for (var i = 0; i <= 109; i++) {
                $("#checkbox" + i).button("refresh");
                $("#checkbox" + i).button("option", "icons", {secondary:"ui-icon-check"});
            }
            $("#checkedColumns").html(109);
        });
        $("#uncheckAll").button();
        $("#uncheckAll").click(function() {
            $(".check").attr('checked', false);
            $(".required").attr('checked', true);
            for (var i = 0; i <= 109; i++) {
                $("#checkbox" + i).button("refresh");
                if ($("#checkbox" + i).attr('checked') == false) {
                    $("#checkbox" + i).button("option", "icons", {secondary:null});
                }
            }
            $("#checkedColumns").html(9);
        });

        for (var i = 0; i <= 109; i++) {
            $("#checkbox" + i).button({
                icons:{secondary:"ui-icon-check"}
            });
            $("#checkbox" + i).click(function() {
                $(this).button("refresh");
                if ($(this).attr('checked') == false) {
                    $(this).button("option", "icons", {secondary:null});
                    $("#checkedColumns").html(parseInt($("#checkedColumns").html(), 10) - 1);
                }
                else {
                    $(this).button("option", "icons", {secondary:"ui-icon-check"});
                    $("#checkedColumns").html(parseInt($("#checkedColumns").html(), 10) + 1);
                }
            });
        }        
    }
    function verificarDeterminacao(){
    	var i = jFilterList.length;
    	while(i--){
    		if(jFilterList[i].controller=="denomination")
    			return true;
    	}
    	return false;
    }
    function clearDiv() {
    	if(verificarDeterminacao())
	        $('#divlink').html('<div class="linkEnd" style="clear:both;"></div>');
    }
    function startExport(){
    	if(verificarDeterminacao()){
    	
    	
        $('#loading').show(3500);
    	//var h = $("#form").serialize();
    	      	
        $.ajax({url:'index.php?r=spreadsheetsync/startExport_monitoring',
            type: 'POST',
            data: {'filter':jFilterList},
            dataType: "json",
            success: function(json){   
		    	var link = '<div style="float:left; position:relative; left:50%; margin-right:15px;"><a id="link" target="_blank" href="'+json.exportMessage.path+'"><img width="35px" src="images/main/excel.png"/><br>Download</a></div>';
				$('#divlink').show();
                $('#result').fadeIn(2000);
                $('#loading').hide();
                var log = [];
                log[0] = '<b># '+json.exportMessage.lines+' registros de monitoramento.</b>';
               
                showMessage(log, true, true);
                $('#divlink').html(link);
			    $('#sinceCountdown').countdown('pause');			    		    	
            	//$('#sinceCountdown').countdown('destroy');              
            }
        });
        $('#sinceCountdown').countdown({since: new Date(), format: 'HMS', description: 'Time elapsed'});
        
        }else{
        	alert("É necessário selecionar uma Denominação para gerar a planilha.\nVolte para a etapa anterior e selecione uma Denominação no campo de Filtro.");
        }
    }
    function selectFilters() {
        if ($('#exportEnd').css("display") == "none") {
            if ($('#exportEnd').css("display") == "none") {
                $('#exportEnd').show('slide');
            }
            if ($('#exportFilters').css("display") != "none") {
                $('#exportFilters').hide('slide');
            }
            $('#exportLeft').css("opacity", "0.5");
            $('#exportMiddle').css("opacity", "0.5");
            $('#exportRight').css("opacity", "1");
        }
    }

    function selectColumns() {
        if ($('#exportFilters').css("display") == "none" && $('#exportEnd').css("display") == "none") {
            if ($('#exportEnd').css("display") == "none") {
                $('#exportEnd').show('slide');
            }
            if ($('#exportColumns').css("display") != "none") {
                $('#exportColumns').hide('slide');
            }
            $('#exportLeft').css("opacity", "0.5");
            $('#exportMiddle').css("opacity", "0.5");
            $('#exportRight').css("opacity", "1");
        }
    }

    function unselectFilters() {
        if ($('#exportFilters').css("display") == "none") {
            $('#exportFilters').show('slide');
        }
        if ($('#exportEnd').css("display") != "none") {
            $('#exportEnd').hide('slide');
        }
        if ($('#exportColumns').css("display") != "none") {
            $('#exportColumns').hide('slide');
        }
        $('#exportLeft').css("opacity", "1");
        $('#exportMiddle').css("opacity", "0.5");
        $('#exportRight').css("opacity", "0.5");
    }

    function unselectColumns() {
        if ($('#exportFilters').css("display") != "none") {
            $('#exportFilters').hide('slide');
        }
        if ($('#exportEnd').css("display") != "none") {
            $('#exportEnd').hide('slide');
        }
        if ($('#exportColumns').css("display") == "none") {
            $('#exportColumns').show('slide');
        }
        $('#exportLeft').css("opacity", "0.5");
        $('#exportMiddle').css("opacity", "1");
        $('#exportRight').css("opacity", "0.5");
    }
	
    //baseado nos testes feitos, o polinômio de 3o grau que melhor aproxima o tempo de conclusao e' o seguinte
    //function estimatePolynomial(n) { return (0.029585 * n)-(1.3605*Math.pow(10,-5)*Math.pow(n,2))+(3.6018*Math.pow(10,-9)*Math.pow(n,3)); }

    function estimateTime(countdown) {
        var recordinfile = max;
        var file = 0;
        while (recordinfile > maxrecordsperfile) {
            recordinfile = recordinfile - maxrecordsperfile;
            file++;
        }
        console.log('recordinfile'+recordinfile);
        console.log('maxrecordsperfile'+maxrecordsperfile);
        console.log('max'+max);
        console.log('file'+file);
        console.log('estimatePolynomial(maxrecordsperfile)'+estimatePolynomial(maxrecordsperfile));
        console.log('estimatePolynomial(recordinfile)'+estimatePolynomial(recordinfile));
        var hour = Math.floor((estimatePolynomial(recordinfile)+file*estimatePolynomial(maxrecordsperfile))/60);
        var minutes = Math.ceil((estimatePolynomial(recordinfile)+file*estimatePolynomial(maxrecordsperfile))%60);
        if (countdown) {
            $('#sinceCountdown').countdown('destroy');
            $('#sinceCountdown').countdown({since: new Date(), format: 'HMS', description: 'Time elapsed'});
        }
        $( ".estimatedTime" ).html( "Estimated time: "+hour+'h '+minutes+'min');
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
                max = parseInt(json.count);
                $('#start').html(start>max?0:start);
                $('#end').html(end>max?max:end);
                $('#max').html(max);
                //sliderRecordsPerFile();
                slider();
                //$( "#slider" ).slider({range: true,min: 0,max: max,values: [$('#start').html(), $('#end').html()]});
                rs = json.result;
                for(var i in rs){
                    insertLine(rs[i]);
                }
            }
        });
    }
    function insertLine(rs){
        var line ='<tr id="id__ID_" title="_TITLE_"><td style="width:20px;text-indent:0;">_ISPRIVATE_</td><td>_LASTTAXA_</td><td style="width:120px;text-align:center;">_CATALOGNUMBER_</td></tr>';
        var aux = line;

        var btnPrivate = "<div class='btnPrivate'><ul class='iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Private Monitoring Record'><span class='ui-icon ui-icon-locked'></span></li></ul></div>";

        aux = aux.replace('_ID_',rs.id);
        aux = aux.replace('_TITLE_','Institution: '+rs.institution+'<br/>Collection: '+rs.collection);
        aux = aux.replace('_ISPRIVATE_',rs.isrestricted?btnPrivate:'');
        aux = aux.replace('_LASTTAXA_',rs.scientificname);
        aux = aux.replace('_CATALOGNUMBER_',rs.catalognumber);

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

                        var tip = '<div class="tipDiv"><div class="tipKey">Código da instituição</div><div class="tipValue">'+monitoring.institutioncode+'</div><div style="clear:both"></div><div class="tipKey">Código da coleção</div><div class="tipValue">'+monitoring.collectioncode+'</div><div style="clear:both"></div></div>';

                        updateCallback(tip);
                    }
                });
                return '<div class="tipDiv">Loading metadata...</div>';
            }
        });
    }
     
    function sliderRecordsPerFile(){
        $("#sliderRecordsPerFile").slider({
            value:3000,
            min: 50,
            max: max>5000 ? 5000 : max<50 ? 50 : max,
            step: 50,
            slide: function( event, ui ) {
                $( ".maxrecordsperfile" ).html( ui.value + ' records per file');
                maxrecordsperfile = ui.value;
                $(".numfile").html(Math.ceil(max/maxrecordsperfile) + ' total files');
                estimateTime(false);
            }
        });
        $( ".maxrecordsperfile" ).html( $( "#sliderRecordsPerFile" ).slider( "value" ) + ' records per file');
        $(".numfile").html(Math.ceil(max/maxrecordsperfile) + ' total files');
        estimateTime(false);
    }
    function slider(){
        $("#slider").slider({
            range: false,
            orientation:'vertical',
            max:0,
            min:interval - max,
            value:-start,
            stop: function(event, ui) {
                start = - ui.value;
                end = start + interval;
                filter('slider');
            },
            slide:function(event, ui) {
                //$('#start').html(ui.value);
                //$('#end').html((ui.value + interval));
                console.log(- ui.value);
                console.log(- ui.value + interval);
            }
        }).find( ".ui-slider-handle" ).css({
            height: handleSize
        });

    }
</script>

<div id="Notification"></div>

<div class="introText" style="width:93%;">
    <div style="float:left;"><?php echo CHtml::image("images/help/iconelist.png"); ?></div>
    <h1 style="padding-left:10px; float:left;"><?php echo Yii::t('yii', 'Exportar para planilha de monitoramento'); ?></h1>
    <div style="clear:both;"></div>
    <p><?php echo Yii::t('yii', 'Utilize esta ferramenta para transcrever todos os dados de monitoramento presentes no BDD para uma planilha. Uma vez que o BDD tenha concluído o processo, será possível baixar o arquivo.'); ?></p>
</div>

<div class="yiiForm" style="width:95%;">

    <?php echo CHtml::beginForm('','post',array ('id'=>'form')); ?>

    <!-- Filter Phase -->
    <div id="exportLeft" style="width: 381px">
        <div class="title">Selecionar registros</div>
        <div class="icon1"><a href="javascript:unselectFilters();"><?php showIcon("Editar", "ui-icon-pencil", 1); ?></a></div>
        <div style="clear:both;"></div>
        <div class="records"><b><span id="max"></span></b> total de registros selecionados</div>
        <div class="records"><b style="color:red"> ATENÇÃO: É necessário filtrar por "Denominação".</b></div>
        <div class="icon2"><a href="javascript:selectFilters();"><?php showIcon("Próximo", "ui-icon-check", 1); ?></a></div>
    </div>

    <!-- Columns Phase -->
<!--
	    <div id="exportMiddle" >
        <div class="title">Select columns</div>
        <div class="icon1"><a href="javascript:unselectColumns();"><?php showIcon("Edit", "ui-icon-pencil", 1); ?></a></div>
        <div style="clear:both;"></div>
        <div class="columns"><b><span id="checkedColumns"></span></b> total columns selected</div>
        <div class="icon2"><a href="javascript:selectColumns();"><?php showIcon("Next", "ui-icon-check", 1); ?></a></div>startExport
    </div>
-->
    <!-- End Phase -->
    <div id="exportRight" style="width: 381px">
        <div class="title">Iniciar exportação</div>
        <div style="clear:both;"></div>
        <div class="numfile"></div>
        <div class="maxrecordsperfile"></div>
        <div class="estimatedTime"></div>
        <div style="position:absolute; bottom:13px; right:15px;"><input type="button" id="startExportButton" value="Iniciar Exportação" onclick="startExport(); clearDiv(); "/></div>
    </div>
    <div style="clear:both"></div>

    <!-- Filters -->
    <div id="exportFilters">
        <div class="filterLabel">Filtro</div>
        <div class="filterMiddle"><a rel="lightbox" href="index.php?r=help&helpfield=filter"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
        <div style="clear:both"></div>
        <div class="filterField">
            <input type="text" id="searchField" style="border: 1px solid #DDDDDD;background: #FFFFFF;color: #013605;font-size: 1.3em; width:410px;" />
            <input type="hidden" id="id"/>
        </div>
        <div style="clear:both"></div>
        <div class="filterList" id="filterList"></div>

        <div class="newslider" id="slider"></div>
        <div id="rs" class="item">
            <table id="tablelist" class="list">
                <thead>
                    <tr>
                        <th></th>
                        <th>Elementos taxonômicos</th>
                        <th style="text-align:center;">Número de catálogo</th>
                    </tr>
                </thead>
                <tbody id="lines">
                <tbody>
            </table>
        </div>
        <div style="clear:both"></div>
    </div>

    <!-- Columns -->
   

    <!-- End -->
    <div id="exportEnd">
        <div class="maxrecordsperfile"></div>
        <div class="estimatedTime"></div>
        <div style="clear:both"></div>

        <div id="loading" style="background-color: #F9F9F9;margin: 50px; display:none">
            <table  style="background-color: #F9F9F9;" align="center" width="100%">
                <tr align="center">
                    <td><?php echo Yii::t('yii', 'Por favor, aguarde enquando o BDD converte os dados para uma planilha.'); ?>
                        <br/><?php echo Yii::t('yii', 'Isso pode levar alguns minutos, dependendo do tamanho do banco de dados.'); ?></td>
                </tr>
                <tr align="center">
                    <th><img width="35px" src="images/main/ajax-loader.gif"/></th>
                </tr>
                <tr align="center">
                    <td><?php echo Yii::t('yii','Working...'); ?></td>
                </tr>
            </table>
        </div>

        <div id="sinceCountdown"></div>

        <div id="result">
            <div id="divlink">
                <div class="linkEnd" style="clear:both;"></div>
            </div>
            <div style="clear:both;"></div>
            <span id="log"></span>
        </div>
    </div>
    <?php echo CHtml::endForm(); ?>
</div>
