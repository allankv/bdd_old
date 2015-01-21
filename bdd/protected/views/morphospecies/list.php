<?php include_once("protected/extensions/config.php"); ?>
<script type="text/javascript" src="js/List.js"></script>

<style type="text/css">
    #slider {
        margin: 10px;
    }
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
    ul#icons li {
        cursor: pointer;
        float: left;
        list-style: none outside none;
        margin: 2px;
        padding: 4px;
        position: relative;
    }
    #project-label {
        color: #AA5511;
        margin-bottom: 1em;
    }
    #project-level {
        color: #AA5511;
        font-weight: bold;
    }
    #project-icon {
        float: right;
        height: 32px;
    }
    #project-description {
        margin: 0;
        padding: 0;
        font-size: small;
    }
    #notFoundScientificName {
	    padding-top: 12px;
		padding-left: 70px;
		font-size: 14px;
		width: 100%;
    }
    
    .containerBlock {
	    border-color: #F6A828;
	    background-color: #F4EFD9;
	    border-style: solid;
	    border-radius: 4px;
	    border-width: 1px;
	    width: auto;
    }
    #inputStep {
	    height: 150px;
    }
    #inputTable {
	    background: none;
	    width: 400px;
	    height: 80px;
	    position: absolute;
	    left: 50%;
	    margin-left: -200px;
	    top: 50%;
	    margin-top: -40px;
    }
    div #loadingIconStep {
    	display: none;
    	height: 150px;
    }
    div #loadingIconStep div {
	    height: 80px;
		width: 500px;
		position: absolute;
		left: 50%;
		margin-left: -250px;
		top: 50%;
		margin-top: -40px;
    }
    div #loadingIconStep div p {
	    text-align: center;
	    font-size: 15px;
	    color: rgb(246, 168, 40);
    }
    div #loadingIconStep div img {
	    display: block;
	    width: 40px;
	    margin-left: auto;
	    margin-right: auto;
    }
    div #scientificNameTable {
	    display: none;
	    min-height: 150px;
	    padding-top: 1px;
    }
    div #newScientificName {
	    display: none;
	    height: 150px;
    }
    div #newScientificName div {
	    height: 110px;
		width: 400px;
		position: absolute;
		left: 50%;
		margin-left: -200px;
		margin-top: 25px;
    }
    .questUseNotValid {
	    display: none;
    }
    .questNewScientific {
	    display: none;
    }
