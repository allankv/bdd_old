<?php
include_once("protected/extensions/config.php");
$key = getGoogleAPIKey('bddapi@gmail.com', 'datadigitizer');
echo '<script src="http://www.google.com/jsapi?sensor=false&key='.$key.'" type="text/javascript"></script>';
?>

<script type="text/javascript" src="js/jcarousel/lib/jquery.jcarousel.min.js"></script>
<link rel="stylesheet" type="text/css" href="js/jcarousel/skins/tango/skin.css"/>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

<script>
	var loading = '<div id="loading"><img style="margin-top:80px; margin-left: 250px;" src="images/main/ajax-loader4.gif"></img><div style="padding-left:12px; font-weight:bold; color:#BB7700; padding-top:10px; text-shadow:1px 1px 3px #777; margin-left: 245px;">Loading...</div></div>';
	var jFilterList;
	
	google.load('visualization', '1', {packages:['corechart', 'geomap', 'table', 'orgchart', 'motionchart']});
	
    $(document).ready(bootUserPanel);
    
    function bootUserPanel() {
    	<?php if (count($icCodes) > 0): foreach($icCodes as $n => $ic): ?>
            $('#institutionCarousel').append('<li><div class="institutionCarouselItem" onclick="javascript:showInstitutionInformation(<?php echo $ic['idinstitutioncode']; ?>, \'<?php echo $ic['institutioncode']; ?>\');"><?php echo $ic['institutioncode']; ?></div></li>');
        <?php endforeach; else:?>
        	$('#institutionCarousel').append('<li><div class="institutionCarouselNoItem">No institutions found.</div></li>');
        <?php endif;?>
        
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
				'-moz-box-shadow': '3px 3px 5px #444444',
    			'-webkit-box-shadow': '3px 3px 5px #444444',
    			'box-shadow': '3px 3px 5px #444444',
    			
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
	    $('#collectionCarousel').jcarousel('add', 1, '<li><div class="collectionCarouselNoItem">Select an Institution.</div></li>');
       
    	drawCountry();
    }
    
    function showInstitutionInformation(idinstitutioncode, institutioncode) {
        $('#instName').empty();
        $('#collCount').empty();
        $('#specimenCount').empty();
        
		$('#instName').append("<b>Institution selected:</b> "+institutioncode);
        $('#collCount').append("<b>Collections found:</b> ");
        //$('#specimenCount').append("<b>Number of Specimens:</b> ");

        printCollectionCodes(idinstitutioncode, institutioncode);
    }
    
    function printCollectionCodes(idinstitutioncode, institutioncode) {
        $.ajax({ type:'POST',
            url:'index.php?r=userpanel/getCollectionCodes',
            data: {'idinstitutioncode':idinstitutioncode},
            dataType: "json",
            success:function(json) {
                var rs = json.result;

                $('#collCount').html("<b>Collections found:</b> " + parseInt(json.count));
                
                $('#collectionCarousel').jcarousel('size', 0);
                $('#collectionCarousel').jcarousel('reset');

                if (parseInt(json.count) == 0) {
                	$('#collectionCarousel').jcarousel('size', 1);
                	$('#collectionCarousel').jcarousel('add', 1, '<li><div class="collectionCarouselNoItem">No collections found.</div></li>');
                }
                else {
                	$('#collectionCarousel').jcarousel('size', parseInt(json.count));
	                for (var i in rs) {
	                    	$('#collectionCarousel').jcarousel('add', parseInt(i, 10) + 1, '<li><div class="collectionCarouselItem" onclick="javascript:getSpecimenInfo('+idinstitutioncode+',\''+institutioncode+'\','+rs[i]['idcollectioncode']+',\''+rs[i]['collectioncode']+'\');">'+rs[i]['collectioncode']+'</div></li>');
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
							'-moz-box-shadow': '3px 3px 5px #444444',
			    			'-webkit-box-shadow': '3px 3px 5px #444444',
			    			'box-shadow': '3px 3px 5px #444444',
			    			
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
    
    function getSpecimenInfo(idinstitutioncode, institutioncode, idcollectioncode, collectioncode) {
    	jFilterList = [
	    	{
	    		category: "Institution selected",
	    		controller: "institutioncode",
	    		id: idinstitutioncode,
	    		name: institutioncode
	    	},
	    	{
	    		category: "Collection selected",
	    		controller: "collectioncode",
	    		id: idcollectioncode,
	    		name: collectioncode
    		}
    	];
    	
    	drawCountry();
    
        $('#specimenCount').empty();
        $('#specimenCount').append("<b>Loading Specimens...</b>");

        $.ajax({ type:'POST',
            url:'index.php?r=userpanel/getSpecimenInfo',
            data: {'idinstitutioncode':idinstitutioncode, 'idcollectioncode':idcollectioncode},
            dataType: "json",
            success:function(json) {
                var rs = json.result;

                $('#specimenCount').empty();
                $('#specimenCount').append("<b>Species-occurrences found:</b> "+parseInt(json.count, 10));
            }
        });

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
            	if (json.result.length > 0) {
            		drawGeoMap(json, 'map');                      
                	drawTable(json, 'table', 'country', 'Country');
            	}
            	else {
            		json = {"result":[{"country":"","count":"","perc":""}]}
            		drawGeoMap(json, 'map');
            	}               
            }
	    });
	}
</script>
<div class="introPanel"><b>Welcome to BDD, <?= Yii::app()->user->name ?></b><br/><br />The Biodiversity Data Digitizer (BDD) is a tool designed for easy digitization, manipulation, and publication of biodiversity data. <br/>It stands out by allowing the user to manipulate its data simply and objectively, especially the data from field observations and <br/>small collections, which do not justify or demand the use of collection management software.
						<br/><br/>Select an Institution and then a Collection to see the statistic distribution of species-ocurrences according to their country names. <!--belonging to selected institution and collection are plotted on the map according the country field filled on specimen ocurrence record.</div>-->
</div>
<div class="userPanelContainer">
	<div style="float:left; width: 556px; margin: 15px auto 0 30px;">
	<div id="map"></div>
	<div id="table"></div>
	</div>
	<div style="float:right">
	<div class="title">Available Institutions</div>
	<div class="text"></div>
	<ul id="institutionCarousel" class="jcarousel-skin-tango">
	</ul>
	<div class="title">Available Collections</div>
	<div class="text"></div>
	<ul id="collectionCarousel" class="jcarousel-skin-tango">
	</ul>
	<div class="title">Map Information</div>
	<div class="text"></div>
	<div id="icInfo">
		<div id="instName"><b>Institution selected:</b> </div>
	    <div id="collCount"><b>Collections found:</b> </div>
	    <div id="specimenCount"><b>Species-Occurrences found:</b> </div>
	</div>
	</div>
</div>



