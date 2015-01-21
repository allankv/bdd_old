function limparCamposTaxonomicElements(){

    $('#taxonomicelements_idkingdom').val('');
    $('#kingdomvalue').val('');
    $('#kingdom').val('');
	
    $('#taxonomicelements_idphylum').val('');
    $('#phylumvalue').val('');
    $('#phylum').val('');
    
    $('#taxonomicelements_idclass').val('');
    $('#classvalue').val('');
    $('#class').val('');    
    
    $('#taxonomicelements_idorder').val('');
    $('#ordervalue').val('');
    $('#order').val('');
    
    $('#taxonomicelements_idfamily').val('');
    $('#familyvalue').val('');
    $('#family').val('');    
    
    $('#taxonomicelements_idgenus').val('');
    $('#genusvalue').val('');
    $('#genus').val('');
    
    $('#taxonomicelements_idsubgenus').val('');
    $('#subgenusvalue').val('');
    $('#subgenus').val('');    
    
    $('#taxonomicelements_idspecificepithet').val('');
    $('#specificepithetvalue').val('');
    $('#specificepithet').val('');
    
    $('#taxonomicelements_idinfraspecificepithet').val('');
    $('#infraspecificepithetvalue').val('');
    $('#infraspecificepithet').val('');
    
    $('#taxonomicelements_idscientificname').val('');
    $('#scientificnamevalue').val('');
    $('#scientificname').val('');       
    
    //    $('#taxonomicelements_idscientificnameauthorship').val('');
    //    $('#scientificnameauthorshipvalue').val('');
    //    $('#scientificnameauthorship').val('');
    //
    //    $('#taxonomicelements_idnomenclaturalcode').val('');
    //    $('#nomenclaturalcodevalue').val('');
    //    $('#nomenclaturalcode').val('');
    //
    //    $('#taxonomicelements_idtaxonconcept').val('');
    //    $('#taxonconceptvalue').val('');
    //    $('#taxonconcept').val('');
    //
    //    $('#taxonomicelements_nomenclaturalstatus').val('');
    //
    //    $('#taxonomicelements_idacceptednameusage').val('');
    //    $('#acceptednameusagevalue').val('');
    //    $('#acceptednameusage').val('');
    //
    //    $('#taxonomicelements_idparentnameusage').val('');
    //    $('#parentnameusagevalue').val('');
    //    $('#parentnameusage').val('');
    //
    //    $('#taxonomicelements_idoriginalnameusage').val('');
    //    $('#originalnameusagevalue').val('');
    //    $('#originalnameusage').val('');
    //
    //    $('#taxonomicelements_idnameaccordingto').val('');
    //    $('#nameaccordingtovalue').val('');
    //    $('#nameaccordingto').val('');
    //
    //    $('#taxonomicelements_idnamepublishedin').val('');
    //    $('#namepublishedinvalue').val('');
    //    $('#namepublishedin').val('');
    //
    //    $('#taxonomicelements_vernacularname').val('');
    //
    //    $('#taxonomicelements_idtaxonomicstatus').val('');
    //
    //    $('#taxonomicelements_verbatimtaxonrank').val('');
    //
    //    $('#taxonomicelements_taxonremarks').val('');
    
    desabilitaLinkDesfazerTaxonomicElements()
    
}

function habilitaLinkDesfazerTaxonomicElements(){	
	
    document.getElementById('divLimparTaxonomicElements').style.display='block';
	
}

function habilitaLabelDesfazerTaxonomicElements(){
	
	if($('#taxonomicelements_idscientificname').val()!=""){
		document.getElementById('labelLimparTaxonomicElements').style.display='inline';
	}
	
	habilitaLinkDesfazerTaxonomicElements();
	
}

function desabilitaLinkDesfazerTaxonomicElements(){
	
    document.getElementById('labelLimparTaxonomicElements').style.display='none';
    document.getElementById('divLimparTaxonomicElements').style.display='none';
	
}


function verificaCamposPreenchidosTaxonomicElements(){
	
    var camposPreenchidos = false;
	
    if(
        ($('#taxonomicelements_idkingdom').val()!="")
        ||($('#taxonomicelements_idphylum').val()!="")
        ||($('#taxonomicelements_idclass').val()!="")
        ||($('#taxonomicelements_idorder').val()!="")
        ||($('#taxonomicelements_idfamily').val()!="")
        ||($('#taxonomicelements_idgenus').val()!="")
        ||($('#taxonomicelements_idsubgenus').val()!="")
        ||($('#taxonomicelements_idspecificepithet').val()!="")
        ||($('#taxonomicelements_idinfraspecificepithet').val()!="")
        //		||($('#taxonomicelements_idscientificnameauthorship').val()!="")
        //		||($('#taxonomicelements_idnomenclaturalcode').val()!="")
        //		||($('#taxonomicelements_idtaxonconcept').val()!="")
        //		||($('#taxonomicelements_nomenclaturalstatus').val()!="")
        //		||($('#taxonomicelements_idacceptednameusage').val()!="")
        //		||($('#taxonomicelements_idparentnameusage').val()!="")
        //		||($('#taxonomicelements_idnameaccordingto').val()!="")
        //		||($('#taxonomicelements_idnamepublishedin').val()!="")
        //		||($('#taxonomicelements_vernacularname').val()!="")
        //		||($('#taxonomicelements_idtaxonomicstatus').val()!="")
        //		||($('#taxonomicelements_verbatimtaxonrank').val()!="")
        //		||($('#taxonomicelements_taxonremarks').val()!="")

		
        ){	
        	//habilitaLinkDesfazerTaxonomicElements();      		
        	habilitaLabelDesfazerTaxonomicElements();
        }
}

$(document).ready(function() {
    verificaCamposPreenchidosTaxonomicElements();
});