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
    .tablelabelcel {
	    width: 250px;
    }
</style>
<script>
    // Arrays para armazenar listas de NxN
    // Nome padrao: controllerList
    var creatorList = new Array();
    var tagList = new Array();

    // Inicia configuracoes Javascript
    $(document).ready(bootMedia);

    function bootMedia(){

        //Configs
        configInitial();
        configNotify();
        configIcons();
        configUploadShow('#MediaAR_idfile');
        configHideShowButtons();
        configPrintButton();
    }
    // Configuracoes iniciais
    function configInitial() {
        $("#editBtn").button();

        // Evento onclick do botao edit
        $("#editBtn").click(function(){
             window.location = "index.php?r=media/goToMaintain&id="+$("#MediaAR_idmedia").val();
         });
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
            hideEmptyBlocks();
        });
        
        $("#showBtn").click(function(){
            $("td.tablefieldcel:empty").parent().show();
            $("div.accordionRight:empty").parent().show();
            $("#hideBtn").parent().show();
            $("#showBtn").parent().hide();
            $("#showBtn").attr("checked", true);
            $("#hideBtn").attr("checked", true);
            showEmptyBlocks();
        });
        
        //empty fields starts hidden
        $("td.tablefieldcel:empty").parent().hide();
        $("div.accordionRight:empty").parent().hide();
        $("#hideBtn").parent().hide();
        $("#showBtn").parent().show();
        $("#showBtn").attr("checked", true);
        $("#hideBtn").attr("checked", true);
        
        hideEmptyBlocks();
    }
    
    function hideEmptyBlocks() {
        if($.trim($(".normalFieldsTable > tbody > tr > td.tablefieldcel:parent").html())=='') {
            $(".normalFields").hide();
        }
    }
    
    function showEmptyBlocks() {
	    $(".normalFields").show();    
    }
    
    function configPrintButton() {
    	$("#printButton").button();
	    $("#printButton").click(function() {
	    	var windowReference = window.open('index.php?r=loadingfile/goToShow');
		   //printPDF(<?php echo $media->idmedia?>); 
		   $.ajax({ type:'GET',
                    url:'index.php?r=media/print',
                    data: {
                    	"id": $('#MediaAR_idmedia').val()
                    },
                    dataType: "json",
                    success:function(json) {
	                    windowReference.location = json;
                    }
           });
	    });
    }
    
    function printPDF(idmedia) {
    	window.open("index.php?r=media/goToPrint&id="+idmedia);
    }


</script>

<div id="Notification"></div>

<?php echo CHtml::beginForm('','post',array ('id'=>'form')); ?>
<?php echo CHtml::activeHiddenField($media,'idmedia');?>
<?php echo CHtml::activeHiddenField($media,'idfile');?>

