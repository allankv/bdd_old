<script type="text/javascript">
    var individualList = new Array();
    var recordedByOccurrenceList = new Array();
    var preparationOccurrenceList = new Array();
    var associatedSequenceOccurrenceList = new Array();

    //Force numeric input
    jQuery(function($){
    $("#OccurrenceElementAR_individualcount").jStepper({minValue:0, disableNonNumeric:true});
    });

    $(document).ready(bootOccurrence);
    function bootOccurrence(){
        
        // id, field, controller, bottao, list Html, list Javascript, acao de relacionamento NN (padrao), hidden do id target
        configAutocompleteNN('#OccurrenceElementAR_idoccurrenceelement', '#RecordedByOccurrenceAR_recordedby', 'recordedby', 'OccurrenceElement');
        configAutocompleteNN('#OccurrenceElementAR_idoccurrenceelement', '#PreparationOccurrenceAR_preparation', 'preparation', 'OccurrenceElement');
        configAutocompleteNN('#OccurrenceElementAR_idoccurrenceelement', '#IndividualAR_individual', 'individual', 'OccurrenceElement');
        configAutocompleteNN('#OccurrenceElementAR_idoccurrenceelement', '#AssociatedSequenceOccurrenceAR_associatedsequence', 'associatedsequence', 'OccurrenceElement');
        // id, field, controller
        configAutocomplete('#OccurrenceElementAR_idbehavior','#BehaviorAR_behavior', 'behavior');
        configAutocomplete('#OccurrenceElementAR_idlifestage','#LifeStageAR_lifestage', 'lifestage');
        configAutocomplete('#OccurrenceElementAR_iddisposition','#DispositionOccurrenceAR_disposition', 'disposition');
        configAutocomplete('#OccurrenceElementAR_idreproductivecondition','#ReproductiveConditionAR_reproductivecondition', 'reproductivecondition');
        configAutocomplete('#OccurrenceElementAR_idestablishmentmean','#EstablishmentMeanAR_establishmentmean', 'establishmentmean');
        configAutocomplete('#OccurrenceElementAR_idsex','#SexAR_sex', 'sex');


        //Autocomplete icons
        //Example
        //<td class="acIcon" id="autocomplete"></td>
        var btnAutocomplete ="<div class='btnAutocomplete' style='width:20px;'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-comment'></span></li></ul></div>";

        $('#autocompleteBehavior').html('<a href="javascript:suggest(\'#OccurrenceElementAR_idbehavior\',\'#BehaviorAR_behavior\', \'behavior\');">'+btnAutocomplete+'</a>');
        $('#autocompleteLifeStage').html('<a href="javascript:suggest(\'#OccurrenceElementAR_idlifestage\',\'#LifeStageAR_lifestage\', \'lifestage\');">'+btnAutocomplete+'</a>');
        $('#autocompleteDisposition').html('<a href="javascript:suggest(\'#OccurrenceElementAR_iddisposition\',\'#DispositionOccurrenceAR_disposition\', \'disposition\');">'+btnAutocomplete+'</a>');
        $('#autocompleteReproductiveCondition').html('<a href="javascript:suggest(\'#OccurrenceElementAR_idreproductivecondition\',\'#ReproductiveConditionAR_reproductivecondition\', \'reproductivecondition\');">'+btnAutocomplete+'</a>');
        $('#autocompleteEstablishmentMean').html('<a href="javascript:suggest(\'#OccurrenceElementAR_idestablishmentmean\',\'#EstablishmentMeanAR_establishmentmean\', \'establishmentmean\');">'+btnAutocomplete+'</a>');
        $('#autocompleteSex').html('<a href="javascript:suggest(\'#OccurrenceElementAR_idsex\',\'#SexAR_sex\', \'sex\');">'+btnAutocomplete+'</a>');


        //Help tooltip for NxN fields
        $('#RecordedByOccurrenceAR_recordedby').poshytip({
            className: 'tip-twitter',
            content: helpTip,
            showOn: 'focus',
            alignTo: 'target',
            alignX: 'inner-left',
            alignY: 'top',
            offsetX: 0,
            offsetY: 5
        });

        $('#PreparationOccurrenceAR_preparation').poshytip({
            className: 'tip-twitter',
            content: helpTip,
            showOn: 'focus',
            alignTo: 'target',
            alignX: 'inner-left',
            alignY: 'top',
            offsetX: 0,
            offsetY: 5
        });

        $('#IndividualAR_individual').poshytip({
            className: 'tip-twitter',
            content: helpTip,
            showOn: 'focus',
            alignTo: 'target',
            alignX: 'inner-left',
            alignY: 'top',
            offsetX: 0,
            offsetY: 5
        });

        $('#AssociatedSequenceOccurrenceAR_associatedsequence').poshytip({
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
    function individualOccurrenceElementRemoveItemList(controller,id,target){
        //alert(controller +" "+id);
        var jsonItem = {"id":id,"action":"delete"};
        individualList.push(jsonItem);
        $('#'+controller+target+'_'+id).remove();
    }
    function recordedbyOccurrenceElementRemoveItemList(controller,id,target){
        //alert(controller +" "+id);
        var jsonItem = {"id":id,"action":"delete"};
        recordedByOccurrenceList.push(jsonItem);
        $('#'+controller+target+'_'+id).remove();
    }
    function preparationOccurrenceElementRemoveItemList(controller,id,target){
        //alert(controller +" "+id);
        var jsonItem = {"id":id,"action":"delete"};
        preparationOccurrenceList.push(jsonItem);
        $('#'+controller+target+'_'+id).remove();
    }
    function associatedsequenceOccurrenceElementRemoveItemList(controller,id,target){
        //alert(controller +" "+id);
        var jsonItem = {"id":id,"action":"delete"};
        associatedSequenceOccurrenceList.push(jsonItem);
        $('#'+controller+target+'_'+id).remove();
    }
</script>

<?php echo CHtml::activeHiddenField($occurrenceElement,'idoccurrenceelement');?>

<table id="occurrenceelementsblock_1" cellspacing="0" cellpadding="0" align="center" class="fieldsTable">	
	<div class="tablerow" id='divcatalognumber'>
        <tr id="catalognumberrow">
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabelEx($occurrenceElement,'catalognumber');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=catalognumber',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $occurrenceElement->catalognumber; ?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divindividual'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel(IndividualAR::model(), "individual");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=individual',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php
                    $individual = "";
                    foreach ($occurrenceElement->individual as $value) {
                        $individual .= $value->individual . ", ";
                    }
                    $individual = substr($individual, 0, -2);
                    echo $individual;
                ?></td>
            <td class="acIcon"></td>
        </tr>

    </div>
    <div class="tablerow" id='divindividualcount'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($occurrenceElement, "individualcount");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=individualcount',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $occurrenceElement->individualcount; ?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divsex'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel(SexAR::model(), "sex"); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=sex',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $occurrenceElement->sex->sex; ?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divbehavior'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($occurrenceElement->behavior, 'behavior');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=behavior',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $occurrenceElement->behavior->behavior; ?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divlifestage'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($occurrenceElement->lifestage,'lifestage');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=lifestage',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $occurrenceElement->lifestage->lifestage; ?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divdisposition'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($occurrenceElement->disposition, 'disposition');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=disposition',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $occurrenceElement->disposition->disposition; ?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divreproductivecondition'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($occurrenceElement->reproductivecondition, 'reproductivecondition');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=reproductivecondition',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $occurrenceElement->reproductivecondition->reproductivecondition; ?></td>
            <td class="acIcon"></td>
        </tr>
    </div>

    <div class="tablerow" id='divestablishmentmean'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($occurrenceElement->establishmentmean, 'establishmentmean');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=establishmentmean',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $occurrenceElement->establishmentmean->establishmentmean; ?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
</table>

<table id="occurrenceelementsblock_2" cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
    <div class="tablerow" id='divrecordedby'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel(RecordedByAR::model(), "recordedby");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=recordedby',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php
                    $recordedby = "";
                    foreach ($occurrenceElement->recordedby as $value) {
                        $recordedby .= $value->recordedby . ", ";
                    }
                    $recordedby = substr($recordedby, 0, -2);
                    echo $recordedby;
                ?></td>
            <td class="acIcon"></td>
        </tr>

    </div>
    <div class="tablerow" id='divrecordnumber'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($occurrenceElement, 'recordnumber');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=recordnumber',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $occurrenceElement->recordnumber ; ?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divothercatalognumber'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($occurrenceElement, 'othercatalognumber');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=othercatalognumber',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $occurrenceElement->othercatalognumber ; ?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divpreparation'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel(PreparationAR::model(),'preparation');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=preparation',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php
                    $preparation = "";
                    foreach ($occurrenceElement->preparation as $value) {
                        $preparation .= $value->preparation . ", ";
                    }
                    $preparation = substr($preparation, 0, -2);
                    echo $preparation;
                ?></td>
            <td class="acIcon"></td>
        </tr>

    </div>
    <div class="tablerow" id='divassociatedsequence'>
        <tr>
            <td class="tablelabelcel">
                <?php  echo CHtml::activeLabel(AssociatedSequenceAR::model(), "associatedsequence");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=associatedsequence',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php
                    $associatedsequence = "";
                    foreach ($occurrenceElement->associatedsequence as $value) {
                        $associatedsequence .= $value->associatedsequence . ", ";
                    }
                    $associatedsequence = substr($associatedsequence, 0, -2);
                    echo $associatedsequence;
                ?></td>
            <td class="acIcon"></td>
        </tr>

    </div>    
</table>

<table id="occurrenceelementsblock_3" cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
    <div class="tablerow" id='divoccurrencedetail'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($occurrenceElement, 'occurrencedetail');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=occurrencedetail',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $occurrenceElement->occurrencedetail ; ?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divoccurrenceremark'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($occurrenceElement, 'occurrenceremark');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=occurrenceremark',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $occurrenceElement->occurrenceremark ; ?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divoccurrencestatus'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($occurrenceElement, "occurrencestatus");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=occurrencestatus',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $occurrenceElement->occurrencestatus ;?></td>
            <td class="acIcon"></td>
        </tr>
    </div>  
</table>