function openBGT(){
    $('#dialog').dialog('destroy');
    $('#dialog').dialog().remove();
    $('#dialog').remove();
    $('<div id="dialog"/>').load('index.php?r=georeferencingtool', {
        "term": 'teste',
        "controller": '_controller'
    }).dialog({
        modal:true,
        title: 'BDD Georeferencing Tool',
        show:'blind',
        hide:'blind',
        width: 1100,
        height:740,
        buttons: {
            'Select': function(){
                $(this).dialog('close');
            }
        },
        open: function(){
            //$(".ui-dialog-titlebar-close").hide();
            dialog=true;
        },
        close: function(){
            opened = false;
            dialog = false;
            //lat = $("#GeospatialElementAR_decimallatitude").val();
            //lng = $("#GeospatialElementAR_decimallongitude").val());
            stepGeo(0,1);
            /*if($('#CountryAR_country').val()==''&&
                $('#StateProvinceAR_stateprovince').val()==''&&
                $('#CountyAR_county').val()==''&&
                $('#MunicipalityAR_municipality').val()=='')
                {
                $('#countryField').hide();
                $('#stateProvinceField').hide();
                $('#countyField').hide();
                $('#municipalityField').hide();
                $('#locationField').show();
            }else{
                $('#countryField').show();
                $('#stateProvinceField').show();
                $('#countyField').show();
                $('#municipalityField').show();
                $('#locationField').hide();
                //georeferencing();
            }*/
        }
    });
}
function configLocation(){    
    if($('#CountryAR_country').val()==''&&
        $('#StateProvinceAR_stateprovince').val()==''&&
        $('#CountyAR_county').val()==''&&
        $('#MunicipalityAR_municipality').val()=='')
        {
	        $('#countryField').hide();
	        $('#stateProvinceField').hide();
	        $('#countyField').hide();
	        $('#municipalityField').hide();
	        $('#locationField').show();
    }else{
        $('#countryField').show();
        $('#stateProvinceField').show();
        $('#countyField').show();
        $('#municipalityField').show();
        $('#locationField').hide();
        //if($('#GeospatialElementAR_decimallatitude').val()==''&&$('#GeospatialElementAR_decimallongitude').val()=='')
          //  georeferencing();
    }
    
    $('#location').autocomplete({
        source: 'index.php?r=localityelement/search',
        minLength: 2,
        select: function( event, ui ) {
            $.ajax({
                type: 'POST',
                dataType: "json",
                url: 'index.php?r=localityelement/getJSON',
                data: {
                    "id": ui.item.id
                },
                success: function(json){
                    $('#CountryAR_country').val(json.country);
                    $('#StateProvinceAR_stateprovince').val(json.stateprovince);
                    $('#CountyAR_county').val(json.county);
                    $('#MunicipalityAR_municipality').val(json.municipality);
                    georeferencing();
                    $('#countryField').show();
                    $('#stateProvinceField').show();
                    $('#countyField').show();
                    $('#municipalityField').show();
                    $('#locationField').hide();
                //if(json.success){
                //    $('#LocalityElementAR_idcountry').val(json.id);
                //    $('#CountryAR_country').val(json.field);
                //}
                }
            });
            
        }
    });
}
function reverseGeocoding () {
    $("#GeospatialElementAR_decimallongitude").blur(function() {
        if($.trim($("#GeospatialElementAR_decimallongitude").val().toString())!=''&&$.trim($("#GeospatialElementAR_decimallatitude").val().toString())!=''){
            geocoding($("#GeospatialElementAR_decimallatitude").val(),$("#GeospatialElementAR_decimallongitude").val());            
        }else{
            if($('#CountryAR_country').val()==''&&
                $('#StateProvinceAR_stateprovince').val()==''&&
                $('#CountyAR_county').val()==''&&
                $('#MunicipalityAR_municipality').val()=='')
                {
                $('#countryField').hide();
                $('#stateProvinceField').hide();
                $('#countyField').hide();
                $('#municipalityField').hide();
                $('#locationField').show();
            }else{
                $('#countryField').show();
                $('#stateProvinceField').show();
                $('#countyField').show();
                $('#municipalityField').show();
                $('#locationField').hide();
            //              if($('#GeospatialElementAR_decimallatitude').val()==''&&$('#GeospatialElementAR_decimallongitude').val()=='')
            //                    georeferencing();
            }
        }

    });
    $("#GeospatialElementAR_decimallatitude").blur(function() {
        if($.trim($("#GeospatialElementAR_decimallongitude").val().toString())!=''&&$.trim($("#GeospatialElementAR_decimallatitude").val().toString())!=''){
            geocoding($("#GeospatialElementAR_decimallatitude").val(),$("#GeospatialElementAR_decimallongitude").val());              
        }else{
            if($('#CountryAR_country').val()==''&&
                $('#StateProvinceAR_stateprovince').val()==''&&
                $('#CountyAR_county').val()==''&&
                $('#MunicipalityAR_municipality').val()=='')
                {
                $('#countryField').hide();
                $('#stateProvinceField').hide();
                $('#countyField').hide();
                $('#municipalityField').hide();
                $('#locationField').show();
            }else{
                $('#countryField').show();
                $('#stateProvinceField').show();
                $('#countyField').show();
                $('#municipalityField').show();
                $('#locationField').hide();
            //              if($('#GeospatialElementAR_decimallatitude').val()==''&&$('#GeospatialElementAR_decimallongitude').val()=='')
            //                    georeferencing();
            }
        }
    });
}

