<?php include_once("protected/extensions/config.php"); ?>


<style type="text/css">
    #slider_child {
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
    #notFoundScientificName_child {
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
    #inputStep_child {
        height: 150px;
    }
    #inputTable_child {
        background: none;
        width: 400px;
        height: 80px;
        position: absolute;
        left: 50%;
        margin-left: -200px;
        top: 50%;
        margin-top: -40px;
    }
    div #loadingIconStep_child {
        display: none;
        height: 150px;
    }
    div #loadingIconStep_child div {
        height: 80px;
        width: 500px;
        position: absolute;
        left: 50%;
        margin-left: -250px;
        top: 50%;
        margin-top: -40px;
    }
    div #loadingIconStep_child div p {
        text-align: center;
        font-size: 15px;
        color: rgb(246, 168, 40);
    }
    div #loadingIconStep_child div img {
        display: block;
        width: 40px;
        margin-left: auto;
        margin-right: auto;
    }
    div #scientificNameTable_child {
        display: none;
        min-height: 150px;
        padding-top: 1px;
    }
    div #newScientificName_child {
        display: none;
        height: 150px;
    }
    div #newScientificName_child div {
        height: 110px;
        width: 400px;
        position: absolute;
        left: 50%;
        margin-left: -200px;
        margin-top: 25px;
    }
    .questUseNotValid_child {
        display: none;
    }
    .questNewScientific_child {
        display: none;
    }
