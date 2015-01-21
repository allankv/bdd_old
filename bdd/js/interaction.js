
/* 
 * Realiza a chamada AJAX para obter todas os espécimes
 * Carrega a resposta da chamada na DIV passada por parametro
 */ 

function exibeEspecimes(idinstitutioncode, idcollectioncode, idscientificname, idbasisofrecord, objSpecimen ){
	
	$.ajax({     		   
		   url: "index.php?r=fieldsdependency/getRecordLevelElements&idinstitutioncode="+idinstitutioncode+"&idcollectioncode="+idcollectioncode+"&idscientificname="+idscientificname+"&idbasisofrecord="+idbasisofrecord+"&objSpecimen="+objSpecimen,     		   	   
		   success: function(msg){
				/*
				 * verifica se a variavel auxiliar do especime está com algum valor, caso esteja marca co check o radio button relacionado
				 */
				if($("#aux_"+objSpecimen).val()!="")
					msg = msg.replace("VALUE="+$("#aux_"+objSpecimen).val(),"VALUE="+$("#aux_"+objSpecimen).val()+" CHECKED ");
				$("#div"+objSpecimen).html(msg);				
			}
	});
	
}


/*
 * Funcao chamada pelo botao de busca
 */

function realizaBusca(intGrupoCampos, msgErro){
	
	 
	 // desativa o basisofecord
	 // $("#basisOfRecord"+intGrupoCampos).attr("disabled", true)
	 
	 // esconde o desfazer do scientific name
	 //  $("#div-scientificName"+intGrupoCampos+"Undo").css('display', 'none')
	 
	 // mostra o desfazer do basisofrecord
	 // $("#div-basisOfRecord"+intGrupoCampos+"Undo").css('display', 'block')
	 
	 
	if(verificaPreenchimentoFiltros(intGrupoCampos)){
		
		if($("#scientificName"+intGrupoCampos).val()!=""){
			//desabilita o basisofrecord
			$("#scientificName"+intGrupoCampos).attr("disabled", true);
			
			// esconde o desfazer do scientific name
			$("#div-basisOfRecord"+intGrupoCampos+"Undo").css('display','none');
			
			//exibe o desafaze no basis of record
			$("#div-scientificName"+intGrupoCampos+"Undo").css('display','block');
		}
		
		exibeEspecimes($("#institutionCode"+intGrupoCampos).val(),
						$("#collectionCode"+intGrupoCampos).val(),
						$("#scientificName"+intGrupoCampos).val(),
						$("#basisOfRecord"+intGrupoCampos).val(),
						"idspecimens"+intGrupoCampos
						)
		
		$("#divErro"+intGrupoCampos).css('display','none');
		$("#divErro"+intGrupoCampos).text("");	
		
		$("#dividspecimens"+intGrupoCampos).css('display','block');
						
	}else{
		
		$("#divErro"+intGrupoCampos).css('display','block');
		$("#divErro"+intGrupoCampos).text(msgErro);
		
	}
	
}


/*
 * Faz a verificação se todos os campos de um determinado grupo de campos estão preenchidos
 */

function verificaPreenchimentoFiltros(intGrupoCampos){
	
	if($("#institutionCode"+intGrupoCampos).val()==""){
	
		return false;
	
	}
	
	if($("#collectionCode"+intGrupoCampos).val()==""){
		
		return false;
		
	}
	
//	if($("#scientificName"+intGrupoCampos).val()==""){
//		
//		return false;
//		
//	}
//	
//	if($("#basisOfRecord"+intGrupoCampos).val()==""){
//		
//		return false;
//		
//	}
	
	
	return true;
	
}
 


/*
 *	Caso a pagina seja chamada por POST, refaz a busca por especimes baseado nos filtros preenchidos
 *	anteriormente 
 */

$(function() {
//	
//	if($("#aux_idspecimens1").val()!=""){
//		exibeEspecimes($("#institutionCode1").val(),$("#collectionCode1").val(),$("#scientificName1").val(),$("#basisOfRecord1").val(),'idspecimens1')
//	}
//	
//	if($("#aux_idspecimens2").val()!=""){
//		exibeEspecimes($('#institutionCode2').val(),$('#collectionCode2').val(),$('#scientificName2').val(),$('#basisOfRecord2').val(),'idspecimens2')
//	}	
	
});
 
 
 /*
  * 
  * Funcao chamada quando o usuario quiser alterar um specimen 
  * no update do interaction element
  * 
  */
 
 function ativaFiltrosSpecimen(intGrupoCampos){
	 
	 $("#divSpecimenSelecionada"+intGrupoCampos).css('display','none');
	 $("#divFiltros"+intGrupoCampos).css('display','block');
	 
	 //se os filtros foram prrenchidos anteriormente, exibe os resultados da busca
	 if(verificaPreenchimentoFiltros(intGrupoCampos)){
		 
		 $("#dividspecimens"+intGrupoCampos).css('display','block');
		 
	 } 
	 
	 $("#interactionelements_idspecimens"+intGrupoCampos).val("");
	 
 }
 
