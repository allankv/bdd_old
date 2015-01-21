<script type="text/javascript">
    var georeferencedByList = new Array();
    var georeferenceSourceLocalityList = new Array();

    //Force numeric input
    jQuery(function($){
    $("#LocalityElementAR_coordinateprecision").jStepper({disableNonNumeric:true, decimalSeparator:"."});
    $("#LocalityElementAR_minimumelevationinmeters").jStepper({disableNonNumeric:true, decimalSeparator:"."});
    $("#LocalityElementAR_maximumelevationinmeters").jStepper({disableNonNumeric:true, decimalSeparator:"."});
    $("#LocalityElementAR_minimumdepthinmeters").jStepper({disableNonNumeric:true, decimalSeparator:"."});
    $("#LocalityElementAR_maximumdepthinmeters").jStepper({disableNonNumeric:true, decimalSeparator:"."});
    $("#LocalityElementAR_minimumdistanceabovesurfaceinmeters").jStepper({disableNonNumeric:true, decimalSeparator:"."});
    $("#LocalityElementAR_maximumdistanceabovesurfaceinmeters").jStepper({disableNonNumeric:true, decimalSeparator:"."});
    });


    $(document).ready(bootLocality);
    function bootLocality(){
    	configAutocomplete('#LocalityElementAR_idcountry','#CountryAR_country', 'country');
        configAutocomplete('#LocalityElementAR_idstateprovince','#StateProvinceAR_stateprovince', 'stateprovince');
        configAutocomplete('#LocalityElementAR_idcounty','#CountyAR_county', 'county');
        configAutocomplete('#LocalityElementAR_idmunicipality','#MunicipalityAR_municipality', 'municipality');
        configAutocomplete('#LocalityElementAR_idlocality','#LocalityAR_locality', 'locality');
        configAutocompleteNN('#LocalityElementAR_idlocalityelement', '#GeoreferencedByAR_georeferencedby', 'georeferencedby', 'LocalityElement')
        //configAutocompleteNN('#GeoreferencedByAR_idgeoreferencedby','#GeoreferencedByAR_georeferencedby', 'georeferencedby', '#georeferencedByList',georeferencedByList,'LocalityElement','#SpecimenAR_idlocalityelement');
        configAutocompleteNN('#LocalityElementAR_idlocalityelement', '#GeoreferenceSourceLocalityAR_georeferencesource', 'georeferencesource', 'LocalityElement')
        //configAutocompleteNN('#GeoreferenceSourceLocalityAR_idgeoreferencesource','#GeoreferenceSourceLocalityAR_georeferencesource', 'georeferencesource', '#georeferenceSourceLocalityList',georeferenceSourceLocalityList,'LocalityElement','#SpecimenAR_idlocalityelement');
        configAutocomplete('#LocalityElementAR_idcontinent','#ContinentAR_continent', 'continent');
        configAutocomplete('#LocalityElementAR_idwaterbody','#WaterBodyAR_waterbody', 'waterbody');
        configAutocomplete('#LocalityElementAR_idislandgroup','#IslandGroupAR_islandgroup', 'islandgroup');
        configAutocomplete('#LocalityElementAR_idisland','#IslandAR_island', 'island');
        configAutocomplete('#LocalityElementAR_idhabitat','#HabitatLocalityAR_habitat', 'habitat');

        //Autocomplete icons
        //Example <td class="acIcon" id="autocomplete"></div>
        var btnAutocomplete ="<div class='btnAutocomplete' style='width:20px;'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-comment'></span></li></ul></div>";
		
		$('#autocompleteCountry').append('<a href="javascript:suggest(\'#LocalityElementAR_idcountry\',\'#CountryAR_country\', \'country\');">'+btnAutocomplete+'</a>');
        $('#autocompleteState').append('<a href="javascript:suggest(\'#LocalityElementAR_idstateprovince\',\'#StateProvinceAR_stateprovince\', \'stateprovince\');">'+btnAutocomplete+'</a>');
        $('#autocompleteCounty').append('<a href="javascript:suggest(\'#LocalityElementAR_idcounty\',\'#CountyAR_county\', \'county\');">'+btnAutocomplete+'</a>');
        $('#autocompleteMunicipality').append('<a href="javascript:suggest(\'#LocalityElementAR_idmunicipality\',\'#MunicipalityAR_municipality\', \'municipality\');">'+btnAutocomplete+'</a>');
        $('#autocompleteLocality').append('<a href="javascript:suggest(\'#LocalityElementAR_idlocality\',\'#LocalityAR_locality\', \'locality\');">'+btnAutocomplete+'</a>');
        $('#autocompleteGeoreferencedBy').html('<a href="javascript:suggest(\'#GeoreferencedByAR_idgeoreferencedby\',\'#GeoreferencedByAR_georeferencedby\', \'georeferencedby\');">'+btnAutocomplete+'</a>');
        $('#autocompleteGeoreferenceSource').html('<a href="javascript:suggest(\'#GeoreferenceSourceLocalityAR_idgeoreferencesource\',\'#GeoreferenceSourceLocalityAR_georeferencesource\', \'georeferencesource\');">'+btnAutocomplete+'</a>');
        $('#autocompleteWaterBody').html('<a href="javascript:suggest(\'#LocalityElementAR_idwaterbody\',\'#WaterBodyAR_waterbody\', \'waterbody\');">'+btnAutocomplete+'</a>');
        $('#autocompleteIslandGroup').html('<a href="javascript:suggest(\'#LocalityElementAR_idislandgroup\',\'#IslandGroupAR_islandgroup\', \'islandgroup\');">'+btnAutocomplete+'</a>');
        $('#autocompleteIsland').html('<a href="javascript:suggest(\'#LocalityElementAR_idisland\',\'#IslandAR_island\', \'island\');">'+btnAutocomplete+'</a>');
        $('#autocompleteHabitatLocality').html('<a href="javascript:suggest(\'#LocalityElementAR_idhabitat\',\'#HabitatLocalityAR_habitat\', \'habitat\');">'+btnAutocomplete+'</a>');

        //Config hover effect for icons
        configIcons();

        //Help tooltip for NxN fields
        //var helpTip = '<div style="font-weight:normal;">In this field, you can create a list of entries.</div>';

        $('#GeoreferencedByAR_georeferencedby').poshytip({
            className: 'tip-twitter',
            content: helpTip,
            showOn: 'focus',
            alignTo: 'target',
            alignX: 'inner-left',
            alignY: 'top',
            offsetX: 0,
            offsetY: 5
        });

        $('#GeoreferenceSourceLocalityAR_georeferencesource').poshytip({
            className: 'tip-twitter',
            content: helpTip,
            showOn: 'focus',
            alignTo: 'target',
            alignX: 'inner-left',
            alignY: 'top',
            offsetX: 0,
            offsetY: 5
        });
    }
    function georeferencesourceLocalityElementRemoveItemList(controller,id,target){
        //alert(controller +" "+id);
        var jsonItem = {"id":id,"action":"delete"};
        georeferenceSourceLocalityList.push(jsonItem);
        $('#'+controller+target+'_'+id).remove();
    }
    function georeferencedbyLocalityElementRemoveItemList(controller,id,target){
        //alert(controller +" "+id);
        var jsonItem = {"id":id,"action":"delete"};
        georeferencedByList.push(jsonItem);
        $('#'+controller+target+'_'+id).remove();
    }
