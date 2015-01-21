var loading = '<div id="loading"><img style="margin-top:180px;" src="images/main/ajax-loader4.gif"></img><div style="padding-left:12px; font-weight:bold; color:#BB7700; padding-top:10px; text-shadow:1px 1px 3px #777;">Loading...</div></div>';

var loadingPie = '<div id="loading"><img style="margin-top:180px; margin-left:110px;" src="images/main/ajax-loader4.gif"></img><div style="margin-left:110px; padding-left:12px; font-weight:bold; color:#BB7700; padding-top:10px; text-shadow:1px 1px 3px #777;">Loading...</div></div>';

google.load('visualization', '1', {packages:['corechart', 'geomap', 'table', 'orgchart', 'motionchart']});

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

/*  Analysis of Monitoring Records  */

// Visualization functions
function drawPieChartMonitoring(json, id, lowercase, uppercase) {
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
	    	title: uppercase + ' versus Número de Registros de Monitoramento',
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
		$('#'+id).html('<div style="margin: 100px auto 0 100px; font-weight: bold; font-size: 15px; color: red;">Não foram encontrados Registros de Monitoramento com os filtros utilizados.</div>');
	}
}

function drawTableMonitoring(json, id, lowercase, uppercase) {
	if (json.result.length > 0) { 
		var data = new google.visualization.DataTable();
	    data.addColumn('string', uppercase);
	    data.addColumn('number', 'Número de Registros');
	    data.addColumn('string', 'Porcentagem');
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

function drawGeoMapMonitoring(json, id) {
	if (json.result.length > 0) {
	    var data = new google.visualization.DataTable();
	    data.addColumn('string', 'País');
	    data.addColumn('number', 'Número de Registros');
	
	    data.addRows(json.result.length);	
	    for (var i in json.result) {
	        data.setValue(parseInt(i, 10), 0, json.result[i]['country']);
	        data.setValue(parseInt(i, 10), 1, parseInt(json.result[i]['count'], 10));
	    }
	
	    var geomap = new google.visualization.GeoMap(document.getElementById(id));
	    geomap.draw(data, {dataMode:'regions'});
	}
	else {
		$('#'+id).html('<div style="margin: 100px auto 0 -10px; font-weight: bold; font-size: 15px; color: red;">Não foram encontrados Registros de Monitoramento com os filtros utilizados.</div>');
	}       
}

// Specific functions
function drawBasisOfRecordMonitoring() {
    $('#chart1').html(loadingPie);
    $('#table1').html('');
    
    $('.printButton').parent().hide();


    $.ajax({
        type:'POST',
        url:'index.php?r=analysismonitoring/getBasisOfRecord',
        data: {'list':jFilterList},
        dataType: "json",
        success:function(json) {
            drawPieChartMonitoring(json, 'chart1', 'basisofrecord', 'Base de Registro');
            drawTableMonitoring(json, 'table1', 'basisofrecord', 'Base de Registro');
        }
    });
}

function drawInstitutionCodeMonitoring() {
    $('#chart2').html(loadingPie);
    $('#table2').html('');

    $('.printButton').parent().hide();

    $.ajax({
        type:'POST',
        url:'index.php?r=analysismonitoring/getInstitutionCode',
        data: {'list':jFilterList},
        dataType: "json",
        success:function(json) {
            drawPieChartMonitoring(json, 'chart2', 'institutioncode', 'Código da Instituição');
            drawTableMonitoring(json, 'table2', 'institutioncode', 'Código da Instituição');
        }   
    });
}

function drawCollectionCodeMonitoring() {
    $('#chart3').html(loadingPie);
    $('#table3').html('');

    $('.printButton').parent().hide();

    $.ajax({
        type:'POST',
        url:'index.php?r=analysismonitoring/getCollectionCode',
        data: {'list':jFilterList},
        dataType: "json",
        success:function(json) {
            drawPieChartMonitoring(json, 'chart3', 'collectioncode', 'Código da Coleção');
            drawTableMonitoring(json, 'table3', 'collectioncode', 'Código da Coleção');
        }
    });
}

function drawTaxonMonitoring() {    	 
    $('#infovis').html(loading);

    $.ajax({
        type:'POST',
        url:'index.php?r=analysismonitoring/getTaxon',
        data: {'list':jFilterList, 'type':'0'},
        dataType: "json",
        success:function(json) {
           	$('#infovis').html('');
           	            
            spaceTree(json.result);
        }
    });
}

function drawCountryMonitoring() {
        $('#chart5').html(loading);
        $('#table5').html('');

        $.ajax({
            type:'POST',
            url:'index.php?r=analysismonitoring/getCountry',
            data: {'list':jFilterList},
            dataType: "json",
            success:function(json) {
            	$.each(json, function(index, val) {
            		drawGeoMapMonitoring(val, 'chart5');                      
                    drawTableMonitoring(val, 'table5', 'country', 'País');
            	  });
                
            }
    });
}

function drawTimeMonitoring() {
        $('#chart6').html(loading);
        $('#table6').html('');
        
        var data = new google.visualization.DataTable();
			
        $.ajax({
            type:'POST',
            url:'index.php?r=analysismonitoring/getTime',
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