</style>
<script>
 
    
    var start_child = 0;
    var end_child = 10;
    var max_child = 10;
    var interval_child = 10;
    var handleSize_child = 50;
    
    $(document).ready(bootMorphospecies_child);
    
    // Inicia configuracoes Javascript
    function bootMorphospecies_child(){
        configIcons();
        filter_child();
        configAutoComplete_child();
        
        configUseCancelButtons();
        
        // textInputConfig
        $("#valueTextField_child").keypress(function(){
            if ($("#button_child").is(":visible")) $("#button_child").hide("fade", function() {
                if (!($("#messageIdentify_child").is(":visible"))) $("#messageIdentify_child").show("slide", {direction: "up"});
            });  
        });
        
        //slider_child();
        
        $( "#identification_child" ).dialog({
            autoOpen: false,
            show: "blind",
            hide: "explode",
            minHeight: 190,
            minWidth: 600,
            resizable: false,
            modal: true
        });
        //Help message for the filter textbox help tool 
        var helpTip = '<div style="font-weight:normal;">Use this box to filter the results below. Different terms for different categories (e.g.: Institution Code and Collection Code) will result in an AND search. Different terms for the same category, however, will result in an OR search.</div>';

        //Set the help tooltip for the Filter textbox
        
    }
    
    function filter_child(senderValue){

        if (senderValue == null) {
            start_child = 0;
        }

        $.ajax({
            type:'POST',
            url:'index.php?r=morphospecies/filterchild',
            data: {'limit':interval_child, 'offset':start_child,'list':jFilterList, 'idmorphospecies':$("#idmorphospecies_child").val() },
            dataType: "json",
            success: function(json) {
            
            	console.log(json);
                var rs = new Object();
                $("#lines_child").html('');

                max_child = parseInt(json.count);

                if (start_child > max_child) {
                    start_child = 0;
                }

                $('#start_child').html(start_child);

                end_child = start_child + interval_child;

                if (end_child > max_child) { 
                    end_child = max_child;
                }

                $('#end_child').html(end_child);
                $('#max_child').html(max_child);

                slider_child();

                rs = json.result;

                for(var i in rs) {                    
                    insertLine_child(rs[i]);
                }

                configIcons();
            }
        });
    }
    
    function configUseCancelButtons() {
        $("#useBtn_child").mouseover(function(){
            $("#useBtn_child").removeClass("ui-button ui-widget ui-state-default ui-corner-all");
            $("#useBtn_child").addClass("ui-button ui-widget ui-state-default ui-corner-all ui-state-hover");
        });
        $("#cancelBtn_child").mouseover(function(){
            $("#cancelBtn_child").removeClass("ui-button ui-widget ui-state-default ui-corner-all");
            $("#cancelBtn_child").addClass("ui-button ui-widget ui-state-default ui-corner-all ui-state-hover");
        });
        $("#useBtn_child").mouseout(function(){
            $("#useBtn_child").removeClass("ui-button ui-widget ui-state-default ui-corner-all ui-state-hover");
            $("#useBtn_child").addClass("ui-button ui-widget ui-state-default ui-corner-all");
        });
        $("#cancelBtn_child").mouseout(function(){
            $("#cancelBtn_child").removeClass("ui-button ui-widget ui-state-default ui-corner-all ui-state-hover");
            $("#cancelBtn_child").addClass("ui-button ui-widget ui-state-default ui-corner-all");
        });
        
    }
    
    function list_child(id){
        alert(id);
    }
    function identification_child(idtaxonomicelement, genus){
    	$("#inputStep_child").show();
    	$("#linesCol_child").remove();
        $("#scientificNameTable_child").hide();
        $("#newScientificName_child").hide();
        $(".questNewScientific_child").hide();
        $(".questUseNotValid_child").hide();
            
        // setup identify button
        $("#button_child").button();
        $("#button_child").hide(); 
        $("#messageIdentify_child").show();
        
        $("#valueTextField_child" ).val(genus);
        $( "#idtaxonomicelement_child").val(idtaxonomicelement);
        // abrir janela de identificação
        $("#identification_child" ).dialog( "open" );
    }
    
    function identify_child(){
        var arraux = $("#valueTextField_child").val().split(" ", 2);
        var species = arraux[1];
        if (!(species == null)){
            $.ajax({
                type:'POST',
                url:'index.php?r=morphospecies/identifychild',
                data: {
                    'idmorphospecies':$( "#idmorphospecies_child" ).val(), 
                    'species':$( "#valueTextField_child" ).val(), 
                    'idspecies':$( "#idscientificname_child" ).val(),
                    'valid':$("#valid_child").val(),
                    'idtaxonomicelement':$("#idtaxonomicelement_child").val()
                },
                dataType: "json",
                success:function(json) {
                    filter();
                    filter_child();
                    $("#identification_child").dialog("close");
                }
            });
        } else {
            alert("Scientificname wasn't specified !");
        }
    }
    function insertLine_child(rs){
        var line ='<tr id="id_child__ID_" title="_TITLE_child_"><td style="text-indent:5px;">_INSTITUTION_</td><td style="width:120px; text-align:center;">_COLLECTION_</td><td style="width:120px; text-align:center;">_CATNUM_</td><td style="width:160px; text-align:center; text-indent:0px;">_BUTTONS_</td></tr>';
        var aux = line;

        //var btnRestricted = '<ul id="icons"><li class="ui-state-default ui-corner-all" title="Restricted Specimen Record"><span class="ui-icon ui-icon-locked"></span></a></li></ul>';
        //var btnEdit = '<ul id="icons"><li class="optionIcon ui-state-default ui-corner-all" title="Update Specimen Record"><a href="index.php?r=specimen/goToMaintain&id='+rs.id+'"><span class="ui-icon ui-icon-document"></span></a></li>';
        //var btnDelete = '<li class="optionIcon ui-state-default ui-corner-all" title="Delete Specimen Record"><a href="javascript:deleteSpecimenRecord('+rs.id+');"><span class="ui-icon ui-icon-trash"></span></a></li></ul>';
        
        var type;
        
        //insert title
        if($("#morphospeciesName").html() == '') $("#morphospeciesName").append("<h1 style=\"padding-left:10px; float:left;\">View \"" + rs.morphospecies + "\" records</h1>");
        
        //insert intro text
        if ($("#intro_text").html() == '') {
            var introText = '<p>Use this tool to search through all records in the BDD database that have the \"_MORPHOSPECIES_\" morphospecies and identify or edit any of them.</p>'
            introText = introText.replace('_MORPHOSPECIES_', rs.morphospecies);
            $("#intro_text").append(introText);
        }
        
        var arr = rs.morphospecies.split(" ", 2);
        var genus = arr[0];
        
        if(arr[1] == "spp.") type = "SPP" ;
        else type = "SPN";
        
        //fazer o btnView redirecionar para a página da ocorrência
        var btnEdit = "<div class='btnUpdate' style='margin-left: 50px;'><a href=index.php?r="+rs.controller +"/goToMaintain&id="+rs.id+"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Edit Record'><span class='ui-icon ui-icon-pencil'></span></li></ul></a></div>";
        var btnIdentification = "<div class='btnDelete'><a href='javascript:identification_child("+rs.idtaxonomicelement+", \""+genus+"\");'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Identify Record'><span class='ui-icon ui-icon-circle-zoomout'></span></li></ul></a></div><div style='clear:both'></div>";
        
        //aux = aux.replace('_TITLE_','Institution: '+rs.institution+'<br/>Collection: '+rs.collection);
        // aux = aux.replace('_ISPRIVATE_',rs.isrestricted?btnPrivate:'');
       
        aux = aux.replace('_ID_',rs.idtaxonomicelement);
        aux = aux.replace('_INSTITUTION_',rs.institutioncode);
        aux = aux.replace('_COLLECTION_',rs.collectioncode);
        aux = aux.replace('_CATNUM_',rs.catalognumber); 
        aux = aux.replace('_BUTTONS_',btnEdit+btnIdentification);

        //var btnEdit = '<a href="index.php?r=specimen/goToMaintain&id='+rs.id+'"><img src="images/main/edit.png" style="border:0px;" title="Update"/></a> | ';
        //var btnReference = '<a href="#"><img src="images/main/doc.png" style="border:0px;" title="References"/></a> | ';
        //var btnMedia = '<a href="#"><img src="images/main/images.gif" style="border:0px;" title="Medias"/></a> | ';
        //var btnInteraction = '<a href="#"><img src="images/main/ic_alvo.gif" style="border:0px;" title="Interaction"/></a> | ';
        //var btnDelete = '<a href="#" onclick="javascript:deleteSpecimenRecord('+rs.id+');"><img src="images/main/canc.gif" style="border:0px;" title="Delete"/></a> | ';
        
        $("#lines_child").append(aux);
        
    }
    
    function configAutoComplete_child() {
        $("#valueTextField_child").autocomplete({
            minLength: 1,
            source: 'index.php?r=morphospecies/searchLocal',
            select: function(event, ui ) {
                if (ui.item.level == 'New') {
                    searchCol_child($("#valueTextField_child").val());
                    $("#inputStep_child").hide();
                    $("#loadingIconStep_child").show();
                } else { 
                    $("#valid_child").val(ui.item.valid);
                    $("#valueTextField_child").val(ui.item.label);
                    $("#idscientificname_child").val(ui.item.id);
                    $("#messageIdentify_child").hide("slide", {direction: "down"}, function(){
                        $("#button_child").show("slide", {direction: "up"}); 
                    });
                }
            }           
        }).data( "autocomplete" )._renderItem = function( ul, item ) {
            return $( "<li></li>" ).data( "item.autocomplete", item ).append("<a><span id='project-label'>" +item.label + "</span> (<span id='project-level'>"+item.level+"</span>) <img id='project-icon' src='"+item.icon+"'/><br><span id='project-description'>" + item.desc + "</span></a>" )
            .appendTo( ul );
        };
    }
    
    function searchCol_child(scientificname) {
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
                    $("#newNameText_child").val(scientificname);
                    $(".questNewScientific_child").show();
                    $("#loadingIconStep_child").hide();
                    $("#newScientificName_child").show();
                } else {
                    for(var i in rs) {
                        insertLineCol_child(rs[i]);
                    }
                    $("#loadingIconStep_child").hide();
                    $("#scientificNameTable_child").show();
                    if (!foundEqual) {
                        $("#newNameText_child").val(scientificname);
                        $(".questUseNotValid_child").show();
                        $("#newScientificName_child").show();
                    }
                }
            }
        });
    }
    function chooseScientificName_child(scientificName) {
        $("#valueTextField_child").val(scientificName);
        $("#valid_child").val(true);
        $("#idscientificname_child").val("");
        $("#button_child").show(); 
        $("#messageIdentify_child").hide();
        
        if($("#newScientificName_child").is(":visible")) {
            $("#newScientificName_child").hide("slide", {direction: "left"}, function() {
                $(".questUseNotValid_child").hide();
                $(".questNewScientific_child").hide();
            });
        }
        
        $("#scientificNameTable_child").hide("slide", {direction: "left"}, function() {
            $("#inputStep_child").show("slide", {direction: "right"}, function(){
                $("#linesCol_child").remove();
            });
        });
    }
    function useNotValidName_child() {
        $("#valueTextField_child").val($("#newNameText_child").val());
        $("#valid_child").val(false);
        $("#idscientificname_child").val("");
        $("#button_child").show(); 
        $("#messageIdentify_child").hide();
        
        if($("#scientificNameTable_child").is(":visible")) {
            $("#scientificNameTable_child").hide("slide", {direction: "left"});
        }
        
        $("#newScientificName_child").hide("slide", {direction: "left"}, function() {
            $(".questUseNotValid_child").hide();
            $(".questNewScientific_child").hide();
            $("#inputStep_child").show("slide", {direction: "right"}, function() {
                $("#linesCol_child").remove();
            });
        });
    }
    function dontUseNotValidName_child() {
	    $(".questUseNotValid_child").hide();
	    $(".questNewScientific_child").hide();
        $("#identification_child").dialog("close");
    }
    
    function insertLineCol_child(rs) {
        var line ='<tr id="linesCol_child" title="_TITLE_"><td>'+rs.label+'</td><td>_BUTTONS_</td></tr>';
        var btnChoose = "<div class='btnUpdate' style='margin-left: 45%'><a href='javascript:chooseScientificName_child(\""+rs.label+"\")'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='List Specimen Records'><span class='ui-icon ui-icon-arrowthick-1-e'></span></li></ul></a></div>";
        line = line.replace('_BUTTONS_',btnChoose);
        $("#linesScientificName_child").append(line);    
    }
    function slider_child(){
        $("#slider_child").slider({
            range: false,
            min:0,
            max:max_child - interval_child,
            value:start_child,
            stop: function(event, ui) {
                start_child = ui.value;
                end_child = start_child + interval_child;
                filter_child('slider');
            },
            slide:function(event, ui) {
                $('#start_child').html(ui.value);
                $('#end_child').html((ui.value + interval_child));
            }
        }).find( ".ui-slider-handle" ).css({
            width: handleSize_child
        });

    }
