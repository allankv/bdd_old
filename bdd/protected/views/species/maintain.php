<?php include_once("protected/extensions/config.php"); ?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="js/validation/jquery.numeric.pack.js"></script>
<script type="text/javascript" src="js/jquery.jstepper.js"></script>
<script type="text/javascript" src="js/loadfields.js"></script>
<script type="text/javascript" src="js/autocomplete.js"></script>
<script type="text/javascript" src="js/List.js"></script>
<script type="text/javascript" src="js/Maintain.js"></script>
<link rel="stylesheet" href="http://www.emposha.com/demo/fcbkcomplete_2/style.css" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" src="js/jquery.fcbkcomplete.js"></script>

<script type="text/javascript">
    // Arrays para armazenar listas de NxN
    // Nome padrao: controllerList
    var creatorList = new Array();
    var contributorList = new Array();
    var relatedNameList = new Array();
    var synonymList = new Array();

    //Tooltip for NxN fields
    var helpTip = '<div style="font-weight:normal;"><b>ENTRY LIST</b><br />In this field, you can create a list of entries.</div>';

    $(document).ready(bootSpecies);
    function bootSpecies(){

        //Date formatter
        $("#SpeciesAR_datecreated").mask("9999/99/99");
        $("#SpeciesAR_datecreated").datepicker({ dateFormat: 'yy/mm/dd' });
        $("#SpeciesAR_datelastmodified").mask("9999/99/99");
        $("#SpeciesAR_datelastmodified").datepicker({ dateFormat: 'yy/mm/dd' });

        // id, field, controller, bottao, list Html, list Javascript, acao de relacionamento NN (padrao), hidden do id target
        // id, field, controller
        configAutocomplete('#SpeciesAR_idinstitutioncode','#InstitutionCodeAR_institutioncode', 'institutioncode');
        configAutocomplete('#TaxonomicElementAR_idscientificname','#ScientificNameAR_scientificname', 'scientificname');

        // id, field, controller, bottao, list Hthml, list Javascript, acao de relacionamento NN (padrao), hidden do id target
        //configAutocompleteNN('#PreparationAR_idpreparation','#PreparationAR_preparation', 'preparation', '#addPreparationBtn', '#preparationList',preparationList,'OccurrenceElement','#SpecimenAR_idoccurrenceelement');
        //configAutocompleteNN('#CreatorAR_idcreator','#CreatorAR_creator', 'creator', '#creatorList',creatorList,'Species','#SpeciesAR_idspecies');
        configAutocompleteNN('#SpeciesAR_idspecies', '#CreatorAR_creator', 'creator', 'Species')
        configAutocompleteNN('#SpeciesAR_idspecies', '#ContributorAR_contributor', 'contributor', 'Species')
        //configAutocompleteNN('#ContributorAR_idcontributor','#ContributorAR_contributor', 'contributor', '#contributorList',contributorList,'Species','#SpeciesAR_idspecies');
        configAutocompleteNN('#SpeciesAR_idspecies', '#RelatedNameAR_relatedname', 'relatedname', 'Species')
        //configAutocompleteNN('#RelatedNameAR_idrelatedname','#RelatedNameAR_relatedname', 'relatedname', '#relatedNameList',relatedNameList,'Species','#SpeciesAR_idspecies');
        configAutocompleteNN('#SpeciesAR_idspecies', '#SynonymAR_synonym', 'synonym', 'Species')
        //configAutocompleteNN('#SynonymAR_idsynonym','#SynonymAR_synonym', 'synonym', '#synonymList',synonymList,'Species','#SpeciesAR_idspecies');


        //Autocomplete icons
        var btnAutocomplete ="<div class='btnAutocomplete' style='width:20px;'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-comment'></span></li></ul></div>";

        $('#autocompleteInstitutionCode').append('<a href="javascript:suggest(\'#SpeciesAR_idinstitutioncode\',\'#InstitutionCodeAR_institutioncode\', \'institutioncode\');">'+btnAutocomplete+'</a>');
        $('#autocompleteScientificName').append('<a href="javascript:suggest(\'#TaxonomicElementAR_idscientificname\',\'#ScientificNameAR_scientificname\', \'scientificname\');">'+btnAutocomplete+'</a>');
       // $('#autocompleteCreator').append('<a href="javascript:suggest(\'#CreatorAR_idcreator\',\'#CreatorAR_creator\', \'creator\');">'+btnAutocomplete+'</a>');
       	$('#autocompleteCreator').append('<a href="javascript:suggestNN(\'#CreatorAR_creator\', \'creator\', \'Species\');">'+btnAutocomplete+'</a>');
        $('#autocompleteContributor').append('<a href="javascript:suggestNN(\'#ContributorAR_contributor\',\'contributor\', \'Species\');">'+btnAutocomplete+'</a>');
        $('#autocompleteRelatedName').append('<a href="javascript:suggestNN(\'#RelatedNameAR_relatedname\',\'relatedname\', \'Species\');">'+btnAutocomplete+'</a>');
        $('#autocompleteSynonym').append('<a href="javascript:suggestNN(\'#SynonymAR_synonym\',\'synonym\', \'Species\');">'+btnAutocomplete+'</a>');
        
        //Help tooltip for Autocomplete Icons
        var acContent = "Click to choose from a list of records";

        $('.acIcon').poshytip({
            className: 'tip-twitter',
            content: acContent,
            alignTo: 'target',
            alignX: 'right',
            alignY: 'center',
            offsetX: 10,
            offsetY: 0
        });


        //Configs
        configInitial();
        configAccordion();
        configNotify();
        configIcons();


    }
    // Configuracoes iniciais
    function configInitial() {
        $("#saveBtn").button();
        $("#btnAutoSuggestionHierarchy").button();


        // Evento onclick do botao save
        $("#saveBtn").click(function() {
            $('html, body').animate({scrollTop: 0}, 'slow');
            $('#saveBtn').button('option', 'label', 'Processing');
            $('#saveBtn').attr('checked', true);
            save();
        });
    }

    function destroyDialogs(){
        //Destroy all dialogs

        $('#listRelatedMedia').dialog('destroy');
        $('#listRelatedMedia').dialog().remove();
        $('#listRelatedMedia').remove();

        $('#listRelatedRef').dialog('destroy');
        $('#listRelatedRef').dialog().remove();
        $('#listRelatedRef').remove();

        $('#listRelatedPub').dialog('destroy');
        $('#listRelatedPub').dialog().remove();
        $('#listRelatedPub').remove();

        $('#listRelatedPaper').dialog('destroy');
        $('#listRelatedPaper').dialog().remove();
        $('#listRelatedPaper').remove();

        $('#listRelatedKey').dialog('destroy');
        $('#listRelatedKey').dialog().remove();
        $('#listRelatedKey').remove();



    }

    // Acao de salva
    function save(){
        $.ajax({ type:'POST',
            url:'index.php?r=species/save',
            data: $("#form").serialize(),
            dataType: "json",
            success:function(json) {                   
                if (json.success) {
                	if ($('#SpeciesAR_idspecies').val() == '') {
	            		$('#TaxonomicElementAR_idscientificname').val('');
	                	$('#ScientificNameAR_scientificname').val('');
	                }
                
                    saveNN(json.ar.idspecies);
                    saveRelatedNN(json.ar.idspecies, "Species", 'reference', refActionList);
                    saveRelatedNN(json.ar.idspecies, "Species", 'media', mediaActionList);
                    saveRelatedNN(json.ar.idspecies, "Species", 'paper', paperActionList);
                    saveRelatedNN(json.ar.idspecies, "Species", 'publicationreference', pubActionList);
                    saveRelatedNN(json.ar.idspecies, "Species", 'idkey', keyActionList);
                }

                showMessage(json.msg, json.success, false);
                $("#saveBtn").button("option", "label", "Save" );
                $('#saveBtn').attr("checked", false);
                $("#saveBtn").button("refresh");

                //Hide taxonomic tip
                $('#taxsuggest').poshytip('hide').poshytip('destroy').replaceWith('');
            }
        });
    }
        /*$.ajax({ type:'POST',
            url:'index.php?r=species/save',
            data: $("#form").serialize(),
            dataType: "json",
            success:function(json) {
                if(json.success){
                    if(creatorList.length>=1)
                        saveNN('creator','saveSpeciesNN',creatorList,json.ar.idspecies);
                    if(contributorList.length>=1)
                        saveNN('contributor','saveSpeciesNN',contributorList,json.ar.idspecies);
                    if(relatedNameList.length>=1)
                        saveNN('relatedname','saveSpeciesNN',relatedNameList,json.ar.idspecies);
                    if(synonymList.length>=1)
                        saveNN('synonym','saveSpeciesNN',synonymList,json.ar.idspecies);
                    if(mediaActionList.length >= 1)
                        saveNN('media', 'saveSpeciesNN', mediaActionList, json.ar.idspecies);
                    if(refActionList.length >= 1)
                        saveNN('reference', 'saveSpeciesNN', refActionList, json.ar.idspecies);
                    if(pubActionList.length >= 1)
                        saveNN('publicationreference', 'saveSpeciesNN', pubActionList, json.ar.idspecies);
                    if(paperActionList.length >= 1)
                        saveNN('paper', 'saveSpeciesNN', paperActionList, json.ar.idspecies);
                    if(keyActionList.length >= 1)
                        saveNN('idkey', 'saveSpeciesNN', keyActionList, json.ar.idspecies);

                }

                showMessage(json.msg, json.success, false);
                $("#saveBtn").button( "option", "label", "Save" );
                $('#saveBtn').attr('checked', false);
                $("#saveBtn").button("refresh");
                

                //Hide taxonomic tip
                $('#taxsuggest').poshytip('hide').poshytip('destroy');

            }
        });
    }*/
    function configAccordion() {
        // Cria accordions apartir das divs
        $( "#informationAccordion").accordion({collapsible: true,autoHeight: false,navigation: true});
        $( "#taxonomicElementsAccordion").accordion({collapsible: true,autoHeight: false,navigation: true});
        $( "#speciesMediaAccordion" ).accordion({collapsible: true,autoHeight: false,navigation: true});
        $( "#speciesReferenceAccordion" ).accordion({collapsible: true,autoHeight: false,navigation: true});
        $( "#speciesPublicationReferenceAccordion" ).accordion({collapsible: true,autoHeight: false,navigation: true});
        $( "#speciesPaperAccordion" ).accordion({collapsible: true,autoHeight: false,navigation: true});
        $( "#speciesIdentificationKeyAccordion" ).accordion({collapsible: true,autoHeight: false,navigation: true});

        // Fecha todas
        $( "#informationAccordion").accordion("activate" ,false);
        $( "#taxonomicElementsAccordion").accordion("activate" ,false);
        $( "#speciesMediaAccordion" ).accordion("activate" ,false);
        $( "#speciesReferenceAccordion" ).accordion("activate" ,false);
        $( "#speciesPublicationReferenceAccordion" ).accordion("activate" ,false);
        $( "#speciesPaperAccordion" ).accordion("activate" ,false);
        $( "#speciesIdentificationKeyAccordion" ).accordion("activate" ,false);
    }

    function showTaxonomicTip(kingdom, phylum, class_, order, family, genus, subgenus, specificepithet, infraspecificepithet)
    {
        $('#taxsuggest').poshytip('hide');
        $('#taxsuggest').poshytip('destroy');

        //Clear the entries if null
        if (kingdom == null)
        {kingdom = '';}
        if (phylum == null)
        {phylum = '';}
        if (class_ == null)
        {class_ = '';}
        if (order == null)
        {order = '';}
        if (family == null)
        {family = '';}
        if (genus == null)
        {genus = '';}
        if (subgenus == null)
        {subgenus = '';}
        if (specificepithet == null)
        {specificepithet = '';}
        if (infraspecificepithet == null)
        {infraspecificepithet = '';}

        var tip = '<div style="font-weight:normal;"><div class="tipKey">Kingdom</div><div class="tipValue">'+kingdom+'</div><div style="clear:both"></div><div class="tipKey">Phylum</div><div class="tipValue">'+phylum+'</div><div style="clear:both"></div><div class="tipKey">Class</div><div class="tipValue">'+class_+'</div><div style="clear:both"></div><div class="tipKey">Order</div><div class="tipValue">'+order+'</div><div style="clear:both"></div><div class="tipKey">Family</div><div class="tipValue">'+family+'</div><div style="clear:both"></div><div class="tipKey">Genus</div><div class="tipValue">'+genus+'</div><div style="clear:both"></div><div class="tipKey">Subgenus</div><div class="tipValue">'+subgenus+'</div><div style="clear:both"></div><div class="tipKey">Specific Epithet</div><div class="tipValue">'+specificepithet+'</div><div style="clear:both"></div><div class="tipKey">Infraspecific Epithet</div><div class="tipValue">'+infraspecificepithet+'</div><div style="clear:both"></div></div>';

        $('#taxsuggest').poshytip({
            className: 'tip-twitter',
            showTimeout: 500,
            alignTo: 'target',
            alignX: 'right',
            alignY: 'center',
            showOn: 'none',
            content: tip
        }).poshytip('show');

        setTimeout(function() {
            $('#taxsuggest').poshytip('hide');
            setTimeout(function(){
                $('#taxsuggest').poshytip('destroy');
            }, 1000);
        }, 5000);
    }
    function creatorSpeciesRemoveItemList(controller,id,target){
        var jsonItem = {"id":id,"action":"delete"};
        creatorList.push(jsonItem);
        $('#'+controller+target+'_'+id).remove();
    }
    function contributorSpeciesRemoveItemList(controller,id,target){
        var jsonItem = {"id":id,"action":"delete"};
        contributorList.push(jsonItem);
        $('#'+controller+target+'_'+id).remove();
    }
    function relatednameSpeciesRemoveItemList(controller,id,target){
        var jsonItem = {"id":id,"action":"delete"};
        relatedNameList.push(jsonItem);
        $('#'+controller+target+'_'+id).remove();
    }
    function synonymSpeciesRemoveItemList(controller,id,target){
        var jsonItem = {"id":id,"action":"delete"};
        synonymList.push(jsonItem);
        $('#'+controller+target+'_'+id).remove();
    }


