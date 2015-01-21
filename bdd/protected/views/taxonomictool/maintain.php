<?php include_once("protected/extensions/config.php"); ?>
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="js/jquery.color.js"></script>

<script>
    $(document).ready(bootTaxonomic);
    function bootTaxonomic() {   	
        configAutocomplete('#TaxonomicElementAR_idkingdom','#KingdomAR_kingdom', 'kingdom');
        configAutocomplete('#TaxonomicElementAR_idphylum','#PhylumAR_phylum', 'phylum');
        configAutocomplete('#TaxonomicElementAR_idclass','#ClassAR_class', 'class');
        configAutocomplete('#TaxonomicElementAR_idorder','#OrderAR_order', 'order');
        configAutocomplete('#TaxonomicElementAR_idfamily','#FamilyAR_family', 'family');
        configAutocomplete('#TaxonomicElementAR_idgenus','#GenusAR_genus', 'genus');
        configAutocomplete('#TaxonomicElementAR_idsubgenus','#SubgenusAR_subgenus', 'subgenus');
        configAutocomplete('#TaxonomicElementAR_idspecificepithet','#SpecificEpithetAR_specificepithet', 'specificepithet');
        configAutocomplete('#TaxonomicElementAR_idinfraspecificepithet','#InfraspecificEpithetAR_infraspecificepithet', 'infraspecificepithet');
        configAutocomplete('#TaxonomicElementAR_idtaxonrank','#TaxonRankAR_taxonrank', 'taxonrank');
        configAutocomplete('#TaxonomicElementAR_idscientificnameauthorship','#ScientificNameAuthorshipAR_scientificnameauthorship', 'scientificnameauthorship');
        configAutocomplete('#TaxonomicElementAR_idnomenclaturalcode','#NomenclaturalCodeAR_nomenclaturalcode', 'nomenclaturalcode');
        configAutocomplete('#TaxonomicElementAR_idtaxonconcept','#TaxonConceptAR_taxonconcept', 'taxonconcept');
        configAutocomplete('#TaxonomicElementAR_idacceptednameusage','#AcceptedNameUsageAR_acceptednameusage', 'acceptednameusage');
        configAutocomplete('#TaxonomicElementAR_idparentnameusage','#ParentNameUsageAR_parentnameusage', 'parentnameusage');
        configAutocomplete('#TaxonomicElementAR_idoriginalnameusage','#OriginalNameUsageAR_originalnameusage', 'originalnameusage');
        configAutocomplete('#TaxonomicElementAR_idnameaccordingto','#NameAccordingToAR_nameaccordingto', 'nameaccordingto');
        configAutocomplete('#TaxonomicElementAR_idnamepublishedin','#NamePublishedInAR_namepublishedin', 'namepublishedin');
        configAutocomplete('#TaxonomicElementAR_idscientificname','#ScientificNameAR_scientificname', 'scientificname');
        
        var btnAutocomplete ="<div class='btnAutocomplete' style='width: 20px;'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-comment'></span></li></ul></div>";
        
        $('#autocompleteScientificName').append('<a href="javascript:suggest(\'#TaxonomicElementAR_idscientificname\',\'#ScientificNameAR_scientificname\', \'scientificname\');">'+btnAutocomplete+'</a>');
        $('#autocompleteKingdom').html('<a href="javascript:suggest(\'#TaxonomicElementAR_idkingdom\',\'#KingdomAR_kingdom\', \'kingdom\');">'+btnAutocomplete+'</a>');
        $('#autocompletePhylum').html('<a href="javascript:suggest(\'#TaxonomicElementAR_idphylum\',\'#PhylumAR_phylum\', \'phylum\');">'+btnAutocomplete+'</a>');
        $('#autocompleteClass').html('<a href="javascript:suggest(\'#TaxonomicElementAR_idclass\',\'#ClassAR_class\', \'class\');">'+btnAutocomplete+'</a>');
        $('#autocompleteOrder').html('<a href="javascript:suggest(\'#TaxonomicElementAR_idorder\',\'#OrderAR_order\', \'order\');">'+btnAutocomplete+'</a>');
        $('#autocompleteFamily').html('<a href="javascript:suggest(\'#TaxonomicElementAR_idfamily\',\'#FamilyAR_family\', \'family\');">'+btnAutocomplete+'</a>');
        $('#autocompleteGenus').html('<a href="javascript:suggest(\'#TaxonomicElementAR_idgenus\',\'#GenusAR_genus\', \'genus\');">'+btnAutocomplete+'</a>');
        $('#autocompleteSubgenus').html('<a href="javascript:suggest(\'#TaxonomicElementAR_idsubgenus\',\'#SubgenusAR_subgenus\', \'subgenus\');">'+btnAutocomplete+'</a>');
        $('#autocompleteSpecificEpithet').html('<a href="javascript:suggest(\'#TaxonomicElementAR_idspecificepithet\',\'#SpecificEpithetAR_specificepithet\', \'specificepithet\');">'+btnAutocomplete+'</a>');
        $('#autocompleteInfraspecificEpithet').html('<a href="javascript:suggest(\'#TaxonomicElementAR_idinfraspecificepithet\',\'#InfraspecificEpithetAR_infraspecificepithet\', \'infraspecificepithet\');">'+btnAutocomplete+'</a>');
        $('#autocompleteTaxonRank').html('<a href="javascript:suggest(\'#TaxonomicElementAR_idtaxonrank\',\'#TaxonRankAR_taxonrank\', \'taxonrank\');">'+btnAutocomplete+'</a>');
        $('#autocompleteScientificNameAuthorship').html('<a href="javascript:suggest(\'#TaxonomicElementAR_idscientificnameauthorship\',\'#ScientificNameAuthorshipAR_scientificnameauthorship\', \'scientificnameauthorship\');">'+btnAutocomplete+'</a>');
        $('#autocompleteNomenclaturalCode').html('<a href="javascript:suggest(\'#TaxonomicElementAR_idnomenclaturalcode\',\'#NomenclaturalCodeAR_nomenclaturalcode\', \'nomenclaturalcode\');">'+btnAutocomplete+'</a>');
        $('#autocompleteTaxonConcept').html('<a href="javascript:suggest(\'#TaxonomicElementAR_idtaxonconcept\',\'#TaxonConceptAR_taxonconcept\', \'taxonconcept\');">'+btnAutocomplete+'</a>');
        $('#autocompleteAcceptedNameUsage').html('<a href="javascript:suggest(\'#TaxonomicElementAR_idacceptednameusage\',\'#AcceptedNameUsageAR_acceptednameusage\', \'acceptednameusage\');">'+btnAutocomplete+'</a>');
        $('#autocompleteParentNameUsage').html('<a href="javascript:suggest(\'#TaxonomicElementAR_idparentnameusage\',\'#ParentNameUsageAR_parentnameusage\', \'parentnameusage\');">'+btnAutocomplete+'</a>');
        $('#autocompleteOriginalNameUsage').html('<a href="javascript:suggest(\'#TaxonomicElementAR_idoriginalnameusage\',\'#OriginalNameUsageAR_originalnameusage\', \'originalnameusage\');">'+btnAutocomplete+'</a>');
        $('#autocompleteNameAccordingTo').html('<a href="javascript:suggest(\'#TaxonomicElementAR_idnameaccordingto\',\'#NameAccordingToAR_nameaccordingto\', \'nameaccordingto\');">'+btnAutocomplete+'</a>');
        $('#autocompleteNamePublishedIn').html('<a href="javascript:suggest(\'#TaxonomicElementAR_idnamepublishedin\',\'#NamePublishedInAR_namepublishedin\', \'namepublishedin\');">'+btnAutocomplete+'</a>');
        
        $('#loadingNameStep').hide();
        $('#loadingHierarchyStep').hide();
        $('#suggestionNameStep').hide();
        
        configSlider();
                
        configIcons();
    			        
        configTaxonNavigation();
        
        configMorphospecies();
        
	}


    function configTaxonNavigation() {	
        $('.taxonTitle:not(:eq(0)), .taxonStepTitle:not(:eq(0))').addClass('taxonUnselected');
        $('.taxonTitle:not(:eq(0)) .title, .taxonStepTitle:not(:eq(0)) .title').hide();
        $('.taxonStepTitle:not(:eq(0)) .taxonIcon').hide();	
        $('.taxonStepContents:not(:eq(0))').hide();
		
        if ($('#SpecimenAR_idspecimen').val()) {
            selectTaxonForm();
        }
        else {
            selectTaxonTool();
        }
		
        $('.taxonTitle:eq(0)').click(function () {
            selectTaxonTool();
        });
		
        $('.taxonTitle:eq(1)').click(function () {
            selectTaxonForm();
        });
	
        $('.taxonTitle .abbr, .taxonStepTitle .number').hover(
        function () {
            if ($(this).parent().hasClass('taxonUnselected')) {
                $('.title', $(this).parent()).show();
            }
        }, 
        function () {
            if ($(this).parent().hasClass('taxonUnselected')) {
                $('.title', $(this).parent()).hide();
            }			
        });		
    }
	
    function selectTaxonTool() {
        $('.taxonTitle:eq(1)').addClass('taxonUnselected');
        $('.taxonTitle:eq(0)').removeClass('taxonUnselected');
        $('.taxonTitle:not(:eq(0)) .title').hide();
        $('.taxonTitle:eq(0) .title').show();		
        $('.taxonContents:eq(1)').hide();
        $('.taxonContents:eq(0)').show();
    }
	
    function selectTaxonForm() {
        $('.taxonTitle:eq(0)').addClass('taxonUnselected');
        $('.taxonTitle:eq(1)').removeClass('taxonUnselected');
        $('.taxonTitle:not(:eq(1)) .title').hide();
        $('.taxonTitle:eq(1) .title').show();			
        $('.taxonContents:eq(0)').hide();
        $('.taxonContents:eq(1)').show();
    }
	
    function stepTaxon(from, to, type) {	
        stepLayoutTaxon(from, to);
    }
	
    function stepLayoutTaxon(from, to) {
        $('.taxonStepTitle:eq('+from+')').addClass('taxonUnselected');
        $('.taxonStepTitle:eq('+from+') .title').hide();
        $('.taxonStepTitle:eq('+from+') .taxonIcon').hide();
			
        $('.taxonStepTitle:eq('+to+')').removeClass('taxonUnselected');
        $('.taxonStepTitle:eq('+to+') .title').show();
        $('.taxonStepTitle:eq('+to+') .taxonIcon').show();
		
        $('.taxonStepContents:eq('+from+')').hide();
        $('.taxonStepContents:eq('+to+')').show();
    }
	
    function resetTaxon() {
        $('#loadingNameStep').hide();
        $('#loadingHierarchyStep').hide();
        $('#suggestionNameStep').hide();
        $('#taxonNameStep').show();
    }
        
    function configSlider(){
        var vI = $( "#TaxonomicElementAR_uncertainty" ).val()==''?50:$( "#TaxonomicElementAR_uncertainty" ).val();
        $( "#uncertaintyslider" ).slider({
            range: "min",
            value: vI,
            min: 0,
            max: 100,
            create: function( event, ui ){
                uncertaintyname(vI);
            },
            slide: function( event, ui ) {
                $( "#TaxonomicElementAR_uncertainty" ).val( ui.value );
                uncertaintyname(ui.value);
            }
        });
    }
    
    function uncertaintyname( value){
        if(value < 20){
            $( "#uncertaintydesc" ).html(' Very low');
        }
        else if(value >= 20 && value < 40){
            $( "#uncertaintydesc" ).html(' Low');
        }
        else if(value >= 40 && value < 60){
            $( "#uncertaintydesc" ).html(' Medium');
        }
        else if(value >= 60 && value < 80){
            $( "#uncertaintydesc" ).html(' High');
        }
        else if(value >= 80 && value <=100){
            $( "#uncertaintydesc" ).html(' Very high');
        }
    }
    
    function configMorphospecies() {
	    if ($("#MorphospeciesAR_morphospecies").val() != '') $("#morphospeciesrow").show();
    }
    
