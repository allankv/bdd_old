<?php include_once("protected/extensions/config.php"); ?>

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="js/Maintain.js"></script>
<script type="text/javascript" src="js/List.js"></script>
<link rel="stylesheet" type="text/css" href="js/tablesorter/themes/blue/style.css" />

<style type="text/css">
    #slider {
		margin: 10px;
	}
    .ui-autocomplete-category {
        color: orange;
        font-weight: bold;
        padding: .2em .4em;
        margin: .8em 0 .2em;
        line-height: 1.5;
    }
    .ui-autocomplete {
        max-height: 300px;
        overflow-y: auto;
    }
    ul#icons li {
            cursor: pointer;
            float: left;
            list-style: none outside none;
            margin: 2px;
            padding: 4px;
            position: relative;
    }
</style>
<script type="text/javascript">
    var start = 0;
    var end = 10;
    var max = 10;
    var interval = 10;
    var handleSize = 50;

    $(document).ready(bootSpecimen);
    // Inicia configuracoes Javascript
    function bootSpecimen(){
        //configCatComplete('#id','#searchField', 'specimen','#filterList');        
        //filter();
        //slider();
        configInitial();
        //configNotify();
        //configIcons();
    	$("#printButton").button();
    }
    // Configuracoes iniciais
    function configInitial() {
        $("#editBtn").button();

        // Evento onclick do botao edit
        $("#editBtn").click(function(){
             window.location = "index.php?r=interaction/goToMaintain&id="+$("#InteractionAR_idinteraction").val();
         });
         
        if($('#InteractionAR_idspecimen1').val()=='') {
            $('#interaction').hide('slide');
            $('#interactionLeft').css("opacity", "1");
            $('#interactionMiddle').css("opacity", "0.5");
            $('#interactionRight').css("opacity", "0.5");
        }
        else {
            $('#specimenFilters').hide('slide');
            $('#interaction').hide('slide');
            $('#interactionLeft').css("opacity", "1");
            $('#interactionMiddle').css("opacity", "1");
            $('#interactionRight').css("opacity", "1");
        }
    }
    
    function print() {
    	var windowReference = window.open('index.php?r=loadingfile/goToShow');
    	$.ajax({ 
    		type:'GET',
            url:'index.php?r=interaction/print',
            data: {
            	"id": $('#InteractionAR_idinteraction').val()
            },
            dataType: "json",
            success:function(json) {
            	windowReference.location = json;
            }
        });
    }

</script>

<div id="Notification"></div>

<!-- Texto Introdutorio-->
<div class="introText" style="width:90%;">
    <h1><?php echo Yii::t('yii','View an existing interaction record'); ?></h1>
    <p><?php echo Yii::t('yii','Use this tool to view information regarding the relationship between two occurrence records in the database.'); ?></p>
</div>