</script>

<div class="introText">
    <div style="float:left;"><?php echo CHtml::image("images/help/iconelist.png"); ?></div>
    <div id="morphospeciesName"></div>
    <div style="clear:both;"></div>
    <div id="intro_text"></div>
</div>

<?php echo CHtml::beginForm(); ?>
<div class="filter">
    <div class="filterInterval">
    Filtered from <b><span id="start_child"></span></b> to <b><span id="end_child"></span></b> of <b><span id="max_child"></span></b>
    </div>
    <div style="clear:both"></div>

    <div class="slider" id="slider_child" style="width: 500px; float: left"></div>
    <div style="clear:both"></div>
    <div class="filterList">
    <div id="filterList_child"></div>
    </div>
</div>
<?php echo CHtml::endForm(); ?>

<div id="rs_child" class="item">
    <table id="tablelist" class="list">
        <thead>
            <tr><th style="text-align:left;">Institution</th><th>Collection</th><th>Catalog Number</th><th>Options</th></tr>
        </thead>
        <tbody id="lines_child"></tbody>
    </table>    
    <div class="legendbar">
        <div class="updateIconLegend" style="margin-left: 130px;"><?php showIcon("Edit Record", "ui-icon-pencil", 0); ?></div>
        <div class="updateIconLegendText">Edit Morphospecies Record</div>
        <div class="deleteIconLegend"><?php showIcon("Identify Record", "ui-icon-circle-zoomout", 0); ?></div>
        <div class="deleteIconLegendText">Identify Morphospecies Record</div>
        <div style="clear:both"></div>
    </div>    
