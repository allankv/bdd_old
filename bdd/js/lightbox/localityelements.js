var camposPreenchidosLocalityElements = new Array();
camposPreenchidosLocalityElements.push(0);

function concatenarValoresUrlLocalityElements(){
	var url = "";

    if ($("#localityelements_idcontinent").val()!="")
    	url += '&formIdContinent='+ $("#localityelements_idcontinent").val();

    if ($("#localityelements_idwaterbody").val()!="")
    	url += '&formIdWaterbody='+ $("#localityelements_idwaterbody").val();

    if ($("#localityelements_idislandgroup").val()!="")
    	url += '&formIdWaterbody='+ $("#localityelements_idislandgroup").val();

    if ($("#localityelements_idisland").val()!="")
    	url += '&formIdIsland='+ $("#localityelements_idisland").val();

    if ($("#localityelements_idcountry").val()!="")
    	url += '&formIdCountry='+ $("#localityelements_idcountry").val();

    if ($("#localityelements_idstateprovince").val()!="")
    	url += '&formIdStateprovince='+ $("#localityelements_idstateprovince").val();

//    if ($("#localityelements_idcounty").val()!="")
//    	url += '&formIdCounty='+ $("#localityelements_idcounty").val();

    if ($("#localityelements_idmunicipality").val()!="")
    	url += '&formIdMunicipality='+ $("#localityelements_idmunicipality").val();

    if ($("#localityelements_idlocality").val()!="")
    	url += '&formIdLocality='+ $("#localityelements_idlocality").val();

    return url;

}

function escondeBotaoResetLocalityElements(){
	// esconde os botões de limpar de todos os camos
 	$("#divcontinentReset").css("display","none");
 	$("#divwaterbodyReset").css("display","none");
 	$("#divislandgroupReset").css("display","none");
 	$("#divislandReset").css("display","none");
 	$("#divcountryReset").css("display","none");
 	$("#divstateprovinceReset").css("display","none");
 	$("#divcountyReset").css("display","none");
 	$("#divmunicipalityeReset").css("display","none");
 	$("#divlocalityReset").css("display","none");
}

