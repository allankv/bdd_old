<?php
$cs=Yii::app()->clientScript;
$cs->registerScriptFile("js/jquery/jquery.min.js",CClientScript::POS_BEGIN);
$cs->registerScriptFile("js/lightbox/lightbox.js",CClientScript::POS_BEGIN);
$cs->registerCssFile("css/lightbox.css");
//$cs->registerScriptFile("js/lightbox/recordlevelelements.js",CClientScript::POS_HEAD);
//$cs->registerScriptFile("js/lightbox/localityelements.js",CClientScript::POS_HEAD);
$cs->registerScriptFile("js/validation/validationdata.js",CClientScript::POS_BEGIN);
$cs->registerScriptFile("js/Maintain.js",CClientScript::POS_BEGIN);
$cs->registerScriptFile("js/Geo.js",CClientScript::POS_BEGIN);
$cs->registerScriptFile("js/validation/jquery.numeric.pack.js",CClientScript::POS_BEGIN);
$cs->registerScriptFile("js/jquery.jstepper.js",CClientScript::POS_BEGIN);
$cs->registerCssFile("js/tips/tip-twitter/tip-twitter.css");
$cs->registerScriptFile("js/tips/jquery.poshytip.min.js",CClientScript::POS_END);
include "protected/extensions/config.php";

$cs->registerScriptFile("js/autocomplete.js",CClientScript::POS_END);
$cs->registerScriptFile("js/loadfields.js",CClientScript::POS_END);
?>

<link href="css/jquery.jnotify.css" rel="stylesheet" type="text/css" />
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/ui-lightness/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>
<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
<script src="js/jquery.jnotify.js" type="text/javascript"></script>
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
<style type="text/css">
    #slider {
        margin: 10px;
    }
    input.ui-button {
        padding: .4em 1em; width:182px; margin-left:10px;
    }
    .tablelabelcel {
    	width:250px;
    }
</style>

<script type="text/javascript">
    
    $(document).ready(bootMonitoring);
    function bootMonitoring(){

        //Configs
        configInitial();
        configAccordion();
        configNotify();
        configIcons();
        configHideShowButtons();
        configPrintButton();

        //geocoding($('#GeospatialElementAR_decimallatitude').val(),$('#GeospatialElementAR_decimallongitude').val());
        //configLocation();

    }
    function configInitial() {
        $("#editBtn").button();

        // Evento onclick do botao edit
        $("#editBtn").click(function(){
             window.location = "index.php?r=monitoring/goToMaintain&id="+$("#MonitoringAR_idmonitoring").val();
         });
    }
    function configAccordion() {
        // Cria accordions apartir das divs
        $( "#dadosAmbientaisAccordion").accordion({collapsible: true,autoHeight: false,navigation: true});
        $( "#panTrapsAccordion" ).accordion({collapsible: true,autoHeight: false,navigation: true});
        $( "#taxonomicElementsAccordion" ).accordion({collapsible: true,autoHeight: false,navigation: true});
        $( "#localityElementsAccordion" ).accordion({collapsible: true,autoHeight: false,navigation: true});
        $( "#dadosEspecimeAccordion" ).accordion({collapsible: true,autoHeight: false,navigation: true});

        // Fecha todas
        $( "#dadosAmbientaisAccordion").accordion("activate" ,false);
        $( "#panTrapsAccordion" ).accordion("activate" ,false);
        $( "#taxonomicElementsAccordion" ).accordion("activate" ,false);
        $( "#localityElementsAccordion" ).accordion("activate" ,false);
        $( "#dadosEspecimeAccordion" ).accordion("activate" ,false);
    }

    function showTaxonomicTip(kingdom, phylum, class_, order, family, genus, subgenus, specificepithet, infraspecificepithet)
    {
        $('#taxsuggest').poshytip('hide');
        $('#taxsuggest').poshytip('destroy');

        //Clear the entries if null
        if (order == null)
        {order = '';}
        if (family == null)
        {family = '';}
        if (genus == null)
        {genus = '';}
        if (subgenus == null)
        {subgenus = '';}
        
        var tip = '<div style="font-weight:normal;"><div style="clear:both"></div><div class="tipKey">Order</div><div class="tipValue">'+order+'</div><div style="clear:both"></div><div class="tipKey">Family</div><div class="tipValue">'+family+'</div><div style="clear:both"></div><div class="tipKey">Genus</div><div class="tipValue">'+genus+'</div><div style="clear:both"></div><div class="tipKey">Subgenus</div><div class="tipValue">'+subgenus+'</div><div style="clear:both"></div><div style="clear:both"></div></div>';

        $('#taxsuggest').poshytip({
            className: 'tip-twitter',
            showTimeout: 500,
            alignTo: 'target',
            alignX: 'right',
            alignY: 'center',
            showOn: 'none',
            content: tip
        }).poshytip('show');

        setTimeout(function() {
            $('#taxsuggest').poshytip('hide');
            setTimeout(function(){
                $('#taxsuggest').poshytip('destroy');
            }, 1000);
        }, 5000);
    }

    function configHideShowButtons() {
    	$("#hideBtn").button();
    	$("#showBtn").button();    
    		
        $("#hideBtn").click(function(){
            $("td.tablefieldcel:empty").parent().hide();
            $("td.tablelabelcel:empty").parent().hide();
            $("div.accordionRight:empty").parent().hide();
            $("#hideBtn").parent().hide();
            $("#showBtn").parent().show();
            $("#showBtn").attr("checked", true);
            $("#hideBtn").attr("checked", true);
        });
        
        $("#showBtn").click(function(){
            $("td.tablefieldcel:empty").parent().show();
            $("td.tablelabelcel:empty").parent().show();
            $("div.accordionRight:empty").parent().show();
            $("#hideBtn").parent().show();
            $("#showBtn").parent().hide();
            $("#showBtn").attr("checked", true);
            $("#hideBtn").attr("checked", true);
        });
        
        //empty fields starts hidden
        $("td.tablefieldcel:empty").parent().hide();
        $("td.tablelabelcel:empty").parent().hide();
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
                    url:'index.php?r=monitoring/print',
                    data: {
                    	"id": $('#MonitoringAR_idmonitoring').val()
                    },
                    dataType: "json",
                    success:function(json) {
	                    windowReference.location = json;
                    }
           });
		});
    }

