var camposPreenchidosEventElements = new Array();
camposPreenchidosEventElements.push(0);

function concatenarValoresUrlEventElements(){
	var url = "";
	
    
    return url;
	
}

function escondeBotaoResetEventElements(){
	// esconde os botões de limpar de todos os camos
        //CONFERIR SE HA A NECESSIDADE
 	//$("#divcollectingmethodReset").css("display","none");
 	//$("#divvaliddistributionflagReset").css("display","none");
 	//$("#divcollectorReset").css("display","none");
	
}

function selecionaItemEventElements(campo, valor, idValor, sugerir){
	
	//escondeBotaoResetEventElements();
	var camposReset = new Array();
	camposReset.push(0);
	
	//alert(sugerir)
	
	switch(campo){

		case "collectingmethod":
			
	
			$('#eventelements_idcollectingmethod').val(idValor);
		     	$('#collectingmethod').val(valor);
                        $('#collectingmethodvalue').val(valor);
		
//                                $("#divcollectingmethodReset").css("display","block");
//
//		 		if (valor!=''){
//		 			dasabilitaCampos("collectingmethod");
//		 			$('#divcollectingmethodValor').text(valor);
//		 		}else
//		 			habilitaCampos("collectingmethod");
	     	
	    	camposReset.push("collectingmethod");
	 		camposPreenchidosEventElements.push(camposReset);
	     	
		break;

		case "validdistributionflag":
			
			$('#eventelements_idvaliddistributionflag').val(idValor);
                        $('#validdistributionflag').val(valor);
		
//                                $("#divvaliddistributionflagReset").css("display","block");
//
//		 		if (valor!=''){
//		 			dasabilitaCampos("validdistributionflag");
//		 			$('#divvaliddistributionflagValor').text(valor);
//		 		}else
//		 			habilitaCampos("validdistributionflag");
	     	
	    	camposReset.push("validdistributionflag");
	 		camposPreenchidosEventElements.push(camposReset);
	     	
		break;	
		
		case "collector":
			
			$('#eventelements_idcollector').val(idValor);
                        $('#collector').val(valor);
                        $('#collectorvalue').val(valor);
		
//                        $("#divcollectorReset").css("display","block");
//
//                        if (valor!=''){
//                                dasabilitaCampos("collector");
//                                $('#divcollectorValor').text(valor);
//                        }else
//                                habilitaCampos("collector");
	     	
	    	camposReset.push("collector");
	 		camposPreenchidosEventElements.push(camposReset);
	     	
		break;

                case "samplingprotocol":

			$('#eventelements_idsamplingprotocol').val(idValor);
                        $('#samplingprotocol').val(valor);
                        $('#samplingprotocolvalue').val(valor);

//                        $("#divcollectorReset").css("display","block");
//
//                        if (valor!=''){
//                                dasabilitaCampos("collector");
//                                $('#divcollectorValor').text(valor);
//                        }else
//                                habilitaCampos("collector");

	    	camposReset.push("samplingprotocol");
	 		camposPreenchidosEventElements.push(camposReset);

		break;

        case "habitatevent":

			$('#eventelements_idhabitatevent').val(idValor);
	        $('#habitatevent').val(valor);
	        $('#habitateventvalue').val(valor);


	    	camposReset.push("habitatevent");
	 		camposPreenchidosEventElements.push(camposReset);

		break;

	}

	$('#overlay').fadeOut('normal');	
	$('#lightbox').fadeOut('normal');	
}

function limpaCamposEventElements(){

	var arrayAux = camposPreenchidosEventElements.pop();
	
	campo = "vazio"
	while (campo!=0){
		campo = arrayAux.pop();
		if (campo!=0){
			$("#"+campo).val("");
                        $("#"+campo+"value").val("");
	 	 	$("#EventElements_id"+campo).val("");
	 	 	habilitaCampos(campo);
	 	 	$("#"+campo+"Reset").css("display","none");
		}
	}
	if (camposPreenchidosEventElements!=0){
		campoPreenchidosAux = camposPreenchidosEventElements.slice();
		arrayAux2 = campoPreenchidosAux.pop().slice(); 	 	
		campo = arrayAux2.pop(); 	 	
		$("#div"+campo+"Reset").css("display","block");
	}		
	
}

function insertDataEventElements(fieldTarget, fieldIdTarget, urlTarget, extraParams){

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
				
				escondeBotaoResetEventElements();
				var camposReset = new Array();
				camposReset.push(0);						
				
		/*		$("#div"+fieldTarget.attr("id")+"Reset").css("display","block");
	         	
	 	 		if (msg.split("|||")[0]!=''){	         	 		
	 	 			dasabilitaCampos(fieldTarget.attr("id"));
	 	 			$('#div'+fieldTarget.attr("id")+'Valor').text(msg.split("|||")[0]);
	 	 		}else
	 	 			habilitaCampos(fieldTarget.attr("id"));	         	
	         	*/
	        	camposReset.push(fieldTarget.attr("id"));
	     		camposPreenchidosEventElements.push(camposReset);

			}else{	
				$('div[class^=target]').html(msg);				
			}
	   }
	 });	
}