</div>
<input id="idmorphospecies_child" type="hidden" value="<?php echo $idmorphospecies_child;?>">


<div id="identification_child">
    <div class="containerBlock">
        <div id="inputStep_child">
            <table id="inputTable_child">
                <tr>
                    <td class="tablefieldcel">
                        <?php echo 'Identification ' . $field . ': '; ?>
                        <input id="valueTextField_child" type="text" style="width: 200px" value="">
                        <input id="idmorphospecies_child" type="hidden">
                        <input id="idtaxonomicelement_child" type="hidden">
                        <input id="idscientificname_child" type="hidden">
                        <input id="valid_child" type="hidden">
                    </td>
                    <td class="tablefieldcel">
                        <span id="messageIdentify_child" ">Please first type a scientific name in the text box field and select an option.</span>
                        <input id="button_child" name="identify" type="button" style="margin-top: 16px" value="<?php echo Yii::t('yii', "Identify"); ?>" onclick='identify_child()'/>
                    </td>
                </tr>
            </table>
        </div>
        <div id="loadingIconStep_child">
            <div>
                <img src="images/main/ajax-loader4.gif"/>
                <p>Searching in COL database...</p>
            </div>
        </div>
        <div id="scientificNameTable_child">
            <p style="margin-left: 40px;">You can choose one of the scientific names found in COL database:</p>
            <table class="list" style="width: 500px; text-align:center; margin-bottom: 0px;">
                <thead>
                    <tr>
                        <th>Scientific Name</th>
                        <th>Select by clicking</th>
                    </tr>
                </thead>
                <tbody id="linesScientificName_child"></tbody>
            </table>
        </div>
        <div id="newScientificName_child">
            <div>
                <p class="questUseNotValid_child">Or do you still want to use the not validated name?</p>
                <p class="questNewScientific_child">Scientific Name not valid in COL Database</p>
                <p class="questNewScientific_child">Do you still want to use the not validated name?</p>
                <input id="newNameText_child" type="text" style="width: 230px" readonly="readonly">
                <input id="useBtn_child" type="button" value="Use" class="ui-button ui-widget ui-state-default ui-corner-all" onclick="useNotValidName_child()" role="button" >
                <input id="cancelBtn_child" type="button" value="Cancel" class="ui-button ui-widget ui-state-default ui-corner-all" onclick="dontUseNotValidName_child()" role="button" >
            </div>
        </div>
    </div>
</div>