</script>

<div id="Notification"></div>

<?php echo CHtml::beginForm('','post',array ('id'=>'form')); ?>
<?php echo CHtml::activeHiddenField($monitoring,'idmonitoring');?>
<?php echo CHtml::activeHiddenField($monitoring,'idrecordlevelelement');?>
<?php echo CHtml::activeHiddenField($monitoring->recordlevelelement,'idrecordlevelelement');?>
<?php echo CHtml::activeHiddenField($monitoring->recordlevelelement,'globaluniqueidentifier');?>
<?php echo CHtml::activeHiddenField($monitoring,'idoccurrenceelement');?>
<?php echo CHtml::activeHiddenField($monitoring->occurrenceelement,'idoccurrenceelement');?>
<?php echo CHtml::activeHiddenField($monitoring,'idtaxonomicelement');?>
<?php echo CHtml::activeHiddenField($monitoring,'idlocalityelement');?>
<?php echo CHtml::activeHiddenField($monitoring->localityelement,'idlocalityelement');?>
<?php echo CHtml::activeHiddenField($monitoring,'idgeospatialelement');?>
<?php echo CHtml::activeHiddenField($monitoring->geospatialelement,'idgeospatialelement');?>

<div class="introText">
    <h1><?php echo Yii::t('yii','Visualizar um registro existente de Monitoramento'); ?></h1>
    <p><?php echo Yii::t('yii',"Use esta ferramenta para visualizar registros de monitoramento de espécimes biológicas, suas ocorrências espaço-temporais, e suas outras informações."); ?></p>
</div>

