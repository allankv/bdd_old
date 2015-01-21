function openDialogListSpecimens(id_taxon,taxonType){


	$('#listSpecimens').load('index.php?r=dataquality/goToListSpecimens&id_taxon='+id_taxon+'&taxonType'+taxonType);
    $( "#listSpecimens" ).dialog({
        autoOpen: false,
        minHeight: 450,
        minWidth: 850,
        resizable: false,
        modal: true
    });
   
    $( "#listSpecimens" ).dialog( "open" );
	
	
}