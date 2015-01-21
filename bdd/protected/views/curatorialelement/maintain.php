<?php
$cs=Yii::app()->clientScript;
$cs->registerScriptFile("js/lightbox/curatorialelements.js",CClientScript::POS_HEAD);
$cs->registerScriptFile("js/validation/validationdata.js",CClientScript::POS_HEAD);
$cs->registerScriptFile("js/validation/jquery.numeric.pack.js",CClientScript::POS_HEAD);
$cs->registerScriptFile("js/lightbox/lightbox.js",CClientScript::POS_BEGIN);
$cs->registerCssFile("css/lightbox.css");
?>

<!--Numeric-->
<script src="js/jquery.jstepper.js" type="text/javascript"></script>

<script>
    var recordedByCuratorialList = new Array();
    var typeStatusCuratorialList = new Array();
    var identifiedByCuratorialList = new Array();
    var preparationCuratorialList = new Array();
    var associatedSequenceCuratorialList = new Array();

    //Force numeric and date input
    jQuery(function($){
        $("#CuratorialElementAR_individualcount").jStepper({minValue:0, disableNonNumeric:true});
        $("#CuratorialElementAR_dateidentified").mask("9999/99/99");
        $("#CuratorialElementAR_dateidentified").datepicker({ dateFormat: 'yy/mm/dd' });
    });

    $(document).ready(bootCuratorial);
    function bootCuratorial(){
        // id, field, controller, bottao, list Html, list Javascript, acao de relacionamento NN (padrao), hidden do id target
        configAutocompleteNN('#RecordedByCuratorialAR_idrecordedby','#RecordedByCuratorialAR_recordedby', 'recordedby', '#addRecordedByCuratorialBtn', '#recordedByCuratorialList',recordedByCuratorialList,'CuratorialElement','#SpecimenAR_idcuratorialelement');
        configAutocompleteNN('#TypeStatusCuratorialAR_idtypestatus','#TypeStatusCuratorialAR_typestatus', 'typestatus', '#addTypeStatusCuratorialBtn', '#typeStatusCuratorialList',typeStatusCuratorialList,'CuratorialElement','#SpecimenAR_idcuratorialelement');
        configAutocompleteNN('#IdentifiedByCuratorialAR_ididentifiedby','#IdentifiedByCuratorialAR_identifiedby', 'identifiedby', '#addIdentifiedByCuratorialBtn', '#identifiedByCuratorialList',identifiedByCuratorialList,'CuratorialElement','#SpecimenAR_idcuratorialelement');
        configAutocompleteNN('#AssociatedSequenceCuratorialAR_idassociatedsequence','#AssociatedSequenceCuratorialAR_associatedsequence', 'associatedsequence', '#addAssociatedSequenceCuratorialBtn', '#associatedSequenceCuratorialList',associatedSequenceCuratorialList,'CuratorialElement','#SpecimenAR_idcuratorialelement');
        configAutocompleteNN('#PreparationCuratorialAR_idpreparation','#PreparationCuratorialAR_preparation', 'preparation', '#addPreparationCuratorialBtn', '#preparationCuratorialList',preparationCuratorialList,'CuratorialElement','#SpecimenAR_idcuratorialelement');
        // id, field, controller
        configAutocomplete('#CuratorialElementAR_iddisposition','#DispositionCuratorialAR_disposition', 'disposition');
    }
    function recordedbyCuratorialElementRemoveItemList(controller,id,target){
        //alert(controller +" "+id);
        var jsonItem = {"id":id,"action":"delete"};
        recordedByCuratorialList.push(jsonItem);
        $('#'+controller+target+'_'+id).remove();
    }
    function typestatusCuratorialElementRemoveItemList(controller,id,target){
        //alert(controller +" "+id);
        var jsonItem = {"id":id,"action":"delete"};
        typeStatusCuratorialList.push(jsonItem);
        $('#'+controller+target+'_'+id).remove();
    }
    function identifiedbyCuratorialElementRemoveItemList(controller,id,target){
        //alert(controller +" "+id);
        var jsonItem = {"id":id,"action":"delete"};
        identifiedByCuratorialList.push(jsonItem);
        $('#'+controller+target+'_'+id).remove();
    }
    function associatedsequenceCuratorialElementRemoveItemList(controller,id,target){
        //alert(controller +" "+id);
        var jsonItem = {"id":id,"action":"delete"};
        associatedSequenceCuratorialList.push(jsonItem);
        $('#'+controller+target+'_'+id).remove();
    }
    function preparationCuratorialElementRemoveItemList(controller,id,target){
        //alert(controller +" "+id);
        var jsonItem = {"id":id,"action":"delete"};
        preparationCuratorialList.push(jsonItem);
        $('#'+controller+target+'_'+id).remove();
    }
