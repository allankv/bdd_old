<?php include_once("protected/extensions/config.php"); ?>
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
<script src="js/jquery.jstepper.js" type="text/javascript"></script>
<script src="js/validation/jquery.numeric.pack.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript" src="js/Maintain.js"></script>

<style type="text/css">
    #slider {
        margin: 10px;
    }
    .tablelabelcel {
    	width: 250px;
    }
    .divAccordion {
    	margin-top: 5px;
    }
    .accordionLeft {
    	float:left;
    	letter-spacing: 0.6px;
    	width: 200px;
    	margin-left:10px;
    	text-align: right;
    	margin-top: 2px;
    }
    .accordionMiddle {
    	float:left;
    	margin-left: 15px;
    	margin-right: 15px;
    	margin-top: 2px;
    }
    .accordionRight {
    	float:left;
    }
    .acIcon {
    	margin-left:10px;
    	margin-top:-2px;
    }   
</style>
<script>
    // Inicia configuracoes Javascript
    $(document).ready(bootDeficit);
    //Date and time formatter
    jQuery(function($){
    	$("#DeficitAR_timeatstart").mask("99:99:99");
        $("#DeficitAR_date").mask("9999/99/99");
        $("#DeficitAR_date").datepicker({ dateFormat: 'yy/mm/dd' });
        $("#DeficitAR_plantingdate").mask("9999/99/99");
        $("#DeficitAR_plantingdate").datepicker({ dateFormat: 'yy/mm/dd' });

        $("#DeficitAR_year").jStepper({minValue:0, disableNonNumeric:true});
        //$("#LocalityElementAR_verbatimelevation").jStepper({minValue:0, disableNonNumeric:true});
        $("#GeospatialElementAR_decimallatitude").jStepper({disableNonNumeric:true});
        $("#GeospatialElementAR_decimallongitude").jStepper({disableNonNumeric:true});
        $("#DeficitAR_distancebetweenrows").jStepper({minValue:0, disableNonNumeric:true});
        $("#DeficitAR_distanceamongplantswithinrows").jStepper({minValue:0, disableNonNumeric:true});
        $("#DeficitAR_recordingnumber").jStepper({minValue:0, disableNonNumeric:true});
        $("#DeficitAR_plotnumber").jStepper({minValue:0, disableNonNumeric:true});
        $("#DeficitAR_numberflowersobserved").jStepper({minValue:0, disableNonNumeric:true});
        $("#DeficitAR_apismellifera").jStepper({minValue:0, disableNonNumeric:true});
        $("#DeficitAR_bumblebees").jStepper({minValue:0, disableNonNumeric:true});
        $("#DeficitAR_otherbees").jStepper({minValue:0, disableNonNumeric:true});
        $("#DeficitAR_other").jStepper({minValue:0, disableNonNumeric:true});
    });
    function bootDeficit() {
    
        configAutocomplete('#DeficitAR_idcommonnamefocalcrop','#CommonNameFocalCropAR_commonnamefocalcrop', 'commonnamefocalcrop');
        configAutocomplete('#LocalityElementAR_idcountry','#CountryAR_country', 'country');
        configAutocomplete('#LocalityElementAR_idstateprovince','#StateProvinceAR_stateprovince', 'stateprovince');
        configAutocomplete('#LocalityElementAR_idcounty','#CountyAR_county', 'county');
        configAutocomplete('#LocalityElementAR_idmunicipality','#MunicipalityAR_municipality', 'municipality');
        configAutocomplete('#LocalityElementAR_idlocality','#LocalityAR_locality', 'locality');
        configAutocomplete('#LocalityElementAR_idsite_','#Site_AR_site_', 'site_');
        configAutocomplete('#DeficitAR_idtypeholding','#TypeHoldingAR_typeholding', 'typeholding');
        configAutocomplete('#DeficitAR_idtopograficalsituation','#TopograficalSituationAR_topograficalsituation', 'topograficalsituation');
        configAutocomplete('#DeficitAR_idsoiltype','#SoilTypeAR_soiltype', 'soiltype');
        configAutocomplete('#DeficitAR_idsoilpreparation','#SoilPreparationAR_soilpreparation', 'soilpreparation');
        configAutocomplete('#DeficitAR_idmainplantspeciesinhedge','#MainPlantSpeciesInHedgeAR_mainplantspeciesinhedge', 'mainplantspeciesinhedge');
        configAutocomplete('#DeficitAR_idscientificname','#ScientificNameAR_scientificname', 'scientificname');
        configAutocomplete('#DeficitAR_idproductionvariety','#ProductionVarietyAR_productionvariety', 'productionvariety');
        configAutocomplete('#DeficitAR_idoriginseeds','#OriginSeedsAR_originseeds', 'originseeds');
        configAutocomplete('#DeficitAR_idtypeplanting','#TypePlantingAR_typeplanting', 'typeplanting');
        configAutocomplete('#DeficitAR_idtypestand','#TypeStandAR_typestand', 'typestand');
        configAutocomplete('#DeficitAR_idfocuscrop','#FocusCropAR_focuscrop', 'focuscrop');
        configAutocomplete('#DeficitAR_idtreatment','#TreatmentAR_treatment', 'treatment');
        configAutocomplete('#DeficitAR_idobserver','#ObserverAR_observer', 'observer');
        configAutocomplete('#DeficitAR_idweathercondition','#WeatherConditionAR_weathercondition', 'weathercondition');
 
        //Autocomplete icons
        var btnAutocomplete ="<div class='btnAutocomplete' style='width:20px;'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-comment'></span></li></ul></div>";
       
        $('#autocompletecommonnamefocalcrop').append('<a href="javascript:suggest(\'#DeficitAR_idcommonnamefocalcrop\',\'#CommonNameFocalCropAR_commonnamefocalcrop\', \'commonnamefocalcrop\');">'+btnAutocomplete+'</a>');
        $('#autocompletecountry').append('<a href="javascript:suggest(\'#LocalityElementAR_idcountry\',\'#CountryAR_country\', \'country\');">'+btnAutocomplete+'</a>');
        $('#autocompletestateprovince').append('<a href="javascript:suggest(\'#LocalityElementAR_idstateprovince\',\'#StateProvinceAR_stateprovince\', \'stateprovince\');">'+btnAutocomplete+'</a>');
        $('#autocompletecounty').append('<a href="javascript:suggest(\'#LocalityElementAR_idcounty\',\'#CountyAR_county\', \'county\');">'+btnAutocomplete+'</a>');
        $('#autocompletemunicipality').append('<a href="javascript:suggest(\'#LocalityElementAR_idmunicipality\',\'#MunicipalityAR_municipality\', \'municipality\');">'+btnAutocomplete+'</a>');
        $('#autocompletelocality').append('<a href="javascript:suggest(\'#LocalityElementAR_idlocality\',\'#LocalityAR_locality\', \'locality\');">'+btnAutocomplete+'</a>');
        $('#autocompletesite_').append('<a href="javascript:suggest(\'#LocalityElementAR_idsite_\',\'#Site_AR_site_\', \'site_\');">'+btnAutocomplete+'</a>');
        $('#autocompletetypeholding').append('<a href="javascript:suggest(\'#DeficitAR_idtypeholding\',\'#TypeHoldingAR_typeholding\', \'typeholding\');">'+btnAutocomplete+'</a>');
        $('#autocompletetopograficalsituation').append('<a href="javascript:suggest(\'#DeficitAR_idtopograficalsituation\',\'#TopograficalSituationAR_topograficalsituation\', \'topograficalsituation\');">'+btnAutocomplete+'</a>');
        $('#autocompletesoiltype').append('<a href="javascript:suggest(\'#DeficitAR_idsoiltype\',\'#SoilTypeAR_soiltype\', \'soiltype\');">'+btnAutocomplete+'</a>');
        $('#autocompletesoilpreparation').append('<a href="javascript:suggest(\'#DeficitAR_idsoilpreparation\',\'#SoilPreparationAR_soilpreparation\', \'soilpreparation\');">'+btnAutocomplete+'</a>');
        $('#autocompletemainplantspeciesinhedge').append('<a href="javascript:suggest(\'#DeficitAR_idmainplantspeciesinhedge\',\'#MainPlantSpeciesInHedgeAR_mainplantspeciesinhedge\', \'mainplantspeciesinhedge\');">'+btnAutocomplete+'</a>');
        $('#autocompletescientificname').append('<a href="javascript:suggest(\'#DeficitAR_idscientificname\',\'#ScientificNameAR_scientificname\', \'scientificname\');">'+btnAutocomplete+'</a>');
        $('#autocompleteproductionvariety').append('<a href="javascript:suggest(\'#DeficitAR_idproductionvariety\',\'#ProductionVarietyAR_productionvariety\', \'productionvariety\');">'+btnAutocomplete+'</a>');
        $('#autocompleteoriginseeds').append('<a href="javascript:suggest(\'#DeficitAR_idoriginseeds\',\'#OriginSeedsAR_originseeds\', \'originseeds\');">'+btnAutocomplete+'</a>');
        $('#autocompletetypeplanting').append('<a href="javascript:suggest(\'#DeficitAR_idtypeplanting\',\'#TypePlantingAR_typeplanting\', \'typeplanting\');">'+btnAutocomplete+'</a>');
        $('#autocompletetypestand').append('<a href="javascript:suggest(\'#DeficitAR_idtypestand\',\'#TypeStandAR_typestand\', \'typestand\');">'+btnAutocomplete+'</a>');
        $('#autocompletefocuscrop').append('<a href="javascript:suggest(\'#DeficitAR_idfocuscrop\',\'#FocusCropAR_focuscrop\', \'focuscrop\');">'+btnAutocomplete+'</a>');
        $('#autocompletetreatment').append('<a href="javascript:suggest(\'#DeficitAR_idtreatment\',\'#TreatmentAR_treatment\', \'treatment\');">'+btnAutocomplete+'</a>');
        $('#autocompleteobserver').append('<a href="javascript:suggest(\'#DeficitAR_idobserver\',\'#ObserverAR_observer\', \'observer\');">'+btnAutocomplete+'</a>');
        $('#autocompleteweathercondition').append('<a href="javascript:suggest(\'#DeficitAR_idweathercondition\',\'#WeatherConditionAR_weathercondition\', \'weathercondition\');">'+btnAutocomplete+'</a>');
        
        //Help tooltip for Autocomplete Icons
        var acContent = "Click to choose from a list of records"
        $('.acIcon').poshytip({
            className: 'tip-twitter',
            content: acContent,
            alignTo: 'target',
            alignX: 'right',
            alignY: 'center',
            offsetX: 10,
            offsetY: 0
        });
        //Configs
        configInitial();
        configNotify();
        configIcons();
        configAccordion();
    }
    // Configuracoes iniciais
    function configInitial() {
        $("#saveBtn").button();

        // Evento onclick do botao save
        $("#saveBtn").click(function() {
            $('html, body').animate({scrollTop: 0}, 'slow');
            $('#saveBtn').button('option', 'label', 'Processing');
            $('#saveBtn').attr('checked', true);
            save();
        });
    }
    function configAccordion() {
        // Cria accordions apartir das divs
        $("#locationAccordion").accordion({collapsible: true, autoHeight: false, navigation: true});
        $("#dimensionAccordion").accordion({collapsible: true, autoHeight: false, navigation: true});
        $("#topographyAccordion").accordion({collapsible: true, autoHeight: false, navigation: true});
        $("#environmentsAccordion").accordion({collapsible: true, autoHeight: false, navigation: true});
        $("#focalcropAccordion").accordion({collapsible: true, autoHeight: false, navigation: true});
        $("#culturalpracticesAccordion").accordion({collapsible: true, autoHeight: false, navigation: true});
        $("#recordingconditionsAccordion").accordion({collapsible: true, autoHeight: false, navigation: true});
        $("#numberofflowervisitorsAccordion").accordion({collapsible: true, autoHeight: false, navigation: true});

        // Fecha todas
        $("#locationAccordion").accordion("activate", false);
        $("#dimensionAccordion").accordion("activate", false);
        $("#topographyAccordion").accordion("activate", false);
        $("#environmentsAccordion").accordion("activate", false);
        $("#focalcropAccordion").accordion("activate", false);
        $("#culturalpracticesAccordion").accordion("activate", false);
        $("#recordingconditionsAccordion").accordion("activate", false);
        $("#numberofflowervisitorsAccordion").accordion("activate", false);

    }
    // Acao de salva
    function save(){
        $.ajax({ type:'POST',
            url:'index.php?r=deficit/save',
            data: $("#form").serialize(),
            dataType: "json",
            success:function(json) {
           	 	if (json.success) {
	            	if ($('#DeficitAR_iddeficit').val() == '') {
		        		$('#DeficitAR_fieldnumber').val('');     		
		            }
		        }
            
                showMessage(json.msg, json.success, false);
                $('#saveBtn').attr('checked', false);
                $('#saveBtn').attr('active', false);
                $('#saveBtn').button('option', 'label', 'Save');
                //printMsg(json.msg,'#msg',json.success);
            }
        });
    }
