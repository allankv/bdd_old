<?php
include_once("protected/extensions/config.php");
$key = getGoogleAPIKey('bddapi@gmail.com', 'datadigitizer');
echo '<script src="http://www.google.com/jsapi?sensor=false&key='.$key.'" type="text/javascript"></script>';
?>

<script type="text/javascript" src="js/jcarousel/lib/jquery.jcarousel.min.js"></script>
<link rel="stylesheet" type="text/css" href="js/jcarousel/skins/tango/skin.css"/>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

<script>
	var loading = '<div id="loading"><img style="margin-top:180px;" src="images/main/ajax-loader4.gif"></img><div style="padding-left:12px; font-weight:bold; color:#BB7700; padding-top:10px; text-shadow:1px 1px 3px #777;">Loading...</div></div>';
	
	google.load('visualization', '1', {packages:['corechart', 'geomap', 'table', 'orgchart', 'motionchart']});
	
    $(document).ready(bootUserPanel);
    
    function bootUserPanel() {
    	drawCountry();
    }
    
    function drawTable(json, id, lowercase, uppercase) {
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
	
	function drawGeoMap(json, id) {
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

    
    function drawCountry() {
        $('#map').html(loading);
        $('#table').html('');

        $.ajax({
            type:'POST',
            url:'index.php?r=analysis/getCountry',
            data: {'list':jFilterList},
            dataType: "json",
            success:function(json) {
                drawGeoMap(json, 'map');                      
                drawTable(json, 'table', 'country', 'Country');
            }
	    });
	}

    //Load Google Earth
    //google.load("earth", "1");
    //var ge;
    //google.setOnLoadCallback(init);
    /*var map;
    var markersArray = [];
    
    function drawMarker(lat, lng, title, content) {
    	if (markersArray) {
			for (i in markersArray) {
				markersArray[i].setMap(null);
			}
		}
		
		markersArray = [];

		var position = new google.maps.LatLng(lat, lng);
	
		var marker = new google.maps.Marker({
			position: position, 
			map: map, 
			title: title
		});
		
		markersArray.push(marker);	
		
		var infowindow = new google.maps.InfoWindow({
		    content: content
		});
		
		google.maps.event.addListener(marker, 'click', function() {
			infowindow.open(map, marker);
		});
	}
*/
    /*function bootUserPanel() {	
    	var zero = new google.maps.LatLng(0, 0);
    
		var myOptions = {
			zoom: 1,
			mapTypeId: google.maps.MapTypeId.TERRAIN,
			center: zero
		};
		
		map = new google.maps.Map(document.getElementById("map"), myOptions);

        <?php //if (count($icCodes) > 0): foreach($icCodes as $n => $ic): ?>
            $('#institutionCarousel').append('<li><div class="institutionCarouselItem" onclick="javascript:showInstitutionInformation(\'<?php echo $ic['institutioncode']; ?>\', <?php echo $ic['idinstitutioncode']; ?>);"><?php echo $ic['institutioncode']; ?></div></li>');
        <?php //endforeach; else:?>
        	$('#institutionCarousel').append('<li><div class="institutionCarouselNoItem">No institutions found.</div></li>');
        <?php //endif;?>
        
        $('#institutionCarousel').jcarousel({
	    	wrap: null,
	    	scroll: 1
	    });
	    
	    $('.institutionCarouselItem').click(function() {
	    	$('.institutionCarouselItem').css({
	    		'margin-top': '20px',
	    		
	    		'-moz-box-shadow': '3px 3px 5px #CCAA77',
    			'-webkit-box-shadow': '3px 3px 5px #CCAA77',
    			'box-shadow': '3px 3px 5px #CCAA77',
    			
    			'background-color': '#F4EFD9',
    			'color': '#336600',
    			'text-shadow': '0px 0px 0px #660033',
    			'border': '1px solid #DDCCAA'
	    	});
	    	$(this).css({
	    		'margin-top': '22px',
	    		
				'-moz-box-shadow': '1px 1px 3px #444444',
    			'-webkit-box-shadow': '1px 1px 3px #444444',
    			'box-shadow': '1px 1px 3px #444444',
    			
    			'background-color': '#337755',
    			'color': '#FFFFFF',
    			'text-shadow': '1px 1px 1px #660033',
    			//'border': '1px solid #337755'
    			'border': '1px solid #006600'
	    	});
	    });
	    
	    $('.institutionCarouselItem').hover(function() {
	    	$(this).css({
				'-moz-box-shadow': '3px 3px 7px #444444',
    			'-webkit-box-shadow': '3px 3px 7px #444444',
    			'box-shadow': '3px 3px 7px #444444',
    			
    			'background-color': '#337755',
    			'color': '#FFFFFF',
    			'text-shadow': '1px 1px 1px #660033',
    			//'border': '1px solid #337755'
    			'border': '1px solid #006600'
	    	});
	    },
	    function() {
	    	if ($(this).css('margin-top') != '22px') {
	    		$(this).css({
		    		'-moz-box-shadow': '3px 3px 5px #CCAA77',
	    			'-webkit-box-shadow': '3px 3px 5px #CCAA77',
	    			'box-shadow': '3px 3px 5px #CCAA77',
	    			
	    			'background-color': '#F4EFD9',
	    			'color': '#336600',
	    			'text-shadow': '0px 0px 0px #660033',
	    			'border': '1px solid #DDCCAA'
		    	});
	    	}
	    	else {
	    		$(this).css({
		    		'-moz-box-shadow': '1px 1px 3px #444444',
	    			'-webkit-box-shadow': '1px 1px 3px #444444',
	    			'box-shadow': '1px 1px 3px #444444',
	    			
	    			'background-color': '#337755',
	    			'color': '#FFFFFF',
	    			'text-shadow': '1px 1px 1px #660033',
	    			//'border': '1px solid #337755'
	    			'border': '1px solid #006600'
		    	});
	    	}
	    });
	    
	    $('#collectionCarousel').jcarousel({
	    	scroll:1
	    });
	    
	    $('#collectionCarousel').jcarousel('size', 1);
	    $('#collectionCarousel').jcarousel('add', 1, '<li><div class="collectionCarouselNoItem">No collections found.</div></li>');
    }
    function showInstitutionInformation(institutioncode, idinstitutioncode) {

        //Empty the information table
        $('#instName').empty();
        $('#collCount').empty();
        $('#specimenCount').empty();
        $('#interactionCount').empty();
        $('#specimenPlotted').empty();
		
		$('#instName').append("<b>Institution Code:</b> "+institutioncode);
        $('#collCount').append("<b>Number of Collections:</b> ");
        $('#specimenCount').append("<b>Number of Specimens:</b> ");
        $('#specimenPlotted').append("<b>Number of Specimens Plotted:</b> ");
        $('#interactionCount').append("<b>Number of Interactions:</b> ");

        //Get the data
        printCollectionCodes(idinstitutioncode);
    }
    *//*
    function printCollectionCodes(idinstitutioncode) {
        $.ajax({ type:'POST',
            url:'index.php?r=userpanel/getCollectionCodes',
            data: {'idinstitutioncode':idinstitutioncode},
            dataType: "json",
            success:function(json) {
                var rs = json.result;

                $('#collCount').html("<b>Number of Collections:</b> " + parseInt(json.count));
                
                $('#collectionCarousel').jcarousel('size', 0);
                $('#collectionCarousel').jcarousel('reset');

                if (parseInt(json.count) == 0) {
                	$('#collectionCarousel').jcarousel('size', 1);
                	$('#collectionCarousel').jcarousel('add', 1, '<li><div class="collectionCarouselNoItem">No collections found.</div></li>');
                }
                else {
                	$('#collectionCarousel').jcarousel('size', parseInt(json.count));
	                for (var i in rs) {
	                    	$('#collectionCarousel').jcarousel('add', parseInt(i, 10) + 1, '<li><div class="collectionCarouselItem" onclick="javascript:getSpecimenInfo('+idinstitutioncode+','+rs[i]['idcollectioncode']+');">'+rs[i]['collectioncode']+'</div></li>');
	                }
	
	                //Set them as buttons
	                $("div.collCodeBtn").button();
	                
	                $('.collectionCarouselItem').click(function() {
				    	$('.collectionCarouselItem').css({
				    		'margin-top': '20px',
				    		
				    		'-moz-box-shadow': '3px 3px 5px #CCAA77',
			    			'-webkit-box-shadow': '3px 3px 5px #CCAA77',
			    			'box-shadow': '3px 3px 5px #CCAA77',
			    			
			    			'background-color': '#F4EFD9',
			    			'color': '#336600',
			    			'text-shadow': '0px 0px 0px #660033',
			    			'border': '1px solid #DDCCAA'
				    	});
				    	$(this).css({
				    		'margin-top': '22px',
				    		
							'-moz-box-shadow': '1px 1px 3px #444444',
			    			'-webkit-box-shadow': '1px 1px 3px #444444',
			    			'box-shadow': '1px 1px 3px #444444',
			    			
			    			'background-color': '#337755',
			    			'color': '#FFFFFF',
			    			'text-shadow': '1px 1px 1px #660033',
			    			//'border': '1px solid #337755'
							'border': '1px solid #006600'
				    	});
				    });
				    
				    $('.collectionCarouselItem').hover(function() {
				    	$(this).css({
							'-moz-box-shadow': '3px 3px 7px #444444',
			    			'-webkit-box-shadow': '3px 3px 7px #444444',
			    			'box-shadow': '3px 3px 7px #444444',
			    			
			    			'background-color': '#337755',
			    			'color': '#FFFFFF',
			    			'text-shadow': '1px 1px 1px #660033',
			    			//'border': '1px solid #337755'
			    			'border': '1px solid #006600'
				    	});
				    },
				    function() {
				    	if ($(this).css('margin-top') != '22px') {
				    		$(this).css({
					    		'-moz-box-shadow': '3px 3px 5px #CCAA77',
				    			'-webkit-box-shadow': '3px 3px 5px #CCAA77',
				    			'box-shadow': '3px 3px 5px #CCAA77',
				    			
				    			'background-color': '#F4EFD9',
				    			'color': '#336600',
				    			'text-shadow': '0px 0px 0px #660033',
				    			'border': '1px solid #DDCCAA'
					    	});
				    	}
				    	else {
				    		$(this).css({
					    		'-moz-box-shadow': '1px 1px 3px #444444',
				    			'-webkit-box-shadow': '1px 1px 3px #444444',
				    			'box-shadow': '1px 1px 3px #444444',
				    			
				    			'background-color': '#337755',
				    			'color': '#FFFFFF',
				    			'text-shadow': '1px 1px 1px #660033',
				    			//'border': '1px solid #337755'
				    			'border': '1px solid #006600'
					    	});
				    	}
				    });
                }
            }
        });
        
    }
*//*
    function getSpecimenInfo(idinstitutioncode, idcollectioncode) {

        //Loading message
        $('#specimenCount').empty();
        $('#specimenCount').append("<b>Loading Specimens...</b>");

        $.ajax({ type:'POST',
            url:'index.php?r=userpanel/getSpecimenInfo',
            data: {'idinstitutioncode':idinstitutioncode, 'idcollectioncode':idcollectioncode},
            dataType: "json",
            success:function(json) {
                var rs = json.result;

                $('#specimenCount').empty();
                $('#specimenCount').append("<b>Number of Specimens:</b> "+parseInt(json.count, 10));

                $('#specimenPlotted').empty();
                $('#specimenPlotted').append('<b>Number of Specimens Plotted:</b> 0');

                //Counter for plotted specimens
                var count = 0;

                //Clear placemarks on Google Earth
                //var features = ge.getFeatures();
                //while (features.getFirstChild()) {
                //    features.removeChild(features.getFirstChild());
                //}

                for (var i in rs)
                    {
                        if (rs[i]['latitude'] != null && rs[i]['longitude'] != null)
                            {
                                count += 1;
                                
                                var info = 'Scientific name: '+rs[i]['scientificname'];
                                var desc = '<div><b>'+'Scientific name: '+rs[i]['scientificname']+'<br />Basis of record: '+rs[i]['basisofrecord']+'<br />Institution code: '+rs[i]['institutioncode']+'<br />Collection code: '+rs[i]['collectioncode'];
                                
                                var loc = (rs[i]['municipality']==null?'':', '+rs[i]['municipality'])+(rs[i]['stateprovince']==null?'':', '+rs[i]['stateprovince'])+(rs[i]['country']==null?'':', '+rs[i]['country']);
                                loc = loc.slice(2);
                                
                                loc = loc==''?'':'<br />Location: '+loc;
                                
                                desc += loc+'<br />Latitude: '+rs[i]['latitude']+'<br />Longitude: '+rs[i]['longitude']+'</b></div>';
                                
                                drawMarker(parseFloat(rs[i]['latitude']), parseFloat(rs[i]['longitude']), info, desc);
                                
                                $('#specimenPlotted').empty();
                                $('#specimenPlotted').append('<b>Number of Specimens Plotted:</b> '+count);
*/
                                //Info to appear on the placemark as text
                                //var info = 'Institution: '+rs[i]['institutioncode']+'<br />Collection: '+rs[i]['collectioncode']+'<br />Scientific Name: '+rs[i]['scientificname'];
                               	// colocar location (Pais, estado, cidade) + coordenadas geograficas + scientificname (Destacado) + basisofrecord 
                                /*var info = 'Scientific name: '+rs[i]['scientificname'];
                                var desc = '<div><b>'+'Basis of record: '+rs[i]['basisofrecord']+'<br />Institution code: '+rs[i]['institutioncode']+'<br />Collection code: '+rs[i]['collectioncode'];
                                
                                var loc = (rs[i]['municipality']==null?'':', '+rs[i]['municipality'])+(rs[i]['stateprovince']==null?'':', '+rs[i]['stateprovince'])+(rs[i]['country']==null?'':', '+rs[i]['country']);
                                loc = loc.slice(2);
                                
                                loc = loc==''?'':'<br />Location: '+loc;
                                
                                desc += loc+'<br />Latitude: '+rs[i]['latitude']+'<br />Longitude: '+rs[i]['longitude']+'</b></div>';
                                
                                $('#latlon').append(rs[i]['latitude']+','+rs[i]['longitude']+'<br />');
                                plotSpecimen(info, desc, parseFloat(rs[i]['latitude']), parseFloat(rs[i]['longitude']));

                                $('#specimenPlotted').empty();
                                $('#specimenPlotted').append('<b>Number of Specimens Plotted:</b> '+count);*/
                            }/*
                    }
            }
        });

    }

    function getInteractionInfo(idinstitutioncode) {
        $.ajax({ type:'POST',
            url:'index.php?r=userpanel/getInteractionInfo',
            data: {'idinstitutioncode':idinstitutioncode},
            dataType: "json",
            success:function(json) {
                $('#interactionCount').empty();
                $('#interactionCount').append("<b>Number of Interactions:</b> "+parseInt(json.count));
            }
        });

    }

    /*function plotSpecimen(info, desc, latitude, longitude) {

        var placemark = ge.createPlacemark('');
        placemark.setName(info);
        placemark.setDescription(desc);
        ge.getFeatures().appendChild(placemark);

        // Create style map for placemark
        var icon = ge.createIcon('');
        icon.setHref('http://maps.google.com/mapfiles/kml/paddle/red-circle.png');
        var style = ge.createStyle('');
        style.getIconStyle().setIcon(icon);
        placemark.setStyleSelector(style);

        // Create point
        var point = ge.createPoint('');
        point.setLatitude(latitude);
        point.setLongitude(longitude);
        placemark.setGeometry(point);
    }

    function init() {
        google.earth.createInstance('map3d', initCB, failureCB);
    }

    function initCB(instance) {
        ge = instance;
        ge.getWindow().setVisibility(true);
    }

    function failureCB(errorCode) {
    }
    
    	$(function() {
		//scrollpane parts
		var scrollPane = $( ".scroll-pane" ),
			scrollContent = $( ".scroll-content" );

		//build slider
		var scrollbar = $( ".scroll-bar" ).slider({
			slide: function( event, ui ) {
				if ( scrollContent.width() > scrollPane.width() ) {
					scrollContent.css( "margin-left", Math.round(
						ui.value / 100 * ( scrollPane.width() - scrollContent.width() )
					) + "px" );
				} else {
					scrollContent.css( "margin-left", 0 );
				}
			}
		});

		//append icon to handle
		var handleHelper = scrollbar.find( ".ui-slider-handle" )
		.mousedown(function() {
			scrollbar.width( handleHelper.width() );
		})
		.mouseup(function() {
			scrollbar.width( "100%" );
		})
		.append( "<span class='ui-icon ui-icon-grip-dotted-vertical'></span>" )
		.wrap( "<div class='ui-handle-helper-parent'></div>" ).parent();

		//change overflow to hidden now that slider handles the scrolling
		scrollPane.css( "overflow", "hidden" );

		//size scrollbar and handle proportionally to scroll distance
		function sizeScrollbar() {
			var remainder = scrollContent.width() - scrollPane.width();
			var proportion = remainder / scrollContent.width();
			var handleSize = scrollPane.width() - ( proportion * scrollPane.width() );
			scrollbar.find( ".ui-slider-handle" ).css({
				width: handleSize,
				"margin-left": -handleSize / 2
			});
			handleHelper.width( "" ).width( scrollbar.width() - handleSize );
		}

		//reset slider value based on scroll content position
		function resetValue() {
			var remainder = scrollPane.width() - scrollContent.width();
			var leftVal = scrollContent.css( "margin-left" ) === "auto" ? 0 :
				parseInt( scrollContent.css( "margin-left" ) );
			var percentage = Math.round( leftVal / remainder * 100 );
			scrollbar.slider( "value", percentage );
		}

		//if the slider is 100% and window gets larger, reveal content
		function reflowContent() {
				var showing = scrollContent.width() + parseInt( scrollContent.css( "margin-left" ), 10 );
				var gap = scrollPane.width() - showing;
				if ( gap > 0 ) {
					scrollContent.css( "margin-left", parseInt( scrollContent.css( "margin-left" ), 10 ) + gap );
				}
		}

		//change handle position on window resize
		$( window ).resize(function() {
			resetValue();
			sizeScrollbar();
			reflowContent();
		});
		//init scrollbar size
		setTimeout( sizeScrollbar, 10 );//safari wants a timeout
	});*/
</script>

<div class="userPanelContainer">
	<div id="map"></div>
	<div id="table"></div>
	<!--<div id="map" class="userPanelMap"></div>
	<div style="float:right">
	<div class="title">Select one Institution Code</div>
	<div class="text"></div>
	<ul id="institutionCarousel" class="jcarousel-skin-tango">
	</ul>
	<div class="title">Select one Collection Code</div>
	<div class="text"></div>
	<ul id="collectionCarousel" class="jcarousel-skin-tango">
	</ul>
	<div class="title">Map Information</div>
	<div class="text">Specimen ocurrences belonging to selected institution and collection will be plotted on the map if their latitude and longitude fields were filled on specimen ocurrence Create or Update tools (available in Tools menu). Additional information will be provided if a map marker is clicked.</div>
	<div id="icInfo">
		<div id="instName"><b>Institution Name:</b> </div>
	    <div id="collCount"><b>Number of Collections:</b> </div>
	    <div id="specimenCount"><b>Number of Specimens:</b> </div>
	    <div id="specimenPlotted"><b>Number of Specimens Plotted:</b> </div>
	</div>
	</div>-->
</div>



