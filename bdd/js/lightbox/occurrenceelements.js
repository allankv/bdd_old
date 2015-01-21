var camposPreenchidosOccurrenceElements = new Array();
camposPreenchidosOccurrenceElements.push(0);

function concatenarValoresUrlOccurrenceElements(){
	var url = "";
	
    
    return url;
	
}

function escondeBotaoResetOccurrenceElements(){
	// esconde os botões de limpar de todos os camos
        //CONFERIR SE HA A NECESSIDADE
 	//$("#divcollectingmethodReset").css("display","none");
 	//$("#divvaliddistributionflagReset").css("display","none");
 	//$("#divcollectorReset").css("display","none");
	
}

function selecionaItemOccurrenceElements(campo, valor, idValor, sugerir){
	
	escondeBotaoResetOccurrenceElements();
	var camposReset = new Array();
	camposReset.push(0);
	
	//alert(sugerir)
	
	switch(campo){

		case "collectingmethod":
			
			$('#occurrenceelements_idcollectingmethod').val(idValor);
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
	 		camposPreenchidosOccurrenceElements.push(camposReset);
	     	
		break;

		case "validdistributionflag":
			
			$('#occurrenceelements_idvaliddistributionflag').val(idValor);
                        $('#validdistributionflag').val(valor);
		
//                                $("#divvaliddistributionflagReset").css("display","block");
//
//		 		if (valor!=''){
//		 			dasabilitaCampos("validdistributionflag");
//		 			$('#divvaliddistributionflagValor').text(valor);
//		 		}else
//		 			habilitaCampos("validdistributionflag");
	     	
	    	camposReset.push("validdistributionflag");
	 		camposPreenchidosOccurrenceElements.push(camposReset);
	     	
		break;	
		
		case "collector":
			
			$('#occurrenceelements_idcollector').val(idValor);
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
	 		camposPreenchidosOccurrenceElements.push(camposReset);
	     	
		break;

        case "disposition":
			$('#occurrenceelements_iddisposition').val(idValor);
            $('#disposition').val(valor);
            $('#dispositionvalue').val(valor);

//                        $("#divcollectorReset").css("display","block");
//
//                        if (valor!=''){
//                                dasabilitaCampos("collector");
//                                $('#divcollectorValor').text(valor);
//                        }else
//                                habilitaCampos("collector");

                        camposReset.push("disposition");
	 		camposPreenchidosOccurrenceElements.push(camposReset);

		break;


         case "dispositioncur":

//			$('#curatorialelements_iddispositioncur').val(idValor);			
//            $('#dispositioncur').val(valor);            	
//            $('#dispositioncurvalue').val(valor);
//
//            camposReset.push("dispositioncur");
//	 		camposPreenchidosCuratorialElements.push(camposReset);

		break;

                case "establishmentmeans":

			$('#occurrenceelements_idestablishmentmeans').val(idValor);
                        $('#establishmentmeans').val(valor);
                        $('#establishmentmeansvalue').val(valor);

//                        $("#divcollectorReset").css("display","block");
//
//                        if (valor!=''){
//                                dasabilitaCampos("collector");
//                                $('#divcollectorValor').text(valor);
//                        }else
//                                habilitaCampos("collector");

	    	camposReset.push("establishmentmeans");
	 		camposPreenchidosOccurrenceElements.push(camposReset);

		break;

                case "behavior":

			$('#occurrenceelements_idbehavior').val(idValor);
                        $('#behavior').val(valor);
                        $('#behaviorvalue').val(valor);

//                        $("#divcollectorReset").css("display","block");
//
//                        if (valor!=''){
//                                dasabilitaCampos("collector");
//                                $('#divcollectorValor').text(valor);
//                        }else
//                                habilitaCampos("collector");

	    	camposReset.push("behavior");
	 		camposPreenchidosOccurrenceElements.push(camposReset);

		break;

                case "reproductivecondition":

			$('#occurrenceelements_idreproductivecondition').val(idValor);
                        $('#reproductivecondition').val(valor);
                        $('#reproductiveconditionvalue').val(valor);

//                        $("#divcollectorReset").css("display","block");
//
//                        if (valor!=''){
//                                dasabilitaCampos("collector");
//                                $('#divcollectorValor').text(valor);
//                        }else
//                                habilitaCampos("collector");

	    	camposReset.push("reproductivecondition");
	 		camposPreenchidosOccurrenceElements.push(camposReset);

		break;

                case "lifestage":

			$('#occurrenceelements_idlifestage').val(idValor);
                        $('#lifestage').val(valor);
                        $('#lifestagevalue').val(valor);

//                        $("#divcollectorReset").css("display","block");
//
//                        if (valor!=''){
//                                dasabilitaCampos("collector");
//                                $('#divcollectorValor').text(valor);
//                        }else
//                                habilitaCampos("collector");

	    	camposReset.push("lifestage");
	 		camposPreenchidosOccurrenceElements.push(camposReset);

		break;

	}



	$('#overlay').fadeOut('normal');	
	$('#lightbox').fadeOut('normal');	
}

function limpaCamposOccurrenceElements(){

	var arrayAux = camposPreenchidosOccurrenceElements.pop();
	
	campo = "vazio"
	while (campo!=0){
		campo = arrayAux.pop();
		if (campo!=0){
			$("#"+campo).val("");
                        $("#"+campo+"value").val("");
	 	 	$("#OccurrenceElements_id"+campo).val("");
	 	 	habilitaCampos(campo);
	 	 	$("#"+campo+"Reset").css("display","none");
		}
	}
	if (camposPreenchidosOccurrenceElements!=0){
		campoPreenchidosAux = camposPreenchidosOccurrenceElements.slice();
		arrayAux2 = campoPreenchidosAux.pop().slice(); 	 	
		campo = arrayAux2.pop(); 	 	
		//$("#div"+campo+"Reset").css("display","block");
	}		
	
}

function insertDataOccurrenceElements(fieldTarget, fieldIdTarget, urlTarget, extraParams){

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
				
				escondeBotaoResetOccurrenceElements();
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
	     		camposPreenchidosOccurrenceElements.push(camposReset);

			}else{	
				$('div[class^=target]').html(msg);				
			}
	   }
	 });	
}