</script>

<!-- div necessária para as animações aparecerem -->
<div style="height:80px;"></div>

<div class="taxonTitle" style="margin-left:45px;"><span class="abbr">BTT</span><span class="title">BDD Taxonomic Tool</span></div>
<div class="taxonTitle"><span class="abbr">Form</span><span class="title">Taxonomic Data</span></div>
<div style="clear:both;"></div>

<div class="taxonContents"><!--
<<<<<<< .mine
	<div class="taxonStepTitle" style="margin-left:45px;">
		<div class="number">1</div>
		<div class="title">Validate taxon name</div>
		<div onclick="resetTaxon();" class="taxonIcon" style="margin-right: 5px;"><?php showIcon("Reset", "ui-icon-closethick", 1);?></div>
		<div style="clear:both;"></div>
	</div>	
	<div class="taxonStepTitle">
		<div class="number">2</div>
		<div class="title">Validate taxon hierarchy</div>
		<div onclick="selectTaxonForm();" class="taxonIcon" style="margin-right: 5px;">
			<?php showIcon("Next", "ui-icon-arrowthick-1-e", 1);?>
		</div>
		<div onclick="stepTaxon(1,0)" class="taxonIcon">
			<?php showIcon("Back", "ui-icon-arrowthick-1-w", 1); ?>
		</div>
		<div style="clear:both;"></div>
	</div>	
	
	<div style="clear:both;"></div>
	
	<div class="taxonStepContents">
		<div class="mainFieldsTable" id="taxonNameStep">
			<div class="sub">
			<div id="taxonNameLeft">Taxon name</div>
			<div id="taxonNameMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=taxonname',array('rel'=>'lightbox'));?></div>
			<div id="taxonNameRight"><input type="text" class="textboxtext" id="taxon_name" /></div>
			</div>
		</div>
		<div class="mainFieldsTable" id="loadingNameStep">
			<img style="width: 30px; margin-bottom: 7px;" src="images/main/ajax-loader2.gif" /><br /><b>Validating taxon name...</b>
		</div>
		<div class="mainFieldsTable" id="suggestionNameStep">
		</div>		
	</div>
	<div class="taxonStepContents">
		<div class="mainFieldsTable" id="loadingHierarchyStep">
			<img style="width: 30px; margin-bottom: 7px;" src="images/main/ajax-loader2.gif" /><br /><b>Validating taxon hierarchy...</b>
		</div>
		<div class="mainFieldsTable" id="suggestionHierarchyStep">
		</div>
		<div class="mainFieldsTable" id="newHierarchyStep">
			<div class="newHierarchyLeft">Kingdom</div> 
			<div class="newHierarchyMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=kingdom',array('rel'=>'lightbox'));?></div>
			<div class="newHierarchyRight"><input type="text" id="new_h_kingdom" style="width: 198px;"/></div>
			<div style="clear:both;"></div>
			
			<div class="newHierarchyLeft">Phylum</div> 
			<div class="newHierarchyMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=phylum',array('rel'=>'lightbox'));?></div>
			<div class="newHierarchyRight"><input type="text" id="new_h_phylum" style="width: 198px;"/></div>
			<div style="clear:both;"></div>
			
			<div class="newHierarchyLeft">Class</div> 
			<div class="newHierarchyMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=class',array('rel'=>'lightbox'));?></div>
			<div class="newHierarchyRight"><input type="text" id="new_h_class" style="width: 198px;"/></div>
			<div style="clear:both;"></div>
			
			<div class="newHierarchyLeft">Order</div> 
			<div class="newHierarchyMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=order',array('rel'=>'lightbox'));?></div>
			<div class="newHierarchyRight"><input type="text" id="new_h_order" style="width: 198px;"/></div>
			<div style="clear:both;"></div>
			
			<div class="newHierarchyLeft">Family</div> 
			<div class="newHierarchyMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=family',array('rel'=>'lightbox'));?></div>
			<div class="newHierarchyRight"><input type="text" id="new_h_family" style="width: 198px;"/></div>
			<div style="clear:both;"></div>
			
			<div class="newHierarchyLeft">Genus</div> 
			<div class="newHierarchyMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=genus',array('rel'=>'lightbox'));?></div>
			<div class="newHierarchyRight"><input type="text" id="new_h_genus" style="width: 198px;"/></div>
			<div style="clear:both;"></div>
			
			<div class="newHierarchyLeft">Subgenus</div> 
			<div class="newHierarchyMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=subgenus',array('rel'=>'lightbox'));?></div>
			<div class="newHierarchyRight"><input type="text" id="new_h_subgenus" style="width: 198px;"/></div>
			<div style="clear:both;"></div>
			
			<div class="newHierarchyLeft">Specific epithet</div> 
			<div class="newHierarchyMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=specificepithet',array('rel'=>'lightbox'));?></div>
			<div class="newHierarchyRight"><input type="text" id="new_h_specificepithet" style="width: 198px;"/></div>
			<div style="clear:both;"></div>
			
			<div class="newHierarchyLeft">Infraspecific epithet</div> 
			<div class="newHierarchyMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=infraspecificepithet',array('rel'=>'lightbox'));?></div>
			<div class="newHierarchyRight"><input type="text" id="new_h_infraspecificepithet" style="width: 198px;"/></div>
			<div style="clear:both;"></div>
			
			<div class="newHierarchyLeft">Scientific name</div> 
			<div class="newHierarchyMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=scientificname',array('rel'=>'lightbox'));?></div>
			<div class="newHierarchyRight"><input type="text" id="new_h_scientificname" style="width: 198px;"/></div>
			<div style="clear:both;"></div>
