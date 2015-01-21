<?php
include_once "protected/extensions/config.php";

$key = getGoogleAPIKey('bddapi@gmail.com', 'datadigitizer');

echo '<script src="http://www.google.com/jsapi?sensor=false&key='.$key.'" type="text/javascript"></script>';
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
        <title>BDD Georeference Tool</title>
        <link href="css/form.css" rel="stylesheet" type="text/css"/>
        <link href="js/jquery/jquery-ui.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript"  src="js/jquery/jquery.min.js"></script>
        <script type="text/javascript"  src="js/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript">
            google.load("earth", "1");
            google.load("maps", "3", {other_params: "sensor=false"});
            //var geo = google.gears.factory.create('beta.geolocation');
            var ge;
            var latitude;
            var longitude;
            var groundAltitude;
            function init() {                
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
                google.earth.addEventListener(ge.getWindow(), 'mousemove', mapMove);
                google.earth.addEventListener(ge.getWindow(), 'click', mapClick);
                // add some layers
                ge.getLayerRoot().enableLayerById(ge.LAYER_BORDERS, true);
                ge.getLayerRoot().enableLayerById(ge.LAYER_ROADS, true);
                ge.getLayerRoot().enableLayerById(ge.LAYER_BUILDINGS, true);
                ge.getLayerRoot().enableLayerById(ge.LAYER_TERRAIN, true);
                $('#search_locality_field').val($('#GeospatialElementAR_decimallatitude',parent.document.body).val()+','+$('#GeospatialElementAR_decimallongitude',parent.document.body).val());
                if($('#search_locality_field').val()==',')
                    $('#search_locality_field').val('')
                else
                    searchByTerm();
                $('#btn_search').button();    
            }
            // evendo de clique no mapa
            function mapClick(event) {                
                //alert($('#CountryAR_country',parent.document.body).val());
                if (event.getDidHitGlobe()) {                    
                    latitude = event.getLatitude();
                    longitude = event.getLongitude();                    
                    groundAltitude = ge.getGlobe().getGroundAltitude(latitude, longitude);                    
                    $('#lat').html(latitude);                    
                    $('#lng').html(longitude);
                    $('#alt').html(groundAltitude+"m");
                    $('#lat',parent.document.body).val(latitude);
                    $('#lng',parent.document.body).val(longitude);
                    var geocoder = new google.maps.Geocoder();                    
                    var latlng = new google.maps.LatLng(parseFloat(latitude), parseFloat(longitude));                    
                    geocoder.geocode({ 'latLng': latlng }, function (results, status) {                                                
                        if (google.maps.GeocoderStatus.OK) {
                            for (var i = 0; i < results[0].address_components.length; i++){
                                if(results[0].address_components[i].types[0]=="country"){
                                    //$('#CountryAR_country',parent.document.body).val(results[0].address_components[i].long_name);
                                    //if($('#CountryAR_country',parent.document.body).val()!=''){
                                        $('#country').html(results[0].address_components[i].long_name);
                                        /*$.ajax({type: 'POST',dataType: "json",
                                            url: 'index.php?r=country/save',
                                            data: {"field": $('#CountryAR_country',parent.document.body).val()},
                                            success: function(json){                                                
                                                if(json.success){
                                                    $('#LocalityElementAR_idcountry',parent.document.body).val(json.id);                                                    
                                                    $('#CountryAR_country',parent.document.body).val(json.field);                                                    
                                                }
                                            }
                                        });*/
                                        //$("#countryField").hide();
                                    //}
                                }
                                if(results[0].address_components[i].types[0]=="administrative_area_level_1"){
                                    //$('#StateProvinceAR_stateprovince',parent.document.body).val(results[0].address_components[i].long_name);
                                    //if($('#StatePronvinceAR_stateprovince',parent.document.body).val()!=''){
                                        $('#state').html(results[0].address_components[i].long_name);
                                        /*$.ajax({type: 'POST',dataType: "json",
                                            url: 'index.php?r=stateprovince/save',
                                            data: {"field": $('#StateProvinceAR_stateprovince',parent.document.body).val()},
                                            success: function(json){
                                                if(json.success){
                                                    $('#LocalityElementAR_idstateprovince',parent.document.body).val(json.id);
                                                    $('#StateProvinceAR_stateprovince',parent.document.body).val(json.field);                                                    
                                                }
                                            }
                                        });*/
                                        //$("#stateProvinceField").hide();
                                    //}
                                }/*
                                if(results[0].address_components[i].types[0]=="administrative_area_level_2"){
                                    $('#CountyAR_county',parent.document.body).val(results[0].address_components[i].long_name);
                                    if($('#CountyAR_county',parent.document.body).val()!=''){
                                        //
                                        $.ajax({type: 'POST',dataType: "json",
                                            url: 'index.php?r=county/save',
                                            data: {"field": $('#CountyAR_county',parent.document.body).val()},
                                            success: function(json){
                                                if(json.success){
                                                    $('#LocalityElementAR_idcounty',parent.document.body).val(json.id);
                                                    $('#CountyAR_county',parent.document.body).val(json.field);                                                    
                                                }
                                            }
                                        });
                                    }
                                }*/
                                if(results[0].address_components[i].types[0]=="locality"){
                                    //$('#MunicipalityAR_municipality',parent.document.body).val(results[0].address_components[i].long_name);
                                    //if($('#MunicipalityAR_municipality',parent.document.body).val()!=''){
                                        $('#municipality').html(results[0].address_components[i].long_name);
                                        /*$.ajax({type: 'POST',dataType: "json",
                                            url: 'index.php?r=municipality/save',
                                            data: {"field": $('#MunicipalityAR_municipality').val()},
                                            success: function(json){
                                                if(json.success){
                                                    $('#LocalityElementAR_idmunicipality',parent.document.body).val(json.id);
                                                    $('#MunicipalityAR_municipality',parent.document.body).val(json.field);
                                                }
                                            }
                                        });*/
                                        //$("#municipalityField").hide();
                                    //}
                                }
                            }
                        }
                        else {
                            //console.log('No results found: ' + status);
                        }
                    });                                        
                }
            }
            function mapMove(event) {                
                if (event.getDidHitGlobe()) {                    
                    latitude = event.getLatitude();                    
                    longitude = event.getLongitude();                    
                    groundAltitude = ge.getGlobe().getGroundAltitude(latitude, longitude);                    
                    if (groundAltitude) {                    
                        $('#lat_at').html(latitude);                        
                        $('#lng_at').html(longitude);
                        $('#alt_at').html(groundAltitude.toFixed(2));
                    }
                }                 
            }            
            function failureCallback(errorCode) {
                alert('Attempt to get location failed: ' + positionError.message);
            }
            function searchByTerm() {                
                var geocodeLocation = $('#search_locality_field').val();                
                /*var geocoder = new google.maps.ClientGeocoder();
                geocoder.getLatLng(geocodeLocation, function(point) {
                    if (point) {
                        var lookAt = ge.createLookAt('');
                        lookAt.set(point.y, point.x, 10, ge.ALTITUDE_RELATIVE_TO_GROUND,0, 60, 20000);
                        ge.getView().setAbstractView(lookAt);
                    }
                });*/
                geocoder = new google.maps.Geocoder();
                geocoder.geocode( { 'address': geocodeLocation}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        var lat = results[0].geometry.location.lat();
                        var lng = results[0].geometry.location.lng();
                        var lookAt = ge.createLookAt('');                        
                        lookAt.set(lat, lng, 10, ge.ALTITUDE_RELATIVE_TO_GROUND,0, 60, 20000);
                        ge.getView().setAbstractView(lookAt);
                        //map.setCenter(results[0].geometry.location);
                        /*var marker = new google.maps.Marker({
                            map: map,
                            position: results[0].geometry.location
                        });*/
                    } else {
                        alert("Geocode was not successful for the following reason: " + status);
                    }
                });
            }

        </script>
    </head>
    <body onload="init()" style="margin:0px; padding:0px;">
        <div class="panelBGT">
        <div class="titleBGT">
            <img src="images/logoBGT.png"></img>
            <div class="title">Biodiversity Georeferencing Tool</div>
        </div>
        <div class="searchBGT">
            <div class="title">Search Locality</div>
            <div class="box"><?php echo  CHtml::textField('search_locality_field', '',array('id'=>'search_locality_field','style'=>'width: 210px;height: 30px; font-size:18px; color:grey;') ); ?></div>
            <div class="button"><input id="btn_search" onclick="searchByTerm();" type="submit" style="width: 210px; height: 30px;" value="Go to Location"/></div>
        </div>
        <div class="dataBGT">
            <div style="float:left">
            <div class="key">Latitude</div>
            <div class="value"><span id="lat"></span></div>


            <div class="key">Country</div>
            <div class="value"><span id="country"></span></div>
            </div>

            <div style="float:left">
            <div class="key">Longitude</div>
            <div class="value"><span id="lng"></span></div>


            <div class="key">State</div>
            <div class="value"><span id="state"></span></div>
            </div>

            <div style="float:left">
            <div class="key">Altitude</div>
            <div class="value"><span id="alt"></span></div>
            
            <div class="key">Municipality</div>
            <div class="value"><span id="municipality"></span></div>
            </div>
            <div style="clear:both;"></div>
        </div>
        <div style="clear:both;"></div>

        <div id="statusBGT" class="statusBGT">
            <div class="key">Latitude:</div>
            <div class="value"><span id="lat_at"></span></div>

            <div class="key">Longitude:</div>
            <div class="value"><span id="lng_at"></span></div>

            <div class="key">Altitude:</div>
            <div class="value"><span id="alt_at"></span></div>

            <div style="clear:both;"></div>
        </div>
        </div>
        
        <div id="map3d" class="map3d"></div>
    </body>
</html>