/*
 * Desativa os filtros de busca por specimens
 * e mostra apenas o specimen cadastrado anteriormente no registro de interaction
 * 
 */ 
 
function desativaFiltrosSpecimen(intGrupoCampos){

	 $("#divSpecimenSelecionada"+intGrupoCampos).css('display','block');
	 $("#divFiltros"+intGrupoCampos).css('display','none');
	 $("#dividspecimens"+intGrupoCampos).css('display','none');
	 
	 var idSpecimenAux = $("#aux_idspecimens"+intGrupoCampos).val();  
	 
	 $("#interactionelements_idspecimens"+intGrupoCampos).val(idSpecimenAux);
}

function controleExibicao(objDivID){
	
	if(document.getElementById(objDivID).style.display=='none'){
		
		document.getElementById(objDivID).style.display='block';
			
	}else{
		
		document.getElementById(objDivID).style.display='none';
		
	}
		
	
}

function habilitaDropDownList(campo, grupo){
	
	switch(campo){
		
		case "institutionCode":
			
			campoDesabilitado = "collectionCode";	
			linkDesfazerHabilitado = "";
			
			
			break;
			
		case "collectionCode":
			

			campoDesabilitado = "basisOfRecord";
			linkDesfazerHabilitado = "institutionCode";
			
			break;
			
		case "basisOfRecord" :
			
			campoDesabilitado = "scientificName";
			linkDesfazerHabilitado = "collectionCode";
			
			break;
			
		case "scientificName":
			
			if(grupo!=""){
				campoDesabilitado = "";
				linkDesfazerHabilitado = "collectionCode";
				$("#dividspecimens"+grupo).html("");
			}else{
			
				campoDesabilitado = "interactionType";
				linkDesfazerHabilitado = "basisOfRecord";				
				
			}
			
			break;
			
//		case "basisOfRecord" :
//			
//			if(grupo!=""){
//				
//				campoDesabilitado = "";
//				linkDesfazerHabilitado = "scientificName";
//				$("#dividspecimens"+grupo).html("");
//				
//			}else{
//				
//				campoDesabilitado = "interactionType";
//				linkDesfazerHabilitado = "scientificName";
//				
//			}
//			
//			break;
		
		case "interactionType":
			
			campoDesabilitado = "";			
			linkDesfazerHabilitado = "scientificName";
			
			break;
	
	}

	
	// habilita o campo
	$("#"+campo+grupo).removeAttr("disabled");
	
	// reinicia o valor do campo
	$("#"+campo+grupo).val("")
	
	//habilita o desfazer para o campo acima
	if(linkDesfazerHabilitado!=""){
		
		$("#div-"+linkDesfazerHabilitado+grupo+"Undo").css('display','inline');
		
	}	
	
	// desabilita o desfazer do campo atual
	$("#div-"+campo+grupo+"Undo").css('display','none');

	if(campoDesabilitado!=""){
		
		// desabilita o campo abaixo
		$("#"+campoDesabilitado+grupo).val("")
		$("#"+campoDesabilitado+grupo).attr("disabled", true);
		
	}
	
	// requisita novos valores para o campo logo abaixo
	requisitaValoresDropDownList(campo, grupo, false)
	

	
	
	
}

/*
 *  requisita e preenche valores para o dropdownlist passado por parametro
 */

