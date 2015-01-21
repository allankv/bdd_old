
<?php include_once("protected/extensions/config.php"); ?>
<script type="text/javascript" src="js/Maintain.js"></script>
<script type="text/javascript" src="js/List.js"></script>

<link rel="stylesheet" type="text/css" href="css/jquery.countdown.css" />
<script type="text/javascript" src="js/jquery.countdown.min.js"></script>

<style>
    .ui-autocomplete-category {
        color: orange;
        font-weight: bold;
        padding: .2em .4em;
        margin: .8em 0 .2em;
        line-height: 1.5;
    }
    .ui-autocomplete {
        max-height: 300px;
        overflow-y: auto;
    }
    .ui-button-text {
        font-size: 12px;
        padding: 5px 26px 5px 5px;
    }
    div.hasCountdown {
        width:550px;
        margin-left:149px;
        background-color:#F9F9F9;
        border:0px solid #F6A828;
    }
    .countdown_show3 .countdown_section {
        width: 160px;
        margin-right:5px;
        background-color:#F8F7F4;
        color:#885522;
        border-radius: 0.4em 0.4em 0.4em 0.4em;
        -moz-border-radius-topleft: 0.4em;
        -moz-border-radius-topright: 0.4em;
        -moz-border-radius-bottomleft: 0.4em;
        -moz-border-radius-bottomright: 0.4em;
        border:1px solid #DDCCAA;
        -moz-box-shadow: 3px 3px 5px #CCAA77;
        -webkit-box-shadow: 3px 3px 5px #CCAA77;
        box-shadow: 3px 3px 5px #CCAA77;
    }
    .countdown_holding .countdown_section {
        background-color: #F4EFD9;
    }
    .countdown_holding span {
        background-color: #F4EFD9;
    }
    .countdown_descr {
        font-weight: bold;
        padding-top:10px;
        padding-bottom:10px;
        width:100px;
        margin-left:197px;
    }
