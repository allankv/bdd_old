<script type="text/javascript">
    $(document).ready(bootTaxonomic);
    function bootTaxonomic(){
        // id, field, controller, bottao, list Html, list Javascript, acao de relacionamento NN (padrao), hidden do id target
        //configAutocompleteNN('#RecordedByOccurrenceAR_idrecordedby','#RecordedByOccurrenceAR_recordedby', 'recordedby', '#addRecordedByOccurrenceBtn', '#recordedByOccurrenceList',recordedByOccurrenceList,'OccurrenceElement','#SpecimenAR_idoccurrenceelement');
        //
        // id, field, controller
        //configAutocomplete('#OccurrenceElementAR_idbehavior','#BehaviorAR_behavior', 'behavior');
        configAutocomplete('#TaxonomicElementAR_idkingdom','#KingdomAR_kingdom', 'kingdom');
        configAutocomplete('#TaxonomicElementAR_idphylum','#PhylumAR_phylum', 'phylum');
        configAutocomplete('#TaxonomicElementAR_idclass','#ClassAR_class', 'class');
        configAutocomplete('#TaxonomicElementAR_idorder','#OrderAR_order', 'order');
        configAutocomplete('#TaxonomicElementAR_idfamily','#FamilyAR_family', 'family');
        configAutocomplete('#TaxonomicElementAR_idgenus','#GenusAR_genus', 'genus');
        configAutocomplete('#TaxonomicElementAR_idsubgenus','#SubgenusAR_subgenus', 'subgenus');
        configAutocomplete('#TaxonomicElementAR_idspecificepithet','#SpecificEpithetAR_specificepithet', 'specificepithet');
        configAutocomplete('#TaxonomicElementAR_idinfraspecificepithet','#InfraspecificEpithetAR_infraspecificepithet', 'infraspecificepithet');
        configAutoSuggestionHierarchy('#btnAutoSuggestionHierarchy','#btnCleanHierarchy');

        //Autocomplete icons
        var btnAutocomplete ="<div class='btnAutocomplete' style='width: 20px;'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-comment'></span></li></ul></div>";

        $('#autocompleteKingdom').append('<a href="javascript:suggest(\'#TaxonomicElementAR_idkingdom\',\'#KingdomAR_kingdom\', \'kingdom\');">'+btnAutocomplete+'</a>');
        $('#autocompletePhylum').append('<a href="javascript:suggest(\'#TaxonomicElementAR_idphylum\',\'#PhylumAR_phylum\', \'phylum\');">'+btnAutocomplete+'</a>');
        $('#autocompleteClass').append('<a href="javascript:suggest(\'#TaxonomicElementAR_idclass\',\'#ClassAR_class\', \'class\');">'+btnAutocomplete+'</a>');
        $('#autocompleteOrder').append('<a href="javascript:suggest(\'#TaxonomicElementAR_idorder\',\'#OrderAR_order\', \'order\');">'+btnAutocomplete+'</a>');
        $('#autocompleteFamily').append('<a href="javascript:suggest(\'#TaxonomicElementAR_idfamily\',\'#FamilyAR_family\', \'family\');">'+btnAutocomplete+'</a>');
        $('#autocompleteGenus').append('<a href="javascript:suggest(\'#TaxonomicElementAR_idgenus\',\'#GenusAR_genus\', \'genus\');">'+btnAutocomplete+'</a>');
        $('#autocompleteSubgenus').append('<a href="javascript:suggest(\'#TaxonomicElementAR_idsubgenus\',\'#SubgenusAR_subgenus\', \'subgenus\');">'+btnAutocomplete+'</a>');
        $('#autocompleteSpecificEpithet').append('<a href="javascript:suggest(\'#TaxonomicElementAR_idspecificepithet\',\'#SpecificEpithetAR_specificepithet\', \'specificepithet\');">'+btnAutocomplete+'</a>');
        $('#autocompleteInfraspecificEpithet').append('<a href="javascript:suggest(\'#TaxonomicElementAR_idinfraspecificepithet\',\'#InfraspecificEpithetAR_infraspecificepithet\', \'infraspecificepithet\');">'+btnAutocomplete+'</a>');
        

    }
    function configAutoSuggestionHierarchy(_btnSug, _btnClean){
        $(_btnSug).button();
        $(_btnClean).button();
        $(_btnClean).click(function(){
            $('#TaxonomicElementAR_idkingdom').val('');
            $('#TaxonomicElementAR_idphylum').val('');
            $('#TaxonomicElementAR_idclass').val('');
            $('#TaxonomicElementAR_idorder').val('');
            $('#TaxonomicElementAR_idfamily').val('');
            $('#TaxonomicElementAR_idgenus').val('');
            $('#TaxonomicElementAR_idsubgenus').val('');
            $('#TaxonomicElementAR_idspecificepithet').val('');
            $('#TaxonomicElementAR_idinfraspecificepithet').val('');
            $('#TaxonomicElementAR_idscientificname').val('');
            $('#KingdomAR_kingdom').val('');
            $('#PhylumAR_phylum').val('');
            $('#ClassAR_class').val('');
            $('#OrderAR_order').val('');
            $('#FamilyAR_family').val('');
            $('#GenusAR_genus').val('');
            $('#SubgenusAR_subgenus').val('');
            $('#SpecificEpithetAR_specificepithet').val('');
            $('#InfraspecificEpithetAR_infraspecificepithet').val('');
            $('#ScientificNameAR_scientificname').val('');

            //Hide taxonomic tip
            $('#taxTip').poshytip('hide').poshytip('destroy').replaceWith('');
        });
        $(_btnSug).click(function(){
            $.ajax({
                type:'POST',
                data: $("#form").serialize(),
                dataType: "json",
                url: 'index.php?r=taxonomicelement/autosuggestionhierarchy',
                success: function(json){
                    if(json.list.length==0){
                        $('#dialog').dialog('destroy');
                        $('#dialog').dialog().remove();
                        $('#dialog').remove();
                        $('<div id="dialog" title="Taxonomic hierarchy does not exist">Taxonomic hierarchy does not exist</div>').dialog({
                            show: "slide",
                            hide: "slide",
                            buttons: {
                                Ok: function() {
                                    $('#dialog').dialog( "close" );
                                }
                            }
                        });
                    }else if(json.list.length==1){
                        $('#TaxonomicElementAR_idkingdom').val(json.list[0].idkingdom);
                        $('#TaxonomicElementAR_idphylum').val(json.list[0].idphylum);
                        $('#TaxonomicElementAR_idclass').val(json.list[0].idclass);
                        $('#TaxonomicElementAR_idorder').val(json.list[0].idorder);
                        $('#TaxonomicElementAR_idfamily').val(json.list[0].idfamily);
                        $('#TaxonomicElementAR_idgenus').val(json.list[0].idgenus);
                        $('#TaxonomicElementAR_idsubgenus').val(json.list[0].idsubgenus);
                        $('#TaxonomicElementAR_idspecificepithet').val(json.list[0].idspecificepithet);
                        $('#TaxonomicElementAR_idinfraspecificepithet').val(json.list[0].idinfraspecificepithet);
                        $('#TaxonomicElementAR_idscientificname').val(json.list[0].idscientificname);
                        $('#KingdomAR_kingdom').val(json.list[0].kingdom);
                        $('#PhylumAR_phylum').val(json.list[0].phylum);
                        $('#ClassAR_class').val(json.list[0].class_);
                        $('#OrderAR_order').val(json.list[0].order);
                        $('#FamilyAR_family').val(json.list[0].family);
                        $('#GenusAR_genus').val(json.list[0].genus);
                        $('#SubgenusAR_subgenus').val(json.list[0].subgenus);
                        $('#SpecificEpithetAR_specificepithet').val(json.list[0].specificepithet);
                        $('#InfraspecificEpithetAR_infraspecificepithet').val(json.list[0].infraspecificepithet);
                        $('#ScientificNameAR_scientificname').val(json.list[0].scientificname);

                        //Show taxonomic tooltip - function found in specimen/maintain
                        showTaxonomicTip(json.list[0].kingdom, json.list[0].phylum, json.list[0].class_, json.list[0].order, json.list[0].family, json.list[0].genus, json.list[0].subgenus, json.list[0].specificepithet, json.list[0].infraspecificepithet);
                    }else{
                        $('#dialog').dialog('destroy');
                        $('#dialog').dialog().remove();
                        $('#dialog').remove();
                        $('<div id="dialog"/>').load('index.php?r=taxonomicelement/nsuggestionhierarchy', {
                            "list": json.list
                        }).dialog({
                            modal:true,
                            title: 'Taxonomic inconsistency.',
                            show:'fade',
                            hide:'fade',
                            width: 600,
                            height:600,
                            buttons: {
                                'Cancel': function(){
                                    $(this).dialog('close');
                                }
                            },
                            open: function(){
                                $(".ui-dialog-titlebar-close").hide();
                                dialog=true;
                            },
                            close: function(){
                                opened = false;
                                dialog = false;
                            }
                        });
                    }                    
                }
            });
        })

    }