=======-->
    <div class="taxonStepTitle" style="margin-left:45px;">
        <div class="number">1</div>
        <div class="title">Validate taxon name</div>
        <div onclick="resetTaxon();" class="taxonIcon" style="margin-right: 5px;"><?php showIcon("Reset", "ui-icon-closethick", 1); ?></div>
        <div style="clear:both;"></div>
    </div>	
    <div class="taxonStepTitle">
        <div class="number">2</div>
        <div class="title">Validate taxon hierarchy</div>
        <div onclick="selectTaxonForm();" class="taxonIcon" style="margin-right: 5px;"><?php showIcon("Next", "ui-icon-arrowthick-1-e", 1); ?></div><div onclick="stepTaxon(1,0)" class="taxonIcon"><?php showIcon("Back", "ui-icon-arrowthick-1-w", 1); ?></div>
        <div style="clear:both;"></div>
    </div>	
    <div style="clear:both;"></div>


    <div class="taxonStepContents">
        <div class="mainFieldsTable" id="taxonNameStep">
            <div class="sub">
                <div id="taxonNameLeft">Taxon name</div>
                <div id="taxonNameMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=taxonname', array('rel' => 'lightbox')); ?></div>
                <div id="taxonNameRight"><input type="text" class="textboxtext" id="taxon_name" /></div>
            </div>
        </div>
        <div class="mainFieldsTable" id="loadingNameStep">
            <img style="width: 30px; margin-bottom: 7px;" src="images/main/ajax-loader2.gif" /><br /><b>Validating taxon name...</b>
        </div>
        <div class="mainFieldsTable" id="suggestionNameStep">
        </div>		
    </div>
    <div class="taxonStepContents">
        <div class="mainFieldsTable" id="loadingHierarchyStep">
            <img style="width: 30px; margin-bottom: 7px;" src="images/main/ajax-loader2.gif" /><br /><b>Validating taxon hierarchy...</b>
        </div>
        <div class="mainFieldsTable" id="suggestionHierarchyStep">
        </div>
        <div class="mainFieldsTable" id="newHierarchyStep">
            <div class="newHierarchyLeft">Kingdom</div> 
            <div class="newHierarchyMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=kingdom', array('rel' => 'lightbox')); ?></div>
            <div class="newHierarchyRight"><input type="text" id="new_h_kingdom" style="width: 198px;"/></div>
            <div style="clear:both;"></div>

            <div class="newHierarchyLeft">Phylum</div> 
            <div class="newHierarchyMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=phylum', array('rel' => 'lightbox')); ?></div>
            <div class="newHierarchyRight"><input type="text" id="new_h_phylum" style="width: 198px;"/></div>
            <div style="clear:both;"></div>

            <div class="newHierarchyLeft">Class</div> 
            <div class="newHierarchyMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=class', array('rel' => 'lightbox')); ?></div>
            <div class="newHierarchyRight"><input type="text" id="new_h_class" style="width: 198px;"/></div>
            <div style="clear:both;"></div>

            <div class="newHierarchyLeft">Order</div> 
            <div class="newHierarchyMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=order', array('rel' => 'lightbox')); ?></div>
            <div class="newHierarchyRight"><input type="text" id="new_h_order" style="width: 198px;"/></div>
            <div style="clear:both;"></div>

            <div class="newHierarchyLeft">Family</div> 
            <div class="newHierarchyMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=family', array('rel' => 'lightbox')); ?></div>
            <div class="newHierarchyRight"><input type="text" id="new_h_family" style="width: 198px;"/></div>
            <div style="clear:both;"></div>

            <div class="newHierarchyLeft">Genus</div> 
            <div class="newHierarchyMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=genus', array('rel' => 'lightbox')); ?></div>
            <div class="newHierarchyRight"><input type="text" id="new_h_genus" style="width: 198px;"/></div>
            <div style="clear:both;"></div>

            <div class="newHierarchyLeft">Subgenus</div> 
            <div class="newHierarchyMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=subgenus', array('rel' => 'lightbox')); ?></div>
            <div class="newHierarchyRight"><input type="text" id="new_h_subgenus" style="width: 198px;"/></div>
            <div style="clear:both;"></div>

            <div class="newHierarchyLeft">Specific epithet</div> 
            <div class="newHierarchyMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=specificepithet', array('rel' => 'lightbox')); ?></div>
            <div class="newHierarchyRight"><input type="text" id="new_h_specificepithet" style="width: 198px;"/></div>
            <div style="clear:both;"></div>

            <div class="newHierarchyLeft">Infraspecific epithet</div> 
            <div class="newHierarchyMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=infraspecificepithet', array('rel' => 'lightbox')); ?></div>
            <div class="newHierarchyRight"><input type="text" id="new_h_infraspecificepithet" style="width: 198px;"/></div>
            <div style="clear:both;"></div>

            <div class="newHierarchyLeft">Scientific name</div> 
            <div class="newHierarchyMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=scientificname', array('rel' => 'lightbox')); ?></div>
            <div class="newHierarchyRight"><input type="text" id="new_h_scientificname" style="width: 198px;"/></div>
            <div style="clear:both;"></div>

            <div style="margin-top: 10px;"><input type="button" value="Create New Hierarchy" onclick="actionCreateHierarchy();" style="width:200px;"/></div>
        </div>		
    </div>
