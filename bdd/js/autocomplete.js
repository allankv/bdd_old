function message(id) {
    //Check if autocomplete div is not blocked.
    if ($('div.ac_results').css('display') != 'block') {
        (id == 0 ? alert($('#message0').val()) : alert($('#message1').val()));
    }
    return 0;
}

//Record level elements
$('#institutioncode').blur(function()
{
    if($('#recordlevelelements_idinstitutioncode').val() == '' && $(this).val() != ''){
        ////message(0);
        $('#institutioncode').val('');
    } else if(($(this).val() != $('#institutioncodevalue').val()) && $('#recordlevelelements_idinstitutioncode').val() != '' && $(this).val() != ''){
        ////message(1);
        $('#institutioncode').val($('#institutioncodevalue').val());
    } else if ($(this).val() == '' && $('#institutioncodevalue').val() != '' && $('#recordlevelelements_idinstitutioncode').val() != '') {
        $('#recordlevelelements_idinstitutioncode').val('');
        $('#institutioncodevalue').val('');
    }
});
$('#ownerinstitution').blur(function()
{
    if($('#recordlevelelements_idownerinstitution').val() == '' && $(this).val() != ''){
        ////message(0);
        $('#ownerinstitution').val('');
    } else if(($(this).val() != $('#ownerinstitutionvalue').val()) && $('#recordlevelelements_idownerinstitution').val() != '' && $(this).val() != ''){
        ////message(1);
        $('#ownerinstitution').val($('#ownerinstitutionvalue').val());
    } else if ($(this).val() == '' && $('#ownerinstitutionvalue').val() != '' && $('#recordlevelelements_idownerinstitution').val() != '') {
        $('#recordlevelelements_idownerinstitution').val('');
        $('#ownerinstitutionvalue').val('');
    }
});
$('#dataset').blur(function()
{
    if($('#recordlevelelements_iddataset').val() == '' && $(this).val() != ''){
        ////message(0);
        $('#dataset').val('');
    } else if(($(this).val() != $('#datasetvalue').val()) && $('#recordlevelelements_iddataset').val() != '' && $(this).val() != ''){
        ////message(1);
        $('#dataset').val($('#datasetvalue').val());
    } else if ($(this).val() == '' && $('#datasetvalue').val() != '' && $('#recordlevelelements_iddataset').val() != '') {
        $('#recordlevelelements_iddataset').val('');
        $('#datasetvalue').val('');
    }
});

$('#collectioncode').blur(function()
{
    if($('#recordlevelelements_idcollectioncode').val() == '' && $(this).val() != ''){
        ////message(0);
        $('#collectioncode').val('');
    } else if(($(this).val() != $('#collectioncodevalue').val()) && $('#recordlevelelements_idcollectioncode').val() != '' && $(this).val() != ''){
        ////message(1);
        $('#collectioncode').val($('#collectioncodevalue').val());
    } else if ($(this).val() == '' && $('#collectioncodevalue').val() != '' && $('#recordlevelelements_idcollectioncode').val() != '') {
        $('#recordlevelelements_idcollectioncode').val('');
        $('#collectioncodevalue').val('');
    }
});

$('#metadataprovider').blur(function()
{
    if($('#media_idmetadataprovider').val() == '' && $(this).val() != ''){
        ////message(0);
        $('#metadataprovider').val('');
    } else if(($(this).val() != $('#metadataprovidervalue').val()) && $('#media_idmetadataprovider').val() != '' && $(this).val() != ''){
        ////message(1);
        $('#metadataprovider').val($('#metadataprovidervalue').val());
    } else if ($(this).val() == '' && $('#metadataprovidervalue').val() != '' && $('#media_idmetadataprovider').val() != '') {
        $('#media_idmetadataprovider').val('');
        $('#metadataprovidervalue').val('');
    }
});
$('#metadataprovider').blur(function()
{
    if($('#media_idmetadataprovider').val() == '' && $(this).val() != ''){
        ////message(0);
        $('#metadataprovider').val('');
    } else if(($(this).val() != $('#metadataprovidervalue').val()) && $('#media_idmetadataprovider').val() != '' && $(this).val() != ''){
        ////message(1);
        $('#metadataprovider').val($('#metadataprovidervalue').val());
    } else if ($(this).val() == '' && $('#metadataprovidervalue').val() != '' && $('#media_idmetadataprovider').val() != '') {
        $('#media_idmetadataprovider').val('');
        $('#metadataprovidervalue').val('');
    }
});

