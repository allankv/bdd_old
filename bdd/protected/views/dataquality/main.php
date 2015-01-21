<?php include_once("protected/extensions/config.php"); 
?>

<link href="css/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="css/bootstrap/css/ui-lightness/jquery-ui-1.10.3.custom.css" rel="stylesheet">
<script type="text/javascript" src="js/List.js"></script>	
<script type="text/javascript" src="js/DataQuality.js"></script>
<script type="text/javascript" src="js/highcharts.js"></script>

<link rel="stylesheet" href="css/dataquality.css" type="text/css" media="screen" charset="utf-8" />

<style>
	.ui-dialog .ui-dialog-buttonpane { 
	    text-align: center;
	}
	.ui-dialog .ui-dialog-buttonpane .ui-dialog-buttonset { 
	    float: none;
	}
	
	li.ui-state-processing a {
  	 target:pointer !important;
	}

	.ui-tabs-selected{
	 	target:pointer !important;
	}

.tip-twitter {
	width: auto !important;
	max-width: 1200px !important;

}


</style>


<div id="contentall">

<div class="introText">
	
	<h1 class="title-dq"><?php echo Yii::t('yii', 'BDD Data Quality Improvement'); ?></h1>
	<div style="clear:both;"></div>
	<br/>
	<div class="ProcessInformation ">
			<table class="list">
					<tr> <td id="left"> Process ID:</td> <td> <div class="processId"> </div> </td></tr>
					<tr> <td id="left" > Start:</td>  <td> <div class="processDate"> </div></td> </tr>
					<tr> <td id="left" > Finish:</td>  <td> <div class="processDateF"> </div></td> </tr>
					<tr> <td id="left"> User</td> <td> <div class="processUser"> </div> </td> </tr>
					
			</table>
			
			<div class="executeButton">
				<button type="button" class="btn btn-warning btn-lg" id="StartButton"><div class="textbt"> </div></button>
				<div class='divLoadInit'> Aguarde a leitura dos dados...</div>
															
			</div>
					
			
	</div>
	<br/>
	<br/>
</div>




<div id="accordion" class ="accordion" style="display:none">
	<?php 
		
		$dqTypes = DataQualityTypesAR ::model()->findAll(array("order"=>"id"));
		if (is_array($dqTypes)){
			foreach($dqTypes as $dq){
			  if ($dq->id!=9){
					
		?>
				<h3 index="<?php echo $dq->id;?>"><div class="sectionHeader" id="section1"> <?php echo $dq->description; ?></div> </h3>
				<div class="accordionContent">
					  <?php
					  	 	if ($dq->id !=2){ 
					            echo Yii::app()->controller->renderPartial('/dataquality/list', 
					            		array('tipo'=>$dq->id,'title_table'=>'Taxonomic elements'));
					  	 	}
					  	 	else if ($dq->id==2){ 
					            echo Yii::app()->controller->renderPartial('/dataquality/taxons_incorrect', 
					            		array('tipo'=>$dq->id,'title_table'=>'Names'));
					  	 	}
					  	 	else {
					  	 		echo '<div style="margin-left:50px;"> under construction. </div>';	
					  	 	}
				      ?>
			
				</div>
		
	<?php }}}?>
</div>

<br/> <br/>

<div id="dialogCheck" title="Location Elements" style="display:none;">
	
	<div id="contentDialogCheck"> location</div>
</div>

<div id="dialogAlert" title="No Information" style="display:none;">
	
	<div id="contentDialogAlert"> no location</div>
</div>
	 
<div id="dialogStart" title="BDD Data Quality Improvement" style="display:none;">
	
	<div id="contentDialogStart"> start</div>
</div>
 
<div id="dialogSugestions" title="Sugestions" style="display:none;">
	
	<div id="contentDialogSugestions"> teste ;</div>
</div>

<div id="dialogTaxonHierarchySugestions" title="Sugestions" style="display:none;">
	
	<div id="contentTaxonHierarchySugestions"> teste ;</div>
</div>


<div id="dialogUndo" title="Undo" style="display:none;">
	
	<div id="contentDialogUndo"> teste ;</div>
</div>

<div id="openAlertListSpecimens"  title="Specimens" style="display:none"; >
		<div id="openAlertListSpecimens"> No Specimens </div>
</div>

<div id="listSpecimens"  title="Specimens" style="display:none"; >
	<div id="contentListSpecimens"> No Specimens </div>
</div>

<div id="dialogCheckDatum" title="Geodetic Datum" style="display:none;">
	
	<div id="contentDialogCheckDatum"> location</div>
</div>
<div id="dialogCheckCoordinateUncertainty" title="Coordinate Uncertainty" style="display:none;">
	
	<div id="contentDialogCheckCoordinateUncertainty"> location</div>
</div>

<div id="dialogCheckTaxonHierarchy" title="Taxon Hierarchy" style="display:none;">
	
	<div id="contentDialogCheckTaxonHierarchy"> TaxonHierarchy</div>
</div>
<div id="dialogSugestNamesLessSpecifics" title="Sugestions" style="display:none;">
	
	<div id="contentSugestNamesLessSpecifics"> teste ;</div>
</div>


<div class= "uncertaintymeters"  idSP="0" idDQ="0" id="uncertaintymeters"> </div>
<script>

$(function () {
	$( "#accordion" ).accordion({
	      	  heightStyle: "content",
	    	  event: "click",
	          active: false,
	          collapsible: true,
	          autoHeight: false
	          //active: activeIndex
	    });
	 
});

</script>


<script>

//openDialogTaxonHierarchySugestions(108,3);





var dialogStart = 1;
var taskinit = 1;
var taskend = 9;
$(function () {
	
	$('#accordion').hide();
	$(".divLoadInit").hide();

	//updateDatumSugestions(162,8);
	
	getProcessInformation();
	
	$( "#StartButton" ).click(function() {

		createProcess();
	
    });

	
	

});


var start = 0;
var end = 10;
var max = 10;
var interval = 10;
var handleSize = 50;
var arrayOut = null;
var lasttask = 8;
var totalTasks = 4;
var tempIdDQ = 0;


/////Start Process

function getProcessInformation(){
	$('#accordion').hide();
	$(".divLoadInit").hide();
	$(".textbt").html('Restart');
	
	$.ajax({
    	type:'POST',
        url:'index.php?r=dataquality/GetProcessInformation',
        dataType: "json",
        //async: false,
        success:function(json) {
               rs = json;
               if (rs!=0){
           		$(".processId").html(rs[0].id);
           		$(".processDate").html(rs[0].start);
           		$(".processDateF").html(rs[0].finish );
           		$(".processNSP").html(rs[0].nSP  );
           		$(".processUser").html(rs[0].user);
           		$(".textbt").html('Restart');

           		executeTasks();

           		$('#accordion').show();

           	}
           	else{
           		$('#accordion').hide();
           		$(".divLoadInit").hide();
           		$(".textbt").html('Start');
           		alert('Execute the Process');
           		
           		//exit;
           	}
        }
 
    });

	
	
    //console.log(rs);
	
}

function executeTasks(google){
	$("#StartButton").hide();
	$(".divLoadInit").show();
	
	for(var i=taskinit;i<taskend;i++){
		bootSpecimen(i);
	}

	
	if (google == 1){
		alert('Limite de consultas ao Google foi excedido. Tente novamente outro dia.');
	}
	$("#StartButton").show();
	$(".divLoadInit").hide();
}

function doTask(task,process_id){
	var rs = -1;
	$.ajax({
    	type:'POST',
        url:'index.php?r=dataquality/DoTask',
        data: {'task':task,'process_id':process_id},
        dataType: "json",
        async: false,
        success:function(json) {
               rs = json;
        }
 
    });

    return rs;
}
function createProcess(){
	var rs = 0;
	$.ajax({
    	type:'POST',
        url:'index.php?r=dataquality/StartProcess',
        dataType: "json",
        //async: false,
        success:function(json) {
               rs = json;
               
               startProcess(rs);
        }
 
    });
    
    return rs;
	
}

/*function terminateProcess(process_id){

	$.ajax({
    	type:'POST',
        url:'index.php?r=dataquality/UpdateProcess',
        data: {'process_id':process_id},
        dataType: "json",
        async: false,
        success:function(json) {
               rs = json;
        }
 
    });
    return rs;
	
}*/



function startProcess(process_id){
	$(".divLoadInit").show();
	$("#StartButton").hide();
	
	var rs = 0;
	var google = 0;
	///loop de tarefas
	$('#accordion').hide();
	for(var i=1;i<9;i++){

		//if (i!=2){
			task = i;
			$(".divLoadInit").html('Wait task '+task+'/8 to load' );
			//create process
			rs = doTask(task,process_id);
					
			if (rs == -9){
				google = 1;
			}
		//}
			
		
	}
	
   //dados do proceso
	getProcessInformation();

   

    //leitura dos dados
    executeTasks(1);
    $("#StartButton").show();
    openDialogStart();
    $(".divLoadInit").hide();

    
	  
	
}




/////End Process
/////---------ALL CORRECTIONS ---------------///

function listSpecimenToCorrection(idDQ){
	$('.list').show();
	var rs = 0;
	var boot_ret = 0;
	
	if (idDQ!=2){
			var rs1 = 0;
			var rs_continue =0;
		
		    $.ajax({
		    	type:'POST',
		        url:'index.php?r=dataquality/ListSpecimensDQ',
		        data: {'idDQ':idDQ,'list':jFilterList},
		        dataType: "json",
		        async: false,
		        success:function(json) {
		            var rs = new Object();
		                rs = json.result;
		                
		                rs1 = 1;
		                ///para cada especie
		                for(var i in rs) {   
		              	    if (idDQ == 1){
								updateCoordinates(rs[i].id); ///altera as coordenadas
		              	    }
		              	    else if ((idDQ == 5)){
									updateLocality(rs[i].id,idDQ); ///altera as cidadades
			              	    }
		              	   else if (idDQ == 8){
								updateDatum(rs[i].id,idDQ); ///altera o datum
		              	    }
		              	  else if (idDQ == 6){
								updateTaxonHierarchy(rs[i].id,idDQ); ///altera os valores dos taxos
		              	    }

		              	    
		              	 }
							
		                
		        }	
		        
		    });
		  
		  if (rs1==1){
			
			 setTimeout(function(){
				 boot_ret = bootSpecimen(idDQ);
			 },5000);
		  } 
	}
	else if (idDQ == 2){

		boot_ret = listIncorrectTaxons(1,idDQ);
		

	}
	

  if (boot_ret==1){
  	return 1;
  }
}

///////////------END ALL CORRECTIONS -----------/////

////-----------COORDINATESlistIncorrectTaxons -----------////

function bootSpecimen(idDQ){

	
	
	if (idDQ!=2){
		 var filter_ret = filter('filter',idDQ);
		 //alert(filter_ret);
	
		return 1;
	} else {

	 	boot_ret = listIncorrectTaxons(1,idDQ);
	 	//$('#accordion').show();
	 	return 1;
	}
}


function logVerify(idSP,idDQ){

	var rs = 0;
	
	$.ajax({
    	type:'POST',
        url:'index.php?r=dataquality/LogSearch',
        data: {'id_specimen':idSP,'idDQ':idDQ},
        dataType: "json",
        async: false,
        success:function(json) {
               rs = json;
        }
 
    });
	
    return rs;
	
    
	
}

function sugestionsLocality(idSP){

	///vai procurar as coordenadas e vai atualizar de uma em uma as localidades
	var rs = 0;
	 $.ajax({
	    	type:'POST',
	        url:'index.php?r=dataquality/SugestionsLocality',
	        data: {'id_specimen':idSP},
	        dataType: "json",
	        async: false,
	        success:function(json) {
	            rs = json;
				
	    	}
	  });
	 return rs; 

}

function sugestionsCoordinates(idSP){

	///vai procurar as coordenadas e vai atualizar de uma em uma as localidades
	var rs = 0;
	 $.ajax({
	    	type:'POST',
	        url:'index.php?r=dataquality/SugestionsCoordinates',
	        data: {'id_specimen':idSP},
	        dataType: "json",
	        async: false,
	        success:function(json) {
	            rs = json;
				
	    	}
	  });
	 return rs; 

}

$("#dialogStart").dialog({
	dialogClass: "no-close",
    autoOpen: false,
    resizable: false,
    height:200,
    modal: true,
    beforeopen: function (event, ui) { 
    	$(".no-close .ui-dialog-titlebar-close").css("display","none");
     },
     position: {
			my: "center",
			at: "center",
			of: window
		},
    buttons: {
        Ok: function() {
            
            $(this).dialog('close');
        }
    }
});

function openDialogStart(){
	$("#contentDialogStart").html('The process has been successfully completed.');
	$("#dialogStart").dialog('open');

  	
}

function filterOutliers(){
	var ret  = 0;
	
	var spArray = [];
    $.ajax({
    	type:'POST',
        url:'index.php?r=dataquality/filter',
        data: {'idDQ':4,'limit':'null', 'offset':0, 'list':jFilterList},
        dataType: "json",
        async: false,
        success:function(json) {
        	var rs = new Object();
             rs = json.result;
             for(var i in rs) { 

            	
                 var ret = getCoordinateOutliers(rs[i].id);
         	     if (ret == 1){
                	 //console.log(rs[i].id);
                	 spArray.push(rs[i].id);
                 }
             }
			
		
            
        }
    });

    console.log(spArray);
    return spArray;

	
}