function showMap(lat, lng, results) {
    if($.trim($("#GeospatialElementAR_decimallongitude").val().toString())!=''&&$.trim($("#GeospatialElementAR_decimallatitude").val().toString())!='') {
        $('#bgtBtn').poshytip('hide');
        $('#bgtBtn').poshytip('destroy');

        var content = '<div><img id="staticMap" src="http://maps.google.com/maps/api/staticmap?center='+lat+','+lng+'&zoom=12&maptype=satellite&size=200x150&sensor=false"></img><div id="loc">'+results+'</div></div>';

        $('#bgtBtn').poshytip({
            className: 'tip-twitter',
            alignTo: 'target',
            alignX: 'center',
            alignY: 'bottom', 
            offsetX: 20,
            offsetY: 5,
            content: content,
            showOn: 'none'
        }).poshytip('show');

        setTimeout(function() {
            $('#bgtBtn').poshytip('hide');
            setTimeout(function() {
                $('#bgtBtn').poshytip('destroy');
            }, 500);
        }, 10000);
    }
}

function geocoding (lat, lng)
{

    var geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(parseFloat(lat), parseFloat(lng));

    geocoder.geocode({
        'latLng': latlng,
        'language':'BR'
    }, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            for (var i = 0; i < results[0].address_components.length; i++){
                if(results[0].address_components[i].types[0]=="country"){
                    $('#CountryAR_country').val(results[0].address_components[i].long_name);
                    if($('#CountryAR_country').val()!=''){
                        $.ajax({
                            type: 'POST',
                            dataType: "json",
                            url: 'index.php?r=country/getJSON',
                            data: {
                                "field": $('#CountryAR_country').val()
                            },
                            success: function(json){
                                if(json.success){
                                    $('#LocalityElementAR_idcountry').val(json.id);
                                    $('#CountryAR_country').val(json.field);
                                }else{
                                	$.ajax({
			                            type: 'POST',
			                            dataType: "json",
			                            url: 'index.php?r=country/save',
			                            data: {
			                                "field": $('#CountryAR_country').val()
			                            },
			                            success: function(json){
			                                if(json.success){
			                                    $('#LocalityElementAR_idcountry').val(json.id);
			                                    $('#CountryAR_country').val(json.field);
			                                }
			                            }
			                        });
                                }
                            }
                        });
                    //$("#countryField").hide();
                    }
                }
                if(results[0].address_components[i].types[0]=="administrative_area_level_1"){
                    $('#StateProvinceAR_stateprovince').val(results[0].address_components[i].long_name);
                    if($('#StatePronvinceAR_stateprovince').val()!=''){
                        $.ajax({
                            type: 'POST',
                            dataType: "json",
                            url: 'index.php?r=stateprovince/getJSON',
                            data: {
                                "field": $('#StateProvinceAR_stateprovince').val()
                            },
                            success: function(json){
                                if(json.success){
                                    $('#LocalityElementAR_idstateprovince').val(json.id);
                                    $('#StateProvinceAR_stateprovince').val(json.field);
                                }else{
                                	$.ajax({
			                            type: 'POST',
			                            dataType: "json",
			                            url: 'index.php?r=stateprovince/save',
			                            data: {
			                                "field": $('#StateProvinceAR_stateprovince').val()
			                            },
			                            success: function(json){
			                                if(json.success){
			                                    $('#LocalityElementAR_idstateprovince').val(json.id);
			                                    $('#StateProvinceAR_stateprovince').val(json.field);
			                                }
			                            }
			                        });
                                }
                            }
                        });
                        
                    //$("#stateProvinceField").hide();
                    }
                }
                if(results[0].address_components[i].types[0]=="administrative_area_level_2"){
                    $('#CountyAR_county').val(results[0].address_components[i].long_name);
                    if($('#CountyAR_county').val()!=''){
                        $.ajax({
                            type: 'POST',
                            dataType: "json",
                            url: 'index.php?r=county/getJSON',
                            data: {
                                "field": $('#CountyAR_county').val()
                            },
                            success: function(json){
                                if(json.success){
                                    $('#LocalityElementAR_idcounty').val(json.id);
                                    $('#CountyAR_county').val(json.field);
                                }else{
                                	$.ajax({
			                            type: 'POST',
			                            dataType: "json",
			                            url: 'index.php?r=county/save',
			                            data: {
			                                "field": $('#CountyAR_county').val()
			                            },
			                            success: function(json){
			                                if(json.success){
			                                    $('#LocalityElementAR_idcounty').val(json.id);
			                                    $('#CountyAR_county').val(json.field);
			                                }
			                            }
			                        });
                                }
                            }
                        });                        
                    //$("#countyField").hide();
                    }
                }
                if(results[0].address_components[i].types[0]=="locality"){
                    $('#MunicipalityAR_municipality').val(results[0].address_components[i].long_name);
                    if($('#MunicipalityAR_municipality').val()!=''){
                    	$.ajax({
                            type: 'POST',
                            dataType: "json",
                            url: 'index.php?r=municipality/getJSON',
                            data: {
                                "field": $('#MunicipalityAR_municipality').val()
                            },
                            success: function(json){
                                if(json.success){
                                    $('#LocalityElementAR_idmunicipality').val(json.id);
                                    $('#MunicipalityAR_municipality').val(json.field);
                                    
                                }else{
                                	$.ajax({
			                            type: 'POST',
			                            dataType: "json",
			                            url: 'index.php?r=municipality/save',
			                            data: {
			                                "field": $('#MunicipalityAR_municipality').val()
			                            },
			                            success: function(json){
			                                if(json.success){
			                                    $('#LocalityElementAR_idmunicipality').val(json.id);
			                                    $('#MunicipalityAR_municipality').val(json.field);
			                                }
			                            }
			                        });
                                }
                            }
                        });                        
                    //$("#municipalityField").hide();
                    }
                }
                showMap(lat, lng, results[0].formatted_address);
                if($('#CountryAR_country').val()==''&&
                    $('#StateProvinceAR_stateprovince').val()==''&&
                    $('#CountyAR_county').val()==''&&
                    $('#MunicipalityAR_municipality').val()=='')
                    {
                    $('#countryField').hide();
                    $('#stateProvinceField').hide();
                    $('#countyField').hide();
                    $('#municipalityField').hide();
                    $('#locationField').show();
                }else{
                    $('#countryField').show();
                    $('#stateProvinceField').show();
                    $('#countyField').show();
                    $('#municipalityField').show();
                    $('#locationField').hide();
                    if($('#GeospatialElementAR_decimallatitude').val()==''&&$('#GeospatialElementAR_decimallongitude').val()=='')
                        georeferencing();
                }
            }
        }
        else {
            //console.log('No results found: ' + status);
        }
    });
}