$('#subcategorymedia').blur(function()
{
    if($('#media_idsubcategorymedia').val() == '' && $(this).val() != ''){
        ////message(0);
        $('#subcategorymedia').val('');
    } else if(($(this).val() != $('#subcategorymediavalue').val()) && $('#media_idsubcategorymedia').val() != '' && $(this).val() != ''){
        ////message(1);
        $('#subcategorymedia').val($('#subcategorymediavalue').val());
    } else if ($(this).val() == '' && $('#subcategorymediavalue').val() != '' && $('#media_idsubcategorymedia').val() != '') {
        $('#media_idsubcategorymedia').val('');
        $('#subcategorymediavalue').val('');
    }
});

$('#categorymedia').blur(function()
{
    if($('#media_idcategorymedia').val() == '' && $(this).val() != ''){
        ////message(0);
        $('#categorymedia').val('');
    } else if(($(this).val() != $('#categorymediavalue').val()) && $('#media_idcategorymedia').val() != '' && $(this).val() != ''){
        ////message(1);
        $('#categorymedia').val($('#categorymediavalue').val());
    } else if ($(this).val() == '' && $('#categorymediavalue').val() != '' && $('#media_idcategorymedia').val() != '') {
        $('#media_idcategorymedia').val('');
        $('#categorymediavalue').val('');
    }
});

$('#subcategoryreferences').blur(function()
{
	
    if($('#referenceselements_idsubcategoryreferences').val() == '' && $(this).val() != ''){
        ////message(0);
        $('#subcategoryreferences').val('');
    } else if(($(this).val() != $('#subcategoryreferencesvalue').val()) && $('#referenceselements_idsubcategoryreferences').val() != '' && $(this).val() != ''){
        ////message(1);
        $('#subcategoryreferences').val($('#subcategoryreferencesvalue').val());
    } else if ($(this).val() == '' && $('#subcategoryreferencesvalue').val() != '' && $('#referenceselements_idsubcategoryreferences').val() != '') {

    	
        $('#referenceselements_idsubcategoryreferences').val('');
        $('#subcategoryreferencesvalue').val('');
    }
});

$('#creators').blur(function()
{

    if($('#referenceselements_idcreators').val() == '' && $(this).val() != ''){
        ////message(0);
        $('#creators').val('');
    } else if(($(this).val() != $('#creatorsvalue').val()) && $('#referenceselements_idcreators').val() != '' && $(this).val() != ''){
        ////message(1);
        $('#creators').val($('#creatorsvalue').val());
    } else if ($(this).val() == '' && $('#creatorsvalue').val() != '' && $('#referenceselements_idcreators').val() != '') {


        $('#referenceselements_idcreators').val('');
        $('#creatorsvalue').val('');
    }
});

$('#categoryreferences').blur(function()
{
	
    if($('#referenceselements_idcategoryreferences').val() == '' && $(this).val() != ''){
        ////message(0);
        $('#categoryreferences').val('');
    } else if(($(this).val() != $('#categoryreferencesvalue').val()) && $('#referenceselements_idcategoryreferences').val() != '' && $(this).val() != ''){
        ////message(1);
        $('#categoryreferences').val($('#categoryreferencesvalue').val());
    } else if ($(this).val() == '' && $('#categoryreferencesvalue').val() != '' && $('#referenceselements_idcategoryreferences').val() != '') {
      

    	$('#referenceselements_idcategoryreferences').val('');
        $('#categoryreferencesvalue').val('');
    }
});

$('#provider').blur(function()
{
    if($('#media_idprovider').val() == '' && $(this).val() != ''){
        ////message(0);
        $('#provider').val('');
    } else if(($(this).val() != $('#providervalue').val()) && $('#media_idprovider').val() != '' && $(this).val() != ''){
        ////message(1);
        $('#provider').val($('#providervalue').val());
    } else if ($(this).val() == '' && $('#providervalue').val() != '' && $('#media_idprovider').val() != '') {
        $('#media_idprovider').val('');
        $('#providervalue').val('');
    }
});

$('#capturedevice').blur(function()
{
    if($('#media_idcapturedevice').val() == '' && $(this).val() != ''){
        ////message(0);
        $('#capturedevice').val('');
    } else if(($(this).val() != $('#capturedevicevalue').val()) && $('#media_idcapturedevice').val() != '' && $(this).val() != ''){
        ////message(1);
        $('#capturedevice').val($('#capturedevicevalue').val());
    } else if ($(this).val() == '' && $('#capturedevicevalue').val() != '' && $('#media_idcapturedevice').val() != '') {
        $('#media_idcapturedevice').val('');
        $('#capturedevicevalue').val('');
    }
});

//Taxonomic elements

