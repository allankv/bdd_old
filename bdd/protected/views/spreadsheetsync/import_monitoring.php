<?php include_once("protected/extensions/config.php"); ?>
<script type="text/javascript" src="js/Maintain.js"></script>

<link href="js/valums/client/fileuploader.css" rel="stylesheet" type="text/css">

<style>
	#tableButtons {
		border-radius: 0.4em;
		-moz-border-radius: 0.4em;
		vertical-align: middle;
		padding: 15px;
		width: 70.5%;
		margin-left: auto;
		margin-right: auto;
		background-color: #F4EFD9;
		border: 1px solid #F6A828;
		height: 22px;
		padding-left: 25px;
	}
	#btnInformative {
		float: left;
		position: relative;
		left: 100px;
	}
	#infoInformative {
		float: left;
		position: relative;
		left: 120px;
		top: -3px;
	}
	#btnAttention {
		float: left;
		position: relative;
		left: 155px;
	}
	#infoAttention {
		float: left;
		position: relative;
		left: 175px;
		top: -3px;
	}
	#btnProblem {
		float: left;
		position: relative;
		left: 215px;
	}
	#infoProblem {
		float: left;
		position: relative;
		left: 235px;
		top: -3px;
	}
	#importMonitoringMessages {
		width: 74.7%;
		margin-left: 111px;
		margin-bottom: 15px;
		height: 400px;
		overflow: scroll;		
	}
</style>
<script src="js/valums/client/fileuploader.js" type="text/javascript"></script>
    <script>
    	$(function() {
    		$("#importMonitoringMessages").tabs();
    		/*
    		var rs = [];
			            	
        	var item = new Object();
        	item.type = "attention";
        	item.line = 5;
        	item.column = "Scientific name";
        	item.implication = "Registro criado";
        	item.messages = "muahahahah euhaouhuohrue horuehouheaw hduahweur";
        	
        	rs[0] = item;
        	
        	var item = new Object();
        	item.type = "attention";
        	item.line = 6;
        	item.column = "Species";
        	item.implication = "Campo omitido";
        	item.messages = "muahahahah euhaouhuohrue horuehouheaw hduahweur";
        	
        	rs[1] = item;
        	
        	var item = new Object();
        	item.type = "problem";
        	item.line = 2;
        	item.column = "Catalog number";
        	item.implication = "Campo omitido";
        	item.messages = "muahahahah euhaouhuohrue horuehouheaw hduahweur";
        	
        	rs[2] = item;
        	
        	var item = new Object();
        	item.type = "informative";
        	item.line = 2;
        	item.column = "Collection code";
        	item.implication = "Registro criado";
        	item.messages = "muahahahah euhaouhuohrue horuehouheaw hduahweur";
        	
        	rs[3] = item;
        	
        	var item = new Object();
        	item.type = "informative";
        	item.line = 5;
        	item.column = "Institution code";
        	item.implication = "Registro atualizado";
        	item.messages = "muahahahah euhaouhuohrue horuehouheaw hduahweur";
        	
        	rs[4] = item;
        	
        	for(var i in rs) {
            	insertLine(rs[i]);
        	}
        	*/
    	});        
        function createUploader(){      
        	configNotify();
        	$(':button').button();      
        	$('#importLoading').hide();
            var uploader = new qq.FileUploader({
                element: document.getElementById('file'),
                action: 'js/valums/server/php.php',
                debug: false,
                onComplete: function(id, fileName, responseJSON){
					$('#file').hide();
                	$('#importLoading').fadeIn(2000);                	
                	$.ajax({url:'index.php?r=spreadsheetsync/startImport_monitoring',
	    		        type: 'POST',
	    	        	data: {'fileName':responseJSON.fileName},
		    	        dataType: "json",
			            success: function(json){
							var created =0;
							var updated =0;
							if($.isArray(json.list[0].messages)){
				            	for(var i in json.list[0].messages) {
									if(json.list[0].messages[i].implications=="Registro criado.")
				            			created++;
				            		if(json.list[0].messages[i].implications=="Registro atualizado.")
			    	        			updated++;
				    	        	insertLine(json.list[0].messages[i]);
			            		}
			            	}else{
			            		if(json.list[0].messages.implications=="Registro criado.")
			            			created++;
			            		if(json.list[0].messages.implications=="Registro atualizado.")
			            			updated++;
				            	insertLine(json.list[0].messages);
			            	}
			            	
			            	$("#importMonitoringMessages").show("slide");
			            	
					    	//var link = '<div style="float:left; position:relative; left:50%; margin-right:15px;"><a id="link" target="_blank" href="'+json.url+'"><img width="35px" src="images/main/excel.png"/><br>Download</a></div>';
							//$('#divlink').show();
		                	//$('#result').fadeIn(2000);
			                var log = [];
			                log[0] = '<b># '+created+' registros criados.</b>';
			                log[1] = '<b># '+updated+' registros atualizados.</b>';
			                log[2] = '<b># '+(created+updated)+' total de registros.</b>';

		        	        showMessage(log, true, true);
		        	        $('#importLoading').fadeOut(2000);
		            	    //$('#divlink').html(link);
					    	//$('#sinceCountdown').countdown('pause');			    		    	
	            			//$('#sinceCountdown').countdown('destroy');              
	        		    }
			        });
                },
            });           
        }
        
        function insertLine(rs){
	        var line ='<tr id="id__ID_" title="_TITLE_"><td style="text-align: center">_LINE_</td><td>_COLUMN_</td><td>_IMPLICATION_</td><td>_MESSAGES_</td></tr>';
	        var aux = line;
	
	        //var btnPrivate = "<div class='btnPrivate'><ul class='iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Private Monitoring Record'><span class='ui-icon ui-icon-locked'></span></li></ul></div>";
	
	        //aux = aux.replace('_ID_',rs.id);
	        //aux = aux.replace('_TITLE_','Institution: '+rs.institution+'<br/>Collection: '+rs.collection);
	        aux = aux.replace('_LINE_',rs.row);
	        aux = aux.replace('_COLUMN_',rs.column);
	        aux = aux.replace('_IMPLICATION_',rs.implications);
	        aux = aux.replace('_MESSAGES_', rs.message);
	
	        if (rs.type == "Informativo.") $("#linesInformative").append(aux);
	        else if (rs.type == "Atenção.") $("#linesAttention").append(aux);
	        else if (rs.type == "Problema.") $("#linesProblem").append(aux);
        }
        