function georeferencing()
{
    var geocoder = new google.maps.Geocoder();
    //var latlng = new google.maps.LatLng(parseFloat(lat), parseFloat(lng));
    
    var address = $('#MunicipalityAR_municipality').val()+', '+$('#CountyAR_county').val()+', '+$('#StateProvinceAR_stateprovince').val()+', '+$('#CountryAR_country').val();

    geocoder.geocode({
        'address': address
    }, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            var a = results[0].geometry.location.toString().split(',',2);
            ;
            var lat = a[0].replace("(", "", "gi");
            var lng = a[1].replace(")", "", "gi");
            $("#GeospatialElementAR_decimallongitude").val($("#GeospatialElementAR_decimallongitude").val()==''?lng:$("#GeospatialElementAR_decimallongitude").val());
            $("#GeospatialElementAR_decimallatitude").val($("#GeospatialElementAR_decimallatitude").val(lat)==''?lat:$("#GeospatialElementAR_decimallatitude").val());
            
            for (var i = 0; i < results[0].address_components.length; i++){
                if(results[0].address_components[i].types[0]=="country"){
                    $('#CountryAR_country').val(results[0].address_components[i].long_name);
                    if($('#CountryAR_country').val()!=''){
                        $.ajax({
                            type: 'POST',
                            dataType: "json",
                            url: 'index.php?r=country/getJSON',
                            data: {
                                "field": $('#CountryAR_country').val()
                            },
                            success: function(json){
                                if(json.success){
                                    $('#LocalityElementAR_idcountry').val(json.id);
                                    $('#CountryAR_country').val(json.field);
                                }else{
                                    $.ajax({
                                        type: 'POST',
                                        dataType: "json",
                                        url: 'index.php?r=country/save',
                                        data: {
                                            "field": $('#CountryAR_country').val()
                                        },
                                        success: function(json){
                                            if(json.success){
                                                $('#LocalityElementAR_idcountry').val(json.id);
                                                $('#CountryAR_country').val(json.field);
                                            }
                                        }
                                    });
                                }
                            }
                        });
                    //$("#countryField").hide();
                    }
                }
                if(results[0].address_components[i].types[0]=="administrative_area_level_1"){
                    $('#StateProvinceAR_stateprovince').val(results[0].address_components[i].long_name);
                    if($('#StatePronvinceAR_stateprovince').val()!=''){
                        $.ajax({
                            type: 'POST',
                            dataType: "json",
                            url: 'index.php?r=stateprovince/getJSON',
                            data: {
                                "field": $('#StateProvinceAR_stateprovince').val()
                            },
                            success: function(json){
                                if(json.success){
                                    $('#LocalityElementAR_idstateprovince').val(json.id);
                                    $('#StateProvinceAR_stateprovince').val(json.field);
                                }else{
                                    $.ajax({
                                        type: 'POST',
                                        dataType: "json",
                                        url: 'index.php?r=stateprovince/save',
                                        data: {
                                            "field": $('#StateProvinceAR_stateprovince').val()
                                        },
                                        success: function(json){
                                            if(json.success){
                                                $('#LocalityElementAR_idstateprovince').val(json.id);
                                                $('#StateProvinceAR_stateprovince').val(json.field);
                                            }
                                        }
                                    });
                                }
                            }
                        });
                    //$("#stateProvinceField").hide();
                    }
                }
                if(results[0].address_components[i].types[0]=="administrative_area_level_2"){
                    $('#CountyAR_county').val(results[0].address_components[i].long_name);
                    if($('#CountyAR_county').val()!=''){
                        $.ajax({
                            type: 'POST',
                            dataType: "json",
                            url: 'index.php?r=county/getJSON',
                            data: {
                                "field": $('#CountyAR_county').val()
                            },
                            success: function(json){
                                if(json.success){
                                    $('#LocalityElementAR_idcounty').val(json.id);
                                    $('#CountyAR_county').val(json.field);
                                }else{
                                    $.ajax({
                                        type: 'POST',
                                        dataType: "json",
                                        url: 'index.php?r=county/save',
                                        data: {
                                            "field": $('#CountyAR_county').val()
                                        },
                                        success: function(json){
                                            if(json.success){
                                                $('#LocalityElementAR_idcounty').val(json.id);
                                                $('#CountyAR_county').val(json.field);
                                            }
                                        }   
                                    });
                                }
                            }
                        });                   
                    }
                }
                if(results[0].address_components[i].types[0]=="locality"){
                    $('#MunicipalityAR_municipality').val(results[0].address_components[i].long_name);
                    if($('#MunicipalityAR_municipality').val()!=''){
                        $.ajax({
                            type: 'POST',
                            dataType: "json",
                            url: 'index.php?r=municipality/getJSON',
                            data: {
                                "field": $('#MunicipalityAR_municipality').val()
                            },
                            success: function(json){
                                if(json.success){
                                    $('#LocalityElementAR_idmunicipality').val(json.id);
                                    $('#MunicipalityAR_municipality').val(json.field);
                                }else{
                                    $.ajax({
                                        type: 'POST',
                                        dataType: "json",
                                        url: 'index.php?r=municipality/save',
                                        data: {
                                            "field": $('#MunicipalityAR_municipality').val()
                                        },
                                        success: function(json){
                                            if(json.success){
                                                $('#LocalityElementAR_idmunicipality').val(json.id);
                                                $('#MunicipalityAR_municipality').val(json.field);
                                            }
                                        }
                                    });
                                }
                            }
                        });
                    //$("#municipalityField").hide();
                    }
                }
                showMap(lat, lng, results[0].formatted_address);
            }
        }
        else {
            //console.log('No results found: ' + status);
        }
    });
}

