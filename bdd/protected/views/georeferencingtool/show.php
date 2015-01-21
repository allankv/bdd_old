<?php include_once("protected/extensions/config.php"); ?>
<script type="text/javascript" src="js/inc/jquery.metadata.js"></script>
<script type="text/javascript" src="js/inc/mbContainer.js"></script>
<link rel="stylesheet" type="text/css" href="css/mbContainer/mbContainer.css"/>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="js/Geo.js"></script>

<script>	
    var action, selectedData, googleData, geonamesData, biogeomancerData;
		
    //var georeferencedByList = new Array();
    var georeferenceSourceLocalityList = new Array();
    var georeferenceSourceGeospatialList = new Array();
	
    $(document).ready(bootLocation);
    function bootLocation() {
        $("#GeospatialElementAR_decimallatitude").jStepper({disableNonNumeric:true, decimalSeparator:"."});
        $("#GeospatialElementAR_decimallongitude").jStepper({disableNonNumeric:true, decimalSeparator:"."});
        $("#GeospatialElementAR_coordinateuncertaintyinmeters").jStepper({decimalSeparator:".", disableNonNumeric:true});
        $("#LocalityElementAR_coordinateprecision").jStepper({disableNonNumeric:true, decimalSeparator:"."});
        $("#LocalityElementAR_minimumelevationinmeters").jStepper({disableNonNumeric:true, decimalSeparator:"."});
        $("#LocalityElementAR_maximumelevationinmeters").jStepper({disableNonNumeric:true, decimalSeparator:"."});
        $("#LocalityElementAR_minimumdepthinmeters").jStepper({disableNonNumeric:true, decimalSeparator:"."});
        $("#LocalityElementAR_maximumdepthinmeters").jStepper({disableNonNumeric:true, decimalSeparator:"."});
        $("#LocalityElementAR_minimumdistanceabovesurfaceinmeters").jStepper({disableNonNumeric:true, decimalSeparator:"."});
        $("#LocalityElementAR_maximumdistanceabovesurfaceinmeters").jStepper({disableNonNumeric:true, decimalSeparator:"."});
	        	
        //configAutocompleteNN('#GeoreferenceSourceGeospatialAR_idgeoreferencesource','#GeoreferenceSourceGeospatialAR_georeferencesource', 'georeferencesource','#georeferenceSourceGeospatialList',georeferenceSourceGeospatialList,'GeospatialElement','#SpecimenAR_idgeospatialelement');
        configAutocomplete('#GeospatialElementAR_idgeoreferenceverificationstatus','#GeoreferenceVerificationStatusGeospatialAR_georeferenceverificationstatus', 'georeferenceverificationstatus');
        configAutocomplete('#LocalityElementAR_idcountry','#CountryAR_country', 'country');
        configAutocomplete('#LocalityElementAR_idstateprovince','#StateProvinceAR_stateprovince', 'stateprovince');
        configAutocomplete('#LocalityElementAR_idcounty','#CountyAR_county', 'county');
        configAutocomplete('#LocalityElementAR_idmunicipality','#MunicipalityAR_municipality', 'municipality');
        configAutocomplete('#LocalityElementAR_idlocality','#LocalityAR_locality', 'locality');  
        //configAutocompleteNN('#GeoreferencedByAR_idgeoreferencedby','#GeoreferencedByAR_georeferencedby', 'georeferencedby', '#georeferencedByList',georeferencedByList,'LocalityElement','#SpecimenAR_idlocalityelement');
        configAutocompleteNN('#SpecimenAR_idlocalityelement', '#GeoreferencedByAR_georeferencedby', 'georeferencedby', 'LocalityElement');
        //configAutocompleteNN('#GeoreferenceSourceLocalityAR_idgeoreferencesource','#GeoreferenceSourceLocalityAR_georeferencesource', 'georeferencesource', '#georeferenceSourceLocalityList',georeferenceSourceLocalityList,'LocalityElement','#SpecimenAR_idlocalityelement');
        configAutocomplete('#LocalityElementAR_idcontinent','#ContinentAR_continent', 'continent');
        configAutocomplete('#LocalityElementAR_idwaterbody','#WaterBodyAR_waterbody', 'waterbody');
        configAutocomplete('#LocalityElementAR_idislandgroup','#IslandGroupAR_islandgroup', 'islandgroup');
        configAutocomplete('#LocalityElementAR_idisland','#IslandAR_island', 'island');
        //configAutocomplete('#LocalityElementAR_idhabitat','#HabitatLocalityAR_habitat', 'habitat');
           
        var btnAutocomplete ="<div class='btnAutocomplete' style='width:20px;'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-comment'></span></li></ul></div>";

        $('#autocompleteGeoreferenceSourceGeospatial').html('<a href="javascript:suggest(\'#GeoreferenceSourceGeospatialAR_idgeoreferencesource\',\'#GeoreferenceSourceGeospatialAR_georeferencesource\', \'georeferencesource\');">'+btnAutocomplete+'</a>');
        $('#autocompleteGeoreferenceVerificationStatus').html('<a href="javascript:suggest(\'#GeospatialElementAR_idgeoreferenceverificationstatus\',\'#GeoreferenceVerificationStatusGeospatialAR_georeferenceverificationstatus\', \'georeferenceverificationstatus\');">'+btnAutocomplete+'</a>');
        $('#autocompleteCountry').html('<a href="javascript:suggest(\'#LocalityElementAR_idcountry\',\'#CountryAR_country\', \'country\');">'+btnAutocomplete+'</a>');
        $('#autocompleteState').html('<a href="javascript:suggest(\'#LocalityElementAR_idstateprovince\',\'#StateProvinceAR_stateprovince\', \'stateprovince\');">'+btnAutocomplete+'</a>');
        $('#autocompleteCounty').html('<a href="javascript:suggest(\'#LocalityElementAR_idcounty\',\'#CountyAR_county\', \'county\');">'+btnAutocomplete+'</a>');
        $('#autocompleteMunicipality').html('<a href="javascript:suggest(\'#LocalityElementAR_idmunicipality\',\'#MunicipalityAR_municipality\', \'municipality\');">'+btnAutocomplete+'</a>');
        $('#autocompleteLocality').html('<a href="javascript:suggest(\'#LocalityElementAR_idlocality\',\'#LocalityAR_locality\', \'locality\');">'+btnAutocomplete+'</a>');
        $('#autocompleteGeoreferenceSource').html('<a href="javascript:suggest(\'#GeoreferenceSourceLocalityAR_idgeoreferencesource\',\'#GeoreferenceSourceLocalityAR_georeferencesource\', \'georeferencesource\');">'+btnAutocomplete+'</a>');
        $('#autocompleteWaterBody').html('<a href="javascript:suggest(\'#LocalityElementAR_idwaterbody\',\'#WaterBodyAR_waterbody\', \'waterbody\');">'+btnAutocomplete+'</a>');
        $('#autocompleteIslandGroup').html('<a href="javascript:suggest(\'#LocalityElementAR_idislandgroup\',\'#IslandGroupAR_islandgroup\', \'islandgroup\');">'+btnAutocomplete+'</a>');
        $('#autocompleteIsland').html('<a href="javascript:suggest(\'#LocalityElementAR_idisland\',\'#IslandAR_island\', \'island\');">'+btnAutocomplete+'</a>');
        //$('#autocompleteHabitatLocality').html('<a href="javascript:suggest(\'#LocalityElementAR_idhabitat\',\'#HabitatLocalityAR_habitat\', \'habitat\');">'+btnAutocomplete+'</a>');
        
        configIcons();
    	
        $("#lat").numeric();
        $("#lng").numeric();
    	
        $(":button").button();
    	
        $("#btnLatLng").click(function() {
            stepGeo(0,1);
        });
        
        $("#btnBgt").click(function() {
            openBGT(); 		
        }); 
        
        $("#btnGeoref").click(function() {
            stepGeo(0,1,1);    		 		
        });   
                
        $('#GeospatialElementAR_decimallatitude').keyup(function() {
            $("#lat").val($('#GeospatialElementAR_decimallatitude').val());
            if (!$('.geoStepTitle:eq(2)').hasClass('geoUnselected')) {
                stepGeo(2,1);
                stepLayoutGeo(1,0);
            }
            else if (!$('.geoStepTitle:eq(1)').hasClass('geoUnselected')) {
                stepLayoutGeo(1,0);
            }
			
            validate();
        });
        
        $('#GeospatialElementAR_decimallongitude').keyup(function() {
            $("#lng").val($('#GeospatialElementAR_decimallongitude').val());
            if (!$('.geoStepTitle:eq(2)').hasClass('geoUnselected')) {
                stepGeo(2,1);
                stepLayoutGeo(1,0);
            }
            else if (!$('.geoStepTitle:eq(1)').hasClass('geoUnselected')) {
                stepLayoutGeo(1,0);
            }
			
            validate();
        });
		
        $('#GeospatialElementAR_coordinateuncertaintyinmeters').keyup(function() {				
            selectedData.coordinateuncertaintyinmeters = $('#GeospatialElementAR_coordinateuncertaintyinmeters').val();
        });
		
        $('#MunicipalityAR_municipality').keyup(function() {
            selectedData.municipality = $('#MunicipalityAR_municipality').val();
            $('#selected_municipality').val($('#MunicipalityAR_municipality').val());
            if (!$('.geoStepTitle:eq(2)').hasClass('geoUnselected')) {
                stepGeo(2,1);
            }
            validate();
        });
        $('#MunicipalityAR_municipality').blur(function() {
            selectedData.municipality = $('#MunicipalityAR_municipality').val();
            $('#selected_municipality').val($('#MunicipalityAR_municipality').val());
            if (!$('.geoStepTitle:eq(2)').hasClass('geoUnselected')) {
                stepGeo(2,1);
            }
            validate();
        });
		
        $('#StateProvinceAR_stateprovince').keyup(function() {
            selectedData.stateprovince = $('#StateProvinceAR_stateprovince').val();
            $('#selected_stateprovince').val($('#StateProvinceAR_stateprovince').val());
            if (!$('.geoStepTitle:eq(2)').hasClass('geoUnselected')) {
                stepGeo(2,1);
            }	
            validate();
        });
        $('#StateProvinceAR_stateprovince').blur(function() {
            selectedData.stateprovince = $('#StateProvinceAR_stateprovince').val();
            $('#selected_stateprovince').val($('#StateProvinceAR_stateprovince').val());
            if (!$('.geoStepTitle:eq(2)').hasClass('geoUnselected')) {
                stepGeo(2,1);
            }	
            validate();
        });
		
        $('#CountryAR_country').keyup(function() {
            selectedData.country = $('#CountryAR_country').val();
            $('#selected_country').val($('#CountryAR_country').val());
            if (!$('.geoStepTitle:eq(2)').hasClass('geoUnselected')) {
                stepGeo(2,1);
            }
            validate();
        });
        $('#CountryAR_country').blur(function() {
            selectedData.country = $('#CountryAR_country').val();
            $('#selected_country').val($('#CountryAR_country').val());
            if (!$('.geoStepTitle:eq(2)').hasClass('geoUnselected')) {
                stepGeo(2,1);
            }
            validate();
        });
		
        $('#GeospatialElementAR_geodeticdatum').keyup(function() {
            selectedData.geodeticdatum = $('#GeospatialElementAR_geodeticdatum').val();
            $('#selected_geodeticdatum').val($('#GeospatialElementAR_geodeticdatum').val());
            if (!$('.geoStepTitle:eq(2)').hasClass('geoUnselected')) {
                stepGeo(2,1);
            }
            validate();
        });
        $('#GeospatialElementAR_geodeticdatum').blur(function() {
            selectedData.geodeticdatum = $('#GeospatialElementAR_geodeticdatum').val();
            $('#selected_geodeticdatum').val($('#GeospatialElementAR_geodeticdatum').val());
            if (!$('.geoStepTitle:eq(2)').hasClass('geoUnselected')) {
                stepGeo(2,1);
            }
            validate();
        });
		
        $('#WaterBodyAR_waterbody').keyup(function() {
            selectedData.waterbody = $('#WaterBodyAR_waterbody').val();
            $('#selected_waterbody').val($('#WaterBodyAR_waterbody').val());
            if (!$('.geoStepTitle:eq(2)').hasClass('geoUnselected')) {
                stepGeo(2,1);
            }
            validate();
        });
        $('#WaterBodyAR_waterbody').blur(function() {
            selectedData.waterbody = $('#WaterBodyAR_waterbody').val();
            $('#selected_waterbody').val($('#WaterBodyAR_waterbody').val());
            if (!$('.geoStepTitle:eq(2)').hasClass('geoUnselected')) {
                stepGeo(2,1);
            }
            validate();
        });
		
        setDefaultValues();
		
        selectedData.lat = $('#GeospatialElementAR_decimallatitude').val();
        selectedData.lng = $('#GeospatialElementAR_decimallongitude').val();
        selectedData.coordinateuncertaintyinmeters = $('#GeospatialElementAR_coordinateuncertaintyinmeters').val();
        selectedData.municipality = $('#MunicipalityAR_municipality').val();
        selectedData.stateprovince = $('#StateProvinceAR_stateprovince').val();
        selectedData.country = $('#CountryAR_country').val();
        selectedData.geodeticdatum = $('#GeospatialElementAR_geodeticdatum').val();
        selectedData.waterbody = $('#WaterBodyAR_waterbody').val();
        
        if ($('#LocalityElementAR_googlevalidation').val() == "1") {
            selectedData.sourceGoogle = true;
            googleData.municipality = $('#MunicipalityAR_municipality').val();
            googleData.stateprovince = $('#StateProvinceAR_stateprovince').val();
            googleData.country = $('#CountryAR_country').val();
            googleData.geodeticdatum = $('#GeospatialElementAR_geodeticdatum').val();
        }
        
        if ($('#LocalityElementAR_geonamesvalidation').val() == "1") {
            selectedData.sourceGeonames  = true;
            geonamesData.municipality = $('#MunicipalityAR_municipality').val();
            geonamesData.stateprovince = $('#StateProvinceAR_stateprovince').val();
            geonamesData.country = $('#CountryAR_country').val();
            geonamesData.geodeticdatum = $('#GeospatialElementAR_geodeticdatum').val();
            geonamesData.waterbody = $('#WaterBodyAR_waterbody').val();
        }
        
        if ($('#LocalityElementAR_biogeomancervalidation').val() == "1") {
            selectedData.sourceBiogeomancer = true;
            biogeomancerData.municipality = $('#MunicipalityAR_municipality').val();
            biogeomancerData.stateprovince = $('#StateProvinceAR_stateprovince').val();
            biogeomancerData.country = $('#CountryAR_country').val();
            biogeomancerData.geodeticdatum = $('#GeospatialElementAR_geodeticdatum').val();
        }
        
        setValues();
		        
        configGeoNavigation();
    }
	
    function validate() {
        if (!isDefault()) {
            if ($('#GeospatialElementAR_decimallatitude').val() == selectedData.lat &&
                $('#GeospatialElementAR_decimallongitude').val() == selectedData.lng &&    	
                $('#MunicipalityAR_municipality').val() == googleData.municipality &&
                $('#StateProvinceAR_stateprovince').val() == googleData.stateprovince &&
                $('#CountryAR_country').val() == googleData.country &&
                $('#GeospatialElementAR_geodeticdatum').val() == googleData.geodeticdatum) {
                selectedData.sourceGoogle = true;
                selectedData.sourceGeonames = false;
                selectedData.sourceBiogeomancer = false;
                setValues();
            }
            else if ($('#GeospatialElementAR_decimallatitude').val() == selectedData.lat &&
                $('#GeospatialElementAR_decimallongitude').val() == selectedData.lng &&    	
                $('#MunicipalityAR_municipality').val() == geonamesData.municipality &&
                $('#StateProvinceAR_stateprovince').val() == geonamesData.stateprovince &&
                $('#CountryAR_country').val() == geonamesData.country &&
                $('#GeospatialElementAR_geodeticdatum').val() == geonamesData.geodeticdatum &&
                $('#WaterBodyAR_waterbody').val() == geonamesData.waterbody) {
                selectedData.sourceGoogle = false;
                selectedData.sourceGeonames = true;
                selectedData.sourceBiogeomancer = false;
                setValues();
            }
            else if ($('#GeospatialElementAR_decimallatitude').val() == selectedData.lat &&
                $('#GeospatialElementAR_decimallongitude').val() == selectedData.lng &&    	
                $('#MunicipalityAR_municipality').val() == biogeomancerData.municipality &&
                $('#StateProvinceAR_stateprovince').val() == biogeomancerData.stateprovince &&
                $('#CountryAR_country').val() == biogeomancerData.country &&
                $('#GeospatialElementAR_geodeticdatum').val() == biogeomancerData.geodeticdatum) {
                selectedData.sourceGoogle = false;
                selectedData.sourceGeonames = false;
                selectedData.sourceBiogeomancer = true;
                setValues();
            }
            else {
                selectedData.sourceGoogle = false;
                selectedData.sourceGeonames = false;
                selectedData.sourceBiogeomancer = false;
                notValid();
            }
        }		
    }
	
    function notValid() {
        $('#sourceOcean').html('Data currently not validated.');
        $('#source').html('Data currently not validated.');
        $('#georefsources').html('<input type="button" onclick="selectGeoTool();" value="USE BGT" style="width:100%"/>');
        $(":button").button();
    }

    function configGeoNavigation() {	
        $('.geoTitle:not(:eq(0)), .geoStepTitle:not(:eq(0))').addClass('geoUnselected');
        $('.geoTitle:not(:eq(0)) .title, .geoStepTitle:not(:eq(0)) .title').hide();
        $('.geoStepTitle .geoIcon').hide();	
        $('.geoStepContents:not(:eq(0))').hide();
		
        if ($('#SpecimenAR_idspecimen').val()) {
            selectGeoForm();
        }
        else {
            selectGeoTool();
        }
		
        $('.geoTitle:eq(0)').click(function () {
            selectGeoTool();
        });
		
        $('.geoTitle:eq(1)').click(function () {
            selectGeoForm();
        });
	
        $('.geoTitle .abbr, .geoStepTitle .number').hover(
        function () {
            if ($(this).parent().hasClass('geoUnselected')) {
                $('.title', $(this).parent()).show();
            }
        }, 
        function () {
            if ($(this).parent().hasClass('geoUnselected')) {
                $('.title', $(this).parent()).hide();
            }			
        });		
    }
	
    function isDefault() {
        return googleData.country == '' 
            && googleData.stateprovince == ''
            && googleData.county == ''
            && googleData.municipality == ''
            && googleData.geodeticdatum == 'WGS84'
            && googleData.coordinateuncertaintyinmeters == ''
		
            && geonamesData.country == '' 
            && geonamesData.stateprovince == ''
            && geonamesData.county == ''
            && geonamesData.municipality == ''
            && geonamesData.geodeticdatum == 'WGS84'
            && geonamesData.coordinateuncertaintyinmeters == ''
            && geonamesData.waterbody == ''
		
            && biogeomancerData.country == '' 
            && biogeomancerData.stateprovince == ''
            && biogeomancerData.county == ''
            && biogeomancerData.municipality == ''
            && biogeomancerData.geodeticdatum == ''
            && biogeomancerData.coordinateuncertaintyinmeters == '';
    }
	
    function selectGeoTool() {
        if (!$('.geoStepTitle:eq(2)').hasClass('geoUnselected')) {
            $('#map').html('');
            $('#map').load('index.php?r=georeferencingtool/minimapIFrame&uncertainty='+selectedData.coordinateuncertaintyinmeters+'&lat='+selectedData.lat+'&lng='+selectedData.lng);
        }	
        $('.geoTitle:eq(1)').addClass('geoUnselected');
        $('.geoTitle:eq(0)').removeClass('geoUnselected');
        $('.geoTitle:not(:eq(0)) .title').hide();
        $('.geoTitle:eq(0) .title').show();		
        $('.geoContents:eq(1)').hide();
        $('.geoContents:eq(0)').show();
    }
	
    function selectGeoForm() {
        if (!$('.geoStepTitle:eq(2)').hasClass('geoUnselected')) {
            $('#map').html('');
        }
        $('.geoTitle:eq(0)').addClass('geoUnselected');
        $('.geoTitle:eq(1)').removeClass('geoUnselected');
        $('.geoTitle:not(:eq(1)) .title').hide();
        $('.geoTitle:eq(1) .title').show();			
        $('.geoContents:eq(0)').hide();
        $('.geoContents:eq(1)').show();
    }
    function geocodingBiogeomancer() {
        $('#georefStep').html('<div class="mainFieldsTable"><img id="loadBiogeomancer" style="width: 30px; margin: 10px auto;" src="images/main/ajax-loader2.gif"/><br /><b style="color: #F6A828;">Searching...</b></div>');
        $.ajax({
            type:'GET',
            url:'index.php?r=georeferencingtool/getBiogeomancer&locality='+$('#locality').val()+'&state='+$('#state').val()+'&country='+$('#country').val(),
            dataType: "json",
            success:function(json) {
                $('#georefStep').html('');	
                if(json.sucess==false){
                    alert('No results.');
                    stepGeo(1,0);
                }else{
                    for (var i = 0; i < json.georeference.length && i<6; i++){						
                        var item = '<div class="georefResult"><div class="map" id="biogeomap'+i+'"></div><table><tr><td></td><td><img style="height: 25px;" src="images/specimen/logo_biogeo.gif" /><br />Biogeomancer</td></tr><tr><td></td><td></td></tr><tr><td style="text-align:right;">Latitude</td><td>_LAT_</td></tr><tr><td style="text-align:right;">Longitude</td>	    		<td>_LNG_</td></tr><tr><td style="text-align:right;">Country</td><td><input disabled="true" id="countrybio'+i+'" type="text"/></td></tr><tr><td style="text-align:right;">State or Province</td><td><input disabled="true" id="statebio'+i+'" type="text"/></td></tr><tr><td style="text-align:right;">Municipality</td><td><input disabled="true" id="municipalitybio'+i+'" type="text"/></td></tr><tr><td style="text-align:right;">Geodetic Datum</td><td>_GEODETIC_</td></tr><tr><td style="text-align:right;">Uncertainty in Meters</td><td>_UNCERTAINTY_</td></tr><tr><td></td><td>_BUTTON_</td></tr>	   </table>			    		    	    </div>';								
                        item = item.replace('_LAT_','<input disabled="true" id="latbio'+i+'" value="'+json.georeference[i].decimallatitude+'" type="text"/>')
                        item = item.replace('_LNG_','<input disabled="true" id="lngbio'+i+'" value="'+json.georeference[i].decimallongitude+'" type="text"/>')
                        item = item.replace('_GEODETIC_','<input disabled="true" id="geodeticbio'+i+'" value="'+json.georeference[i].geodeticdatum+'" type="text"/>')
                        item = item.replace('_UNCERTAINTY_','<input disabled="true" id="uncertaintybio'+i+'" value="'+json.georeference[i].uncertainty+'" type="text"/>')							    							
                        item = item.replace('_BUTTON_','<input id="buttonBiogeomancerSource'+i+'" onClick="selectBiogeomancer('+i+');" type="button" value="Select" style="width:100%"/>');						
                        $('#georefStep').html($('#georefStep').html()+item);										
                        $('#biogeomap'+i).html('<img id="staticMap" src="http://maps.google.com/maps/api/staticmap?center='+json.georeference[i].decimallatitude+','+json.georeference[i].decimallongitude+'&zoom=10&maptype=satellite&size=300x300&sensor=false"></img>');																						
                        reverseGeocodingBiogeomancer(i);
                    }
                    $(':button').button();
                }							
            }							
        });	
    }
    function selectBiogeomancer(i){
        selectedData.country= $('#countrybio'+i).val();
        selectedData.stateprovince= $('#statebio'+i).val();
        selectedData.municipality= $('#municipalitybio'+i).val();
        selectedData.geodeticdatum= $('#geodeticbio'+i).val();
        selectedData.coordinateuncertaintyinmeters= $('#uncertaintybio'+i).val();
        biogeomancerData.country= $('#countrybio'+i).val();
        biogeomancerData.stateprovince= $('#statebio'+i).val();
        biogeomancerData.municipality= $('#municipalitybio'+i).val();
        biogeomancerData.geodeticdatum= $('#geodeticbio'+i).val();
        biogeomancerData.coordinateuncertaintyinmeters= $('#uncertaintybio'+i).val();
        selectedData.lat= $('#latbio'+i).val();
        selectedData.lng= $('#lngbio'+i).val();		
        setValues();
        validate();
        stepGeo(1,2);
    }
    function reverseGeocodingBiogeomancer(i){
        var geocoder = new google.maps.Geocoder();		
        var latlng = new google.maps.LatLng(parseFloat($('#latbio'+i).val()), parseFloat($('#lngbio'+i).val()));
        geocoder.geocode({
            'latLng': latlng,
            'language':'US'
        }, function (results, status) {	
            console.log(i+"-"+status);
            if(status=='OK'){
                if (results[0]) {
                    for (var j = 0; j < results[0].address_components.length; j++){		    			
                        if(results[0].address_components[j].types[0]=="country"){
                            //console.log(i+" = "+results[0].address_components[j].long_name);
                            $('#countrybio'+i).val(results[0].address_components[j].long_name);
                        }						                							                	
                        if(results[0].address_components[j].types[0]=="administrative_area_level_1"){
                            $('#statebio'+i).val(results[0].address_components[j].long_name);
                        }	
                        if(results[0].address_components[j].types[0]=="locality"){
                            $('#municipalitybio'+i).val(results[0].address_components[j].long_name);
                        }
                    }
                }   
            }else if(status=='OVER_QUERY_LIMIT'){
                var t=setTimeout("reverseGeocodingBiogeomancer("+i+");",1001);
            }
        });	
    }
    function stepGeo(from, to, type) {		
        if (from == 0 && to == 1) {
            if (type == 1) {
                if($('#locality').val()!=''){
                    geocodingBiogeomancer();
                    $("#revgeoStep").hide();
                    $("#georefStep").show();		    				    		
		    		
                    stepLayoutGeo(from, to);
                }
                else{
                    alert('Please fill Locality field.');
                }
            }
            else {
                if ($('#lat').val() != '' && $('#lng').val() != '') {
                    selectedData.lat = $('#lat').val();
                    selectedData.lng = $('#lng').val();	    			    			
                    reverseGeocodingGoogle(selectedData.lat,selectedData.lng);
                    reverseGeocodingGeonames(selectedData.lat,selectedData.lng);
                    $('#revgeoMap').html('<div><img id="staticMap" src="http://maps.google.com/maps/api/staticmap?center='+selectedData.lat+','+selectedData.lng+'&zoom=10&maptype=satellite&size=400x350&sensor=false"></img></div>');
                    $("#revgeoStep").show();
                    $("#georefStep").hide();
					
                    stepLayoutGeo(from, to); 						
                }
                else {
                    alert('Please fill latitude and longitude fields.'); 
                }
            }			
        }
        else if (from == 1 && to == 0) {
            setDefaultValues();
	    	
            setValues();
	    	
            $('#GeospatialElementAR_coordinateuncertaintyinmeters').val("");
    	
            stepLayoutGeo(from, to);
        }
        else if (from == 1 && to == 2) {
            $('#map').html('');
            $('#map').load('index.php?r=georeferencingtool/minimapIFrame&uncertainty='+selectedData.coordinateuncertaintyinmeters+'&lat='+selectedData.lat+'&lng='+selectedData.lng);
            stepLayoutGeo(from, to);
        }
        else if (from == 2 && to == 1) {
            $('#map').html('');
            stepLayoutGeo(from, to);
        }
    }
	
    function stepLayoutGeo(from, to) {
        $('.geoStepTitle:eq('+from+')').addClass('geoUnselected');
        $('.geoStepTitle:eq('+from+') .title').hide();
        $('.geoStepTitle:eq('+from+') .geoIcon').hide();
			
        $('.geoStepTitle:eq('+to+')').removeClass('geoUnselected');
        $('.geoStepTitle:eq('+to+') .title').show();
        $('.geoStepTitle:eq('+to+') .geoIcon').show();
		
        $('.geoStepContents:eq('+from+')').hide();
        $('.geoStepContents:eq('+to+')').show();
    }
		
    function actionLatLng() {	
        selectedData.lat=$('#lat').val();
        selectedData.lng=$('#lng').val();	    			    			
        reverseGeocodingGoogle(selectedData.lat,selectedData.lng);
        reverseGeocodingGeonames(selectedData.lat,selectedData.lng);
        //reverseGeocodingLocal(selectedData.lat,selectedData.lng);	
    }
	
    function reverseGeocodingGeonames(lat, lng) {
        $('#loadGeonames').show();
        $.ajax({
            type:'GET',
            url:'http://api.geonames.org/findNearbyPlaceNameJSON?style=FULL&lat='+lat+'&lng='+lng+'&username=bdd',
            dataType: "json",
            success:function(json) {
                $('#loadGeonames').hide();
                if (json.geonames[0]) {
                    if (json.geonames[0] != '') {
                        geonamesData.stateprovince = json.geonames[0].adminName1;
                        geonamesData.country = json.geonames[0].countryName;
                        geonamesData.municipality = json.geonames[0].name;
                        if (json.geonames[0].distance != '') {
                            geonamesData.coordinateuncertaintyinmeters = parseFloat(json.geonames[0].distance)*1000;
                            selectedData.coordinateuncertaintyinmeters = geonamesData.coordinateuncertaintyinmeters;
                        }
                        setValues();
																	
                        $('#defaultStep').show();
                        $('#oceanStep').hide();
                    }
                    return null;
                }
                reverseGeocodingGeonamesOcean(lat,lng);					
            }							
        });	
    }
	
    function reverseGeocodingGeonamesOcean(lat, lng){
        $('#loadGeonamesOcean').show();
        $.ajax({
            type:'GET',
            url:'http://api.geonames.org/oceanJSON?lat='+lat+'&lng='+lng+'&username=bdd',
            dataType: "json",
            success:function(json) {
                $('#loadGeonamesOcean').hide();							
								
                geonamesData.waterbody = json.ocean.name;					
                setValues();
                selectGeonamesSource();
				
                $('#defaultStep').hide();
                $('#oceanStep').show();								
            }
        });	
    }
	
    function reverseGeocodingGoogle(lat, lng) {
        $('#loadGoogle').show();
        var geocoder = new google.maps.Geocoder();
        var latlng = new google.maps.LatLng(parseFloat(lat), parseFloat(lng));
        geocoder.geocode({
            'latLng': latlng,
            'language':'en'
        }, function (results, status) {
            //console.log(results);
            $('#loadGoogle').hide();
            if (results[0]) {
                for (var i = 0; i < results[0].address_components.length; i++){
                    if(results[0].address_components[i].types[0]=="country")
                        googleData.country = results[0].address_components[i].long_name;                                   
                    if(results[0].address_components[i].types[0]=="administrative_area_level_1")
                        googleData.stateprovince = results[0].address_components[i].long_name;                    
                    if(results[0].address_components[i].types[0]=="administrative_area_level_2")
                        googleData.county = results[0].address_components[i].long_name;                    
                    if(results[0].address_components[i].types[0]=="locality"){
                        googleData.municipality = results[0].address_components[i].long_name;                    	                	
                    }	                	
                }
                setValues();
            }           
        });		
    }
 
    function setDefaultValues() {
        selectedData = {
            "country":"",
            "stateprovince":"",
            "county":"",
            "municipality":"",
            "geodeticdatum":"",
            "lat":"",
            "lng":"",
            "coordinateuncertaintyinmeters":"100",
            "waterbody":"",
            "sourceGoogle":false,
            "sourceGeonames":false,
            "sourceBiogeomancer":false
        };
        googleData = {	
            "country":"",
            "stateprovince":"",
            "county":"",
            "municipality":"",
            "geodeticdatum":"WGS84",
            "coordinateuncertaintyinmeters":""
        };
        geonamesData = {	
            "country":"",
            "stateprovince":"",
            "county":"" ,
            "municipality":"",
            "geodeticdatum":"WGS84",
            "coordinateuncertaintyinmeters":"",
            "waterbody":""
        };
        biogeomancerData = {
            "country":"",
            "stateprovince":"",
            "county":"" ,
            "municipality":"",
            "geodeticdatum":"",
            "coordinateuncertaintyinmeters":""
        };
    }
	
    function setValues() {
        $('#google_municipality').val(googleData.municipality);
        $('#google_stateprovince').val(googleData.stateprovince);
        $('#google_country').val(googleData.country);
        $('#google_geodeticdatum').val(googleData.geodeticdatum);    	
    	
        $('#geonames_municipality').val(geonamesData.municipality);    	
        $('#geonames_stateprovince').val(geonamesData.stateprovince);
        $('#geonames_country').val(geonamesData.country);
        $('#geonames_geodeticdatum').val(geonamesData.geodeticdatum);
        $('#geonames_waterbody').val(geonamesData.waterbody);
    	   	   	    
        if (googleData.municipality == geonamesData.municipality
            && googleData.stateprovince == geonamesData.stateprovince
            && googleData.country == geonamesData.country
            && googleData.country != '')
        {
            selectedData.municipality = googleData.municipality;
            selectedData.stateprovince = googleData.stateprovince;
            selectedData.country = googleData.country;
            selectedData.geodeticdatum = googleData.geodeticdatum;    		 
            selectedData.sourceGoogle = true;
            selectedData.sourceGeonames = true;
        }   
    	
        $('#selected_municipality').val(selectedData.municipality);
        $('#MunicipalityAR_municipality').val(selectedData.municipality);  	
        $('#selected_stateprovince').val(selectedData.stateprovince);
        $('#StateProvinceAR_stateprovince').val(selectedData.stateprovince);
        $('#selected_country').val(selectedData.country);
        $('#CountryAR_country').val(selectedData.country);
        $('#selected_geodeticdatum').val(selectedData.geodeticdatum);
        $('#GeospatialElementAR_geodeticdatum').val(selectedData.geodeticdatum);
        //$("#lat").val(selectedData.lat);  
        $('#selected_lat').html(selectedData.lat);    	
        $('#GeospatialElementAR_decimallatitude').val(selectedData.lat);
        //$("#lng").val(selectedData.lng); 
        $('#selected_lng').html(selectedData.lng);
        $('#GeospatialElementAR_decimallongitude').val(selectedData.lng);    	
        $('#selected_waterbody').val(selectedData.waterbody);
        $('#WaterBodyAR_waterbody').val(selectedData.waterbody);
    	    			
        if (selectedData.sourceGoogle && selectedData.sourceGeonames) {
            $('#source').html('Valid according to:<br />Google and GeoNames');
            $('#georefsources').html('<img style="height: 25px;" src="images/specimen/logo_google.png" /><img style="height: 25px;" src="images/specimen/logo_geonames.gif" />');			
        }else if(selectedData.sourceBiogeomancer){
            $('#source').html('Valid according to:<br />Biogeomancer');
            $('#georefsources').html('<img style="height: 25px;" src="images/specimen/logo_biogeo.gif" />');
        }
        else if (selectedData.sourceGoogle) {
            $('#source').html('Valid according to:<br />Google');
            $('#georefsources').html('<img style="height: 25px;" src="images/specimen/logo_google.png" />');
        }
        else if (selectedData.sourceGeonames) {
            $('#source').html('Valid according to:<br />GeoNames');
            $('#sourceOcean').html('Valid according to:<br />GeoNames');
            $('#georefsources').html('<img style="height: 25px;" src="images/specimen/logo_geonames.gif" />');
        }
        else {
            notValid();
        }
    }
    
    function selectGoogleSource() {
        selectedData.municipality = googleData.municipality;
        selectedData.stateprovince = googleData.stateprovince;
        selectedData.country = googleData.country;
        selectedData.geodeticdatum = googleData.geodeticdatum;
        selectedData.sourceGoogle = true;
        selectedData.sourceGeonames = false;
    	
        setValues();
    }
    
    function selectGeonamesSource() {
        selectedData.municipality = geonamesData.municipality;
        selectedData.stateprovince = geonamesData.stateprovince;
        selectedData.country = geonamesData.country;
        selectedData.geodeticdatum = geonamesData.geodeticdatum;
        selectedData.waterbody = geonamesData.waterbody;
        selectedData.sourceGeonames = true;
        selectedData.sourceGoogle = false;
    	
        setValues();
    }