$('#kingdom').blur(function()
{
    if($('#taxonomicelements_idkingdom').val() == '' && $(this).val() != ''){
       // //message(0);
        $('#kingdom').val('');
    } else if(($(this).val() != $('#kingdomvalue').val()) && $('#taxonomicelements_idkingdom').val() != '' && $(this).val() != ''){
        ////message(1);
        $('#kingdom').val($('#kingdomvalue').val());
    } else if ($(this).val() == '' && $('#kingdomvalue').val() != '' && $('#taxonomicelements_idkingdom').val() != '') {
        $('#taxonomicelements_idkingdom').val('');
        $('#kingdomvalue').val('');
    }
});

$('#phylum').blur(function()
{
    if($('#taxonomicelements_idphylum').val() == '' && $(this).val() != ''){
        ////message(0);
        $('#phylum').val('');
    } else if(($(this).val() != $('#phylumvalue').val()) && $('#taxonomicelements_idphylum').val() != '' && $(this).val() != ''){
        ////message(1);
        $('#phylum').val($('#phylumvalue').val());
    } else if ($(this).val() == '' && $('#phylumvalue').val() != '' && $('#taxonomicelements_idphylum').val() != '') {
        $('#taxonomicelements_idphylum').val('');
        $('#phylumvalue').val('');
    }
});

$('#class').blur(function()
{
    if($('#taxonomicelements_idclass').val() == '' && $(this).val() != ''){
        ////message(0);
        $('#class').val('');
    } else if(($(this).val() != $('#classvalue').val()) && $('#taxonomicelements_idclass').val() != '' && $(this).val() != ''){
        ////message(1);
        $('#class').val($('#classvalue').val());
    } else if ($(this).val() == '' && $('#classvalue').val() != '' && $('#taxonomicelements_idclass').val() != '') {
        $('#taxonomicelements_idclass').val('');
        $('#classvalue').val('');
    }
});

$('#order').blur(function()
{
    if($('#taxonomicelements_idorder').val() == '' && $(this).val() != ''){
        ////message(0);
        $('#order').val('');
    } else if(($(this).val() != $('#ordervalue').val()) && $('#taxonomicelements_idorder').val() != '' && $(this).val() != ''){
        ////message(1);
        $('#order').val($('#ordervalue').val());
    } else if ($(this).val() == '' && $('#ordervalue').val() != '' && $('#taxonomicelements_idorder').val() != '') {
        $('#taxonomicelements_idorder').val('');
        $('#ordervalue').val('');
    }
});

$('#family').blur(function()
{
    if($('#taxonomicelements_idfamily').val() == '' && $(this).val() != ''){
        ////message(0);
        $('#family').val('');
    } else if(($(this).val() != $('#familyvalue').val()) && $('#taxonomicelements_idfamily').val() != '' && $(this).val() != ''){
        ////message(1);
        $('#family').val($('#familyvalue').val());
    } else if ($(this).val() == '' && $('#familyvalue').val() != '' && $('#taxonomicelements_idfamily').val() != '') {
        $('#taxonomicelements_idfamily').val('');
        $('#familyvalue').val('');
    }
});

$('#genus').blur(function()
{
    if($('#taxonomicelements_idgenus').val() == '' && $(this).val() != ''){
        ////message(0);
        $('#genus').val('');
    } else if(($(this).val() != $('#genusvalue').val()) && $('#taxonomicelements_idgenus').val() != '' && $(this).val() != ''){
        ////message(1);
        $('#genus').val($('#genusvalue').val());
    } else if ($(this).val() == '' && $('#genusvalue').val() != '' && $('#taxonomicelements_idgenus').val() != '') {
        $('#taxonomicelements_idgenus').val('');
        $('#genusvalue').val('');
    }
});

$('#subgenus').blur(function()
{
    if($('#taxonomicelements_idsubgenus').val() == '' && $(this).val() != ''){
        ////message(0);
        $('#subgenus').val('');
    } else if(($(this).val() != $('#subgenusvalue').val()) && $('#taxonomicelements_idsubgenus').val() != '' && $(this).val() != ''){
        ////message(1);
        $('#subgenus').val($('#subgenusvalue').val());
    } else if ($(this).val() == '' && $('#subgenusvalue').val() != '' && $('#taxonomicelements_idsubgenus').val() != '') {
        $('#taxonomicelements_idsubgenus').val('');
        $('#subgenusvalue').val('');
    }
});

$('#specificepithet').blur(function()
{
    if($('#taxonomicelements_idspecificepithet').val() == '' && $(this).val() != ''){
        ////message(0);
        $('#specificepithet').val('');
    } else if(($(this).val() != $('#specificepithetvalue').val()) && $('#taxonomicelements_idspecificepithet').val() != '' && $(this).val() != ''){
        ////message(1);
        $('#specificepithet').val($('#specificepithetvalue').val());
    } else if ($(this).val() == '' && $('#specificepithetvalue').val() != '' && $('#taxonomicelements_idspecificepithet').val() != '') {
        $('#taxonomicelements_idspecificepithet').val('');
        $('#specificepithetvalue').val('');
    }
});

