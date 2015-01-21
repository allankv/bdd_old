<?php include_once("protected/extensions/config.php"); ?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="js/analysis.sliding.form.js"></script>
<link rel="stylesheet" type="text/css" href="css/analysis.sliding.form.css"/>
<script type="text/javascript" src="js/jit/jit.js"></script>
<script type="text/javascript" src="js/jit/taxon.spacetree.js"></script>
<link rel="stylesheet" type="text/css" href="js/jit/taxon.spacetree.css"/>
<script type="text/javascript" src="js/List.js"></script>
<script type="text/javascript" src="js/AnalysisMonitoring.js"></script>

<script type="text/javascript" src="http://canvg.googlecode.com/svn/trunk/rgbcolor.js"></script> 
<script type="text/javascript" src="http://canvg.googlecode.com/svn/trunk/canvg.js"></script> 

<link rel="stylesheet" type="text/css" href="css/analysis.css">

<style>
#navigation ul li a p {
    position: absolute;
    left: 50%;
    width: 122px;
    margin-left: -61px;
    margin-top: 0px;
}
</style>

<script type="text/javascript">
    var start = 0;
    var end = 10;
    var max = 10;
    var interval = 15;
    var handleSize = 50;

    function filter(senderValue){

        //If it's BOOT or a filter, reset the offset to 0. Otherwise, leave it as is.
        if (senderValue == null)
            {start = 0;}

        $.ajax({ type:'POST',
            url:'index.php?r=analysismonitoring/filter',
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
        var line ='<tr id="id__ID_" title="_TITLE_"><td style="width:20px; text-indent:0;">_ISPRIVATE_</td><td style="text-indent:5px;">_LASTTAXA_</td><td style="text-align:center;">_DENOMINATION_</td><td style="text-align:center;">_COLLECTIONCODE_</td><td style="text-align:center;">_CATALOGNUMBER_</td></tr>';
        var aux = line;
        
        var btnPrivate = "<div class='btnPrivate'><ul class='iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Private Monitoring Record'><span class='ui-icon ui-icon-locked'></span></li></ul></div>";

        aux = aux.replace('_ID_',rs.id);
        aux = aux.replace('_TITLE_','Institution: '+rs.institution);
        aux = aux.replace('_ISPRIVATE_',rs.isrestricted?btnPrivate:'');
        aux = aux.replace('_LASTTAXA_',rs.scientificname);
        aux = aux.replace('_DENOMINATION_',rs.denomination);
        aux = aux.replace('_COLLECTIONCODE_',rs.collection);
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

                                var tip = '<div class="tipDiv"><div class="tipKey">Codigo da Instituicao</div><div class="tipValue">'+monitoring.institutioncode+'</div><div style="clear:both"></div><div class="tipKey">Tecnica de Coleta</div><div class="tipValue">'+monitoring.technicalcollection+'</div><div style="clear:both"></div><div class="tipKey">Cultura</div><div class="tipValue">'+monitoring.culture+'</div><div style="clear:both"></div></div>';

                                updateCallback(tip);
                            }
                        });
                return '<div class="tipDiv">Loading metadata...</div>';
            }
        });
        
    }

    function slider() {
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

    $(document).ready(bootAnalysis);
    
    function bootAnalysis() {
    	configIcons();
    	configCatComplete('#id','#searchField', 'analysismonitoring','#filterList');
        filter();

        $('#buttonset').buttonset();
        
        $(".printButton").button();

        var helpTip = '<div style="font-weight:normal;">Utilize esse campo para filtrar os resultados abaixo. Diferentes termos de diferentes categorias (ex.: Codigo de Instituicao e Codigo de Colecao) resultarao em consultas E. Diferentes termos da mesma categoria, entretanto, resultarao em uma consulta OU.</div>';

        $('#searchField').poshytip({
            className: 'tip-twitter',
            content: helpTip,
            showOn: 'focus',
            alignTo: 'target',
            alignX: 'right',
            alignY: 'center',
            offsetX: 35
        });
        
        $('#chart4-1').poshytip({
            className: 'tip-twitter',
            content: "This chart can be dragged.",
            showOn: 'hover',
            alignTo: 'target',
            alignX: 'inner-right',
            alignY: 'top',
            offsetY: 15
        });
        
        $('#Notification').jnotifyInizialize({
            oneAtTime: false,
            appendType: 'append'
        })
        .css({
            'position': 'fixed',
            'marginTop': '-130px',
            'right': '10px',
            'width': '400px',
            'z-index': '9999'
        });
    }
    
    function printAnalysisMonitoring(controller) {
    
	    var windowReference = window.open('index.php?r=loadingfile/goToShow');  
	      	
    	// let's generate the images!
		var canvas = document.getElementById('canvas');
		var svg;
		// generate chart image
    	svg = $("#hiddenChart div div").html().replace(/>\s+/g, ">").replace(/\s+</g, "<").replace(" xlink=", " xmlns:xlink=").replace(/\shref=/g, " xlink:href="); //retiramos todos os espaços entre as tags e substituímos " xlink=" por " xmlns:xlink=" e " href=" por " xlink:href=", caso o navegador tenha alterado (Chrome, por exemplo).
        canvg(canvas, svg);
		var imgChart = canvasToImage("rgba(255,255,255,1)", canvas);
						
		switch (controller) {
			case 'basisofrecord':
				controller = 'printBasisOfRecord';
				break;
			case 'institutioncode':
				controller = 'printInstitutionCode';
				break;
			case 'collectioncode':
				controller = 'printCollectionCode';
				break;
		}
		
    	$.ajax({
	    	type:'POST',
	        url:'index.php?r=analysismonitoring/' + controller,
	        data: {
	        	'list': jFilterList,
	        	'chart': imgChart,
	        	'colors': colors
	        },
	        dataType: "json",
	        success:function(json) {
		        windowReference.location = json;
	        }
    	});	   
    }
</script>

<canvas id="canvas" style="display: none"></canvas>
<img id="imagem" />

<div style="display: none;" id="hiddenChart"></div>

<div id="Notification"></div>

<div class="introText">
    <h1><?php echo Yii::t('yii','Ferramenta de análise estatística para Registros de Monitoramento'); ?></h1>
    <p><?php echo Yii::t('yii','Esta ferramenta oferece um conjunto de visualizações e análises estatísticas dos Registros de Monitoramento do atual banco de dados.'); ?></p>
</div>

<div class="yiiForm" style="width:80%; margin-bottom:20px; margin-left:160px;">
    <div id="contentAnalysis">
        <div id="wrapperAnalysis">
            <div id="steps">
                <form>
                    <fieldset class="step">
                        <legend>Filtro</legend>
                        <div id="filter" style="margin-top:80px; margin-left:-7px;">
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
                                <div class="filterList">
                                <div id="filterList"></div>
                                </div>
                            </div>
                            <table id="tablelist" class="list">
                                <thead><tr><th></th><th style="text-align:left;">Elementos taxonômicos</th><th>Denominação</th><th>Código da coleção</th><th>Número de catálogo</th></tr></thead>
                                <tbody id="lines"></tbody>
                            </table>
                        </div>
                    </fieldset>
                    <fieldset class="step">
                        <legend>Base de registro</legend>
                        <div class="pieChart" id="chart1"></div>
                        <div style="width:600px; margin-left:auto; margin-right:auto;" id="table1"></div>
                        <div class="saveButton" style="width: 96.5%; display: hidden;" id="print1">
	                    	<input class="printButton" type="button" value="Print" onclick="printAnalysisMonitoring('basisofrecord')">
						</div>                    </fieldset>
                    <fieldset class="step">
                        <legend>Código da Instituição</legend>
                        <div class="pieChart" id="chart2" ></div>
                        <div style="width:600px; margin-left:auto; margin-right:auto;" id="table2"></div>
                        <div class="saveButton" style="width: 96.5%; display: hidden;" id="print2">
	                    	<input class="printButton" type="button" value="Print" onclick="printAnalysisMonitoring('institutioncode')">
						</div>                     
                    </fieldset>
                    <fieldset class="step">
                        <legend>Código da Coleção</legend>
                        <div class="pieChart" id="chart3" ></div>
                        <div style="width:600px; margin-left:auto; margin-right:auto;" id="table3"></div>
                        <div class="saveButton" style="width: 96.5%; display: hidden;" id="print3">
	                    	<input class="printButton" type="button" value="Print" onclick="printAnalysisMonitoring('collectioncode')">
						</div>                
                    </fieldset>
                    <fieldset class="step">
                        <legend>Árvore Taxonômica</legend>                        
                        
                        <div id="chart4-1">                        
                        <div id="container"><div id="log"></div><div id="infovis"></div></div>                        
						</div>
						<div id="buttonset">
							<input type="radio" id="r-left" name="orientation" checked="checked" value="left" /><label for="r-left">Left</label>
							<input type="radio" id="r-top" name="orientation" value="top" /><label for="r-top">Top</label>
							<input type="radio" id="r-bottom" name="orientation" value="bottom" /><label for="r-bottom">Bottom</label>
							<input type="radio" id="r-right" name="orientation" value="right" /><label for="r-right">Right</label>
	            		</div>
                        <div style="width:600px;" id="chart4-2"></div>
                        <div style="margin-top:10px; width:600px; margin-left:auto; margin-right:auto;" id="table4"></div>                
                    </fieldset>
                    <fieldset class="step">
                        <legend>País</legend>
                        <div style="width:600px; margin-left:auto; margin-right:auto;" id="chart5" ></div>
                        <div style="margin-top:10px; width:600px; margin-left:auto; margin-right:auto;" id="table5"></div>                
                    </fieldset>
                    <fieldset class="step">
                        <legend>Tempo</legend>
                        <div id="chart6" ></div>
                        <div style="width:600px; margin-left:auto; margin-right:auto;" id="table6"></div>                
                    </fieldset>
                </form>
            </div>
            <div id="navigation" style="display:none;">
                <ul>
                	<li class="selected">
                        <a><p>Filtro</p></a>
                    </li>
                    <li onclick="javascript:drawBasisOfRecordMonitoring();">
                        <a><p>Base de Registro</p></a>
                    </li>
                    <li onclick="javascript:drawInstitutionCodeMonitoring();">
                        <a><p>Código da Instituição</p></a>
                    </li>
                    <li onclick="javascript:drawCollectionCodeMonitoring();">
                        <a><p>Código da Coleção</p></a>
                    </li>
                    <li onclick="javascript:drawTaxonMonitoring();">
                        <a><p>Taxon</p></a>
                    </li>
                    <li onclick="javascript:drawCountryMonitoring();">
                        <a><p>País</p></a>
                    </li>
                    <li onclick="javascript:drawTimeMonitoring();">
                        <a><p>Tempo</p></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>