</style>
<script>
	var hidden = {"hidden" : {
             "type"  : 1,
             "ownerinstitution" : 1,
             "dataset" : 1,
             "rights" : 1,
             "rightsholder" : 1,
             "accessrights" : 1,
             "informationwithheld" : 1,
             "datageneralization" : 1,
             "dynamicproperties" : 1,
             "kingdom" : 1,
             "phylum" : 1,
             "classe" : 1,
             "order" : 1,
             "family" : 1,
             "genus" : 1,
             "subgenus" : 1,
             "specificepithet" : 1,
             "infraspecificepithet" : 1,
             "taxonrank" : 1,
             "scientificnameauthor" : 1,
             "nomenclaturalcode" : 1,
             "taxonconcept" : 1,
             "nomenclaturalstatus" : 1,
             "acceptednameusage" : 1,
             "parentnameusage" : 1,
             "originalnameusage" : 1,
             "nameaccordingto" : 1,
             "namepublishedin" : 1,
             "vernacularname" : 1,
             "taxonomicstatus" : 1,
             "verbatimtaxonrank" : 1,
             "taxonremarks" : 1,
             "individual" : 1,
             "individualcount" : 1,
             "sex" : 1,
             "behavior" : 1,
             "lifestage" : 1,
             "disposition" : 1,
             "reproductivecondition" : 1,
             "estabilishmentmean" : 1,
             "recordedby" : 1,
             "recordnumber" : 1,
             "othercatalognumbers" : 1,
             "preparations" : 1,
             "associatedsequences" : 1,
             "occurrencedetails" : 1,
             "occurrenceremarks" : 1,
             "occurrencestatus" : 1,
             "dateidentified" : 1,
             "identificationqualifier" : 1,
             "identifiedby" : 1,
             "typestatus" : 1,
             "identificationremarks" : 1,
             "samplingprotocol" : 1,
             "samplingeffort" : 1,
             "habitat" : 1,
             "verbatimeventdate" : 1,
             "eventtime" : 1,
             "eventdate" : 1,
             "fieldnumber" : 1,
             "fieldnotes" : 1,
             "eventremarks" : 1,
             "decimalaltitude" : 1,
             "decimallongitude" : 1,
             "continent" : 1,
             "country" : 1,
             "stateorprovince" : 1,
             "county" : 1,
             "municipality" : 1,
             "locality" : 1,
             "waterbody" : 1,
             "islandgroup" : 1,
             "island" : 1,
             "locationaccordingto" : 1,
             "coordinateprecision" : 1,
             "locationremarks" : 1,
             "minimunelevation" : 1,
             "maximumelevation" : 1,
             "minimumdepth" : 1,
             "maximumdepth" : 1,
             "minimumdistance" : 1,
             "maximumdistance" : 1,
             "verbatimdepth" : 1,
             "verbatimelevation" : 1,
             "verbatimlocality" : 1,
             "verbatimsrs" : 1,
             "georeferencedby" : 1,
             "georeferencesources" : 1,
             "footprintsrs" : 1,
             "coordinateuncertainty" : 1,
             "geodeticdatum" : 1,
             "pointradiusspatialfit" : 1,
             "verbatimcoordinates" : 1,
             "verbatimlatitude" : 1,
             "verbatimlongitude" : 1,
             "verbatimcoordinatesystem" : 1,
             "georeferenceprotocol" : 1,
             "verificationstatus" : 1,
             "georeferenceremarks" : 1,
             "footprintwkt" : 1,
             "footprintspatialfit" : 1}
    };

    var start = 0;
    var end = 10;
    var max = 10;
    var interval = 10;
    var handleSize = 20;
    var maxrecordsperfile = 3000;

    $(document).ready(bootExport);
    function bootExport(){
        configNotify();
        configIcons();
        $('#log').hide();
        $('#divlink').hide();
        $('#result').hide();
        configCatComplete('#id','#searchField', 'specimen','#filterList');
        filter();
        slider();

        //Help message for the filter textbox help tooltip
        var helpTip = '<div style="font-weight:normal;">Use this box to filter the results below. Different terms for different categories (e.g.: Institution Code and Collection Code) will result in an AND search. Different terms for the same category, however, will result in an OR search.</div>';

        //Set the help tooltip for the Filter textbox
        $('#searchField').poshytip({
            className: 'tip-twitter',
            content: helpTip,
            showOn: 'focus',
            alignTo: 'target',
            alignX: 'right',
            alignY: 'center',
            offsetX: 15
        });

        $("#startExportButton").button();
        $('#exportMiddle').css("opacity", "0.5");
        $('#exportRight').css("opacity", "0.5");
        $('#exportColumns').hide('slide');
        $('#exportEnd').hide('slide');

        $("#checkedColumns").html(109);
        $("#checkAll").button();
        $("#checkAll").click(function() {
            $(".check").attr('checked', true);
            for (var i = 0; i <= 109; i++) {
                $("#checkbox" + i).button("refresh");
                $("#checkbox" + i).button("option", "icons", {secondary:"ui-icon-check"});
            }
            $("#checkedColumns").html(109);
        });
        $("#uncheckAll").button();
        $("#uncheckAll").click(function() {
            $(".check").attr('checked', false);
            $(".required").attr('checked', true);
            for (var i = 0; i <= 109; i++) {
                $("#checkbox" + i).button("refresh");
                if ($("#checkbox" + i).attr('checked') == false) {
                    $("#checkbox" + i).button("option", "icons", {secondary:null});
                }
            }
            $("#checkedColumns").html(9);
        });

        for (var i = 0; i <= 109; i++) {
            $("#checkbox" + i).button({
                icons:{secondary:"ui-icon-check"}
            });
            $("#checkbox" + i).click(function() {
                $(this).button("refresh");
                if ($(this).attr('checked') == false) {
                    $(this).button("option", "icons", {secondary:null});
                    $("#checkedColumns").html(parseInt($("#checkedColumns").html(), 10) - 1);
                }
                else {
                    $(this).button("option", "icons", {secondary:"ui-icon-check"});
                    $("#checkedColumns").html(parseInt($("#checkedColumns").html(), 10) + 1);
                }
            });
        }        
    }
    function clearDiv() {
        $('#divlink').html('<div class="linkEnd" style="clear:both;"></div>');
    }
    function startExport(){
        $('#loading').show(3500);
    	var h = $("#form").serialize();
    	h1 = h.replace(/Col=/g,"");
    	n1 = h1.split("&");    	
    	for (var i =0; i< n1.length;i++){   
    		if(n1[i]=='ownerinstitution')
	    		hidden.ownerinstitution = 0;  
	    	if(n1[i]=='type')  		
    			hidden.type = 0;
		if(n1[i]=='dataset')
                		hidden.hidden.dataset = 0;
		if(n1[i]=='rights')
                		hidden.hidden.rights = 0;
		if(n1[i]=='rightsholder')
                		hidden.hidden.rightsholder = 0;
		if(n1[i]=='accessrights')
                		hidden.hidden.accessrights = 0;
		if(n1[i]=='informationwithheld')
                		hidden.hidden.informationwithheld = 0;
		if(n1[i]=='datageneralization')
                		hidden.hidden.datageneralization = 0;
		if(n1[i]=='dynamicproperties')
                		hidden.hidden.dynamicproperties = 0;
		if(n1[i]=='kingdom')
    			hidden.hidden.kingdom = 0;
		if(n1[i]=='phylum')
                		hidden.hidden.phylum = 0;
		if(n1[i]=='class_')
                		hidden.hidden.classe = 0;
		if(n1[i]=='order')
                		hidden.hidden.order = 0;
		if(n1[i]=='family')
                		hidden.hidden.family = 0;
		if(n1[i]=='genus')
                		hidden.hidden.genus = 0;
		if(n1[i]=='subgenus')
                		hidden.hidden.subgenus = 0;
		if(n1[i]=='specificepithet')
    			hidden.hidden.specificepithet = 0;
		if(n1[i]=='infraspecificepithet')
                		hidden.hidden.infraspecificepithet = 0;
		if(n1[i]=='taxonrank')
                		hidden.hidden.taxonrank = 0;
		if(n1[i]=='scientificnameauthor')
                		hidden.hidden.scientificnameauthor = 0;
		if(n1[i]=='nomenclaturalcode')
                		hidden.hidden.nomenclaturalcode = 0;
		if(n1[i]=='taxonconcept')
                		hidden.hidden.taxonconcept = 0;
		if(n1[i]=='nomenclaturalstatus')
                		hidden.hidden.nomenclaturalstatus = 0;
		if(n1[i]=='acceptednameusage')
			hidden.hidden.acceptednameusage = 0;
		if(n1[i]=='parentnameusage')
                		hidden.hidden.parentnameusage = 0;
		if(n1[i]=='originalnameusage')
                		hidden.hidden.originalnameusage = 0;
		if(n1[i]=='nameaccordingto')
                		hidden.hidden.nameaccordingto = 0;
		if(n1[i]=='namepublishedin')
                		hidden.hidden.namepublishedin = 0;
		if(n1[i]=='vernacularname')
                		hidden.hidden.vernacularname = 0;
		if(n1[i]=='taxonomicstatus')
                		hidden.hidden.taxonomicstatus = 0;
		if(n1[i]=='verbatimtaxonrank')
    			hidden.hidden.verbatimtaxonrank = 0;
		if(n1[i]=='taxonremarks')
                		hidden.hidden.taxonremarks = 0;
		if(n1[i]=='individual')
                		hidden.hidden.individual = 0;
		if(n1[i]=='individualcount')
                		hidden.hidden.individualcount = 0;
		if(n1[i]=='sex')
                		hidden.hidden.sex = 0;
		if(n1[i]=='behavior')
                		hidden.hidden.behavior = 0;
		if(n1[i]=='lifestage')
                		hidden.hidden.lifestage = 0;
		if(n1[i]=='disposition')
    			hidden.hidden.disposition = 0;
		if(n1[i]=='reproductivecondition')                
			hidden.hidden.reproductivecondition = 0;
		if(n1[i]=='estabilishmentmean')
                		hidden.hidden.estabilishmentmean = 0;
		if(n1[i]=='recordedby')
                		hidden.hidden.recordedby = 0;
		if(n1[i]=='recordnumber')
                		hidden.hidden.recordnumber = 0;
		if(n1[i]=='othercatalognumbers')
                		hidden.hidden.othercatalognumbers = 0;
		if(n1[i]=='preparations')
               		hidden.hidden.preparations = 0;
		if(n1[i]=='associatedsequences')
    			hidden.hidden.associatedsequences = 0;
		if(n1[i]=='occurrencedetails')                
			hidden.hidden.occurrencedetails = 0;
		if(n1[i]=='occurrenceremarks')
                		hidden.hidden.occurrenceremarks = 0;
		if(n1[i]=='occurrencestatus')
                		hidden.hidden.occurrencestatus = 0;
		if(n1[i]=='dateidentified')
                		hidden.hidden.dateidentified = 0;
		if(n1[i]=='identificationqualifier')
                		hidden.hidden.identificationqualifier = 0;
		if(n1[i]=='identifiedby')
                		hidden.hidden.identifiedby = 0;
		if(n1[i]=='typestatus')    		
			hidden.hidden.typestatus = 0;
		if(n1[i]=='identificationremarks')
                		hidden.hidden.identificationremarks = 0;
		if(n1[i]=='samplingprotocol')
                		hidden.hidden.samplingprotocol = 0;
		if(n1[i]=='samplingeffort')
                		hidden.hidden.samplingeffort = 0;
		if(n1[i]=='habitat')
                		hidden.hidden.habitat = 0;
		if(n1[i]=='verbatimeventdate')
                		hidden.hidden.verbatimeventdate = 0;
		if(n1[i]=='eventtime')
                		hidden.hidden.eventtime = 0;
		if(n1[i]=='eventdate')
                		hidden.hidden.eventdate = 0;
		if(n1[i]=='fieldnumber')
                		hidden.hidden.fieldnumber = 0;
		if(n1[i]=='fieldnotes')
    			hidden.hidden.fieldnotes = 0;
		if(n1[i]=='eventremarks')
                		hidden.hidden.eventremarks = 0
		if(n1[i]=='decimalaltitude');
                		hidden.hidden.decimalaltitude = 0;
		if(n1[i]=='decimallongitude')
                		hidden.hidden.decimallongitude = 0;
		if(n1[i]=='continent')
                		hidden.hidden.continent = 0;
		if(n1[i]=='country')
                		hidden.hidden.country = 0;
		if(n1[i]=='stateorprovince')
                		hidden.hidden.stateorprovince = 0;
		if(n1[i]=='county')
    			hidden.hidden.county = 0;
		if(n1[i]=='municipality')
                		hidden.hidden.municipality = 0;
		if(n1[i]=='locality')
                		hidden.hidden.locality = 0;
		if(n1[i]=='waterbody')                
			hidden.hidden.waterbody = 0;
		if(n1[i]=='islandgroup')
                		hidden.hidden.islandgroup = 0;
		if(n1[i]=='island')
                		hidden.hidden.island = 0;
		if(n1[i]=='locationaccordingto')                
			hidden.hidden.locationaccordingto = 0;
		if(n1[i]=='coordinateprecision')
    			hidden.hidden.coordinateprecision = 0;
		if(n1[i]=='locationremarks')
                		hidden.hidden.locationremarks = 0;
		if(n1[i]=='minimunelevation')
                		hidden.hidden.minimunelevation = 0;
		if(n1[i]=='maximumelevation')
                		hidden.hidden.maximumelevation = 0;
		if(n1[i]=='minimumdepth')
                		hidden.hidden.minimumdepth = 0;
		if(n1[i]=='maximumdepth')
                		hidden.hidden.maximumdepth = 0;
		if(n1[i]=='minimumdistance')
                		hidden.hidden.minimumdistance = 0;
		if(n1[i]=='maximumdistance')
                		hidden.hidden.maximumdistance = 0;
		if(n1[i]=='verbatimdepth')
    			hidden.hidden.verbatimdepth = 0;
		if(n1[i]=='verbatimelevation')
                		hidden.hidden.verbatimelevation = 0;
		if(n1[i]=='verbatimlocality')
                		hidden.hidden.verbatimlocality = 0;
		if(n1[i]=='verbatimsrs')
                		hidden.hidden.verbatimsrs = 0;
		if(n1[i]=='georeferencedby')
                		hidden.hidden.georeferencedby = 0;
		if(n1[i]=='georeferencesources')
                		hidden.hidden.georeferencesources = 0;
		if(n1[i]=='footprintsrs')
                		hidden.hidden.footprintsrs = 0;
		if(n1[i]=='coordinateuncertainty')
    			hidden.hidden.coordinateuncertainty = 0;
		if(n1[i]=='geodeticdatum')
                		hidden.hidden.geodeticdatum = 0;
		if(n1[i]=='pointradiusspatialfit')
                		hidden.hidden.pointradiusspatialfit = 0;
		if(n1[i]=='verbatimcoordinates')
                		hidden.hidden.verbatimcoordinates = 0;
		if(n1[i]=='verbatimlatitude')
                		hidden.hidden.verbatimlatitude = 0;
		if(n1[i]=='verbatimlongitude')
                		hidden.hidden.verbatimlongitude = 0;
		if(n1[i]=='verbatimcoordinatesystem')
			hidden.hidden.verbatimcoordinatesystem = 0;
		if(n1[i]=='georeferenceprotocol')    		
			hidden.hidden.georeferenceprotocol = 0;
		if(n1[i]=='verificationstatus')
                		hidden.hidden.verificationstatus = 0;
		if(n1[i]=='georeferenceremarks')
                		hidden.hidden.georeferenceremarks = 0;
		if(n1[i]=='footprintwkt')
                		hidden.hidden.footprintwkt = 0;
		if(n1[i]=='footprintspatialfit')
                		hidden.hidden.footprintspatialfit = 0;
		}       	
        $.ajax({url:'index.php?r=spreadsheetsync/startExport',
            type: 'POST',
            data: {'hidden':hidden, 'filter':jFilterList},
            dataType: "json",
            success: function(json){   
		    	var link = '<div style="float:left; position:relative; left:50%; margin-right:15px;"><a id="link" target="_blank" href="'+json.response.url+'"><img width="35px" src="images/main/excel.png"/><br>Download</a></div>';
				$('#divlink').show();
                $('#result').fadeIn(2000);
                $('#loading').hide();
                var log = [];
                log[1] = '<b># '+json.response.totalSpecimen+' Specimens records.</b>';
                log[2] = '<b># '+json.response.totalInteraction+' Interactions records.</b>';
				log[0] = '<b># '+json.response.totalLines+' Lines</b>';
                showMessage(log, true, true);
                $('#divlink').html(link);
			    $('#sinceCountdown').countdown('pause');			    		    	
            	//$('#sinceCountdown').countdown('destroy');              
            }
        });
        $('#sinceCountdown').countdown({since: new Date(), format: 'HMS', description: 'Time elapsed'});
    }
    function TIRAR_startExport(j){
        var numfile = Math.ceil(max/maxrecordsperfile);

        $.ajax({url:'index.php?r=spreadsheetsync/startExport',
            type: 'POST',
            data: {'hidden':hidden, 'filter':jFilterList},
            dataType: "json",
            success: function(json){
                $("#exportRight").html(json);
            }
        });
        var numfile = Math.ceil(max/maxrecordsperfile);
        $.ajax({url:'index.php?r=spreadsheetsync/startExport',
            type: 'POST',
            data: {'list':jFilterList, 'offset':j*maxrecordsperfile, 'max':(j+1)*maxrecordsperfile, 'collumn':$("#form").serialize()},
            dataType: "json",
            success: function(json){
                var link = '<div style="float:left; position:relative; left:50%; margin-right:15px;"><a id="link" target="_blank" href="'+json.link+'"><img width="35px" src="images/main/excel.png"/><br>Download<br>part '+(j+1)+' of '+numfile+'</a></div>';
                if (j == 0) {
                    $('#result').hide();
                    $('#divlink').show();
                    $('#result').fadeIn(2000);
                }
                if (j == numfile-1) {
                	$('#sinceCountdown').countdown('pause');
                }
                $('#divlink').show();
                $('#result').fadeIn(2000);
                json.log[0] = '<b> File '+(j+1)+' of '+numfile+'</b>';
                showMessage(json.log, true, true);
                $('.linkEnd').before(link);
                if (j < numfile-1) {
                	startExport(j+1);
                }
            }
        });
    }
    function selectFilters() {
        if ($('#exportColumns').css("display") == "none" && $('#exportEnd').css("display") == "none") {
            if ($('#exportColumns').css("display") == "none") {
                $('#exportColumns').show('slide');
            }
            if ($('#exportFilters').css("display") != "none") {
                $('#exportFilters').hide('slide');
            }
            $('#exportLeft').css("opacity", "0.5");
            $('#exportMiddle').css("opacity", "1");
            $('#exportRight').css("opacity", "0.5");
        }
    }

    function selectColumns() {
        if ($('#exportFilters').css("display") == "none" && $('#exportEnd').css("display") == "none") {
            if ($('#exportEnd').css("display") == "none") {
                $('#exportEnd').show('slide');
            }
            if ($('#exportColumns').css("display") != "none") {
                $('#exportColumns').hide('slide');
            }
            $('#exportLeft').css("opacity", "0.5");
            $('#exportMiddle').css("opacity", "0.5");
            $('#exportRight').css("opacity", "1");
        }
    }

    function unselectFilters() {
        if ($('#exportFilters').css("display") == "none") {
            $('#exportFilters').show('slide');
        }
        if ($('#exportEnd').css("display") != "none") {
            $('#exportEnd').hide('slide');
        }
        if ($('#exportColumns').css("display") != "none") {
            $('#exportColumns').hide('slide');
        }
        $('#exportLeft').css("opacity", "1");
        $('#exportMiddle').css("opacity", "0.5");
        $('#exportRight').css("opacity", "0.5");
    }

    function unselectColumns() {
        if ($('#exportFilters').css("display") != "none") {
            $('#exportFilters').hide('slide');
        }
        if ($('#exportEnd').css("display") != "none") {
            $('#exportEnd').hide('slide');
        }
        if ($('#exportColumns').css("display") == "none") {
            $('#exportColumns').show('slide');
        }
        $('#exportLeft').css("opacity", "0.5");
        $('#exportMiddle').css("opacity", "1");
        $('#exportRight').css("opacity", "0.5");
    }
	
    //baseado nos testes feitos, o polinômio de 3o grau que melhor aproxima o tempo de conclusao e' o seguinte
    //function estimatePolynomial(n) { return (0.029585 * n)-(1.3605*Math.pow(10,-5)*Math.pow(n,2))+(3.6018*Math.pow(10,-9)*Math.pow(n,3)); }

    function estimateTime(countdown) {
        var recordinfile = max;
        var file = 0;
        while (recordinfile > maxrecordsperfile) {
            recordinfile = recordinfile - maxrecordsperfile;
            file++;
        }
        console.log('recordinfile'+recordinfile);
        console.log('maxrecordsperfile'+maxrecordsperfile);
        console.log('max'+max);
        console.log('file'+file);
        console.log('estimatePolynomial(maxrecordsperfile)'+estimatePolynomial(maxrecordsperfile));
        console.log('estimatePolynomial(recordinfile)'+estimatePolynomial(recordinfile));
        var hour = Math.floor((estimatePolynomial(recordinfile)+file*estimatePolynomial(maxrecordsperfile))/60);
        var minutes = Math.ceil((estimatePolynomial(recordinfile)+file*estimatePolynomial(maxrecordsperfile))%60);
        if (countdown) {
            $('#sinceCountdown').countdown('destroy');
            $('#sinceCountdown').countdown({since: new Date(), format: 'HMS', description: 'Time elapsed'});
        }
        $( ".estimatedTime" ).html( "Estimated time: "+hour+'h '+minutes+'min');
    }
    function filter(senderValue){

        //If it's BOOT or a filter, reset the offset to 0. Otherwise, leave it as is.
        if (senderValue == null)
        {start = 0;}

        $.ajax({ type:'POST',
            url:'index.php?r=specimen/filter',
            data: {'limit':interval,'offset':start,'list':jFilterList},
            dataType: "json",
            success:function(json) {
                var rs = new Object();
                $("#lines").html('');
                max = parseInt(json.count);
                $('#start').html(start>max?0:start);
                $('#end').html(end>max?max:end);
                $('#max').html(max);
                //sliderRecordsPerFile();
                slider();
                //$( "#slider" ).slider({range: true,min: 0,max: max,values: [$('#start').html(), $('#end').html()]});
                rs = json.result;
                for(var i in rs){
                    insertLine(rs[i]);
                }
            }
        });
    }
    function insertLine(rs){
        var line ='<tr id="id__ID_" title="_TITLE_"><td style="width:20px;text-indent:0;">_ISPRIVATE_</td><td>_LASTTAXA_</td><td style="width:120px;text-align:center;">_CATALOGNUMBER_</td></tr>';
        var aux = line;

        var btnPrivate = "<div class='btnPrivate'><ul class='iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Private Specimen Record'><span class='ui-icon ui-icon-locked'></span></li></ul></div>";

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
        $('#id_'+rs.id).poshytip({
            className: 'tip-twitter',
            showTimeout: 500,
            alignTo: 'target',
            alignX: 'left',
            alignY: 'center',
            offsetX:10,
            content: function(updateCallback) {
                $.ajax({    type:'POST',
                    url:'index.php?r=specimen/getTip',
                    data: {'idspecimen':rs.id},
                    dataType: "json",
                    success:function(json) {

                        var specimen = json.sp[0];

                        var tip = '<div class="tipDiv"><div class="tipKey">Institution Code</div><div class="tipValue">'+specimen.institutioncode+'</div><div style="clear:both"></div><div class="tipKey">Collection Code</div><div class="tipValue">'+specimen.collectioncode+'</div><div style="clear:both"></div></div>';

                        updateCallback(tip);
                    }
                });
                return '<div class="tipDiv">Loading metadata...</div>';
            }
        });
    }
     
    function sliderRecordsPerFile(){
        $("#sliderRecordsPerFile").slider({
            value:3000,
            min: 50,
            max: max>5000 ? 5000 : max<50 ? 50 : max,
            step: 50,
            slide: function( event, ui ) {
                $( ".maxrecordsperfile" ).html( ui.value + ' records per file');
                maxrecordsperfile = ui.value;
                $(".numfile").html(Math.ceil(max/maxrecordsperfile) + ' total files');
                estimateTime(false);
            }
        });
        $( ".maxrecordsperfile" ).html( $( "#sliderRecordsPerFile" ).slider( "value" ) + ' records per file');
        $(".numfile").html(Math.ceil(max/maxrecordsperfile) + ' total files');
        estimateTime(false);
    }
    function slider(){
        $("#slider").slider({
            range: false,
            orientation:'vertical',
            max:0,
            min:interval - max,
            value:-start,
            stop: function(event, ui) {
                start = - ui.value;
                end = start + interval;
                filter('slider');
            },
            slide:function(event, ui) {
                //$('#start').html(ui.value);
                //$('#end').html((ui.value + interval));
                console.log(- ui.value);
                console.log(- ui.value + interval);
            }
        }).find( ".ui-slider-handle" ).css({
            height: handleSize
        });

    }
