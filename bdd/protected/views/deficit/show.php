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
    .tablelabelcel {
	    width: 240px;
    }   
</style>

<script>
    // Inicia configuracoes Javascript
    $(document).ready(bootDeficit);
    
    function bootDeficit() {
    
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
        configHideShowButtons();
        configPrintButton();
    }
    // Configuracoes iniciais
    function configInitial() {
        $("#editBtn").button();

        // Evento onclick do botao edit
        $("#editBtn").click(function(){
             window.location = "index.php?r=deficit/goToMaintain&id="+$("#DeficitAR_iddeficit").val();
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
    function configHideShowButtons() {
    	$("#hideBtn").button();
    	$("#showBtn").button();    
    		
        $("#hideBtn").click(function(){
            $("td.tablefieldcel:empty").parent().hide();
            $("div.accordionRight:empty").parent().hide();
            $("#hideBtn").parent().hide();
            $("#showBtn").parent().show();
            $("#showBtn").attr("checked", true);
            $("#hideBtn").attr("checked", true);
        });
        
        $("#showBtn").click(function(){
            $("td.tablefieldcel:empty").parent().show();
            $("div.accordionRight:empty").parent().show();
            $("#hideBtn").parent().show();
            $("#showBtn").parent().hide();
            $("#showBtn").attr("checked", true);
            $("#hideBtn").attr("checked", true);
        });
        
        //empty fields starts hidden
        $("td.tablefieldcel:empty").parent().hide();
        $("div.accordionRight:empty").parent().hide();
        $("#hideBtn").parent().hide();
        $("#showBtn").parent().show();
        $("#showBtn").attr("checked", true);
        $("#hideBtn").attr("checked", true);
    }
    
    function configPrintButton() {
    	$("#printButton").button();
	    $("#printButton").click(function() {
	    	var windowReference = window.open('index.php?r=loadingfile/goToShow');
		   $.ajax({ type:'GET',
                    url:'index.php?r=deficit/print',
                    data: {
                    	"id": $('#DeficitAR_iddeficit').val()
                    },
                    dataType: "json",
                    success:function(json) {
	                    windowReference.location = json;
                    }
           });
	    });
    }
    
    function printPDF(iddeficit) {
    	window.open("index.php?r=deficit/goToPrint&id="+iddeficit);
    }
    
</script>

<div id="Notification"></div>

<?php echo CHtml::beginForm('','post',array ('id'=>'form')); ?>
<?php echo CHtml::activeHiddenField($deficit,'iddeficit');?>

<!-- TEXTO INTRODUTORIO ----------------------------------------------->

<div class="introText">
    <h1><?php echo Yii::t('yii','View an existing deficit record'); ?></h1>
    <p><?php echo Yii::t('yii',"Use this tool to view records of pollination deficit assessment and detection studies."); ?></p>
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
                <td class="tablefieldcel"><?php echo $deficit->fieldnumber; ?></td>
                <td class="acIcon"></td>
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
                <td class="tablefieldcel"><?php echo $deficit->commonnamefocalcrop->commonnamefocalcrop;?></td>
                <td class="acIcon"></td>
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

                <td class="tablefieldcel"><?php echo $deficit->year; ?></td>
                <td class="acIcon"></td>
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
                <td class="tablefieldcel"><?php echo $deficit->focuscrop->focuscrop;?></td>
                <td class="acIcon"></td>
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
                <td class="tablefieldcel"><?php echo $deficit->size; ?></td>
                <td class="acIcon"></td>
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
                <td class="tablefieldcel"><?php echo $deficit->treatment->treatment; ?></td>
                <td class="acIcon"></td>
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
                <td class="tablefieldcel"><?php echo $deficit->date; ?></td>
                <td class="acIcon"></td>
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
                <td class="tablefieldcel"><?php echo $deficit->observer->observer; ?></td>
                <td class="acIcon"></td>
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

                <td class="tablefieldcel"><?php echo $deficit->recordingnumber; ?></td>
                <td class="acIcon"></td>
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
                <td class="tablefieldcel"><?php echo $deficit->plotnumber; ?></td>
                <td class="acIcon"></td>
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

                <td class="tablefieldcel"><?php echo $deficit->numberflowersobserved; ?></td>
                <td class="acIcon"></td>
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
                <td class="tablefieldcel"><?php echo $deficit->remark; ?></td>
                <td class="acIcon"></td>
            </tr>
        </div>
    </table>
    
     <div id="showHideBtn" class="saveButton" style="clear:both;">
    	<div style="margin-right:40%;"><input type="checkbox" id="showBtn" /><label for="showBtn">Show empty fields</label></div>
    	<div style="margin-right:40%;"><input type="checkbox" id="hideBtn" /><label for="hideBtn">Hide empty fields</label></div>
    </div>
    
    <div id="locationAccordion">
    	<h3><a href="#">Location</a></h3>
    	<div>
    		<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel(CountryAR::model(),'country');?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=country',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo $deficit->localityelement->country->country;?></div>
		    	<div class="acIcon"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel(StateProvinceAR::model(),'stateprovince');?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=stateprovince',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo $deficit->localityelement->stateprovince->stateprovince;?></div>
		    	<div class="acIcon"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel(CountyAR::model(),'county');?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=county',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo $deficit->localityelement->county->county;?></div>
		    	<div class="acIcon"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel(MunicipalityAR::model(),'municipality');?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=municipality',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo $deficit->localityelement->municipality->municipality;?></div>
		    	<div class="acIcon"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo "Locality references" //echo CHtml::activeLabel(LocalityAR::model(),'locality');?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=locality',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo $deficit->localityelement->locality->locality;?></div>
		    	<div class="acIcon"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel(Site_AR::model(),'site_');?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=site_',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo $deficit->localityelement->site_->site_;?></div>
		    	<div class="acIcon"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel($deficit->geospatialelement, "decimallatitude"); ?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=decimallatitude',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo $deficit->geospatialelement->decimallatitude; ?></div>
		    	<div class="acIcon"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel($deficit->geospatialelement, "decimallongitude"); ?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=decimallongitude',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo $deficit->geospatialelement->decimallongitude; ?></div>
		    	<div class="acIcon"></div>
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
		    	<div class="accordionRight"><?php echo $deficit->typeholding->typeholding;?></div>
		    	<div class="acIcon"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel($deficit, "fieldsize"); ?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=fieldsize',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo $deficit->fieldsize; ?></div>
		    	<div class="acIcon"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel($deficit, "dimension"); ?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=dimension',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo $deficit->dimension; ?></div>
		    	<div class="acIcon"></div>
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
		    	<div class="accordionRight"><?php echo $deficit->localityelement->verbatimelevation; ?></div>
		    	<div class="acIcon"></div>
		    	<div style="clear:both;"></div>
	    	</div>
    		
    		<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel(TopograficalSituationAR::model(),'topograficalsituation');?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=topograficalsituation',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo $deficit->topograficalsituation->topograficalsituation;?></div>
		    	<div class="acIcon"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel(SoilTypeAR::model(),'soiltype');?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=soiltype',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo $deficit->soiltype->soiltype;?></div>
		    	<div class="acIcon"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel(SoilPreparationAR::model(),'soilpreparation');?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=typeholding',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo $deficit->soilpreparation->soilpreparation;?></div>
		    	<div class="acIcon"></div>
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
		    	<div class="accordionRight"><?php echo $deficit->hedgesurroundingfield = 1 ? "yes" : "no"; ?></div>
		    	<div class="acIcon"></div>
		    	<div style="clear:both;"></div>
	    	</div>
    		
    		<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel(MainPlantSpeciesInHedgeAR::model(),'mainplantspeciesinhedge');?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=mainplantspeciesinhedge',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo $deficit->mainplantspeciesinhedge->mainplantspeciesinhedge;?></div>
		    	<div class="acIcon"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel($deficit, "distanceofnaturalhabitat"); ?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=distanceofnaturalhabitat',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo $deficit->distanceofnaturalhabitat; ?></div>
		    	<div class="acIcon"></div>
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
		    	<div class="accordionRight"><?php echo $deficit->scientificname->scientificname;?></div>
		    	<div class="acIcon"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel(ProductionVarietyAR::model(),'productionvariety');?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=productionvariety',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo $deficit->productionvariety->productionvariety;?></div>
		    	<div class="acIcon"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel($deficit, "varietypollenizer"); ?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=varietypollenizer',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo $deficit->varietypollenizer; ?></div>
		    	<div class="acIcon"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel(OriginSeedsAR::model(),'originseeds');?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=originseeds',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo $deficit->originseeds->originseeds;?></div>
		    	<div class="acIcon"></div>
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
		    	<div class="accordionRight"><?php echo $deficit->plantingdate; ?></div>
		    	<div class="acIcon"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel(TypePlantingAR::model(),'typeplanting');?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=typeplanting',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo $deficit->typeplanting->typeplanting;?></div>
		    	<div class="acIcon"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel($deficit, "plantdensity"); ?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=plantdensity',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo $deficit->plantdensity; ?></div>
		    	<div class="acIcon"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel(TypeStandAR::model(),'typestand');?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=typestand',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo $deficit->typestand->typestand;?></div>
		    	<div class="acIcon"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel($deficit, "ratiopollenizertree"); ?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=ratiopollenizertree',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo $deficit->ratiopollenizertree; ?></div>
		    	<div class="acIcon"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel($deficit, "distancebetweenrows"); ?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=distancebetweenrows',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo $deficit->distancebetweenrows; ?></div>
		    	<div class="acIcon"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel($deficit, "distanceamongplantswithinrows"); ?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=distanceamongplantswithinrows',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo $deficit->distanceamongplantswithinrows; ?></div>
		    	<div class="acIcon"></div>
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
		    	<div class="accordionRight"><?php echo $deficit->timeatstart; ?></div>
		    	<div class="acIcon"></div>
		    	<div style="clear:both;"></div>
	    	</div>
    		
    		<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel($deficit, "period"); ?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=period',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo $deficit->period; ?></div>
		    	<div class="acIcon"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel(WeatherConditionAR::model(),'weathercondition');?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=weathercondition',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo $deficit->weathercondition->weathercondition;?></div>
		    	<div class="acIcon"></div>
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
		    	<div class="accordionRight"><?php echo $deficit->apismellifera; ?></div>
		    	<div class="acIcon"></div>
		    	<div style="clear:both;"></div>
	    	</div>
    		
    		<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel($deficit, "bumblebees"); ?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=bumblebees',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo $deficit->bumblebees; ?></div>
		    	<div class="acIcon"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel($deficit, "otherbees"); ?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=otherbees',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo $deficit->otherbees; ?></div>
		    	<div class="acIcon"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    	
	    	<div class="divAccordion">
		    	<div class="accordionLeft"><?php echo CHtml::activeLabel($deficit, "other"); ?></div>
		    	<div class="accordionMiddle"><?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=other',array('rel'=>'lightbox'));?></div>
		    	<div class="accordionRight"><?php echo $deficit->other; ?></div>
		    	<div class="acIcon"></div>
		    	<div style="clear:both;"></div>
	    	</div>
	    </div>
    </div>
    
    <div class="privateRecord">
        <div class="title"><?php echo $deficit->isrestricted ? "This is a private record." : "This is not a private record." ; ?></div>
        <div class="icon"><?php if ($deficit->isrestricted) showIcon("Private Record", "ui-icon-locked", 0); else showIcon("Not Private Record", "ui-icon-unlocked", 0) ; ?></div>
    </div>

    <div class="saveButton">
        <input type="checkbox" id="printButton" /><label for="printButton">Print</label>
        <input type="checkbox" id="editBtn" /><label for="editBtn">Edit</label>
    </div>
    
</div>

<?php echo CHtml::endForm(); ?>
