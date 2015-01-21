function limparCamposLocalityElements(){

	$('#localityelements_idcontinent').val('');
    $('#continentvalue').val('');
    $('#continent').val('');
	
    $('#localityelements_idwaterbody').val('');
    $('#waterbodyvalue').val('');
    $('#waterbody').val('');
    	
    $('#localityelements_idislandgroup').val('');
    $('#islandgroupvalue').val('');
    $('#islandgroup').val('');
	
    $('#localityelements_idisland').val('');
    $('#islandvalue').val('');
    $('#island').val('');
	
    $('#localityelements_idcountry').val('');
    $('#countryvalue').val('');
    $('#country').val('');    
	
    $('#localityelements_idstateprovince').val('');
    $('#stateprovincevalue').val('');
    $('#stateprovince').val('');    
	
    $('#localityelements_idcounty').val('');
    $('#countyvalue').val('');
    $('#county').val('');  
    
    $('#localityelements_idlocality').val('');
    $('#localityvalue').val('');
    $('#locality').val('');  
    
    $('#localityelements_idmunicipality').val('');
    $('#municipalityvalue').val('');
    $('#municipality').val('');    
    
    desabilitaLinkDesfazerLocalityElements()
    
}

function habilitaLinkDesfazerLocalityElements(){
	
	document.getElementById('divLimparLocalityElements').style.display='block';
	
}

function habilitaLabelDesfazerLocalityElements(){
	
	if($('#localityelements_idmunicipality').val()!=""){
		document.getElementById('labelLimparLocalityElementsMunicipality').style.display='inline';
	}
	
	if($('#localityelements_idlocality').val()!=""){
		document.getElementById('labelLimparLocalityElementsLocality').style.display='inline';
	}	
	
	habilitaLinkDesfazerLocalityElements();
	
}

function desabilitaLinkDesfazerLocalityElements(){

    document.getElementById('labelLimparLocalityElementsMunicipality').style.display='none';
    document.getElementById('labelLimparLocalityElementsLocality').style.display='none';
	document.getElementById('divLimparLocalityElements').style.display='none';
	
}


function verificaCamposPreenchidosLocalityElements(){
	
	var camposPreenchidos = false;
	
	if(
		($('#localityelements_idcontinent').val()!="")
		||($('#localityelements_idwaterbody').val()!="")
		||($('#localityelements_idislandgroup').val()!="")
		||($('#localityelements_idisland').val()!="")
		||($('#localityelements_idcountry').val()!="")
		||($('#localityelements_idstateprovince').val()!="")
//		||($('#localityelements_idcounty').val()!="")
//		||($('#localityelements_idgeoreferenceverificationstatus').val()!="")
		||($('#localityelements_idhabitat').val()!="")
		||($('#localityelements_locationaccordingto').val()!="")
		||($('#localityelements_coordinateprecision').val()!="")
		||($('#localityelements_locationremarks').val()!="")
		||($('#localityelements_minimumelevationinmeters').val()!="")
		||($('#localityelements_maximumelevationinmeters').val()!="")
		||($('#localityelements_minimumdepthinmeters').val()!="")
		||($('#localityelements_maximumdepthinmeters').val()!="")
		||($('#localityelements_minimumdistanceabovesurficeinmeters').val()!="")
		||($('#localityelements_maximumdistanceabovesurficeinmeters').val()!="")
		||($('#localityelements_verbatimdepth').val()!="")
		||($('#localityelements_verbatimelevation').val()!="")
		||($('#localityelements_verbatimlocality').val()!="")
		||($('#localityelements_verbatimsrs').val()!="")
		||($('#georeferencedby_georeferencedby').val()!="")
		||($('#georeferencesources_georeferencesources').val()!="")
		||($('#localityelements_footprintsrs').val()!="")
		
	  )
	{

		habilitaLabelDesfazerLocalityElements()
	
	}
}

$(document).ready(function() {
	verificaCamposPreenchidosLocalityElements();
	});