</script>

<?php echo CHtml::activeHiddenField($localityElement,'idlocalityelement');?>

<table cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
	<tr id="divlocation">
        <td class="tablelabelcel">
            <?php echo 'Location'?>
        </td>
        <td class="tablemiddlecel">
        </td>
        <td class="tablefieldcel">
            <?php echo CHtml::textField('location', '', array('id'=>'location'));?>
        </td>
        <td></td>
    </tr>      
    <tr id="divcountry">
        <td class="tablelabelcel">
            <?php echo CHtml::activeLabel(CountryAR::model(),'country');?>
        </td>
        <td class="tablemiddlecel">
        </td>
        <td class="tablefieldcel">
            <?php echo CHtml::activeHiddenField($localityElement,'idcountry');?>
            <?php echo CHtml::activeTextField($localityElement->country,'country');?>
        </td>
        <td class="acIcon" id="autocompleteCountry">
        </td>
    </tr>
    <tr id="divstateprovince">
        <td class="tablelabelcel">
            <?php echo CHtml::activeLabel(StateProvinceAR::model(),'stateprovince');?>
        </td>
        <td class="tablemiddlecel">
            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=stateprovince',array('rel'=>'lightbox'));?>
        </td>
        <td class="tablefieldcel">
            <?php echo CHtml::activeHiddenField($localityElement,'idstateprovince');?>
            <?php echo CHtml::activeTextField($localityElement->stateprovince,'stateprovince');?>
        </td>
        <td class="acIcon" id="autocompleteState">
        </td>
    </tr>
    <tr id="divcounty">
        <td class="tablelabelcel">
            <?php echo CHtml::activeLabel(CountyAR::model(),'county');?>
        </td>
        <td class="tablemiddlecel">
            <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=county',array('rel'=>'lightbox'));?>
        </td>
        <td class="tablefieldcel">
            <?php echo CHtml::activeHiddenField($localityElement,'idcounty');?>
            <?php echo CHtml::activeTextField($localityElement->county,'county');?>
        </td>
        <td class="acIcon" id="autocompleteCounty">
        </td>
    </tr>
    <tr id="divmunicipality">
        <td class="tablelabelcel">
            <?php echo CHtml::activeLabel(MunicipalityAR::model(),'municipality');?>
        </td>
        <td class="tablemiddlecel">
        </td>
        <td class="tablefieldcel">
            <?php echo CHtml::activeHiddenField($localityElement,'idmunicipality');?>
            <?php echo CHtml::activeTextField($localityElement->municipality,'municipality');?>
        </td>
        <td class="acIcon" id="autocompleteMunicipality">
        </td>
    </tr>
    <div class="tablerow" id='divlocality'>
        <tr>
        <td class="tablelabelcel">
            <?php echo CHtml::activeLabel(LocalityAR::model(),'locality');?>
        </td>
        <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=locality',array('rel'=>'lightbox'));?>
        </td>
        <td class="tablefieldcel">
            <?php echo CHtml::activeHiddenField($localityElement,'idlocality');?>
            <?php echo CHtml::activeTextField($localityElement->locality, 'locality',array('class'=>'textboxtext'));?>
        </td>
        <td class="acIcon" id="autocompleteLocality">
        </td>
    </tr>
    </div>