$('#infraspecificepithet').blur(function()
{
    if($('#taxonomicelements_idinfraspecificepithet').val() == '' && $(this).val() != ''){
        ////message(0);
        $('#specificepithet').val('');
    } else if(($(this).val() != $('#infraspecificepithetvalue').val()) && $('#taxonomicelements_idinfraspecificepithet').val() != '' && $(this).val() != ''){
        ////message(1);
        $('#infraspecificepithet').val($('#infraspecificepithetvalue').val());
    } else if ($(this).val() == '' && $('#infraspecificepithetvalue').val() != '' && $('#taxonomicelements_idinfraspecificepithet').val() != '') {
        $('#taxonomicelements_idinfraspecificepithet').val('');
        $('#infraspecificepithetvalue').val('');
    }
});

$('#scientificname').blur(function()
{
    if($('#taxonomicelements_idscientificname').val() == '' && $(this).val() != '') {
        ////message(0);
        $('#scientificname').val('');
    } else if(($(this).val() != $('#scientificnamevalue').val()) && $('#taxonomicelements_idscientificname').val() != '' && $(this).val() != ''){
        ////message(1);
        $('#scientificname').val($('#scientificnamevalue').val());
    } else if ($(this).val() == '' && $('#scientificnamevalue').val() != '' && $('#taxonomicelements_idscientificname').val() != '') {
        $('#taxonomicelements_idscientificname').val('');
        $('#recordlevelelements_idscientificname').val('');
        $('#scientificnamevalue').val('');
    }
});

$('#taxonconcept').blur(function()
{
    if($('#taxonomicelements_idtaxonconcept').val() == '' && $(this).val() != ''){
        //message(0);
        $('#taxonconcept').val('');
    } else if(($(this).val() != $('#taxonconceptvalue').val()) && $('#taxonomicelements_idtaxonconcept').val() != ''&& $(this).val() != ''){
        //message(1);
        $('#taxonconcept').val($('#taxonconceptvalue').val());
    } else if ($(this).val() == '' && $('#taxonconceptvalue').val() != '' && $('#taxonomicelements_idtaxonconcept').val() != '') {
        $('#taxonomicelements_idtaxonconcept').val('');
        $('#taxonconceptvalue').val('');
    }
});

$('#taxonrank').blur(function()
{
    if($('#taxonomicelements_idtaxonrank').val() == '' && $(this).val() != ''){
        //message(0);
        $('#taxonrank').val('');
    } else if(($(this).val() != $('#taxonrankvalue').val()) && $('#taxonomicelements_idtaxonrank').val() != ''&& $(this).val() != ''){
        //message(1);
        $('#taxonrank').val($('#taxonrankvalue').val());
    } else if ($(this).val() == '' && $('#taxonrankvalue').val() != '' && $('#taxonomicelements_idtaxonrank').val() != '') {
        $('#taxonomicelements_idtaxonrank').val('');
        $('#taxonrankvalue').val('');
    }
});

$('#acceptednameusage').blur(function()
{
    if($('#taxonomicelements_idacceptednameusage').val() == '' && $(this).val() != ''){
        //message(0);
        $('#acceptednameusage').val('');
    } else if(($(this).val() != $('#acceptednameusagevalue').val()) && $('#taxonomicelements_idacceptednameusage').val() != ''&& $(this).val() != ''){
        //message(1);
        $('#acceptednameusage').val($('#acceptednameusagevalue').val());
    } else if ($(this).val() == '' && $('#acceptednameusagevalue').val() != '' && $('#taxonomicelements_idacceptednameusage').val() != '') {
        $('#taxonomicelements_idacceptednameusage').val('');
        $('#acceptednameusagevalue').val('');
    }
});

$('#parentnameusage').blur(function()
{
    if($('#taxonomicelements_idparentnameusage').val() == '' && $(this).val() != ''){
        //message(0);
        $('#parentnameusage').val('');
    } else if(($(this).val() != $('#parentnameusagevalue').val()) && $('#taxonomicelements_idparentnameusage').val() != ''&& $(this).val() != ''){
        //message(1);
        $('#parentnameusage').val($('#parentnameusagevalue').val());
    } else if ($(this).val() == '' && $('#parentnameusagevalue').val() != '' && $('#taxonomicelements_idparentnameusage').val() != '') {
        $('#taxonomicelements_idparentnameusage').val('');
        $('#parentnameusagevalue').val('');
    }
});

