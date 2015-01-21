var camposPreenchidosTaxonomicElements = new Array();
camposPreenchidosTaxonomicElements.push(0);

function concatenarValoresUrlTaxonomicElements(){
    var url = "";
	
    if ($("#taxonomicelements_idkingdom").val()!="")
        url += '&formIdKingdom='+ $("#taxonomicelements_idkingdom").val();

    if ($("#taxonomicelements_idphylum").val()!="")
        url += '&formIdPhylum='+ $("#taxonomicelements_idphylum").val();
    
    if ($("#taxonomicelements_idclass").val()!="")
        url += '&formIdClass='+ $("#taxonomicelements_idclass").val();
    
    if ($("#taxonomicelements_idorder").val()!="")
        url += '&formIdOrder='+ $("#taxonomicelements_idorder").val();
    
    if ($("#taxonomicelements_idfamily").val()!="")
        url += '&formIdFamily='+ $("#taxonomicelements_idfamily").val();
    
    if ($("#taxonomicelements_idgenus").val()!="")
        url += '&formIdGenus='+ $("#taxonomicelements_idgenus").val();

    if ($("#taxonomicelements_idsubgenus").val()!="")
        url += '&formIdSubgenus='+ $("#taxonomicelements_idsubgenus").val();

    if ($("#taxonomicelements_idspecificepithet").val()!="")
        url += '&formIdSpecificepithet='+ $("#taxonomicelements_idspecificepithet").val();
    
    if ($("#taxonomicelements_idscientificname").val()!="")
        url += '&formIdScientificname='+ $("#taxonomicelements_idscientificname").val();
    
    if ($("#taxonomicelements_idinfraspecificepithet").val()!="")
        url += '&formIdInfraspecificepithet='+ $("#taxonomicelements_idinfraspecificepithet").val();
    
    return url;
	
}

function escondeBotaoResetTaxonomicElements(){
    // esconde os botões de limpar de todos os camos
    $("#divkingdomReset").css("display","none");
    $("#divphylumReset").css("display","none");
    $("#divclassReset").css("display","none");
    $("#divorderReset").css("display","none");
    $("#divfamilyReset").css("display","none");
    $("#divgenusReset").css("display","none");
    $("#divsubgenusReset").css("display","none");
    $("#divspecificepithetReset").css("display","none");
    $("#divscientificnameReset").css("display","none");
    $("#divinfraspecificepithetReset").css("display","none");
    $("#divinfraspecificepithetReset").css("display","none");
    $("#divinfraspecificrankReset").css("display","none");
    $("#divnomenclaturalcodeReset").css("display","none");
    $("#divnomenclaturalcodeReset").css("display","none");
    $("#divscientificnameauthorshipReset").css("display","none");
}

