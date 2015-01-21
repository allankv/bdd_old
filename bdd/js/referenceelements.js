function controleExibicao(objDivID){
	
	if(document.getElementById(objDivID).style.display=='none'){
		
		document.getElementById(objDivID).style.display='block';
			
	}else{
		
		document.getElementById(objDivID).style.display='none';
		
	}
		
	
}

function habilitaDropDownList(campo){
	
	switch(campo){
		
//		
//		case "referenceselements_idtypereferences":
//			
//			campoDesabilitado = "referenceselements_title";
//			linkDesfazerHabilitado = "";
//			
//			break;
//			
//		case "referenceselements_title":
//			
//
//			campoDesabilitado = "";
//			linkDesfazerHabilitado = "referenceselements_idtypereferences";
//			
//			break;
	
		case "referenceselements_idsubtypereferences":
			
			campoDesabilitado = "";
			linkDesfazerHabilitado = "referenceselements_idtypereferences";			
			
			break;
			
		case "referenceselements_idtypereferences":

			campoDesabilitado = "referenceselements_idsubtypereferences";
			linkDesfazerHabilitado = "";		
		
			
			break;
	
	}
	
	
	// reinicia o valor do campo
	$("#"+campo).val("")
	
	$("#"+campo+"Combo").val("");

	$("#"+campo+"Combo").removeAttr("disabled");
	
	//habilita o desfazer para o campo acima
	if(linkDesfazerHabilitado!=""){
		
		$("#div-"+linkDesfazerHabilitado+"Undo").css('display','block');
		
	}	
	
	// desabilita o desfazer do campo atual
	$("#div-"+campo+"Undo").css('display','none');

	if(campoDesabilitado!=""){

		// desabilita o campo abaixo
		$("#"+campoDesabilitado).val("")
		$("#"+campoDesabilitado+"Combo").val("")
		$("#"+campoDesabilitado+"Combo").attr("disabled", true);
		
	}
	
	// requisita novos valores para o campo logo abaixo
	requisitaValoresDropDownList(campo)	
	
}

/*
 *  requisita e preenche valores para o dropdownlist passado por parametro
 */


function requisitaValoresDropDownList(campo,desabilitarCampoAcima){
	
	var action = "";
	var parametros = "";
	var campoDesabilitado = "";
	var linkDesfazerDesabilitado = "";
	
	if(desabilitarCampoAcima==null)
		desabilitarCampoAcima = true;

		
	switch(campo){

//
//		case "referenceselements_title" :
//			
//			action = "getTitle";
//			parametros = "idtypereferences="+$("#referenceselements_idtypereferences").val();
//			campoDesabilitado = "referenceselements_idtypereferences"
//			linkDesfazerDesabilitado = "";
//			
//			break;
//			
//		default:
//		
//			action = "getTypereferenceselements";
//			parametros = "";
//			campoDesabilitado = "";
//			linkDesabilitado = "";
//		
//			break;
	
		case "referenceselements_idsubtypereferences":
			action = "getSubTypeReferences";
			parametros = "idtypereferences="+$("#referenceselements_idtypereferencesCombo").val();
			campoDesabilitado = "referenceselements_idtypereferences";
			linkDesfazerDesabilitado = "";
			
			$("#referenceselements_idtypereferences").val($("#referenceselements_idtypereferencesCombo").val()); 
			
			break;
	
		default :

			
			break;
	
	}	

	
	// desabilita o campo acima
	
	if(desabilitarCampoAcima){
		
		$("#"+campoDesabilitado+"Combo").attr("disabled", true);
		
	}	
	
	// desabilita o desfazer do campo mais acima
	
	if(linkDesfazerDesabilitado!=""){
	
		$("#div-"+linkDesfazerDesabilitado+"Undo").css('display','none');
		
	}
	
	// habilita o desfazer do campo acima
	
	if(campoDesabilitado!=""){
	
		$("#div-"+campoDesabilitado+"Undo").css('display','block');
		
	}
	
	if(action!=""){
	
		$.ajax({     		   
			   url: "index.php?r=fieldsdependency/"+action+"&"+parametros,     		   	   
			   success: function(msg){
						
					atualizaDropDownList(msg.split("|"),campo+"Combo");
					
						
				}
		});	
	}	
}

//funcao que atualiza conteudo de dropdownlist
function atualizaDropDownList(arrayDropDownList,campo){


	if(arrayDropDownList.length>0){
		$("#"+campo).empty();
		$("#"+campo).append("<option value='' >-</option>");
		$("#"+campo).removeAttr("disabled"); 
	}
	else	
		$("#"+campo).attr("disabled", true);
	
	
	for(i=0;i<arrayDropDownList.length-1;i=i+2){
		
		var strOption = "<option ";
		
		strOption += " value='"+arrayDropDownList[i]+"' >"+arrayDropDownList[i+1]+"</option>";
		
		$("#"+campo).append(strOption);
	}
	


}

function dependenciaPreenchida(campo, campoAcima){
	
	//esconder o Undo de cima
	$("#div-"+campoAcima+"Undo").css('display','none');
	
	//mostrar o Undo do campo
	$("#div-"+campo+"Undo").css('display','block');

	//salvar o valor em campo hidden
	$("#"+campo).val($("#"+campo+"Combo").val());	
	
	//desabilitar o campo
	$("#"+campo+"Combo").attr("disabled", true);
	
}