function getCoordinateOutliers(id_specimen){
	var ret  = 0;
	var rs = new Object();
    $.ajax({
    	type:'POST',
        url:'index.php?r=dataquality/GetCoordinateOutliers',
        data: {'id_specimen':id_specimen},
        dataType: "json",
        async: false,
        success:function(json) {
           
             rs = json;
             
			
		
            
        }
    });
    return rs;

	
}

function filter(filter,idDQ,rs_continue){

	
	var idDQ_filter = idDQ>0?idDQ:tempIdDQ;
	console.log('Tarefa '+idDQ_filter);
	$(".divLoadInit").html('Wait task '+idDQ+'/8 to load' );
	$("#StartButton").html('Restart' );
			
	action = 'filter';
	arrayOut = null;

	
	//alert(arrayOut.length);
	if ((idDQ == 99) && (arrayOut.length<1)){
			//alert('Consulta Vazia');
			$('#divTableList4').hide();
			//$('#noResults').show();
	}
	else {
		$('#noResults'+idDQ).hide();
		//console.log(arrayOut);
		//alert(action);
		var ret  = 0;
		var numReg = 0;
	    $.ajax({
	    	type:'POST',
	        url:'index.php?r=dataquality/'+action,
	        data: {'idDQ':idDQ_filter,'limit':interval, 'offset':start, 'list':jFilterList, 'arrayOut': arrayOut},
	        dataType: "json",
	        async: true,
	        success:function(json) {
	            var rs = new Object();
	            $(".lines"+idDQ_filter).html('');
				
	            max = parseInt(json.count);

	            numReg = max;
	            //console.log(json);
	            			
	            if (start > max) {
	            	start = 0;
	            }
	
	            $('#start'+idDQ_filter).html(start);
	
	            end = start + interval;
	
	            if (end > max) { 
	            	end = max;
	            }
	
	            $('#end'+idDQ_filter).html(end);
	            $('#max'+idDQ_filter).html(max);
	
	            rs = json.result;
	            //console.log(rs);
				
			
	            slider(idDQ_filter);
	
	           
	            //console.log(idDQ);
				
	            for(var i in rs) {    

					  insertLine(rs[i],idDQ_filter,rs[i].sugestion);
	            }
	            
	    		
	           //$(".divLoadInit").hide();
	            
				
	
	        }
	    });

	    //graphs(idDQ_filter);
	    //return numReg;
	}

	  
}

$("#dialogCheck").dialog({
	
    autoOpen: false,
    resizable: false,
    height:200,
    modal: true,
    beforeopen: function (event, ui) { 
    	$(".no-close .ui-dialog-titlebar-close").css("display","none");
     },
    position: {
			my: "left top",
			at: "right top",
			of: "#tablelist"
		} ,
     buttons: {
		        Ok: function() {
		            $(this).dialog('close');
               }
     }
   
});


$("#dialogAlert").dialog({
	dialogClass: "no-close",
    autoOpen: false,
    resizable: false,
    height:200,
    modal: true,
    beforeopen: function (event, ui) { 
    	$(".no-close .ui-dialog-titlebar-close").css("display","none");
     },
     position: {
			my: "left top",
			at: "right top",
			of: "#tablelist"
		},
    buttons: {
        Ok: function() {
            $(this).dialog('close');
        }
    }
});

$("#dialogSugestion").dialog({
	dialogClass: "no-close",
    autoOpen: false,
    resizable: false,
    height:200,
    modal: true,
    beforeopen: function (event, ui) { 
    	$(".no-close .ui-dialog-titlebar-close").css("display","none");
     },
     position: {
			my: "left top",
			at: "right top",
			of: "#tablelist"
		},
    buttons: {
        Ok: function() {
            $(this).dialog('close');
        }
    }
});



function openDialogAlert(idDQ){

		if ((idDQ == 3)||(idDQ == 6)){
			$("#contentDialogAlert").html('Specimen Name was not found.');
		}
		else {
			$("#contentDialogAlert").html('No information');
		}
	    
		
		$("#dialogAlert").dialog('open');

  	
}



$("#dialogSugestions").dialog({
	dialogClass: "no-close",
    autoOpen: false,
    resizable: true,
    //height:500,
    width:600,
    modal: true,
    beforeopen: function (event, ui) { 
    	$(".no-close .ui-dialog-titlebar-close").css("display","none");
     },
     position: {
			my: "center",
			at: "center",
			of: window
		},
    buttons: {
        Ok: function() {
            $(this).dialog('close');
        }
    }
});

$("#dialogListSpecimens").dialog({
	dialogClass: "no-close",
    autoOpen: false,
    resizable: false,
    height:500,
    width:600,
    modal: true,
    beforeopen: function (event, ui) { 
    	$(".no-close .ui-dialog-titlebar-close").css("display","none");
     },
     position: {
			my: "center",
			at: "center",
			of: window
		},
    buttons: {
        Ok: function() {
            $(this).dialog('close');
        }
    }
});



function openDialogUpdateLocalitySugestions(idSP,idDQ){
	var array_sugestions = sugestionsLocality(idSP);

	var html = '';
	$.each(array_sugestions, function(index, val) {
		country = val.idcountry;
		locality = val.idmunicipality;
		state = val.idstateprovince;
		rcountry = val.country;
		rlocality = val.municipality;
		rstate = val.state;
		
	});
	
	
	var rs = 0;
	 $.ajax({
	    	type:'POST',
	        url:'index.php?r=dataquality/UpdateLocality',
	        data: {'idDQ':idDQ,'id_specimen':idSP,'country':country,'locality':locality,'state':state},
	        dataType: "json",
	        async: false,
	        success:function(json) {
	            rs = json;
	            if (rs == 1){
					alert('The locality has been successfully updated.');
	            }
	            else{
	            	alert('There was an error to update the locality.');
	            }
				
	    	}
	  });
	//idDQ = 4;
	if (rs==1){
		var htmlAux = "<div class='classChange_"+idDQ+idSP+"'>";
		var fechaHtmlAux = "</div>";
		var btnShow = "<div class='btnShow'><a href='index.php?r=specimen/goToShow&id="+rs.id+"'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Show Specimen Record'><span class='ui-icon ui-icon-search'></span></li></ul></a></div>";
	   // var btnCheck = "<div class='btnCheck' id=\"btnCheck"+idDQ+"_"+idSP+"\"><a onclick=\"openDialogCheck("+idSP+","+idDQ+");\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Corrections OK'><span class='ui-icon ui-icon-check'></span></li></ul></a></div>";
    	var btnCheck = "<div class='btnCheck'id=\"btnCheck"+idDQ+"_"+idSP+"\"><a><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Corrections OK'><span class='ui-icon ui-icon-check'></span></li></ul></a></div>";
	    
	   // var btnUndo = "<div class='btnUndo' id=\"btnUndo"+idDQ+"_"+idSP+"\"><a onclick=\"openDialogUndoCorrections("+idSP+","+idDQ+");\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Undo'><span class='ui-icon ui-icon-arrowreturnthick-1-s'></span></li></ul></a></div>";
	    $(".classChange_"+idDQ+idSP).replaceWith(htmlAux+btnShow+btnCheck+fechaHtmlAux);
	}
	
	 $("#dialogSugestions").dialog('close');

	 //openDialogCheckLocality(rs.municipality,rs.stateprovince,rs.country,+idSP,idDQ);
	 //check
	 var rs = new Array();
	 var rs = {
			municipality: locality,
			stateprovince: state,
			country: country
		};

	    var btnUndo = "<div class='btnUndo' id=\"btnUndo"+idDQ+"_"+idSP+"\"><a onclick=\"openDialogUndoCorrections("+idSP+","+idDQ+");\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Undo'><span class='ui-icon ui-icon-arrowreturnthick-1-s'></span></li></ul></a></div>";
		var html = tipCheckTask(idDQ,idSP,rs);
		//html = '<table> <tr> <td align="center">'+'<div class="tipTask1">'+ btnUndo+'</div>'+'</td> </tr> </table>';
		html = html + '<br/>'+'<div class="tipTask1">'+ btnUndo+'</div>';
		var idTip=idDQ+"_"+idSP;
		
		$('#btnCheck'+idTip).poshytip({
			className: 'tip-twitter',
			showOn: 'hover',
			content: html,
			alignTo: 'target',
			alignX: 'center',
			alignY: 'bottom',
			offsetX: 5,
			offsetY: 5,
			allowTipHover: true,
			fade: false,
			slide: false
     });
	     
	 graphs(idDQ);
	 return rs;
	
}

function openDialogUpdateSugestions(latitude,longitude,idSP,idDQ){
	
	var rs = 0;
	 $.ajax({
	    	type:'POST',
	        url:'index.php?r=dataquality/UpdateCoordinatesSugestions',
	        data: {'id_specimen':idSP,'latitude':latitude,'longitude':longitude},
	        dataType: "json",
	        async: false,
	        success:function(json) {
	            rs = json;
	            if (rs == 1){
					alert('The coordinate has been successfully updated.');
	            }
	            else{
	            	alert('There was an error to update the coordinates.');
	            }
				
	    	}
	  });

	if (rs==1){
		var htmlAux = "<div class='classChange_"+idDQ+idSP+"'>";
		var fechaHtmlAux = "</div>";
		var btnShow = "<div class='btnShow'><a href='index.php?r=specimen/goToShow&id="+idSP+"'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Show Specimen Record'><span class='ui-icon ui-icon-search'></span></li></ul></a></div>";
	    var btnCheck = "<div class='btnCheck' id=\"btnCheck"+idDQ+"_"+idSP+"\"><a><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' ><span class='ui-icon ui-icon-check'></span></li></ul></a></div>";
	    var btnUndo = "<div class='btnUndo' id=\"btnUndo"+idDQ+"_"+idSP+"\"><a onclick=\"openDialogUndoCorrections("+idSP+","+idDQ+");\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Undo'><span class='ui-icon ui-icon-arrowreturnthick-1-s'></span></li></ul></a></div>";


	    
	    $(".classChange_"+idDQ+idSP).replaceWith(htmlAux+btnShow+btnCheck+fechaHtmlAux);

	    $("#dialogSugestions").dialog('close');
	    
	  //check
		var html = tipCheckTask(idDQ,idSP);
		//html = '<table> <tr> <td align="center">'+'<div class="tipTask1">'+ btnUndo+'</div>'+'</td> </tr> </table>';
		html = html + '<br/>'+'<div class="tipTask1">'+ btnUndo+'</div>';
		var idTip=idDQ+"_"+idSP;
		
		$('#btnCheck'+idTip).poshytip({
			className: 'tip-twitter',
			//hideTimeout: 1200,
			//showTimeout: 500, 
			showOn: 'hover',
			content: html,
			alignTo: 'target',
			alignX: 'center',
			alignY: 'bottom',
			offsetX: 5,
			offsetY: 5,
			allowTipHover: true,
			fade: false,
			slide: false
        });

		        
        
	}
	
	

	 graphs(1);
	 return rs;
	
}

function tipSugestions(idDQ,idSP){

	
	if (idDQ==1){

		var array_sugestions = sugestionsCoordinates(idSP);

	
		var html = '';
		$.each(array_sugestions, function(index, val) {
			var content = '';
			html = html + '<div id="'+idSP+'">';
			content = val.formatted_address+' - Lat: '+val.latitude +' - Long: '+val.longitude;
			html = html +"<a class=\"link_sugestion\" onclick=\"openDialogUpdateSugestions("+val.latitude+","+val.longitude+","+idSP+","+idDQ+");\">"+content+"</a>";
			html = html+"</div>";
			
		});
		return html;
	}
	else if ((idDQ==4)||(idDQ==5)){
		var array_sugestions = sugestionsLocality(idSP);
		var html = '';
		$.each(array_sugestions, function(index, val) {
			var content = '';
			html = html + '<div id="'+idSP+'">';
			content = val.formatted_address;
			//html = html +"<a class=\"link_sugestion\" onclick=\"openDialogUpdateSugestions("+val.latitude+","+val.longitude+","+idSP+","+idDQ+");\">"+content+"</a>";
			html = html +"<a class=\"link_sugestion\" onclick=\"openDialogUpdateLocalitySugestions("+idSP+","+idDQ+");\">"+content+"</a>";
			html = html+"</div>";
			
		});
		return html;
		
	}


}


