<script type="text/javascript">
    var identifiedByIdentificationList = new Array();
    var typeStatusIdentificationList = new Array();

    //Date and time formatter
    jQuery(function($){
    $("#IdentificationElementAR_dateidentified").mask("9999/99/99");
    $("#IdentificationElementAR_dateidentified").datepicker({ dateFormat: 'yy/mm/dd' });
    });

    $(document).ready(bootIdentification);
    function bootIdentification(){
        // id, field, controller, bottao, list Html, list Javascript, acao de relacionamento NN (padrao), hidden do id target
        configAutocompleteNN('#IdentificationElementAR_ididentificationelement', '#IdentifiedByIdentificationAR_identifiedby', 'identifiedby', 'IdentificationElement');
        configAutocompleteNN('#IdentificationElementAR_ididentificationelement', '#TypeStatusIdentificationAR_typestatus', 'typestatus', 'IdentificationElement');
        // id, field, controller
        configAutocomplete('#IdentificationElementAR_ididentificationqualifier','#IdentificationQualifierAR_identificationqualifier', 'identificationqualifier');

        //Autocomplete icons
        //Example <td class="acIcon" id="autocomplete"></div>
        var btnAutocomplete ="<div class='btnAutocomplete' style='width:20px;'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-comment'></span></li></ul></div>";

        $('#autocompleteIdentificationQualifier').html('<a href="javascript:suggest(\'#IdentificationElementAR_ididentificationqualifier\',\'#IdentificationQualifierAR_identificationqualifier\', \'identificationqualifier\');">'+btnAutocomplete+'</a>');

        //Config hover effect for
        configIcons();

        //Help tooltip for NxN fields
        //var helpTip = '<div style="font-weight:normal;">In this field, you can create a list of entries.</div>';

        $('#IdentifiedByIdentificationAR_identifiedby').poshytip({
            className: 'tip-twitter',
            content: helpTip,
            showOn: 'focus',
            alignTo: 'target',
            alignX: 'inner-left',
            alignY: 'top',
            offsetX: 0,
            offsetY: 5
        });

        $('#TypeStatusIdentificationAR_typestatus').poshytip({
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
    function identifiedbyIdentificationElementRemoveItemList(controller,id,target){
        //alert(controller +" "+id);
        var jsonItem = {"id":id,"action":"delete"};
        identifiedByIdentificationList.push(jsonItem);
        $('#'+controller+target+'_'+id).remove();
    }
    function typestatusIdentificationElementRemoveItemList(controller,id,target){
        //alert(controller +" "+id);
        var jsonItem = {"id":id,"action":"delete"};
        typeStatusIdentificationList.push(jsonItem);
        $('#'+controller+target+'_'+id).remove();
    }
</script>

<div class="overflow">
<table cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
<?php echo CHtml::activeHiddenField($identificationElement,'ididentificationelement');?>
    <div class="tablerow" id='divdateidentified'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($identificationElement, "dateidentified");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=dateidentified',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($identificationElement,'dateidentified',array('class'=>'timeordate')); ?>
                <span style="font-size: 10px;"> YYYY/MM/DD</span>
            </td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='dividentificationqualifier'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($identificationElement->identificationqualifier, 'identificationqualifier');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=identificationqualifier',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($identificationElement,'ididentificationqualifier');?>
                    <?php echo CHtml::activeTextField($identificationElement->identificationqualifier, 'identificationqualifier', array('class'=>'textfield'));?>
                </div>
            </td>
            <td class="acIcon" id="autocompleteIdentificationQualifier"></div>
        </tr>
    </div>
    <div class="tablerow" id='dividentifiedby'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel(IdentifiedByIdentificationAR::model(), "identifiedby");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=identifiedby',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField(IdentifiedByIdentificationAR::model(),'ididentifiedby');?>
                    <?php echo CHtml::activeTextField(IdentifiedByIdentificationAR::model(), 'identifiedby', array('class'=>'textfield'));?>                    
                </div>
            </td>
            <td class="acIcon"></td>
        </tr>

    </div>
    <div class="tablerow" id='divtypestatus'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel(TypeStatusIdentificationAR::model(), "typestatus");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=typestatus',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField(TypeStatusIdentificationAR::model(),'idtypestatus');?>
                    <?php echo CHtml::activeTextField(TypeStatusIdentificationAR::model(), 'typestatus', array('class'=>'textfield'));?>                    
                </div>
            </td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='dividentificationremark'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($identificationElement, "identificationremark");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=identificationremark',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextArea($identificationElement,'identificationremark',array('class'=>'textarea')); ?>
            </td>
            <td class="acIcon"></td>
        </tr>
    </div> 
</table>
</div>