<div class="yiiForm" style="width:85%">
    <div class="staticMap">
        <!--<span id="loc"></span>-->
        
    </div>
    <div class="attention">
        <?php echo CHtml::image('images/main/attention.png','',array('border'=>'0px'))."&nbsp;".Yii::t('yii', "Main Fields");?>
        (<span style="color: red; font-weight: bold;"><?php echo Yii::t('yii',"Campos com * são obrigatórios"); ?></span>)
    </div>
    
    <table cellspacing="0" cellpadding="0" align="center" class="tablerequired" style="margin-bottom:12px;">
        <div class="tablerow" id='divbasisofrecord'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::label(Yii::t('yii','Base do Registro'), ""); ?>
                    <span class="required">*</span>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=basisofrecord',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel"><?php echo $monitoring->recordlevelelement->basisofrecord->basisofrecord;?></td>
                <td class="acIcon"></td>
            </tr>
        </div>
        <div class="tablerow" id='divinstitutioncode'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::label(Yii::t('yii','Código de Instituição'), ""); ?>
                    <span class="required">*</span>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=institutioncode',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel"><?php echo $monitoring->recordlevelelement->institutioncode->institutioncode;?></td>
                <td class="acIcon"></td>
                </td>
            </tr>
        </div>
        <div class="tablerow" id='divcollectioncode'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::label(Yii::t('yii','Código de Coleção'), ""); ?>
                    <span class="required">*</span>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=collectioncode',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel"><?php echo $monitoring->recordlevelelement->collectioncode->collectioncode;?></td>
                <td class="acIcon"></td>
                </td>
            </tr>
        </div>
        <div class="tablerow" id='divcatalognumber'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::label(Yii::t('yii','Número de Catálogo'), ""); ?>
                    <span class="required">*</span>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=catalognumber',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel"><?php echo $monitoring->occurrenceelement->catalognumber; ?></td>
                <td class="acIcon"></td>
            </tr>
        </div>
        <div class="tablerow" id='dividgeral'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','ID Geral'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=idgeral',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $monitoring->idgeral; ?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
        <div class="tablerow" id='divscientificname'>
            <tr style="display:none">
                <td class="tablelabelcel">
                    <?php echo CHtml::label(Yii::t('yii','Nome Científico'), ""); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=scientificname',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete"><?php echo $monitoring->taxonomicelement->scientificname->scientificname;?></td>
                <td class="acIcon"></td>
            </tr>
        </div>
        <div class="tablerow" id='divmorphospecies'>
            <tr style="display:none">
                <td class="tablelabelcel">
                    <?php echo CHtml::label(Yii::t('yii','Morfoespécie'), ""); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=morphospecies',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete"><?php echo $monitoring->taxonomicelement->morphospecies->morphospecies;?></td>
                <td class="acIcon"></td>
            </tr>
        </div>
        <div class="tablerow" id='divtaxoname'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::label(Yii::t('yii','Nome científico'), ""); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=scientificname',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel">
                    <div class="field autocomplete"><?php echo $monitoring->taxonomicelement->scientificname->scientificname==''?$monitoring->taxonomicelement->morphospecies->morphospecies:$monitoring->taxonomicelement->scientificname->scientificname;?></td>
                <td class="acIcon"></td>
            </tr>
        </div>
        <tr>
            <td class="tablelabelcel" colspan=4></td>
        </tr>
        <div class="tablerow" id='divdenomination'>
            <tr>
                <td class="tablelabelcel">
                    <?php// echo CHtml::activeLabel($monitoring->denomination, 'denomination');?>
                    <?php echo CHtml::label(Yii::t('yii','Denominação'), ""); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=denomination',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel"><?php echo $monitoring->denomination->denomination;?></td>
                <td class="acIcon"></td>
            </tr>
        </div>
        <div class="tablerow" id='divtechnicalcollection'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::label(Yii::t('yii','Técnica de Coleta'), ""); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=technicalcollection',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel"><?php echo $monitoring->technicalcollection->technicalcollection;?></td>
                <td class="acIcon"></td>
            </tr>
        </div>
        <div class="tablerow" id='divdigitizer'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::label(Yii::t('yii','Digitador'), ""); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=digitizer',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel"><?php echo $monitoring->digitizer->digitizer;?></td>
                <td class="acIcon"></td>
            </tr>
        </div>
        <div class="tablerow" id='divcollector'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::label(Yii::t('yii','Coletor'), ""); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=collector',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel"><?php echo $monitoring->collector->collector;?></td>
                <td class="acIcon"></td>
            </tr>
        </div>
        <tr>
            <td class="tablelabelcel" colspan=4></td>
        </tr>
        <div class="tablerow" id='divdecimallatitude'>
            <tr>  
                <td class="tablelabelcel">
                    <?php echo CHtml::label(Yii::t('yii','Latitude (Graus Decimais)'), ""); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=decimallatitude',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel"><?php echo $monitoring->geospatialelement->decimallatitude;?></td>
                <td class="acIcon"></td>
                <td rowspan=2>
                    <div class="field autocomplete">
                        <!--<input type="button" value="BDD Georeferencing Tool" id="bgtBtn">-->
                    </div>
                </td>
            </tr>
        </div>
        <div class="tablerow" id='divdecimallongitude'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::label(Yii::t('yii','Longitude (Graus Decimais)'), ""); ?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=decimallongitude',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel"><?php echo $monitoring->geospatialelement->decimallongitude;?></td>
                <td class="acIcon"></td>
            </tr>
        </div>
        <!--<tr>
            <td class="tablelabelcel" colspan=4>
            </td>
        </tr>-->
        <div class="tablerow" id='divdecimallongitude'>
            <tr>
                <td class="tablelabelcel"><?php echo '';?></td>
                <td class="tablemiddlecel">
                    <?php echo '';?>                    
                </td>
                <td class="tablefieldcel">
                    
                </td>
            </tr>
        </div>
        <!--<tr>
            <td class="tablelabelcel" colspan=4>
            </td>
        </tr>
        <tr id="locationField">
            <td class="tablelabelcel">
                <?php //echo 'Location'?>
            </td>
            <td class="tablemiddlecel">
            </td>
            <td class="tablefieldcel">
                <?php //echo CHtml::textField('location', '', array('id'=>'location'));?>
            </td>
        </tr>-->      
        <tr id="countryField">
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','País'), ""); ?>
            </td>
            <td class="tablemiddlecel">
            </td>
            <td class="tablefieldcel"><?php echo $monitoring->localityelement->country->country;?></td>
             <td class="acIcon"></td>
        </tr>
        <tr id="stateProvinceField">
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Estado ou Província'), ""); ?>
            </td>
            <td class="tablemiddlecel">
            </td>
            <td class="tablefieldcel"><?php echo $monitoring->localityelement->stateprovince->stateprovince;?></td>
            <td class="acIcon"></td>
        </tr>