function selecionaItemTaxonomicElements(campo, valor, idValor, sugerir){
	
    //escondeBotaoResetTaxonomicElements();
    //resetCampos();
    var camposReset = new Array();
    camposReset.push(0);	
	
    switch(campo){
        case "kingdom":
            $('#taxonomicelements_idkingdom').val(idValor);
            $('#kingdom').val(valor);
            $('#kingdomvalue').val(valor);
         	
            //                      $("#divkingdomReset").css("display","block");
            //
            // 	 		if (valor!=''){
            // 	 			dasabilitaCampos("kingdom");
            // 	 			$('#divkingdomValor').text(valor);
            // 	 		}else
            // 	 			habilitaCampos("kingdom");
 	 		
            if(sugerir!="no"){
            	
            	/*
            	 * Comentado para nao apagar os campos abaixo
            	 */
            	
//                $("#phylum").val("");
//                $("#phylumvalue").val("");
//                $("#taxonomicelements_idphylum").val("");
//                $("#class").val("");
//                $("#classvalue").val("");
//                $("#taxonomicelements_idclass").val("");
//                $("#order").val("");
//                $("#ordervalue").val("");
//                $("#taxonomicelements_idorder").val("");
//                $("#family").val("");
//                $("#familyvalue").val("");
//                $("#taxonomicelements_idfamily").val("");
//                $("#genus").val("");
//                $("#genusvalue").val("");
//                $("#taxonomicelements_idgenus").val("");
//                $("#subgenus").val("");
//                $("#subgenusvalue").val("");
//                $("#taxonomicelements_idsubgenus").val("");
//                $("#specificepithet").val("");
//                $("#specificepithetvalue").val("");
//                $("#taxonomicelements_idspecificepithet").val("");
//                $("#scientificname").val("");
//                $("#scientificnamevalue").val("");
//                $("#taxonomicelements_idscientificname").val("");
//                $("#infraspecificepithet").val("");
//                $("#infraspecificepithetvalue").val("");
//                $("#taxonomicelements_idinfraspecificepithet").val("");
            }
 	 		

//            camposReset.push("kingdom");
//            camposPreenchidosTaxonomicElements.push(camposReset);
//            
//            habilitaLinkDesfazerTaxonomicElements();
         	
            break;
		
        case "phylum":
            $('#taxonomicelements_idphylum').val(idValor);
            $('#phylum').val(valor);
            $('#phylumvalue').val(valor);

            //                        $("#divphylumReset").css("display","block");
            //
            // 	 		if (valor!=''){
            // 	 			dasabilitaCampos("phylum");
            // 	 			$('#divphylumValor').text(valor);
            // 	 		}else
            // 	 			habilitaCampos("phylum");
 	 		
            if(sugerir!="no"){
 	 		
                $.ajax({
                    url: "index.php?r=autocomplete&idSelect="+idValor+"&tableField="+campo,
                    success: function(msg){
	        		
//                        if($("#kingdom").val()==''){
//                            camposReset.push("kingdom");
//                        }
	        		
						
							if($("#taxonomicelements_idkingdom").val()==''){
								$("#kingdom").val(msg.split("|")[2]);
								$("#kingdomvalue").val(msg.split("|")[2]);
								$("#taxonomicelements_idkingdom").val(msg.split("|")[3]);
							}
	        			
                        //	         	 		if (msg.split("|")[2]!=''){
                        //	         	 			dasabilitaCampos("kingdom");
                        //	         	 			$('#divkingdomValor').text(msg.split("|")[2]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("kingdom");
	         	 		
                        //camposReset.push("kingdom");
	        			
                    	/*
                    	 * Comentado para nao apagar os campos abaixo
                    	 */                        
                        
//                        $("#class").val("");
//                        $("#classvalue").val("");
//                        $("#taxonomicelements_idclass").val("");
//                        $("#order").val("");
//                        $("#ordervalue").val("");
//                        $("#taxonomicelements_idorder").val("");
//                        $("#family").val("");
//                        $("#familyvalue").val("");
//                        $("#taxonomicelements_idfamily").val("");
//                        $("#genus").val("");
//                        $("#genusvalue").val("");
//                        $("#taxonomicelements_idgenus").val("");
//                        $("#subgenus").val("");
//                        $("#subgenusvalue").val("");
//                        $("#taxonomicelements_idsubgenus").val("");
//                        $("#specificepithet").val("");
//                        $("#specificepithetvalue").val("");
//                        $("#taxonomicelements_idspecificepithet").val("");
//                        $("#scientificname").val("");
//                        $("#scientificnamevalue").val("");
//                        $("#taxonomicelements_idscientificname").val("");
//                        $("#infraspecificepithet").val("");
//                        $("#infraspecificepithetvalue").val("");
//                        $("#taxonomicelements_idinfraspecificepithet").val("");
		         	 	
                        camposReset.push("phylum");
                        camposPreenchidosTaxonomicElements.push(camposReset);
                        
                        habilitaLinkDesfazerTaxonomicElements();
                    }
                });
	        	

            }else{
            	
                $("#kingdom").val("");
                $("#kingdomvalue").val("");
                $("#taxonomicelements_idkingdom").val("");            	
            	
            	
//                camposReset.push("phylum");
//                camposPreenchidosTaxonomicElements.push(camposReset);
            }         
            
            
            break;
		
        case "class":
            $('#taxonomicelements_idclass').val(idValor);
            $('#class').val(valor);
            $('#classvalue').val(valor);
         	
            //                        $("#divclassReset").css("display","block");
            //
            // 	 		if (valor!=''){
            // 	 			dasabilitaCampos("class");
            // 	 			$('#divclassValor').text(valor);
            // 	 		}else
            // 	 			habilitaCampos("class");
         	
            if(sugerir!='no'){

            	
                $.ajax({
                    url: "index.php?r=autocomplete&idSelect="+idValor+"&tableField="+campo,
                    success: function(msg){
	        		
                      
//                		if($("#kingdom").val()=='')
//                            camposReset.push("kingdom");
        		
						if($("#taxonomicelements_idkingdom").val()==''){	
	
	                        $("#kingdom").val(msg.split("|")[2]);
	                        $("#kingdomvalue").val(msg.split("|")[2]);
	                        $("#taxonomicelements_idkingdom").val(msg.split("|")[3]);
                        
						}
	         			
                        //	         	 		if (msg.split("|")[2]!=''){
                        //	         	 			dasabilitaCampos("kingdom");
                        //	         	 			$('#divkingdomValor').text(msg.split("|")[2]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("kingdom");

//                        if($("#phylum").val()=='')
//                            camposReset.push("phylum");
	         	 		
                        if($("#taxonomicelements_idphylum").val()==''){                        
                        
	                        $("#phylum").val(msg.split("|")[4]);
	                        $("#phylumvalue").val(msg.split("|")[4]);
	                        $("#taxonomicelements_idphylum").val(msg.split("|")[5]);
                        
                        }
	         			
                        //	         	 		if (msg.split("|")[4]!=''){
                        //	         	 			dasabilitaCampos("phylum");
                        //	         	 			$('#divphylumValor').text(msg.split("|")[4]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("phylum");
	         	 		
                    	/*
                    	 * Comentado para nao apagar os campos abaixo
                    	 */
                        
//                        $("#order").val("");
//                        $("#ordervalue").val("");
//                        $("#taxonomicelements_idorder").val("");
//                        $("#family").val("");
//                        $("#familyvalue").val("");
//                        $("#taxonomicelements_idfamily").val("");
//                        $("#genus").val("");
//                        $("#genusvalue").val("");
//                        $("#taxonomicelements_idgenus").val("");
//                        $("#subgenus").val("");
//                        $("#subgenusvalue").val("");
//                        $("#taxonomicelements_idsubgenus").val("");
//                        $("#specificepithet").val("");
//                        $("#specificepithetvalue").val("");
//                        $("#taxonomicelements_idspecificepithet").val("");
//                        $("#scientificname").val("");
//                        $("#scientificnamevalue").val("");
//                        $("#taxonomicelements_idscientificname").val("");
//                        $("#infraspecificepithet").val("");
//                        $("#infraspecificepithetvalue").val("");
//                        $("#taxonomicelements_idinfraspecificepithet").val("");
		         	 	
                        camposReset.push("class");
                        camposPreenchidosTaxonomicElements.push(camposReset);
                        
                        habilitaLinkDesfazerTaxonomicElements();
                    }
                });
	        	
	        	
            }else{
            	
                $("#kingdom").val("");
                $("#kingdomvalue").val("");
                $("#taxonomicelements_idkingdom").val("");
                
                $("#phylum").val("");
                $("#phylumvalue").val("");
                $("#taxonomicelements_idphylum").val("");                
            	
            	
//                camposReset.push("class");
//                camposPreenchidosTaxonomicElements.push(camposReset);
            }
            break;
		
        case "order":
            $('#taxonomicelements_idorder').val(idValor);
            $('#order').val(valor);
            $('#ordervalue').val(valor);

            //                        $("#divorderReset").css("display","block");
            //
            // 	 		if (valor!=''){
            // 	 			dasabilitaCampos("order");
            // 	 			$('#divorderValor').text(valor);
            // 	 		}else
            // 	 			habilitaCampos("order");
         	
            if(sugerir!="no"){
                $.ajax({
                    url: "index.php?r=autocomplete&idSelect="+idValor+"&tableField="+campo,
                    success: function(msg){
	        		
//                        if($("#kingdom").val()=='')
//                            camposReset.push("kingdom");

                        if($("#taxonomicelements_idkingdom").val()==''){                       
	                        
                        	$("#kingdom").val(msg.split("|")[2]);
	                        $("#kingdomvalue").val(msg.split("|")[2]);
	                        $("#taxonomicelements_idkingdom").val(msg.split("|")[3]);
	                        
                        }
	        			
                        //	         	 		if (msg.split("|")[2]!=''){
                        //	         	 			dasabilitaCampos("kingdom");
                        //	         	 			$('#divkingdomValor').text(msg.split("|")[2]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("kingdom");
	         	 		
//                        if($("#phylum").val()=='')
//                            camposReset.push("phylum");
	        			
                        
                        if($("#taxonomicelements_idphylum").val()==''){                        
	                        
                        	$("#phylum").val(msg.split("|")[4]);
	                        $("#phylumvalue").val(msg.split("|")[4]);
	                        $("#taxonomicelements_idphylum").val(msg.split("|")[5]);
	                        
                        }
	         			
                        //	         	 		if (msg.split("|")[4]!=''){
                        //	         	 			dasabilitaCampos("phylum");
                        //	         	 			$('#divphylumValor').text(msg.split("|")[4]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("phylum");

//                        if($("#class").val()=='')
//                            camposReset.push("class");
	        			
                        if($("#taxonomicelements_idclass").val()==''){             
                        
	                        $("#class").val(msg.split("|")[6]);
	                        $("#classvalue").val(msg.split("|")[6]);
	                        $("#taxonomicelements_idclass").val(msg.split("|")[7]);
                        
                        }
	        			
                        //	         	 		if (msg.split("|")[6]!=''){
                        //	         	 			dasabilitaCampos("class");
                        //	         	 			$('#divclassValor').text(msg.split("|")[6]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("class");
	         	 		
                    	/*
                    	 * Comentado para nao apagar os campos abaixo
                    	 */                        
   			
//                        $("#family").val("");
//                        $("#familyvalue").val("");
//                        $("#taxonomicelements_idfamily").val("");
//                        $("#genus").val("");
//                        $("#genusvalue").val("");
//                        $("#taxonomicelements_idgenus").val("");
//                        $("#subgenus").val("");
//                        $("#subgenusvalue").val("");
//                        $("#taxonomicelements_idsubgenus").val("");
//                        $("#specificepithet").val("");
//                        $("#specificepithetvalue").val("");
//                        $("#taxonomicelements_idspecificepithet").val("");
//                        $("#scientificname").val("");
//                        $("#scientificnamevalue").val("");
//                        $("#taxonomicelements_idscientificname").val("");
//                        $("#infraspecificepithet").val("");
//                        $("#infraspecificepithetvalue").val("");
//                        $("#taxonomicelements_idinfraspecificepithet").val("");
		         	 	
                        camposReset.push("order");
                        camposPreenchidosTaxonomicElements.push(camposReset);
                        
                        habilitaLinkDesfazerTaxonomicElements();
                        
                    }
                });


            }else{
            	
                $("#kingdom").val("");
                $("#kingdomvalue").val("");
                $("#taxonomicelements_idkingdom").val("");
                
                $("#phylum").val("");
                $("#phylumvalue").val("");
                $("#taxonomicelements_idphylum").val("");            	

                $("#class").val("");
                $("#classvalue").val("");
                $("#taxonomicelements_idclass").val("");                
                
            	
//                camposReset.push("order");
//                camposPreenchidosTaxonomicElements.push(camposReset);
            }
            break;
		
        case "family":
            $('#taxonomicelements_idfamily').val(idValor);
            $('#family').val(valor);
            $('#familyvalue').val(valor);

            //                        $("#divfamilyReset").css("display","block");
            //
            // 	 		if (valor!=''){
            // 	 			dasabilitaCampos("family");
            // 	 			$('#divfamilyValor').text(valor);
            // 	 		}else
            // 	 			habilitaCampos("family");
 	 		
            if(sugerir!="no"){
                $.ajax({
                    url: "index.php?r=autocomplete&idSelect="+idValor+"&tableField="+campo,
                    success: function(msg){
	        		
//                        if($("#kingdom").val()=='')
//                            camposReset.push("kingdom");
	        		
                        if($("#taxonomicelements_idkingdom").val()==''){
                        
	                        $("#kingdom").val(msg.split("|")[2]);
	                        $("#kingdomvalue").val(msg.split("|")[2]);
	                        $("#taxonomicelements_idkingdom").val(msg.split("|")[3]);
                        
                        }
	        			
                        //	         	 		if (msg.split("|")[2]!=''){
                        //	         	 			dasabilitaCampos("kingdom");
                        //	         	 			$('#divkingdomValor').text(msg.split("|")[2]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("kingdom");
       	 		
	         	 		
//                        if($("#phylum").val()=='')
//                            camposReset.push("phylum");
	         	 		
                        if($("#taxonomicelements_idphylum").val()==''){
                        
	                        $("#phylum").val(msg.split("|")[4]);
	                        $("#phylumvalue").val(msg.split("|")[4]);
	                        $("#taxonomicelements_idphylum").val(msg.split("|")[5]);
                        
                        }
	         			
                        //	         	 		if (msg.split("|")[4]!=''){
                        //	         	 			dasabilitaCampos("phylum");
                        //	         	 			$('#divphylumValor').text(msg.split("|")[4]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("phylum");
	         	 		
//                        if($("#class").val()=='')
//                            camposReset.push("class");
	        			
                        if($("#taxonomicelements_idclass").val()==''){
                        
	                        $("#class").val(msg.split("|")[6]);
	                        $("#classvalue").val(msg.split("|")[6]);
	                        $("#taxonomicelements_idclass").val(msg.split("|")[7]);
                        
                        }
	        			
                        //	         	 		if (msg.split("|")[6]!=''){
                        //	         	 			dasabilitaCampos("class");
                        //	         	 			$('#divclassValor').text(msg.split("|")[6]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("class");
	         	 		
//                        if($("#order").val()=='')
//                            camposReset.push("order");
	        			
                        if($("#taxonomicelements_idorder").val()==''){
                        
	                        $("#order").val(msg.split("|")[8]);
	                        $("#ordervalue").val(msg.split("|")[8]);
	                        $("#taxonomicelements_idorder").val(msg.split("|")[9]);
                        
                        }
	        			
                        //	         	 		if (msg.split("|")[8]!=''){
                        //	         	 			dasabilitaCampos("order");
                        //	         	 			$('#divorderValor').text(msg.split("|")[8]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("order");

                    	/*
                    	 * Comentado para nao apagar os campos abaixo
                    	 */                        
                        
//                        $("#genus").val("");
//                        $("#genusvalue").val("");
//                        $("#taxonomicelements_idgenus").val("");
//                        $("#subgenus").val("");
//                        $("#subgenusvalue").val("");
//                        $("#taxonomicelements_idsubgenus").val("");
//                        $("#specificepithet").val("");
//                        $("#specificepithetvalue").val("");
//                        $("#taxonomicelements_idspecificepithet").val("");
//                        $("#scientificname").val("");
//                        $("#scientificnamevalue").val("");
//                        $("#taxonomicelements_idscientificname").val("");
//                        $("#infraspecificepithet").val("");
//                        $("#infraspecificepithetvalue").val("");
//                        $("#taxonomicelements_idinfraspecificepithet").val("");

                        camposReset.push("family");
                        camposPreenchidosTaxonomicElements.push(camposReset);
                        
                        habilitaLinkDesfazerTaxonomicElements();
                    }
                });
	        	
            //camposReset.push("divfamilyReset");
        	
            }else{            	
            	
                $("#kingdom").val("");
                $("#kingdomvalue").val("");
                $("#taxonomicelements_idkingdom").val("");
                
                $("#phylum").val("");
                $("#phylumvalue").val("");
                $("#taxonomicelements_idphylum").val("");            	

                $("#class").val("");
                $("#classvalue").val("");
                $("#taxonomicelements_idclass").val("");            	
            	
                $("#order").val("");
                $("#ordervalue").val("");
                $("#taxonomicelements_idorder").val("");
                
//                camposReset.push("family");
//                camposPreenchidosTaxonomicElements.push(camposReset);
            }
         	
            break;
		
        case "genus":
            $('#taxonomicelements_idgenus').val(idValor);
            $('#genus').val(valor);
            $('#genusvalue').val(valor);
         	
            //      	 	$("#divgenusReset").css("display","block");
            //
            // 	 		if (valor!=''){
            // 	 			dasabilitaCampos("genus");
            // 	 			$('#divgenusValor').text(valor);
            // 	 		}else
            // 	 			habilitaCampos("genus");
 	 		
            if(sugerir!="no"){
 	 		
                $.ajax({
                    url: "index.php?r=autocomplete&idSelect="+idValor+"&tableField="+campo,
                    success: function(msg){
	        		
//                        if($("#kingdom").val()=='')
//                            camposReset.push("kingdom");

						if($("#taxonomicelements_idkingdom").val()==''){
	
	                        $("#kingdom").val(msg.split("|")[2]);
	                        $("#kingdomvalue").val(msg.split("|")[2]);
	                        $("#taxonomicelements_idkingdom").val(msg.split("|")[3]);
                        
						}
	        			
                        //	         	 		if (msg.split("|")[2]!=''){
                        //	         	 			dasabilitaCampos("kingdom");
                        //                                                $('#divkingdomValor').text(msg.split("|")[2]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("kingdom");
	        			
//                        if($("#phylum").val()=='')
//                            camposReset.push("phylum");
	         	 		
                        if($("#taxonomicelements_idphylum").val()==''){
                        
	                        $("#phylum").val(msg.split("|")[4]);
	                        $("#phylumvalue").val(msg.split("|")[4]);
	                        $("#taxonomicelements_idphylum").val(msg.split("|")[5]);
                        
                        }
	         			
                        //	         	 		if (msg.split("|")[4]!=''){
                        //	         	 			dasabilitaCampos("phylum");
                        //	         	 			$('#divphylumValor').text(msg.split("|")[4]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("phylum");
	         	 		
                        if($("#class").val()=='')
                            camposReset.push("class");
	        			
                        if($("#taxonomicelements_idclass").val()==''){
                        
	                        $("#class").val(msg.split("|")[6]);
	                        $("#classvalue").val(msg.split("|")[6]);
	                        $("#taxonomicelements_idclass").val(msg.split("|")[7]);
                        
                        }
	        			
                        //	         	 		if (msg.split("|")[6]!=''){
                        //	         	 			dasabilitaCampos("class");
                        //	         	 			$('#divclassValor').text(msg.split("|")[6]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("class");
	         	 		
//                        if($("#order").val()=='')
//                            camposReset.push("order");
	        			
                        if($("#taxonomicelements_idorder").val()==''){
                        
	                        $("#order").val(msg.split("|")[8]);
	                        $("#ordervalue").val(msg.split("|")[8]);
	                        $("#taxonomicelements_idorder").val(msg.split("|")[9]);
                        
                        }
	        			
                        //	         	 		if (msg.split("|")[8]!=''){
                        //	         	 			dasabilitaCampos("order");
                        //	         	 			$('#divorderValor').text(msg.split("|")[8]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("order");

//                        if($("#family").val()=='')
//                            camposReset.push("family");
	        			
                        if($("#taxonomicelements_idfamily").val()==''){
                        
	                        $("#family").val(msg.split("|")[10]);
	                        $("#familyvalue").val(msg.split("|")[10]);
	                        $("#taxonomicelements_idfamily").val(msg.split("|")[11]);
                        
                        }
	        			
                        //	         	 		if (msg.split("|")[10]!=''){
                        //	         	 			dasabilitaCampos("family");
                        //	         	 			$('#divfamilyValor').text(msg.split("|")[10]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("family");
	         	 		
	         	 		
                    	/*
                    	 * Comentado para nao apagar os campos abaixo
                    	 */                        
                        
//                        $("#subgenus").val("");
//                        $("#subgenusvalue").val("");
//                        $("#taxonomicelements_idsubgenus").val("");
//                        $("#specificepithet").val("");
//                        $("#specificepithetvalue").val("");
//                        $("#taxonomicelements_idspecificepithet").val("");
//                        $("#scientificname").val("");
//                        $("#scientificnamevalue").val("");
//                        $("#taxonomicelements_idscientificname").val("");
//                        $("#infraspecificepithet").val("");
//                        $("#infraspecificepithetvalue").val("");
//                        $("#taxonomicelements_idinfraspecificepithet").val("");
					  	
                        camposReset.push("genus");
                        camposPreenchidosTaxonomicElements.push(camposReset);
                        
                        habilitaLinkDesfazerTaxonomicElements();
                    }
                });
	        	
            //camposReset.push("divgenusReset");
            }else{            	
            	
				$("#kingdom").val("");
				$("#kingdomvalue").val("");
				$("#taxonomicelements_idkingdom").val("");
				
				$("#phylum").val("");
				$("#phylumvalue").val("");
				$("#taxonomicelements_idphylum").val("");            	
				
				$("#class").val("");
				$("#classvalue").val("");
				$("#taxonomicelements_idclass").val("");            	
				
				$("#order").val("");
				$("#ordervalue").val("");
				$("#taxonomicelements_idorder").val("");   
				
				$("#family").val("");
				$("#familyvalue").val("");
				$("#taxonomicelements_idfamily").val("");    	
            	
//                camposReset.push("genus");
//                camposPreenchidosTaxonomicElements.push(camposReset);



            }
            break;

        case "subgenus":
            $('#taxonomicelements_idsubgenus').val(idValor);
            $('#subgenus').val(valor);
            $('#subgenusvalue').val(valor);

            //      	 	$("#divsubgenusReset").css("display","block");
            //
            // 	 		if (valor!=''){
            // 	 			dasabilitaCampos("subgenus");
            // 	 			$('#divsubgenusValor').text(valor);
            // 	 		}else
            // 	 			habilitaCampos("subgenus");

            if(sugerir!="no"){

                $.ajax({
                    url: "index.php?r=autocomplete&idSelect="+idValor+"&tableField="+campo,
                    success: function(msg){

//                        if($("#kingdom").val()=='')
//                            camposReset.push("kingdom");

						if($("#taxonomicelements_idkingdom").val()==''){
	
	                        $("#kingdom").val(msg.split("|")[2]);
	                        $("#kingdomvalue").val(msg.split("|")[2]);
	                        $("#taxonomicelements_idkingdom").val(msg.split("|")[3]);
                        
						}

                        //	         	 		if (msg.split("|")[2]!=''){
                        //	         	 			dasabilitaCampos("kingdom");
                        //                                                $('#divkingdomValor').text(msg.split("|")[2]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("kingdom");

//                        if($("#phylum").val()=='')
//                            camposReset.push("phylum");

                        if($("#taxonomicelements_idphylum").val()==''){

	                        $("#phylum").val(msg.split("|")[4]);
	                        $("#phylumvalue").val(msg.split("|")[4]);
	                        $("#taxonomicelements_idphylum").val(msg.split("|")[5]);
                        
                        }

                        //	         	 		if (msg.split("|")[4]!=''){
                        //	         	 			dasabilitaCampos("phylum");
                        //	         	 			$('#divphylumValor').text(msg.split("|")[4]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("phylum");

//                        if($("#class").val()=='')
//                            camposReset.push("class");

                        if($("#taxonomicelements_idclass").val()==''){
                        	
	                        $("#class").val(msg.split("|")[6]);
	                        $("#classvalue").val(msg.split("|")[6]);
	                        $("#taxonomicelements_idclass").val(msg.split("|")[7]);
                        
                        }

                        //	         	 		if (msg.split("|")[6]!=''){
                        //	         	 			dasabilitaCampos("class");
                        //	         	 			$('#divclassValor').text(msg.split("|")[6]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("class");

//                        if($("#order").val()=='')
//                            camposReset.push("order");

                        if($("#taxonomicelements_idorder").val()==''){
                        
	                        $("#order").val(msg.split("|")[8]);
	                        $("#ordervalue").val(msg.split("|")[8]);
	                        $("#taxonomicelements_idorder").val(msg.split("|")[9]);
                        
                        }

                        //	         	 		if (msg.split("|")[8]!=''){
                        //	         	 			dasabilitaCampos("order");
                        //	         	 			$('#divorderValor').text(msg.split("|")[8]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("order");

//                        if($("#family").val()=='')
//                            camposReset.push("family");

                        if($("#taxonomicelements_idorder").val()==''){
                        
	                        $("#family").val(msg.split("|")[10]);
	                        $("#familyvalue").val(msg.split("|")[10]);
	                        $("#taxonomicelements_idorder").val(msg.split("|")[11]);
                        
                        }

                        //	         	 		if (msg.split("|")[10]!=''){
                        //	         	 			dasabilitaCampos("family");
                        //	         	 			$('#divfamilyValor').text(msg.split("|")[10]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("family");

//                        if($("#genus").val()=='')
//                            camposReset.push("genus");

                        if($("#taxonomicelements_idgenus").val()==''){
                        
	                        $("#genus").val(msg.split("|")[12]);
	                        $("#genusvalue").val(msg.split("|")[12]);
	                        $("#taxonomicelements_idgenus").val(msg.split("|")[13]);
                        
                        }

                        //	         	 		if (msg.split("|")[12]!=''){
                        //	         	 			dasabilitaCampos("genus");
                        //	         	 			$('#divgenusValor').text(msg.split("|")[12]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("genus");

                    	/*
                    	 * Comentado para nao apagar os campos abaixo
                    	 */
                        
//                        $("#specificepithet").val("");
//                        $("#specificepithetvalue").val("");
//                        $("#taxonomicelements_idspecificepithet").val("");
//                        $("#scientificname").val("");
//                        $("#scientificnamevalue").val("");
//                        $("#taxonomicelements_idscientificname").val("");
//                        $("#infraspecificepithet").val("");
//                        $("#infraspecificepithetvalue").val("");
//                        $("#taxonomicelements_idinfraspecificepithet").val("");

                        camposReset.push("subgenus");
                        camposPreenchidosTaxonomicElements.push(camposReset);
                        
                        habilitaLinkDesfazerTaxonomicElements();
                    }
                });

            //camposReset.push("divsubgenusReset");
            }else{
//                camposReset.push("subgenus");
//                camposPreenchidosTaxonomicElements.push(camposReset);


				$("#kingdom").val("");
				$("#kingdomvalue").val("");
				$("#taxonomicelements_idkingdom").val("");
				
				$("#phylum").val("");
				$("#phylumvalue").val("");
				$("#taxonomicelements_idphylum").val("");            	
				
				$("#class").val("");
				$("#classvalue").val("");
				$("#taxonomicelements_idclass").val("");            	
				
				$("#order").val("");
				$("#ordervalue").val("");
				$("#taxonomicelements_idorder").val("");   
				
				$("#family").val("");
				$("#familyvalue").val("");
				$("#taxonomicelements_idfamily").val("");
				
				$("#genus").val("");
				$("#genusvalue").val("");
				$("#taxonomicelements_idgenus").val("");				
            }
            break;

        case "specificepithet":
            $('#taxonomicelements_idspecificepithet').val(idValor);
            $('#specificepithet').val(valor);
            $('#specificepithetvalue').val(valor);

            //                        $("#divspecificepithetReset").css("display","block");
            //
            // 	 		if (valor!=''){
            // 	 			dasabilitaCampos("specificepithet");
            // 	 			$('#divspecificepithetValor').text(valor);
            // 	 		}else
            // 	 			habilitaCampos("specificepithet");
         	
            if(sugerir!="no"){
                $.ajax({
                    url: "index.php?r=autocomplete&idSelect="+idValor+"&tableField="+campo,
                    success: function(msg){
	        		
//                        if($("#kingdom").val()=='')
//                            camposReset.push("kingdom");
	        		
						if($("#taxonomicelements_idkingdom").val()==''){	
	
	                        $("#kingdom").val(msg.split("|")[2]);
	                        $("#kingdomvalue").val(msg.split("|")[2]);
	                        $("#taxonomicelements_idkingdom").val(msg.split("|")[3]);
                        
						}
	        			
                        //	         	 		if (msg.split("|")[2]!=''){
                        //	         	 			dasabilitaCampos("kingdom");
                        //	         	 			$('#divkingdomValor').text(msg.split("|")[2]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("kingdom");
	         	 		
//                        if($("#phylum").val()=='')
//                            camposReset.push("phylum");
	        			
                        if($("#taxonomicelements_idphylum").val()==''){
                        
	                        $("#phylum").val(msg.split("|")[4]);
	                        $("#phylumvalue").val(msg.split("|")[4]);
	                        $("#taxonomicelements_idphylum").val(msg.split("|")[5]);
                        
                        }
	         			
                        //	         	 		if (msg.split("|")[4]!=''){
                        //                                                dasabilitaCampos("phylum");
                        //	         	 			$('#divphylumValor').text(msg.split("|")[4]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("phylum");

//                        if($("#class").val()=='')
//                            camposReset.push("class");
	         	 		
                        if($("#taxonomicelements_idclass").val()==''){
                        
	                        $("#class").val(msg.split("|")[6]);
	                        $("#classvalue").val(msg.split("|")[6]);
	                        $("#taxonomicelements_idclass").val(msg.split("|")[7]);
                        
                        }
	        			
                        //	         	 		if (msg.split("|")[6]!=''){
                        //	         	 			dasabilitaCampos("class");
                        //	         	 			$('#divclassValor').text(msg.split("|")[6]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("class");
	        			
//                        if($("#order").val()=='')
//                            camposReset.push("order");
	         	 		
                        if($("#taxonomicelements_idorder").val()==''){
                        
	                        $("#order").val(msg.split("|")[8]);
	                        $("#ordervalue").val(msg.split("|")[8]);
	                        $("#taxonomicelements_idorder").val(msg.split("|")[9]);
                        
                        }
	        			
                        //	         	 		if (msg.split("|")[8]!=''){
                        //	         	 			dasabilitaCampos("order");
                        //	         	 			$('#divorderValor').text(msg.split("|")[8]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("order");
	        			
//                        if($("#family").val()=='')
//                            camposReset.push("family");
	         	 		
                        if($("#taxonomicelements_idfamily").val()==''){
                        
	                        $("#family").val(msg.split("|")[10]);
	                        $("#familyvalue").val(msg.split("|")[10]);
	                        $("#taxonomicelements_idfamily").val(msg.split("|")[11]);
                        
                        }
	        			
                        //	         	 		if (msg.split("|")[10]!=''){
                        //	         	 			dasabilitaCampos("family");
                        //	         	 			$('#divfamilyValor').text(msg.split("|")[10]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("family");

//                        if($("#genus").val()=='')
//                            camposReset.push("genus");
	        			
                        if($("#taxonomicelements_idgenus").val()==''){
                        
	                        $("#genus").val(msg.split("|")[12]);
	                        $("#genusvalue").val(msg.split("|")[12]);
	                        $("#taxonomicelements_idgenus").val(msg.split("|")[13]);
                        
                        }
		         	 	
                        //	         	 		if (msg.split("|")[12]!=''){
                        //	         	 			dasabilitaCampos("genus");
                        //	         	 			$('#divgenusValor').text(msg.split("|")[12]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("genus");

//                        if($("#subgenus").val()=='')
//                            camposReset.push("subgenus");
	         	 		
                        if($("#taxonomicelements_idsubgenus").val()==''){
                        
	                        $("#subgenus").val(msg.split("|")[14]);
	                        $("#subgenusvalue").val(msg.split("|")[14]);
	                        $("#taxonomicelements_idsubgenus").val(msg.split("|")[15]);
                        
                        }
		         	 	
                        //	         	 		if (msg.split("|")[12]!=''){
                        //	         	 			dasabilitaCampos("subgenus");
                        //	         	 			$('#divsubgenusValor').text(msg.split("|")[12]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("subgenus");

                    	/*
                    	 * Comentado para nao apagar os campos abaixo
                    	 */
                        
//                        $("#scientificname").val("");
//                        $("#scientificnamevalue").val("");
//                        $("#taxonomicelements_idscientificname").val("");
//                        $("#infraspecificepithet").val("");
//                        $("#infraspecificepithetvalue").val("");
//                        $("#taxonomicelements_idinfraspecificepithet").val("");
		         	 	
                        camposReset.push("specificepithet");
                        camposPreenchidosTaxonomicElements.push(camposReset);
                        
                        habilitaLinkDesfazerTaxonomicElements();
		         	 	
                    }
                });
	        	
            //camposReset.push("divspecificepithetReset");
            }else{
            	
				$("#kingdom").val("");
				$("#kingdomvalue").val("");
				$("#taxonomicelements_idkingdom").val("");
				
				$("#phylum").val("");
				$("#phylumvalue").val();
				$("#taxonomicelements_idphylum").val("");            	
				
				$("#class").val("");
				$("#classvalue").val("");
				$("#taxonomicelements_idclass").val("");            	
				
				$("#order").val("");
				$("#ordervalue").val("");
				$("#taxonomicelements_idorder").val("");   
				
				$("#family").val("");
				$("#familyvalue").val("");
				$("#taxonomicelements_idfamily").val("");
				
				$("#genus").val("");
				$("#genusvalue").val("");
				$("#taxonomicelements_idgenus").val("");		            	
            	
				$("#subgenus").val("");
				$("#subgenusvalue").val("");
				$("#taxonomicelements_idsubgenus").val("");		            	
//                camposReset.push("specificepithet");
//                camposPreenchidosTaxonomicElements.push(camposReset);
            }
         	
            break;
		
        case "scientificname":
            $('#taxonomicelements_idscientificname').val(idValor);
            $('#scientificname').val(valor);
            $('#scientificnamevalue').val(valor);
         	
            //                        $("#divscientificnameReset").css("display","block");
            //
            // 	 		if (valor!=''){
            // 	 			dasabilitaCampos("scientificname");
            // 	 			$('#divscientificnameValor').text(valor);
            // 	 		}else
            // 	 			habilitaCampos("scientificname");
         	
            if(sugerir!="no"){
 	 		
                $.ajax({
                    url: "index.php?r=autocomplete&idSelect="+idValor+"&tableField="+campo,
                    success: function(msg){
	        		
//                        if($("#kingdom").val()=='')
//                            camposReset.push("kingdom");
	        		
						if($("#taxonomicelements_idkingdom").val()==''){
	
	                        $("#kingdom").val(msg.split("|")[2]);
	                        $("#kingdomvalue").val(msg.split("|")[2]);
	                        $("#taxonomicelements_idkingdom").val(msg.split("|")[3]);
                        
						}
	        			
                        //	         	 		if (msg.split("|")[2]!=''){
                        //	         	 			dasabilitaCampos("kingdom");
                        //	         	 			$('#divkingdomValor').text(msg.split("|")[2]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("kingdom");

//                        if($("#phylum").val()=='')
//                            camposReset.push("phylum");
	         	 		
                        if($("#taxonomicelements_idphylum").val()==''){
                        
	                        $("#phylum").val(msg.split("|")[4]);
	                        $("#phylumvalue").val(msg.split("|")[4]);
	                        $("#taxonomicelements_idphylum").val(msg.split("|")[5]);
                        
                        }                        
	        			         			
                        //	         	 		if (msg.split("|")[4]!=''){
                        //	         	 			dasabilitaCampos("phylum");
                        //	         	 			$('#divphylumValor').text(msg.split("|")[4]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("phylum");
	         	 		
//                        if($("#class").val()=='')
//                            camposReset.push("class");
                        
                        if($("#taxonomicelements_idclass").val()==''){
                        
	                        $("#class").val(msg.split("|")[6]);
	                        $("#classvalue").val(msg.split("|")[6]);
	                        $("#taxonomicelements_idclass").val(msg.split("|")[7]);
                        
                        }
	        			
                        //	         	 		if (msg.split("|")[6]!=''){
                        //	         	 			dasabilitaCampos("class");
                        //	         	 			$('#divclassValor').text(msg.split("|")[6]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("class");
	         	 		
//                        if($("#order").val()=='')
//                            camposReset.push("order");
	        			
                        if($("#taxonomicelements_idorder").val()==''){
                        
		                    $("#order").val(msg.split("|")[8]);
		                    $("#ordervalue").val(msg.split("|")[8]);
		                    $("#taxonomicelements_idorder").val(msg.split("|")[9]);
                        
                        }
	        			
                        //	         	 		if (msg.split("|")[8]!=''){
                        //	         	 			dasabilitaCampos("order");
                        //	         	 			$('#divorderValor').text(msg.split("|")[8]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("order");
	         	 		
//                        if($("#family").val()=='')
//                            camposReset.push("family");
	        			
                        if($("#taxonomicelements_idfamily").val()==''){
                        
	                        $("#family").val(msg.split("|")[10]);
	                        $("#familyvalue").val(msg.split("|")[10]);
	                        $("#taxonomicelements_idfamily").val(msg.split("|")[11]);
                        
                        }
	        			
                        //	         	 		if (msg.split("|")[10]!=''){
                        //	         	 			dasabilitaCampos("family");
                        //	         	 			$('#divfamilyValor').text(msg.split("|")[10]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("family");
	         	 		
//                        if($("#genus").val()=='')
//                            camposReset.push("genus");
	        			
                        if($("#taxonomicelements_idgenus").val()==''){
                        
	                        $("#genus").val(msg.split("|")[12]);
	                        $("#genusvalue").val(msg.split("|")[12]);
	                        $("#taxonomicelements_idgenus").val(msg.split("|")[13]);
                        
                        }
		         	 	
                        //	         	 		if (msg.split("|")[12]!=''){
                        //	         	 			dasabilitaCampos("genus");
                        //	         	 			$('#divgenusValor').text(msg.split("|")[12]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("genus");

//                        if($("#subgenus").val()=='')
//                            camposReset.push("subgenus");

                        if($("#taxonomicelements_idsubgenus").val()==''){
                        
	                        $("#subgenus").val(msg.split("|")[14]);
	                        $("#subgenusvalue").val(msg.split("|")[14]);
	                        $("#taxonomicelements_idsubgenus").val(msg.split("|")[15]);
                        
                        }

                        //	         	 		if (msg.split("|")[12]!=''){
                        //	         	 			dasabilitaCampos("subgenus");
                        //	         	 			$('#divsubgenusValor').text(msg.split("|")[12]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("subgenus");
	         	 		
//                        if($("#specificepithet").val()=='')
//                            camposReset.push("specificepithet");
		         	 	
                        if($("#taxonomicelements_idspecificepithet").val()==''){
                        
	                        $("#specificepithet").val(msg.split("|")[16]);
	                        $("#specificepithetvalue").val(msg.split("|")[16]);
	                        $("#taxonomicelements_idspecificepithet").val(msg.split("|")[17]);
                        
                        }
		         	 	
                        //	         	 		if (msg.split("|")[14]!=''){
                        //	         	 			dasabilitaCampos("specificepithet");
                        //	         	 			$('#divspecificepithetValor').text(msg.split("|")[14]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("specificepithet");
	         	 		
                        
                    	/*
                    	 * Comentado para nao apagar os campos abaixo
                    	 */
                        
//                        $("#infraspecificepithet").val("");
//                        $("#infraspecificepithetvalue").val("");
//                        $("#taxonomicelements_idinfraspecificepithet").val("");
		         	 	
                        camposReset.push("scientificname");
                        camposPreenchidosTaxonomicElements.push(camposReset);
                        
                        //habilitaLinkDesfazerTaxonomicElements();
                        habilitaLabelDesfazerTaxonomicElements();
		       
                    }
                });
            //camposReset.push("divscientificnameReset");
            }else{
            	
				$("#kingdom").val("");
				$("#kingdomvalue").val("");
				$("#taxonomicelements_idkingdom").val("");
				
				$("#phylum").val("");
				$("#phylumvalue").val("");
				$("#taxonomicelements_idphylum").val("");            	
				
				$("#class").val("");
				$("#classvalue").val("");
				$("#taxonomicelements_idclass").val("");            	
				
				$("#order").val("");
				$("#ordervalue").val("");
				$("#taxonomicelements_idorder").val("");   
				
				$("#family").val("");
				$("#familyvalue").val("");
				$("#taxonomicelements_idfamily").val("");
				
				$("#genus").val("");
				$("#genusvalue").val("");
				$("#taxonomicelements_idgenus").val("");		            	
            	
				$("#subgenus").val("");
				$("#subgenusvalue").val("");
				$("#taxonomicelements_idsubgenus").val("");         

				$("#specificepithet").val("");
				$("#specificepithetvalue").val("");
				$("#taxonomicelements_idspecificepithet").val("");				
				
				
            	
            	
//                camposReset.push("scientificname");
//                camposPreenchidosTaxonomicElements.push(camposReset);
            }
            break;
		
        case "infraspecificepithet":
            $('#taxonomicelements_idinfraspecificepithet').val(idValor);
            $('#infraspecificepithet').val(valor);
            $('#infraspecificepithetvalue').val(valor);
         	
            //                        $("#divinfraspecificepithetReset").css("display","block");
            //
            // 	 		if (valor!=''){
            // 	 			dasabilitaCampos("infraspecificepithet");
            // 	 			$('#divinfraspecificepithetValor').text(valor);
            // 	 		}else
            // 	 			habilitaCampos("infraspecificepithet");
         	
            if(sugerir!="no"){
 	 		
                $.ajax({
                    url: "index.php?r=autocomplete&idSelect="+idValor+"&tableField="+campo,
                    success: function(msg){
	        		
//                        if($("#kingdom").val()=='')
//                            camposReset.push("kingdom");
	        		
						if($("#taxonomicelements_idkingdom").val()==''){
	
	                        $("#kingdom").val(msg.split("|")[2]);
	                        $("#kingdomvalue").val(msg.split("|")[2]);
	                        $("#taxonomicelements_idkingdom").val(msg.split("|")[3]);
                        
						}
	        			
                        //	         	 		if (msg.split("|")[2]!=''){
                        //	         	 			dasabilitaCampos("kingdom");
                        //	         	 			$('#divkingdomValor').text(msg.split("|")[2]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("kingdom");
	         	 		
//                        if($("#phylum").val()=='')
//                            camposReset.push("phylum");
	        			
                        if($("#taxonomicelements_idphylum").val()==''){
                        
	                        $("#phylum").val(msg.split("|")[4]);
	                        $("#phylumvalue").val(msg.split("|")[4]);
	                        $("#taxonomicelements_idphylum").val(msg.split("|")[5]);
                        
                        }
	         			
                        //	         	 		if (msg.split("|")[4]!=''){
                        //	         	 			dasabilitaCampos("phylum");
                        //	         	 			$('#divphylumValor').text(msg.split("|")[4]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("phylum");
	         	 		
//                        if($("#class").val()=='')
//                            camposReset.push("class");
	        			
                        if($("#taxonomicelements_idclass").val()==''){
                        
	                        $("#class").val(msg.split("|")[6]);
	                        $("#classvalue").val(msg.split("|")[6]);
	                        $("#taxonomicelements_idclass").val(msg.split("|")[7]);
                        
                        }
	
                        //	         	 		if (msg.split("|")[6]!=''){
                        //	         	 			dasabilitaCampos("class");
                        //	         	 			$('#divclassValor').text(msg.split("|")[6]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("class");
	        			
//                        if($("#order").val()=='')
//                            camposReset.push("order");
	         	 		
                        if($("#taxonomicelements_idorder").val()==''){
                        
	                        $("#order").val(msg.split("|")[8]);
	                        $("#ordervalue").val(msg.split("|")[8]);
	                        $("#taxonomicelements_idorder").val(msg.split("|")[9]);
	        			
                        }
                        //	         	 		if (msg.split("|")[8]!=''){
                        //	         	 			dasabilitaCampos("order");
                        //	         	 			$('#divorderValor').text(msg.split("|")[8]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("order");
	         	 		
//                        if($("#family").val()=='')
//                            camposReset.push("family");
	        			
                        if($("#taxonomicelements_idfamily").val()==''){
                        
	                        $("#family").val(msg.split("|")[10]);
	                        $("#familyvalue").val(msg.split("|")[10]);
	                        $("#taxonomicelements_idfamily").val(msg.split("|")[11]);
                        
                        }
	        			
                        //	         	 		if (msg.split("|")[10]!=''){
                        //	         	 			dasabilitaCampos("family");
                        //	         	 			$('#divfamilyValor').text(msg.split("|")[10]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("family");
	         	 		
//                        if($("#genus").val()=='')
//                            camposReset.push("genus");
	        			
                        if($("#taxonomicelements_idgenus").val()==''){
                        
	                        $("#genus").val(msg.split("|")[12]);
	                        $("#genusvalue").val(msg.split("|")[12]);
	                        $("#taxonomicelements_idgenus").val(msg.split("|")[13]);
                        
                        }
		         	 	
                        //	         	 		if (msg.split("|")[12]!=''){
                        //	         	 			dasabilitaCampos("genus");
                        //	         	 			$('#divgenusValor').text(msg.split("|")[12]);
                        //	         	 		}else
                        //	         	 			habilitaCampos("genus");

//                        if($("#subgenus").val()=='')
//                            camposReset.push("subgenus");

                        if($("#taxonomicelements_idsubgenus").val()==''){
                        
		                    $("#subgenus").val(msg.split("|")[14]);
		                    $("#subgenusvalue").val(msg.split("|")[14]);
		                    $("#taxonomicelements_idsubgenus").val(msg.split("|")[15]);
                        
                        }
                        
	         	 		
//                        if($("#specificepithet").val()=='')
//                            camposReset.push("specificepithet");
		         	 	
						if($("#taxonomicelements_idspecificepithet").val()==''){
	
	                        $("#specificepithet").val(msg.split("|")[16]);
	                        $("#specificepithetvalue").val(msg.split("|")[16]);
	                        $("#taxonomicelements_idspecificepithet").val(msg.split("|")[17]);
                        
						}
	
//                        if($("#scientificname").val()=='')
//                            camposReset.push("scientificname");
	         	 		
						if($("#taxonomicelements_idscientificname").val()==''){
	
	                        $("#scientificname").val(msg.split("|")[18]);
	                        $("#scientificnamevalue").val(msg.split("|")[18]);
	                        $("#taxonomicelements_idscientificname").val(msg.split("|")[19]);
					  	
						}

                        camposReset.push("infraspecificepithet");
                        camposPreenchidosTaxonomicElements.push(camposReset);
                        
                        habilitaLinkDesfazerTaxonomicElements();
	         	 		
                    }
                });
	        	 
            //camposReset.push("divinfraspecificepithetReset");
            }else{
//                camposReset.push("infraspecificepithet");
//                camposPreenchidosTaxonomicElements.push(camposReset);

				$("#kingdom").val("");
				$("#kingdomvalue").val("");
				$("#taxonomicelements_idkingdom").val("");
				
				$("#phylum").val();
				$("#phylumvalue").val();
				$("#taxonomicelements_idphylum").val("");            	
				
				$("#class").val("");
				$("#classvalue").val("");
				$("#taxonomicelements_idclass").val("");            	
				
				$("#order").val("");
				$("#ordervalue").val("");
				$("#taxonomicelements_idorder").val("");   
				
				$("#family").val("");
				$("#familyvalue").val("");
				$("#taxonomicelements_idfamily").val("");
				
				$("#genus").val("");
				$("#genusvalue").val("");
				$("#taxonomicelements_idgenus").val("");		            	
				
				$("#subgenus").val("");
				$("#subgenusvalue").val("");
				$("#taxonomicelements_idsubgenus").val("");         
				
				$("#specificepithet").val("");
				$("#specificepithetvalue").val("");
				$("#taxonomicelements_idspecificepithet").val("");

				$("#infraspecificepithet").val("");
				$("#infraspecificepithetvalue").val("");
				$("#taxonomicelements_idinfraspecificepithet").val("");				

            }
            break;
		
        case "infraspecificrank":
			
            $('#taxonomicelements_infraspecificrank').val(idValor);
            $('#infraspecificrank').val(valor);
            $('#infraspecificrankvalue').val(valor);
		
            //			$("#divinfraspecificrankReset").css("display","block");
            //
            // 	 		if (valor!=''){
            // 	 			dasabilitaCampos("infraspecificrank");
            // 	 			$('#divinfraspecificrankValor').text(valor);
            // 	 		}else
            // 	 			habilitaCampos("infraspecificrank");
         	
            camposReset.push("infraspecificrank");
            camposPreenchidosTaxonomicElements.push(camposReset);
         	
            break;

        case "taxonrank":

            $('#taxonomicelements_idtaxonrank').val(idValor);
            $('#taxonrank').val(valor);
            $('#taxonrankvalue').val(valor);

            //			$("#divinfraspecificrankReset").css("display","block");
            //
            // 	 		if (valor!=''){
            // 	 			dasabilitaCampos("infraspecificrank");
            // 	 			$('#divinfraspecificrankValor').text(valor);
            // 	 		}else
            // 	 			habilitaCampos("infraspecificrank");

            camposReset.push("infraspecificrank");
            camposPreenchidosTaxonomicElements.push(camposReset);

            break;
		
        case "scientificnameauthorship":
            $('#taxonomicelements_idscientificnameauthorship').val(idValor);
            $('#scientificnameauthorship').val(valor);
            $('#scientificnameauthorshipvalue').val(valor);
         	
            //			$("#divscientificnameauthorshipReset").css("display","block");
            //
            // 	 		if (valor!=''){
            // 	 			dasabilitaCampos("scientificnameauthorship");
            // 	 			$('#divscientificnameauthorshipValor').text(valor);
            // 	 		}else
            // 	 			habilitaCampos("scientificnameauthorship");
         	
            camposReset.push("scientificnameauthorship");
            camposPreenchidosTaxonomicElements.push(camposReset);
            break;
		
        case "nomenclaturalcode":
            $('#taxonomicelements_idnomenclaturalcode').val(idValor);
            $('#nomenclaturalcode').val(valor);
            $('#nomenclaturalcodevalue').val(valor);

            //			$("#divnomenclaturalcodeReset").css("display","block");
            //
            // 	 		if (valor!=''){
            // 	 			dasabilitaCampos("nomenclaturalcode");
            // 	 			$('#divnomenclaturalcodeValor').text(valor);
            // 	 		}else
            // 	 			habilitaCampos("nomenclaturalcode");
         	
            camposReset.push("nomenclaturalcode");
            camposPreenchidosTaxonomicElements.push(camposReset);
            break;

        case "acceptednameusage":
            $('#taxonomicelements_idacceptednameusage').val(idValor);
            $('#acceptednameusage').val(valor);
            $('#acceptednameusagevalue').val(valor);

            //			$("#divnomenclaturalcodeReset").css("display","block");
            //
            // 	 		if (valor!=''){
            // 	 			dasabilitaCampos("nomenclaturalcode");
            // 	 			$('#divnomenclaturalcodeValor').text(valor);
            // 	 		}else
            // 	 			habilitaCampos("nomenclaturalcode");

            camposReset.push("acceptednameusage");
            camposPreenchidosTaxonomicElements.push(camposReset);
            break;

        case "parentnameusage":
            $('#taxonomicelements_idparentnameusage').val(idValor);
            $('#parentnameusage').val(valor);
            $('#parentnameusagevalue').val(valor);

            //			$("#divnomenclaturalcodeReset").css("display","block");
            //
            // 	 		if (valor!=''){
            // 	 			dasabilitaCampos("nomenclaturalcode");
            // 	 			$('#divnomenclaturalcodeValor').text(valor);
            // 	 		}else
            // 	 			habilitaCampos("nomenclaturalcode");

            camposReset.push("parentnameusage");
            camposPreenchidosTaxonomicElements.push(camposReset);
            break;

        case "originalnameusage":
            $('#taxonomicelements_idoriginalnameusage').val(idValor);
            $('#originalnameusage').val(valor);
            $('#originalnameusagevalue').val(valor);

            //			$("#divnomenclaturalcodeReset").css("display","block");
            //
            // 	 		if (valor!=''){
            // 	 			dasabilitaCampos("nomenclaturalcode");
            // 	 			$('#divnomenclaturalcodeValor').text(valor);
            // 	 		}else
            // 	 			habilitaCampos("nomenclaturalcode");

            camposReset.push("originalnameusage");
            camposPreenchidosTaxonomicElements.push(camposReset);
            break;

        case "nameaccordingto":
            $('#taxonomicelements_idnameaccordingto').val(idValor);
            $('#nameaccordingto').val(valor);
            $('#nameaccordingtovalue').val(valor);

            //			$("#divnomenclaturalcodeReset").css("display","block");
            //
            // 	 		if (valor!=''){
            // 	 			dasabilitaCampos("nomenclaturalcode");
            // 	 			$('#divnomenclaturalcodeValor').text(valor);
            // 	 		}else
            // 	 			habilitaCampos("nomenclaturalcode");

            camposReset.push("nameaccordingto");
            camposPreenchidosTaxonomicElements.push(camposReset);
            break;

        case "namepublishedin":
            $('#taxonomicelements_idnamepublishedin').val(idValor);
            $('#namepublishedin').val(valor);
            $('#namepublishedinvalue').val(valor);

            //			$("#divnomenclaturalcodeReset").css("display","block");
            //
            // 	 		if (valor!=''){
            // 	 			dasabilitaCampos("nomenclaturalcode");
            // 	 			$('#divnomenclaturalcodeValor').text(valor);
            // 	 		}else
            // 	 			habilitaCampos("nomenclaturalcode");

            camposReset.push("namepublishedin");
            camposPreenchidosTaxonomicElements.push(camposReset);
            break;

        case "taxonconcept":
            $('#taxonomicelements_idtaxonconcept').val(idValor);
            $('#taxonconcept').val(valor);
            $('#taxonconceptvalue').val(valor);

            //			$("#divnomenclaturalcodeReset").css("display","block");
            //
            // 	 		if (valor!=''){
            // 	 			dasabilitaCampos("nomenclaturalcode");
            // 	 			$('#divnomenclaturalcodeValor').text(valor);
            // 	 		}else
            // 	 			habilitaCampos("nomenclaturalcode");

            camposReset.push("taxonconcept");
            camposPreenchidosTaxonomicElements.push(camposReset);
            break;

		
    }
    // overlay.add(container).fadeOut('normal');
	
    //$('#overlay').add($('#container')).fadeOut('normal');
    $('#overlay').fadeOut('normal');	
    $('#lightbox').fadeOut('normal');
    
    
}