function selecionaItemLocalityElements(campo, valor, idValor, sugerir){

        //escondeBotaoResetTaxonomicElements();
        //resetCampos();
	var camposReset = new Array();
	camposReset.push(0);

	//alert(sugerir)

	switch(campo){
		case "continent":			
			
	 	 		$('#localityelements_idcontinent').val(idValor);
	 	 		$('#continent').val(valor);
	 	 		$('#continentvalue').val(valor);
			

//                      $("#divcontinentReset").css("display","block");
//
// 	 		if (valor!=''){
// 	 			dasabilitaCampos("continent");
// 	 			$('#divcontinentValor').text(valor);
// 	 		}else
// 	 			habilitaCampos("continent");

 	 		if(sugerir!="no"){
//	 			$("#waterbody").val("");
//	 			$("#waterbodyvalue").val("");
//	 			$("#localityelements_idwaterbody").val("");
//				$("#islandgroup").val("");
//				$("#islandgroupvalue").val("");
//				$("#localityelements_idislandgroup").val("");
//				$("#island").val("");
//                $("#islandvalue").val("");
//				$("#localityelements_idisland").val("");
//				$("#country").val("");
//                $("#countryvalue").val("");
//				$("#localityelements_idcountry").val("");
//                $("#stateprovince").val("");
//                $("#stateprovincevalue").val("");
//                $("#localityelements_idstateprovince").val("");
//                $("#county").val("");
//                $("#countyvalue").val("");
//                $("#localityelements_idcounty").val("");
//				$("#municipality").val("");
//                $("#municipalityvalue").val("");
//			  	$("#localityelements_idmunicipality").val("");
//                $("#locality").val("");
//                $("#localityvalue").val("");
//                $("#localityelements_idlocality").val("");
 	 		}

            camposReset.push("continent");
            camposPreenchidosLocalityElements.push(camposReset);
            
            habilitaLinkDesfazerLocalityElements();

		break;

		case "waterbody":
 	 		$('#localityelements_idwaterbody').val(idValor);
 	 		$('#waterbody').val(valor);
 	 		$('#waterbodyvalue').val(valor);

//                        $("#divwaterbodyReset").css("display","block");
//
// 	 		if (valor!=''){
// 	 			dasabilitaCampos("waterbody");
// 	 			$('#divwaterbodyValor').text(valor);
// 	 		}else
// 	 			habilitaCampos("waterbody");

         	if(sugerir!="no"){

	        	$.ajax({
	     		   url: "index.php?r=autocompletelocalityelements&idSelect="+idValor+"&tableField="+campo,
	     		   success: function(msg){

	        		
//		        		if($("#continent").val()==''){
//		        			camposReset.push("continent");
//         				}


						if($('#localityelements_idcontinent').val()==""){
		        			
							$("#continent").val(msg.split("|")[2]);
		        			$("#continentvalue").val(msg.split("|")[2]);
		        			$("#localityelements_idcontinent").val(msg.split("|")[3]);
		        			
						}

//	         	 		if (msg.split("|")[2]!=''){
//	         	 			dasabilitaCampos("continent");
//	         	 			$('#divcontinentValor').text(msg.split("|")[2]);
//	         	 		}else
//	         	 			habilitaCampos("continent");

//	         	 		camposReset.push("continent");

                    	/*
                    	 * Comentado para nao apagar os campos abaixo do formulario
                    	 */	         	 		
	         	 		
//						$("#islandgroup").val("");
//						$("#islandgroupvalue").val("");
//						$("#localityelements_idislandgroup").val("");
//						$("#island").val("");
//						$("#islandvalue").val("");
//						$("#localityelements_idisland").val("");
//						$("#country").val("");
//						$("#countryvalue").val("");
//						$("#localityelements_idcountry").val("");
//						$("#stateprovince").val("");
//						$("#stateprovincevalue").val("");
//						$("#localityelements_idstateprovince").val("");
//						$("#county").val("");
//						$("#countyvalue").val("");
//						$("#localityelements_idcounty").val("");
//						$("#municipality").val("");
//						$("#municipalityvalue").val("");
//						$("#localityelements_idmunicipality").val("");
//						$("#locality").val("");
//						$("#localityvalue").val("");
//						$("#localityelements_idlocality").val("");

			        	camposReset.push("waterbody");
			        	camposPreenchidosLocalityElements.push(camposReset);
			        	
			        	habilitaLinkDesfazerLocalityElements();
	     		   }
	     		 });


         	}else{
	        	camposReset.push("waterbody");
         		camposPreenchidosLocalityElements.push(camposReset);
         	}
		break;

		case "islandgroup":
 	 		$('#localityelements_idislandgroup').val(idValor);
                        $('#islandgroup').val(valor);
                        $('#islandgroupvalue').val(valor);

//                        $("#divislandgroupReset").css("display","block");
//
// 	 		if (valor!=''){
// 	 			dasabilitaCampos("islandgroup");
// 	 			$('#divislandgroupValor').text(valor);
// 	 		}else
// 	 			habilitaCampos("islandgroup");

 	 		if(sugerir!="no"){

	        	$.ajax({
	      		   url: "index.php?r=autocompletelocalityelements&idSelect="+idValor+"&tableField="+campo,
	      		   success: function(msg){
	        		
//						if($("#continent").val()=='')
//							camposReset.push("continent");

						if($('#localityelements_idcontinent').val()==""){
							
							$("#continent").val(msg.split("|")[2]);
							$("#continentvalue").val(msg.split("|")[2]);
							$("#localityelements_idcontinent").val(msg.split("|")[3]);
							
						}

//	         	 		if (msg.split("|")[2]!=''){
//	         	 			dasabilitaCampos("continent");
//	         	 			$('#divcontinentValor').text(msg.split("|")[2]);
//	         	 		}else
//	         	 			habilitaCampos("continent");

						if($("#waterbody").val()=='')
							camposReset.push("waterbody");

						
						if($('#localityelements_idwaterbody').val()==""){
						
		         			$("#waterbody").val(msg.split("|")[4]);
		         			$("#waterbodyvalue").val(msg.split("|")[4]);
		         			$("#localityelements_idwaterbody").val(msg.split("|")[5]);

						}
						
//	         	 		if (msg.split("|")[4]!=''){
//	         	 			dasabilitaCampos("waterbody");
//	         	 			$('#divwaterbodyValor').text(msg.split("|")[4]);
//	         	 		}else
//	         	 			habilitaCampos("waterbody");

                    	/*
                    	 * Comentado para nao apagar os campos abaixo do formulario
                    	 */
	         			
//						$("#island").val("");
//						$("#islandvalue").val("");
//						$("#localityelements_idisland").val("");
//						$("#country").val("");
//						$("#countryvalue").val("");
//						$("#localityelements_idcountry").val("");
//						$("#stateprovince").val("");
//						$("#stateprovincevalue").val("");
//						$("#localityelements_idstateprovince").val("");
//						$("#county").val("");
//						$("#countyvalue").val("");
//						$("#localityelements_idcounty").val("");
//						$("#municipality").val("");
//						$("#municipalityvalue").val("");
//						$("#localityelements_idmunicipality").val("");
//						$("#locality").val("");
//						$("#localityvalue").val("");
//						$("#localityelements_idlocality").val("");

		         	 	camposReset.push("islandgroup");
		         	 	camposPreenchidosLocalityElements.push(camposReset);
		         	 	
		         	 	habilitaLinkDesfazerLocalityElements();
	      		   }
	      		 });


 	 		}else{
         	 	camposReset.push("islandgroup");
         	 	camposPreenchidosLocalityElements.push(camposReset);
 	 		}
		break;

		case "island":
 	 		$('#localityelements_idisland').val(idValor);
 	 		$('#island').val(valor);
 	 		$('#islandvalue').val(valor);

//                        $("#divislandReset").css("display","block");
//
// 	 		if (valor!=''){
// 	 			dasabilitaCampos("island");
// 	 			$('#divislandValor').text(valor);
// 	 		}else
// 	 			habilitaCampos("island");

 	 		if(sugerir!="no"){
	        	$.ajax({
	     		   url: "index.php?r=autocompletelocalityelements&idSelect="+idValor+"&tableField="+campo,
	     		   success: function(msg){

//						if($("#continent").val()=='')
//							camposReset.push("continent");

						if($('#localityelements_idcontinent').val()==""){
		        			
							$("#continent").val(msg.split("|")[2]);
		        			$("#continentvalue").val(msg.split("|")[2]);
		        			$("#localityelements_idcontinent").val(msg.split("|")[3]);
		        			
						}

//	         	 		if (msg.split("|")[2]!=''){
//	         	 			dasabilitaCampos("continent");
//	         	 			$('#divcontinentValor').text(msg.split("|")[2]);
//	         	 		}else
//	         	 			habilitaCampos("continent");

//						if($("#waterbody").val()=='')
//							camposReset.push("waterbody");


						if($('#localityelements_idwaterbody').val()==""){
		        			
							$("#waterbody").val(msg.split("|")[4]);
		        			$("#waterbodyvalue").val(msg.split("|")[4]);
		        			$("#localityelements_idwaterbody").val(msg.split("|")[5]);
		        			
						}

//	         	 		if (msg.split("|")[4]!=''){
//	         	 			dasabilitaCampos("waterbody");
//	         	 			$('#divwaterbodyValor').text(msg.split("|")[4]);
//	         	 		}else
//	         	 			habilitaCampos("waterbody");

//						if($("#islandgroup").val()=='')
//							camposReset.push("islandgroup");

						if($('#localityelements_idislandgroup').val()==""){
			
		        			$("#islandgroup").val(msg.split("|")[6]);
		        			$("#islandgroupvalue").val(msg.split("|")[6]);
		        			$("#localityelements_idislandgroup").val(msg.split("|")[7]);
	        			
						}

//	         	 		if (msg.split("|")[6]!=''){
//	         	 			dasabilitaCampos("islandgroup");
//	         	 			$('#divislandgroupValor').text(msg.split("|")[6]);
//	         	 		}else
//	         	 			habilitaCampos("islandgroup");

                    	/*
                    	 * Comentado para nao apagar os campos abaixo do formulario
                    	 */
	        			
//						$("#country").val("");
//						$("#countryvalue").val("");
//						$("#localityelements_idcountry").val("");
//						$("#stateprovince").val("");
//						$("#stateprovincevalue").val("");
//						$("#localityelements_idstateprovince").val("");
//						$("#county").val("");
//						$("#countyvalue").val("");
//						$("#localityelements_idcounty").val("");
//						$("#municipality").val("");
//						$("#municipalityvalue").val("");
//						$("#localityelements_idmunicipality").val("");
//						$("#locality").val("");
//						$("#localityvalue").val("");
//						$("#localityelements_idlocality").val("");

			        	camposReset.push("island");
			        	camposPreenchidosLocalityElements.push(camposReset);
			        	
			        	habilitaLinkDesfazerLocalityElements();
	     		   }
	     		 });


 	 		}else{
	        	camposReset.push("island");
	        	camposPreenchidosLocalityElements.push(camposReset);
 	 		}
		break;

		case "country":
 	 		$('#localityelements_idcountry').val(idValor);
                        $('#country').val(valor);
                        $('#countryvalue').val(valor);

//                        $("#divcountryReset").css("display","block");
//
// 	 		if (valor!=''){
// 	 			dasabilitaCampos("country");
// 	 			$('#divcountryValor').text(valor);
// 	 		}else
// 	 			habilitaCampos("country");

 	 		if(sugerir!="no"){
	        	$.ajax({
	     		   url: "index.php?r=autocompletelocalityelements&idSelect="+idValor+"&tableField="+campo,
	     		   success: function(msg){

//						if($("#continent").val()=='')
//							camposReset.push("continent");

						if($('#localityelements_idcontinent').val()==""){
	
		        			$("#continent").val(msg.split("|")[2]);
		        			$("#continentvalue").val(msg.split("|")[2]);
		        			$("#localityelements_idcontinent").val(msg.split("|")[3]);
	        			
						}

//	         	 		if (msg.split("|")[2]!=''){
//	         	 			dasabilitaCampos("continent");
//	         	 			$('#divcontinentValor').text(msg.split("|")[2]);
//	         	 		}else
//	         	 			habilitaCampos("continent");


//						if($("#waterbody").val()=='')
//							camposReset.push("waterbody");


						if($('#localityelements_idwaterbody').val()==""){
		        			
							$("#waterbody").val(msg.split("|")[4]);
		        			$("#waterbodyvalue").val(msg.split("|")[4]);
		        			$("#localityelements_idwaterbody").val(msg.split("|")[5]);

						}
						
//	         	 		if (msg.split("|")[4]!=''){
//	         	 			dasabilitaCampos("waterbody");
//	         	 			$('#divwaterbodyValor').text(msg.split("|")[4]);
//	         	 		}else
//	         	 			habilitaCampos("waterbody");

//						if($("#islandgroup").val()=='')
//							camposReset.push("islandgroup");

						if($('#localityelements_idislandgroup').val()==""){
						
		        			$("#islandgroup").val(msg.split("|")[6]);
		        			$("#islandgroupvalue").val(msg.split("|")[6]);
		        			$("#localityelements_idislandgroup").val(msg.split("|")[7]);
	        			
						}

//	         	 		if (msg.split("|")[6]!=''){
//	         	 			dasabilitaCampos("islandgroup");
//	         	 			$('#divislandgroupValor').text(msg.split("|")[6]);
//	         	 		}else
//	         	 			habilitaCampos("islandgroup");

//						if($("#island").val()=='')
//							camposReset.push("island");

						if($('#localityelements_idisland').val()==""){
                                                
							$("#island").val(msg.split("|")[8]);
							$("#islandvalue").val(msg.split("|")[8]);
							$("#localityelements_idisland").val(msg.split("|")[9]);
							
						}

//	         	 		if (msg.split("|")[8]!=''){
//	         	 			dasabilitaCampos("island");
//	         	 			$('#divislandValor').text(msg.split("|")[8]);
//	         	 		}else
//	         	 			habilitaCampos("island");

                    	/*
                    	 * Comentado para nao apagar os campos abaixo do formulario
                    	 */                                                
                                                
//                        $("#stateprovince").val("");
//                        $("#stateprovincevalue").val("");
//                        $("#localityelements_idstateprovince").val("");
//                        $("#county").val("");
//                        $("#countyvalue").val("");
//                        $("#localityelements_idcounty").val("");
//                        $("#municipality").val("");
//                        $("#municipalityvalue").val("");
//                        $("#localityelements_idmunicipality").val("");
//                        $("#locality").val("");
//                        $("#localityvalue").val("");
//                        $("#localityelements_idlocality").val("");

                        camposReset.push("country");
                        camposPreenchidosLocalityElements.push(camposReset);
                        
                        habilitaLinkDesfazerLocalityElements();
	     		   }
	     		 });

	        	//camposReset.push("divcountryReset");

 	 		}else{
 	 			camposReset.push("country");
         		camposPreenchidosLocalityElements.push(camposReset);
 	 		}

		break;

		case "stateprovince":
 	 		$('#localityelements_idstateprovince').val(idValor);
 	 		$('#stateprovince').val(valor);
 	 		$('#stateprovincevalue').val(valor);

//      	 	$("#divstateprovinceReset").css("display","block");
//
// 	 		if (valor!=''){
// 	 			dasabilitaCampos("stateprovince");
// 	 			$('#divstateprovinceValor').text(valor);
// 	 		}else
// 	 			habilitaCampos("stateprovince");

 	 		if(sugerir!="no"){

	        	$.ajax({
	     		   url: "index.php?r=autocompletelocalityelements&idSelect="+idValor+"&tableField="+campo,
	     		   success: function(msg){

//						if($("#continent").val()=='')
//							camposReset.push("continent");

	
						if($('#localityelements_idcontinent').val()==""){
	        			
							$("#continent").val(msg.split("|")[2]);
		        			$("#continentvalue").val(msg.split("|")[2]);
		        			$("#localityelements_idcontinent").val(msg.split("|")[3]);
	        			
						}

//	         	 		if (msg.split("|")[2]!=''){
//	         	 			dasabilitaCampos("continent");
//                                                $('#divcontinentValor').text(msg.split("|")[2]);
//	         	 		}else
//	         	 			habilitaCampos("continent");

//						if($("#waterbody").val()=='')
//							camposReset.push("waterbody");

						if($('#localityelements_idwaterbody').val()==""){
						
		        			$("#waterbody").val(msg.split("|")[4]);
		        			$("#waterbodyvalue").val(msg.split("|")[4]);
		        			$("#localityelements_idwaterbody").val(msg.split("|")[5]);
	        			
						}

//	         	 		if (msg.split("|")[4]!=''){
//	         	 			dasabilitaCampos("waterbody");
//	         	 			$('#divwaterbodyValor').text(msg.split("|")[4]);
//	         	 		}else
//	         	 			habilitaCampos("waterbody");

//						if($("#islandgroup").val()=='')
//							camposReset.push("islandgroup");

						if($('#localityelements_idislandgroup').val()==""){

							$("#islandgroup").val(msg.split("|")[6]);
							$("#islandgroupvalue").val(msg.split("|")[6]);
		        			$("#localityelements_idislandgroup").val(msg.split("|")[7]);
	        			
						}

//	         	 		if (msg.split("|")[6]!=''){
//	         	 			dasabilitaCampos("islandgroup");
//	         	 			$('#divislandgroupValor').text(msg.split("|")[6]);
//	         	 		}else
//	         	 			habilitaCampos("islandgroup");

//						if($("#island").val()=='')
//							camposReset.push("island");

						if($('#localityelements_idisland').val()==""){

		        			$("#island").val(msg.split("|")[8]);
		        			$("#islandvalue").val(msg.split("|")[8]);
		        			$("#localityelements_idisland").val(msg.split("|")[9]);
	        			
						}

//	         	 		if (msg.split("|")[8]!=''){
//	         	 			dasabilitaCampos("island");
//	         	 			$('#divislandValor').text(msg.split("|")[8]);
//	         	 		}else
//	         	 			habilitaCampos("island");

//						if($("#country").val()=='')
//							camposReset.push("country");

						if($('#localityelements_idcountry').val()==""){

		        			$("#country").val(msg.split("|")[10]);
		        			$("#countryvalue").val(msg.split("|")[10]);
		        			$("#localityelements_idcountry").val(msg.split("|")[11]);
	        			
						}

//	         	 		if (msg.split("|")[10]!=''){
//	         	 			dasabilitaCampos("country");
//	         	 			$('#divcountryValor').text(msg.split("|")[10]);
//	         	 		}else
//	         	 			habilitaCampos("country");


                    	/*
                    	 * Comentado para nao apagar os campos abaixo do formulario
                    	 */
	        			
//						$("#county").val("");
//						$("#countyvalue").val("");
//						$("#localityelements_idcounty").val("");
//						$("#municipality").val("");
//						$("#municipalityvalue").val("");
//						$("#localityelements_idmunicipality").val("");
//						$("#locality").val("");
//						$("#localityvalue").val("");
//						$("#localityelements_idlocality").val("");

		         	 	camposReset.push("stateprovince");
		         		camposPreenchidosLocalityElements.push(camposReset);
		         		
		         		habilitaLinkDesfazerLocalityElements();
	     		   }
	     		 });

	        	//camposReset.push("divstateprovinceReset");
 	 		}else{
         	 	camposReset.push("stateprovince");
         		camposPreenchidosLocalityElements.push(camposReset);
 	 		}
		break;

//		case "county":
// 	 		$('#localityelements_idcounty').val(idValor);
//                        $('#county').val(valor);
//                        $('#countyvalue').val(valor);
//
////                        $("#divcountyReset").css("display","block");
////
//// 	 		if (valor!=''){
//// 	 			dasabilitaCampos("county");
//// 	 			$('#divcountyValor').text(valor);
//// 	 		}else
//// 	 			habilitaCampos("county");
//
// 	 		if(sugerir!="no"){
//	        	$.ajax({
//	     		   url: "index.php?r=autocompletelocalityelements&idSelect="+idValor+"&tableField="+campo,
//	     		   success: function(msg){
//
////						if($("#continent").val()=='')
////							camposReset.push("continent");
//
//	
//						if($('#localityelements_idcontinent').val()==""){
//		        			
//							$("#continent").val(msg.split("|")[2]);
//		        			$("#continentvalue").val(msg.split("|")[2]);
//		        			$("#localityelements_idcontinent").val(msg.split("|")[3]);
//		        			
//						}
//
////	         	 		if (msg.split("|")[2]!=''){
////	         	 			dasabilitaCampos("continent");
////	         	 			$('#divcontinentValor').text(msg.split("|")[2]);
////	         	 		}else
////	         	 			habilitaCampos("continent");
//
////						if($("#waterbody").val()=='')
////							camposReset.push("waterbody");
//
//
//						if($('#localityelements_idwaterbody').val()==""){
//	        			
//							$("#waterbody").val(msg.split("|")[4]);
//							$("#waterbodyvalue").val(msg.split("|")[4]);
//		        			$("#localityelements_idwaterbody").val(msg.split("|")[5]);
//	        			
//						}
//
////	         	 		if (msg.split("|")[4]!=''){
////                                                dasabilitaCampos("waterbody");
////	         	 			$('#divwaterbodyValor').text(msg.split("|")[4]);
////	         	 		}else
////	         	 			habilitaCampos("waterbody");
//
////						if($("#islandgroup").val()=='')
////							camposReset.push("islandgroup");
//
//						if($('#localityelements_idislandgroup').val()==""){
//		
//							$("#islandgroup").val(msg.split("|")[6]);
//							$("#islandgroupvalue").val(msg.split("|")[6]);
//		        			$("#localityelements_idislandgroup").val(msg.split("|")[7]);
//	        			
//						}
//
////	         	 		if (msg.split("|")[6]!=''){
////	         	 			dasabilitaCampos("islandgroup");
////	         	 			$('#divislandgroupValor').text(msg.split("|")[6]);
////	         	 		}else
////	         	 			habilitaCampos("islandgroup");
//
////						if($("#island").val()=='')
////							camposReset.push("island");
//
//						if($('#localityelements_idisland').val()==""){
//	        			
//							$("#island").val(msg.split("|")[8]);
//							$("#islandvalue").val(msg.split("|")[8]);
//		        			$("#localityelements_idisland").val(msg.split("|")[9]);
//
//						}
////	         	 		if (msg.split("|")[8]!=''){
////	         	 			dasabilitaCampos("island");
////	         	 			$('#divislandValor').text(msg.split("|")[8]);
////	         	 		}else
////	         	 			habilitaCampos("island");
//
////						if($("#country").val()=='')
////							camposReset.push("country");
//
//						if($('#localityelements_idcountry').val()==""){
//
//							$("#country").val(msg.split("|")[10]);
//							$("#countryvalue").val(msg.split("|")[10]);
//		        			$("#localityelements_idcountry").val(msg.split("|")[11]);
//	        			
//						}
//
////	         	 		if (msg.split("|")[10]!=''){
////	         	 			dasabilitaCampos("country");
////	         	 			$('#divcountryValor').text(msg.split("|")[10]);
////	         	 		}else
////	         	 			habilitaCampos("country");
//
////						if($("#stateprovince").val()=='')
////							camposReset.push("stateprovince");
//
//						if($('#localityelements_idstateprovince').val()==""){
//
//							$("#stateprovince").val(msg.split("|")[12]);
//							$("#stateprovincevalue").val(msg.split("|")[12]);
//			         	 	$("#localityelements_idstateprovince").val(msg.split("|")[13]);
//
//						}
////	         	 		if (msg.split("|")[12]!=''){
////	         	 			dasabilitaCampos("stateprovince");
////	         	 			$('#divstateprovinceValor').text(msg.split("|")[12]);
////	         	 		}else
////	         	 			habilitaCampos("stateprovince");
//
//                    	/*
//                    	 * Comentado para nao apagar os campos abaixo do formulario
//                    	 */		         	 	
//		         	 	
////						$("#municipality").val("");
////						$("#municipalityvalue").val("");
////						$("#localityelements_idmunicipality").val("");
////						$("#locality").val("");
////						$("#localityvalue").val("");
////						$("#localityelements_idlocality").val("");
//
//		         	 	camposReset.push("county");
//		         		camposPreenchidosLocalityElements.push(camposReset);
//		         		
//		         		habilitaLinkDesfazerLocalityElements();
//
//	     		   }
//	     		 });
//
//	        	//camposReset.push("divcountyReset");
// 	 		}else{
//         	 	camposReset.push("county");
//         		camposPreenchidosLocalityElements.push(camposReset);
// 	 		}
//
//		break;

		case "municipality":
 	 		$('#localityelements_idmunicipality').val(idValor);
 	 		$('#municipality').val(valor);
 	 		$('#municipalityvalue').val(valor);

//                        $("#divmunicipalityeReset").css("display","block");
//
// 	 		if (valor!=''){
// 	 			dasabilitaCampos("municipality");
// 	 			$('#divmunicipalityValor').text(valor);
// 	 		}else
// 	 			habilitaCampos("municipality");

 	 		if(sugerir!="no"){

	        	$.ajax({
	     		   url: "index.php?r=autocompletelocalityelements&idSelect="+idValor+"&tableField="+campo,
	     		   success: function(msg){

//		        		if($("#continent").val()=='')
//		        			camposReset.push("continent");

						if($('#localityelements_idcontinent').val()==""){
	
		        			$("#continent").val(msg.split("|")[2]);
							$("#continentvalue").val(msg.split("|")[2]);
		        			$("#localityelements_idcontinent").val(msg.split("|")[3]);

						}

//	         	 		if (msg.split("|")[2]!=''){
//	         	 			dasabilitaCampos("continent");
//	         	 			$('#divcontinentValor').text(msg.split("|")[2]);
//	         	 		}else
//	         	 			habilitaCampos("continent");

//						if($("#waterbody").val()=='')
//							camposReset.push("waterbody");

						if($('#localityelements_idwaterbody').val()==""){

		        			$("#waterbody").val(msg.split("|")[4]);
		        			$("#waterbodyvalue").val(msg.split("|")[4]);
		        			$("#localityelements_idwaterbody").val(msg.split("|")[5]);
	        			
						}

//	         	 		if (msg.split("|")[4]!=''){
//	         	 			dasabilitaCampos("waterbody");
//	         	 			$('#divwaterbodyValor').text(msg.split("|")[4]);
//	         	 		}else
//	         	 			habilitaCampos("waterbody");

//						if($("#islandgroup").val()=='')
//							camposReset.push("islandgroup");

						if($('#localityelements_idislandgroup').val()==""){
				
							$("#islandgroup").val(msg.split("|")[6]);
							$("#islandgroupvalue").val(msg.split("|")[6]);
		        			$("#localityelements_idislandgroup").val(msg.split("|")[7]);
	        			
						}

//	         	 		if (msg.split("|")[6]!=''){
//	         	 			dasabilitaCampos("islandgroup");
//	         	 			$('#divislandgroupValor').text(msg.split("|")[6]);
//	         	 		}else
//	         	 			habilitaCampos("islandgroup");

//						if($("#island").val()=='')
//							camposReset.push("island");

						if($('#localityelements_idisland').val()==""){

							$("#island").val(msg.split("|")[8]);
							$("#islandvalue").val(msg.split("|")[8]);
		        			$("#localityelements_idisland").val(msg.split("|")[9]);
	        			
						}

//	         	 		if (msg.split("|")[8]!=''){
//	         	 			dasabilitaCampos("island");
//	         	 			$('#divislandValor').text(msg.split("|")[8]);
//	         	 		}else
//	         	 			habilitaCampos("island");

//						if($("#country").val()=='')
//							camposReset.push("country");

						if($('#localityelements_idcountry').val()==""){

		        			$("#country").val(msg.split("|")[10]);
		        			$("#countryvalue").val(msg.split("|")[10]);
		        			$("#localityelements_idcountry").val(msg.split("|")[11]);

						}
//	         	 		if (msg.split("|")[10]!=''){
//	         	 			dasabilitaCampos("country");
//	         	 			$('#divcountryValor').text(msg.split("|")[10]);
//	         	 		}else
//	         	 			habilitaCampos("country");

//						if($("#stateprovince").val()=='')
//							camposReset.push("stateprovince");

						if($('#localityelements_idstateprovince').val()==""){

			         		$("#stateprovince").val(msg.split("|")[12]);
			         		$("#stateprovincevalue").val(msg.split("|")[12]);
			         	 	$("#localityelements_idstateprovince").val(msg.split("|")[13]);
		         	 	
						}

//	         	 		if (msg.split("|")[12]!=''){
//	         	 			dasabilitaCampos("stateprovince");
//	         	 			$('#divstateprovinceValor').text(msg.split("|")[12]);
//	         	 		}else
//	         	 			habilitaCampos("stateprovince");

//						if($("#county").val()=='')
//							camposReset.push("county");

//						if($('#localityelements_idcounty').val()==""){
//
//			         	 	$("#county").val(msg.split("|")[14]);
//			         	 	$("#countyvalue").val(msg.split("|")[14]);
//			         	 	$("#localityelements_idcounty").val(msg.split("|")[15]);
//		         	 	
//						}

//	         	 		if (msg.split("|")[14]!=''){
//	         	 			dasabilitaCampos("county");
//	         	 			$('#divcountyValor').text(msg.split("|")[14]);
//	         	 		}else
//	         	 			habilitaCampos("county");

		         	 	
                    	/*
                    	 * Comentado para nao apagar os campos abaixo do formulario
                    	 */		         	 	
		         	 	
//						$("#locality").val("");
//						$("#localityvalue").val("");
//						$("#localityelements_idlocality").val("");

		         	 	camposReset.push("municipality");
		         		camposPreenchidosLocalityElements.push(camposReset);
		         		
		         		habilitaLabelDesfazerLocalityElements();

	     		   }
	     		 });
	        	//camposReset.push("divmunicipalityeReset");
 	 		}else{
         	 	camposReset.push("municipality");
         		camposPreenchidosLocalityElements.push(camposReset);
 	 		}
		break;

		case "locality":
 	 		$('#localityelements_idlocality').val(idValor);
 	 		$('#locality').val(valor);
 	 		$('#localityvalue').val(valor);

//                        $("#divlocalityReset").css("display","block");
//
// 	 		if (valor!=''){
// 	 			dasabilitaCampos("locality");
// 	 			$('#divlocalityValor').text(valor);
// 	 		}else
// 	 			habilitaCampos("locality");

 	 		if(sugerir!="no"){

	        	$.ajax({
	     		   url: "index.php?r=autocompletelocalityelements&idSelect="+idValor+"&tableField="+campo,
	     		   success: function(msg){

//						if($("#continent").val()=='')
//							camposReset.push("continent");

						if($('#localityelements_idcontinent').val()==""){
	
		        			$("#continent").val(msg.split("|")[2]);
		        			$("#continentvalue").val(msg.split("|")[2]);
		        			$("#localityelements_idcontinent").val(msg.split("|")[3]);

						}
//	         	 		if (msg.split("|")[2]!=''){
//	         	 			dasabilitaCampos("continent");
//	         	 			$('#divcontinentValor').text(msg.split("|")[2]);
//	         	 		}else
//	         	 			habilitaCampos("continent");

//						if($("#waterbody").val()=='')
//							camposReset.push("waterbody");

						if($('#localityelements_idwaterbody').val()==""){

		        			$("#waterbody").val(msg.split("|")[4]);
		        			$("#waterbodyvalue").val(msg.split("|")[4]);
		        			$("#localityelements_idwaterbody").val(msg.split("|")[5]);
	        			
						}

//	         	 		if (msg.split("|")[4]!=''){
//	         	 			dasabilitaCampos("waterbody");
//	         	 			$('#divwaterbodyValor').text(msg.split("|")[4]);
//	         	 		}else
//	         	 			habilitaCampos("waterbody");

//						if($("#islandgroup").val()=='')
//		         	 		camposReset.push("islandgroup");

						if($('#localityelements_idislandgroup').val()==""){

		        			$("#islandgroup").val(msg.split("|")[6]);
		        			$("#islandgroupvalue").val(msg.split("|")[6]);
		        			$("#localityelements_idislandgroup").val(msg.split("|")[7]);
		        			
						}

//	         	 		if (msg.split("|")[6]!=''){
//	         	 			dasabilitaCampos("islandgroup");
//	         	 			$('#divislandgroupValor').text(msg.split("|")[6]);
//	         	 		}else
//	         	 			habilitaCampos("islandgroup");

//						if($("#island").val()=='')
//							camposReset.push("island");

						if($('#localityelements_idisland').val()==""){

							$("#island").val(msg.split("|")[8]);
							$("#islandvalue").val(msg.split("|")[8]);
		        			$("#localityelements_idisland").val(msg.split("|")[9]);

						}
//	         	 		if (msg.split("|")[8]!=''){
//	         	 			dasabilitaCampos("island");
//	         	 			$('#divislandValor').text(msg.split("|")[8]);
//	         	 		}else
//	         	 			habilitaCampos("island");

//						if($("#country").val()=='')
//							camposReset.push("country");

						if($('#localityelements_idcountry').val()==""){

		        			$("#country").val(msg.split("|")[10]);
		        			$("#countryvalue").val(msg.split("|")[10]);
		        			$("#localityelements_idcountry").val(msg.split("|")[11]);

						}
//	         	 		if (msg.split("|")[10]!=''){
//	         	 			dasabilitaCampos("country");
//	         	 			$('#divcountryValor').text(msg.split("|")[10]);
//	         	 		}else
//	         	 			habilitaCampos("country");

//						if($("#stateprovince").val()=='')
//							camposReset.push("stateprovince");

						if($('#localityelements_idstateprovince').val()==""){

			         		$("#stateprovince").val(msg.split("|")[12]);
			         		$("#stateprovincevalue").val(msg.split("|")[12]);
			         	 	$("#localityelements_idstateprovince").val(msg.split("|")[13]);
		         	 	
						}

//	         	 		if (msg.split("|")[12]!=''){
//	         	 			dasabilitaCampos("stateprovince");
//	         	 			$('#divstateprovinceValor').text(msg.split("|")[12]);
//	         	 		}else
//	         	 			habilitaCampos("stateprovince");

//						if($("#county").val()=='')
//							camposReset.push("county");

//						if($('#localityelements_idcounty').val()==""){
//
//			         	 	$("#county").val(msg.split("|")[14]);
//			         	 	$("#countyvalue").val(msg.split("|")[14]);
//			         	 	$("#localityelements_idcounty").val(msg.split("|")[15]);
//
//						}
//	         	 		if (msg.split("|")[14]!=''){
//	         	 			dasabilitaCampos("county");
//	         	 			$('#divcountyValor').text(msg.split("|")[14]);
//	         	 		}else
//	         	 			habilitaCampos("county");

//						if($("#municipality").val()=='')
//							camposReset.push("municipality");

						if($('#localityelements_idmunicipality').val()==""){
						
							$("#municipality").val(msg.split("|")[16]);
							$("#municipalityvalue").val(msg.split("|")[16]);
						  	$("#localityelements_idmunicipality").val(msg.split("|")[17]);

						}
//	         	 		if (msg.split("|")[16]!=''){
//	         	 			dasabilitaCampos("municipality");
//	         	 			$('#divmunicipalityValor').text(msg.split("|")[16]);
//	         	 		}else
//	         	 			habilitaCampos("municipality");

	             	 	camposReset.push("locality");
	             		camposPreenchidosLocalityElements.push(camposReset);
	             		
	             		habilitaLabelDesfazerLocalityElements();

	     		   }
	     		 });

	        	//camposReset.push("divlocalityReset");
 	 		}else{
         	 	camposReset.push("locality");
         		camposPreenchidosLocalityElements.push(camposReset);
 	 		}
		break;
		
		case "habitat":
			
			$('#localityelements_idhabitat').val(idValor);
            $('#habitat').val(valor);
            $('#habitatvalue').val(valor);			
			
		break;

	}
	// overlay.add(container).fadeOut('normal');

	//$('#overlay').add($('#container')).fadeOut('normal');
	$('#overlay').fadeOut('normal');
	$('#lightbox').fadeOut('normal');
	
}