<!--        
			<tr id="countyField">
            <td class="tablelabelcel">
                <?php echo CHtml::activeLabel(CountyAR::model(),'county');?>
            </td>
            <td class="tablemiddlecel">
            </td>
            <td class="tablefieldcel">
                <?php echo CHtml::activeHiddenField($monitoring->localityelement,'idcounty');?>
                <?php echo CHtml::activeTextField($monitoring->localityelement->county,'county');?>
            </td>
            <td class="acIcon" id="autocompleteCounty">
            </td>
        </tr>
-->
        <tr id="municipalityField">
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Município'), ""); ?>
            </td>
            <td class="tablemiddlecel">
            </td>
            <td class="tablefieldcel"><?php echo $monitoring->localityelement->municipality->municipality;?></td>
            <td class="acIcon"></td>
        </tr>
        <tr id="localityField">
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Localidade'), ""); ?>
            </td>
            <td class="tablemiddlecel">
            </td>
            <td class="tablefieldcel"><?php echo $monitoring->localityelement->locality->locality;?></td>
            <td class="acIcon"></td>
        </tr>
        <tr>
            <td class="tablelabelcel" colspan=4></td>
        </tr>
    </table>
    
    <div id="showHideBtn" class="saveButton" style="clear:both;">
    	<div style="margin-right:40%;"><input type="checkbox" id="showBtn" /><label for="showBtn">Show empty fields</label></div>
    	<div style="margin-right:40%;"><input type="checkbox" id="hideBtn" /><label for="hideBtn">Hide empty fields</label></div>
    </div>
    
    
    <div id="dadosAmbientaisAccordion">
        <h3><a href="#">Dados Ambientais</a></h3>
        <div>
           <table cellspacing="0" cellpadding="0" align="center" class="normalFieldsTable">
    <div class="tablerow" id='divculture'>
        <tr>
            <td class="tablelabelcel">
                <?php// echo CHtml::activeLabel($monitoring->culture, 'culture');?>
                <?php echo CHtml::label(Yii::t('yii','Cultura'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=culture',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $monitoring->culture->culture;?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divcultivar'>
        <tr>
            <td class="tablelabelcel">
                <?php// echo CHtml::activeLabel($monitoring->cultivar, 'cultivar');?>
                <?php echo CHtml::label(Yii::t('yii','Cultivar'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=cultivar',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $monitoring->cultivar->cultivar;?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divsurroundingsvegetation'>
        <tr>
            <td class="tablelabelcel">
                <?php// echo CHtml::activeLabel($monitoring->surroundingsculture, 'surroundingsculture');?>
                <?php echo CHtml::label(Yii::t('yii','Vegetação Próxima'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=surroundingsvegetation',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $monitoring->surroundingsvegetation->surroundingsvegetation;?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divpredominantbiome'>
        <tr>
            <td class="tablelabelcel">
                <?php// echo CHtml::activeLabel($monitoring->predominantbiome, 'predominantbiome');?>
                <?php echo CHtml::label(Yii::t('yii','Bioma Predominante'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=predominantbiome',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $monitoring->predominantbiome->predominantbiome;?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
</table>
        </div>
    </div>
    <div id="panTrapsAccordion">
        <h3><a href="#">Pan Traps</a></h3>
        <div>
            
<table cellspacing="0" cellpadding="0" align="center" class="normalFieldsTable">
    <div class="tablerow" id='divinstallationdate'>
        <tr>
            <td class="tablelabelcel">
                <?php// echo CHtml::activeLabel($monitoring, "installationdate");?>
                <?php echo CHtml::label(Yii::t('yii','Data da Instalação'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=installationdate',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $monitoring->installationdate; ?></td>
            <td><span style="font-size: 10px;"> YYYY/MM/DD</span></td>
        </tr>
    </div>
    <div class="tablerow" id='divinstallationtime'>
        <tr>
            <td class="tablelabelcel">
                <?php// echo CHtml::activeLabel($monitoring, "installationtime");?>
                <?php echo CHtml::label(Yii::t('yii','Hora da Instalação'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=installationtime',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $monitoring->installationtime; ?></td>
            <td><span style="font-size: 10px;">24 hh:mm:ss</span></td>
        </tr>
    </div>
    <div class="tablerow" id='divcollectdate'>
        <tr>
            <td class="tablelabelcel">
                <?php// echo CHtml::activeLabel($monitoring, "collectdate");?>
                <?php echo CHtml::label(Yii::t('yii','Data da Coleta'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=collectdate',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $monitoring->collectdate; ?></td>
            <td><span style="font-size: 10px;"> YYYY/MM/DD</span></td>
        </tr>
    </div>
    <div class="tablerow" id='divcollecttime'>
        <tr>
            <td class="tablelabelcel">
                <?php// echo CHtml::activeLabel($monitoring, "collecttime");?>
                <?php echo CHtml::label(Yii::t('yii','Hora da Coleta'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=collecttime',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $monitoring->collecttime; ?></td>
            <td><span style="font-size: 10px;">24 hh:mm:ss</span></td>
        </tr>
    </div>
    <div class="tablerow" id='divsurroundingsculture'>
        <tr>
            <td class="tablelabelcel">
                <?php// echo CHtml::activeLabel($monitoring->surroundingsculture, 'surroundingsculture');?>
                <?php echo CHtml::label(Yii::t('yii','Entorno/Cultura'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=surroundingsculture',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $monitoring->surroundingsculture->surroundingsculture;?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divplotnumber'>
        <tr>
            <td class="tablelabelcel">
                <?php //echo CHtml::activeLabel($monitoring, "plotnumber");?>
                <?php echo CHtml::label(Yii::t('yii','Identificação Número do Plot'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=plotnumber',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $monitoring->plotnumber; ?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divamostralnumber'>
        <tr>
            <td class="tablelabelcel">
                <?php// echo CHtml::activeLabel($monitoring, "amostralnumber");?>
                <?php echo CHtml::label(Yii::t('yii','Identificação Número da Unidade Amostral'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=amostralnumber',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $monitoring->amostralnumber; ?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divcolorpantrap'>
        <tr>
            <td class="tablelabelcel">
                <?php// echo CHtml::activeLabel($monitoring->colorpantrap, 'colorpantrap');?>
                <?php echo CHtml::label(Yii::t('yii','Cor do Pan Trap'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=colorpantrap',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $monitoring->colorpantrap->colorpantrap;?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='supporttype'>
        <tr>
            <td class="tablelabelcel">
                <?php //echo CHtml::activeLabel($monitoring, "plotnumber");?>
                <?php echo CHtml::label(Yii::t('yii','Tipo de Suporte'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=supporttype',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $monitoring->supporttype->supporttype;?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divfloorheight'>
        <tr>
            <td class="tablelabelcel">
                <?php// echo CHtml::activeLabel($monitoring, "floorheight");?>
                <?php echo CHtml::label(Yii::t('yii','Altura do Chão'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=floorheight',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $monitoring->floorheight; ?></td>
            <td class="acIcon"><span style="font-size: 10px; position: relative; top: 6px;">cm</span></td>
        </tr>
    </div>
</table>
        </div>
    </div>
    <div id="taxonomicElementsAccordion">
        <h3><a href="#">Taxonomia do Espécime</a></h3>
        <div>
        	 <?php
            echo Yii::app()->controller->renderPartial('/monitoringtaxonomic/maintain', array(
            'taxonomicElement'=>$monitoring->taxonomicelement,
            ));
            ?>
            <div class="subgroup" style="background-color: transparent;"><?php echo Yii::t('yii','Taxa'); ?></div>

<?php echo CHtml::activeHiddenField($monitoring->taxonomicelement,'idtaxonomicelement');?>
<?php echo CHtml::activeHiddenField($monitoring->taxonomicelement,'idtaxonrank');?>
<?php echo CHtml::activeHiddenField($monitoring->taxonomicelement,'idscientificnameauthorship');?>
<?php echo CHtml::activeHiddenField($monitoring->taxonomicelement,'idnomenclaturalcode');?>
<?php echo CHtml::activeHiddenField($monitoring->taxonomicelement,'idacceptednameusage');?>
<?php echo CHtml::activeHiddenField($monitoring->taxonomicelement,'idparentnameusage');?>
<?php echo CHtml::activeHiddenField($monitoring->taxonomicelement,'idoriginalnameusage');?>
<?php echo CHtml::activeHiddenField($monitoring->taxonomicelement,'idnameaccordingto');?>
<?php echo CHtml::activeHiddenField($monitoring->taxonomicelement,'idnamepublishedin');?>
<?php echo CHtml::activeHiddenField($monitoring->taxonomicelement,'idtaxonconcept');?>
<?php echo CHtml::activeHiddenField($monitoring->taxonomicelement,'idtaxonomicstatus');?>

<table cellspacing="0" cellpadding="0" align="center" class="normalFieldsTable">
    <div class="tablerow" id='divorder'>
        <tr>
            <td class="tablelabelcel">
                <?php// echo CHtml::activeLabel(OrderAR::model(), "order");?>
                <?php echo CHtml::label(Yii::t('yii','Ordem'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=order',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $monitoring->taxonomicelement->order->order;?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divfamily'>
        <tr>
            <td class="tablelabelcel">
                <?php //echo CHtml::activeLabel(FamilyAR::model(), "family");?>
                <?php echo CHtml::label(Yii::t('yii','Família'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=family',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $monitoring->taxonomicelement->family->family;?></td>
            <td class="acIcon"></td>
    </div>
    <div class="tablerow" id='divtribe'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Tribo'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=tribe',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $monitoring->taxonomicelement->tribe->tribe;?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divsubtribe'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Sub-tribo'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=subtribe',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $monitoring->taxonomicelement->subtribe->subtribe;?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divgenus'>
        <tr>
            <td class="tablelabelcel">
                <?php //echo CHtml::activeLabel(GenusAR::model(), "genus");?>
                <?php echo CHtml::label(Yii::t('yii','Gênero'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=genus',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $monitoring->taxonomicelement->genus->genus;?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
<!--
    <div class="tablerow" id='divsubgenus'>
        <tr>
            <td class="tablelabelcel">
                <?php //echo CHtml::activeLabel(SubgenusAR::model(), "subgenus");?>
                <?php echo CHtml::label(Yii::t('yii','Sub-gênero'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=subgenus',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel">
                <div class="field autocomplete">
                    <?php echo CHtml::activeHiddenField($monitoring->taxonomicelement,'idsubgenus');?>
                    <?php echo CHtml::activeTextField($monitoring->taxonomicelement->subgenus, 'subgenus', array('class'=>'textfield'));?>
                </div>
            </td>
            <td class="acIcon" id="autocompleteSubgenus">
            </td>
        </tr>
    </div>
-->
    <div class="tablerow" id='divspeciesname'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Espécie'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=species',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $monitoring->taxonomicelement->speciesname->speciesname;?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divsubspecies'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Sub-espécie'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=subspecies',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $monitoring->taxonomicelement->subspecies->subspecies;?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divpopularname'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Nome Popular'), ""); ?>

            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=subtribe',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $monitoring->taxonomicelement->vernacularname;?></td>
            <td class="acIcon"></td>
        </tr>
    </div>

</table>
        </div>
    </div>
    <div id="localityElementsAccordion">
        <h3><a href="#">Localização do Espécime</a></h3>
        <div>
           <table cellspacing="0" cellpadding="0" align="center" class="normalFieldsTable">

    <div class="tablerow" id='divaltitude'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Altitude'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=verbatimelevation',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $monitoring->localityelement->verbatimelevation;?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divgeodeticdatum'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Datum Geodésico'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=coordinateprecision',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $monitoring->geospatialelement->geodeticdatum;?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divlocationremark'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','Dados Complementares da Localidade'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=coordinateprecision',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $monitoring->localityelement->locationremark;?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divcoordinateprecision'>
        <tr>
            <td class="tablelabelcel">
                <?php echo 'Precisão GPS'; ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=coordinateprecision',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $monitoring->localityelement->coordinateprecision;?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divcoordinateprecision'>
        <tr>
            <td class="tablelabelcel">
                <?php echo CHtml::label(Yii::t('yii','GPS Pontos de Referência'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=coordinateprecision',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $monitoring->geospatialelement->referencepoints;?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
</table>
        </div>
    </div>
    <div id="dadosEspecimeAccordion">
        <h3><a href="#">Dados Sobre o Espécime</a></h3>
        <div>
            
            <table cellspacing="0" cellpadding="0" align="center" class="normalFieldsTable">

    <div class="tablerow" id='divsex'>
        <tr>
            <td class="tablelabelcel">
                <?php// echo CHtml::activeLabel($monitoring->denomination, 'denomination');?>
                <?php echo CHtml::label(Yii::t('yii','Sexo'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=denomination',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $monitoring->occurrenceelement->sex->sex;?></td>
            <td class="acIcon"></td>
        </tr>
    </div>
    <div class="tablerow" id='divweight'>
        <tr>
            <td class="tablelabelcel">
                <?php// echo CHtml::activeLabel($monitoring, "weight");?>
                <?php echo CHtml::label(Yii::t('yii','Peso'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=weight',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $monitoring->weight; ?></td>
            <td class="acIcon"><span style="font-size: 10px; position: relative; top: 6px;">mg</span></td>
        </tr>
    </div>
    <div class="tablerow" id='divwidth'>
        <tr>
            <td class="tablelabelcel">
                <?php //echo CHtml::activeLabel($monitoring, "width");?>
                <?php echo CHtml::label(Yii::t('yii','Largura'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=width',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $monitoring->width; ?></td>
            <td class="acIcon"><span style="font-size: 10px; position: relative; top: 6px;">mm</span></td>
        </tr>
    </div>
    <div class="tablerow" id='divlength'>
        <tr>
            <td class="tablelabelcel">
                <?php //echo CHtml::activeLabel($monitoring, "length");?>
                <?php echo CHtml::label(Yii::t('yii','Comprimento'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=length',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $monitoring->length; ?></td>
            <td class="acIcon"><span style="font-size: 10px; position: relative; top: 6px;">mm</span></td>
        </tr>
    </div>
    <div class="tablerow" id='divheight'>
        <tr>
            <td class="tablelabelcel">
                <?php// echo CHtml::activeLabel($monitoring, "height");?>
                <?php echo CHtml::label(Yii::t('yii','Altura'), ""); ?>
            </td>
            <td class="tablemiddlecel">
                <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=height',array('rel'=>'lightbox'));?>
            </td>
            <td class="tablefieldcel"><?php echo $monitoring->height; ?></td>
            <td class="acIcon"><span style="font-size: 10px; position: relative; top: 6px;">mm</span></td>
        </tr>
    </div>
</table>
        </div>
    </div>
    <div class="privateRecord">
        <div class="title"><?php echo $monitoring->recordlevelelement->isrestricted ? "This is a private record." : "This is not a private record." ; ?></div>
        <div class="icon"><?php if ($monitoring->recordlevelelement->isrestricted) showIcon("Private Record", "ui-icon-locked", 0); else showIcon("Not Private Record", "ui-icon-unlocked", 0) ; ?></div>
    </div>

    <div class="saveButton">
	    <input type="checkbox" id="printButton" /><label for="printButton">Print</label>
        <input type="checkbox" id="editBtn" /><label for="editBtn">Edit</label>
    </div>
</div>

<?php echo CHtml::endForm(); ?>