$("#dialogTaxonHierarchySugestions").dialog({
	dialogClass: "no-close",
    autoOpen: false,
    resizable: true,
    //height:500,
    width:600,
    modal: true,
    beforeopen: function (event, ui) { 
    	$(".no-close .ui-dialog-titlebar-close").css("display","none");
     },
     position: {
			my: "center",
			at: "center",
			of: window
		},
    buttons: {
    	Save: function() {
            //$(this).dialog('close');
    		var idSP = $(this).data('idSP');
    		var ret = updateTaxonHierarchy(idSP,3);
    		//alert(ret);
    		
    		if (ret == 1){
				alert('The Hierarchy has been successfully updated.');

				///mostrar botaão undo
				var idDq = 3;
				var htmlAux = "<div class='classChange_"+idDq+idSP+"'>";
			        		var fechaHtmlAux = "</div>";
			     var array_fields = getLocalTaxonHierarchy(idSP,idDq);
			
			     var fields = array_fields[0].genus+'|'+array_fields[0].family+'|'+array_fields[0].order+'|'+array_fields[0].class+'|'+array_fields[0].phylum+'|'+array_fields[0].kingdom;
			    	   
			      var btnShow = "<div class='btnShow'><a href='index.php?r=specimen/goToShow&id="+idSP+"' target='_blank'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Show Specimen Record'><span class='ui-icon ui-icon-search'></span></li></ul></a></div>";
			      var btnCheck = "<div class='btnCheck' id=\"btnCheck"+idDq+"_"+idSP+"\"><a onclick=\"openDialogCheckTaxonHierarchy('"+fields+"'"+","+idSP+","+idDq+");\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Corrections OK'><span class='ui-icon ui-icon-check'></span></li></ul></a></div>";
			      var btnUndo = "<div class='btnUndo' id=\"btnUndo\"><a onclick=\"openDialogUndoCorrections("+idSP+","+idDq+");\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Undo'><span class='ui-icon ui-icon-arrowreturnthick-1-s'></span></li></ul></a></div>";	
	
			     $(".classChange_"+idDq+idSP).replaceWith(htmlAux+btnShow+btnCheck+btnUndo+fechaHtmlAux);
			     graphs(idDq);       		
				$(this).dialog('close');
    		}
    		else {
    			alert('There was an error to update the hierarchy.');
    			$(this).dialog('close');
    		}
    		
        },
        Cancel: function() {
            $(this).dialog('close');
        }
    }
});



$("#dialogSugestNamesLessSpecifics").dialog({
	dialogClass: "no-close",
    autoOpen: false,
    resizable: true,
    //height:500,
    width:600,
    modal: true,
    beforeopen: function (event, ui) { 
    	$(".no-close .ui-dialog-titlebar-close").css("display","none");
     },
     position: {
			my: "center",
			at: "center",
			of: window
		},
    buttons: {
    	Save: function() {
            //$(this).dialog('close');
    		var idSP = $(this).data('idSP');
    		var ret = updateTaxonHierarchy(idSP,6);
    		//alert(ret);
    		
    		if (ret == 1){
				alert('The data has been successfully updated.');

				///mostrar botaão undo
				var idDq = 6;
				var htmlAux = "<div class='classChange_"+idDq+idSP+"'>";
			        		var fechaHtmlAux = "</div>";
			     var array_fields = getLocalTaxonHierarchy(idSP,idDq);
			
			     var fields = array_fields[0].genus+'|'+array_fields[0].family+'|'+array_fields[0].order+'|'+array_fields[0].class+'|'+array_fields[0].phylum+'|'+array_fields[0].kingdom;
			    	   
			      var btnShow = "<div class='btnShow'><a href='index.php?r=specimen/goToShow&id="+idSP+"' target='_blank'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Show Specimen Record'><span class='ui-icon ui-icon-search'></span></li></ul></a></div>";
			      var btnCheck = "<div class='btnCheck' id=\"btnCheck"+idDq+"_"+idSP+"\"><a onclick=\"openDialogCheckTaxonHierarchy('"+fields+"'"+","+idSP+","+idDq+");\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Corrections OK'><span class='ui-icon ui-icon-check'></span></li></ul></a></div>";
			      var btnUndo = "<div class='btnUndo' id=\"btnUndo\"><a onclick=\"openDialogUndoCorrections("+idSP+","+idDq+");\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Undo'><span class='ui-icon ui-icon-arrowreturnthick-1-s'></span></li></ul></a></div>";	
	
			     $(".classChange_"+idDq+idSP).replaceWith(htmlAux+btnShow+btnCheck+btnUndo+fechaHtmlAux);
			     graphs(idDq);       		
				$(this).dialog('close');
    		}
    		else {
    			alert('There was an error to update the hierarchy.');
    			$(this).dialog('close');
    		}
    		
        },
        Cancel: function() {
            $(this).dialog('close');
        }
    }
});




function openDialogUndoCorrections(idSP,idDQ){

	var rs = 0;
	var count_sugest = 0; 
	 $.ajax({
	    	type:'POST',
	        url:'index.php?r=dataquality/UndoCorrections',
	        data: {'id_specimen':idSP,'idDQ':idDQ},
	        dataType: "json",
	        async: false,
	        success:function(json) {
	            rs = json;
	    	}
	  });	
	
	//console.log(rs);
	  
	var html =  '';
	if (rs != null){
		var latitude = 0;
		var longitude = 0;
		var municipality = 0; 
		var country = 0; 
		var stateprovince = 0; 
		var geodeticdatum = null;

		var genus = null;
		var family = null;
		var order = null;
		var classs = null;
		var phylum = null;
		var kingdom = null;
		
		
		for(var i in rs) {     
        	//alert(idDQ);
        	
			if (idDQ == 1){
		        	if (rs[i].field_name=='latitude') {
			 	 		latitude = rs[i].field_value;
		
			 	 	}
		    		else if (rs[i].field_name=='longitude') {
			 	 		longitude = rs[i].field_value;
			 	 	}
			 	 	
			 	 	
				
				html = ('The data was successfully undone.');
				var htmlAux = "<div class='classChange_"+idDQ+idSP+"'>";
				var fechaHtmlAux = "</div>";
				    
			    var btnShow = "<div class='btnShow'><a href='index.php?r=specimen/goToShow&id="+idSP+"'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Show Specimen Record'><span class='ui-icon ui-icon-search'></span></li></ul></a></div>";
				///tem que mostrar sugestão
				//openDialogSugestions(165,1);
				var btnFlag = "<div class='btnFlag' id=\"btnFlag"+idDQ+"_"+idSP+"\"><a onclick=\"openDialogSugestions("+idSP+","+idDQ+");\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Corrections OK'><span class='ui-icon ui-icon-help'></span></li></ul></a></div>";
				$(".classChange_"+idDQ+idSP).replaceWith(htmlAux+btnShow+btnFlag+fechaHtmlAux);

				var idTip=idDQ+"_"+idSP;
				
				
						
				//alert(html);
			    //graphs(idDQ);	
			}
			else if ((idDQ == 3)){

				
				

				html = ('The data was successfully undone.');
				var htmlAux = "<div class='classChange_"+idDQ+idSP+"'>";
				var fechaHtmlAux = "</div>";

			
			    var btnShow = "<div class='btnShow'><a href='index.php?r=specimen/goToShow&id="+idSP+"' target=\"_blank\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Show Specimen Record'><span class='ui-icon ui-icon-search'></span></li></ul></a></div>";

				if (rs[i]){
				    if (rs[i].field_name=='idgenus') {
					    
				    	genus = rs[i].field_value;
						//alert(family);
						//alert(html);
			 	 	}else
				    if (rs[i].field_name=='idfamily') {
				    	family = rs[i].field_value;
						//alert(family);
						//alert(html);
			 	 	}
		    		else if (rs[i].field_name=='idorder') {
		    			order = rs[i].field_value;
			 	 	}
		    		else if (rs[i].field_name=='idclass') {
		    			classs = rs[i].field_value;
			 	 	}
		    		else if (rs[i].field_name=='idphylum') {
		    			phylum = rs[i].field_value;
			 	 	}
		    		else if (rs[i].field_name=='idkingdom') {
		    			kingdom = rs[i].field_value;
			 	 	}
				}
				 var fields = genus+'|'+family+'|'+order+'|'+classs+'|'+phylum+'|'+kingdom;

				 console.log(fields);
				 //openDialogTaxonHierarchySugestions(108,3);
				//alert(fields);
				var btnFlag = "<div class='btnFlag' id=\"btnFlag"+idDQ+"_"+idSP+"\"><a><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Corrections OK'><span class='ui-icon ui-icon-help'></span></li></ul></a></div>";
				
				//alert(idDQ+' '+idSP);
			    //var btnCheck = "<div class='btnCheck' id=\"btnCheck"+idDQ+"_"+idSP+"\"><a onclick=\"openDialogCheckLocality("+"'"+municipality+"'"+","+"'"+stateprovince+"'"+","+"'"+country+"'"+","+idSP+","+idDQ+");\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Corrections OK'><span class='ui-icon ui-icon-check'></span></li></ul></a></div>";
			    $(".classChange_"+idDQ+idSP).replaceWith(htmlAux+btnShow+btnFlag+fechaHtmlAux);
			   // graphs(idDQ);

			    var rs = new Array();
				 var rs = {
						 genus: genus,
						 family: family,
						 order: order,
						 class: classs,
						 phylum:phylum,
						 kingdom:kingdom
					};
			
		 	 	
			}
			else if ((idDQ == 5)||(idDQ == 4)){

				
				if (rs[i].field_name=='municipality') {
					municipality = rs[i].field_value;
	
		 	 	}
	    		else if (rs[i].field_name=='country') {
		 	 		country = rs[i].field_value;
		 	 	}
	    		else if (rs[i].field_name=='stateprovince') {
	    			stateprovince = rs[i].field_value;
		 	 	}

				html = ('The data was successfully undone.');
				var htmlAux = "<div class='classChange_"+idDQ+idSP+"'>";
				var fechaHtmlAux = "</div>";

			
			    var btnShow = "<div class='btnShow'><a href='index.php?r=specimen/goToShow&id="+idSP+"' target=\"_blank\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Show Specimen Record'><span class='ui-icon ui-icon-search'></span></li></ul></a></div>";
			    var btnCheck = "<div class='btnCheck' id=\"btnCheck"+idDQ+"_"+idSP+"\"><a onclick=\"openDialogSugestions("+idSP+","+idDQ+");\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Corrections OK'><span class='ui-icon ui-icon-help'></span></li></ul></a></div>";
			   // $(".classChange_"+idDQ+idSP).replaceWith(htmlAux+btnShow+btnCheck+fechaHtmlAux);

			    var btnFlag = "<div class='btnFlag' id=\"btnFlag"+idDQ+"_"+idSP+"\"><a><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Corrections OK'><span class='ui-icon ui-icon-help'></span></li></ul></a></div>";
				$(".classChange_"+idDQ+idSP).replaceWith(htmlAux+btnShow+btnFlag+fechaHtmlAux);

				
			   
		 	 	
			}
		else if ((idDQ == 6)){

				
				

				html = ('The data was successfully undone.');
				var htmlAux = "<div class='classChange_"+idDQ+idSP+"'>";
				var fechaHtmlAux = "</div>";

			
			    var btnShow = "<div class='btnShow'><a href='index.php?r=specimen/goToShow&id="+idSP+"' target=\"_blank\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Show Specimen Record'><span class='ui-icon ui-icon-search'></span></li></ul></a></div>";

				
				var btnCheck = "<div class='btnCheck' id=\"btnCheck"+idDQ+"_"+idSP+"\"><a onclick=\"openDialogCheckTaxonHierarchy('"+fields+"'"+","+idSP+","+idDQ+");\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Corrections OK'><span class='ui-icon ui-icon-check'></span></li></ul></a></div>";
				var btnFlag = "<div class='btnFlag' id=\"btnFlag"+idDQ+"_"+idSP+"\"><a onclick=\"openDialogSugestNamesLessSpecifics("+idSP+","+idDQ+");\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Corrections OK'><span class='ui-icon ui-icon-help'></span></li></ul></a></div>";
				
			    //var btnCheck = "<div class='btnCheck' id=\"btnCheck"+idDQ+"_"+idSP+"\"><a onclick=\"openDialogCheckLocality("+"'"+municipality+"'"+","+"'"+stateprovince+"'"+","+"'"+country+"'"+","+idSP+","+idDQ+");\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Corrections OK'><span class='ui-icon ui-icon-check'></span></li></ul></a></div>";
			    $(".classChange_"+idDQ+idSP).replaceWith(htmlAux+btnShow+btnFlag+fechaHtmlAux);
			    
			   
		 	 	
			}
			else if (idDQ == 8){

				
				if (rs[i].field_name=='geodeticdatum') {
					geodeticdatum = rs[i].field_value;
	
		 	 	}
	    		

				html = ('The data was successfully undone.');
				var htmlAux = "<div class='classChange_"+idDQ+idSP+"'>";
				var fechaHtmlAux = "</div>";
				    
			    var btnShow = "<div class='btnShow'><a href='index.php?r=specimen/goToShow&id="+idSP+"' target=\"_blank\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Show Specimen Record'><span class='ui-icon ui-icon-search'></span></li></ul></a></div>";
			    var btnCheck = "<div class='btnCheck' id=\"btnCheck"+idDQ+"_"+idSP+"\"><a><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Corrections OK'><span class='ui-icon ui-icon-check'></span></li></ul></a></div>";
			    var btnFlag = "<div class='btnFlag' id=\"btnFlag"+idDQ+"_"+idSP+"\"><a><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Corrections OK'><span class='ui-icon ui-icon-help'></span></li></ul></a></div>";
			    $(".classChange_"+idDQ+idSP).replaceWith(htmlAux+btnShow+btnFlag+fechaHtmlAux);

			    graphs(idDQ);

				
		 	 	
			}
			else if (idDQ == 7){

				var latitude = 0;
				var longitude = 0;
				 $.ajax({
				    	type:'POST',
				        url:'index.php?r=dataquality/GetLatitudeLongitude',
				        data: {'id_specimen':idSP},
				        dataType: "json",
				        async: false,
				        success:function(json) {
				        	latitude = json[0].latitude;
				        	longitude = json[0].longitude;
				    	}
				  });	
				  
				if (rs[i].field_name=='coordinateuncertaintyinmeters') {
					coordinateuncertaintyinmeters = rs[i].field_value;
	
		 	 	}

				
				
				html = ('The data was successfully undone.');
				var htmlAux = "<div class='classChange_"+idDQ+idSP+"'>";
				var fechaHtmlAux = "</div>";
				    
			    var btnShow = "<div class='btnShow'><a href='index.php?r=specimen/goToShow&id="+idSP+"' target=\"_blank\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Show Specimen Record'><span class='ui-icon ui-icon-search'></span></li></ul></a></div>";
			    var btnCheck = "<div class='btnCheck' id=\"btnCheck"+idDQ+"_"+idSP+"\"><a onclick=\"openDialogCheckCoordinateUncertainty("+coordinateuncertaintyinmeters+""+","+idSP+","+idDQ+","+latitude+","+longitude+");\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Corrections OK'><span class='ui-icon ui-icon-pencil'></span></li></ul></a></div>";
			    $(".classChange_"+idDQ+idSP).replaceWith(htmlAux+btnShow+btnCheck+fechaHtmlAux);
			    //alert(html);
			    //graphs(idDQ);
		 	 	
			}

			
		}
    }
    else{
    	html = ('There was an error to update the data.');
    }


	if ((idDQ==6)||(idDQ==5)||(idDQ==4)||(idDQ==1)||(idDQ==8)||(idDQ==3)){
		
		html2 = tipSugestionTask(idDQ,idSP);
		var idTip=idDQ+"_"+idSP;
		if (html2){

			$('#btnFlag'+idTip).poshytip({
				className: 'tip-twitter',
				showOn: 'hover',
				content: html2,
				alignTo: 'target',
				alignX: 'center',
				alignY: 'bottom',
				offsetX: 5,
				offsetY: 5,
				allowTipHover: true,
				fade: false,
				slide: false
	        });

		}
	}
	
	 graphs(idDQ);
	$("#contentDialogUndo").html(html);
	$("#dialogUndo").dialog('open');
	
}


