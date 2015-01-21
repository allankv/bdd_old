var loading = '<div id="loading"><img style="margin-top:180px;" src="images/main/ajax-loader4.gif"></img><div style="padding-left:12px; font-weight:bold; color:#BB7700; padding-top:10px; text-shadow:1px 1px 3px #777;">Loading...</div></div>';

var loadingPie = '<div id="loading"><img style="margin-top:180px; margin-left:110px;" src="images/main/ajax-loader4.gif"></img><div style="margin-left:110px; padding-left:12px; font-weight:bold; color:#BB7700; padding-top:10px; text-shadow:1px 1px 3px #777;">Loading...</div></div>';

google.load('visualization', '1', {packages:['corechart', 'geomap', 'table', 'orgchart', 'motionchart']});

// pie chart auxiliar
var colors = ["#FF0F00", "#FF6600", "#FF9E01", "#FCD202", "#F8FF01", "#B0DE09", "#04D215", "#0D8ECF", "#0D52D1", "#2A0CD0", "#8A0CCF", "#CD0D74", "#754DEB", "#DDDDDD", "#999999", "#333333", "#000000", "#57032A", "#CA9726", "#990000", "#4B0C25"];

function getRandomColor() {
	var letters = '0123456789ABCDEF'.split('');
	var color = '#';
	for (var i = 0; i < 6; i++ ) {
	color += letters[Math.round(Math.random() * 15)];
	}
	return color;
}

function updateChartColors(numberOfRows) {
	if (numberOfRows <= 21) {
		colors = ["#FF0F00", "#FF6600", "#FF9E01", "#FCD202", "#F8FF01", "#B0DE09", "#04D215", "#0D8ECF", "#0D52D1", "#2A0CD0", "#8A0CCF", "#CD0D74", "#754DEB", "#DDDDDD", "#999999", "#333333", "#000000", "#57032A", "#CA9726", "#990000", "#4B0C25"];
	} else {
		for (var i = 0; i < numberOfRows - 21; i++) {
			colors.push(getRandomColor());
		}
	}
}

/*  Analysis of Specimen Occurrence Records  */

// Visualization functions
function drawPieChart(json, id, lowercase, uppercase) {
	if (json.result.length > 0) {
	    var data = new google.visualization.DataTable();
	    data.addColumn('string', uppercase);
	    data.addColumn('number', 'Number of Records');
	
	    data.addRows(json.result.length);           
	    for (var i in json.result) {
	        data.setValue(parseInt(i, 10), 0, json.result[i][lowercase]);
	        data.setValue(parseInt(i, 10), 1, parseInt(json.result[i]['count'], 10));
	    }
	    
	    updateChartColors(json.result.length);
	    
	    var options = {
	    	width: 800,
	    	height: 450,
	    	backgroundColor:'transparent',
	    	title: uppercase + ' versus Number of Specimen Occurrence Records',
	    	is3D: true,
	    	sliceVisibilityThreshold: 1/50000,
		    colors: colors
	    }
	
	    var chart = new google.visualization.PieChart(document.getElementById(id));
	    chart.draw(data, options);
	    
	    // generate chart for print in a hidden div
	    var options = {
	    	width: 400,
	    	height: 320,
	    	chartArea:{left:0,top:0,width:"100%",height:"100%"},
	    	backgroundColor:'transparent',
	    	is3D: true,
	    	sliceVisibilityThreshold: 1/50000,
		    pieSliceText: 'none',
		    colors: colors,
		    legend: {
			    position: 'none'
		    }
	    }
	    
	    var hiddenChart = new google.visualization.PieChart(document.getElementById('hiddenChart'));
	    hiddenChart.draw(data, options);
	    
	    $('.printButton').parent().show();
    }
    else {
		$('#'+id).html('<div style="margin: 100px auto 0 100px; font-weight: bold; font-size: 15px; color: red;">No specimen ocurrence records found with selected filters.</div>');
	}
}

function drawTable(json, id, lowercase, uppercase) {
	if (json.result.length > 0) { 
		var data = new google.visualization.DataTable();
	    data.addColumn('string', uppercase);
	    data.addColumn('number', 'Number of Records');
	    data.addColumn('string', 'Percentage');
	    data.addRows(json.result.length);

	   	for (var i in json.result) {
	        data.setValue(parseInt(i, 10), 0, json.result[i][lowercase]);
	        data.setValue(parseInt(i, 10), 1, parseInt(json.result[i]['count'], 10));
	        data.setValue(parseInt(i, 10), 2, json.result[i]['perc']);
	    }
	
	    var table = new google.visualization.Table(document.getElementById(id));
	    table.draw(data, null);
	}
}

function drawGeoMap(json, id) {
	if (json.result.length > 0) {
	    var data = new google.visualization.DataTable();
	    data.addColumn('string', 'Country');
	    data.addColumn('number', 'Number of Records');
	
	    data.addRows(json.result.length);	
	    for (var i in json.result) {
	        data.setValue(parseInt(i, 10), 0, json.result[i]['country']);
	        data.setValue(parseInt(i, 10), 1, parseInt(json.result[i]['count'], 10));
	    }
	
	    var geomap = new google.visualization.GeoMap(document.getElementById(id));
	    geomap.draw(data, {dataMode:'regions'});
	}
	else {
		$('#'+id).html('<div style="margin: 100px auto 0 -10px; font-weight: bold; font-size: 15px; color: red;">No specimen ocurrence records found with selected filters.</div>');
	}       
}
// Specific functions
function drawBasisOfRecord() {
    $('#chart1').html(loadingPie);
    $('#table1').html('');
    
    $('.printButton').parent().hide();

    $.ajax({
        type:'POST',
        url:'index.php?r=analysis/getBasisOfRecord',
        data: {'list':jFilterList},
        dataType: "json",
        success:function(json) {        	
            drawPieChart(json, 'chart1', 'basisofrecord', 'Basis of Record');
            drawTable(json, 'table1', 'basisofrecord', 'Basis of Record');
        }
    });
}

