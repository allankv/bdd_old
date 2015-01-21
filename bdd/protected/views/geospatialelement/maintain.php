<script type="text/javascript">
    var georeferenceSourceGeospatialList = new Array();

    //Force numeric input
    jQuery(function($){
    $("#GeospatialElementAR_coordinateuncertaintyinmeters").jStepper({decimalSeparator:".", disableNonNumeric:true});
    });

    $(document).ready(bootIdentification);
    function bootIdentification(){
        // id, field, controller, bottao, list Html, list Javascript, acao de relacionamento NN (padrao), hidden do id target
        configAutocompleteNN('#GeoreferenceSourceGeospatialAR_idgeoreferencesource','#GeoreferenceSourceGeospatialAR_georeferencesource', 'georeferencesource','#georeferenceSourceGeospatialList',georeferenceSourceGeospatialList,'GeospatialElement','#SpecimenAR_idgeospatialelement');
        // id, field, controller
        configAutocomplete('#GeospatialElementAR_idgeoreferenceverificationstatus','#GeoreferenceVerificationStatusGeospatialAR_georeferenceverificationstatus', 'georeferenceverificationstatus');

        //Autocomplete icons
        //Example <td class="acIcon" id="autocomplete"></div>
        var btnAutocomplete ="<div class='btnAutocomplete' style='width:20px;'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-comment'></span></li></ul></div>";

        $('#autocompleteGeoreferenceSourceGeospatial').html('<a href="javascript:suggest(\'#GeoreferenceSourceGeospatialAR_idgeoreferencesource\',\'#GeoreferenceSourceGeospatialAR_georeferencesource\', \'georeferencesource\');">'+btnAutocomplete+'</a>');
        $('#autocompleteGeoreferenceVerificationStatus').html('<a href="javascript:suggest(\'#GeospatialElementAR_idgeoreferenceverificationstatus\',\'#GeoreferenceVerificationStatusGeospatialAR_georeferenceverificationstatus\', \'georeferenceverificationstatus\');">'+btnAutocomplete+'</a>');

        //Config hover effect for icons
        configIcons();

        //Help tooltip for NxN fields
        //var helpTip = '<div style="font-weight:normal;">In this field, you can create a list of entries.</div>';

        $('#GeoreferenceSourceGeospatialAR_georeferencesource').poshytip({
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
    function georeferencesourceGeospatialElementRemoveItemList(controller,id,target){
        //alert(controller +" "+id);
        var jsonItem = {"id":id,"action":"delete"};
        georeferenceSourceGeospatialList.push(jsonItem);
        $('#'+controller+target+'_'+id).remove();
    }
</script>

<?php echo CHtml::activeHiddenField($geospatialElement,'idgeospatialelement');?>

<table cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
	<div class="tablerow" id='divdecimallatitude'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($geospatialElement,'decimallatitude');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=decimallatitude',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($geospatialElement,'decimallatitude',array('class'=>'textboxnumber'));?>
            </td>
            <td></td>
            <!--<td rowspan=2>
                <div class="field autocomplete">
                    <input type="button" value="BDD Georeferencing Tool" id="bgtBtn">
                </div>
            </td>-->
        </tr>
    </div>
    <div class="tablerow" id='divdecimallongitude'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($geospatialElement,'decimallongitude');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=decimallongitude',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($geospatialElement,'decimallongitude',array('class'=>'textboxnumber'));?>
            </td>
            <td></td>
        </tr>
    </div>
    <div class="tablerow" id='divcoordinateuncertaintyinmeters'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($geospatialElement, "coordinateuncertaintyinmeters");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=coordinateuncertaintyinmeters',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($geospatialElement,'coordinateuncertaintyinmeters',array('class'=>'textboxnumber'));?>
            </td>
            <td></td>
        </tr>
    </div>
    <div class="tablerow" id='divgeodeticdatum'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($geospatialElement, "geodeticdatum");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=geodeticdatum',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($geospatialElement,'geodeticdatum',array('class'=>'textboxtext'));?>
            </td>
            <td></td>
        </tr>
    </div>
    <div class="tablerow" id='divpointradiusspatialfit'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($geospatialElement, "pointradiusspatialfit");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=pointradiusspatialfit',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($geospatialElement,'pointradiusspatialfit',array('class'=>'textboxtext'));?>
            </td>
            <td></td>
        </tr>
    </div>
</table>

<table cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
    <div class="tablerow" id='divverbatimcoordinate'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($geospatialElement, "verbatimcoordinate");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=verbatimcoordinate',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($geospatialElement,'verbatimcoordinate',array('class'=>'textboxtext'));?>
            </td>
            <td></td>
        </tr>
    </div>
    <div class="tablerow" id='divverbatimlatitude'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($geospatialElement, "verbatimlatitude");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=verbatimlatitude',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($geospatialElement,'verbatimlatitude',array('class'=>'textboxtext'));?>
            </td>
            <td></td>
        </tr>
    </div>
    <div class="tablerow" id='divverbatimlongitude'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($geospatialElement, "verbatimlongitude");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=verbatimlongitude',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($geospatialElement,'verbatimlongitude',array('class'=>'textboxtext'));?>
            </td>
            <td></td>
        </tr>
    </div>
    <div class="tablerow" id='divverbatimcoordinatesystem'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($geospatialElement, "verbatimcoordinatesystem");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=verbatimcoordinatesystem',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($geospatialElement,'verbatimcoordinatesystem',array('class'=>'textboxtext'));?>
            </td>
            <td></td>
        </tr>
    </div>
</table>

<table cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
    <div class="tablerow" id='divgeoreferenceprotocol'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($geospatialElement, "georeferenceprotocol");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=georeferenceprotocol',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($geospatialElement,'georeferenceprotocol',array('class'=>'textboxtext'));?>
            </td>
            <td></td>
        </tr>
    </div>
    <div class="tablerow" id='divgeoreferencesource'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel(GeoreferenceSourceAR::model(), "georeferencesource");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=georeferencesource',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField(GeoreferenceSourceGeospatialAR::model(),'idgeoreferencesource');?>
                    <?php echo CHtml::activeTextField(GeoreferenceSourceGeospatialAR::model(), 'georeferencesource', array('class'=>'textfield'));?>
                </div>
            </td>
            <td class="acIcon" id="autocompleteGeoreferenceSourceGeospatial"></td>
        </tr>
        <tr>
            <td class="tablelabelcel">
                <?php echo ' ';?>
            </td>
            <td class="tablemiddlecel">
                <?php echo ' ';?>
            </td>
            <td class="tablefieldcel">
                <div class="entryListBox" id="georeferenceSourceGeospatialList">
                    <div class="entryListHeader">List of Georeference Sources</div>
                </div>
            </td>
            <td></td>
        </tr>
    </div>
    <div class="tablerow" id='divgeoreferenceverificationstatus'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($geospatialElement->georeferenceverificationstatus, 'georeferenceverificationstatus');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=georeferenceverificationstatus',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($geospatialElement,'idgeoreferenceverificationstatus');?>
                    <?php echo CHtml::activeTextField($geospatialElement->georeferenceverificationstatus, 'georeferenceverificationstatus', array('class'=>'textfield'));?>
                </div>
            </td>
            <td class="acIcon" id="autocompleteGeoreferenceVerificationStatus"></div>
        </tr>
    </div>
    <div class="tablerow" id='divgeoreferenceremark'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($geospatialElement, "georeferenceremark");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=georeferenceremark',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextArea($geospatialElement,'georeferenceremark',array('class'=>'textboxarea'));?>
            </td>
            <td></td>
        </tr>
    </div>
</table>

<table cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
    <div class="tablerow" id='divfootprintwkt'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($geospatialElement, "footprintwkt");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=footprintwkt',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($geospatialElement,'footprintwkt',array('class'=>'textboxtext'));?>
            </td>
            <td></td>
        </tr>
    </div>
    <div class="tablerow" id='divfootprintspatialfit'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($geospatialElement, "footprintspatialfit");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=footprintspatialfit',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($geospatialElement,'footprintspatialfit',array('class'=>'textboxtext'));?>
            </td>
            <td></td>
        </tr>
    </div>
</table>