$("#dialogUndo").dialog({
	dialogClass: "no-close",
    autoOpen: false,
    resizable: true,
    //height:500,
    width:500,
    modal: true,
    beforeopen: function (event, ui) { 
    	$(".no-close .ui-dialog-titlebar-close").css("display","none");
     },
     position: {
			my: "center",
			at: "center",
			of: window
		},
    buttons: {
        Ok: function() {
            $(this).dialog('close');
        }
    }
});


function showButtonReturn(id_deleted_item,undo_log,idDQ){
	var rs = 0;

	 if ((id_deleted_item!=null) && (undo_log==null)){
		 rs = 1;
	 }

	// alert(idDQ);
	 if (idDQ == lasttask){
		 
		 setTimeout(function() {
		      $(".divLoadInit").hide();
				$('#accordion').show();
		}, 10);
			
		}
		
    return rs;
	
}

function insertLine(rs,idDq, rs_continue){

	 
	 
	//alert(rs_continue);
    var line ='<tr id="id__ID_"><td style="text-indent:5px;">_LASTTAXA_</td><td>_COLECTION_</td><td>_CATALOGUE_</td><td style="width:160px; text-align:center; text-indent:0px;">_BUTTONS_</td></tr>';
    var aux = line;

    
    
    var btnShow = "<div class='btnShow'><a href='index.php?r=specimen/goToShow&id="+rs.id+"' target='_blank'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Show Specimen Record'><span class='ui-icon ui-icon-search'></span></li></ul></a></div>";
    var btnAlert = "<div class='btnAlert' id=\"btnAlert"+idDq+"_"+rs.id+"\"><a><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Alert'><span class='ui-icon ui-icon-alert'></span></li></ul></a></div><div style='clear:both'></div>";

	if (idDq == 1){
    	var btnCheck = "<div class='btnCheck' id=\"btnCheck"+idDq+"_"+rs.id+"\"><a><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-check'></span></li></ul></a></div>";
    	var btnFlag = "<div class='btnFlag' id=\"btnFlag"+idDq+"_"+rs.id+"\"><a><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-help'</span></li></ul></a></div>";

	}
	else if ((idDq == 5)||(idDq == 4)){
    	var btnCheck = "<div class='btnCheck'id=\"btnCheck"+idDq+"_"+rs.id+"\"><a><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Corrections OK'><span class='ui-icon ui-icon-check'></span></li></ul></a></div>";
    	var btnFlag = "<div class='btnFlag' id=\"btnFlag"+idDq+"_"+rs.id+"\"><a><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Sugestions'><span class='ui-icon ui-icon-help'</span></li></ul></a></div>";
	}
	else if (idDq == 8){
	    var btnCheck = "<div class='btnCheck' id=\"btnCheck"+idDq+"_"+rs.id+"\"><a><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-check'></span></li></ul></a></div>";
	}
	else if (idDq == 7){
					  
	  var btnEdit = "<div class='btnCheck'id=\"btnCheck"+idDq+"_"+rs.id+"\"><a onclick=\"openDialogCheckCoordinateUncertainty('"+rs.coordinateuncertaintyinmeters+"'"+","+rs.id+","+idDq+","+rs.latitude+","+rs.longitude+");\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' ><span class='ui-icon ui-icon-pencil'></span></li></ul></a></div>";
	  var btnCheck = "<div class='btnCheck'id=\"btnCheck"+idDq+"_"+rs.id+"\"><a onclick=\"openDialogCheckCoordinateUncertainty('"+rs.coordinateuncertaintyinmeters+"'"+","+rs.id+","+idDq+","+rs.latitude+","+rs.longitude+");\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-check'></span></li></ul></a></div>";
	}
	else if (idDq == 6){
		
		var fields = rs.genus+'|'+rs.family+'|'+rs.order+'|'+rs.class+'|'+rs.phylum+'|'+rs.kingdom;

		var btnCheck = "<div class='btnCheck' id=\"btnCheck"+idDq+"_"+rs.id+"\"><a onclick=\"openDialogCheckTaxonHierarchy('"+fields+"'"+","+rs.id+","+idDq+");\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Corrections OK'><span class='ui-icon ui-icon-check'></span></li></ul></a></div>";
		var btnFlag = "<div class='btnFlag' id=\"btnFlag"+idDq+"_"+rs.id+"\"><a onclick=\"openDialogSugestNamesLessSpecifics("+rs.id+","+idDq+");\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Sugestions'><span class='ui-icon ui-icon-help'</span></li></ul></a></div>";
	}
	if (idDq == 3){
		var fields = rs.genus+'|'+rs.family+'|'+rs.order+'|'+rs.class+'|'+rs.phylum+'|'+rs.kingdom;

		//alert(fields);
		var btnCheck = "<div class='btnCheck' id=\"btnCheck"+idDq+"_"+rs.id+"\"><a><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-check'></span></li></ul></a></div>";
    	var btnFlag = "<div class='btnFlag' id=\"btnFlag"+idDq+"_"+rs.id+"\"><a><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Sugestions'><span class='ui-icon ui-icon-help'</span></li></ul></a></div>";

	}
	
    var btnUndo = "<div class='btnUndo' id=\"btnUndo"+idDq+"_"+rs.id+"\"><a onclick=\"openDialogUndoCorrections("+rs.id+","+idDq+");\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Undo'><span class='ui-icon ui-icon-arrowreturnthick-1-s'></span></li></ul></a></div>";
    

   //alert(aux);
    aux = aux.replace('_ID_',rs.id);
    aux = aux.replace('_TITLE_','Institution: '+rs.institution+'<br/>Collection: '+rs.collection);
  
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
    //alert(rs.collection);
    aux = aux.replace('_COLECTION_',rs.collection);
    aux = aux.replace('_LASTTAXA_',taxon);
    aux = aux.replace('_CATALOGUE_',rs.catalognumber); 

    
    
    
    var logVar = rs.type_execution==1?1:-1;
    //var logVar = rs.id_log_dq_deleted_items!=null?1:-1;
	//alert(logVar);
	
    var htmlAux = "<div class='classChange_"+idDq+rs.id+"'>";
    var fechaHtmlAux = "</div>";
  //Verifica se a latitude ou longitude é nula. Se sim, procura pelos dados da cidade, se estiverem completos podem ser corrigidos.
  
    var idmunicipality = parseInt(rs.idmunicipality);
   // alert(idmunicipality);
    
    var returnShowButton = showButtonReturn(rs.id_log_dq_deleted_items, rs.undo_log,idDq);
          
    if (idDq==1){   
       
		if((rs.type_execution==2) && (rs.sugestion==1)){
			aux = aux.replace('_BUTTONS_',htmlAux+btnShow+btnFlag+fechaHtmlAux);
		}
		else if((rs.type_execution==1) && (rs.sugestion==0)){
			aux = aux.replace('_BUTTONS_',htmlAux+btnShow+btnCheck+fechaHtmlAux);
		}
		
		else if((rs.type_execution==2) && (rs.sugestion==0)){
			aux = aux.replace('_BUTTONS_',htmlAux+btnShow+btnAlert+fechaHtmlAux);
		}
		
    }
    else  if ((idDq == 5)||(idDq == 4)){ 

    	
    	if((rs.type_execution==2) && (rs.sugestion==1)){
			aux = aux.replace('_BUTTONS_',htmlAux+btnShow+btnFlag+fechaHtmlAux);
		}
		else if((rs.type_execution==1) && (rs.sugestion==0)){
			aux = aux.replace('_BUTTONS_',htmlAux+btnShow+btnCheck+fechaHtmlAux);
		}
		
		else if((rs.type_execution==2) && (rs.sugestion==0)){
			aux = aux.replace('_BUTTONS_',htmlAux+btnShow+btnAlert+fechaHtmlAux);
		}
    	
		
    }
    else  if (idDq==8){   
       
      
    	var btnFlag = "<div class='btnFlag' id=\"btnFlag"+idDq+"_"+rs.id+"\"><a onclick=\"openDialogSugestDatum("+rs.id+","+idDq+");\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-help'></span></li></ul></a></div>";
    	if((rs.type_execution==2) && (rs.sugestion==1)){
			aux = aux.replace('_BUTTONS_',htmlAux+btnShow+btnFlag+fechaHtmlAux);
		}
		else if((rs.type_execution==1) && (rs.sugestion==0)){
			aux = aux.replace('_BUTTONS_',htmlAux+btnShow+btnCheck+fechaHtmlAux);
		}
		
		else if((rs.type_execution==2) && (rs.sugestion==0)){
			aux = aux.replace('_BUTTONS_',htmlAux+btnShow+btnAlert+fechaHtmlAux);
		}
    }
    else  if (idDq==7){   
       
        //alert(rs.coordinateuncertaintyinmeters);
       // alert(logVar);
       // 
    	if ((rs.coordinateuncertaintyinmeters != null)&&(logVar==1)){
			//var returnShowButton = showButtonReturn(rs.id,idDq);
			//alert(returnShowButton);
            if (returnShowButton==1){
        		aux = aux.replace('_BUTTONS_',htmlAux+btnShow+btnCheck+fechaHtmlAux);
            }
            else  if (returnShowButton==0){
        		aux = aux.replace('_BUTTONS_',htmlAux+btnShow+btnEdit+fechaHtmlAux);

            }
           
    		
        } else 	if ((rs.coordinateuncertaintyinmeters == null)&&(logVar==-1)){
			
        		aux = aux.replace('_BUTTONS_',htmlAux+btnShow+btnEdit+fechaHtmlAux);

            }
        else {
        	aux = aux.replace('_BUTTONS_',htmlAux+btnShow+btnAlert+fechaHtmlAux);
        }
    }
	else  if (idDq==6){   

		if((rs.type_execution==2) && (rs.sugestion==1)){
			aux = aux.replace('_BUTTONS_',htmlAux+btnShow+btnFlag+fechaHtmlAux);
		}
		else if((rs.type_execution==1) && (rs.sugestion==0)){
			aux = aux.replace('_BUTTONS_',htmlAux+btnShow+btnCheck+fechaHtmlAux);
		}
		
		else if((rs.type_execution==2) && (rs.sugestion==0)){
			aux = aux.replace('_BUTTONS_',htmlAux+btnShow+btnAlert+fechaHtmlAux);
		}
    }
    if (idDq==3){ 

 
        
        if (logVar==1){

            if (returnShowButton==1){
        		aux = aux.replace('_BUTTONS_',htmlAux+btnShow+btnCheck+fechaHtmlAux);
            }
            else  if (returnShowButton==0){
        		aux = aux.replace('_BUTTONS_',htmlAux+btnShow+btnCheck+btnFlag+fechaHtmlAux);

            }
        }else   {
        	//console.log(rs.id + ' '+ rs_continue);
			if (rs.type_execution	== 2){
				aux = aux.replace('_BUTTONS_',htmlAux+btnShow+btnFlag+fechaHtmlAux);
			}
			else if (rs.type_execution	== 3){
				aux = aux.replace('_BUTTONS_',htmlAux+btnShow+btnAlert+fechaHtmlAux);
			}
			
    	}
		
    }
	


    
    	$(".lines"+idDq).append(aux);


		//Textos tips Alert
			var textAlert= 'No Information';
			
	    	var idTip=idDq+"_"+rs.id;
	    	
	        var htmlTipAlert = '<div style="font-weight:normal;">'+textAlert+'</div>';
       
			 $('#btnAlert'+idTip).poshytip({
						className: 'tip-twitter',
						showOn: 'hover',
						content: htmlTipAlert,
						alignTo: 'target',
						alignX: 'center',
						alignY: 'bottom',
						offsetX: 5,
						offsetY: 5,
						allowTipHover: true,
						fade: false,
						slide: false
			        });

			
			if (rs.type_execution==1){
				var html = '';
			
		
					$('#btnCheck'+idTip).poshytip({
						className: 'tip-twitter',
						showOn: 'hover',
						
						alignTo: 'target',
						alignX: 'center',
						alignY: 'bottom',
						offsetX: 5,
						offsetY: 5,
						allowTipHover: true,
						fade: false,
						slide: false,
						content: function(updateCallback) {
							window.setTimeout(function() {
								html2 = tipCheckTask(idDq,rs.id,rs);
								if (idDq!=7){
									html2 = html2 + '<br/>'+'<div class="tipTask1">'+ btnUndo+'</div>';
								}
								updateCallback(html2);
							}, 1);
							return true;
						}
			        });
	
				
			 }

			//sugestion 
			if (rs.sugestion==1){
				
				$('#btnFlag'+idTip).poshytip({
					className: 'tip-twitter',
					showOn: 'hover',
					alignTo: 'target',
					alignX: 'center',
					alignY: 'bottom',
					offsetX: 5,
					offsetY: 5,
					allowTipHover: true,
					fade: false,
					slide: false,
					content: function(updateCallback) {
						window.setTimeout(function() {
							html2 = tipSugestionTask(idDq,rs.id);
							updateCallback(html2);
						}, 1);
						return 'Loading...';
					}
					
				});
			}
			

			
	
    return 1;
}


