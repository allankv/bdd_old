var camposPreenchidosReferencesElements = new Array();
camposPreenchidosReferencesElements.push(0);

function concatenarValoresUrlReferencesElements(){
	var url = "";

    return url;

}

function escondeBotaoResetReferencesElements(){
	// esconde os botões de limpar de todos os camos
 	$("#divsexReset").css("display","none");
 	$("#divlifestageReset").css("display","none");
}

function selecionaItemReferencesElements(campo, valor, idValor, sugerir){

	escondeBotaoResetReferencesElements();
	var camposReset = new Array();
	camposReset.push(0);	

	switch(campo){
		case "subcategoryreferences":                        
			$('#referenceselements_idsubcategoryreferences').val(idValor);
            $('#subcategoryreferences').val(valor);
            $('#subcategoryreferencesvalue').val(valor);
            
	    	camposReset.push("subcategoryreferences");
	 		camposPreenchidosReferencesElements.push(camposReset);
	 		
		break;

		case "categoryreferences":
			$('#referenceselements_idcategoryreferences').val(idValor);
            $('#categoryreferences').val(valor);
            $('#categoryreferencesvalue').val(valor);
            
	    	camposReset.push("categoryreferences");
	 		camposPreenchidosReferencesElements.push(camposReset);
	 		
		break;
		
		case "creators":
			$('#referenceselements_idcreators').val(idValor);
            $('#creators').val(valor);
            $('#creatorsvalue').val(valor);
            
	    	camposReset.push("creators");
	 		camposPreenchidosReferencesElements.push(camposReset);
			
			
		break;

		
	}
	$('#overlay').fadeOut('normal');
	$('#lightbox').fadeOut('normal');
}

function limpaCamposReferencesElements(){

	var arrayAux = camposPreenchidosReferencesElements.pop();

	campo = "vazio"
	while (campo!=0){
		campo = arrayAux.pop();
		if (campo!=0){
			$("#"+campo).val("");
	 	 	$("#referenceselements_id"+campo).val("");
	 	 	habilitaCampos(campo);
	 	 	$("#"+campo+"Reset").css("display","none");
		}
	}
	if (camposPreenchidosReferencesElements!=0){
		campoPreenchidosAux = camposPreenchidosReferencesElements.slice();
		arrayAux2 = campoPreenchidosAux.pop().slice();
		campo = arrayAux2.pop();
		//$("#div"+campo+"Reset").css("display","block");
	}

}

function insertDataReferencesElements(fieldTarget, fieldIdTarget, urlTarget, extraParams){

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

				escondeBotaoResetReferencesElements();
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
	     		camposPreenchidosReferencesElements.push(camposReset);

			}else{
				$('div[class^=target]').html(msg);
			}
	   }
	 });
}