</script>

<table cellspacing="0" cellpadding="0" align="center" class="normalFieldsTable">

    <?php echo CHtml::activeHiddenField($curatorialElement,'idcuratorialelement');?>

    <div class="tablerow" id='divrecordedby'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel(RecordedByAR::model(), "recordedby");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=recordedby',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField(RecordedByCuratorialAR::model(),'idrecordedby');?>
                    <?php echo CHtml::activeTextField(RecordedByCuratorialAR::model(), 'recordedby', array('class'=>'textfield'));?>
                    <td class="tablebuttoncel">
                        <input type="button" title="+" value="+" id="addRecordedByCuratorialBtn">
                    </td>
                </div>
            </td>
            <td class="tableautocel">&nbsp;</td>
            <td class="tableundocel">&nbsp;</td>
        </tr>
        <tr>
            <td class="tablelabelcel">
                <?php echo ' ';?>
            </td>
            <td class="tablemiddlecel">
                <?php echo ' ';?>
            </td>
            <td class="tablefieldcel">
                <ul id="recordedByCuratorialList">
                </ul>
            </td>
        </tr>
    </div>
    <div class="tablerow" id='divtypestatus'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel(TypeStatusCuratorialAR::model(), "typestatus");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=typestatus',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField(TypeStatusCuratorialAR::model(),'idtypestatus');?>
                    <?php echo CHtml::activeTextField(TypeStatusCuratorialAR::model(), 'typestatus', array('class'=>'textfield'));?>
                    <td class="tablebuttoncel">
                        <input type="button" title="+" value="+" id="addTypeStatusCuratorialBtn">
                    </td>
                </div>
            </td>
            <td class="tableautocel">&nbsp;</td>
            <td class="tableundocel">&nbsp;</td>
        </tr>
        <tr>
            <td class="tablelabelcel">
                <?php echo ' ';?>
            </td>
            <td class="tablemiddlecel">
                <?php echo ' ';?>
            </td>
            <td class="tablefieldcel">
                <ul id="typeStatusCuratorialList">
                </ul>
            </td>
        </tr>
    </div>
    <div class="tablerow" id='dividentifiedby'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel(IdentifiedByCuratorialAR::model(), "identifiedby");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=identifiedby',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField(IdentifiedByCuratorialAR::model(),'ididentifiedby');?>
                    <?php echo CHtml::activeTextField(IdentifiedByCuratorialAR::model(), 'identifiedby', array('class'=>'textfield'));?>
                    <td class="tablebuttoncel">
                        <input type="button" title="+" value="+" id="addIdentifiedByCuratorialBtn">
                    </td>
                </div>
            </td>
            <td class="tableautocel">&nbsp;</td>
            <td class="tableundocel">&nbsp;</td>
        </tr>
        <tr>
            <td class="tablelabelcel">
                <?php echo ' ';?>
            </td>
            <td class="tablemiddlecel">
                <?php echo ' ';?>
            </td>
            <td class="tablefieldcel">
                <ul id="identifiedByCuratorialList">
                </ul>
            </td>
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
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField(AssociatedSequenceCuratorialAR::model(),'idassociatedsequence');?>
                    <?php echo CHtml::activeTextField(AssociatedSequenceCuratorialAR::model(), 'associatedsequence', array('class'=>'textfield'));?>
                    <td class="tablebuttoncel">
                        <input type="button" title="+" value="+" id="addAssociatedSequenceCuratorialBtn">
                    </td>
                </div>
            </td>
        </tr>
        <tr>
            <td class="tablelabelcel">
                <?php echo ' ';?>
            </td>
            <td class="tablemiddlecel">
                <?php echo ' ';?>
            </td>
            <td class="tablefieldcel">
                <ul id="associatedSequenceCuratorialList">
                </ul>
            </td>
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
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField(PreparationCuratorialAR::model(),'idpreparation');?>
                    <?php echo CHtml::activeTextField(PreparationCuratorialAR::model(), 'preparation', array('class'=>'textfield'));?>
                    <td class="tablebuttoncel">
                        <input type="button" title="+" value="+" id="addPreparationCuratorialBtn">
                    </td>
                </div>
            </td>
        </tr>
        <tr>
            <td class="tablelabelcel">
                <?php echo ' ';?>
            </td>
            <td class="tablemiddlecel">
                <?php echo ' ';?>
            </td>
            <td class="tablefieldcel">
                <ul id="preparationCuratorialList">
                </ul>
            </td>
        </tr>
    </div>
    <div class="tablerow" id='divdateidentified'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($curatorialElement,"dateidentified"); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=dateidentified',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($curatorialElement,'dateidentified',array('class'=>'timeordate')); ?>
                <span style="font-size: 10px;"> YYYY/MM/DD</span>
            </td>
        </tr>
    </div>
    <div class="tablerow" id='divfieldnumber'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($curatorialElement, 'fieldnumber');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=fieldnumber',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($curatorialElement,'fieldnumber',array('class'=>'textboxtext')); ?>
            </td>
            <td class="tableautocel">&nbsp;</td>
            <td class="tableundocel">&nbsp;</td>
        </tr>
    </div>
    <div class="tablerow" id='divindividualcount'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($curatorialElement, "individualcount");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=individualcount',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($curatorialElement,'individualcount',array('class'=>'textboxnumber')); ?>
            </td>
            <td class="tableautocel">&nbsp;</td>
            <td class="tableundocel">&nbsp;</td>
        </tr>
    </div>
    <div class="tablerow" id='divfieldnote'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($curatorialElement, "fieldnote");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=fieldnote',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextArea($curatorialElement,'fieldnote',array('class'=>'textarea')); ?>
            </td>
            <td class="tableautocel">&nbsp;</td>
            <td class="tableundocel">&nbsp;</td>
        </tr>
    </div>
    <div class="tablerow" id='divverbatimeventdate'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($curatorialElement, "verbatimeventdate");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=verbatimeventdate',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($curatorialElement,'verbatimeventdate',array('class'=>'textboxtext')); ?>
            </td>
            <td class="tableautocel">&nbsp;</td>
            <td class="tableundocel">&nbsp;</td>
        </tr>
    </div>
    <div class="tablerow" id='divverbatimelevation'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($curatorialElement, "verbatimelevation");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=verbatimelevation',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($curatorialElement,'verbatimelevation',array('class'=>'textboxtext')); ?>
            </td>
            <td class="tableautocel">&nbsp;</td>
            <td class="tableundocel">&nbsp;</td>
        </tr>
    </div>
    <div class="tablerow" id='divverbatimdepth'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($curatorialElement, "verbatimdepth");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=verbatimdepth',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($curatorialElement,'verbatimdepth',array('class'=>'textboxtext')); ?>
            </td>
            <td class="tableautocel">&nbsp;</td>
            <td class="tableundocel">&nbsp;</td>
        </tr>
    </div>
    <div class="tablerow" id='divdisposition'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($curatorialElement->disposition, 'disposition');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=disposition',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($curatorialElement,'iddisposition');?>
                    <?php echo CHtml::activeTextField($curatorialElement->disposition, 'disposition', array('class'=>'textfield'));?>
                </div>
            </td>
        </tr>
    </div>
</table>