</script>

<!-- div necessária para as animações aparecerem -->
<!-- <div style="height:80px;"></div>

<div class="geoTitle" style="margin-left:45px;"><span class="abbr">BGT</span><span class="title">BDD Georeferencing Tool</span></div>
<div class="geoTitle"><span class="abbr">Form</span><span class="title">Location and Geospatial Data</span></div>
<div style="clear:both;"></div> -->

<div class="geoContents">
    <div class="geoStepTitle" style="margin-left:45px;">
        <div class="number">1</div>
        <div class="title">What kind of data do you have?</div>
        <div style="clear:both;"></div>
    </div>	
    <div class="geoStepTitle">
        <div class="number">2</div>
        <div class="title">Select the data source</div>
        <div onclick="stepGeo(1,2)" class="geoIcon" style="margin-right: 5px;"><?php showIcon("Next", "ui-icon-arrowthick-1-e", 1); ?></div><div onclick="stepGeo(1,0)" class="geoIcon"><?php showIcon("Back", "ui-icon-arrowthick-1-w", 1); ?></div>
        <div style="clear:both;"></div>
    </div>	
    <div class="geoStepTitle">
        <div class="number">3</div>
        <div class="title">Select the uncertainty of the coordinates</div>
        <div onclick="selectGeoForm()" class="geoIcon" style="margin-right: 5px;"><?php showIcon("Next", "ui-icon-arrowthick-1-e", 1); ?></div><div onclick="stepGeo(2,1)" class="geoIcon"><?php showIcon("Back", "ui-icon-arrowthick-1-w", 1); ?></div>
        <div style="clear:both;"></div>
    </div>
    <div style="clear:both;"></div>

    <div class="geoStepContents">
        <div id="geoToolLeft" style="margin-left: 45px;">
            <div class="title"><?php echo CHtml::encode(Yii::t('yii', 'The geographic coordinates')); ?></div>
            <div style="clear:both;"></div>
            <div class="sub" style="padding-left: 8px; margin-top: 40px;">
                <div class="key"><?php echo Yii::t('yii', "Latitude") ?></div>
                <div class="value"><input id="lat" size="18" type="number" style="width: 120px"/></div>
                <div style="clear:both;"></div>
                <div class="key"><?php echo Yii::t('yii', "Longitude") ?></div>
                <div class="value"><input id="lng" size="18" type="number" style="width: 120px"/></div>
                <div style="clear:both;"></div>
            </div>    
            <div style="margin-top: 51px;"><input id="btnLatLng" type="button" value="Rev. Georeferencing" style="width:100%"></div>
        </div>

        <div id="geoToolMiddle">
            <div class="title"><?php echo CHtml::encode(Yii::t('yii', 'An aproximate location')); ?></div>
            <div style="clear:both;"></div>
            <div><img src="images/specimen/globe.png" style="margin: 20px auto 0px; width: 100px;"/></div>
            <div style="margin-top: 31.7px;"><input id="btnBgt" type="button" value="Georeferencing using Map"></div>
        </div>

        <div id="geoToolRight">
            <div class="title"><?php echo CHtml::encode(Yii::t('yii', 'A recorded locality name')); ?></div>
            <div style="clear:both;"></div>
            <div class="sub"> 
                <div class="key"><?php echo Yii::t('yii', "Locality") ?></div>
                <div class="value"><input style="width: 120px" id="locality" size="18" type="text"/></div>
                <div style="clear:both;"></div>
            </div>
            <div class="title">Context</div>
            <div style="clear:both;"></div>
            <div class="sub"> 
                <div class="key"><?php echo Yii::t('yii', "Country") ?></div>
                <div class="value"><input style="width: 120px" id="country" size="18" type="text"/></div>
                <div style="clear:both;"></div>
                <div class="key"><?php echo Yii::t('yii', "State") ?></div>
                <div class="value"><input style="width: 120px" id="state" size="18" type="text"/></div>
                <div style="clear:both;"></div>
            </div>	       
            <div style="margin-top: 10px;"><input id="btnGeoref" type="button" value="Georeferencing" style="width:100%;"></div> 
        </div>

        <div style="clear:both"></div>
    </div>
    <div class="geoStepContents">
        <div id="revgeoStep">
            <div class="mainFieldsTable" id="defaultStep">
                <div class="geoToolLoading">
                    <?php echo Yii::t('yii', 'Please wait while data are retrieving from data sources. <br>This may take a few seconds depending on the each data source.'); ?>
                </div>
                <table class="geoToolMain">
                    <tr>
                        <td></td>
                        <td><img style="height: 25px;" src="images/specimen/logo_google.png" /><br />Google</td>
                        <td><img style="height: 25px;" src="images/specimen/logo_geonames.gif"/><br />GeoNames</td>
                        <td><img style="height: 25px;" src="images/main/logo_bdd.png" /><br />Selected</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><img id="loadGoogle" style="width: 25px;" src="images/main/ajax-loader2.gif"/></td>
                        <td><img id="loadGeonames" style="width: 25px;" src="images/main/ajax-loader2.gif"/></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="text-align:right;">Country</td>
                        <td><input disabled="true" id="google_country" type="text"/></td>
                        <td><input disabled="true" id="geonames_country" type="text"/></td>
                        <td><input disabled="true" id="selected_country" type="text" style="width: 198px;"/></td>
                    </tr>
                    <tr>
                        <td style="text-align:right;">State or Province</td>	    		
                        <td><input disabled="true" id="google_stateprovince" type="text"/></td>
                        <td><input disabled="true" id="geonames_stateprovince" type="text"/></td>
                        <td><input disabled="true" id="selected_stateprovince" type="text" style="width: 198px;"/></td>
                    </tr>
                    <tr>
                        <td style="text-align:right;">Municipality</td>
                        <td><input disabled="true" id="google_municipality" type="text"/></td>
                        <td><input disabled="true" id="geonames_municipality" type="text"/></td>
                        <td><input disabled="true" id="selected_municipality" type="text" style="width: 198px;"/></td>
                    </tr>
                    <tr>
                        <td style="text-align:right;">Geodetic Datum</td>
                        <td><input disabled="true" id="google_geodeticdatum" type="text"/></td>
                        <td><input disabled="true" id="geonames_geodeticdatum" type="text"/></td>
                        <td><input disabled="true" id="selected_geodeticdatum" type="text" style="width: 198px;" /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input id="buttonGoogleSource" type="button" onclick="selectGoogleSource();" value="Select" style="width:100%"/></td>
                        <td><input id="buttonGeonamesSource" type="button" onclick="selectGeonamesSource();" value="Select" style="width:100%"/></td>
                        <td><div id="source"></div></td>
                    </tr>	   
                </table>		    
            </div>
            <div class="mainFieldsTable" id="oceanStep">
                <div class="geoToolLoading">
                    <?php echo Yii::t('yii', 'An ocean was found.'); ?>
                </div>
                <table class="geoToolMain">
                    <tr>
                        <td></td>
                        <td><img style="height: 25px;" src="images/specimen/logo_geonames.gif"/><br />GeoNames</td>
                        <td><img style="height: 25px;" src="images/main/logo_bdd.png" /><br />Selected</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><img id="loadGeonamesOcean" style="width: 25px;" src="images/main/ajax-loader2.gif"/></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="text-align:right;">Water body (Ocean)</td>
                        <td><input disabled="true" id="geonames_waterbody" type="text"/></td>
                        <td><input disabled="true" id="selected_waterbody" type="text" style="width: 198px;"/></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input id="buttonGeonamesSource" type="button" onclick="selectGeonamesSource();" value="Select" style="width:100%"/></td>
                        <td><div id="sourceOcean"></div></td>
                    </tr>	   
                </table>
            </div>
            <div class="mainFieldsTable">
                <table class="geoToolMain">
                    <tr>
                        <td style="width:40%;"><div>Decimal Latitude:</div><div><span id="selected_lat"/></div></td>
                        <td style="width:40%;"><div>Decimal Longitude:</div><div><span id="selected_lng"/></td>	    
                    </tr>
                </table>
                <table class="geoToolMain">
                    <tr>
                        <td><span id="revgeoMap"/></td>
                    </tr>		   		   	   		    	
                </table>	    
            </div>
        </div>

        <div id="georefStep">						
        </div>		
    </div>
    <div class="geoStepContents">
        <div id="map" style="height:600px;"/></div>