function drawInstitutionCode() {
    $('#chart2').html(loadingPie);
    $('#table2').html('');
    
    $('.printButton').parent().hide();

    $.ajax({
        type:'POST',
        url:'index.php?r=analysis/getInstitutionCode',
        data: {'list':jFilterList},
        dataType: "json",
        success:function(json) {
            drawPieChart(json, 'chart2', 'institutioncode', 'Institution Code');
            drawTable(json, 'table2', 'institutioncode', 'Institution Code');
        }   
    });
}

function drawCollectionCode() {
    $('#chart3').html(loadingPie);
    $('#table3').html('');
    
    $('.printButton').parent().hide();

    $.ajax({
        type:'POST',
        url:'index.php?r=analysis/getCollectionCode',
        data: {'list':jFilterList},
        dataType: "json",
        success:function(json) {
            drawPieChart(json, 'chart3', 'collectioncode', 'Collection Code');
            drawTable(json, 'table3', 'collectioncode', 'Collection Code');
        }
    });
}

function drawTaxon() {    	 
    $('#infovis').html(loading);

    $.ajax({
        type:'POST',
        url:'index.php?r=analysis/getTaxon',
        data: {'list':jFilterList, 'type':'0'},
        dataType: "json",
        success:function(json) {
           	$('#infovis').html('');
           	            
            spaceTree(json.result);
        }
    });
}

function drawCountry() {
        $('#chart5').html(loading);
        $('#table5').html('');

        $.ajax({
            type:'POST',
            url:'index.php?r=analysis/getCountry',
            data: {'list':jFilterList},
            dataType: "json",
            success:function(json) {
                drawGeoMap(json, 'chart5');                      
                drawTable(json, 'table5', 'country', 'Country');
            }
    });
}

function drawTime() {
        $('#chart6').html(loading);
        $('#table6').html('');
        
        var data = new google.visualization.DataTable();
			
        $.ajax({
            type:'POST',
            url:'index.php?r=analysis/getTime',
            data: {'list':jFilterList},
            dataType: "json",
            success:function(json) {
            	if (json.records.length > 0) {
	                data.addColumn('string', 'Module');
	                data.addColumn('date', 'Date');
					data.addColumn('number', 'Number of Records');
					data.addColumn('number', 'Number of Created Records');
					data.addColumn('number', 'Number of Updated Records');
					data.addColumn('number', 'Number of Deleted Records');
					
					var count = 0;									
							        
			        for (var i in json.records) {
			        	if (json.records[i]['module'] && json.records[i]['date'] && json.records[i]['count']) {
			        		data.addRows(1); 
					        data.setValue(count, 0, json.records[i]['module']);			      
				            data.setValue(count, 1, new Date(parseInt(json.records[i]['date'].substr(0,4), 10), parseInt(json.records[i]['date'].substr(5,2), 10)-1, parseInt(json.records[i]['date'].substr(8,2), 10)));
				            data.setValue(count, 2, parseInt(parseInt(json.records[i]['count']), 10));
				            count++;
			            }
			        }
			        
			        var rows = count;
			        count = 0;
			        
			        for (var i in json.create) {
			        	if (json.create[i]['module'] && json.create[i]['date'] && json.create[i]['count']) {
			        		data.addRows(1);        		
					        data.setValue(count + rows, 0, json.create[i]['module']);			      
				            data.setValue(count + rows, 1, new Date(parseInt(json.create[i]['date'].substr(0,4), 10), parseInt(json.create[i]['date'].substr(5,2), 10)-1, parseInt(json.create[i]['date'].substr(8,2), 10)));
				            data.setValue(count + rows, 3, parseInt(parseInt(json.create[i]['count']), 10));
				            count++;
			            }
			        }
			        
			        rows += count;
			        count = 0;
			        
			        for (var i in json.update) {
			        	if (json.update[i]['module'] && json.update[i]['date'] && json.update[i]['count']) {
			        		data.addRows(1);  		
			        		data.setValue(count + rows, 0, json.update[i]['module']);			      
				            data.setValue(count + rows, 1, new Date(parseInt(json.update[i]['date'].substr(0,4), 10), parseInt(json.update[i]['date'].substr(5,2), 10)-1, parseInt(json.update[i]['date'].substr(8,2), 10)));
				            data.setValue(count + rows, 4, parseInt(parseInt(json.update[i]['count']), 10));
				            count++;
			        	}
			        }
			        
			        rows += count;
			        count = 0;
			        
			        for (var i in json.delete) {
			        	if (json.delete[i]['module'] && json.delete[i]['date'] && json.delete[i]['count']) {
			        		data.addRows(1);
					        data.setValue(count + rows, 0, json.delete[i]['module']);			      
				            data.setValue(count + rows, 1, new Date(parseInt(json.delete[i]['date'].substr(0,4), 10), parseInt(json.delete[i]['date'].substr(5,2), 10)-1, parseInt(json.delete[i]['date'].substr(8,2), 10)));
				            data.setValue(count + rows, 5, parseInt(parseInt(json.delete[i]['count']), 10));
							count++;
				        }
			        }
	
					var motionchart = new google.visualization.MotionChart(document.getElementById('chart6'));
					motionchart.draw(data, {'width': 600, 'height': 400});
				}
				else {
					$('#chart6').html('<div style="margin: 0 auto 0 -10px; font-weight: bold; font-size: 15px; color: red;">No specimen ocurrence records found with selected filters.</div>');
				}
            }
    });
}