$('#originalnameusage').blur(function()
{
    if($('#taxonomicelements_idoriginalnameusage').val() == '' && $(this).val() != ''){
        //message(0);
        $('#originalnameusage').val('');
    } else if(($(this).val() != $('#originalnameusagevalue').val()) && $('#taxonomicelements_idoriginalnameusage').val() != ''&& $(this).val() != ''){
        //message(1);
        $('#originalnameusage').val($('#originalnameusagevalue').val());
    } else if ($(this).val() == '' && $('#originalnameusagevalue').val() != '' && $('#taxonomicelements_idoriginalnameusage').val() != '') {
        $('#taxonomicelements_idoriginalnameusage').val('');
        $('#originalnameusagevalue').val('');
    }
});

$('#nameaccordingto').blur(function()
{
    if($('#taxonomicelements_idnameaccordingto').val() == '' && $(this).val() != ''){
        //message(0);
        $('#nameaccordingto').val('');
    } else if(($(this).val() != $('#nameaccordingtovalue').val()) && $('#taxonomicelements_idnameaccordingto').val() != ''&& $(this).val() != ''){
        //message(1);
        $('#nameaccordingto').val($('#nameaccordingtovalue').val());
    } else if ($(this).val() == '' && $('#nameaccordingtovalue').val() != '' && $('#taxonomicelements_idnameaccordingto').val() != '') {
        $('#taxonomicelements_idnameaccordingto').val('');
        $('#nameaccordingtovalue').val('');
    }
});

$('#namepublishedin').blur(function()
{
    if($('#taxonomicelements_idnamepublishedin').val() == '' && $(this).val() != ''){
        //message(0);
        $('#namepublishedin').val('');
    } else if(($(this).val() != $('#namepublishedinvalue').val()) && $('#taxonomicelements_idnamepublishedin').val() != ''&& $(this).val() != ''){
        //message(1);
        $('#namepublishedin').val($('#namepublishedinvalue').val());
    } else if ($(this).val() == '' && $('#namepublishedinvalue').val() != '' && $('#taxonomicelements_idnamepublishedin').val() != '') {
        $('#taxonomicelements_idnamepublishedin').val('');
        $('#namepublishedinvalue').val('');
    }
});

$('#scientificnameauthorship').blur(function()
{
    if($('#taxonomicelements_idscientificnameauthorship').val() == '' && $(this).val() != ''){
        //message(0);
        $('#scientificnameauthorship').val('');
    } else if(($(this).val() != $('#scientificnameauthorshipvalue').val()) && $('#taxonomicelements_idscientificnameauthorship').val() != '' && $(this).val() != ''){

        //message(1);
        $('#scientificnameauthorship').val($('#scientificnameauthorshipvalue').val());
    } else if ($(this).val() == '' && $('#authoryearofscientificnamevalue').val() != '' && $('#taxonomicelements_idauthoryearofscientificname').val() != '') {
        $('#taxonomicelements_idauthoryearofscientificname').val('');
        $('#authoryearofscientificnamevalue').val('');
    }
});

$('#nomenclaturalcode').blur(function()
{
    if($('#taxonomicelements_idnomenclaturalcode').val() == '' && $(this).val() != ''){
        //message(0);
        $('#nomenclaturalcode').val('');
    } else if(($(this).val() != $('#nomenclaturalcodevalue').val()) && $('#taxonomicelements_idnomenclaturalcode').val() != '' && $(this).val() != ''){
        //message(1);
        $('#nomenclaturalcode').val($('#nomenclaturalcodevalue').val());
    } else if ($(this).val() == '' && $('#nomenclaturalcodevalue').val() != '' && $('#taxonomicelements_idnomenclaturalcode').val() != '') {
        $('#taxonomicelements_idnomenclaturalcode').val('');
        $('#nomenclaturalcodevalue').val('');
    }
});

//Identification Elements

$('#identificationqualifier').blur(function()
{
    if($('#identificationelements_ididentificationqualifier').val() == '' && $(this).val() != ''){
        //message(0);
        $('#identificationqualifier').val('');
    } else if(($(this).val() != $('#nomenclaturalcodevalue').val()) && $('#identificationelements_ididentificationqualifier').val() != '' && $(this).val() != ''){
        //message(1);
        $('#identificationqualifier').val($('#identificationqualifiervalue').val());
    } else if ($(this).val() == '' && $('#identificationqualifiervalue').val() != '' && $('#identificationelements_ididentificationqualifier').val() != '') {
        $('#identificationelements_ididentificationqualifier').val('');
        $('#identificationqualifiervalue').val('');
    }
});

//Locality Elements

