<?php
include_once "protected/extensions/config.php";

$key = getGoogleAPIKey('bddapi@gmail.com', 'datadigitizer');

echo '<script src="http://www.google.com/jsapi?sensor=false&key='.$key.'" type="text/javascript"></script>';
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>BDD Georeference Tool</title>
<link href="css/main.css" rel="stylesheet" type="text/css"/>
<link href="css/form.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="js/jquery/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="js/jquery/jquery-ui.css"/>
<style>
body {
	background: transparent;
	margin: 0px;
	padding: 0px;
}
#map3d {
	margin: 0px auto;
	width: 660px;
	height: 400px;
	-moz-box-shadow: 5px 5px 9px #AAAAAA;
	-webkit-box-shadow: 5px 5px 9px #AAAAAA;
	box-shadow: 5px 5px 9px #AAAAAA;
}
</style>
<script type="text/javascript" src="js/polydraw.js"></script> 
<script type="text/javascript">        
	google.load("earth", "1",{'other_params': 'sensor=false' });
	var pm = null;
	google.load("maps", "3", {other_params: "sensor=false"});
	var ge;
	var latitude;
	var longitude;
	function init() {     			
		//$( "#uncertainty" ).val(10);  		
		/*$( "#slider" ).slider({
			value:$('#uncertainty').val(),
			min: 1,
			max: 100000,
			step: 1,
			change: function( event, ui ) {
				$( "#uncertainty" ).val(ui.value);
				plotUncertainty(ui.value)
			}
		});		*/		
		$('#uncertainty').keyup(function() {				
			plotUncertainty($('#uncertainty').val())	
			//$('#slider').slider( "value", $('#uncertainty').val());
		});
		//$( "#uncertainty" ).val( $( "#slider" ).slider( "value" )); 	  				  
	    google.earth.createInstance('map3d', initCallback, failureCallback); 	                               
	}
	function updatePosition(position) {
	    alert('Current lat/lon is: ' + position.latitude + ',' + position.longitude);
	}
	//inicia o mapa
	function initCallback(instance) {                
	    ge = instance;
	    ge.getWindow().setVisibility(true);
	    // add a navigation control
	    ge.getNavigationControl().setVisibility(ge.VISIBILITY_AUTO);
	    // add some layers
	    ge.getLayerRoot().enableLayerById(ge.LAYER_BORDERS, true);
	    ge.getLayerRoot().enableLayerById(ge.LAYER_ROADS, true);
	    ge.getLayerRoot().enableLayerById(ge.LAYER_BUILDINGS, true);
	    ge.getLayerRoot().enableLayerById(ge.LAYER_TERRAIN, true);                  
		plotSpecimen();
		plotUncertainty($('#uncertainty').val());
	}           
	function failureCallback(errorCode) {
	    alert('Attempt to get location failed: ' + positionError.message);
	}
	var lat;
	var lng;
	function plotSpecimen() {
		//lat = parseFloat($('#lat',parent.document.body).val());
		//lng = parseFloat($('#lng',parent.document.body).val());
		lat = parseFloat(<?php echo $lat;?>);
		lng = parseFloat(<?php echo $lng;?>);
		
		var point = ge.createPoint('');
	    point.setLatitude(lat);
	    point.setLongitude(lng);		        
	    var lookAt = ge.createLookAt('');                        
	    lookAt.set(lat, lng, 10, ge.ALTITUDE_RELATIVE_TO_GROUND,0, 50, 10000);
		ge.getView().setAbstractView(lookAt);
		var uncertainty = parent.selectedData.coordinateuncertaintyinmeters;
	
		plotUncertainty(lat,lng,uncertainty)	          	
	}
	var pm = null;
	function plotUncertainty(uncertainty) {
		parent.selectedData.coordinateuncertaintyinmeters = uncertainty;
		$('#GeospatialElementAR_coordinateuncertaintyinmeters',parent.document.body).val(uncertainty);
		if(pm!=null)
			pm.lineString.getCoordinates().clear();	
		pm = new Polygon(lat,lng,0,0,25,uncertainty/1000);       				
	    pm.numsides = 25;
	    pm.drawPolygon();
	}
</script>
</head>
<body onload="init()">
	<div style="padding: 20px;">	
		<!--<div id="slider" style="width:380px; float:left; margin-top:5px;"></div>-->
		<div style="float:left; margin-left: 15px;">
			<b>Uncertainty in meters</b>
			<input type="text" id="uncertainty" style="font-weight: bold; margin-left: 10px;" value="<?=$uncertainty;?>" />
		</div>
		<div style="clear:both;"></div>			
	</div>
	<input type="hidden" id='centre'></input>
	<input type="hidden" id='outer'></input>
	<input type="hidden" id='rad'></input>
	<input type="hidden" id='bear'></input>
	<input type="hidden" id='per'></input>
	<input type="hidden" id='are'></input>
	<div id="map3d"></div>
</body>
</html>

