var camposPreenchidosIdentificationElements = new Array();
camposPreenchidosIdentificationElements.push(0);

function concatenarValoresUrlIdentificationElements(){
	var url = "";
    
    return url;
	
}


function escondeBotaoResetIdentificationElements(){
	// esconde os botões de limpar de todos os camos
 	$("#divsexReset").css("display","none");
 	$("#divlifestageReset").css("display","none");
}

function selecionaItemIdentificationElements(campo, valor, idValor, sugerir){
	
	escondeBotaoResetIdentificationElements();
	var camposReset = new Array();
	camposReset.push(0);
	
	//alert(sugerir)
	
	switch(campo){

		case "identificationqualifier":
				//identificationelements_ididentificationqualifier
			$('#identificationelements_ididentificationqualifier').val(idValor);
                        $('#identificationqualifier').val(valor);
                        $('#identificationqualifiervalue').val(valor);
		
//			$("#dividentificationqualifierReset").css("display","block");
//
//                        if (valor!=''){
//                                dasabilitaCampos("identificationqualifier");
//                                $('#dividentificationqualifierValor').text(valor);
//                        }else
//                                habilitaCampos("identificationqualifier");
	     	
	    	camposReset.push("identificationqualifier");
	 		camposPreenchidosIdentificationElements.push(camposReset);         	
	     	
		break;

	}
	$('#overlay').fadeOut('normal');	
	$('#lightbox').fadeOut('normal');	
}

function limpaCamposIdentificationElements(){

	var arrayAux = camposPreenchidosIdentificationElements.pop();
	
	campo = "vazio"
	while (campo!=0){
		campo = arrayAux.pop();
		if (campo!=0){
			$("#"+campo).val("");
	 	 	$("#identificationelements_id"+campo).val("");
	 	 	habilitaCampos(campo);
	 	 	$("#"+campo+"Reset").css("display","none");
		}
	}
	if (camposPreenchidosIdentificationElements!=0){	 	
		campoPreenchidosAux = camposPreenchidosIdentificationElements.slice(); 	 	
		arrayAux2 = campoPreenchidosAux.pop().slice(); 	 	
		campo = arrayAux2.pop(); 	 	
		//$("#div"+campo+"Reset").css("display","block");
	}		
	
}


function insertDataIdentificationElements(fieldTarget, fieldIdTarget, urlTarget, extraParams){

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
				
				escondeBotaoResetIdentificationElements();
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
	     		camposPreenchidosIdentificationElements.push(camposReset);

			}else{	
				$('div[class^=target]').html(msg);				
			}
	   }
	 });	
}
