var selectedName = {"value":"",
					"rank":"",
					"source":"",
					"valid":false};
var selectedHierarchy = {	"kingdom":"",
							"phylum":"",
							"class_":"",
							"order":"",
							"family":"",
							"genus":"",
							"subgenus":"",
							"specificepithet":"",
							"infraspecificepithet":"",
							"scientificname":"",
							"count":"",
							"colvalidation":false
							};
var taxonColvalidation = {	"kingdom_colvalidation":"",
							"phylum_colvalidation":"",
							"class_colvalidation":"",
							"order_colvalidation":"",
							"family_colvalidation":"",
							"genus_colvalidation":"",
							"subgenus_colvalidation":"",
							"specificepithet_colvalidation":"",
							"infraspecificepithet_colvalidation":"",
							"scientificname_colvalidation":"",
							};
var suggestionNameLocal, suggestionNameCol, suggestionHierarchyLocal, suggestionHierarchyCol;
var loadingTaxon = "<img style='width: 30px; margin-bottom: 7px;' src='images/main/ajax-loader2.gif' /><br />";
/*
* SCROLL
*/
function scrollable(container) {
	//Background color, mouseover and mouseout
	var colorOver = '#337755';
	var colorTextOver = '#F6A828';
	var colorOut = '#F4EFD9';
	var colorTextOut = '#000';
	var fontOver = '11px';
	var fontOut = '10px';
	//Animate the LI on mouse over, mouse out
	$(container + ' #list li').click(function () {	
		//Make LI clickable
		
	}).mouseover(function (){		
		//mouse over LI and look for A element for transition
		$(this).find('a')
		.animate( { fontSize: fontOver}, { queue:false, duration:100 } )
		.animate( { backgroundColor: colorOver, color: colorTextOver }, { queue:false, duration:200 });

	}).mouseout(function () {
		//mouse oout LI and look for A element and discard the mouse over transition
		$(this).find('a')
		.animate( { fontSize: fontOut }, { queue:false, duration:100 } )
		.animate( { backgroundColor: colorOut, color: colorTextOut }, { queue:false, duration:200 });
	});	
	//Scroll the menu on mouse move above the #sidebar layer
	$(container).mousemove(function(e) {
		//Sidebar Offset, Top value
		var s_top = parseInt($(container).offset().top);		
		//Sidebar Offset, Bottom value
		var s_bottom = parseInt($(container).height() + s_top);
		//Roughly calculate the height of the menu by multiply height of a single LI with the total of LIs
		var mheight = parseInt($(container + ' #list li').height() * $(container + ' #list li').length);
		//I used this coordinate and offset values for debuggin
		$('#debugging_mouse_axis').html("X Axis : " + e.pageX + " | Y Axis " + e.pageY);
		$('#debugging_status').html(Math.round(((s_top - e.pageY)/100) * mheight / 2));
		//Calculate the top value
		//This equation is not the perfect, but it 's very close	
		var top_value = Math.round(( (s_top - e.pageY) /100) * mheight / 3);		
		//Animate the ul by chaging the top value
		$(container + ' #list').animate({top: top_value}, { queue:false, duration:500});
	});
}
/*
* MAIN
*/
function configTaxonTool() {
	$('#newHierarchyStep').hide();
	loadSetValues();
	$( "#taxon_name" ).autocomplete({
		minLength: 1,
		source: 'index.php?r=taxonomictool/searchLocal',
		select: function(event, ui ) {
            if(ui.item.desc=='Morphospecies' || ui.item.desc == 'New morphospecies?'){
                $("#TaxonomicElementAR_idmorphospecies").val(ui.item.id);
                $("#MorphospeciesAR_morphospecies").val(ui.item.label);
                ui.item.label = ui.item.label.split(' ')[0];
                ui.item.rank = 'genus';
                $("#morphospeciesrow").show();
            }
            selectedName.value = ui.item.label;
            selectedName.rank = ui.item.rank;
			selectedName.source = 'local';
			if(ui.item.valid){
				selectedName.valid = true;
				actionSelectValidName();
			}else{
				selectedName.valid = false;
				actionSelectNotValidName();
			}
		}			
	}).data( "autocomplete" )._renderItem = function( ul, item ) {
		return $( "<li></li>" ).data( "item.autocomplete", item ).append("<a><span id='project-label'>" +item.label + "</span> (<span id='project-level'>"+item.level+"</span>) <img id='project-icon' src='"+item.icon+"'/><br><span id='project-description'>" + item.desc + "</span></a>" )
			.appendTo( ul );
	};
		    
    $('#KingdomAR_kingdom').keyup(function() {
		compareHierarchies();
	});
	$('#KingdomAR_kingdom').blur(function() {
		compareHierarchies();
	});
	
	$('#PhylumAR_phylum').keyup(function() {
		compareHierarchies();
	});
	$('#PhylumAR_phylum').blur(function() {
		compareHierarchies();
	});
	
	$('#ClassAR_class').keyup(function() {
		compareHierarchies();
	});
	$('#ClassAR_class').blur(function() {
		compareHierarchies();
	});
	
	$('#OrderAR_order').keyup(function() {
		compareHierarchies();
	});
	$('#OrderAR_order').blur(function() {
		compareHierarchies();
	});
	
	$('#FamilyAR_family').keyup(function() {
		compareHierarchies();
	});
	$('#FamilyAR_family').blur(function() {
		compareHierarchies();
	});
	
	$('#GenusAR_genus').keyup(function() {
		compareHierarchies();
	});
	$('#GenusAR_genus').blur(function() {
		compareHierarchies();
	});
	
	$('#SubgenusAR_subgenus').keyup(function() {
		compareHierarchies();
	});
	$('#SubgenusAR_subgenus').blur(function() {
		compareHierarchies();
	});
	
	$('#SpecificEpithetAR_specificepithet').keyup(function() {
		compareHierarchies();
	});
	$('#SpecificEpithetAR_specificepithet').blur(function() {
		compareHierarchies();
	});
	
	$('#InfraspecificEpithetAR_infraspecificepithet').keyup(function() {
		compareHierarchies();
	});
	$('#InfraspecificEpithetAR_infraspecificepithet').blur(function() {
		compareHierarchies();
	});
	
	$('#ScientificNameAR_scientificname').keyup(function() {
		compareHierarchies();
	});
	$('#ScientificNameAR_scientificname').blur(function() {
		compareHierarchies();
	});
}
function compareHierarchies() {
	if ($('#KingdomAR_kingdom').val() == selectedHierarchy.kingdom &&
	$('#PhylumAR_phylum').val() == selectedHierarchy.phylum &&
	$('#ClassAR_class').val() == selectedHierarchy.class_ &&
	$('#OrderAR_order').val() == selectedHierarchy.order &&
	$('#FamilyAR_family').val() == selectedHierarchy.family &&
	$('#GenusAR_genus').val() == selectedHierarchy.genus &&
	$('#SubgenusAR_subgenus').val() == selectedHierarchy.subgenus &&
	$('#SpecificEpithetAR_specificepithet').val() == selectedHierarchy.specificepithet &&
	$('#InfraspecificEpithetAR_infraspecificepithet').val() == selectedHierarchy.infraspecificepithet &&
	$('#ScientificNameAR_scientificname').val() == selectedHierarchy.scientificname &&
	selectedHierarchy.colvalidation) {
		$('#taxonsources').html('<img style="height: 25px;" src="images/specimen/ITIS.gif" />');			
	}
	else {
		$('#taxonsources').html('<input type="button" onclick="selectTaxonTool();" value="USE BTT" style="width:100%"/>');
		$(":button").button();
	}
}
/*
* NOT VALID NAME
*/
function actionSelectNotValidName(){
	layoutValidatingName();
	logicSelectNotValidName();	
}
function layoutValidatingName(){
	$('#taxonNameStep').hide();
	$('#loadingNameStep').show();
	//$('#checkingNameStep').html(loadingTaxon + "<b>Validating taxon name...</b>");
}
function logicSelectNotValidName(){
	if(selectedName.rank!="New"){
		$.ajax({
	    	type: 'POST',
	        dataType: "json",
	        url: 'index.php?r=taxonomictool/validate',
	        data: {
	        	"term": selectedName.value, "rank":selectedName.rank
	        },
	        success: function(json){
	        	if(json.valid){
	        		selectedName.valid = true;
	        		actionSelectValidName();
	             }else{
	             	layoutSuggestionName();
	             	logicSuggestionName();           	           	                 	                             
	             }
	    	}
		});
	}else{
		layoutSuggestionName();
		logicSuggestionName();
	}
}
function layoutSuggestionName(){
	$('#loadingNameStep').hide();
	$('#suggestionNameStep').html("<div><b style='color:#885522'>Not valid taxon name. </b><br />Suggestions for <b>\""+selectedName.value+"\"</b>:</div><div class='sub'><div class='title'>Catalog of Life database</div><div id='incol'>"+loadingTaxon+"<b style='color: #F6A828'>Searching...</b></div></div><div class='sub'><div class='title'>Local database</div><div id='inlocal'>"+loadingTaxon+"<b style='color: #F6A828'>Searching...</b></div></div><div class='sub' style='width: 632px;'><div id='useInvalidName'><input type='button' onclick='layoutNewName(\""+selectedName.value+"\")' value='Use invalid name \""+selectedName.value+"\"'></input></div></div><div style='clear:both;'></div>");
	$('#suggestionNameStep').show();
	$(':button').button();	
    //$('#useInvalidNameLink').click(function(){
    	//if(selectedName.rank=="New"){
    	//	layoutNewName();
    	//}else{
    	//	actionSelectValidName();
    	//}
    //});
}
function layoutNewName(name){
	selectedName.value = name;
	var selectHtml = '<div class="title"><select id="selectTaxonRank"><option value="scientificname">Scientific name</option><option value="infraspecificepithet">Infraspecific epithet</option><option value="specificepithet">Specific epithet</option><option value="subgenus">Subgenus</option><option value="genus">Genus</option><option value="family">Family</option><option value="order">Order</option><option value="class">Class</option><option value="phylum">Phylum</option><option value="kingdom">Kingdom</option></select></div>'
	var buttonHtml = '<div><input type="button" value="Create New Taxon Name" onClick="actionCreateName();" style="width:200px;"/></div>';
	var divHtml = '<div class="title">Select the taxon rank with name <b>"'+selectedName.value+'"</b></div>'+selectHtml+buttonHtml;
	$('#useInvalidName').html(divHtml);
	$(':button').button();
}
function actionCreateName(){
	selectedName.rank = $('#selectTaxonRank').val();
	logicCreateName();
	actionNewHierarchy();
	logicSelectNotValidName();
}
function logicCreateName(){
	$.ajax({
    	type: 'POST',
        dataType: "json",
        url: 'index.php?r='+selectedName.rank+'/save',
        data: {
        	"field": selectedName.value
        },
        success: function(json){        	
        }
    });
}
function logicSuggestionName() {
	suggestionNameLocal = [];
	suggestionNameCol = [];
	// Local suggestions
	$.ajax({
    	type: 'POST',
        dataType: "json",
        url: 'index.php?r=taxonomictool/localSuggestions',
        data: {
        	"term": selectedName.value
        },
        success: function(json){
        	for(var i = 0; i < json.length; i++){
        		var n = new Object();
        		n.value = json[i].label;
        		n.rank = json[i].rank;
        		n.level = json[i].level;
        		n.source = 'local';
        		n.valid = true;
        		
        		suggestionNameLocal.push(n);
        	}
        	layoutSuggestionNameShowLocal();
        }
    });
    // CoL suggestions
	$.ajax({
    	type: 'POST',
        dataType: "json",
        url: 'index.php?r=taxonomictool/colSuggestions',
        data: {
        	"term": selectedName.value
        },
        success: function(json){
            for(var i = 0; i < json.length; i++){
        		var n = new Object();
        		n.value = json[i].label;
        		n.rank = json[i].level;
        		n.level = json[i].level;
        		n.source = 'col';
        		n.valid = true;        		
        		suggestionNameCol.push(n);
        	}
        	layoutSuggestionNameShowCol();
        }
    });
}
function layoutSuggestionNameShowLocal(){
	var str = "<ul id='list'>";
	for(var i = 0; i < suggestionNameLocal.length; i++){
		str = str+"<li><a style='text-align:center;' onclick=\"logicSelectSuggestedNameLocal("+i+");\" id='l"+i+"'><b>"+suggestionNameLocal[i].value+" ("+suggestionNameLocal[i].level+")</b></a></li>";
	}
	str = str+"</ul>";
	$('#inlocal').html(str);
	if (suggestionNameLocal.length != 0) {
		$('#inlocal').addClass('scrollable');
	}		
	scrollable('#inlocal');	                        
}
function layoutSuggestionNameShowCol(){
	var str = "<ul id='list'>";
	for(var i = 0; i < suggestionNameCol.length; i++){
    	str = str+"<li><a style='text-align:center;' onclick=\"logicSelectSuggestedNameCol("+i+");\" id='c"+i+"'><b>"+suggestionNameCol[i].value+" ("+suggestionNameCol[i].rank+")</b></a></li>";
    }
    str = str+"</ul>";
    $('#incol').html(str);
    if (suggestionNameCol.length != 0) {
		$('#incol').addClass('scrollable');
	} 	
  	scrollable('#incol');
}
function logicSelectSuggestedNameLocal(i){
	selectedName.value = suggestionNameLocal[i].value;
	selectedName.source = 'local'; 
	selectedName.rank = suggestionNameLocal[i].rank;
	selectedName.valid = true;
	actionSelectValidName();
}
function logicSelectSuggestedNameCol(i){
	selectedName.value = suggestionNameCol[i].value;
	selectedName.source = 'col'; 
	selectedName.rank = suggestionNameCol[i].rank;
	selectedName.valid = true;
	actionSelectValidName();
}
/*
* NEW HIERARCHY
*/
function actionNewHierarchy(){
	stepTaxon(0,1);
	logicNewHierarchy();
	layoutNewHierarchy();
}
function logicNewHierarchy(){
		selectedHierarchy = {	"scientificname":(selectedName.rank=='scientificname'?selectedName.value:""),
								"infraspecificepithet":(selectedName.rank=='infraspecificepithet'?selectedName.value:""),
								"specificepithet":(selectedName.rank=='specificepithet'?selectedName.value:""),
								"subgenus":(selectedName.rank=='subgenus'?selectedName.value:""),
								"genus":(selectedName.rank=='genus'?selectedName.value:""),
								"family":(selectedName.rank=='family'?selectedName.value:""),
								"order":(selectedName.rank=='order'?selectedName.value:""),
								"class_":(selectedName.rank=='class_'?selectedName.value:""),
								"phylum":(selectedName.rank=='phylum'?selectedName.value:""),
								"kingdom":(selectedName.rank=='kingdom'?selectedName.value:""),
								"colvalidation":false,
								"count":0};	
}
function layoutNewHierarchy(){
	$('#suggestionHierarchyStep').hide();
	$('#newHierarchyStep').show();
	$('#new_h_scientificname').val(selectedHierarchy.scientificname);
	$('#new_h_infraspecificepithet').val(selectedHierarchy.infraspecificepithet);
	$('#new_h_specificepithet').val(selectedHierarchy.specificepithet);
	$('#new_h_subgenus').val(selectedHierarchy.subgenus);
	$('#new_h_genus').val(selectedHierarchy.genus);
	$('#new_h_family').val(selectedHierarchy.family);
	$('#new_h_order').val(selectedHierarchy.order);
	$('#new_h_class').val(selectedHierarchy.class_);
	$('#new_h_phylum').val(selectedHierarchy.phylum);
	$('#new_h_kingdom').val(selectedHierarchy.kingdom);
	// createHierarchy
}
function actionCreateHierarchy(){
	logicCreateHierarchy();
	layoutFormSetValues();
	selectTaxonForm();
}
function logicCreateHierarchy(){	
	selectedHierarchy.scientificname = $('#new_h_scientificname').val();
	selectedHierarchy.infraspecificepithet = $('#new_h_infraspecificepithet').val();
	selectedHierarchy.specificepithet = $('#new_h_specificepithet').val();
	selectedHierarchy.subgenus = $('#new_h_subgenus').val();
	selectedHierarchy.genus = $('#new_h_genus').val();
	selectedHierarchy.family = $('#new_h_family').val();
	selectedHierarchy.order = $('#new_h_order').val();
	selectedHierarchy.class_ = $('#new_h_class').val();
	selectedHierarchy.phylum = $('#new_h_phylum').val();
	selectedHierarchy.kingdom = $('#new_h_kingdom').val();	
}
function layoutValidatingHierarchy(){
	$('#newHierarchyStep').hide();
	$('#loadingHierarchyStep').show();
	//$('#checkingNameStep').html(loadingTaxon + "<b>Validating taxon hierarchy...</b>");
}
/*
* VALID NAME
*/
function actionSelectValidName(){
	layoutSuggestionHierarchyInit();
	logicSelectValidName();	
}
function compareSuggestion() {
	if (suggestionHierarchyLocal.length != 0 && suggestionHierarchyCol.length != 0) {
		var aux = [];
            
		for (var i in suggestionHierarchyLocal) {		
			for (var j in suggestionHierarchyCol) {
				if (suggestionHierarchyLocal[i].kingdom == suggestionHierarchyCol[j].kingdom &&
					suggestionHierarchyLocal[i].phylum == suggestionHierarchyCol[j].phylum &&
					suggestionHierarchyLocal[i].class == suggestionHierarchyCol[j].class &&
					suggestionHierarchyLocal[i].order == suggestionHierarchyCol[j].order &&
					suggestionHierarchyLocal[i].family == suggestionHierarchyCol[j].family &&
					suggestionHierarchyLocal[i].genus == suggestionHierarchyCol[j].genus &&
					suggestionHierarchyLocal[i].subgenus == suggestionHierarchyCol[j].subgenus &&
					suggestionHierarchyLocal[i].specificepithet == suggestionHierarchyCol[j].specificepithet &&
					suggestionHierarchyLocal[i].infraspecificepithet == suggestionHierarchyCol[j].infraspecificepithet &&
					suggestionHierarchyLocal[i].scientificname == suggestionHierarchyCol[j].scientificname
				) {
					aux.push(i);
				}
			}
		}
		
		for (var i in aux) {
			suggestionHierarchyLocal[aux[i]] = null;
		}
		
		aux = [];
		
		for (var i in suggestionHierarchyLocal) {
			if (suggestionHierarchyLocal[i]) {
				aux.push(suggestionHierarchyLocal[i]);
			}
		}
		
		suggestionHierarchyLocal = aux;
		
		layoutSuggestionHierarchyShowLocal();		
	}
}
function logicSelectValidName(){
	suggestionHierarchyLocal = [];
	suggestionHierarchyCol = [];
	$.ajax({
    	type: 'POST',
        dataType: "json",
        url: 'index.php?r=taxonomictool/searchLocalHierarchy',
        data: {"term": selectedName.value, "rank":selectedName.rank, "source":selectedName.source}, 
        success: function(json){
        	if(json.sucess){
        		for(var i = 0; i < json.list.length; i++){
	        		var h = new Object();
	        		h.kingdom = json.list[i].kingdom;
	        		h.phylum = json.list[i].phylum;
		    		h.class_ = json.list[i].class_;
		    		h.order = json.list[i].order;
		    		h.family = json.list[i].family;
		    		h.genus = json.list[i].genus;
		    		h.subgenus = json.list[i].subgenus;
		    		h.specificepithet = json.list[i].specificepithet;
		    		h.infraspecificepithet = json.list[i].infraspecificepithet;
		    		h.scientificname = json.list[i].scientificname;
		    		h.colvalidation = json.list[i].colvalidation;
		    		h.count = json.list[i].count;
		    		suggestionHierarchyLocal.push(h);
	        	}	        	
        	}
			
			compareSuggestion();
        	
        	layoutSuggestionHierarchyShowLocal();        	        	   	
        }
    }); 
    $.ajax({
    	type: 'POST',
        dataType: "json",
        url: 'index.php?r=taxonomictool/searchColHierarchy',
        data: {"term": selectedName.value, "rank":selectedName.rank, "source":selectedName.source},
        success: function(json){  
            for(var h = 0; h < json.length; h++){
                var hAux = new Object();
		    	hAux.colvalidation = true;
		    	hAux.count = 0;
		    	
                for(var i = 0; i < json[h].length; i++){                 			    				    		                                               
                    for(var t = 0; t < json[h].length; t++){                                                
                        if(json[h][t].taxon=="Kingdom")
                            hAux.kingdom = json[h][t].name;     
		                else if(json[h][t].taxon=="Phylum")
		                    hAux.phylum = json[h][t].name;       
		                else if(json[h][t].taxon=="Class")
	                        hAux.class_ = json[h][t].name;        
                        else if(json[h][t].taxon=="Order")
							hAux.order = json[h][t].name; 
	                    else if(json[h][t].taxon=="Family")
		                	hAux.family = json[h][t].name;       
		                else if(json[h][t].taxon=="Genus")
	                        hAux.genus = json[h][t].name; 
		                else if(json[h][t].taxon=="Infraspecies")
		                    hAux.infraspecificepithet = json[h][t].name;  
	                    else if(json[h][t].taxon=="Species")
		                	hAux.scientificname = json[h][t].name;	                	
	                }	                
                }
                suggestionHierarchyCol.push(hAux);
            }
            
			compareSuggestion();
                            
            layoutSuggestionHierarchyShowCol(); 
        }
    });
}
function layoutSuggestionHierarchyShowCol(){
	$('#resultCol').html(''); 
	var hList = '';        	         	
	for(var i = 0; i < suggestionHierarchyCol.length; i++){        		        	
		var onClickHierarchy = suggestionHierarchyCol[i].colvalidation?"actionSelectHierarchy("+i+",'col');":"hierarchyValidation("+i+");"	    		    		
		var rec;	    		
		if (suggestionHierarchyCol[i].count == 1) {
			rec = " record ";
		}
		else {
			rec = " records ";
		}
		var h = "<li><a onclick=\""+onClickHierarchy+"\" ><b>"+(suggestionHierarchyCol[i].colvalidation?"Valid according to Catalog of Life.":"Not valid")+"</b>";
		h += "<br /><b>Kingdom:</b> "+(suggestionHierarchyCol[i].kingdom==null?'____':suggestionHierarchyCol[i].kingdom);
		h += "<br /><b>Phylum:</b> "+(suggestionHierarchyCol[i].phylum==null?'____':suggestionHierarchyCol[i].phylum);
		h += "<br /><b>Class:</b> "+(suggestionHierarchyCol[i].class_==null?'____':suggestionHierarchyCol[i].class_);
		h += "<br /><b>Order:</b> "+(suggestionHierarchyCol[i].order==null?'____':suggestionHierarchyCol[i].order);
		h += "<br /><b>Family:</b> "+(suggestionHierarchyCol[i].family==null?'____':suggestionHierarchyCol[i].family);
		h += "<br /><b>Genus:</b> "+(suggestionHierarchyCol[i].genus==null?'____':suggestionHierarchyCol[i].genus);
		h += "<br /><b>Subgenus:</b> "+(suggestionHierarchyCol[i].subgenus==null?'____':suggestionHierarchyCol[i].subgenus);
		h += "<br /><b>Specific epithet:</b> "+(suggestionHierarchyCol[i].specificepithet==null?'____':suggestionHierarchyCol[i].specificepithet);
		h += "<br /><b>Infraspecific epithet:</b> "+(suggestionHierarchyCol[i].infraspecificepithet==null?'____':suggestionHierarchyCol[i].infraspecificepithet);
		h += "<br /><b>Scientific name:</b> "+(suggestionHierarchyCol[i].scientificname==null?'____':suggestionHierarchyCol[i].scientificname);
		h += "</a></li>";        		
		hList += h;
	}
	$('#resultCol').html('<ul id="list">'+hList+'</ul>');
	if (suggestionHierarchyCol.length != 0) {
		$('#resultCol').addClass('scrollable');
	}          	
	scrollable('#resultCol'); 
}
function layoutSuggestionHierarchyShowLocal(){
	$('#resultLocal').html('');
	var hList = '';        	         	
	for(var i = 0; i < suggestionHierarchyLocal.length; i++){        		        	
		var onClickHierarchy = suggestionHierarchyLocal[i].colvalidation?"actionSelectHierarchy("+i+",'local');":"hierarchyValidation("+i+",'local');"	    		    		
		var rec;	    		
		if (suggestionHierarchyLocal[i].count == 1) {
			rec = " record ";
		}
		else {
			rec = " records ";
		}
		var h = "<li><a onclick=\""+onClickHierarchy+"\" ><b>"+(suggestionHierarchyLocal[i].colvalidation?"Valid":"Not valid")+"</b> - "+suggestionHierarchyLocal[i].count+rec+"using this hierarchy.";
		h += "<br /><b>Kingdom:</b> "+(suggestionHierarchyLocal[i].kingdom==null?'____':suggestionHierarchyLocal[i].kingdom);
		h += "<br /><b>Phylum:</b> "+(suggestionHierarchyLocal[i].phylum==null?'____':suggestionHierarchyLocal[i].phylum);
		h += "<br /><b>Class:</b> "+(suggestionHierarchyLocal[i].class_==null?'____':suggestionHierarchyLocal[i].class_);
		h += "<br /><b>Order:</b> "+(suggestionHierarchyLocal[i].order==null?'____':suggestionHierarchyLocal[i].order);
		h += "<br /><b>Family:</b> "+(suggestionHierarchyLocal[i].family==null?'____':suggestionHierarchyLocal[i].family);
		h += "<br /><b>Genus:</b> "+(suggestionHierarchyLocal[i].genus==null?'____':suggestionHierarchyLocal[i].genus);
		h += "<br /><b>Subgenus:</b> "+(suggestionHierarchyLocal[i].subgenus==null?'____':suggestionHierarchyLocal[i].subgenus);
		h += "<br /><b>Specific epithet:</b> "+(suggestionHierarchyLocal[i].specificepithet==null?'____':suggestionHierarchyLocal[i].specificepithet);
		h += "<br /><b>Infraspecific epithet:</b> "+(suggestionHierarchyLocal[i].infraspecificepithet==null?'____':suggestionHierarchyLocal[i].infraspecificepithet);
		h += "<br /><b>Scientific name:</b> "+(suggestionHierarchyLocal[i].scientificname==null?'____':suggestionHierarchyLocal[i].scientificname);
		h += "</a></li>";        		
		hList += h;
	}
	$('#resultLocal').html('<ul id="list">'+hList+'</ul>');
	if (suggestionHierarchyLocal.length != 0) {
		$('#resultLocal').addClass('scrollable');
	}          	
	scrollable('#resultLocal'); 
}
function layoutSuggestionHierarchyInit(){
	stepTaxon(0,1);
	$('#newHierarchyStep').hide();
	$('#suggestionHierarchyStep').html("<div class='sub'><div class='title'>Catalog of Life database</div><div id='resultCol'>"+loadingTaxon+"<b style='color: #F6A828'>Searching...</b></div></div><div class='sub'><div class='title'>Local database</div><div id='resultLocal'>"+loadingTaxon+"<b style='color: #F6A828'>Searching...</b></div></div><div class='sub' style='width: 632px;'><input type='button' onclick='actionNewHierarchy()' value='Create New Hierarchy'></input></div>");
	$(':button').button();	
	$('#suggestionHierarchyStep').show();
}
/*
* VALID HIERARCHY
*/
function hierarchyValidation(i,source){
	logicSelectHierarchy(i,source);
	$.ajax({
    	type: 'POST',
        dataType: "json",
        url: 'index.php?r=taxonomictool/hierarchyValidation',
        data: {
        	"kingdom": selectedHierarchy.kingdom,
        	"phylum": selectedHierarchy.phylum,
        	"class": selectedHierarchy.class_,
        	"order": selectedHierarchy.order,
        	"family": selectedHierarchy.family,
        	"genus": selectedHierarchy.genus,
        	"subgenus": selectedHierarchy.subgenus,
        	"infraspecies": selectedHierarchy.specificepithet,
        	"infraspecificepithet": selectedHierarchy.infraspecificepithet,
        	"scientificname": selectedHierarchy.scientificname
        },success: function(json){
        	selectedHierarchy.colvalidation = json;
        	layoutFormSetValues();
        	layoutForm();
        }
    });	
}
function setLocalHierarchy(h){
	alert('set os ids nos hiddens e os values nos text inputs '+i);
}
function actionSelectHierarchy(i, source){
	logicSelectHierarchy(i,source);
	layoutFormSetValues();
	layoutForm();
}
function logicSelectHierarchy(i, source){
	if(source=='col'){
		selectedHierarchy.kingdom = suggestionHierarchyCol[i].kingdom==undefined?"":suggestionHierarchyCol[i].kingdom;
		selectedHierarchy.phylum = suggestionHierarchyCol[i].phylum==undefined?"":suggestionHierarchyCol[i].phylum;
		selectedHierarchy.class_ = suggestionHierarchyCol[i].class_==undefined?"":suggestionHierarchyCol[i].class_;
		selectedHierarchy.order = suggestionHierarchyCol[i].order==undefined?"":suggestionHierarchyCol[i].order;
		selectedHierarchy.family = suggestionHierarchyCol[i].family==undefined?"":suggestionHierarchyCol[i].family;
		selectedHierarchy.genus = suggestionHierarchyCol[i].genus==undefined?"":suggestionHierarchyCol[i].genus;
		selectedHierarchy.subgenus = suggestionHierarchyCol[i].subgenus==undefined?"":suggestionHierarchyCol[i].subgenus;
		selectedHierarchy.specificepithet = suggestionHierarchyCol[i].specificepithet==undefined?"":suggestionHierarchyCol[i].specificepithet;
		selectedHierarchy.infraspecificepithet = suggestionHierarchyCol[i].infraspecificepithet==undefined?"":suggestionHierarchyCol[i].infraspecificepithet;
		selectedHierarchy.scientificname = suggestionHierarchyCol[i].scientificname==undefined?"":suggestionHierarchyCol[i].scientificname;
		
		taxonColvalidation.kingdom_colvalidation = suggestionHierarchyCol[i].kingdom==undefined?"":true;
		taxonColvalidation.phylum_colvalidation = suggestionHierarchyCol[i].phylum==undefined?"":true;
		taxonColvalidation.class_colvalidation = suggestionHierarchyCol[i].class_==undefined?"":true;
		taxonColvalidation.order_colvalidation = suggestionHierarchyCol[i].order==undefined?"":true;
		taxonColvalidation.family_colvalidation = suggestionHierarchyCol[i].family==undefined?"":true;
		taxonColvalidation.genus_colvalidation = suggestionHierarchyCol[i].genus==undefined?"":true;
		taxonColvalidation.subgenus_colvalidation = suggestionHierarchyCol[i].subgenus==undefined?"":true;
		taxonColvalidation.specificepithet_colvalidation = suggestionHierarchyCol[i].specificepithet==undefined?"":true;
		taxonColvalidation.infraspecificepithet_colvalidation = suggestionHierarchyCol[i].infraspecificepithet==undefined?"":true;
		taxonColvalidation.scientificname_colvalidation = suggestionHierarchyCol[i].scientificname==undefined?"":true;
		
		selectedHierarchy.count = 0;
		selectedHierarchy.colvalidation = true;
	}else{
		selectedHierarchy.kingdom = suggestionHierarchyLocal[i].kingdom==undefined?"":suggestionHierarchyLocal[i].kingdom;
		selectedHierarchy.phylum = suggestionHierarchyLocal[i].phylum==undefined?"":suggestionHierarchyLocal[i].phylum;
		selectedHierarchy.class_ = suggestionHierarchyLocal[i].class_==undefined?"":suggestionHierarchyLocal[i].class_;
		selectedHierarchy.order = suggestionHierarchyLocal[i].order==undefined?"":suggestionHierarchyLocal[i].order;
		selectedHierarchy.family = suggestionHierarchyLocal[i].family==undefined?"":suggestionHierarchyLocal[i].family;
		selectedHierarchy.genus = suggestionHierarchyLocal[i].genus==undefined?"":suggestionHierarchyLocal[i].genus;
		selectedHierarchy.subgenus = suggestionHierarchyLocal[i].subgenus==undefined?"":suggestionHierarchyLocal[i].subgenus;
		selectedHierarchy.specificepithet = suggestionHierarchyLocal[i].specificepithet==undefined?"":suggestionHierarchyLocal[i].specificepithet;
		selectedHierarchy.infraspecificepithet = suggestionHierarchyLocal[i].infraspecificepithet==undefined?"":suggestionHierarchyLocal[i].infraspecificepithet;
		selectedHierarchy.scientificname = suggestionHierarchyLocal[i].scientificname==undefined?"":suggestionHierarchyLocal[i].scientificname;
		selectedHierarchy.count = suggestionHierarchyLocal[i].count;
		selectedHierarchy.colvalidation = suggestionHierarchyLocal[i].colvalidation;
	}
}
function layoutFormSetValues(){
	$('#KingdomAR_kingdom').val(selectedHierarchy.kingdom);
	$('#PhylumAR_phylum').val(selectedHierarchy.phylum);
	$('#ClassAR_class').val(selectedHierarchy.class_);
	$('#OrderAR_order').val(selectedHierarchy.order);
	$('#FamilyAR_family').val(selectedHierarchy.family);
	$('#GenusAR_genus').val(selectedHierarchy.genus);
	$('#SubgenusAR_subgenus').val(selectedHierarchy.subgenus);
	$('#InfraspecificEpithetAR_infraspecificepithet').val(selectedHierarchy.infraspecificepithet);
	$('#SpecificEpithetAR_specificepithet').val(selectedHierarchy.specificepithet);
	$('#ScientificNameAR_scientificname').val(selectedHierarchy.scientificname);
	$('#TaxonRankAR_taxonrank').val(selectedName.rank);
	
	$('#KingdomAR_colvalidation').val(taxonColvalidation.kingdom_colvalidation);
	$('#PhylumAR_colvalidation').val(taxonColvalidation.phylum_colvalidation);
	$('#ClassAR_colvalidation').val(taxonColvalidation.class_colvalidation);
	$('#OrderAR_colvalidation').val(taxonColvalidation.order_colvalidation);
	$('#FamilyAR_colvalidation').val(taxonColvalidation.family_colvalidation);
	$('#GenusAR_colvalidation').val(taxonColvalidation.genus_colvalidation);
	$('#SubgenusAR_colvalidation').val(taxonColvalidation.subgenus_colvalidation);
	$('#InfraspecificEpithetAR_colvalidation').val(taxonColvalidation.infraspecificepithet_colvalidation);
	$('#SpecificEpithetAR_colvalidation').val(taxonColvalidation.specificepithet_colvalidation);
	$('#ScientificNameAR_colvalidation').val(taxonColvalidation.scientificname_colvalidation);
	
	compareHierarchies();
}
function loadSetValues(){
	selectedHierarchy.kingdom = $('#KingdomAR_kingdom').val();
	selectedHierarchy.phylum = $('#PhylumAR_phylum').val();
	selectedHierarchy.class_ = $('#ClassAR_class').val();
	selectedHierarchy.order = $('#OrderAR_order').val();
	selectedHierarchy.family = $('#FamilyAR_family').val();
	selectedHierarchy.genus = $('#GenusAR_genus').val();
	selectedHierarchy.subgenus = $('#SubgenusAR_subgenus').val();
	selectedHierarchy.infraspecificepithet = $('#InfraspecificEpithetAR_infraspecificepithet').val();
	selectedHierarchy.specificepithet = $('#SpecificEpithetAR_specificepithet').val();
	selectedHierarchy.scientificname = $('#ScientificNameAR_scientificname').val();
	selectedName.rank = $('#TaxonRankAR_taxonrank').val();
	
	if ($('#TaxonomicElementAR_colvalidation').val() == "1") {
    	selectedHierarchy.colvalidation = true;
    }
    
    compareHierarchies();
}
function layoutForm(){
	selectTaxonForm();
}