$('#locality').blur(function()
{
    if($('#localityelements_idlocality').val() == '' && $(this).val() != ''){
        //message(0);
        $('#locality').val('');
    } else if(($(this).val() != $('#localityvalue').val()) && $('#localityelements_idlocality').val() != '' && $(this).val() != ''){
        //message(1);
        $('#locality').val($('#localityvalue').val());
    } else if ($(this).val() == '' && $('#localityvalue').val() != '' && $('#localityelements_idlocality').val() != '') {
        $('#localityelements_idlocality').val('');
        $('#localityvalue').val('');
    }
});

$('#waterbody').blur(function()
{
    if($('#localityelements_idwaterbody').val() == '' && $(this).val() != ''){
        //message(0);
        $('#waterbody').val('');
    } else if(($(this).val() != $('#waterbodyvalue').val()) && $('#localityelements_idwaterbody').val() != '' && $(this).val() != ''){
        //message(1);
        $('#waterbody').val($('#waterbodyvalue').val());
    } else if ($(this).val() == '' && $('#waterbodyvalue').val() != '' && $('#localityelements_idwaterbody').val() != '') {
        $('#localityelements_idwaterbody').val('');
        $('#waterbodyvalue').val('');
    }
});

$('#islandgroup').blur(function()
{
    if($('#localityelements_idislandgroup').val() == '' && $(this).val() != ''){
        //message(0);
        $('#islandgroup').val('');
    } else if(($(this).val() != $('#islandgroupvalue').val()) && $('#localityelements_idislandgroup').val() != '' && $(this).val() != ''){
        //message(1);
        $('#islandgroup').val($('#islandgroupvalue').val());
    } else if ($(this).val() == '' && $('#islandgroupvalue').val() != '' && $('#localityelements_idislandgroup').val() != '') {
        $('#localityelements_idislandgroup').val('');
        $('#islandgroupvalue').val('');
    }
});

$('#island').blur(function()
{
    if($('#localityelements_idisland').val() == '' && $(this).val() != ''){
        //message(0);
        $('#island').val('');
    } else if(($(this).val() != $('#islandvalue').val()) && $('#localityelements_idisland').val() != '' && $(this).val() != ''){
        //message(1);
        $('#island').val($('#islandvalue').val());
    } else if ($(this).val() == '' && $('#islandvalue').val() != '' && $('#localityelements_idisland').val() != '') {
        $('#localityelements_idisland').val('');
        $('#islandvalue').val('');
    }
});
$('#municipality').blur(function()
{
    if($('#localityelements_idmunicipality').val() == '' && $(this).val() != ''){
        //message(0);
        $('#municipality').val('');
    } else if(($(this).val() != $('#municipalityvalue').val()) && $('#localityelements_idmunicipality').val() != '' && $(this).val() != ''){
        //message(1);
        $('#municipality').val($('#municipalityvalue').val());
    } else if ($(this).val() == '' && $('#municipalityvalue').val() != '' && $('#localityelements_idmunicipality').val() != '') {
        $('#localityelements_idmunicipality').val('');
        $('#municipalityvalue').val('');
    }
});
$('#county').blur(function()
{
    if($('#localityelements_idcounty').val() == '' && $(this).val() != ''){
        //message(0);
        $('#county').val('');
    } else if(($(this).val() != $('#countyvalue').val()) && $('#localityelements_idcounty').val() != '' && $(this).val() != ''){
        //message(1);
        $('#county').val($('#countyvalue').val());
    } else if ($(this).val() == '' && $('#countyvalue').val() != '' && $('#localityelements_idcounty').val() != '') {
        $('#localityelements_idcounty').val('');
        $('#countyvalue').val('');
    }
});

$('#stateprovince').blur(function()
{
    if($('#localityelements_idstateprovince').val() == '' && $(this).val() != ''){
        //message(0);
        $('#stateprovince').val('');
    } else if(($(this).val() != $('#stateprovincevalue').val()) && $('#localityelements_idstateprovince').val() != '' && $(this).val() != ''){
        //message(1);
        $('#stateprovince').val($('#stateprovincevalue').val());
    } else if ($(this).val() == '' && $('#stateprovincevalue').val() != '' && $('#localityelements_idstateprovince').val() != '') {
        $('#localityelements_idstateprovince').val('');
        $('#stateprovincevalue').val('');
    }
});


$('#continent').blur(function()
{
    if($('#localityelements_idcontinent').val() == '' && $(this).val() != ''){
        //message(0);
        $('#continent').val('');
    } else if(($(this).val() != $('#continentvalue').val()) && $('#localityelements_idcontinent').val() != '' && $(this).val() != ''){
        //message(1);
        $('#continent').val($('#continentvalue').val());
    } else if ($(this).val() == '' && $('#continentvalue').val() != '' && $('#localityelements_idcontinent').val() != '') {
        $('#localityelements_idcontinent').val('');
        $('#continentvalue').val('');
    }
});