</div>
</div>

<div class="geoContents">
    <div class="mainFieldsTable">
        <table id="locationelementsblock_1" cellspacing="0" cellpadding="0" align="center" class="geoToolMain">
            <tr>
                <!--
                <td>
                <?php echo "Georeference sources "; ?>
                </td>
                <td style="width:25px;">	                
                </td>
                <td>
                <?php echo CHtml::activeHiddenField($localityElement, 'googlevalidation'); ?>
                <?php echo CHtml::activeHiddenField($localityElement, 'geonamesvalidation'); ?>
                <?php echo CHtml::activeHiddenField($localityElement, 'biogeomancervalidation'); ?>
                                    <span id="georefsources"></span>
                </td>
                <td class="acIcon"></td>
                -->
            </tr>
            <tr id="decimallatituderow">
                <td class="tablelabelcel" style="text-align: center; width: 260px;">
                    <?php echo CHtml::activeLabel($geospatialElement, 'decimallatitude'); ?>
                </td>
                <td style="width:25px;" class="tablemiddlecel">	                
                </td>
                <td class="tablefieldcel"><?php echo $geospatialElement->decimallatitude; ?></td>
                <td class="acIcon"></td>
            </tr>
            <tr id="decimallongituderow">
                <td class="tablelabelcel" style="text-align: center; width: 260px;">
                    <?php echo CHtml::activeLabel($geospatialElement, 'decimallongitude'); ?>
                </td>
                <td style="width:25px;" class="tablemiddlecel">	                
                </td>
                <td class="tablefieldcel"><?php echo $geospatialElement->decimallongitude; ?></td>
                <td class="acIcon"></td>
            </tr>
            <tr id="coordinateuncertaintyinmetersrow" >
                <td class="tablelabelcel" style="text-align: center; width: 260px;">
                    <?php echo CHtml::activeLabel($geospatialElement, "coordinateuncertaintyinmeters"); ?>
                </td>
                <td style="width:25px;">	                
                </td>
                <td class="tablefieldcel"><?php echo $geospatialElement->coordinateuncertaintyinmeters; ?></td>
                <td class="acIcon"></td>
            </tr>
            <tr id="geodeticdatumrow">
                <td class="tablelabelcel" style="text-align: center; width: 260px;">
                    <?php echo CHtml::activeLabel($geospatialElement, "geodeticdatum"); ?>
                </td>
                <td style="width:25px;" class="tablemiddlecel">	                
                </td>
                <td class="tablefieldcel"><?php echo $geospatialElement->geodeticdatum; ?></td>
                <td></td>
            </tr>
            <tr id="countryrow">
                <td class="tablelabelcel" style="text-align: center; width: 260px;">	                
                    <?php echo CHtml::activeLabel(CountryAR::model(), 'country'); ?>
                </td>
                <td style="width:25px;" class="tablemiddlecel">	                
                </td>
                <td class="tablefieldcel"><?php echo $localityElement->country->country; ?></td>
                <td class="acIcon"></td>
            </tr>
            <tr id="stateprovincerow">
               <td class="tablelabelcel" style="text-align: center; width: 260px;">	                
                    <?php echo CHtml::activeLabel(StateProvinceAR::model(), 'stateprovince'); ?>
                </td>
                <td style="width:25px;" class="tablemiddlecel">	                
                </td>
                <td class="tablefieldcel"><?php echo $localityElement->stateprovince->stateprovince; ?></td>
                <td class="acIcon"></td>
            </tr>
            <tr id="municipalityrow">
                <td class="tablelabelcel" style="text-align: center; width: 260px;">	                
                    <?php echo CHtml::activeLabel(MunicipalityAR::model(), 'municipality'); ?>
                </td>
                <td style="width:25px;" class="tablemiddlecel">	                
                </td>
                <td class="tablefieldcel"><?php echo $localityElement->municipality->municipality; ?></td>
                <td class="acIcon"></td>
            </tr>
            <tr id="waterbodyrow">
                <td class="tablelabelcel" style="text-align: center; width: 260px;">
                    <?php echo CHtml::activeLabel($localityElement->waterbody, 'waterbody'); ?>
                </td>
                <td style="width:25px;" class="tablemiddlecel">
                </td>
                <td class="tablefieldcel"><?php echo $localityElement->waterbody->waterbody; ?></td>
                <td class="acIcon"></td>
            </tr>      			     	        
        </table>
    </div>
    <div class="yiiForm" style="width:100%; float:left">
        <table id="locationelementsblock_2" cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
            <div class="tablerow" id='divpointradiusspatialfit'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($geospatialElement, "pointradiusspatialfit"); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image src="images/help.gif">', 'index.php?r=help&helpfield=pointradiusspatialfit', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php echo $geospatialElement->pointradiusspatialfit; ?></td>
                    <td class="acIcon"></td>
                </tr>
            </div>
        </table>

        <table id="locationelementsblock_3" cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
            <div class="tablerow" id='divverbatimcoordinate'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($geospatialElement, "verbatimcoordinate"); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image src="images/help.gif">', 'index.php?r=help&helpfield=verbatimcoordinate', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php echo $geospatialElement->verbatimcoordinate; ?></td>
                    <td class="acIcon"></td>
                </tr>
            </div>
            <div class="tablerow" id='divverbatimlatitude'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($geospatialElement, "verbatimlatitude"); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image src="images/help.gif">', 'index.php?r=help&helpfield=verbatimlatitude', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php echo $geospatialElement->verbatimlatitude; ?></td>
                    <td class="acIcon"></td>
                </tr>
            </div>
            <div class="tablerow" id='divverbatimlongitude'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($geospatialElement, "verbatimlongitude"); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image src="images/help.gif">', 'index.php?r=help&helpfield=verbatimlongitude', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php echo $geospatialElement->verbatimlongitude; ?></td>
                    <td class="acIcon"></td>
                </tr>
            </div>
            <div class="tablerow" id='divverbatimcoordinatesystem'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($geospatialElement, "verbatimcoordinatesystem"); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image src="images/help.gif">', 'index.php?r=help&helpfield=verbatimcoordinatesystem', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php echo $geospatialElement->verbatimcoordinatesystem; ?></td>
                    <td class="acIcon"></td>
                </tr>
            </div>
        </table>

        <table id="locationelementsblock_4" cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
            <div class="tablerow" id='divgeoreferenceprotocol'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($geospatialElement, "georeferenceprotocol"); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image src="images/help.gif">', 'index.php?r=help&helpfield=georeferenceprotocol', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php echo $geospatialElement->georeferenceprotocol; ?></td>
                    <td class="acIcon"></td>
                </tr>
            </div>
            <div class="tablerow" id='divgeoreferenceverificationstatus'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($geospatialElement->georeferenceverificationstatus, 'georeferenceverificationstatus'); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image src="images/help.gif">', 'index.php?r=help&helpfield=georeferenceverificationstatus', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php echo $geospatialElement->georeferenceverificationstatus->georeferenceverificationstatus; ?></td>
                    <td></td>
                </tr>
            </div>
            <div class="tablerow" id='divgeoreferenceremark'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($geospatialElement, "georeferenceremark"); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image src="images/help.gif">', 'index.php?r=help&helpfield=georeferenceremark', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php echo $geospatialElement->georeferenceremark; ?></td>
                    <td class="acIcon"></td>
                </tr>
            </div>
        </table>

        <table id="locationelementsblock_5" cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
            <div class="tablerow" id='divfootprintwkt'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($geospatialElement, "footprintwkt"); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image src="images/help.gif">', 'index.php?r=help&helpfield=footprintwkt', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php echo $geospatialElement->footprintwkt; ?></td>
                    <td class="acIcon"></td>
                </tr>
            </div>
            <div class="tablerow" id='divfootprintspatialfit'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($geospatialElement, "footprintspatialfit"); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image src="images/help.gif">', 'index.php?r=help&helpfield=footprintspatialfit', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php $geospatialElement->footprintspatialfit; ?></td>
                    <td class="acIcon"></td>
                </tr>
            </div>
        </table>

        <table id="locationelementsblock_6" cellspacing="0" cellpadding="0" align="center" class="fieldsTable">		
            <tr id="divcounty">
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel(CountyAR::model(), 'county'); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=county', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel"><?php echo $localityElement->county->county; ?></td>
                <td class="acIcon"></td>
            </tr>

            <tr id="divlocality">
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel(LocalityAR::model(), 'locality'); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=locality', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel"><?php echo $localityElement->locality->locality; ?></td>
                <td class="acIcon"></td>
            </tr>
        </table>
        <table id="locationelementsblock_7" cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
            <div class="tablerow" id='divcontinent'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel(ContinentAR::model(), "continent"); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image src="images/help.gif">', 'index.php?r=help&helpfield=continent', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php echo $localityElement->continent->continent; ?></td>
                    <td class="acIcon"></td>
                </tr>
            </div>
            <div class="tablerow" id='divislandgroup'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($localityElement->islandgroup, 'islandgroup'); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image src="images/help.gif">', 'index.php?r=help&helpfield=islandgroup', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php echo $localityElement->islandgroup->islandgroup; ?></td>
                    <td></td>
                </tr>
            </div>
            <div class="tablerow" id='divisland'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($localityElement->island, 'island'); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image src="images/help.gif">', 'index.php?r=help&helpfield=island', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php echo $localityElement->island->island; ?></td>
                    <td></td>
                </tr>
            </div>
        </table>
        <table id="locationelementsblock_8" cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
            <!--<div class="tablerow" id='divhabitat'>
                <tr>
                    <td class="tablelabelcel">
            <?php //echo CHtml::activeLabel($localityElement->habitat, 'habitat');?>
                    </td>
                    <td class="tablemiddlecel">
            <?php //echo CHtml::link('<image src="images/help.gif">','index.php?r=help&helpfield=habitat',array('rel'=>'lightbox'));?>
                    </td>
                    <td class="tablefieldcel">
                        <div class="field autocomplete">
            <?php //echo CHtml::activeHiddenField($localityElement,'idhabitat');?>
            <?php //echo CHtml::activeTextField($localityElement->habitat, 'habitat', array('class'=>'textfield'));?>
                        </div>
                    </td>
                    <td class="acIcon" id="autocompleteHabitatLocality"></td>
                </tr>
            </div>-->
            <div class="tablerow" id='divlocationaccordingto'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($localityElement, 'locationaccordingto'); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image src="images/help.gif">', 'index.php?r=help&helpfield=locationaccordingto', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php echo $localityElement->locationaccordingto; ?></td>
                    <td class="acIcon"></td>
                </tr>
            </div>
            <div class="tablerow" id='divcoordinateprecision'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($localityElement, 'coordinateprecision'); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image src="images/help.gif">', 'index.php?r=help&helpfield=coordinateprecision', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php echo $localityElement->coordinateprecision; ?></td>
                    <td class="acIcon"></td>
                </tr>
            </div>
            <div class="tablerow" id='divlocationremark'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($localityElement, 'locationremark'); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image src="images/help.gif">', 'index.php?r=help&helpfield=locationremark', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php echo $localityElement->locationremark; ?></td>
                    <td class="acIcon"></td>
                </tr>
            </div>
        </table>

        <table id="locationelementsblock_9" cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
            <div class="tablerow" id='divminimumelevationinmeters'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($localityElement, 'minimumelevationinmeters'); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image src="images/help.gif">', 'index.php?r=help&helpfield=minimumelevationinmeters', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php echo $localityElement->minimumelevationinmeters; ?></td>
                    <td class="acIcon"></td>
                </tr>
            </div>
            <div class="tablerow" id='divmaximumelevationinmeters'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($localityElement, 'maximumelevationinmeters'); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image src="images/help.gif">', 'index.php?r=help&helpfield=maximumelevationinmeters', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php echo $localityElement->maximumelevationinmeters; ?></td>
                    <td class="acIcon"></td>
                </tr>
            </div>
        </table>

        <table id="locationelementsblock_10" cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
            <div class="tablerow" id='divminimumdepthinmeters'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($localityElement, 'minimumdepthinmeters'); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image src="images/help.gif">', 'index.php?r=help&helpfield=minimumdepthinmeters', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php echo $localityElement->minimumdepthinmeters; ?></td>
                    <td class="acIcon"></td>
                </tr>
            </div>
            <div class="tablerow" id='divmaximumdepthinmeters'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($localityElement, 'maximumdepthinmeters'); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image src="images/help.gif">', 'index.php?r=help&helpfield=maximumdepthinmeters', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php echo $localityElement->maximumdepthinmeters; ?></td>
                    <td class="acIcon"></td>
                </tr>
            </div>
        </table>

        <table id="locationelementsblock_11" cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
            <div class="tablerow" id='divminimumdistanceabovesurfaceinmeters'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($localityElement, 'minimumdistanceabovesurfaceinmeters'); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image src="images/help.gif">', 'index.php?r=help&helpfield=minimumdistanceabovesurfaceinmeters', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php echo $localityElement->minimumdistanceabovesurfaceinmeters; ?></td>
                    <td class="acIcon"></td>
                </tr>
            </div>
            <div class="tablerow" id='divmaximumdistanceabovesurfaceinmeters'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($localityElement, 'maximumdistanceabovesurfaceinmeters'); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image src="images/help.gif">', 'index.php?r=help&helpfield=maximumdistanceabovesurfaceinmeters', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php echo $localityElement->maximumdistanceabovesurfaceinmeters; ?></td>
                    <td class="acIcon"></td>
                </tr>
            </div>
        </table>

        <table id="locationelementsblock_12" cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
            <div class="tablerow" id='divverbatimdepth'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($localityElement, 'verbatimdepth'); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image src="images/help.gif">', 'index.php?r=help&helpfield=verbatimdepth', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php echo $localityElement->verbatimdepth; ?></td>
                    <td class="acIcon"></td>
                </tr>
            </div>
            <div class="tablerow" id='divverbatimelevation'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($localityElement, 'verbatimelevation'); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image src="images/help.gif">', 'index.php?r=help&helpfield=verbatimelevation', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php echo $localityElement->verbatimelevation; ?></td>
                    <td class="acIcon"></td>
                </tr>
            </div>
            <div class="tablerow" id='divverbatimlocality'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($localityElement, 'verbatimlocality'); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image src="images/help.gif">', 'index.php?r=help&helpfield=verbatimlocality', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php echo $localityElement->verbatimlocality; ?></td>
                    <td class="acIcon"></td>
                </tr>
            </div>
            <div class="tablerow" id='divverbatimsrs'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($localityElement, 'verbatimsrs'); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image src="images/help.gif">', 'index.php?r=help&helpfield=verbatimsrs', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php echo $localityElement->verbatimsrs; ?></td>
                    <td class="acIcon"></td>
                </tr>
            </div>
        </table>

        <table id="locationelementsblock_13" cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
            <div class="tablerow" id='divgeoreferencedby'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel(GeoreferencedByAR::model(), "georeferencedby"); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image src="images/help.gif">', 'index.php?r=help&helpfield=georeferencedby', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel">
                        <?php
                        $georeferencedby = "";
                        foreach ($localityElement->georeferencedby as $value) {
                            $georeferencedby .= $value->georeferencedby . ", ";
                        }
                        $georeferencedby = substr($georeferencedby, 0, -2);
                        echo $georeferencedby;
                        ?>
                    </td>
                    <td class="acIcon"></td>
                </tr>
            </div>
        </table>

        <table id="locationelementsblock_14" cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
            <div class="tablerow" id='divfootprintsrs'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($localityElement, 'footprintsrs'); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image src="images/help.gif">', 'index.php?r=help&helpfield=footprintsrs', array('rel' => 'lightbox')); ?>
                    </td>
                    <td class="tablefieldcel"><?php echo $localityElement->footprintsrs; ?></td>
                    <td class="acIcon"></td>
                </tr>
            </div>
        </table>
    </div>
</div>