<div class="introText">
    <h1><?php echo Yii::t('yii','View an existing media record'); ?></h1>
    <p><?php echo Yii::t('yii',"Use this tool to view media records of modern biological specimens and information such as format, copyright and date digitized. This set of fields is based on international standards, such as Darwin Core, Dublin Core and their extensions."); ?></p>
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
                <td class="tablefieldcel"><?php echo $media->title; ?></td>
                <td class="acIcon"></td>
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
                <td class="tablefieldcel"><?php echo $media->caption;?></td>
                <td class="acIcon"></td>
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
                <td class="tablefieldcel"><?php echo $media->typemedia->typemedia;?></td>
                <td class="acIcon"></td>
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
                <td class="tablefieldcel"><?php echo $media->subtype->subtype;?></td>
                <td class="acIcon"></td>
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
                <td class="tablefieldcel"><?php echo $media->categorymedia->categorymedia;?></td>
                <td class="acIcon"></td>
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
                <td class="tablefieldcel"><?php echo $media->subcategorymedia->subcategorymedia;?></td>
                <td class="acIcon"></td>
            </tr>
        </div>
    </table>
    
     <div id="showHideBtn" class="saveButton" style="clear:both;">
    	<div style="margin-right:40%;"><input type="checkbox" id="showBtn" /><label for="showBtn">Show empty fields</label></div>
    	<div style="margin-right:40%;"><input type="checkbox" id="hideBtn" /><label for="hideBtn">Hide empty fields</label></div>
    </div>
    
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
                    <td class="tablefieldcel"><?php echo $media->extent; ?></td>
                    <td class="acIcon"></td>
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
                    <td class="tablefieldcel"><?php echo $media->language->language; ?></td>
                    <td class="acIcon"></td>
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
                    <td class="tablefieldcel"><?php echo $media->description; ?></td>
                    <td class="acIcon"></td>
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
                    <td class="tablefieldcel"><?php
                                $tags = "";
                                foreach ($media->tag as $value) {
                                    $tags .= $value->tag . "; ";
                                }
                                $tags = substr($tags, 0, -2);
                                echo $tags;
                            ?></td>
                    <td class="acIcon"></td>
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
                    <td class="tablefieldcel"><?php echo $media->capturedevice->capturedevice;?></td>
                    <td class="acIcon"></td>
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
                    <td class="tablefieldcel"><?php
                                $creator = "";
                                foreach ($media->creator as $value) {
                                    $creator .= $value->creator . "; ";
                                }
                                $creator = substr($creator, 0, -2);
                                echo $creator;
                            ?></td>
                    <td class="acIcon"></td>
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
                    <td class="tablefieldcel"><?php echo $media->metadataprovider->metadataprovider;?></td>
                    <td class="acIcon"></td>
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
                    <td class="tablefieldcel"><?php echo $media->timedigitized; ?></td>
                    <td><span style="font-size: 10px; margin-left: 10px;">24 hh:mm:ss</span></td>
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
                    <td class="tablefieldcel"><?php echo $media->datedigitized; ?></td>
                    <td><span style="font-size: 10px; margin-left: 10px;"> YYYY-MM-DD</span></td>
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
                    <td class="tablefieldcel"><?php echo $media->copyrightowner; ?></td>
                    <td class="acIcon"></td>
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
                    <td class="tablefieldcel"><?php echo $media->copyrightstatement; ?></td>
                    <td class="acIcon"></td>
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
                    <td class="tablefieldcel"><?php echo $media->formatmedia->formatmedia; ?></td>
                    <td class="acIcon"></td>
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
                    <td class="tablefieldcel"><?php echo $media->attributionlinkurl; ?></td>
                    <td class="acIcon"></td>
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
                    <td class="tablefieldcel"><?php echo $media->attributionlogourl; ?></td>
                    <td class="acIcon"></td>
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
                    <td class="tablefieldcel"><?php echo $media->attributionstatement; ?></td>
                    <td class="acIcon"></td>
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
                    <td class="tablefieldcel"><?php echo $media->accesspoint; ?></td>
                    <td class="acIcon"></td>
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
                    <td class="tablefieldcel"><?php echo $media->accessurl; ?></td>
                    <td class="acIcon"></td>
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
                    <td class="tablefieldcel"><?php echo $media->dateavailable; ?></td>
                    <td><span style="font-size: 10px;"> YYYY-MM-DD</span></td>
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
                    <td class="tablefieldcel"><?php echo $media->comment; ?></td>
                    <td class="acIcon"></td>
                </tr>
            </div>
        </table>
    </div>
   <div class="privateRecord" id="file">		
		<noscript>			
			<p>Please enable JavaScript to use file uploader.</p>
		</noscript>         
		<p id="noFile" display="none">There is no uploaded file.<p>
	</div>	
	<div class="privateRecord" id="fileStatus"></div>
		
    <div class="privateRecord">
        <div class="title"><?php echo $media->isrestricted ? "This is a private record." : "This is not a private record." ; ?></div>
        <div class="icon"><?php if ($media->isrestricted) showIcon("Private Record", "ui-icon-locked", 0); else showIcon("Not Private Record", "ui-icon-unlocked", 0) ; ?></div>
    </div>

    <div class="saveButton">
        <input type="checkbox" id="printButton" /><label for="printButton">Print</label>
        <input type="checkbox" id="editBtn" /><label for="editBtn">Edit</label>
    </div>
    
</div>

<?php echo CHtml::endForm(); ?>