function drawPieChartDQ(info, id, title, labelyes, labelno) {
	
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'records title');
    data.addColumn('number', 'Records');

    data.addRows([
        [labelyes, info.total - info.part],
        [labelno, info.part]
    ]);
    
    var colorChart;
    if (id == 'chartDQ1') {
	    colorChart = ["#FF0F00", "#FF6600"];
    } else if (id == 'chartDQ2') {
	    colorChart = ["#FF9E01", "#FCD202"];
    } else if (id == 'chartDQ3') {
	    colorChart = ["#04D215", "#0D8ECF"];
    } else {
	    colorChart = ["#0D52D1", "#2A0CD0"];
    }
    
    var options = {
    	width: 800,
    	height: 400,
    	backgroundColor:'transparent',
    	title: title,
    	is3D: false,
    	sliceVisibilityThreshold: 1/50000,
	    colors: colorChart
    }

    var chart = new google.visualization.PieChart(document.getElementById(id));
    chart.draw(data, options);
    
}

function drawDataQuality() {
    $('#chartDQ1').html('');
    $('#chartDQ2').html('');
    $('#chartDQ3').html('');
    $('#chartDQ4').html('');
    $('#chartDQ5').html('');
    
    $('#chartDQ1').html(loading);
    
    $('.printButton').parent().hide();
	
	$.ajax({
        type:'POST',
        url:'index.php?r=analysis/getDataQualityInfo',
        data: {'list':jFilterList},
        dataType: "json",
        success:function(response) {
           	//console.log(response);
           	
           	$('#chartDQ1').html('');
           	
           	if (response.total > 0) {
           		$('.printButton').parent().show();
	           	var info = {"total": response.total, "part": response.referenced}
	           	drawPieChartDQ(info, 'chartDQ1', 'Total of referenced records', 'Referenced records', 'Not referenced records');
	           	info = {"total": response.total, "part": response.colvalid}
	           	drawPieChartDQ(info, 'chartDQ2', 'Total of records validated by COL', 'Records validated by COL', 'Records not validated by COL');
	           	info = {"total": response.total, "part": response.eventdate}
	           	drawPieChartDQ(info, 'chartDQ3', 'Total of records with event date', 'With event date', 'Without event date');
	           	info = {"total": response.total, "part": response.geouncertainty}
	           	drawPieChartDQ(info, 'chartDQ4', 'Total of records with uncertainty of geographic coordinates', 'With uncertainty', 'Without uncertainty');
	           	drawColumnChartTaxonRank();
           	} else {
	           	$('#chartDQ1').html('<div style="margin: 100px auto 0 100px; font-weight: bold; font-size: 15px; color: red;">No specimen ocurrence records found with selected filters.</div>');
           	}
        }
    });
}

function drawColumnChartTaxonRank() {
	$.ajax({
        type:'POST',
        url:'index.php?r=analysis/getTaxonRankInfo',
        data: {'list':jFilterList},
        dataType: "json",
        success:function(response) {
	        var data = google.visualization.arrayToDataTable([
	          ['Taxon Rank', 'Scientific Name', 'Genus', 'Family', 'Order', 'Class', 'Phylum', 'Kingdom', 'Without taxon'],
	          ['Taxon Rank',  response.scientificname, response.genus, response.family, response.order, response.class, response.phylum, response.kingdom, response.others]
	        ]);
	        var options = {
		        width: 740,
		        height: 400,
		        backgroundColor:'transparent',
		        title: 'Taxon rank',
		        colors: colors,
		        vAxis: {
			        title: 'Number of records'
		        }
	        };
	
	        var chart = new google.visualization.ColumnChart(document.getElementById('chartDQ5'));
	        chart.draw(data, options);

           	
        }
    });
}

function canvasToImage(backgroundColor, canvas) {
	var context = canvas.getContext("2d");
	
	//cache height and width		
	var w = canvas.width;
	var h = canvas.height;

	var data;		

	if(backgroundColor)
	{
		//get the current ImageData for the canvas.
		data = context.getImageData(0, 0, w, h);

		//store the current globalCompositeOperation
		var compositeOperation = context.globalCompositeOperation;

		//set to draw behind current content
		context.globalCompositeOperation = "destination-over";

		//set background color
		context.fillStyle = backgroundColor;

		//draw background / rect on entire canvas
		context.fillRect(0,0,w,h);
	}

	//get the image data from the canvas
	var imageData = this.canvas.toDataURL("image/jpeg");

	if(backgroundColor)
	{
		//clear the canvas
		context.clearRect (0,0,w,h);

		//restore it with original / cached ImageData
		context.putImageData(data, 0,0);		

		//reset the globalCompositeOperation to what it was
		context.globalCompositeOperation = compositeOperation;
	}

	//return the Base64 encoded data url string
	return imageData;
}

