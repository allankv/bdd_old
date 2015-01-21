
<script>      
    $(document).ready(bootAutoSuggestionHierarchy)
    function bootAutoSuggestionHierarchy(){
        $("#select").buttonset();
    }
    function selectTaxon(idkingdom,idphylum,idclass,idorder,idfamily,idgenus,idsubgenus,idspecificepithet,idinfraspecificepithet,idscientificname,
    kingdom,phylum,class_,order,family,genus,subgenus,specificepithet,infraspecificepithet,scientificname){        
        $('#TaxonomicElementAR_idkingdom').val(idkingdom);
        $('#TaxonomicElementAR_idphylum').val(idphylum);
        $('#TaxonomicElementAR_idclass').val(idclass);
        $('#TaxonomicElementAR_idorder').val(idorder);
        $('#TaxonomicElementAR_idfamily').val(idfamily);
        $('#TaxonomicElementAR_idgenus').val(idgenus);
        $('#TaxonomicElementAR_idsubgenus').val(idsubgenus);
        $('#TaxonomicElementAR_idspecificepithet').val(idspecificepithet);
        $('#TaxonomicElementAR_idinfraspecificepithet').val(idinfraspecificepithet);
        $('#TaxonomicElementAR_idscientificname').val(idscientificname);        
        $('#KingdomAR_kingdom').val(kingdom);
        $('#PhylumAR_phylum').val(phylum);
        $('#ClassAR_class').val(class_);
        $('#OrderAR_order').val(order);
        $('#FamilyAR_family').val(family);
        $('#GenusAR_genus').val(genus);
        $('#SubgenusAR_subgenus').val(subgenus);
        $('#SpecificEpithetAR_specificepithet').val(specificepithet);
        $('#InfraspecificEpithetAR_infraspecificepithet').val(infraspecificepithet);
        $('#ScientificNameAR_scientificname').val(scientificname);
        $('#dialog').dialog('close');

        //Show tax tool tip - function inside specimen/maintain
        showTaxonomicTip(kingdom, phylum, class_, order, family, genus, subgenus, specificepithet, infraspecificepithet);
    }
</script>
<div class="table" style="width: 554px; background-color: #F4F4F4; margin-top:10px; margin-bottom:10px; -moz-border-radius-topleft: 1.0em; -moz-border-radius-topright: 1.0em; -moz-border-radius-bottomleft: 1.0em; -moz-border-radius-bottomright: 1.0em; border: 1px solid #ccc;">
    <div id="select">
        <div style="width: 554px; height: 80px;">
            <div>
                <?php echo CHtml::image("images/help/iconelist.png","",array("style"=>"padding-left: 30px; padding-top: 20px ; float: left;")); ?>
                <div style="padding-left: 30px; padding-top: 20px; float: left; color: #a35353; font-size: 18px; font-family: Verdana;">
                    <?php //echo Yii::t('yii', "Country \"").$term."\" does not exist.";?>
                </div>
            </div>
        </div>        
        <div style="padding-left: 30px; padding-top: 0px ; float: left; color: #535353; font-size: 16px; font-family: Verdana;">
            <?php echo Yii::t('yii', "Choose one hierarchy: ");?>
        </div>
        <table style="width: 90%; padding-bottom: 10px; border-top: 5px solid #CCCCCC; border-bottom: 5px solid #CCCCCC;" align="center" cellpadding="0" cellspacing="0">
            <?php foreach($list as $n=>$item): ?>
            <tr style="width:500px; height: 30px;">
                <td style="border-right: 1px solid #CCCCCC; padding-left: 10px; border-bottom: 1px solid #CCCCCC;">
                    <span style="padding-left: 0px;"><?php echo 
                            ($item['kingdom']!='null'?'<br/><b>Kingdom:</b> '.$item['kingdom']:'').
                                    ($item['phylum']!='null'?'<br/><b>Phylum:</b> '.$item['phylum']:'').
                                    ($item['class']!='null'?'<br/><b>Class:</b> '.$item['class']:'').
                                    ($item['order']!='null'?('<br/><b>Order:</b> '.$item['order']):'').
                                    ($item['family']!='null'?'<br/><b>Family:</b> '.$item['family']:'').
                                    ($item['genus']!='null'?'<br/><b>Genus:</b> '.$item['genus']:'').
                                    ($item['subgenus']!='null'?'<br/><b>Subgenus:</b> '.$item['subgenus']:'').
                                    ($item['specificepithet']!='null'?'<br/><b>Specific epithet:</b> '.$item['specificepithet']:'').
                                    ($item['infraspecificepithet']!='null'?'<br/><b>Infraspecific epithet:</b> '.$item['infraspecificepithet']:'').
                                    ($item['scientificname']!='null'?'<br/><b>Scientific name:</b> '.$item['scientificname']:'').'<br/>'
                            ; ?></span>
                </td>
                <td style="text-align: center; border-bottom: 1px solid #CCCCCC; width: 100px;" >                    
                    &nbsp;&nbsp;<input type="button" value="<?php echo Yii::t('yii', "Select");?>" onclick='selectTaxon(<?php echo '"'.($item['idkingdom']!='null'?$item['idkingdom']:'').' ",'.
                                '"'.($item['idphylum']!='null'?$item['idphylum']:'').'",'.
                                '"'.($item['idclass']!='null'?$item['idclass']:'').'",'.
                                '"'.($item['idorder']!='null'?$item['idorder']:'').'",'.
                                '"'.($item['idfamily']!='null'?$item['idfamily']:'').'",'.
                                '"'.($item['idgenus']!='null'?$item['idgenus']:'').'",'.
                                '"'.($item['idsubgenus']!='null'?$item['idsubgenus']:'').'",'.
                                '"'.($item['idspecificepithet']!='null'?$item['idspecificepithet']:'').'",'.
                                '"'.($item['idinfraspecificepithet']!='null'?$item['idinfraspecificepithet']:'').'",'.
                                '"'.($item['idscientificname']!='null'?$item['idscientificname']:'').'",'.
                                '"'.($item['kingdom']!='null'?$item['kingdom']:'').'",'.
                                '"'.($item['phylum']!='null'?$item['phylum']:'').'",'.
                                '"'.($item['class']!='null'?$item['class']:'').'",'.
                                '"'.($item['order']!='null'?$item['order']:'').'",'.
                                '"'.($item['family']!='null'?$item['family']:'').'",'.
                                '"'.($item['genus']!='null'?$item['genus']:'').'",'.
                                '"'.($item['subgenus']!='null'?$item['subgenus']:'').'",'.
                                '"'.($item['specificepithet']!='null'?$item['specificepithet']:'').'",'.
                                '"'.($item['infraspecificepithet']!='null'?$item['infraspecificepithet']:'').'",'.
                                                   '"'.($item['scientificname']!='null'?$item['scientificname']:'').'"';?>);' name="select" />
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>