function limpaCamposTaxonomicElements(){

    var arrayAux = camposPreenchidosTaxonomicElements.pop();
	
    campo = "vazio"
    while (campo!=0){
        campo = arrayAux.pop();
        if (campo!=0){
            $("#"+campo).val("");
            $("#"+campo+"value").val("");
            $("#taxonomicelements_id"+campo).val("");
            habilitaCampos(campo);
            $("#"+campo+"Reset").css("display","none");
        }
    }
    if (camposPreenchidosTaxonomicElements!=0){
        campoPreenchidosAux = camposPreenchidosTaxonomicElements.slice();
        arrayAux2 = campoPreenchidosAux.pop().slice();
        campo = arrayAux2.pop();
    //$("#div"+campo+"Reset").css("display","block");
    }
	
}


function insertDataTaxonomicElements(fieldTarget, fieldIdTarget, urlTarget, extraParams){

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
				
                escondeBotaoResetTaxonomicElements();
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
                camposPreenchidosTaxonomicElements.push(camposReset);
                
                if((fieldTarget.attr("id")=="kingdom")
                	||(fieldTarget.attr("id")=="phylum")
                	||(fieldTarget.attr("id")=="class")
                	||(fieldTarget.attr("id")=="order")
                	||(fieldTarget.attr("id")=="family")
                	||(fieldTarget.attr("id")=="genus")
                	||(fieldTarget.attr("id")=="subgenus")
                	||(fieldTarget.attr("id")=="specificepithet")
                	||(fieldTarget.attr("id")=="infraspecificepithet")
                	||(fieldTarget.attr("id")=="scientificname")
                ){
                	habilitaLabelDesfazerTaxonomicElements();
                }


            } else {
                $('div[class^=target]').html(msg);
            }
        }
    });
}