function requisitaValoresDropDownList(campo, grupo, desabilitarCampoAcima){
	
	var action = "";
	var parametros = "";
	var campoDesabilitado = "";
	var ativaBotaoSearch = false;
	
	if(desabilitarCampoAcima==null)
		desabilitarCampoAcima = true
		
	switch(campo){
	
		case "collectionCode" :
			
			action = "getCollectionCodes";
			parametros = "idinstitutioncode="+$("#institutionCode"+grupo).val()+"&procurainteracao=true";
			campoDesabilitado = "institutionCode"
			linkDesfazerDesabilitado = "";
			
			break;
			
		case "basisOfRecord" :
			
			action = "getBasisOfRecords";
			parametros = "idinstitutioncode="+$("#institutionCode"+grupo).val()+"&idcollectioncode="+$("#collectionCode"+grupo).val()+"&procurainteracao=true";
			campoDesabilitado = "collectionCode"
			linkDesfazerDesabilitado = "institutionCode";
			
			ativaBotaoSearch = true;
			
			break;			
			
		case "scientificName" :
			
			action = "getScientificNames";
			parametros = "idinstitutioncode="+$("#institutionCode"+grupo).val()+"&idcollectioncode="+$("#collectionCode"+grupo).val()+"&idbasisofrecord="+$("#basisOfRecord"+grupo).val()+"&procurainteracao=true";
			campoDesabilitado = "basisOfRecord"
			linkDesfazerDesabilitado = "collectionCode";
			
			ativaBotaoSearch = true;
			
			break;	

			
		case "interactionType" :
			
			action = "getInteractionTypes";
			parametros = "idinstitutioncode="+$("#institutionCode"+grupo).val()+"&idcollectioncode="+$("#collectionCode"+grupo).val()+"&idscientificname="+$("#scientificName"+grupo).val()+"&idbasisofrecord="+$("#basisOfRecord"+grupo).val()+"&idinteractiontype="+$("#interactionType"+grupo).val()+"&procurainteracao=true";
			campoDesabilitado = "scientificName"
			linkDesfazerDesabilitado = "basisOfRecord";			

			ativaBotaoSearch = true;
			
			break;
			
		default:
		
			action = "getInstitutionCodes";
			parametros = "";
			campoDesabilitado = "";
			linkDesabilitado = "";
		
			ativaBotaoSearch = false;
			
			break;
	
	}
	
	
	//Apenas ativa o botao de busca se institutioncode, collectioncode e scientiicname estiverem preenchidos
	if(ativaBotaoSearch){
		
		$("#botaoSearch"+grupo).removeAttr("disabled");
		
	}else{
		
		$("#botaoSearch"+grupo).attr("disabled", true);
		
	}		
	
	// desabilita o campo acima
	if(desabilitarCampoAcima){
		
		$("#"+campoDesabilitado+grupo).attr("disabled", true);
		
	}
	
	// desabilita o desfazer do campo mais acima
	if(linkDesfazerDesabilitado!=""){
	
		$("#div-"+linkDesfazerDesabilitado+grupo+"Undo").css('display','none');
		
	}
	
	// habilita o desfazer do campo acima
	
	if(campoDesabilitado!=""){
	
		$("#div-"+campoDesabilitado+grupo+"Undo").css('display','block');
		
	}
	
	$.ajax({     		   
		   url: "index.php?r=fieldsdependency/"+action+"&"+parametros,     		   	   
		   success: function(msg){
					
				atualizaDropDownList(msg.split("|"),campo+grupo);
				
					
			}
	});	
	
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
		
		//verifica qual foi o id selecionado no formulario
//		if (idSelecionado == arrayDropDownList[i+1])
//			strOption += " SELECTED ";	
		
		strOption += " value='"+arrayDropDownList[i]+"' >"+arrayDropDownList[i+1]+"</option>";
		
		$("#"+campo).append(strOption);
	}
	


}

function exibeRespostaBusca(){

	 
	 // desativa o interactiontype
	 $("#interactionType").attr("disabled", true)
	 
	 // esconde o desfazer do basis of record
	 $("#div-basisOfRecordUndo").css('display', 'none')
	 
	 // mostra o desfazer do interaction type
	 //$("#div-interactionTypeUndo").css('display', 'block')	
	
	 document.forms[0].action = "index.php?r=interactionelements/list&idinstitutioncode="+$("#institutionCode").val()+"&idcollectioncode="+$("#collectionCode").val()+"&idscientificname="+$("#scientificName").val()+"&idbasisofrecord="+$("#basisOfRecord").val()+"&idinteractiontype="+$("#interactionType").val()
	 
	 document.forms[0].submit();

}

function submeterFormulario(){
	
	document.forms[0].action += "&institutionCode1="+$("#institutionCode1").val()+"&collectionCode1="+$("#collectionCode1").val()+"&basisOfRecord1="+$("#basisOfRecord1").val()+"&scientificName1="+$("#scientificName1").val()+"&institutionCode2="+$("#institutionCode2").val()+"&collectionCode2="+$("#collectionCode2").val()+"&basisOfRecord2="+$("#basisOfRecord2").val()+"&scientificName2="+$("#scientificName2").val();
	document.forms[0].submit();

}
