<?php
$cs=Yii::app()->clientScript;
//$cs->registerScriptFile("js/lightbox/taxonomicelements.js",CClientScript::POS_HEAD);
$cs->registerScriptFile("js/validation/validationdata.js",CClientScript::POS_HEAD);
$cs->registerScriptFile("js/validation/jquery.numeric.pack.js",CClientScript::POS_HEAD);
//$cs->registerScriptFile("js/lightbox/lightbox.js",CClientScript::POS_HEAD);
//$cs->registerCssFile("css/lightbox.css");
?>
<script>
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
        configAutocomplete('#TaxonomicElementAR_idtribe','#TribeAR_tribe', 'tribe');
        configAutocomplete('#TaxonomicElementAR_idsubtribe','#SubtribeAR_subtribe', 'subtribe');
        configAutocomplete('#TaxonomicElementAR_idspeciesname','#SpeciesNameAR_speciesname', 'speciesname');
        configAutocomplete('#TaxonomicElementAR_idsubspecies','#SubspeciesAR_subspecies', 'subspecies');


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
        
        $('#autocompleteTribe').append('<a href="javascript:suggest(\'#TaxonomicElementAR_idtribe\',\'#TribeAR_tribe\', \'tribe\');">'+btnAutocomplete+'</a>');
        $('#autocompleteSubtribe').append('<a href="javascript:suggest(\'#TaxonomicElementAR_idsubtribe\',\'#SubtribeAR_subtribe\', \'subtribe\');">'+btnAutocomplete+'</a>');
        $('#autocompleteSpeciesName').append('<a href="javascript:suggest(\'#TaxonomicElementAR_idspeciesname\',\'#SpeciesNameAR_speciesname\', \'speciesname\');">'+btnAutocomplete+'</a>');
        $('#autocompleteSubspecies').append('<a href="javascript:suggest(\'#TaxonomicElementAR_idsubspecies\',\'#SubspeciesAR_subspecies\', \'subspecies\');">'+btnAutocomplete+'</a>');
        

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
