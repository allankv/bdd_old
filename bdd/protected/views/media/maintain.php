<?php include_once("protected/extensions/config.php"); ?>
<script type="text/javascript" src="js/jquery.maskedinput.js"></script>
<script type="text/javascript" src="js/Maintain.js"></script>
<script type="text/javascript" src="js/upload.js"></script>
<link rel="stylesheet" href="http://www.emposha.com/demo/fcbkcomplete_2/style.css" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" src="js/jquery.fcbkcomplete.js"></script>
<link href="js/valums/client/fileuploader.css" rel="stylesheet" type="text/css">
<script src="js/valums/client/fileuploader.js" type="text/javascript"></script>



<style type="text/css">
    #slider {
        margin: 10px;
    }
</style>
<script>
    // Arrays para armazenar listas de NxN
    // Nome padrao: controllerList
    var creatorList = new Array();
    var tagList = new Array();

    // Inicia configuracoes Javascript
    $(document).ready(bootMedia);

    //Date and time formatter
    jQuery(function($){
        $("#MediaAR_timedigitized").mask("99:99:99");
        $("#MediaAR_datedigitized").mask("9999/99/99");
        $("#MediaAR_datedigitized").datepicker({ dateFormat: 'yy/mm/dd' });
        $("#MediaAR_dateavailable").mask("9999/99/99");
        $("#MediaAR_dateavailable").datepicker({ dateFormat: 'yy/mm/dd' });
    });

    function bootMedia(){
        configAutocompleteNN('#MediaAR_idmedia', '#CreatorAR_creator', 'creator', 'Media')
        configAutocompleteNN('#MediaAR_idmedia', '#TagAR_tag', 'tag', 'Media')
        configAutocomplete('#MediaAR_idcategorymedia','#CategoryMediaAR_categorymedia', 'categorymedia');
        configAutocomplete('#MediaAR_idsubcategorymedia','#SubcategoryMediaAR_subcategorymedia', 'subcategorymedia');
        configAutocomplete('#MediaAR_idcapturedevice','#CaptureDeviceAR_capturedevice', 'capturedevice');
        configAutocomplete('#MediaAR_idmetadataprovider','#MetadataProviderAR_metadataprovider', 'metadataprovider');

        var btnAutocomplete ="<div class='btnAutocomplete' style='width:20px;'><ul class='iconJQueryHover iconJQuery ui-widget ui-helper-clearfix'><li class='ui-state-default ui-corner-all'><span class='ui-icon ui-icon-comment'></span></li></ul></div>";

        $('#autocompleteCategory').append('<a href="javascript:suggest(\'#MediaAR_idcategorymedia\',\'#CategoryMediaAR_categorymedia\', \'categorymedia\');">'+btnAutocomplete+'</a>');
        $('#autocompleteSubcategory').append('<a href="javascript:suggest(\'#MediaAR_idsubcategorymedia\',\'#SubcategoryMediaAR_subcategorymedia\', \'subcategorymedia\');">'+btnAutocomplete+'</a>');
        $('#autocompleteCaptureDevice').append('<a href="javascript:suggest(\'#MediaAR_idcapturedevice\',\'#CaptureDeviceAR_capturedevice\', \'capturedevice\');">'+btnAutocomplete+'</a>');
        $('#autocompleteMetadataProvider').append('<a href="javascript:suggest(\'#MediaAR_idmetadataprovider\',\'#MetadataProviderAR_metadataprovider\', \'metadataprovider\');">'+btnAutocomplete+'</a>');
        $('#autocompleteTag').append('<a href="javascript:suggest(\'#TagAR_idtag\',\'#TagAR_tag\', \'tag\');">'+btnAutocomplete+'</a>');
        $('#autocompleteCreator').append('<a href="javascript:suggest(\'#CreatorAR_idcreator\',\'#CreatorAR_creator\', \'creator\');">'+btnAutocomplete+'</a>');

        //Config hover effect for icons
        configIcons();

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
        configUpload('#MediaAR_idfile');   
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
    // Acao de salva
    function save(){
        $.ajax({ type:'POST',
            url:'index.php?r=media/save',
            data: $("#form").serialize(),
            dataType: "json",
            success:function(json) {
                if (json.success) {
                	if ($('#MediaAR_idmedia').val() == '') {
		        		$('#MediaAR_title').val('');     		
		            }
                
                	saveNN(json.id);
                }
                
                showMessage(json.msg, json.success, false);
                $("#saveBtn").button("option", "label", "Save" );
                $('#saveBtn').attr("checked", false);
                $("#saveBtn").button("refresh");

                //Hide taxonomic tip
                $('#taxsuggest').poshytip('hide').poshytip('destroy').replaceWith('');
            }
        });
    }

</script>

<div id="Notification"></div>

<?php echo CHtml::beginForm('','post',array ('id'=>'form')); ?>
<?php echo CHtml::activeHiddenField($media,'idmedia');?>
<?php echo CHtml::activeHiddenField($media,'idfile');?>

<div class="introText">
    <h1><?php echo $media->title != null?Yii::t('yii','Update an existing media record'):Yii::t('yii','Create a new media record'); ?></h1>
    <p><?php echo Yii::t('yii',"Use this tool to save media records of modern biological specimens and information such as format, copyright and date digitized. This set of fields is based on international standards, such as Darwin Core, Dublin Core and their extensions."); ?></p>
</div>

<div class="yiiForm">
    <div class="attention">
        <?php echo CHtml::image('images/main/attention.png','',array('border'=>'0px'))."&nbsp;&nbsp;".Yii::t('yii', "Main Fields");?>
        (<span style="color: red; font-weight: bold;"><?php echo Yii::t('yii',"Fields with * are required"); ?></span>)
    </div> 
    <table cellspacing="0" cellpadding="0" align="center" class="tablerequired" style="margin-bottom:12px;">
        <div class="tablerow" id='divtitle'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel($media, "title"); ?>
                    <span class="required">*</span>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=titlemedia',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel">
                    <?php echo CHtml::activeTextField($media,'title', array('class'=>'textboxtext')); ?>
                </td>
            </tr>
        </div>
        <div class="tablerow" id='divcaption'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel($media,'caption');?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=caption',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel">
                    <?php echo CHtml::activeTextField($media, 'caption', array('class'=>'textboxtext'));?>
                </td>
            </tr>
        </div>
        <div class="tablerow" id='divtypemedia'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel(TypeMediaAR::model(),'typemedia');?>
                    <span class="required">*</span>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=typemedia',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel">
                    <?php echo CHtml::activeDropDownList($media, 'idtypemedia', CHtml::listData(TypeMediaAR::model()->findAll(" 1=1 ORDER BY typemedia "), 'idtypemedia', 'typemedia'), array('empty'=>'-'));?>
                </td>
            </tr>
        </div>
        <div class="tablerow" id='divsubtype'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel(SubtypeAR::model(),'subtype');?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=subtype',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel">
                    <?php echo CHtml::activeDropDownList($media, 'idsubtype', CHtml::listData(SubtypeAR::model()->findAll(" 1=1 ORDER BY subtype "), 'idsubtype', 'subtype'), array('empty'=>'-'));?>
                </td>
            </tr>
        </div>
        <div class="tablerow" id='divcategorymedia'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel(CategoryMediaAR::model(),'categorymedia');?>
                    <span class="required">*</span>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=categoryreference',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel">
                    <?php echo CHtml::activeHiddenField($media,'idcategorymedia');?>
                    <?php echo CHtml::activeTextField($media->categorymedia, 'categorymedia', array('class'=>'textboxtext'));?>
                </td>
                <td class="acIcon" id="autocompleteCategory">
                </td>
            </tr>
        </div>
        <div class="tablerow" id='divsubcategorymedia'>
            <tr>
                <td class="tablelabelcel">
                    <?php echo CHtml::activeLabel(SubcategoryMediaAR::model(),'subcategorymedia');?>
                </td>
                <td class="tablemiddlecel">
                    <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=subcategoryreference',array('rel'=>'lightbox'));?>
                </td>
                <td class="tablefieldcel">
                    <?php echo CHtml::activeHiddenField($media,'idsubcategorymedia');?>
                    <?php echo CHtml::activeTextField($media->subcategorymedia, 'subcategorymedia', array('class'=>'textboxtext'));?>
                </td>
                <td class="acIcon" id="autocompleteSubcategory">
                </td>
            </tr>
        </div>
    </table>
    
    <!--Rest of the fields-->
    <div class="normalFields">
        <table cellspacing="0" cellpadding="0" align="center" class="normalFieldsTable">
            <div class="tablerow" id='divextent'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($media,"extent"); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=extent',array('rel'=>'lightbox'));?>
                    </td>
                    <td class="tablefieldcel">
                        <?php echo CHtml::activeTextField($media,'extent', array('class'=>'textboxtext')); ?>
                    </td>
                </tr>
            </div>
            <div class="tablerow" id='divlanguage'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel(LanguageAR::model(), 'language'); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=language',array('rel'=>'lightbox'));?>
                    </td>
                    <td class="tablefieldcel">
                        <?php echo CHtml::activeDropDownList($media,'idlanguage', CHtml::listData(LanguageAR::model()->findAll(), 'idlanguage', 'language'), array('empty'=>'-')); ?>
                    </td>
                </tr>
            </div>
            <div class="tablerow" id='divdescription'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($media, 'description'); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=description',array('rel'=>'lightbox'));?>
                    </td>
                    <td class="tablefieldcel">
                        <?php echo CHtml::activeTextArea($media,'description',array('class'=>'textarea')); ?>
                    </td>
                </tr>
            </div>
            <div class="tablerow" id='divtag'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel(TagAR::model(),'tag');?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=tag',array('rel'=>'lightbox'));?>
                    </td>
                    <td class="tablefieldcel">
                        <?php echo CHtml::activeHiddenField(TagAR::model(),'idtag');?>
                        <?php echo CHtml::activeTextField(TagAR::model(), 'tag', array('class'=>'textboxtext'));?>
                    </td>
                </tr>
            </div>
            <div class="tablerow" id='divcapturedevice'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel(CaptureDeviceAR::model(),'capturedevice');?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=capturedevice',array('rel'=>'lightbox'));?>
                    </td>
                    <td class="tablefieldcel">
                        <?php echo CHtml::activeHiddenField($media,'idcapturedevice');?>
                        <?php echo CHtml::activeTextField($media->capturedevice, 'capturedevice', array('class'=>'textboxtext'));?>
                    </td>
                    <td class="acIcon" id="autocompleteCaptureDevice">
                    </td>
                </tr>
            </div>
            <div class="tablerow" id='divcreator'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel(CreatorAR::model(),'creator');?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=creator',array('rel'=>'lightbox'));?>
                    </td>
                    <td class="tablefieldcel">
                        <?php echo CHtml::activeHiddenField(CreatorAR::model(),'idcreator');?>
                        <?php echo CHtml::activeTextField(CreatorAR::model(), 'creator', array('class'=>'textboxtext'));?>
                    </td>
                </tr>
            </div>
            <div class="tablerow" id='divmetadataprovider'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel(MetadataProviderAR::model(),'metadataprovider');?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=metadataprovider',array('rel'=>'lightbox'));?>
                    </td>
                    <td class="tablefieldcel">
                        <?php echo CHtml::activeHiddenField($media,'idmetadataprovider');?>
                        <?php echo CHtml::activeTextField($media->metadataprovider, 'metadataprovider', array('class'=>'textboxtext'));?>
                    </td>
                    <td class="acIcon" id="autocompleteMetadataProvider">
                    </td>
                </tr>
            </div>
            <div class="tablerow" id='divtimedigitized'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($media,"timedigitized"); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=timedigitized',array('rel'=>'lightbox'));?>
                    </td>
                    <td class="tablefieldcel">
                        <?php echo CHtml::activeTextField($media,'timedigitized',array('class'=>'timeordate')); ?>
                        <span style="font-size: 10px;">24 hh:mm:ss</span>
                    </td>
                </tr>
            </div>
            <div class="tablerow" id='divdatedigitized'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($media,"datedigitized"); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=datedigitized',array('rel'=>'lightbox'));?>
                    </td>
                    <td class="tablefieldcel">
                        <?php echo CHtml::activeTextField($media,'datedigitized',array('class'=>'timeordate')); ?>
                        <span style="font-size: 10px;"> YYYY/MM/DD</span>
                    </td>
                </tr>
            </div>
            <div class="tablerow" id='divcopyrightowner'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($media,"copyrightowner"); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=copyrightowner',array('rel'=>'lightbox'));?>
                    </td>
                    <td class="tablefieldcel">
                        <?php echo CHtml::activeTextField($media,'copyrightowner', array('class'=>'textboxtext')); ?>
                    </td>
                </tr>
            </div>
            <div class="tablerow" id='divcopyrightstatement'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($media,"copyrightstatement"); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=copyrightstatement',array('rel'=>'lightbox'));?>
                    </td>
                    <td class="tablefieldcel">
                        <?php echo CHtml::activeTextField($media,'copyrightstatement', array('class'=>'textboxtext')); ?>
                    </td>
                </tr>
            </div>
            <div class="tablerow" id='divformatmedia'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel(FormatMediaAR::model(), 'formatmedia'); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=formatmedia',array('rel'=>'lightbox'));?>
                    </td>
                    <td class="tablefieldcel">
                        <?php echo CHtml::activeDropDownList($media,'idformatmedia', CHtml::listData(FormatMediaAR::model()->findAll(), 'idformatmedia', 'formatmedia'), array('empty'=>'-')); ?>
                    </td>
                </tr>
            </div>
            <div class="tablerow" id='divattributionlinkurl'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($media,"attributionlinkurl"); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=attributionlinkurl',array('rel'=>'lightbox'));?>
                    </td>
                    <td class="tablefieldcel">
                        <?php echo CHtml::activeTextField($media,'attributionlinkurl', array('class'=>'textboxtext')); ?>
                    </td>
                </tr>
            </div>
            <div class="tablerow" id='divattributionlogourl'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($media,"attributionlogourl"); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=attributionlogourl',array('rel'=>'lightbox'));?>
                    </td>
                    <td class="tablefieldcel">
                        <?php echo CHtml::activeTextField($media,'attributionlogourl', array('class'=>'textboxtext')); ?>
                    </td>
                </tr>
            </div>
            <div class="tablerow" id='divattributionstatement'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($media,"attributionstatement"); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=attributionstatement',array('rel'=>'lightbox'));?>
                    </td>
                    <td class="tablefieldcel">
                        <?php echo CHtml::activeTextField($media,'attributionstatement', array('class'=>'textboxtext')); ?>
                    </td>
                </tr>
            </div>
            <div class="tablerow" id='divaccesspoint'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($media,"accesspoint"); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=accesspoint',array('rel'=>'lightbox'));?>
                    </td>
                    <td class="tablefieldcel">
                        <?php echo CHtml::activeTextField($media,'accesspoint', array('class'=>'textboxtext')); ?>
                    </td>
                </tr>
            </div>
            <div class="tablerow" id='divaccessurl'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($media,"accessurl"); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=accessurl',array('rel'=>'lightbox'));?>
                    </td>
                    <td class="tablefieldcel">
                        <?php echo CHtml::activeTextField($media,'accessurl', array('class'=>'textboxtext')); ?>
                    </td>
                </tr>
            </div>
            <div class="tablerow" id='divdateavailable'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($media,"dateavailable"); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=dateavailable',array('rel'=>'lightbox'));?>
                    </td>
                    <td class="tablefieldcel">
                        <?php echo CHtml::activeTextField($media,'dateavailable',array('class'=>'timeordate')); ?>
                        <span style="font-size: 10px;"> YYYY/MM/DD</span>
                    </td>
                </tr>
            </div>
            <div class="tablerow" id='divcomment'>
                <tr>
                    <td class="tablelabelcel">
                        <?php echo CHtml::activeLabel($media, 'comment'); ?>
                    </td>
                    <td class="tablemiddlecel">
                        <?php echo CHtml::link('<image style border=\'0px\' src="images/help.gif">','index.php?r=help&helpfield=comment',array('rel'=>'lightbox'));?>
                    </td>
                    <td class="tablefieldcel">
                        <?php echo CHtml::activeTextArea($media,'comment',array('class'=>'textarea')); ?>
                    </td>
                </tr>
            </div>
        </table>
    </div>
   <div class="privateRecord" id="file">		
		<noscript>			
			<p>Please enable JavaScript to use file uploader.</p>
		</noscript>         
	</div>	
	<div class="privateRecord" id="fileStatus"></div>	
    <div class="privateRecord">
        <div class="title"><?php echo CHtml::activeCheckBox($media, 'isrestricted')."&nbsp;&nbsp;".Yii::t('yii','Check here to make this record private')."&nbsp;&nbsp;"; ?></div>
        <div class="icon"><?php showIcon("Private Record", "ui-icon-locked", 0); ?></div>
    </div>
    
    <div class="saveButton">
        <input type="checkbox" id="saveBtn" /><label for="saveBtn">Save</label>
    </div>
</div>

<?php echo CHtml::endForm(); ?>
