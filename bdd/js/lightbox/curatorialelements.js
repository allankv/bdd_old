var camposPreenchidosCuratorialElements = new Array();
camposPreenchidosCuratorialElements.push(0);

function concatenarValoresUrlCuratorialElements(){
	var url = "";
    
    return url;
	
}


function escondeBotaoResetCuratorialElements(){
	// esconde os botões de limpar de todos os camos
 	//$("#divsexReset").css("display","none");
 	//$("#divlifestageReset").css("display","none");
}

function selecionaItemCuratorialElements(campo, valor, idValor, sugerir){
	
	escondeBotaoResetCuratorialElements();
	var camposReset = new Array();
	camposReset.push(0);
	
	//alert(sugerir)
	
	switch(campo){

		/*case "sex":
			
			$('#curatorialelements_idsex').val(idValor);
	     	$('#sex').val(valor);    	
		
			$("#divsexReset").css("display","block");
	     	
		 		if (valor!=''){	         	 		
		 			dasabilitaCampos("sex");
		 			$('#divsexValor').text(valor);
		 		}else
		 			habilitaCampos("sex");	
	     	
	    	camposReset.push("sex");
	 		camposPreenchidosCuratorialElements.push(camposReset);         	
	     	
		break;
		
		case "lifestage":
			
			$('#curatorialelements_idlifestage').val(idValor);
	     	$('#lifestage').val(valor);    	
		
			$("#divlifestageReset").css("display","block");
	     	
		 		if (valor!=''){	         	 		
		 			dasabilitaCampos("lifestage");
		 			$('#divlifestageValor').text(valor);
		 		}else
		 			habilitaCampos("lifestage");	
	     	
	    	camposReset.push("lifestage");
	 		camposPreenchidosCuratorialElements.push(camposReset);         	
	     	
		break;	*/
		
		case "dispositioncur":

			$('#curatorialelements_iddispositioncur').val(idValor);
	     	$('#dispositioncur').val(valor);    
	     	$('#dispositioncurvalue').val(valor);
		
//			$("#divdispositioncurReset").css("display","block");
//	     	
//		 		if (valor!=''){	         	 		
//		 			dasabilitaCampos("dispositioncur");
//		 			$('#divdispositioncurValor').text(valor);
//		 		}else
//		 			habilitaCampos("dispositioncur");	
//	     	
//	    	camposReset.push("dispositioncur");
//	 		camposPreenchidosCuratorialElements.push(camposReset);			
			
		break;
		
		
	}

	$('#overlay').fadeOut('normal');	
	$('#lightbox').fadeOut('normal');	
}

function limpaCamposCuratorialElements(){

	var arrayAux = camposPreenchidosCuratorialElements.pop();
	
	campo = "vazio"
	while (campo!=0){
		campo = arrayAux.pop();
		if (campo!=0){
			$("#"+campo).val("");
	 	 	$("#curatorialelements_id"+campo).val("");
	 	 	habilitaCampos(campo);
	 	 	$("#"+campo+"Reset").css("display","none");
		}
	}
	if (camposPreenchidosCuratorialElements!=0){
		campoPreenchidosAux = camposPreenchidosCuratorialElements.slice();
		arrayAux2 = campoPreenchidosAux.pop().slice(); 	 	
		campo = arrayAux2.pop(); 	 	
		$("#div"+campo+"Reset").css("display","block");
	}		
	
}


function insertDataCuratorialElements(fieldTarget, fieldIdTarget, urlTarget, extraParams){

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
				
				escondeBotaoResetCuratorialElements();
				var camposReset = new Array();
				camposReset.push(0);						
				
				$("#div"+fieldTarget.attr("id")+"Reset").css("display","block");
	         	
	 	 		if (msg.split("|||")[0]!=''){	         	 		
	 	 			dasabilitaCampos(fieldTarget.attr("id"));
	 	 			$('#div'+fieldTarget.attr("id")+'Valor').text(msg.split("|||")[0]);
	 	 		}else
	 	 			habilitaCampos(fieldTarget.attr("id"));	         	
	         	
	        	camposReset.push(fieldTarget.attr("id"));
	     		camposPreenchidosCuratorialElements.push(camposReset);

			}else{	
				$('div[class^=target]').html(msg);				
			}
	   }
	 });	
}
