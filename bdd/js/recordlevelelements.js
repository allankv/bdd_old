
function controleExibicao(objDivID){
	
	if(document.getElementById(objDivID).style.display=='none'){
		
		document.getElementById(objDivID).style.display='block';
			
	}else{
		
		document.getElementById(objDivID).style.display='none';
		
	}
		
	
}

function habilitaDropDownList(campo){
	
	switch(campo){
		
		case "recordlevelelements_idinstitutioncode":
			
			campoDesabilitado = "recordlevelelements_idcollectioncode";	
			linkDesfazerHabilitado = "";
			
			break;
			
		case "recordlevelelements_idcollectioncode":
			

			campoDesabilitado = "taxonomicelements_idscientificname";
			linkDesfazerHabilitado = "recordlevelelements_idinstitutioncode";
			
			break;
			
		case "taxonomicelements_idscientificname":
			
			campoDesabilitado = "occurrenceelements_catalognumber";
			linkDesfazerHabilitado = "recordlevelelements_idcollectioncode";			
			
			break;
			
		case "occurrenceelements_catalognumber" :
				
			campoDesabilitado = "";
			linkDesfazerHabilitado = "taxonomicelements_idscientificname";				
			
			break;		
	
	}
	
	// habilita o campo
	$("#"+campo).removeAttr("disabled");
	
	// reinicia o valor do campo
	$("#"+campo).val("")
	
	//habilita o desfazer para o campo acima
	if(linkDesfazerHabilitado!=""){
		
		$("#div-"+linkDesfazerHabilitado+"Undo").css('display','block');
		
	}	
	
	// desabilita o desfazer do campo atual
	$("#div-"+campo+"Undo").css('display','none');

	if(campoDesabilitado!=""){
		
		// desabilita o campo abaixo
		$("#"+campoDesabilitado).val("")
		$("#"+campoDesabilitado).attr("disabled", true);
		
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
	var ativaBotaoSearch = false;
	
	if(desabilitarCampoAcima==null)
		desabilitarCampoAcima = true	
	
	switch(campo){
	
		case "recordlevelelements_idcollectioncode" :
			
			action = "getCollectionCodes";
			parametros = "idinstitutioncode="+$("#recordlevelelements_idinstitutioncode").val();
			campoDesabilitado = "recordlevelelements_idinstitutioncode"
			linkDesfazerDesabilitado = "";
			
			break;
			
		case "taxonomicelements_idscientificname" :
			
			action = "getScientificNames";
			parametros = "idinstitutioncode="+$("#recordlevelelements_idinstitutioncode").val()+"&idcollectioncode="+$("#recordlevelelements_idcollectioncode").val();
			campoDesabilitado = "recordlevelelements_idcollectioncode"
			linkDesfazerDesabilitado = "recordlevelelements_idinstitutioncode";
			ativaBotaoSearch = true;
			
			break;
			
		case "occurrenceelements_catalognumber" :
			
			action = "getCatalogNumbers";
			parametros = "idinstitutioncode="+$("#recordlevelelements_idinstitutioncode").val()+"&idcollectioncode="+$("#recordlevelelements_idcollectioncode").val()+"&idscientificname="+$("#taxonomicelements_idscientificname").val();
			campoDesabilitado = "taxonomicelements_idscientificname"
			linkDesfazerDesabilitado = "recordlevelelements_idcollectioncode";
			ativaBotaoSearch = true;
			
			break;
			
		default:
		
			action = "getInstitutionCodes";
			parametros = "";
			campoDesabilitado = "";
			linkDesabilitado = "";
		
			break;
	
	}
	
	//Apenas ativa o botao de busca se institutioncode, collectioncode e scientiicname estiverem preenchidos
	if(ativaBotaoSearch){
		
		$("#botaoSearch").removeAttr("disabled");
		
	}else{
		
		$("#botaoSearch").attr("disabled", true);
		
	}
	
	// desabilita o campo acima
	if(desabilitarCampoAcima){
		
		$("#"+campoDesabilitado).attr("disabled", true);
		
	}	
	
	// desabilita o desfazer do campo mais acima
	if(linkDesfazerDesabilitado!=""){
	
		$("#div-"+linkDesfazerDesabilitado+"Undo").css('display','none');
		
	}
	
	// habilita o desfazer do campo acima
	
	if(campoDesabilitado!=""){
	
		$("#div-"+campoDesabilitado+"Undo").css('display','block');
		
	}
	
	$.ajax({     		   
		   url: "index.php?r=fieldsdependency/"+action+"&"+parametros,     		   	   
		   success: function(msg){
					
				atualizaDropDownList(msg.split("|"),campo);
				
					
			}
	});	
	
}

//funcao que atualiza conteudo de dropdownlist
function atualizaDropDownList(arrayDropDownList,campo){

	//alert(arrayDropDownList+"   "+arrayDropDownList.length);
	
	if(arrayDropDownList.length>0){
		
		$("#"+campo).removeAttr("disabled"); 
		
		//removendo todos os option do combo, o ideal seria usar o empty do jQuery mas é muito lento
		
		var tamanhoCombo = document.getElementById(campo).length;
		
		var x = document.getElementById(campo);
		
		for(t=0;t<tamanhoCombo;t++){			
			x.remove(0);
		}
		
		
		//$("#"+campo).empty();
	
		
		$("#"+campo).append("<option value='' >-</option>");		
		
		
	}
	else	
		$("#"+campo).attr("disabled", true);

	
	var strOption = "";
	
	for(i=0;i<arrayDropDownList.length-1;i=i+2){
		
		strOption += "<option  value='"+arrayDropDownList[i]+"' >"+arrayDropDownList[i+1]+"</option>";		

	}

	
	$("#"+campo).append(strOption);


}

function exibeRespostaBusca(urlRequisicao){

	 // desativa o catalog number
	 $("#occurrenceelements_catalognumber").attr("disabled", true)
	 
	 // esconde o desfazer do scientific name
	 $("#div-taxonomicelements_scientificnameUndo").css('display', 'none') 
	 
	 
	 document.forms[0].action = "index.php?r="+urlRequisicao+"&idinstitutioncode="+$("#recordlevelelements_idinstitutioncode").val()+"&idcollectioncode="+$("#recordlevelelements_idcollectioncode").val()+"&idscientificname="+$("#taxonomicelements_idscientificname").val()+"&catalognumber="+$("#occurrenceelements_catalognumber").val();
	 
	 document.forms[0].submit();

}


