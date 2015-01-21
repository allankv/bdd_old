<?php include_once("protected/extensions/config.php"); ?>
<input id="id_taxon" type="hidden" value="<?php echo $id_taxon;?>">
<input id="taxonType" type="hidden" value="<?php echo $taxonType;?>">


<style>
div {
    font-size: 1.01em !important;
    line-height: 1.1 !important;
}



</style>




	<br/>
	<br/>
	
	 
    <div id="divTableList" class="listsp" style="display:inline-block;">
		<table id="tablelist" class="list tableListSP" style="margin-top:-10px;" width="750px">
	        <thead><tr><th style="text-align:left;" width="400px">Specimen Name</th>
	        <th style="text-align:left;" width="450px">Institution</th>
	        <th style="text-align:left;" width="150px">Collection</th>
	        <th style="text-align:center;" width="150px">Catalog Number</th>
	        <th style="text-align:center;" width="100px">Options</th></tr>
	        </thead>
	        <tbody class="lines_specimens"></tbody>
	    </table>    
	    
	    
		<div class="filter">
		    <div class="centerSlider"> 
			    <div class="slider" id="slidersp"></div> 
			   <div class="countRegister">
			   	 Register number from <b><span id="startsp"></span></b> to <b><span id="endsp"></span></b> of <b><span id="maxsp"></span></b>
			   </div> 
			    
		    </div>
		    <div style="clear:both"></div>
		    <div class="filterList">
		    <div id="filterList"></div>
		    </div>
		</div>
		
		<br/><br/>
	
	</div>
	
	

<script>
 


	var start = 0;
	var end = 10;
	var max = 10;
	var interval = 10;
	var handleSize = 50;  


    $(function () {

    	$('.listsp').hide();

    	var id_taxon = $("#id_taxon").val();
    	var taxonType = $("#taxonType").val();
    	listSpecimens(id_taxon,taxonType);
    
    	
    });

	
    

   function slidersp(id_taxon,taxonType){

	   
	   
        $("#slidersp").slider({
            range: false,
            min:0,
            max:max - interval,
            value:start,
            stop: function(event, ui) {
                start = ui.value;
                end = start + interval;
                listSpecimens(id_taxon,taxonType);
            },



            slide:function(event, ui) {
                $('#startsp').html(ui.value);
                $('#endsp').html((ui.value + interval));
            }
        }).find( ".ui-slider-handle" ).css({
    			width: handleSize
    		});
	 }
    
    function listSpecimens(id_taxon,taxonType){

    	
    	
    	var ret  = 0;
        $.ajax({
        	type:'POST',
        	 url:'index.php?r=dataquality/ListSpecimensByIdTaxon',
            data: {'list':jFilterList,'id_taxon':id_taxon,'taxonType':taxonType,'limit':interval, 'offset':start},
            dataType: "json",
	        async: false,
            success:function(json) {
                var rs = new Object();
                
                
                $(".lines_specimens").html('');

                max = parseInt(json.count);

               
                
                if (start > max) {
                	start = 0;
                }

                $('#startsp').html(start);

                end = start + interval;

                if (end > max) { 
                	end = max;
                }

                $('#endsp').html(end);
                $('#maxsp').html(max);

                
                rs = json.result;
                
    			    		
                slidersp(id_taxon,taxonType);
                
 		
               
				//rs = null;
				$('.listsp').hide();
                for(var i in rs) {    

                	
                	$('.listsp').show();
                	insertLine_Specimens(rs[i]);
                	
                }	

                

    			

            },
            cache: false
        });

		return ret;
        
    }

    function insertLine_Specimens(rs){
		 var line ='<tr id="id__ID_"><td style="text-indent:5px;"> _NAME_ </td>';
		 line = line+ '<td style="text-indent:5px;"> _INSTITUTION_ </td>';
		 line = line+ '<td style="text-indent:5px; "> _COLLECTION_ </td>';
		 line = line+ '<td style="text-indent:5px; text-align:center;"> _CATALOGNUMBER_ </td>';
		 line = line+'<td style="width:160px; text-align:center; text-indent:0px;">_BUTTONS_</td></tr>';
	     
	    
	   //var btnFlag = "<div class='btnFlag' id=\"btnCheck\"><a onclick=\"openDialogSugestionsCol('"+rs.value+"','"+taxonName+"','"+rs.id+"','"+taxonType+"');\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Sugestions'><span class='ui-icon ui-icon-flag'</span></li></ul></a></div>";
	    //var btnUndo = "<div class='btnUndo' id=\"btnUndo\"><a><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Undo'><span class='ui-icon ui-icon-arrowreturnthick-1-s'></span></li></ul></a></div>";
	    var btnShow = "<div class='btnShow'><a href='index.php?r=specimen/goToShow&id="+rs.id+"' target=\"_blank\"><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all' title='Show Specimen Record'><span class='ui-icon ui-icon-search'></span></li></ul></a></div>";

	    var htmlAux = "<div class='classChange_"+rs.id+"'>";
	    var fechaHtmlAux = "</div>";

	    var aux = line; 
	    aux = aux.replace('_NAME_',rs.scientificname);
	    aux = aux.replace('_INSTITUTION_',rs.institution);
	    aux = aux.replace('_COLLECTION_',rs.collection);
	    aux = aux.replace('_CATALOGNUMBER_',rs.catalognumber);

	    
	    aux = aux.replace('_BUTTONS_',htmlAux+btnShow+fechaHtmlAux);

		//alert(aux);
		
	    $(".lines_specimens").append(aux);
}
   
</script>