function slider(idDQ,rs_continue){

    $("#slider"+idDQ).slider({
        range: false,
        min:0,
        max:max - interval,
        value:start,
        stop: function(event, ui) {
            start = ui.value;
            end = start + interval;
            filter('slider',idDQ,rs_continue);
        },



        slide:function(event, ui) {
            $('#start'+idDQ).html(ui.value);
            $('#end'+idDQ).html((ui.value + interval));
        }
    }).find( ".ui-slider-handle" ).css({
			width: handleSize
		});

}

//////////---- END COORDINATES ---------------///////

////-----------TAXONS -----------////

function filter_taxons(taxonType,idDQ){
	var ret = 0;
    $.ajax({
    	type:'POST',
        url:'index.php?r=dataquality/FilterTaxon',
        data: {'taxonType':taxonType},
        dataType: "json",
        //async: false,
        success:function(json) {
            var rs = new Object();
            $(".lines_taxons"+taxonType).html('');

            rs = json.result;
            for(var i in rs) {    
            	ret = ret+1;
               	insertLine_Taxons(rs[i],taxonType,idDQ);
               	
            }

            return ret;
            
			

        }
    });
	
   
}

function listIncorrectTaxons(taxonType,idDQ){
	$(".listTaxons").hide();
	$(".divNoTaxon").hide();
	
	$(".divLoad").show();
	
	var ret =  filter_taxons(taxonType,idDQ);
	if (ret >0){
		$(".divLoad").hide();
	 	$(".listTaxons").show();
	 	return 1;
	}
	else{
		$(".divLoad").hide();
		$(".divNoTaxon").show();
		return 1;

	}
	
	 	 
}

function getTaxonName(taxonType){

	 switch(taxonType)
     {
     case 1:
    	 taxonName = 'kingdom';
       break;
     case 2:
    	 taxonName = 'phylum';
       break;

     case 3:
    	 taxonName = 'class';
       break;

     case 4:
    	 taxonName = 'order';
       break;

     case 5:
    	 taxonName = 'family';
       break;

     case 6:
    	 taxonName = 'genus';
       break;
     
	case 7:
		 taxonName = 'scientificname';
	  break;
	}

     return taxonName;
}


function insertLine_Taxons(rs,taxonType,idDQ){
		 var line ='<tr id="id__ID_"><td style="text-indent:5px;"><div class="taxon_name_'+rs.id+'\"> _NAME_ </div></td><td style="width:160px; text-align:center; text-indent:0px;">_BUTTONS_</td></tr>';
	     var aux = line;
	     
	     	     
	    var taxonName = getTaxonName(taxonType);
	     
	    var btnFlag = "<div class='btnFlag'  id=\"btnFlag"+idDQ+"_"+rs.id+"\"><a><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-help'</span></li></ul></a></div>";
	    //var btnUndo = "<div class='btnUndo' id=\"btnUndo\"><a onclick=\"openDialogUndoCorrectionsTaxons('"+rs.value+"','"+taxonName+"','"+rs.id+"','"+taxonType+"','"+idDQ+"');\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Undo'><span class='ui-icon ui-icon-arrowreturnthick-1-s'></span></li></ul></a></div>";
	    var btnList = "<div class='btnList' id=\"btnList\"><a onclick=\"openDialogListSpecimens('"+rs.id+"','"+taxonType+"');\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='List Specimens'><span class='ui-icon ui-icon-search'></span></li></ul></a></div>";

	    var htmlAux = "<div class='classChange_"+rs.id+"'>";
	    var fechaHtmlAux = "</div>";

	    aux = aux.replace('id__ID_','line_'+rs.id);
	    aux = aux.replace('_NAME_',rs.value);


		var canUndo = parseInt(rs.undo);

	    aux = aux.replace('_BUTTONS_',htmlAux+btnList+btnFlag+fechaHtmlAux);
	  
		
		
	    $(".lines_taxons"+taxonType).append(aux);

	    $(".divNoTaxon").hide();
		$(".divLoad").hide();
	 	$(".listTaxons").show();
	 	
		//console.log(rs);
		var idTip=2+"_"+rs.id;
		if (rs.sugestion==1){
			
			$('#btnFlag'+idTip).poshytip({
				className: 'tip-twitter',
				showOn: 'hover',
				alignTo: 'target',
				alignX: 'center',
				alignY: 'bottom',
				offsetX: 5,
				offsetY: 5,
				allowTipHover: true,
				fade: false,
				slide: false,
				content: function(updateCallback) {
					window.setTimeout(function() {
						html2 = tipSugestionTask(2,rs.id,rs);
						updateCallback(html2);
					}, 1);
					return 'Loading...';
				}
				
			});
			
	   
		}
		
}






function searchSugestionsCol(value,taxonName){
	var rs = 0;
	 $.ajax({
	    	type:'POST',
	        url:'index.php?r=dataquality/ColSuggestions',
	        data: {'value':value,'name':taxonName},
	        dataType: "json",
	        async: false,
	        success:function(json) {
	        	rs = json;
	        	
	           
				
	    	}
	  });
	 return rs;
	 
}

function openDialogUpdateTaxonsSugestions(id_taxon,value,taxonType,idDQ){

	var taxonName = getTaxonName(taxonType); 
	
	var rs = 0;
	 $.ajax({  
	    	type:'POST',
	        url:'index.php?r=dataquality/UpdateTaxonsSugestions',
	        data: {'id_taxon':id_taxon,'value':value,'taxonType':taxonType,'idDQ':idDQ},
	        dataType: "json",
	        async: false,
	        success:function(json) {
	            rs = json;
	            //alert(rs);
	            if (rs == 1){
					alert('The update has been successfully completed.');
	            }
	            else  if (rs == 2){
					alert('There was no species for the taxon updated. Already exists a register with previous name. The item has been removed' );
	            }
	            else{
	            	alert('There was an error to update the taxons.');
	            }
	            
				
	    	}
	  });

	var taxonName = getTaxonName(taxonType); 

	
	var current_id = 0;
	 $.ajax({  
	    	type:'POST',
	        url:'index.php?r=dataquality/GetTaxonIdByName',
	        data: {'value':value,'taxonTypeName':taxonName},
	        dataType: "json",
	        async: false,
	        success:function(json) {
	            rs2 = json;
				
	            current_id = rs2;
	           // alert(current_id);
				
	    	}
	  });


	if (rs==1){
		var htmlAux = "<div class='classChange_"+current_id+"'>";
		var fechaHtmlAux = "</div>";

		var htmlAux2 = "<div class='taxon_name_"+current_id+"'>";
		var fechaHtmlAux2 = "</div>";
		
		//var btnShow = "<div class='btnShow'><a href='index.php?r=specimen/goToShow&id="+rs.id+"'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Show Specimen Record'><span class='ui-icon ui-icon-search'></span></li></ul></a></div>";
	   var btnCheck = "<div class='btnCheck' id=\"btnCheck\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-check'></span></li></ul></div>";
	   var btnUndo = "<div class='btnUndo' id=\"btnUndo\"><a onclick=\"openDialogUndoCorrectionsTaxons('"+value+"','"+taxonName+"','"+current_id+"','"+taxonType+"','"+idDQ+"');\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Undo'><span class='ui-icon ui-icon-arrowreturnthick-1-s'></span></li></ul></a></div>";
	   var btnList = "<div class='btnList' id=\"btnList\"><a onclick=\"openDialogListSpecimens('"+current_id+"','"+taxonType+"');\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='List Specimens'><span class='ui-icon ui-icon-search'></span></li></ul></a></div>";
	  // var btnCheck = '*';
	  // var btnUndo = 'c';
	    $(".classChange_"+id_taxon).replaceWith(htmlAux+btnList+btnCheck+fechaHtmlAux);
	    
	    
	    $(".taxon_name_"+id_taxon).replaceWith(htmlAux2+value+fechaHtmlAux2);
	    
	    
	}
	else if (rs==2){
		var htmlAux = "<div class='classChange_"+current_id+"'>";
		var fechaHtmlAux = "</div>";

		var htmlAux2 = "<div class='taxon_name_"+current_id+"'>";
		var fechaHtmlAux2 = "</div>";
		
		//var btnShow = "<div class='btnShow'><a href='index.php?r=specimen/goToShow&id="+rs.id+"'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Show Specimen Record'><span class='ui-icon ui-icon-search'></span></li></ul></a></div>";
	   var btnCheck = "<div class='btnCheck' id=\"btnCheck\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Corrections OK'><span class='ui-icon ui-icon-check'></span></li></ul></div>";
	   var btnUndo = "<div class='btnUndo' id=\"btnUndo\"><a onclick=\"openDialogUndoCorrectionsTaxons('"+value+"','"+taxonName+"','"+current_id+"','"+taxonType+"','"+idDQ+"');\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Undo'><span class='ui-icon ui-icon-arrowreturnthick-1-s'></span></li></ul></a></div>";
	   var btnList = "<div class='btnList' id=\"btnList\"><a onclick=\"openDialogListSpecimens('"+current_id+"','"+taxonType+"');\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='List Specimens'><span class='ui-icon ui-icon-search'></span></li></ul></a></div>";
	  // var btnCheck = '*';
	  // var btnUndo = 'c';
	    $(".classChange_"+id_taxon).hide();
	    
	    
	    $(".taxon_name_"+id_taxon).hide();
	 
	    
	    
	}
	
	 $("#dialogSugestions").dialog('close');
	 graphs(idDQ);
	 return rs;

}

function listSpecimensCheck(id_taxon,taxonType){

	var res = 0;
	 $.ajax({  
	    	type:'POST',
	        url:'index.php?r=dataquality/ListSpecimensByIdTaxon',
	        data: {'id_taxon':id_taxon,'taxonType':taxonType},
	        dataType: "json",
	        async: false,
	        success:function(json) {
	        	
	        	 
	            res = parseInt(json.count);
	            
	            //alert(res);
	           //console.log('res='+rs);
	            
	            				
	    	},
	    	cache: false
	  });
	  
	  return res;
	  
}



function openAlertListSpecimens(){


	
    $( "#openAlertListSpecimens" ).dialog({
        autoOpen: false,
        minHeight: 200,
        minWidth: 200,
        resizable: false,
        modal: true,
        open: function() {
        	$("#listSpecimens").dialog("close");
        }
    });
   
    $( "#openAlertListSpecimens" ).dialog( "open" );
   
	
	
}

function openDialogListSpecimens(id_taxon,taxonType){

	var ret = listSpecimensCheck(id_taxon,taxonType);

	//alert(parseInt(ret));
	if (ret > 0){
		 $('#listSpecimens').load('index.php?r=dataquality/goToListSpecimens&id_taxon='+id_taxon+'&taxonType='+taxonType);
		    $( "#listSpecimens" ).dialog({
		        autoOpen: false,
		        minHeight: 450,
		        minWidth: 835,
		        resizable: false,
		        modal: true
		    });
		    $( "#listSpecimens" ).dialog('open');
	}
	  else {
	   openAlertListSpecimens();
	 }

	
}