</table>

<table cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
    <div class="tablerow" id='divcontinent'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel(ContinentAR::model(), "continent"); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=continent',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeDropDownList($localityElement, 'idcontinent', CHtml::listData(ContinentAR::model()->findAll(" 1=1 ORDER BY continent "), 'idcontinent', 'continent'), array('empty'=>'-'));?>
            </td>
            <td></td>
        </tr>
    </div>
    <div class="tablerow" id='divwaterbody'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($localityElement->waterbody, 'waterbody');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=waterbody',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($localityElement,'idwaterbody');?>
                    <?php echo CHtml::activeTextField($localityElement->waterbody, 'waterbody', array('class'=>'textfield'));?>
                </div>
            </td>
            <td class="acIcon" id="autocompleteWaterBody">
        </tr>
    </div>
    <div class="tablerow" id='divislandgroup'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($localityElement->islandgroup, 'islandgroup');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=islandgroup',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($localityElement,'idislandgroup');?>
                    <?php echo CHtml::activeTextField($localityElement->islandgroup, 'islandgroup', array('class'=>'textfield'));?>
                </div>
            </td>
            <td class="acIcon" id="autocompleteIslandGroup">
        </tr>
    </div>
    <div class="tablerow" id='divisland'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($localityElement->island, 'island');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=island',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($localityElement,'idisland');?>
                    <?php echo CHtml::activeTextField($localityElement->island, 'island', array('class'=>'textfield'));?>
                </div>
            </td>
            <td class="acIcon" id="autocompleteIsland">
        </tr>
    </div>
    <!--
    <div class="tablerow" id='divcountry'>
        <tr>
            <td class="tablelabelcel">
                <?php //echo CHtml::activeLabel($localityElement->country, 'country');?>
            </td>
            <td class="tablemiddlecel">
                <?php //echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=country',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php //echo CHtml::activeHiddenField($localityElement,'idcountry');?>
                    <?php //echo CHtml::activeTextField($localityElement->country, 'country', array('class'=>'textfield'));*/?>
                </div>
            </td>
        </tr>
    </div>
    -->
</table>

