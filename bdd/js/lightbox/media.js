var camposPreenchidosMedia = new Array();
camposPreenchidosMedia.push(0);

function concatenarValoresUrlMedia(){
	var url = "";

    return url;

}

function escondeBotaoResetMedia(){
	// esconde os botões de limpar de todos os camos
 	//$("#divsexReset").css("display","none");
 	//$("#divlifestageReset").css("display","none");
}

function selecionaItemMedia(campo, valor, idValor, sugerir){

	escondeBotaoResetMedia();
	var camposReset = new Array();
	camposReset.push(0);

	switch(campo){

        case "subcategorymedia":                        
			$('#media_idsubcategorymedia').val(idValor);
            $('#subcategorymedia').val(valor);
            $('#subcategorymediavalue').val(valor);

	    	camposReset.push("subcategorymedia");
	 		camposPreenchidosMedia.push(camposReset);
	 		
		break;

        case "categorymedia":
			$('#media_idcategorymedia').val(idValor);
            $('#categorymedia').val(valor);
            $('#categorymediavalue').val(valor);

	    	camposReset.push("categorymedia");
	 		camposPreenchidosMedia.push(camposReset);
	 		
		break;

		case "capturedevice":
			
			$('#media_idcapturedevice').val(idValor);
            $('#capturedevice').val(valor);
            $('#capturedevicevalue').val(valor);

	    	camposReset.push("capturedevice");
	 		camposPreenchidosMedia.push(camposReset);
	 		
		break;

        case "provider":
			$('#media_idprovider').val(idValor);
	        $('#provider').val(valor);
	        $('#providervalue').val(valor);

	    	camposReset.push("provider");
	 		camposPreenchidosMedia.push(camposReset);
		break;

        case "metadataprovider":
			$('#media_idmetadataprovider').val(idValor);
	        $('#metadataprovider').val(valor);
	        $('#metadataprovidervalue').val(valor);

	    	camposReset.push("metadataprovider");
	 		camposPreenchidosMedia.push(camposReset);
		break;
		
        case "creators":
        
			$('#media_idcreators').val(idValor);
	        $('#creators').val(valor);
	        $('#creatorsvalue').val(valor);
	        
	    	camposReset.push("creators");
	 		camposPreenchidosMedia.push(camposReset);
 		
 		break;

	}
	$('#overlay').fadeOut('normal');
	$('#lightbox').fadeOut('normal');
}

function limpaCamposMedia(){

	var arrayAux = camposPreenchidosMedia.pop();

	campo = "vazio"
	while (campo!=0){
		campo = arrayAux.pop();
		if (campo!=0){
			$("#"+campo).val("");
	 	 	$("#media_id"+campo).val("");
	 	 	habilitaCampos(campo);
	 	 	$("#"+campo+"Reset").css("display","none");
		}
	}
	if (camposPreenchidosMedia!=0){
		campoPreenchidosAux = camposPreenchidosMedia.slice();
		arrayAux2 = campoPreenchidosAux.pop().slice();
		campo = arrayAux2.pop();
		//$("#div"+campo+"Reset").css("display","block");
	}

}

function insertDataMedia(fieldTarget, fieldIdTarget, urlTarget, extraParams){

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

				escondeBotaoResetMedia();
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
	     		camposPreenchidosMedia.push(camposReset);

			}else{
				$('div[class^=target]').html(msg);
			}
	   }
	 });
}