</script>

<div id="Notification"></div>

<div class="introText" style="width:93%;">
    <div style="float:left;"><?php echo CHtml::image("images/help/iconelist.png"); ?></div>
    <h1 style="padding-left:10px; float:left;"><?php echo Yii::t('yii', 'Export to spreadsheet'); ?></h1>
    <div style="clear:both;"></div>
    <p><?php echo Yii::t('yii', 'Use this to transcribe all of the Specimen and Interaction data present in the BDD into a spreadsheet file. Once the BDD has finished the transcription process, it will allow you to download the file.'); ?></p>
</div>

<div class="yiiForm" style="width:95%;">

    <?php echo CHtml::beginForm('','post',array ('id'=>'form')); ?>

    <!-- Filter Phase -->
    <div id="exportLeft" >
        <div class="title">Select records</div>
        <div class="icon1"><a href="javascript:unselectFilters();"><?php showIcon("Edit", "ui-icon-pencil", 1); ?></a></div>
        <div style="clear:both;"></div>
        <div class="records"><b><span id="max"></span></b> total records selected</div>
        <div class="icon2"><a href="javascript:selectFilters();"><?php showIcon("Next", "ui-icon-check", 1); ?></a></div>
    </div>

    <!-- Columns Phase -->
    <div id="exportMiddle" >
        <div class="title">Select columns</div>
        <div class="icon1"><a href="javascript:unselectColumns();"><?php showIcon("Edit", "ui-icon-pencil", 1); ?></a></div>
        <div style="clear:both;"></div>
        <div class="columns"><b><span id="checkedColumns"></span></b> total columns selected</div>
        <div class="icon2"><a href="javascript:selectColumns();"><?php showIcon("Next", "ui-icon-check", 1); ?></a></div>
    </div>

    <!-- End Phase -->
    <div id="exportRight" >
        <div class="title">Start exporting</div>
        <div style="clear:both;"></div>
        <div class="numfile"></div>
        <div class="maxrecordsperfile"></div>
        <div class="estimatedTime"></div>
        <div style="position:absolute; bottom:13px; right:15px;"><input type="button" id="startExportButton" value="Start Export" onclick="startExport(); clearDiv(); "/></div>
    </div>
    <div style="clear:both"></div>

    <!-- Filters -->
    <div id="exportFilters">
        <div class="filterLabel">Filter</div>
        <div class="filterMiddle"><a rel="lightbox" href="index.php?r=help&helpfield=filter"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
        <div style="clear:both"></div>
        <div class="filterField">
            <input type="text" id="searchField" style="border: 1px solid #DDDDDD;background: #FFFFFF;color: #013605;font-size: 1.3em; width:410px;" />
            <input type="hidden" id="id"/>
        </div>
        <div style="clear:both"></div>
        <div class="filterList" id="filterList"></div>

        <div class="newslider" id="slider"></div>
        <div id="rs" class="item">
            <table id="tablelist" class="list">
                <thead>
                    <tr>
                        <th></th>
                        <th>Taxonomic elements</th>
                        <th style="text-align:center;">Catalog number</th>
                    </tr>
                </thead>
                <tbody id="lines">
                <tbody>
            </table>
        </div>
        <div style="clear:both"></div>
    </div>

    <!-- Columns -->
    <div id="exportColumns">
        <div class="introText filterFloat" style="width:90%; margin: 5px auto 15px auto; padding: 5px 15px 5px 15px;">
            <p><?php echo Yii::t('yii', 'Here you can select (check) the column fields which the final spreadsheet file will have. They are based on international standards, such as Darwin Core, Dublin Core and their extensions. There is a help button near each checkbox for further reference. The disabled fields are required.<br>(!) Note that unchecked fields will be collapsed in the spreadsheet, but their data WILL BE written to file and may be retrieved by unhiding said collumn.'); ?></p>
        </div>

        <div style="float:left; margin-left:280px; margin-right:20px; margin-bottom:20px"><input type="button" value="Check all" id="checkAll"></div>
        <div style="float:left;"><input type="button" value="Uncheck all" id="uncheckAll"></div>
        <div style="clear:both"></div>

        <div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=interactiontype"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox108" name="Col" value="interactiontype" class="check required" checked disabled/><label for="checkbox108">Interaction type</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=interactionrelatedinformation"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox109" name="Col" value="interactionrelatedinformation" class="check required" checked disabled/><label for="checkbox109">Interaction related information</label></div>
            <div style="clear:both"></div>
        </div>
        <div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=delete"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox0" name="Col" value="delete" class="check required" checked disabled/><label for="checkbox0">Delete</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=private"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox1" name="Col" value="private" class="check required" checked disabled/><label for="checkbox1">Private</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=basisofrecord"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox2" name="Col" value="basisofrecord" class="check required" checked disabled/><label for="checkbox2">Basis of record</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=institutioncode"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox3" name="Col" value="institutioncode" class="check required" checked disabled/><label for="checkbox3">Institution code</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=collectioncode"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox4" name="Col" value="collectioncode" class="check required" checked disabled/><label for="checkbox4">Collection code</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=catalognumber"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox5" name="Col" value="catalognumber" class="check required" checked disabled/><label for="checkbox5">Catalog number</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=scientificname"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox6" name="Col" value="scientificname" class="check required" checked disabled/><label for="checkbox6">Scientific name</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=type"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox7" name="Col" value="type" class="check" checked/><label for="checkbox7">Type</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=ownerinstitution"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox8" name="Col" value="ownerinstitution" class="check" checked/><label for="checkbox8">Owner institution code</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=dataset"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox9" name="Col" value="dataset" class="check" checked/><label for="checkbox9">Dataset</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=rights"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox10" name="Col" value="rights" class="check" checked/><label for="checkbox10">Rights</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=rightsholder"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox11" name="Col" value="rightsholder" class="check" checked/><label for="checkbox11">Rights holder</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=accessrights"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox12" name="Col" value="accessrights" class="check" checked/><label for="checkbox12">Access rights</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=informationwithheld"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox13" name="Col" value="informationwithheld" class="check" checked/><label for="checkbox13">Information withheld</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=datageneralization"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox14" name="Col" value="datageneralization" class="check" checked/><label for="checkbox14">Data generalization</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=dynamicproperty"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox15" name="Col" value="dynamicproperties" class="check" checked/><label for="checkbox15">Dynamic properties</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=kingdom"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox16" name="Col" value="kingdom" class="check" checked/><label for="checkbox16">Kingdom</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=phylum"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox17" name="Col" value="phylum" class="check" checked/><label for="checkbox17">Phylum</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=class"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox18" name="Col" value="class_" class="check" checked/><label for="checkbox18">Class</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=order"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox19" name="Col" value="order" class="check" checked/><label for="checkbox19">Order</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=family"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox20" name="Col" value="family" class="check" checked/><label for="checkbox20">Family</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=genus"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox21" name="Col" value="genus" class="check" checked/><label for="checkbox21">Genus</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=subgenus"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox22" name="Col" value="subgenus" class="check" checked/><label for="checkbox22">Subgenus</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=specificepithet"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox23" name="Col" value="specificepithet" class="check" checked/><label for="checkbox23">Specific epithet</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=infraspecificepithet"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox24" name="Col" value="infraspecificepithet" class="check" checked/><label for="checkbox24">Infraspecific epithet</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=taxonrank"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox25" name="Col" value="taxonrank" class="check" checked/><label for="checkbox25">Taxon rank</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=scientificnameauthorship"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox26" name="Col" value="scientificnameauthor" class="check" checked/><label for="checkbox26">Scientific name authorship</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=nomenclaturalcode"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox27" name="Col" value="nomenclaturalcode" class="check" checked/><label for="checkbox27">Nomenclatural code</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=taxonconcept"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox28" name="Col" value="taxonconcept" class="check" checked/><label for="checkbox28">Taxon concept</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=nomenclaturalstatus"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox29" name="Col" value="nomenclaturalstatus" class="check" checked/><label for="checkbox29">Nomenclatural status</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=acceptednameusage"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox30" name="Col" value="acceptednameusage" class="check" checked/><label for="checkbox30">Accepted name usage</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=parentnameusage"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox31" name="Col" value="parentnameusage" class="check" checked/><label for="checkbox31">Parent name usage</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=originalnameusage"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox32" name="Col" value="originalnameusage" class="check" checked/><label for="checkbox32">Original name usage</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=nameaccordingto"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox33" name="Col" value="nameaccordingto" class="check" checked/><label for="checkbox33">Name according to</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=namepublishedin"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox34" name="Col" value="namepublishedin" class="check" checked/><label for="checkbox34">Name published in</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=vernacularname"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox35" name="Col" value="vernacularname" class="check" checked/><label for="checkbox35">Vernacular name</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=taxonomicstatus"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox36" name="Col" value="taxonomicstatus" class="check" checked/><label for="checkbox36">Taxonomic status</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=verbatimtaxonrank"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox37" name="Col" value="verbatimtaxonrank" class="check" checked/><label for="checkbox37">Verbatim taxon rank</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=taxonremark"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox38" name="Col" value="taxonremarks" class="check" checked/><label for="checkbox38">Taxon remarks</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=individual"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox39" name="Col" value="individual" class="check" checked/><label for="checkbox39">Individual</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=individualcount"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox40" name="Col" value="individualcount" class="check" checked/><label for="checkbox40">Individual count</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=sex"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox41" name="Col" value="sex" class="check" checked/><label for="checkbox41">Sex</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=behavior"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox42" name="Col" value="behavior" class="check" checked/><label for="checkbox42">Behavior</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=lifestage"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox43" name="Col" value="lifestage" class="check" checked/><label for="checkbox43">Life stage</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=disposition"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox44" name="Col" value="disposition" class="check" checked/><label for="checkbox44">Disposition</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=reproductivecondition"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox45" name="Col" value="reproductivecondition" class="check" checked/><label for="checkbox45">Reproductive condition</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=establishmentmean"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox46" name="Col" value="estabilishmentmean" class="check" checked/><label for="checkbox46">Estabilishment mean</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=recordedby"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox47" name="Col" value="recordedby" class="check" checked/><label for="checkbox47">Recorded by</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=recordnumber"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox48" name="Col" value="recordnumber" class="check" checked/><label for="checkbox48">Record number</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=othercatalognumber"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox49" name="Col" value="othercatalognumbers" class="check" checked/><label for="checkbox49">Other catalog numbers</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=preparation"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox50" name="Col" value="preparations" class="check" checked/><label for="checkbox50">Preparations</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=associatedsequences"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox51" name="Col" value="associatedsequence" class="check" checked/><label for="checkbox51">Associated sequence</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=occurrencedetail"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox52" name="Col" value="occurrencedetails" class="check" checked/><label for="checkbox52">Occurrence details</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=occurrenceremark"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox53" name="Col" value="occurrenceremarks" class="check" checked/><label for="checkbox53">Ocurrence remarks</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=occurrencestatus"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox54" name="Col" value="occurrencestatus" class="check" checked/><label for="checkbox54">Ocurrence status</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=dateidentified"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox55" name="Col" value="dateidentified" class="check" checked/><label for="checkbox55">Date identified</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=identificationqualifier"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox56" name="Col" value="identificationqualifier" class="check" checked/><label for="checkbox56">Identification qualifier</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=identifiedby"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox57" name="Col" value="identifiedby" class="check" checked/><label for="checkbox57">Identified by</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=typestatus"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox58" name="Col" value="typestatus" class="check" checked/><label for="checkbox58">Type status</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=identificationremark"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox59" name="Col" value="identificationremarks" class="check" checked/><label for="checkbox59">Identification remarks</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=samplingprotocol"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox60" name="Col" value="samplingprotocol" class="check" checked/><label for="checkbox60">Sampling protocol</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=samplingeffort"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox61" name="Col" value="samplingeffort" class="check" checked/><label for="checkbox61">Sampling effort</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=habitat"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox62" name="Col" value="habitat" class="check" checked/><label for="checkbox62">Habitat</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=verbatimeventdate"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox63" name="Col" value="verbatimeventdate" class="check" checked/><label for="checkbox63">Verbatim event date</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=eventtime"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox64" name="Col" value="eventtime" class="check" checked/><label for="checkbox64">Event time</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=eventdate"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox65" name="Col" value="eventdate" class="check" checked/><label for="checkbox65">Event date</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=fieldnumber"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox66" name="Col" value="fieldnumber" class="check" checked/><label for="checkbox66">Field number</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=fieldnotes"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox67" name="Col" value="fieldnotes" class="check" checked/><label for="checkbox67">Field notes</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=eventremark"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox68" name="Col" value="eventremarks" class="check" checked/><label for="checkbox68">Event remarks</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=decimalatitude"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox69" name="Col" value="decimalatitude" class="check" checked/><label for="checkbox69">Decimal latitude</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=decimallongitude"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox70" name="Col" value="decimallongitude" class="check" checked/><label for="checkbox70">Decimal longitude</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=continent"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox71" name="Col" value="continent" class="check" checked/><label for="checkbox71">Continent</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=country"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox72" name="Col" value="country" class="check" checked/><label for="checkbox72">Country</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=stateprovince"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox73" name="Col" value="stateorprovince" class="check" checked/><label for="checkbox73">State or province</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=county"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox74" name="Col" value="county" class="check" checked/><label for="checkbox74">County</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=municipality"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox75" name="Col" value="municipality" class="check" checked/><label for="checkbox75">Municipality</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=locality"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox76" name="Col" value="locality" class="check" checked/><label for="checkbox76">Locality</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=waterbody"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox77" name="Col" value="waterbody" class="check" checked/><label for="checkbox77">Water body</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=islandgroup"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox78" name="Col" value="islandgroup" class="check" checked/><label for="checkbox78">Island group</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=island"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox79" name="Col" value="island" class="check" checked/><label for="checkbox79">Island</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=locationaccordingto"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox80" name="Col" value="locationaccordingto" class="check" checked/><label for="checkbox80">Location according to</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=coordinateprecision"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox81" name="Col" value="coordinateprecision" class="check" checked/><label for="checkbox81">Coordinate precision</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=locationremark"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox82" name="Col" value="locationremarks" class="check" checked/><label for="checkbox82">Location remarks</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=minimumelevationinmeters"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox83" name="Col" value="minimunelevation" class="check" checked/><label for="checkbox83">Minimum elevation in meters</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=maximumelevationinmeters"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox84" name="Col" value="maximumelevation" class="check" checked/><label for="checkbox84">Maximum elevation in meters</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=minimumdepthinmeters"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox85" name="Col" value="minimumdepth" class="check" checked/><label for="checkbox85">Minimum depth in meters</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=maximumdepthinmeters"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox86" name="Col" value="maximumdepth" class="check" checked/><label for="checkbox86">Maximum depth in meters</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=minimumdistanceabovesurfaceinmeters"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox87" name="Col" value="minimumdistance" class="check" checked/><label for="checkbox87">Minimum distance above surface in meters</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=maximumdistanceabovesurfaceinmeters"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox88" name="Col" value="maximumdistance" class="check" checked/><label for="checkbox88">Maximum distance above surface in meters</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=verbatimdepth"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox89" name="Col" value="verbatimdepth" class="check" checked/><label for="checkbox89">Verbatim depth</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=verbatimelevation"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox90" name="Col" value="verbatimelevation" class="check" checked/><label for="checkbox90">Verbatim elevation</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=verbatimlocality"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox91" name="Col" value="verbatimlocality" class="check" checked/><label for="checkbox91">Verbatim locality</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=verbatimsrs"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox92" name="Col" value="verbatimsrs" class="check" checked/><label for="checkbox92">Verbatim SRS</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=georeferencedby"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox93" name="Col" value="georeferencedby" class="check" checked/><label for="checkbox93">Georeferenced by</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=georeferencesource"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox94" name="Col" value="georeferencesources" class="check" checked/><label for="checkbox94">Georeference sources</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=footprintsrs"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox95" name="Col" value="footprintsrs" class="check" checked/><label for="checkbox95">Footprint SRS</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=coordinateuncertainty"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox96" name="Col" value="coordinateuncertainty" class="check" checked/><label for="checkbox96">Coordinate uncertainty</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=geodeticdatum"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox97" name="Col" value="geodeticdatum" class="check" checked/><label for="checkbox97">Geodetic datum</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=pointradiusspatialfit"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox98" name="Col" value="pointradiusspatialfit" class="check" checked/><label for="checkbox98">Point radius spatial fit</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=verbatimcoordinate"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox99" name="Col" value="verbatimcoordinates" class="check" checked/><label for="checkbox99">Verbatim coordinates</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=verbatimlatitude"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox100" name="Col" value="verbatimlatitude" class="check" checked/><label for="checkbox100">Verbatim latitude</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=verbatimlongitude"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox101" name="Col" value="verbatimlongitude" class="check" checked/><label for="checkbox101">Verbatim longitude</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=verbatimcoordinatesystem"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox102" name="Col" value="verbatimcoordinatesystem" class="check" checked/><label for="checkbox102">Verbatim coordinate system</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=georeferenceprotocol"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox103" name="Col" value="georeferenceprotocol" class="check" checked/><label for="checkbox103">Georeference protocol</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=verificationstatus"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox104" name="Col" value="verificationstatus" class="check" checked/><label for="checkbox104">Verification status</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=georeferenceremark"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox105" name="Col" value="georeferenceremarks" class="check" checked/><label for="checkbox105">Georeference remarks</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=footprintwkt"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox106" name="Col" value="footprintwkt" class="check" checked/><label for="checkbox106">Footprint wkt</label></div>
            <div style="clear:both"></div>
        </div><div class="exportCheckbox">
            <div class="icon"><a rel="lightbox" href="index.php?r=help&helpfield=footprintspatialfit"><?php showIcon("Help", "ui-icon-help", 1); ?></a></div>
            <div class="label"><input type="checkbox" id="checkbox107" name="Col" value="footprintspatialfit" class="check" checked/><label for="checkbox107">Footprint spatial fit</label></div>
            <div style="clear:both"></div>
        </div>
        <div style="clear:both"></div>
    </div>

    <!-- End -->
    <div id="exportEnd">
        <div class="maxrecordsperfile"></div>
        <div class="estimatedTime"></div>
        <div style="clear:both"></div>

        <div id="loading" style="background-color: #F9F9F9;margin: 50px; display:none">
            <table  style="background-color: #F9F9F9;" align="center" width="100%">
                <tr align="center">
                    <td><?php echo Yii::t('yii', 'Please wait while the BDD converts the data into a spreadsheet file.'); ?>
                        <br/><?php echo Yii::t('yii', 'This may take a few minutes depending on the size of the database.'); ?></td>
                </tr>
                <tr align="center">
                    <th><img width="35px" src="images/main/ajax-loader.gif"/></th>
                </tr>
                <tr align="center">
                    <td><?php echo Yii::t('yii','Working...'); ?></td>
                </tr>
            </table>
        </div>

        <div id="sinceCountdown"></div>

        <div id="result">
            <div id="divlink">
                <div class="linkEnd" style="clear:both;"></div>
            </div>
            <div style="clear:both;"></div>
            <span id="log"></span>
        </div>
    </div>
    <?php echo CHtml::endForm(); ?>
</div>