$('#country').blur(function()
{
    if($('#localityelements_idcountry').val() == '' && $(this).val() != ''){
        //message(0);
        $('#country').val('');
    } else if(($(this).val() != $('#countryvalue').val()) && $('#localityelements_idcountry').val() != '' && $(this).val() != ''){
        //message(1);
        $('#country').val($('#countrytvalue').val());
    } else if ($(this).val() == '' && $('#countrytvalue').val() != '' && $('#localityelements_idcountry').val() != '') {
        $('#localityelements_idcountry').val('');
        $('#countrytvalue').val('');
    }
});

// Curatorial elements
$('#dispositioncur').blur(function()
{
    if($('#curatorialelements_iddispositioncur').val() == '' && $(this).val() != ''){
        //message(0);
        $('#dispositioncur').val('');
    } else if(($(this).val() != $('#dispositioncurvalue').val()) && $('#curatorialelements_iddispositioncur').val() != '' && $(this).val() != ''){
        //message(1);
        $('#dispositioncur').val($('#dispositioncurvalue').val());
    } else if ($(this).val() == '' && $('#dispositionvalue').val() != '' && $('#occurrenceelements_iddisposition').val() != '') {
        $('#curatorialelements_iddispositioncur').val('');
        $('#dispositioncurvalue').val('');
    }
});

// Occurrence elements
$('#disposition').blur(function()
{
    if($('#occurrenceelements_iddisposition').val() == '' && $(this).val() != ''){
        //message(0);
        $('#disposition').val('');
    } else if(($(this).val() != $('#dispositionvalue').val()) && $('#occurrenceelements_iddisposition').val() != '' && $(this).val() != ''){
        //message(1);
        $('#disposition').val($('#dispositionvalue').val());
    } else if ($(this).val() == '' && $('#dispositionvalue').val() != '' && $('#occurrenceelements_iddisposition').val() != '') {
        $('#occurrenceelements_iddisposition').val('');
        $('#dispositionvalue').val('');
    }
});

$('#behavior').blur(function()
{
    if($('#occurrenceelements_idbehavior').val() == '' && $(this).val() != ''){
        //message(0);
        $('#behavior').val('');
    } else if(($(this).val() != $('#behaviorvalue').val()) && $('#occurrenceelements_idbehavior').val() != '' && $(this).val() != ''){
        //message(1);
        $('#behavior').val($('#behaviorvalue').val());
    } else if ($(this).val() == '' && $('#behaviorvalue').val() != '' && $('#occurrenceelements_idbehavior').val() != '') {
        $('#occurrenceelements_idbehavior').val('');
        $('#behaviorvalue').val('');
    }
});
$('#establishmentmeans').blur(function()
{
    if($('#occurrenceelements_idestablishmentmeans').val() == '' && $(this).val() != ''){
        //message(0);
        $('#establishmentmeans').val('');
    } else if(($(this).val() != $('#establishmentmeansvalue').val()) && $('#occurrenceelements_idestablishmentmeans').val() != '' && $(this).val() != ''){
        //message(1);
        $('#establishmentmeans').val($('#establishmentmeansvalue').val());
    } else if ($(this).val() == '' && $('#establishmentmeansvalue').val() != '' && $('#occurrenceelements_idestablishmentmeans').val() != '') {
        $('#occurrenceelements_idestablishmentmeans').val('');
        $('#establishmentmeansvalue').val('');
    }
});
$('#reproductivecondition').blur(function()
{
    if($('#occurrenceelements_idreproductivecondition').val() == '' && $(this).val() != ''){
        //message(0);
        $('#reproductivecondition').val('');
    } else if(($(this).val() != $('#reproductiveconditionvalue').val()) && $('#occurrenceelements_idreproductivecondition').val() != '' && $(this).val() != ''){
        //message(1);
        $('#reproductivecondition').val($('#reproductiveconditionvalue').val());
    } else if ($(this).val() == '' && $('#reproductiveconditionvalue').val() != '' && $('#occurrenceelements_idreproductivecondition').val() != '') {
        $('#occurrenceelements_idreproductivecondition').val('');
        $('#reproductiveconditionvalue').val('');
    }
});
$('#lifestage').blur(function()
{
    if($('#occurrenceelements_idlifestage').val() == '' && $(this).val() != ''){
        //message(0);
        $('#lifestage').val('');
    } else if(($(this).val() != $('#lifestagevalue').val()) && $('#occurrenceelements_idlifestage').val() != '' && $(this).val() != ''){
        //message(1);
        $('#lifestage').val($('#lifestagevalue').val());
    } else if ($(this).val() == '' && $('#lifestagevalue').val() != '' && $('#occurrenceelements_idlifestage').val() != '') {
        $('#occurrenceelements_idlifestage').val('');
        $('#lifestagevalue').val('');
    }
});

