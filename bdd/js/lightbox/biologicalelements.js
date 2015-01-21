var camposPreenchidosBiologicalElements = new Array();
camposPreenchidosBiologicalElements.push(0);

function concatenarValoresUrlBiologicalElements(){
	var url = "";
    
    return url;
	
}


function escondeBotaoResetBiologicalElements(){
	// esconde os botões de limpar de todos os camos
 	$("#divsexReset").css("display","none");
 	$("#divlifestageReset").css("display","none");
}

function selecionaItemBiologicalElements(campo, valor, idValor, sugerir){
	
	escondeBotaoResetBiologicalElements();
	var camposReset = new Array();
	camposReset.push(0);
	
	//alert(sugerir)
	
	switch(campo){

		case "sex":
			
			$('#biologicalelements_idsex').val(idValor);
	     	$('#sex').val(valor);    	
		
			$("#divsexReset").css("display","block");
	     	
		 		if (valor!=''){	         	 		
		 			dasabilitaCampos("sex");
		 			$('#divsexValor').text(valor);
		 		}else
		 			habilitaCampos("sex");	
	     	
	    	camposReset.push("sex");
	 		camposPreenchidosBiologicalElements.push(camposReset);         	
	     	
		break;
		
		case "lifestage":
			
			$('#biologicalelements_idlifestage').val(idValor);
	     	$('#lifestage').val(valor);    	
		
			$("#divlifestageReset").css("display","block");
	     	
		 		if (valor!=''){	         	 		
		 			dasabilitaCampos("lifestage");
		 			$('#divlifestageValor').text(valor);
		 		}else
		 			habilitaCampos("lifestage");	
	     	
	    	camposReset.push("lifestage");
	 		camposPreenchidosBiologicalElements.push(camposReset);         	
	     	
		break;			
		
		
	}

	$('#overlay').fadeOut('normal');	
	$('#lightbox').fadeOut('normal');	
}

function limpaCamposBiologicalElements(){

	var arrayAux = camposPreenchidosBiologicalElements.pop();
	
	campo = "vazio"
	while (campo!=0){
		campo = arrayAux.pop();
		if (campo!=0){
			$("#"+campo).val("");
	 	 	$("#biologicalelements_id"+campo).val("");
	 	 	habilitaCampos(campo);
	 	 	$("#"+campo+"Reset").css("display","none");
		}
	}
	if (camposPreenchidosBiologicalElements!=0){	 	
		campoPreenchidosAux = camposPreenchidosBiologicalElements.slice(); 	 	
		arrayAux2 = campoPreenchidosAux.pop().slice(); 	 	
		campo = arrayAux2.pop(); 	 	
		$("#div"+campo+"Reset").css("display","block");
	}		
	
}


function insertDataBiologicalElements(fieldTarget, fieldIdTarget, urlTarget, extraParams){

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
				
				escondeBotaoResetBiologicalElements();
				var camposReset = new Array();
				camposReset.push(0);						
				
				$("#div"+fieldTarget.attr("id")+"Reset").css("display","block");
	         	
	 	 		if (msg.split("|||")[0]!=''){	         	 		
	 	 			dasabilitaCampos(fieldTarget.attr("id"));
	 	 			$('#div'+fieldTarget.attr("id")+'Valor').text(msg.split("|||")[0]);
	 	 		}else
	 	 			habilitaCampos(fieldTarget.attr("id"));	         	
	         	
	        	camposReset.push(fieldTarget.attr("id"));
	     		camposPreenchidosBiologicalElements.push(camposReset);

			}else{	
				$('div[class^=target]').html(msg);				
			}
	   }
	 });	
}