<div class="yiiForm" style="width:95%;">

    <?php echo CHtml::beginForm('','post',array ('id'=>'form'));?>
    
    <!-- Specimen 1 -->
    <div id="interactionLeft">
    	<div class="title"><?php echo CHtml::encode(Yii::t('yii','Specimen')); ?> 1</div>
        <div style="clear:both;"></div>
        
        <div class="key"><?php echo Yii::t('yii',"Institution")?></div>
        <div class="value"><span id="institutioncode_specimen1"><?php echo CHtml::encode($interaction->specimen1->recordlevelelement->institutioncode->institutioncode)?></span></div>
        <div style="clear:both;"></div>
        
        <div class="key"><?php echo Yii::t('yii',"Collection")?></div>
        <div class="value"><span id="collectioncode_specimen1"><?php echo CHtml::encode($interaction->specimen1->recordlevelelement->collectioncode->collectioncode)?></span></div>
        <div style="clear:both;"></div>
        
        <div class="key"><?php echo Yii::t('yii',"Catalog Number")?></div>
        <div class="value"><span id="catalognumber_specimen1"><?php echo CHtml::encode($interaction->specimen1->occurrenceelement->catalognumber)?></span></div>
        <div style="clear:both;"></div>
        
        <div class="key"><?php echo Yii::t('yii',"Taxonomic Element")?></div>
        <div class="value"><span id="taxon_specimen1"><?php echo CHtml::encode($interaction->specimen1->taxonomicelement->scientificname->scientificname)?></span></div>
        <div style="clear:both;"></div>
        
		<?php echo CHtml::activeHiddenField($interaction,"idspecimen1")?>
    </div>
    
    <!-- Interaction Get -->
    <div id="interactionMiddle">
    	<div class="title"><?php echo CHtml::encode(Yii::t('yii','Interaction')); ?></div>
        <div style="clear:both;"></div>
        
        <div class="key"><?php echo CHtml::activeLabel($interaction->interactiontype,'interactiontype'); ?></div>
        <div class="value"><span id="interactiontype"><?php echo CHtml::encode($interaction->interactiontype->interactiontype)?></span></div>
        <div style="clear:both;"></div>
        
        <div class="key"><?php echo CHtml::activeLabel($interaction,'interactionrelatedinformation'); ?></div>
        <div class="value"><span id="interactionrelatedinformation"><?php echo CHtml::encode($interaction->interactionrelatedinformation)?></span></div>
        <div style="clear:both;"></div>
    
        
        <div class="field"><?php //echo CHtml::activeDropDownList($interaction, 'idinteractiontype', CHtml::listData(InteractionTypeAR::model()->findAll(), 'idinteractiontype', 'interactiontype'), array('empty'=>'-'));?></div>
        <div class="label"></div>
        <div class="field"><?php //echo CHtml::activeTextArea($interaction,'interactionrelatedinformation',array('rows'=>8, 'cols'=>150,'style'=>'width:230px;height:60px;')); ?></div>
        
        <?php echo CHtml::activeHiddenField($interaction,"idinteraction")?>
    </div>
    
    <!-- Specimen 2 -->
    <div id="interactionRight">
    	<div class="title"><?php echo CHtml::encode(Yii::t('yii','Specimen')); ?> 2</div>
        <div style="clear:both;"></div>
        
        <div class="key"><?php echo Yii::t('yii',"Institution")?></div>
        <div class="value"><span id="institutioncode_specimen2"><?php echo CHtml::encode($interaction->specimen2->recordlevelelement->institutioncode->institutioncode)?></span></div>
        <div style="clear:both;"></div>
        
        <div class="key"><?php echo Yii::t('yii',"Collection")?></div>
        <div class="value"><span id="collectioncode_specimen2"><?php echo CHtml::encode($interaction->specimen2->recordlevelelement->collectioncode->collectioncode)?></span></div>
        <div style="clear:both;"></div>
        
        <div class="key"><?php echo Yii::t('yii',"Catalog Number")?></div>
        <div class="value"><span id="catalognumber_specimen2"><?php echo CHtml::encode($interaction->specimen2->occurrenceelement->catalognumber)?></span></div>
        <div style="clear:both;"></div>
        
        <div class="key"><?php echo Yii::t('yii',"Taxonomic Element")?></div>
        <div class="value"><span id="taxon_specimen2"><?php echo CHtml::encode($interaction->specimen2->taxonomicelement->scientificname->scientificname)?></span></div>
        <div style="clear:both;"></div>
        
		<?php echo CHtml::activeHiddenField($interaction,"idspecimen2")?>
    </div>
    <div style="clear:both"></div>

    <div class="privateRecord">
        <div class="title"><?php echo $monitoring->recordlevelelement->isrestricted ? "This is a private record." : "This is not a private record." ; ?></div>
        <div class="icon"><?php if ($monitoring->recordlevelelement->isrestricted) showIcon("Private Record", "ui-icon-locked", 0); else showIcon("Not Private Record", "ui-icon-unlocked", 0) ; ?></div>
    </div>

    <div class="saveButton">
	    <input id="printButton" type="button" value="Print" onclick="print()">
        <input type="checkbox" id="editBtn" /><label for="editBtn">Edit</label>
    </div>
    
    <?php echo CHtml::endForm(); ?>
    </div>