//Event elements

$('#collectingmethod').blur(function()
{
    if($('#collectingeventelements_idcollectingmethod').val() == '' && $(this).val() != ''){
        //message(0);
        $('#collectingmethod').val('');
    } else if(($(this).val() != $('#collectingmethodvalue').val()) && $('#collectingeventelements_idcollectingmethod').val() != '' && $(this).val() != ''){
        //message(1);
        $('#collectingmethod').val($('#collectingmethodtvalue').val());
    } else if ($(this).val() == '' && $('#collectingmethodtvalue').val() != '' && $('#collectingeventelements_idcollectingmethod').val() != '') {
        $('#collectingeventelements_idcollectingmethod').val('');
        $('#collectingmethodtvalue').val('');
    }
});

$('#collector').blur(function()
{
    if($('#collectingeventelements_idcollector').val() == '' && $(this).val() != ''){
        //message(0);
        $('#collector').val('');
    } else if(($(this).val() != $('#collectorvalue').val()) && $('#collectingeventelements_idcollector').val() != '' && $(this).val() != ''){
        //message(1);
        $('#collector').val($('#collectortvalue').val());
    } else if ($(this).val() == '' && $('#collectortvalue').val() != '' && $('#collectingeventelements_idcollector').val() != '') {
        $('#collectingeventelements_idcollector').val('');
        $('#collectortvalue').val('');
    }
});

$('#habitat').blur(function()
{
    if($('#eventelements_idhabitat').val() == '' && $(this).val() != ''){        
        $('#habitat').val('');
    } else if(($(this).val() != $('#habitatvalue').val()) && $('#eventelements_idhabitat').val() != '' && $(this).val() != ''){
        //message(1);
        $('#habitat').val($('#habitatvalue').val());
    } else if ($(this).val() == '' && $('#habitatvalue').val() != '' && $('#eventelements_idhabitat').val() != '') {
        $('#eventelements_idhabitat').val('');
        $('#habitatvalue').val('');
    }
});

$('#samplingprotocol').blur(function()
{
    if($('#eventelements_idsamplingprotocol').val() == '' && $(this).val() != ''){
        //message(0);
        $('#samplingprotocol').val('');
    } else if(($(this).val() != $('#samplingprotocolvalue').val()) && $('#eventelements_idsamplingprotocol').val() != '' && $(this).val() != ''){
        //message(1);
        $('#samplingprotocol').val($('#samplingprotocolvalue').val());
    } else if ($(this).val() == '' && $('#samplingprotocolvalue').val() != '' && $('#eventelements_idsamplingprotocol').val() != '') {
        $('#eventelements_idsamplingprotocol').val('');
        $('#samplingprotocolvalue').val('');
    }
});

$('#habitatevent').blur(function()
		{
		    if($('#eventelements_idhabitatevent').val() == '' && $(this).val() != ''){
		        //message(0);
		        $('#habitatevent').val('');
		    } else if(($(this).val() != $('#habitateventvalue').val()) && $('#eventelements_idhabitatevent').val() != '' && $(this).val() != ''){
		        //message(1);
		        $('#habitatevent').val($('#habitateventvalue').val());
		    } else if ($(this).val() == '' && $('#habitateventvalue').val() != '' && $('#eventelements_idhabitatevent').val() != '') {
		        $('#eventelements_idhabitatevent').val('');
		        $('#habitateventvalue').val('');
		    }
		});

$('#georeferenceverificationstatus').blur(function()
{
    if($('#geospatialelements_idgeoreferenceverificationstatus').val() == '' && $(this).val() != ''){
        //message(0);
        $('#georeferenceverificationstatus').val('');
    } else if(($(this).val() != $('#georeferenceverificationstatusvalue').val()) && $('#geospatialelements_idgeoreferenceverificationstatus').val() != '' && $(this).val() != ''){
        //message(1);
        $('#georeferenceverificationstatus').val($('#georeferenceverificationstatusvalue').val());
    } else if ($(this).val() == '' && $('#georeferenceverificationstatusvalue').val() != '' && $('#geospatialelements_idgeoreferenceverificationstatus').val() != '') {
        $('#geospatialelements_idgeoreferenceverificationstatus').val('');
        $('#georeferenceverificationstatusvalue').val('');
    }
});