</style>
<script>
    

    var start = 0;
    var end = 10;
    var max = 10;
    var interval = 10;
    var handleSize = 50;
    
    $(document).ready(bootMorphospecies);
    
    // Inicia configuracoes Javascript
    function bootMorphospecies(){
        configCatComplete('#id','#searchField', 'morphospecies','#filterList');
        configIcons();
        configAutoComplete();
        configUseCancelButtons();
        filter();
        
        //slider();
        $( "#identification" ).dialog({
            autoOpen: false,
            show: "blind",
            hide: "explode",
            minHeight: 190,
            minWidth: 600,
            resizable: false,
            modal: true
        });
        
        // textInputConfig
        $("#valueTextField").keyup(function(){
	        if ($("#button").is(":visible")) $("#button").hide("fade", function() {
		        if (!($("#messageIdentify").is(":visible"))) $("#messageIdentify").show("slide", {direction: "up"});
	        });  
        });
        
        // filterPoshyTipConfig
        var helpTip = '<div style="font-weight:normal;">Use this box to filter the results below. Different terms for different categories (e.g.: Institution Code and Collection Code) will result in an AND search. Different terms for the same category, however, will result in an OR search.</div>';
        $('#searchField').poshytip({
            className: 'tip-twitter',
            content: helpTip,
            showOn: 'focus',
            alignTo: 'target',
            alignX: 'left',
            alignY: 'center',
            offsetX: 35
        });

        //Set the help tooltip for the Filter textbox
        
    }
    
    function filter(senderValue){
        if (senderValue == null) {
            start = 0;
        }

        $.ajax({
            type:'POST',
            url:'index.php?r=morphospecies/filter',
            data: {'limit':interval, 'offset':start, 'list':jFilterList},
            dataType: "json",
            success: function(json) {
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

                for(var i in rs) {                    
                    insertLine(rs[i]);
                }

                configIcons();
            }
        });
    }
    
    function configUseCancelButtons() {
	    $("#useBtn").mouseover(function(){
			$("#useBtn").removeClass("ui-button ui-widget ui-state-default ui-corner-all");
			$("#useBtn").addClass("ui-button ui-widget ui-state-default ui-corner-all ui-state-hover");
	    });
	    $("#cancelBtn").mouseover(function(){
			$("#cancelBtn").removeClass("ui-button ui-widget ui-state-default ui-corner-all");
			$("#cancelBtn").addClass("ui-button ui-widget ui-state-default ui-corner-all ui-state-hover");
	    });
	    $("#useBtn").mouseout(function(){
	    	$("#useBtn").removeClass("ui-button ui-widget ui-state-default ui-corner-all ui-state-hover");
			$("#useBtn").addClass("ui-button ui-widget ui-state-default ui-corner-all");
	    });
	    $("#cancelBtn").mouseout(function(){
	   		$("#cancelBtn").removeClass("ui-button ui-widget ui-state-default ui-corner-all ui-state-hover");
			$("#cancelBtn").addClass("ui-button ui-widget ui-state-default ui-corner-all");
	    });
	    
    }
    
    function list(id){
        $('#listSpecimens').load('index.php?r=morphospecies/goToListSpecimens&idmorphospecies='+id);
        $( "#listSpecimens" ).dialog({
            autoOpen: false,
            show: "blind",
            hide: "explode",
            minHeight: 450,
            minWidth: 850,
            resizable: false,
            modal: true
        });
        $( "#listSpecimens" ).dialog( "open" );
    }
 
    function identification(id, genus) {
    	$("#inputStep").show();
    	$("#linesCol").remove();
        $("#scientificNameTable").hide();
        $("#newScientificName").hide();
        $(".questNewScientific").hide();
        $(".questUseNotValid").hide();
        
        // setup identify button
        $("#button").button();
    	$("#button").hide(); 
	    $("#messageIdentify").show();
	    
        $("#valueTextField" ).val(genus);
        $("#idmorphospecies" ).val(id);
        
        // abrir janela de identificação
        $("#identification" ).dialog( "open" );

    }
    
    function identify(){
        var arraux = $("#valueTextField").val().split(" ", 2);
        var species = arraux[1];
        if (!(species == null)){
            $.ajax({
                type:'POST',
                url:'index.php?r=morphospecies/identify',
                data: {
                    'idmorphospecies':$( "#idmorphospecies" ).val(), 
                    'species':$( "#valueTextField" ).val(), 
                    'idspecies':$("#idscientificname").val(),
                    'valid':$("#valid").val()
                },
                dataType: "json",
                success:function(json) {
                    filter();
                    $("#identification").dialog("close");
                }
            });
        } else {
            alert("Scientificname wasn't specified !");
        }
    }
    
    function insertLine(rs){
        var line ='<tr id="_ID_" title="_TITLE_"><td style="text-indent:5px;">_MORPHOSPECIES_</td><td style="width:120px; text-align:center;">_QUANTITY_</td><td style="width:160px; text-align:center; text-indent:0px;">_BUTTONS_</td></tr>';
        var aux = line;

        //var btnRestricted = '<ul id="icons"><li class="ui-state-default ui-corner-all" title="Restricted Specimen Record"><span class="ui-icon ui-icon-locked"></span></a></li></ul>';
        //var btnEdit = '<ul id="icons"><li class="optionIcon ui-state-default ui-corner-all" title="Update Specimen Record"><a href="index.php?r=specimen/goToMaintain&id='+rs.id+'"><span class="ui-icon ui-icon-document"></span></a></li>';
        //var btnDelete = '<li class="optionIcon ui-state-default ui-corner-all" title="Delete Specimen Record"><a href="javascript:deleteSpecimenRecord('+rs.id+');"><span class="ui-icon ui-icon-trash"></span></a></li></ul>';
        
        var type;
        var arr = rs.morphospecies.split(" ", 2);
        var genus = arr[0];
        
        if(arr[1] == "spp.") type = "SPP" ;
        else type = "SPN";
        
        var btnList = "<div class='btnUpdate' style='margin-left: 50px;'><a href='javascript:list(\""+rs.id+"\")'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='List Morphospecies Records'><span class='ui-icon ui-icon-script'></span></li></ul></a></div>";
        if(type=="SPN")
            var btnIdentification = "<div class='btnDelete'><a href='javascript:identification(\""+rs.id+"\", \""+genus+"\");'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Identify Morphospecies Record'><span class='ui-icon ui-icon-circle-zoomout'></span></li></ul></a></div><div style='clear:both'></div>";
        else
            var btnIdentification = "<div class='btnDelete'><a href='javascript:list(\""+rs.id+"\");'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Identify Morphospecies Record'><span class='ui-icon ui-icon-circle-zoomout'></span></li></ul></a></div><div style='clear:both'></div>";
            
        
        //aux = aux.replace('_TITLE_','Institution: '+rs.institution+'<br/>Collection: '+rs.collection);
        // aux = aux.replace('_ISPRIVATE_',rs.isrestricted?btnPrivate:'');
       
        aux = aux.replace('_ID_',rs.id);
        aux = aux.replace('_MORPHOSPECIES_',rs.morphospecies);
        aux = aux.replace('_QUANTITY_',rs.quantity);        
        aux = aux.replace('_BUTTONS_',btnList+btnIdentification);

        //var btnEdit = '<a href="index.php?r=specimen/goToMaintain&id='+rs.id+'"><img src="images/main/edit.png" style="border:0px;" title="Update"/></a> | ';
        //var btnReference = '<a href="#"><img src="images/main/doc.png" style="border:0px;" title="References"/></a> | ';
        //var btnMedia = '<a href="#"><img src="images/main/images.gif" style="border:0px;" title="Medias"/></a> | ';
        //var btnInteraction = '<a href="#"><img src="images/main/ic_alvo.gif" style="border:0px;" title="Interaction"/></a> | ';
        //var btnDelete = '<a href="#" onclick="javascript:deleteSpecimenRecord('+rs.id+');"><img src="images/main/canc.gif" style="border:0px;" title="Delete"/></a> | ';


        $("#lines").append(aux);
    }
      
    function configAutoComplete() {
        $("#valueTextField").autocomplete({
            minLength: 1,
            source: 'index.php?r=morphospecies/searchLocal',
            select: function(event, ui ) {
            	if (ui.item.level == 'New') {
	            	searchCol($("#valueTextField").val());
	            	$("#inputStep").hide();
	            	$("#loadingIconStep").show();
            	} else { 
                	$("#valid").val(ui.item.valid);
                	$("#valueTextField").val(ui.item.label);
                	$("#idscientificname").val(ui.item.id);
                	$("#messageIdentify").hide("slide", {direction: "down"}, function(){
	                	$("#button").show("slide", {direction: "up"}); 
                	});
                }
            }			
        }).data( "autocomplete" )._renderItem = function( ul, item ) {
            return $( "<li></li>" ).data( "item.autocomplete", item ).append("<a><span id='project-label'>" +item.label + "</span> (<span id='project-level'>"+item.level+"</span>) <img id='project-icon' src='"+item.icon+"'/><br><span id='project-description'>" + item.desc + "</span></a>" )
            .appendTo( ul );
        };
    }
    
    function searchCol(scientificname) {
    	var foundEqual = true;
    	$.ajax({
            type:'POST',
            url:'index.php?r=morphospecies/searchColEqual',
            data: {
            	'scientificname':scientificname,
            },
            dataType: "json",
            success: function(json) {
	           	var rsEqual = new Object();
                rsEqual = json;
                if (rsEqual.length == 0) {
	                foundEqual = false;              
                }
            }
        });
        $.ajax({
            type:'POST',
            url:'index.php?r=morphospecies/searchCol',
            data: {
            	'scientificname':scientificname,
            },
            dataType: "json",
            success: function(json2) {
	           	var rs = new Object();
                rs = json2;
                if (rs.length == 0) {
	                $("#newNameText").val(scientificname);
                	$(".questNewScientific").show();
                	$("#loadingIconStep").hide();
                	$("#newScientificName").show();
                } else {
	            	for(var i in rs) {
	                	insertLineCol(rs[i]);
	                }
	                $("#loadingIconStep").hide();
	                $("#scientificNameTable").show();
	                if (!foundEqual) {
		                $("#newNameText").val(scientificname);
		                $(".questUseNotValid").show();
		                $("#newScientificName").show();
	                }
	            }
            }
        });
    }
    function chooseScientificName(scientificName) {
	    $("#valueTextField").val(scientificName);
	    $("#valid").val(true);
	    $("#idscientificname").val("");
	    $("#button").show(); 
	    $("#messageIdentify").hide();
	    
	    if($("#newScientificName").is(":visible")) {
		    $("#newScientificName").hide("slide", {direction: "left"}, function() {
			    $(".questUseNotValid").hide();
			    $(".questNewScientific").hide();
		    });
	    }
	    
	    $("#scientificNameTable").hide("slide", {direction: "left"}, function() {
	    	$("#inputStep").show("slide", {direction: "right"}, function(){
		    	$("#linesCol").remove();
	    	});
	    });
    }
    function useNotValidName() {
	    $("#valueTextField").val($("#newNameText").val());
	    $("#valid").val(false);
	    $("#idscientificname").val("");
	    $("#button").show(); 
	    $("#messageIdentify").hide();
	    
	    if($("#scientificNameTable").is(":visible")) {
	    	$("#scientificNameTable").hide("slide", {direction: "left"});
	    }
	    
	    $("#newScientificName").hide("slide", {direction: "left"}, function() {
	    	$(".questUseNotValid").hide();
	    	$(".questNewScientific").hide();
			$("#inputStep").show("slide", {direction: "right"}, function() {
				$("#linesCol").remove();
			});
	    });
    }
    function dontUseNotValidName() {
	    $(".questUseNotValid").hide();
	    $(".questNewScientific").hide();
	    $("#identification").dialog("close");
    }
    function insertLineCol(rs) {
	    var line ='<tr id="linesCol" title="_TITLE_"><td>'+rs.label+'</td><td>_BUTTONS_</td></tr>';
        var btnChoose = "<div class='btnUpdate' style='margin-left: 45%'><a href='javascript:chooseScientificName(\""+rs.label+"\")'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='List Specimen Records'><span class='ui-icon ui-icon-arrowthick-1-e'></span></li></ul></a></div>";
        line = line.replace('_BUTTONS_',btnChoose);
        $("#linesScientificName").append(line);    
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
</script>

<div class="introText">
    <div style="float:left;"><?php echo CHtml::image("images/help/iconelist.png"); ?></div>
    <h1 style="padding-left:10px; float:left;"><?php echo Yii::t('yii', 'View morphospecies records'); ?></h1>
    <div style="clear:both;"></div>
    <p><?php echo Yii::t('yii', 'Use this tool to search through all morphospecies records in the BDD database and identify any of them. Moreover,this tool includes quick links to view the records associated with their respective morphospecies.'); ?></p>
</div>

<?php echo CHtml::beginForm(); ?>
<div class="filter">
    <div class="filterLabel"><?php echo 'Filter'; ?></div>
    <div class="filterMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=filter', array('rel' => 'lightbox', 'style' => 'margin: 0px 10px 0px 0px;')); ?></div>
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
<?php echo CHtml::endForm(); ?>

<div id="rs" class="item">
    <table id="tablelist" class="list"">
	    <thead>
	    	<tr>
	    		<th style="text-align:left;">Morphospecies</th>
	    		<th>Quantity</th>
	    		<th>Options</th>
	    	</tr>
        </thead>
        <tbody id="lines"></tbody>
    </table>    
    <div class="legendbar">        
        <div class="updateIconLegend" style="margin-left: 145px"><?php showIcon("List Morphospecies Records", "ui-icon-script", 0); ?></div>
        <div class="updateIconLegendText">List Morphospecies Records</div>
        <div class="deleteIconLegend"><?php showIcon("Identify Morphospecies Record", "ui-icon-circle-zoomout", 0); ?></div>
        <div class="deleteIconLegendText">Identify Morphospecies Record</div>
        <div style="clear:both"></div>
    </div>    
</div>

<div id="identification">
	<div class="containerBlock">
	    <div id="inputStep">
	        <table id="inputTable">
	            <tr>
	                <td class="tablefieldcel">
	                	<?php echo 'Identification ' . $field . ': '; ?>
	                    <input id="valueTextField" type="text" style="width: 200px" value="">
	                    <input id="idmorphospecies" type="hidden">
	                    <input id="idscientificname" type="hidden">
	                    <input id="valid" type="hidden">
	                </td>
	                <td class="tablefieldcel">
	                	<span id="messageIdentify" ">Please first type a scientific name in the text box field and select an option.</span>
	                    <input id="button" name="identify" type="button" style="margin-top: 16px" value="<?php echo Yii::t('yii', "Identify"); ?>" onclick='identify()'/>
	                </td>
	            </tr>
	        </table>
	    </div>
	    <div id="loadingIconStep">
	    	<div>
				<img src="images/main/ajax-loader4.gif"/>
				<p>Searching in COL database...</p>
	    	</div>
		</div>
		<div id="scientificNameTable">
			<p style="margin-left: 40px;">You can choose one of the scientific names found in COL database:</p>
	        <table class="list" style="width: 500px; text-align:center; margin-bottom: 0px;">
	        	<thead>
		        	<tr>
			        	<th>Scientific Name</th>
			        	<th>Select by clicking</th>
		        	</tr>
	        	</thead>
	        	<tbody id="linesScientificName"></tbody>
	        </table>
		</div>
	    <div id="newScientificName">
	    	<div>
	    		<p class="questUseNotValid">Or do you still want to use the not validated name?</p>
		    	<p class="questNewScientific">Scientific Name not valid in COL Database</p>
				<p class="questNewScientific">Do you still want to use the not validated name?</p>
		    	<input id="newNameText" type="text" style="width: 230px" readonly="readonly">
		    	<input id="useBtn" type="button" value="Use" class="ui-button ui-widget ui-state-default ui-corner-all" onclick="useNotValidName()" role="button" >
		    	<input id="cancelBtn" type="button" value="Cancel" class="ui-button ui-widget ui-state-default ui-corner-all" onclick="dontUseNotValidName()" role="button" >
    		</div>
	    </div>
	</div>
</div>
<div id="listSpecimens"></div>