function saveLocation() {
	$.ajax({
        type: 'POST',
        dataType: "json",
        url: 'index.php?r=georeferencingtool/save',
        data: {
            "country": selectedData.country,
            "stateprovince": selectedData.stateprovince,
            "municipality": selectedData.municipality,
            "waterbody": selectedData.waterbody	                        
        },
        success: function(json) {
        	if (json.country.ar) {
        		$('#CountryAR_country').val(json.country.ar.country);
        		$('#LocalityElementAR_idcountry').val(json.country.ar.idcountry);
        	}
        	else {
        		$('#CountryAR_country').val("");
        		$('#LocalityElementAR_idcountry').val("");
        	}
			
			if (json.stateprovince.ar) {
				$('#StateProvinceAR_stateprovince').val(json.stateprovince.ar.stateprovince);
        		$('#LocalityElementAR_idstateprovince').val(json.stateprovince.ar.idstateprovince);
			}
			else {
				$('#StateProvinceAR_stateprovince').val("");
        		$('#LocalityElementAR_idstateprovince').val("");
			}        	
        	
        	if (json.municipality.ar) {
        		$('#MunicipalityAR_municipality').val(json.municipality.ar.municipality);
        		$('#LocalityElementAR_idmunicipality').val(json.municipality.ar.idmunicipality);
        	}
        	else {
        		$('#MunicipalityAR_municipality').val("");
        		$('#LocalityElementAR_idmunicipality').val("");
        	}
			
			if (json.waterbody.ar) {
				$('#WaterBodyAR_waterbody').val(json.waterbody.ar.waterbody);
        		$('#LocalityElementAR_idwaterbody').val(json.waterbody.ar.idwaterbody);
			}
			else {
				$('#WaterBodyAR_waterbody').val("");
        		$('#LocalityElementAR_idwaterbody').val("");
			}
			
			if (selectedData.sourceGoogle) {
				$('#LocalityElementAR_googlevalidation').val("1");
			}
			else {
				$('#LocalityElementAR_googlevalidation').val("");
			}
			
			if (selectedData.sourceGeonames) {
				$('#LocalityElementAR_geonamesvalidation').val("1");
			}
			else {
				$('#LocalityElementAR_geonamesvalidation').val("");
			}
			
			if (selectedData.sourceBiogeomancer) {
				$('#LocalityElementAR_biogeomancervalidation').val("1");
			}
			else {
				$('#LocalityElementAR_biogeomancervalidation').val("");
			}
			
			save();	        	
        }
    });
}