function openDialogUndoCorrectionsTaxons(value, taxonName, id, taxonType, idDQ){
	
	var id_taxon = id;
	var new_id = 0;
	var old_name = '';
	
	$.ajax({  
    	type:'POST',
        url:'index.php?r=dataquality/UndoCorrectionsTaxons',
        data: {'id_taxon':id,'taxonType':taxonType},
        dataType: "json",
        async: false,
        success:function(json) {
            new_id = parseInt(json[0].id);
            old_name = json[0].old_name;
            //alert(new_id);
			
    	}
  });
	  
	 	
	if (new_id>1){	
		html = ('The data was successfully undone.');
		var htmlAux = "<div class='classChange_"+new_id+"'>";
		var fechaHtmlAux = "</div>";

		var htmlAux2 = "<div class='taxon_name_"+new_id+"'>";
		var fechaHtmlAux2 = "</div>";
		   
        var btnFlag = "<div class='btnFlag' id=\"btnFlag\"><a onclick=\"openDialogSugestionsCol('"+value+"','"+taxonName+"','"+new_id+"','"+taxonType+"','"+idDQ+"');\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Sugestions'><span class='ui-icon ui-icon-help'</span></li></ul></a></div>";
        var btnList = "<div class='btnList' id=\"btnList\"><a onclick=\"openDialogListSpecimens('"+new_id+"','"+taxonType+"');\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='List Specimens'><span class='ui-icon ui-icon-search'></span></li></ul></a></div>";

		$(".classChange_"+id_taxon).replaceWith(htmlAux+btnList+btnFlag+fechaHtmlAux);
	    	    
	    $(".taxon_name_"+id_taxon).replaceWith(htmlAux2+old_name+fechaHtmlAux2);

		
    }
    else{
    	html = ('There was an error to update the data.');
    }
    
	$("#contentDialogUndo").html(html);
	$("#dialogUndo").dialog('open');
	
}

//////////---- END TAXONS ---------------///////

///////---------DADOS DE LOCALIZACAO ------------////

function updateLocality(idSP,idDQ){

	///vai procurar as coordenadas e vai atualizar de uma em uma as localidades
	var rs = 0;
	 $.ajax({
	    	type:'POST',
	        url:'index.php?r=dataquality/Locality',
	        data: {'id_specimen':idSP,'idDQ':idDQ},
	        dataType: "json",
	        async: false,
	        success:function(json) {
	            rs = json;
				
	    	}
	  });
	 return rs; 

}

function searchNamesLocality(municipality,stateprovince,country){
	var rs = 0;
	 $.ajax({
	    	type:'POST',
	        url:'index.php?r=dataquality/SearchNamesLocality',
	        data: {'municipality':municipality,'stateprovince':stateprovince,'country':country},
	        dataType: "json",
	        async: false,
	        success:function(json) {
	            rs = json;
				
	    	}
	  });
	 return rs; 
	 
	
}
function openDialogCheckLocality(municipality,stateprovince,country,id, idDQ){
	
	if (stateprovince==0){
		stateprovince = null;
	}
	if (country==0){
		country = null;
	}
	if (municipality==0){
		municipality = null;
	}

	if ((stateprovince>0)||(country>0)||(municipality>0)){

		///buscar nome cidade,estado, pais
		var array_locality_names = searchNamesLocality(municipality,stateprovince,country);

		municipality = array_locality_names[0];
		stateprovince = array_locality_names[1];
		country = array_locality_names[2];
		

	}
	$("#contentDialogCheck").html('Country: '+country + '<br/>'+'Stateprovince: '+stateprovince+ '<br/>'+'Municipality: '+municipality);

 	$( "#dialogCheck" ).dialog('open');
 	
  
}

//////////---- FIM DADOS DE LOCALIZACAO---------------///////

///////---------DATUM ------------////

$("#dialogCheckDatum").dialog({
	
    autoOpen: false,
    resizable: false,
    height:200,
    modal: true,
    beforeopen: function (event, ui) { 
    	$(".no-close .ui-dialog-titlebar-close").css("display","none");
     },
    position: {
			my: "left top",
			at: "right top",
			of: "#tablelist"
		} ,
     buttons: {
		        Ok: function() {
			        var  idSP = $('#datumValue').attr('idSP');
			        var datum = $('#datumValue').val();
			        var idDQ = $('#datumValue').attr('idDQ');
		        	var ret = updateDatumSP(idSP,datum,idDQ);

		        	if (ret == 1){
		        		var htmlAux = "<div class='classChange_"+idDQ+idSP+"'>";
		        		var fechaHtmlAux = "</div>";
	        		   
		        		var btnShow = "<div class='btnShow'><a href='index.php?r=specimen/goToShow&id="+idSP+"' target='_blank'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Show Specimen Record'><span class='ui-icon ui-icon-search'></span></li></ul></a></div>";
		                var btnCheck = "<div class='btnCheck' id=\"btnCheck"+idDQ+"_"+idSP+"\"><a onclick=\"openDialogCheckDatum('"+datum+"'"+","+idSP+","+idDQ+");\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Corrections OK'><span class='ui-icon ui-icon-check'></span></li></ul></a></div>";
		                var btnUndo = "<div class='btnUndo' id=\"btnUndo\"><a onclick=\"openDialogUndoCorrections("+idSP+","+idDQ+");\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Undo'><span class='ui-icon ui-icon-arrowreturnthick-1-s'></span></li></ul></a></div>";	

		        		$(".classChange_"+idDQ+idSP).replaceWith(htmlAux+btnShow+btnCheck+btnUndo+fechaHtmlAux);
		        	    	    
		        		graphs(idDQ);
		        			
				
		        	}
		            $(this).dialog('close');
               }
     }
   
});



function openDialogCheckDatum(datum, idSP, idDQ){
	
	if (datum == ''){
		datum = null;
	}

	form_html = "<br/>Geodetic datum:  <input type=\"text\" name=\"datumValue\"  idSP='"+idSP+"'"+" idDQ='"+idDQ+"'"+" id=\"datumValue\" value=\""+datum+"\"/> ";


	$("#contentDialogCheckDatum").html(form_html);
	
	
 	$( "#dialogCheckDatum" ).dialog('open');
 	
  
}





function updateDatum(idSP,idDQ){

	var rs = 0;
	 $.ajax({
	    	type:'POST',
	        url:'index.php?r=dataquality/Datum',
	        data: {'id_specimen':idSP,'idDQ':idDQ},
	        dataType: "json",
	        async: false,
	        success:function(json) {
	            rs = json;
				
	    	}
	  });
	 return rs; 

}

function updateDatumSP(idSP,datum,idDQ){


	var rs = 0;
	 $.ajax({
	    	type:'POST',
	        url:'index.php?r=dataquality/DatumSP',
	        data: {'id_specimen':idSP,'datum':datum,'idDQ':idDQ},
	        dataType: "json",
	        async: false,
	        success:function(json) {
	            rs = json;
				
	    	}
	  });
	 return rs; 

}
//////////---- FIM DATUM--------------///////

///////---------CoordinateUncertainty ------------////

var idSP = 0;
var idDQ = 0;



	$("#dialogCheckCoordinateUncertainty").dialog({
		
	    autoOpen: false,
	    resizable: false,
	    height:700,
	    width:800,
	    modal: true,
	    beforeopen: function (event, ui) { 
	    	$(".no-close .ui-dialog-titlebar-close").css("display","none");
	     },
	    position: {
	    	my: "center",
			at: "center",
			of: window
			} ,
		open: function(event, ui) {
			   
			    var meters = $(this).data('uncertainty');
			    var latitude = $(this).data('latitude');
			    var longitude = $(this).data('longitude');

			    
			    
	            $('#contentD').load('index.php?r=dataquality/EditUncertainty&uncertainty='+meters+'&lat='+latitude+'&lng='+longitude, function(event, ui) {
	            	
	            });
	            
		},
		
	     buttons: {
			        Ok: function(event, ui) {
			        	var latitude = $(this).data('latitude');
						var longitude = $(this).data('longitude');
						    
			        	var input_uncertainty =  $(".mainFieldsTable").contents().find("#uncertainty");
					 
				        var  idSP = $("#dialogCheckCoordinateUncertainty").data('idSP');
				        
				        var meters = input_uncertainty.val();
				   
				        var  idDQ = $("#dialogCheckCoordinateUncertainty").data('idDQ');
				        
			        	var ret = updateCoordinateUncertaintySP(idSP,meters,idDQ);
	
			        	if (ret == 1){
			        		var htmlAux = "<div class='classChange_"+idDQ+idSP+"'>";
			        		var fechaHtmlAux = "</div>";
		        		   
			        		var btnShow = "<div class='btnShow'><a href='index.php?r=specimen/goToShow&id="+idSP+"' target='_blank'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Show Specimen Record'><span class='ui-icon ui-icon-search'></span></li></ul></a></div>";
			                var btnCheck = "<div class='btnCheck' id=\"btnCheck"+idDQ+"_"+idSP+"\"><a onclick=\"openDialogCheckCoordinateUncertainty('"+meters+"'"+","+idSP+","+idDQ+","+latitude+","+longitude+");\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-check'></span></li></ul></a></div>";
			                var btnUndo = "<div class='btnUndo' id=\"btnUndo\"><a onclick=\"openDialogUndoCorrections("+idSP+","+idDQ+");\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Undo'><span class='ui-icon ui-icon-arrowreturnthick-1-s'></span></li></ul></a></div>";	
	
			        		$(".classChange_"+idDQ+idSP).replaceWith(htmlAux+btnShow+btnCheck+fechaHtmlAux);
			        		graphs(idDQ);	    

			        		var idTip=idDQ+"_"+idSP;
			        		
			        		var html = '';
							//check
							
							var rs = new Array();
							 var rs = {
									 coordinateuncertaintyinmeters: meters
								};
							
							
							html = tipCheckTask(idDQ,idSP,rs);
							
							if (html){
								
					
								$('#btnCheck'+idTip).poshytip({
									className: 'tip-twitter',
									showOn: 'hover',
									content: html,
									alignTo: 'target',
									alignX: 'center',
									alignY: 'bottom',
									offsetX: 5,
									offsetY: 5,
									allowTipHover: true,
									fade: false,
									slide: false
						        });
				
							}
			        	   
			        			
					
			        	}
			       
			            $(this).dialog('close');
			            
	               }
	     }
	   
	});

	
	
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
			"sourceBiogeomancer":false,
			"sourceGeolocate":false
		};
	}
	setDefaultValues();
	
	

	
	function openDialogCheckCoordinateUncertainty(meters, idSP, idDQ, latitude, longitude){
		 //setDefaultValues();
	
		
		  
		if (meters == ''){
			meters = 100;
		}
	
		 selectedData.coordinateuncertaintyinmeters = meters;
		 selectedData.lat= latitude;
		 selectedData.lng= longitude;	

		
		form_html =  "<div class= =\"contentD\" id=\"contentD\"> </div>";

		form_html =  form_html+ "<div id=\"valueInput\"> </div>";
		
		//form_html = form_html+ "<script> var valo = $(\"#uncertainty\").val(); alert(valo)<\/script>";
		
		$("#dialogCheckCoordinateUncertainty").html(form_html);
			
		$( "#dialogCheckCoordinateUncertainty" ).data('uncertainty', meters);
		$( "#dialogCheckCoordinateUncertainty" ).data('idSP', idSP);
		$( "#dialogCheckCoordinateUncertainty" ).data('idDQ', idDQ);
		$( "#dialogCheckCoordinateUncertainty" ).data('latitude', latitude);
		$( "#dialogCheckCoordinateUncertainty" ).data('longitude', longitude);
		
	 	$( "#dialogCheckCoordinateUncertainty" ).dialog('open');
	 	
	  
	}
	
		
	function updateCoordinateUncertaintySP(idSP,meters,idDQ){
	
	
		var rs = 0;
		 $.ajax({
		    	type:'POST',
		        url:'index.php?r=dataquality/CoordinateUncertaintySP',
		        data: {'id_specimen':idSP,'meters':meters,'idDQ':idDQ},
		        dataType: "json",
		        async: false,
		        success:function(json) {
		            rs = json;
					
		    	}
		  });
		 return rs; 
		 
	
	}




///////---------FIM CoordinateUncertainty ------------////

