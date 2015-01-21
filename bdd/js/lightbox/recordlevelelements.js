var camposPreenchidosRecordLevelElements = new Array();
camposPreenchidosRecordLevelElements.push(0);

function concatenarValoresUrlRecordLevelElements(){
	var url = "";
    
    return url;
	
}

function escondeBotaoResetRecordLevelElements(){
	// esconde os botões de limpar de todos os campos
 	//$("#divbasisofrecordReset").css("display","none");
 	//$("#divinstitutioncodeReset").css("display","none");
 	//$("#divcollectioncodeReset").css("display","none");
 	 	
}

function selecionaItemTaxonomicElements(campo, valor, idValor, sugerir){

	//escondeBotaoResetTaxonomicElements();
	//var camposReset = new Array();
	//camposReset.push(0);

	//alert(sugerir)

	switch(campo){
            case "scientificname":
                    $('#recordlevelelements_idscientificname').val(idValor);
                    $('#scientificname').val(valor);
                    $('#scientificnamevalue').val(valor);
            break;
        }
        $('#overlay').fadeOut('normal');
	$('#lightbox').fadeOut('normal');
}

function selecionaItemRecordLevelElements(campo, valor, idValor, sugerir){
	
	escondeBotaoResetRecordLevelElements();
	var camposReset = new Array();
	camposReset.push(0);
	
	//alert(sugerir)
	
	switch(campo){

		case "basisofrecord":
			
			$('#recordlevelelements_idbasisofrecord').val(idValor);
                        $('#basisofrecord').val(valor);
		
//			$("#divbasisofrecordReset").css("display","block");
//
//                        if (valor!=''){
//                                dasabilitaCampos("basisofrecord");
//                                $('#divbasisofrecordValor').text(valor);
//                        }else
//                                habilitaCampos("basisofrecord");
	     	
                        camposReset.push("basisofrecord");
	 		camposPreenchidosRecordLevelElements.push(camposReset);         	
	     	
		break;
		
		case "institutioncode":
			
			$('#recordlevelelements_idinstitutioncode').val(idValor);
                        $('#institutioncode').val(valor);
                        $('#institutioncodevalue').val(valor);
		

//			$("#divinstitutioncodeReset").css("display","block");
//
//                        if (valor!=''){
//                                dasabilitaCampos("institutioncode");
//                                $('#divinstitutioncodeValor').text(valor);
//                        }else
//                                habilitaCampos("institutioncode");
     	
                        camposReset.push("institutioncode");
	 		camposPreenchidosRecordLevelElements.push(camposReset);         	
	     	
		break;

                case "ownerinstitution":

			$('#recordlevelelements_idownerinstitution').val(idValor);
                        $('#ownerinstitution').val(valor);
                        $('#ownerinstitutionvalue').val(valor);


//			$("#divinstitutioncodeReset").css("display","block");
//
//                        if (valor!=''){
//                                dasabilitaCampos("institutioncode");
//                                $('#divinstitutioncodeValor').text(valor);
//                        }else
//                                habilitaCampos("institutioncode");

                        camposReset.push("ownerinstitution");
	 		camposPreenchidosRecordLevelElements.push(camposReset);

		break;
	
                case "dataset":

			$('#recordlevelelements_iddataset').val(idValor);
                        $('#dataset').val(valor);
                        $('#datasetvalue').val(valor);


//			$("#divinstitutioncodeReset").css("display","block");
//
//                        if (valor!=''){
//                                dasabilitaCampos("institutioncode");
//                                $('#divinstitutioncodeValor').text(valor);
//                        }else
//                                habilitaCampos("institutioncode");

                        camposReset.push("datasetname");
	 		camposPreenchidosRecordLevelElements.push(camposReset);

		break;

                case "collectioncode":

			$('#recordlevelelements_idcollectioncode').val(idValor);
                        $('#collectioncode').val(valor);
                        $('#collectioncodevalue').val(valor);

//                        $("#divcollectioncodeReset").css("display","block");
//
//                        if (valor!=''){
//                                dasabilitaCampos("collectioncode");
//                                $('#divcollectioncodeValor').text(valor);
//                        }else
//                                habilitaCampos("collectioncode");

                        camposReset.push("collectioncode");
	 		camposPreenchidosRecordLevelElements.push(camposReset);

		break;


	}
	$('#overlay').fadeOut('normal');	
	$('#lightbox').fadeOut('normal');
	
	habilitaLinkDesfazerTaxonomicElements();
	
}

function limpaCamposRecordLevelElements(){

	var arrayAux = camposPreenchidosRecordLevelElements.pop();
	
	campo = "vazio"
	while (campo!=0){
		campo = arrayAux.pop();
		if (campo!=0){
			$("#"+campo).val("");
                        $("#"+campo+"value").val("");
	 	 	$("#recordlevelelements_id"+campo).val("");
	 	 	habilitaCampos(campo);
	 	 	$("#"+campo+"Reset").css("display","none");
		}
	}
	if (camposPreenchidosRecordLevelElements!=0){	 	
		campoPreenchidosAux = camposPreenchidosRecordLevelElements.slice(); 	 	
		arrayAux2 = campoPreenchidosAux.pop().slice(); 	 	
		campo = arrayAux2.pop(); 	 	
		//$("#div"+campo+"Reset").css("display","block");
	}		
	
}

function insertDataRecordLevelElements(fieldTarget, fieldIdTarget, urlTarget, extraParams){

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
				
				escondeBotaoResetRecordLevelElements();
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
	     		camposPreenchidosRecordLevelElements.push(camposReset);

			}else{	
				$('div[class^=target]').html(msg);
			}
	   }
	 });	
}