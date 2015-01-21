<script type="text/javascript">
    //Date and time formatter
    jQuery(function($){
    $("#EventElementAR_eventtime").mask("99:99:99");
    $("#EventElementAR_eventdate").mask("9999/99/99");
    $("#EventElementAR_eventdate").datepicker({ dateFormat: 'yy/mm/dd' });
    });

    $(document).ready(bootEvent);
    function bootEvent(){
        // id, field, controller, bottao, list Html, list Javascript, acao de relacionamento NN (padrao), hidden do id target
        // id, field, controller
        configAutocomplete('#EventElementAR_idsamplingprotocol','#SamplingProtocolAR_samplingprotocol', 'samplingprotocol');
        configAutocomplete('#EventElementAR_idhabitat','#HabitatEventAR_habitat', 'habitat');

        //Autocomplete icons
        //Example <td class="acIcon" id="autocomplete"></div>
        var btnAutocomplete ="<div class='btnAutocomplete' style='width:20px;'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-comment'></span></li></ul></div>";

        $('#autocompleteSamplingProtocol').html('<a href="javascript:suggest(\'#EventElementAR_idsamplingprotocol\',\'#SamplingProtocolAR_samplingprotocol\', \'samplingprotocol\');">'+btnAutocomplete+'</a>');
        $('#autocompleteHabitat').html('<a href="javascript:suggest(\'#EventElementAR_idhabitat\',\'#HabitatEventAR_habitat\', \'habitat\');">'+btnAutocomplete+'</a>');

        //Config hover effect for icons
        configIcons();

    }
</script>

<table id="eventelementsblock_1" cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
<?php echo CHtml::activeHiddenField($eventElement,'ideventelement');?>

    <div class="tablerow" id='divsamplingprotocol'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($eventElement->samplingprotocol, 'samplingprotocol');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=samplingprotocol',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php $eventElement->samplingprotocol->samplingprotocol; ?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divsamplingeffort'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($eventElement, "samplingeffort");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=samplingeffort',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $eventElement->samplingeffort; ?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divhabitat'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($eventElement->habitat, 'habitat');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=habitat',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $eventElement->habitat->habitat; ?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divverbatimeventdate'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($eventElement, "verbatimeventdate");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=verbatimeventdate',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $eventElement->verbatimeventdate; ?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='diveventtime'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($eventElement, "eventtime");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=eventtime',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $eventElement->eventtime; ?></td>
            <td style="font-size: 10px;"><?php echo "24 hh:mm:ss" ?></td>
        </tr>
    </div>
    <div class="tablerow" id='diveventdate'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($eventElement, "eventdate");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=eventdate',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $eventElement->eventdate; ?></td>
            <td style="font-size: 10px;"><?php echo "YYYY/MM/DD" ?></td>
        </tr>
    </div>
    <div class="tablerow" id='divfieldnumber'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($eventElement, "fieldnumber");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=fieldnumber',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $eventElement->fieldnumber; ?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divfieldnote'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($eventElement, "fieldnote");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=fieldnote',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $eventElement->fieldnote; ?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='diveventremark'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($eventElement, "eventremark");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=eventremark',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $eventElement->eventremark; ?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
</table>