</script>

<div id="Notification"></div>

<?php echo CHtml::beginForm('','post',array ('id'=>'form')); ?>
<?php echo CHtml::activeHiddenField($spc,'idspecies');?>
<?php echo CHtml::activeHiddenField($spc,'idtaxonomicelement');?>

<!-- TEXTO INTRODUTORIO ----------------------------------------------->

<div class="introText">
    <h1><?php echo $spc->idspecies != null?Yii::t('yii','Update an existing species sheet'):Yii::t('yii','Create a new species sheet'); ?></h1>
    <p><?php echo Yii::t('yii',"Use this tool to save a sheet of modern biological species' information. This set of fields is based on international standards, such as Plinian Core."); ?></p>
</div>

<div class="yiiForm" style="width:85%">
        <div class="attention">
        <?php echo CHtml::image('images/main/attention.png','',array('border'=>'0px'))."&nbsp;".Yii::t('yii', "Main Fields");?>
        (<span style="color: red; font-weight: bold;"><?php echo Yii::t('yii',"Fields with * are required"); ?></span>)
    </div>
    <table cellspacing="0" cellpadding="0" align="center" class="tablerequired" style="margin-bottom:12px;">
        <div class="tablerow" id='divinstitutioncode'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabelEx($spc->institutioncode,'institutioncode');?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=institutioncode',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                        <?php echo CHtml::activeHiddenField($spc,'idinstitutioncode');?>
                        <?php echo CHtml::activeTextField($spc->institutioncode, 'institutioncode',array('class'=>'textboxtext'));?>
                    </div>
                </td>
                <td class="acIcon" id="autocompleteInstitutionCode">
                </td>
            </tr>
        </div>
        <div class="tablerow" id='divscientificname'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel($spc->taxonomicelement->scientificname,'scientificname');?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=scientificname',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                        <?php echo CHtml::activeHiddenField($spc->taxonomicelement,'idscientificname');?>
                        <?php echo CHtml::activeTextField($spc->taxonomicelement->scientificname, 'scientificname',array('class'=>'textboxtext'));?>
                    </div>
                </td>
                <td class="acIcon" id="autocompleteScientificName">
                </td>
                <td>
                    <div class="field autocomplete" id="taxsuggest">
                        <input type="button" value="Auto Suggestion Hierarchy" id="btnAutoSuggestionHierarchy">
                    </div>
                </td>
            </tr>
        </div>
    </table>

    <!-- ACCORDIONS  -->
    <div id="informationAccordion">
        <h3><a href="#">Species Information</a></h3>
        <div>
            <table cellspacing="0" cellpadding="0" align="center" class="normalFieldsTable">
                <div class="tablerow" id='divlanguage'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel(LanguageAR::model(), 'language'); ?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=language',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeDropDownList($spc,'idlanguage', CHtml::listData(LanguageAR::model()->findAll(), 'idlanguage', 'language'), array('empty'=>'-')); ?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divcreator'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel(CreatorAR::model(),'creator');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=creator',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeHiddenField(CreatorAR::model(),'idcreator');?>
                            <?php echo CHtml::activeTextField(CreatorAR::model(), 'creator', array('class'=>'textboxtext'));?>
                        </td>
                        <td class= "acIcon" id="autocompleteCreator">
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divcontributor'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel(ContributorAR::model(),'contributor');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=contributor',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeHiddenField(ContributorAR::model(),'idcontributor');?>
                            <?php echo CHtml::activeTextField(ContributorAR::model(), 'contributor', array('class'=>'textboxtext'));?>
                        </td>
                        <td class="acIcon" id="autocompleteContributor">
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divrelatedname'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel(RelatedNameAR::model(),'relatedname');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=relatedname',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeHiddenField(RelatedNameAR::model(),'idrelatedname');?>
                            <?php echo CHtml::activeTextField(RelatedNameAR::model(), 'relatedname', array('class'=>'textboxtext'));?>
                        </td>
                        <td class="acIcon" id="autocompleteRelatedName">
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divsynonym'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel(SynonymAR::model(),'synonym');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=synonym',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeHiddenField(SynonymAR::model(),'idsynonym');?>
                            <?php echo CHtml::activeTextField(SynonymAR::model(), 'synonym', array('class'=>'textboxtext'));?>
                        </td>
                        <td class="acIcon" id="autocompleteSynonym"> 
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divabstract'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'abstract');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=abstract',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'abstract',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divannualcycle'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'annualcycle');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=annual',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'annualcycle',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divauthoryearofscientificname'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'authoryearsofscientificname');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=authoryearofscientificname',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextField($spc, 'authoryearofscientificname',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divbehavior'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'behavior');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=behavior',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'behavior',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divbenefits'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'benefits');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=benefits',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'benefits',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divbriefdescription'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'briefdescription');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=briefdescription',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'briefdescription',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divchromosomicnumber'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'chromosomicnumber');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=chromosomicnumber',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'chromosomicnumber',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divcomprehensivedescription'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'comprehensivedescription');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=comprehensivedescription',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'comprehensivedescription',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divconservationstatus'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'conservationstatus');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=conservationstatus',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'conservationstatus',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divdatecreated'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'datecreated');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=datecreated',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextField($spc, 'datecreated',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divdatelastmodified'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'datelastmodified');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=datelastmodified',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextField($spc, 'datelastmodified',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divdistribution'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'distribution');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=distribution',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'distribution',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divecologicalsignificance'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'ecologicalsignificance');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=ecologicalsignificance',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'ecologicalsignificance',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divendemicity'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'endemicity');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=endemicity',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'endemicity',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divfeeding'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'feeding');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=feeding',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'feeding',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divfolklore'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'folklore');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=folklore',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'folklore',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divlsid'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'lsid');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=lsid',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'lsid',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divhabit'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'habit');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=habit',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'habit',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divhabitat'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'habitat');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=habitat',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'habitat',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divinteractions'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'interactions');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=interactions',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'interactions',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divinvasivenessdata'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'invasivenessdata');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=invasivenessdata',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'invasivenessdata',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divlegislation'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'legislation');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=legislation',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'legislation',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divlifecycle'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'lifecycle');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=lifecycle',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'lifecycle',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divlifeexpectancy'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'lifeexpectancy');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=lifeexpectancy',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'lifeexpectancy',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divmanagement'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'management');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=management',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'management',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divmigratorydata'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'migratorydata');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=migratorydata',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'migratorydata',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divmoleculardata'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'moleculardata');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=moleculardata',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'moleculardata',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divmorphology'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'morphology');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=morphology',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'morphology',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divoccurrence'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'occurrence');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=occurrence',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'occurrence',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divotherinformationsources'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'otherinformationsources');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=otherinformationsources',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'otherinformationsources',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divpopulationbiology'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'populationbiology');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=populationbiology',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'populationbiology',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divreproduction'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'reproduction');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=reproduction',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'reproduction',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divscientificdescription'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'scientificdescription');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=scientificdescription',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'scientificdescription',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divsize'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'size');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=size',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextField($spc, 'size',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divtargetaudiences'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'targetaudiences');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=targetaudiences',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'targetaudiences',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divterritory'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'territory');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=territory',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'territory',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divthreatstatus'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'threatstatus');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=threatstatus',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'threatstatus',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divtypification'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'typification');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=typification',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'typification',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divunstructureddocumentation'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'unstructureddocumentation');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=unstructureddocumentation',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'unstructureddocumentation',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divunstructurednaturalhistory'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'unstructurednaturalhistory');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=unstructurednaturalhistory',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'unstructurednaturalhistory',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divuses'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'uses');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=uses',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'uses',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
                <div class="tablerow" id='divversion'>
                    <tr>
                        <td class="tablelabelcel">
                            <?php echo CHtml::activeLabel($spc,'version');?>
                        </td>
                        <td class="tablemiddlecel">
                            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=version',array('rel'=>'lightbox'));?>
                        </td>
                        <td class="tablefieldcel">
                            <?php echo CHtml::activeTextArea($spc, 'version',array('class'=>'textboxtext'));?>
                        </td>
                    </tr>
                </div>
            </table>
        </div>
    </div>
    <div id="taxonomicElementsAccordion">
        <h3><a href="#">Taxonomic Elements</a></h3>
        <div>
            <?php
            echo Yii::app()->controller->renderPartial('/speciestaxonomic/maintain', array(
            'taxonomicElement'=>$spc->taxonomicelement,
            ));
            ?>
        </div>
    </div>
    <div id="speciesMediaAccordion">
        <h3><a href="#">Related Media Records</a></h3>
        <div>
            <?php
            echo Yii::app()->controller->renderPartial('/speciesmedia/maintain', array(
            'speciesMedia'=>$spc,
            ));
            ?>
        </div>
    </div>
    <div id="speciesReferenceAccordion">
        <h3><a href="#">Related Reference Records</a></h3>
        <div>
            <?php
            echo Yii::app()->controller->renderPartial('/speciesreference/maintain', array(
            'speciesRef'=>$spc,
            ));
            ?>
        </div>
    </div>
    <div id="speciesPaperAccordion">
        <h3><a href="#">Related Papers</a></h3>
        <div>
            <?php
            echo Yii::app()->controller->renderPartial('/speciespaper/maintain', array(
            'speciesPaper'=>$spc,
            ));
            ?>
        </div>
    </div>
    <div id="speciesPublicationReferenceAccordion">
        <h3><a href="#">Related Publication References</a></h3>
        <div>
            <?php
            echo Yii::app()->controller->renderPartial('/speciespublicationreference/maintain', array(
            'speciesPub'=>$spc,
            ));
            ?>
        </div>
    </div>
    <div id="speciesIdentificationKeyAccordion">
        <h3><a href="#">Related Identification Keys</a></h3>
        <div>
            <?php
            echo Yii::app()->controller->renderPartial('/speciesidkey/maintain', array(
            'speciesKey'=>$spc,
            ));
            ?>
        </div>
    </div>
    <div class="saveButton">
        <input type="checkbox" id="saveBtn" /><label for="saveBtn">Save</label>
    </div>
</div>

<?php echo CHtml::endForm(); ?>
