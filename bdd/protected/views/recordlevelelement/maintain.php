<script type="text/javascript">
    var dynamicPropertyList = new Array();
    $(document).ready(bootRecordLevel);

    function bootRecordLevel(){
        // id, field, controller, bottao, list Html, list Javascript, acao de relacionamento NN (padrao), hidden do id target
        // START configAutocomplete
        configAutocomplete('#RecordLevelElementAR_idinstitutioncode','#InstitutionCodeAR_institutioncode', 'institutioncode');
        configAutocomplete('#RecordLevelElementAR_idcollectioncode','#CollectionCodeAR_collectioncode', 'collectioncode');
        configAutocomplete('#RecordLevelElementAR_idownerinstitution','#OwnerInstitutionAR_ownerinstitution', 'ownerinstitution');
        configAutocomplete('#RecordLevelElementAR_iddataset','#DatasetAR_dataset', 'dataset');

        configAutocompleteNN('#RecordLevelElementAR_idrecordlevelelement', '#DynamicPropertyAR_dynamicproperty', 'dynamicproperty', 'RecordLevelElement')

        // END configAutocomplete

        //configAutocompleteNN('#DynamicPropertyAR_iddynamicproperty','#DynamicPropertyAR_dynamicproperty', 'dynamicproperty', '#dynamicPropertyList',dynamicPropertyList,'RecordLevelElement','#SpecimenAR_idrecordlevelelement');
        // id, field, controller
        
        //Autocomplete icons
        var btnAutocomplete ="<div class='btnAutocomplete' style='width:20px;'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-comment'></span></li></ul></div>";
	
        $('#autocompleteInstitutionCode').html('<a href="javascript:suggest(\'#RecordLevelElementAR_idinstitutioncode\',\'#InstitutionCodeAR_institutioncode\', \'institutioncode\');">'+btnAutocomplete+'</a>');
        $('#autocompleteCollectionCode').html('<a href="javascript:suggest(\'#RecordLevelElementAR_idcollectioncode\',\'#CollectionCodeAR_collectioncode\', \'collectioncode\');">'+btnAutocomplete+'</a>');
        //$('#autocompleteDynamicProperty').html('<a href="javascript:suggest(\'#DynamicPropertyAR_iddynamicproperty\',\'#DynamicPropertyAR_dynamicproperty\', \'dynamicproperty\');">'+btnAutocomplete+'</a>');
        $('#autocompleteOwnerInstitution').html('<a href="javascript:suggest(\'#RecordLevelElementAR_idownerinstitution\',\'#OwnerInstitutionAR_ownerinstitution\', \'ownerinstitution\');">'+btnAutocomplete+'</a>');
        $('#autocompleteDataset').html('<a href="javascript:suggest(\'#RecordLevelElementAR_iddataset\',\'#DatasetAR_dataset\', \'dataset\');">'+btnAutocomplete+'</a>');

        $("#RecordLevelElementAR_lendingdate").mask("9999/99/99");
        $("#RecordLevelElementAR_lendingdate").datepicker({ dateFormat: 'yy/mm/dd' });

        
        //Help tooltip for NxN fields
        /*$('#DynamicPropertyAR_dynamicproperty').poshytip({
            className: 'tip-twitter',
            content: helpTip,
            showOn: 'focus',
            alignTo: 'target',
            alignX: 'inner-left',
            alignY: 'top',
            offsetX: 0,
            offsetY: 5
        });*/
    }
    /* function dynamicpropertyRecordLevelElementRemoveItemList(controller,id,target){
        //alert(controller +" "+id);
        var jsonItem = {"id":id,"action":"delete"};
        dynamicPropertyList.push(jsonItem);
        $('#'+controller+target+'_'+id).remove();
    }*/
</script>

<?php echo CHtml::activeHiddenField($recordLevelElement, 'idrecordlevelelement'); ?>
<?php echo CHtml::activeHiddenField($recordLevelElement, 'globaluniqueidentifier'); ?>

<div class="overflow">
<table cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
    <div class="tablerow" id='divbasisofrecord'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabelEx($recordLevelElement->basisofrecord, 'basisofrecord'); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=basisofrecord', array('rel' => 'lightbox')); ?>
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeDropDownList($recordLevelElement, 'idbasisofrecord', CHtml::listData(BasisOfRecordAR::model()->findAll(" 1=1 ORDER BY basisofrecord "), 'idbasisofrecord', 'basisofrecord'), array('empty' => '-')); ?>
            </td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divinstitutioncode'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabelEx($recordLevelElement->institutioncode, 'institutioncode'); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=institutioncode', array('rel' => 'lightbox')); ?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($recordLevelElement, 'idinstitutioncode'); ?>
                    <?php echo CHtml::activeTextField($recordLevelElement->institutioncode, 'institutioncode', array('class' => 'textboxtext')); ?>
                </div>
            </td>
            <td class="acIcon" id="autocompleteInstitutionCode">
            </td>
        </tr>
    </div>
    <div class="tablerow" id='divcollectioncode'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabelEx($recordLevelElement->collectioncode, 'collectioncode'); ?>
                </td>
                <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=collectioncode', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($recordLevelElement, 'idcollectioncode'); ?>
                    <?php echo CHtml::activeTextField($recordLevelElement->collectioncode, 'collectioncode', array('class' => 'textboxtext')); ?>
                </div>
            </td>
            <td class="acIcon" id="autocompleteCollectionCode">
            </td>
        </tr>
    </div>