/* 

// this is a implemetation of pie charts using amcharts

function drawPieChartV2(json, id, lowercase, uppercase) {
	if (json.result.length > 0) {
		var chart;
		var legend;
		
		var idlegend = 'legend' + id.replace(/[A-z]/gi, "");
		var idtitle = 'title' + id.replace(/[A-z]/gi, "");
		var idprintbutton = 'print' + id.replace(/[A-z]/gi, "");
		
		var chartData = new Array();
		for (var i in json.result) {
	        var item = {
		        label: json.result[i][lowercase],
		        value: json.result[i]['count'],
		        percents: json.result[i]['perc']
	        }
	        chartData.push(item);
	    }
		
	    // PIE CHART
	    chart = new AmCharts.AmPieChart();
	    chart.dataProvider = chartData;
	    chart.titleField = 'label';
	    chart.valueField = 'value';
	    chart.minRadius = 150;
	    
	    chart.depth3D = 25;
	    chart.angle = 30;
	    
	    chart.hideLabelsPercent = 100;			    			
	    
	    // LEGEND
	    legend = new AmCharts.AmLegend();
	    legend.align = "center";
	    legend.markerType = "circle";
	    legend.maxColumns = 2;
	    legend.valueText = '[[close]]';
	    legend.marginLeft = 100;
	    legend.textClickEnabled = true;
	    legend.switchable = false;
	    
	    chart.addLegend(legend, idlegend);
		
	    // WRITE
	    $('#' + id).css({"height":"300px", "width":"100%"});
	    $('#' + idlegend).show();
	    $('#' + idtitle).show();
	    $('#' + idprintbutton).show();

	    chart.write(id);
	    
	    // arrumar posicao da legenda
	    $('#' + idlegend + ' svg').css({"position":"relative"});
				
    } else {
	    $('#'+id).html('<div style="margin: 100px auto 0 100px; font-weight: bold; font-size: 15px; color: red;">No specimen ocurrence records found with selected filters.</div>');
    }
}

function drawBasisOfRecordV2() {
	$('#chart1').html(loadingPie);
    $('#legend1').html('');
	$('#table1').html('');
	$('#table1').css({"margin-top":"30px"});
	
    $.ajax({
        type:'POST',
        url:'index.php?r=analysis/getBasisOfRecord',
        data: {'list':jFilterList},
        dataType: "json",
        success:function(json) {
			drawPieChartV2(json, 'chart1', 'basisofrecord', 'Basis of Record');
			drawTable(json, 'table1', 'basisofrecord', 'Basis of Record');
        }
    });
}

function drawInstitutionCodeV2() {
	$('#chart2').html(loadingPie);
    $('#legend2').html('');
    $('#table2').html('');
    $('#table2').css({"margin-top":"30px"});
	
    $.ajax({
        type:'POST',
        url:'index.php?r=analysis/getInstitutionCode',
        data: {'list':jFilterList},
        dataType: "json",
        success:function(json) {
        	drawPieChartV2(json, 'chart2', 'institutioncode', 'Institution Code');
        	drawTable(json, 'table2', 'institutioncode', 'Institution Code');
        }
    });
}

function drawCollectionCodeV2() {
	$('#chart3').html(loadingPie);
    $('#legend3').html('');
    $('#table3').html('');
    $('#table3').css({"margin-top":"30px"});
    
    $.ajax({
        type:'POST',
        url:'index.php?r=analysis/getCollectionCode',
        data: {'list':jFilterList},
        dataType: "json",
        success:function(json) {
			drawPieChartV2(json, 'chart3', 'collectioncode', 'Collection Code');
			drawTable(json, 'table3', 'collectioncode', 'Collection Code');
        }
    });
}
*/