function saveTaxon() {
	loadSetValues();
	
	$.ajax({
        type: 'POST',
        dataType: "json",
        url: 'index.php?r=taxonomictool/save',
        data: {
            "kingdom": selectedHierarchy.kingdom,
            "phylum": selectedHierarchy.phylum,
            "class": selectedHierarchy.class_,
            "order": selectedHierarchy.order,
            "family": selectedHierarchy.family,
            "genus": selectedHierarchy.genus,
            "subgenus": selectedHierarchy.subgenus,
            "specificepithet": selectedHierarchy.specificepithet,
            "infraspecificepithet": selectedHierarchy.infraspecificepithet,
            "scientificname": selectedHierarchy.scientificname,
            
            "kingdom_colvalidation": taxonColvalidation.kingdom_colvalidation,
            "phylum_colvalidation": taxonColvalidation.phylum_colvalidation,
            "class_colvalidation": taxonColvalidation.class_colvalidation,
            "order_colvalidation": taxonColvalidation.order_colvalidation,
            "family_colvalidation": taxonColvalidation.family_colvalidation,
            "genus_colvalidation": taxonColvalidation.genus_colvalidation,
            "subgenus_colvalidation": taxonColvalidation.subgenus_colvalidation,
            "specificepithet_colvalidation": taxonColvalidation.specificepithet_colvalidation,
            "infraspecificepithet_colvalidation": taxonColvalidation.infraspecificepithet_colvalidation,
            "scientificname_colvalidation": taxonColvalidation.scientificname_colvalidation,
            
            "taxonrank": selectedName.rank
        },
        success: function(json) {        	
        	if (json.kingdom.ar) {
        		$('#KingdomAR_kingdom').val(json.kingdom.ar.kingdom);
        		$('#TaxonomicElementAR_idkingdom').val(json.kingdom.ar.idkingdom);
        	}
        	else {
        		$('#KingdomAR_kingdom').val("");
        		$('#TaxonomicElementAR_idkingdom').val("");
        	}
        	
        	if (json.phylum.ar) {
        		$('#PhylumAR_phylum').val(json.phylum.ar.phylum);
        		$('#TaxonomicElementAR_idphylum').val(json.phylum.ar.idphylum);
        	}
        	else {
        		$('#PhylumAR_phylum').val("");
        		$('#TaxonomicElementAR_idphylum').val("");
        	}
        	
        	if (json.class.ar) {
        		$('#ClassAR_class').val(json.class.ar.class);
        		$('#TaxonomicElementAR_idclass').val(json.class.ar.idclass);
        	}
        	else {
        		$('#ClassAR_class').val("");
        		$('#TaxonomicElementAR_idclass').val("");
        	}
        	
        	if (json.order.ar) {
        		$('#OrderAR_order').val(json.order.ar.order);
        		$('#TaxonomicElementAR_idorder').val(json.order.ar.idorder);
        	}
        	else {
        		$('#OrderAR_order').val("");
        		$('#TaxonomicElementAR_idorder').val("");
        	}
        	
        	if (json.family.ar) {
        		$('#FamilyAR_family').val(json.family.ar.family);
        		$('#TaxonomicElementAR_idfamily').val(json.family.ar.idfamily);
        	}
        	else {
        		$('#FamilyAR_family').val("");
        		$('#TaxonomicElementAR_idfamily').val("");
        	}
        	
        	if (json.genus.ar) {
        		$('#GenusAR_genus').val(json.genus.ar.genus);
        		$('#TaxonomicElementAR_idgenus').val(json.genus.ar.idgenus);
        	}
        	else {
        		$('#GenusAR_genus').val("");
        		$('#TaxonomicElementAR_idgenus').val("");
        	}
        	
        	if (json.subgenus.ar) {
        		$('#SubgenusAR_subgenus').val(json.subgenus.ar.subgenus);
        		$('#TaxonomicElementAR_idsubgenus').val(json.subgenus.ar.idsubgenus);
        	}
        	else {
        		$('#SubgenusAR_subgenus').val("");
        		$('#TaxonomicElementAR_idsubgenus').val("");
        	}
        	
        	if (json.specificepithet.ar) {
        		$('#SpecificEpithetAR_specificepithet').val(json.specificepithet.ar.specificepithet);
        		$('#TaxonomicElementAR_idspecificepithet').val(json.specificepithet.ar.idspecificepithet);
        	}
        	else {
        		$('#SpecificEpithetAR_specificepithet').val("");
        		$('#TaxonomicElementAR_idspecificepithet').val("");
        	}
        	
        	if (json.infraspecificepithet.ar) {
        		$('#InfraspecificEpithetAR_infraspecificepithet').val(json.infraspecificepithet.ar.infraspecificepithet);
        		$('#TaxonomicElementAR_idinfraspecificepithet').val(json.infraspecificepithet.ar.idinfraspecificepithet);
        	}
        	else {
        		$('#InfraspecificEpithetAR_infraspecificepithet').val("");
        		$('#TaxonomicElementAR_idinfraspecificepithet').val("");
        	}
        	
        	if (json.scientificname.ar) {
        		$('#ScientificNameAR_scientificname').val(json.scientificname.ar.scientificname);
        		$('#TaxonomicElementAR_idscientificname').val(json.scientificname.ar.idscientificname);
        	}
        	else {
        		$('#ScientificNameAR_scientificname').val("");
        		$('#TaxonomicElementAR_idscientificname').val("");
        	}
        	
        	if (json.taxonrank.ar) {
        		$('#TaxonRankAR_taxonrank').val(json.taxonrank.ar.taxonrank);
        		$('#TaxonomicElementAR_idtaxonrank').val(json.taxonrank.ar.idtaxonrank);
        	}
        	else {
        		$('#TaxonRankAR_taxonrank').val("");
        		$('#TaxonomicElementAR_idtaxonrank').val("");
        	}
        	
        	if (selectedHierarchy.colvalidation) {
				$('#TaxonomicElementAR_colvalidation').val("1");
			}
			else {
				$('#TaxonomicElementAR_colvalidation').val("");
			}		
			
			saveLocation();	        	
        }
    });
}