/* 
        function selectInformative(){
	    	if($('#divAttention').is(':visible')) $("#divAttention").hide("slide");
        	if($('#divProblem').is(':visible')) $("#divProblem").hide("slide");
        	$("#divInformative").show("slide"); 
        }
        function selectAttention(){
        	if($('#divInformative').is(':visible')) $("#divInformative").hide("slide");
        	if($('#divProblem').is(':visible')) $("#divProblem").hide("slide");
        	$("#divAttention").show("slide");
        }
        function selectProblem(){
        	if($('#divInformative').is(':visible')) $("#divInformative").hide("slide");
        	if($('#divAttention').is(':visible')) $("#divAttention").hide("slide");
        	$("#divProblem").show("slide");
        }
*/
        window.onload = createUploader;     
</script>   
<div id="Notification"></div>

<div class="introText">
    <div style="float:left;"><?php echo CHtml::image("images/help/iconelist.png"); ?></div>
    <h1 style="padding-left:10px; float:left;"><?php echo Yii::t('yii', 'Importar de uma planilha de monitoramento'); ?></h1>
    <div style="clear:both;"></div>
    <p><?php echo Yii::t('yii', 'Utilize essa ferramenta para importar os dados de uma planilha para o banco de dados do BDD. Para criar o arquivo de planilha, por favor utilize o modelo fornecido e siga as recomendações, ambos abaixo.'); ?></p>

    <table align="center" width="100%">
            <tbody>
                <tr align="center">
                <tr align="center">
                    <td>
                        <a style="text-decoration:none; " href="/tmp/PanTrap_Ver01.xlsx" target="_blank">
                            <img width="35px" src="images/main/excel.png">
                            <br>
                            Modelo de arquivo de planilha
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>

</div>

<div class="importContainer" style="height: auto; margin-bottom: 15px;">
	<div id="importStart">
			<div class="privateRecord" id="file">		
		<noscript>			
			<p>Por favor, habilite o Javascript em seu navegador para utilizar o uploader.</p>
		</noscript>         
			</div>
	</div>	
	<div id="importLoading">
		<div><img width="25px" src="images/main/ajax-loader2.gif"/></div>
	    <div class="loading"><?php echo Yii::t('yii', 'Por favor, aguarde enquanto seu arquivo está sendo importado para o BDD. Isso pode levar alguns minutos dependendo do tamanho da sua planilha e da velocidade de sua conexão com a internet.'); ?></div>
	    <button onclick="window.open('<?php echo getCurrentURL(); ?>');">Continue utilizando o BDD</button>
	</div>
 </div>
 
 <div id="importMonitoringMessages" style="display: none">
 
 <!--
 <div id="tableButtons">
	 <div id='btnInformative'><a href="javascript:selectInformative();"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Informativo'><span class='ui-icon ui-icon-check'></span></li></ul></a></div>
	 <button id='infoInformative' onclick="javascript:selectInformative()">Informativo</button>
	 <div id='btnAttention'><a href="javascript:selectAttention();"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Atenção'><span class='ui-icon ui-icon-notice'></span></li></ul></a></div>
	 <button id='infoAttention' onclick="javascript:selectAttention()">Atenção</button>
	 <div id='btnProblem'><a href="javascript:selectProblem();"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Problema'><span class='ui-icon ui-icon-cancel'></span></li></ul></a></div>
	 <button id='infoProblem' onclick="javascript:selectProblem()">Problemas</button>
 </div>
 -->
  
 <ul>
 	<li><a href="#divProblem"><span class="ui-icon ui-icon-circle-close" style="float: left; margin-right: 3px;"></span>Problemas</a></li>
 	<li><a href="#divAttention"><span class="ui-icon ui-icon-alert" style="float: left; margin-right: 3px;"></span>Atenção</a></li>
 	<li><a href="#divInformative"><span class="ui-icon ui-icon-info" style="float: left; margin-right: 3px;"></span>Informativo</a></li>
 </ul>
 
 <div id="divProblem">
    <table class="list" style="width: 672px; margin-top: 10px; margin-left: -16px;">
        <thead>
            <tr>
                <th>Linha</th>
                <th>Coluna</th>
                <th>Implicações</th>
                <th>Mensagens</th>
            </tr>
        </thead>
        <tbody id="linesProblem">
        <tbody>
    </table>
 </div>
 <div id="divAttention">
    <table class="list" style="width: 672px; margin-top: 10px; margin-left: -16px;">
        <thead>
            <tr>
                <th>Linha</th>
                <th>Coluna</th>
                <th>Implicações</th>
                <th>Mensagens</th>
            </tr>
        </thead>
        <tbody id="linesAttention">
        <tbody>
    </table>
 </div>
 <div id="divInformative">
    <table class="list" style="width: 672px; margin-top: 10px; margin-left: -16px;">
        <thead>
            <tr>
                <th>Linha</th>
                <th>Coluna</th>
                <th>Implicações</th>
                <th>Mensagens</th>
            </tr>
        </thead>
        <tbody id="linesInformative">
        <tbody>
    </table>
 </div>

 
 
 </div>