</script>

<div id="Notification"></div>

<?php echo CHtml::beginForm('','post',array ('id'=>'form')); ?>
<?php echo CHtml::activeHiddenField($deficit,'iddeficit');?>

<!-- TEXTO INTRODUTORIO ----------------------------------------------->

<div class="introText">
    <h1><?php echo $deficit->iddeficit != null?Yii::t('yii','Update an existing deficit record'):Yii::t('yii','Create a new deficit record'); ?></h1>
    <p><?php echo Yii::t('yii',"Use this tool to save records of pollination deficit assessment and detection studies."); ?></p>
</div>

<div class="yiiForm">
    <div class="attention">
        <?php echo CHtml::image('images/main/attention.png','',array('border'=>'0px'))."&nbsp;&nbsp;".Yii::t('yii', "Main Fields");?>
        (<span style="color: red; font-weight: bold;"><?php echo Yii::t('yii',"Fields with * are required"); ?></span>)
    </div>
    <table cellspacing="0" cellpadding="0" align="center" class="tablerequired" style="margin-bottom:12px;">
    	<div class="tablerow" id='divfieldnumber'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel($deficit, "fieldnumber"); ?>
                    <span class="required">*</span>
                    
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=fieldnumber',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel">
                    <?php echo CHtml::activeTextField($deficit,'fieldnumber', array('class'=>'textboxtext')); ?>
                </td>
            </tr>
        </div>
        <div class="tablerow" id='divcommonnamefocalcrop'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel(CommonNameFocalCropAR::model(),'commonnamefocalcrop');?>
                    
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=commonnamefocalcrop',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel">
                    <?php echo CHtml::activeHiddenField($deficit,'idcommonnamefocalcrop');?>
                    <?php echo CHtml::activeTextField($deficit->commonnamefocalcrop, 'commonnamefocalcrop', array('class'=>'textboxtext'));?>
                </td>
                <td class="acIcon" id="autocompletecommonnamefocalcrop">
                </td>
            </tr>
        </div>
        <div class="tablerow" id='divyear'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel($deficit, "year"); ?>
                    
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=year',array('rel'=>'lightbox'));?>
                </td>

                <td class="tablefieldcel">
                    <?php echo CHtml::activeTextField($deficit,'year', array('class'=>'textboxtext')); ?>
                </td>
            </tr>
        </div>
        <div class="tablerow" id='divfocuscrop'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel(FocusCropAR::model(),'focuscrop');?>
                    
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=focuscrop',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel">
                    <?php echo CHtml::activeHiddenField($deficit,'idfocuscrop');?>
                    <?php echo CHtml::activeTextField($deficit->focuscrop, 'focuscrop', array('class'=>'textboxtext'));?>
                </td>
                <td class="acIcon" id="autocompletefocuscrop">
                </td>
            </tr>
        </div>
        <div class="tablerow" id='divsize'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel($deficit, "size"); ?>
                    
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=size',array('rel'=>'lightbox'));?>
                </td>

                <td class="tablefieldcel">
                    <?php echo CHtml::activeTextField($deficit,'size', array('class'=>'textboxtext')); ?>
                </td>
            </tr>
        </div>
        <div class="tablerow" id='divtreatment'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel(TreatmentAR::model(),'treatment');?>
                    
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=treatment',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel">
                    <?php echo CHtml::activeHiddenField($deficit,'idtreatment');?>
                    <?php echo CHtml::activeTextField($deficit->treatment, 'treatment', array('class'=>'textboxtext'));?>
                </td>
                <td class="acIcon" id="autocompletetreatment">
                </td>
            </tr>
        </div>
        <div class="tablerow" id='divdate'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel($deficit, "date"); ?>
                    

                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=date',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel">
                    <?php echo CHtml::activeTextField($deficit,'date', array('class'=>'timeordate')); ?>
                </td>
            </tr>
        </div>
        <div class="tablerow" id='divobserver'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel(ObserverAR::model(),'observer');?>
                    
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=observer',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel">
                    <?php echo CHtml::activeHiddenField($deficit,'idobserver');?>
                    <?php echo CHtml::activeTextField($deficit->observer, 'observer', array('class'=>'textboxtext'));?>
                </td>
                <td class="acIcon" id="autocompleteobserver">
                </td>
            </tr>
        </div>
        <div class="tablerow" id='divrecordingnumber'>

            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel($deficit, "recordingnumber"); ?>
                    
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=recordingnumber',array('rel'=>'lightbox'));?>
                </td>

                <td class="tablefieldcel">
                    <?php echo CHtml::activeTextField($deficit,'recordingnumber', array('class'=>'textboxtext')); ?>
                </td>
            </tr>
        </div>
        
        <div class="tablerow" id='divplotnumber'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel($deficit, "plotnumber"); ?>
                    

                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=plotnumber',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel">
                    <?php echo CHtml::activeTextField($deficit,'plotnumber', array('class'=>'textboxtext')); ?>
                </td>
            </tr>
        </div>
        <div class="tablerow" id='divnumberflowersobserved'>

            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel($deficit, "numberflowersobserved"); ?>
                    
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=numberflowersobserved',array('rel'=>'lightbox'));?>
                </td>

                <td class="tablefieldcel">
                    <?php echo CHtml::activeTextField($deficit,'numberflowersobserved', array('class'=>'textboxtext')); ?>
                </td>
            </tr>
        </div>
        
        <div class="tablerow" id='divremark'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel($deficit, "remark"); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=remark',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel">
                    <?php echo CHtml::activeTextField($deficit,'remark', array('class'=>'textboxtext')); ?>
                </td>
            </tr>
        </div>
    </table>
    
    <div id="locationAccordion">
    	<h3><a href="#">Location</a></h3>
    	<div>
    		<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel(CountryAR::model(),'country');?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=country',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo CHtml::activeHiddenField($deficit->localityelement,'idcountry'); echo CHtml::activeTextField($deficit->localityelement->country, 'country', array('class'=>'textboxtext'));?></div>
		    	<div class="acIcon" id="autocompletecountry"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel(StateProvinceAR::model(),'stateprovince');?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=stateprovince',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo CHtml::activeHiddenField($deficit->localityelement,'idstateprovince'); echo CHtml::activeTextField($deficit->localityelement->stateprovince, 'stateprovince', array('class'=>'textboxtext'));?></div>
		    	<div class="acIcon" id="autocompletestateprovince"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel(CountyAR::model(),'county');?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=county',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo CHtml::activeHiddenField($deficit->localityelement,'idcounty'); echo CHtml::activeTextField($deficit->localityelement->county, 'county', array('class'=>'textboxtext'));?></div>
		    	<div class="acIcon" id="autocompletecounty"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel(MunicipalityAR::model(),'municipality');?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=municipality',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo CHtml::activeHiddenField($deficit->localityelement,'idmunicipality'); echo CHtml::activeTextField($deficit->localityelement->municipality, 'municipality', array('class'=>'textboxtext'));?></div>
		    	<div class="acIcon" id="autocompletemunicipality"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo "Locality references" //echo CHtml::activeLabel(LocalityAR::model(),'locality');?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=locality',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo CHtml::activeHiddenField($deficit->localityelement,'idlocality'); echo CHtml::activeTextField($deficit->localityelement->locality, 'locality', array('class'=>'textboxtext'));?></div>
		    	<div class="acIcon" id="autocompletelocality"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel(Site_AR::model(),'site_');?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=site_',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo CHtml::activeHiddenField($deficit->localityelement,'idsite_'); echo CHtml::activeTextField($deficit->localityelement->site_, 'site_', array('class'=>'textboxtext'));?></div>
		    	<div class="acIcon" id="autocompletesite_"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel($deficit->geospatialelement, "decimallatitude"); ?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=decimallatitude',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo CHtml::activeTextField($deficit->geospatialelement,'decimallatitude', array('class'=>'textboxtext')); ?></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel($deficit->geospatialelement, "decimallongitude"); ?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=decimallongitude',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo CHtml::activeTextField($deficit->geospatialelement,'decimallongitude', array('class'=>'textboxtext')); ?></div>
		    	<div style="clear:both;"></div>
	    	</div>
    	</div>
    </div>
    
    <div id="dimensionAccordion">
    	<h3><a href="#">Dimension</a></h3>
    	<div>
    		<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel(TypeHoldingAR::model(),'typeholding');?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=typeholding',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo CHtml::activeHiddenField($deficit,'idtypeholding'); echo CHtml::activeTextField($deficit->typeholding, 'typeholding', array('class'=>'textboxtext'));?></div>
		    	<div class="acIcon" id="autocompletetypeholding"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel($deficit, "fieldsize"); ?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=fieldsize',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo CHtml::activeTextField($deficit,'fieldsize', array('class'=>'textboxtext')); ?></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel($deficit, "dimension"); ?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=dimension',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo CHtml::activeTextField($deficit,'dimension', array('class'=>'textboxtext')); ?></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    </div>
    </div>
    
    <div id="topographyAccordion">
    	<h3><a href="#">Topography and Soil</a></h3>
    	<div>
    		<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel($deficit->localityelement, "verbatimelevation"); ?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=verbatimelevation',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo CHtml::activeTextField($deficit->localityelement,'verbatimelevation', array('class'=>'textboxtext')); ?></div>
		    	<div style="clear:both;"></div>
	    	</div>
    		
    		<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel(TopograficalSituationAR::model(),'topograficalsituation');?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=topograficalsituation',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo CHtml::activeHiddenField($deficit,'idtopograficalsituation'); echo CHtml::activeTextField($deficit->topograficalsituation, 'topograficalsituation', array('class'=>'textboxtext'));?></div>
		    	<div class="acIcon" id="autocompletetopograficalsituation"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel(SoilTypeAR::model(),'soiltype');?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=soiltype',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo CHtml::activeHiddenField($deficit,'idsoiltype'); echo CHtml::activeTextField($deficit->soiltype, 'soiltype', array('class'=>'textboxtext'));?></div>
		    	<div class="acIcon" id="autocompletesoiltype"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel(SoilPreparationAR::model(),'soilpreparation');?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=typeholding',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo CHtml::activeHiddenField($deficit,'idsoilpreparation'); echo CHtml::activeTextField($deficit->soilpreparation, 'soilpreparation', array('class'=>'textboxtext'));?></div>
		    	<div class="acIcon" id="autocompletesoilpreparation"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    </div>
    </div>
    
    <div id="environmentsAccordion">
    	<h3><a href="#">Environments</a></h3>
    	<div>
    		<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel($deficit, "hedgesurroundingfield"); ?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=hedgesurroundingfield',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo CHtml::activeCheckBox($deficit, 'hedgesurroundingfield')?></div>
		    	<div style="clear:both;"></div>
	    	</div>
    		
    		<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel(MainPlantSpeciesInHedgeAR::model(),'mainplantspeciesinhedge');?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=mainplantspeciesinhedge',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo CHtml::activeHiddenField($deficit,'idmainplantspeciesinhedge'); echo CHtml::activeTextField($deficit->mainplantspeciesinhedge, 'mainplantspeciesinhedge', array('class'=>'textboxtext'));?></div>
		    	<div class="acIcon" id="autocompletemainplantspeciesinhedge"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel($deficit, "distanceofnaturalhabitat"); ?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=distanceofnaturalhabitat',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo CHtml::activeTextField($deficit,'distanceofnaturalhabitat', array('class'=>'textboxtext')); ?></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    </div>
    </div>
    
    <div id="focalcropAccordion">
    	<h3><a href="#">Focal Crop</a></h3>
    	<div>    		
    		<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel(ScientificNameAR::model(),'scientificname');?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=scientificname',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo CHtml::activeHiddenField($deficit,'idscientificname'); echo CHtml::activeTextField($deficit->scientificname, 'scientificname', array('class'=>'textboxtext'));?></div>
		    	<div class="acIcon" id="autocompletescientificname"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel(ProductionVarietyAR::model(),'productionvariety');?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=productionvariety',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo CHtml::activeHiddenField($deficit,'idproductionvariety'); echo CHtml::activeTextField($deficit->productionvariety, 'productionvariety', array('class'=>'textboxtext'));?></div>
		    	<div class="acIcon" id="autocompleteproductionvariety"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel($deficit, "varietypollenizer"); ?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=varietypollenizer',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo CHtml::activeTextField($deficit,'varietypollenizer', array('class'=>'textboxtext')); ?></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel(OriginSeedsAR::model(),'originseeds');?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=originseeds',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo CHtml::activeHiddenField($deficit,'idoriginseeds'); echo CHtml::activeTextField($deficit->originseeds, 'originseeds', array('class'=>'textboxtext'));?></div>
		    	<div class="acIcon" id="autocompleteoriginseeds"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    </div>
    </div>
    
     <div id="culturalpracticesAccordion">
    	<h3><a href="#">Cultural Practices</a></h3>
    	<div>    		
    		<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel($deficit, "plantingdate"); ?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=plantingdate',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo CHtml::activeTextField($deficit,'plantingdate', array('class'=>'timeordate')); ?></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel(TypePlantingAR::model(),'typeplanting');?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=typeplanting',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo CHtml::activeHiddenField($deficit,'idtypeplanting'); echo CHtml::activeTextField($deficit->typeplanting, 'typeplanting', array('class'=>'textboxtext'));?></div>
		    	<div class="acIcon" id="autocompletetypeplanting"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel($deficit, "plantdensity"); ?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=plantdensity',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo CHtml::activeTextField($deficit,'plantdensity', array('class'=>'textboxtext')); ?></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel(TypeStandAR::model(),'typestand');?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=typestand',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo CHtml::activeHiddenField($deficit,'idtypestand'); echo CHtml::activeTextField($deficit->typestand, 'typestand', array('class'=>'textboxtext'));?></div>
		    	<div class="acIcon" id="autocompletetypestand"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel($deficit, "ratiopollenizertree"); ?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=ratiopollenizertree',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo CHtml::activeTextField($deficit,'ratiopollenizertree', array('class'=>'textboxtext')); ?></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel($deficit, "distancebetweenrows"); ?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=distancebetweenrows',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo CHtml::activeTextField($deficit,'distancebetweenrows', array('class'=>'textboxtext')); ?></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel($deficit, "distanceamongplantswithinrows"); ?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=distanceamongplantswithinrows',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo CHtml::activeTextField($deficit,'distanceamongplantswithinrows', array('class'=>'textboxtext')); ?></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    </div>
    </div>
    
    <div id="recordingconditionsAccordion">
    	<h3><a href="#">Recording Conditions</a></h3>
    	<div>
    		<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel($deficit, "timeatstart"); ?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=timeatstart',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo CHtml::activeTextField($deficit,'timeatstart', array('class'=>'timeordate')); ?></div>
		    	<div style="clear:both;"></div>
	    	</div>
    		
    		<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel($deficit, "period"); ?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=period',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo CHtml::activeTextField($deficit,'period', array('class'=>'textboxtext')); ?></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel(WeatherConditionAR::model(),'weathercondition');?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=weathercondition',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo CHtml::activeHiddenField($deficit,'idweathercondition'); echo CHtml::activeTextField($deficit->weathercondition, 'weathercondition', array('class'=>'textboxtext'));?></div>
                        <div class="acIcon" id="autocompleteweathercondition"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    </div>
    </div>
    
    <div id="numberofflowervisitorsAccordion">
    	<h3><a href="#">Number of Flower Visitors</a></h3>
    	<div>
    		<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel($deficit, "apismellifera"); ?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=apismellifera',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo CHtml::activeTextField($deficit,'apismellifera', array('class'=>'textboxtext')); ?></div>
		    	<div style="clear:both;"></div>
	    	</div>
    		
    		<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel($deficit, "bumblebees"); ?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=bumblebees',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo CHtml::activeTextField($deficit,'bumblebees', array('class'=>'textboxtext')); ?></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel($deficit, "otherbees"); ?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=otherbees',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo CHtml::activeTextField($deficit,'otherbees', array('class'=>'textboxtext')); ?></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel($deficit, "other"); ?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=other',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo CHtml::activeTextField($deficit,'other', array('class'=>'textboxtext')); ?></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    </div>
    </div>
    
    <div class="privateRecord">
        <div class="title"><?php echo CHtml::activeCheckBox($deficit, 'isrestricted')."&nbsp;&nbsp;".Yii::t('yii','Check here to make this record private')."&nbsp;&nbsp;"; ?></div>
        <div class="icon"><?php showIcon("Private Record", "ui-icon-locked", 0); ?></div>
    </div>

    <div class="saveButton">
        <input type="checkbox" id="saveBtn" /><label for="saveBtn">Save</label>
    </div>
    
</div>

<?php echo CHtml::endForm(); ?>