////-------Taxon Hierarchy -------///

	function updateTaxonHierarchy(idSP,idDQ,sugestion){

		var rs = 0;
		 $.ajax({
		    	type:'POST',
		        url:'index.php?r=dataquality/TaxonHierarchy',
		        data: {'id_specimen':idSP,'idDQ':idDQ,'sugestion':sugestion},
		        dataType: "json",
		        async: false,
		        success:function(json) {
		            rs = json;
					
		    	}
		  });
		  
		 return rs; 
		 

	}

	function getLocalTaxonHierarchy(idSP,idDQ){

		var rs = 0;
		 $.ajax({
		    	type:'POST',
		        url:'index.php?r=dataquality/GetLocalTaxonHierarchy',
		        data: {'id_specimen':idSP,'idDQ':idDQ},
		        dataType: "json",
		        async: false,
		        success:function(json) {
		            rs = json;
					
		    	}
		  });
		 return rs; 

	}
	
	
	function openDialogCheckTaxonHierarchy(fields, idSP, idDQ){

		///consultar hierarquia
		
				

		var myArray = fields.split('|');

		var genus = myArray[0];
		var family = myArray[1];
		var order = myArray[2];
		var classs = myArray[3];
		var phylum = myArray[4];
		var kingdom = myArray[5];
		
		
		if (genus == ''){
			genus = null;
		}
		if (family == ''){
			family = null;
		}
		if (order == ''){
			order = null;
		}
		if (classs == ''){
			classs = null;
		}
		if (phylum == ''){
			phylum = null;
		}
		if (kingdom == ''){
			kingdom = null;
		}
		
		var form_html = "Genus: "+genus;
		form_html = form_html+"<br/> Family: "+family;
		form_html = form_html+"<br/> Order: "+order;
		form_html = form_html+"<br/> Classs: "+classs;
		form_html = form_html+"<br/> Phylum: "+phylum;
		form_html = form_html+"<br/> Kingdom: "+kingdom;
		


		$( "#dialogCheckTaxonHierarchy" ).dialog({
	        autoOpen: false,
	        minHeight: 200,
	        minWidth: 200,
	        resizable: false,
	        modal: true
	        
	    });
	   
	    /*$( "#openAlertListSpecimens" ).dialog( "open" );
	    
		
		$("#contentDialogCheckTaxonHierarchy").html(form_html);
		
		
	 	$( "#dialogCheckTaxonHierarchy" ).dialog('open');*/

	 	return form_html;
	  
	}


	function filterTaxonHierarchy(){
		var ret  = 0;
		
		var spArray = [];
	    $.ajax({
	    	type:'POST',
	        url:'index.php?r=dataquality/filter',

	        data: {'idDQ':3,'limit':'null', 'offset':0, 'list':jFilterList},
	        dataType: "json",
	        async: false,
	        success:function(json) {
	        	var rs = new Object();
	             rs = json.result;
	             //max = parseInt(json.count);
	             //console.log(max);
	             
	             for(var i in rs) { 

	            	
	                 ret = checkTaxonHierarchy(rs[i].id);
	                 var logVar = logVerify(rs[i].id,3);
	                 
	                 //console.log(i);
	         	     if ((ret != 0)||(logVar==1)){
	                	 //console.log(ret);
	                	 spArray.push(rs[i].id);
	                 }
	             }
				
			
	            
	        }
	    });

	    console.log(spArray);
	    return spArray;

		
	}

	function checkTaxonHierarchy(idSP){

		
		var ret  = 0;
		

	    $.ajax({
	    	type:'POST',
	        url:'index.php?r=dataquality/CheckTaxonHierarchy',
	        data: {'id_specimen':idSP,'idDQ':3,'limit':'null', 'offset':0, 'list':jFilterList},
	        dataType: "json",
	        async: false,
	        success:function(json) {
	        	ret = json;
	        	//rs = 0;	
			
	            
	        }
	    });
	    return ret;
	}
	var det=0;
    var cor=0;
	///FIM Taxon Hierarchy----//////

	 $(".accordion h3").bind("click", function() {
		var accordionIndex= $(this).attr("index");
		
		
		tempIdDQ = accordionIndex;

		
			graphs(tempIdDQ);
		
    });

	function graph2(){
		plot2 = jQuery.jqplot('chart2', 
			    [[['Verwerkende industrie', 9],['Retail', 0], ['Primaire producent', 0], 
			    ['Out of home', 0],['Groothandel', 0], ['Grondstof', 0], ['Consument', 3], ['Bewerkende industrie', 2]]], 
			    {
			      title: ' ', 
			      seriesDefaults: {
			        shadow: false, 
			        renderer: jQuery.jqplot.PieRenderer, 
			        rendererOptions: { 
			          startAngle: 180, 
			          sliceMargin: 4, 
			          showDataLabels: true } 
			      }, 
			      legend: { show:true, location: 'w' }
			    }
			  );



	}
	 function graphs(idDQ){
     	
 		var rs = 0;
 		
         $.ajax({
         	type:'POST',
             url:'index.php?r=dataquality/getNumbers',
             data: {'idDQ':idDQ},
             dataType: "json",
             //async: false,
             success:function(json) {
                    rs = json;
                    cor = rs[0].correction;
            		 det = parseInt($('#max'+idDQ).html())-cor;
            		
                    cor = rs[0].correction;
                    
                    $('#container'+idDQ).highcharts({
                        chart: {
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                            margin: [0, 0, 0, 0],
                            spacingTop: 0,
                            spacingBottom: 0,
                            spacingLeft: 0,
                            spacingright: 0
                        },
                        title: {
                            text: 'Statistics for Corrections and Detections'
                        },
                        tooltip: {
                    	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: false,
                                target: 'pointer',
                                dataLabels: {
                                    enabled: false,
                                    color: '#000000',
                                    connectorColor: '#000000',
                                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                                },
                                showInLegend: true,
                                size:'60%'
                            }
                        },
                        series: [{
                            type: 'pie',
                            name: 'Browser share',
                            data: [
                                {
                                    name: 'Detected',
                                    y: det,
                                    sliced: true,
                                    selected: true,
                                    color: '#008000'
                                },
                                {
                                    name: 'Corrected',
                                    y: cor,
                                    sliced: true,
                                    selected: true,
                                    color: '#F0AD4E'
                                },
                                
                            ]
                        }]
                    });
             }
      
         });
 		 
 		
 		 


     }
///--------Tips --------//////

	 function tipCheckTask(idDQ,idSP,rs){
		 var html = null;
			if (idDQ==1){
	
				html = openDialogCheck(idSP, idDQ,rs);
				return html;
			}
			else if ((idDQ==4)||(idDQ==5)){

				html = openDialogCheckLocality(rs.municipality,rs.stateprovince,rs.country,+idSP,idDQ);
			
				return html;
			}
			else if(idDQ==7){

				html = openDialogCheck(idSP, idDQ,rs);
				return html;
				
			}
			else if(idDQ==8){

				html = openDialogCheck(idSP, idDQ,rs);
				
				return html;
				
			}
			else if ((idDQ==6)||((idDQ==3))){
				var fields = rs.genus+'|'+rs.family+'|'+rs.order+'|'+rs.class+'|'+rs.phylum+'|'+rs.kingdom;
				html = openDialogCheckTaxonHierarchy(fields,idSP,idDQ);
				return html;
			}
		  
		}

	 function tipSugestionTask(idDQ,idSP,rs){
			var html = null;
				if(idDQ==1){

					html=openDialogSugestions(idSP,idDQ);

					
				}
				else if ((idDQ==4)||(idDQ==5)){

					html=openDialogSugestions(idSP,idDQ);

					
				}
				if(idDQ==8){

					html=openDialogSugestDatum(idSP,idDQ);

					
				}
				else if (idDQ==2){
					
					var  id_taxon_type = rs.id_taxon_type;
					var  taxon = rs.value;
					var id = idSP;
					var taxonName = getTaxonName(id_taxon_type);

					
					//console.log(rs+'taxon');
					html= openDialogSugestionsCol(taxon,taxonName,id,id_taxon_type,idDQ);
					return html;
				}
				else if (idDQ==6){
										
					html= openDialogSugestNamesLessSpecifics(idSP,idDQ);
					return html;
				}
				else if (idDQ==3){
					
					html= openDialogTaxonHierarchySugestions(idSP,idDQ);
					return html;
				}
				
				return html;
		} 

		///check coordinates
		function openDialogCheck(idSP, idDQ,rs){

			if (idDQ==1){
				var rs = 0;
				 $.ajax({
				    	type:'POST',
				        url:'index.php?r=dataquality/getCoordinates',
				        data: {'id_specimen':idSP,'idDQ':idDQ},
				        dataType: "json",
				        async: false,
				        success:function(json) {
				            rs = json;
				    	}
				  });	
				
				var latitude = rs[0].latitude==0?null:rs[0].latitude;
				var longitude = rs[0].longitude==0?null:rs[0].longitude;
				html = 'Latitude: '+latitude + '<br/>'+'Longitude: '+longitude;
				return html;
			}
			else if (idDQ==7){
				
				
				 html = 'Meters: '+rs.coordinateuncertaintyinmeters;
				return html;
			}
			else if (idDQ==8){
				
				
				 html = 'Datum: '+rs.geodeticdatum;
				return html;
			}
			
		 	
		  
		}
			 

		function openDialogCheckLocality(municipality,stateprovince,country,id, idDQ){
			
			if (stateprovince==0){
				stateprovince = null;
			}
			if (country==0){
				country = null;
			}
			if (municipality==0){
				municipality = null;
			}

			if ((stateprovince>0)||(country>0)||(municipality>0)){

				///buscar nome cidade,estado, pais
				var array_locality_names = searchNamesLocality(municipality,stateprovince,country);

				municipality = array_locality_names[0];
				stateprovince = array_locality_names[1];
				country = array_locality_names[2];
				

			}
			//$("#contentDialogCheck").html('Country: '+country + '<br/>'+'Stateprovince: '+stateprovince+ '<br/>'+'Municipality: '+municipality);
		 	//$( "#dialogCheck" ).dialog('open');
		 	html = 'Country: '+country + '<br/>'+'Stateprovince: '+stateprovince+ '<br/>'+'Municipality: '+municipality;
		 	return html;
		 	
		  
		}
	///sugest coordinates
	function openDialogSugestions(idSP,idDQ){

		var html ='';
		if (idDQ==1){

			var array_sugestions = sugestionsCoordinates(idSP);

		
			var html = '';
			$.each(array_sugestions, function(index, val) {
				var content = '';
				html = html + '<div id="'+idSP+'">';
				content = val.formatted_address+' - Lat: '+val.latitude +' - Long: '+val.longitude;
				html = html +"<a class=\"link_sugestion\" onclick=\"openDialogUpdateSugestions("+val.latitude+","+val.longitude+","+idSP+","+idDQ+");\">"+content+"</a>";
				html = html+"</div>";
				
			});
		}
		else if ((idDQ==4)||(idDQ==5)){
			var array_sugestions = sugestionsLocality(idSP);
			var html = '';
			$.each(array_sugestions, function(index, val) {
				var content = '';
				html = html + '<div id="'+idSP+'">';
				content = val.formatted_address;
				//html = html +"<a class=\"link_sugestion\" onclick=\"openDialogUpdateSugestions("+val.latitude+","+val.longitude+","+idSP+","+idDQ+");\">"+content+"</a>";
				html = html +"<a class=\"link_sugestion\" onclick=\"openDialogUpdateLocalitySugestions("+idSP+","+idDQ+");\">"+content+"</a>";
				html = html+"</div>";
				
			});
			
		}

		return html;
}
	//sugest Datum
	function openDialogSugestDatum(idSP, idDQ){
		var html = '';
		var content = 'Datum: WGS84';
		html = html +"<a class=\"link_sugestion\" onclick=\"updateDatumSugestions("+idSP+","+idDQ+");\">"+content+"</a>";
		//alert(html);
		return html;
	  
	}

	function updateDatumSugestions(idSP, idDQ){
		var datum = 'WGS84';
		
		var ret = updateDatumSP(idSP,datum,idDQ);

    	if (ret == 1){
    		var htmlAux = "<div class='classChange_"+idDQ+idSP+"'>";
    		var fechaHtmlAux = "</div>";
		   
    		var btnShow = "<div class='btnShow'><a href='index.php?r=specimen/goToShow&id="+idSP+"' target='_blank'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Show Specimen Record'><span class='ui-icon ui-icon-search'></span></li></ul></a></div>";
            var btnCheck = "<div class='btnCheck' id=\"btnCheck"+idDQ+"_"+idSP+"\"><a><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' ><span class='ui-icon ui-icon-check'></span></li></ul></a></div>";
            var btnUndo = "<div class='btnUndo' id=\"btnUndo\"><a onclick=\"openDialogUndoCorrections("+idSP+","+idDQ+");\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Undo'><span class='ui-icon ui-icon-arrowreturnthick-1-s'></span></li></ul></a></div>";	

    		$(".classChange_"+idDQ+idSP).replaceWith(htmlAux+btnShow+btnCheck+fechaHtmlAux);
    	    	    
    		graphs(idDQ);

    		 var rs = new Array();
    		 var rs = {
    				 geodeticdatum: datum
    			
    			};
 			
    		var html = '';
			//check
			html = tipCheckTask(idDQ,idSP,rs);
			
			
			var idTip=idDQ+"_"+idSP;

			if (idDQ!=7){
				html = html + '<br/>'+'<div class="tipTask1">'+ btnUndo+'</div>';
			}
			
			if (html){
				
				var idTip=idDQ+"_"+idSP;
				
				
				$('#btnCheck'+idTip).poshytip({
					className: 'tip-twitter',
					showOn: 'hover',
					content: html,
					alignTo: 'target',
					alignX: 'center',
					alignY: 'bottom',
					offsetX: 5,
					offsetY: 5,
					allowTipHover: true,
					fade: false,
					slide: false
		        });

			}
    			
	
    	}
	}

	function openDialogSugestionsCol(value,taxonName,id_taxon,taxonType,idDQ){
	
		var array_sugestions = searchSugestionsCol(value,taxonName);

		//console.log(array_sugestions);
		
		var html = '';
		$.each(array_sugestions, function(index, val) {
			var content = '';
			html = html + '<div>';
			content = val.label; //sugestao que vai procurar
				
		
			html = html +"<a class='link_sugestion' onclick=\"openDialogUpdateTaxonsSugestions('"+id_taxon+"','"+content+"','"+taxonType+"','"+idDQ+"');\" >"+content+"</a>";
			html = html+"</div>";
			
		});

			
		if (html == ''){
			html = 'No sugestions';
		}

		return html;
		
		//$("#contentDialogSugestions").html(html);
		//$("#dialogSugestions").dialog('open');
		
	}


	function openDialogCheckTaxonHierarchy(fields, idSP, idDQ){

		///consultar hierarquia
		
				

		var myArray = fields.split('|');

		var genus = myArray[0];
		var family = myArray[1];
		var order = myArray[2];
		var classs = myArray[3];
		var phylum = myArray[4];
		var kingdom = myArray[5];
		
		
		if (genus == ''){
			genus = null;
		}
		if (family == ''){
			family = null;
		}
		if (order == ''){
			order = null;
		}
		if (classs == ''){
			classs = null;
		}
		if (phylum == ''){
			phylum = null;
		}
		if (kingdom == ''){
			kingdom = null;
		}
		
		var form_html = "Genus: "+genus;
		form_html = form_html+"<br/> Family: "+family;
		form_html = form_html+"<br/> Order: "+order;
		form_html = form_html+"<br/> Classs: "+classs;
		form_html = form_html+"<br/> Phylum: "+phylum;
		form_html = form_html+"<br/> Kingdom: "+kingdom;
		


		$( "#dialogCheckTaxonHierarchy" ).dialog({
	        autoOpen: false,
	        minHeight: 200,
	        minWidth: 200,
	        resizable: false,
	        modal: true
	        
	    });
	   
	    /*$( "#openAlertListSpecimens" ).dialog( "open" );
	    
		
		$("#contentDialogCheckTaxonHierarchy").html(form_html);
		
		
	 	$( "#dialogCheckTaxonHierarchy" ).dialog('open');*/

	 	return form_html;
	  
	}

	function openDialogSugestNamesLessSpecifics(idSP,idDQ){

		if(idDQ == 6){

			var rs = 0;
			 $.ajax({
			    	type:'POST',
			        url:'index.php?r=dataquality/GetColTaxonHierarchy',
			        data: {'id_specimen':idSP,'idDQ':idDQ},
			        dataType: "json",
			        async: false,
			        success:function(json) {
			            rs = json;
			    	}
			  });	
			 if (rs!=0){
				var array_fields = getLocalTaxonHierarchy(idSP,idDQ);
	
					
				//console.log(array_fields);
				var array_sugestions = rs;

				$.each(array_sugestions, function(index, val) {
					// console.log(val);
					
						var i = 0;
						html = html + '<td><div>';
						for (i=0;i<10;i++){
							if (val[i]){
								if (val[i].taxon=='Genus'){
									gs = val[i].name;
								}
								else if (val[i].taxon=='Family'){
									fs = val[i].name;
								}
								else if (val[i].taxon=='Order'){
									os = val[i].name;
								}
								else if (val[i].taxon=='Class'){
									cs = val[i].name;
								}
								else if (val[i].taxon=='Phylum'){
									ps = val[i].name;
								}
								else if (val[i].taxon=='Kingdom'){
									ks = val[i].name;
								}
							}
						}
						
				
				});
				
				
				var html = '';
				
					var content = '';
					
					//content = val.formatted_address+' - Lat: '+val.latitude +' - Long: '+val.longitude;
					//html = html +"<a class=\"link_sugestion\" onclick=\"openDialogUpdateSugestions("+val.latitude+","+val.longitude+","+idSP+","+idDQ+");\">"+content+"</a>";
					var genus = array_fields[0].genus?array_fields[0].genus:gs;
					var html = "Genus: "+genus;
					var family = array_fields[0].family?array_fields[0].family:fs;
					html = html+"<br/> Family: "+family;
					var order = array_fields[0].order?array_fields[0].order:os;
					html = html+"<br/> Order: "+order;
					var classs = array_fields[0].class?array_fields[0].class:cs;
					html = html+"<br/> Classs: "+classs;
					var phylum = array_fields[0].phylum?array_fields[0].phylum:ps;
					html = html+"<br/> Phylum: "+phylum;
					var kingdom=array_fields[0].kingdom?array_fields[0].kingdom:ks;
					html = html+"<br/> Kingdom: "+kingdom;

				
			 }

			
		}
		
		/*$("#contentSugestNamesLessSpecifics").html(html);
		$("#dialogSugestNamesLessSpecifics" ).data('idSP', idSP);
		$("#dialogSugestNamesLessSpecifics").dialog('open');*/
		var btn = '<button id="salve" class="btn btnSalvar" type="button" style="display: inline-block;">Salvar</button>';
		html = html+ '<br/><br/>';
		html = html+ '<p align="center"> <a onclick=\"updateNamesLessSpecifics('+idSP+');\">'+btn+'</a> </p>';

		//<a class="btnSalvar" ;"="" onclick="updateNamesLessSpecifics(57)">Salvar</a>
		return html;

	  	
	}