</script>
<div class="subgroup"><?php echo Yii::t('yii','Taxa'); ?></div>

<?php echo CHtml::activeHiddenField($taxonomicElement,'idtaxonomicelement');?>
<?php echo CHtml::activeHiddenField($taxonomicElement,'idtaxonrank');?>
<?php echo CHtml::activeHiddenField($taxonomicElement,'idscientificnameauthorship');?>
<?php echo CHtml::activeHiddenField($taxonomicElement,'idnomenclaturalcode');?>
<?php echo CHtml::activeHiddenField($taxonomicElement,'idacceptednameusage');?>
<?php echo CHtml::activeHiddenField($taxonomicElement,'idparentnameusage');?>
<?php echo CHtml::activeHiddenField($taxonomicElement,'idoriginalnameusage');?>
<?php echo CHtml::activeHiddenField($taxonomicElement,'idnameaccordingto');?>
<?php echo CHtml::activeHiddenField($taxonomicElement,'idnamepublishedin');?>
<?php echo CHtml::activeHiddenField($taxonomicElement,'idtaxonconcept');?>
<?php echo CHtml::activeHiddenField($taxonomicElement,'idtaxonomicstatus');?>

<div style="display: none;" class="boxclean" id="divLimparTaxonomicElements"  >
    <a href="javascript:limparCamposTaxonomicElements()" >
        <?php echo CHtml::image("images/main/eraser.jpg", "",array("style"=>"border:0px;")); ?>&nbsp;
        <?php echo Yii::t('yii','Clean suggested items'); ?>
    </a>
