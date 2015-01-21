<?php include_once("protected/extensions/config.php"); ?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="js/analysis.sliding.form.js"></script>
<link rel="stylesheet" type="text/css" href="css/analysis.sliding.form.css"/>
<script type="text/javascript" src="js/jit/jit.js"></script>
<script type="text/javascript" src="js/jit/taxon.spacetree.js"></script>
<link rel="stylesheet" type="text/css" href="js/jit/taxon.spacetree.css"/>
<script type="text/javascript" src="js/List.js"></script>
<script type="text/javascript" src="js/Analysis.js"></script>

<script type="text/javascript" src="http://canvg.googlecode.com/svn/trunk/rgbcolor.js"></script> 
<script type="text/javascript" src="http://canvg.googlecode.com/svn/trunk/canvg.js"></script> 

<link rel="stylesheet" type="text/css" href="css/analysis.css">

<script type="text/javascript">
    var start = 0;
    var end = 10;
    var max = 10;
    var interval = 15;
    var handleSize = 50;

    $(document).ready(bootAnalysis);
    
    function bootAnalysis() {
    	configIcons();
    	configCatComplete('#id','#searchField', 'analysis','#filterList');
        filter();
                
        $('#buttonset').buttonset();
        
        $(".printButton").button();

        var helpTip = '<div style="font-weight:normal;">Use this box to filter the results below. Different terms for different categories (e.g.: Institution Code and Collection Code) will result in an AND search. Different terms for the same category, however, will result in an OR search.</div>';

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

    function filter(senderValue) {
        if (senderValue == null) {
        	start = 0;
        }

        $.ajax({
        	type:'POST',
            url:'index.php?r=analysis/filter',
            data: {'limit':interval, 'offset':start, 'list':jFilterList},
            dataType: 'json',
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

                for (var i in rs) {                    
                    insertLine(rs[i]);
                }

                configIcons();
            }
        });
    }
    
    function insertLine(rs) {
        var line ='<tr id="id__ID_" title="_TITLE_"><td style="width:20px; text-indent:0;">_ISPRIVATE_</td><td style="text-indent:5px;">_LASTTAXA_</td><td style="width:200px; text-align:center;">_CATALOGNUMBER_</td></tr>';
        var aux = line;

        var btnPrivate = "<div class='btnPrivate'><ul class='iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Private Specimen Record'><span class='ui-icon ui-icon-locked'></span></li></ul></div>";
        var btnUpdate = "<div class='btnUpdate'><a href='index.php?r=specimen/goToMaintain&id="+rs.id+"'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Update Specimen Record'><span class='ui-icon ui-icon-pencil'></span></li></ul></a></div>";
        var btnDelete = "<div class='btnDelete'><a href='javascript:deleteSpecimenRecord("+rs.id+");'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Delete Specimen Record'><span class='ui-icon ui-icon-trash'></span></li></ul></a></div><div style='clear:both'></div>";

        aux = aux.replace('_ID_',rs.id);
        aux = aux.replace('_TITLE_','Institution: '+rs.institution+'<br/>Collection: '+rs.collection);
        aux = aux.replace('_ISPRIVATE_',rs.isrestricted?btnPrivate:'');
        
        var taxon;
        if (rs.scientificname != '' && rs.scientificname != null) {
        	taxon = rs.scientificname + " (Scientific Name)";
        }
        else if (rs.infraspecificepithet != '' && rs.infraspecificepithet != null) {
        	taxon = rs.infraspecificepithet + " (Infraspecific Epithet)";
        }
        else if (rs.specificepithet != '' && rs.specificepithet != null) {
        	taxon = rs.specificepithet + " (Specific Epithet)";
        }
        else if (rs.subgenus != '' && rs.subgenus != null) {
        	taxon = rs.subgenus + " (Subgenus)";
        }
        else if (rs.genus != '' && rs.genus != null) {
        	taxon = rs.genus + " (Genus)";
        }
        else if (rs.family != '' && rs.family != null) {
        	taxon = rs.family + " (Family)";
        }
        else if (rs.order != '' && rs.order != null) {
        	taxon = rs.order + " (Order)";
        }
        else if (rs.class != '' && rs.class != null) {
        	taxon = rs.class + " (Class)";
        }
        else if (rs.phylum != '' && rs.phylum != null) {
        	taxon = rs.phylum + " (Phylum)";
        }
        else if (rs.kingdom != '' && rs.kingdom != null) {
        	taxon = rs.kingdom + " (Kingdom)";
        }

        aux = aux.replace('_LASTTAXA_',taxon);
        aux = aux.replace('_CATALOGNUMBER_',rs.catalognumber);

        $("#lines").append(aux);
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
    
    function printAnalysis(controller) {
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
	        url:'index.php?r=analysis/' + controller,
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
    
    function printDataQuality() {
	    var windowReference = window.open('index.php?r=loadingfile/goToShow');
	        	
    	// let's generate the images!
		var canvas = document.getElementById('canvas');
		var svg;
		
		// generate chart image of "Total of referenced records"
    	svg = $("#chartDQ1 div div").html().replace(/>\s+/g, ">").replace(/\s+</g, "<").replace(" xlink=", " xmlns:xlink=").replace(/\shref=/g, " xlink:href="); //retiramos todos os espaços entre as tags e substituímos " xlink=" por " xmlns:xlink=" e " href=" por " xlink:href=", caso o navegador tenha alterado (Chrome, por exemplo).
        canvg(canvas, svg);
		var chartDQ1 = canvasToImage("rgba(255,255,255,1)", canvas);
		
		// generate chart image of "Total of records validated by COL"
		svg = $("#chartDQ2 div div").html().replace(/>\s+/g, ">").replace(/\s+</g, "<").replace(" xlink=", " xmlns:xlink=").replace(/\shref=/g, " xlink:href="); //retiramos todos os espaços entre as tags e substituímos " xlink=" por " xmlns:xlink=" e " href=" por " xlink:href=", caso o navegador tenha alterado (Chrome, por exemplo).
        canvg(canvas, svg);
		var chartDQ2 = canvasToImage("rgba(255,255,255,1)", canvas);
		
		// generate chart image of "Total of records with event date"
		svg = $("#chartDQ3 div div").html().replace(/>\s+/g, ">").replace(/\s+</g, "<").replace(" xlink=", " xmlns:xlink=").replace(/\shref=/g, " xlink:href="); //retiramos todos os espaços entre as tags e substituímos " xlink=" por " xmlns:xlink=" e " href=" por " xlink:href=", caso o navegador tenha alterado (Chrome, por exemplo).
        canvg(canvas, svg);
		var chartDQ3 = canvasToImage("rgba(255,255,255,1)", canvas);
		
		// generate chart image of "Total of records with uncertainty of geographic coordinates"
		svg = $("#chartDQ4 div div").html().replace(/>\s+/g, ">").replace(/\s+</g, "<").replace(" xlink=", " xmlns:xlink=").replace(/\shref=/g, " xlink:href="); //retiramos todos os espaços entre as tags e substituímos " xlink=" por " xmlns:xlink=" e " href=" por " xlink:href=", caso o navegador tenha alterado (Chrome, por exemplo).
        canvg(canvas, svg);
		var chartDQ4 = canvasToImage("rgba(255,255,255,1)", canvas);
		
		svg = $("#chartDQ5 div div").html().replace(/>\s+/g, ">").replace(/\s+</g, "<").replace(" xlink=", " xmlns:xlink=").replace(/\shref=/g, " xlink:href="); //retiramos todos os espaços entre as tags e substituímos " xlink=" por " xmlns:xlink=" e " href=" por " xlink:href=", caso o navegador tenha alterado (Chrome, por exemplo).
        canvg(canvas, svg);
		var chartDQ5 = canvasToImage("rgba(255,255,255,1)", canvas);
		
	    $.ajax({
	    	type:'POST',
	        url:'index.php?r=analysis/printDataQuality',
	        data: {
	        	'chartDQ1': chartDQ1,
	        	'chartDQ2': chartDQ2,
	        	'chartDQ3': chartDQ3,
	        	'chartDQ4': chartDQ4,
	        	'chartDQ5': chartDQ5
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
    <h1><?php echo Yii::t('yii','BDD Statistical Analysis Tool'); ?></h1>
    <p><?php echo Yii::t('yii','This tool provides a set of visualizations and statistical analyses of the current specimen occurrence records database.'); ?></p>
</div>

<div class="yiiForm" style="width:80%; margin-bottom:20px; margin-left:160px;">
    <div id="contentAnalysis">
        <div id="wrapperAnalysis">
            <div id="steps">
                <form>
                    <fieldset class="step">
                        <legend>Filter</legend>
                        <div id="filter" style="margin-top:80px; margin-left:-7px;">
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
                            <table id="tablelist" class="list">
                                <thead><tr><th></th><th style="text-align:left;">Taxonomic elements</th><th>Catalog number</th></tr>
                                </thead>
                                <tbody id="lines"></tbody>
                            </table>
                        </div>
                    </fieldset>
                    <fieldset class="step">
                        <legend>Basis of Record</legend>
                        <div class="pieChart" id="chart1"></div>
                        <div style="width:600px; margin-left:auto; margin-right:auto;" id="table1"></div>
                        <div class="saveButton" style="width: 96.5%; display: hidden;" id="print1">
	                    	<input class="printButton" type="button" value="Print" onclick="printAnalysis('basisofrecord')">
						</div>
					</fieldset>
                    <fieldset class="step">
                        <legend>Institution Code</legend>
                        <div class="pieChart" id="chart2" ></div>
                        <div style="width:600px; margin-left:auto; margin-right:auto;" id="table2"></div>
                        <div class="saveButton" style="width: 96.5%; display: hidden;" id="print2">
	                    	<input class="printButton" type="button" value="Print" onclick="printAnalysis('institutioncode')">
						</div>               
                    </fieldset>
                    <fieldset class="step">
                        <legend>Collection Code</legend>
                        <div class="pieChart" id="chart3" ></div>
                        <div style="width:600px; margin-left:auto; margin-right:auto;" id="table3"></div>
                        <div class="saveButton" style="width: 96.5%; display: hidden;" id="print3">
	                    	<input class="printButton" type="button" value="Print" onclick="printAnalysis('collectioncode')">
						</div>              
                    </fieldset>
                    <fieldset class="step">
                        <legend>Taxonomic Tree</legend>                        
                        
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
                        <legend>Country</legend>
                        <div style="width:600px; margin-left:auto; margin-right:auto;" id="chart5" ></div>
                        <div style="margin-top:10px; width:600px; margin-left:auto; margin-right:auto;" id="table5"></div>                
                    </fieldset>
                    <fieldset class="step">
                        <legend>Time</legend>
                        <div id="chart6" ></div>
                        <div style="width:600px; margin-left:auto; margin-right:auto;" id="table6"></div>                
                    </fieldset>
                    <fieldset class="step">
                        <legend>Data Quality Measures</legend>
                        <div class="pieChart" style="margin-top: 20px" id="chartDQ1"></div>
                        <div class="pieChart" id="chartDQ2"></div>
                        <div class="pieChart" id="chartDQ3"></div>
                        <div class="pieChart" id="chartDQ4"></div>
                        <div class="pieChart" id="chartDQ5" style="height:450px"></div>
                        <div class="saveButton" style="width: 96.5%; display: hidden;">
	                    	<input class="printButton" type="button" value="Print" onclick="printDataQuality()">
						</div>            
                    </fieldset>
                </form>
            </div>
            <div id="navigation" style="display:none;">
                <ul>
                	<li class="selected">
                        <a>Filter</a>
                    </li>
                    <li onclick="javascript:drawBasisOfRecord();">
                        <a>Basis of Record</a>
                    </li>
                    <li onclick="javascript:drawInstitutionCode();">
                        <a>Institution Code</a>
                    </li>
                    <li onclick="javascript:drawCollectionCode();">
                        <a>Collection Code</a>
                    </li>
                    <li onclick="javascript:drawTaxon();">
                        <a>Taxon</a>
                    </li>
                    <li onclick="javascript:drawCountry();">
                        <a>Country</a>
                    </li>
                    <li onclick="javascript:drawTime();">
                        <a>Time</a>
                    </li>
                    <li onclick="javascript:drawDataQuality();">
                    	<a>Data Quality</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