</div>

<div class="taxonContents">
    <div class="overflow">
        <table cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
        <!--<tr>
            <td class="tablelabelcel">
            <?php //echo ' ';?>
            </td>
            <td class="tablemiddlecel">
            <?php //echo ' ';?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <input type="button" value="Clean Hierarchy" id="btnCleanHierarchy">
                </div>
            </td>
            <td class="acIcon"></td>
        </tr> -->
            <tr>
                <td class="tablelabelcel">
                    <?php echo "Taxonomic sources "; ?>
                </td>
                <td class="tablemiddlecel">
                    <?php //echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=taxonomicsources', array('rel' => 'lightbox')); ?>	                
                </td>
                <td class="tablefieldcel" style="height: 40px;">
                    <?php echo CHtml::activeHiddenField($taxonomicElement, 'colvalidation'); ?>
                    <span id="taxonsources"></span>
                </td>
                <td class="acIcon"></td>
            </tr>
            <tr>
                <td class="tablelabelcel">
                    <?php echo 'Taxonomic identification uncertainty'; ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=kingdom', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                    <div id="uncertaintyslider"></div>
                    <?php echo CHtml::activeHiddenField($taxonomicElement, 'uncertainty'); ?>
                </td>
                <td style="width: 60px; float: left;">
                    <div id="uncertaintydesc" style="float: left; vertical-align: bottom; margin-left: 10px; padding-top: 5px;"></div>
                </td>
            </tr>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel(KingdomAR::model(), 'kingdom'); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=kingdom', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                    	<?php echo CHtml::activeHiddenField($taxonomicElement->kingdom, 'colvalidation'); ?>
                        <?php echo CHtml::activeHiddenField($taxonomicElement, 'idkingdom'); ?>
                        <?php echo CHtml::activeTextField($taxonomicElement->kingdom, 'kingdom', array('class' => 'textfield')); ?>
                    </div>
                </td>
                <td class="acIcon" id="autocompleteKingdom"></td>
            </tr>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel(PhylumAR::model(), "phylum"); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=phylum', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                    	<?php echo CHtml::activeHiddenField($taxonomicElement->phylum, 'colvalidation'); ?>
                        <?php echo CHtml::activeHiddenField($taxonomicElement, 'idphylum'); ?>
                        <?php echo CHtml::activeTextField($taxonomicElement->phylum, 'phylum', array('class' => 'textfield')); ?>
                    </div>
                </td>
                <td class="acIcon" id="autocompletePhylum">
                </td>
            </tr>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel(ClassAR::model(), "class"); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=class', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                    	<?php echo CHtml::activeHiddenField($taxonomicElement->class, 'colvalidation'); ?>
                        <?php echo CHtml::activeHiddenField($taxonomicElement, 'idclass'); ?>
                        <?php echo CHtml::activeTextField($taxonomicElement->class, 'class', array('class' => 'textfield')); ?>
                    </div>
                </td>
                <td class="acIcon" id="autocompleteClass">
                </td>
            </tr>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel(OrderAR::model(), "order"); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=order', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                    	<?php echo CHtml::activeHiddenField($taxonomicElement->order, 'colvalidation'); ?>
                        <?php echo CHtml::activeHiddenField($taxonomicElement, 'idorder'); ?>
                        <?php echo CHtml::activeTextField($taxonomicElement->order, 'order', array('class' => 'textfield')); ?>
                    </div>
                </td>
                <td class="acIcon" id="autocompleteOrder">
                </td>
            </tr>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel(FamilyAR::model(), "family"); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=family', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                    	<?php echo CHtml::activeHiddenField($taxonomicElement->family, 'colvalidation'); ?>
                        <?php echo CHtml::activeHiddenField($taxonomicElement, 'idfamily'); ?>
                        <?php echo CHtml::activeTextField($taxonomicElement->family, 'family', array('class' => 'textfield')); ?>
                    </div>
                </td>
                <td class="acIcon" id="autocompleteFamily">
                </td>
            </tr>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel(GenusAR::model(), "genus"); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=genus', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                    	<?php echo CHtml::activeHiddenField($taxonomicElement->genus, 'colvalidation'); ?>
                        <?php echo CHtml::activeHiddenField($taxonomicElement, 'idgenus'); ?>
                        <?php echo CHtml::activeTextField($taxonomicElement->genus, 'genus', array('class' => 'textfield')); ?>
                    </div>
                </td>
                <td class="acIcon" id="autocompleteGenus">
                </td>
            </tr>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel(SubgenusAR::model(), "subgenus"); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=subgenus', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                    	<?php echo CHtml::activeHiddenField($taxonomicElement->subgenus, 'colvalidation'); ?>
                        <?php echo CHtml::activeHiddenField($taxonomicElement, 'idsubgenus'); ?>
                        <?php echo CHtml::activeTextField($taxonomicElement->subgenus, 'subgenus', array('class' => 'textfield')); ?>
                    </div>
                </td>
                <td class="acIcon" id="autocompleteSubgenus">
                </td>
            </tr>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel(SpecificEpithetAR::model(), "specificepithet"); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=specificepithet', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                    	<?php echo CHtml::activeHiddenField($taxonomicElement->specificepithet, 'colvalidation'); ?>
                        <?php echo CHtml::activeHiddenField($taxonomicElement, 'idspecificepithet'); ?>
                        <?php echo CHtml::activeTextField($taxonomicElement->specificepithet, 'specificepithet', array('class' => 'textfield')); ?>
                    </div>
                </td>
                <td class="acIcon" id="autocompleteSpecificEpithet">
                </td>
            </tr>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel(InfraspecificEpithetAR::model(), "infraspecificepithet"); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=infraspecificepithet', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                    	<?php echo CHtml::activeHiddenField($taxonomicElement->infraspecificepithet, 'colvalidation'); ?>                    
                        <?php echo CHtml::activeHiddenField($taxonomicElement, 'idinfraspecificepithet'); ?>
                        <?php echo CHtml::activeTextField($taxonomicElement->infraspecificepithet, 'infraspecificepithet', array('class' => 'textfield')); ?>
                    </div>
                </td>
                <td class="acIcon" id="autocompleteInfraspecificEpithet">
                </td>
            </tr>
            <tr>
                <td class="tablelabelcel">
                    <?php echo 'Scientific name'; ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=scientificname', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                    	<?php echo CHtml::activeHiddenField($taxonomicElement->scientificname, 'colvalidation'); ?>
                        <?php echo CHtml::activeHiddenField($taxonomicElement, 'idscientificname'); ?>
                        <?php echo CHtml::activeTextField($taxonomicElement->scientificname, 'scientificname', array('class' => 'textboxtext')); ?>
                    </div>
                </td>
                <td class="acIcon" id="autocompleteScientificName">
                </td>
            </tr>
            <tr id="morphospeciesrow" style="display: none">
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel(MorphospeciesAR::model(), "morphospecies"); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=kingdom', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                        <?php echo CHtml::activeHiddenField($taxonomicElement, 'idmorphospecies'); ?>
                        <?php echo CHtml::activeTextField($taxonomicElement->morphospecies, 'morphospecies', array('class' => 'textfield')); ?>
                    </div>
                </td>
                <td class="acIcon" id="autocompleteKingdom"></td>
            </tr>
        </table>

        <table cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel(TaxonRankAR::model(), 'taxonrank'); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=taxonrank', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                        <?php echo CHtml::activeHiddenField($taxonomicElement, 'idtaxonrank'); ?>
                        <?php echo CHtml::activeTextField($taxonomicElement->taxonrank, 'taxonrank', array('class' => 'textfield')); ?>
                    </div>
                </td>
                <td class="acIcon" id="autocompleteTaxonRank">
                </td>
            </tr>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel(ScientificNameAuthorshipAR::model(), "scientificnameauthorship"); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=scientificnameauthorship', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                        <?php echo CHtml::activeHiddenField($taxonomicElement, 'idscientificnameauthorship'); ?>
                        <?php echo CHtml::activeTextField($taxonomicElement->scientificnameauthorship, 'scientificnameauthorship', array('class' => 'textfield')); ?>
                    </div>
                </td>
                <td class="acIcon" id="autocompleteScientificNameAuthorship">
                </td>
            </tr>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel(NomenclaturalCodeAR::model(), "nomenclaturalcode"); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=nomenclaturalcode', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                        <?php echo CHtml::activeHiddenField($taxonomicElement, 'idnomenclaturalcode'); ?>
                        <?php echo CHtml::activeTextField($taxonomicElement->nomenclaturalcode, 'nomenclaturalcode', array('class' => 'textfield')); ?>
                    </div>
                </td>
                <td class="acIcon" id="autocompleteNomenclaturalCode">
                </td>
            </tr>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel(TaxonConceptAR::model(), "taxonconcept"); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=taxonconcept', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                        <?php echo CHtml::activeHiddenField($taxonomicElement, 'idtaxonconcept'); ?>
                        <?php echo CHtml::activeTextField($taxonomicElement->taxonconcept, 'taxonconcept', array('class' => 'textfield')); ?>
                    </div>
                </td>
                <td class="acIcon" id="autocompleteTaxonConcept">
                </td>
            </tr>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel($taxonomicElement, "nomenclaturalstatus"); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=nomenclaturalstatus', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                        <?php echo CHtml::activeTextField($taxonomicElement, 'nomenclaturalstatus', array('class' => 'textfield')); ?>
                    </div>
                </td>
                <td class="acIcon"></td>
            </tr>
        </table>

        <table cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel(AcceptedNameUsageAR::model(), 'acceptednameusage'); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=acceptednameusage', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                        <?php echo CHtml::activeHiddenField($taxonomicElement, 'idacceptednameusage'); ?>
                        <?php echo CHtml::activeTextField($taxonomicElement->acceptednameusage, 'acceptednameusage', array('class' => 'textfield')); ?>
                    </div>
                </td>
                <td class="acIcon" id="autocompleteAcceptedNameUsage">
                </td>
            </tr>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel(ParentNameUsageAR::model(), "parentnameusage"); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=parentnameusage', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                        <?php echo CHtml::activeHiddenField($taxonomicElement, 'idparentnameusage'); ?>
                        <?php echo CHtml::activeTextField($taxonomicElement->parentnameusage, 'parentnameusage', array('class' => 'textfield')); ?>
                    </div>
                </td>
                <td class="acIcon" id="autocompleteParentNameUsage">
                </td>
            </tr>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel(OriginalNameUsageAR::model(), "originalnameusage"); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=originalnameusage', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                        <?php echo CHtml::activeHiddenField($taxonomicElement, 'idoriginalnameusage'); ?>
                        <?php echo CHtml::activeTextField($taxonomicElement->originalnameusage, 'originalnameusage', array('class' => 'textfield')); ?>
                    </div>
                </td>
                <td class="acIcon" id="autocompleteOriginalNameUsage">
                </td>
            </tr>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel(NameAccordingToAR::model(), "nameaccordingto"); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=nameaccordingto', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                        <?php echo CHtml::activeHiddenField($taxonomicElement, 'idnameaccordingto'); ?>
                        <?php echo CHtml::activeTextField($taxonomicElement->nameaccordingto, 'nameaccordingto', array('class' => 'textfield')); ?>
                    </div>
                </td>
                <td class="acIcon" id="autocompleteNameAccordingTo">
                </td>
            </tr>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel(NamePublishedInAR::model(), "namepublishedin"); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=namepublishedin', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                        <?php echo CHtml::activeHiddenField($taxonomicElement, 'idnamepublishedin'); ?>
                        <?php echo CHtml::activeTextField($taxonomicElement->namepublishedin, 'namepublishedin', array('class' => 'textfield')); ?>
                    </div>
                </td>
                <td class="acIcon" id="autocompleteNamePublishedIn">
                </td>
            </tr>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel($taxonomicElement, "vernacularname"); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=vernacularname', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                        <?php echo CHtml::activeTextField($taxonomicElement, 'vernacularname', array('class' => 'textfield')); ?>
                    </div>
                </td>
                <td class="acIcon"></td>
            </tr>
        </table>

        <table cellspacing="0" cellpadding="0" align="center" class="fieldsTable">
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel(TaxonomicStatusAR::model(), "taxonomicstatus"); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=taxonomicstatus', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                        <?php echo CHtml::activeDropDownList($taxonomicElement, 'idtaxonomicstatus', CHtml::listData(TaxonomicStatusAR::model()->findAll(" 1=1 ORDER BY taxonomicstatus "), 'idtaxonomicstatus', 'taxonomicstatus'), array('empty' => '-')); ?>
                    </div>
                </td>
                <td class="acIcon"></td>
            </tr>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel($taxonomicElement, "verbatimtaxonrank"); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=verbatimtaxonrank', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                        <?php echo CHtml::activeTextField($taxonomicElement, 'verbatimtaxonrank', array('class' => 'textfield')); ?>
                    </div>
                </td>
                <td class="acIcon"></td>
            </tr>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel($taxonomicElement, "taxonremark"); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">', 'index.php?r=help&helpfield=taxonremark', array('rel' => 'lightbox')); ?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete">
                        <?php echo CHtml::activeTextArea($taxonomicElement, 'taxonremark', array('class' => 'textfield')); ?>
                    </div>
                </td>
                <td class="acIcon"></td>
            </tr>
        </table>
    </div>
</div>