function updateNamesLessSpecifics(idSP){

	var ret = updateTaxonHierarchy(idSP,6);
	//alert(ret);
	
	if (ret == 1){
		alert('The data has been successfully updated.');

		///mostrar botaão undo
		var idDq = 6;
		var htmlAux = "<div class='classChange_"+idDq+idSP+"'>";
	        		var fechaHtmlAux = "</div>";
	     var array_fields = getLocalTaxonHierarchy(idSP,idDq);
	
	     var fields = array_fields[0].genus+'|'+array_fields[0].family+'|'+array_fields[0].order+'|'+array_fields[0].class+'|'+array_fields[0].phylum+'|'+array_fields[0].kingdom;
	    	   
	      var btnShow = "<div class='btnShow'><a href='index.php?r=specimen/goToShow&id="+idSP+"' target='_blank'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Show Specimen Record'><span class='ui-icon ui-icon-search'></span></li></ul></a></div>";
	      var btnCheck = "<div class='btnCheck' id=\"btnCheck"+idDq+"_"+idSP+"\"><a onclick=\"openDialogCheckTaxonHierarchy('"+fields+"'"+","+idSP+","+idDq+");\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Corrections OK'><span class='ui-icon ui-icon-check'></span></li></ul></a></div>";
	      	

	     $(".classChange_"+idDq+idSP).replaceWith(htmlAux+btnShow+btnCheck+fechaHtmlAux);
	     graphs(idDq);   

	    
	     var rs = new Array();
		 var rs = {
				 genus: array_fields[0].genus,
				 family: array_fields[0].family,
				 order: array_fields[0].order,
				 class: array_fields[0].class,
				 phylum:array_fields[0].phylum,
				 kingdom:array_fields[0].kingdom
			};

		    var btnUndo = "<div class='btnUndo' id=\"btnUndo"+idDq+"_"+idSP+"\"><a onclick=\"openDialogUndoCorrections("+idSP+","+idDq+");\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Undo'><span class='ui-icon ui-icon-arrowreturnthick-1-s'></span></li></ul></a></div>";
	     	var html = '';
			//check
			html = tipCheckTask(idDq,idSP,rs);
			var idTip=idDq+"_"+idSP;
			if (html){
				if (idDq!=7){
					html = html + '<br/>'+'<div class="tipTask1">'+ btnUndo+'</div>';
				}
				$('#btnCheck'+idTip).poshytip({
					className: 'tip-twitter',
					showOn: 'hover', 
					content: html,
					alignTo: 'target',
					alignX: 'center',
					alignY: 'bottom',
					offsetX: 5,
					offsetY: 5,
					allowTipHover: true,
					fade: false,
					slide: false
		        });

			}
			    		
		
	}
	else {
		alert('There was an error to update the hierarchy.');
		
	}
}
function openDialogTaxonHierarchySugestions(idSP,idDQ){
	var html = '';
	var content = '';
	
   
	if(idDQ == 3){

		var rs = null;
		 $.ajax({
		    	type:'POST',
		        url:'index.php?r=dataquality/GetColTaxonHierarchy',
		        data: {'id_specimen':idSP,'idDQ':idDQ},
		        dataType: "json",
		        async: false,
		        success:function(json) {
		        	
		            rs = json;
		    	}
		  });	

		 //console.log(rs);
		 
		 if (rs){

			
			var array_sugestions = rs;
			//console.log(array_sugestions);
			 /*
			
				
				//content = val.formatted_address+' - Lat: '+val.latitude +' - Long: '+val.longitude;
				//html = html +"<a class=\"link_sugestion\" onclick=\"openDialogUpdateSugestions("+val.latitude+","+val.longitude+","+idSP+","+idDQ+");\">"+content+"</a>";
				var html = "Genus: "+array_sugestions[0].genus;
				html = html+"<br/> Family: "+array_sugestions[1].family;
				html = html+"<br/> Order: "+array_sugestions[2].order;
				html = html+"<br/> Classs: "+array_sugestions[3].class;
				html = html+"<br/> Phylum: "+array_sugestions[4].phylum;
				html = html+"<br/> Kingdom: "+array_sugestions[5].kingdom;
				//console.log(html);*/

			var count = 0;
			html = html + '<table class="tableSugestions"><tr>';
			var idSugestion=1;
			 $.each(array_sugestions, function(index, val) {
					// console.log(val);
					if (count<3){
						var i = 0;
						html = html + '<td><div>';
						for (i=0;i<10;i++){
							if (val[i]){
								if (val[i].taxon=='Genus'){
									html = html+"<br/> Genus: "+val[i].name;
								}
								else if (val[i].taxon=='Family'){
									html = html+"<br/> Family: "+val[i].name;
								}
								else if (val[i].taxon=='Order'){
									html = html+"<br/> Order: "+val[i].name;
								}
								else if (val[i].taxon=='Classs'){
									html = html+"<br/> Classs: "+val[i].name;
								}
								else if (val[i].taxon=='Phylum'){
									html = html+"<br/> Phylum: "+val[i].name;
								}
								else if (val[i].taxon=='Kingdom'){
									html = html+"<br/> Kingdom: "+val[i].name;
								}
							}
						}
						html = html+"</div>";
	
						var btn = '<button id="salve" class="btn btnSalvar" type="button" style="display: inline-block;">Salvar</button>';
						html = html+ '<br/>';
						html = html+ '<p align="center"> <a onclick=\"updateTaxonHierarchySugestions('+idSP+','+idSugestion+');\">'+btn+'</a> </p>';
						html = html + '</td>';
						idSugestion = idSugestion+1;
						count = count+1;
					}
					
				});
			 html = html + '</tr></table>';
				
		 }
		
	}

	

	
	return html;
	//$("#contentTaxonHierarchySugestions").html(html);
	//$( "#dialogTaxonHierarchySugestions" ).data('idSP', idSP);
	//$("#dialogTaxonHierarchySugestions").dialog('open');

  	
}

function updateTaxonHierarchySugestions(idSP,sugestion){
	var ret = updateTaxonHierarchy(idSP,3,sugestion);
	//alert(ret);
	
	if (ret == 1){
		alert('The Hierarchy has been successfully updated.');

		///mostrar botaão undo
		var idDq = 3;
		var htmlAux = "<div class='classChange_"+idDq+idSP+"'>";
	        		var fechaHtmlAux = "</div>";
	     var array_fields = getLocalTaxonHierarchy(idSP,idDq);
	
	     var fields = array_fields[0].genus+'|'+array_fields[0].family+'|'+array_fields[0].order+'|'+array_fields[0].class+'|'+array_fields[0].phylum+'|'+array_fields[0].kingdom;
	    	   
	      var btnShow = "<div class='btnShow'><a href='index.php?r=specimen/goToShow&id="+idSP+"' target='_blank'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Show Specimen Record'><span class='ui-icon ui-icon-search'></span></li></ul></a></div>";
	      var btnCheck = "<div class='btnCheck' id=\"btnCheck"+idDq+"_"+idSP+"\"><a onclick=\"openDialogCheckTaxonHierarchy('"+fields+"'"+","+idSP+","+idDq+");\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Corrections OK'><span class='ui-icon ui-icon-check'></span></li></ul></a></div>";
	      var btnUndo = "<div class='btnUndo' id=\"btnUndo\"><a onclick=\"openDialogUndoCorrections("+idSP+","+idDq+");\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Undo'><span class='ui-icon ui-icon-arrowreturnthick-1-s'></span></li></ul></a></div>";	

	     $(".classChange_"+idDq+idSP).replaceWith(htmlAux+btnShow+btnCheck+fechaHtmlAux);
	     graphs(idDq);       		

	     var rs = new Array();
		 var rs = {
				 genus: array_fields[0].genus,
				 family: array_fields[0].family,
				 order: array_fields[0].order,
				 class: array_fields[0].class,
				 phylum:array_fields[0].phylum,
				 kingdom:array_fields[0].kingdom
			};

		    var btnUndo = "<div class='btnUndo' id=\"btnUndo"+idDq+"_"+idSP+"\"><a onclick=\"openDialogUndoCorrections("+idSP+","+idDq+");\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Undo'><span class='ui-icon ui-icon-arrowreturnthick-1-s'></span></li></ul></a></div>";
	     	var html = '';
			//check
			html = tipCheckTask(idDq,idSP,rs);
			var idTip=idDq+"_"+idSP;
			if (html){
				if (idDq!=7){
					html = html + '<br/>'+'<div class="tipTask1">'+ btnUndo+'</div>';
				}
				$('#btnCheck'+idTip).poshytip({
					className: 'tip-twitter',
					showOn: 'hover',
					content: html,
					alignTo: 'target',
					alignX: 'center',
					alignY: 'bottom',
					offsetX: 5,
					offsetY: 5,
					allowTipHover: true,
					fade: false,
					slide: false
		        });

			}
	}
	else {
		alert('There was an error to update the hierarchy.');
		
	}



}



</script>	


</div>