/*
var prevData;
var prevJson;

function drawTaxon(idkingdom, idphylum, idclass, idorder, idfamily, idgenus, idsubgenus, idspecificepithet, idinfraspecificepithet) {
    $('#chart4-1').html('<img style="margin-left:auto; margin-right:auto;" src="images/main/ajax-loader4.gif"></img>');
    $('#chart4-2').html('');
    $('#table4').html('');

    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Current Level');
    data.addColumn('string', 'Parent Level');

    $.ajax({
        type:'POST',
        url:'index.php?r=analysis/getTaxon',
        data: {'list':jFilterList, 'idkingdom':idkingdom, 'idphylum':idphylum, 'idclass':idclass, 'idorder':idorder, 'idfamily':idfamily, 'idgenus':idgenus, 'idsubgenus':idsubgenus, 'idspecificepithet':idspecificepithet, 'idinfraspecificepithet':idinfraspecificepithet},
        dataType: "json",
        success:function(json) {
            if (json.result[0]) {
                console.log(json.result);

                data.addRows(json.result.length);

                var prev;

                if (idkingdom && idphylum && idclass && idorder && idfamily && idgenus && idsubgenus && idspecificepithet && idinfraspecificepithet) {
                    prev = 9;
                    data.addRows(prev);
                    data.setCell(0, 0, "<div class='taxonTitle'>Kingdom</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+")'>"+json.result[0]['kingdom']+"</div>");
                    data.setCell(1, 0, "<div class='taxonTitle'>Phylum</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+")'>"+json.result[0]['phylum']+"</div>");
                    data.setCell(1, 1, "<div class='taxonTitle'>Kingdom</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+")'>"+json.result[0]['kingdom']+"</div>");
                    data.setCell(2, 0, "<div class='taxonTitle'>Class</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+")'>"+json.result[0]['class']+"</div>");
                    data.setCell(2, 1, "<div class='taxonTitle'>Phylum</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+")'>"+json.result[0]['phylum']+"</div>");
                    data.setCell(3, 0, "<div class='taxonTitle'>Order</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+")'>"+json.result[0]['order']+"</span>");
                    data.setCell(3, 1, "<div class='taxonTitle'>Class</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+")'>"+json.result[0]['class']+"</span>");
                    data.setCell(4, 0, "<div class='taxonTitle'>Family</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+","+json.result[0]['idfamily']+")'>"+json.result[0]['family']+"</div>");
                    data.setCell(4, 1, "<div class='taxonTitle'>Order</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+")'>"+json.result[0]['order']+"</div>");
                    data.setCell(5, 0, "<div class='taxonTitle'>Genus</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+","+json.result[0]['idfamily']+","+json.result[0]['idgenus']+")'>"+json.result[0]['genus']+"</div>");
                    data.setCell(5, 1, "<div class='taxonTitle'>Family</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+","+json.result[0]['idfamily']+")'>"+json.result[0]['family']+"</div>");
                    data.setCell(6, 0, "<div class='taxonTitle'>Subgenus</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+","+json.result[0]['idfamily']+","+json.result[0]['idgenus']+","+json.result[0]['idsubgenus']+")'>"+json.result[0]['subgenus']+"</div>");
                    data.setCell(6, 1, "<div class='taxonTitle'>Genus</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+","+json.result[0]['idfamily']+","+json.result[0]['idgenus']+")'>"+json.result[0]['genus']+"</div>");
                    data.setCell(7, 0, "<div class='taxonTitle'>Specific Epithet</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+","+json.result[0]['idfamily']+","+json.result[0]['idgenus']+","+json.result[0]['idsubgenus']+","+json.result[0]['idspecificepithet']+")'>"+json.result[0]['specificepithet']+"</div>");
                    data.setCell(7, 1, "<div class='taxonTitle'>Subgenus</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+","+json.result[0]['idfamily']+","+json.result[0]['idgenus']+","+json.result[0]['idsubgenus']+")'>"+json.result[0]['subgenus']+"</div>");
                    data.setCell(8, 0, "<div class='taxonTitle'>Infraspecific Epithet</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+","+json.result[0]['idfamily']+","+json.result[0]['idgenus']+","+json.result[0]['idsubgenus']+","+json.result[0]['idspecificepithet']+","+json.result[0]['idinfraspecificepithet']+")'>"+json.result[0]['infraspecificepithet']+"</div>");
                    data.setCell(8, 1, "<div class='taxonTitle'>Specific Epithet</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+","+json.result[0]['idfamily']+","+json.result[0]['idgenus']+","+json.result[0]['idsubgenus']+","+json.result[0]['idspecificepithet']+")'>"+json.result[0]['specificepithet']+"</div>");

                    for (var i in json.result) {
                        data.setCell(parseInt(i, 10)+prev, 0, "<div class='taxonTitle'>Scientific Name</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[i]['idkingdom']+","+json.result[i]['idphylum']+","+json.result[i]['idclass']+","+json.result[i]['idorder']+","+json.result[i]['idfamily']+","+json.result[i]['idgenus']+","+json.result[i]['idsubgenus']+","+json.result[i]['idspecificepithet']+","+json.result[i]['idinfraspecificepithet']+","+json.result[i]['idscientificname']+")'>"+json.result[i]['scientificname']+" ("+json.result[i]['count']+") </div>");
                        data.setCell(parseInt(i, 10)+prev, 1, "<div class='taxonTitle'>Infraspecific Epithet</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+","+json.result[0]['idfamily']+","+json.result[0]['idgenus']+","+json.result[0]['idsubgenus']+","+json.result[0]['idspecificepithet']+","+json.result[0]['idinfraspecificepithet']+")'>"+json.result[0]['infraspecificepithet']+"</div>");                     
                    }

                    drawPieChart(json, 'chart4-2', 'scientificname', 'Scientific Name');
                    drawTable(json, 'table4', 'scientificname', 'Scientific Name');
                }
                else if (idkingdom && idphylum && idclass && idorder && idfamily && idgenus && idsubgenus && idspecificepithet) {
                    prev = 8;
                    data.addRows(prev);
                    data.setCell(0, 0, "<div class='taxonTitle'>Kingdom</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+")'>"+json.result[0]['kingdom']+"</div>");
                    data.setCell(1, 0, "<div class='taxonTitle'>Phylum</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+")'>"+json.result[0]['phylum']+"</div>");
                    data.setCell(1, 1, "<div class='taxonTitle'>Kingdom</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+")'>"+json.result[0]['kingdom']+"</div>");
                    data.setCell(2, 0, "<div class='taxonTitle'>Class</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+")'>"+json.result[0]['class']+"</div>");
                    data.setCell(2, 1, "<div class='taxonTitle'>Phylum</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+")'>"+json.result[0]['phylum']+"</div>");
                    data.setCell(3, 0, "<div class='taxonTitle'>Order</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+")'>"+json.result[0]['order']+"</span>");
                    data.setCell(3, 1, "<div class='taxonTitle'>Class</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+")'>"+json.result[0]['class']+"</span>");
                    data.setCell(4, 0, "<div class='taxonTitle'>Family</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+","+json.result[0]['idfamily']+")'>"+json.result[0]['family']+"</div>");
                    data.setCell(4, 1, "<div class='taxonTitle'>Order</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+")'>"+json.result[0]['order']+"</div>");
                    data.setCell(5, 0, "<div class='taxonTitle'>Genus</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+","+json.result[0]['idfamily']+","+json.result[0]['idgenus']+")'>"+json.result[0]['genus']+"</div>");
                    data.setCell(5, 1, "<div class='taxonTitle'>Family</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+","+json.result[0]['idfamily']+")'>"+json.result[0]['family']+"</div>");
                    data.setCell(6, 0, "<div class='taxonTitle'>Subgenus</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+","+json.result[0]['idfamily']+","+json.result[0]['idgenus']+","+json.result[0]['idsubgenus']+")'>"+json.result[0]['subgenus']+"</div>");
                    data.setCell(6, 1, "<div class='taxonTitle'>Genus</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+","+json.result[0]['idfamily']+","+json.result[0]['idgenus']+")'>"+json.result[0]['genus']+"</div>");
                    data.setCell(7, 0, "<div class='taxonTitle'>Specific Epithet</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+","+json.result[0]['idfamily']+","+json.result[0]['idgenus']+","+json.result[0]['idsubgenus']+","+json.result[0]['idspecificepithet']+")'>"+json.result[0]['specificepithet']+"</div>");
                    data.setCell(7, 1, "<div class='taxonTitle'>Subgenus</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+","+json.result[0]['idfamily']+","+json.result[0]['idgenus']+","+json.result[0]['idsubgenus']+")'>"+json.result[0]['subgenus']+"</div>");

                    for (var i in json.result) {
                        data.setCell(parseInt(i, 10)+prev, 0, "<div class='taxonTitle'>Infraspecific Epithet</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[i]['idkingdom']+","+json.result[i]['idphylum']+","+json.result[i]['idclass']+","+json.result[i]['idorder']+","+json.result[i]['idfamily']+","+json.result[i]['idgenus']+","+json.result[i]['idsubgenus']+","+json.result[i]['idspecificepithet']+","+json.result[i]['idinfraspecificepithet']+")'>"+json.result[i]['infraspecificepithet']+" ("+json.result[i]['count']+") </div>");
                        data.setCell(parseInt(i, 10)+prev, 1, "<div class='taxonTitle'>Specific Epithet</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+","+json.result[0]['idfamily']+","+json.result[0]['idgenus']+","+json.result[0]['idsubgenus']+","+json.result[0]['idspecificepithet']+")'>"+json.result[0]['specificepithet']+"</div>");                     
                    }

                    drawPieChart(json, 'chart4-2', 'infraspecificepithet', 'Infraspecific Epithet');
                    drawTable(json, 'table4', 'infraspecificepithet', 'Infraspecific Epithet');
                }
                else if (idkingdom && idphylum && idclass && idorder && idfamily && idgenus && idsubgenus) {
                    prev = 7;
                    data.addRows(prev);
                    data.setCell(0, 0, "<div class='taxonTitle'>Kingdom</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+")'>"+json.result[0]['kingdom']+"</div>");
                    data.setCell(1, 0, "<div class='taxonTitle'>Phylum</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+")'>"+json.result[0]['phylum']+"</div>");
                    data.setCell(1, 1, "<div class='taxonTitle'>Kingdom</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+")'>"+json.result[0]['kingdom']+"</div>");
                    data.setCell(2, 0, "<div class='taxonTitle'>Class</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+")'>"+json.result[0]['class']+"</div>");
                    data.setCell(2, 1, "<div class='taxonTitle'>Phylum</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+")'>"+json.result[0]['phylum']+"</div>");
                    data.setCell(3, 0, "<div class='taxonTitle'>Order</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+")'>"+json.result[0]['order']+"</span>");
                    data.setCell(3, 1, "<div class='taxonTitle'>Class</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+")'>"+json.result[0]['class']+"</span>");
                    data.setCell(4, 0, "<div class='taxonTitle'>Family</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+","+json.result[0]['idfamily']+")'>"+json.result[0]['family']+"</div>");
                    data.setCell(4, 1, "<div class='taxonTitle'>Order</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+")'>"+json.result[0]['order']+"</div>");
                    data.setCell(5, 0, "<div class='taxonTitle'>Genus</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+","+json.result[0]['idfamily']+","+json.result[0]['idgenus']+")'>"+json.result[0]['genus']+"</div>");
                    data.setCell(5, 1, "<div class='taxonTitle'>Family</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+","+json.result[0]['idfamily']+")'>"+json.result[0]['family']+"</div>");
                    data.setCell(6, 0, "<div class='taxonTitle'>Subgenus</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+","+json.result[0]['idfamily']+","+json.result[0]['idgenus']+","+json.result[0]['idsubgenus']+")'>"+json.result[0]['subgenus']+"</div>");
                    data.setCell(6, 1, "<div class='taxonTitle'>Genus</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+","+json.result[0]['idfamily']+","+json.result[0]['idgenus']+")'>"+json.result[0]['genus']+"</div>");

                    for (var i in json.result) {
                        data.setCell(parseInt(i, 10)+prev, 0, "<div class='taxonTitle'>Specific Epithet</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[i]['idkingdom']+","+json.result[i]['idphylum']+","+json.result[i]['idclass']+","+json.result[i]['idorder']+","+json.result[i]['idfamily']+","+json.result[i]['idgenus']+","+json.result[i]['idsubgenus']+","+json.result[i]['idspecificepithet']+")'>"+json.result[i]['specificepithet']+" ("+json.result[i]['count']+") </div>");
                        data.setCell(parseInt(i, 10)+prev, 1, "<div class='taxonTitle'>Subgenus</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+","+json.result[0]['idfamily']+","+json.result[0]['idgenus']+","+json.result[0]['idsubgenus']+")'>"+json.result[0]['subgenus']+"</div>");                     
                    }

                    drawPieChart(json, 'chart4-2', 'specificepithet', 'Specific Epithet');
                    drawTable(json, 'table4', 'specificepithet', 'Specific Epithet');
                }
                else if (idkingdom && idphylum && idclass && idorder && idfamily && idgenus) {
                    prev = 6;
                    data.addRows(prev);
                    data.setCell(0, 0, "<div class='taxonTitle'>Kingdom</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+")'>"+json.result[0]['kingdom']+"</div>");
                    data.setCell(1, 0, "<div class='taxonTitle'>Phylum</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+")'>"+json.result[0]['phylum']+"</div>");
                    data.setCell(1, 1, "<div class='taxonTitle'>Kingdom</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+")'>"+json.result[0]['kingdom']+"</div>");
                    data.setCell(2, 0, "<div class='taxonTitle'>Class</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+")'>"+json.result[0]['class']+"</div>");
                    data.setCell(2, 1, "<div class='taxonTitle'>Phylum</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+")'>"+json.result[0]['phylum']+"</div>");
                    data.setCell(3, 0, "<div class='taxonTitle'>Order</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+")'>"+json.result[0]['order']+"</span>");
                    data.setCell(3, 1, "<div class='taxonTitle'>Class</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+")'>"+json.result[0]['class']+"</span>");
                    data.setCell(4, 0, "<div class='taxonTitle'>Family</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+","+json.result[0]['idfamily']+")'>"+json.result[0]['family']+"</div>");
                    data.setCell(4, 1, "<div class='taxonTitle'>Order</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+")'>"+json.result[0]['order']+"</div>");
                    data.setCell(5, 0, "<div class='taxonTitle'>Genus</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+","+json.result[0]['idfamily']+","+json.result[0]['idgenus']+")'>"+json.result[0]['genus']+"</div>");
                    data.setCell(5, 1, "<div class='taxonTitle'>Family</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+","+json.result[0]['idfamily']+")'>"+json.result[0]['family']+"</div>");

                    for (var i in json.result) {
                        data.setCell(parseInt(i, 10)+prev, 0, "<div class='taxonTitle'>Subgenus</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[i]['idkingdom']+","+json.result[i]['idphylum']+","+json.result[i]['idclass']+","+json.result[i]['idorder']+","+json.result[i]['idfamily']+","+json.result[i]['idgenus']+","+json.result[i]['idsubgenus']+")'>"+json.result[i]['subgenus']+" ("+json.result[i]['count']+") </div>");
                        data.setCell(parseInt(i, 10)+prev, 1, "<div class='taxonTitle'>Genus</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+","+json.result[0]['idfamily']+","+json.result[0]['idgenus']+")'>"+json.result[0]['genus']+"</div>");                     
                    }

                    drawPieChart(json, 'chart4-2', 'subgenus', 'Subgenus');
                    drawTable(json, 'table4', 'subgenus', 'Subgenus');
                }
                else if (idkingdom && idphylum && idclass && idorder && idfamily) {
                    prev = 5;
                    data.addRows(prev);
                    data.setCell(0, 0, "<div class='taxonTitle'>Kingdom</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+")'>"+json.result[0]['kingdom']+"</div>");
                    data.setCell(1, 0, "<div class='taxonTitle'>Phylum</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+")'>"+json.result[0]['phylum']+"</div>");
                    data.setCell(1, 1, "<div class='taxonTitle'>Kingdom</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+")'>"+json.result[0]['kingdom']+"</div>");
                    data.setCell(2, 0, "<div class='taxonTitle'>Class</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+")'>"+json.result[0]['class']+"</div>");
                    data.setCell(2, 1, "<div class='taxonTitle'>Phylum</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+")'>"+json.result[0]['phylum']+"</div>");
                    data.setCell(3, 0, "<div class='taxonTitle'>Order</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+")'>"+json.result[0]['order']+"</span>");
                    data.setCell(3, 1, "<div class='taxonTitle'>Class</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+")'>"+json.result[0]['class']+"</span>");
                    data.setCell(4, 0, "<div class='taxonTitle'>Family</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+","+json.result[0]['idfamily']+")'>"+json.result[0]['family']+"</div>");
                    data.setCell(4, 1, "<div class='taxonTitle'>Order</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+")'>"+json.result[0]['order']+"</div>");

                    for (var i in json.result) {
                        data.setCell(parseInt(i, 10)+prev, 0, "<div class='taxonTitle'>Genus</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[i]['idkingdom']+","+json.result[i]['idphylum']+","+json.result[i]['idclass']+","+json.result[i]['idorder']+","+json.result[i]['idfamily']+","+json.result[i]['idgenus']+")'>"+json.result[i]['genus']+" ("+json.result[i]['count']+") </div>");
                        data.setCell(parseInt(i, 10)+prev, 1, "<div class='taxonTitle'>Family</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+","+json.result[0]['idfamily']+")'>"+json.result[0]['family']+"</div>");                      
                    }

                    drawPieChart(json, 'chart4-2', 'genus', 'Genus');
                    drawTable(json, 'table4', 'genus', 'Genus');
                }
                else if (idkingdom && idphylum && idclass && idorder) {
                    prev = 4;
                    data.addRows(prev);
                    data.setCell(0, 0, "<div class='taxonTitle'>Kingdom</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+")'>"+json.result[0]['kingdom']+"</div>");
                    data.setCell(1, 0, "<div class='taxonTitle'>Phylum</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+")'>"+json.result[0]['phylum']+"</div>");
                    data.setCell(1, 1, "<div class='taxonTitle'>Kingdom</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+")'>"+json.result[0]['kingdom']+"</div>");
                    data.setCell(2, 0, "<div class='taxonTitle'>Class</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+")'>"+json.result[0]['class']+"</div>");
                    data.setCell(2, 1, "<div class='taxonTitle'>Phylum</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+")'>"+json.result[0]['phylum']+"</div>");
                    data.setCell(3, 0, "<div class='taxonTitle'>Order</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+")'>"+json.result[0]['order']+"</span>");
                    data.setCell(3, 1, "<div class='taxonTitle'>Class</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+")'>"+json.result[0]['class']+"</span>");

                    for (var i in json.result) {
                        data.setCell(parseInt(i, 10)+prev, 0, "<div class='taxonTitle'>Family</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[i]['idkingdom']+","+json.result[i]['idphylum']+","+json.result[i]['idclass']+","+json.result[i]['idorder']+","+json.result[i]['idfamily']+")'>"+json.result[i]['family']+" ("+json.result[i]['count']+") </div>");
                        data.setCell(parseInt(i, 10)+prev, 1, "<div class='taxonTitle'>Order</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+","+json.result[0]['idorder']+")'>"+json.result[0]['order']+"</div>");                      
                    }

                    drawPieChart(json, 'chart4-2', 'family', 'Family');
                    drawTable(json, 'table4', 'family', 'Family');
                }
                else if (idkingdom && idphylum && idclass) {
                    prev = 3;
                    data.addRows(prev);
                    data.setCell(0, 0, "<div class='taxonTitle'>Kingdom</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+")'>"+json.result[0]['kingdom']+"</div>");
                    data.setCell(1, 0, "<div class='taxonTitle'>Phylum</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+")'>"+json.result[0]['phylum']+"</div>");
                    data.setCell(1, 1, "<div class='taxonTitle'>Kingdom</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+")'>"+json.result[0]['kingdom']+"</div>");
                    data.setCell(2, 0, "<div class='taxonTitle'>Class</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+")'>"+json.result[0]['class']+"</div>");
                    data.setCell(2, 1, "<div class='taxonTitle'>Phylum</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+")'>"+json.result[0]['phylum']+"</div>");

                    for (var i in json.result) {
                        data.setCell(parseInt(i, 10)+prev, 0, "<div class='taxonTitle'>Order</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[i]['idkingdom']+","+json.result[i]['idphylum']+","+json.result[i]['idclass']+","+json.result[i]['idorder']+")'>"+json.result[i]['order']+" ("+json.result[i]['count']+") </div>");
                        data.setCell(parseInt(i, 10)+prev, 1, "<div class='taxonTitle'>Class</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+","+json.result[0]['idclass']+")'>"+json.result[0]['class']+"</div>");                      
                    }

                    drawPieChart(json, 'chart4-2', 'order', 'Order');
                    drawTable(json, 'table4', 'order', 'Order');
                }
                else if (idkingdom && idphylum) {
                    prev = 2;
                    data.addRows(prev);
                    data.setCell(0, 0, "<div class='taxonTitle'>Kingdom</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+")'>"+json.result[0]['kingdom']+"</div>");
                    data.setCell(1, 0, "<div class='taxonTitle'>Phylum</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+")'>"+json.result[0]['phylum']+"</div>");
                    data.setCell(1, 1, "<div class='taxonTitle'>Kingdom</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+")'>"+json.result[0]['kingdom']+"</div>");

                    for (var i in json.result) {
                        data.setCell(parseInt(i, 10)+prev, 0, "<div class='taxonTitle'>Class</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[i]['idkingdom']+","+json.result[i]['idphylum']+","+json.result[i]['idclass']+")'>"+json.result[i]['class']+" ("+json.result[i]['count']+") </div>");
                        data.setCell(parseInt(i, 10)+prev, 1, "<div class='taxonTitle'>Phylum</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+","+json.result[0]['idphylum']+")'>"+json.result[0]['phylum']+"</div>");                      
                    }

                    drawPieChart(json, 'chart4-2', 'class', 'Class');
                    drawTable(json, 'table4', 'class', 'Class');
                }
                else if (idkingdom) {
                    prev = 1;
                    data.addRows(prev);
                    data.setCell(0, 0, "<div class='taxonTitle'>Kingdom</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[0]['idkingdom']+")'>"+json.result[0]['kingdom']+"</div>");

                    for (var i in json.result) {
                        data.setCell(parseInt(i, 10)+prev, 0, "<div class='taxonTitle'>Phylum</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[i]['idkingdom']+","+json.result[i]['idphylum']+")'>"+json.result[i]['phylum']+" ("+json.result[i]['count']+") </div>");
                        data.setCell(parseInt(i, 10)+prev, 1, "<div class='taxonTitle'>Kingdom</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[i]['idkingdom']+")'>"+json.result[i]['kingdom']+"</div>");                      
                    }

                    drawPieChart(json, 'chart4-2', 'phylum', 'Phylum');
                    drawTable(json, 'table4', 'phylum', 'Phylum');
                }
                else {
                    for (var i in json.result) {
                        data.setCell(parseInt(i, 10), 0, "<div class='taxonTitle'>Kingdom</div><div class='taxonText' onclick='javascript:drawTaxon("+json.result[i]['idkingdom']+")'>"+json.result[i]['kingdom']+" ("+json.result[i]['count']+") </div>");
                    }

                    drawPieChart(json, 'chart4-2', 'kingdom', 'Kingdom');
                    drawTable(json, 'table4', 'kingdom', 'Kingdom');
                }

                new google.visualization.TreeChart(document.getElementById('chart4-1')).
                draw(data, {allowHtml: true});

                $("#chart4-1").overscroll({wheelDirection:'horizontal'});

                prevData = data;
                prevJson = json;
            }
            else {
                $('#Notification').jnotifyAddMessage({
                    text: "<div style='margin-left:40px; margin-bottom:10px; margin-top:10px;'>The selected taxon level has no children levels.</div>",
                    permanent: false,
                    disappearTime: 5000,
                    type: 'error'
                });
                
                new google.visualization.OrgChart(document.getElementById('chart4-1')).
                draw(prevData, {allowHtml: true, size:'large'});

                $("#chart4-1").overscroll({wheelDirection:'horizontal'});
                
                if (idkingdom && idphylum && idclass && idorder && idfamily && idgenus && idsubgenus && idspecificepithet && idinfraspecificepithet) {
                    drawPieChart(prevJson, 'chart4-2', 'infraspecificepithet', 'Infraspecific Epithet');
                    drawTable(prevJson, 'table4', 'infraspecificepithet', 'Infraspecific Epithet');
                }
                else if (idkingdom && idphylum && idclass && idorder && idfamily && idgenus && idsubgenus && idspecificepithet) {
                    drawPieChart(prevJson, 'chart4-2', 'specificepithet', 'Specific Epithet');
                    drawTable(prevJson, 'table4', 'specificepithet', 'Specific Epithet');
                }
                else if (idkingdom && idphylum && idclass && idorder && idfamily && idgenus && idsubgenus) {
                    drawPieChart(prevJson, 'chart4-2', 'subgenus', 'Subgenus');
                    drawTable(prevJson, 'table4', 'subgenus', 'Subgenus');
                }
                else if (idkingdom && idphylum && idclass && idorder && idfamily && idgenus) {
                    drawPieChart(prevJson, 'chart4-2', 'genus', 'Genus');
                    drawTable(prevJson, 'table4', 'genus', 'Genus');
                }
                else if (idkingdom && idphylum && idclass && idorder && idfamily) {
                    drawPieChart(prevJson, 'chart4-2', 'family', 'Family');
                    drawTable(prevJson, 'table4', 'family', 'Family');
                }
                else if (idkingdom && idphylum && idclass && idorder) {
                    drawPieChart(prevJson, 'chart4-2', 'order', 'Order');
                    drawTable(prevJson, 'table4', 'order', 'Order');
                }
                else if (idkingdom && idphylum && idclass) {
                    drawPieChart(prevJson, 'chart4-2', 'class', 'Class');
                    drawTable(prevJson, 'table4', 'class', 'Class');
                }
                else if (idkingdom && idphylum) {
                    drawPieChart(prevJson, 'chart4-2', 'phylum', 'Phylum');
                    drawTable(prevJson, 'table4', 'phylum', 'Phylum');
                }
                else if (idkingdom) {
                    drawPieChart(prevJson, 'chart4-2', 'kingdom', 'Kingdom');
                    drawTable(prevJson, 'table4', 'kingdom', 'Kingdom');
                }
            }
        }
    });
}*/