</table>
<table cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
    <div class="tablerow" id='divtype'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel(TypeAR::model(), "type"); ?>
                </td>
                <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=type', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                <?php echo CHtml::activeDropDownList($recordLevelElement, 'idtype', CHtml::listData(TypeAR::model()->findAll(" 1=1 ORDER BY type "), 'idtype', 'type'), array('empty' => '-')); ?>
                </td>
                <td></td>
            </tr>
        </div>
        <div class="tablerow" id='divownerinstitution'>
            <tr>
                <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($recordLevelElement->ownerinstitution, 'ownerinstitution'); ?>
                </td>
                <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=ownerinstitution', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($recordLevelElement, 'idownerinstitution'); ?>
                    <?php echo CHtml::activeTextField($recordLevelElement->ownerinstitution, 'ownerinstitution', array('class' => 'textfield')); ?>
                </div>
            </td>
            <td class="acIcon" id="autocompleteOwnerInstitution">
            </td>
        </tr>
    </div>
    <div class="tablerow" id='divdataset'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($recordLevelElement->dataset, 'dataset'); ?>
                </td>
                <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=dataset', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($recordLevelElement, 'iddataset'); ?>
                    <?php echo CHtml::activeTextField($recordLevelElement->dataset, 'dataset', array('class' => 'textfield')); ?>
                </div>
            </td>
            <td class="acIcon" id="autocompleteDataset">
            </td>
        </tr>
    </div>
</table>

<table cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
    <div class="tablerow" id='divrights'>
        <tr>   	   
            <td class="tablelabelcel">          	
                <?php echo CHtml::activeLabel($recordLevelElement, 'rights'); ?>
                </td>
                <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=rights', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($recordLevelElement, 'rights', array('class' => 'textfield')); ?>
                </td>
                <td></td>
            </tr>
        </div>
        <div class="tablerow" id='divrightsholder'>
            <tr>
                <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($recordLevelElement, 'rightsholder'); ?>
                </td>
                <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=rightsholder', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($recordLevelElement, 'rightsholder', array('class' => 'textfield')); ?>
                </td>
                <td></td>
            </tr>
        </div>
        <div class="tablerow" id='divaccessrights'>
            <tr>
                <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($recordLevelElement, 'accessrights'); ?>
                </td>
                <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=accessrights', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($recordLevelElement, 'accessrights', array('class' => 'textfield')); ?>
                </td>
                <td class="acIcon"></td>
            </tr>
        </div>
    </table>

    <table cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
        <div class="tablerow" id='divinformationwithheld'>
            <tr>
                <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($recordLevelElement, 'informationwithheld'); ?>
                </td>
                <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=informationwithheld', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                <?php echo CHtml::activeTextArea($recordLevelElement, 'informationwithheld', array('class' => 'textarea')); ?>
                </td>
                <td></td>
            </tr>
        </div>
        <div class="tablerow" id='divdatageneralization'>
            <tr>
                <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($recordLevelElement, 'datageneralization'); ?>
                </td>
                <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=datageneralization', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                <?php echo CHtml::activeTextArea($recordLevelElement, 'datageneralization', array('class' => 'textarea')); ?>
                </td>
                <td></td>
            </tr>
        </div>
        <div class="tablerow" id='divdynamicproperty'>
            <tr>
                <td class="tablelabelcel">
                <?php echo CHtml::activeLabel(DynamicPropertyAR::model(), 'dynamicproperty'); ?>
                </td>
                <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=dynamicproperty', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                        <select id="DynamicPropertyAR_dynamicproperty" name="DynamicPropertyAR_dynamicproperty">
                        </select>
                    <?php //echo CHtml::activeHiddenField(DynamicPropertyAR::model(), 'iddynamicproperty'); ?>
                    <?php //echo CHtml::activeTextField(DynamicPropertyAR::model(), 'dynamicproperty', array('class' => 'textfield')); ?>
                </div>
            </td>
            <td class="acIcon" id="autocompleteDynamicProperty">
            </td>
        </tr>
    </div>
</table>
	<table cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
        <div class="tablerow" id='divlending'>
            <tr>
                <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($recordLevelElement, 'lending'); ?>
                </td>
                <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=lending', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
	            <?php echo CHtml::activeCheckBox($recordLevelElement, 'lending'); ?>
                </td>
                <td class="acIcon"></td>
            </tr>
        </div>
        <div class="tablerow" id='divlendingwho'>
            <tr>
                <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($recordLevelElement, 'lendingwho'); ?>
                </td>
                <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=lendingwho', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($recordLevelElement, 'lendingwho', array('class' => 'textfield')); ?>
                </td>
                <td class="acIcon"></td>
            </tr>
        </div>
        <div class="tablerow" id='divlendingdate'>
            <tr>
                <td class="tablelabelcel">
                <?php echo CHtml::activeLabel($recordLevelElement, 'lendingdate'); ?>
                </td>
                <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=lendingdate', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                <?php echo CHtml::activeTextField($recordLevelElement,'lendingdate',array('class'=>'timeordate')); ?>
                <span style="font-size: 10px;"> YYYY/MM/DD</span>
                </td>
                <td class="acIcon"></td>
            </tr>
        </div>
    </table>

<div class="privateRecord" style="float: left; width:668px; height: 20px; margin-left: 45px;">
    <div class="title"><?php echo CHtml::activeCheckBox($recordLevelElement, 'isrestricted') . "&nbsp;&nbsp;" . Yii::t('yii', 'Check here to make this record private') . "&nbsp;&nbsp;"; ?></div>
    <div class="icon"><?php showIcon("Private Record", "ui-icon-locked", 0); ?></div>
</div>
</div>