</div>

<table cellspacing="0" cellpadding="0" align="center" class="normalFieldsTable">
    <div class="tablerow" id='divbutton'>
        <tr>
            <td class="tablelabelcel">
                <?php echo ' ';?>
            </td>
            <td class="tablemiddlecel">
                <?php echo ' ';?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <input type="button" value="Clean Hierarchy" id="btnCleanHierarchy">
                </div>
            </td>
        </tr>
    </div>
    <div class="tablerow" id='divkingdom'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel(KingdomAR::model(), 'kingdom');?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=kingdom',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($taxonomicElement,'idkingdom');?>
                    <?php echo CHtml::activeTextField($taxonomicElement->kingdom, 'kingdom', array('class'=>'textfield'));?>
                </div>
            </td>
            <td class="acIcon" id="autocompleteKingdom"></td>
        </tr>
    </div>
    <div class="tablerow" id='divphylum'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel(PhylumAR::model(), "phylum");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=phylum',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($taxonomicElement,'idphylum');?>
                    <?php echo CHtml::activeTextField($taxonomicElement->phylum, 'phylum', array('class'=>'textfield'));?>
                </div>
            </td>
            <td class="acIcon" id="autocompletePhylum">
            </td>
        </tr>
    </div>
    <div class="tablerow" id='divclass'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel(ClassAR::model(), "class");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=class',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($taxonomicElement,'idclass');?>
                    <?php echo CHtml::activeTextField($taxonomicElement->class, 'class', array('class'=>'textfield'));?>
                </div>
            </td>
            <td class="acIcon" id="autocompleteClass">
            </td>
        </tr>
    </div>
    <div class="tablerow" id='divorder'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel(OrderAR::model(), "order");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=order',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($taxonomicElement,'idorder');?>
                    <?php echo CHtml::activeTextField($taxonomicElement->order, 'order', array('class'=>'textfield'));?>
                </div>
            </td>
            <td class="acIcon" id="autocompleteOrder">
            </td>
        </tr>
    </div>
    <div class="tablerow" id='divfamily'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel(FamilyAR::model(), "family");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=family',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($taxonomicElement,'idfamily');?>
                    <?php echo CHtml::activeTextField($taxonomicElement->family, 'family', array('class'=>'textfield'));?>
                </div>
            </td>
            <td class="acIcon" id="autocompleteFamily">
            </td>
        </tr>
    </div>
    <div class="tablerow" id='divgenus'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel(GenusAR::model(), "genus");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=genus',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($taxonomicElement,'idgenus');?>
                    <?php echo CHtml::activeTextField($taxonomicElement->genus, 'genus', array('class'=>'textfield'));?>
                </div>
            </td>
            <td class="acIcon" id="autocompleteGenus">
            </td>
        </tr>
    </div>
    <div class="tablerow" id='divsubgenus'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel(SubgenusAR::model(), "subgenus");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=subgenus',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($taxonomicElement,'idsubgenus');?>
                    <?php echo CHtml::activeTextField($taxonomicElement->subgenus, 'subgenus', array('class'=>'textfield'));?>
                </div>
            </td>
            <td class="acIcon" id="autocompleteSubgenus">
            </td>
        </tr>
    </div>
    <div class="tablerow" id='divspecificepithet'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel(SpecificEpithetAR::model(), "specificepithet");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=specificepithet',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($taxonomicElement,'idspecificepithet');?>
                    <?php echo CHtml::activeTextField($taxonomicElement->specificepithet, 'specificepithet', array('class'=>'textfield'));?>
                </div>
            </td>
            <td class="acIcon" id="autocompleteSpecificEpithet">
            </td>
        </tr>
    </div>
    <div class="tablerow" id='divinfraspecificepithet'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel(InfraspecificEpithetAR::model(), "infraspecificepithet");?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=infraspecificepithet',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($taxonomicElement,'idinfraspecificepithet');?>
                    <?php echo CHtml::activeTextField($taxonomicElement->infraspecificepithet, 'infraspecificepithet', array('class'=>'textfield'));?>
                </div>
            </td>
            <td class="acIcon" id="autocompleteInfraspecificEpithet">
            </td>
        </tr>
    </div>
</table>