function limpaCamposLocalityElements(){

	var arrayAux = camposPreenchidosLocalityElements.pop();

	campo = "vazio"
	while (campo!=0){
		campo = arrayAux.pop();
		if (campo!=0){
			$("#"+campo).val("");
                        $("#"+campo+"value").val("");
	 	 	$("#localityelements_id"+campo).val("");
	 	 	habilitaCampos(campo);
	 	 	$("#"+campo+"Reset").css("display","none");
		}
	}
	if (camposPreenchidosLocalityElements!=0){
		campoPreenchidosAux = camposPreenchidosLocalityElements.slice();
		arrayAux2 = campoPreenchidosAux.pop().slice();
		campo = arrayAux2.pop();
		//$("#div"+campo+"Reset").css("display","block");
	}

}

function insertDataLocalityElements(fieldTarget, fieldIdTarget, urlTarget, extraParams){

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

                        escondeBotaoResetLocalityElements();
                        var camposReset = new Array();
                        camposReset.push(0);

//				$("#div"+fieldTarget.attr("id")+"Reset").css("display","block");
//
//	 	 		if (msg.split("|||")[0]!=''){
//	 	 			dasabilitaCampos(fieldTarget.attr("id"));
//                                        $('#div'+fieldTarget.attr("id")+'Valor').text(msg.split("|||")[0]);
//	 	 		}else
//	 	 			habilitaCampos(fieldTarget.attr("id"));

	                camposReset.push(fieldTarget.attr("id"));
	                camposPreenchidosLocalityElements.push(camposReset);

	                
	                if((fieldTarget.attr("id")=="kingdom")
	                    	||(fieldTarget.attr("id")=="continent")
	                    	||(fieldTarget.attr("id")=="waterbody")
	                    	||(fieldTarget.attr("id")=="islandgroup")
	                    	||(fieldTarget.attr("id")=="island")
	                    	||(fieldTarget.attr("id")=="country")
	                    	||(fieldTarget.attr("id")=="stateprovince")
	                    	||(fieldTarget.attr("id")=="county")
	                    	||(fieldTarget.attr("id")=="locality")
	                    	||(fieldTarget.attr("id")=="municipality")
	                    ){
	                		habilitaLabelDesfazerLocalityElements();
	                    }	       

                } else {
                        $('div[class^=target]').html(msg);
                }
	   }
	 });
}