var camposPreenchidosGeospatialElements = new Array();
camposPreenchidosGeospatialElements.push(0);

function concatenarValoresUrlGeospatialElements(){
	var url = "";
	
    
    return url;
	
}


function escondeBotaoResetGeospatialElements(){
	// esconde os botões de limpar de todos os camos
 	$("#divgeospatialReset").css("display","none");
 	
}

function selecionaItemGeospatialElements(campo, valor, idValor, sugerir){
	
	//escondeBotaoResetGeospatialElements();
	var camposReset = new Array();
	camposReset.push(0);
	
	//alert(sugerir)

        switch(campo){

		case "georeferenceverificationstatus":

			$('#geospatialelements_idgeoreferenceverificationstatus').val(idValor);
            $('#georeferenceverificationstatus').val(valor);
            $('#georeferenceverificationstatusvalue').val(valor);

//			$("#divlocalityReset").css("display","block");
//
//                        if (valor!=''){
//                                dasabilitaCampos("locality");
//                                $('#divlocalityValor').text(valor);
//                        }else
//                                habilitaCampos("locality");

	    	camposReset.push("georeferenceverificationstatus");
	 		camposPreenchidosGeospatialElements.push(camposReset);

		break;
        }

	
	$('#overlay').fadeOut('normal');	
	$('#lightbox').fadeOut('normal');	
}

function limpaCamposGeospatialElements(){

	var arrayAux = camposPreenchidosGeospatialElements.pop();
	
	campo = "vazio"
	while (campo!=0){
		campo = arrayAux.pop();
		if (campo!=0){
			$("#"+campo).val("");
                        $("#"+campo+"value").val("");
	 	 	$("#geospatialelements_id"+campo).val("");
	 	 	habilitaCampos(campo);
	 	 	$("#"+campo+"Reset").css("display","none");
		}
	}
	if (camposPreenchidosGeospatialElements!=0){
		campoPreenchidosAux = camposPreenchidosGeospatialElements.slice();
		arrayAux2 = campoPreenchidosAux.pop().slice(); 	 	
		campo = arrayAux2.pop(); 	 	
		//$("#div"+campo+"Reset").css("display","block");
	}		
	
}


function insertDataGeospatialElements(fieldTarget, fieldIdTarget, urlTarget, extraParams){

$.ajax({
	   type: "POST",
	   url: urlTarget,
	   data: extraParams,		   
	   success: function(msg){	
				
			if(msg.indexOf("|||")>-1){
				fieldIdTarget.val(msg.split("|||")[1]);
				fieldTarget.val(msg.split("|||")[0]);
                                $("#"+fieldTarget.attr("id")+"value").val(msg.split("|||")[0]);
				$('#overlay').fadeOut('normal');
				$('#lightbox').fadeOut('normal');	
				
				escondeBotaoResetGeospatialElements();
				var camposReset = new Array();
				camposReset.push(0);						
				
//				$("#div"+fieldTarget.attr("id")+"Reset").css("display","block");
//
//	 	 		if (msg.split("|||")[0]!=''){
//	 	 			dasabilitaCampos(fieldTarget.attr("id"));
//	 	 			$('#div'+fieldTarget.attr("id")+'Valor').text(msg.split("|||")[0]);
//	 	 		}else
//	 	 			habilitaCampos(fieldTarget.attr("id"));
	         	
	        	camposReset.push(fieldTarget.attr("id"));
	     		camposPreenchidosGeospatialElements.push(camposReset);

			}else{	
				$('div[class^=target]').html(msg);				
			}
	   }
	 });	
}