<table cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
    <div class="tablerow" id='divhabitat'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($localityElement->habitat, 'habitat');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=habitat',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($localityElement,'idhabitat');?>
                    <?php echo CHtml::activeTextField($localityElement->habitat, 'habitat', array('class'=>'textfield'));?>
                </div>
            </td>
            <td class="acIcon" id="autocompleteHabitatLocality"></div>
        </tr>
    </div>
    <div class="tablerow" id='divlocationaccordingto'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($localityElement, 'locationaccordingto');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=locationaccordingto',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($localityElement,'locationaccordingto',array('class'=>'textfield')); ?>
            </td>
            <td></td>
        </tr>
    </div>
    <div class="tablerow" id='divcoordinateprecision'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($localityElement, 'coordinateprecision');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=coordinateprecision',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($localityElement,'coordinateprecision',array('class'=>'textfield')); ?>
            </td>
            <td></td>
        </tr>
    </div>
    <div class="tablerow" id='divlocationremark'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($localityElement, 'locationremark');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=locationremark',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextArea($localityElement,'locationremark',array('class'=>'textarea')); ?>
            </td>
            <td></td>
        </tr>
    </div>
</table>

<table cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
    <div class="tablerow" id='divminimumelevationinmeters'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($localityElement, 'minimumelevationinmeters');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=minimumelevationinmeters',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($localityElement,'minimumelevationinmeters',array('class'=>'textfield')); ?>
            </td>
            <td></td>
        </tr>
    </div>
    <div class="tablerow" id='divmaximumelevationinmeters'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($localityElement, 'maximumelevationinmeters');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=maximumelevationinmeters',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($localityElement,'maximumelevationinmeters',array('class'=>'textfield')); ?>
            </td>
            <td></td>
        </tr>
    </div>
</table>

<table cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
    <div class="tablerow" id='divminimumdepthinmeters'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($localityElement, 'minimumdepthinmeters');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=minimumdepthinmeters',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($localityElement,'minimumdepthinmeters',array('class'=>'textfield')); ?>
            </td>
            <td></td>
        </tr>
    </div>
    <div class="tablerow" id='divmaximumdepthinmeters'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($localityElement, 'maximumdepthinmeters');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=maximumdepthinmeters',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($localityElement,'maximumdepthinmeters',array('class'=>'textfield')); ?>
            </td>
            <td></td>
        </tr>
    </div>
</table>

<table cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
    <div class="tablerow" id='divminimumdistanceabovesurfaceinmeters'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($localityElement, 'minimumdistanceabovesurfaceinmeters');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=minimumdistanceabovesurfaceinmeters',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($localityElement,'minimumdistanceabovesurfaceinmeters',array('class'=>'textfield')); ?>
            </td>
            <td></td>
        </tr>
    </div>
    <div class="tablerow" id='divmaximumdistanceabovesurfaceinmeters'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($localityElement, 'maximumdistanceabovesurfaceinmeters');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=maximumdistanceabovesurfaceinmeters',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($localityElement,'maximumdistanceabovesurfaceinmeters',array('class'=>'textfield')); ?>
            </td>
            <td></td>
        </tr>
    </div>
</table>

<table cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
    <div class="tablerow" id='divverbatimdepth'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($localityElement, 'verbatimdepth');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=verbatimdepth',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($localityElement,'verbatimdepth',array('class'=>'textfield')); ?>
            </td>
            <td></td>
        </tr>
    </div>
    <div class="tablerow" id='divverbatimelevation'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($localityElement, 'verbatimelevation');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=verbatimelevation',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($localityElement,'verbatimelevation',array('class'=>'textfield')); ?>
            </td>
            <td></td>
        </tr>
    </div>
    <div class="tablerow" id='divverbatimlocality'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($localityElement, 'verbatimlocality');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=verbatimlocality',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($localityElement,'verbatimlocality',array('class'=>'textfield')); ?>
            </td>
            <td></td>
        </tr>
    </div>
    <div class="tablerow" id='divverbatimsrs'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($localityElement, 'verbatimsrs');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=verbatimsrs',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($localityElement,'verbatimsrs',array('class'=>'textfield')); ?>
            </td>
            <td></td>
        </tr>
    </div>
</table>

<table cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
    <div class="tablerow" id='divgeoreferencedby'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel(GeoreferencedByAR::model(), "georeferencedby");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=georeferencedby',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField(GeoreferencedByAR::model(),'idgeoreferencedby');?>
                    <?php echo CHtml::activeTextField(GeoreferencedByAR::model(), 'georeferencedby', array('class'=>'textfield'));?>                    
                </div>
            </td>
            <td class="acIcon" id="autocompleteGeoreferencedBy"></td>
        </tr>
    </div>
</table>

<table cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
    <div class="tablerow" id='divfootprintsrs'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($localityElement, 'footprintsrs');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=footprintsrs',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($localityElement,'footprintsrs',array('class'=>'textfield')); ?>
            </td>
            <td></td>
        </tr>
    </div>
</table>